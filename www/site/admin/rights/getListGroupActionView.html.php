<?php
global $g_user;
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <?php if ($g_user->haveRight("right_edit")) : ?>
  <div class="alignright">
    <div class="icone">
      <a rel="shadowbox; width=600;height=600" href="<?php echo $this->createUriFromModule("newGroup", true);?>">
        <span class="icon-plus-sign" title="Ajouter"></span>
      </a>
    </div>
  </div>
  <?php endif; ?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom du groupe</th>
        <th>Nom du droit</th>
        <th>Autorisation</th>
        <?php if ($g_user->haveRight("right_edit")) : ?>
        <th class="button">Bouton</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->rights_group as $right) : ?>
      <tr id="group_right_<?php echo $right->group_id; ?>_<?php echo $right->right_id; ?>" class="group_right">
        <td class="name"><?php echo $right->group_name; ?></td>
        <td><?php echo $right->right_name; ?></td>
        <td class="button <?php echo $right->group__right_value;?>">
          <button class="btn btn-small<?php if ($right->group__right_value=='deny') echo ' btn-danger';?>">
          <?php echo $right->group__right_value; ?>
          </button>
        </td>
        <?php if ($g_user->haveRight("right_delete")) : ?>
        <td class="button_list">
          <center>
            <div class="icone">
              <a rel="shadowbox; width=600;height=130" href="<?php echo $this->createUriFromModule($right->right_id."/".$right->group_id."/deleteGroup");?>">
                <span class="icon-trash" title="Supprimer"></span>
              </a>
            </div>
          </center>
        </td>
        <?php endif; ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $(function(){
    $('button.btn').click(function(){
      var el   = $(this);
      var elem = el.closest('.group_right');
      var id   = elem[0].id.split('_');
      $.post("<?php echo $this->createUriFromModule('');?>/"+id[3]+"/"+id[2]+"/changeRight.json?_method=POST", function(data) {
      if (data.res == 'allow') {
        el.removeClass('btn-danger');
      } else if (data.res == 'deny') {
        el.addClass('btn-danger');
      }
      el.html(data.res);
      }, "json");
    });
  });
</script>
