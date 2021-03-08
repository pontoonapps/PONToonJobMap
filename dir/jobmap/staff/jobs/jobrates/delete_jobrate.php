<?php require_once('../../../../private/initialize.php');

require_login();

if(!isset($_GET['XXXjobrate_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/staff/jobs/jobrates/index.php'));
}
$jobrate_id = $_GET['jobrate_id'];
$jobrate = find_jobrate_by_id($jobrate_id);

if(is_post_request()) {

    $result = delete_jobrate($jobrate_id);
    $_SESSION['message'] = 'The Job Rate was deleted sucessfully.';
    redirect_to(url_for('/jobmap/staff/jobs/jobrates/index.php'));
}

?>

<?php $page_title = 'Delete Job Rate'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Delete Job Rate</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="text-uppercase"> You are about to delete this job rate. <b>Are you sure?</b></h4>
                <p><b>If not, please click Cancel now.</b></p>
                <p class="lead">The job rate to be deleted: <b><?php echo h($jobrate['jobrate_name']); ?></b></p>
            </div>
        </div>
        <form action="<?php echo url_for('/jobmap/staff/jobs/jobrates/delete_jobrate.php?jobrate_id=' . h(u($jobrate['id']))); ?>" method="post">
        <a title="Back to Job Rates list" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/index.php'); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times mr-2"></i>Cancel</a>
        <button type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete Job Rate</button>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
