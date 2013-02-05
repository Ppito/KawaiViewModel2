<?php

use Zend\Db\ResultSet\ResultSet, 
    Zend\Db\TableGateway\AbstractTableGateway;

class Knb_AbstractTable extends AbstractTableGateway {

  public function __construct($type = ResultSet::TYPE_ARRAYOBJECT) {
    global $g_database;
    $this -> adapter = $g_database;
    $this -> resultSetPrototype = new ResultSet($type);
    $this -> initialize();
  }

  public function fetchAll($type = ResultSet::TYPE_ARRAYOBJECT) {
    $resultSet = $this -> select();
    if ($type == ResultSet::TYPE_ARRAY) {
      foreach ($resultSet as $value) {
        $res[] = $value;
      }
    } else {
      $res = $resultSet;
    }
    return $res;
  }

  public function fetchOne() {
    $resultSet = $this -> select();
    return $resultSet -> current();
  }

  public function __call($name, $arguments) {
    $reflect = new ReflectionClass($this -> tableName);
    $properties = $reflect -> getProperties();
    foreach ($properties as $propertie) {
      $proper[] = Utils::fuCamelCase($propertie -> getName());
    }

    list($find, $args) = explode("By", $name);
    if (!preg_match('/^find(One)?$/', $find)) {
      throw new Exception("Error $name does not exist.", 1);
    }

    $params = explode('And', $args);
    foreach ($params as $key => $value) {
      if (!in_array($value, $proper)) {
        throw new Exception("Error $value property does not exist.", 1);
      }
      if (!array_key_exists($key, $arguments)) {
        throw new Exception("Error missing argument in $name.", 1);
      }
      $where[Utils::undoCamelCase($value)] = $arguments[$key];
    }
    $rowset = $this -> select($where);
    if (!$rowset)
      throw new Exception('Could not find ' . $this -> table . ' row by ' . Utils::fuCamelCase($propertie -> getName()) . ' in ' . $argument);
    return ('findOne' == $find) ? $rowset -> current() : $rowset;
  }

}
