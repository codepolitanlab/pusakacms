<?php

namespace philwc\Test;

class JsonFileSetup extends \PHPUnit_Framework_TestCase
{
    protected $jsonFile;
    protected $table;
    protected $path;

    public function setUp()
    {
        $this->path     = '/tmp/JsonDB';
        $this->table    = uniqid('jsondb', true);
        $this->jsonFile = $this->path . '/' . $this->table . '.json';

        if (!file_exists($this->path)) {
            mkdir($this->path);
        }

        if (!file_exists($this->jsonFile)) {
            file_put_contents($this->jsonFile,
                '[{"ID":0,"Name":"Josef Brunzer","Age":43},{"ID":1,"Name":"Harald Beidlpraka","Age":34},{"ID":2,"Name":"Heinz Goschnfuada","Age":67},{"ID":3,"Name":"Gerald Ofnsacka","Age":43}]');
        }
    }

    public function tearDown()
    {
        if (file_exists($this->jsonFile)) {
            unlink($this->jsonFile);
        }
    }
}
