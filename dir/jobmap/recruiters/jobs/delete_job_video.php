<?php require_once '../../../private/initialize.php';

if (is_logged_in()) {
    if (!isset($_GET['job_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

$job_id = $_GET['job_id'];

if (!isset($_GET['job_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
}

$job = find_job_vid_by_id($job_id);

if (is_logged_in()) {
    if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
} else {
    if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/recruiters/index.php?rec_id=' . h(u($_SESSION['recruiter_id']))));
    }
}

if(is_post_request()) {

    // $filename = "videos/".$job_id."-".$jobTitle."*";
    // $fileinfo = glob($filename); //glob is a function that goes and searches for a specific file that has part of the name we're looking for e.g. company_name.xxx
    // $fileExt = explode(".", $fileinfo[0]);
    // $fileActualExt = $fileExt[1];

    $file = "videos/".$job['video_filename'];

    if (!unlink($file)) {
        $_SESSION['message'] = 'Your video was not deleted sucessfully.';
    } else {
        $_SESSION['message'] = 'Your video was deleted sucessfully.';
    }

    $sql = "DELETE FROM job_videos WHERE job_id='$job_id';";
    mysqli_query($db, $sql);
    // header("Location: index.php?deletesuccess");
    redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id));
}

$page_title = 'Remove Video';?>
<?php include SHARED_PATH . '/public_header.php';?>

<div class="container">
    <div class="jumbotron border-red shadow">

        <h1>Delete video</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="alert-danger text-uppercase"><b>You are about to delete this video. <b>Are you sure?</b></h4>
                <p>If not, please click Cancel now.</b></p>
                <p class="lead">The video to be deleted: <b><?php echo h($job['video_filename']); ?></b></p>
            </div>
        </div>

        <form action="<?php echo url_for('/jobmap/recruiters/jobs/delete_job_video.php?job_id=' . h(u($job_id))); ?>" method="post">
            <a title="Cancel! Return to the job listing" class="btn btn-secondary mt-4" href="<?php echo url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id . ''); ?>" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button title="Yes, I am sure. Please delete this video." type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete video</button>
        </form>
    </div>
</div>
<?php unset($_SESSION['job_title']);?>
<?php include SHARED_PATH . '/public_footer.php';?>