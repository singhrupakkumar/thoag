<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>View Review</h1>
                </div>
            </div>
                <div class="page_content">
                    <div class="col-sm-5">
                                            <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <td><?php echo h($review['RestaurantsReview']['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Store Name</th>
                                    <td><?php echo h($review['Restaurant']['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>User Name</th>
                                    <td><?php echo h($review['User']['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Message</th>
                                    <td><?php echo h($review['RestaurantsReview']['text']); ?></td>
                                </tr>
                                <tr>
                                    <th>Rating</th>
                                    <td><?php echo h($review['RestaurantsReview']['rating']); ?></td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td><?php echo h($review['RestaurantsReview']['created']); ?></td>
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