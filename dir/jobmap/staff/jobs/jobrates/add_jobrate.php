<?php require_once('../../../../private/initialize.php');

require_login();

$jobrate_set = find_all_jobrates();
mysqli_free_result($jobrate_set);

if(is_post_request()) {

    $jobrate = [];
    $jobrate['jobrate_name'] = $_POST['jobrate_name'] ?? '';

    $result = insert_jobrate($jobrate);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = 'The Job Rate was created sucessfully.';
        redirect_to(url_for('/jobmap/staff/jobs/jobrates/show_jobrate.php?jobrate_id=' . $new_id));
    } else {
        $errors = $result;
    }
} else {
    $jobrate = [];
    $jobrate['jobrate_name'] = '';
}

?>

<?php $page_title = 'Create Job Rate'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <a title="Cancel. Go back to Job Rates list" href="<?php echo url_for('/jobmap/staff/jobs/jobrates/index.php'); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>

        <h1>Create Job Rate</h1>
        <?php echo display_errors($errors); ?>

        <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/staff/jobs/jobrates/add_jobrate.php'); ?>" method="post">
            <div class="form-group">
                <label for="validationJobRateName">Job Rate:</label>
                <input type="text" pattern="[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,}" class="form-control" id="validationJobRateName" name="jobrate_name" class="form-control mb-3" name="jobrate_name" value="<?php echo h($jobrate['jobrate_name']); ?>" required />
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Please provide a valid job rate!</div>

                <button type="submit" class="btn btn-blue mt-4" name="submit"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Rate</button>
            </div>
        </form>
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
