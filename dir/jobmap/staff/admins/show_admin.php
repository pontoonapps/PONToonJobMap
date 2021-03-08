<?php require_once('../../../private/initialize.php');

require_login();

$admin_id = $_GET['admin_id'] ?? '1'; // PHP > 7.0
$admin = find_admin_by_id($admin_id);

if ($admin['id'] != $_SESSION['admin_id']) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
}

?>

<?php $page_title = 'Show Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-teal shadow">
    <?php echo display_session_message(); ?>

    <a title="Back to Admin accounts list" href="<?php echo url_for('/jobmap/staff/admins/user_accounts.php'); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Admin accounts</a>

    <div class="card border-teal">
        <div class="card-header bg-teal text-white ">
            <h3 class="my-1"><i class="fas fa-user fa-lg mr-2"></i>Admin contact details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                  <h4>Full name: <?php echo h($admin['first_name']); ?> <?php echo h($admin['last_name']); ?></h4>
                  <h4>Email: <?php echo h($admin['email']); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <a title="Edit admin account" href="<?php echo url_for('/jobmap/staff/admins/edit_admin.php?admin_id=' . h(u($admin['id']))); ?>" class="btn btn-teal mt-2 btn-md" role="button"><i class="fas fa-edit fa-lg mr-2"></i>Edit admin</a>

    <a title="Delete admin account" href="<?php echo url_for('/jobmap/staff/admins/delete_admin.php?admin_id=' . h(u($admin['id']))); ?>" class="btn btn-red btn-md mt-2 float-right" role="button"><i class="fas fa-trash-alt fa-lg mr-2"></i>Delete admin</a>
  </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
