<?php require_once('../../../private/initialize.php');

require_recruiter_login();

if(!isset($_GET['co_id'])) {
  redirect_to(url_for('/jobmap/recruiters/companies/index.php'));
}

$co_id = $_GET['co_id'];
$_SESSION['company_id'] = $co_id;

$company = find_company_by_id($co_id);

if ($company['recruiter_id'] != $_SESSION['recruiter_id']) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/jobmap/recruiters/companies/index.php'));
}

$_SESSION['company_name'] = $company['company_name'];

?>

<?php $page_title = 'Recruiter - Upload jobs list CSV'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_errors($errors); ?>
        <?php echo display_session_attempt_message(); ?>
        <?php echo display_session_message(); ?>
        <a title="Cancel. Go back to Company Jobs List" href="<?php echo url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . h(u($co_id))); ?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>

        <div class="card border-orange mb-4">
            <div class="card-header text-white bg-orange">
                <h3 class="my-1"><i class="fas fa-file-upload fa-lg mr-2"></i>Upload jobs list CSV</h3>
            </div>
            <div class="card-body">
                <div class="accordion mb-2" id="accordionExample">
                    <div class="card">
                        <div class="card-header text-white bg-teal pb-0" type="button" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h4><i class="fas fa-chevron-down fa-lg mr-2"></i>Multi Jobs CSV Template Guide & Download Area </span></h4>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <p>This area contains the CSV template guide and CSV template file.</p>
                                <a title="Download PONToon Job Map CSV MS Excel template" href="<?php echo url_for('/jobmap/recruiters/jobs/PONToon_Job_Map_CSV_template_guide_v1.2.pdf'); ?>" target="_blank" class="btn btn-teal btn-md btn-block mt-4" role="button"><i class="fas fa-file-download fa-lg mr-2"></i>Download CSV template guide.</a>
                                <a title="Download CSV MS Excel template" href="<?php echo url_for('/jobmap/recruiters/jobs/multi-job-csv-template.csv'); ?>" class="btn btn-secondary btn-md btn-block mt-4" role="button"><i class="fas fa-file-download fa-lg mr-2"></i>Download CSV template file.</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info" role="alert">
                    <p>Your CSV file should be no more than <b>2.0 MB.</b></p>
                    <p><b>File format accepted: .CSV</b></p>
                </div>
                <form class="needs-validation" novalidate action="<?php echo url_for('/jobmap/recruiters/jobs/upload_jobs_csv_file.php');?>" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-2">
                        <label for="csvfilename"><b>CSV file:</b></label>
                        <div id="fileSelectBtn" title="Select job list CSV file" onclick="getFile()">Select CSV file</div>
                        <input type="file" name="file" id="csvfilename" class="form-control-file" onchange="sub(this)">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback" id="jobsCSVError1" style="display:none;">Invalid file format! File format must be <b>csv</b>.</div>
                        <div class="invalid-feedback" id="jobsCSVError2" style="display:none;">File size exceeded! Maximum file size limit is <b>2MB!</b></div>
                    </div>
                    <button type="submit" class="btn btn-green" name="submitJobsCSV"><i class="fas fa-file-upload fa-lg mr-2"></i>Upload CSV file</button>
                </form>
                <script>
                function getFile() {
                    document.getElementById("csvfilename").click();
                }
                function sub(obj){
                    var file = obj.value;
                    var fileName = file.split("\\");
                    document.getElementById("fileSelectBtn").innerHTML = fileName[fileName.length-1];
                    // document.myForm.submit();
                    // event.preventDefault();
                }
                $('button:submit[name=submitJobsCSV]').prop("disabled", true);
                var a=0;
                //binds to onchange event of your input field
                $('#csvfilename').bind('change', function() {
                if ($('button:submit[name=submitJobsCSV]').attr('disabled',false)){
                    $('button:submit[name=submitJobsCSV]').attr('disabled',true);
                    }
                var jobsCSVExt = $('#csvfilename').val().split('.').pop().toLowerCase();
                if ($.inArray(jobsCSVExt, ['csv']) == -1){
                    $('#jobsCSVError1').slideDown("slow");
                    $('#jobsCSVError2').slideUp("slow");
                    a=0;
                    }else{
                        var cvSize = (this.files[0].size);
                        if (cvSize > 2000000){
                            $('#jobsCSVError2').slideDown("slow");
                            a=0;
                        }else{
                            a=1;
                            $('#jobsCSVError2').slideUp("slow");
                        }
                        $('#jobsCSVError1').slideUp("slow");
                        if (a==1){
                            $('button:submit[name=submitJobsCSV]').attr('disabled',false);
                        }
                    }
                });
                </script>
            </div>
        </div>
    </div>
</div>
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
</script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
