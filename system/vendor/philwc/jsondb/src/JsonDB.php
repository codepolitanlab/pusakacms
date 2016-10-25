<?php
namespace philwc;

class JsonDB
{

    protected $path    = './';
    protected $fileExt = '.json';
    protected $tables  = [];

    /**
     * @param null $path
     */
    public function __construct($path = null)
    {
        if ($path !== null) {
            $this->init($path);
        }
    }

    /**
     * @param $path
     * @throws \philwc\JsonDBException
     */
    public function init($path)
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
            if (substr($path, strlen($path) - 1) !== '/') {
                $path .= '/';
            }
            $this->path = $path;
            return;
        }

        throw new JsonDBException('Path not found');
    }

    /**
     * Get Table Instance
     *
     * @param $table
     *
     * @return JsonTable
     * @throws \philwc\JsonDBException
     */
    protected function getTableInstance($table)
    {
        if (array_key_exists($table, $this->tables)) {
            return $this->tables[$table];
        }

        $this->tables[$table] = new JsonTable($this->path . $table);
        return $this->tables[$table];
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
            $table = array_shift($args);

            $tableFile = $table . $this->fileExt;
            /** @var \philwc\JsonTable $instance */
            $instance = $this->getTableInstance($tableFile);

            return $instance->$op($args);
        }

        throw new JsonDBException('Unknown method or wrong arguments');
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
