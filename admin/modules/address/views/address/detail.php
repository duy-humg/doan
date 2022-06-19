<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyA9lE-qL2km2EUJYwM6MNW2l2P_MT_ct1Y&v=3.exp&sensor=true&libraries=places&language=vi"></script>
<link rel="stylesheet" href="<?php echo URL_ROOT.'libraries/jquery/google_map/gg_map.css'?>" />
<style>
    #gmap {
  height: 400px;
  margin: 20px 0px;
  width: 100% !important;
}

.controls {
    margin-top: 16px;
    border: 1px solid transparent;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    height: 32px;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 15px;
    text-overflow: ellipsis;
    width: 400px;
}

#pac-input:focus {
    border-color: #4d90fe;
}

.pac-container {
    font-family: Roboto;
}

#type-selector {
    color: #fff;
    background-color: #4d90fe;
    padding: 5px 11px 0px 11px;
}

#type-selector label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
}
</style>
<script>
var oldMarker;
function initialize() {
    <?php 
    $latitude = @$data -> latitude? $data -> latitude:'21.028224';
    $longitude = @$data -> longitude? $data -> longitude:'105.835419';
    ?>
    var latlng = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>);
    var markers = [];
	var image = '/images/point.png';
    var myOptions = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,  
    };
    var map = new google.maps.Map(document.getElementById("gmap"),myOptions);
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
    // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // [START region_getplaces]
  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });
  // [END region_getplaces]

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
    function placeMarker(location) {
        marker = new google.maps.Marker({
            position: location,
            map: map,
            animation: google.maps.Animation.DROP,
			icon: image,
        });
        if (oldMarker != undefined){
            oldMarker.setMap(null);
        }
        oldMarker = marker;
        map.setCenter(location);
		//var infowindow = new google.maps.InfoWindow({
//			content: $('#title').val(),
//			maxWidth: 3500
//		});
		//infowindow.open(map,marker);
		document.getElementById("latitude").value = location.lat();

		document.getElementById("longitude").value = location.lng();
    }
 	placeMarker(latlng);
}
$(document).ready(function(){
google.maps.event.addDomListener(window, 'load', initialize);
});
</script>
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<!-- FOR TAB -->	
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin(0);
	?>

                <?php include_once 'detail_base.php';?>

	<?php 

	$this -> dt_form_end(@$data,0);

?>
<script type="text/javascript" src="<?php // echo URL_ROOT.'libraries/jquery/google_map/gg_map.js'?>"></script>	
<script>
function changeCity22($city_id,$id){
    $.ajax({
		type : 'get',
		url : '/admin_adcbook/index.php?module=address&view=address&raw=1&task=loadDistricts',
		dataType : 'html',
		data: {city_id:$city_id},
		success : function(data){
            $('#'+$id).html(data);
        },
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
    return false;
}
</script>