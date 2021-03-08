<?php require_once('../../../private/initialize.php');

if (is_logged_in()) {
    if ($_GET['co_id'] != ($_SESSION['co_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

$rec_id = $_SESSION['recruiter_id'];

if ($_GET['co_id'] != ($_SESSION['co_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($rec_id))));

} else {
    $co_id = $_GET['co_id'];
    $coImg = find_company_logo($rec_id);
    // echo $cv['status'];
    // exit;
    if ($coImg['logo_status'] != 1) {
        // $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($rec_id))));
    }
}

$rec_id = '';
$rec_id = $_SESSION['recruiter_id'];
$co_logo = $_SESSION['co_logo'];
// print_r($co_logo);
// exit;

$filename = "logos/".$co_logo."";
// print_r($filename);
// exit;

// $fileinfo = glob($filename); //glob is a function that goes and searches for a specific file that has part of the name we're looking for e.g. company_name.xxx

// $fileExt = explode(".", $fileinfo[0]);
// $fileActualExt = $fileExt[1];
// print_r($fileExt);
// exit;


// $file = "logos/".$co_logo.".".$fileExt;
// print_r($file);
// exit;

// $_SESSION['coImgFile'] = $file;
// $_SESSION['coImgFileName'] = $co_logo."";

// print_r($_SESSION['coImgFileName']);
// exit;

if(is_post_request()) {
    if (!unlink($filename)) {
        $_SESSION['message'] = 'Your logo was not deleted sucessfully.';
    } else {
        $_SESSION['message'] = 'Your logo was deleted sucessfully.';
    }
    $sql = "UPDATE companies SET logo_status=0, logo='no_company_logo.png' WHERE recruiter_id='$rec_id';";
    mysqli_query($db, $sql);
    // header("Location: index.php?deletesuccess");
    redirect_to(url_for('/jobmap/recruiters/companies/index.php?rec_id=' . $_SESSION['recruiter_id']));
}
?>

<?php $page_title = 'Delete Company Logo';?>
<?php include SHARED_PATH . '/public_header.php';?>

<div class="container">
    <div class="jumbotron border-red shadow">

        <h1>Delete company logo</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="text-uppercase"><b>You are about to delete your company logo.</b></h4>
                <p><b>Are you sure? </b>If not, please click Cancel now.</b></p>
                <p class="lead">Company logo to be deleted: <b><?php echo h($co_logo); ?></b></p>
            </div>
        </div>
        <form action="<?php echo url_for('/jobmap/recruiters/companies/delete_logo.php?co_id=' . h(u($co_id))); ?>" method="post">
            <a title="Cancel! Return to my company account" href="<?php echo url_for('/jobmap/recruiters/companies/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button title="Yes, I am sure. Please delete my company logo." type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete logo</button>
        </form>
    </div>
</div>

<?php include SHARED_PATH . '/public_footer.php';?>