<?php

/**
 * Obtain a users token and secret using xAuth.
 * This example is intended to be run from the command line. To use it:
 *
 * Instructions:
 * 1) If you don't have one already, create a Twitter application on
 *      https://dev.twitter.com/apps
 * 2) From the application details page copy the consumer key and consumer
 *      secret into the place in this code marked with (YOUR_CONSUMER_KEY
 *      and YOUR_CONSUMER_SECRET)
 * 3) In a terminal or server type:
 *      php /path/to/here/oob.php
 *
 * @author themattharris
 */
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

function welcome() {
  echo <<<EOM
tmhOAuth PHP Out-of-band.
This script runs the OAuth flow in out-of-band mode. You will need access to
a web browser to authorise the application. At the end of this script you will
be presented with the user token and secret needed to authenticate as the user.

EOM;
}

function request_token($tmhOAuth) {
  $code = $tmhOAuth->apponly_request(array(
    'without_bearer' => true,
    'method' => 'POST',
    'url' => $tmhOAuth->url('oauth/request_token', ''),
    'params' => array(
      'oauth_callback' => 'oob',
    ),
  ));

  if ($code == 200) {
    $oauth_creds = $tmhOAuth->extract_params($tmhOAuth->response['response']);

    // update with the temporary token and secret
    $tmhOAuth->reconfigure(array_merge($tmhOAuth->config, array(
      'token'  => $oauth_creds['oauth_token'],
      'secret' => $oauth_creds['oauth_token_secret'],
    )));

    // check the callback has been confirmed
    if ($oauth_creds['oauth_callback_confirmed'] !== 'true') {
      echo "The callback was not confirmed by Twitter so we cannot continue." . PHP_EOL;
      die();
    }

    $url = $tmhOAuth->url('oauth/authorize', '') . "?oauth_token={$oauth_creds['oauth_token']}";
    echo <<<EOM

Copy and paste this URL into your web browser and follower the prompts to get a pin code.
    {$url}

EOM;
  } else {
    echo "There was an error communicating with Twitter. {$tmhOAuth->response['response']}" . PHP_EOL;
    die();
  }
}

function ask_for_pin() {
  echo 'What was the Pin Code?: ';
  $handle = fopen("php://stdin","r");
  $data = fgets($handle);
  return trim($data);
}

function access_token($tmhOAuth, $pin) {
  $code = $tmhOAuth->user_request(array(
    'method' => 'POST',
    'url' => $tmhOAuth->url('oauth/access_token', ''),
    'params' => array(
      'oauth_verifier' => trim($pin),
    )
  ));

  if ($code == 200) {
    $oauth_creds = $tmhOAuth->extract_params($tmhOAuth->response['response']);

    // print tokens
    echo <<<EOM
Congratulations, below is the user token and secret for {$oauth_creds['screen_name']}.
Use these to make authenticated calls to Twitter using the application with
consumer key: {$tmhOAuth->config['consumer_key']}

User Token: {$oauth_creds['oauth_token']}
User Secret: {$oauth_creds['oauth_token_secret']}

EOM;
  } else {
    echo "There was an error communicating with Twitter. {$tmhOAuth->response['response']}" . PHP_EOL;
  }
  die();
}

welcome();
request_token($tmhOAuth);
access_token($tmhOAuth, ask_for_pin());