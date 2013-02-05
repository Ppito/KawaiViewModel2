<?php

class Users_Dispatcher extends Vbf_Mvc_Dispatcher
{
  public function getDispatchRules()
  {
    return array(
     // List
     array('type' => 'action', 'params' => 0, 'url' => '', 'name' => 'list', 'method' => 'GET'),

     // Create
     array('type' => 'action', 'params' => 0, 'url' => 'add', 'name' => 'edit', 'method' => 'GET'),
     array('type' => 'action', 'params' => 0, 'url' => 'add', 'name' => 'edit', 'method' => 'POST'),

     // Edit
     array('type' => 'action', 'params' => 1, 'url' => 'edit', 'name' => 'edit', 'method' => 'GET'),
     array('type' => 'action', 'params' => 1, 'url' => 'edit', 'name' => 'edit', 'method' => 'POST'),

     // Delete
     array('type' => 'action', 'params' => 1, 'url' => 'delete', 'name' => 'delete', 'method' => 'GET'),
     array('type' => 'action', 'params' => 1, 'url' => 'delete', 'name' => 'delete', 'method' => 'POST'),
     );
  }
}

?>