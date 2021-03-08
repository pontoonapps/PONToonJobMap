<?php require_once('../../../../private/initialize.php');

require_login();

if(!isset($_GET['jobrate_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/staff/jobs/jobrates/index.php'));
}
$jobrate_id = $_GET['jobrate_id'];

if(is_post_request()) {

    // Handle form values sent by new.php

    $jobrate = [];
    $jobrate['id'] = $jobrate_id;
    $jobrate['jobrate_name'] = $_POST['jobrate_name'] ?? '';

    $result = update_jobrate($jobrate);
    if($result === true) {
        $_SESSION['message'] = 'The job rate was updated sucessfully.';
        redirect_to(url_for('/jobmap/staff/jobs/jobrates/index.php?jobrate_id=' . $jobrate_id));
    } else {
        $errors = $result;
    }
} else {
    $jobrate = find_jobrate_by_id($jobrate_id);
}

?>

<?php $page_title = 'Edit Job Rate'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_errors($errors); ?>
        <a title="Back to Jobs Rates list" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/index.php'); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Job Rates</a>
        <a class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>

        <div class="card border-orange">
            <div class="card-header bg-orange text-white">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Edit Job Rate</h3>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/staff/jobs/jobrates/edit_jobrate.php?jobrate_id=' . h(u($jobrate_id))); ?>" method="post">
                    <div class="form-group">
                        <label for="validationJobRateName">&ast; Job Rate name</label>
                        <input type="text" pattern="[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,}" class="form-control" id="validationJobRateName" name="jobrate_name" class="form-control mb-3" name="jobrate_name" value="<?php echo h($jobrate['jobrate_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid job rate name!</div>

                        <button type="submit" class="btn btn-green mt-4" name="submit"><i class="fas fa-check fa-lg mr-2"></i>Update</button>

                        <a title="Cancel and return to Jobs Rates list" class="btn btn-secondary float-right mt-4" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/index.php'); ?>"  role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
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
