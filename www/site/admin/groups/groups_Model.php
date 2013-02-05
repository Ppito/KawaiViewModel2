<?php

class Groups extends Knb_GroupTable
{
  public function findAll() {
    $result = $this->findByIsDeleted(0);
    foreach ($result as $value) {
      $res[] = $value;
    }
    return $res;
  }

  public function deleteGroup($group_id)
  {
  	$group 						 = new Knb_Group();
  	$group->group_id 	 = $group_id;
  	$group->is_deleted = 1;

    return $this->saveGroup($group);
  }

  public static function getListRight()
  {
    return $this->select(function (Select $select) use ($user_id) {
      $select
        ->join(array('gr'  => 'group__right'),  'group_.group_id = gr.group_id')
        ->join(array('r'  => 'right_'), 'r.right_id = gr.right_id')
        ->where(array(
          'g.is_deleted' => 0,
          'r.is_deleted' => 0
        ))
        ->order(array("group_.group_name", "r.right_name")); 
    });
  }
}
?>