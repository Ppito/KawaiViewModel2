<?php
$this->guardAllParametersXml();
?>
<users>
  <?php
  foreach ($this->users as $user) :
    $avatarPath = "";
    $avatarLocalPath = "upload/avatar/".$user->user_id.".jpg";
    if (file_exists(ROOT_PATH.$avatarLocalPath)) {
      $avatarPath = ROOT_URL.$avatarLocalPath;
    }
  ?>
    <user
      id="<?php echo $user->user_id; ?>"
      login="<?php echo $user->user_login; ?>"
      last_name="<?php echo $user->user_last_name; ?>"
      first_name="<?php echo $user->user_first_name; ?>"
      mail="<?php echo $user->user_mail; ?>"
      phone="<?php echo $user->user_phone; ?>"
      avatar="<?php echo $avatarPath; ?>"
      groups="<?php echo implode(", ", $user->user_groups); ?>"
      />
  <?php endforeach; ?>
</users>
