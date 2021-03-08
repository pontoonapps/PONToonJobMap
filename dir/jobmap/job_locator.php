<?php

require_once '../private/initialize.php';

// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$jobTitle = h($_GET["name"]);
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

// Search the rows in the jobs table
$query = sprintf("SELECT jobs.id AS job_id, jobs.company_id, jobs.jobsector_id, jobs.job_title AS name, jobs.job_desc, jobtypes.id, jobtypes.jobtype_name, jobs.salary AS salary, jobs.currency_id, currency.alphacode AS currency_code, jobrates.jobrate_name, jobs.job_location AS address, jobs.city AS city, jobs.visible, jobs.date_ending, jobs.lat, jobs.lng, ( 3959 * acos(cos(radians('%s')) * cos(radians(lat) ) * cos(radians(lng) - radians('%s')) + sin(radians('%s')) * sin(radians(lat)))) AS distance, jobsectors.id, jobsectors.jobsector_name, jobsectors.jsector_short, jobsectors.jsector_group, jobsectors.jsector_icon, companies.company_name, companies.logo AS company_logo FROM jobs INNER JOIN companies ON companies.id = jobs.company_id INNER JOIN jobsectors ON jobsectors.id = jobs.jobsector_id INNER JOIN jobtypes ON jobtypes.id = jobs.jobtype_id INNER JOIN jobrates ON jobrates.id = jobs.jobrate_id INNER JOIN currency ON currency.id = jobs.currency_id WHERE (jobs.job_title LIKE '%%%s%%' OR jobsectors.jobsector_name LIKE '%%%s%%' OR companies.company_name LIKE '%%%s%%' AND jobs.job_location LIKE '%%%s%%') AND jobs.visible <> 'false' AND companies.visible <> 'false' AND jobs.date_ending >= CURDATE() HAVING distance < '%s' ORDER BY name ASC, distance LIMIT 0 , 100",

    db_escape($db, $center_lat),
    db_escape($db, $center_lng),
    db_escape($db, $center_lat),
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
    $newnode->setAttribute("address", "Centered on location.");
    $newnode->setAttribute("city", "");
    $newnode->setAttribute("title", "");
    $newnode->setAttribute("company_name", "");
    $newnode->setAttribute("company_logo", "");
    $newnode->setAttribute("jobsector_name", "");
    $newnode->setAttribute("jobtype_name", "");
    $newnode->setAttribute("salary", "");
    $newnode->setAttribute("jobrate_name", "");
    $newnode->setAttribute("job_desc", "Please refine your search.");
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
        $newnode->setAttribute("job_id", $row['job_id']);
        // $newnode->setAttribute("name", str_replace("'", "\\'", html_entity_decode($row['name'], ENT_QUOTES)));
        $newnode->setAttribute("name2", preg_replace("/'/",'%27', h($row['name'])));
        $newnode->setAttribute("name", $row['name']);
        $newnode->setAttribute("company_name2", preg_replace("/'/",'%27', h($row['company_name'])));
        $newnode->setAttribute("company_name", $row['company_name']);
        $newnode->setAttribute("company_logo", $row['company_logo']);
        $newnode->setAttribute("address", $row['address']);
        $newnode->setAttribute("city", $row['city']);
        $newnode->setAttribute("jobsector_name", $row['jobsector_name']);
        $newnode->setAttribute("job_desc", $excerpt);
        $newnode->setAttribute("jobtype_name", $row['jobtype_name']);
        $format_salary = number_format($row['salary'], 2);
        $newnode->setAttribute("salary", $format_salary);
        $newnode->setAttribute("currency_id", $row['currency_id']);
        $newnode->setAttribute("currency_code", $row['currency_code']);
        $newnode->setAttribute("jobrate_name", $row['jobrate_name']);
        $newnode->setAttribute("jsector_short", $row['jsector_short']);
        $newnode->setAttribute("jsector_group", $row['jsector_group']);
        $newnode->setAttribute("jsector_icon", $row['jsector_icon']);
        $newnode->setAttribute("lat", $row['lat']);
        $newnode->setAttribute("lng", $row['lng']);
        $newnode->setAttribute("distance", $row['distance']);
    }
}

echo $dom->saveXML();