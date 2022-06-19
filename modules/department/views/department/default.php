<?php
	global $tmpl;
	$tmpl -> addStylesheet('cat','modules/department/assets/css');
	$tmpl -> addStylesheet('jquery.mCustomScrollbar','modules/department/assets/css');
//	$tmpl -> addScript('data','modules/department/assets/js');
	$tmpl -> addScript('jquery.mCustomScrollbar.concat.min','modules/department/assets/js');
	$tmpl -> addScript('cat','modules/department/assets/js','bottom');
	$total = count($list);
	$i=0;
	$tmpl->addTitle("Hệ thống cửa hàng");
?>	

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9lE-qL2km2EUJYwM6MNW2l2P_MT_ct1Y&callback=initMap&sensor=false"
  type="text/javascript"></script>
<?php
//	$tmpl -> addScript('smartinfowindow','modules/department/assets/js');
?>	
<script>
 $(document).ready(function () {
    // Asynchronously Load the map API
    
});

function initialize(address,latitude,longitude,info,zoom) {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
    var image = '/images/arrow-up1.png';
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
    // var marker = new google.maps.Marker({
    //   position: myLatLng,
    //   map: map,
    //   icon: image
    // });
    // Multiple Markers
   
    var markers2 = {
        
        <?php
            foreach($list as $value){
                ?>
                <?php echo $value->id; ?>:'<div class="info_content"><div class="map-top"><h4><?php echo $value->name ?></h4><p><?php echo "Địa chỉ: ".$value->address ?></p><p><?php echo "Điện thoại: ".$value->phone ?></p><p><?php echo "Email: ".$value->email ?></p></div><div class="map-bottom"><?php foreach($info_other as $value_other){ if($value->id==$value_other->record_id){ echo "<p>".$value_other->source."</p>"; }} ?></div></div>',
        <?php
            }
        ?>
            
                        
                        };
    
    if(address != '' && latitude != '' && longitude != ''){
        var markers = [
            [address, latitude,longitude]
        ];
    }else{
    var markers = [
        <?php
            foreach($list as $value){
                ?>
                ["<?php echo $value->name; ?>", <?php echo $value->latitude; ?>,<?php echo $value->longitude; ?>],
        <?php
            }
        ?>
            
                        
                                ];

}                           
        // Info Window Content
    if(info ==0){    
    var infoWindowContent = [
        <?php
            foreach($list as $value){
                ?>
                ['<div class="info_content">' +'<div class="map-top"><h4><?php echo $value->name ?></h4><p><?php echo "Địa chỉ: ".$value->address ?></p><p><?php echo "Điện thoại: ".$value->phone ?></p><p><?php echo "Email: ".$value->email ?></p></div>' +'<div class="map-bottom"><?php foreach($info_other as $value_other){ if($value->id==$value_other->record_id){ echo "<p>".$value_other->source."</p>"; }} ?></div></div>'],
                
        <?php
            }
        ?>
    ];
    }else{
        var infoWindowContent = [
       [markers2[info]]
    ];
    }
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Loop through our array of markers & place each one on the map
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0],
            icon: '/images/point.png'
        });

        // Allow each marker to have an info window
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() { 
                infoWindow.setContent(infoWindowContent[i][0]);
            
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
		if(zoom){
        this.setZoom(zoom);
		}else{
        this.setZoom(<?php echo isset($_SESSION["city"])?"13":"6"; ?>);
		}
        google.maps.event.removeListener(boundsListener);
    });

}
  jQuery(function($) {
    initialize('','','',0,6);
});
</script>
<div class="wraper-department">
    <div class="wrapper-ct-depart clearfix">
        <?php
        if ($detect->isMobile()) {
            ?>
            <div class="left-de" style="margin-bottom:15px">
                <div id="map_canvas" ></div>
            </div>
            <?php
        }
        ?>
        <div class="right-de fr">
            <h3 class="title-add">Tìm kiếm theo địa chỉ</h3>
            <div class="wrapper-select-add">
                <select name="province" id="province"  onchange="changeCity22(this.value,'district');" >
                    <option value="">--Chọn tỉnh/thành phố--</option>
                    <?php foreach ($dataCity as $province) {
                        ?>
                        <option <?php if (@$_SESSION["city"] == $province->id) echo 'selected="selected"'; if ($province->id==1) echo 'selected="selected"'; ?> value="<?php echo $province->id; ?>">
                            <?php echo $province->name; ?>
                        </option>
                    <?php } ?>

                </select>
                <select name="district" id="district"   onchange="changeDistrict(this.value,' ')">
                    <option value="0">--Chọn Quận/Huyện--</option>
                    <?php foreach ($district as $city) {
                        ?>
                        <option <?php if (@$_SESSION["district"] == $city->id) echo 'selected="selected"'; ?> value="<?php echo $city->id; ?>">
                            <?php echo $city->name; ?>
                        </option>
                    <?php } ?>

                </select>
            </div>
            <div class="wrapper-list-agency">
                <ul class="list-item-agency">
                    <?php
                    $html = "";
                    foreach ($list as $value) {
                        ?>
                        <li class="item-agency clearfix">
                            <img  onclick="initialize('<?php echo $value->name; ?>',<?php echo $value->latitude; ?>,<?php echo $value->longitude ?>,<?php echo $value->id; ?>,19)" class="img-agency fl" alt="<?php echo $value->name; ?>" src="<?php echo URL_ROOT . str_replace("original", "resized", $value->image) ?>" />
                            <div class="wrapper-info-agency">
                                <h2 class="name-agency" onclick="initialize('<?php echo $value->name; ?>',<?php echo $value->latitude; ?>,<?php echo $value->longitude ?>,<?php echo $value->id; ?>,19)"><?php echo $value->name; ?></h2>
                                <p class="add-agency"><?php echo $value->address; ?></p>
                                <p class="add-phone"><?php echo $value->phone; ?></p>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
        if (!$detect->isMobile()) {
            ?>
            <div class="left-de">
                <div id="map_canvas" ></div>
            </div>
            <?php
        }
        ?>

    </div>
</div>
<div class="clearfix"></div>