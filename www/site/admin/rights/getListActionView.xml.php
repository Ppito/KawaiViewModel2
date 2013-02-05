<?php $this->guardAllParametersXml(); ?>
<rights>
<?php foreach($this->rights as $right):?>
  <right
    id="<?php echo $right->right_id; ?>"
    name="<?php echo $right->right_name; ?>"
    description="<?php echo addslashes($right->right_description); ?>"
    />
<?php endforeach; ?>
</rights>
