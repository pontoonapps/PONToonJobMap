<?php require_once('../private/initialize.php');

$page_title = 'Job Map - Password reset requested';
include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border shadow">
      <h1>Job Map - Password reset requested</h1>
      <?php if ($_SESSION['message'] != ""){
        echo display_session_message();
      } else {
      redirect_to(url_for('/jobmap/index.php'));
      }
      ?>
      <p><b>Please note: </b>If you do not recieve the message within a few minutes, please check your Junk E-mail or Spam folder, in case the email got delivered there.</p>
  </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
