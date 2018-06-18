<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Unavailable Area'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                		<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                			<thead>
                				<tr>
                					<th><?php echo __('Id'); ?></th>
                					<td><?php echo h($UnavailableArea['UnavailableArea']['id']); ?></td>
                				</tr>
                				<tr>
                					<th><?php echo __('City'); ?></th>
                					<td><?php echo h($UnavailableArea['UnavailableArea']['city']); ?></td>
                				</tr>
                				<tr>
                					<th><?php echo __('Area'); ?></th>
                					<td><?php echo h($UnavailableArea['UnavailableArea']['area']); ?></td>
                				</tr>
                				<tr>
                					<th><?php echo __('Created'); ?></th>
                					<td><?php echo h($UnavailableArea['UnavailableArea']['created']); ?></td>
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