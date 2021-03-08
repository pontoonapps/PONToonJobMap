<?php require_once '../../../private/initialize.php';?>
<?php $page_title = 'Recruiter - Add a job';?>
<?php include SHARED_PATH . '/public_header.php';?>
<script>
  $( function() {
      var date = $("#validationDateEnding").datepicker({ dateFormat:'yy-mm-dd'}).val();
      $('.ui-datepicker').addClass('notranslate');
      $( "#validationDateEnding" ).datepicker({dateFormat:"yy-mm-dd"})
      .on('changeDate', function(ev) {
            $(this).valid();  // triggers the validation test
            // '$(this)' refers to '$("#datepicker")'
        });
  } );
</script>

<?php
if (is_logged_in()) {
    if (!isset($_GET['co_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
    }
}

require_recruiter_login();

$co_id = $_GET['co_id'];
$dateNow = date("Y-m-d");

$company = find_company_by_id($co_id);

if (!isset($_GET['co_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
}

if (is_post_request()) {

    $job = [];
    $job['company_id'] = $co_id ?? '';
    $job['recruiter_id'] = $_SESSION['recruiter_id'] ?? '';
    $job['job_title'] = $_POST['job_title'] ?? '';
    $jobsector['jobsector_id'] = $_POST['jobsector_id'] ?? '';
    $job['job_desc'] = $_POST['job_desc'] ?? '';
    $jobtype['jobtype_id'] = $_POST['jobtype_id'] ?? '';
    $job['salary'] = $_POST['salary'] ?? '';
    $jobrate['jobrate_id'] = $_POST['jobrate_id'] ?? '';
    $currency['currency_id'] = $_POST['currency_id'] ?? '';
    $job['job_location'] = $_POST['job_location'] ?? '';
    $job['visible'] = $_POST['visible'] ?? '';
    $job['lat'] = $_POST['lat'] ?? '';
    $job['lng'] = $_POST['lng'] ?? '';
    $job['city'] = $_POST['city'] ?? '';
    $job['date_ending'] = $_POST['date_ending'] ?? '';

    $_SESSION['theLocation'] = $job['job_location'];
    $_SESSION['theLat'] = $job['lat'];
    $_SESSION['theLng'] = $job['lng'];

    // $theLoc = $_SESSION['theLocation'];
    // $theLat = $_SESSION['theLat'];
    // $theLng = $_SESSION['theLng'];

    $result = insert_recruiter_job($job, $jobsector, $jobtype, $jobrate, $currency);
    if ($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = 'The job was created sucessfully.';
        redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $new_id));
    } else {
        $errors = $result;

        unset($_SESSION['theLocation']);
        unset($_SESSION['theLat']);
        unset($_SESSION['theLng']);

    }
} else {
    $job = [];
    $job['company_id'] = $_GET['company_id'] ?? '1';
    $job['recruiter_id'] = '';
    $job['job_title'] = '';
    $jobsector['jobsector_id'] = '';
    $job['job_desc'] = '';
    $jobtype['jobtype_id'] = '';
    $job['salary'] = '';
    $jobrate['jobrate_id'] = '';
    $currency['currency_id'] = '';
    $job['job_location'] = '';
    $job['visible'] = '';
    $job['lat'] = '';
    $job['lng'] = '';
    $job['city'] = '';
    $job['date_ending'] = $dateNow;

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
}
?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_errors($errors);?>
        <a title="Cancel. Go back to company jobs list" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($company['id']))); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>

        <div class="card border-orange mb-4">
            <div class="card-header text-white bg-orange">
                <h3 class="my-1"><i class="fas fa-plus fa-lg mr-2"></i>Add job</h3>
            </div>
            <div class="card-body">
                <form id="newJobForm" class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/jobs/add_job.php?co_id=' . h(u($company['id']))); ?>" method="post">
                    <div class="form-group">
                    <h3><?php echo h($company['company_name']);?></h3>
                    </div>

                    <div class="form-group">
                        <label for="validationJobTitle"><b>&ast; Job Title:</b></label>
                        <input type="text" pattern="[a-zA-Z0-9 àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\x27\x28\x29\x2d\x2f]{4,}" class="form-control" id="validationJobTitle" name="job_title" value="<?php echo h($job['job_title']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid job title!</div>
                    </div>

                    <div class="form-group">
                        <label for="validationJobSector"><b>&ast; Job Sector:</b></label>
                        <select class="custom-select" id="validationJobSector" name="jobsector_id" id="jobsector_id" required>
                        <option value="">Select Job Sector</option>
                        <?php
                        $query = "SELECT * FROM jobsectors ORDER BY jobsector_name ASC";
                        $results = mysqli_query($db, $query);
                        $_SESSION['jobsector_id'] = $jobsector['jobsector_id'];
                        $_POST['jobsector_id'] = $_SESSION['jobsector_id'];
                        //loop
                        foreach ($results as $jobsector): ?>
                        <option value="<?php echo h($jobsector['id']); ?>"
                        <?php if ($jobsector['id'] == $_POST['jobsector_id']){echo " selected";}?>>
                        <?php echo h($jobsector['jobsector_name']); ?>
                        </option>
                        <?php endforeach;
                        unset ($_SESSION['jobsector_id']); ?>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please select a job sector!</div>
                    </div>

                    <div class="form-group">
                        <label for="validationJobType"><b>&ast; Job Type:</b></label>
                        <select class="custom-select" id="validationJobType" name="jobtype_id" required>
                        <option value="">Select Job Type</option>
                        <?php
                        $query = "SELECT * FROM jobtypes ORDER BY jobtype_name ASC";
                        $results = mysqli_query($db, $query);
                        $_SESSION['jobtype_id'] = $jobtype['jobtype_id'];
                        $_POST['jobtype_id'] = $_SESSION['jobtype_id'];
                        //loop
                        foreach ($results as $jobtype): ?>
                        <option value="<?php echo h($jobtype['id']); ?>"
                        <?php if ($jobtype['id'] == $_POST['jobtype_id']){echo " selected";}?>>
                        <?php echo h($jobtype['jobtype_name']); ?>
                        </option>
                        <?php endforeach;
                        unset ($_SESSION['jobtype_id']); ?>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please select a job type!</div>
                    </div>

                    <div class="form-group">
                        <label for="validationSalary"><b>&ast; Salary: </b><span class="small"><b>Between 1 and 6 digits followed by a decimal point and 2 digits. E.g. 8.00 - 888888.00</b></span></label>
                        <input type="text" pattern="(?!(\.|0))(?!\.?$)\d{0,6}(\.\d{2})" class="form-control" id="validationSalary" name="salary" value="<?php echo h($job['salary']); ?>" placeholder="8.00" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Invalid input! Please match the format requested.</div>
                    </div>

                    <div class="form-group">
                        <label for="validationCurrency"><b>&ast; Currency:</b></label>
                        <select class="custom-select" id="validationCurrency" name="currency_id" required>
                        <option value="">Select Currency</option>
                        <?php
                        $query = "SELECT * FROM currency ORDER BY id ASC";
                        $results = mysqli_query($db, $query);
                        $_SESSION['currency_id'] = $currency['currency_id'];
                        $_POST['currency_id'] = $_SESSION['currency_id'];
                        //loop
                        foreach ($results as $currency): ?>
                        <option value="<?php echo h($currency['id']); ?>"
                        <?php if ($currency['id'] == $_POST['currency_id']){echo " selected";}?>>
                        <?php echo h($currency['alphacode']); ?>
                        </option>
                        <?php endforeach;
                        unset ($_SESSION['currency_id']); ?>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please select a currency!</div>
                    </div>

                    <div class="form-group">
                        <label for="validationJobRate"><b>&ast; Job Rate:</b></label>
                        <select class="custom-select" id="validationJobRate" name="jobrate_id" required>
                        <option value="">Select Job Rate</option>
                        <?php
                        $query = "SELECT * FROM jobrates ORDER BY jobrate_name ASC";
                        $results = mysqli_query($db, $query);
                        $_SESSION['jobrate_id'] = $jobrate['jobrate_id'];
                        $_POST['jobrate_id'] = $_SESSION['jobrate_id'];
                        //loop
                        foreach ($results as $jobrate): ?>
                        <option value="<?php echo h($jobrate['id']); ?>"
                        <?php if ($jobrate['id'] == $_POST['jobrate_id']){echo " selected";}?>>
                        <?php echo h($jobrate['jobrate_name']); ?>
                        </option>
                        <?php endforeach;
                        unset ($_SESSION['jobrate_id']); ?>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please select a job rate!</div>
                    </div>

                    <div class="form-group">
                        <label for="validationJobDesc"><b>&ast; Job Description: </b><span class="small">Minimum 3 characters. Accepts the following HTML tags: &lt;h1&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;br&gt;, &lt;strong&gt;, &lt;b&gt;, &lt;i&gt;, &lt;em&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;</b></span></label>
                        <textarea name="job_desc" class="form-control" id="validationJobDesc" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{3,}" cols="60" rows="10" required><?php echo h($job['job_desc']); ?></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Invalid input! Please match the format requested.</div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="validationDateEnding"><b>&ast; Date Ending: </b><span class="small">Click below to select a date</b></span></label>
                        <input type="text" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" class="form-control" id="validationDateEnding" placeholder="" name="date_ending" value="<?php echo h($job['date_ending']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Invalid input! Please match the format requested.</div>
                    </div>

                    <div class="form-group">
                        <label for="map-search"><b>&ast; Location: </b><span class="small">Enter location and select the desired result. <b>You can also click and drag the marker to update the precise location.</b></span></label>
                        <input type="text" name="job_location" id="map-search" class="form-control" placeholder="Enter location and select the desired result." size="104" value="<?php echo h($job['job_location']); ?>" autocomplete="off" onkeydown="onkeypressed(event, this);" required></label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please select a location!</div>
                    </div>

                    <div class="form-group form-inline flex-nowrap">
                        <label for="lat" class="mr-2"><b>Latitude: </b></label>
                        <input type="text" name="lat" id="lat" class="form-control-plaintext latitude mr-2 disabled" value="<?php echo h($job['lat']); ?>" readonly="readonly">
                        <label for="lng" class="mr-2"><b>Longitude: </b></label>
                        <input type="text" name="lng" id="lng" class="form-control-plaintext longitude mr-2 disabled" value="<?php echo h($job['lng']); ?>" readonly="readonly">
                        <label for="city" class="mr-2"><b>City: </b></label>
                        <input type="text" name="city" id="city" class="form-control-plaintext reg-input-city disabled" value="<?php echo h($job['city']); ?>" readonly="readonly">
                    </div>

                    <!--Google Map Container -->
                    <div>
                        <div id="map"></div>
                    </div>
                    <!--Google Map Container -->
                    <div class="form-group mt-4">
                        <p><b>Status:</b></p>
                        <input type="hidden" class="form-control" name="visible" value="false" />
                        <label class="switch">
                        <input type="checkbox" class="form-check-input" name="visible" value="true" <?php if($job['visible'] == "true") { echo " checked"; } ?> />
                        <span class="slider"></span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-orange mt-2" name="submit"><i class="fas fa-plus fa-lg mr-2"></i>Create Job</button>

                    <a title="Cancel. Go back to company jobs list" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($_GET['co_id']))); ?>" class="btn btn-secondary btn-md mb-2 float-right" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include SHARED_PATH . '/js_gmaps_places_new_job.php';?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<script>
function onkeypressed(evt, input) {
    var code = evt.charCode || evt.keyCode;
    if (code == 27) {
        input.value = '';
    }
    if (code == 13) {
        evt.preventDefault();
    }
}
</script>
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
$('#validationJobDesc').keyup(validateTextarea);

function validateTextarea() {
    var errorMsg = "Please match the format requested.";
    var textarea = this;
    var pattern = new RegExp('^' + $(textarea).attr('pattern') + '$');
    // check each line of text
    $.each($(this).val().split("\n"), function () {
        // check if the line matches the pattern
        var hasError = !this.match(pattern);
        if (typeof textarea.setCustomValidity === 'function') {
            textarea.setCustomValidity(hasError ? errorMsg : '');

        } else {
            // Not supported by the browser, fallback to manual error display...
            $(textarea).toggleClass('is-invalid', !!hasError);
            $(textarea).toggleClass('is-valid', !hasError);
            if (hasError) {
                $(textarea).attr('title', errorMsg);
            } else {
                $(textarea).removeAttr('title');
            }
        }
        return !hasError;
    });
}
</script>
<?php include SHARED_PATH . '/public_footer.php';
