<?php
global $g_options;
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <form id="formGroup" class="form-horizontal" name="formGroup" method="post" action="<?php echo $this->createUriFromModule($this->group_id . '/edit?_method=POST'); ?>">
  <input type="hidden" name="from_html" value="true" />
    <?php if ( array_key_exists('FormGroup', $_SESSION) && array_key_exists('errors', $_SESSION['FormGroup']) && count($_SESSION['FormGroup']['errors']) > 0 ) : ?>
    <div>
      <?php foreach($_SESSION['FormGroup']['errors'] as $error) : ?>
      <span class="label label-important"><?php echo $error; ?></span><br/>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="control-group">
      <label class="control-label" for="user_login">Nom</label>
      <div class="controls">
        <?php echo Form::input('group_name', 'text', (isset($this->group_name) ? $this->group_name : ""), '', array('style' => 'width:200px')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_login">Description</label>
      <div class="controls">
        <?php echo Form::textarea('group_description', (isset($this->group_description) ? $this->group_description : ''), '', array('style' => 'width:200px')); ?>
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
  $().ready(function() {
    $("#formGroup").validate({
      rules : {
        group_name : {
          required : true,
          minlength : 2,
          maxlength : 255
        },
        group_description : {
          required : true,
          minlength : 2,
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
<?php unset($_SESSION['FormGroup']); ?>