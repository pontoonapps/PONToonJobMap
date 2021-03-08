<?php require_once('../../../private/initialize.php');

if (is_logged_in()) {
    if (!isset($_GET['job_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

$job_id = $_GET['job_id'];

if(!isset($_GET['job_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
}

$job = find_job_by_id($job_id);
// $job_id = $job['job_id'];
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
    $result = $jVid = find_job_vid_by_id($job_id);
    $file = "videos/" . $jVid['video_filename'];

    // if (!unlink($file)) {
    // $_SESSION['message'] = 'Your video was not deleted sucessfully.';
    // } else {
    // $_SESSION['message'] = 'Your video was deleted sucessfully.';
    // }

    disable_job($job_id);

    $_SESSION['message'] = 'Job marked for removal was sucessfull.';
    redirect_to(url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($job['company_id']))));
}
?>

<?php $page_title = 'Remove Job'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Delete job</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="alert-danger text-uppercase">This job will be temporarily marked for removal and will remain in your job list. This is to allow time to notify Job Seekers that the job is no longer available, before it is deleted.</h4>
                <p><b>Are you sure?</p>
                <p class="lead">The job to be removed: <b><?php echo h($job['job_title']); ?></b></p>
            </div>
        </div>

        <form action="<?php echo url_for('/jobmap/recruiters/jobs/delete_job.php?job_id=' . h(u($job['id']))); ?>" method="post">
            <a title="Cancel! Go back to company jobs" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($job['company_id']))); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button title="Yes, I am sure. Please remove the job." type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Remove job</button>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
