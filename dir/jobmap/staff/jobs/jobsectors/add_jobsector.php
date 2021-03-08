<?php require_once('../../../../private/initialize.php');

require_login();

$jobsector_set = find_all_jobsectors();
mysqli_free_result($jobsector_set);

if(is_post_request()) {

    $jobsector = [];
    $jobsector['jobsector_name'] = $_POST['jobsector_name'] ?? '';

    $result = insert_jobsector($jobsector);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = 'The Job Sector [ ' .h($jobsector['jobsector_name']).' ] was created sucessfully.';
        redirect_to(url_for('/jobmap/staff/jobs/jobsectors/show_jobsector.php?jobsector_id=' . $new_id));
    } else {
        $errors = $result;
    }
} else {
    $jobsector = [];
    $jobsector['jobsector_name'] = '';
}

?>

<?php $page_title = 'Add Job Sector'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-blue shadow">
        <?php echo display_errors($errors); ?>
        <a title="Cancel. Go back to Job Sector list" href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/index.php'); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>

        <div class="card border-blue">
            <div class="card-header bg-blue text-white">
                <h3 class="my-1"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Sector</h3>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/staff/jobs/jobsectors/add_jobsector.php'); ?>" method="post">
                    <div class="form-group">
                        <label for="validationJobSector">&ast; Job Sector name</label>
                        <input type="text" pattern="[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,}" class="form-control mb-3" id="validationJobSector" name="jobsector_name" value="<?php echo h($jobsector['jobsector_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid job sector name!</div>
                    </div>
                    <button type="submit" class="btn btn-green mt-2" name="submit"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Sector</button>
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
