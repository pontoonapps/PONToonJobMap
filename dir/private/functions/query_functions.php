<?php

function find_all_users_in_failed_logins()
{
    global $db;
    $sql = "SELECT * FROM failed_logins";
    // $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function admin_find_user_email($user_id)
{
    global $db;

    $sql = "SELECT id, email FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    //  confirm_result_set($result);
    //  return $result;
}

function find_user_email_in_failed_logins($email)
{
    global $db;

    $sql = "SELECT email, attempt, last_time FROM failed_logins ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $email = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $email; // returns an assoc. array
    // $results = find_all_users_in_failed_logins($email);
    // $result = count($results) > 0 ? $results[0] : null;
    // return $results;
}

function add_record_to_failed_logins($failed_login) {

    global $db;

    $sql = "INSERT INTO failed_logins ";
    $sql .= "(email, attempt, last_time) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $failed_login['email']) . "',";
    $sql .= "'" . db_escape($db, $failed_login['attempt']) . "',";
    $sql .= "'" . db_escape($db, $failed_login['last_time']) . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_record_in_failed_logins($failed_login)
{
    global $db;

    $sql = "UPDATE failed_logins SET ";
    $sql .= "attempt='" . db_escape($db, $failed_login['attempt']) . "', ";
    $sql .= "last_time='" . db_escape($db, $failed_login['last_time']) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $failed_login['email']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_admins_token($admin)
{
    global $db;

    $sql = "UPDATE admins SET ";
    $sql .= "reset_token='" . db_escape($db, $admin['reset_token']) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $admin['email']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_recruiters_token($recruiter)
{
    global $db;

    $sql = "UPDATE recruiters SET ";
    $sql .= "reset_token='" . db_escape($db, $recruiter['reset_token']) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $recruiter['email']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_users_token($user)
{
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "reset_token='" . db_escape($db, $user['reset_token']) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $user['email']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_admin_email_token($admin)
{
    global $db;

    $sql = "UPDATE admins SET ";
    $sql .= "email_token='" . db_escape($db, $admin['email_token']) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $admin['email']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_recruiter_email_token($recruiter)
{
    global $db;

    $sql = "UPDATE recruiters SET ";
    $sql .= "email_token='" . db_escape($db, $recruiter['email_token']) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $recruiter['email']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_user_email_token($user)
{
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "email_token='" . db_escape($db, $user['email_token']) . "' ";
    $sql .= "WHERE email='" . db_escape($db, $user['email']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_admin_token($token)
{
    global $db;

    $sql = "SELECT reset_token, email FROM admins ";
    $sql .= "WHERE reset_token='" . db_escape($db, $token) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
    // $results = find_all_users_in_failed_logins($email);
    // $result = count($results) > 0 ? $results[0] : null;
    // return $results;
}

function find_recruiter_token($token)
{
    global $db;

    $sql = "SELECT reset_token, email FROM recruiters ";
    $sql .= "WHERE reset_token='" . db_escape($db, $token) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recruiter = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $recruiter; // returns an assoc. array
    // $results = find_all_users_in_failed_logins($email);
    // $result = count($results) > 0 ? $results[0] : null;
    // return $results;
}

function find_user_token($token)
{
    global $db;

    $sql = "SELECT reset_token, email FROM users ";
    $sql .= "WHERE reset_token='" . db_escape($db, $token) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $user; // returns an assoc. array
    // $results = find_all_users_in_failed_logins($email);
    // $result = count($results) > 0 ? $results[0] : null;
    // return $results;
}

function find_admin_email_token($token)
{
    global $db;

    $sql = "SELECT email_token, email FROM admins ";
    $sql .= "WHERE email_token='" . db_escape($db, $token) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
    // $results = find_all_users_in_failed_logins($email);
    // $result = count($results) > 0 ? $results[0] : null;
    // return $results;
}

function find_recruiter_email_token($token)
{
    global $db;

    $sql = "SELECT email_token, email FROM recruiters ";
    $sql .= "WHERE email_token='" . db_escape($db, $token) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recruiter = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $recruiter; // returns an assoc. array
    // $results = find_all_users_in_failed_logins($email);
    // $result = count($results) > 0 ? $results[0] : null;
    // return $results;
}

function find_user_email_token($token)
{
    global $db;

    $sql = "SELECT email_token, email FROM users ";
    $sql .= "WHERE email_token='" . db_escape($db, $token) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $user; // returns an assoc. array
    // $results = find_all_users_in_failed_logins($email);
    // $result = count($results) > 0 ? $results[0] : null;
    // return $results;
}

function update_admin_password($admin)
{
    global $db;

    $sql = "UPDATE admins SET ";
    $sql .= "hashed_password='" . db_escape($db, $admin['hashed_password']) . "' ";
    $sql .= "WHERE reset_token='" . db_escape($db, $admin['reset_token']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_recruiter_password($recruiter)
{
    global $db;

    $sql = "UPDATE recruiters SET ";
    $sql .= "hashed_password='" . db_escape($db, $recruiter['hashed_password']) . "' ";
    $sql .= "WHERE reset_token='" . db_escape($db, $recruiter['reset_token']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_user_password($user)
{
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "hashed_password='" . db_escape($db, $user['hashed_password']) . "' ";
    $sql .= "WHERE reset_token='" . db_escape($db, $user['reset_token']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

/**
 * Get excerpt from string
 *
 * @param String $str String to get an excerpt from
 * @param Integer $startPos Position int string to start excerpt from
 * @param Integer $maxLength Maximum length the excerpt may be
 * @return String excerpt
 */
function getExcerpt($str, $startPos=0, $maxLength=100)
{
    if (strlen($str) > $maxLength) {
        $excerpt   = substr($str, $startPos, $maxLength-3);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt   = substr($excerpt, 0, $lastSpace);
        $excerpt  .= '...';
    } else {
        $excerpt = $str;
    }

    return $excerpt;
}


function get_rads($rad)
{
    global $db;
    // $rad = $_POST['rad_id'];

    $sql = "SELECT radius.id, radius.rad_num FROM radius ";
    $sql .= "WHERE radius.rad_num='" . db_escape($db, $rad) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $radius = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $radius; // returns an assoc. array
}

function get_locations($location)
{
    global $db;
    // $rad = $_POST['rad_id'];

    $sql = "SELECT job_location, lat, lng FROM jobs ";
    $sql .= "WHERE job_location='" . db_escape($db, $location) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function whatIsToday()
{
    global $db;
    echo "Today is " . date('l', mktime());
}

//Relative Date Functions
//Job Created / Application Sent
function relative_date($time)
{
    $today = strtotime(date('l jS F Y'));
    $reldays = ($time - $today) / 86400; //86000 seconds = 24 hours
    $relweeks = ($time - $today)/604800;
    if ($reldays >= 0 && $reldays < 1) {
        return 'Today';
    } else if ($reldays >= 1 && $reldays < 2) {
        return 'Tomorrow';
    } else if ($reldays >= -1 && $reldays < 0) {
        return 'Yesterday';
    }

    if (abs($reldays) < 15) {
        if ($reldays > 0) {
            $reldays = floor($reldays);
            return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');
        } else {
            $reldays = abs(floor($reldays));
            return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';
        }
    }

    if (abs($relweeks) > 2) {
      if ($relweeks > 0) {
      $relweeks = floor($relweeks);
      return 'In ' . $relweeks . ' wk' . ($relweeks != 1 ? 's' : '');
      } else {
      $relweeks = abs(floor($relweeks));
      return $relweeks . ' wk' . ($relweeks != 1 ? 's' : '') . ' ago';
      }
    }

    if (abs($reldays) < 182) {
        return date('D, d M Y', $time ? $time : time());
    } else {
        return date('D, d M Y', $time ? $time : time());
    }
}

//Job Ending
function job_ending_relative_date($time)
{
    $today = strtotime(date('D, d M Y'));
    $reldays = ($time - $today) / 86400; //86400 seconds = 24 hours
    $relweeks = ($time - $today)/604800;
    if ($reldays >= 0 && $reldays <= 1) {
        return 'Ending Today';
    } elseif (abs($reldays) >= 1 && abs($reldays) < 2) {
        return 'Closed Yesterday';
    } elseif (abs($reldays) >= -1 && abs($reldays) < 0) {
        return 'Ending Tomorrow';
    }

    if (abs($reldays) < 15) {
        if ($reldays > 0) {
            $reldays = floor($reldays);
            return 'Ending in ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');
        } else {
            $reldays = abs(floor($reldays));
            return 'Ended ' . $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';
        }
    }

    if (abs($relweeks) > 2) {
      if ($relweeks > 0) {
      $relweeks = floor($relweeks);
      return 'Ending in ' . $relweeks . ' week' . ($relweeks != 1 ? 's' : '');
      } else {
      $relweeks = abs(floor($relweeks));
      return 'Ended ' . $relweeks . ' wk' . ($relweeks != 1 ? 's' : '') . ' ago';
      }
    }

    if (abs($reldays) <= 182) {
        return 'Ends ' . date('D, d M Y', $time ? $time : time());
    } else {
        return 'Closes ' . date('D, d M Y', $time ? $time : time());
    }
}

function time_before($time)
{
    $out	= '';
    $now	= time();
    $diff	= $now - $time;

    if ($diff < 60) {
        return TIMEBEFORE_NOW;
    } elseif ($diff < 3600) {
        return str_replace('{num}', ($out = round($diff / 60)), $out == 1 ? TIMEBEFORE_MINUTE : TIMEBEFORE_MINUTES);
    } elseif ($diff < 3600 * 24) {
        return str_replace('{num}', ($out = round($diff / 3600)), $out == 1 ? TIMEBEFORE_HOUR : TIMEBEFORE_HOURS);
    } elseif ($diff < 3600 * 24 * 2) {
        return TIMEBEFORE_YESTERDAY;
    } else {
        return strftime(date('Y', $time) == date('Y') ? TIMEBEFORE_FORMAT : TIMEBEFORE_FORMAT_YEAR, $time);
    }
}

function getSum($num1, $num2)
{
    $total = $num1 + $num2;
    return $total;
}

function test()
{
    global $db;
    global $greet;
    echo $greet;
}

// Defining recursive function
function printValues($arr)
{
    global $db;
    global $count;
    global $items;

    // Check input is an array
    if (!is_array($arr)) {
        die("ERROR: Input is not an array");
    }

    /*
    Loop through array, if value is itself an array recursively call the function,
    else add the value found to the output items array,
    and increment counter by 1 for each value found
    */
    foreach ($arr as $a) {
        if (is_array($a)) {
            printValues($a);
        } else {
            $items[] = $a;
            $count++;
        }
    }

    // Return total count and values found in array
    return array('total' => $count, 'values' => $items);
}

function do_pagination_search($search, $location, $rad, $lat, $lng, $tbl_name) {

    global $db;

    $sql = "SELECT SUM(1) as num
    FROM
        ( SELECT
            ( 3959
                * acos(cos(radians({$lat}))
                * cos(radians(lat))
                * cos(radians(lng) - radians({$lng}))
                + sin(radians({$lat}))
                * sin(radians(lat))
            )
        ) AS distance
        FROM   $tbl_name ";
            $sql .= "INNER JOIN companies ON companies.id=jobs.company_id ";
            $sql .= "INNER JOIN jobsectors ON jobsectors.id=jobs.jobsector_id ";
            $sql .= "WHERE (jobs.job_location LIKE '%$location%' AND companies.visible <> 'false' AND jobs.visible <> 'false' AND jobs.date_ending > CURDATE()) ";
            $sql .= "OR (jobs.job_title LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false' AND jobs.date_ending > CURDATE()) ";
            $sql .= "OR (jobsectors.jobsector_name LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false' AND jobs.date_ending > CURDATE()) ";
            $sql .= "OR (company_name LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false' AND jobs.date_ending > CURDATE()) ";
            //   $sql .= "AND (jobs.date_ending <= CURDATE()) ";
            $sql .= "HAVING distance <= {$rad}
            ORDER BY distance DESC
        ) t";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function do_sort_search($search, $location, $rad, $lat, $lng, $tbl_name, $start, $limit, $sort) {

    global $db;
    // $sort = $_SESSION['sort'];
    // $_SESSION['sort'] == $sort;

    $sql = "SELECT jobs.id AS job_id, jobs.visible, jobs.job_title, jobs.job_location, jobtypes.jobtype_name, jobrates.jobrate_name, jobs.salary, jobs.job_desc, jobs.date_created, DATEDIFF(CURDATE(), jobs.date_created), jobs.lat, jobs.lng, jobsectors.jobsector_name, companies.id, companies.company_name, companies.logo, companies.visible, ( 3959 * acos( cos( radians( {$lat} ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( {$lng} ) ) + sin( radians( {$lat} ) ) * sin( radians( lat ) ) ) ) AS distance FROM $tbl_name ";

    $sql .= "INNER JOIN companies ON companies.id=jobs.company_id ";
    $sql .= "INNER JOIN jobsectors ON jobsectors.id=jobs.jobsector_id ";
    $sql .= "INNER JOIN jobtypes ON jobtypes.id=jobs.jobtype_id ";
    $sql .= "INNER JOIN jobrates ON jobrates.id=jobs.jobrate_id ";
    $sql .= "WHERE (jobs.job_title LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "AND (jobs.job_location LIKE '%$location%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "OR (jobsectors.jobsector_name LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "AND (jobs.job_location LIKE '%$location%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "OR (company_name LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "AND (jobs.job_location LIKE '%$location%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";

    $sql .= "HAVING distance >= {$rad} ";

    $sql .= "ORDER BY ";
    switch ($sort) {
    case "asc":
            $sql .= "jobs.date_created ASC ";
    break;
    case "desc":
            $sql .= "jobs.date_created DESC ";
    break;
    case "dasc":
            $sql .= "distance ASC ";
    break;
    case "ddesc":
            $sql .= "distance DESC ";
    break;
    case "sasc":
            $sql .= "salary ASC ";
    break;
    case "sdesc":
            $sql .= "salary DESC ";
    break;
}

    $sql .= "LIMIT $start, $limit";

    // $result = mysqli_query($db, $sql);
    // confirm_result_set($result);
    // return $result;

    $sortResult = mysqli_query($db, $sql);
    confirm_result_set($sortResult);
    // $sortResult = mysqli_fetch_assoc($result);
    // mysqli_free_result($result);
    return $sortResult; // returns an assoc. array
}

// ADMIN COMPANY MANAGEMENT
function admin_find_company_by_id($co_id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE id='" . db_escape($db, $co_id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $company = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $company; // returns an assoc. array
}

function admin_find_all_companies($options = []) {
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT companies.id, companies.recruiter_id, companies.visible, companies.company_name, companies.company_desc, companies.location, companies.logo, recruiters.first_name, recruiters.last_name FROM companies ";
    $sql .= "INNER JOIN recruiters ";
    $sql .= "ON recruiters.id = companies.recruiter_id ";
    if ($visible) {
        $sql .= "WHERE visible = true ";
    }
    $sql .= "ORDER BY companies.id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_all_companies($options=[])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT companies.id, companies.recruiter_id, companies.visible, companies.company_name, companies.company_desc, companies.location, companies.logo, recruiters.first_name, recruiters.last_name FROM companies ";
    $sql .= "INNER JOIN recruiters ";
    $sql .= "ON recruiters.id = companies.recruiter_id ";
    if ($visible) {
        $sql .= "WHERE visible = true ";
    }
    $sql .= "ORDER BY companies.id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

//(Cannot Insert Recruiter ID!)
function insert_company($company)
{
    global $db;

    $errors = validate_company($company);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO companies ";
    $sql .= "(recruiter_id, visible, company_name, company_desc, location, logo) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $_SESSION['recruiter_id']) . "',";
    $sql .= "'" . db_escape($db, $company['visible']) . "',";
    $sql .= "'" . db_escape($db, $company['company_name']) . "',";
    $sql .= "'" . db_escape($db, $company['company_desc']) . "',";
    $sql .= "'" . db_escape($db, $company['location']) . "',";
    $sql .= "'" . db_escape($db, 'no_company_logo.png') . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Shared with RECRUITERS
function find_company_by_id($co_id, $options=[])
{
    global $db;

    //$visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE id='" . db_escape($db, $co_id) . "' ";
    $sql .= "AND recruiter_id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    // if ($visible) {
    //     $sql .= "AND visible = true";
    // }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $company = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $company; // returns an assoc. array
}

function find_company_by_recruiter_id($co_id, $options = [])
{
    global $db;

    //$visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    // if ($visible) {
    //     $sql .= "AND visible = true";
    // }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $company = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $company; // returns an assoc. array
}


function validate_company($company)
{
    $errors = [];

    // visible
    // Make sure we are working with a string
    // $visible_str = (string) $company['visible'];
    // if (!has_inclusion_of($visible_str, ["true","false"])) {
    //     $errors[] = "Visible must be true or false.";
    // }

    // company_name
    // if (is_blank($company['company_name'])) {
    //     $errors[] = "Company Name cannot be blank.";
    // } elseif (!has_length($company['company_name'], ['min' => 1, 'max' => 255])) {
    //     $errors[] = "Name must be between 2 and 255 characters.";
    // }

    // company_desc
    // if (is_blank($company['company_desc'])) {
    //     $errors[] = "Company Description cannot be blank.";
    // }

    //location
    // if (is_blank($company['location'])) {
    //     $errors[] = "Location cannot be blank.";
    // } elseif (!has_length($company['location'], ['min' => 1, 'max' => 255])) {
    //     $errors[] = "Location must be between 2 and 255 characters.";
    // }

    // logo
    // if(is_blank($company['logo'])) {
    //   $errors[] = "Logo cannot be blank.";
    // } //elseif(!has_length($company['logo'], ['min' => 2, 'max' => 255])) {
    //$errors[] = "Logo must be between 2 and 255 characters.";
    //}

    return $errors;
}

function update_company($company)
{
    global $db;

    $errors = validate_company($company);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE companies SET ";

    $sql .= "company_name='" . db_escape($db, $company['company_name']) . "', ";
    $sql .= "company_desc='" . db_escape($db, $company['company_desc']) . "', ";
    $sql .= "location='" . db_escape($db, $company['location']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $company['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_company_logo($company)
{
    global $db;

    $sql = "UPDATE companies SET ";
    $sql .= "logo='" . db_escape($db, $company['logo']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $company['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//From delete_recruiter.php
function disable_recruiter_company($rec_id)
{
    global $db;

    $sql = "UPDATE companies SET ";
    $sql .= "visible = '" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//From delete_company.php
function disable_company($rec_id)
{
    global $db;

    $sql = "UPDATE companies SET ";
    $sql .= "visible = '" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function disable_company_jobs($rec_id)
{
    global $db;

    $sql = "UPDATE jobs SET ";
    $sql .= "visible = '" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $rec_id) . "' ";
    // $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//Set aside for actual deletion of company
function XXXdelete_company($co_id) {

    global $db;

    $sql = "DELETE FROM companies ";
    $sql .= "WHERE id='" . db_escape($db, $co_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    //For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        //DELETE failed
        echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
}

//Admin Validate User
function admin_validate_user($user)

{
    $errors = [];

    if (!has_unique_user_email($user['email'], $user['id'] ?? 0)) {
        $errors[] = "Email address is not allowed. Please try another.";
    }

    return $errors;
}

// Admin update user
function admin_update_user($user) {

    global $db;

    $errors = admin_validate_user($user);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $user['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $user['email']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $user['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// jobs
function find_all_jobs()
{
    global $db;

    $sql = "SELECT jobs.id, jobs.company_id, jobs.jobsector_id, jobs.visible, jobs.job_title, jobs.job_desc, jobs.job_location, jobs.lat, jobs.lng, jobs.jobtype_id, jobs.salary, jobs.date_created FROM jobs ";
    $sql .= "ORDER BY company_id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_all_the_jobs($job_id)
{
    global $db;

    $sql = "SELECT jobs.id, jobs.company_id, jobs.jobsector_id, jobs.visible, jobs.job_title, jobs.job_desc, jobs.job_location, jobs.lat, jobs.lng, jobs.jobtype_id, jobs.salary, jobs.date_created FROM jobs ";
    $sql .= "WHERE jobs.id='" . db_escape($db, $job_id) . "' ";
    $sql .= "ORDER BY company_id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_all_jobsectors()
{
    global $db;

    $sql = "SELECT id, jobsector_name FROM jobsectors ";
    $sql .= "ORDER BY jobsector_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_all_jobrates()
{
 global $db;

 $sql = "SELECT id, jobrate_name FROM jobrates ";
 $sql .= "ORDER BY id ASC";
 $result = mysqli_query($db, $sql);
 confirm_result_set($result);
 return $result;
}


function find_all_jobtypes()
{
 global $db;

 $sql = "SELECT id, jobtype_name FROM jobtypes ";
 $sql .= "ORDER BY jobtype_name ASC";
 $result = mysqli_query($db, $sql);
 confirm_result_set($result);
 return $result;
}

function find_jobtype_by_id($jobtype_id)
{
    global $db;

    $sql = "SELECT id, jobtype_name FROM jobtypes ";
    $sql .= "WHERE jobtypes.id='" . db_escape($db, $jobtype_id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $jobtype = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $jobtype; // returns an assoc. array
}

function validate_jobtype($jobtype)
{
 $errors = [];

 // jobsector_name
 if (is_blank($jobtype['jobtype_name'])) {
  $errors[] = "Job Type Name cannot be blank.";
 }
 // elseif(!has_length($jobsector['jobsector_name'], ['min' => 2, 'max' => 255])) {
 //   $errors[] = "Menu Name must be between 2 and 255 characters.";
 // }
 $current_id = $jobtype['id'] ?? '0';
 if (!has_unique_jobtype_name($jobtype['jobtype_name'], $current_id)) {
  $errors[] = "Job Type Name must be unique!";
 }

 return $errors;
}

function insert_jobtype($jobtype)
{
 global $db;

 $errors = validate_jobtype($jobtype);
 if (!empty($errors)) {
  return $errors;
 }

 $sql = "INSERT INTO jobtypes ";
 $sql .= "(jobtype_name) ";
 $sql .= "VALUES (";
 $sql .= "'" . db_escape($db, $jobtype['jobtype_name']) . "'";
 $sql .= ")";
 $result = mysqli_query($db, $sql);
 // For INSERT statements, $result is true/false
 if ($result) {
  return true;
 } else {
  // INSERT failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }
}

function update_jobtype($jobtype)
{
 global $db;

 $errors = validate_jobtype($jobtype);
 if (!empty($errors)) {
  return $errors;
 }

 $sql = "UPDATE jobtypes SET ";
 $sql .= "jobtype_name='" . db_escape($db, $jobtype['jobtype_name']) . "' ";
 $sql .= "WHERE id='" . db_escape($db, $jobtype['id']) . "' ";
 $sql .= "LIMIT 1";

 $result = mysqli_query($db, $sql);
 // For UPDATE statements, $result is true/false
 if ($result) {
  return true;
 } else {
  // UPDATE failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }
}

function delete_jobtype($jobtype_id)
{
 global $db;

 $sql = "DELETE FROM jobtypes ";
 $sql .= "WHERE id='" . db_escape($db, $jobtype_id) . "' ";
 $sql .= "LIMIT 1";
 $result = mysqli_query($db, $sql);

 // For DELETE statements, $result is true/false
 if ($result) {
  return true;
 } else {
  // DELETE failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }
}

function update_jobrate($jobrate)
{
 global $db;

 $errors = validate_jobrate($jobrate);
 if (!empty($errors)) {
  return $errors;
 }

 $sql = "UPDATE jobrates SET ";
 $sql .= "jobrate_name='" . db_escape($db, $jobrate['jobrate_name']) . "' ";
 $sql .= "WHERE id='" . db_escape($db, $jobrate['id']) . "' ";
 $sql .= "LIMIT 1";

 $result = mysqli_query($db, $sql);
 // For UPDATE statements, $result is true/false
 if ($result) {
  return true;
 } else {
  // UPDATE failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }
}

function delete_jobrate($jobrate_id)
{
 global $db;

 $sql = "DELETE FROM jobrates ";
 $sql .= "WHERE id='" . db_escape($db, $jobrate_id) . "' ";
 $sql .= "LIMIT 1";
 $result = mysqli_query($db, $sql);

 // For DELETE statements, $result is true/false
 if ($result) {
  return true;
 } else {
  // DELETE failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }
}


function find_jobrate_by_id($jobrate_id)
{
 global $db;

 $sql = "SELECT id, jobrate_name FROM jobrates ";
 $sql .= "WHERE jobrates.id='" . db_escape($db, $jobrate_id) . "' ";
 $result = mysqli_query($db, $sql);
 confirm_result_set($result);
 $jobrate = mysqli_fetch_assoc($result);
 mysqli_free_result($result);
 return $jobrate; // returns an assoc. array
}

function validate_jobrate($jobrate)
{
 $errors = [];

 // jobsector_name
 if (is_blank($jobrate['jobrate_name'])) {
  $errors[] = "Job Rate Name cannot be blank.";
 }
 // elseif(!has_length($jobsector['jobsector_name'], ['min' => 2, 'max' => 255])) {
 //   $errors[] = "Menu Name must be between 2 and 255 characters.";
 // }
 $current_id = $jobrate['id'] ?? '0';
 if (!has_unique_jobrate_name($jobrate['jobrate_name'], $current_id)) {
  $errors[] = "Job Rate Name must be unique!";
 }

 return $errors;
}


function insert_jobrate($jobrate)
{
 global $db;

 $errors = validate_jobrate($jobrate);
 if (!empty($errors)) {
  return $errors;
 }

 $sql = "INSERT INTO jobrates ";
 $sql .= "(jobrate_name) ";
 $sql .= "VALUES (";
 $sql .= "'" . db_escape($db, $jobrate['jobrate_name']) . "'";
 $sql .= ")";
 $result = mysqli_query($db, $sql);
 // For INSERT statements, $result is true/false
 if ($result) {
  return true;
 } else {
  // INSERT failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
 }
}


function find_job_by_id($job_id, $options=[])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT jobs.id, jobs.company_id, jobs.recruiter_id, jobs.jobsector_id, jobs.visible, jobs.job_title, jobs.job_desc, jobs.job_location, jobs.lat, jobs.lng, jobs.city, jobs.jobtype_id, jobtypes.jobtype_name, jobs.salary, jobs.currency_id, currency.alphacode, jobs.jobrate_id, jobrates.jobrate_name, jobs.date_created, jobs.date_ending, jobsectors.jobsector_name FROM jobs ";
    $sql .= "INNER JOIN jobsectors ";
    $sql .= "ON jobsectors.id = jobs.jobsector_id ";
    $sql .= "INNER JOIN jobtypes ";
    $sql .= "ON jobtypes.id = jobs.jobtype_id ";
    $sql .= "INNER JOIN jobrates ";
    $sql .= "ON jobrates.id = jobs.jobrate_id ";
    $sql .= "INNER JOIN currency ";
    $sql .= "ON currency.id = jobs.currency_id ";
    $sql .= "WHERE jobs.id='" . db_escape($db, $job_id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $job = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $job; // returns an assoc. array
}

function find_job_by_location($job_id)
{
    global $db;

    $sql = "SELECT jobs.lat, jobs.lng FROM jobs ";
    $sql .="INNER JOIN companies ";
    $sql .="ON companies.id = jobs.company_id ";
    $sql .= "WHERE id='" . db_escape($db, $job_id) . "' ";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $jobLoc = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $jobLoc; // returns an assoc. array
}

function find_job_vid_by_id($job_id)
{
    global $db;

    // $visible = $options['visible'] ?? false;

    $sql = "SELECT jobs.id, jobs.job_title, job_videos.id, jobs.company_id, job_videos.recruiter_id, job_videos.job_id, job_videos.video_desc, job_videos.video_filename FROM jobs ";
    $sql .= "INNER JOIN job_videos ";
    $sql .= "ON job_videos.job_id = jobs.id ";
    $sql .= "INNER JOIN companies ";
    $sql .= "ON companies.id = jobs.company_id ";
    $sql .= "WHERE job_videos.job_id='" . db_escape($db, $job_id) . "' ";
    $sql .= "AND job_videos.job_id IS NOT NULL ";
    // if ($visible) {
    //     $sql .= "AND visible = true ";
    $sql .= "ORDER BY job_videos.id DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $job_vid = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $job_vid; // returns an assoc. array
}

function job_vid_modal($job_id)
{
    global $db;

    $sql = "SELECT jobs.id, job_videos.id, job_videos.job_id, job_videos.video_desc, job_videos.video_filename FROM jobs ";
    $sql .= "INNER JOIN job_videos ";
    $sql .= "ON job_videos.job_id = jobs.id ";
    $sql .= "WHERE jobs.id='" . db_escape($db, $job_id) . "' ";
    $sql .= "ORDER BY job_videos.job_id DESC ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_jobsector_by_id($jobsector_id)
{
    global $db;

    $sql = "SELECT * FROM jobsectors ";
    $sql .= "WHERE id='" . db_escape($db, $jobsector_id) . "' ";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $jobsector = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $jobsector; // returns an assoc. array
}

function validate_job($job)
{
    $errors = [];

    // company_id
    if (is_blank($job['company_id'])) {
        $errors[] = "Company cannot be blank.";
    }

    // menu_name
    // if(is_blank($job['menu_name'])) {
    //   $errors[] = "Menu Name cannot be blank.";
    // } elseif(!has_length($job['menu_name'], ['min' => 2, 'max' => 255])) {
    //   $errors[] = "Menu Name must be between 2 and 255 characters.";
    // }
    // $current_id = $job['id'] ?? '0';
    // if(!has_unique_job_menu_name($job['menu_name'], $current_id)) {
    //   $errors[] = "Menu Name must be unique.";
    // }

    // position
    // Make sure we are working with an integer
    // $postion_int = (int) $job['position'];
    // if($postion_int <= 0) {
    // $errors[] = "Position must be greater than zero.";
    // }
    // if($postion_int > 999) {
    // $errors[] = "Position must be less than 999.";
    // }

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $job['visible'];
    if (!has_inclusion_of($visible_str, ["true","false"])) {
        $errors[] = "Visible must be true or false.";
    }

    // job_title
    if (is_blank($job['job_title'])) {
        $errors[] = "Job Title cannot be blank.";
    } elseif (!has_length($job['job_title'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Job Title must be between 3 and 255 characters.";
    }

    // job_desc
    if (is_blank($job['job_desc'])) {
        $errors[] = "Job Description cannot be blank.";
    }

    // salary
    if (is_blank($job['salary'])) {
        $errors[] = "Salary cannot be blank.";
    } elseif (!has_number($job['salary'])) {
        $errors[] = "Salary must be a number.";
    } elseif (!has_length($job['salary'], ['min' => 3, 'max' => 10])) {
        $errors[] = "Salary must be between 4 and 10 characters, e.g. 7.80";
    }

    return $errors;
}

function insert_job($job)
{
    global $db;

    $errors = validate_job($job);
    if (!empty($errors)) {
        return $errors;
    }

    //shift_job_positions(0, $job['position'], $job['company_id']);

    $sql = "INSERT INTO jobs ";
    $sql .= "(company_id, recruiter_id, visible, job_title, job_desc, job_location, jobtype_id, salary) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $job['company_id']) . "',";
    $sql .= "'" . db_escape($db, $_SESSION['recruiter_id']) . "',";
    $sql .= "'" . db_escape($db, $job['visible']) . "',";
    $sql .= "'" . db_escape($db, $job['job_title']) . "',";
    $sql .= "'" . db_escape($db, $job['job_desc']) . "',";
    $sql .= "'" . db_escape($db, $job['job_location']) . "',";
    $sql .= "'" . db_escape($db, $job['jobtype_id']) . "',";
    $sql .= "'" . db_escape($db, $job['salary']) . "' ";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_job($job)
{
    global $db;

    $errors = validate_job($job);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE jobs SET ";
    $sql .= "company_id='" . db_escape($db, $job['company_id']) . "', ";
    $sql .= "recruiter_id='" . db_escape($db, $job['recruiter_id']) . "', ";
    $sql .= "visible='" . db_escape($db, $job['visible']) . "', ";
    $sql .= "job_title='" . db_escape($db, $job['job_title']) . "', ";
    $sql .= "job_desc='" . db_escape($db, $job['job_desc']) . "', ";
    $sql .= "job_location='" . db_escape($db, $job['job_location']) . "', ";
    $sql .= "jobtype_id='" . db_escape($db, $job['jobtype_id']) . "', ";
    $sql .= "salary='" . db_escape($db, $job['salary']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $job['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_job_video($job)
{
    global $db;

    // $errors = validate_job($job);
    // if (!empty($errors)) {
    //     return $errors;
    // }

    $sql = "UPDATE job_videos SET ";
    $sql .= "video_desc='" . db_escape($db, $job['video_desc']) . "' ";
    $sql .= "WHERE job_id='" . db_escape($db, $job['job_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function disable_job($job_id)
{
    global $db;

    $sql = "UPDATE jobs SET ";
    $sql .= "visible ='" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE id='" . db_escape($db, $job_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//Set aside for full delete
function XXXdelete_job($job_id)
{
    global $db;

    $sql = "DELETE FROM jobs ";
    $sql .= "WHERE id='" . db_escape($db, $job_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_job_video($job_id)
{
    global $db;

    $sql = "DELETE FROM job_videos ";
    $sql .= "WHERE job_id='" . db_escape($db, $job_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function validate_jobsector($jobsector)
{
    $errors = [];

    // jobsector_name
    if (is_blank($jobsector['jobsector_name'])) {
        $errors[] = "Job Sector Name cannot be blank.";
    }
    // elseif(!has_length($jobsector['jobsector_name'], ['min' => 2, 'max' => 255])) {
    //   $errors[] = "Menu Name must be between 2 and 255 characters.";
    // }
    $current_id = $jobsector['id'] ?? '0';
    if (!has_unique_jobsector_name($jobsector['jobsector_name'], $current_id)) {
        $errors[] = "Job Sector Name must be unique!";
    }

    return $errors;
}

function insert_jobsector($jobsector)
{
    global $db;

    $errors = validate_jobsector($jobsector);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO jobsectors ";
    $sql .= "(jobsector_name) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $jobsector['jobsector_name']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_jobsector($jobsector)
{
    global $db;

    $errors = validate_jobsector($jobsector);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE jobsectors SET ";
    $sql .= "jobsector_name='" . db_escape($db, $jobsector['jobsector_name']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $jobsector['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_jobsector($jobsector_id)
{
    global $db;

    $sql = "DELETE FROM jobsectors ";
    $sql .= "WHERE id='" . db_escape($db, $jobsector_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_jobs_by_company_id($company_id, $options=[])
{
    global $db;

    $visible = $options['visible'] ?? false; //setting a default value

    $sql = "SELECT jobs.id, jobs.company_id, jobs.recruiter_id, jobs.jobsector_id, jobs.visible, jobs.job_title, jobs.job_desc, jobs.job_location, jobs.lat, jobs.lng, jobs.jobtype_id, jobtypes.jobtype_name, jobs.jobrate_id, jobrates.jobrate_name, jobs.salary, jobs.currency_id, currency.alphacode, jobs.date_created, jobs.date_ending, jobsectors.jobsector_name FROM jobs ";
    $sql .= "INNER JOIN jobsectors ";
    $sql .= "ON jobsectors.id = jobs.jobsector_id ";
    $sql .= "INNER JOIN jobtypes ";
    $sql .= "ON jobtypes.id = jobs.jobtype_id ";
    $sql .= "INNER JOIN jobrates ";
    $sql .= "ON jobrates.id = jobs.jobrate_id ";
    $sql .= "INNER JOIN currency ";
    $sql .= "ON currency.id = jobs.currency_id ";

    $sql .= "WHERE company_id='" . db_escape($db, $company_id) . "' ";
    if ($visible) {
        $sql .= "AND visible = true ";
    }
    $sql .= "ORDER BY jobs.id DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns a result set, compared to find_job_by_id which returns an assoc. array!
}

function count_all_jobs()
{
    global $db;

    $sql = "SELECT COUNT(id) FROM jobs";
    // $sql .= "WHERE company_id='" . db_escape($db, $recruiter_company_id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $row = mysqli_fetch_row($result); // mysqli_fetch_row, returns a single array
    mysqli_free_result($result);
    $count = $row[0];
    return $count;
}

function count_jobs_by_company_id($recruiter_company_id) {

    global $db;

    $sql = "SELECT COUNT(id) FROM jobs ";
    $sql .= "WHERE company_id='" . db_escape($db, $recruiter_company_id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $row = mysqli_fetch_row($result); // mysqli_fetch_row, returns a single array
    mysqli_free_result($result);
    $count = $row[0];
    return $count;
}

function count_job_apps_by_job_id($job)
{
    global $db;

    $sql = "SELECT COUNT(job_id) FROM userjobs ";
    $sql .= "WHERE job_id='" . db_escape($db, $job) . "' ";
    $sql .= "AND applic_sent='" . db_escape($db, '1') . "'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $row = mysqli_fetch_row($result); // mysqli_fetch_row, returns a single array
    mysqli_free_result($result);
    $count = $row[0];
    return $count;
}


// function shift_job_positions($start_pos, $end_pos, $company_id, $current_id=0) {
//   global $db;
//
//   if($start_pos == $end_pos) { return; }
//
//   $sql = "UPDATE jobs ";
//   if($start_pos == 0) {
//     // new item, +1 to items greater than $end_pos
//     $sql .= "SET position = position + 1 ";
//     $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
//   } elseif($end_pos == 0) {
//     // delete item, -1 from items greater than $start_pos
//     $sql .= "SET position = position - 1 ";
//     $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
//   } elseif($start_pos < $end_pos) {
//     // move later, -1 from items between (including $end_pos)
//     $sql .= "SET position = position - 1 ";
//     $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
//     $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
//   } elseif($start_pos > $end_pos) {
//     // move earlier, +1 to items between (including $end_pos)
//     $sql .= "SET position = position + 1 ";
//     $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
//     $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
//   }
//   // Exclude the current_id in the SQL WHERE clause
//   $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
//   $sql .= "AND company_id = '" . db_escape($db, $company_id) . "'";
//
//   $result = mysqli_query($db, $sql);
//   // For UPDATE statements, $result is true/false
//   if($result) {
//     return true;
//   } else {
//     // UPDATE failed
//     echo mysqli_error($db);
//     db_disconnect($db);
//     exit;
//   }
// }

// Admins
// Find all admins, ordered last_name, first_name
function find_all_admins()
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_admin_by_id($admin_id)
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $admin_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function find_admin_by_admin_email($email)
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function validate_new_admin($admin)
{
    $errors = [];

    if (!has_unique_admin_email($admin['email'], $admin['id'] ?? 0)) {
        $errors[] = "Email address is not allowed. Please try another.";
    }

    return $errors;
}

function validate_admin($admin)
{

    if (!has_unique_admin_email($admin['email'], $admin['id'] ?? 0)) {
        $errors[] = "Email address is not allowed. Please try another.";
    }

    return $errors;
}

function insert_admin($admin)
{
    global $db;

    $errors = validate_new_admin($admin);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_admin($admin)
{
    global $db;

    // $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function admin_disable_admin($admin_id)
{
    global $db;

    $sql = "UPDATE admins SET ";
    $sql .= "visible='" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin_id) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_admin($admin)
{
    global $db;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Users
// Find all users, ordered by ID
function show_user()
{
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "AND visible='" . db_escape($db, 'true') . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function admin_show_user($user_id)
{
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $user_id) . "' ";
    $sql .= "AND visible='" . db_escape($db, 'true') . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}



// Find all users, ordered by ID
function find_all_users()
{
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}


function find_user_by_id($user_id)
{
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $user; // returns an assoc. array
}

function find_user_by_user_email($email)
{
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $user; // returns an assoc. array
}

function find_user_by_email($email)
{
    global $db;

    $sql = "SELECT email FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $email = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $email; // returns an assoc. array
}

function validate_user($user) {

    $errors = [];

    if (!has_unique_user_email($user['email'], $user['id'] ?? 0)) {
        $errors[] = "Email address is not allowed. Please try another.";
    }

    return $errors;
}

function validate_new_user($user) {

    $errors = [];

    if (!has_unique_user_email($user['email'], $user['id'] ?? 0)) {
        $errors[] = "Email address is not allowed. Please try another.";
        }

    return $errors;
}

function insert_user($user)
{
    global $db;

    $errors = validate_new_user($user);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, profile_img, profile_img_status, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['profile_img']) . "',";
    $sql .= "'" . db_escape($db, $user['profile_img_status']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "' ";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//For setting up usercv defaults
function set_usercv_defaults($new_id)
{
    global $db;

    $sql = "INSERT INTO usercvs "; // IGNORE used if job already saved
    $sql .= "(userid, cv_name, status) ";
    $sql .= "VALUES (";
    //$sql .= "'" . db_escape($db, $user['id']) . "', ";
    $sql .= "'" . db_escape($db, $new_id) . "', ";
    $sql .= "'" . db_escape($db, 'no-cv.png') . "', ";
    $sql .= "'" . db_escape($db, '0') . "' ";
    $sql .= ")";

    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_user($user)
{
    global $db;

    // $password_sent = !is_blank($user['password']);

    $errors = validate_user($user);
    if (!empty($errors)) {
        return $errors;
    }

    // $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $user['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $user['email']) . "', ";
    $sql .= "job_prefs='" . db_escape($db, $user['job_prefs']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $user['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function admin_disable_user($user_id)
{
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "visible='" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE id='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_user($user_id) {
    global $db;

    $sql = "DELETE FROM usercvs ";
    $sql .= "WHERE userid='" . db_escape($db, $user_id) . "' ";

    $sql = "DELETE FROM userjobs ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";

    $sql = "DELETE FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $user_id) . "' ";

    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// User Jobs
//For displaying in My Saved Jobs
function find_jobs_by_user_id($user_id)
{
    global $db;

    $rad = 0;

    $radius = get_rads($rad);
    $lat = 50.795276;
    $lng = -1.074379;

    $sql = "SELECT jobs.id, jobs.company_id, jobs.job_title, jobs.job_location, jobtypes.jobtype_name, jobs.job_desc, jobs.salary, jobs.currency_id, currency.alphacode, jobrates.jobrate_name, jobs.date_created AS job_posted, jobs.date_ending, jobs.visible, companies.company_name, companies.visible AS co_vis, companies.logo, jobs.recruiter_id, jobsectors.jobsector_name, jobsectors.jsector_icon, recruiters.email AS rec_email, userjobs.job_id, userjobs.date_created, userjobs.applic_sent, userjobs.applic_sent_date, users.id, ( 3959 * acos( cos( radians( {$lat} ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( {$lng} ) ) + sin( radians( {$lat} ) ) * sin( radians( lat ) ) ) ) AS distance ";
    $sql .= "FROM jobs ";
    $sql .= "INNER JOIN recruiters ON jobs.recruiter_id=recruiters.id ";
    $sql .= "INNER JOIN companies ";
    $sql .= "ON companies.id = company_id ";
    $sql .= "INNER JOIN userjobs ";
    $sql .= "ON jobs.id = job_id ";
    $sql .= "INNER JOIN users ";
    $sql .= "ON user_id = users.id ";
    $sql .= "INNER JOIN jobsectors ON jobsectors.id=jobs.jobsector_id ";
    $sql .= "INNER JOIN jobtypes ON jobtypes.id=jobs.jobtype_id ";
    $sql .= "INNER JOIN jobrates ON jobrates.id=jobs.jobrate_id ";
    $sql .= "INNER JOIN currency ON currency.id=jobs.currency_id ";
    $sql .= "WHERE users.id='" . db_escape($db, $user_id) . "' ";
    // $sql .= "HAVING distance >= {$rad} ";
    $sql .= "ORDER BY jobs.date_created DESC";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns a result set, compared to find_job_by_id which returns an assoc. array!
}

function find_user_job_title($title)
{
    global $db;

    $sql = "SELECT userjobs.job_id, userjobs.user_id, jobs.job_title ";
    $sql .= "FROM userjobs ";
    $sql .= "INNER JOIN jobs ";
    $sql .= "ON jobs.id = job_id ";
    $sql .= "WHERE jobs.job_title='" . db_escape($db, $title) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

//For checking saved user job exists
function find_user_job($job_id)
{
    global $db;

    $sql = "SELECT userjobs.job_id, userjobs.user_id, userjobs.applic_sent, userjobs.applic_sent_date, jobs.job_title, recruiters.email AS rec_email ";
    $sql .= "FROM userjobs ";
    $sql .= "INNER JOIN jobs ";
    $sql .= "ON jobs.id = job_id ";
    $sql .= "INNER JOIN recruiters ";
    $sql .= "ON recruiters.id = recruiter_id ";
    $sql .= "WHERE userjobs.job_id='" . db_escape($db, $job_id) . "' ";
    $sql .= "AND userjobs.user_id='" . db_escape($db, $_SESSION['user_id']) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $job = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $job; // returns an assoc. array
}

//For checking saved user job exists
function find_user_job_applic($job_id) {
  global $db;

    $sql = "SELECT jobs.id, jobs.company_id, jobs.job_title, jobs.job_location, jobs.salary, jobs.date_created, jobs.visible, companies.company_name, companies.logo, jobs.recruiter_id, recruiters.email AS rec_email, userjobs.job_id, userjobs.applic_sent, users.id, usercvs.userid, usercvs.cv_name, usercvs.status AS cv_status ";
    $sql .= "FROM userjobs ";
    $sql .= "INNER JOIN users ";
    $sql .= "ON users.id = userjobs.user_id ";
    $sql .= "INNER JOIN usercvs ";
    $sql .= "ON usercvs.userid = userjobs.user_id ";
    $sql .= "INNER JOIN jobs ";
    $sql .= "ON jobs.id = job_id ";
    $sql .= "INNER JOIN recruiters ";
    $sql .= "ON recruiters.id = recruiter_id ";
    $sql .= "INNER JOIN companies ";
    $sql .= "ON companies.id = company_id ";
    $sql .= "WHERE job_id='" . db_escape($db, $job_id) . "' ";
    $sql .= "AND user_id='" . db_escape($db, $_SESSION['user_id']) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $job = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $job; // returns an assoc. array
}

function find_user_by_job_id($job_id)
{
    global $db;

    $sql = "SELECT jobs.id, users.profile_img, users.first_name, users.last_name, users.email, jobs.date_created, userjobs.job_id, userjobs.applic_sent, userjobs.user_id, users.id, userjobs.applic_sent, userjobs.applic_sent_date, usercvs.cv_name, usercvs.status ";
    $sql .= "FROM jobs ";
    $sql .= "INNER JOIN userjobs ";
    $sql .= "ON userjobs.job_id = jobs.id ";
    $sql .= "INNER JOIN users ";
    $sql .= "ON users.id = userjobs.user_id ";
    $sql .= "INNER JOIN usercvs ";
    $sql .= "ON usercvs.userid = userjobs.user_id ";
    $sql .= "WHERE userjobs.job_id='" . db_escape($db, $job_id) . "' ";
    $sql .= "AND applic_sent = '1' ";
    $sql .= "ORDER BY userjobs.id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns a result set, compared to find_job_by_id which returns an assoc. array!
}


function find_user_cv($user_id)
{
    global $db;

    $sql = "SELECT userid, cv_name, status ";
    $sql .= "FROM usercvs ";
    $sql .= "WHERE userid='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $cv = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $cv; // returns an assoc. array
}

//Admin control
function admin_find_company_logo($co_id)
{
    global $db;

    $sql = "SELECT id, logo, logo_status ";
    $sql .= "FROM companies ";
    $sql .= "WHERE id='" . db_escape($db, $co_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $coImg = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $coImg; // returns an assoc. array
}


function find_company_logo($rec_id)
{
    global $db;

    $sql = "SELECT recruiter_id, logo, logo_status ";
    $sql .= "FROM companies ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $coImg = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $coImg; // returns an assoc. array
}


function find_user_profile($user_id)
{
    global $db;

    $sql = "SELECT profile_img, profile_img_status ";
    $sql .= "FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $pimg = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $pimg; // returns an assoc. array
}

function find_company_by_job_id()
{
    global $db;

    $sql = "SELECT company_name FROM companies ";
    $sql .= "INNER JOIN jobs ";
    $sql .= "ON jobs.company_id = companies.id ";
    $sql .= "WHERE jobs.id='" . db_escape($db, $_SESSION['job_id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $co = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $co; // returns an assoc. array
}

//For inserting saved job in userjobs
function insert_user_job()
{
    global $db;

    $sql = "INSERT INTO userjobs ";
    $sql .= "(job_id, user_id) ";
    $sql .= "VALUES (";
    //$sql .= "'" . db_escape($db, $user['id']) . "', ";
    $sql .= "'" . db_escape($db, $_SESSION['job_id']) . "', ";
    $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
    // $sql .= "'" . db_escape($db, 0) . "'";
    $sql .= ")";
    // $sql .= "ON DUPLICATE KEY UPDATE applic_sent = VALUES(applic_sent) + 1 ";
    // $sql .= "'" . db_escape($db, 1) . "'";

    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function user_job_app_sent()
{
    global $db;
    $job_id = $_SESSION['job_id'];
    $job_sent = '1';

    $sql = "UPDATE userjobs SET ";
    $sql .= "applic_sent='" . db_escape($db, $job_sent) . "' ";
    $sql .= "WHERE job_id='" . db_escape($db, $job_id) . "' ";
    $sql .= "AND user_id='" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//For removing from Saved Jobs list
function delete_user_job($job_id)
{
    global $db;

    $sql = "DELETE FROM userjobs ";
    $sql .= "WHERE job_id='" . db_escape($db, $job_id) . "' ";
    $sql .= "AND user_id='" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function admin_show_recruiter($rec_id)
{
    global $db;

    $sql = "SELECT * FROM recruiters ";
    $sql .= "WHERE id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "AND visible='" . db_escape($db, 'true') . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// RECRUITERS
function show_recruiter()
{
    global $db;

    $sql = "SELECT * FROM recruiters ";
    $sql .= "WHERE id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    $sql .= "AND visible='" . db_escape($db, 'true') . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function admin_find_all_recruiters()
{
    global $db;

    $sql = "SELECT recruiters.id, first_name, last_name, email, recruiters.visible FROM recruiters ";
    // $sql .= "INNER JOIN companies ";
    // $sql .= "ON companies.recruiter_id = recruiters.id ";
    $sql .= "ORDER BY recruiters.id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function admin_find_all_recruiter_companies($rec_id)
{
    global $db;

    $sql = "SELECT recruiters.id, first_name, last_name, email, recruiters.visible, companies.id AS company_id, companies.company_name FROM recruiters ";
    $sql .= "INNER JOIN companies ";
    $sql .= "ON companies.recruiter_id = recruiters.id ";
    $sql .= "WHERE recruiters.id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "ORDER BY recruiters.id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

//Job Seeker Root Recruiters Index
function find_the_recruiter_by_id($rec_id)
{
    global $db;

    $sql = "SELECT * FROM recruiters ";
    $sql .= "INNER JOIN companies ";
    $sql .= "ON companies.recruiter_id = recruiters.id ";
    $sql .= "WHERE recruiters.id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "AND companies.recruiter_id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "AND recruiters.visible='" . db_escape($db, 'true') . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recruiter = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $recruiter; // returns an assoc. array
}

//PA Root Recruiters Index
function find_recruiter_by_id($rec_id)
{
    global $db;

    $sql = "SELECT * FROM recruiters ";
    // $sql .= "INNER JOIN companies ";
    // $sql .= "ON companies.recruiter_id = recruiters.id ";
    $sql .= "WHERE recruiters.id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    $sql .= "AND visible='" . db_escape($db, 'true') . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recruiter = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $recruiter; // returns an assoc. array
}

//Job Seeker Root Recruiters Index
function find_the_user_by_id($user_id)
{
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE users.id='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $the_user = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $the_user; // returns an assoc. array
}

function admin_find_recruiter_by_id($rec_id)
{
    global $db;

    $sql = "SELECT recruiters.id AS recId, recruiters.first_name, recruiters.last_name, recruiters.email, companies.id AS co_id, companies.company_name FROM recruiters ";
    $sql .= "INNER JOIN companies ";
    $sql .= "ON companies.recruiter_id = recruiters.id ";
    $sql .= "WHERE recruiters.id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recruiter = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $recruiter; // returns an assoc. array
}

function find_recruiter_by_recruiter_email($email)
{
    global $db;

    $sql = "SELECT * FROM recruiters ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recruiter = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $recruiter; // returns an assoc. array
}

function validate_recruiter($recruiter)
{
    $errors = [];

    if (!has_unique_recruiter_email($recruiter['email'], $recruiter['id'] ?? 0)) {
        $errors[] = "Email address is not allowed. Please try another.";
    }

    return $errors;
}

function validate_new_recruiter($recruiter)
{
    $errors = [];

    if (!has_unique_recruiter_email($recruiter['email'], $recruiter['id'] ?? 0)) {
        $errors[] = "Email address is not allowed. Please try another.";
    }

 return $errors;
}

function insert_recruiter($recruiter)
{
    global $db;

    $errors = validate_new_recruiter($recruiter);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($recruiter['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO recruiters ";
    $sql .= "(first_name, last_name, email, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $recruiter['first_name']) . "',";
    $sql .= "'" . db_escape($db, $recruiter['last_name']) . "',";
    $sql .= "'" . db_escape($db, $recruiter['email']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "' ";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_recruiter($recruiter)
{
    global $db;

    // $password_sent = !is_blank($recruiter['password']);

    $errors = validate_recruiter($recruiter);
    if (!empty($errors)) {
        return $errors;
    }

    // $hashed_password = password_hash($recruiter['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE recruiters SET ";
    $sql .= "first_name='" . db_escape($db, $recruiter['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $recruiter['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $recruiter['email']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $recruiter['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function disable_recruiter($rec_id)
{
    global $db;

    $sql = "UPDATE recruiters SET ";
    $sql .= "visible='" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE id='" . db_escape($db, $rec_id) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function disable_user($user_id)
{
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "visible='" . db_escape($db, 'false') . "' ";
    $sql .= "WHERE id='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//Set aside for actual deletion of recruiter
function XXXdelete_recruiter($recruiter)
{
    global $db;

    $sql = "DELETE FROM recruiters ";
    $sql .= "WHERE id='" . db_escape($db, $recruiter['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function admin_show_recruiter_company($rec_id)
{
    global $db;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $rec_id) . "' ";
    //$sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// Recruiter Companies
function show_recruiter_company()
{
    global $db;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    //$sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function show_recruiter_company_modal($co_id)
{
    global $db;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE id='" . db_escape($db, $co_id) . "' ";
    //$sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_recruiter_company_by_rec_id($rec_id) {
    global $db;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE recruiter_id='" . db_escape($db,   $rec_id) . "' ";
    // $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $company = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $company; // returns an assoc. array
}

function find_all_recruiter_companies($options=[])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM companies ";
    if ($visible) {
        $sql .= "WHERE visible = true ";
        $sql .= "AND companies.recruiter_id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    }
    //$sql .= "ORDER BY recruiter_id ASC ";
    //$sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_recruiter_job($job_id)
{
    global $db;

    $sql = "SELECT jobs.job_title, recruiters.email AS rec_email FROM jobs ";
    $sql .= "INNER JOIN recruiters ";
    $sql .= "ON recruiters.id = jobs.recruiter_id ";
    $sql .= "WHERE jobs.id = '" . db_escape($db, $_SESSION['job_id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $job = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $job; // returns an assoc. array
}

function find_all_companies_by_recruiter($options=[])
{
    global $db;

    //$visible = $options['visible'] ?? false;

    $sql = "SELECT id, recruiter_id, company_name FROM companies ";
    //if($visible) {
    //$sql .= "WHERE visible = true ";
    $sql .= "WHERE recruiter_id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    //}
    $sql .= "ORDER BY recruiter_id ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function insert_recruiter_company($company)
{
    global $db;

    $errors = validate_recruiter_company($company);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO companies ";
    $sql .= "(recruiter_id, visible, company_name, company_desc, location, logo) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $_SESSION['recruiter_id']) . "',";
    $sql .= "'" . db_escape($db, $company['visible']) . "',";
    $sql .= "'" . db_escape($db, $company['company_name']) . "',";
    $sql .= "'" . db_escape($db, $company['company_desc']) . "',";
    $sql .= "'" . db_escape($db, $company['location']) . "',";
    $sql .= "'" . db_escape($db, 'no_company_logo.png') . "'";
    $sql .= ")";


    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function validate_recruiter_company($company)
{
    $errors = [];

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $company['visible'];
    if (!has_inclusion_of($visible_str, ["true","false"])) {
        $errors[] = "Visible must be true or false.";
    }

    // company_name
    if (is_blank($company['company_name'])) {
        $errors[] = "Company Name cannot be blank.";
    } elseif (!has_length($company['company_name'], ['min' => 1, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // company_desc
    if (is_blank($company['company_desc'])) {
        $errors[] = "Company Description cannot be blank.";
    }

    // location
    if (is_blank($company['location'])) {
        $errors[] = "Location cannot be blank.";
    } elseif (!has_length($company['location'], ['min' => 1, 'max' => 255])) {
        $errors[] = "Location must be between 2 and 255 characters.";
    }

    // logo
    // if(is_blank($company['logo'])) {
    //   $errors[] = "Logo cannot be blank.";
    // } //elseif(!has_length($company['logo'], ['min' => 2, 'max' => 255])) {
    //$errors[] = "Logo must be between 2 and 255 characters.";
    //}

    return $errors;
}

function admin_find_recruiter_company($rec_id)
{
    global $db;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE companies.recruiter_id='" . db_escape($db, $rec_id) . "' ";
    //$sql .= "ORDER BY recruiter_id ASC ";
    //$sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_recruiter_company()
{
    global $db;

    $sql = "SELECT * FROM companies ";
    $sql .= "WHERE companies.recruiter_id='" . db_escape($db, $_SESSION['recruiter_id']) . "' ";
    //$sql .= "ORDER BY recruiter_id ASC ";
    //$sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// Recruiter Company Jobs
// function count_jobs_by_recruiter_company_id($company_id, $options=[]) {
//   global $db;
//
//   $visible = $options['visible'] ?? false; //setting a default value
//
//   $sql = "SELECT COUNT(id) FROM jobs ";
//   $sql .= "WHERE company_id='" . db_escape($db, $company_id) . "' ";
//   if($visible) {
//     $sql .= "AND visible = true ";
//   }
//   $sql .= "ORDER BY position ASC";
//   $result = mysqli_query($db, $sql);
//   confirm_result_set($result);
//   $row = mysqli_fetch_row($result); // mysqli_fetch_row, returns a single array
//   mysqli_free_result($result);
//   $count = $row[0];
//   return $count;
// }

function admin_validate_recruiter_job($job, $jobsector, $jobtype, $jobrate)
{
    $errors = [];

    // job_title
    if (is_blank($job['job_title'])) {
        $errors[] = "Job Title cannot be blank.";
    } elseif (!has_length($job['job_title'], ['min' => 2, 'max' => 101])) {
        $errors[] = "Job Title must be between 3 and 100 characters.";
    }

    //job_sector
    if (!has_presence($jobsector['jobsector_id'], "Select Sector")) {
        $errors[] = "Select a Job Sector";
    }

    // job_desc
    if (is_blank($job['job_desc'])) {
        $errors[] = "Job Description cannot be blank.";
    }

    //job_type
    if (!has_presence($jobtype['jobtype_id'], "Select Job Type")) {
        $errors[] = "Select a Job Type";
    }

    //job_rate
    if (!has_presence($jobrate['jobrate_id'], "Select Job Rate")) {
        $errors[] = "Select a Job Rate";
    }

    // salary
    if (is_blank($job['salary'])) {
        $errors[] = "Salary cannot be blank.";
    } elseif (!has_number($job['salary'])) {
        $errors[] = "Salary must be a number.";
    } elseif (!has_length($job['salary'], ['min' => 3, 'max' => 10])) {
        $errors[] = "Salary must be between 4 and 10 characters, e.g. 7.80";
    }

    //location
    if (is_blank($job['job_location'])) {
        $errors[] = "Location cannot be blank.";
    }

    // date ending
    if (is_blank($job['date_ending'])) {
        $errors[] = "Job Date Ending cannot be blank.";
    } elseif (!has_length($job['date_ending'], ['min' => 9, 'max' => 11])) {
        $errors[] = "Date must have 10 characters.";
    } elseif (!has_valid_date($job['date_ending'])) {
        $errors[] = "Invalid date format entered.";
    }

    // visible
    // Make sure we are working with a string
    // $visible_str = (string) $job['visible'];
    // if(!has_inclusion_of($visible_str, ["true","false"])) {
    //   $errors[] = "Visible must be true or false.";
    // }

    //lat
    // if(is_blank($job['lat'])) {
    //   $errors[] = "Latitude cannot be blank.";
    // }
    // elseif(!is_numeric($job['lat'])) {
    //   $errors[] = "Latitude data entered is not numeric.";
    // }
    // elseif(!has_length($job['lat'], ['min' => 8 , 'max' => 19])) {
    //   $errors[] = "Latitude must use at least 9 digits including decimal point.";
    // }
    // elseif(!has_valid_lat_coords($job['lat'])) {
    //   $errors[] = "Invalid Latitude entered.";
    // }

    //lng
    // if(is_blank($job['lng'])) {
    //   $errors[] = "Longitude cannot be blank.";
    // }
    // elseif(!is_numeric($job['lng'])) {
    //   $errors[] = "Longitude data entered is not numeric.";
    // }
    // elseif(!has_length($job['lng'], ['min' => 8 , 'max' => 19])) {
    //   $errors[] = "Longitude must use at least 9 digits including decimal point.";
    // }
    // elseif(!has_valid_lat_coords($job['lng'])) {
    //   $errors[] = "Invalid Longitude entered.";
    // }

    return $errors;
}

function admin_insert_recruiter_job($job, $jobsector)
{
    global $db;

    $errors = admin_validate_recruiter_job($job, $jobsector);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO jobs ";
    $sql .= "(company_id, recruiter_id, job_title, jobsector_id, job_desc, jobtype_id ,salary, job_location, city, visible, lat, lng, location_status, date_ending) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $job['company_id']) . "',";
    $sql .= "'" . db_escape($db, $job['recruiter_id']) . "',";
    $sql .= "'" . db_escape($db, $job['job_title']) . "',";
    $sql .= "'" . db_escape($db, $jobsector['jobsector_id']) . "',";
    $sql .= "'" . db_escape($db, $job['job_desc']) . "',";
    $sql .= "'" . db_escape($db, $job['jobtype_id']) . "',";
    $sql .= "'" . db_escape($db, $job['salary']) . "', ";
    $sql .= "'" . db_escape($db, $job['job_location']) . "',";
    $sql .= "'" . db_escape($db, $job['city']) . "',";
    $sql .= "'" . db_escape($db, $job['visible']) . "',";
    $sql .= "'" . db_escape($db, $job['lat']) . "',";
    $sql .= "'" . db_escape($db, $job['lng']) . "',";
    $sql .= "'" . db_escape($db, 1) . "',";
    $sql .= "'" . db_escape($db, $job['date_ending']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function admin_update_recruiter_job($job, $jobsector, $jobtype, $jobrate)
{
    global $db;

    $errors = admin_validate_recruiter_job($job, $jobsector, $jobtype, $jobrate);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE jobs SET ";
    $sql .= "company_id='" . db_escape($db, $job['company_id']) . "', ";
    $sql .= "jobsector_id='" . db_escape($db, $jobsector['jobsector_id']) . "', ";
    $sql .= "job_title='" . db_escape($db, $job['job_title']) . "', ";
    $sql .= "job_desc='" . db_escape($db, $job['job_desc']) . "', ";
    $sql .= "jobtype_id='" . db_escape($db, $jobtype['jobtype_id']) . "', ";
    $sql .= "jobrate_id='" . db_escape($db, $jobrate['jobrate_id']) . "', ";
    $sql .= "salary='" . db_escape($db, $job['salary']) . "', ";
    $sql .= "job_location='" . db_escape($db, $job['job_location']) . "', ";
    $sql .= "city='" . db_escape($db, $job['city']) . "', ";
    $sql .= "lat='" . db_escape($db, $job['lat']) . "', ";
    $sql .= "lng='" . db_escape($db, $job['lng']) . "', ";
    $sql .= "date_ending='" . db_escape($db, $job['date_ending']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $job['job_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function admin_find_recruiter_job_by_id($job_id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM jobs ";
    $sql .= "INNER JOIN jobsectors ";
    $sql .= "ON jobsectors.id = jobs.jobsector_id ";
    $sql .= "INNER JOIN jobtypes ";
    $sql .= "ON jobtypes.id = jobs.jobtype_id ";
    $sql .= "INNER JOIN jobrates ";
    $sql .= "ON jobrates.id = jobs.jobrate_id ";
    $sql .= "INNER JOIN currency ";
    $sql .= "ON currency.id = jobs.currency_id ";
    $sql .= "WHERE jobs.id='" . db_escape($db, $job_id) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $job = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $job; // returns an assoc. array
}

function find_recruiter_job_by_id($job_id)
{
    global $db;

    $sql = "SELECT * FROM jobs ";
    $sql .= "INNER JOIN jobsectors ";
    $sql .= "ON jobsectors.id = jobs.jobsector_id ";
    $sql .= "INNER JOIN jobtypes ";
    $sql .= "ON jobtypes.id = jobs.jobtype_id ";
    $sql .= "INNER JOIN jobrates ";
    $sql .= "ON jobrates.id = jobs.jobrate_id ";
    $sql .= "INNER JOIN currency ";
    $sql .= "ON currency.id = jobs.currency_id ";
    $sql .= "WHERE jobs.id='" . db_escape($db, $job_id) . "' ";
    $sql .= "AND recruiter_id='" . db_escape($db, $_SESSION['recruiter_id']) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $job = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $job; // returns an assoc. array
}

function validate_recruiter_job($job, $jobsector, $jobtype, $jobrate, $currency)
{
    $errors = [];

    // job_title
    if (is_blank($job['job_title'])) {
        $errors[] = "Job Title cannot be blank.";
    } elseif (!has_length($job['job_title'], ['min' => 2, 'max' => 101])) {
        $errors[] = "Job Title must be between 3 and 100 characters.";
    }

    //job_sector
    if (!has_presence($jobsector['jobsector_id'], "Select Sector")) {
        $errors[] = "Select a Job Sector";
    }

    // job_desc
    if (is_blank($job['job_desc'])) {
        $errors[] = "Job Description cannot be blank.";
    }

    //job_type
    if (!has_presence($jobtype['jobtype_id'], "Select Job Type")) {
        $errors[] = "Select a Job Type";
    }

    //job_rate
    if (!has_presence($jobrate['jobrate_id'], "Select Job Rate")) {
        $errors[] = "Select a Job Rate";
    }

// salary
    if (is_blank($job['salary'])) {
        $errors[] = "Salary cannot be blank.";
    // } elseif (!has_number($job['salary'])) {
    //     $errors[] = "Salary must be a number.";
    } elseif (!has_length($job['salary'], ['max' => 10])) {
        $errors[] = "Salary must be between 1 and 9 characters including decimal point";
    }

    //currency
    if (!has_presence($currency['currency_id'], "Select Currency")) {
        $errors[] = "Select a Currency";
    }

    //location
    if (is_blank($job['job_location'])) {
        $errors[] = "Location cannot be blank.";
    }

    // date ending
    // if (is_blank($job['date_ending'])) {
    //     $errors[] = "Job Date Ending cannot be blank.";
    // } elseif (!has_length($job['date_ending'], ['min' => 9, 'max' => 11])) {
    //     $errors[] = "Date must have 10 characters.";
    // } elseif(!has_valid_date($job['date_ending'])) {
    //    $errors[] = "Invalid date format entered.";
    // }

    // visible
    // Make sure we are working with a string
    // $visible_str = (string) $job['visible'];
    // if(!has_inclusion_of($visible_str, ["true","false"])) {
    //   $errors[] = "Visible must be true or false.";
    // }

    //lat
    // if(is_blank($job['lat'])) {
    //   $errors[] = "Latitude cannot be blank.";
    // }
    // elseif(!is_numeric($job['lat'])) {
    //   $errors[] = "Latitude data entered is not numeric.";
    // }
    // elseif(!has_length($job['lat'], ['min' => 8 , 'max' => 19])) {
    //   $errors[] = "Latitude must use at least 9 digits including decimal point.";
    // }
    // elseif(!has_valid_lat_coords($job['lat'])) {
    //   $errors[] = "Invalid Latitude entered.";
    // }

    //lng
    // if(is_blank($job['lng'])) {
    //   $errors[] = "Longitude cannot be blank.";
    // }
    // elseif(!is_numeric($job['lng'])) {
    //   $errors[] = "Longitude data entered is not numeric.";
    // }
    // elseif(!has_length($job['lng'], ['min' => 8 , 'max' => 19])) {
    //   $errors[] = "Longitude must use at least 9 digits including decimal point.";
    // }
    // elseif(!has_valid_lat_coords($job['lng'])) {
    //   $errors[] = "Invalid Longitude entered.";
    // }

    return $errors;
}


function insert_recruiter_job($job, $jobsector, $jobtype, $jobrate, $currency)
{
    global $db;

    $errors = validate_recruiter_job($job, $jobsector, $jobtype, $jobrate, $currency);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO jobs ";
    $sql .= "(company_id, recruiter_id, job_title, jobsector_id, job_desc, jobtype_id, salary, currency_id, jobrate_id, job_location, city, visible, lat, lng, location_status, date_ending) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $job['company_id']) . "',";
    $sql .= "'" . db_escape($db, $_SESSION['recruiter_id']) . "',";
    $sql .= "'" . db_escape($db, $job['job_title']) . "',";
    $sql .= "'" . db_escape($db, $jobsector['jobsector_id']) . "',";
    $sql .= "'" . db_escape($db, $job['job_desc']) . "',";
    $sql .= "'" . db_escape($db, $jobtype['jobtype_id']) . "',";
    $sql .= "'" . db_escape($db, $job['salary']) . "', ";
    $sql .= "'" . db_escape($db, $currency['currency_id']) . "', ";
    $sql .= "'" . db_escape($db, $jobrate['jobrate_id']) . "', ";
    $sql .= "'" . db_escape($db, $job['job_location']) . "',";
    $sql .= "'" . db_escape($db, $job['city']) . "',";
    $sql .= "'" . db_escape($db, $job['visible']) . "',";
    $sql .= "'" . db_escape($db, $job['lat']) . "',";
    $sql .= "'" . db_escape($db, $job['lng']) . "',";
    $sql .= "'" . db_escape($db, 1) . "',";
    $sql .= "'" . db_escape($db, $job['date_ending']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_recruiter_job($job, $jobsector, $jobtype, $jobrate, $currency)
{
    global $db;

    $errors = validate_recruiter_job($job, $jobsector, $jobtype, $jobrate, $currency);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE jobs SET ";
    $sql .= "company_id='" . db_escape($db, $job['company_id']) . "', ";
    $sql .= "jobsector_id='" . db_escape($db, $jobsector['jobsector_id']) . "', ";
    $sql .= "job_title='" . db_escape($db, $job['job_title']) . "', ";
    $sql .= "job_desc='" . db_escape($db, $job['job_desc']) . "', ";
    $sql .= "jobtype_id='" . db_escape($db, $jobtype['jobtype_id']) . "', ";
    $sql .= "salary='" . db_escape($db, $job['salary']) . "', ";
    $sql .= "currency_id='" . db_escape($db, $currency['currency_id']) . "', ";
    $sql .= "jobrate_id='" . db_escape($db, $jobrate['jobrate_id']) . "', ";
    $sql .= "job_location='" . db_escape($db, $job['job_location']) . "', ";
    $sql .= "city='" . db_escape($db, $job['city']) . "', ";
    $sql .= "lat='" . db_escape($db, $job['lat']) . "', ";
    $sql .= "lng='" . db_escape($db, $job['lng']) . "', ";
    $sql .= "date_ending='" . db_escape($db, $job['date_ending']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $job['job_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function validate_recruiter_job_location($job)
{
    $errors = [];

    // job_title
    // if (is_blank($job['job_title'])) {
    //     $errors[] = "Job Title cannot be blank.";
    // } elseif (!has_length($job['job_title'], ['min' >= 2, 'max' => 255])) {
    //     $errors[] = "Job Title must be between 2 and 255 characters.";
    // }

    //job_sector
    // if (!has_presence($jobsector['jobsector_id'], "Select Sector")) {
    //     $errors[] = "Please select a Job Sector";
    // }
    // $current_id = $job['id'] ?? '0';
    // if(!has_unique_job_menu_name($job['job_title'], $current_id)) {
    //   $errors[] = "Job Title  must be unique.";
    // }

    // job_desc
    // if (is_blank($job['job_desc'])) {
    //     $errors[] = "Job Description cannot be blank.";
    // }

    // salary
    // if (is_blank($job['salary'])) {
    //     $errors[] = "Salary cannot be blank.";
    // } elseif (!has_number($job['salary'])) {
    //     $errors[] = "Salary must be a number.";
    // } elseif (!has_length($job['salary'], ['min' >= 2, 'max' => 10])) {
    //     $errors[] = "Salary must be between 2 and 10 characters.";
    // }

    //location
    if (is_blank($job['job_location'])) {
        $errors[] = "Location cannot be blank.";
    }

    // visible
    // Make sure we are working with a string
    // $visible_str = (string) $job['visible'];
    // if(!has_inclusion_of($visible_str, ["true","false"])) {
    //   $errors[] = "Visible must be true or false.";
    // }

    //lat
    // if(is_blank($job['lat'])) {
    //   $errors[] = "Latitude cannot be blank.";
    // }
    // elseif(!is_numeric($job['lat'])) {
    //   $errors[] = "Latitude data entered is not numeric.";
    // }
    // elseif(!has_length($job['lat'], ['min' => 8 , 'max' => 19])) {
    //   $errors[] = "Latitude must use at least 9 digits including decimal point.";
    // }
    // elseif(!has_valid_lat_coords($job['lat'])) {
    //   $errors[] = "Invalid Latitude entered.";
    // }

    //lng
    // if(is_blank($job['lng'])) {
    //   $errors[] = "Longitude cannot be blank.";
    // }
    // elseif(!is_numeric($job['lng'])) {
    //   $errors[] = "Longitude data entered is not numeric.";
    // }
    // elseif(!has_length($job['lng'], ['min' => 8 , 'max' => 19])) {
    //   $errors[] = "Longitude must use at least 9 digits including decimal point.";
    // }
    // elseif(!has_valid_lat_coords($job['lng'])) {
    //   $errors[] = "Invalid Longitude entered.";
    // }

    return $errors;
}

function update_recruiter_job_location($job)
{
    global $db;

    $errors = validate_recruiter_job_location($job);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE jobs SET ";
    $sql .= "company_id='" . db_escape($db, $job['company_id']) . "', ";
    $sql .= "job_location='" . db_escape($db, $job['job_location']) . "', ";
    // $sql .= "visible='" . db_escape($db, $job['visible']) . "', ";
    $sql .= "lat='" . db_escape($db, $job['lat']) . "', ";
    $sql .= "lng='" . db_escape($db, $job['lng']) . "' ";
    // $sql .= "date_ending='" . db_escape($db, $job['date_ending']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $job['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//Google Map Functions
//gmaps_markers version
function add_gmaps_google_location()
{
    global $db;

    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $description = $_GET['description'];
    // Inserts new row with place data.
    $query = sprintf(
        "INSERT INTO locations " .
        " (id, lat, lng, description) " .
        " VALUES (NULL, '%s', '%s', '%s');",
        db_escape($db, $lat),
        db_escape($db, $lng),
        db_escape($db, $description)
    );

    $result = mysqli_query($db, $query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

function add_google_location()
{
    global $db;

    $co_id = $_GET['co_id'];
    $recId = $_SESSION['recruiter_id'];
    $jobTitle = $_GET['jobTitle'];
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    // $description = $_GET['description'];
    // Inserts new row with place data.
    $query = sprintf(
        "INSERT INTO jobs " .
        " (id, company_id, recruiter_id, job_title, lat, lng, location_status) " .
        " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '1');",
        db_escape($db, $co_id),
        db_escape($db, $recId),
        db_escape($db, $jobTitle),
        db_escape($db, $lat),
        db_escape($db, $lng)
    );

    $result = mysqli_query($db, $query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

function update_google_location()
{
    global $db;

    $job_id = $_GET['id'];
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    // Inserts new row with place data.
    $query = sprintf("UPDATE jobs SET lat = %s, lng = %s, location_status = 1 WHERE id = $job_id", $lat, $lng);

    $result = mysqli_query($db, $query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

function confirm_google_location()
{
    global $db;

    $location_id =$_GET['id'];
    $confirmed =$_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "UPDATE locations SET location_status = $confirmed WHERE id = $location_id ";
    $result = mysqli_query($db, $query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

//gmaps_markers version
function get_confirmed_gmaps_google_locations()
{
    global $db;

    $sql = mysqli_query($db, "SELECT id, lat, lng, description, location_status AS isconfirmed FROM locations WHERE location_status = 1");

    $rows = array();
    while ($r = mysqli_fetch_assoc($sql)) {
        $rows[] = $r;
    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function get_confirmed_google_locations($co_id)
{
    global $db;

    $sql = mysqli_query($db, "SELECT jobs.id, jobs.company_id, jobs.lat, jobs.lng, jobs.location_status AS isconfirmed, jobs.job_title FROM jobs INNER JOIN companies ON companies.id = jobs.company_id WHERE jobs.company_id='" . db_escape($db, $co_id) . "' AND jobs.location_status = 1");

    $rows = array();
    while ($r = mysqli_fetch_assoc($sql)) {
        $rows[] = $r;
    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function show_google_map($job_id)
{
    global $db;

    $sql = mysqli_query($db, "SELECT jobs.id, jobs.lat, jobs.lng, jobs.location_status AS isconfirmed, jobs.job_title FROM jobs WHERE jobs.id='" . db_escape($db, $job_id) . "' AND jobs.location_status = 1");

    $rows = array();
    while ($r = mysqli_fetch_assoc($sql)) {
        $rows[] = $r;
    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function get_all_google_locations()
{
    global $db;

    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db, "SELECT id, lat, lng, description, location_status AS isconfirmed FROM locations");

    $rows = array();
    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }
    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function get_all_job_locations()
{
    global $db;

    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db, "SELECT jobs.id, jobs.lat, jobs.lng, jobs.job_title, companies.company_name, jobs.job_location FROM jobs INNER JOIN companies ON companies.id=jobs.company_id");

    $rows = array();
    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }
    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function search_jobs()
{
    global $db;
    $search = h($_SESSION['search']);
    $location = h($_SESSION['location']);
    $rad = $_SESSION['rad_num'];
    $radius = get_rads($rad);
    $lat = 50.795276;
    $lng = -1.074379;
    $tbl_name = "jobs";


    // search jobs.
    $sql = "SELECT jobs.id AS job_id, jobs.visible, jobs.job_title, jobs.job_location, jobtypes.jobtype_name, jobs.salary, jobs.job_desc, jobs.date_created, DATEDIFF(CURDATE(), jobs.date_created), jobs.lat, jobs.lng, jobsectors.jobsector_name, companies.id, companies.company_name, companies.logo, companies.visible, ( 3959 * acos( cos( radians( {$lat} ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( {$lng} ) ) + sin( radians( {$lat} ) ) * sin( radians( lat ) ) ) ) AS distance FROM $tbl_name ";
    $sql .= "INNER JOIN companies ON companies.id=jobs.company_id ";
    $sql .= "INNER JOIN jobsectors ON jobsectors.id=jobs.jobsector_id ";
    $sql .= "INNER JOIN jobtypes ON jobtypes.id=jobs.jobtype_id ";
    $sql .= "WHERE (jobs.job_title LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "AND (jobs.job_location LIKE '%$location%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "OR (jobsectors.jobsector_name LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "AND (jobs.job_location LIKE '%$location%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "OR (company_name LIKE '%$search%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";
    $sql .= "AND (jobs.job_location LIKE '%$location%' AND companies.visible <> 'false' AND jobs.visible <> 'false') ";

    $sql .= "HAVING distance <= {$rad}";

    $rows = array();
    while ($r = mysqli_fetch_assoc($sql)) {
        $rows[] = $r;
    }
    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function array_flatten($array)
{
    if (!is_array($array)) {
        return false;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}

// Mapbox Functions
function add_location()
{
    global $db;
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];

    // Inserts new row with place data.
    $sql = "INSERT IGNORE INTO mapboxlocs ";
    $sql .= "(id, lat, lng) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, null) . "',";
    $sql .= "'" . db_escape($db, $lat) . "',";
    $sql .= "'" . db_escape($db, $lng) . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);

    if ($result) {
        return true;
        echo json_encode("Inserted Successfully");
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function get_saved_locations()
{
    global $db;
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db, "select lng,lat from mapboxlocs ");

    $rows = array();
    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }
    $indexed = array_map('array_values', $rows);

    //  $array = array_filter($indexed);
    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function show_job_location($job_id)
{
    global $db;

    $sql = "SELECT * FROM jobs ";
    $sql .= "WHERE id='" . db_escape($db, $job_id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

?>
