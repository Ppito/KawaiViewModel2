<?php

class   Knb_GroupTable extends Knb_AbstractTable
{
  protected $table     = 'group_';
  protected $tableName = 'Knb_Group';

  public function saveGroup(Knb_Group $group)
  {
    $data = $group->exchangeObject();
    $id   = (int) $group->group_id;

    if ($id == 0) {
      $this->insert($data);
      $id = $this->getLastInsertValue();
    } else {
      if ($this->findOneByGroupId($id)) {
        $this->update($data, array('group_id' => $id));
      } else {
        throw new Exception('Group id does not exist');
      }
    }
    return $id;
  }
  
  public function deleteGroup($id)
  {
    return $this->delete(array('group_id' => $id));
  }
}