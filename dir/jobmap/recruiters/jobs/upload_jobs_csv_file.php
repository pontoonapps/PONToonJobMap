<?php require_once('../../../private/initialize.php');

$rec_id = $_SESSION['recruiter_id'];
$co_id = $_SESSION['company_id'];
$co_name = $_SESSION['company_name'];

if(isset($_POST['submitJobsCSV'])) {
    $file = $_FILES['file'];
    $fileName =$_FILES['file']['name'];
    $fileTmpName =$_FILES['file']['tmp_name'];
    $fileSize =$_FILES['file']['size'];
    $fileError =$_FILES['file']['error'];
    $fileType =$_FILES['file']['type'];

    //extension then filename, e.g. mypic.jpeg
    $fileExt = explode('.', $fileName);

    //extension string to lowercase e.g. .jpg NOT .JPG
    $fileActualExt = strtolower(end($fileExt));

    // allowed file extensions
    $allowed = array('csv');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $newCoName = preg_replace('#[ -\']+#', '-', trim(ucfirst($co_name)));
                $fileNameNew = "".$newCoName.".".$fileActualExt;
                $fileDestination = 'csv_files/'.$fileNameNew;

                //Upload CSV file
                // read only
                $handle = fopen($fileTmpName, 'r');

                while (($myData = fgetcsv($handle, 1000, ",")) !== false) {
                    $jobsectorId = $myData[0];
                    $jobTitle = utf8_encode($myData[1]);
                    $jobDesc = utf8_encode($myData[2]);
                    $jobTypeId = $myData[3];
                    $salary = $myData[4];
                    $currency = $myData[5];
                    $jobRateId = $myData[6];
                    $jobLocation = utf8_encode($myData[7]);
                    $visible = strtolower($myData[8]);
                    $lat = $myData[9];
                    $lng = $myData[10];
                    $dateEnding = $myData[11];

                    global $db;

                    $sql = "INSERT INTO jobs ";
                    $sql .= "(company_id, recruiter_id, jobsector_id, job_title, job_desc, jobtype_id, salary, currency_id, jobrate_id, job_location, visible, lat, lng, location_status, date_ending) ";
                    $sql .= "VALUES (";
                    $sql .= "'" . db_escape($db, $co_id) . "',";
                    $sql .= "'" . db_escape($db, $rec_id) . "',";
                    $sql .= "'" . db_escape($db, $jobsectorId) . "',";
                    $sql .= "'" . db_escape($db, $jobTitle) . "',";
                    $sql .= "'" . db_escape($db, $jobDesc) . "',";
                    $sql .= "'" . db_escape($db, $jobTypeId) . "',";
                    $sql .= "'" . db_escape($db, $salary) . "', ";
                    $sql .= "'" . db_escape($db, $currency) . "', ";
                    $sql .= "'" . db_escape($db, $jobRateId) . "', ";
                    $sql .= "'" . db_escape($db, $jobLocation) . "',";
                    $sql .= "'" . db_escape($db, $visible) . "',";
                    $sql .= "'" . db_escape($db, $lat) . "',";
                    $sql .= "'" . db_escape($db, $lng) . "',";
                    $sql .= "'" . db_escape($db, 1) . "',";
                    $sql .= "'" . db_escape($db, date("Y-m-d", strtotime(str_replace('/', '-',($dateEnding))))) . "'";
                    $sql .= ")";

                    $result = mysqli_query($db, $sql);
                }

                if (!$result) {
                    // INSERT failed
                    echo mysqli_error($db);
                    db_disconnect($db);
                    exit;
                } else {
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $_SESSION['message'] = 'The CSV jobs list file '.$fileNameNew.' was uploaded successfully.';
                    redirect_to(url_for('/jobmap/recruiters/companies/show_company.php?co_id=' . $co_id));
                    return true;
                }
            } else {
                $_SESSION['attempt_message'] = 'Your file is too big!';
                redirect_to(url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?co_id=' . $co_id));
            }
        } else {
            $_SESSION['attempt_message'] = 'There was an error uploading your file!';
            redirect_to(url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?co_id=' . $co_id));
        }
    } else {
        $_SESSION['attempt_message'] = 'You cannot upload files of this type!';
        redirect_to(url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?co_id=' . $co_id));
        //echo "You cannot upload files of this type!";
    }
}

?>

