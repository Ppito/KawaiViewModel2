<?php

class Knb_Right
{
  public $right_id;
  public $right_name;
  public $right_description;
  public $is_deleted;

  public function exchangeArray($data)
  {
    $this->right_id          = (array_key_exists('right_id', $data)) ? $data['right_id'] : null;
    $this->right_name        = (array_key_exists('right_name', $data)) ? $data['right_name'] : null;
    $this->right_description = (array_key_exists('right_description', $data)) ? $data['right_description'] : null;
    $this->is_deleted        = (array_key_exists('is_deleted', $data)) ? $data['is_deleted'] : null;
  }
  
  public function exchangeObject()
  {
    if (isset($this->right_id)) $data['right_id'] = $this->right_id;
    if (isset($this->right_name)) $data['right_name'] = $this->right_name;
    if (isset($this->right_description)) $data['right_description'] = $this->right_description;
    if (isset($this->is_deleted)) $data['is_deleted'] = $this->is_deleted;
    return $data;
  }

}