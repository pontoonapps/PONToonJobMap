<?php require_once('../private/initialize.php');

if (is_get_request()) {
    // Get search term
    $searchTerm = h($_GET['term']);

    // Get matched data from jobs and companies tables
    $query3 = $db->query("SELECT DISTINCT job_location FROM jobs INNER JOIN companies ON companies.id=jobs.company_id WHERE job_location LIKE '%".$searchTerm."%' AND jobs.visible <> 'false' AND companies.visible <> 'false' AND jobs.date_ending >= CURDATE() ORDER BY job_location ASC LIMIT 5");

    // Generate jobs data array
    $locTitle = array();
    if ($query3->num_rows > 0) {
        while ($row = $query3->fetch_assoc()) {
            // $data['id'] = $row['id'];
            $data3['label'] = $row['job_location'];
            array_push($locTitle, $data3);
        }
    }
}
// Return results as json encoded array
echo json_encode($locTitle);