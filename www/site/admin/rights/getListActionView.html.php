<?php
global $g_user;
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <?php if ($g_user->haveRight("right_edit")) : ?>
  <div class="alignright">
    <div class="icone">
      <a rel="shadowbox; width=600;height=600" href="<?php echo $this->createUriFromModule("add", true);?>">
        <span class="icon-plus-sign" title="Ajouter"></span>
      </a>
    </div>
  </div>
  <?php endif; ?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Description</th>
        <?php if ($g_user->haveRight("right_edit")) : ?>
        <th class="button">Bouton</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->rights as $right) : ?>
      <tr id="right_<?php echo $right->right_id; ?>" class="right">
        <td class="name"><?php echo $right->right_name; ?></td>
        <td><?php echo $right->right_description; ?></td>
        <td class="button_list">
          <center>
            <?php if ($g_user->haveRight("right_edit")) : ?>
            <div class="icone">
              <a rel="shadowbox; width=600;height=600" href="<?php echo $this->createUriFromModule($right->right_id."/edit");?>">
                <span class="icon-edit" title="Editer"></span>
              </a>
            </div>
            <?php endif; ?>
            <?php if ($g_user->haveRight("right_delete")) : ?>
            <div class="icone">
              <a rel="shadowbox; width=600;height=130" href="<?php echo $this->createUriFromModule($right->right_id."/delete");?>">
                <span class="icon-trash" title="Supprimer" ></span>
              </a>
            </div>
            <?php endif; ?>
          </center>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
