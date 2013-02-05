<?php
use Zend\Db\Sql\Select;

class Users extends Knb_UserTable
{
  public function findAll() {
    $result = $this->findByIsDeleted(0);
    foreach ($result as $value) {
      $res[] = $value;
    }
    return $res;
  }

  public function deleteUser($user_id)
  {
    $user             = new Knb_User();
    $user->user_id    = $user_id;
    $user->is_deleted = 1;

    return $this->saveUser($user);
  }

  public function getGroupForUser($user_id)
  {
    return $this->select(function (Select $select) use ($user_id) {
        $select
          ->columns(array())
          ->join(array('ug'  => 'user__group'),  'user.user_id = ug.user_id', array())
          ->join(array('g'  => 'group_'), 'g.group_id = ug.group_id')
          ->where(array(
            'g.is_deleted'    => 0,
            'user.is_deleted' => 0,
            'ug.user_id'      => $user_id
          )); 
      });
  }

}
?>
