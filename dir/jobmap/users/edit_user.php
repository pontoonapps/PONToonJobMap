<?php require_once('../../private/initialize.php');

require_user_login();

if($_GET['user_id'] != ($_SESSION['user_id'])) {
  $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
  redirect_to(url_for('/jobmap/users/index.php'));
} else {
    $user_id = $_GET['user_id'];
}

if(is_post_request()) {
    $user = [];
    $user['id'] = $user_id;
    $user['first_name'] = $_POST['first_name'] ?? '';
    $user['last_name'] = $_POST['last_name'] ?? '';
    $user['email'] = $_POST['email'] ?? '';
    $user['job_prefs'] = $_POST['job_prefs'] ?? '';

    $result = update_user($user);
    if($result === true) {
        $_SESSION['message'] = 'Your profile details have been updated.';
        redirect_to(url_for('/jobmap/users/index.php?user_id=' . $user_id));
    } else {
        $errors = $result;
    }
} else {
    $user = find_user_by_id($user_id);
}
?>

<?php $page_title = 'Update my profile'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-blue shadow">
      <?php echo display_errors($errors); ?>

        <div class="card border-blue mb-4">
            <div class="card-header text-white bg-blue">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Edit personal details</h3>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/users/edit_user.php?user_id=' . h(u($user_id))); ?>" method="post">
                    <div class="form-group">
                        <label for="validationFirstName">&ast; First name</label>
                        <input type="text" autocomplete="given-name" pattern="[A-Za-z0-9-]{2,40}" class="form-control" id="validationFirstName" name="first_name" value="<?php echo h($user['first_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide your first name!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationLastName">&ast; Last name</label>
                        <input type="text" autocomplete="family-name" pattern="[A-Za-z0-9-]{2,60}" class="form-control" id="validationLastName" name="last_name" value="<?php echo h($user['last_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide your last name!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationEmail">&ast; Email </label>
                        <input type="email" autocomplete="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control" id="validationEmail" name="email" value="<?php echo h($user['email']); ?>" required />
                        <div class="valid-feedback">Format is ok.</div>
                        <?php echo display_email_error($errors); ?>
                        <div class="invalid-feedback">Please provide a valid email address!</div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="validationJobPrefs">What I'm looking for... [Optional]</label>
                        <p class="small">Use this space to note the kind of things your looking for in a job. [300 characters or less]</p>
                        <textarea name="job_prefs" type="text" class="form-control" id="validationJobPrefs" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{0,300}" rows="3" placeholder="For example: Full time, permanent position, minimum of £8.21 per hour, jobs in a 10 mile radius of my address. - Par exemple: temps plein, poste permanent, minimum de £ 8,21 par heure, emplois dans un rayon de 10 miles de mon adresse." maxlength="300"><?php echo h($user['job_prefs']); ?></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Invalid response or format!</div>
                    </div>

                    <button type="submit" class="btn btn-green" name="submit"><i class="fas fa-check fa-lg mr-2"></i>Update</button>
                    <a class="btn btn-secondary mb-1 float-right" href="<?php echo url_for('/jobmap/users/index.php?user_id='.h(u($user_id))); ?>" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
                </form>
            </div>
        </div>
        <div class="card border-blue">
            <div class="card-header text-white bg-blue">
                <h3 class="my-1"><i class="fas fa-key fa-lg mr-2"></i>Reset password</h3>
            </div>
            <div class="card-body">
                <p class="alert alert-info">To reset your password, please click the password key below.</p>
                <p><a title="Click here to reset your password" href="<?php echo url_for('/request_reset_password.php');?>"><i class="fas fa-key fa-lg mr-2"></i>Reset my password.</a></p>
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
    $('.needs-validation').find('input,select,textarea').on('blur', function () {
        // check element validity and change class
        $(this).removeClass('is-valid is-invalid')
               .addClass(this.checkValidity() ? 'is-valid' : 'is-invalid');
               document.getElementById('emailError').remove();
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

$('#job_prefs').keyup(validateTextarea);

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
            $(textarea).toggleClass('is-invalid', !!hasError);
            $(textarea).toggleClass('is-valid', !hasError);
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
