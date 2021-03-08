<?php require_once('../../../private/initialize.php');

if(is_logged_in()){
    $co_id = $_GET['co_id'];
}
else{
require_recruiter_login();
}

// $co_id = isset($_GET['id']) ? $_GET['id'] : '1';
$co_id = $_GET['co_id'] ?? '1'; // PHP > 7.0

$company = find_company_by_id($co_id);

if ($company['recruiter_id'] != $_SESSION['recruiter_id']) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/recruiters/companies/index.php'));
}

$job_set = find_jobs_by_company_id($co_id);
$job_count = count_jobs_by_company_id($company['id']);

if(is_logged_in()){
    $page_title = $company['company_name'] . '\'s dashboard';
}
else{
    $page_title = $_SESSION['recruiter_first_name'] . '\'s company jobs dashboard';
}


?>


<?php include(SHARED_PATH . '/public_header.php'); ?>
<script src="<?php echo url_for('/jobmap/js/co_viz.js');?>"></script>
<script src="<?php echo url_for('/jobmap/js/job_viz.js');?>"></script>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_session_message(); ?>
        <script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js');?>"></script>

            <a title="Back to my company account" href="<?php echo url_for('/jobmap/recruiters/companies/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Company account</a>
            <?php if(is_logged_in()) { ?>
            <a class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
            <?php }
            else { ?>
            <a class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/recruiters/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
        <?php } ?>

        <h1><?php echo h($company['company_name']); ?></h1>

        <div class="card border-orange">
                            <div class="card-header text-white bg-orange">
                        <h3 class="my-1"><?php echo h($company['company_name']); ?>
                        <span class="badge badge-primary badge-pill small float-right">Jobs: <?php echo $job_count; ?></span>
                        </h3>
                    </div>

            <div class="card-body">
                <?php $mtRand = (mt_rand(10, 100)); ?>
                <img class="company_logo_thumb mb-1" src="<?php echo url_for('/jobmap/recruiters/companies/logos/'.h($company['logo']).'?'.$mtRand);?>" alt="<?php echo h($company['company_name']); ?> logo" title="<?php echo h($company['company_name']); ?> logo" />
                <p class="mb-1"><?php echo h($company['company_desc']); ?></p>
                <p><?php echo h($company['location']); ?></p>

                <p class="mt-2 mb-2"><b>Status:</b>
                <?php if ($company['visible'] != 'false') {?>
                    <span id="coStatusBody_<?php echo h($co_id); ?>">[Active]</span>
                <?php }
                else {?>
                    <span id="coStatusBody_<?php echo ($co_id); ?>">[Marked for removal]</span>
                <?php }?></p>
                <label class="switch">
                <input type="checkbox" class="form-check-input" name="coToggle" id="coToggle_<?php echo ($co_id); ?>" value="<?php echo ($co_id); ?>" <?php if ($company['visible'] == "true") {echo " checked";}?> /><span class="slider round"></span></label>
            </div>

        </div>
            <a title="Edit my company information" href="<?php echo url_for('/jobmap/recruiters/companies/edit_company.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-orange btn-md btn-block my-2" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit company</a>
            <a title="Delete Company" href="<?php echo url_for('/jobmap/recruiters/companies/delete_company.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-red btn-md btn-block" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete company</a>
    </div>

    <div class="jumbotron border-orange shadow">
        <h2><?php echo h($company['company_name']); ?> - Jobs Posted</h2>
        <a title="Add a new job" href="<?php echo url_for('/jobmap/recruiters/jobs/add_job.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-green btn-md btn-block mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Add job</a>

        <div class="accordion mb-2" id="accordionExample">
            <div class="card">
                <div class="card-header text-white bg-teal pb-0" type="button" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h4><i class="fas fa-chevron-down fa-lg mr-2"></i>Multi Jobs CSV Template Guide & Download Area </span></h4>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p>This area contains the CSV template guide and CSV template file.</p>
                        <a title="Download CSV MS Excel template" href="<?php echo url_for('/jobmap/recruiters/jobs/PONToon_Job_Map_CSV_template_guide_v1.2.pdf'); ?>" target="_blank" class="btn btn-teal btn-md btn-block mt-4" role="button"><i class="fas fa-file-download fa-lg mr-2"></i>Download CSV template guide.</a>
                        <a title="Download CSV MS Excel template" href="<?php echo url_for('/jobmap/recruiters/jobs/multi-job-csv-template.csv'); ?>" class="btn btn-secondary btn-md btn-block mt-4" role="button"><i class="fas fa-file-download fa-lg mr-2"></i>Download CSV template file.</a>
                    </div>
                </div>
            </div>
        </div>
        <a title="Upload multiple jobs using CSV file" href="<?php echo url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-blue btn-md btn-block mb-2" role="button"><i class="fas fa-file-upload fa-lg mr-2"></i>Upload multiple jobs using CSV</a>
        <?php if(mysqli_num_rows($job_set) > 0) {?>
            <div class="accordion" id="coJobList">
                <div class="card mb-2">
                    <?php while($job = mysqli_fetch_assoc($job_set)) {?>
                        <?php $_SESSION['job_title'] = $job['job_title'];?>
                        <!-- Job Vid Modal -->
                        <div class="modal fade videoModal" id="jobVidModal<?php echo h($job['id']);?>" tabindex="-1" role="dialog" aria-labelledby="jobVidModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <?php $job_vid_set = job_vid_modal($job['id']);
                                while($job_vid = mysqli_fetch_assoc($job_vid_set)) { ?>
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="jobVidModalLabel"><?php echo h($job['job_title']); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <video class="embed-responsive-item mb-2" controls poster="" src="<?php echo url_for('/jobmap/recruiters/jobs/videos/' . h($job_vid['video_filename']));?>" allowfullscreen></video>
                                            </div>
                                            <div><?php echo ($job_vid['video_desc']);?></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php mysqli_free_result($job_vid_set); ?>
                            </div>
                        </div>
                        <?php
                        //$company = find_company_by_id($job['company_id']);
                        $userjob_app_count = count_job_apps_by_job_id($job['id']);
                        // $co_id = $job['id'];
                        $the_job_vid = find_job_vid_by_id($job['id']);
                        $job_post_date = $job['date_created'];
                        $job_post_relative_date = relative_date(strtotime($job_post_date));

                        $job_post_date_ending = $job['date_ending'];
                        $job_post_ending_relative_date = job_ending_relative_date(strtotime($job_post_date_ending));?>

                        <div class="card-header text-white bg-secondary" type="button" id="jobHeader" data-toggle="collapse" data-target="#jobid1<?php echo h($job['id']); ?>" aria-expanded="true" aria-controls="jobid1<?php echo h($job['id']); ?>">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h4><i class="fas fa-chevron-down fa-lg mr-2"></i><?php echo h($job['job_title']);?>
                                    <?php if ($job['visible'] != 'false'){?>
                                        <span class="active" id="jobStatusHead_<?php echo h($job['id']); ?>">[Active]</span>
                                    <?php }
                                    else{?>
                                        <span class="active inactive" id="jobStatusHead_<?php echo h($job['id']); ?>">[Marked for removal]</span>
                                    <?php }?>
                                    </h4>
                                </div>
                                <div class="col-sm-4">
                                    <?php if ($userjob_app_count > 0) {?>
                                        <h5 class="text-md-right text-sm-left"><i class="fas fa-calendar-alt fa-lg mr-2"></i><?php echo h($job_post_relative_date);?><span class="badge badge-success badge-pill small float-right ml-4">Applications: <?php echo $userjob_app_count; ?></span></h5>
                                    <?php }
                                    else {?>
                                        <h5 class="text-md-right text-sm-left"><i class="fas fa-calendar-alt fa-lg mr-2"></i><?php echo h($job_post_relative_date); ?><span class="badge badge-primary badge-pill small float-right ml-4">Applications: <?php echo $userjob_app_count; ?></span></h5>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div id="jobid1<?php echo h($job['id']); ?>" class="collapse" aria-labelledby="jobHeader" data-parent="#coJobList">
                            <div class="card-body">
                                <h1><?php echo h($job['job_title']); ?> - Job Description (HTML Preview)</h1>
                                <p><?php $allowed_job_desc_tags = '<h1><h2><h3><p><br><strong><b><i><em><ul><ol><li>'; // This is a string and NOT an array!!
                                echo strip_tags($job['job_desc'], $allowed_job_desc_tags); ?></p>
                                <?php if(!empty($the_job_vid)) {?>
                                    <!-- Job Vid Modal button -->
                                    <button type="button" class="btn btn-blue mb-2 mr-2" data-toggle="modal" data-target="#jobVidModal<?php echo h($job['id']);?>" title="View [<?php echo h($the_job_vid['video_filename']); ?>] video"><i class="fas fa-eye fa-lg mr-2"></i>View video</button>
                                    <a title="Edit video description" href="<?php echo url_for('/jobmap/recruiters/jobs/edit_job_video.php?job_id=' . h(u($the_job_vid['job_id']))); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit video</a>
                                    <a title="Delete video" href="<?php echo url_for('/jobmap/recruiters/jobs/delete_job_video.php?job_id=' . h(u($the_job_vid['job_id']))); ?>" class="btn btn-red btn-md float-right mb-2" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete video</a>
                                <?php }
                                else {
                                    //show no modal button
                                }?>
                                <a href="<?php echo url_for('/jobmap/recruiters/jobs/edit_job.php?job_id=' . h(u($job['id']))); ?>" title="Edit Job" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between"></div>
                                <dl class="row">
                                    <dt class="col-md-4">Job Ref:</dt>
                                    <dd class="col-md-8"><?php echo h($job['id']); ?></dd>
                                    <dt class="col-md-4">Job Title:</dt>
                                    <dd class="col-md-8"><?php echo h($job['job_title']); ?></dd>
                                    <dt class="col-md-4">Job Sector:</dt>
                                    <dd class="col-md-8"><?php echo h($job['jobsector_name']); ?></dd>
                                    <dt class="col-md-4">Description:</dt>
                                    <dd class="col-md-8"><?php echo h($job['job_desc']); ?></dd>
                                    <dt class="col-md-4">Location:</dt>
                                    <dd class="col-md-8"><?php echo h($job['job_location']); ?></dd>
                                    <dt class="col-md-4">Latitude:</dt>
                                    <dd class="col-md-8"><?php echo h($job['lat']); ?></dd>
                                    <dt class="col-md-4">Longitude:</dt>
                                    <dd class="col-md-8"><?php echo h($job['lng']); ?></dd>
                                    <dt class="col-md-4">Job Type:</dt>
                                    <dd class="col-md-8"><?php echo h($job['jobtype_name']); ?></dd>
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
                                    <dt class="col-md-4">Rate: </dt>
                                    <dd class="col-md-8"><?php echo h($job['jobrate_name']); ?> </dd>
                                    <dt class="col-md-4">Job added:</dt>
                                    <dd class="col-md-8"><?php echo h($job_post_relative_date); ?></dd>
                                    <dt class="col-md-4">Closing date:</dt>
                                    <dd class="col-md-8"><?php echo h($job_post_ending_relative_date); ?></dd>
                                    <dt class="col-md-4">Status:
                                    <br><label class="switch mt-2">
                                    <input type="checkbox" class="form-check-input" name="jobToggle" id="jobToggle_<?php echo $job['id']; ?>" value="<?php echo $job['id']; ?>" <?php if($job['visible'] == "true") { echo " checked"; } ?> /><span class="slider round"></span></label></dt>
                                    <dd class="col-md-8">
                                    <?php if ($job['visible'] != 'false') {?>
                                    <p id="jobStatusBody_<?php echo h($job['id']); ?>">[Active]</p>
                                    <?php } else {?>
                                    <p id="jobStatusBody_<?php echo h($job['id']); ?>">[Marked for removal]</p>
                                    <?php }?>
                                    </dd>

                                    <dt class="col-md-4">Job Video:</dt>
                                    <dd class="col-md-8">
                                    <?php if(empty($the_job_vid)){ ?>
                                    <p>No video added yet!</p>
                                    <?php }
                                    else { ?>
                                    <?php echo h($the_job_vid['video_filename']); ?></dd>
                                    <?php }?>
                                    <dt class="col-md-4">
                                    <?php if ($userjob_app_count > 0) {?>
                                        <h5 class="text-sm-left"><span class="badge badge-success badge-pill small">Applications: <?php echo $userjob_app_count; ?></span></h5>
                                    <?php } else {?>
                                        <h5 class="text-sm-left"><span class="badge badge-primary badge-pill small">Applications: <?php echo $userjob_app_count; ?></span></h5>
                                    <?php }?>
                                    </dt>
                                    <dd class="col-md-8"></dd>
                                </dl></a>
                                <?php $user_set = find_user_by_job_id($job['id']);
                                if(mysqli_num_rows($user_set) > 0) {?>
                                    <button class="btn btn-orange mb-2" type="button" data-toggle="collapse" data-target="#jobid<?php echo h($job['id']); ?>" aria-expanded="false" aria-controls="#jobid<?php echo h($job['id']); ?>"><i class="fas fa-eye fa-lg mr-2"></i>View Applicants</button>
                                    <?php
                                    while($user = mysqli_fetch_assoc($user_set)) { ?>
                                        <div id="jobid<?php echo h($user['job_id']); ?>" class="collapse">
                                            <div class="card card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col" class="text-center">Profile</th>
                                                                <th scope="col">Full name</th>
                                                                <th scope="col">Email</th>
                                                                <th scope="col">Applied</th>
                                                                <th scope="col">CV</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $dateApplied = $user['applic_sent_date'];
                                                        $dateApplied = date("l jS F Y",strtotime($dateApplied));
                                                        $relative_dateApplied = relative_date(strtotime($dateApplied)); ?>
                                                            <tr>
                                                                <th scope="row"><?php echo h($user['id']); ?></th>
                                                                <td><img class="profile_img_sml mx-auto d-block mb-4" alt="<?php echo h($user['first_name']); ?> <?php echo h($user['last_name']); ?>" title="<?php echo h($user['first_name']); ?> <?php echo h($user['last_name']); ?>" src="<?php echo url_for('/jobmap/users/uploads/profile_imgs/'.h($user['profile_img']).'');?>"/></td>
                                                                <td><?php echo h($user['first_name']); ?> <?php echo h($user['last_name']); ?></td>
                                                                <td><a title="Email <?php echo h($user['first_name']);?>" href="mailto:<?php echo h($user['email']); ?>?subject=Your recent application for <?php echo h($job['job_title']); ?>"><i class="fas fa-envelope fa-lg mr-2"></i>Email <?php echo h($user['first_name']); ?></a></td>
                                                                <td><?php echo h($relative_dateApplied);?></td>
                                                                <td><?php if($user['status'] == '0'){ ?>
                                                                        <p class="small">Check email!</p>
                                                                    <?php }
                                                                    else { ?>
                                                                        <a target="_blank" title="View <?php echo h($user['first_name']);?>'s CV" href="<?php echo url_for('/jobmap/users/uploads/cvs/'.h(u($user['cv_name'])));?>"><i class="fas fa-download fa-lg mr-2"></i>View <?php echo h($user['first_name']);?>'s CV</a>
                                                                    <?php }?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                else { ?>
                                    <div class="alert alert-warning p-2">There are no applicants yet!</div>
                                    <?php mysqli_free_result($user_set); ?>
                                <?php } ?>

                                <?php if(!empty($the_job_vid)) {?>
                                    <!-- <a title="Replace Job video" href="<?php //echo url_for('/jobmap/recruiters/jobs/add_job_video.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-blue btn-md btn-block mb-2" role="button"><i class="fas fa-video fa-lg mr-2"></i>Replace Job video</a> -->
                                <?php }
                                else { ?>
                                    <a title="Add a job video" href="<?php echo url_for('/jobmap/recruiters/jobs/add_job_video.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-blue btn-md btn-block mb-2" role="button"><i class="fas fa-video fa-lg mr-2"></i>Add job video</a>
                                <?php } ?>
                                <a title="Edit job" href="<?php echo url_for('/jobmap/recruiters/jobs/edit_job.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-orange btn-md btn-block mb-2" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit job</a>
                                <a title="Remove job" href="<?php echo url_for('/jobmap/recruiters/jobs/delete_job.php?job_id=' . h(u($job['id']))); ?>" class="btn btn-red btn-md btn-block mb-2" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Remove job</a>
                                <a title="Create a new job" href="<?php echo url_for('/jobmap/recruiters/jobs/add_job.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-green btn-md btn-block mb-3" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Add job</a>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
            <?php }
            else { ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">You have not added any jobs yet. Click the<i class="fas fa-plus fa-lg mx-2"></i><b>Add job</b> button to create your first job!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <a title="Add a new job" href="<?php echo url_for('/jobmap/recruiters/jobs/add_job.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-green btn-block mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Add job</a>
            <?php } ?>
            <a title="Back to my company account" href="<?php echo url_for('/jobmap/recruiters/companies/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Company account</a>
            <?php if (is_logged_in()) {?>
                <a class="btn btn-secondary btn-md float-right mb-2" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
            <?php } else {?>
                <a class="btn btn-secondary btn-md float-right mb-2" href="<?php echo url_for('/jobmap/recruiters/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
            <?php }?>
    </div>
</div>
<script>
$('.videoModal').on('hide.bs.modal', function(e) {
    var $if = $(e.delegateTarget).find('video');
    var src = $if.attr("src");
    $if.attr("src", '/empty.html');
    $if.attr("src", src);
});
</script>
<?php mysqli_free_result($job_set); ?>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
