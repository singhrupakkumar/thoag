<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>View Associate Product</h1>
                </div>
            </div>
                <div class="page_content">
                    <div class="col-sm-5">
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <th>Id</th>
                                    <td><?php echo h($product['Product']['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo h($product['Product']['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td><?php echo h($product['Product']['description']); ?></td>
                                </tr>
                                <tr>
                                    <th>Image</th>
                                    <td><?php echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image')); ?></td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td><?php echo h($product['Product']['price']); ?></td>
                                </tr>
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
                            </tbody>
                        </table>
                    </div><!-- End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>