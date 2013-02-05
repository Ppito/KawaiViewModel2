<groups>
<?php
$this->guardAllParametersXml();

foreach($this->groups as $group):?>
<group
  id="<?php echo $group->group_id; ?>"
  name="<?php echo $group->group_name; ?>"
  description="<?php echo addslashes($group->group_description); ?>"
  />
<?php endforeach; ?>
</groups>
