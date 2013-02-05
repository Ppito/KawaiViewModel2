<?php
global $g_user;
global $g_options;

$this->initializeParameter('string', 'title');
$this->initializeParameter('string', 'body');
$this->initializeParameterDefault('array', 'smallboxes',  NULL);
$this->initializeParameterDefault('bool',  'noPageTitle', FALSE);
$this->initializeParameterDefault('bool',  'noFullText',  FALSE);

$title = htmlspecialchars($this->title);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title><?php if (!$this->noPageTitle) echo $title . ' - '; ?>Ppito</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"              />
    <meta name="generator"          content="Ppito.fr - Developpement website"      />
    <meta name="viewport"           content="width=device-width, initial-scale=1.0" />
    
    <link rel="shortcut icon" href="<?php echo $this->createUriFromBase('img/favicon.ico'); ?>" />

    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/bootstrap-responsive.css'); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/bootstrap.css'); ?>"            type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/datepicker.css'); ?>"           type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/shadowbox.css'); ?>"            type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/buttons.css'); ?>"              type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/screen.css'); ?>"               type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/print.css'); ?>"                type="text/css" media="print"  />
    <!--[if IE]>
      <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/internet-explorer.css'); ?>"  type="text/css" media="screen" />
    <![endif]-->
    
    <script type="text/javascript">root_url = "<?php echo ROOT_URL; ?>";</script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/jquery.js'); ?>"                ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/shadowbox.js'); ?>"             ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/knb.js'); ?>"                   ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/bootstrap.js'); ?>"             ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/bootstrap-datepicker.js'); ?>"  ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/jquery.validate.js'); ?>"       ></script>
  </head>
  <body>
    <header>
      <div id="logo">
        <a href="/">
          <img src="/img/logo.png" alt="kvm" />
        </a>
      </div>
      <div id="member" class="well well-small">
        <?php if ($g_user->isAnonymous()): ?>
          <form class="form-horizontal" id="loginform" action="<?php echo $this->createUriFromBase('login'); ?>" method="post" onsubmit="doLogin();return false;">
            <label for="login">Utilisateur</label>
            <input class="input-small" type="text" id="login" name="login" />
            <label for="password">Mot de passe</label>
            <input class="input-small" type="password" id="password" />
            <input id="submit_login" type="submit" class="btn btn-mini" value="Ok" />
          </form>
        <?php else: ?>
          <p>
            Bienvenue <strong><?php echo $g_user->getLogin(); ?></strong>.
            <br />
            <a class="btn btn-mini" href="<?php echo $this->createUriFromBase('logout'); ?>">Logout</a>
          </p>
        <?php endif; ?>
      </div>
    </header>

    <nav class="main">
      <ul class="nav nav-tabs">
      <?php foreach ($this->mainmenu as $title => $menu) : ?>
        <li>
          <a href="<?php echo $this->createUriFromModule($menu['link']); ?>"><?php echo $title; ?></a>
        </li>
      <?php endforeach; ?>
     </ul>
    </nav>
    
    <section class="main row-fluid">
      <?php if (!empty($this->submenu)) : ?>
      <aside class="submenu span3">
        <nav class="sub">
        <?php foreach ($this->submenu as $title => $submenuContent) : ?>
          <h2><?php echo $title; ?></h2>
          <ul class="nav nav-tabs nav-stacked">
            <?php foreach ($submenuContent as $text => $menu) : ?>
              <li>
                <a href="<?php echo $this->createUriFromResource($menu['link']); ?>">
                  <i class="icon-chevron-right"></i>
                  <?php echo $text; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
        </nav>
      </aside>
      <?php endif; ?>

      <section id="content"<?php if (empty($this->submenu)) echo ' style="width:963px"';?> class="well span9">
        <h1><?php echo $this->title; ?></h1>
        <?php if (!$this->noFullText): ?>
        <div id="fulltext">
          <?php echo $this->body; ?>
        </div>
        <?php else: echo $this->body; endif; ?>
      </section>
    </section>

    <footer>
      <p>Copyright © 2012 - <?php echo date('Y') ; ?> Ppito - Tous droits réservés pour tous les pays.</p>
    </footer>
    <script type="text/javascript">
      function closeShadobox()    { setTimeout(function() { $(location).attr('href',"<?php echo $this->getCurrentUri();?>"); }, 100);}
      function ShadowViewClose()  { Shadowbox.close(); }
      Shadowbox.init({ modal: true, onClose: closeShadobox });
      $(function(){
        $('span').tooltip();
      });
    </script>
  </body>
</html>
