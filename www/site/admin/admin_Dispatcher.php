<?php

class Admin_Dispatcher extends Vbf_Mvc_Dispatcher
{
  public function getDispatchRules()
  {
    return array(
      array('type' => 'action', 'params' => 0, 'url' => '', 'name' => '', 'method' => 'GET'  )
     // Module
     ,array('type' => 'module', 'params' => 0, 'url' => 'htpasswd', 'name' => 'htpasswd')
     ,array('type' => 'module', 'params' => 0, 'url' => 'users', 'name' => 'users')
     ,array('type' => 'module', 'params' => 0, 'url' => 'groups', 'name' => 'groups')
     ,array('type' => 'module', 'params' => 0, 'url' => 'rights', 'name' => 'rights')
    );
  }
}

?>