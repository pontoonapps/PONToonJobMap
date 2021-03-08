<?php

  // Performs all actions necessary to log in a recruiter
function log_in_recruiter($recruiter) {
  // Regenerating the ID protects the recruiter from session fixation.
    session_regenerate_id(); //makes sure the recruiter gets a new session id anytime they log in.
    $_SESSION['recruiter_id'] = $recruiter['id'];
    $_SESSION['recruiter_last_login'] = time();
    $_SESSION['recruiter_first_name'] = $recruiter['first_name']; //take value for recruiter first name and store in the session
    $_SESSION['recruiter_last_name'] = $recruiter['last_name']; //take value for recruiter last name and store in the session
    $_SESSION['recruiter_email'] = $recruiter['email']; //take value for recruiter email and store in the session
    return true;
  }

  // Performs all actions necessary to log out a recruiter
function log_out_recruiter() {
  // unset($_SESSION['recruiter_id']);
  // unset($_SESSION['last_login']);
  // unset($_SESSION['company_name']);
  session_destroy(); // optional: destroys the whole session
  return true;
}


  // is_recruiter_logged_in() contains all the logic for determining if a
  // request should be considered a "logged in" request or not.
  // It is the core of require_recruiter_login() but it can also be called
  // on its own in other contexts (e.g. display one link if a recruiter
  // is logged in and display another link if they are not)
  function is_recruiter_logged_in() {
    // Having a recruiter_id in the session serves a dual-purpose:
    // - Its presence indicates the recruiter is logged in.
    // - Its value tells which recruiter for looking up their record.
    return isset($_SESSION['recruiter_id']);
  }

  // Call require_recruiter_login() at the top of any page which needs to
  // require a valid login before granting acccess to the page.
  function require_recruiter_login() {
    if(!is_recruiter_logged_in()) {
      redirect_to(url_for('/login.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
  }

?>
