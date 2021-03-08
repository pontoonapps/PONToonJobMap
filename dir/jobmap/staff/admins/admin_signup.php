<?php require_once('../../../private/initialize.php');

require_login();

if(is_post_request()) {
  $admin = [];
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['password'] = $_POST['password'] ?? '';
  $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = insert_admin($admin);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    create_admin_email_token($admin['email']);
    pa_email_email_token($admin['email']);
    // $_SESSION['message'] = 'Admin account has been created.';
    // redirect_to(url_for('/jobmap/staff/admins/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $admin = [];
  $admin["first_name"] = '';
  $admin["last_name"] = '';
  $admin["email"] = '';
  $admin['password'] = '';
  $admin['confirm_password'] = '';
}

?>

<?php $page_title = 'Create Admin Account'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border shadow">
    <a title="Back to Admins List" href="<?php echo url_for('/jobmap/staff/admins/user_accounts.php'); ?>" class="btn btn-blue btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Back to Accounts List</a>
    <h1>Create Admin</h1>
    <?php echo display_errors($errors); ?>

        <form id="newAdminForm" class="needs-validation" novalidate action="<?php echo url_for('/jobmap/staff/admins/admin_signup.php'); ?>" method="post">
            <div class="form-group">
                <label for="validationFirstName">&ast; First name</label>
                <input type="text" autocomplete="given-name" pattern="[A-Za-z0-9-]{2,40}" class="form-control border-teal" id="validationFirstName" name="first_name" value="<?php echo h($admin['first_name']); ?>" required />
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Please provide your first name!</div>
            </div>
            <div class="form-group">
                <label for="validationLastName">&ast; Last name</label>
                <input type="text" autocomplete="family-name" pattern="[A-Za-z0-9-]{2,60}" class="form-control border-blue" id="validationLastName" name="last_name" value="<?php echo h($admin['last_name']); ?>" required />
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Please provide your last name!</div>
            </div>
            <div class="form-group">
                <label for="validationEmail">&ast; Email</label>
                <input type="email" autocomplete="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" class="form-control border-green" id="validationEmail" name="email" value="<?php echo h($admin['email']); ?>" required />
                <div class="valid-feedback">Format is ok.</div>
                <?php echo display_email_error($errors); ?>
                <div class="invalid-feedback">Please provide a valid email address!</div>
            </div>
            <div class="form-group">
                <label for="validationPassword">&ast; Password<small id="password" class="form-text text-muted alert-info p-1">Passwords must be 8 characters or more and include at least one uppercase letter, one lowercase letter, one number and one symbol.</small></label>
                <input type="password" autocomplete="new-password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\xa3\x21-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e])[A-Za-z\d\xa3\x21-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{8,}" class="form-control border-orange" id="validationPassword" name="password" value="" required />
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Please provide a valid password!</div>
            </div>
            <div class="form-group">
                <label for="validationConfirmPassword">&ast; Confirm Password</label>
                <input type="password" autocomplete="new-password" class="form-control border-red mb-2" id="validationConfirmPassword" name="confirm_password" value="" required />
                <div class="valid-feedback">Passwords match!</div>
                <div class="invalid-feedback">Confirm password must match!</div>
            </div>
            <button type="submit" class="btn btn-green mt-2" name="submit"><i class="fas fa-check fa-lg mr-2"></i>Create My Account</button>
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
