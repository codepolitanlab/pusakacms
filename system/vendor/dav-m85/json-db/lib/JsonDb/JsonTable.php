<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 17/11/13
 * Time: 00:08
 * To change this template use File | Settings | File Templates.
 */

namespace JsonDb;


class JsonTable {
    protected $jsonFile;
    protected $fileHandle;
    protected $fileData = array();

    public function __construct($_jsonFile) {
        $this->jsonFile = $_jsonFile;

        if (file_exists($_jsonFile)) {
            $this->fileData = json_decode(file_get_contents($this->jsonFile), true);

        }
        else{
            touch($_jsonFile);
            $this->fileData = array();
        }
        $this->lockFile();
        //else throw new \Exception("JsonTable Error: File not found: ".$_jsonFile);
    }

    public function __destruct() {
        $this->save();
        fclose($this->fileHandle);
    }

    protected function lockFile() {
        $handle = fopen($this->jsonFile, "w");
        if (flock($handle, LOCK_EX)) $this->fileHandle = $handle;
        else throw new \Exception("JsonTable Error: Can't set file-lock");
    }

    protected function save() {
        if (fwrite($this->fileHandle, json_encode($this->fileData))) return true;
        else throw new \Exception("JsonTable Error: Can't write data to: ".$this->jsonFile);
    }

    public function selectAll() {
        return $this->fileData;
    }

    public function select($key, $val = 0) {
        $result = array();
        if (is_array($key)) $result = $this->select($key[1], $key[2]);
        else {
            $data = $this->fileData;
            foreach($data as $_key => $_val) {
                if (isset($data[$_key][$key])) {
                    if ($data[$_key][$key] == $val) {
                        $result[] = $data[$_key];
                    }
                }
            }
        }
        return $result;
    }

    public function updateAll($data = array()) {
        if (isset($data[0]) && substr_compare($data[0],$this->jsonFile,0)) $data = $data[1];
        return $this->fileData = array($data);
    }

    public function update($key, $val = 0, $newData = array()) {
        $result = false;
        if (is_array($key)) $result = $this->update($key[1], $key[2], $key[3]);
        else {
            $data = $this->fileData;
            foreach($data as $_key => $_val) {
                if (isset($data[$_key][$key])) {
                    if ($data[$_key][$key] == $val) {
                        $data[$_key] = $newData;
                        $result = true;
                        break;
                    }
                }
            }
            if ($result) $this->fileData = $data;
        }
        return $result;
    }

    public function insert($data = array()) {
        if (isset($data[0]) && substr_compare($data[0],$this->jsonFile,0)) $data = $data[1];
        $this->fileData[] = $data;
        return true;
    }

    public function deleteAll() {
        $this->fileData = array();
        return true;
    }

    public function delete($key, $val = 0) {
        $result = 0;
        if (is_array($key)) $result = $this->delete($key[1], $key[2]);
        else {
            $data = $this->fileData;
            foreach($data as $_key => $_val) {
                if (isset($data[$_key][$key])) {
                    if ($data[$_key][$key] == $val) {
                        unset($data[$_key]);
                        $result++;
                    }
                }
            }
            if ($result) {
                sort($data);
                $this->fileData = $data;
            }
        }
        return $result;
    }
}