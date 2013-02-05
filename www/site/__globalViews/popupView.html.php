<?php
global $g_user;
global $g_options;

$this->initializeParameter('string', 'body');
$this->initializeParameterDefault('array', 'smallboxes',  NULL);
$this->initializeParameterDefault('bool',  'noPageTitle', FALSE);
$this->initializeParameterDefault('bool',  'noFullText',  FALSE);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title><?php if (!$this->noPageTitle) echo $this->title . ' - '; ?>Ppito</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"              />
    <meta name="generator"          content="Ppito.fr - Developpement website"      />
    <meta name="viewport"           content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/bootstrap-responsive.css'); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/bootstrap.css'); ?>"            type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/buttons.css'); ?>"              type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/datepicker.css'); ?>"           type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo $this->createUriFromBase('styles/#SKIN#/screen_shadowbox.css'); ?>"     type="text/css" media="screen" />

    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/jquery.js'); ?>"                ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/jquery.validate.js'); ?>"       ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/bootstrap.js'); ?>"             ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/bootstrap-datepicker.js'); ?>"  ></script>
    <script type="text/javascript" src="<?php echo $this->createUriFromBase('script/knb.js'); ?>"                   ></script>
  </head>
  <body id="shadow_page">
    <?php if (!$this->noPageTitle):?>
    <h2>&gt; <?php echo $this->title; ?></h2>
    <?php endif; ?>
    <?php if (!$this->noFullText): ?>
    <div id="fulltext">
      <?php echo $this->body; ?>
    </div>
    <?php else: ?>
      <?php echo $this->body; ?> 
    <?php endif; ?>
  </body>
</html>
