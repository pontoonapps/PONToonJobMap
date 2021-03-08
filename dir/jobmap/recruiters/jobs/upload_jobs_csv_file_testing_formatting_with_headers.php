<?php require_once '../../../private/initialize.php';

$id = $_SESSION['recruiter_id'];
$co_id = $_SESSION['company_id'];
$co_name = $_SESSION['company_name'];

if (isset($_POST['submit'])) {

  $row = 0;
  $myData = array();

    $file = $_FILES['file'];
    //print_r($file);
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName); //extension then filename, e.g. mypic.jpeg
    $fileActualExt = strtolower(end($fileExt)); //extension string to lowercase e.g. .jpg NOT .JPG

    $allowed = array('csv'); // allowed file extensions
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {

                $newCoName = preg_replace('#[ -]+#', '-', trim(ucfirst($co_name)));
                $fileNameNew = "" . $newCoName . "." . $fileActualExt;
                $fileDestination = 'csv_files/' . $fileNameNew;
                // $fieldseparator = ",";
                // $lineseparator = "\r";

                //Upload CSV file
                $handle = fopen($fileTmpName, 'r'); // read only

                $i = 0;
                // $co_id; //company_id
                // $id; //recruiter_id
                // $locationStatus = 1;
                // fclose($handle);
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                  $num = count($data);
                  $row++;

                  $myData[] = $data;

                  $jobsectorId = $myData[0][0];
                  $jobTitle = $myData[0][1];
                  $jobDesc = $myData[0][2];
                  $jobType = $myData[0][3];
                  $salary = $myData[0][4];
                  $jobLocation = $myData[0][5];
                  $visible = $myData[0][6];
                  $lat = $myData[0][7];
                  $lng = $myData[0][8];
                  $dateEnding = $myData[0][9];

                  if ($jobsectorId !== 'jobsector_id' || $jobTitle !== 'job_title' || $jobDesc !== 'job_desc' || $jobType !== 'job_type' || $salary !== 'salary' || $jobLocation !== 'job_location' || $visible !== 'visible' || $lat !== 'lat' || $lng !== 'lng' || $dateEnding !== 'date_ending') {


$_SESSION['attempt_message'] = 'Invalid Header at' .$row;
redirect_to(url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?id=' . $co_id));
                  }

                  else {
                      if ($i > 0) {
                        if (has_valid_lat_coords($data[7])) {



                            global $db;
                            $sql = "INSERT INTO jobs ";
                            $sql .= "(company_id, recruiter_id, jobsector_id, job_title, job_desc, job_type, salary, job_location, visible, lat, lng, location_status, date_ending) ";
                            $sql .= "VALUES (";
                            $sql .= "'" . db_escape($db, $co_id) . "',";
                            $sql .= "'" . db_escape($db, $id) . "',";
                            $sql .= "'" . db_escape($db, $data[0]) . "',";
                            $sql .= "'" . db_escape($db, $data[1]) . "',";
                            $sql .= "'" . db_escape($db, $data[2]) . "',";
                            $sql .= "'" . db_escape($db, $data[3]) . "',";
                            $sql .= "'" . db_escape($db, $data[4]) . "', ";
                            $sql .= "'" . db_escape($db, $data[5]) . "',";
                            $sql .= "'" . db_escape($db, $data[6]) . "',";
                            $sql .= "'" . db_escape($db, $data[7]) . "',";
                            $sql .= "'" . db_escape($db, $data[8]) . "',";
                            $sql .= "'" . db_escape($db, 1) . "',";
                            $sql .= "'" . db_escape($db, date("Y-m-d", strtotime($data[9]))) . "'";
                            $sql .= ")";
                            $result = mysqli_query($db, $sql);
                            // echo"<pre>".print_r($fileDestination, true)."</pre>";
                            // exit;
                            // print_r(fgetcsv($handle));

                          } else {
                          echo "The row $row doesn't have the right format";

                        }
                      }
                    }
                $i++;
              }
              // fclose($handle);
            }

            else {
                $_SESSION['attempt_message'] = 'Your file is too big!';
                redirect_to(url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?id=' . $co_id));
              }
        } else {
            $_SESSION['attempt_message'] = 'There was an error uploading your file!';
            redirect_to(url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?id=' . $co_id));
        }

    } else {
        $_SESSION['attempt_message'] = 'You cannot upload files of this type!';
        redirect_to(url_for('/jobmap/recruiters/jobs/upload_jobs_csv.php?id=' . $co_id));
        //echo "You cannot upload files of this type!";
    }
}

?>