<?php

namespace philwc\Test;

use philwc\JsonDB;

class JsonDBTest extends JsonFileSetup
{
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new JsonDB($this->path);
    }

    public function testSelect()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->select($this->table, 'Age', 43));
    }

    public function testSelectAll()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 2, "Name" => "Heinz Goschnfuada", "Age" => 67],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->selectAll($this->table));
    }

    public function testGetFieldNames()
    {
        $expected = ['ID', 'Name', 'Age'];

        $this->assertEquals($expected, $this->instance->getFieldNames($this->table));

        //Non existent record

        $this->assertEquals([], $this->instance->getFieldNames($this->table, 4));
    }

    public function testBetween()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->between($this->table, 'Age', 30, 45));
    }

    public function testLike()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->like($this->table, 'Name', 'sef'));

    }

    public function testInsert()
    {
        $this->instance->insert($this->table, ['ID' => 4, 'Name' => 'Test McTesterson', 'Age' => 99]);

        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 2, "Name" => "Heinz Goschnfuada", "Age" => 67],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
            ['ID' => 4, 'Name' => 'Test McTesterson', 'Age' => 99],
        ];

        $this->assertEquals($expected, $this->instance->selectAll($this->table));
    }

    public function testUpdate()
    {
        $initial  = [["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43]];
        $expected = [["ID" => 0, "Name" => "Josef Brunzer", "Age" => 99]];

        $this->assertEquals($initial, $this->instance->select($this->table, 'ID', 0));

        $this->instance->update($this->table, 'ID', 0, ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 99]);

        $this->assertEquals($expected, $this->instance->select($this->table, 'ID', 0));
    }

    public function testUpdateAll()
    {
        $expected = ['ID' => 0, 'Name' => 'Test McTesterson', 'Age' => 99];

        $this->instance->updateAll($this->table, $expected);

        $this->assertEquals([$expected], $this->instance->selectAll($this->table));
    }

    public function testDelete()
    {
        $this->instance->delete($this->table, 'ID', 0);

        $expected = [
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 2, "Name" => "Heinz Goschnfuada", "Age" => 67],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->selectAll($this->table));
    }

    public function testDeleteAll()
    {
        $this->instance->deleteAll($this->table);

        $expected = [];

        $this->assertEquals($expected, $this->instance->selectAll($this->table));
    }

    public function testJsonOptions()
    {
        $this->assertEquals(0, $this->instance->getJsonEncodeOptions($this->table));

        $this->instance->setJsonEncodeOptions($this->table, JSON_HEX_TAG);

        $this->assertEquals(JSON_HEX_TAG, $this->instance->getJsonEncodeOptions($this->table));
    }

    public function testSetPrettyOutput()
    {
        $this->instance->setPrettyOutput($this->table, true);

        $this->assertEquals(JSON_PRETTY_PRINT, $this->instance->getJsonEncodeOptions($this->table));
    }
}
