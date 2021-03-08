<?php require_once('../../../private/initialize.php');

$recid = $_SESSION['recruiter_id'];
$job_id = $_GET['job_id'];

$job = find_job_by_id($job_id);
$_SESSION['job_title'] = $job['job_title'];
$jobTitle = $_SESSION['job_title'];

if(is_post_request()) {
  $file = $_FILES['file'];
  $video_desc = $_POST['video_desc'];
  //print_r($file);
  $fileName =$_FILES['file']['name'];
  $fileTmpName =$_FILES['file']['tmp_name'];
  $fileSize =$_FILES['file']['size'];
  $fileError =$_FILES['file']['error'];
  $fileType =$_FILES['file']['type'];
  $fileExt = explode('.', $fileName); //extension then filename, e.g. mypic.jpeg
  $fileActualExt = strtolower(end($fileExt));  //extension string to lowercase e.g. .jpg NOT .JPG
  $allowed = array('mp4'); // allowed file extensions
    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 2000000) {

          // $random_digit = rand(0000, 9999);
          $newFileName = preg_replace('#[ -]+#', '-', trim(strtolower($job_id)));
          $fileNameNew = "" . $recid . "-" . $newFileName . "-" . $jobTitle . "." . $fileActualExt;
          // $fileNameNew = "".$newVidName."-".$random_digit."-".$jobTitle.".".$fileActualExt;
          $fileDestination = 'videos/'.$fileNameNew;
          $sql = "INSERT INTO job_videos ";
          $sql .= "(recruiter_id, job_id, video_desc, video_filename) ";
          $sql .= "VALUES (";
          $sql .= "'" . db_escape($db, $recid) . "',";
          $sql .= "'" . db_escape($db, $job_id) . "',";
          $sql .= "'" . db_escape($db, $video_desc) . "',";
          $sql .= "'" . db_escape($db, $fileNameNew) . "'";
          $sql .= ")";
          $sql .= "ON DUPLICATE KEY UPDATE ";
          $sql .= "video_filename = '" . db_escape($db, $fileNameNew) . "'";
          $result = mysqli_query($db, $sql);
          // For INSERT statements, $result is true/false
          if (!$result) {
            // INSERT failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
          } else {
            move_uploaded_file($fileTmpName, $fileDestination);
            // echo"<pre>".print_r($file, true)."</pre>";
            // exit;
            $_SESSION['message'] = 'Your video '.$fileNameNew.' was uploaded successfully.';
            redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id));
            return true;
          }

        } else {
          $_SESSION['attempt_message'] = 'Your file is too big!';
          redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id));
          }
        } else {
          $_SESSION['attempt_message'] = 'There was an error uploading your file!';
          redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id));
      }
    }
     else {
        $_SESSION['attempt_message'] = 'You cannot upload files of this type!';
        redirect_to(url_for('/jobmap/recruiters/jobs/show_job.php?job_id=' . $job_id));
        //echo "You cannot upload files of this type!";
    }
}
?>
