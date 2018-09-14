<?php
  require_once('humantime.php');

// Start the login session
session_start([ 'gc_max_lifetime' => 86000 + 3600 ]);

// Connect to database
//                        Host        User       PW          DB
$link = mysqli_connect('localhost', 'twitter', 'twitter', 'twitter');

if(mysqli_connect_errno()) {
  print_r(mysqli_connect_error());
  exit();
}

// Display the tweets, just all public tweets for now.
function displayTweets($type) {
  global $link;

  $whereClause = '';

  // if ($type === 'public') {
  //   $whereClause = '';
  // }

  $query = 'SELECT * FROM `tweets` ' . $whereClause . ' ORDER BY `created_at` DESC LIMIT 10';
  $result = mysqli_query($link, $query);

  if (mysqli_num_rows($result) === 0) {
    echo 'There are no tweets to display';
  }
  else {
    while ($row = mysqli_fetch_object($result)) {
      $query = 'SELECT * FROM `users` WHERE `id`=' . $row->user_id;
      $user_result = mysqli_query($link, $query);
      $user = mysqli_fetch_object($user_result);
?>
      <div class="tweet">
        <div class="tweet__content"><?php echo $row->tweet; ?></div>
        <span class="tweet__email"><?php echo $user->email; ?></span>
        <span class="tweet__time"><?php echo human_time(strtotime($row->created_at)) ?></span>
      </div>
<?php
    }
  }
}

// Display a search form
function displaySearch() {
?>
  <div class="form-row align-items-center mb-5">
    <div class="col-sm-9">
      <input type="text" class="form-control" id="search" placeholder="Search">
    </div>
    <div class="col-sm-3">
      <button class="btn btn-primary">Search</button>
    </div>
  </div>
<?php
}

// Display a new tweet box
function displayTweetBox() {
  if ($_SESSION['id']): ?>
    <form>
      <div class="form-group">
        <label for="new-tweet-text">Say something profound</label>
        <textarea class="form-control" id="new-tweet-text" rows="3"></textarea>
      </div>
      <button type="button" class="btn btn-primary">Twinge</button>
    </form>
<?php
  endif;
}

// Load the sent data that was POSTed as JSON.
function getPOSTData() {
  return json_decode(file_get_contents('php://input'));
}
