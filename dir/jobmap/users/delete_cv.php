<?php require_once('../../private/initialize.php');

require_user_login();

// DURING DEMO ADD PREFIX 'DEMO' to $_SESSION TO PREVENT ACCOUNT FROM BEING DELETED!!
if ($_GET['user_id'] != ($_SESSION['user_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
redirect_to(url_for('/jobmap/users/index.php'));
} else {
    $user_id = $_GET['user_id'];
    $user = find_user_by_id($user_id);
    $cv = find_user_cv($user_id);
    // echo $cv['status'];
    // exit;
    if ($cv['status'] != 1) {
        // $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/users/index.php?user_id='.h(u($user_id))));
    }
}

if (isset($_GET['job_id'])){
    $jobId = $_GET['job_id'];
}
else{
}

$user_id = '';
$user_id = $_SESSION['user_id'];
$fullName = $user['first_name'].$user['last_name'];

$filename = "uploads/cvs/cv".$user_id."-".$fullName."*";
$fileinfo = glob($filename); //glob is a function that goes and searches for a specific file that has part of the name we're looking for e.g. cv1.xxx
$fileExt = explode(".", $fileinfo[0]);
$fileActualExt = $fileExt[1];

$file = "uploads/cvs/cv" . $user_id . "-" . $fullName . "." . $fileActualExt;
$_SESSION['cvFile'] = $file;
$_SESSION['cvFileName'] = $user_id . "-" . $fullName . "." . $fileActualExt;

if(is_post_request()) {

    if (!unlink($_SESSION['cvFile'])) {
        $_SESSION['message'] = 'Your CV was not deleted successfully.';
    } else {
        $_SESSION['message'] = 'Your CV was deleted successfully.';
    }

    $sql = "UPDATE usercvs SET status=0, cv_name='no-cv.png' WHERE userid='$user_id';";
    mysqli_query($db, $sql);
    // header("Location: index.php?deletesuccess");
    if(!isset($_GET['job_id'])){
        redirect_to(url_for('/jobmap/users/index.php?user_id=' . $user_id));
    }
    else {
        redirect_to(url_for('/jobmap/apply_now.php?job_id=' . $jobId));
    }
}
?>

<?php $page_title = 'Delete CV';?>
<?php include SHARED_PATH . '/public_header.php';?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Delete CV</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="text-uppercase">You are about to delete your CV. <b>Are you sure?</b></h4>
                <p><b>If not, please click Cancel now.</b></p>
                <p class="lead">CV to be deleted: <b>cv<?php echo h($_SESSION['cvFileName']); ?></b></p>
            </div>
        </div>
        <form action="<?php echo url_for('/jobmap/users/delete_cv.php?user_id=' . h(u($user_id))); ?>" method="post">
            <a title="Cancel! Go back to my account" href="<?php echo url_for('/jobmap/users/index.php?user_id=' . h(u($user_id))); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button title="Yes, I am sure. Delete my CV." type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete CV</button>
        </form>
    </div>
</div>

<?php include SHARED_PATH . '/public_footer.php';?>