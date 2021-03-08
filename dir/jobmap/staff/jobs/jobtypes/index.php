<?php require_once('../../../../private/initialize.php');
require_login();
$jobtype_set = find_all_jobtypes();

$page_title = 'Job Types';
include(SHARED_PATH . '/staff_header.php'); ?>
<script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js'); ?>"></script>

<div class="container">
    <div class="jumbotron border-green shadow">
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_session_message(); ?>
        <h1>Job Types</h1>
        <a title="Add new Job Type" href="<?php echo url_for('/jobmap/staff/jobs/jobtypes/add_jobtype.php'); ?>" class="btn btn-green btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Type</a>
        <a title="Return to dashboard" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/dashboard.php'); ?>" role="button">Dashboard<i class="fas fa-angle-double-right fa-lg ml-2"></i></a>

        <?php if(mysqli_num_rows($jobtype_set) > 0) {
            while($jobtype = mysqli_fetch_assoc($jobtype_set)) { ?>
            <div class="list-group">
                <a href="<?php echo url_for('/jobmap/staff/jobs/jobtypes/show_jobtype.php?jobtype_id=' . h(u($jobtype['id']))); ?>" title="View Job Types" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo h($jobtype['jobtype_name']); ?></h5>
                </div>

                <a title="Edit Job Type" href="<?php echo url_for('/jobmap/staff/jobs/jobtypes/edit_jobtype.php?jobtype_id=' . h(u($jobtype['id']))); ?>" class="btn btn-green btn-md btn-block" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit Job Type</a>

                <a title="Delete Job Type" href="<?php echo url_for('/jobmap/staff/jobs/jobtypes/delete_jobtype.php?jobtype_id=' . h(u($jobtype['id']))); ?>" class="btn btn-red btn-md btn-block mb-2" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete Job Type</a>
            </div>
        <?php }
        }
        else { ?>
            <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">You have not added any jobs types yet!</div>
        <?php } ?>
    </div>
</div>
<?php mysqli_free_result($jobtype_set);
include(SHARED_PATH . '/public_footer.php'); ?>
