<?php require_once '../private/initialize.php';?>
<?php include SHARED_PATH . '/jobmap_header.php';?>
<?php include SHARED_PATH . '/js_auto_complete.php';

unset($_SESSION['job_id']);
unset($_SESSION['search']);
unset($_SESSION['location']);
?>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="locationResults">
            <ul id="jobSectorFilters" style="visibility: hidden" class="list-unstyled components">
                <li class="sectorFilterByToggler">
                    <a href="#jobSectors" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle filter">Filter by Job Sector</a>
                    <ul class="collapse list-unstyled" id="jobSectors">
                        <li class="form-check">
                          <input id="check-all" class="form-check-input ca" type="checkbox" value="Check all" onclick="check();" >
                          <label class="form-check-label ca font-weight-bold mb-1" for="check-all" onclick="check();">Check all</label>
                        </li>
                        <li class="form-check">
                          <input id="uncheck-all" class="form-check-input ca" type="checkbox" value="Uncheck all" onclick="uncheck();">
                          <label class="form-check-label ca font-weight-bold mb-1" for="uncheck-all" onclick="uncheck();">Uncheck all</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector blue" type="checkbox" id="adminbox" value="admin" onchange="boxclick(this,'admin')" checked />
                          <label class="form-check-label sector blue mb-1" for="adminbox">Admininistrative and clerical</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector teal" type="checkbox" id="advertisingbox" value="advertising" onchange="boxclick(this,'advertising')" checked />
                          <label class="form-check-label sector teal mb-1" for="advertisingbox">Advertising, marketing and PR</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector red" type="checkbox" id="healthbox" value="health" onchange="boxclick(this,'health')" checked />
                          <label class="form-check-label sector red mb-1" for="healthbox">Health and social care</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector green " type="checkbox" id="agriculturebox" value="agriculture" onchange="boxclick(this,'agriculture')" checked />
                          <label class="form-check-label sector green mb-1" for="agriculturebox">Agriculture, horticulture and animal services</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector teal" type="checkbox" id="artbox" value="art" onchange="boxclick(this,'art')" checked />
                          <label class="form-check-label sector teal mb-1" for="artbox">Arts, crafts and design</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector red" type="checkbox" id="cateringbox" value="catering" onchange="boxclick(this,'catering')" checked />
                          <label class="form-check-label sector red mb-1" for="cateringbox">Catering services</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector red" type="checkbox" id="educationbox" value="education" onchange="boxclick(this,'education')" checked />
                          <label class="form-check-label sector red mb-1" for="educationbox">Education and training</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector green" type="checkbox" id="environmentbox" value="environment" onchange="boxclick(this,'environment')" checked />
                          <label class="form-check-label sector green mb-1" for="environmentbox">Environmental sciences</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector blue" type="checkbox" id="financebox" value="finance" onchange="boxclick(this,'finance')" checked />
                          <label class="form-check-label sector blue mb-1" for="financebox">Financial services</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector green" type="checkbox" id="ITbox" value="IT" onchange="boxclick(this,'IT')" checked />
                          <label class="form-check-label sector green mb-1" for="ITbox">Information technology and information management</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector blue" type="checkbox" id="legalbox" value="legal" onchange="boxclick(this,'legal')" checked />
                          <label class="form-check-label sector blue mb-1" for="legalbox">Legal services</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector blue" type="checkbox" id="businessbox" value="business" onchange="boxclick(this,'business')" checked />
                          <label class="form-check-label sector blue mb-1" for="businessbox">Business management and planning</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector green" type="checkbox" id="manufacturingbox" value="manufacturing" onchange="boxclick(this,'manufacturing')" checked />
                          <label class="form-check-label sector green mb-1" for="manufacturingbox">Manufacturing and engineering</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector teal" type="checkbox" id="performancebox" value="performance" onchange="boxclick(this,'performance')" checked />
                          <label class="form-check-label sector teal mb-1" for="performancebox">Performing arts and media</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector blue" type="checkbox" id="propertybox" value="property" onchange="boxclick(this,'property')" checked />
                          <label class="form-check-label sector blue mb-1" for="propertybox">Property and facilities management</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector teal" type="checkbox" id="publishingbox" value="publishing" onchange="boxclick(this,'publishing')" checked />
                          <label class="form-check-label sector teal mb-1" for="publishingbox">Publishing and journalism</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector red" type="checkbox" id="retailbox" value="retail" onchange="boxclick(this,'retail')" checked />
                          <label class="form-check-label sector red mb-1" for="retailbox">Retail sales and customer service</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector green" type="checkbox" id="sciencebox" value="science" onchange="boxclick(this,'science')" checked />
                          <label class="form-check-label sector green mb-1" for="sciencebox">Science and research</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector blue" type="checkbox" id="securitybox" value="security" onchange="boxclick(this,'security')" checked />
                          <label class="form-check-label sector blue mb-1" for="securitybox">Security and uniformed services</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector teal" type="checkbox" id="sportsbox" value="sports" onchange="boxclick(this,'sports')" checked />
                          <label class="form-check-label sector teal mb-1" for="sportsbox">Sport, leisure and tourism</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector blue" type="checkbox" id="transportbox" value="transport" onchange="boxclick(this,'transport')" checked />
                          <label class="form-check-label sector blue mb-1" for="transportbox">Transport and logistics</label>
                        </li>
                        <li class="form-check">
                          <input class="form-check-input sector red" type="checkbox" id="generalbox" value="general" onchange="boxclick(this,'general')" checked />
                          <label class="form-check-label sector red mb-1" for="generalbox">General and personal services</label>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul id="locationSelect" style="visibility: hidden"></ul>
        </div>
    </nav>
    <!-- Page Content  -->
    <div id="page-content">
        <div class="container-fluid" style="background-color:#fafafa;">
            <button type="button" id="sidebarCollapse" class="navbar-btn float-left">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <form id="target">
                <div class="form-row">
                  <div class="col-lg-5">
                      <div class="form-group auto-widget">
                          <input type="search" class="form-control col-md mr-2" placeholder="Location [Required] - Lieu [Requis]"
                              aria-label="location_search" aria-describedby="location_search" name="location"
                              id="location_search" value="" required>
                          <button type="button" title="clear" id="clearbutton2" class="invisible"></button>
                      </div>
                  </div>
                    <div class="col-lg-4">
                        <div class="form-group auto-widget">
                            <input type="search" class="form-control col-md mr-2" placeholder="Job keyword [Optional] - Mot clé de travail [en option]"
                                aria-label="job_search" aria-describedby="job_search" name="search" id="job_search"
                                value="">
                            <button type="button" title="clear" id="clearbutton" class="invisible"></button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <select class="custom-select" id="radiusSelect">
                                <option value="5" selected>within 5 miles</option>
                                <option value="10">within 10 miles</option>
                                <option value="15">within 15 miles</option>
                                <option value="25">within 25 miles</option>
                                <option value="50">within 50 miles</option>
                                <option value="100">within 100 miles</option>
                            </select>
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-success mb-2" id="searchButton" title="Find all jobs"><i class="fas fa-search fa-lg mr-2"></i>Find Jobs</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="map" class="jobMap"></div>
      </div>
    

<script>
  var map;
  var markers = [];
  var markerIcon = {
    catering: {
      url: 'https://pontoonapps.com/jobmap/images/pins/red-pin.png'
    },
    education: {
      url: 'https://pontoonapps.com/jobmap/images/pins/red-pin.png'
    },
    general: {
      url: 'https://pontoonapps.com/jobmap/images/pins/red-pin.png'
    },
    health: {
      url: 'https://pontoonapps.com/jobmap/images/pins/red-pin.png'
    },
    retail: {
      url: 'https://pontoonapps.com/jobmap/images/pins/red-pin.png'
    },
    agriculture: {
      url: 'https://pontoonapps.com/jobmap/images/pins/green-pin.png'
    },
    environment: {
      url: 'https://pontoonapps.com/jobmap/images/pins/green-pin.png'
    },
    IT: {
      url: 'https://pontoonapps.com/jobmap/images/pins/green-pin.png'
    },
    manufacturing: {
      url: 'https://pontoonapps.com/jobmap/images/pins/green-pin.png'
    },
    science: {
      url: 'https://pontoonapps.com/jobmap/images/pins/green-pin.png'
    },
    admin: {
      url: 'https://pontoonapps.com/jobmap/images/pins/blue-pin.png'
    },
    business: {
      url: 'https://pontoonapps.com/jobmap/images/pins/blue-pin.png'
    },
    finance: {
      url: 'https://pontoonapps.com/jobmap/images/pins/blue-pin.png'
    },
    legal: {
      url: 'https://pontoonapps.com/jobmap/images/pins/blue-pin.png'
    },
    property: {
      url: 'https://pontoonapps.com/jobmap/images/pins/blue-pin.png'
    },
    security: {
      url: 'https://pontoonapps.com/jobmap/images/pins/blue-pin.png'
    },
    transport: {
      url: 'https://pontoonapps.com/jobmap/images/pins/blue-pin.png'
    },
    advertising: {
      url: 'https://pontoonapps.com/jobmap/images/pins/teal-pin.png'
    },
    art: {
      url: 'https://pontoonapps.com/jobmap/images/pins/teal-pin.png'
    },
    performance: {
      url: 'https://pontoonapps.com/jobmap/images/pins/teal-pin.png'
    },
    publishing: {
      url: 'https://pontoonapps.com/jobmap/images/pins/teal-pin.png'
    },
    sports: {
      url: 'https://pontoonapps.com/jobmap/images/pins/teal-pin.png'
    }
  };

  var infoWindow;
  var locationSelect;
  var jobSectorFilters;

  function initMap() {
    // Create a new StyledMapType object, passing it an array of styles,
    // and the name to be displayed on the map type control.
    // Styles taken from https://snazzymaps.com/style/61/blue-essence
    var styledMapType = new google.maps.StyledMapType(
    [
      {
          "featureType": "landscape.natural",
          "elementType": "geometry.fill",
          "stylers": [
              {
                  "visibility": "on"
              },
              {
                  "color": "#e0efef"
              }
          ]
      },
      {
          "featureType": "poi",
          "elementType": "geometry.fill",
          "stylers": [
              {
                  "visibility": "on"
              },
              {
                  "hue": "#1900ff"
              },
              {
                  "color": "#c0e8e8"
              }
          ]
      },
      {
          "featureType": "road",
          "elementType": "geometry",
          "stylers": [
              {
                  "lightness": 100
              },
              {
                  "visibility": "simplified"
              }
          ]
      },
      {
          "featureType": "road",
          "elementType": "labels",
          "stylers": [
              {
                  "visibility": "on"
              }
          ]
      },
      {
          "featureType": "transit.line",
          "elementType": "geometry",
          "stylers": [
              {
                  "visibility": "on"
              },
              {
                  "lightness": 700
              }
          ]
      },
      {
          "featureType": "water",
          "elementType": "all",
          "stylers": [
              {
                  "color": "#7dcdcd"
              }
          ]
      }
    ],
    {name: 'Job Map'});

    var portsmouth = { lat: 50.794851, lng: -1.090886 };
    map = new google.maps.Map(document.getElementById('map'), {
      center: portsmouth,
      zoom: 14,
      mapTypeControlOptions: {
        mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
        'styled_map'],
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
      },
    zoomControl:true,
    zoomControlOptions: {
        position:google.maps.ControlPosition.RIGHT_TOP
    },
    scaleControl:true,
    streetViewControl: true,
    streetViewControlOptions:{
        position:google.maps.ControlPosition.RIGHT_TOP
    }
    });
    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');

    infoWindow = new google.maps.InfoWindow();
    $('#target').submit(function (event) {
      // alert( "Handler for .submit() called." );
      check();
      event.preventDefault();
    });

    searchButton = document.getElementById('searchButton').onclick = searchLocations;
    locationSelect = document.getElementById('locationSelect');
    jobSectorFilters = document.getElementById('jobSectorFilters');
    locationSelect.onchange = function () {
      var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
      if (markerNum != 'none') {
        google.maps.event.trigger(markers[markerNum], 'click');
      }
    };
  }

  function searchLocations() {
    var address = document.getElementById('location_search').value;
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: address }, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        searchLocationsNear(results[0].geometry.location);
      } else {
        alert(address + ' location not found');
      }
    });
  }

  function clearLocations() {
    infoWindow.close();
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }
    markers.length = 0;

    locationSelect.innerHTML = '';
    var option = document.createElement('h2');
    // var address = document.getAttribute("address");
    // option.value = "none";
    var searchResultsClass = 'searchResults';
    option.setAttribute('class', searchResultsClass);

    option.innerHTML = 'Search results:';
    locationSelect.appendChild(option, searchResultsClass);
  }

  function searchLocationsNear(center) {
    clearLocations();
    var jobTitle = document.getElementById('job_search').value;
    var sector = document.getElementById('job_search').value;
    var recruiter = document.getElementById('job_search').value;
    var address = document.getElementById('location_search').value;
    var radius = document.getElementById('radiusSelect').value;
    var searchUrl = '/jobmap/job_locator.php?name=' + jobTitle + '&sector=' + sector + '&recruiter=' + recruiter + '&address=' + address + '&lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
    // var searchUrl2 = 'users_job_locator.php?name=' + jobTitle + '&sector=' + sector + '&recruiter=' + recruiter + '&address=' + address + '&lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;

    console.log(searchUrl);
    // console.log(searchUrl2);
    // downloadUrl(searchUrl + searchUrl2, function (data) {

    downloadUrl(searchUrl, function (data) {
      var xml = parseXml(data);
      var markerNodes = xml.documentElement.getElementsByTagName('marker');
      var bounds = new google.maps.LatLngBounds();
      for (var i = 0; i < markerNodes.length; i++) {
        var id = markerNodes[i].getAttribute('id');
        var jobId = markerNodes[i].getAttribute('job_id');
        // var userid = markerNodes[i].getAttribute('user_id');
        var name = markerNodes[i].getAttribute('name');
        var name2 = markerNodes[i].getAttribute('name2');
        var company = markerNodes[i].getAttribute('company_name');
        var companyName2 = markerNodes[i].getAttribute('company_name2');
        var companyLogo = markerNodes[i].getAttribute('company_logo');
        var address = markerNodes[i].getAttribute('address');
        var city = markerNodes[i].getAttribute('city');
        var jsectorName = markerNodes[i].getAttribute('jobsector_name');
        var jsectorShort = markerNodes[i].getAttribute('jsector_short');
        var jsectorGroup = markerNodes[i].getAttribute('jsector_group');
        var jsectorIcon = markerNodes[i].getAttribute('jsector_icon');
        var jobdesc = markerNodes[i].getAttribute('job_desc');
        var jobTypeName = markerNodes[i].getAttribute('jobtype_name');
        var salary = markerNodes[i].getAttribute('salary');
        var currencyID = markerNodes[i].getAttribute('currency_id');
        var currencyCode = markerNodes[i].getAttribute('currency_code');
        var jobRateName = markerNodes[i].getAttribute('jobrate_name');
        var distance = parseFloat(markerNodes[i].getAttribute('distance'));
        var latlng = new google.maps.LatLng(
          parseFloat(markerNodes[i].getAttribute('lat')),
          parseFloat(markerNodes[i].getAttribute('lng')));

        createOption(name, company, jsectorName, jsectorGroup, jsectorShort, jsectorIcon, distance, i);
        // createModal(name, company, i);
        createMarker(latlng, jobId, name, name2, company, companyName2, companyLogo, address, city, jsectorName, jsectorShort, jsectorGroup, jobdesc, jobTypeName, salary, currencyID, currencyCode, jobRateName);
        // createMarker2(latlng, name, company, address, jsectorName, jsectorShort, jsectorGroup, jobdesc);
        bounds.extend(latlng);
      }
      // Don't zoom in too far on only one marker
      if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
        var extendPoint1 = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.01, bounds.getNorthEast().lng() + 0.01);
        var extendPoint2 = new google.maps.LatLng(bounds.getNorthEast().lat() - 0.01, bounds.getNorthEast().lng() - 0.01);
        bounds.extend(extendPoint1);
        bounds.extend(extendPoint2);
      }

      map.fitBounds(bounds);
      locationSelect.style.visibility = 'visible';
      jobSectorFilters.style.visibility = 'visible';
      locationSelect.onchange = function () {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        google.maps.event.trigger(markers[markerNum], 'click');
      };
    });
  }

  function createMarker(latlng, jobId, name, name2, company, companyName2, companyLogo, address, city, jsectorName, jsectorShort, jsectorGroup, jobdesc, jobTypeName, salary, currencyID, currencyCode, jobRateName) {

    var theJobId = '';
    var jobButton = '';
    var jobButtonName = 'More information';
    var jobDescTitle = '';
    var theCity = '';
    var theJobTypeName = '';
    var theSalary = '';
    var theCurrencySymbol = '';
    var theCompanyLogo = '';
    var theJobRateName = '';
    if (currencyID == '1') {
      theCurrencySymbol = "&pound;";
    }
    else if (currencyID == '2') {
      theCurrencySymbol = "&euro;";
      jobButtonName = 'Plus d\'information';
    }
    else {
      theCurrencySymbol = "&dollar;";
    }
    var jobDetailsUrl = '<?php echo url_for('/jobmap/job_details.php');?>'
    if (name != 'No jobs found!') {
        theCompanyLogo = '<img class=\'float-right company_logo_sml mb-2\' alt="' + company + '" title="' + company + '" src=\'recruiters/companies/logos/' + companyLogo + '\'/>';
        jobDescTitle = '<h5 class="my-1"><b>Job description:</b></h5>';
        theSalary = '<h6>' + theCurrencySymbol + salary + ' ' + '(' + currencyCode + ') ' + jobRateName + ' - ' + jobTypeName + '</h6>';
        jobButton = '<a class=\'btn btn-green btn-sm mt-4 ml-4 float-right\' role=\'button\' href=\'' + jobDetailsUrl + '?' + 'job_id=' + jobId + '\'' + 'target=\'_blank\'>' + jobButtonName + '</a>';
    }
    var html = '' + theCompanyLogo + '<h3 class="text-capitalize">' + name + '</h3>' + '<h4>' + company + '</h4>' + '<h5>' + address + ' ' + theCity + '</h5>' + '<h5>' + city + '</h5>' + '<h6>' + jsectorName + '</h6>' + theSalary + theJobRateName + theJobTypeName + jobDescTitle + jobdesc + jobButton;
    var icon = markerIcon[jsectorShort] || {};
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      icon: icon.url
    });
    google.maps.event.addListener(marker, 'click', function () {
      infoWindow.setContent(html);
      infoWindow.open(map, marker);
    });
    marker.mycategory = jsectorShort;
    markers.push(marker);
  }

  function createOption(name, company, jsectorName, jsectorGroup, jsectorShort, jsectorIcon, distance, num) {
    var option = document.createElement('li');
    var JobItemHoverClass = 'jobItem_' + jsectorGroup;
    option.setAttribute('id', jsectorShort);
    option.setAttribute('class', JobItemHoverClass);
    option.value = num;
    option.innerHTML = '<img class=\'float-left mb-2 pr-2\' alt=\'' + jsectorName + '\' title=\'' + jsectorName + '\' src=\'/jobmap/images/icons/jobsector_icons/' + jsectorIcon + '\'/><h4 class=\'text-capitalize\'>' + name + '</h4><h5>' + company + '</h5>';
    locationSelect.appendChild(option, JobItemHoverClass);
  }

  $('#locationSelect').on('click', 'li', function () {
    var markerNum = $(this).val();
    if (markerNum != 'none') {
      google.maps.event.trigger(markers[markerNum], 'click');
      markers[markerNum].setVisible(true);
    }
  });

  function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

    request.onreadystatechange = function () {
      if (request.readyState == 4) {
        request.onreadystatechange = doNothing;
        callback(request.responseText, request.status);
      }
    };

    request.open('GET', url, true);
    request.send(null);
  }

  function parseXml(str) {
    if (window.ActiveXObject) {
      var doc = new ActiveXObject('Microsoft.XMLDOM');
      doc.loadXML(str);
      return doc;
    } else if (window.DOMParser) {
      return (new DOMParser).parseFromString(str, 'text/xml');
    }
  }

  function doNothing() { }

  function check() {
    $('input[type="checkbox"]').prop('checked', true).change();
  }

  function uncheck() {
    $('input[type="checkbox"]').prop('checked', false).change();
  }
  //shows all markers of a particular category, and ensures the checkbox is checked
  function show(jsectorShort) {
    for (var i = 0; i < markers.length; i++) {
      if (markers[i].mycategory == jsectorShort) {
        markers[i].setVisible(true);
      }
    }
    // == check the checkbox ==
    document.getElementById(jsectorShort + 'box').checked = true;
  }

  // == hides all markers of a particular category, and ensures the checkbox is cleared ==
  function hide(jsectorShort) {
    for (var i = 0; i < markers.length; i++) {
      if (markers[i].mycategory == jsectorShort) {
        markers[i].setVisible(false);
      }
    }
    // == clear the checkbox ==
    document.getElementById(jsectorShort + 'box').checked = false;

    // == close the info window, in case its open on a marker that we just hid
    infoWindow.close();
  }

  // == a checkbox has been clicked ==
  function boxclick(box, jsectorShort) {
    if (box.checked) {
      show(jsectorShort);
      var $theseLI = $('#locationSelect' + '>' + '#' + jsectorShort);
      $theseLI.css('display', '');
      // $theseLI.find('.' + jsectorGroup).css('display','');
    } else {
      var $theseLI = $('#locationSelect' + '>' + '#' + jsectorShort);
      $theseLI.css('display', 'none');
      // $theseLI.find('.' + jsectorGroup).css('display','');
      hide(jsectorShort);
    }
  }

  $('.checkbox').change(function () {
    var cat = $(this).attr('value');
    // If checked
    if ($(this).is(':checked')) {
      show(cat);
    } else {
      hide(cat);
    }
  });
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALVxwyRMC_j6k8kTohW7MsDUJTYIUf_tw&region=UK&callback=initMap"></script>

<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('sidebarActive');
            $(this).toggleClass('sidebarActive');
            // console.log(sidebarCollapse);
        });
    });
</script>
<!-- Cookie notice script -->
<script src="<?php echo url_for('/jobmap/js/cookiealert.js'); ?>"></script>
<!-- Scroll to top icon script -->
<script src="<?php echo url_for('/jobmap/js/scroll_to_top.js');?>"></script>
<!-- Header nav & toggle show / hide elements script -->
<script src="<?php echo url_for('/jobmap/js/showhide.js');?>"></script>

<!-- Bootstrap scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

