<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$code = $tmhOAuth->apponly_request(array(
  'without_bearer' => true,
  'method' => 'POST',
  'url' => $tmhOAuth->url('oauth/access_token', ''),
  'params' => array(
    'x_auth_username'  => 'USERNAME',
    'x_auth_password'  => 'PASSWORD',
    'x_auth_mode'      => 'client_auth',
    'send_error_codes' => true,
  )
));

if ($code == 200) {
  $data = $tmhOAuth->extract_params($tmhOAuth->response['response']);
  if (isset($data['oauth_token'])) {
    echo 'OAuth Credentials for @'.$data['screen_name'].' ('.$data['user_id'].')' . PHP_EOL;
    echo 'Token: '.$data['oauth_token'].PHP_EOL;
    echo 'Secret: '.$data['oauth_token_secret'].PHP_EOL;

    // instead of printing these to screen you would typically save them to a database
    // if you do store the oauth_token and oauth_secret to a database it's best practice
    // store them with some kind of encryption. e.g. mcrypt_encrypt
  }
} else {
  $tmhOAuth->render_response();
}