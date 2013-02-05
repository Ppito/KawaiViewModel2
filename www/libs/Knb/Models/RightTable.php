<?php

class Knb_RightTable extends Knb_AbstractTable
{
  protected $table     = 'right_';
  protected $tableName = 'Knb_Right';

  public function saveRight(Knb_Right $right)
  {
    $data = $right->exchangeObject();
    $id   = (int) $right->right_id;

    if ($id == 0) {
      $this->insert($data);
      $id = $this->getLastInsertValue();
    } else {
      if ($this->findOneByRightId($id)) {
        $this->update($data, array('right_id' => $id));
      } else {
        throw new Exception('Right id does not exist');
      }
    }
    return $id;
  }

  public function deleteRight($id)
  {
    $this->delete(array('right_id' => $id));
  }
}