<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Edit Restaurant</h1>
                </div>
                <div class="page_content">
                    <p>
                        <?php $x = $this->Session->flash(); ?>
                        <?php if ($x) { ?>
                        <div class="alert success">
                            <span class="icon"></span>
                            <strong></strong><?php echo $x; ?>
                        </div>
                        <?php } ?>
                    </p>
                    <div class="restaurants index">
                        <?php echo $this->Form->create('Restaurant', array('id' => 'tab', 'type' => 'file')); ?>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php echo "Username:- ". $this->request->data['User']['email'];
                                ?>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Store Name:','required' => true)); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->input('name_ar', array('class' => 'form-control', 'label' => 'Store Name in arabic:','required' => true)); ?>
                            </div>
                            <div class="form-group">
                    <?php echo $this->Form->input('phone', array('class' => 'form-control', 'label' => 'Store Phone:','required' => true,'maxlength'=>12)); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('owner_name', array('class' => 'form-control', 'label' => 'Owner Name:','required' => true)); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('owner_phone', array('class' => 'form-control', 'label' => 'Owner Phone:','required' => true,'maxlength'=>12)); ?>
                </div>
                            <div class="form-group">

                    <div style="position:relative; width:100%;">
                        <?php echo $this->Form->input('address', array('class' => 'form-control', 'label' => 'Address:','id'=>'address','type'=>'text')); ?>
                        <div style="position: absolute; z-index: 9999; width:100%">
                            <a class="btn btn-primary" id='getlatlong' style="position: absolute;right:30px; top:-8px;" >Get Lat&Long</a></div>
                        <div id="map" style="position: absolute; right:-600px;top:0; width:500px;height:300px"></div>
                    </div>

                    </div>
<!--                <div class="form-group">
                   <label>Select Address:</label>
                    <input id="address" name="data[Restaurant][address]" placeholder="Select Address" onFocus="geolocate()" type="text" class="form-control" value="<?php echo $this->request->data['Restaurant']['address']; ?>"/>
                    
                </div>-->
                <div class="form-group">  
                    <label>Latitude:</label>
                    <input type="text" name="data[Restaurant][latitude]" id="latitude" value="<?php echo $this->request->data['Restaurant']['latitude']; ?>">
                    <?php //echo $this->Form->input('street_number', array('class' => 'form-control', 'label' => 'Street Number:', 'id' => 'street_number')); ?>
                </div>
                
                <div class="form-group">   
                    <label>Longitude:</label>
                    <input type="text" name="data[Restaurant][longitude]" id="longitude" value="<?php echo $this->request->data['Restaurant']['longitude']; ?>">
                    <?php //echo $this->Form->input('street_number', array('class' => 'form-control', 'label' => 'Street Number:', 'id' => 'street_number')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('address_ar', array('class' => 'form-control', 'label' => 'Address Ar:','required' => true)); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('city', array('class' => 'form-control locality', 'label' => 'City:', 'id' => 'locality','required' => true)); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('state', array('class' => 'form-control', 'label' => 'State:', 'id' => 'administrative_area_level_1','required' => true)); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('zip', array('class' => 'form-control', 'label' => 'Zip:','id' => 'postal_code','required' => true)); ?>
                </div>          
                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => 'Description:','required' => true)); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('description_ar', array('class' => 'form-control', 'label' => 'Description in arabic:','required' => true)); ?>
                </div>
                <?php if(!empty($Restaurant['Restaurant']['logo'])){ ?>
                <div class="form-group">
                    <?php
                    $restaurantPath = '/files/restaurants/';
                    echo $this->Html->image($restaurantPath . $Restaurant['Restaurant']['logo'], array('alt' => 'Store Logo', 'width' => 100));
                    ?>
                </div> 
                <?php } ?>
                <div class="form-group">
                    <label>Logo:</label>
                    <input type="file" name="data[Restaurant][logo]" class="form-control" id="RestaurantLogo" >
                    <?php //echo $this->Form->input('logo', array('type' => 'file', 'class' => 'form-control', 'label' => 'Logo:','value'=>'efr')); ?>
                </div>
                <?php if(!empty($Restaurant['Restaurant']['banner'])){ ?>
                <div class="form-group">
                    <?php
                    $restaurantPath = '/files/restaurants/';
                    echo $this->Html->image($restaurantPath . $Restaurant['Restaurant']['banner'], array('alt' => 'Store banner', 'width' => 100));
                    ?>
                </div> 
                <?php } ?>
                <div class="form-group">
                    <label>Banner Image:</label>
                    <input type="file" name="data[Restaurant][banner]" class="form-control" id="RestaurantLogo">
                    <?php //echo $this->Form->input('logo', array('type' => 'file', 'class' => 'form-control', 'label' => 'Logo:','value'=>'efr')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => 'Email:','required' => true)); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('delivery', array('class' => 'form-control1', 'type'=>'checkbox', 'label' => 'Delivery')); ?>
                </div>
               
                 
                <div class="form-group">
                    <?php echo $this->Form->input('takeaway', array('class' => 'form-control1', 'type'=>'checkbox', 'label' => 'Takeaway')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('catering', array('class' => 'form-control1', 'type'=>'checkbox', 'label' => 'Catering')); ?>
                </div>
                <div class="form-group">
                    <?php if(!empty($Restaurant['Restaurant']['offer_image'])){
                    echo $this->Html->image('/files/offers/' . $Restaurant['Restaurant']['offer_image'], array('alt' => 'Offer Image', 'width' => 100));
                    }
                    ?>
                </div> 
                <div class="form-group">
                    <label>Offer Image:</label>
                    <input type="file" name="data[Restaurant][offer_image]" class="form-control" id="RestaurantLogo">
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('offer_title', array('class' => 'form-control', 'label' => 'Offer Title:')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('rapid_booking', array('class' => 'form-control1', 'type'=>'checkbox', 'label' => 'Rapid Booking')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('verified', array('class' => 'form-control1', 'type'=>'checkbox', 'label' => 'Thoag Verified')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('is_featured', array('class' => 'form-control1', 'type'=>'checkbox', 'label' => 'Is Featured')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('lead_time', array('class' => 'form-control', 'label' => 'Lead Time(in hrs):')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('min_order', array('class' => 'form-control', 'label' => 'Minimum Order Amount:')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('opening_time', array('class' => 'form-control', 'label' => 'Opening Time:', 'type' => 'time')); ?>
                </div>

                <div class="form-group">
                    <?php echo $this->Form->input('closing_time', array('class' => 'form-control', 'label' => 'Closing Time:', 'type' => 'time')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('weekend_opening_time', array('class' => 'form-control', 'label' => 'Weekend Opening Time:', 'type' => 'time')); ?>
                </div>

                <div class="form-group">
                    <?php echo $this->Form->input('weekend_closing_time', array('class' => 'form-control', 'label' => 'Weekend Closing Time:', 'type' => 'time')); ?>
                </div>
                
                 <div class="form-group">
                    <?php
                    echo $this->Html->image('/files/restaurants/' . $Restaurant['Restaurant']['marker'], array('alt' => 'Marker', 'width' => 100));
                    ?>
                </div> 
                <div class="form-group">
                    <label>Map marker:</label>
                    <input type="file" name="data[Restaurant][marker]" class="form-control" id="RestaurantLogo">
                </div>
                <input type="hidden" name="data[Restaurant][created]" value="<?php echo date('Y-m-d H:i:s'); ?>">
                
                <input type="hidden" name="data[Restaurant][status]" value="1">
                <div class="btn-toolbar list-toolbar">
                    <?php echo $this->Form->submit('Save', array('formnovalidate' => true, 'class' => "submitres btn btn-primary")); ?>
                    <a href="<?php echo $this->Html->url(array('controller' => 'Restaurants', 'action' => 'admin_index')); ?>" data-toggle="modal" style="float: left;" class="btn btn-primary">Cancel</a>
                </div>
                        </div>
                        <?php //echo $this->Form->end(); ?>
                    </div><!-- End Here -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    
    $(document).ready(function(){
        var a_latitude = "<?php echo $this->request->data['Restaurant']['latitude'] ?>";
    var a_longitude = "<?php echo $this->request->data['Restaurant']['latitude'] ?>";
    console.log(a_latitude)
        //displayMap(a_latitude,a_longitude)
    })
    $("#getlatlong").click(function(){
        console.log('clicked')
        $.post("http://rajdeep.crystalbiltech.com/thoag/eng/restaurants/LatLongFromAddress",
        {
            address: $("#address").val()
        },
        function(data, status){
            console.log("Data: " + data + "\nStatus: " + status);
            if(status=='success'){
                var res = JSON.parse(data);
                displayMap(res.latitude,res.longitude)
            }
            
        });
    });
    function displayMap(latitude,longitude){
        console.log('display map')
        $('#RestaurantLatitude').val(latitude)
        $('#RestaurantLongitude').val(longitude)
        var myCenter = new google.maps.LatLng(latitude,longitude);
        var mapCanvas = document.getElementById("map");
        var mapOptions = {center: myCenter, zoom: 15};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position:myCenter,draggable: true});
        marker.setMap(map);
        
        google.maps.event.addListener(marker, 'dragend', function(evt){
            console.log('dragged')
            $('#latitude').val(evt.latLng.lat())
            $('#longitude').val(evt.latLng.lng())
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
    }

</script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>-->
<script src="https://maps.googleapis.com/maps/api/js" async defer></script>
<script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

//    var placeSearch, autocomplete;
//    var componentForm = {
//        street_number: 'short_name',
//        route: 'long_name',
//        locality: 'long_name',
//        administrative_area_level_1: 'long_name',
//        country: 'long_name',
//        postal_code: 'short_name'
//    };
//
//
//    function initAutocomplete() {
//        console.log('init function')
//        // Create the autocomplete object, restricting the search to geographical
//        // location types.
//        autocomplete = new google.maps.places.Autocomplete(
//                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
//                {types: ['geocode']});
//
//        // When the user selects an address from the dropdown, populate the address
//        // fields in the form.
//        autocomplete.addListener('place_changed', fillInAddress);
//    }
//
//// [START region_fillform]
//    function fillInAddress() {
//        // Get the place details from the autocomplete object.
//        var place = autocomplete.getPlace();
//        
//        console.log(place);
//       //return false;         
//        document.getElementById('latitude').value = place.geometry.location.lat();
//        document.getElementById('longitude').value = place.geometry.location.lng();
//        
//        
//        
//        
//        for (var component in componentForm) {
//            document.getElementById(component).value = '';
//        }
//      /*  var lat = place.geometry.location.lat();
//        var lng = place.geometry.location.lng();
//        document.getElementById("latitude").value = lat;
//        document.getElementById("longitude").value = lng;*/
//        // Get each component of the address from the place details
//        // and fill the corresponding field on the form.
//        for (var i = 0; i < place.address_components.length; i++) {
//            var addressType = place.address_components[i].types[0];
//            if (componentForm[addressType]) {
//                var val = place.address_components[i][componentForm[addressType]];
//                document.getElementById(addressType).value = val;
//            }
//        }
//    }
//// [END region_fillform]
//
//// [START region_geolocation]
//// Bias the autocomplete object to the user's geographical location,
//// as supplied by the browser's 'navigator.geolocation' object.
//    function geolocate() {
//        if (navigator.geolocation) {
//            navigator.geolocation.getCurrentPosition(function (position) {
//                var geolocation = {
//                    lat: position.coords.latitude,
//                    lng: position.coords.longitude
//                };
//                var circle = new google.maps.Circle({
//                    center: geolocation,
//                    radius: position.coords.accuracy
//                });
//                autocomplete.setBounds(circle.getBounds());
//            });
//        }
//    }
// [END region_geolocation]

</script>
<!--<script src="https://maps.googleapis.com/maps/api/js?&signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?&libraries=places&callback=initAutocomplete" async defer></script>-->