<?php require_once("../private/initialize.php"); ?>
<?php

$message = "";
$errors = [];
$token = $_GET['token'];
// $rectoken = $_GET['rectoken'];

// Confirm that the token sent is valid
$recruiter = find_recruiter_with_token($token);

if(!isset($recruiter)) {
    // Token wasn't sent or didn't match a user.
    redirect_to('forgot_password.php');
}

if(is_post_request() && request_is_same_domain()) {

    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $errors[] = "Sorry, request was not valid.";
    } else {
        // CSRF tests passed--form was created by us recently.
        // retrieve the values submitted via the form
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        if(!has_presence($password) || !has_presence($password_confirm)) {
            $errors[] = "Password and Confirm Password are required fields.";
        } elseif(!has_length($password, ['min' >= 8])) {
            $errors[] = "Password must be at least 8 characters long.";
        } elseif(!has_format_matching($password, '/[^A-Za-z0-9]/')) {
            $errors[] = "Password must contain at least one character which is not a letter or a number.";
        } elseif($password !== $password_confirm) {
            $errors[] = "Password confirmation does not match password.";
        } else {
            // password and password_confirm are valid
            // Hash the password and save it to the fake database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $recruiter['hashed_password'] = $hashed_password;
            update_recruiter_password($recruiter);
            delete_reset_token($recruiter['email']);
            $_SESSION['message'] = 'Your password has been reset. Please login using your new password.';
            redirect_to('login.php');
        }
    }
}
?>

<?php $page_title = 'Reset Password'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border shadow">
        <?php if($errors != "") {
            echo display_errors($errors);
        } ?>

        <h1>Set your new password.</h1>

        <?php $url = "reset_rec_password.php?token=" . u($token); ?>
        <form id="recPasswordReset" class="needs-validation" novalidate action="<?php echo $url; ?>" method="POST" accept-charset="utf-8">
            <?php echo csrf_token_tag(); ?>
            <div class="form-group">
                <label for="validationPassword">Password<small id="password" class="form-text text-muted alert-info p-1">Passwords must be 8 characters or more and include at least one uppercase letter, one lowercase letter, one number and one symbol.</small></label>
                <input type="password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\xa3\x21-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e])[A-Za-z\d\xa3\x21-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{8,}" class="form-control" id="validationPassword" name="password" value="" required />
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Please provide a valid password!</div>
            </div>
            <div class="form-group">
                <label for="validationConfirmPassword">Confirm Password</label>
                <input type="password" class="form-control mb-2" id="validationConfirmPassword" name="confirm_password" value="" required />
                <div class="valid-feedback">Passwords match!</div>
                <div class="invalid-feedback">Confirm password must match!</div>
            </div>
            <button type="submit" class="btn btn-blue" name="submit">Set Password<i class="fas fa-angle-right fa-lg ml-2"></i></button>
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

var password = document.getElementById("validationPassword");
var confirm_password = document.getElementById("validationConfirmPassword");

function validatePassword(){
    if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords don't match!");
    } else {
        confirm_password.setCustomValidity('');
    }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

</script>

<?php include(SHARED_PATH . '/public_footer.php'); ?>