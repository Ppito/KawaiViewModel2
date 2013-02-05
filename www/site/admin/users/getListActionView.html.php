<?php
global $g_user;
$this->guardAllParametersHtml();
?>
<div class="content_list">
  <?php if ($g_user->haveRight("user_edit")) : ?>
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
        <th>Utilisateur</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Membre</th>
        <?php if ($g_user->haveRight("user_edit")) :?>
        <th class="button">Bouton</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->users as $user) : ?>
      <tr id="user_<?php echo $user->user_id; ?>" class="user">
        <td class="login"><?php echo $user->user_login; ?></td>
        <td><?php echo $user->user_last_name; ?></td>
        <td><?php echo $user->user_first_name; ?></td>
        <td><?php echo $user->user_mail; ?></td>
        <td><?php echo $user->user_phone; ?></td>
        <td><?php echo implode(", ", $user->user_groups); ?></td>
        <td class="button_list">
          <center>
            <?php if ($g_user->haveRight("user_edit")) : ?>
            <div class="icone">
              <a rel="shadowbox; width=600;height=600" href="<?php echo $this->createUriFromModule($user->user_id."/edit");?>">
                <span class="icon-edit" title="Editer"></span>
              </a>
            </div>
            <?php endif; ?>
            <?php if ($g_user->haveRight("user_delete")) : ?>
            <div class="icone">
              <a rel="shadowbox; width=600;height=130" href="<?php echo $this->createUriFromModule($user->user_id."/delete");?>">
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