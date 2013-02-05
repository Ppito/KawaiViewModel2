<?php

function knb_exception_handler($exception)
{
  global $g_options;

  /* 
   * For most users we want to display either the configured message if possible or a short error message.
   */
  if ( !isset($g_options['error']['debug']) || $g_options['error']['debug'] !== TRUE ) {
    if ( isset($g_options['error']['redirect']) && $g_options['error']['redirect'] !== FALSE &&  !headers_sent() ) {
      header('location: ' . $g_options['error']['redirect']);
    } else {
      echo "An exception has occured, please contact the site administrator";
    }
    exit;
  }

  /* 
   * We will use some functions like var_export that don't like for any buffering to be in progress.
   */
  while ( @ob_end_clean() );

  $sanitize_func = create_function('&$a', 'if (is_string($a)) { $a = htmlentities($a); }');
  $css           = ROOT_URL . 'styles/error.css';
  $title         = htmlentities(get_class($exception));
  $message       = htmlentities($exception->getMessage());
  $line          = htmlentities($exception->getLine());
  $file          = htmlentities($exception->getFile());
  $stackTrace    = "";

  foreach ( $exception->getTrace() as $trace ) {

    array_walk($trace, $sanitize_func);

    $stackTrace .= '<li><div class="caller">';

    $reflectedCaller = null;
    if ( isset($trace['class']) ) {
      $stackTrace .= '<span class="class">'.$trace['class'].'</span><span class="type">'.$trace['type'].'</span>';

      $reflectedCaller = new ReflectionMethod($trace['class'], $trace['function']);
    } else {
      try {
        $reflectedCaller = new ReflectionFunction($trace['function']);
      } catch(ReflectionException $e) {
              // Internal function can't be reflected upon... we may have it one of them.
      }
    }
    $stackTrace .= '<span class="function">'.$trace['function'].'</span><span class="argdef">(';

    if ( $reflectedCaller !== null ) {
      foreach ( $reflectedCaller->getParameters() as $arg ) {
        if ( $arg->isPassedByReference() ) $stackTrace .= '&amp;';
        $stackTrace .= '$' . htmlentities($arg->getName());
                if ( $arg->isDefaultValueAvailable() ) {
          $stackTrace .= ' = ' . htmlentities(var_export($arg->getDefaultValue(), TRUE));
        }
      }
    } else {
      $stackTrace .= "...";
    }

    $stackTrace .= ')
        </span>
      </div>
      <p class="position">
        At line <span class="line">'.$trace['line'].'</span> of <span class="file">'.$trace['file'].'</span>
      </p>';

    if ( isset($trace['args']) && count($trace['args']) ) {
      $stackTrace .= '<p class="args">Argument values : </p>';
      $stackTrace .= '<ul class="args">';
      foreach( $trace['args'] as $arg ) {
        $stackTrace .= '<li>'.htmlentities(var_export($arg, TRUE)).'</li>';
      }
      $stackTrace .= '</ul>';
    }
    $stackTrace .= '</li>';
  }

  $html = <<<EOF
<!DOCTYPE>
<html>
  <head>
    <title>Exception</title>
    <link rel="stylesheet" href="{$css}" type="text/css"></head>
  </head>
  <body>
    <h1>{$title}</h1>
    <p id="message">{$message}</p>
    <p>
      At line <span id="line">{$line}</span> of <span id="file">{$file}</span>
    </p>
    <ul id="stacktrace">
      {$stackTrace}
    </ul>
  </body>
</html>
EOF;

  echo $html;
}
?>