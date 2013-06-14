<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$code = $tmhOAuth->user_request(array(
  'method' => 'GET',
  'url'    => $tmhOAuth->url('1.1/users/lookup'),
  'params' => array(
    'user_id' => array(
      777925,
    ),
    'screen_name' => array(
      'tmhoauth',
    ),
    'map' => 1
  ),
));

$tmhOAuth->render_response();