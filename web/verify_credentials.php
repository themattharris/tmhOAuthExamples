<div id="verify_credentials">
  <h2>Verify Credentials</h2>
<?php

$code = $tmhOAuth->user_request(array(
  'url' => $tmhOAuth->url('1.1/account/verify_credentials')
));

if ($code == 200) :
  $data = json_decode($tmhOAuth->response['response'], true);

  if (isset($data['status'])) {
    $code = $tmhOAuth->user_request(array(
      'url' => $tmhOAuth->url('1.1/statuses/oembed'),
      'params' => array(
        'id' => $data['status']['id_str']
      )
    ));

    if ($code == 200)
      $tweet = json_decode($tmhOAuth->response['response'], true);
  }
?>
  <p>Hello, @<?php echo $data['screen_name'] ?>.</p>
  <?php echo $tweet['html'] ?>
<?php else : ?>
  <h3>Something went wrong</h3>
  <p><?php echo $tmhOAuth->response['error'] ?></p>
<?php endif; ?>
</div>