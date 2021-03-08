<?php require_once('../../../../private/initialize.php');

require_login();

$jobtype_set = find_all_jobtypes();
mysqli_free_result($jobtype_set);

if(is_post_request()) {

    $jobtype = [];
    $jobtype['jobtype_name'] = $_POST['jobtype_name'] ?? '';

    $result = insert_jobtype($jobtype);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = 'The Job Type was created sucessfully.';
        redirect_to(url_for('/jobmap/staff/jobs/jobtypes/show_jobtype.php?jobtype_id=' . $new_id));
    } else {
        $errors = $result;
    }
} else {
    $jobtype = [];
    $jobtype['jobtype_name'] = '';
}

?>

<?php $page_title = 'Add Job Type'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-green shadow">
        <?php echo display_errors($errors); ?>
        <a title="Cancel. Go back to Job Types list" href="<?php echo url_for('/jobmap/staff/jobs/jobtypes/index.php'); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>

        <div class="card border-green">
            <div class="card-header bg-green text-white">
                <h3 class="my-1"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Type</h3>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/staff/jobs/jobtypes/add_jobtype.php'); ?>" method="post">
                    <div class="form-group">
                        <label for="validationJobTypeName">&ast; Job Type name</label>
                        <input type="text" pattern="[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ]{2,}" class="form-control" id="validationJobTypeName" name="jobtype_name" class="form-control mb-3" name="jobtype_name" value="<?php echo h($jobtype['jobtype_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid job type name!</div>

                        <button type="submit" class="btn btn-green mt-4" name="submit"><i class="fas fa-plus fa-lg mr-2"></i>Add Job Type</button>
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
