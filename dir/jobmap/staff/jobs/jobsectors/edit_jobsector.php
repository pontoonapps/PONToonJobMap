<?php require_once('../../../../private/initialize.php');

require_login();

if(!isset($_GET['jobsector_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/staff/jobs/jobsectors/index.php'));
}
$jobsector_id = $_GET['jobsector_id'];

if(is_post_request()) {

    // Handle form values sent by new.php

    $jobsector = [];
    $jobsector['id'] = $jobsector_id;
    $jobsector['jobsector_name'] = $_POST['jobsector_name'] ?? '';

    $result = update_jobsector($jobsector);
    if($result === true) {
        $_SESSION['message'] = 'The Job Sector was updated successfully.';
        redirect_to(url_for('/jobmap/staff/jobs/jobsectors/index.php?jobsector_id=' . $jobsector_id));
    } else {
        $errors = $result;
    }
} else {
    $jobsector = find_jobsector_by_id($jobsector_id);
}
//$job_count = count_jobs_by_company_id($job['company_id']);
?>

<?php $page_title = 'Edit Job Sector'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-blue shadow">
        <?php echo display_errors($errors); ?>
        <a title="Back to Jobs Sectors list" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/index.php'); ?>" class="btn btn-blue btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Job Sectors</a>
        <a class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>

        <div class="card border-blue">
            <div class="card-header bg-blue text-white">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Edit Job Sector</h3>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/staff/jobs/jobsectors/edit_jobsector.php?jobsector_id=' . h(u($jobsector_id))); ?>" method="post">
                    <div class="form-group">
                        <label for="validationJobSector">&ast; Job Sector name</label>
                        <input type="text" pattern="[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,}" class="form-control" id="validationJobSector" name="jobsector_name" value="<?php echo h($jobsector['jobsector_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid job sector name!</div>

                        <button type="submit" class="btn btn-green mt-4" name="submit"><i class="fas fa-check fa-lg mr-2"></i>Update</button>

                        <a title="Cancel and return to Jobs Sector list" class="btn btn-secondary float-right mt-4" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/index.php'); ?>"  role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
                    </div>
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
</script>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
