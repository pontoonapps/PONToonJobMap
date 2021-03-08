<?php require_once('../../../private/initialize.php');

require_recruiter_login();

$co_id = $_GET['co_id'];

$company = find_company_by_id($co_id);

if(!isset($_GET['co_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id=' . h(u($_SESSION['recruiter_id']))));
} else {
}

if(is_post_request()) {
    // Handle form values sent by new_job.php
    $company = [];
    $company['id'] = $co_id;
    $company['recruiter_id'] = $_SESSION['recruiter_id'];
    $company['company_name'] = $_POST['company_name'] ?? '';
    $company['company_desc'] = $_POST['company_desc'] ?? '';
    $company['location'] = $_POST['location'] ?? '';

    $result = update_company($company);
    if($result === true) {
            $_SESSION['message'] = 'Your company information has been updated successfully.';
            redirect_to(url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . $co_id));
    } else {
        $errors = $result;
        var_dump($errors);
    }
} else {
    if(is_logged_in()){
        if ($company['recruiter_id'] != $_SESSION['recruiter_id']) {
            $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
            redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
        }
    }
    else {
        if ($company['recruiter_id'] != $_SESSION['recruiter_id']) {
            $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
            redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
        }
    }
}

?>

<?php $page_title = 'Edit Company'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<script src="<?php echo url_for('/jobmap/js/co_viz.js');?>"></script>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_errors($errors); ?>
        <a title="Cancel and return to my company account" href="<?php echo url_for('/jobmap/recruiters/companies/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
        <?php if (is_logged_in()) {?>
            <a title="Logout" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
        <?php } else {?>
            <a title="Back to My Account" class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/recruiters/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
        <?php }?>

        <div class="card border-orange mb-4">
            <div class="card-header text-white bg-orange">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Edit company information</h3>
            </div>
            <div class="card-body">
                <form id="editCompanyForm" class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/companies/edit_company.php?co_id=' . h(u($co_id))); ?>" method="post">
                    <div class="form-group">
                        <label for="validationCompanyName"><b>&ast; Company name: </b><span class="small">Minimum 2 characters. '-' (hyphens) and ['] apostrophies allowed.</span></label>
                        <input type="text" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\x20\x27\x2d]{2,}" class="form-control" id="validationCompanyName" name="company_name" value="<?php echo h($company['company_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid company name!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationCompanyDesc"><b>&ast; Company Description:</b></label>
                        <p class="small">Add a brief description about your company. [500 characters or less]</p>
                        <textarea name="company_desc" class="form-control" id="validationCompanyDesc" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{0,500}" rows="3" placeholder="Add a brief description about your company." maxlength="500" required ><?php echo h($company['company_desc']); ?></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a company description!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationLocation"><b>&ast; Location: </b><span class="small">Minimum 3 characters. '-' (hyphens) and ['] apostrophies allowed.</span></label>
                        <input type="text" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\x20\x27\x2d]{3,}" class="form-control" id="validationLocation" name="location" value="<?php echo h($company['location']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid location!</div>
                    </div>
                    <div class="form-group">
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
                    <button type="submit" class="btn btn-green" name="submit"><i class="fas fa-check fa-lg mr-2"></i>Update</button>
                    <a title="Cancel and return to my company account" class="btn btn-secondary mb-1 float-right" href="<?php echo url_for('/jobmap/recruiters/companies/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
                </form>
            </div>
        </div>
    <!-- COMPANY LOGO START -->
    <div class="card border-orange">
        <div class="card-header text-white bg-orange">
            <h3 class="my-1"><i class="fas fa-image fa-lg mr-2"></i>Company logo</h3>
        </div>
        <div class="card-body p-4">
                <div class="row">
                <div class="col-sm-4">
                    <?php
                    $sql = "SELECT * FROM companies ";
                    $sql .= "INNER JOIN recruiters ";
                    $sql .= "ON recruiters.id = recruiter_id ";
                    $sql .= "WHERE recruiter_id='$_SESSION[recruiter_id]' ";
                    // $sql .= "AND email='$_SESSION[recruiter_email]' ";
                    $sql .= "LIMIT 1";
                    $result = mysqli_query($db, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $rec_id = $row['recruiter_id'];
                            $co_name = $row['company_name'];
                            $_SESSION['co_id'] = $co_id;
                            $_SESSION['company_name'] = $co_name;
                            $_SESSION['co_logo'] = $row['logo'];
                            // echo $_SESSION['co_id'];
                            // exit;
                            $sqlLogo = "SELECT * FROM companies ";
                            $sqlLogo .= "WHERE recruiter_id='$_SESSION[recruiter_id]' ";
                            $sqlLogo .= "LIMIT 1";
                            $resultLogo = mysqli_query($db, $sqlLogo);
                            while ($row = mysqli_fetch_assoc($resultLogo)) {
                                if ($row['logo_status'] == 1) { ?>
                                    <?php $filename = "logos/".$row['logo']."";
                                    $fileinfo = glob($filename); //glob is function that searches for a specific file with part of the name we're looking for e.g. rec2-bobbyjones.xxx
                                    $fileExt = explode(".", $fileinfo[0]);
                                    $fileActualExt = $fileExt[1]; ?>
                                    <img class="company_logo_med mb-4" alt="<?php echo h($row['company_name']); ?> logo" title="<?php echo h($row['company_name']); ?> logo" src="<?php echo url_for('/jobmap/recruiters/companies/logos/'.h($row['logo']).'?'.mt_rand().'');?>">
                                    <form action="<?php echo url_for('/jobmap/recruiters/companies/delete_logo.php'); ?>" method="post">
                                        <a title="Delete company logo" href="<?php echo url_for('/jobmap/recruiters/companies/delete_logo.php?co_id=' . h(u($co_id))); ?>" class="btn btn-red btn-md btn-block" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete logo</a>
                                    </form>
                                <?php  }
                                else { ?>
                                    <img class="company_logo_med" src="<?php echo url_for('/jobmap/recruiters/companies/logos/no_company_logo.png');?>" alt="Upload your company logo!" title="Upload your company logo!">
                                    <p><small class="card-text text-danger mb-2">No company logo found!</small></p>

                                    </div>
                                    <div class='col-sm-8'>
                                        <h2>Upload company logo</h2>
                                        <p class="card-text mb-0">Maximum file size: <b>1MB.</b></p>
                                        <p class="card-text">Allowed file formats: <b>gif, jpg or png</b>.</p>

                                        <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/companies/upload_logo.php?co_id='.$co_id);?>" method="post" enctype="multipart/form-data">
                                            <!-- <div class="form-inline"> -->
                                                <div class="form-group mb-2">
                                                    <div id="fileSelectBtn" title="Select a company logo" onclick="getFile()">Select company logo</div>
                                                    <input id="coImg" type="file" name="file" class="form-control-file" onchange="sub(this)">
                                                    <div class="invalid-feedback" id="coImgError1" style="display:none;">Invalid file format! File format must be <b>gif</b>, <b>jpg</b> or <b>png</b>.</div>
                                                    <div class="invalid-feedback" id="coImgError2" style="display:none;">File size exceeded! Maximum file size limit is <b>1MB!</b></div>
                                                </div>
                                                <button type="submit" name="submitCoLogo" class="btn btn-green" name="submit"><i class="fas fa-file-upload fa-lg mr-2"></i>Upload Logo</button>
                                            <!-- </div> -->
                                        </form>
                                        <script>
                                        function getFile() {
                                            document.getElementById("coImg").click();
                                        }
                                        function sub(obj){
                                            var file = obj.value;
                                            var fileName = file.split("\\");
                                            document.getElementById("fileSelectBtn").innerHTML = fileName[fileName.length-1];
                                            // document.myForm.submit();
                                            // event.preventDefault();
                                        }
                                        $('button:submit[name=submitCoLogo]').prop("disabled", true);
                                        var a=0;

                                        //binds to onchange event of your input field
                                        $('#coImg').bind('change', function() {
                                        if ($('button:submit[name=submitCoLogo]').attr('disabled',false)){
                                            $('button:submit[name=submitCoLogo]').attr('disabled',true);
                                            }
                                        var coImgExt = $('#coImg').val().split('.').pop().toLowerCase();
                                        if ($.inArray(coImgExt, ['gif','jpg','png']) == -1){
                                            $('#coImgError1').slideDown("slow");
                                            $('#coImgError2').slideUp("slow");
                                            a=0;
                                            }else{
                                                var cvSize = (this.files[0].size);
                                                if (cvSize > 1000000){
                                                    $('#coImgError2').slideDown("slow");
                                                    a=0;
                                                }else{
                                                    a=1;
                                                    $('#coImgError2').slideUp("slow");
                                                }
                                                $('#coImgError1').slideUp("slow");
                                                if (a==1){
                                                    $('button:submit[name=submitCoLogo]').attr('disabled',false);
                                                }
                                            }
                                        });
                                        </script>

                                    </div>
                                <?php }
                            }
                        }
                    }
                    else {
                        // nothing to show
                    } ?>
            </div>
        </div>
    </div><!-- COMPANY LOGO END -->
</div>
<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        $(function () { // jQuery ready
            // On blur validation listener for form elements
            $('.needs-validation').find('input,select,textarea').on('focusout', function () {
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
$('#validationCompanyDesc').keyup(validateTextarea);

function validateTextarea() {
    var errorMsg = "Please match the format requested.";
    var textarea = this;
    var pattern = new RegExp('^' + $(textarea).attr('pattern') + '$');
    // check each line of text
    $.each($(this).val().split("\n"), function () {
        // check if the line matches the pattern
        var hasError = !this.match(pattern);
        if (typeof textarea.setCustomValidity === 'function') {
            textarea.setCustomValidity(hasError ? errorMsg : '');

        } else {
            // Not supported by the browser, fallback to manual error display...
            $(textarea).toggleClass('error', !!hasError);
            $(textarea).toggleClass('ok', !hasError);
            if (hasError) {
                $(textarea).attr('title', errorMsg);
            } else {
                $(textarea).removeAttr('title');
            }
        }
        return !hasError;
    });
}
</script>
<script>
        $('textarea').maxlength({
              alwaysShow: true,
              threshold: 10,
              warningClass: "badge badge-success mb-4",
              limitReachedClass: "badge badge-danger mb-4",
              separator: ' out of ',
              preText: 'You\'ve used ',
              postText: ' characters.',
              validate: true,
              appendToParent: true
        });
</script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
