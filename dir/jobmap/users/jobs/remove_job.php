<?php require_once('../../../private/initialize.php');

require_user_login();

if(!isset($_GET['job_id'])) {
    redirect_to(url_for('/jobmap/users/index.php?user_id='.h(u($_SESSION['user_id']))));
}
$job_id = $_GET['job_id'];
$_SESSION['job_id'] = $_GET['job_id'];

$userjob = find_user_job($job_id);
    $company = find_company_by_job_id($_SESSION['job_id']);
    $_SESSION['company_name'] = $company['company_name'];

if ($userjob['user_id'] != $_SESSION['user_id']) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/users/index.php'));
}

if(is_post_request()) {
    $result = delete_user_job($job_id);
    if($result === true) {
        $_SESSION['message'] = 'The saved job was removed sucessfully.';
        redirect_to(url_for('/jobmap/users/index.php?user_id='.h(u($_SESSION['user_id']))));
    } else {
        $errors = $result;
        $userjob = find_user_job($job_id);
    }
}
?>

<?php $page_title = 'Remove saved job'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Remove saved job</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="text-uppercase"> You are about to remove the following saved job posting: <b>Are you sure?</b></h4>
                <p><b>If not, please click Cancel now.</b></p>
                <p class="lead">Job to be deleted: <b><?php echo h($userjob['job_title']); ?> - <?php echo h($_SESSION['company_name']); ?></b></p>
            </div>
        </div>
        <form action="<?php echo url_for('/jobmap/users/jobs/remove_job.php?job_id=' . h(u($userjob['job_id']))); ?>" method="post">
            <a title="Cancel! Go Back to My Account" href="<?php echo url_for('/jobmap/users/index.php?user_id='.h(u($_SESSION['user_id']))); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Remove Job</button>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
