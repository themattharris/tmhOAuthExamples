<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

$image = __DIR__ . DIRECTORY_SEPARATOR . 'photo.jpg';
$name  = basename($image);
$status = "Picture time";

if (class_exists('CurlFile', false)) {
  $media = new CurlFile($image);
} else {
  $media = "@{$image};type=image/jpeg;filename={$name}";
}

// ref: https://dev.twitter.com/rest/public/uploading-media
// first we post to the media upload endpoint
// then we use the returned information to post to the tweet endpoint

$code = $tmhOAuth->user_request(array(
  'method' => 'POST',
  'url'    => 'https://upload.twitter.com/1.1/media/upload.json',
  'params' => array(
    'media' => $media,
  ),
  'multipart' => true,
));

$tmhOAuth->render_response();

// response looks like this:
/*
{
  "media_id": 553656900508606464,
  "media_id_string": "553656900508606464",
  "size": 998865,
  "image": {
    "w": 2234,
    "h": 1873,
    "image_type": "image/jpeg"
  }
}
*/

if ($code == 200) {
  $data = json_decode($tmhOAuth->response['response']);
  $media_id = $data->media_id_string;

  $code = $tmhOAuth->user_request(array(
    'method' => 'POST',
    'url'    => $tmhOAuth->url('1.1/statuses/update'),
    'params' => array(
      'media_ids' => $media_id,
      'status'    => $status,
    )
  ));
}

$tmhOAuth->render_response();
