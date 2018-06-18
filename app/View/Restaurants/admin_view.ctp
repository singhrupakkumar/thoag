<?php echo $this->Html->css(array('bootstrap-editable.css', '/select2/select2.css'), 'stylesheet', array('inline' => false)); ?>
<?php echo $this->Html->script(array('bootstrap-editable.js', '/select2/select2.js'), array('inline' => false)); ?>
<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>View Restaurant</h1>
                </div>
            </div>
            <div class="col-sm-5">
                <p>
                    <?php
                        // debug($restaurant);exit;
                        $x = $this->Session->flash();
                    ?>
                    <?php if ($x) { ?>
                    <div class="alert success">
                        <span class="icon"></span>
                        <strong></strong><?php echo $x; ?>
                    </div>
                    <?php } ?>
                </p>
                <div class="inner-table">
                    <?php echo $this->Form->create('Restaurant'); ?>
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo h($restaurant['Restaurant']['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Name Arabic</th>
                                    <td><?php echo h($restaurant['Restaurant']['name_ar']); ?></td>
                                </tr>
<!--                                <tr>
                                    <th>Store Type</th>
                                    <td><?php //echo h($restaurant['RestaurantsType']['name']); ?></td>
                                </tr>-->
                              
                                <tr>
                                    <th>Phone</th>
                                    <td><?php echo h($restaurant['Restaurant']['phone']); ?></td>
                                </tr>
                                <tr>
                                    <th>Owner Name</th>
                                    <td><?php echo h($restaurant['Restaurant']['owner_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Owner Phone</th>
                                    <td><?php echo h($restaurant['Restaurant']['owner_phone']); ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo h($restaurant['Restaurant']['address']); ?></td>
                                </tr>
                                <tr>
                                    <th>Address Arabic</th>
                                    <td><?php echo h($restaurant['Restaurant']['address_ar']); ?></td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><?php echo h($restaurant['Restaurant']['city']); ?></td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><?php echo h($restaurant['Restaurant']['state']); ?></td>
                                </tr>
                                <tr>
                                    <th>Zip</th>
                                    <td><?php echo h($restaurant['Restaurant']['zip']); ?></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td><?php echo h($restaurant['Restaurant']['description']); ?></td>
                                </tr>
                                <tr>
                                    <th>Description Arabic</th>
                                    <td><?php echo h($restaurant['Restaurant']['description_ar']); ?></td>
                                </tr>
                                <tr>
                                    <th>Logo</th>
                                    <td><?php //echo $this->Html->image("../files/restaurants/".$restaurant['Restaurant']['logo']);
                                        echo $this->Html->link(
    $this->Html->image("../files/restaurants/".$restaurant['Restaurant']['logo'],array("style"=>"width:200px; height:200px;")), "../../files/restaurants/".$restaurant['Restaurant']['logo'], array('escape' => false,'target'=>'_blank'));
                                        
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Banner</th>
                                    <td><?php 
                                        echo $this->Html->link(
    $this->Html->image("../files/restaurants/".$restaurant['Restaurant']['banner'],array("style"=>"width:200px; height:200px;")), "../../files/restaurants/".$restaurant['Restaurant']['banner'], array('escape' => false,'target'=>'_blank'));
                                        ?></td>
                                </tr>
<!--                                <tr>
                                    <th>Website</th>
                                    <td><?php echo h($restaurant['Restaurant']['website']); ?></td>
                                </tr>-->
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo h($restaurant['Restaurant']['email']); ?></td>
                                </tr>
                                
<!--                                <tr>
                                    <th>Delivery Distance in miles:</th>
                                    <td><?php // echo h($restaurant['Restaurant']['delivery_distance']); ?></td>
                                </tr>-->
                                
                                <tr>
                                    <th>Delivery</th>
                                    <td><?php echo h($restaurant['Restaurant']['delivery'] == 1) ? "Yes" : "No"; ?></td>
                                </tr>
                                <tr>
                                    <th>Takeaway</th>
                                    <td><?php echo h($restaurant['Restaurant']['takeaway'] == 1) ? " Yes" : "No"; ?></td>
                                </tr>
                                <tr>
                                    <th>Catering</th>
                                    <td><?php echo h($restaurant['Restaurant']['catering'] == 1) ? " Yes" : "No"; ?></td>
                                </tr>
<!--                                <tr>
                                    <th>Tax</th>
                                    <td><?php //echo h($restaurant['Restaurant']['taxes']); ?></td>
                                </tr>-->
                                <tr>
                                    <th>Latitude</th>
                                    <td><?php echo h($restaurant['Restaurant']['latitude']); ?></td>
                                </tr>
                                <tr>
                                    <th>Longitude</th>
                                    <td><?php echo h($restaurant['Restaurant']['longitude']); ?></td>
                                </tr>
                                
                                <!--Restaurant Owner Information-->
                                
                                <tr>
                                    <th>Owner Name</th>
                                    <td><?php echo h($restaurant['Restaurant']['owner_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Owner Phone</th>
                                    <td><?php echo h($restaurant['Restaurant']['owner_phone']); ?></td>
                                </tr>
                                
                                <!--Restaurant Offers Image-->
                                <tr>
                                    <th>Offer Image</th>
                                    <td><?php //echo h($restaurant['Restaurant']['offer_image']);
                                        echo $this->Html->image("../files/offers/".$restaurant['Restaurant']['offer_image'],array("style"=>"width:100px; height:100px;"));
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Offer Title</th>
                                    <td><?php echo h($restaurant['Restaurant']['offer_title']); ?></td>
                                </tr>
                                
                                <!-- Restaurants Extra fields for labeling -->
                                <tr>
                                    <th>Rapid Booking</th>
                                    <td><?php
                                        if($restaurant['Restaurant']['rapid_booking']==1){echo "Yes";}else{ echo "No"; }
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Thoag Verified</th>
                                    <td><?php
                                        if($restaurant['Restaurant']['verified']==1){echo "Yes";}else{ echo "No"; }
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Lead Time</th>
                                    <td><?php echo h($restaurant['Restaurant']['lead_time'])."hrs"; ?></td>
                                </tr>
                                <tr>
                                    <th>Minimum Order</th>
                                    <td><?php echo h($restaurant['Restaurant']['min_order']); ?></td>
                                </tr>
                                <tr>
                                    <th>Is Featured</th>
                                    <td><?php if($restaurant['Restaurant']['is_featured']==1){echo "Yes";}else{ echo "No"; } ?></td>
                                </tr>
                                
                                <!-- Review Information -->
                                <tr>
                                    <th>Review Average</th>
                                    <td><?php echo h($restaurant['Restaurant']['review_avg']); ?></td>
                                </tr>
                                <tr>
                                    <th>Review Count</th>
                                    <td><?php echo h($restaurant['Restaurant']['review_count']); ?></td>
                                </tr>
                                
                                <!-- Restaurant Timing  Information -->
                                <tr>
                                    <th>Weekdays Opening Time </th>
                                    <td><?php echo h($restaurant['Restaurant']['opening_time']); ?></td>
                                </tr>
                                <tr>
                                    <th>Weekdays Closing Time</th>
                                    <td><?php echo h($restaurant['Restaurant']['closing_time']); ?></td>
                                </tr>
                                <tr>
                                    <th>Weekend Opening Time </th>
                                    <td><?php echo h($restaurant['Restaurant']['weekend_opening_time']); ?></td>
                                </tr>
                                <tr>
                                    <th>Weekend Closing Time</th>
                                    <td><?php echo h($restaurant['Restaurant']['weekend_closing_time']); ?></td>
                                </tr>
                                
                                <!-- Restaurant Map marker -->
                                <tr>
                                    <th>Map Marker</th>
                                    <td><?php //echo h($restaurant['Restaurant']['marker']);
                                       echo $this->Html->image("../files/restaurants/".$restaurant['Restaurant']['marker'],array("style"=>"width:20px; height:20px;"));
                                        ?></td>
                                </tr>
                                
                            </thead>
                        </table>
                    </div>
                </div><!-- End Here -->
            </div>
        </div>
    </div>
</section>