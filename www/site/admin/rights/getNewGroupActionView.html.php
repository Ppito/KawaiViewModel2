<?php
global $g_options;
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <form id="formRightGroup" class="form-horizontal" name="formRightGroup" method="post" action="<?php echo $this->createUriFromModule('newGroup?_method=POST'); ?>">
    <input type="hidden" name="from_html" value="true" />
    <?php if ( array_key_exists('FormRightGroup', $_SESSION) && array_key_exists('errors', $_SESSION['FormRightGroup']) && count($_SESSION['FormRightGroup']['errors']) > 0 ) : ?>
      <div>
        <?php foreach($_SESSION['FormRightGroup']['errors'] as $error) : ?>
        <span class="label label-important"><?php echo $error; ?></span><br/>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div class="control-group">
      <label class="control-label" for="user_login">Groupe</label>
      <div class="controls">
        <?php echo Form::select('group_id', $this->group, '', '', array('style' => 'width:200px')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_login">Droit</label>
      <div class="controls">
        <?php echo Form::select('right_id', $this->right, '', '', array('style' => 'width:200px')); ?>
      </div>
    </div>
    <div class="control-group radio">
      <label class="control-label" for="user_login">Autorisation</label>
      <div class="controls btn-group">
        <?php $options = array( 
          'allow' => array('id' => 'allow', 'label' => 'Allow'),
          'deny'  => array('id' => 'deny', 'label' => 'Deny'));
         echo Form::radio('group__right_value', $options, '');?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <?php echo Form::input('Valider', 'submit', '', '', array('value' => "Envoyer", 'class' => 'btn btn-primary')); ?>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">

$().ready(function(){
  $("#formRightGroup").validate({
    rules: {
      group_id: {
        required: true
      },
      right_id: {
        required: true
      },
      group__right_value: {
        required: true
      }
    },
    highlight: function(label) {
      $(label).closest('.control-group').addClass('error');
    },
    success: function(label) {
      label
        .text('OK!').addClass('valid')
        .closest('.control-group').addClass('success');
    }
  });

});
</script>
<?php unset($_SESSION['FormRightGroup']); ?>