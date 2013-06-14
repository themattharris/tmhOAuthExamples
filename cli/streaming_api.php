<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

function my_streaming_callback($data, $length, $metrics) {
  $file = __DIR__.'/metrics.txt';

  echo $data .PHP_EOL;
  if (!is_null($metrics)) {
    if (!file_exists($file)) {
      $line = 'time' . "\t" . implode("\t", array_keys($metrics)) . PHP_EOL;
      file_put_contents($file, $line);
    }
    $line = time() . "\t" . implode("\t", $metrics) . PHP_EOL;
    file_put_contents($file, $line, FILE_APPEND);
  }
  return file_exists(dirname(__FILE__) . '/STOP');
}

$code = $tmhOAuth->streaming_request(
  'GET',
  'https://stream.twitter.com/1.1/statuses/sample.json',
  array(),
  'my_streaming_callback'
);

$tmhOAuth->render_response();