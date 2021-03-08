<?php require_once('../../../private/initialize.php');

if (is_logged_in()) {
    if (!isset($_GET['job_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

$job_id = $_GET['job_id'];
$job = find_recruiter_job_by_id($job_id);

if(!isset($_GET['job_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
}

if (is_logged_in()) {
    if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
} else {
    if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/recruiters/index.php?rec_id=' . h(u($_SESSION['recruiter_id']))));
    }
}

$job_vid = find_job_vid_by_id($job_id);
if($job_vid){
    $_SESSION['attempt_message'] = 'A video already exists for this job! Please delete it first before trying to upload a new video!';
    redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id . ''));
}

use jobseekerphp\UploadFile;

$_SESSION['job_id'] = $job_id;

require_once 'src/jobseekerphp/UploadFile.php';
if (!isset($_SESSION['maxfiles'])) {
    $_SESSION['maxfiles'] = ini_get('max_file_uploads');
    $_SESSION['postmax'] = UploadFile::convertToBytes(ini_get('post_max_size'));
    $_SESSION['displaymax'] = UploadFile::convertFromBytes($_SESSION['postmax']);
}
$max = 2048 * 1024;
$result = array();
if (isset($_POST['upload'])) {

    $vidDesc['video_desc'] = $_POST['video_desc'] ?? '';

    $destination = __DIR__ . '/videos/'; // Get a fully qualified path using the PHP Constant __DIR__, then the path is a relative one.

    try {
        $upload = new UploadFile($destination);
        $upload->setMaxSize($max);
        // $upload->allowAllTypes('mysuffix');   // ('mysuffix') = add a custom suffix to allow risky filetypes, or ('') allow but no suffix would be added to risky files!, or comment this line out completely to allow all types unrestricted
        $upload->upload();
        $result = $upload->getMessages();
    } catch (Exception $e) {
        $result[] = $e->getMessage();
    }
}
else {
    $vidDesc['video_desc'] = '';
}
$error  = error_get_last();
?>

<?php $page_title = 'Submit job video'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-orange">
        <div class="card border-orange">
            <div class="card-header text-white bg-orange">
                <h3>Submit job video - <?php echo $job['job_title'];?></h3>
            </div>
            <div class="card-body">
                <?php if ($result || $error) { ?>
                    <ul class="list-group">
                        <?php
                        if ($error) {
                            echo "<li class='list-group-item list-group-item-warning mb-3'>{$error['message']}</li>";// Getting assoc array so wrap variable in {}
                        }
                        if ($result) {
                            foreach ($result as $message) {
                                echo "<li class='list-group-item list-group-item-danger mb-3'>$message</li>";
                            }
                        }
                        ?>
                    </ul>
                <?php } ?>
                <form id="submitVideo" class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/jobs/add_job_video.php?job_id=' . h(u($_GET['job_id'])).'&rec_id='.h(u($_SESSION['recruiter_id']))); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max;?>">
                    <div class="form-group mt-2">
                        <label for="filename"><b>Video:</b></label>
                        <div id="fileSelectBtn" title="Select a job video" onclick="getFile()">Select a job video</div>
                        <input type="file" name="filename" id="filename"
                        data-maxfiles="<?php echo $_SESSION['maxfiles'];?>"
                        data-postmax="<?php echo $_SESSION['postmax'];?>"
                        data-displaymax="<?php echo $_SESSION['displaymax'];?>" onchange="sub(this)">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback" id="vidError1" style="display:none;">Invalid file format! File format must be either an <b>mp4</b>, <b>webm</b>, <b>mov</b>, <b>avi</b> or <b>wmv</b>.</div>
                        <div class="invalid-feedback" id="vidError2" style="display:none;">File size exceeded! Maximum file size limit is <b>2MB!</b></div>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <p>Your video file should be no more than <b><?php echo UploadFile::convertFromBytes($max);?>.</b></p>
                        <p class="mb-0"><b>File formats accepted:</b></p>
                        <p class="mb-0">.MP4, .WEBM, .MOV, .AVI & .WMV</p>
                    </div>

                    <div class="form-group mt-2">
                        <label for="validationVideoDesc"><b>Video details: </b><span class="small">Add some information that describes what the video is about. [500 characters or less]</span></label><br>
                        <textarea class="form-control" rows="3" id="validationVideoDesc" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{0,500}" placeholder="Add some information that describes what the video is about. - Ajouter des informations décrivant ce que la vidéo est sur le point." maxlength="500" name="video_desc" required><?php echo h($vidDesc['video_desc']); ?></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a video description!</div>
                    </div>

                    <button type="submit" class="btn btn-orange" name="upload"><i class="fas fa-upload fa-lg mr-2"></i>Submit video</button>

                    <a class="btn btn-secondary mb-1 float-right" href="<?php echo url_for('/jobmap/recruiters/jobs/show_job.php?job_id='.$job_id.''); ?>" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
                </form>
                <script>
                function getFile() {
                    document.getElementById("filename").click();
                }
                function sub(obj){
                    var file = obj.value;
                    var fileName = file.split("\\");
                    document.getElementById("fileSelectBtn").innerHTML = fileName[fileName.length-1];
                    // document.myForm.submit();
                    // event.preventDefault();
                }
                $('button:submit[name=upload]').prop("disabled", true);
                var a=0;

                //binds to onchange event of your input field
                $('#filename').bind('change', function() {
                if ($('button:submit[name=upload]').attr('disabled',false)){
                    $('button:submit[name=upload]').attr('disabled',true);
                    }
                var filenameExt = $('#filename').val().split('.').pop().toLowerCase();
                if ($.inArray(filenameExt, ['mp4','webm','mov', 'avi', 'wmv']) == -1){
                    $('#vidError1').slideDown("slow");
                    $('#vidError2').slideUp("slow");
                    a=0;
                    }else{
                        var vidFileSize = (this.files[0].size);
                        if (vidFileSize > 2000000){
                            $('#vidError2').slideDown("slow");
                            a=0;
                        }else{
                            a=1;
                            $('#vidError2').slideUp("slow");
                        }
                        $('#vidError1').slideUp("slow");
                        if (a==1){
                            $('button:submit[name=upload]').attr('disabled',false);
                        }
                    }
                });
                </script>
            </div>
        </div>
    </div>
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
