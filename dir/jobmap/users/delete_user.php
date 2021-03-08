<?php require_once('../../private/initialize.php');

require_user_login();

// DURING DEMO ADD PREFIX 'DEMO' to $_SESSION TO PREVENT ACCOUNT FROM BEING DELETED!!
if($_GET['user_id'] != ($_SESSION['user_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/users/index.php'));
}
$user_id = $_GET['user_id'];


if(is_post_request()) {
    $user_id = $_SESSION['user_id'];
    $fullName = $_SESSION['first_name'].$_SESSION['last_name'];

    //Delete User CV
    $cvFilename = "uploads/cvs/cv".$user_id."-".$fullName."*";
    $cvFileinfo = glob($cvFilename); //glob is a function that goes and searches for a specific file that has part of the name we're looking for e.g. cv1.xxx
    $cvFileExt = explode(".", $cvFileinfo[0]);
    $cvFileActualExt = $cvFileExt[1];

    $cvFile = "uploads/cvs/cv".$user_id."-".$fullName.".".$cvFileActualExt;

    // print_r($cvFile);
    // exit;
    unlink($cvFile);
    if (!unlink($cvFile)) {
        $_SESSION['message'] = 'Your CV was not deleted sucessfully.';
    } else {
        $_SESSION['message'] = 'Your CV was deleted sucessfully.';
    }
    $sql = "UPDATE usercvs SET status=0, cv_name='no-cv.png' WHERE userid='$user_id';";
    mysqli_query($db, $sql);


    //Delete User Profile Image
    $pimgFilename = "uploads/profile_imgs/pimg".$user_id."-".$fullName."*";
    $pimgFileinfo = glob($pimgFilename); //glob is a function that goes and searches for a specific file that has part of the name we're looking for e.g. cv1.xxx
    $pimgFileExt = explode(".", $pimgFileinfo[0]);
    $pimgFileActualExt = $pimgFileExt[1];

    $pimgFile = "uploads/profile_imgs/pimg".$user_id."-".$fullName.".".$pimgFileActualExt;

    // print_r($pimgFile);
    // exit;
    unlink($pimgFile);
    if (!unlink($_SESSION['pimgFile'])) {
        $_SESSION['message'] = 'Your profile image was not deleted sucessfully.';
    } else {
        $_SESSION['message'] = 'Your profile image was deleted sucessfully.';
    }
    $sql = "UPDATE users SET profile_img_status=0, profile_img='no_profile_img.png' WHERE id='$user_id';";
    mysqli_query($db, $sql);

    $result = disable_user($user_id);
    // $result = delete_user($user_id);
    log_out_user();
    redirect_to(url_for('/jobmap/farewell.php?cu=goodbye'));
} else {
    $user = find_user_by_id($user_id);
}
?>

<?php $page_title = 'Delete User'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Delete Account</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="text-uppercase"><b>You are about to delete your account.</b></h4>
                <p>If you've saved any jobs or uploaded a CV, these will also be removed. <b>Are you sure? </b>If not, please click Cancel now.</p>
                <p class="lead">The account to be deleted is: <b><?php echo h($user['first_name'] . ' ' .$user['last_name']); ?></b></p>
            </div>
        </div>
        <form action="<?php echo url_for('/jobmap/users/delete_user.php?user_id=' . h(u($user['id']))); ?>" method="post">
            <a title="Cancel! Go back to my account" href="<?php echo url_for('/jobmap/users/index.php?user_id='.h(u($user['id']))); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button title="Yes, I am sure. Please delete my account." type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete account</button>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
