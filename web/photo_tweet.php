<div id="photo_tweet">
  <h2>Photo Tweet</h2>
<?php

if (!empty($_FILES)) {
  // we set the type and filename are set here as well
  $params = array(
    'media[]' => "@{$_FILES['image']['tmp_name']};type={$_FILES['image']['type']};filename={$_FILES['image']['name']}",
    'status'  => $_POST['status']
  );

  $code = $tmhOAuth->user_request(array(
    'method' => 'POST',
    'url' => $tmhOAuth->url("1.1/statuses/update_with_media"),
    'params' => $params,
    'multipart' => true
  ));

  if ($code == 200) :
  $data = json_decode($tmhOAuth->response['response'], true);
?>
  <p>Hello, @<?php echo htmlspecialchars($data['user']['screen_name']) ?>.</p>
  You just <a href="https://twitter.com/<?php echo htmlspecialchars($data['user']['screen_name']) ?>/statuses/<?php echo htmlspecialchars($data['id_str']) ?>">tweeted</a>
<?php else : ?>
  <h3>Something went wrong</h3>
  <p><?php echo $tmhOAuth->response['error'] ?></p>
<?php endif; ?>
</div>
<?php } else { ?>
  <form action="" method="POST" enctype="multipart/form-data">
    <div>
      <label for="status">Tweet Text</label>
      <textarea type="text" name="status" rows="5" cols="60"></textarea>
      <br />

      <label for="image">Photo</label>
      <input type="file" name="image" />
      <br />
      <input type="submit" value="Submit" />
    </div>
  </form>
<?php } ?>