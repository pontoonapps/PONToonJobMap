<?php require_once '../../private/initialize.php';

if (is_logged_in()) {
    if (!isset($_GET['user_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
    else {
        $user_id = $_GET['user_id'];
        $_SESSION['user_id'] = $_GET['user_id'];
        // $user_fn = $_GET['fn'];
        $the_user_set = admin_show_user($user_id);
        // $user_email = admin_find_user_email($user_id);
    }
}
else {
    require_user_login();
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/users/index.php?user_id='.h(u($_SESSION['user_id']))));
    }
    $user_id = $_SESSION['user_id'];
}

$get_user = find_user_by_id($user_id);

$user_set = show_user();

// if ($_GET['user_id'] != $_SESSION['user_id']) {
//     $_SESSION['attempt_message'] = 'You are EEEEnot authorised to perform this action!';
//     redirect_to(url_for('users/index.php'));
// }


unset($_SESSION['job_title']);
unset($_SESSION['rec_email']);
unset($_SESSION['company_name']);
unset($_SESSION['cvFile']);
unset($_SESSION['cvFileName']);
unset($_SESSION['pimgFileName']);
$show_modal = false;

if (is_get_request()) {
    $_SESSION['job_id'] = $_GET['job_id'] ?? '1';
    $job_id = h($_SESSION['job_id']);
    $job = find_user_job($job_id);
    if ($job['applic_sent'] == '1') {
        $show_modal = true;
    } else {
        //do nothing
    }
}
?>

<?php if(is_logged_in()) {
    $page_title = $_SESSION['admin_first_name'] . '\'s Dashboard';
}
else {
    $page_title = $_SESSION['first_name'] . '\'s Dashboard';

}?>
<?php include SHARED_PATH . '/public_header.php';?>
<script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js'); ?>"></script>

<div class="modal fade" id="myJobModal" tabindex="-1" role="dialog" aria-labelledby="myJobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white bg-success">
                <h5 class="modal-title" id="myJobModalLabel"><?php echo $job['job_title']; ?>  - Job application submitted.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">The application has been submitted for consideration and a copy sent to your registered email address. If you do not receive the message within a few minutes, please check your Junk E-mail or Spam folder, in case the email got delivered there. Good luck!!</p>
                <small class="text-muted">This job has also been saved to the <b>[My Saved Jobs]</b> section below.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if ($show_modal): ?>
<script>
    $(document).ready(function () {
        $('#myJobModal').modal('show');
    });
</script>
<?php endif;?>

<script>
$(document).ready(function(){
    /* Get iframe src attribute value i.e. YouTube video url and store it in a variable */
    var url = $("#videoFrame").attr('src');
    /* Assign empty url value to the iframe src attribute when modal hide, which stop the video playing */
    $("#myModal").on('hide.bs.modal', function(){
        $("#videoFrame").attr('src', '');
    });
    /* Assign the initially stored url back to the iframe src attribute when modal is displayed again */
    $("#myModal").on('show.bs.modal', function(){
        $("#videoFrame").attr('src', url);
    });
});
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PONToon video - How to write a powerful CV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9 mb-2">
                    <iframe id="videoFrame" class="embed-responsive-item" src="https://www.youtube.com/embed/uG2aEh5xBJE" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="jumbotron text-dark border-blue shadow">
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_session_message(); ?>
        <?php echo display_session_primary_message(); ?>
        <?php if (is_logged_in()) {?>
            <a title="Back to user's account" href="<?php echo url_for('/users/index.php?user_id='.h($user_id)); ?>" class="btn btn-blue btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>User account</a>
            <a class="btn btn-secondary float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
            <h1 class="display-4">Hello, <?php echo $_SESSION['admin_first_name'] ?? ''; ?></h1>
            <div class="card border-red mb-4">
                <div class="card-header text-white bg-red">
                    <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
                </div>
                <div class="card-body">
                    <p class="lead">As an administrator, you have full access to manage this account.<br>
                    Please ensure that you have permission from the user before any changes are made!!</p>
                </div>
            </div>
        <?php }
        else {?>
            <a title="Back to my account" href="<?php echo url_for('/users/index.php'); ?>" class="btn btn-blue btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>My account</a>
            <a class="btn btn-secondary float-right" href="<?php echo url_for('/users/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
            <h1 class="display-4">Hello, <?php echo $get_user['first_name'] ?? ''; ?></h1>
            <h2>Welcome to your Job Seeker dashboard.</h2>
            <h5>From here, you can manage your profile image, contact details, CV and saved jobs list.</h5>
        <?php }?>

        <!-- MY PROFILE START -->
        <div class="row mb-4">
            <div class="col-md-8 d-flex flex-column">
                <div class="card text-dark border-blue mb-2 h-100">
                    <div class="card-header bg-blue text-white">
                        <h3 class="my-0"><i class="fas fa-user-alt fa-lg mr-2"></i>My profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row h-100">
                            <div class="col-md-5 d-flex flex-column">
                                <?php
                                $sql = "SELECT * FROM users ";
                                if(is_logged_in()){
                                    $sql .= "WHERE id='$user_id' ";
                                    // $sql .= "AND first_name='$user[first_name] ";
                                }
                                else{
                                    $sql .= "WHERE id='$_SESSION[user_id]' ";
                                    // $sql .= "AND first_name='$_SESSION[first_name]' ";
                                }
                                $sql .= "LIMIT 1";
                                $result = mysqli_query($db, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $pimgid = $row['id'];
                                        $fullName = $row['first_name'] . ' ' . $row['last_name'];
                                        $sqlImg = "SELECT profile_img, profile_img_status FROM users WHERE id='$pimgid'";
                                        $resultImg = mysqli_query($db, $sqlImg);
                                        while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                            if ($rowImg['profile_img_status'] == 1) {
                                                $mtRand = (mt_rand(10, 100));?>
                                                <img class="profile_img mb-2" alt="<?php echo h($fullName); ?>" title="<?php echo h($fullName); ?>" src="<?php echo url_for('/jobmap/users/uploads/profile_imgs/' . h($rowImg['profile_img']) . '?' . $mtRand); ?>"/>
                                                <form action="<?php echo url_for('/jobmap/users/delete_profile_img.php?user_id='.$user_id); ?>" method="post" class="mt-auto">
                                                    <a title="Delete my profile image" href="<?php echo url_for('/jobmap/users/delete_profile_img.php?user_id=' . h(u($pimgid))); ?>" class="btn btn-red btn-md btn-block mt-auto" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete image</a>
                                                </form>
                                            <?php }
                                            else {?>
                                                <a target=""><img class="float-left mb-2" alt="No profile image found! Add a profile image" title="No profile image found! Add a profile image" src="<?php echo url_for('/jobmap/users/uploads/profile_imgs/no_profile_img.png'); ?>"></a>
                                                <small class="card-text text-danger mb-2">No profile image found!</small>
                                            <?php }
                                        }
                                    }
                                } else {
                                    $_SESSION['attempt_message'] = 'No user!';
                                    redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
                                }?>

                                <?php if(is_logged_in()){
                                    $pimg = find_user_profile($user_id);
                                }
                                else{
                                    $pimg = find_user_profile($_SESSION['user_id']);
                                }
                                if ($pimg['profile_img_status'] != 1) {?>
                                    <h3>Upload your profile image<i class="fas fa-info-circle fa-md ml-2" data-toggle="tooltip" data-html="true" title="Preferred dimensions:</br> <b>128 x 128px.</b></br>Maximum file size:</br><b>1Mb.</b></br>Allowed file types:</br><b>gif, jpg, or png.</b>"></i></h3>
                                    <form class="needs-validation form-inline mt-auto" novalidate action="<?php echo url_for('/jobmap/users/upload_profile_img.php?user_id='.h(u($user_id))); ?>" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div id="fileSelectBtn" title="Select a profile image" onclick="getPimgFile()">Select profile image</div>
                                                    <input type="file" name="file" id="filePimg" class="form-control-file mb-2" onchange="pimgSub(this)">
                                                    <div class="invalid-feedback mb-2" id="pimgError1" style="display:none;">Invalid file format! File must be <b>gif</b>, <b>jpg</b> or <b>png</b>.</div>
                                                    <div class="invalid-feedback mb-2" id="pimgError2" style="display:none;">File size exceeded! Maximum file size limit is <b>2MB!</b></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-block btn-green mt-auto" name="submitPimg" title="Upload profile image"><i class="fas fa-file-upload fa-lg mr-2"></i>Upload image</button>
                                    </form>
                                    <script>
                                    function getPimgFile() {
                                        document.getElementById("filePimg").click();
                                    }
                                    function pimgSub(obj){
                                        var file = obj.value;
                                        var fileName = file.split("\\");
                                        document.getElementById("fileSelectBtn").innerHTML = fileName[fileName.length-1];
                                        // document.myForm.submit();
                                        // event.preventDefault();
                                    }
                                    $('button:submit[name=submitPimg]').prop("disabled", true);
                                    var a=0;

                                    //binds to onchange event of your input field
                                    $('#filePimg').bind('change', function() {
                                    if ($('button:submit[name=submitPimg]').attr('disabled',false)){
                                        $('button:submit[name=submitPimg]').attr('disabled',true);
                                        }
                                    var pimgExt = $('#filePimg').val().split('.').pop().toLowerCase();
                                    if ($.inArray(pimgExt, ['gif','jpg','png']) == -1){
                                        $('#pimgError1').slideDown("slow");
                                        $('#pimgError2').slideUp("slow");
                                        a=0;
                                        }else{
                                            var pimgSize = (this.files[0].size);
                                            if (pimgSize > 2000000){
                                                $('#pimgError2').slideDown("slow");
                                                a=0;
                                            }else{
                                                a=1;
                                                $('#pimgError2').slideUp("slow");
                                            }
                                            $('#pimgError1').slideUp("slow");
                                            if (a==1){
                                                $('button:submit[name=submitPimg]').attr('disabled',false);
                                            }
                                        }
                                    });
                                    </script>
                                <? }
                                else { ?>
                                <?php }?>
                            </div>
                            <div class="col-md-7 d-flex flex-column">
                                <?php while ($user = mysqli_fetch_assoc($user_set)) {?>
                                    <a title="Edit my profile" href="<?php echo url_for('/jobmap/users/edit_user.php?user_id=' . h(u($user['id']))); ?>" class="btn btn-orange btn-md float-right mb-3" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit profile</a>
                                    <h4><?php echo h($user['first_name']); ?> <?php echo h($user['last_name']); ?></h4>
                                    <h4><?php echo h($user['email']); ?></h4>
                                    <h4><b>What I'm looking for:</b></h4>
                                    <?php if($user['job_prefs'] != "") { ?>
                                        <h5><?php echo h($user['job_prefs']); ?></h5>
                                    <?php }
                                    else { ?>
                                        <h5><i>Edit profile to note the kind of things your looking for in a job.</i></h5>
                                    <?php } ?>
                                    <a title="Delete my profile" href="<?php echo url_for('/jobmap/users/delete_user.php?user_id=' . h(u($user['id']))); ?>" class="btn btn-red btn-md btn-block mt-auto" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete profile</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MY PROFILE END -->

            <!-- MY CV START -->
            <div class="col-md-4 d-flex flex-column">
                <div class="card text-dark border-blue mb-4 h-100">
                    <div class="card-header text-white bg-blue">
                        <h4 class="my-0"><i class="fas fa-id-card fa-lg mr-2"></i>My CV</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <small class="card-text">Watch the <a title="Watch 'How to write a powerful CV' video" href="" data-toggle="modal" data-target="#myModal">"<u>How to write a powerful CV</u>"</a> video</small>
                        <small class="card-text"><a title="Download an MS Word CV template" href="<?php echo url_for('/jobmap/PONToon_CV_template_example.docx'); ?>"><u>Download an MS Word CV template</a></u></small>
                        <?php
                        $sql = "SELECT * FROM users ";
                        if (is_logged_in()) {
                            $sql .= "WHERE id='$user_id' ";
                                // $sql .= "AND first_name='$user_fn' ";
                        } else {
                            $sql .= "WHERE id='$_SESSION[user_id]' ";
                            $sql .= "AND first_name='$_SESSION[first_name]' ";
                        }
                        $sql .= "LIMIT 1";
                        $result = mysqli_query($db, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $cvid = $row['id'];
                                $fullName = $row['first_name'] . $row['last_name'];
                                $sqlCv = "SELECT * FROM usercvs WHERE userid='$cvid'";
                                $resultCv = mysqli_query($db, $sqlCv);
                                while ($rowCv = mysqli_fetch_assoc($resultCv)) {
                                    if ($rowCv['status'] == 1) {
                                        $filename = "uploads/cvs/cv" . $cvid . "*";
                                        $fileinfo = glob($filename); //glob is function that searches for a specific file with part of the name we're looking for e.g. cv3-janesmith.xxx
                                        $fileExt = explode(".", $fileinfo[0]);
                                        $fileActualExt = $fileExt[1];?>

                                        <a class="my-2" target="_blank" title="View / Download my CV." href="<?php echo url_for('/jobmap/users/uploads/cvs/cv' . h(u($cvid)) . '-' . h(u($fullName)) . '.' . h(u($fileActualExt)) . '?' . mt_rand() . ''); ?>"><img src="<?php echo url_for('/jobmap/users/uploads/cvs/has-cv.png'); ?>"></a>
                                        <form action="<?php echo url_for('/jobmap/users/delete_cv.php?user_id='.$user_id); ?>" method="post" class="mt-auto">
                                            <a title="Delete My CV" href="<?php echo url_for('/jobmap/users/delete_cv.php?user_id=' . h(u($cvid))); ?>" class="btn btn-red btn-md btn-block" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete CV</a>
                                        </form>
                                    <?php }
                                    else {?>
                                        <a class="my-2" target=""><img alt="No CV found! Upload a CV" title="No CV found! Upload a CV" src="<?php echo url_for('/jobmap/users/uploads/cvs/no-cv.png'); ?>"></a>
                                        <small class="card-text text-danger mb-2">No CV file found!</small>
                                        <h3>Upload your CV<i class="fas fa-info-circle fa-md ml-2" data-toggle="tooltip" data-html="true" title="Maximum file size:</br><b>2Mb.</b></br>Allowed file types:</br><b>pdf, doc, or docx.</b>"></i></h3>
                                    <?php }
                                }
                            }
                        }
                        else {
                        // nothing to show
                        } ?>
                        <?php if (is_logged_in()) {
                            $usercv = find_user_cv($user_id);
                        } else {
                            $usercv = find_user_cv($_SESSION['user_id']);
                        }
                        if ($usercv['status'] != 1) {?>
                            <form class="needs-validation form-inline mt-auto" novalidate action="<?php echo url_for('/jobmap/users/upload_cv.php?user_id='.h(u($user_id))); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div id="cvfileSelectBtn" title="Select a CV file" onclick="getCVFile()">Select CV file</div>
                                    <input type="file" name="file" id="fileCV" class="form-control-file mb-2" onchange="fileCVSub(this)">
                                    <div class="invalid-feedback mb-2" id="cvError1" style="display:none;">Invalid file format! File must be <b>pdf</b>, <b>doc</b> or <b>docx</b>.</div>
                                    <div class="invalid-feedback mb-2" id="cvError2" style="display:none;">File size exceeded! Maximum file size is <b>2MB!</b></div>
                                </div>
                                <button type="submit" class="btn btn-block btn-green mt-auto" name="submitCV"><i class="fas fa-file-upload fa-lg mr-2"></i>Upload CV</button>
                            </form>
                            <script>
                            function getCVFile() {
                                document.getElementById("fileCV").click();
                            }
                            function fileCVSub(obj){
                                var file = obj.value;
                                var fileName = file.split("\\");
                                document.getElementById("cvfileSelectBtn").innerHTML = fileName[fileName.length-1];
                                // document.myForm.submit();
                                // event.preventDefault();
                            }
                            $('button:submit[name=submitCV]').prop("disabled", true);
                            var a=0;
                            //binds to onchange event of your input field
                            $('#fileCV').bind('change', function() {
                            if ($('button:submit[name=submitCV]').attr('disabled',false)){
                                $('button:submit[name=submitCV]').attr('disabled',true);
                                }
                            var cvExt = $('#fileCV').val().split('.').pop().toLowerCase();
                            if ($.inArray(cvExt, ['pdf','doc','docx']) == -1){
                                $('#cvError1').slideDown("slow");
                                $('#cvError2').slideUp("slow");
                                a=0;
                                }else{
                                    var cvSize = (this.files[0].size);
                                    if (cvSize > 2000000){
                                        $('#cvError2').slideDown("slow");
                                        a=0;
                                    }else{
                                        a=1;
                                        $('#cvError2').slideUp("slow");
                                    }
                                    $('#cvError1').slideUp("slow");
                                    if (a==1){
                                        $('button:submit[name=submitCV]').attr('disabled',false);
                                    }
                                }
                            });
                            </script>
                        <?php }
                        else {?>
                        <?php }?>
                    </div>
                </div>
            </div>
            <!-- MY CV END -->
        </div>
        <!-- ROW END -->


        <!-- MY SAVED JOBS START -->
        <?php if (isset($_POST['submit'])) {
            $_SESSION['job_id'] = $_POST['job_id'];
            // $user['user_id'] = $_POST['user_id'];
            $result = insert_user_job();
            if ($result === true) {
                $_SESSION['message'] = 'This job has been saved.';
                redirect_to(url_for('/jobmap/users/index.php'));
            } else {
                $errors = $result;
            }
        }
        if (isset($_GET['job_id'], $_GET['user_id'])) {
            $_SESSION['job_id'] = $_GET['job_id'];
            $_SESSION['user_id'] = $_GET['user_id'];
            $job_id = $_SESSION['job_id'];
            $job = find_user_job($job_id);
            if (empty($job)) {
                $result = insert_user_job();
            } else {
                // do nothing
            }
        }?>

        <div class="card border-blue">
            <div class="card-header text-white bg-blue">
                <h4 class="my-0"><i class="fas fa-clipboard-list fa-lg mr-2"></i>My saved jobs</h4>
            </div>
            <?php $userjob_set = find_jobs_by_user_id($user_id);
            if (mysqli_num_rows($userjob_set) > 0) {?>
            <div class="accordion" id="savedJobList">
                <div class="card text-dark border-0">
                <p class="p-1 mb-0">Click a job title to view the details.</p>
                <?php while ($userjob = mysqli_fetch_assoc($userjob_set)) {?>
                    <!-- Company Modal -->
                    <div class="modal fade" id="myModal<?php echo h($userjob['company_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <?php $recruiter_company_set = show_recruiter_company_modal($userjob['company_id']);
                            while ($recruiter_company = mysqli_fetch_assoc($recruiter_company_set)) {?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo h($recruiter_company['company_name']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="company_logo_thumb mb-1" src="<?php echo url_for('/jobmap/recruiters/companies/logos/' . h($recruiter_company['logo']) . ''); ?>" alt="<?php echo h($recruiter_company['company_name']); ?>" title="<?php echo h($recruiter_company['company_name']); ?>" />
                                        <p class="mb-1"><?php echo h($recruiter_company['company_desc']); ?></p>
                                        <small class="text-muted"><?php echo h($recruiter_company['location']); ?></small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            <?php }?>
                            <?php mysqli_free_result($recruiter_company_set);?>
                        </div>
                    </div>
                    <?php
                    $allowed_job_desc_tags = '<h1><h2><h3><p><br><strong><b><i><em><ul><ol><li>'; // This is a string and NOT an array!!
                    $_SESSION['job_id'] = $userjob['job_id'];
                    $_SESSION['job_title'] = $userjob['job_title'];
                    $_SESSION['rec_email'] = $userjob['rec_email'];
                    $jobDesc = $userjob['job_desc'];
                    $excerpt = getExcerpt($jobDesc, 0, 150);
                    $dateNow = date("Y-m-d");
                    // echo $dateNow;
                    $job_post_date = $userjob['job_posted'];
                    // $job_post_date = date("l jS F Y",strtotime($job_post_date));
                    $job_post_relative_date = relative_date(strtotime($job_post_date));

                    $job_post_date_ending = $userjob['date_ending'];
                    // $job_post_date = date("l jS F Y",strtotime($job_post_date));
                    $job_post_ending_relative_date = job_ending_relative_date(strtotime($job_post_date_ending));
                    // echo 'Job Posted ' . $userjob['job_posted'] . ' Job Post End ' . $userjob['date_ending'];

                    $sent_date = $userjob['applic_sent_date'];
                    $sent_date = date("l jS F Y", strtotime($sent_date));
                    $my_relative_sent_date = relative_date(strtotime($sent_date));
                    ?>
                    <?php if ($userjob['visible'] == "false" || $userjob['co_vis'] == "false" || $userjob['applic_sent'] == "0" && $userjob['date_ending'] < $dateNow) {?>
                        <div class="card-header text-white bg-secondary pb-0" type="button" id="jobHeader" data-toggle="collapse" title="View job details" data-target="#jobid<?php echo h($userjob['job_id']); ?>" aria-expanded="false" aria-controls="jobid<?php echo h($userjob['job_id']); ?>" title="This job has ended!">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-capitalize"><i class="fas fa-chevron-down mr-2"></i><?php echo h($userjob['job_title']); ?><span class="small ml-4">[This job has ended!]</span></h4>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-left text-sm-left"><i class="fas fa-calendar-alt fa-lg mr-2"></i>Posted: <?php echo h($job_post_relative_date); ?></h5>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-right text-sm-right"><?php echo h($job_post_ending_relative_date); ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($userjob['visible'] == "false" || $userjob['co_vis'] == "false" || $userjob['applic_sent'] == "1" && $userjob['date_ending'] < $dateNow) {?>
                        <div class="card-header text-white bg-green pb-0" type="button" id="jobHeader" data-toggle="collapse" title="View job details" data-target="#jobid<?php echo h($userjob['job_id']); ?>" aria-expanded="false" aria-controls="jobid<?php echo h($userjob['job_id']); ?>" title="This job has ended!">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-capitalize"><i class="fas fa-chevron-down mr-2"></i><?php echo h($userjob['job_title']); ?><span class="small ml-4">[Application Sent] <?php echo h($my_relative_sent_date); ?></span></h4>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-left text-sm-left"><i class="fas fa-calendar-alt fa-lg mr-2"></i>Posted: <?php echo h($job_post_relative_date); ?></h5>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-right text-sm-right"><?php echo h($job_post_ending_relative_date); ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($userjob['visible'] == "false" || $userjob['co_vis'] == "false" || $userjob['applic_sent'] == "1" && $userjob['date_ending'] > $dateNow) {?>
                        <div class="card-header text-white bg-green pb-0" type="button" id="jobHeader" data-toggle="collapse" title="View job details" data-target="#jobid<?php echo h($userjob['job_id']); ?>" aria-expanded="false" aria-controls="jobid<?php echo h($userjob['job_id']); ?>" title="This job has ended!">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-capitalize"><i class="fas fa-chevron-down mr-2"></i><?php echo h($userjob['job_title']); ?><span class="small ml-4">[Application Sent] <?php echo h($my_relative_sent_date); ?></span></h4>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-left text-sm-left"><i class="fas fa-calendar-alt fa-lg mr-2"></i>Posted: <?php echo h($job_post_relative_date); ?></h5>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-right text-sm-right"><?php echo h($job_post_ending_relative_date); ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="card-header text-white bg-blue pb-0" type="button" id="jobHeader" data-toggle="collapse" title="View job details" data-target="#jobid<?php echo h($userjob['job_id']); ?>" aria-expanded="false" aria-controls="jobid<?php echo h($userjob['job_id']); ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="text-capitalize"><i class="fas fa-chevron-down mr-2"></i><?php echo h($userjob['job_title']); ?><span class="small ml-4">[Job Open] </h4>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-left text-sm-left"><i class="fas fa-calendar-alt fa-lg mr-2"></i>Posted: <?php echo h($job_post_relative_date); ?></h5>
                                </div>
                                <div class="col-sm-3">
                                    <h5 class="text-md-right text-sm-right"><?php echo h($job_post_ending_relative_date); ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <div id="jobid<?php echo h($userjob['job_id']); ?>" class="collapse" aria-labelledby="jobHeader" data-parent="#savedJobList">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8 mb-4">
                                    <img class="mb-2 mr-2" src="<?php echo url_for('/jobmap/images/icons/jobsector_icons/' . h($userjob['jsector_icon'])); ?>" alt="Job sector: <?php echo h($userjob['jobsector_name']); ?>" title="Job sector: <?php echo h($userjob['jobsector_name']); ?>" /></a>
                                    <p class="card-text mb-1" title="Job location"><i class="fas fa-map-marker-alt fa-lg mr-2"></i><?php echo h($userjob['job_location']); ?> (<?php echo h(round($userjob['distance'], 1, PHP_ROUND_HALF_UP)); ?> miles)</p>

                                    <p class="card-text mb-1" title="Salary and rate" class="mb-1">
                                    <?php if ($userjob['currency_id'] == '1') {?>
                                        <i class="fas fa-pound-sign fa-lg mr-2"></i>
                                    <?php } else if ($userjob['currency_id'] == '2') {?>
                                        <i class="fas fa-euro-sign fa-lg mr-2"></i>
                                    <?php } else {?>
                                        <i class="fas fa-dollar-sign fa-lg mr-2"></i>
                                    <?php } ?>
                                    <?php $format_salary = number_format($userjob['salary'], 2);?><?php echo h($format_salary); ?> (<?php echo h($userjob['alphacode']); ?>)

                                    <?php echo h($userjob['jobrate_name']); ?></p>
                                    <p class="card-text mb-2" title="Job type"><i class="fas fa-user-clock fa-lg mr-2"></i><?php echo h($userjob['jobtype_name']); ?>
                                    <p class="card-text"><?php echo strip_tags($excerpt, $allowed_job_desc_tags); ?>
                                </div>
                                <div class="col-sm-4">
                                    <a href="javascript:;" title="View company information" data-toggle="modal" data-target="#myModal<?php echo h($userjob['company_id']); ?>"><h5 class="card-title text-lg-right text-md-right"><i class="fas fa-building fa-lg mr-2"></i><?php echo h($userjob['company_name']); ?></h5>
                                    <img class="company_logo_thumb float-lg-right float-md-right mb-1" src="<?php echo url_for('/jobmap/recruiters/companies/logos/' . h($userjob['logo'])); ?>" alt="<?php echo h($userjob['company_name']); ?>" title="<?php echo h($userjob['company_name']); ?>" /></a>
                                </div>
                            </div>

                            <?php if ($userjob['visible'] == "false" || $userjob['co_vis'] == "false" || $userjob['date_ending'] < $dateNow) {?>
                                <a class="btn btn-red btn-block text-white disabled" href="users/index.php" role="button"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>This job has ended!</a>
                            <?php } else {?>
                                <a title="View Job Details" href="<?php echo url_for('/jobmap/users/job_details.php?job_id=' . h(u($userjob['job_id']))); ?>" class="btn btn-blue btn-block btn-md" role="button"><i class="fas fa-eye fa-lg mr-2"></i>View job details</a>
                            <?php }?>

                            <?php if ($userjob['applic_sent'] == "1") {?>
                                <a class="btn btn-green btn-block mt-2 text-dark disabled" href="" role="button"><i class="fas fa-check fa-lg mr-2"></i>Application sent - <?php echo h($my_relative_sent_date); ?></a>
                            <?php } else {
                                if ($userjob['visible'] == "false" || $userjob['co_vis'] == "false" || $userjob['date_ending'] < $dateNow) {?>
                                    <a class="btn btn-green btn-block mt-2 d-none" href="" role="button"><i class="fas fa-envelope-open fa-lg mr-2"></i>Apply now</a>
                                <?php } else {?>
                                    <a class="btn btn-green btn-block mt-2" href="<?php echo url_for('/jobmap/apply_now.php?job_id=' . h(u($userjob['job_id']))); ?>" role="button"><i class="fas fa-envelope-open fa-lg mr-2"></i>Apply now</a>
                                <?php }
                            }?>
                            <a title="Remove this job" href="<?php echo url_for('/jobmap/users/jobs/remove_job.php?job_id=' . h(u($userjob['job_id']))); ?>" class="btn btn-red btn-block mb-3" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Remove this job</a>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <?php }
        else {?>
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">You have not saved any jobs yet!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <?php }?>
        <!-- MY SAVED JOBS END -->
    </div><!--Jumbotron Container -->
</div><!--Container -->

<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        $(function () { // jQuery ready
            // On blur validation listener for form elements
            $('.needs-validation').find('input,select,textarea').on('focus', function () {
                // check element validity and change class
                $(this).removeClass('is-valid is-invalid')
                .addClass(this.checkValidity() ? 'is-valid' : 'is-invalid');
            });
        });
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<?php mysqli_free_result($user_set);?>
<?php mysqli_free_result($userjob_set);?>
<?php include SHARED_PATH . '/public_footer.php';?>