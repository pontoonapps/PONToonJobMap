<?php require_once('../../../private/initialize.php');
require_login();

$page_title = 'Staff Menu';
include(SHARED_PATH . '/staff_header.php'); ?>

<div class="container">
    <div class="jumbotron border-red shadow">
        <a title="Return to Dashboard" href="<?php echo url_for('/jobmap/staff/dashboard.php');?>" class="btn btn-secondary btn-md mb-2" role="button"><i class="fas fa-angle-double-left fa-lg mr-2"></i>Dashboard</a>
        <a class="btn btn-secondary btn-md float-right" href="<?php echo url_for('/jobmap/staff/logout.php'); ?>" role="button">Log Out<i class="fas fa-sign-out-alt fa-lg ml-2"></i></a>
        <h1>All job locations</h1>
        <?php $total_job_count = count_all_jobs();?>

        <h3>Total: <b><?php echo $total_job_count; ?></b></h3>
        <div id="map"></div>
    </div>
</div>

<!------ Include the above in your HEAD tag ---------->
<script src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyALVxwyRMC_j6k8kTohW7MsDUJTYIUf_tw">
</script>

<script>
    // var marker;
    var infowindow = new google.maps.InfoWindow;
    var map;
    var red_icon =  'https://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
    var purple_icon =  'https://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
    var locations = <?php get_all_job_locations() ?>;
    var myOptions = {
        zoom: 14,
        center: new google.maps.LatLng(50.794851, -1.090886),
        mapTypeId: 'roadmap'
    };
    map = new google.maps.Map(document.getElementById('map'), myOptions);


        var i ;
        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon :   locations[i][4] === '1' ?  red_icon :purple_icon,
                html: "<div class=\"admin_map_popup\" id='form'>" +
                "<div id='iw-container'>" +
                "<h4 class=\"mb-1\" id='job_title' value=''>"+locations[i][3]+"</h4>" +
                "</div>" +
                "<h5 class=\"mb-1\" id='company'>"+locations[i][4]+"</h5>" +
                "<div class=\"mb-1\" id='location'>"+locations[i][5]+"</div>" +
                "</div>"
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    $("#id").val(locations[i][0]);
                    $("#job_title").val(locations[i][3]);
                    $("#company").val(locations[i][4]);
                    $("#location").val(locations[i][5]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

</script>

<!-- <div class="admin_map_popup" style="display: none;" id="form">
    <div class="map1">
            <input name="id" type="hidden" id="id"/> -->
            <!-- <a>Job Title:</a> -->
            <!-- <p id='job_title'></p> -->
            <!-- <div id="iw-container">
                <div class="iw-title"><input type="text" readonly class="form-control-plaintext" id="job_title" value="job-title"></div>
            </div>
            <input type="text" readonly class="form-control-plaintext" id="company">
            <input type="text" readonly class="form-control-plaintext" id="location">
    </div>
</div> -->
<?php include(SHARED_PATH . '/public_footer.php'); ?>