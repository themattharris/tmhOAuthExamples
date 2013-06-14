<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$code = $tmhOAuth->user_request(array(
  'method' => 'POST',
  'url' => $tmhOAuth->url('1.1/statuses/update'),
  'params' => array(
    'status' => 'Something for the weekend'
  )
));

$tmhOAuth->render_response();