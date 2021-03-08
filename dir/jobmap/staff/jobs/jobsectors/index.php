<?php require_once('../../../../private/initialize.php');
require_login();
$jobsector_set = find_all_jobsectors();

$page_title = 'Job Sectors';
include(SHARED_PATH . '/staff_header.php'); ?>
<script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js');?>"></script>

<div class="container">
    <div id="theJobSectors" class="jumbotron border-blue shadow">
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_session_message(); ?>
        <h1>Job Sectors</h1>
        <a title="Add new Job Sector" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/add_jobsector.php'); ?>" class="btn btn-green btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Sector</a>
        <a title="Return to Staff Dashboard" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/dashboard.php'); ?>" role="button">Dashboard<i class="fas fa-angle-double-right fa-lg ml-2"></i></a>

        <?php if(mysqli_num_rows($jobsector_set) > 0) {
            while($jobsector = mysqli_fetch_assoc($jobsector_set)) { ?>
                <div class="list-group">
                    <a href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/show_jobsector.php?jobsector_id=' . h(u($jobsector['id']))); ?>" title="View Job Sector" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?php echo h($jobsector['jobsector_name']); ?></h5>
                    </div>
                    <a title="Edit Job Sector" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/edit_jobsector.php?jobsector_id=' . h(u($jobsector['id']))); ?>" class="btn btn-blue btn-md btn-block" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit Job Sector</a>
                    <a title="Delete Job Sector" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/delete_jobsector.php?jobsector_id=' . h(u($jobsector['id']))); ?>" class="btn btn-red btn-md btn-block mb-2" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete Job Sector</a>
            <?php }
        }
        else { ?>
            <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">You have not added any jobs sectors yet!</div>
        <?php } ?>
                </div>
    </div>
</div>
<?php mysqli_free_result($jobsector_set);
include(SHARED_PATH . '/public_footer.php'); ?>
