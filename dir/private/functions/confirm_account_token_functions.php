<?php
// Reset token functions

// This function generates a string that can be
// used as an email token.
function email_token() {
	return md5(uniqid(rand()));
}

// Looks up an admin and sets their email_token to
// the given value. Can be used both to create and
// to delete the token.
function set_admin_email_token($email, $token_value)
{
    $admin = find_admin_by_admin_email(sql_prep($email));

    if ($admin) {
        $admin['email_token'] = $token_value;
        update_admin_email_token($admin);
        return true;
    } else {
        return false;
    }
}

// Looks up a recruiter and sets their email_token to
// the given value. Can be used both to create and
// to delete the token.
function set_recruiter_email_token($email, $token_value) {
    $recruiter = find_recruiter_by_recruiter_email(sql_prep($email));

    if($recruiter) {
        $recruiter['email_token'] = $token_value;
        update_recruiter_email_token($recruiter);
        return true;
    } else {
        return false;
    }
}

// Looks up a user by their new id and sets their email_token to
// the given value. Can be used both to create and
// to delete the token.
function set_user_email_token($email, $token_value) {
    $user = find_user_by_user_email(sql_prep($email));

    if($user) {
        $user['email_token'] = $token_value;
        update_user_email_token($user);
        return true;
    } else {
        return false;
    }
}

// Add a new email token to the admin from admin email
function create_admin_email_token($email)
{
    $token = email_token();
    return set_admin_email_token($email, $token);
}

// Add a new email token to the recruiter from recruiter email
function create_recruiter_email_token($email) 
{
    $token = email_token();
    return set_recruiter_email_token($email, $token);
}

// Add a new email token to the user from user email
function create_user_email_token($email)
{
    $token = email_token();
    return set_user_email_token($email, $token);
}

// Remove any email token for this admin.
function delete_admin_email_token($email)
{
 $token = null;
 return set_admin_email_token($email, $token);
}

// Remove any email token for this recruiter.
function delete_recruiter_email_token($email) {
    $token = null;
    return set_recruiter_email_token($email, $token);
}

// Remove any email token for this user.
function delete_user_email_token($email) {
    $token = null;
    return set_user_email_token($email, $token);
}

// Returns the admin record for a given email token.
// If token is not found, returns null.
function find_admin_with_email_token($token)
{
    if (!has_presence($token)) {
        // We were expecting a token and didn't get one.
        return null;
    } else {
        $admin = find_admin_email_token(sql_prep($token));
        // Note: returns null if not found.
        return $admin;
    }
}

// Returns the recruiter record for a given email token.
// If token is not found, returns null.
function find_recruiter_with_email_token($token) {
    if(!has_presence($token)) {
        // We were expecting a token and didn't get one.
        return null;
    } else {
        $recruiter = find_recruiter_email_token(sql_prep($token));
        // Note: returns null if not found.
        return $recruiter;
    }
}

// Returns the user record for a given email token.
// If token is not found, returns null.
function find_user_with_email_token($token) {
    if(!has_presence($token)) {
    // We were expecting a token and didn't get one.
        return null;
    } else {
        $user = find_user_email_token(sql_prep($token));
        // Note: returns null if not found.
        return $user;
	}
}

// A function to email the email token to the email
// address on file for these users
// when registering from PONToon EU
function pa_email_email_token($email)
{
    $user = find_user_by_user_email(sql_prep($email));
    $recruiter = find_recruiter_by_recruiter_email(sql_prep($email));
    $admin = find_admin_by_admin_email(sql_prep($email));

    if ($user && isset($user['email_token'])) {
        $token = $user['email_token'];

        // Connect to emailer and send an email with a URL that includes the token
        $message = '';

        //LOCALHOST
        // $message = '
        // <h1>Thank you for registering your account with us!</h1>
        // <h3>To complete the registration process, please click the link below to confirm your email address</h3>
        // <h5><a href="http://pontoonapps.com_uk_dev_tracked.localhost/confirm_jobseeker_email.php?token='.$token.'">Click here to confirm your email address</a></h4>';

        //PONTOONAPPSEU User Registration
        $message = '
        <center>
        <img src="https://pontoonapps.com/image/PONToon-logo-600.png" alt="PONToon logo">
        <p>Thank you for registering your account with PONToon Apps!</p>
        <p>To complete your registration, please click the button below to confirm your email address</p>
        <a href="https://pontoonapps.com/confirm_jobseeker_email.php?token=' . $token . '">
        <button style="background-color:#E69911; border:none; padding:10px; border-radius:4px; color:white;"> Click here to confirm your email. </button>
        </a>
        <p> If you did not request this email, please let us know at pontoon@port.ac.uk</p> 
        <br></br>
        Thank you,
        The PONToon Team
        <br></br>
        <p><i><a href="https://pontoonapps.com/confirm_jobseeker_email.php?token=' . $token . '">If the button does not work, click here</a></i></p>
        <img src="https://pontoonapps.com/image/partner-logos.png" width="50%" alt="PONToon partner logos">
        </center>
        ';

        //Localhost XAMPP PEAR Server Settings
        // require_once "Mail.php";
        // include 'Mail\mime.php';

        //PONTOONAPPSEU PEAR Server Settings
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

        $headers['From'] = 'PONToonApp <no-reply@pontoonapps.com>';
        $headers['To'] = $to;
        $headers['Subject'] = 'PONToon Apps - User Registration';
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
            $_SESSION['message'] = 'Thank you for registering with us! Please check your email and click on the link provided to confirm your email address.';
            redirect_to(url_for('/signup_thankyou.php'));
        }
        return true;
    } //else {
    // return false;
    // }

    if ($recruiter && isset($recruiter['email_token'])) {
        $token = $recruiter['email_token'];

        // Connect to emailer and send an email with a URL that includes the token
        $message = '';

        //LOCALHOST
        // $message = '
        // <h1>Thank you for registering your recruiter account with us!</h1>
        // <h3>To complete the registration process, please click the link below to confirm your email address</h3>
        // <h5><a href="http://pontoonapps.com_uk_dev_tracked.localhost/confirm_recruiter_email.php?token=' . $token . '">Click here to confirm your email address</a></h5>';
        //<h1>Thank you for registering your recruiter account with us!</h1>
        //<h3>To complete the registration process, please click the link below to confirm your email address</h3>
        //<h5><a href="https://pontoonapps.com/confirm_recruiter_email.php?token=' . $token . '">Click here to confirm your email address</a></h5>
     
        //PONTOONAPPSEU Recruiter Confirm
        $message = '
        
        <center>
        <img src="https://pontoonapps.com/image/PONToon-logo-600.png" alt="PONToon logo">
        <p>Thank you for registering your account with PONToon Apps!</p>
        <p>To complete your registration, please click the button below to confirm your email address</p>
        <a href="https://pontoonapps.com/confirm_recruiter_email.php?token=' . $token . '">
        <button style="background-color:#E8491F; border:none; padding:10px; border-radius:4px; color:white;"> Click here to confirm your email. </button>
        </a>
        <p> If you did not request this email, please let us know at pontoon@port.ac.uk</p> 
        <br></br>
        Thank you,
        The PONToon Team
        <br></br>
        <p><i><a href="https://pontoonapps.com/confirm_recruiter_email.php?token=' . $token . '">If the button does not work, click here</a></i></p>
        <img src="https://pontoonapps.com/image/partner-logos.png" width="50%" alt="PONToon partner logos">
        </center>
        ';

        //Localhost XAMPP PEAR Server Settings
        // require_once "Mail.php";
        // include('Mail\mime.php');

        //PONTOONAPPSEU PEAR Server Settings
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
        $headers['Subject'] = 'PONToon - Recruiter Registration';
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
            //pear throwing a syntax error for a missing bracket or quotation. error was not found so it temporarily redirects to the thank you page instead of showing the error message.
            echo ("<p>" . $mail->getMessage() . "</p>");
            //$_SESSION['message'] = 'Thank you for registering your recruiter account with us! Please click Log In and enter the details you just provided.';
            //redirect_to(url_for('/signup_thankyou.php'));
        } else {
            $_SESSION['message'] = 'Thank you for registering with us! Please check your email and click on the link provided to confirm your email address.';
            redirect_to(url_for('/signup_thankyou.php'));
        }
        return true;
    } //else {
    //return false;
    //}

    if ($admin && isset($admin['email_token'])) {
        $token = $admin['email_token'];

        // Connect to emailer and send an email with a URL that includes the token
        $message = '';

        //LOCALHOST
        // $message = '
        // <h1>Thank you for registering your admin account with us!</h1>
        // <h3>To complete the registration process, please click the link below to confirm your email address</h3>
        // <h5><a href="http://pontoonapps.eu_uk_dev_tracked.localhost/confirm_admin_email.php?token=' . $token . '">Click here to confirm your email address</a></h5>';

        //PONTOONAPPSEU
        $message = '
        <h1>Thank you for registering your admin account with us!</h1>
        <h3>To complete the registration process, please click the link below to confirm your email address</h3>
        <h5><a href="https://pontoonapps.com/confirm_admin_email.php?token=' . $token . '">Click here to confirm your email address</a></h5>';

        //Localhost XAMPP PEAR Server Settings
        // require_once "Mail.php";
        // include('Mail\mime.php');

        //PONTOONAPPSEU PEAR Server Settings
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

        $headers['From'] = 'PONToon - JobMap <no-reply@pontoonapps.com>';
        $headers['To'] = $to;
        $headers['Subject'] = 'PONToon - JobMap - Admin Registration - Confirm Email Account';
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
            $_SESSION['message'] = 'Thank you for registering your admin account with us! Please check your email and click on the link provided to confirm your email address.';
            redirect_to(url_for('/signup_thankyou.php'));
        }
        return true;
    } //else {
        //return false;
    //}
}

?>