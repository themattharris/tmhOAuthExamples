<div id="search_tweets">
  <h2>Search Tweets</h2>
<?php

if (!empty($_GET['q'])) {

  $code = $tmhOAuth->apponly_request(array(
    'url' => $tmhOAuth->url('1.1/search/tweets'),
    'params' => array(
      'q' => $_GET['q']
    )
  ));

  if ($code == 200) :
  $data = json_decode($tmhOAuth->response['response'], true);
?>
  <p>Oh, results .. cool.</p>
<?php else : ?>
  <h3>Something went wrong</h3>
  <p><?php echo $tmhOAuth->response['error'] ?></p>
<?php endif; ?>
</div>
<?php } else { ?>
  <form action="" method="GET">
    <div>
      <label for="q">Search Term</label>
      <input type="text" name="q"></input>
      <input type="hidden" name="e" value="search_tweets"></input>

      <br />
      <input type="submit" value="Submit" />
    </div>
  </form>
<?php } ?>