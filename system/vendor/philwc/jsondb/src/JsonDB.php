<?php
namespace philwc;

class JsonDB
{

    protected $path = "./";
    protected $fileExt = ".json";
    protected $tables = array();

    /**
     * Construct
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->validatePath($path);
    }

    /**
     * Validate Path
     *
     * @param $path
     *
     * @throws JsonDBException
     */
    private function validatePath($path)
    {
        if (is_dir($path)) {
            if (substr($path, strlen($path) - 1) != '/') {
                $path .= '/';
            }
            $this->path = $path;
        } else {
            throw new JsonDBException('Path not found');
        }
    }

    /**
     * Get Table Instance
     *
     * @param $table
     *
     * @return JsonTable
     */
    protected function getTableInstance($table)
    {
        if (isset($tables[$table])) {
            return $tables[$table];
        } else {
            return $tables[$table] = new JsonTable($this->path . $table);
        }
    }

    /**
     * Call
     *
     * @param mixed $op
     * @param mixed $args
     *
     * @return mixed
     * @throws JsonDBException
     */
    public function __call($op, $args)
    {
        if ($args && method_exists("philwc\JsonTable", $op)) {
            $table = $args[0] . $this->fileExt;
            return $this->getTableInstance($table)
                        ->$op(
                        $args
              );
        } else {
            throw new JsonDBException('Unknown method or wrong arguments');
        }
    }

    /**
     * Set Extension
     *
     * @param $_fileExt
     *
     * @return $this
     */
    public function setExtension($_fileExt)
    {
        $this->fileExt = $_fileExt;
        return $this;
    }

}
