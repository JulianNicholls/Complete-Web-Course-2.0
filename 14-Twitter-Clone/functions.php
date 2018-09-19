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

  $whereClause = prepareWhereClause($type);

  $query = "SELECT * FROM `tweets` $whereClause ORDER BY `created_at` DESC LIMIT 10";
  $result = mysqli_query($link, $query);

  if (mysqli_num_rows($result) === 0) {
    echo '<p class="lead text-center">There are no tweets to display';
  }
  else {
    while ($row = mysqli_fetch_object($result)) {
      $query = "SELECT `id`, `email` FROM `users` WHERE `id`=$row->user_id";
      $userResult = mysqli_query($link, $query);
      $user = mysqli_fetch_object($userResult);
      
      $query = "SELECT * FROM `following` WHERE `follower`={$_SESSION['id']} AND `following`={$row->user_id}";
      $followResult = mysqli_query($link, $query);
      $following = mysqli_num_rows($followResult) !== 0;
?>
      <div class="tweet">
        <div class="tweet__content"><?php echo $row->tweet; ?></div>
        <div class="my-2 d-flex justify-content-between align-items-center">
          <span class="tweet__time flex-grow-1"><?php echo human_time(strtotime($row->created_at)) ?></span>
          <span class="tweet__email pr-3">
            <a href="<?php echo "?page=profiles&userid={$user->id}"; ?>">
              <?php echo $user->email; ?>
            </a>
          </span>
          <button class="toggle-follow btn btn-success btn-sm" data-user-id="<?php echo $row->user_id ?>">
            <?php echo $following ? 'Unfollow' : 'Follow'; ?>
          </button>
        </div>
      </div>
<?php
    }
  }
}

// Display a search form
function displaySearch() {
?>
  <form class="form-row align-items-center mb-5">
    <div class="col-sm-9">
      <input type="hidden" name="page" value="search">
      <input type="text" class="form-control" id="search" name="q" placeholder="Search">
    </div>
    <div class="col-sm-3">
      <button class="btn btn-primary">Search</button>
    </div>
  </form>
<?php
}

// Display a new twinge box
function displayTwingeBox() {
  if ($_SESSION['id']): ?>
    <form>
      <div class="form-group">
        <label for="new-tweet-text">Say something profound</label>
        <textarea class="form-control" id="new-twinge-text" rows="3"></textarea>
      </div>
      <button id="new-twinge" type="button" class="btn btn-primary" disabled>Twinge</button>
    </form>
<?php
  endif;
}

// Display all the users
function displayUsers() {
  global $link;

  $query = "SELECT u.id, u.email, COUNT(t.user_id) AS twinge_count FROM users u LEFT JOIN tweets t ON u.id = t.user_id GROUP BY u.id";
  $result = mysqli_query($link, $query);

  echo '<ul class="list-group">';

  while($user = mysqli_fetch_object($result)) {
    echo '<li class="list-group-item d-flex justify-content-between">';
    echo   "<a href=\"?page=profiles&userid=$user->id\">";
    echo     $user->email . '</a>';
    echo   "<a href=\"?page=profiles&userid=$user->id\">";
    echo     $user->twinge_count . ' twinges</a>';
    echo '</li>';
  }

  echo '</ul>';
}

// Sign up
function signup($loginData) {
  global $link;

  $response = [ 'errors' => [] ];

  $query = "SELECT `email` FROM `users` WHERE `email`='" . mysqli_real_escape_string($link, $loginData->email) . "' LIMIT 1";
  $result = mysqli_query($link, $query);
  
  if (mysqli_num_rows($result) > 0) {
    $response['errors'][] = 'That email address has already been signed up.';
    return $response;
  }
  else {
    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('" . 
      mysqli_real_escape_string($link, $loginData->email) . 
      "', '" . 
      password_hash($loginData->password, PASSWORD_DEFAULT) . 
      "')";

    if (mysqli_query($link, $query)) {
      $_SESSION['id'] = mysqli_insert_id($link);
    }
    else {
      $response['errors'][] = mysqli_error($link);
    }
  }

  return $response;
}

// Log in
function login($loginData) {
  global $link;

  $response = [ 'errors' => [] ];

  $loginError = 'The email or password was not recognised.';
  $query = "SELECT * FROM `users` WHERE `email`='" . mysqli_real_escape_string($link, $loginData->email) . "' LIMIT 1";
  $result = mysqli_query($link, $query);
  
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_object($result);
    
    if (password_verify($loginData->password, $row->password)) {
      $_SESSION['id'] = $row->id;
    }
    else {
      $response['errors'][] = $loginError;
    }
  }
  else {
    $response['errors'][] = $loginError;
  }

  return $response;
}

// Load the sent data that was POSTed as JSON.
function getPOSTData() {
  return json_decode(file_get_contents('php://input'));
}

// Prepare the WHERE clause based on the display type
function prepareWhereClause($type) {
  global $link;

  $whereClause = '';

  switch ($type) {
    case 'following':
      $query = "SELECT `following` FROM `following` WHERE `follower`={$_SESSION['id']}";
      $result = mysqli_query($link, $query);
    
      if (mysqli_num_rows($result) > 0) {    
        while($row = mysqli_fetch_object($result)) {
          if ($whereClause === '') {
            $whereClause = "WHERE `user_id` IN ({$row->following}";
          } 
          else {
            $whereClause .= ", {$row->following}";
          }
        }
    
        $whereClause .= ')';
      }
      else {
        $whereClause = 'WHERE 1=0';  // Always false, no follows
      }
      break;

    case 'personal':
      $whereClause = "WHERE `user_id`={$_SESSION['id']}";
      break;
      
    case 'search':
      $searchTerm = mysqli_real_escape_string($link, $_GET['q']);
      echo "<h3 class=\"text-center\">Showing results for $searchTerm</h3>";
      $whereClause = "WHERE `tweet` LIKE '%$searchTerm%'";
      break;
      
    default:
      if (is_numeric($type)) {
        $query = "SELECT `email` FROM `users` WHERE `id`=$type";
        $result = mysqli_query($link, $query);
        $user = mysqli_fetch_object($result);

        echo "<h3 class=\"text-center\">$user->email twinges</h3>";
        $whereClause = "WHERE `user_id`=$type";
      }
      break;
  }

  return $whereClause;
}
