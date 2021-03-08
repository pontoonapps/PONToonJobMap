<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Staff Menu'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border shadow">
    <?php echo display_session_message();
    echo display_session_attempt_message();?>
    <h1 class="display-4">Hello, <?php echo $_SESSION['admin_first_name'] ?? ''; ?></h1>
    <p class="lead">This account represents a Super Administrator.</p>
    <hr class="my-2">
    <p>It provides a method for managing all user accounts, companies, jobs and job sectors.</p>
    <p class="lead">
    </p>
    <div class="list-group">
      <a href="<?php echo url_for('/jobmap/staff/admins/user_accounts.php'); ?>" class="list-group-item list-group-item-action bg-teal text-dark mb-2"><i class="fas fa-users fa-fw fa-lg mr-2"></i>User Accounts</a>
      <a href="<?php echo url_for('/jobmap/staff/jobs/jobsectors/index.php'); ?>" class="list-group-item list-group-item-action  bg-blue text-dark mb-2"><i class="fas fa-industry fa-fw fa-lg mr-2"></i>Jobs Sectors</a>
      <a href="<?php echo url_for('/jobmap/staff/jobs/jobtypes/index.php'); ?>" class="list-group-item list-group-item-action  bg-green text-dark mb-2"><i class="fas fa-industry fa-fw fa-lg mr-2"></i>Job Types</a>
      <a href="<?php echo url_for('/jobmap/staff/jobs/jobrates/index.php'); ?>" class="list-group-item list-group-item-action  bg-orange text-dark mb-2"><i class="fas fa-industry fa-fw fa-lg mr-2"></i>Job Rates</a>
      <a href="<?php echo url_for('/jobmap/staff/admins/admin_map.php'); ?>" class="list-group-item list-group-item-action  bg-red text-dark mb-3"><i class="fas fa-map-marked fa-fw fa-lg mr-2"></i>Jobs Map</a>
      <a class="btn btn-secondary btn-md float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
    </div>
  </div>
</div>


<?php include(SHARED_PATH . '/public_footer.php'); ?>
