<?php
// Performs all actions necessary to log in a user
function log_in_user($user) {
    // Regenerating the ID protects the user from session fixation.
    session_regenerate_id(); //makes sure the user gets a new session id anytime they log in.
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_last_login'] = time();
    $_SESSION['first_name'] = $user['first_name']; //take value for user firstname and store in the session
    $_SESSION['last_name'] = $user['last_name']; //take value for user lastname and store in the session
    $_SESSION['user_email'] = $user['email']; //take value for user email and store in the session
    return true;
}

// Performs all actions necessary to log out a user
function log_out_user() {
  // unset($_SESSION['user_id']);
  // unset($_SESSION['last_login']);
  // unset($_SESSION['first_name']);
  // unset($_SESSION['last_name']);
  // unset($_SESSION['job_id']);
  // unset($_SESSION['job_title']);
  // unset($_SESSION['user_email']);
  // unset($_SESSION['rec_email']);
  // unset($_SESSION['company_name']);
  session_destroy(); // optional: destroys the whole session
  return true;
}


// is_user_logged_in() contains all the logic for determining if a
// request should be considered a "logged in" request or not.
// It is the core of require_user_login() but it can also be called
// on its own in other contexts (e.g. display one link if a user
// is logged in and display another link if they are not)
function is_user_logged_in() {
  // Having a user_id in the session serves a dual-purpose:
  // - Its presence indicates the user is logged in.
  // - Its value tells which user for looking up their record.
  return isset($_SESSION['user_id']);
}

// Call require_user_login() at the top of any page which needs to
// require a valid login before granting acccess to the page.
function require_user_login() {
  if(!is_user_logged_in()) {
    redirect_to(url_for('/login.php'));
  } else {
    // Do nothing, let the rest of the page proceed
  }
}
?>