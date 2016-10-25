<?php
namespace philwc\Test;

use philwc\JsonTable;

class JsonTableTest extends JsonFileSetup
{

    /**
     * @var JsonTable
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new JsonTable($this->jsonFile);
    }

    public function testSelect()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->select('Age', 43));

        //Alternative Select
        $this->assertEquals($expected, $this->instance->select(['Age', 43]));
    }

    public function testSelectAll()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 2, "Name" => "Heinz Goschnfuada", "Age" => 67],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->selectAll());
    }

    public function testGetFieldNames()
    {
        $expected = ['ID', 'Name', 'Age'];

        $this->assertEquals($expected, $this->instance->getFieldNames());

        //Non existent record

        $this->assertEquals([], $this->instance->getFieldNames(4));
    }

    public function testBetween()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->between('Age', 30, 45));

        //Alternative syntax
        $this->assertEquals($expected, $this->instance->between(['Age', 30, 45]));
    }

    public function testLike()
    {
        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->like('Name', 'sef'));

        //Alternative syntax
        $this->assertEquals($expected, $this->instance->like(['Name', 'sef']));
    }

    public function testInsert()
    {
        $this->instance->insert(['ID' => 4, 'Name' => 'Test McTesterson', 'Age' => 99]);

        $expected = [
            ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43],
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 2, "Name" => "Heinz Goschnfuada", "Age" => 67],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
            ['ID' => 4, 'Name' => 'Test McTesterson', 'Age' => 99],
        ];

        $this->assertEquals($expected, $this->instance->selectAll());
    }

    public function testUpdate()
    {
        $initial  = [["ID" => 0, "Name" => "Josef Brunzer", "Age" => 43]];
        $expected = [["ID" => 0, "Name" => "Josef Brunzer", "Age" => 99]];

        $this->assertEquals($initial, $this->instance->select('ID', 0));

        $this->instance->update('ID', 0, ["ID" => 0, "Name" => "Josef Brunzer", "Age" => 99]);

        $this->assertEquals($expected, $this->instance->select('ID', 0));
    }

    public function testUpdateAll()
    {
        $expected = ['ID' => 0, 'Name' => 'Test McTesterson', 'Age' => 99];

        $this->instance->updateAll($expected);

        $this->assertEquals([$expected], $this->instance->selectAll());
    }

    public function testDelete()
    {
        $this->instance->delete('ID', 0);

        $expected = [
            ["ID" => 1, "Name" => "Harald Beidlpraka", "Age" => 34],
            ["ID" => 2, "Name" => "Heinz Goschnfuada", "Age" => 67],
            ["ID" => 3, "Name" => "Gerald Ofnsacka", "Age" => 43],
        ];

        $this->assertEquals($expected, $this->instance->selectAll());
    }

    public function testDeleteAll()
    {
        $this->instance->deleteAll();

        $expected = [];

        $this->assertEquals($expected, $this->instance->selectAll());
    }

    public function testJsonOptions()
    {
        $this->assertEquals(0, $this->instance->getJsonEncodeOptions());

        $this->instance->setJsonEncodeOptions(JSON_HEX_TAG);

        $this->assertEquals(JSON_HEX_TAG, $this->instance->getJsonEncodeOptions());
    }

    public function testSetPrettyOutput()
    {
        $this->instance->setPrettyOutput(true);

        $this->assertEquals(JSON_PRETTY_PRINT, $this->instance->getJsonEncodeOptions());
    }
}
