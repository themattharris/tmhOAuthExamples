<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$code = $tmhOAuth->user_request(array(
  'url' => $tmhOAuth->url('1.1/account/verify_credentials')
));

$tmhOAuth->render_response();