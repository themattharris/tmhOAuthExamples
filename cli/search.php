<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$code = $tmhOAuth->apponly_request(array(
  'method' => 'GET',
  'url' => $tmhOAuth->url('1.1/search/tweets'),
  'params' => array(
    'q' => 'tmhoauth'
  )
));

$tmhOAuth->render_response();