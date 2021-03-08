<?php require_once('../../../private/initialize.php');

if (is_logged_in()) {
    if (!isset($_GET['co_id'])) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

$co_id = $_GET['co_id'];

if(!isset($_GET['co_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id=' . h(u($_SESSION['recruiter_id']))));
}

$company = find_company_by_id($co_id);
if (is_logged_in()) {
    if ($company['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
} else {
    if ($company['recruiter_id'] != $_SESSION['recruiter_id']) {
        $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
        redirect_to(url_for('/recruiters/index.php?rec_id=' . h(u($_SESSION['recruiter_id']))));
    }
}

if(is_post_request()) {

    $result = disable_company($co_id);
    $_SESSION['attempt_message'] = 'The request for your company account to be removed has been submitted. This is to allow time to notify Job Seekers that any jobs you may have added will be removed from their account. To cancel this operation click the red toggle switch to renable your company account.';
    redirect_to(url_for('/jobmap/recruiters/companies/index.php'));
} else {
    $company = find_company_by_id($co_id);
}
?>

<?php $page_title = 'Delete company'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <h1>Delete company</h1>
        <div class="card border-red">
            <div class="card-header text-white bg-red">
                <h3 class="my-1"><i class="fas fa-exclamation-triangle fa-lg mr-2"></i>WARNING!</h3>
            </div>
            <div class="card-body alert-danger">
                <h4 class="alert-danger text-uppercase"><b>You are about to delete your Company Account. If you have added any jobs, these will also be removed.</h4>
                <p><b>Are you sure?</b> If not, please click Cancel now.</b></p>
                <p class="lead">The company to be deleted: <b><?php echo h($company['company_name']); ?></b></p>
            </div>
        </div>

        <form action="<?php echo url_for('/jobmap/recruiters/companies/delete_company.php?co_id=' . h(u($company['id']))); ?>" method="post">
            <a title="Cancel! Return to my company account" href="<?php echo url_for('/jobmap/recruiters/companies/index.php?rec_id='.h(u($_SESSION['recruiter_id']))); ?>" class="btn btn-secondary btn-md mt-4" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
            <button title="Yes, I am sure. Please delete my company account." type="submit" class="btn btn-red float-right mt-4" name="commit"><i class="fas fa-check-double fa-lg mr-2"></i>Delete company</button>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
