<?php

class   Knb_UserTable extends Knb_AbstractTable
{
  protected $table          = 'user';
  protected $tableName      = 'Knb_User';

  public function saveUser(Knb_User $user)
  {
    global $g_sql;
    global $g_database;

    $data = $user->exchangeObject();
    $id   = (int) $user->user_id;

    if (array_key_exists('user_password_md5', $data) && !empty($data['user_password_md5'])) {
      $nonce = rand(1, 2147483647);
      $data['user_password_nonce'] = $nonce;
      $data['user_password_md5']   = md5($nonce.$data['user_password_md5']);
    }

    if ($id == 0) {
      $this->insert($data);

      $id      = $this->getLastInsertValue();
      $stmt    = $g_database->createStatement();
      $insert  = $g_sql->insert()->into('user__group')
        ->values(array('user_id' => $id, 'group_id' => 2));
      $insert->prepareStatement($g_database, $stmt);
      $stmt->execute();
    } else {
      if ($this->findOneByUserId($id)) {
        $this->update($data, array('user_id' => $id));
      } else {
        throw new Exception('User id does not exist');
      }
    }
    return $id;
  }

  public function deleteUser($id)
  {
    $this->delete(array('user_id' => $id));
  }
}

