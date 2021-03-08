<?php require_once "../private/initialize.php";?>
<?php include SHARED_PATH . '/pa_home_header.php';?>
<?php if(!isset($_GET['f'])){
redirect_to(url_for('/index.php'));
}?>
<div class="container">
    <div class="jumbotron border-red shadow">
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-ban fa-lg mr-2"></i>Your account has been temporarily suspended!</h3>
            </div>
            <div class="card-body alert-danger">
                <p class="lead">Please contact <a href="mailto:support@pontoonapps.com?subject=Account suspension">support@pontoonapps.com</a> as soon as possible.</p>
            </div>
        </div>
    </div>
</div>
<?php include SHARED_PATH . '/public_footer.php';?>
