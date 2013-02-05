<?php

class Knb_Session
{
  public $user_id;
  public $session_key;
  public $session_start_timestamp;

  public function exchangeArray($data)
  {
    $this->user_id                 = (array_key_exists('user_id', $data)) ? $data['user_id'] : null;
    $this->session_key             = (array_key_exists('session_key', $data)) ? $data['session_key'] : null;
    $this->session_start_timestamp = (array_key_exists('session_start_timestamp', $data)) ? $data['session_start_timestamp'] : null;
  }
  
  public function exchangeObject()
  {
    if (isset($this->user_id)) $data['user_id'] = $this->user_id;
    if (isset($this->session_key)) $data['session_key'] = $this->session_key;
    if (isset($this->session_start_timestamp)) $data['session_start_timestamp'] = $this->session_start_timestamp;
    return $data;
  }
}