<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>View Discount</h1>
                </div>
            </div>
                <div class="page_content">
                    <div class="col-sm-5">
                                            <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <td><?php echo h($discount['Discount']['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Store Name</th>
                                    <td><?php echo h($discount['Restaurant']['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Order From (Min)</th>
                                    <td><?php echo h($discount['Discount']['min_order']); ?></td>
                                </tr>
                                <tr>
                                    <th>Order To (max)</th>
                                    <td><?php echo h($discount['Discount']['max_order']); ?></td>
                                </tr>
                                <tr>
                                    <th>Discount(%)</th>
                                    <td><?php echo h($discount['Discount']['discount']); ?></td>
                                </tr>
                                <tr>
                                    <th>Order Amount(Min)</th>
                                    <td><?php echo h($discount['Discount']['min_order_amount']); ?></td>
                                </tr>
                                
                                <tr>
                                    <th>Discount Amount(Max)</th>
                                    <td><?php echo h($discount['Discount']['max_discount_amount']); ?></td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td><?php echo h($discount['Discount']['created']); ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>