<?php

// * validate value has a format matching a regular expression
// Be sure to use anchor expressions to match start and end of string.
// (Use \A and \Z, not ^ and $ which allow line returns.)
//
// Example:
// has_format_matching('1234', '/\d{4}/') is true
// has_format_matching('12345', '/\d{4}/') is also true
// has_format_matching('12345', '/\A\d{4}\Z/') is false
function has_format_matching($value, $regex='//') {
    return preg_match($regex, $value);
}

// is_blank('abcd')
// * validate data presence
// * uses trim() so empty spaces don't count
// * uses === to avoid false positives
// * better than empty() which considers "0" to be empty
function is_blank($value) {
    return !isset($value) || trim($value) === '';
}

// has_presence('abcd')
// * validate data presence
// * reverse of is_blank()
// * I prefer validation names with "has_"
function has_presence($value) {
    return !is_blank($value);
}

// * validate value is a number
// submitted values are strings, so use is_numeric instead of is_int
// options: max, min
// has_number($items_to_order, ['min' => 1, 'max' => 5])
function has_number($value, $options=[])
{
    if (!is_numeric($value)) {
      return false;
    }
    if (isset($options['max']) && ($value > (int)$options['max'])) {
        return false;
    }
    if (isset($options['min']) && ($value < (int)$options['min'])) {
        return false;
    }
    return true;
}

// has_length_greater_than('abcd', 3)
// * validate string length
// * spaces count towards length
// * use trim() if spaces should not count
function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
}

// has_length_less_than('abcd', 5)
// * validate string length
// * spaces count towards length
// * use trim() if spaces should not count
function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
}

// has_length_exactly('abcd', 4)
// * validate string length
// * spaces count towards length
// * use trim() if spaces should not count
function has_length_exactly($value, $exact) {
    $length = strlen($value);
    return $length == $exact;
}

// has_length('abcd', ['min' => 3, 'max' => 5])
// * validate string length
// * combines functions_greater_than, _less_than, _exactly
// * spaces count towards length
// * use trim() if spaces should not count
function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'])) {
        return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'])) {
        return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
        return false;
    } else {
        return true;
    }
}

// has_inclusion_of( 5, [1,3,5,7,9] )
// * validate inclusion in a set
function has_inclusion_of($value, $set) {
    return in_array($value, $set);
}

// has_exclusion_of( 5, [1,3,5,7,9] )
// * validate exclusion from a set
function has_exclusion_of($value, $set) {
    return !in_array($value, $set);
}

// has_string('nobody@nowhere.com', '.com')
// * validate inclusion of character(s)
// * strpos returns string start position or false
// * uses !== to prevent position 0 from being considered false
// * strpos is faster than preg_match()
function has_string($value, $required_string) {
    return strpos($value, $required_string) !== false;
}

function has_valid_salary_format($value)
{
    $salary_regex = '/^[^.]*$/';
    return preg_match($salary_regex, $value) === 1;
}


// has_valid_email_format('nobody@nowhere.com')
// * validate correct format for email addresses
// * format: [chars]@[chars].[2+ letters]
// * preg_match is helpful, uses a regular expression
//    returns 1 for a match, 0 for no match
//    http://php.net/manual/en/function.preg-match.php
function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
}

function has_valid_lat_coords($value) {
    $lat_regex = '/^-?[0-9]{1,3}(?:\.[0-9]{1,18})?$/';
    return preg_match($lat_regex, $value) === 1;
}

function has_valid_lng_coords($value) {
    $lng_regex = '/^-?[0-9]{1,3}(?:\.[0-9]{1,18})?$/';
    return preg_match($lng_regex, $value) === 1;
}

function has_valid_date($value)
{
    $date_ending_regex = '/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/';
    return preg_match($date_ending_regex, $value) === 1;
}

// has_unique_job_type_name('History')
// * Validates uniqueness of jobtypes.job_type
// * For new records, provide only the job_type.
// * For existing records, provide current ID as second arugment
//   has_unique_jobtype_name('History', 4)
function has_unique_jobtype_name($jobtype, $current_id="0") {

    global $db;

    $sql = "SELECT * FROM jobtypes ";
    $sql .= "WHERE jobtype_name='" . db_escape($db, $jobtype) . "' ";
    $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

    $jobtype_set = mysqli_query($db, $sql);
    $jobtype_count = mysqli_num_rows($jobtype_set);
    mysqli_free_result($jobtype_set);

    return $jobtype_count === 0;
}

function has_unique_jobrate_name($jobrate, $current_id = "0")
{

    global $db;

    $sql = "SELECT * FROM jobrates ";
    $sql .= "WHERE jobrate_name='" . db_escape($db, $jobrate) . "' ";
    $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

    $jobrate_set = mysqli_query($db, $sql);
    $jobrate_count = mysqli_num_rows($jobrate_set);
    mysqli_free_result($jobrate_set);

    return $jobrate_count === 0;
}

function has_unique_admin_email($admin_email, $current_id="0") {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE email='" . db_escape($db, $admin_email) . "' ";
    $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

    $result = mysqli_query($db, $sql);
    $admin_count = mysqli_num_rows($result);
    mysqli_free_result($result);

    return $admin_count === 0;
}

function has_unique_user_email($email, $current_id="0") {

    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
    $sql .= "AND id !='" . db_escape($db, $current_id) . "'";

    $result = mysqli_query($db, $sql);
    $user_count = mysqli_num_rows($result);
    mysqli_free_result($result);

    return $user_count === 0;
}

function has_unique_recruiter_email($recruiter_email, $current_id="0") {

    global $db;

    $sql = "SELECT * FROM recruiters ";
    $sql .= "WHERE email='" . db_escape($db, $recruiter_email) . "' ";
    $sql .= "AND id !='" . db_escape($db, $current_id) . "'";

    $result = mysqli_query($db, $sql);
    $user_count = mysqli_num_rows($result);
    mysqli_free_result($result);

    return $user_count === 0;
}

function has_unique_jobsector_name($jobsector_name, $current_id="0") {

    global $db;

    $sql = "SELECT * FROM jobsectors ";
    $sql .= "WHERE jobsector_name='" . db_escape($db, $jobsector_name) . "' ";
    $sql .= "AND id !='" . db_escape($db, $current_id) . "'";

    $result = mysqli_query($db, $sql);
    $jobsector_count = mysqli_num_rows($result);
    mysqli_free_result($result);

    return $jobsector_count === 0;
}

?>
