<?php

/**
* Base file for tmhOAuthExamples. This class extends tmhOAuth which means
* it can do everything tmhOAuth does. All examples implement this class as
* opposed to tmhOAuth directly.
*
* In production you shouldn't use this file, but you could use the idea of
* extended tmhOAuth with any includes or helper functions you might want
* for all your scripts.
*
* Although this uses a static user_token and user_secret, you can always
* set them at runtime from a database or local cache or other user tokens/secrets
* that users have allowed you to use on their behalf.
*
* Instructions:
* 1) Ensure you have tmhOAuth checked out or installed via composer.
* 2) If you don't have one already, create a Twitter application on
*      https://dev.twitter.com/apps
* 3) From the application details page copy the consumer key and consumer
*      secret into the place in this code marked with (YOUR_CONSUMER_KEY
*      and YOUR_CONSUMER_SECRET)
* 4) From the application details page copy the access token and access token
*      secret into the place in this code marked with (A_USER_TOKEN
*      and A_USER_SECRET)
* 5) In a terminal or on a server run any of the example scripts:
*      php verify_credentials.php
*
* @author themattharris
*/

define('TMH_INDENT', 25);

// use composers autoload if it exists, or require directly if not
if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php')) {
  require __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
} elseif (file_exists(__DIR__.DIRECTORY_SEPARATOR.'tmhOAuth'.DIRECTORY_SEPARATOR.'tmhOAuth.php')) {
  require __DIR__.DIRECTORY_SEPARATOR.'tmhOAuth'.DIRECTORY_SEPARATOR.'tmhOAuth.php';
} else {
  throw "tmhOAuth.php could not be found. have you tried installing with composer?";
}

class tmhOAuthExample extends tmhOAuth {

  public function __construct($config = array()) {

    $this->config = array_merge(
      array(

        // change the values below to ones for your application
        'consumer_key'    => 'YOUR_CONSUMER_KEY',
        'consumer_secret' => 'YOUR_CONSUMER_SECRET',
        'token'           => 'A_USER_TOKEN',
        'secret'          => 'A_USER_SECRET',
        'bearer'          => 'YOUR_OAUTH2_TOKEN',

        'user_agent'      => 'tmhOAuth ' . parent::VERSION . ' Examples 0.1',
      ),
      $config
    );

    if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'tmh_myconfig.php')) {
      include __DIR__.DIRECTORY_SEPARATOR.'tmh_myconfig.php';
      $this->config = array_merge(
        $this->config,
        tmh_myconfig()
      );
    }

    parent::__construct($this->config);
  }


  // below are helper functions for rendering the response from the Twitter API in a command line interface
  public function render_response() {
    self::eko('Request Settings', false, '=');
    self::eko_kv($this->request_settings, 0, TMH_INDENT);
    self::eko('');

    self::eko('Request Headers', false, '=');
    self::eko_kv($this->convert_headers($this->response['info']['request_header']), 0, TMH_INDENT);
    self::eko('');

    self::eko('Request Data', false, '=');
    $d = $this->response['info'];
    unset($d['request_header']);
    self::eko_kv($d, 0, TMH_INDENT);
    self::eko('');

    self::eko('Response Headers', false, '=');
    self::eko_kv($this->response['headers'], 0, TMH_INDENT);
    self::eko('');

    if (defined(JSON_PRETTY_PRINT)) {
      self::eko('Response Body (Formatted)', false, '=');
      $d = json_decode($this->response['response']);
      $d = json_encode($d, JSON_PRETTY_PRINT);
      self::eko($d);
    } else {
      self::eko('Response Body (As an Object)', false, '=');
      $d = json_decode($this->response['response'], true);
      var_dump($d);
    }

    self::eko('');
    self::eko('Raw response', true, '=');
    self::eko($this->response['raw'], true);
  }

  private function convert_headers($headers) {
    $headers = explode(PHP_EOL, $headers);
    $_headers = array();
    foreach ($headers as $header) {
      list($key, $value) = array_pad(explode(':', trim($header), 2), 2, null);
      $_headers[trim($key)] = trim($value);
    }
    return $_headers;
  }

  private static function eko_kv($items, $indent=0, $padding=10) {
    foreach ((array)$items as $k => $v) {
      if (is_array($v) && !empty($v)) {
        $text = str_pad('', $indent) . str_pad($k, $padding);
        self::eko($text);

        foreach ($v as $k2 => $v2) {
          self::eko_kv(array($k2 => $v2), $indent+5, $padding);
        }
      } else {
        $text = str_pad('', $indent) . str_pad($k, $padding) . implode('',(array)$v);
        self::eko($text);
      }
    }
  }

  private static function eko($text, $newline=false, $underline=NULL) {
    echo $text . PHP_EOL;

    if (!empty($underline))
      echo str_pad('', strlen($text), $underline) . PHP_EOL;

    if ($newline)
      echo PHP_EOL;
  }
}