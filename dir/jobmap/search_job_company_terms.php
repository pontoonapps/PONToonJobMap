<?php require_once('../private/initialize.php');

if (is_get_request()) {
    // Get search term
    $searchTerm = h($_GET['term']);

    // Get matched data from jobs and companies tables
    $query = $db->query("SELECT DISTINCT job_title FROM jobs INNER JOIN companies ON companies.id=jobs.company_id WHERE (job_title LIKE '%".$searchTerm."%' AND companies.visible <> 'false' AND jobs.visible <> 'false' AND jobs.date_ending >= CURDATE()) ORDER BY job_title ASC");

    $query2 = $db->query("SELECT DISTINCT company_name FROM companies INNER JOIN jobs ON jobs.company_id = companies.id WHERE company_name LIKE '%".$searchTerm."%' AND companies.visible <> 'false' AND jobs.date_ending >= CURDATE() ORDER BY company_name ASC");

    $query3 = $db->query("SELECT DISTINCT jobsector_name FROM jobsectors INNER JOIN jobs ON jobs.jobsector_id = jobsectors.id WHERE jobsector_name LIKE '%".$searchTerm."%' AND jobs.date_ending >= CURDATE() ORDER BY jobsector_name ASC");

    // Generate job titles and company names data array
    $jobCompany = array();
    if ($query->num_rows > 0 || $query2->num_rows > 0 || $query3->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            // $data['id'] = $row['id'];
            $data['value'] = h($row['job_title']);
            array_push($jobCompany, $data);
        }
        while ($row = $query2->fetch_assoc()) {
            // $data['id'] = $row['id'];
            $data2['value'] = $row['company_name'];
            array_push($jobCompany, $data2);
        }
        while ($row = $query3->fetch_assoc()) {
            // $data['id'] = $row['id'];
            $data3['value'] = $row['jobsector_name'];
            array_push($jobCompany, $data3);
        }
    }
}
// Return results as json encoded array
echo json_encode($jobCompany);