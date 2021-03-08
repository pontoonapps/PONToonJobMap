<?php require_once '../../../private/initialize.php';

require_recruiter_login();

//$company_set = find_all_recruiter_companies();
// $company_count = mysqli_num_rows($company_set) + 1;
//mysqli_free_result($company_set);

if (is_post_request()) {

 $company = [];
 $company['recruiter_id'] = $_SESSION['recruiter_id'] ?? '';
 $company['visible'] = $_POST['visible'] ?? '';
 $company['company_name'] = $_POST['company_name'] ?? '';
 $company['company_desc'] = $_POST['company_desc'] ?? '';
 $company['location'] = $_POST['location'] ?? '';
 // $company['logo'] = $_FILES['logo']['name'] ?? '';
 // $company_logo_tmp['logo'] = $_FILES['logo']['tmp_name'] ?? '';

 $result = insert_recruiter_company($company);
 if ($result === true) {
  $new_id = mysqli_insert_id($db);
  // move_uploaded_file($company_logo_tmp['logo'],"logos/{$company['logo']}");

  $_SESSION['message'] = 'The company was created sucessfully.';
  redirect_to(url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . $new_id));
 } else {
  $errors = $result;
 }
} else {
 // display the blank form
 $company = [];
 $company["recruiter_id"] = '';
 $company["visible"] = '';
 $company["company_name"] = '';
 $company["company_desc"] = '';
 $company["location"] = '';
 // $company["logo"] = '';
}
?>

<?php $page_title = 'Recruiter - Create new company account';?>
<?php include SHARED_PATH . '/public_header.php';?>

<div class="container">
    <div class="jumbotron border shadow">
        <?php echo display_errors($errors); ?>
        <a title="Back to Company List" href="<?php echo url_for('/recruiters/index.php'); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Cancel</a>

        <div class="card border-orange">
            <div class="card-header text-white bg-orange">
                <h3 class="my-1"><i class="fas fa-plus fa-lg mr-2"></i>Create company</h3>
            </div>
            <div class="card-body">
                <form id="newCompanyForm" class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/companies/new_company.php'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="company_name" value="<?php echo h($company['recruiter_id']); ?>" />
                    </div>
                    <div class="form-group">
                        <label for="validationCompanyName">&ast; Company Name:</label>
                        <input type="text" pattern="[a-zA-Z0-9 àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ'-]{2,}" class="form-control" id="validationCompanyName" name="company_name" value="<?php echo h($company['company_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid company name!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationCompanyDesc">&ast; Company Description:</label>
                        <p class="small">Add a brief description about your company. [500 characters or less]</p>
                        <textarea name="company_desc" class="form-control" id="validationCompanyDesc" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{0,500}" rows="3" placeholder="Add a brief description about your company." maxlength="500" required ><?php echo h($company['company_desc']); ?></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid company description!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationLocation">&ast; Location:</label>
                        <input type="text" pattern="[a-zA-Z0-9 àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ',-]{3,}" class="form-control" id="validationLocation" name="location" value="<?php echo h($company['location']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid location!</div>
                    </div>
                    <div class="form-group">
                        <p><b>Set Company Active?</b></p>
                        <input type="hidden" class="form-control" name="visible" value="false" />
                        <label class="switch">
                            <input type="checkbox" class="form-check-input" name="visible" value="true" <?php if ($company['visible'] == "true") {echo " checked";}?> />
                            <span class="slider"></span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-orange mt-2" name="submit"><i class="fas fa-plus fa-lg mr-2"></i>Create Company</button>
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

<?php include SHARED_PATH . '/public_footer.php';?>
