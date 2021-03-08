<?php require_once '../../private/initialize.php';?>
<?php include SHARED_PATH . '/public_header.php';?>
<?php require_user_login();?>

<?php
// if(!isset($_GET['job_id'])){
// $_SESSION['message'] = 'You messed with job_id=!';
// redirect_to(url_for('/jobmap/users/index.php?user_id='.h($_SESSION['user_id'])));
// }
// else {
    $job_id = $_GET['job_id'] ?? 1;
//}?>
<div class="container">
    <div class="jumbotron border-orange shadow">
        <?php echo display_session_message(); ?>
        <a title="Return to my account" href="<?php echo url_for('/index.php?user_id='.h(u($_SESSION['user_id']))); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>My account</a>
        <h1>Job details</h1>
        <?php
        $lat = 50.795276;
        $lng = -1.074379;
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT jobs.id AS job_id, jobs.job_title, jobs.job_desc, jobs.job_location, jobtypes.jobtype_name, jobs.salary, jobs.currency_id, currency.alphacode, jobrates.jobrate_name, jobs.date_created, DATEDIFF(CURDATE(), jobs.date_created), jobs.date_ending, DATEDIFF(CURDATE(), jobs.date_ending),jobsectors.jobsector_name, jobsectors.jsector_icon, companies.id, companies.company_name, companies.logo, companies.visible, userjobs.applic_sent, userjobs.applic_sent_date, (((acos(sin(({$lat}*pi()/180))*sin((lat*pi()/180))+cos(({$lat}*pi()/180))*cos((lat*pi()/180))*cos((({$lng}-lng)*pi()/180))))*180/pi())*60*1.1515) AS distance ";
        $sql .= "FROM jobs ";
        $sql .= "INNER JOIN companies ON jobs.company_id=companies.id ";
        $sql .= "INNER JOIN jobsectors ON jobsectors.id=jobs.jobsector_id ";
        $sql .= "INNER JOIN jobtypes ON jobtypes.id=jobs.jobtype_id ";
        $sql .= "INNER JOIN jobrates ON jobrates.id=jobs.jobrate_id ";
        $sql .= "INNER JOIN currency ON currency.id=jobs.currency_id ";
        $sql .= "INNER JOIN userjobs ";
        $sql .= "ON jobs.id = job_id ";
        $sql .= "WHERE userjobs.job_id='$job_id' ";
        $sql .= "AND user_id='" . db_escape($db, $user_id) . "' ";
        $sql .= "LIMIT 1";
        $result = mysqli_query($db, $sql);
        $queryResults = mysqli_num_rows($result);

        if ($queryResults > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $allowed_job_desc_tags = '<h1><h2><h3><p><br><strong><b><i><em><ul><ol><li>'; // This is a string and NOT an array!!
                $_SESSION['job_id'] = $row['job_id'];
                $_SESSION['job_title'] = $row['job_title'];

                $job_post_date = $row['date_created'];
                $job_post_date = date("l jS F Y", strtotime($job_post_date));
                $job_post_relative_date = relative_date(strtotime($job_post_date));

                $job_post_date_ending = $row['date_ending'];
                $job_post_ending_relative_date = job_ending_relative_date(strtotime($job_post_date_ending));

                $sent_date = $row['applic_sent_date'];
                $sent_date = date("l jS F Y", strtotime($sent_date));
                $my_relative_sent_date = relative_date(strtotime($sent_date));?>

                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="card border-orange">
                            <div class="card-header bg-orange text-white pb-0">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4><?php echo h($row['job_title']); ?></h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <h5 class="text-md-right text-lg-right"><i class="fas fa-calendar-alt fa-lg mr-2"></i>Posted: <?php echo h($job_post_relative_date); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8 mb-4">
                                        <img class="mb-2 mr-2" src="<?php echo url_for('/jobmap/images/icons/jobsector_icons/' . h($row['jsector_icon'])); ?>" alt="Job sector: <?php echo h($row['jobsector_name']); ?>" title="Job sector: <?php echo h($row['jobsector_name']); ?>" />
                                        <p title="Job reference: <?php echo h($_SESSION['job_id']); ?>" class="mb-1"><i class="fas fa-hashtag fa-fw fa-lg mr-1"></i><?php echo h($_SESSION['job_id']); ?></p>
                                        <a title="View job location" data-toggle="modal" data-target="#GoogleMapModal" href="javascript:void(0);"><p class="mb-1"><i class="fas fa-map-marker-alt fa-lg mr-2"></i><u><?php echo h($row['job_location']); ?> (<?php echo h(round($row['distance'], 1, PHP_ROUND_HALF_UP)); ?> miles)</u></p></a>
                                        <p title="Job type" class="mb-1"><i class="fas fa-user-clock fa-lg mr-2"></i><?php echo h($row['jobtype_name']); ?></p>

                                        <p title="Salary and rate" class="mb-1">
                                        <?php if ($row['currency_id'] == '1') {?>
                                            <i class="fas fa-pound-sign fa-lg mr-2"></i>
                                        <?php } else if ($row['currency_id'] == '2') {?>
                                            <i class="fas fa-euro-sign fa-lg mr-2"></i>
                                        <?php } else {?>
                                            <i class="fas fa-dollar-sign fa-lg mr-2"></i>
                                        <?php }?>
                                        <?php $format_salary = number_format($row['salary'], 2);?><?php echo h($format_salary); ?> (<?php echo h($row['alphacode']); ?>)

                                         <?php echo h($row['jobrate_name']); ?></p>
                                        <p title="Job ends" class="mb-1"><i class="fas fa-calendar-times fa-lg mr-2"></i><?php echo h($job_post_ending_relative_date); ?></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="javascript:void(0);" title="View <?php echo h($row['company_name']); ?>'s details." data-toggle="modal" data-target="#coModal<?php echo h($row['id']); ?>">
                                        <h5 class="card-title text-lg-right text-md-right"><i class="fas fa-building fa-lg mr-2"></i><?php echo h($row['company_name']); ?></h5>
                                        <img class="company_logo_thumb float-lg-right float-md-right mb-1" src="<?php echo url_for('/jobmap/recruiters/companies/logos/' . h($row['logo'])); ?>" alt="View <?php echo h($row['company_name']); ?>'s details" title="View <?php echo h($row['company_name']); ?>'s details" /></a>
                                    </div>
                                </div>
                                <p class="mb-3"><b>Job description: </b><?php echo strip_tags($row['job_desc'], $allowed_job_desc_tags); ?></p>

                                <!-- Google Map Button trigger modal -->
                                <button type="button" class="btn btn-orange" data-toggle="modal" data-target="#GoogleMapModal" title="View location"><i class="fas fa-map-marker-alt text-white fa-lg white mr-2"></i>View location</button>

                                <!-- Job Video Button trigger modal -->
                                <?php $job_id = $row['job_id'];
                                $job_vid = find_job_vid_by_id($job_id);
                                if (!empty($job_vid)) {?>
                                    <button type="button" class="btn btn-orange" data-toggle="modal" data-target="#jobVidModal" title="Watch video"><i class="fas fa-eye fa-lg mr-2"></i>Watch video</button>
                                <?php } else {
                                    // show no view video button
                                }?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Vid Modal -->
                <div class="modal fade" id="jobVidModal" tabindex="-1" role="dialog" aria-labelledby="jobVidModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo h($row['job_title']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <?php if(!empty($job_vid)){ ?>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video class="embed-responsive-item mb-2" controls poster="" src="<?php echo url_for('/jobmap/recruiters/jobs/videos/'. h($job_vid['video_filename'])); ?>" allowfullscreen></video>
                                    </div>
                                    <div><?php echo ($job_vid['video_desc']);?></div>
                                <?php  }
                                else {
                                    //show no video
                                }?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company info modal -->
                <div class="modal fade" id="coModal<?php echo h($row['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="coModal<?php echo h($row['id']); ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php $recruiter_company_set = show_recruiter_company_modal($row['id']);
                        while ($recruiter_company = mysqli_fetch_assoc($recruiter_company_set)) {?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo h($recruiter_company['company_name']); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <img class="company_logo_thumb mb-1" src="<?php echo url_for('/jobmap/recruiters/companies/logos/' . h($recruiter_company['logo']) . ''); ?>" alt="<?php echo h($recruiter_company['company_name']); ?>" title="<?php echo h($recruiter_company['company_name']); ?>" />
                                    <p class="mb-1"><?php echo h($recruiter_company['company_desc']); ?></p>
                                    <small class="text-muted"><?php echo h($recruiter_company['location']); ?></small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        <?php }?>
                        <?php mysqli_free_result($recruiter_company_set);?>
                    </div>
                </div>

                <!-- Google Map Modal -->
                <div class="modal fade" id="GoogleMapModal" tabindex="-1" role="dialog" aria-labelledby="GoogleMapModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo h($row['job_title']); ?> - Job Location</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="map-container">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($row['applic_sent'] == '1') {?>
                    <a title="&check; Application Sent" class="btn btn-green btn-block mt-2 disabled" href="" role="button"><i class="fas fa-envelope fa-lg mr-2"></i>Application sent - <?php echo h($my_relative_sent_date); ?></a>
                <?php }

                if ($row['applic_sent'] != '1') {?>
                    <a title="Apply for this job now" class="btn btn-green btn-block mt-2" href="<?php echo url_for('/jobmap/apply_now.php?job_id=' . h(u($row['job_id']))); ?>" role="button"><i class="fas fa-envelope-open fa-lg mr-2"></i>Apply now</a>
                <?php }
                else {
                  //show nothing
                }

                if ($row['job_id'] == $_SESSION['job_id']) {?>
                    <button title="You have saved this job" class="btn btn-block btn-blue disabled text-white mb-2"><i class="fas fa-star fa-lg mr-2"></i>Job saved</button>
                <?php }
            } // While loop end
        } // If $queryResults end
        else {
        // $_SESSION['message'] = 'No job here mate!';
        redirect_to(url_for('/jobmap/index.php?user_id=' . h($_SESSION['user_id'])));
        } ?>
      
        <a title="Return to my account" href="<?php echo url_for('/jobmap/users/index.php?user_id='.h(u($_SESSION['user_id']))); ?>" class="btn btn-orange btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>My account</a>
    </div>
</div>

<?php $job_location_set = show_job_location($job_id);?>
<?php while ($job_location = mysqli_fetch_assoc($job_location_set)) {
    $newJobLocation = str_replace("'", "\\'", html_entity_decode($job_location['job_location'], ENT_QUOTES));
    $newJobTitle = str_replace("'", "\\'", html_entity_decode($job_location['job_title'], ENT_QUOTES));
    // echo $newJobLocation;
    // exit;
    ?>
    <script>
    // Initialize and add the map
    function initMap() {
        // Get the lat / lng of the job
        var geoLat = parseFloat("<?php echo h($job_location['lat']); ?>");
        var geoLng = parseFloat("<?php echo h($job_location['lng']); ?>");
        var jobLocation = {lat: geoLat, lng: geoLng};

        // The map, centered on the job location
        var map = new google.maps.Map(
        document.getElementById('map'), {
            zoom: 16,
            center: jobLocation
        });

        var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h3 id="firstHeading" class="firstHeading"><?php echo h($newJobTitle); ?></h3>'+
        '<h5><?php echo h($newJobLocation); ?></h5>'+
        '<div id="bodyContent">'+
        '<a class="btn btn-green btn-sm mt-2" role="button" href="https://www.google.com/maps/search/?api=1&query=<?php echo h($job_location['lat']); ?>,<?php echo h($job_location['lng']); ?>" target="_blank">'+
        '<i class="fas fa-map-marked-alt fa-lg mr-2"></i>Get Directions</a>'+
        '</div>'+
        '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 200
        });

        // The marker, positioned at the job location
        var marker = new google.maps.Marker({
            position: jobLocation,
            map: map
        });

        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }

    </script>
<?php }?>

<!-- Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALVxwyRMC_j6k8kTohW7MsDUJTYIUf_tw&callback=initMap">
</script>
<script>
    $('.videoModal').on('hide.bs.modal', function(e) {
        var $if = $(e.delegateTarget).find('video');
        var src = $if.attr("src");
        $if.attr("src", '/empty.html');
        $if.attr("src", src);
    });
</script>

<?php mysqli_free_result($job_location_set);?>
<?php include SHARED_PATH . '/public_footer.php';?>
