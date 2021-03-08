<?php require_once('../../../private/initialize.php');?>
<?php $page_title = 'Edit Job'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<script src="<?php echo url_for('/jobmap/js/job_viz.js');?>"></script>

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


<?php require_recruiter_login();

$job_id = $_GET['job_id'];
// $dateNow = date("Y-m-d");

// $_SESSION['job_id'] = $job_id;
$job = find_recruiter_job_by_id($job_id);

if(!isset($_GET['job_id'])) {
  $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
  redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
}

$_SESSION['theLocation'] = $job['job_location'];
$_SESSION['theLat'] = $job['lat'];
$_SESSION['theLng'] = $job['lng'];

if(is_post_request()) {
    // Handle form values sent by show_job.php / show_company.php
    $job = [];
    $job['job_id'] = $job_id;
    $job['company_id'] = $_POST['company_id'] ?? '';
    $jobsector['jobsector_id'] = $_POST['jobsector_id'] ?? '';
    $job['job_title'] = $_POST['job_title'] ?? '';
    $job['job_desc'] = $_POST['job_desc'] ?? '';
    $jobtype['jobtype_id'] = $_POST['jobtype_id'] ?? '';
    $job['salary'] = $_POST['salary'] ?? '';
    $currency['currency_id'] = $_POST['currency_id'] ?? '';
    $jobrate['jobrate_id'] = $_POST['jobrate_id'] ?? '';
    $job['job_location'] = $_POST['job_location'] ?? '';
    $job['visible'] = $_POST['visible'] ?? '';
    $job['lat'] = $_POST['lat'] ?? '';
    $job['lng'] = $_POST['lng'] ?? '';
    $job['city'] = $_POST['city'] ?? '';
    $job['date_ending'] = $_POST['date_ending'] ?? '';

    $result = update_recruiter_job($job, $jobsector, $jobtype, $jobrate, $currency);
    if($result === true) {
        $_SESSION['message'] = 'The job was updated sucessfully.';
        redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id));
    } else {
        $errors = $result;
    }

} else {
    if(is_logged_in()){
        if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
            $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
            redirect_to(url_for('/jobmap/staff/admins/user_accounts.php'));
        }
    }
    else{
        if ($job['recruiter_id'] != $_SESSION['recruiter_id']) {
            $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
            redirect_to(url_for('/recruiters/index.php?rec_id='.h(u($_SESSION['recruiter_id']))));
        }
    }
}
?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_errors($errors); ?>
        <a title="Back to company jobs list" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($job['company_id']))); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Company jobs</a>
            <?php if (is_logged_in()) {?>
                <a class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
            <?php } else {?>
            <a class="btn btn-secondary btn-md mb-2 float-right" href="<?php echo url_for('/recruiters/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
        <?php }?>

        <div class="card border-orange mb-4">
            <div class="card-header text-white bg-orange">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Edit job</h3>
            </div>
            <div class="card-body">
                <form id="newJobForm" class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/jobs/edit_job.php?job_id=' . h(u($job_id))); ?>" method="post">
                    <div class="form-group">
                        <?php $company_set = find_recruiter_company();
                        while($company = mysqli_fetch_assoc($company_set)) {
                            echo "<input type='hidden' class='form-control' name='company_id' value=\"" . h($company['id']) . "\"";
                            if($job["company_id"] == $company['id']) {
                                echo "/>";
                            }
                            echo "<h3>" . h($company['company_name']) . "</h3>";
                        }
                        mysqli_free_result($company_set);
                        ?>
                    </div>
                    <p><b>Job Ref: </b><span class="text-muted"><?php echo h($_GET['job_id']); ?></p>

                    <?php $job_post_date = $job['date_created'];
                    $job_post_relative_date = relative_date(strtotime($job_post_date));?>

                    <p><b>Date Added: </b><span class="text-muted"><?php echo h($job_post_relative_date); ?></p>


                    <div class="form-group">
                        <label for="validationJobTitle"><b>Job Title:</b></label>
                        <input type="text" pattern="[a-zA-Z0-9 àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\x27\x28\x29\x2d\x2f]{4,}" class="form-control" id="validationJobTitle" name="job_title" value="<?php echo h($job['job_title']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please provide a valid job title!</div>
                    </div>

                    <div class="form-group">
                        <label for="jobsector_id"><b>Job Sector:</b></label>
                        <?php $the_job = find_job_by_id($job_id);?>
                        <select class="custom-select" name="jobsector_id" id="jobsector_id">
                            <option selected value="<?php echo h($the_job['jobsector_id']); ?>">[Current] <?php echo h($the_job['jobsector_name']); ?></option>
                            <?php
                            $query = "SELECT * FROM jobsectors ORDER BY jobsector_name ASC";
                            $results = mysqli_query($db, $query);
                            $_SESSION['jobsector_id'] = $job['jobsector_id'];
                            $_POST['jobsector_id'] = $_SESSION['jobsector_id'];

                            //-- loop
                            foreach ($results as $jobsector): ?>
                                <option value="<?php echo h($jobsector['id']); ?>"
                                    <?php if ($jobsector['id'] == $_POST['jobsector_id']){echo " selected";} ?>>
                                    <?php echo h($jobsector['jobsector_name']); ?>
                                </option>
                            <?php endforeach;
                            unset ($_SESSION['jobsector_id']); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jobtype_id"><b>Job Type:</b></label>
                        <?php $the_job = find_job_by_id($job_id);?>
                        <select class="custom-select" name="jobtype_id" id="jobtype_id">
                            <option selected value="<?php echo h($the_job['jobtype_id']); ?>">[Current] <?php echo h($the_job['jobtype_name']); ?></option>
                            <?php
                            $query = "SELECT * FROM jobtypes ORDER BY jobtype_name ASC";
                            $results = mysqli_query($db, $query);
                            $_SESSION['jobtype_id'] = $job['jobtype_id'];
                            $_POST['jobtype_id'] = $_SESSION['jobtype_id'];

                            //-- loop
                            foreach ($results as $jobtype): ?>
                                <option value="<?php echo h($jobtype['id']); ?>"
                                    <?php if ($jobtype['id'] == $_POST['jobtype_id']){echo " selected";} ?>>
                                    <?php echo h($jobtype['jobtype_name']); ?>
                                </option>
                            <?php endforeach;
                            unset ($_SESSION['jobtype_id']); ?>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="validationSalary"><b>Salary (&pound;): </b><span class="small"><b>Between 1 and 6 digits followed by a decimal point and 2 digits. E.g. 8.00 - 888888.00</b></span></label>
                        <input type="text" pattern="(?!(\.|0))(?!\.?$)\d{0,6}(\.\d{2})" class="form-control" id="validationSalary" name="salary" value="<?php echo h($job['salary']); ?>" placeholder="8.00" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Invalid input! Please match the format requested.</div>
                    </div>

                    <div class="form-group">
                        <label for="currency_id"><b>Currency:</b></label>
                        <?php $the_job = find_job_by_id($job_id);?>
                        <select class="custom-select" name="currency_id" id="currency_id">
                            <option selected value="<?php echo h($the_job['currency_id']); ?>">[Current] <?php echo h($the_job['alphacode']); ?></option>
                            <?php
                            $query = "SELECT * FROM currency ORDER BY id ASC";
                            $results = mysqli_query($db, $query);
                            $_SESSION['currency_id'] = $currency['currency_id'];
                            $_POST['currency_id'] = $_SESSION['currency_id'];

                            //-- loop
                            foreach ($results as $currency): ?>
                                <option value="<?php echo h($currency['id']); ?>"
                                    <?php if ($currency['id'] == $_POST['currency_id']){echo " selected";} ?>>
                                    <?php echo h($currency['alphacode']); ?>
                                </option>
                            <?php endforeach;
                            unset ($_SESSION['currency_id']); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jobrate_id"><b>Job Rate:</b></label>
                        <?php $the_job = find_job_by_id($job_id);?>
                        <select class="custom-select" name="jobrate_id" id="jobrate_id">
                            <option selected value="<?php echo h($the_job['jobrate_id']); ?>">[Current] <?php echo h($the_job['jobrate_name']); ?></option>
                            <?php
                            $query = "SELECT * FROM jobrates ORDER BY jobrate_name ASC";
                            $results = mysqli_query($db, $query);
                            $_SESSION['jobrate_id'] = $job['jobrate_id'];
                            $_POST['jobrate_id'] = $_SESSION['jobrate_id'];

                            //-- loop
                            foreach ($results as $jobrate): ?>
                                <option value="<?php echo h($jobrate['id']); ?>"
                                    <?php if ($jobrate['id'] == $_POST['jobrate_id']){echo " selected";} ?>>
                                    <?php echo h($jobrate['jobrate_name']); ?>
                                </option>
                            <?php endforeach;
                            unset ($_SESSION['jobrate_id']); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="validationJobDesc"><b>Job Description: </b><span class="small">Minimum 3 characters. Accepts the following HTML tags: &lt;h1&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;br&gt;, &lt;strong&gt;, &lt;b&gt;, &lt;i&gt;, &lt;em&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;</b></span></label>
                        <textarea name="job_desc" class="form-control" id="validationJobDesc" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{3,}" cols="60" rows="10" required><?php echo h($job['job_desc']); ?></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Invalid input! Please match the format requested.</div>
                    </div>


                    <div class="form-group mt-2">
                        <label for="validationDateEnding"><b>Date Ending: </b><span class="small">Click below to select a new date</b></span></label>
                        <input type="text" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" class="form-control" id="validationDateEnding" placeholder="2019-01-01" name="date_ending" value="<?php echo h($job['date_ending']); ?>" required />
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Invalid input! Please match the format requested.</div>
                    </div>

                    <div class="form-group">
                        <label for="map-search"><b>Location: </b><span class="small">Enter a new location and select the desired result. <b>You can also click and drag the existing marker to update the precise location.</b></span></label>
                        <input type="text" name="job_location" id="map-search" class="form-control" placeholder="Enter a new location and select the desired result." size="104" value="<?php echo h($job['job_location']); ?>" autocomplete="off" onkeydown="onkeypressed(event, this);" required></label>
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

                    <!-- Google Maps Integration Start -->
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

                    <div class="form-group mt-4">
                        <p class="mb-2"><b>Status:</b>
                        <?php if ($job['visible'] != 'false') {?>
                            <span id="jobStatusBody_<?php echo h($job_id); ?>">[Active]</span>
                        <?php }
                        else {?>
                            <span id="jobStatusBody_<?php echo h($job_id); ?>">[Marked for removal]</span>
                        <?php }?></p>
                        <label class="switch">
                        <input type="checkbox" class="form-check-input" name="jobToggle" id="jobToggle_<?php echo $job_id; ?>" value="<?php echo $job_id; ?>" <?php if ($job['visible'] == "true") {echo " checked";}?> /><span class="slider round"></span></label>
                    </div>

                    <button type="submit" class="btn btn-green" name="submit"><i class="fas fa-check fa-lg mr-2"></i>Update</button>
                    <a class="btn btn-secondary mb-1 float-right" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($job['company_id']))); ?>" title="Back to company jobs list" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include SHARED_PATH . '/js_gmaps_places_edit_job.php'; ?>


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
$('#validationCompanyDesc').keyup(validateTextarea);

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
$('#validationJobType').keyup(validateJobType);

function validateJobType() {
    var errorMsg = "Please match the format requested.";
    var input = this;
    var pattern = new RegExp('^' + $(input).attr('pattern') + '$');
    // check each line of text
    $.each($(this).val().split("\n"), function () {
        // check if the line matches the pattern
        var hasError = !this.match(pattern);
        if (typeof input.setCustomValidity === 'function') {
            input.setCustomValidity(hasError ? errorMsg : '');

        } else {
            // Not supported by the browser, fallback to manual error display...
            $(input).toggleClass('is-invalid', !!hasError);
            $(input).toggleClass('is-valid', !hasError);
            if (hasError) {
                $(input).attr('title', errorMsg);
            } else {
                $(input).removeAttr('title');
            }
        }
        return !hasError;
    });
}

</script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
