<?php require_once('../../../private/initialize.php');

if (is_logged_in()) {
    if (!isset($_GET['job_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

unset($_SESSION['theLocation']);
unset($_SESSION['theLat']);
unset($_SESSION['theLng']);

$job_id = $_GET['job_id'] ?? '1'; // PHP > 7.0
// $job_id = isset($_GET['id']) ? $_GET['id'] : '1';

if (!isset($_GET['job_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
}

$job = find_job_by_id($job_id);
$job_vid = find_job_vid_by_id($job_id);
$company = find_company_by_id($job['company_id']);
//$jobtype = find_jobtype_by_id($job['jobtype_id']);
if (is_logged_in()) {
    if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
} else {
    if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
    }
}
?>

<?php $page_title = 'Show job'; ?>
<?php include(SHARED_PATH . '/public_header.php');?>
<script src="<?php echo url_for('/jobmap/js/job_viz.js');?>"></script>
<?php
$job_post_date = $job['date_created'];
$job_post_relative_date = relative_date(strtotime($job_post_date));

$job_post_date_ending = $job['date_ending'];
$job_post_ending_relative_date = job_ending_relative_date(strtotime($job_post_date_ending));

?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_session_message(); ?>
        <?php echo display_session_attempt_message(); ?>
        <script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js');?>"></script>

        <a title="Back to company jobs" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Company jobs</a>

        <h1>Job: <?php echo h($job['job_title']); ?></h1>

        <div class="list-group">
            <div class="card border-orange mt-2 mb-2">
                <div class="card-header text-white bg-orange">
                    <h4 class="my-0"><?php echo h($job['job_title']); ?> - Job Description (HTML Preview)</h4>
                </div>
                <div class="card-body">
                    <?php $allowed_job_desc_tags = '<h1><h2><h3><p><br><strong><b><i><em><ul><ol><li>'; // This is a string and NOT an array!!
                    echo strip_tags($job['job_desc'], $allowed_job_desc_tags);?>

                    <?php if(empty($job_vid)){
                    }
                    else {?>

                        <div class="embed-responsive embed-responsive-16by9 border mt-4">
                            <video class="embed-responsive-item mb-2" controls poster="" src="videos/<?php echo h($job_vid['video_filename']); ?>" allowfullscreen></video>
                        </div>
                        <p class=""><b>Video description: </b></p>
                        <p><?php echo ($job_vid['video_desc']);?></p>
                        <a title="Edit video description" href="<?php echo url_for('/jobmap/recruiters/jobs/edit_job_video.php?job_id=' . h(u($job_vid['job_id']))); ?>" class="btn btn-orange btn-md mt-4" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit description</a>
                        <a title="Delete this video" href="<?php echo url_for('/jobmap/recruiters/jobs/delete_job_video.php?job_id=' . h(u($job_vid['job_id']))); ?>" class="btn btn-red btn-md mt-4 float-right" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete video</a>
                    <?php }?>
                </div>
            </div>
        </div>

        <a href="<?php echo url_for('/jobmap/recruiters/jobs/edit_job.php?job_id=' . h(u($job['id']))); ?>" title="Edit Job" class="list-group-item list-group-item-action flex-column align-items-start border-orange">

        <dl class="row w-100">
        <dt class="col-sm-4">Company:</dt>
        <dd class="col-sm-8"><?php echo h($company['company_name']); ?></dd>
        <dt class="col-sm-4">Job Ref:</dt>
        <dd class="col-sm-8"><?php echo h($job['id']); ?></dd>
        <dt class="col-sm-4">Job Title:</dt>
        <dd class="col-sm-8"><?php echo h($job['job_title']); ?></dd>
        <dt class="col-sm-4">Job Sector:</dt>
        <dd class="col-sm-8"><?php echo h($job['jobsector_name']); ?></dd>
        <dt class="col-sm-4">Job Description:</dt>
        <dd class="col-sm-8 w-100 h-100"><?php echo h($job['job_desc']); ?></dd>
        <dt class="col-sm-4">Job Location:</dt>
        <dd class="col-sm-8"><?php echo h($job['job_location']); ?></dd>
        <dt class="col-sm-4">Latitude:</dt>
        <dd class="col-sm-8"><?php echo h($job['lat']); ?></dd>
        <dt class="col-sm-4">Longitude:</dt>
        <dd class="col-sm-8"><?php echo h($job['lng']); ?></dd>
        <dt class="col-sm-4">Job Type:</dt>
        <dd class="col-sm-8"><?php echo h($job['jobtype_name']); ?></dd>
        <dt class="col-sm-4">Salary
        <?php if ($job['currency_id'] == '1') {
            echo '(&pound;):';
        } else if ($job['currency_id'] == '2') {
            echo '(&euro;):';
        } else {
            echo '(&dollar;):';
        }
        ?></dt>
        <?php $format_salary = number_format($job['salary'], 2);?>
        <dd class="col-sm-8"><?php echo h($format_salary); ?> <?php echo h($job['alphacode']); ?></dd>
        <dt class="col-sm-4">Rate:</dt>
        <dd class="col-sm-8"><?php echo h($job['jobrate_name']); ?></dd>
        <dt class="col-sm-4">Job Added:</dt>
        <dd class="col-sm-8"><?php echo h($job_post_relative_date); ?></dd>
        <dt class="col-sm-4">Closing Date:</dt>
        <dd class="col-sm-8"><?php echo h($job_post_ending_relative_date); ?></dd>
        <dt class="col-sm-4">Job Open Status:</dt>
        <dd class="col-sm-8">
        <?php if ($job['visible'] != 'false') {?>
            <span id="jobStatusBody_<?php echo h($job['id']); ?>">[Active]</span>
        <?php } else {?>
            <span id="jobStatusBody_<?php echo h($job['id']); ?>">[Marked for removal]</span>
        <?php }?>
        </dd>
        <dt class="col-sm-4">
        <label class="switch">
        <input type="checkbox" class="form-check-input" name="jobToggle" id="jobToggle_<?php echo $job['id']; ?>" value="<?php echo $job['id']; ?>" <?php if($job['visible'] == "true") { echo " checked"; } ?> /><span class="slider round"></span></label></dt>
        <dd class="col-sm-8"></dd>
        <dt class="col-sm-4">Job Video:</dt>
        <dd class="col-sm-8">
        <?php if(empty($job_vid)){ ?>
            <p>No video added yet!</p>
        <?php }
        else { ?>
        <?php echo h($job_vid['video_filename']); ?></dd>
        <?php }?>
        </dl>
        </a>

        <?php if (!empty($job_vid)) {?>
            <!-- <a title="Replace Job video" href="<?php //echo url_for('/jobmap/recruiters/jobs/add_job_video.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-blue btn-md btn-block mb-2" role="button"><i class="fas fa-video fa-lg mr-2"></i>Replace Job video</a> -->
        <?php } else {?>
            <a title="Add job video" href="<?php echo url_for('/jobmap/recruiters/jobs/add_job_video.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-green btn-md btn-block mb-2" role="button"><i class="fas fa-video fa-lg mr-2"></i>Add job video</a>
        <?php }?>

        <a title="Edit job" href="<?php echo url_for('/jobmap/recruiters/jobs/edit_job.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-orange btn-md my-2" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit job</a>

        <a title="Delete job" href="<?php echo url_for('/jobmap/recruiters/jobs/delete_job.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-red btn-md my-2 float-right" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete job</a>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
