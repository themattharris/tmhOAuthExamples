<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

function request() {
  global $tmhOAuth;

  // verify crendentials using one set of credentials
  $code = $tmhOAuth->user_request(array(
    'url' => $tmhOAuth->url('1.1/account/verify_credentials')
  ));

  $d = json_decode($tmhOAuth->response['response']);
  if ($code == 200) {
    echo 'hello @' . $d->screen_name . PHP_EOL;
  } elseif (isset($d->errors[0]->message)) {
    echo 'hmm, the API returned an error: ' . $d->errors[0]->message . PHP_EOL;
  } else {
    echo 'hmm, the API returned an error: ' . $tmhOAuth->response['response'] . PHP_EOL;
  }
}

request();

// change to another set of credentials by copying the current config and merging new values on top
$tmhOAuth->reconfigure(array_merge($tmhOAuth->config, array(
  'token' => 'ANOTHER_USER_TOKEN',
  'secret' => 'ANOTHER_USER_SECRET',
));

request();