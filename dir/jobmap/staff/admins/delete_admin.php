<?php require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['admin_id'])) {
  redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
}
$admin_id = $_GET['admin_id'];

$admin = find_admin_by_id($admin_id);
if ($admin['id'] != $_SESSION['admin_id']) {
  $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
  redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
}

if(is_post_request()) {
  $result = admin_disable_admin($admin_id);
  $_SESSION['message'] = 'Admin account disabled successfully.';
  redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
} else {
  $admin = find_admin_by_id($admin_id);
}

?>

<?php $page_title = 'Disable admin account'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Delete admin account</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="text-uppercase"><b>You are about to delete this admin account. Are you sure?</b></h4>
                <p>If not, please click <b>Cancel</b> now.</p>
                <p class="lead">The account to be deleted is: <b><?php echo h($admin['first_name'] . ' ' .$admin['last_name']); ?></b></p>
            </div>
        </div>
        <form action="<?php echo url_for('/jobmap/staff/admins/delete_admin.php?admin_id=' . h(u($admin['id']))); ?>" method="post">
            <a title="Cancel and return to admin accounts list" href="<?php echo url_for('/jobmap/staff/admins/user_accounts.php'); ?>" class="btn btn-secondary btn-md mt-4 mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button title="Yes I'm sure. Please delete this account." type="submit" class="btn btn-red mt-4 float-right" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete admin</button>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
