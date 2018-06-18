<style type="text/css">
    table{
        margin-bottom: 15px;
    }
</style>
<?php
//exit;
echo $this->Html->css(array('bootstrap-editable.css', '/select2/select2.css'), 'stylesheet', array('inline' => false)); ?>
<?php echo $this->Html->script(array('bootstrap-editable.js', '/select2/select2.js'), array('inline' => false)); ?>

<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Products</h1>
                </div>
                <div class="page_content">
                    <div class="btn-toolbar list-toolbar">
                        <?php echo $this->Form->create('Product', array()); ?>
                        <?php echo $this->Form->hidden('search', array('value' => 1)); ?>
                        <div class="col-lg-2">
        <?php  echo $this->Form->input('dish_catid', ['options' => $DishCategory, 'label' =>false,'class' => 'form-control','empty'=>'Choose category','selected'=>$all['dish_catid']]);  ?>

    </div>
                        <div class="col-lg-2">
        <?php echo $this->Form->input('filter', array(
            'label' => false,
            'class' => 'form-control',
            'options' => array(
                'name' => 'Name',
               // 'description' => 'Description',
                'price' => 'Price',
              //  'created' => 'Created',
            ),
            'selected' => $all['filter']
        )); ?>

    </div>
                        <div class="col-lg-2">
        <?php echo $this->Form->input('name', array('label' => false, 'id' => false, 'class' => 'form-control', 'value' => $all['name'])); ?>

    </div>
                        <div class="col-lg-4">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('View All', array('controller' => 'products', 'action' => 'resreset',$resid, 'admin' => true), array('class' => 'btn btn-danger')); ?>

    </div>

    <?php echo $this->Form->end(); ?>
                    </div><!-- Button Group End Here -->


                     <div class="button_outer">
                   

 <?php echo $this->Html->link('Add New Product for Sale', array('controller' => 'restaurants','action' => 'addproduct', $resid), array('class' => 'btn btn-xs btn-default')); ?>
      
     <?php echo $this->Html->link('View all Associate Products', array('controller' => 'products','action' => 'assoresindex', $resid), array('class' => 'btn btn-xs btn-default')); ?>
      <?php echo $this->Html->link('Add New Associate Product for Sale', array('controller' => 'restaurants','action' => 'assoaddproduct', $resid), array('class' => 'btn btn-xs btn-default')); ?>
                         
 <?php //echo $this->Html->link('Add New Dish Category', array('controller' => 'dish_categories', 'action' => 'add'), array('class' => 'btn btn-xs btn-default')); ?>
                    <?php //echo $this->Html->link('Add new subcategory', array('controller' => 'dish_subcats', 'action' => 'add'), array('class' => 'btn btn-xs btn-default')); ?>

                </div>


                    <div class="restaurants index">
                        <table class="table-striped table-bordered table-condensed table-hover">
    <tr>
        <th><?php echo $this->Paginator->sort('image'); ?></th>
        <th><?php echo $this->Paginator->sort('dishcategory_id'); ?></th>
        <!--<th><?php //echo $this->Paginator->sort('dishsubcat_id'); ?></th>-->
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th style="width: 10%;"><?php echo $this->Paginator->sort('name_ar'); ?></th>
        <!--<th><?php echo $this->Paginator->sort('description'); ?></th>-->
        <!--<th style="width: 15%;"><?php echo $this->Paginator->sort('description_ar'); ?></th>-->
        <th style="width: 10%;"><?php echo $this->Paginator->sort('price'); ?></th>
        <th style="width: 10%;"><?php echo $this->Paginator->sort('Associated Products'); ?></th>
<!--        <th><?php //echo $this->Paginator->sort('weight'); ?></th>
        <th><?php //echo $this->Paginator->sort('size'); ?></th>-->
        <th style="width: 10%;"><?php echo $this->Paginator->sort('created'); ?></th>
        <th style="width: 10%;"><?php echo $this->Paginator->sort('modified'); ?></th>
        <th class="actions">Actions</th>
    </tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?php echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image')); ?></td>
        <td><span class="category" data-value="<?php echo $product['DishCategory']['id']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['DishCategory']['name']; ?></span></td>
        <!--<td><span class="brand" data-value="<?php //echo $product['DishSubcat']['id']; ?>" data-pk="<?php //echo $product['Product']['id']; ?>"><?php // echo $product['DishSubcat']['name']; ?></span></td>-->
        <td><span class="name" data-value="<?php echo $product['Product']['name']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['name']; ?></span></td>
        <td><span class="name" data-value="<?php echo $product['Product']['name_ar']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['name_ar']; ?></span></td>
        <!--<td><span class="description" data-value="<?php echo $product['Product']['description']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['description']; ?></span></td>-->
        <!--<td><span class="description" data-value="<?php echo $product['Product']['description_ar']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['description_ar']; ?></span></td>-->
        <td><span class="price" data-value="<?php echo $product['Product']['price']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['price']; ?></span></td>
        <td><?php $unserialized= unserialize($product['Product']['pro_id']); 
            if(!empty($unserialized)){ ?>
                <i class="fa fa-check" aria-hidden="true"></i>
            <?php }else{ ?>
                <i class="fa fa-times" aria-hidden="true"></i>
            <?php }
            ?>
        </td>
        <!--        <td><span class="weight" data-value="<?php echo $product['Product']['weight']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['weight']; ?></span></td>
                <td><span class="sizes" data-value="<?php echo $product['Product']['sizes']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['sizes']; ?></span></td>-->
<!--        <td><?php //echo $this->Html->link($this->Html->image('icon_' . $product['Product']['active'] . '.png'), array('controller' => 'products', 'action' => 'switch', 'active', $product['Product']['id']), array('class' => 'status', 'escape' => false)); ?></td>-->
        <td><?php echo h($product['Product']['created']); ?></td>
        <td><?php echo h($product['Product']['modified']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('', array('action' => 'resview', $product['Product']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye', 'title' => 'View')); ?>

            <?php echo $this->Html->link('', array('action' => 'resedit', $product['Product']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil', 'title' => 'Edit')); ?>
            <?php echo $this->Form->postLink((''), array('action' => 'resdelete', $product['Product']['id']), array('class' => 'delete1 btn btn-default btn-xs fa fa-trash-o','href'=>''), __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?>
            <?php //echo $this->Html->link('', array('action' => 'resdelete', $product['Product']['id']), array('class' => 'btn btn-default btn-xs fa fa-trash'), __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
                    </div><!-- End Here -->


        <div class="bottom_button">
<?php echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>
        </div>
                </div>
            </div>
        </div>
    </div>
</section>