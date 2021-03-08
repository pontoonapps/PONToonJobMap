<?php
// Reset token functions

// This function generates a string that can be
// used as a reset token.
function reset_token() {
	return md5(uniqid(rand()));
}

// Looks up a user and sets their reset_token to
// the given value. Can be used both to create and
// to delete the token.
function set_user_reset_token($email, $token_value) {
    $user = find_user_by_user_email(sql_prep($email));
    $recruiter = find_recruiter_by_recruiter_email(sql_prep($email));
    $admin = find_admin_by_admin_email(sql_prep($email));

    if($user) {
        $user['reset_token'] = $token_value;
        update_users_token($user);
        return true;
    }

    elseif($recruiter) {
        $recruiter['reset_token'] = $token_value;
        update_recruiters_token($recruiter);
        return true;
    }

    elseif($admin) {
        $admin['reset_token'] = $token_value;
        update_admins_token($admin);
        return true;
    }

    else {
        return false;
    }

}

// Add a new reset token to the user
function create_reset_token($email) {
    $token = reset_token();
    return set_user_reset_token($email, $token);
}

// Remove any reset token for this user.
function delete_reset_token($email) {
    $token = null;
    return set_user_reset_token($email, $token);
}

// Returns the recruiter record for a given reset token.
// If token is not found, returns null.
function find_admin_with_token($token)
{
    if (!has_presence($token)) {
        // We were expecting a token and didn't get one.
        return null;
    } else {
        $admin = find_admin_token(sql_prep($token));
        // Note: find_one_in_fake_db returns null if not found.
        return $admin;
    }
}

// Returns the recruiter record for a given reset token.
// If token is not found, returns null.
function find_recruiter_with_token($token) {
    if(!has_presence($token)) {
        // We were expecting a token and didn't get one.
        return null;
    } else {
        $recruiter = find_recruiter_token(sql_prep($token));
        // Note: find_one_in_fake_db returns null if not found.
        return $recruiter;
    }
}

// Returns the user record for a given reset token.
// If token is not found, returns null.
function find_user_with_token($token) {
    if(!has_presence($token)) {
        // We were expecting a token and didn't get one.
        return null;
    } else {
        $user = find_user_token(sql_prep($token));
        // Note: find_one_in_fake_db returns null if not found.
        return $user;
    }
}

function pa_email_reset_token($email) {
    $user = find_user_by_user_email(sql_prep($email));
    $recruiter = find_recruiter_by_recruiter_email(sql_prep($email));
    $admin = find_admin_by_admin_email(sql_prep($email));

 // User Reset password Email
    if ($user && isset($user['reset_token'])) {
        $token = $user['reset_token'];

        // Connect to emailer and send an email with a URL that includes the token
        $message = '';

        //LOCALHOST
        // $message = '
        // <h1>PONToon - Job Seeker - Password reset</h1>
        // <h3>Click the link below to reset your password</h3>
        // <h5><a href="http://pontoonapps.com_uk_dev_tracked.localhost/reset_user_password.php?token='.$token.'">Click here to reset your password</a></h5>
        // <p>If you did not make this request, you do not need to take any action. Your password cannot be changed without clicking the above link to verify the request.</p>';

        //PONTOONAPPSEU
        $message = '
        <center>
        <img src="https://pontoonapps.com/image/PONToon-logo-600.png" alt="PONToon logo">
        <p>You have recently requested to reset your password for your PONToonApps User Account. Click the button below to reset it.</P>
        <a href="https://pontoonapps.com/reset_user_password.php?token=' . $token . '"> 
            <button style="background-color:#E69911; border:none; padding:10px; border-radius:4px; color:white;"> Click here to reset your password </button>
        </a>
        <p>If you did not request this password reset please ignore this email as your password cannot be changed without clicking the link. 
        <br></br>
        <br>Thank you,</br> 
        <br>The PONToon Team </br>
        <br></br>
        </p>
        <p><i><a href="https://pontoonapps.com/reset_user_password.php?token=' . $token . '">If you are having trouble clicking the password reset button press here.</a></i></p>
        <img src="https://pontoonapps.com/image/partner-logos.png" width="50%" alt="PONToon partner logos">
        </center>';

        //Localhost XAMPP PEAR Server Settings
        // require_once "Mail.php";
        // include('Mail\mime.php');

        //PONTOONAPPSEU PEAR Server Settings
        ini_set("include_path", '/soul/home/pontoonapps/php:' . ini_get("include_path"));
        require_once "/soul/home/pontoonapps/php/Mail.php";
        include '/soul/home/pontoonapps/php/Mail/mime.php';

        //LOCALHOST
        // $host = "ssl://smtp.gmail.com";

        //PONTOONAPPSEU
        $host = "ssl://pontoonapps.com";

        $port = "465";

        //LOCALHOST
        // $username = "lihoujason@gmail.com";

        //PONTOONAPPSEU
        $username = "no-reply@pontoonapps.com";

        //LOCALHOST
        // $password = "gzs4V&o9#%b@";

        //PONTOONAPPSEU
        $password = "wMt=f~V#D64O";

        $to = $user['email'];

        // $cc = $_SESSION['user_email'];

        $recipients = $to;
        // $recipients = $to.",".$cc;

        $headers['From'] = 'PONToonApps <no-reply@pontoonapps.com>';
        $headers['To'] = $to;
        $headers['Subject'] = 'PONToon Apps Password Reset - User';
        // $headers['Cc']        = $_SESSION['user_email'];
        // $headers['Reply-To'] = $_SESSION['rec_email'];

        //  $subject = "Test email using PHP SMTP with SSL\r\n\r\n";

        // $headers = array ('From' => $from, 'To' => $to, 'Cc' => $cc, 'Subject' => $subject);

        $html = $message;
        // $file = $path;

        $crlf = "\n";
        $mime = new Mail_mime($crlf);
        $mime->setHTMLBody($html);
        // $mime->addAttachment($file);

        $body = $mime->get();
        $headers = $mime->headers($headers, true);

        $smtp = Mail::factory('smtp',
            array(
                'host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password,
            )
        );

        $mail = $smtp->send($recipients, $headers, $body, $message);

        if (PEAR::isError($mail)) {
            echo ("<p>" . $mail->getMessage() . "</p>");
        } else {
            // insert_user_job();
            // user_job_app_sent();
            // echo("<p>Message successfully sent!</p>");
            $_SESSION['message'] = 'Thank you. Please check your email and click on the link provided to reset your password.';
            redirect_to(url_for('/password_reset_requested.php'));
        }
        return true;
    }

// Recruter Reset Password

    if ($recruiter && isset($recruiter['reset_token'])) {
        $token = $recruiter['reset_token'];

        // Connect to emailer and send an email with a URL that includes the token
        $message = '';

        //LOCALHOST
        // $message = '
        // <h1>PONToon - Recruiter - Password reset</h1>
        // <h3>Click the link below to reset your password</h3>
        // <h5><a href="http://pontoonapps.com_uk_dev_tracked.localhost/reset_rec_password.php?token='.$token.'">Click here to reset your password</a></h4>
        // <p>If you did not make this request, you do not need to take any action. Your password cannot be changed without clicking the above link to verify the request.</p>';

        //PONTOONAPPSEU
        $message = '
        <center>
        <img src="https://pontoonapps.com/image/PONToon-logo-600.png" alt="PONToon logo">
        <p>You have recently requested to reset your password for your PONToonApps Recruiter Account. Click the button below to reset it.</P>
        <a href="https://pontoonapps.com/reset_rec_password.php?token=' . $token . '"> 
            <button style="background-color:#E8491F; border:none; padding:10px; border-radius:4px; color:white;"> Click here to reset your password </button>
        </a>
        <p>If you did not request this password reset please ignore this email as your password cannot be changed without clicking the link. 
        <br></br>
        <br>Thank you,</br> 
        <br>The PONToon Team </br>
        <br></br>
        </p>
        <p><i><a href="https://pontoonapps.com/reset_rec_password.php?token=' . $token . '">If you are having trouble clicking the password reset button press here.</a></i></p>
        <img src="https://pontoonapps.com/image/partner-logos.png" width="50%" alt="PONToon partner logos">
        </center>
        ';

        //Localhost XAMPP PEAR Server Settings
        // require_once "Mail.php";
        // include('Mail\mime.php');

        //PONTOONAPPSEU PEAR Server Settings
        ini_set("include_path", '/soul/home/pontoonapps/php:' . ini_get("include_path"));
        require_once "/soul/home/pontoonapps/php/Mail.php";
        include '/soul/home/pontoonapps/php/Mail/mime.php';

        //LOCALHOST
        // $host = "ssl://smtp.gmail.com";

        //PONTOONAPPSEU
        $host = "ssl://pontoonapps.com";

        $port = "465";

        //LOCALHOST
        // $username = "lihoujason@gmail.com";

        //PONTOONAPPSEU
        $username = "no-reply@pontoonapps.com";

        //LOCALHOST
        // $password = "gzs4V&o9#%b@";

        //PONTOONAPPSEU
        $password = "wMt=f~V#D64O";

        $to = $recruiter['email'];

        // $cc = $_SESSION['user_email'];

        $recipients = $to;
        // $recipients = $to.",".$cc;

        $headers['From'] = 'PONToonApps <no-reply@pontoonapps.com>';
        $headers['To'] = $to;
        $headers['Subject'] = 'PONToon Apps Password Reset - Recruiter';
        // $headers['Cc']        = $_SESSION['user_email'];
        // $headers['Reply-To'] = $_SESSION['rec_email'];

        //  $subject = "Test email using PHP SMTP with SSL\r\n\r\n";

        // $headers = array ('From' => $from, 'To' => $to, 'Cc' => $cc, 'Subject' => $subject);

        $html = $message;
        // $file = $path;

        $crlf = "\n";
        $mime = new Mail_mime($crlf);
        $mime->setHTMLBody($html);
        // $mime->addAttachment($file);

        $body = $mime->get();
        $headers = $mime->headers($headers, true);

        $smtp = Mail::factory('smtp',
            array(
                'host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password,
            )
        );

        $mail = $smtp->send($recipients, $headers, $body, $message);

        if (PEAR::isError($mail)) {
            echo ("<p>" . $mail->getMessage() . "</p>");
        } else {
            // insert_user_job();
            // user_job_app_sent();
            // echo("<p>Message successfully sent!</p>");
            $_SESSION['message'] = 'Thank you. Please check your email and click on the link provided to reset your password.';
            redirect_to(url_for('/password_reset_requested.php'));
        }
        return true;
    }

    if ($admin && isset($admin['reset_token'])) {
        $token = $admin['reset_token'];

        // Connect to emailer and send an email with a URL that includes the token
        $message = '';

        //LOCALHOST
        // $message = '
        // <h1>PONToon - Recruiter - Password reset</h1>
        // <h3>Click the link below to reset your password</h3>
        // <h5><a href="http://pontoonapps.com_uk_dev_tracked.localhost/reset_admin_password.php?token='.$token.'">Click here to reset your password</a></h4>
        // <p>If you did not make this request, you do not need to take any action. Your password cannot be changed without clicking the above link to verify the request.</p>';

        //PONTOONAPPSEU
        $message = '
        <h1>PONToon - Job Seekers - Recruiter Password reset</h1>
        <h3>Click the link below to reset your password</h3>
        <h5><a href="https://pontoonapps.com/reset_admin_password.php?token=' . $token . '">Click here to reset your password</a></h4>
        <p>If you did not make this request, you do not need to take any action. Your password cannot be changed without clicking the above link to verify the request.</p>';

        //Localhost XAMPP PEAR Server Settings
        // require_once "Mail.php";
        // include('Mail\mime.php');

        //PONTOONAPPSEU PEAR Server Settings
        ini_set("include_path", '/soul/home/pontoonapps/php:' . ini_get("include_path"));
        require_once "/soul/home/pontoonapps/php/Mail.php";
        include '/soul/home/pontoonapps/php/Mail/mime.php';

        //LOCALHOST
        // $host = "ssl://smtp.gmail.com";

        //PONTOONAPPSEU
        $host = "ssl://pontoonapps.com";

        $port = "465";

        //LOCALHOST
        // $username = "lihoujason@gmail.com";

        //PONTOONAPPSEU
        $username = "no-reply@pontoonapps.com";

        //LOCALHOST
        // $password = "gzs4V&o9#%b@";

        //PONTOONAPPSEU
        $password = "wMt=f~V#D64O";

        $to = $admin['email'];

        // $cc = $_SESSION['user_email'];

        $recipients = $to;
        // $recipients = $to.",".$cc;

        $headers['From'] = 'PONToon - Job Seekers <no-reply@pontoonapps.com>';
        $headers['To'] = $to;
        $headers['Subject'] = 'PONToon - Job Seekers - Admin Password reset';
        // $headers['Cc']        = $_SESSION['user_email'];
        // $headers['Reply-To'] = $_SESSION['rec_email'];

        //  $subject = "Test email using PHP SMTP with SSL\r\n\r\n";

        // $headers = array ('From' => $from, 'To' => $to, 'Cc' => $cc, 'Subject' => $subject);

        $html = $message;
        // $file = $path;

        $crlf = "\n";
        $mime = new Mail_mime($crlf);
        $mime->setHTMLBody($html);
        // $mime->addAttachment($file);

        $body = $mime->get();
        $headers = $mime->headers($headers, true);

        $smtp = Mail::factory('smtp',
        array(
        'host' => $host,
        'port' => $port,
        'auth' => true,
        'username' => $username,
        'password' => $password,
        )
        );

        $mail = $smtp->send($recipients, $headers, $body, $message);

        if (PEAR::isError($mail)) {
        echo ("<p>" . $mail->getMessage() . "</p>");
        } else {
        // insert_user_job();
        // user_job_app_sent();
        // echo("<p>Message successfully sent!</p>");
        $_SESSION['message'] = 'Thank you. Please check your email and click on the link provided to reset your password.';
        redirect_to(url_for('/password_reset_requested.php'));
        }
        return true;
    }
}

?>