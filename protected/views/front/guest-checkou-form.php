<div class="form-group">
  <?php echo CHtml::textField('first_name','',array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","First Name"),
   'data-validation'=>"required"
  ))?> 
</div>
<div class="form-group">
  <?php echo CHtml::textField('last_name','',array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Last Name"),
   'data-validation'=>"required"
  ))?> 
</div>

<div class="input-group">
    <?php echo CHtml::textField('zipcode',
      isset($client_info['zipcode'])?$client_info['zipcode']:''
      ,array(
       'class'=>'postcode form-control',
       'placeholder'=>Yii::t("default","postcode"),
       'data-validation'=>"required"
      ))?>
    <div class="input-group-btn">
      <input name="search_address" class="search_address btn btn-primary" value="search " type="button">
    </div>
</div>
<br />
<span class="has-error" id="wrong_pin" style="display:none;"></span>
<div class="form-group get_address_div" style="display:none;">
                  <?php 
                  echo CHtml::dropDownList('slt_address','','',          
    array(
    'class'=>'form-control slt_address'                   
    ))?>
</div> 

<div class="form-group">
<?php echo CHtml::hiddenField('street',isIsset($client_info['street']),array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Street")
  // ,'data-validation'=>"required"
  ))?> 
</div>  
<div class="form-group">
<?php echo CHtml::textField('city',isIsset($client_info['city']),array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","City"),
   'data-validation'=>"required"
  ))?>  
</div>
<!--<div class="form-group">
<?php echo CHtml::textField('state',isIsset($client_info['state']),array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","State"),
   'data-validation'=>"required"
  ))?>  
</div>
 <div class="form-group">
<?php echo CHtml::textField('zipcode',isIsset($client_info['zipcode']),array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Zip code")
  ))?>  
</div>  -->
<div class="form-group">
<?php echo CHtml::textField('location_name',isIsset($client_info['location_name']),array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Apartment suite, unit number, or company name"),   
  ))?> 
</div>
<div class="form-group">
<?php echo CHtml::textField('contact_phone',isIsset($client_info['contact_phone']),array(
   'class'=>'form-control mobile_inputs',
   'placeholder'=>Yii::t("default","Mobile Number"),
   'data-validation'=>"required"  
  ))?> 
</div>  
<!--
<div class="form-group">
<?php echo CHtml::textField('delivery_instruction','',array(
  'class'=>'form-control full-width',
  'placeholder'=>Yii::t("default","Delivery instructions")   
))?> 
</div>  -->

<?php if (isset($is_guest_checkout)):?>
                  <div class="form-group">
                    <span class="guest_checkout_registeration"> You are just a couple of steps away from registering your membership .  </span>
                    <br /><br />
                    <?php echo CHtml::checkBox('save_as_member',false,array('class'=>"save_as_member",'value'=>2));  ?>
                  <label for="saved_address" class="control-label"> Save as member </label> 
                  </div>
                <?php endif; ?> 


 <?php if (isset($is_guest_checkout)):?>
                                  <div id="save_as_member_div" style="display:none;">
                                  <?php FunctionsV3::sectionHeader('Required')?>
                                   <div class="form-group">
                    <?php echo CHtml::textField('email_address1','',
                      array('class'=>'form-control',
              'placeholder'=>t("Email address"),
                'required'=>true,
                'data-validation'=>"email"
                ))?>
                   </div>                                   
                                    <div class="form-group">
                                       <?php echo CHtml::passwordField('password1','',array(
                                         'class'=>'form-control',
                                         'placeholder'=>Yii::t("default","Password"),     
                                          'data-validation'=>"length",
                        'data-validation-length'=>"min8"          
                                        ))?> 
                                    </div>                                
                                </div> 
<?php endif; ?> 
<!-- <div class="form-group">
<?php echo CHtml::textField('email_address','',array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Email address"),   
  ))?> 
</div>  

<?php FunctionsV3::sectionHeader('Create Account')?>		  
<p class="text-muted text-small">***<?php echo t("Optional")?></p>
<div class="form-group">
   <?php echo CHtml::passwordField('password','',array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Password"),   
  ))?> 
</div>          -->