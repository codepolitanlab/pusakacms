<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 17/11/13
 * Time: 00:07
 * To change this template use File | Settings | File Templates.
 */

namespace JsonDb;


class JsonDb {
    protected $path = "./";
    protected $fileExt = ".json";
    protected $tables = array();

    public function __construct($path) {
        if (is_dir($path)) $this->path = $path;
        else throw new \Exception("JsonDB Error: Path not found");
    }

    protected function getTableInstance($table) {
        if (isset($tables[$table])) return $tables[$table];
        else return $tables[$table] = new JsonTable($this->path.$table);
    }

    public function __call($op, $args) {
        if ($args && method_exists('\JsonDb\JsonTable', $op)) {
            $table = $args[0].$this->fileExt;
            return $this->getTableInstance($table)->$op($args);
        } else throw new \Exception("JsonDB Error: Unknown method or wrong arguments ");
    }

    public function setExtension($_fileExt) {
        $this->fileExt = $_fileExt;
        return $this;
    }
}