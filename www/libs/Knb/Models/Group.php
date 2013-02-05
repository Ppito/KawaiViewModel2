<?php

class Knb_Group
{
  public $group_id;
  public $group_name;
  public $group_description;
  public $is_deleted;

  public function exchangeArray($data)
  {
    $this->group_id          = (array_key_exists('group_id', $data)) ? $data['group_id'] : null;
    $this->group_name        = (array_key_exists('group_name', $data)) ? $data['group_name'] : null;
    $this->group_description = (array_key_exists('group_description', $data)) ? $data['group_description'] : null;
    $this->is_deleted        = (array_key_exists('is_deleted', $data)) ? $data['is_deleted'] : null;
  }
  
  public function exchangeObject()
  {
    if (isset($this->group_id)) $data['group_id'] = $this->group_id;
    if (isset($this->group_name)) $data['group_name'] = $this->group_name;
    if (isset($this->group_description)) $data['group_description'] = $this->group_description;
    if (isset($this->is_deleted)) $data['is_deleted'] = $this->is_deleted;
    return $data;
  }
}