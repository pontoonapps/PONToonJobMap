<?php require_once('../private/initialize.php');?>
<script>
//Using setTimeout to execute a function after 5 seconds.
setTimeout(function () {
   //Redirect with JavaScript
   window.location.href= 'https://pontoonapps.com/';
}, 10000);
</script>

<?php $page_title = 'Farewell Job Seeker!'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php if ($_GET['cu'] != ""){
  echo display_session_message();
} else {
  redirect_to(url_for('/index.php'));
}
?>
<div class="container">
    <div class="jumbotron border-green shadow">
        <div class="card border-green">
            <div class="card-header text-white bg-green">
                <h1 class="my-1"><i class="fas fa-handshake fa-lg mr-2"></i>Farewell Job Seeker!!</h1>
            </div>
            <div class="card-body alert-success">
                <h1>We wish you all the very best for the future.</h1>
                <p>If you do decide to return to us at a later date, just click Sign Up.</p>
                <h2 class="mb-4">Good bye.</h2>
                <p><i>You will be redirected to PONToon Apps EU in 10 seconds. If you are not, please <a href="<?php echo url_for('/index.php'); ?>">click here.
            </div>
        </div>
    </div>
</div>
<?php include(SHARED_PATH . '/public_footer.php'); ?>