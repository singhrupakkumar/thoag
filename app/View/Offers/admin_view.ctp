<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Offer'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                    	<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                    		<thead>
                    			<tr>
                    				<th><?php echo __('Id'); ?></th>
                    				<td><?php echo h($offer['Offer']['id']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Res Id'); ?></th>
                    				<td><?php echo h($offer['Offer']['res_id']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Name'); ?></th>
                    				<td><?php echo h($offer['Offer']['name']); ?></td>
                    			</tr>
                                        <tr>
                    				<th><?php echo __('Name in Arabic'); ?></th>
                    				<td><?php echo h($offer['Offer']['name_ar']); ?></td>
                    			</tr>
                    			<tr style="vertical-align: top;">
                    				<th style="vertical-align: top;"><?php echo __('Description'); ?></th>
                    				<td><?php echo $offer['Offer']['description']; ?></td>
                    			</tr>
                                        <tr style="vertical-align: top;">
                    				<th style="vertical-align: top;"><?php echo __('Description in Arabic'); ?></th>
                    				<td><?php echo $offer['Offer']['description_ar']; ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Image'); ?></th>
                    				<td>
                                                    <?php if(!empty($offer['Offer']['image'])){ ?>
                                                    <a href="<?php echo $this->webroot.'/files/offers/'.$offer['Offer']['image']; ?>" target="_blank"><img src="<?php echo $this->webroot.'/files/offers/'.$offer['Offer']['image']; ?>" style='width: 150px;height: 150px;'/></a>
                                                    <?php } ?>
                                                </td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Created'); ?></th>
                    				<td><?php echo h($offer['Offer']['created']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Modified'); ?></th>
                    				<td><?php echo h($offer['Offer']['modified']); ?></td>
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