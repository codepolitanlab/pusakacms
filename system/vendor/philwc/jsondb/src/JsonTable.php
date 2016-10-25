<?php
namespace philwc;

class JsonTable
{
    protected $jsonFile;
    protected $fileHandle;
    protected $fileData = [];
    protected $prettyOutput;
    protected $jsonEncodeOptions = 0;

    /**
     * @param null $_jsonFile
     *
     * @throws \philwc\JsonDBException
     */
    public function __construct($_jsonFile = null)
    {
        if ($_jsonFile !== null) {
            $this->init($_jsonFile);
        }
    }

    /**
     * @param $_jsonFile
     * @return $this
     *
     * @throws JsonDBException
     */
    public function init($_jsonFile)
    {
        if (file_exists($_jsonFile)) {
            $this->jsonFile = $_jsonFile;
            $this->fileData = json_decode(file_get_contents($this->jsonFile), true);
            $this->checkJson();
            $this->lockFile();
        } else {
            throw new JsonDBException('File not found: ' . $_jsonFile);
        }

        return $this;
    }

    /**
     * Destruct
     */
    public function __destruct()
    {
        flock($this->fileHandle, LOCK_UN);
        fclose($this->fileHandle);
    }

    /**
     * Check JSON
     *
     * @throws JsonDBException
     */
    protected function checkJson()
    {
        $error = '';
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                break;
            case JSON_ERROR_DEPTH:
                $error = 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $error = 'Unknown error';
                break;
        }

        if ($error !== '') {
            throw new JsonDBException('Invalid JSON: ' . $error);
        }
    }

    /**
     * Set Pretty Output
     *
     * @param bool|array $val
     * @return $this
     *
     * @throws JsonDBException
     */
    public function setPrettyOutput($val)
    {
        if (is_array($val) && count($val) === 1) {
            return $this->setPrettyOutput($val[0]);
        }

        if (is_bool($val)) {
            $this->prettyOutput = $val;
            return $this;
        }

        throw new JsonDBException('Error. Please supply a bool value');
    }

    /**
     * Return options for json_encode.
     *
     * @return int
     */
    public function getJsonEncodeOptions()
    {
        if ($this->prettyOutput) {
            return $this->jsonEncodeOptions | JSON_PRETTY_PRINT;
        }

        return $this->jsonEncodeOptions;
    }

    /**
     * Set options for json_encode.
     *
     * @param int|array $val
     * @return $this
     *
     * @throws JsonDBException
     */
    public function setJsonEncodeOptions($val)
    {
        if (is_array($val) && count($val) === 1) {
            return $this->setJsonEncodeOptions($val[0]);
        }

        if (is_int($val)) {
            $this->jsonEncodeOptions = $val;
            return $this;
        }

        throw new JsonDBException('Error. Please supply a int value');
    }

    /**
     * Lock File
     *
     * @throws JsonDBException
     */
    protected function lockFile()
    {
        $handle = fopen($this->jsonFile, 'c+');
        if (flock($handle, LOCK_EX)) {
            $this->fileHandle = $handle;
            return;
        }

        throw new JsonDBException('Can\'t set file-lock');
    }

    /**
     * Save
     *
     * @return bool
     * @throws JsonDBException
     */
    protected function save()
    {
        $flags = $this->jsonEncodeOptions;
        if ($this->prettyOutput) {
            $flags = JSON_PRETTY_PRINT | $flags;
        }

        if (!is_array($this->fileData)) {
            if ($this->fileData === null || $this->fileData === '') {
                throw new JsonDBException('Refusing to write null data to: ' . $this->jsonFile);
            }
        }

        ftruncate($this->fileHandle, 0);
        if (fwrite($this->fileHandle, json_encode($this->fileData, $flags))) {
            fflush($this->fileHandle);

            return true;
        }

        throw new JsonDBException('Can\'t write data to: ' . $this->jsonFile);
    }

    /**
     * Select All
     *
     * @return array|mixed
     */
    public function selectAll()
    {
        return $this->fileData;
    }

    /**
     * Get Field Names
     *
     * @param int|array $recordNumber
     *
     * @return array
     */
    public function getFieldNames($recordNumber = 0)
    {
        if (is_array($recordNumber)) {
            if (count($recordNumber) === 1) {
                return $this->getFieldNames($recordNumber[0]);
            }
            return $this->getFieldNames(0);
        }

        if (array_key_exists($recordNumber, $this->fileData)) {
            return array_keys($this->fileData[$recordNumber]);
        }

        return [];
    }

    /**
     * Select
     *
     * @param mixed $key
     * @param int $val
     *
     * @return array
     */
    public function select($key, $val = 0)
    {
        $result = array();
        if (is_array($key) && count($key) === 2) {
            return $this->select($key[0], $key[1]);
        }

        $data = $this->fileData;

        foreach ($data as $_key => $_val) {
            if (array_key_exists($_key, $data) && array_key_exists($key, $data[$_key])) {
                if ($data[$_key][$key] === $val) {
                    $result[] = $data[$_key];
                }
            }
        }

        return count($result) == 1 ? $result[0] : $result;
    }

    /**
     * Between
     *
     * @param mixed $key
     * @param int $min
     * @param int $max
     *
     * @return array
     */
    public function between($key, $min = 0, $max = 0)
    {
        if (is_array($key) && count($key) === 3) {
            return $this->between($key[0], $key[1], $key[2]);
        }

        $data   = $this->fileData;
        $result = [];

        foreach ($data as $_key => $_val) {
            if (array_key_exists($_key, $data) &&
                array_key_exists($key, $data[$_key]) &&
                $min <= $data[$_key][$key]
                && $data[$_key][$key] <= $max
            ) {
                $result[] = $_val;
            }
        }

        return $result;
    }

    /**
     * Like
     *
     * @param mixed $key
     * @param string $like
     *
     * @return array
     */
    public function like($key, $like = null)
    {
        if (is_array($key) && count($key) === 2) {
            return $this->like($key[0], $key[1]);
        }

        $data   = $this->fileData;
        $result = [];
        foreach ($data as $_key => $_val) {
            if (array_key_exists($_key, $data) && array_key_exists($key, $data[$_key]) && strrpos($data[$_key][$key], $like)) 
            {
                $result[] = $_val;
            }
        }

        return $result;
    }

    /**
     * Update All
     *
     * @param array $data
     *
     * @return array
     * @throws \philwc\JsonDBException
     */
    public function updateAll(array $data = [])
    {
        if (is_array($data) && array_key_exists(0, $data) && is_array($data[0]) && count($data) === 1) {
            return $this->updateAll($data[0]);
        }

        if (array_key_exists(0, $data) && substr_compare($data[0], $this->jsonFile, 0)) {
            $data = $data[1];
        }

        $this->save();

        return $this->fileData = array($data);
    }

    /**
     * Update
     *
     * @param mixed $key
     * @param int $val
     * @param array $newData
     *
     * @return bool
     * @throws \philwc\JsonDBException
     */
    public function update($key, $val = 0, array $newData = [])
    {
        if (is_array($key) && count($key) === 3) {
            return $this->update($key[0], $key[1], $key[2]);
        }

        if (count($this->select($key, $val)) !== 0) {
            $data       = $this->fileData;
            $resultData = [];

            foreach ($data as $_key => $_val) {
                if ($data[$_key][$key] === $val) {
                    $resultData[] = $newData;
                } else {
                    $resultData[] = $_val;
                }
            }

            $this->fileData = $resultData;
            return $this->save();
        }

        return false;
    }

    /**
     * Insert
     *
     * @param array $data
     *
     * @return bool
     * @throws \philwc\JsonDBException
     */
    public function insert(array $data = [])
    {
        if (is_array($data) && array_key_exists(0, $data) && is_array($data[0]) && count($data) === 1) {
            return $this->insert($data[0]);
        }

        if (array_key_exists(0, $data) && substr_compare($data[0], $this->jsonFile, 0)) {
            $data = $data[1];
        }

        $this->fileData[] = $data;
        return $this->save();
    }

    /**
     * Delete All
     *
     * @return bool
     * @throws \philwc\JsonDBException
     */
    public function deleteAll()
    {
        $this->fileData = array();
        return $this->save();
    }

    /**
     * Delete
     *
     * @param mixed $key
     * @param int $val
     *
     * @return int
     * @throws \philwc\JsonDBException
     */
    public function delete($key, $val = 0)
    {
        if (is_array($key)) {
            if (count($key) === 2) {
                return $this->delete($key[0], $key[1]);
            }

            return 0;
        }

        $data = $this->fileData;
        $i    = 0;
        foreach ($data as $_key => $_val) {
            if (array_key_exists($_key, $data) && array_key_exists($key, $data[$_key])) {
                if ($data[$_key][$key] === $val) {
                    unset($data[$_key]);
                    $i++;
                }
            }
        }

        $this->fileData = array_values($data);
        $this->save();
        return $i;
    }
}
