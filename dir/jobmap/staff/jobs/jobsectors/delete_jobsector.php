<?php require_once('../../../../private/initialize.php');

require_login();

if(!isset($_GET['XXXjobsector_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/staff/jobs/jobsectors/index.php'));
}

$jobsector_id = $_GET['jobsector_id'];
$jobsector = find_jobsector_by_id($jobsector_id);

if(is_post_request()) {
    $result = delete_jobsector($jobsector_id);
    $_SESSION['message'] = 'The Job Sector was deleted sucessfully.';
    redirect_to(url_for('/jobmap/staff/jobs/jobsectors/index.php'));
}
?>

<?php $page_title = 'Delete Job Sector'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Delete Job Sector</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="text-uppercase"> You are about to delete this job sector. <b>Are you sure?</b></h4>
                <p><b>If not, please click Cancel now.</b></p>
                <p class="lead">The job sector to be deleted: <b><?php echo h($jobsector['jobsector_name']); ?></b></p>
            </div>
        </div>
        <form action="<?php echo url_for('/jobmap/staff/jobs/jobsectors/delete_jobsector.php?jobsector_id=' . h(u($jobsector['id']))); ?>" method="post">
            <a title="Cancel! Go back to Job Sectors list" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/index.php'); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete Job Sector</button>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
