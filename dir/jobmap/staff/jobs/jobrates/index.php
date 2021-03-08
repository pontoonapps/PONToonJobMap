<?php require_once('../../../../private/initialize.php');
require_login();
$jobrate_set = find_all_jobrates();

$page_title = 'Job Types';
include(SHARED_PATH . '/staff_header.php'); ?>
<script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js'); ?>"></script>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_session_message(); ?>
        <h1>Job Rates</h1>
        <a title="Add new Job Rate" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/add_jobrate.php'); ?>" class="btn btn-green btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Rate</a>
        <a title="Return to dashboard" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/dashboard.php'); ?>" role="button">Dashboard<i class="fas fa-angle-double-right fa-lg ml-2"></i></a>

        <?php if(mysqli_num_rows($jobrate_set) > 0) {
            while($jobrate = mysqli_fetch_assoc($jobrate_set)) { ?>
            <div class="list-group">
                <a href="<?php echo url_for('/jobmap/staff/jobs/jobrates/show_jobrate.php?jobrate_id=' . h(u($jobrate['id']))); ?>" title="View Job Rates" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo h($jobrate['jobrate_name']); ?></h5>
                </div>

                <a title="Edit Job Rate" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/edit_jobrate.php?jobrate_id=' . h(u($jobrate['id']))); ?>" class="btn btn-orange btn-md btn-block" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit Job Rate</a>

                <a title="Delete Job Rate" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/delete_jobrate.php?jobrate_id=' . h(u($jobrate['id']))); ?>" class="btn btn-red btn-md btn-block mb-2" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete Job Rate</a>
            </div>
        <?php }
        }
        else { ?>
            <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">You have not added any jobs rates yet!</div>
        <?php } ?>
    </div>
</div>
<?php mysqli_free_result($jobrate_set);
include(SHARED_PATH . '/public_footer.php'); ?>
