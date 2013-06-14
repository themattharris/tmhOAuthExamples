<?php

require 'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

define('DEMO_ROOT', __DIR__.DIRECTORY_SEPARATOR.'web');
session_start();

function available_demos($dir) {
  $demos = array();

  $dh = opendir($dir);
  while (($name = readdir($dh)) !== false) {
    if (!is_dir("${dir}/${name}") && !in_array($name, array('.', '..', '.git')) && stripos($name, '.php')) {
      $title = str_ireplace('.php', '', $name);
      $demos[$title] = "${dir}/${name}";
    }
  }
  return $demos;
}

function current_demo($demos) {
  if (isset($_GET['e']) && in_array($_GET['e'], array_keys($demos)))
    return $_GET['e'];

  return null;
}

function page_title($demo) {
  $title = 'tmhOAuth Examples';
  if (!is_null($demo))
    $title .= ': ' . $demo;

  echo $title;
}

function demo_a_tag($name) {
  echo "<a href=\"?e=${name}\">${name}</a>";
}

$demos = available_demos(DEMO_ROOT);
$current_demo = current_demo($demos);
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php page_title($current_demo); ?></title>
  <style type="text/css">
    #demos {
      width: 20%;
      float: left;
    }
    #demo {
      width: 80%;
      float: right;
    }
    #raw {
      clear: both;
    }
    #raw pre {
      width: 100%;
      white-space: pre-wrap;
    }
    label {
      display: block;
    }
    input[type=submit] {
      margin-top: 1em;
    }
  </style>
</head>
<body>
  <div id="demos">
    <h2>Demos</h2>
  <?php if (!empty($demos)) : ?>
    <ul>
  <?php foreach ($demos as $k => $v) : ?>
      <li><?php demo_a_tag($k); ?></li>
  <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  </div>

  <div id="demo">
  <?php if ($path = $demos[$current_demo]) :
    include $path;
  else : ?>
    <p>Select a demo from the list.</p>
  <?php endif; ?>
  </div>

  <?php if (!empty($tmhOAuth->response['raw'])) : ?>
  <div id="raw">
    <h2>Raw Response</h2>
    <pre>
      <?php echo $tmhOAuth->response['raw']; ?>
    </pre>
  </div>
  <?php endif; ?>
</body>
</html>
