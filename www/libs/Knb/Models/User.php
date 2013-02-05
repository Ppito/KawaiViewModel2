<?php

class Knb_User
{
  public $user_id;
  public $user_login;
  public $user_last_name;
  public $user_first_name;
  public $user_birthday;
  public $user_sexe;
  public $user_mail;
  public $user_phone;
  public $user_password_nonce;
  public $user_password_md5;
  public $user_creation;
  public $is_deleted;

  public function exchangeArray(array $data)
  {
    $this->user_id             = (array_key_exists('user_id', $data)) ? $data['user_id'] : null;
    $this->user_login          = (array_key_exists('user_login', $data)) ? $data['user_login'] : null;
    $this->user_last_name      = (array_key_exists('user_last_name', $data)) ? $data['user_last_name'] : null;
    $this->user_first_name     = (array_key_exists('user_first_name', $data)) ? $data['user_first_name'] : null;
    $this->user_birthday       = (array_key_exists('user_birthday', $data)) ? $data['user_birthday'] : null;
    $this->user_sexe           = (array_key_exists('user_sexe', $data)) ? $data['user_sexe'] : null;
    $this->user_mail           = (array_key_exists('user_mail', $data)) ? $data['user_mail'] : null;
    $this->user_phone          = (array_key_exists('user_phone', $data)) ? $data['user_phone'] : null;
    $this->user_password_nonce = (array_key_exists('user_password_nonce', $data)) ? $data['user_password_nonce'] : null;
    $this->user_password_md5   = (array_key_exists('user_password_md5', $data)) ? $data['user_password_md5'] : null;
    $this->user_creation       = (array_key_exists('user_creation', $data)) ? $data['user_creation'] : null;
    $this->is_deleted          = (array_key_exists('is_deleted', $data)) ? $data['is_deleted'] : null;
  }

  public function exchangeObject()
  {
    if (isset($this->user_id)) $data['user_id'] = $this->user_id;
    if (isset($this->user_login)) $data['user_login'] = $this->user_login;
    if (isset($this->user_last_name)) $data['user_last_name'] = $this->user_last_name;
    if (isset($this->user_first_name)) $data['user_first_name'] = $this->user_first_name;
    if (isset($this->user_birthday)) $data['user_birthday'] = $this->user_birthday;
    if (isset($this->user_sexe)) $data['user_sexe'] = $this->user_sexe;
    if (isset($this->user_mail)) $data['user_mail'] = $this->user_mail;
    if (isset($this->user_phone)) $data['user_phone'] = $this->user_phone;
    if (isset($this->user_password_nonce)) $data['user_password_nonce'] = $this->user_password_nonce;
    if (isset($this->user_password_md5)) $data['user_password_md5'] = $this->user_password_md5;
    if (isset($this->user_creation)) $data['user_creation'] = $this->user_creation;
    if (isset($this->is_deleted)) $data['is_deleted'] = $this->is_deleted;
    return $data;
  }

}