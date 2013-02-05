<?php

use Zend\Db\Sql\Where;

class   Knb_SessionTable extends Knb_AbstractTable
{
  protected $table     = 'session';
  protected $tableName = 'Knb_Session';

  public function clear() 
  {
    $this->delete('session_start_timestamp < DATE_SUB(now(), INTERVAL '.Knb_Cookie::COOKIE_EXPIRE_DAYS.' DAY)');
  }
  
  public function saveSession(Knb_Session $session)
  {
    $data = $session->exchangeObject();
    $this->insert($data);
    return (int) $session->user_id;
  }

  public function deleteSession($id)
  {
    $this->delete(array('user_id' => $id));
  }

}