<?php

use Zend\Db\Sql\Select,
    Zend\Db\TableGateway\TableGateway;

class Rights extends Knb_RightTable
{
  public function findAll() 
  {
    $result = $this->findByIsDeleted(0);
    foreach ($result as $value) {
      $res[] = $value;
    }
    return $res;
  }

  public function getGroupList()
  {
     $result = $this->select(function (Select $select) {
       $select
        ->join(array('gr' => 'group__right'),  'right_.right_id = gr.right_id')
        ->join(array('g'  => 'group_'), 'g.group_id = gr.group_id')
        ->where(array('g.is_deleted' => 0, 'right_.is_deleted' => 0))
        ->order(array("g.group_name", "right_.right_name")); 
    });

    foreach ($result as $value) {
      $res[] = $value;
    }
    return $res;
  }

  public static function createRightGroup(array $params)
  {
    global $g_database;
    $table = new TableGateway('group__right', $g_database);
    return $table->insert($params);
  }

  public static function updateGroupRight($group_id, $right_id)
  {
    global $g_database;
    $value = array('deny' => 'allow', 'allow' => 'deny');

    $table = new TableGateway('group__right', $g_database);
    $res = $table->select(function (Select $select) use ($group_id, $right_id) {
        $select->where(array('group_id' => $group_id, 'right_id' => $right_id));
    });
    $res = $res->current();

    $params['group__right_value'] = $value[$res['group__right_value']];
    $where['group_id = ?'] = $group_id;
    $where['right_id = ?'] = $right_id;

    $table->update($params, $where);
    return $value[$res['group__right_value']];
  }
 
  public static function deleteRightGroup($right_id,$group_id)
  {
    global $g_database;
    $table = new TableGateway('group__right', $g_database);
    return $table->delete(array(
       'right_id = ?' => $right_id
      ,'group_id = ?' => $group_id
    ));
  }

}

?>