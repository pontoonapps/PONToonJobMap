<?php require_once('../../../private/initialize.php');

if (is_logged_in()) {
    // $_SESSION['co_id'] = $_GET['co_id'];
    if (!isset($_GET['rec_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

if (!isset($_GET['rec_id']) || $_GET['rec_id'] != $_SESSION['recruiter_id']) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php'));
}

// $rec_id = $_GET['rec_id'];
// $recruiter_company = find_company_by_recruiter_id($rec_id);?>


<?php //if (!$recruiter_company) {
//     if(is_logged_in()){
//         $_SESSION['attempt_message'] = 'No company exists for this recruiter yet!';
//         redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
//     }
//     else{
//         $_SESSION['attempt_message'] = 'No company exists for this recruiter yet!';
//         redirect_to(url_for('recruiters/index.php'));
//     }
// }

$recruiter_company_set = show_recruiter_company();



if (is_logged_in()) {
    $page_title = 'Recruiters - Company account';
} else {
    $page_title = $_SESSION['recruiter_first_name'] . '\'s company jobs dashboard';
}
?>

<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_session_message(); ?>
        <script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js');?>"></script>

        <a title="Back to my account" class="btn btn-orange btn-md mb-2" href="<?php echo url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>My account</a>
        <?php if (is_logged_in()){ ?>
        <a title="Log out" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
        <?php }
        else { ?>
        <a title="Log out" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/recruiters/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
        <?php } ?>
        <?php if(mysqli_num_rows($recruiter_company_set) > 0) {
            while($recruiter_company = mysqli_fetch_assoc($recruiter_company_set)) { ?>
                <?php $co_id = $recruiter_company['id'];?>

                <?php $job_count = count_jobs_by_company_id($recruiter_company['id']); ?>

                <div class="card border-orange">
                    <div class="card-header text-white bg-orange">
                        <h3 class="my-1"><?php echo h($recruiter_company['company_name']); ?>
                        <span class="badge badge-primary badge-pill small float-right">Jobs: <?php echo $job_count; ?></span>
                        </h3>
                    </div>

                    <div class="card-body">
                        <?php $mtRand = (mt_rand(10, 100));
                        if($recruiter_company['logo_status'] != 1){?>
                        <img alt="Upload your company logo!" title="Upload your company logo!" class="d-block company_logo_thumb my-2" src="<?php echo url_for('/jobmap/recruiters/companies/logos/'.h($recruiter_company['logo']).'?'.$mtRand);?>" />
                        <?php }
                        else {?>
                        <img alt="<?php echo h($recruiter_company['company_name']); ?> logo" title="<?php echo h($recruiter_company['company_name']); ?> logo" class="d-block company_logo_med my-2" src="<?php echo url_for('/jobmap/recruiters/companies/logos/'.h($recruiter_company['logo']).'?'.$mtRand);?>" />
                        <?php }?>
                        <p class="my-1"><b>Company description:</b></p>
                        <p class="mb-1"><?php echo h($recruiter_company['company_desc']); ?></p>
                        <p class="my-1"><b>Location: </b><?php echo h($recruiter_company['location']); ?></p>
                        <p class="mt-2 mb-2"><b>Status:</b>
                        <?php if ($recruiter_company['visible'] != 'false') {?>
                            <span id="coStatusBody_<?php echo h($co_id); ?>">[Active]</span>
                        <?php }
                        else {?>
                            <span id="coStatusBody_<?php echo ($co_id); ?>">[Marked for removal]</span>
                        <?php }?></p>
                        <label class="switch">
                        <input type="checkbox" class="form-check-input" name="coToggle" id="coToggle_<?php echo ($co_id); ?>" value="<?php echo ($co_id); ?>" <?php if ($recruiter_company['visible'] == "true") {echo " checked";}?> /><span class="slider round"></span></label>

                        <script src="<?php echo url_for('/jobmap/js/co_viz.js');?>"></script>
                    </div>
                </div>
                <a title="Edit company" href="<?php echo url_for('/jobmap/recruiters/companies/edit_company.php?co_id=' . h(u($recruiter_company['id']))); ?>" class="btn btn-orange btn-block my-2" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit company</a>
                <a title="Delete company" href="<?php echo url_for('/jobmap/recruiters/companies/delete_company.php?co_id=' . h(u($recruiter_company['id']))); ?>" class="btn btn-red btn-block" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete company</a>
                <?php if ($job_count > 0) {?>
                    <a title="Manage jobs" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($recruiter_company['id']))); ?>" class="btn btn-green btn-block" role="button"><i class="fas fa-tasks fa-lg mr-2"></i>Manage jobs</a>
                <?php }
                else {?>
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">You have not added any jobs yet. Click the<i class="fas fa-plus fa-lg mx-2"></i><b>Add Job</b> button to create your first job!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <a title="Add a new job" href="<?php echo url_for('/jobmap/recruiters/jobs/add_job.php?co_id=' . h(u($recruiter_company['id']))); ?>" class="btn btn-green btn-block" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Add Job</a>
                <?php }?>
            <?php }
        }
        else {
            // if(is_logged_in()){
            //     $_SESSION['attempt_message'] = 'No user or user with company account!';
            //     redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
            // }
            // else { ?>
                <div class="alert alert-info p-2">
                    <p>You haven't added your company yet!</p>
                    <p>Please click the<b><i class="fas fa-plus fa-lg mx-2"></i>Create company</b> button below to create your company account.</p>
                    <p>You can then start adding jobs.</p>
                </div>
                <a title="Create my company account" href="<?php echo url_for('/jobmap/recruiters/companies/new_company.php'); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Create company</a>
            <?php }?>
        <?php //} ?>
        </div>
    </div>
</div>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
