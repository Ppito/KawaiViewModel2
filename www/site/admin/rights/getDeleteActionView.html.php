<?php
global $g_options;
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <form id="formRight" name="formRight" method="post" action="<?php echo $this->createUriFromModule($this->right_id . '/delete?_method=POST'); ?>">
    <input type="hidden" name="from_html" value="true" />
    <h4>Êtes vous sûr de vouloir supprimer ce droit ?</h4>
    <div class="alignright">
      <?php echo Form::input('cancel', 'button', '', '', array('value' => "Cancel", 'class' => 'btn', 'onclick' => 'parent.Shadowbox.close();')); ?>
      <?php echo Form::input('valider', 'submit', '', '', array('value' => "Supprimer", 'class' => 'btn btn-danger')); ?>
    </div>
  </form>
</div>
<?php unset($_SESSION['formRight']); ?>