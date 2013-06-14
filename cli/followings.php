<?php

# https://dev.twitter.com/docs/api/1.1/get/friends/list

function check_rate_limit($response) {
  $headers = $response['headers'];
  if (0 === intval($headers['x-rate-limit-remaining'])) :
    $reset = $headers['x-rate-limit-reset'];
    $sleep = intval($reset) - time();
    echo 'rate limited. reset time is ' . $reset . PHP_EOL;
    echo 'sleeping for ' . $sleep . ' seconds';
    sleep($sleep);
  endif;
}

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$screen_name = 'tmhoauth';
$cursor = '-1';
$friends = array();
while (true) :
  if ($cursor == '0')
    break;

  echo '.';

  $code = $tmhOAuth->request(
    'GET',
    $tmhOAuth->url('1.1/friends/list'),
    array(
      'cursor' => $cursor,
      'skip_status' => true,
      'screen_name' => $screen_name
    )
  );

  check_rate_limit($tmhOAuth->response);

  if ($code == 200) {
    $data = json_decode($tmhOAuth->response['response'], true);
    $friends = array_merge($friends, $data['users']);
    $cursor = $data['next_cursor_str'];
  } else {
    $tmhOAuth->render_response();
    break;
  }
  usleep(500000);
endwhile;

echo '@' . $screen_name . ' follows ' . count($friends) . ' users.' . PHP_EOL . PHP_EOL;
foreach ($friends as $friend) {
  echo '@' . $friend['screen_name'] . ' (' . $friend['id_str'] . ')' . PHP_EOL;
}