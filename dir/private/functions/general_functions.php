<?php

function url_for($script_path)
{
    // add the leading '/' if not present (Absolute Path)
    if ($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

// XSS Sanitize functions
// Sanitize for use in a URL
function u($string="")
{
    return urlencode($string);
    //E.g. echo u("?title=Working? Or not?");
}
// Sanitize for use in a URL
function raw_u($string="")
{
    return rawurlencode($string);
}
// Sanitize for HTML output
function h($string="")
{
    return htmlspecialchars($string);
    //Escapes any special characters (Prevents XSS Cross Site Scripting)
    //E.g. echo h("<h1>Test string</h1><br/>");
}
// Sanitize for JavaScript output
function j($string="")
{
    return json_encode($string);
    //Escapes any special characters (Prevents XSS Cross Site Scripting)
    //E.g. j("'};alert('Gotcha!'); //");
}
// XSS Usage examples, leave commented out
// echo h("<h1>Test string</h1><br />");
// echo j("'}; alert('Gotcha!'); //");
// echo u("?title=Working? Or not?");


function error_404()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
}

function error_500()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

//CSRF REQUEST TYPE Functions POST & GET
// GET requests should not make changes
// Only POST requests should make changes
// Usage:
// if(is_post_request()) {
//   ... process form, update database, etc.
// } else {
//   ... do something safe, redirect, error page, etc.
// }

function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function display_errors($errors=array())
{
    $output = '';
    if (!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "<h5>Please fix the following errors:</h5>";
        $output .= "<ul class='list-group'>";
        foreach ($errors as $error) {
            $output .= "<li class='list-group-item list-group-item-danger'>" . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "<br />";
    }
    return $output;
}

function display_email_error($errors=array())
{
    $output = '';
    if (!empty($errors)) {
        $output .= "<div>";
        foreach ($errors as $error) {
            $output .= "<p id='emailError' class='alert-danger small mb-0'>" . h($error) . "</p>";
        }
        $output .= "</div>";
    }
        return $output;
}

function get_and_clear_session_message()
{
    if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
        $msg = $_SESSION['message'];
        unset($_SESSION['message']);
        return $msg;
    }
}

function display_session_message()
{
    $msg = get_and_clear_session_message();
    if (!is_blank($msg)) {
        return '<div class="alert alert-success alert-dismissible fade show" role="alert"><b>' . h($msg) . '</b><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    }
}

function get_and_clear_session_attempt_message()
{
    if (isset($_SESSION['attempt_message']) && $_SESSION['attempt_message'] != '') {
        $attempt_msg = $_SESSION['attempt_message'];
        unset($_SESSION['attempt_message']);
        return $attempt_msg;
    }
}

function display_session_attempt_message()
{
    $attempt_msg = get_and_clear_session_attempt_message();
    if (!is_blank($attempt_msg)) {
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>' . h($attempt_msg) . '</b><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    }
}

function get_and_clear_session_primary_message()
{
    if (isset($_SESSION['primary_message']) && $_SESSION['primary_message'] != '') {
        $primary_msg = $_SESSION['primary_message'];
        unset($_SESSION['primary_message']);
        return $primary_msg;
    }
}

function display_session_primary_message()
{
    $primary_msg = get_and_clear_session_primary_message();
    if (!is_blank($primary_msg)) {
        return '<div class="alert alert-primary alert-dismissible fade show" role="alert"><b>' . h($primary_msg) . '</b><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
    }
}

?>