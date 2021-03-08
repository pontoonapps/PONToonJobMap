<?php require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['admin_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/staff/dashboard.php'));
}
$admin_id = $_GET['admin_id'];

if(is_post_request()) {
    $admin = [];
    $admin['id'] = $admin_id;
    $admin['first_name'] = $_POST['first_name'] ?? '';
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['email'] = $_POST['email'] ?? '';

    $result = update_admin($admin);
    if($result === true) {
        $_SESSION['message'] = 'Admin account was updated successfully.';
        redirect_to(url_for('/jobmap/staff/admins/show_admin.php?admin_id=' . $admin_id));
        } else {
        $errors = $result;
    }
} else {
    $admin = find_admin_by_id($admin_id);
    if ($admin['id'] != $_SESSION['admin_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

?>

<?php $page_title = 'Edit Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-teal shadow">
        <?php echo display_errors($errors); ?>
        <a title="Back to all Admin accounts" href="<?php echo url_for('/jobmap/staff/admins/user_accounts.php'); ?>#theAdmins" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Admin accounts</a>

        <div class="card border-teal">
            <div class="card-header bg-teal text-white">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Edit Admin</h3>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/staff/admins/edit_admin.php?admin_id=' . h(u($admin_id))); ?>" method="post">
                    <div class="form-group">
                        <label for="validationFirstName">&ast; First name</label>
                        <input type="text" pattern="[A-Za-z0-9-]{2,40}" class="form-control" id="validationFirstName" name="first_name" value="<?php echo h($admin['first_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide your first name!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationLastName">&ast; Last name</label>
                        <input type="text" pattern="[A-Za-z0-9-]{2,60}" class="form-control" id="validationLastName" name="last_name" value="<?php echo h($admin['last_name']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide your last name!</div>
                    </div>
                    <div class="form-group">
                        <label for="validationEmail">&ast; Email </label>
                        <input type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control" id="validationEmail" name="email" value="<?php echo h($admin['email']); ?>" required />
                        <div class="valid-feedback"></div>
                        <?php echo display_email_error($errors); ?>
                        <div class="invalid-feedback">Please provide a valid email address!</div>
                    </div>

                    <button type="submit" class="btn btn-green" name="submit"><i class="fas fa-check fa-lg mr-2"></i>Update</button>

                    <a title="Cancel and return to Admin accounts list" class="btn btn-secondary mb-1 float-right" href="<?php echo url_for('/jobmap/staff/admins/user_accounts.php'); ?>#theAdmins" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
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

// var password = document.getElementById("validationPassword")
//   , confirm_password = document.getElementById("validationConfirmPassword");

// function validatePassword(){
//   if(password.value != confirm_password.value) {
//     confirm_password.setCustomValidity("Passwords don't match!");
//   } else {
//     confirm_password.setCustomValidity('');
//   }
// }

// password.onchange = validatePassword;
// confirm_password.onkeyup = validatePassword;

</script>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
