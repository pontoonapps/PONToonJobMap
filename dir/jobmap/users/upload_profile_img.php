<?php require_once('../../private/initialize.php');

require_user_login();

if ($_GET['user_id'] != ($_SESSION['user_id'])) {
    $_SESSION['attempt_message'] = 'You are not authorised to perform this action!';
    redirect_to(url_for('/users/index.php'));
} else {
    $user_id = $_GET['user_id'];
    $user = find_user_by_id($user_id);
    $fullName = $user['first_name'] . $user['last_name'];
}

if(isset($_POST['submitPimg'])) {
    $file = $_FILES['file'];
    //print_r($file);
    $fileName =$_FILES['file']['name'];
    $fileTmpName =$_FILES['file']['tmp_name'];
    $fileSize =$_FILES['file']['size'];
    $fileError =$_FILES['file']['error'];
    $fileType =$_FILES['file']['type'];
    $fileExt = explode('.', $fileName); //extension then filename, e.g. mypic.jpeg
    $fileActualExt = strtolower(end($fileExt));  //extension string to lowercase e.g. .jpg NOT .JPG

    $allowed = array('gif', 'jpg', 'png', 'jpeg'); // allowed file extensions
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
        if ($fileSize < 1000000) {
            $fileNameNew = "pimg".$user_id."-".$fullName.".".$fileActualExt;
            $fileDestination = 'uploads/profile_imgs/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            $sql = "UPDATE users SET profile_img_status=1, profile_img='$fileNameNew' WHERE id='$user_id';";
            $result = mysqli_query($db, $sql);
            // echo"<pre>".print_r($fileDestination, true)."</pre>";
            // exit;
            $_SESSION['message'] = 'Your profile image '.$fileNameNew.' was uploaded successfully.';
            redirect_to(url_for('/jobmap/users/index.php?user_id=' . $user_id));

        } else {
            $_SESSION['attempt_message'] = 'Your file is too big!';
            redirect_to(url_for('/jobmap/users/index.php?user_id=' . $user_id));
            }
        } else {
            $_SESSION['message'] = 'There was an error uploading your file!';
            redirect_to(url_for('/jobmap/users/index.php?user_id=' . $user_id));
        }
    }
        else {
        $_SESSION['attempt_message'] = 'You cannot upload files of this type!';
        redirect_to(url_for('/jobmap/users/index.php?user_id=' . $user_id));
        //echo "You cannot upload files of this type!";
    }
}
?>
