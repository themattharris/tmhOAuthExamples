<?php

// this example follows the guidance given on dev.twitter.com for obtaining an app-only bearer token
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$bearer = $tmhOAuth->bearer_token_credentials();
$params = array(
  'grant_type' => 'client_credentials',
);

$code = $tmhOAuth->request(
  'POST',
  $tmhOAuth->url('/oauth2/token', null),
  $params,
  false,
  false,
  array(
    'Authorization' => "Basic ${bearer}"
  )
);

if ($code == 200) {
  $data = json_decode($tmhOAuth->response['response']);
  if (isset($data->token_type) && strcasecmp($data->token_type, 'bearer') === 0) {
    $new_bearer = $data->access_token;
    echo 'Your app-only bearer token is: ' . $new_bearer . PHP_EOL;
  }
} else {
  $tmhOAuth->render_response();
}