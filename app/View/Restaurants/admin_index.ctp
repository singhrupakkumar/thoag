<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Restaurants</h1>
                </div>
                <div class="page_content">
                    <?php 
                        $x = $this->Session->flash(); ?>
                    <?php if ($x) { ?>
                    <div class="alert success">
                        <span class="icon"></span>
                        <strong></strong><?php echo $x; ?>
                    </div>
                    <?php }  if($loggedUserRole!='rest_admin'){ ?>
                    <div class="btn-toolbar list-toolbar">
                        <?php echo $this->Form->create('Restaurant', array()); ?>
                        <div class="col-lg-2">
                            <?php
                                echo $this->Form->input('filter', array(
                                    'label' => false,
                                    'class' => 'form-control',
                                    'options' => array(
                                    'name' => 'Name',
                                    'owner_phone' => 'Phone',
                                    //'owner_name' => 'Owner Name',
                                    // 'phone' => 'Owner phone',
                                    ),
                                    'selected' => $all['filter']
                                ));
                            ?>
                        </div>
                        <div class="col-lg-2">
                            <?php echo $this->Form->input('name', array('label' => false, 'id' => false, 'type' => 'text', 'class' => 'form-control', 'value' => $all['name'])); ?>
                        </div>
                        <div class="col-lg-4">
                            <?php
                                echo $this->Form->button('Search', array('class' => 'btn btn-default'));
                                echo $this->Form->end();
                            ?>
                            <?php 
                                echo $this->Html->link('View All', array('controller' => 'restaurants', 'action' => 'reset', 'admin' => true), array('class' => 'btn btn-danger')); 
                            ?>
                        </div>
                        <div class="btn-group">     
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- Button Group End Here -->
                    <?php }// echo $this->Form->create('Restaurant', array("action" => "deleteall", 'id' => 'mbc')); ?>
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                   <!-- <th class="admin_check_b" width="1%"><input type="checkbox" id="selectall" onClick="selectallCHBox();" /></th-->
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('logo'); ?></th>
                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th style="width: 15%;"><?php echo $this->Paginator->sort('name_ar'); ?></th>
                                    <th style="width: 15%;"><?php echo $this->Paginator->sort('owner_phone'); ?></th>
                                    <th>Address</th>
                                    <th style="width: 10%;"><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($restaurants as $restaurant): ?>
                                <tr>
                                    <!--td><?php echo $this->Form->checkbox("res" + $restaurant['Restaurant']['id'], array('value' => $restaurant['Restaurant']['id'], 'class' => 'chechid')); ?></td-->
                                    <td><?php echo h($restaurant['Restaurant']['id']); ?></td>
                                    <td>
                                    <?php 
                                        $restaurantPath = '/files/restaurants/';
                                        echo $this->Html->image($restaurantPath . $restaurant['Restaurant']['logo'], array('alt' => 'Logo', 'width' => 60));
                                    ?></td>
                                    <?php  //print_r($restaurant); ?>
                                    <td><?php echo h($restaurant['Restaurant']['name']); ?></td>
                                    <td><?php echo h($restaurant['Restaurant']['name_ar']); ?></td>
                                    <td><?php echo h($restaurant['Restaurant']['owner_phone']); ?></td>
                                    <td><?php echo h($restaurant['Restaurant']['address']); ?></td>
                                    <td><?php echo h($restaurant['Restaurant']['created']); ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__(''), array('action' => 'view', $restaurant['Restaurant']['id']), array('class' => 'view1 btn btn-default btn-xs fa fa-eye', 'title' => 'View')); ?>

                                        <?php echo $this->Html->link(__(''), array('action' => 'edit/' . $restaurant['Restaurant']['id'] . '/' . $restaurant['Restaurant']['user_id']), array('class' => 'edit1 btn btn-default btn-xs fa fa-pencil', 'title' => 'Edit')); ?>

                                        <?php if($loggedUserRole!='rest_admin'){ 
                                          echo $this->Form->postLink((''), array('action' => 'delete', $restaurant['Restaurant']['id']), array('class' => 'delete1 btn btn-default btn-xs fa fa-trash-o', 'title' => 'Delete','href'=>''), __('Are you sure you want to delete # %s?', $restaurant['Restaurant']['id']));
                                        ?>

                                        <?php 
                                            if ($restaurant['Restaurant']['status'] == 0) {
                                            echo $this->Form->postLink((''), array('controller' => 'Restaurants', 'action' => 'admin_activate', $restaurant['Restaurant']['id']), array('escape' => false, 'class' => 'active1 btn btn-default btn-xs fa fa-check', 'title' => 'Active'));
                                            } 
                                            else {
                                            echo $this->Form->postLink((''), array('controller' => 'Restaurants', 'action' => 'admin_deactivate', $restaurant['Restaurant']['id']), array('escape' => false, 'class' => 'deactive1 btn btn-default btn-xs fa fa-ban', 'title' => 'Block', __('Are you sure you want to deactivate # %s?', $restaurant['Restaurant']['id'])));
                                            }
                                        ?>
                                        <?php } ?>
                                        <?php //echo $this->Html->link(__(''), array('action' => 'uploadresimage/' . $restaurant['Restaurant']['id']), array('class' => 'edit1 btn btn-default btn-xs fa fa-picture-o', 'title' => 'Gallery')); ?>

                                        <?php echo $this->Html->link('', array('controller' => 'products', 'action' => 'resindex', $restaurant['Restaurant']['id']), array('class' => 'btn btn-default btn-xs fa fa-bars', 'title' => 'Menu')); ?>

                                        <?php echo $this->Html->link('', array('controller' => 'restaurants', 'action' => 'unavailabledates', $restaurant['Restaurant']['id']), array('class' => 'btn btn-default btn-xs fa fa-calendar', 'title' => 'Unavailable Dates')); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- End Here -->
                    <?php //echo $this->Form->end(); 
                        if($loggedUserRole!='rest_admin'){ 
                    ?>


        <div class="bottom_button">
            <!--<button class="btn btn-sm btn-success delete_all" name="delete" value="Activate" onclick=" <?php if (@$url[2] == 'restaurant') { ?>$('#mbc').attr({'action': './activateall'});<?php } else { ?>$('#mbc').attr({'action': 'restaurants/activateall'});<?php } ?>$('#mbc').submit();"><?php echo __("Activate All") ?></button>

            <button class="btn btn-sm btn-default delete_all" name="delete" value="Deactivate" onclick=" <?php if (@$url[2] == 'restaurant') { ?>$('#mbc').attr({'action': './inactivateall'});<?php } else { ?>$('#mbc').attr({'action': 'restaurants/inactivateall'});<?php } ?>$('#mbc').submit();"><?php echo __("Deactivate All") ?></button>

            <button onclick="$('#mbc').submit();" value="Delete" class="btn btn-sm btn-danger delete_all"><?php echo __("DeleteAll"); ?></button-->

            <ul class="paginator_Admin">
                <div class="first_button1"><?php echo $this->Paginator->prev('Previous ', null, null, array('class' => 'disabled')); ?></div>
                <?php echo $this->Paginator->numbers(); ?>
                <div class="first_button1"><?php echo $this->Paginator->next(' Next ', null, null, array('class' => 'disabled')); ?></div>
            </ul>
        </div>
         <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>