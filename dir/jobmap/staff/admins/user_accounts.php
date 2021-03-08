<?php require_once('../../../private/initialize.php');
unset($_SESSION['recruiter_id']);
unset($_SESSION['user_id']);
unset($_SESSION['recruiter_first_name']);
unset($_SESSION['recruiter_last_name']);
unset($_SESSION['first_name']);
unset($_SESSION['last_name']);

require_login();
$admin_set = find_all_admins();
$recruiter_set = admin_find_all_recruiters();
$user_set = find_all_users();?>

<?php $page_title = 'Staff - User Accounts list'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<script src="<?php echo url_for('/jobmap/js/admins_viz.js');?>"></script>

<div class="container">
    <div class="jumbotron border-teal shadow">
        <h1>Admins</h1>
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_session_message(); ?>
        <a title="Create new Admin account" href="<?php echo url_for('/jobmap/staff/admins/admin_signup.php'); ?>" class="btn btn-green btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Create Admin account</a>
        <a title="Return to Dashboard" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/dashboard.php'); ?>" role="button">Dashboard<i class="fas fa-angle-double-right fa-lg ml-2"></i></a>
        <div class="accordion" id="adminList">
            <div class="card">
                <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
                    <div class="card-header text-white bg-secondary" type="button" id="adminHeader" data-toggle="collapse" data-target="#adminID<?php echo h($admin['id']); ?>" aria-expanded="true" aria-controls="adminID<?php echo h($admin['id']); ?>">
                        <div class="row">
                            <h4><i class="fas fa-chevron-down fa-lg ml-4 mr-4"></i><?php echo h($admin['first_name']. ' ' .$admin['last_name']);?></h4>
                        </div>
                    </div>
                    <div id="adminID<?php echo h($admin['id']); ?>" class="collapse" aria-labelledby="adminHeader" data-parent="#adminList">
                        <div class="card-body">
                            <p class="mb-1"><b>Admin ID # </b><?php echo h($admin['id']); ?></p>
                            <p class="mb-1"><b>Full name: </b><?php echo h($admin['first_name']); ?> <?php echo h($admin['last_name']); ?></p>
                            <p class="mb-1"><b>Email: </b><a title="Send email" href="mailto:<?php echo h($admin['email']); ?>?subject=PONToon Job Map - Your Admin account"><?php echo h($admin['email']); ?></a></p>
                            <p><b>Active status: </b><span id="adminHeading_<?php echo $admin['id']; ?>"></span></p>
                            <label class="switch">
                            <input type="checkbox" class="form-check-input" name="adminToggle" id="adminToggle_<?php echo $admin['id']; ?>" value="<?php echo $admin['id']; ?>" <?php if($admin['visible'] == "true") { echo " checked"; } ?> />
                            <span class="slider round"></span>
                            </label>
                            <a title="Edit Admin" href="<?php echo url_for('/jobmap/staff/admins/edit_admin.php?admin_id=' . h(u($admin['id']))); ?>" class="btn btn-teal btn-md btn-block" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit admin</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php mysqli_free_result($admin_set); ?>
        </div>
    </div>

    <div id="theRecruiters" class="jumbotron border-orange shadow">
        <h1>Recruiters</h1>
        <a title="Create Recruiter account" href="<?php echo url_for('recruiter_signup.php'); ?>" class="btn btn-green btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Create Recruiter account</a>
        <div class="accordion" id="recList">
            <div class="card">
                <?php while($recruiter = mysqli_fetch_assoc($recruiter_set)) { ?>
                    <div class="card-header text-white bg-secondary" type="button" id="recHeader" data-toggle="collapse" data-target="#recID<?php echo h($recruiter['id']); ?>" aria-expanded="true" aria-controls="recID<?php echo h($recruiter['id']); ?>">
                        <div class="row">
                            <h4><i class="fas fa-chevron-down fa-lg ml-4 mr-4"></i><?php echo h($recruiter['first_name']. ' ' .$recruiter['last_name']);?></h4>
                        </div>
                    </div>
                    <div id="recID<?php echo h($recruiter['id']); ?>" class="collapse" aria-labelledby="recHeader" data-parent="#recList">
                        <div class="card-body">
                            <p class="mb-1"><b>Recruiter ID # </b><?php echo h($recruiter['id']); ?></p>
                            <p class="mb-1"><b>Full name: </b><?php echo h($recruiter['first_name']); ?> <?php echo h($recruiter['last_name']); ?></p>
                            <p class="mb-1"><b>Email: </b><a title="Send email" href="mailto:<?php echo h($recruiter['email']); ?>?subject=PONToon Job Map - Your Recruiter account"><?php echo h($recruiter['email']); ?></a></p>
                            <p><b>Active status: </b><span id="recHeading_<?php echo $recruiter['id']; ?>"></span></p>
                            <label class="switch">
                            <input type="checkbox" class="form-check-input" name="recToggle" id="recToggle_<?php echo $recruiter['id']; ?>" value="<?php echo $recruiter['id']; ?>" <?php if($recruiter['visible'] == "true") { echo " checked"; } ?> />
                            <span class="slider round"></span>
                            </label>
                            <?php $rec_id = $recruiter['id'];
                            $_SESSION['recruiter_id'] = $rec_id;

                            $recruiter_company_set = admin_find_all_recruiter_companies($rec_id);

                            if (mysqli_num_rows($recruiter_company_set) > 0) {
                                while ($recruiter_company = mysqli_fetch_assoc($recruiter_company_set)) {?>
                                    <?php $job_count = count_jobs_by_company_id($recruiter_company['company_id']);?>
                                    <p class="mb-1"><b>Company Name: </b>
                                    <?php echo h($recruiter_company['company_name']); ?></p>
                                    <p><b>Job Posts: </b><?php echo $job_count; ?></p>
                                <?php }
                            } else {?>
                                <p class="alert alert-info px-1">No company has been created yet!</p>
                                <a title="Create New Company account" href="<?php echo url_for('/jobmap/recruiters/companies/new_company.php'); ?>" class="btn btn-green btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Create new company</a>
                            <?php }?>
                                <a class="btn btn-orange btn-md btn-block" title="Manage <?php echo $recruiter['first_name'];?>'s account" href="<?php echo url_for('/recruiters/index.php?rec_id=' . h(u($rec_id))); ?>" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Manage <?php echo $recruiter['first_name'];?>'s account</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php mysqli_free_result($recruiter_set); ?>
            <?php mysqli_free_result($recruiter_company_set); ?>
        </div>
    </div>

    <div id="theUsers" class="jumbotron border-blue shadow">
        <h1>Job Seekers</h1>
        <a title="Create Job Seeker account" href="<?php echo url_for('/user_signup.php'); ?>" class="btn btn-green btn-md mb-2" role="button"><i class="fas fa-plus fa-lg mr-2"></i>Create Job Seeker account</a>
        <div class="accordion" id="userList">
            <div class="card">
                <?php while($user = mysqli_fetch_assoc($user_set)) { ?>
                    <div class="card-header text-white bg-secondary" type="button" id="userHeader" data-toggle="collapse" data-target="#userID<?php echo h($user['id']); ?>" aria-expanded="true" aria-controls="userID<?php echo h($user['id']); ?>">
                        <div class="row">
                            <h4><i class="fas fa-chevron-down fa-lg ml-4 mr-4"></i><?php echo h($user['first_name']. ' ' .$user['last_name']);?></h4>
                        </div>
                    </div>
                    <div id="userID<?php echo h($user['id']); ?>" class="collapse" aria-labelledby="userHeader" data-parent="#userList">
                        <div class="card-body">
                            <p class="mb-1"><b>Job Seeker ID # </b><?php echo h($user['id']); ?></p>
                            <p class="mb-1"><b>Full name: </b><?php echo h($user['first_name']); ?> <?php echo h($user['last_name']); ?></p>
                            <p class="mb-1"><b>Email: </b><a title="Send email" href="mailto:<?php echo h($user['email']); ?>?subject=PONToon Job Map - Your Job Seeker account"><?php echo h($user['email']); ?></a></p>
                            <p><b>Active status: </b><span id="userHeading_<?php echo $user['id']; ?>"></span></p>
                            <label class="switch">
                            <input type="checkbox" class="form-check-input" name="userToggle" id="userToggle_<?php echo $user['id']; ?>" value="<?php echo $user['id']; ?>" <?php if($user['visible'] == "true") { echo " checked"; } ?> />
                            <span class="slider round"></span>
                            </label>
                            <a class="btn btn-blue btn-md btn-block" title="Manage <?php echo $user['first_name'];?>'s account" href="<?php echo url_for('/users/index.php?user_id=' . h(u($user['id']))); ?>" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Manage <?php echo $user['first_name'];?>'s account</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php mysqli_free_result($user_set); ?>
        </div>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
