<?php

require '../vendor/autoload.php';

$db     = new \philwc\JsonDB('./data/');
$result = $db->select('test', 'Age', 43);
var_dump($result);

/*
  array(2) {
  [0] =>
  array(3) {
    'ID' =>
    int(0)
    'Name' =>
    string(13) "Josef Brunzer"
    'Age' =>
    int(43)
  }
  [1] =>
  array(3) {
    'ID' =>
    int(3)
    'Name' =>
    string(15) "Gerald Ofnsacka"
    'Age' =>
    int(43)
  }
}
*/

$db     = new \philwc\JsonTable('./data/test.json');
$result = $db->select('Age', 43);
var_dump($result);

/*
 array(2) {
  [0] =>
  array(3) {
    'ID' =>
    int(0)
    'Name' =>
    string(13) "Josef Brunzer"
    'Age' =>
    int(43)
  }
  [1] =>
  array(3) {
    'ID' =>
    int(3)
    'Name' =>
    string(15) "Gerald Ofnsacka"
    'Age' =>
    int(43)
  }
}
*/