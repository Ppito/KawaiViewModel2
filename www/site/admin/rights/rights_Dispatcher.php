<?php

class Rights_Dispatcher extends Vbf_Mvc_Dispatcher
{
  public function getDispatchRules()
  {
     return array(
        // List
        array('type' => 'action', 'params' => 0, 'url' => '', 'name' => 'list', 'method' => 'GET')
       ,array('type' => 'action', 'params' => 0, 'url' => 'listGroup', 'name' => 'listGroup', 'method' => 'GET')

       // Create
       ,array('type' => 'action', 'params' => 0, 'url' => 'add', 'name' => 'edit', 'method' => 'GET')
       ,array('type' => 'action', 'params' => 0, 'url' => 'add', 'name' => 'edit', 'method' => 'POST')
       ,array('type' => 'action', 'params' => 0, 'url' => 'newGroup', 'name' => 'newGroup', 'method' => 'GET')
       ,array('type' => 'action', 'params' => 0, 'url' => 'newGroup', 'name' => 'newGroup', 'method' => 'POST')

       // Edit
       ,array('type' => 'action', 'params' => 1, 'url' => 'edit', 'name' => 'edit', 'method' => 'GET')
       ,array('type' => 'action', 'params' => 1, 'url' => 'edit', 'name' => 'edit', 'method' => 'POST')

       // Delete
       ,array('type' => 'action', 'params' => 1, 'url' => 'delete', 'name' => 'delete', 'method' => 'GET')
       ,array('type' => 'action', 'params' => 1, 'url' => 'delete', 'name' => 'delete', 'method' => 'POST')
       ,array('type' => 'action', 'params' => 2, 'url' => 'deleteGroup', 'name' => 'deleteGroup', 'method' => 'GET')
       ,array('type' => 'action', 'params' => 2, 'url' => 'deleteGroup', 'name' => 'deleteGroup', 'method' => 'POST')

       // Ajax
       ,array('type' => 'action', 'params' => 2, 'url' => 'changeRight', 'name' => 'changeRight', 'method' => 'POST')
      );
  }
}

?>