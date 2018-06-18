<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Edit Store Settings</h1>
                </div>



<div class="row">
    <div class="col-sm-5">
        <div class="add_dish">
            <?php 
			echo $this->Form->create('Setting', array('type' => 'file')); ?>
            <?php foreach($settings as $setting){
                
				 if($setting['Setting']['type']=='file'){
					   echo $this->Form->input($setting['Setting']['key'],array('type'=>'file','label'=>ucwords(str_replace('_', ' ', $setting['Setting']['key'])),'value'=>$setting['Setting']['value'])); 
				}else{
					  echo $this->Form->input($setting['Setting']['key'],array('label'=>ucwords(str_replace('_', ' ', $setting['Setting']['key'])),'value'=>$setting['Setting']['value'])); 
				 }
            } ?>
          
            <br />
           
            <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
            <?php echo $this->Form->end(); ?>  
			<ul>
			<li><label>Blog Banner</label>
			 <img src="<?php echo $this->webroot."files/staticpage/".$settings[5]['Setting']['value']; ?>" width="100" height="100"> </li>
			 <li><label>Faq Banner</label>
			 <img src="<?php echo $this->webroot."files/staticpage/". $settings[7]['Setting']['value']; ?>" width="100" height="100"> </li>
			<ul> 
        </div>
    </div>
</div>

         </div>
        </div>
    </div>
</section>




