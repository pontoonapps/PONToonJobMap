<?php

ob_start(); // output buffering is turned on

session_start(); // turn on sessions

// Assign file paths to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the parent directory
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/');
define("SHARED_PATH", PRIVATE_PATH . '/shared');

// Assign the root URL to a PHP constant
// * Do not need to include the domain
// * Use same document root as webserver
// * Can set a hardcoded value:
// define("WWW_ROOT", '/localhost/job_seekers/public');
// define("WWW_ROOT", '');
// * Can dynamically find everything in URL up to "/public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/');
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);


require_once(PRIVATE_PATH . "/database.php");
require_once(PRIVATE_PATH . "/functions/general_functions.php");
require_once(PRIVATE_PATH . "/functions/blacklist_functions.php");
require_once(PRIVATE_PATH . "/functions/query_functions.php");
require_once(PRIVATE_PATH . "/functions/csrf_token_functions.php");
require_once(PRIVATE_PATH . "/functions/request_forgery_functions.php");
require_once(PRIVATE_PATH . "/functions/confirm_account_token_functions.php");
require_once(PRIVATE_PATH . "/functions/reset_token_functions.php");
require_once(PRIVATE_PATH . "/functions/sqli_escape_functions.php");
require_once(PRIVATE_PATH . "/functions/throttle_functions.php");
require_once(PRIVATE_PATH . "/functions/validation_functions.php");
require_once(PRIVATE_PATH . "/functions/auth_functions.php");
require_once(PRIVATE_PATH . "/functions/recruiter_auth_functions.php");
require_once(PRIVATE_PATH . "/functions/user_auth_functions.php");

$db = db_connect();
//block_blacklisted_ips();

$errors = [];

?>