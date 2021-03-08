<?php require_once('../private/initialize.php');
require_user_login();

error_reporting(E_ALL);
ini_set("display_errors", 1);

if(isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'] ?? '1';
    $user_id = $_SESSION['user_id'] ?? '1'; // PHP > 7.0
    $usercv = find_user_cv($user_id);

    // Check if job is already in users saved jobs list
    $userjob = find_user_job($job_id);
    // if not then first save the job in users saved jobs list
    if(empty($userjob)) {
        insert_user_job();
    }

    // Check if job has previously been applied for
    $job = find_user_job_applic($job_id);

    if ($job['applic_sent'] != '1') {
        //If new application then set sessions to populate form
        $user_id = $_SESSION['user_id'] ?? '1'; // PHP > 7.0

        $_SESSION['job_id'] = $job_id;
        $_SESSION['company_name'] = $job['company_name'];
        $_SESSION['job_title'] = $job['job_title'];
        $_SESSION['rec_email'] = $job['rec_email'];
    }

    else {
        //The user has already applied
        unset($_SESSION['job_id']);
        $_SESSION['primary_message'] = 'You have already applied for the job:  ' .h($job['job_title']);
        redirect_to(url_for('/jobmap/users/index.php?user_id='.h(u($_SESSION['user_id']))));
    }
}
?>

<?php
$message = '';

if(is_post_request()) {
    $user_id = $_SESSION['user_id'] ?? '1'; // PHP > 7.0
    $usercv = find_user_cv($user_id);

    if ($usercv['status'] != 1){
        $fullName = $_SESSION['first_name'] . $_SESSION['last_name'];

        $file = $_FILES['file'];
        //print_r($file);
        $fileName =$_FILES['file']['name'];
        $fileTmpName =$_FILES['file']['tmp_name'];
        $fileSize =$_FILES['file']['size'];
        $fileError =$_FILES['file']['error'];
        $fileType =$_FILES['file']['type'];
        $fileExt = explode('.', $fileName); //extension then filename, e.g. mypic.jpeg
        $fileActualExt = strtolower(end($fileExt));  //extension string to lowercase e.g. .doc NOT .DOC
        $allowed = array('doc', 'docx', 'pdf'); // allowed file extensions
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2000000) {
                $fileNameNew = "cv".$user_id."-".$fullName.".".$fileActualExt;
                $fileDestination = 'users/uploads/cvs/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE usercvs SET status=1, cv_name='$fileNameNew' WHERE userid='$user_id';";
                $result = mysqli_query($db, $sql);
                // echo"<pre>".print_r($fileDestination, true)."</pre>";
                // exit;
                } else {
                    $_SESSION['attempt_message'] = 'Your file is too big!';
                    redirect_to(url_for('/jobmap/apply_now.php?job_id=' . $job_id));
                }
            } else {
                $_SESSION['message'] = 'There was an error uploading your file!';
                redirect_to(url_for('/jobmap/apply_now.php?job_id=' . $job_id));
                }
        } else {
            $_SESSION['attempt_message'] = 'Please add your CV!';
            redirect_to(url_for('/jobmap/apply_now.php?job_id=' . $job_id));
        }
    }
        $usercv = find_user_cv($user_id);
        $path = 'users/uploads/cvs/' . $usercv["cv_name"];
        // var_dump($_FILES, $path);
        // echo $path;
        // exit;
        $message = utf8_decode('
            <style>
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                td,
                th {
                    border: 1px solid #ddd;
                    text-align: left;
                    padding: 8px;
                }
                th {
                    color:white;
                    background:#E69911;
                    border: 1px solid #E69911;
                    font-size: 26px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }
            </style>
            
            <img src="https://pontoonapps.com/image/PONToon-logo-600.png" width="400px" alt="PONToon logo">
            <p style="font-size:28px; font-weight:bold;"> PONToon Job Map - Job Application Details</p>
            
            <table>
                <tr>
                    <td width="30%"><b>Job title (Ref)</b></td>
                    <td width="70%">'.$_SESSION["job_title"].'<span><i> ('.$_SESSION["job_id"].')</i></span></td>
                </tr>
                <tr>
                    <td width="30%"><b>Company</b></td>
                    <td width="70%">'.$_SESSION["company_name"].'</td>
                </tr>
                <tr>
                    <td width="30%"><b>Full name</b></td>
                    <td width="70%">'.$_SESSION["first_name"].' '.$_SESSION["last_name"].'</td>
                </tr>
                <tr>
                    <td width="30%"><b>Email address</b></td>
                    <td width="70%"><a href=mailto:"'.$_SESSION["user_email"].'">'.$_SESSION["user_email"].'</a></td>
                </tr>
                <tr>
                    <td width="30%"><b>Note to recruiter</b></td>
                    <td width="70%">'.h($_POST["note_to_recruiter"]).'</td>
                </tr>
            </table>
            
            <br><br>
            <img src="https://pontoonapps.com/image/partner-logos.png" width="50%" alt="PONToon partner logos">
        ');

        //PONTOONAPPSEU PEAR Server Settings
        ini_set("include_path", '/soul/home/pontoonapps/php:' . ini_get("include_path"));
        require_once "/soul/home/pontoonapps/php/Mail.php";
        include '/soul/home/pontoonapps/php/Mail/mime.php';

        //PONTOONAPPSEU
        $host = "ssl://pontoonapps.com";
        $port = "465";

        //PONTOONAPPSEU
        $username = "no-reply@pontoonapps.com";

        //PONTOONAPPSEU
        $password = "wMt=f~V#D64O";

        $to = $_SESSION['rec_email'];

        $cc = $_SESSION['user_email'];

        $recipients = $to.",".$cc;

        $headers['From']    = 'PONToon Job Map - Applications <no-reply@pontoonapps.com>';
        $headers['To']      = $to;
        $headers['Subject'] = 'PONToon Job Map - Job Application - ' . $_SESSION["job_title"] . ' - Job ref: [' . $_SESSION["job_id"] .']';
        $headers['Cc']	    = $_SESSION['user_email'];
        $headers['Reply-To'] = $_SESSION['rec_email'];

        // $subject = "Test email using PHP SMTP with SSL\r\n\r\n";
        // $headers = array ('From' => $from, 'To' => $to, 'Cc' => $cc, 'Subject' => $subject);

        $html = $message;

        $file = $path;


        $crlf = "\n";
        $mime = new Mail_mime($crlf);
        $mime->setHTMLBody($html);
        $mime->addAttachment($file);

        // $body = $mime->get();
        $body = $mime->get(array('text_charset' => 'iso8859-1'));

        $headers = $mime->headers($headers, true);

        $smtp = Mail::factory('smtp',
        array ('host' => $host,
        'port' => $port,
        'auth' => true,
        'username' => $username,
        'password' => $password));

        $mail = $smtp->send($recipients, $headers, $body, $message);

        if (PEAR::isError($mail)) {
            echo("<p>" . $mail->getMessage() . "</p>");
        } else {
            // insert_user_job();
            user_job_app_sent();
            // echo("<p>Message successfully sent!</p>");
            // $_SESSION['message'] = 'Thank you. Your application has been submitted for consideration and a copy sent to your email address. See the [My Saved Jobs] section below for more information.';
            redirect_to(url_for('/jobmap/users/index.php?job_id=' . h(u($_SESSION['job_id']))));
        }

}
?>

<?php $page_title = 'Job Map - Application'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div class="container">
    <div class="jumbotron border-blue shadow">
        <?php echo display_session_message(); ?>
        <?php echo display_session_primary_message(); ?>
        <?php echo display_session_attempt_message(); ?>

        <script src="<?php echo url_for('/jobmap/js/alert_message_timeout.js');?>"></script>

        <a title="Return to My Account" href="<?php echo url_for('/jobmap/users/index.php?user_id='.h(u($_SESSION['user_id'])));?>" class="btn btn-blue btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>My Account</a>

        <a title="Cancel and return to my profile" href="<?php echo url_for('/jobmap/users/index.php?user_id='.h(u($_SESSION['user_id']))); ?>" class="btn btn-secondary btn-md float-right mb-2" role="button"><i class="fas fa-times fa-lg mr-2"></i>Cancel</a>

        <!-- <div class="container border-blue my-4">
        <h1>Debug info</h1>
        <p>Recruiters email: <?php //echo h($_SESSION['rec_email']); ?>
        </div> -->

        <div class="card border-blue mt-2">
            <div class="card-header text-white bg-blue">
                <h3 class="my-1"><i class="fas fa-edit fa-lg mr-2"></i>Job Map application</h3>
            </div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h3 class="text-center">You are applying for the position,</h3>
                        <h3 class="text-center text-capitalize font-weight-bold mt-2"><?php echo h($_SESSION['job_title']);?><span class="ml-2 small text-muted">[Job ref: <?php echo h($_SESSION['job_id']); ?>]</span></h3>
                        <h3 class="text-center">at</h3>
                        <h3 class="text-center mb-3 text-capitalize font-weight-bold"><?php echo h($_SESSION['company_name']);?></h3>
                        <?php //print_r($message); ?>
                        <div class="card p-2">
                        <h2>Your details</h2>
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Full name</h3>
                                <p><?php echo h($_SESSION['first_name'] . " " . $_SESSION['last_name']); ?></p>
                            </div>
                            <div class="col-md-4">
                                <h3>Email address</h3>
                                <p><?php echo h($_SESSION['user_email']); ?></p>
                            </div>
                            <div class="col-md-4">
                                <h3>Your CV</h3>
                                <?php if ($usercv['status'] != 1) {?>
                                <p class="alert alert-warning px-2 py-0">Please add your CV below!</p>
                                <?php }
                                else {?>
                                    <p id="cvName"><?php echo h($usercv['cv_name']); ?></p>
                                    <!-- <input id="cvName" value="<?php //echo h($usercv['cv_name']); ?>"> -->
                                <?php }?>
                            </div>
                        </div></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form id="jobApplicationForm" class="needs-validation" novalidate action="<?php echo url_for('/jobmap/apply_now.php?job_id=' . h(u($job_id))); ?>" autocomplete="on" method="post" enctype="multipart/form-data">
                        <h2>Please provide the following information:</h2>
                        <?php if ($usercv['status'] != 1) {?>
                            <h3>Select your CV<i class="fas fa-info-circle fa-md ml-2" data-toggle="tooltip" data-html="true" title="Maximum file size:</br><b>2Mb.</b></br>Allowed file types:</br><b>pdf, doc, or docx.</b>"></i></h3>
                            <div class="form-group">
                                <div id="cvfileSelectBtn" title="Select a CV file" onclick="getCVFile()">Select CV file</div>
                                <input type="file" name="file" id="fileCV" class="form-control-file mb-2" onchange="fileCVSub(this)">
                                <div class="invalid-feedback mb-2" id="cvError1" style="display:none;">Invalid file format! File must be <b>pdf</b>, <b>doc</b> or <b>docx</b>.</div>
                                <div class="invalid-feedback mb-2" id="cvError2" style="display:none;">File size exceeded! Maximum file size is <b>2MB!</b></div>
                            </div>
                        <?php }
                        else {?>
                            <!-- <h2>Please provide the following information:</h2> -->
                        <?php }?>
                            <div class="form-group mb-4">
                                <label for="note_to_recruiter"><i class="fas fa-edit fa-lg mr-2"></i><b>Add note to the recruiter.</b></label>
                                <p class="small">Use this note to convince the recruiter that you are the right person for the job. Include key skills and relevant experience.</p>
                                <textarea name="note_to_recruiter" id="note_to_recruiter" type="text" class="form-control" id="validationNoteToRecruiter" pattern="[a-zA-Z0-9àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ£\x20-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]{1,500}" rows="3" placeholder="Use this note to convince the recruiter in three to five bullet points that you are the right person for the job. Include key skills and relevant experience. - Utilisez cette note pour convaincre le recruteur en trois à cinq points que vous êtes la bonne personne pour le poste. Inclure les compétences clés et l'expérience pertinente." maxlength="500" required></textarea>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Invalid response or format!</div>
                            </div>

                            <button type="submit" class="btn btn-blue float-right" name="submitCV"><i class="fas fa-envelope fa-lg mr-2"></i>Submit</button>
                        </form>
                        <script>
                        var existingCv = $('#cvName').text();
                        if(existingCv){
                            $('button:submit[name=submitCV]').attr('disabled', false);
                            // console.log(existingCv);
                        }
                        else {
                             $('button:submit[name=submitCV]').attr('disabled',true);
                        }
                        function getCVFile() {
                            document.getElementById("fileCV").click();
                        }
                        function fileCVSub(obj){
                            var file = obj.value;
                            var fileName = file.split("\\");
                            document.getElementById("cvfileSelectBtn").innerHTML = fileName[fileName.length-1];
                            // document.myForm.submit();
                            // event.preventDefault();
                        }
                        //$('button:submit[name=submitCV]').prop("disabled", true);
                        var a=0;
                        //binds to onchange event of your input field
                        $('#fileCV').bind('change', function() {
                        if ($('button:submit[name=submitCV]').attr('disabled',false)){
                            $('button:submit[name=submitCV]').attr('disabled',true);
                            }
                        var cvExt = $('#fileCV').val().split('.').pop().toLowerCase();
                        if ($.inArray(cvExt, ['pdf','doc','docx']) == -1){
                            $('#cvError1').slideDown("slow");
                            $('#cvError2').slideUp("slow");
                            a=0;
                            }else{
                                var cvSize = (this.files[0].size);
                                if (cvSize > 2000000){
                                    $('#cvError2').slideDown("slow");
                                    a=0;
                                }else{
                                    a=1;
                                    $('#cvError2').slideUp("slow");
                                }
                                $('#cvError1').slideUp("slow");
                                if (a==1){
                                    $('button:submit[name=submitCV]').attr('disabled',false);
                                }
                            }
                        });
                        </script>
                    </div>
                </div>
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

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$('#note_to_recruiter').keyup(validateTextarea);

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
<script>
        $('textarea').maxlength({
              alwaysShow: true,
              threshold: 10,
              warningClass: "badge badge-success mb-4",
              limitReachedClass: "badge badge-danger mb-4",
              separator: ' out of ',
              preText: 'You\'ve used ',
              postText: ' characters.',
              validate: true,
              appendToParent: true
        });
</script>

<script>

// var existingCv = $('#cvName').val();
// if (existingCv){
//     $('button:submit').attr('disabled',false)
//     console.log(existingCv);
// }
// else {
//     $('button[type="submit"]').prop("disabled", true);
//     var a=0;
// }
//binds to onchange event of your input field
// $('#validationCvFile').bind('change', function() {
// if ($('button:submit').attr('disabled',false)){
//     $('button:submit').attr('disabled',true);
//     }
// var ext = $('#validationCvFile').val().split('.').pop().toLowerCase();
// if ($.inArray(ext, ['pdf','doc','docx']) == -1){
//     $('#error1').slideDown("slow");
//     $('#error2').slideUp("slow");
//     a=0;
//     }else{
//         var cvsize = (this.files[0].size);
//         if (cvsize > 2000000){
//             $('#error2').slideDown("slow");
//             a=0;
//         }else{
//             a=1;
//             $('#error2').slideUp("slow");
//         }
//         $('#error1').slideUp("slow");
//         if (a==1){
//             $('button:submit').attr('disabled',false);
//         }
//     }
// });

</script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
