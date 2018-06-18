<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Product</h1>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="page_content">
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
        <th>Id</th>
        <td><?php echo h($product['Product']['id']); ?></td>
    </tr>

    <tr>
        <th>Name</th>
        <td><?php echo h($product['Product']['name']); ?></td>
    </tr>
    <tr>
        <th>Name in arabic</th>
        <td><?php echo h($product['Product']['name_ar']); ?></td>
    </tr>

    <tr>
        <th>Description</th>
        <td><?php echo h($product['Product']['description']); ?></td>
    </tr>
    <tr>
        <th>Description in arabic</th>
        <td><?php echo h($product['Product']['description_ar']); ?></td>
        
    </tr>
    <tr>
        <th>Image</th>
        <td>
            <?php echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image')); ?>
            </td>
    </tr>
    <tr>
        <th>Price</th>
        <td><?php echo h($product['Product']['price']); ?></td>
    </tr>
     <?php if($loggeduser!=427){  ?>
     <?php } ?>
    <tr>
        <th>Dish Category</th>
        <td><?php echo h($product['DishCategory']['name']); ?></td>
    </tr>
    <tr>
        <th>Created</th>
        <td><?php echo h($product['Product']['created']); ?></td>
    </tr>
    <tr>
        <th>Modified</th>
        <td><?php echo h($product['Product']['modified']); ?></td>
    </tr>
	    <tr>
        <th>Catering</th>
        <td><input type="checkbox" <?php if($product['Product']['catering']==1) { echo "checked";} ?>></td>
    </tr>
	    <tr>
        <th>Delivery</th>
        <td><input type="checkbox" <?php if($product['Product']['delivery']==1) { echo "checked";} ?>></td>
    </tr>
	    <tr>
        <th>Pickup</th>
        <td><input type="checkbox" <?php if($product['Product']['pickup']==1) { echo "checked";} ?>></td>
    </tr>
	    <tr>
        <th>Quantity</th>
        <td><?php echo h($product['Product']['quantity']); ?></td>
    </tr>
	    <tr>
        <th>Min Order Quantity</th>
        <td><?php echo h($product['Product']['min_order_quantity']); ?></td>
    </tr>
	    <tr>
        <th>Max Order Quantity</th>
        <td><?php echo h($product['Product']['max_order_quantity']); ?></td>
    </tr>
	

                            </thead>
                        </table>
                    </div><!-- End Here -->
                </div>
                <!--Associated Items -->
                <?php if (!empty($assoproduct)): 
                    //print_r($assoproduct);
                    ?>
                            <div class="page_content">
                <div class="col-sm-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Related Associated Items</h1>
                </div>
                    <div class="restaurants index">
                    
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
        <th>Id</th>
        <th>Category</th>
        <th>Name</th>
        <th>Name(AR)</th>
        <th>Price(SAR)</th>
        <th>Created</th>
        <th>Modified</th>
        <th>Actions</th>
    </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assoproduct as $product_item): ?>
    <tr>
        <td><?php echo $product_item['PT']['id']; ?></td>
        <td><?php echo $product_item['dish_categories']['name']; ?></td>
        <td><?php echo $product_item['PT']['name']; ?></td>
        <td><?php echo $product_item['PT']['name_ar']; ?></td>
        <td><?php echo $product_item['PT']['price']; ?></td>
        <td><?php echo $product_item['PT']['created']; ?></td>
        <td><?php echo $product_item['PT']['modified']; ?></td>
        <td>
            <?php echo $this->Html->link('', array('controller' => 'products', 'action' => 'assoresview', $product_item['PT']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>

            <?php //echo $this->Html->link('', array('controller' => 'order_items', 'action' => 'edit', $orderItem['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil','title'=>'Edit')); ?>
            <?php //echo $this->Form->postLink('', array('controller' => 'order_items', 'action' => 'delete', $orderItem['id']), array('class' => 'btn btn-default btn-xs fa fa-trash','title'=>'Delete'), __('Are you sure you want to delete # %s?', $orderItem['id'])); ?>

        </td>
    </tr>
    <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                    </div><!-- End Here -->
                </div>
            </div>
                    <?php endif; ?>
                <!-- end here -->
                
            </div>
        </div>
    </div>
</section>