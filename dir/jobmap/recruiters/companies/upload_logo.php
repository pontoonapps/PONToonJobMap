<?php require_once('../../../private/initialize.php');

$rec_id = $_SESSION['recruiter_id'];
$co_id = $_GET['co_id'];
$co_name = $_SESSION['company_name'];

if(isset($_POST['submitCoLogo'])) {
    $file = $_FILES['file'];
    //print_r($file);
    $fileName =$_FILES['file']['name'];
    $fileTmpName =$_FILES['file']['tmp_name'];
    $fileSize =$_FILES['file']['size'];
    $fileError =$_FILES['file']['error'];
    $fileType =$_FILES['file']['type'];
    $fileExt = explode('.', $fileName); //extension then filename, e.g. mypic.jpeg
    $fileActualExt = strtolower(end($fileExt));  //extension string to lowercase e.g. .jpg NOT .JPG

    $allowed = array('gif', 'jpg', 'png'); // allowed file extensions
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {

                $newCoName = preg_replace('#[ -\']+#', '-', trim(strtolower($co_name)));
                $_SESSION['co-logo'] = $newCoName;
                $fileNameNew = "cologo".$co_id."-".$newCoName.".".$fileActualExt;
                $fileDestination = 'logos/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE companies SET logo_status=1, logo='$fileNameNew' WHERE recruiter_id='$rec_id';";
                $result = mysqli_query($db, $sql);
                // echo"<pre>".print_r($fileDestination, true)."</pre>";
                // exit;
                $_SESSION['message'] = 'Your logo '.$fileNameNew.' was uploaded successfully.';
                redirect_to(url_for('/jobmap/recruiters/companies/index.php?rec_id=' . $_SESSION['recruiter_id']));

            } else {
            $_SESSION['attempt_message'] = 'Your file is too big!';
            redirect_to(url_for('/jobmap/recruiters/companies/index.php?rec_id=' . $_SESSION['recruiter_id']));
            }
            } else {
            $_SESSION['attempt_message'] = 'There was an error uploading your file!';
            redirect_to(url_for('/jobmap/recruiters/companies/index.php?rec_id=' . $_SESSION['recruiter_id']));
        }
    }
    else {
        $_SESSION['attempt_message'] = 'You cannot upload files of this type!';
        redirect_to(url_for('/jobmap/recruiters/companies/index.php?rec_id=' . $_SESSION['recruiter_id']));
    }
}
?>
