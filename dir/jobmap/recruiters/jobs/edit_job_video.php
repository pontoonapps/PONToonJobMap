<?php require_once('../../../private/initialize.php');

if (is_logged_in()) {
    if (!isset($_GET['job_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

$job_id = $_GET['job_id'];
$job = find_job_vid_by_id($job_id);

if (!isset($_GET['job_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id=' . h(u($_SESSION['recruiter_id']))));
}

// $_SESSION['job_id'] = $job_id;

if(is_post_request()) {
    // Handle form values sent by show_job.php
    $job = [];
    $job['job_id'] = $job_id;
    $job['video_desc'] = $_POST['video_desc'] ?? '';

    $result = update_job_video($job);
    if($result === true) {
        $_SESSION['message'] = 'The job video description was updated sucessfully.';
        redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id));
    } else {
        $errors = $result;
    }
} else {
    if(is_logged_in()){
        if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
            $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
            redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
        }
    }
    else{
        if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
            $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
            redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
        }
    }
}
?>

<?php $page_title = 'Edit Job Video'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <div class="card border-orange">
            <div class="card-header text-white bg-orange">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Edit video description [<?php echo $job['job_title'];?>]</h3>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/jobs/edit_job_video.php?job_id=' . h(u($job_id))); ?>" method="post">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video class="embed-responsive-item mb-2" controls poster="" src="videos/<?php echo h($job['video_filename']); ?>" allowfullscreen></video>
                    </div>
                    <div class="form-group mt-2">
                        <label for="validationVideoDesc"><b>Video description: </b></label><br>
                        <textarea class="form-control" rows="3" id="validationVideoDesc" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{0,500}" placeholder="Please provides some information that describes what the video is about." maxlength="500" name="video_desc" required><?php echo h($job['video_desc']); ?></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a video description!</div>
                    </div>
                    <button title="Update job video description" type="submit" class="btn btn-green" name="upload"><i class="fas fa-check fa-lg mr-2"></i>Update</button>
                    <a class="btn btn-secondary mb-1 float-right" href="<?php echo url_for('/jobmap/recruiters/jobs/show_job.php?job_id='.$job_id.''); ?>" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
                </form>
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
