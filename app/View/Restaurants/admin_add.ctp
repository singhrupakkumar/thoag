<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Add Restaurant</h1>
                </div>
                <div class="page_content">
        <p>
            <?php //debug($restype); exit;  
            $x = $this->Session->flash();
            ?>
<?php if ($x) { ?>
        <div class="alert success">
            <span class="icon"></span>
            <strong></strong>
            <?php echo $x; ?>
        </div>
<?php } ?>
        </p>
        <div class="row">
            <div class="col-md-4">
                <div class="restaurants form">
<?php echo $this->Form->create('Restaurant', array('type' => 'file')); ?>

                    <div class="form-group">
                        <?php //echo $this->Form->input('typeid', ['options' => $restype, 'label' => 'Restaurant Type:']); ?>
<?php //echo $this->Form->input('name',array('class'=>'form-control','label'=>'Restaurant Name:')); 	 ?>
                    </div>

                    <div class="form-group">
<?php if($loggedin['role']=='admin'){
    echo $this->Form->input('user_id', array('class' => 'form-control','label' => 'Store Owner:','type'=>'select','options'=>$restaurant_owners));
}else{
    echo "<b>Store Owner:</b> ".$loggedin['email'];
} ?>
<?php  ?>
                    </div>

                    <div class="form-group">

<?php echo $this->Form->input('name', array('class' => 'form-control','label' => 'Store Name:','type'=>'text')); ?>
                    </div>

                    <div class="form-group">

<?php echo $this->Form->input('name_ar', array('class' => 'form-control', 'value'=>$rname,'label' => 'Store Name in arabic:')); ?>
                    </div>
                    <!--                    <div class="form-group">
<?php // echo $this->Form->input('barcodeno', array('class' => 'form-control', 'label' => 'Barcode NO.')); ?>
                                        </div>-->
                    <div class="form-group">
<?php echo $this->Form->input('phone', array('class' => 'form-control', 'label' => 'Store Phone:','maxlength'=>'12')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('owner_name', array('class' => 'form-control', 'label' => 'Owner Name:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('owner_phone', array('class' => 'form-control', 'label' => 'Owner Phone:','maxlength'=>'12')); ?>
                    </div>
                    <div class="form-group">

<div style="position:relative; width:100%;">
    <?php echo $this->Form->input('address', array('class' => 'form-control', 'label' => 'Address:','id'=>'address','type'=>'text')); ?>
    <div style="position: absolute; z-index: 9999; width:100%">
        <a class="btn btn-primary" id='getlatlong' style="position: absolute;right:30px; top:-8px;" >Get Lat&Long</a></div>
    <div id="map" style="position: absolute; right:-600px;top:0; width:500px;height:300px"></div>
</div>

                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('address_ar', array('class' => 'form-control', 'label' => 'Address in Arabic:')); ?>
                    </div>
                     <div class="form-group">
<?php echo $this->Form->input('latitude', array('class' => 'form-control', 'label' => 'Latitude:')); ?>
                    </div>
                     <div class="form-group">
<?php echo $this->Form->input('longitude', array('class' => 'form-control', 'label' => 'Longitude:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('city', array('class' => 'form-control', 'label' => 'City:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('state', array('class' => 'form-control', 'label' => 'State:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('zip', array('class' => 'form-control', 'label' => 'Zip:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => 'Description:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('description_ar', array('class' => 'form-control', 'label' => 'Description in Arabic:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('logo', array('type' => 'file', 'class' => 'form-control', 'label' => 'Logo:')); ?>
                    </div>
                     </div>
                    <div class="form-group">
<?php echo $this->Form->input('banner', array('type' => 'file', 'class' => 'form-control', 'label' => 'Banner:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('website', array('class' => 'form-control', 'label' => 'Website:')); ?>
                    </div>
                    <div class="form-group">
<?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => 'Email:')); ?>
                    </div>
                    <!--                       <div class="form-group">
<?php //echo $this->Form->input('delivery_distance', array('class' => 'form-control', 'label' => 'Delivery Distance in miles:')); ?>
                                        </div>-->
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
				
				 <!--div class="form-group">
                    <?php echo $this->Form->input('min_amount_for_down_payment', array('class' => 'form-control', 'label' => 'Minimum Amount For Down Payment:')); ?>
                </div>
				
				 <div class="form-group">
                    <?php echo $this->Form->input('down_payment_percentage', array('class' => 'form-control', 'label' => 'Down Payment Percentage:')); ?>
                </div>
				
				 <div class="form-group">
				<?php echo $this->Form->input('down_payment', array('type' => 'checkbox')); ?>


				</div-->
				
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
                    <label>Map marker:</label>
                    <input type="file" name="data[Restaurant][marker]" class="form-control" id="RestaurantLogo">
                </div>

                    <!--                    <div class="form-group"><?php //$options = array('hh','gg','sss'); ?>
<?php //echo $this->Form->radio('Amities',$options ,array('class'=>'form-control','label'=>'Amities:'));	 ?>
                                        </div>-->





                    <?php //$options = array(1 => 'ONE', 'TWO', 'THREE');
                    //$selected = array(1, 3); , 'selected' => $selected
                    ?>
<?php //echo $this->Form->input('amities_selected', array('label'=>'Amenities','class'=>'form-control','multiple' => 'checkbox', 'options' => $Restaurantx));	 ?>
<?php //echo $this->Form->checkbox('done', array('value' => 555,'label'=>'fggf'));  ?>

                <input type="hidden" name="data[Restaurant][created]" value="
                <?php echo date('Y-m-d H:i:s'); ?>">
                <input type="hidden" name="data[Restaurant][status]" value="1">
                <div class="btn-toolbar list-toolbar">
                       <?php echo $this->Form->submit('Save', array('formnovalidate' => true, 'class' => "submitres btn btn-primary", 'div' => array('class' => 'btn-div'))); ?>

                    <a href="<?php echo $this->Html->url(array('controller' => 'Restaurants', 'action' => 'admin_index')); ?>" data-toggle="modal" style="float:left;" class="btn btn-primary">Cancel</a>
                </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</section>
<style type="text/css">
    .input.select select.form-control{
        width: 100%;
    }
</style>

<script>
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
            $('#RestaurantLatitude').val(evt.latLng.lat())
            $('#RestaurantLongitude').val(evt.latLng.lng())
            //document.getElementById('current').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
        });
    }

</script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>-->
<script src="https://maps.googleapis.com/maps/api/js" async defer></script>