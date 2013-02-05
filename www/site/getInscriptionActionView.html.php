<?php
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <form id="formUser" class="form-horizontal" name="formUser" method="post" action="<?php echo $this->createUriFromModule('/inscription?_method=POST'); ?>">
    <input type="hidden" name="from_html" value="true" />
    <?php if ( array_key_exists('FormUser', $_SESSION) && array_key_exists('errors', $_SESSION['FormUser']) && count($_SESSION['FormUser']['errors']) > 0 ) : ?>
      <div>
        <?php foreach($_SESSION['FormUser']['errors'] as $error) : ?>
        <span class="label label-important"><?php echo $error; ?></span><br/>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div class="control-group">
      <label class="control-label" for="user_login">Identifiant</label>
      <div class="controls">
        <?php echo Form::input('user_login', 'text', (isset($this->user_login) ? $this->user_login : "")); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_last_name">Nom</label>
      <div class="controls">
        <?php echo Form::input('user_last_name', 'text', (isset($this->user_last_name) ? $this->user_last_name : '')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_first_name">Prénom</label>
      <div class="controls">
        <?php echo Form::input('user_first_name', 'text', (isset($this->user_last_name) ? $this->user_first_name : '')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_birthday">Date de naissance</label>
      <div class="controls">
        <?php echo Form::input('user_birthday', 'text', (isset($this->user_birthday) ? $this->user_birthday : ''), 'user_birthday'); ?>
      </div>
    </div>
    <div class="control-group radio">
      <label class="control-label" for="user_sexe">Sexe</label>
      <div class="controls btn-group">
        <?php
        $options = array(
          '0' => array('id' => 'homme', 'label' => 'Homme'), 
          '1' => array('id' => 'femme', 'label' => 'Femme'));
        echo Form::radio('user_sexe', $options, (isset($this->user_sexe) ? $this->user_sexe : ''), true);
        ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_mail">Adresse mail</label>
      <div class="controls">
        <?php echo Form::input('user_mail', 'email', (isset($this->user_mail) ? $this->user_mail : '')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_phone">Téléphone</label>
      <div class="controls">
        <?php echo Form::input('user_phone', 'tel', (isset($this->user_phone) ? $this->user_phone : '')); ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="user_password">Mot de passe</label>
      <div class="controls">
        <?php echo Form::input('user_password', 'password'); ?>
        <br />
        <?php echo Form::input('user_verif_password', 'password'); ?>
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
  $.validator.addMethod('phone', function(value) {
    var numbers = value.split(/\d/).length - 1;
    return (numbers >= 10 && numbers <= 20 && value.match(/^(\+){0,1}(\d|\s|\(|\)){10,20}$/));
  }, 'Please enter a valid phone number');

  $(function(){
    $("#formUser").validate({
      rules: {
        user_login: {
          required: true,
          minlength: 4,
          maxlength: 64
         },
        user_last_name: {
          required: true,
          minlength: 2,
          maxlength: 128
         },
        user_first_name: {
          required: true,
          minlength: 2,
          maxlength: 128
         },
        user_sexe: {
          required: true
         },
        user_birthday: {
          required: true,
          date: true
        },
        user_phone: {
          required: false,
          phone: true,
          minlength: 10,
          maxlength: 20
        },
        user_mail: {
          required: false,
          email: true,
          maxlength: 512
        },
        user_password: {
          required: false,
          minlength: 6,
          maxlength: 16
        },
        user_verif_password: {
          required: false,
          minlength: 6,
          maxlength: 16
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

    // $.fn.datepicker.dates['fr'] = {
      // days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samdi'],
      // daysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
      // daysMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
      // months: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
      // monthsShort: ['Jan','Fév','Mar','Avr','Mai','Jui','Jui','Aoû','Sep','Oct','Nov','Déc']
    // };
    $("#user_birthday").datepicker({
         inline:  true,
         format:  'dd/mm/yyyy',
         weekStart: 1,
         language: 'fr',
    });
  });
</script>
<?php unset($_SESSION['FormUser']); ?>
