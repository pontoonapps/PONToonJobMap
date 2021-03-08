<?php
if (!isset($page_title)) {$page_title = 'Your search for a job';
} ?>

<!doctype html>
<html lang="en">
<head>
    <title>PONToon Job Map <?php if (isset($page_title)) {echo '- ' . h($page_title);}?></title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo url_for('/jobmap/images/icons/apple-touch-icon.png?v=eEGwWW8YGO'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo url_for('/jobmap/images/icons/favicon-32x32.png?v=eEGwWW8YGO'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo url_for('/jobmap/images/icons/favicon-16x16.png?v=eEGwWW8YGO'); ?>">
    <link rel="manifest" href="<?php echo url_for('/jobmap/images/icons/site.webmanifest?v=eEGwWW8YGO'); ?>">
    <link rel="mask-icon" href="<?php echo url_for('/jobmap/images/icons/safari-pinned-tab.svg?v=eEGwWW8YGO'); ?>" color="#ff8a00">
    <link rel="shortcut icon" href="<?php echo url_for('/jobmap/images/icons/favicon.ico?v=eEGwWW8YGO'); ?>" type="image/x-icon" />
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="theme-color" content="#ffffff">

    <style>
    body {position: static !important; top:0px !important;}
    </style>

    <!--Bootstrap Stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--Font Awesome -->
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script> -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!--Active Menu Links -->
    <script>
    window.onload=function(){
    $('a[href="' + this.location.pathname + '"]').parents('li,ul').addClass('active');
    }
    </script>

    <!--jQuery auto-complete Stylesheet -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-maxlength/1.7.0/bootstrap-maxlength.min.js"></script>

    <!-- Cookies Management -->
    <!-- <script src="js/cookie.js"></script> -->

    <!-- Translation -->
    <!-- <script src="js/jquery.translate.js"></script>
    <script src="js/dictionnary.js"></script> -->

    <!--Javascript Files for Auto-complete -->
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>

    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
    rel="stylesheet" type="text/css" />

    <!-- PONToon Style Guide Styles -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'>

    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet'>

    <!-- Map & Sidebar Custom Styles -->
    <link rel="stylesheet" media="all" href="<?php echo url_for('/jobmap/stylesheets/job_locations_map_styles.css'); ?>" />

    <!-- JSA Custom Styles -->
    <link rel="stylesheet" media="all" href="<?php echo url_for('/jobmap/stylesheets/jseeker_custom.css'); ?>" />

</head>
<body style="background: white; overflow-y:hidden;">
    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-bg-orange fixed-top shadow">
        <a class="navbar-brand" href="<?php echo url_for('/index.php'); ?>">
        <img src="<?php echo url_for('/jobmap/images/PONToon-logo-119x28-white.png'); ?>" width="119" height="28" alt="PONToon" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url_for('/jobmap/index.php'); ?>"><i class="fas fa-map fa-lg mr-2"></i>Map</a>
                </li>

                <?php if (is_logged_in()) {?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#0" id="adminNavbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tachometer-alt fa-lg mr-2"></i>Management</a>
                        <div class="dropdown-menu" aria-labelledby="adminNavbarDropdown">
                            <a class="dropdown-item" href="<?php echo url_for('/jobmap/staff/admins/user_accounts.php'); ?>">User Accounts</a>
                            <!-- <a class="dropdown-item" href="<?php //echo url_for('/jobmap/staff/companies/index.php'); ?>">Companies & Jobs</a> -->
                            <a class="dropdown-item" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/index.php'); ?>">Job Sectors</a>
                            <a class="dropdown-item" href="<?php echo url_for('/jobmap/staff/jobs/jobtypes/index.php'); ?>">Job Types</a>
                            <a class="dropdown-item" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/index.php'); ?>">Job Rates</a>
                            <a class="dropdown-item" href="<?php echo url_for('/jobmap/staff/admins/admin_map.php'); ?>">Jobs Map</a>
                        </div>
                    </li>
                <?php }
                else if (is_recruiter_logged_in()) {?>
                  <li class="nav-item">
                    <a class='nav-link' href="<?php echo url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>"><i class="fas fa-user-alt fa-lg mr-2"></i>My Account</a>
                </li>
                    <?php }
                else if (is_user_logged_in()) {?>
                  <li class="nav-item">
                    <a class='nav-link' href="<?php echo url_for('/users/index.php?user_id='.h(u($_SESSION['user_id']))); ?>"><i class="fas fa-user-alt fa-lg mr-2"></i>My Account</a>
                </li>
                <?php }
                else {?>
                  <li class="nav-item">
                    <a class='nav-link' href="<?php echo url_for('/login.php'); ?>"><i class="fas fa-sign-in-alt fa-lg mr-2"></i>Log In</a>
                </li>
                <?php }?>
                <li class="nav-item">
                    <?php if (is_logged_in()) {?>
                        <a class='nav-link' href="<?php echo url_for('/jobmap/staff/logout.php'); ?>"><i class="fas fa-sign-out-alt fa-lg mr-2"></i>Log Out</a>
                    <?php }
                    else if (is_recruiter_logged_in()) {?>
                        <a class='nav-link' href="<?php echo url_for('/recruiters/logout.php'); ?>"><i class="fas fa-sign-out-alt fa-lg mr-2"></i>Log Out</a>
                    <?php }
                    else if (is_user_logged_in()) {?>
                        <a class='nav-link' href="<?php echo url_for('/users/logout.php'); ?>"><i class="fas fa-sign-out-alt fa-lg mr-2"></i>Log Out</a>
                    <?php }?>
                </li>
                <?php if (!is_user_logged_in() && !is_recruiter_logged_in()) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url_for('/signup.php'); ?>"><i class="fas fa-user-plus fa-lg mr-2"></i> Sign Up </a>
                    </li>
                <?php } else {
                //don't show sign up
                }?>
                <li class="nav-item">
                      <?php  if (is_recruiter_logged_in()) {?>
                        <a class='nav-link' href="<?php echo url_for('jobmap/recruiters/companies/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>"><i class="fas fa-tasks fa-lg mr-2"></i>Manage Jobs</a>
                    <?php }
                    else if (is_user_logged_in()) {?>
                        <a class='nav-link' href="<?php echo url_for('jobmap/users/index.php?user_id='.h(u($_SESSION['user_id']))); ?>"><i class="fas fa-star fa-lg mr-2"></i>My Saved Jobs</a>
                    <?php }?>
                </li>
            </ul>
            <!-- <button id="translate" title="Toggle En/Fr" class="btn btn-outline-pt-orange" type="button"><i class="fas fa-language fa-lg"></i></button> -->
            <!-- Google Translation menu scripts-->
            <div id="google_translate_element" class="mr-4"></div>
                <script>
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,fr',  layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
                }
                </script>
                <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            <!-- Job Map logo -->
            <a class="navbar-brand ml-4" href="<?php echo url_for('/jobmap/index.php'); ?>">
            <img src="<?php echo url_for('/jobmap/images/job-map-icon-sml.png'); ?>" width="73" height="54" alt="Job Map logo" /></a>
        </div>
    </nav>
