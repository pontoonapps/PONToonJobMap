<?php
require_once '../private/initialize.php';

if(is_user_logged_in()){
$user = $_SESSION["user_id"] ?? 1;
}

// $user = $_SESSION["user_id"];

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$jobTitle = $_GET["name"];
$sector = $_GET["sector"];
$recruiter = $_GET["recruiter"];
$address = $_GET["address"];
$radius = $_GET["radius"];
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
// Opens a connection to a mySQL server
global $db;
// $lat = 50.794851;
// $lng = -1.090886;

// $connection = mysqli_connect(localhost, $username, $password);
// if (!$connection) {
//     die("Not connected : " . mysqli_error());
// }
// // Set the active mySQL database
// $db_selected = mysqli_select_db($database, $connection);
// if (!$db_selected) {
//     die("Can\'t use db : " . mysqli_error($connection));
// }
// Search the rows in the jobs table

$query = sprintf("SELECT userjobs.user_id, jobs.id, jobs.company_id, jobs.jobsector_id, jobs.job_title AS name, jobs.job_desc, jobs.job_location AS address, jobs.visible, jobs.lat, jobs.lng, ( 3959 * acos(cos(radians('%s')) * cos(radians(lat) ) * cos(radians(lng) - radians('%s')) + sin(radians('%s')) * sin(radians(lat)))) AS distance, jobsectors.id, jobsectors.jobsector_name, jobsectors.jsector_short, jobsectors.jsector_group, companies.company_name FROM jobs INNER JOIN companies ON companies.id = jobs.company_id INNER JOIN jobsectors ON jobsectors.id = jobs.jobsector_id INNER JOIN userjobs ON userjobs.job_id = jobs.id WHERE (userjobs.user_id = {$user} AND jobs.job_title LIKE '%%%s%%' OR jobsectors.jobsector_name LIKE '%%%s%%' OR companies.company_name LIKE '%%%s%%' AND jobs.job_location LIKE '%%%s%%') AND jobs.visible <> 'false' AND companies.visible <> 'false' HAVING distance < '%s' ORDER BY name ASC, distance LIMIT 0 , 100",
    db_escape($db, $center_lat),
    db_escape($db, $center_lng),
    db_escape($db, $center_lat),
    db_escape($db, $user),
    db_escape($db, $jobTitle),
    db_escape($db, $sector),
    db_escape($db, $recruiter),
    db_escape($db, $address),
    db_escape($db, $radius));
$result = mysqli_query($db, $query);
// $result = mysqli_query($db, $query);
if (!$result) {
    die("Invalid query: " . mysqli_error($db));
}
header("Content-type: text/xml");
if (mysqli_num_rows($result) == 0) {
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", "No jobs found!");
    $newnode->setAttribute("company_name", "");
    $newnode->setAttribute("address", "Centered on Location.");
    $newnode->setAttribute("jobsector_name", "");
    $newnode->setAttribute("job_desc", "Please refine your search.");
    $newnode->setAttribute("title", "");
    $newnode->setAttribute("lat", $center_lat);
    $newnode->setAttribute("lng", $center_lng);
    $newnode->setAttribute("distance", 0);
    // $newnode->getElementById("btn", "");

} else {
// Iterate through the rows, adding XML nodes for each
    while ($row = @mysqli_fetch_assoc($result)) {
        $allowed_job_desc_tags = '<h1><h2><h3><p><br><strong><b><i><em><ul><ol><li>'; // This is a string and NOT an array!!
        $jobdesc = strip_tags($row['job_desc'], $allowed_job_desc_tags);
        $excerpt = getExcerpt($jobdesc, 0, 300);
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("id", $row['id']);
        $newnode->setAttribute("user_id", $row['user_id']);
        $newnode->setAttribute("name", $row['name']);
        $newnode->setAttribute("company_name", $row['company_name']);
        $newnode->setAttribute("address", $row['address']);
        $newnode->setAttribute("jobsector_name", $row['jobsector_name']);
        $newnode->setAttribute("job_desc", $excerpt);
        $newnode->setAttribute("jsector_short", $row['jsector_short']);
        $newnode->setAttribute("jsector_group", $row['jsector_group']);
        $newnode->setAttribute("lat", $row['lat']);
        $newnode->setAttribute("lng", $row['lng']);
        $newnode->setAttribute("distance", $row['distance']);
    }
}
echo $dom->saveXML();
