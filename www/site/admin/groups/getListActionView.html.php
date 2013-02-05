<?php
global $g_user;
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <?php if ($g_user->haveRight("group_edit")) : ?>
  <div class="alignright">
    <div class="icone"><a rel="shadowbox; width=600;height=600" href="<?php echo $this->createUriFromModule("add", true);?>"><span class="icon-plus-sign" title="Ajouter"></span></a></div>
  </div>
  <?php endif; ?>
  <table class="table table-hover">
    <thead>
      <tr>
      <th>Nom</th>
      <th>Description</th>
      <?php if ($g_user->haveRight("group_edit")) :?>
      <th class="button">Bouton</th>
      <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->groups as $group) : ?>
      <tr id="group_<?php echo $group->group_id; ?>" class="group">
        <td class="name"><?php echo $group->group_name; ?></td>
        <td><?php echo $group->group_description; ?></td>
        <td class="button_list">
          <center>
            <?php if ($g_user->haveRight("group_edit")) : ?>
            <div class="icone">
              <a rel="shadowbox; width=600;height=600" href="<?php echo $this->createUriFromModule($group->group_id . "/edit"); ?>">
                <span class="icon-edit" title="Editer"></span>
              </a>
            </div>
            <?php endif; ?>
            <?php if ($g_user->haveRight("group_delete")) : ?>
            <div class="icone">
              <a rel="shadowbox; width=600;height=130" href="<?php echo $this->createUriFromModule($group->group_id."/delete");?>">
                <span class="icon-trash" title="Supprimer"></span>
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
