<?php require_once('../private/initialize.php');
//require_user_login();
?>

<?php $page_title = 'Job Map Registration'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border shadow">
      <h1>Job Map Registration</h1>
      <?php if ($_SESSION['message'] != ""){
        echo display_session_message();
      } else {
      redirect_to(url_for('/index.php'));
      }
      ?>
      <p><b>Please note: </b>If you do not recieve the message within a few minutes of signing up, please check your Junk E-mail or Spam folder, just in case the email got delivered there instead of your inbox.</p>
  </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
