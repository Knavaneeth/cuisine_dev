<?php
$merchant_id=Yii::app()->functions->getMerchantID();
$enabled_chip_pin=Yii::app()->functions->getOption('merchant_enabled_chip_pin',$merchant_id);
$chip_pin_mode=Yii::app()->functions->getOption('merchant_chip_pin_mode',$merchant_id); 
?>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','saveMerchantchip_pinSettings')?>

<!--<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Chippin?")?></label>
  <?php 
  echo CHtml::checkBox('merchant_enabled_chip_pin',
  $enabled_chip_pin=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>-->
  
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Chip Pin")?>?</label>
  <?php 
  echo CHtml::checkBox('merchant_enabled_chip_pin',
  Yii::app()->functions->getOption('merchant_enabled_chip_pin',$merchant_id)=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>

<?php echo  "Chip Pin Mode   ".$chip_pin_mode;  ?>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Mode")?></label>
  <div class="col-lg-6">
  <?php 
  echo CHtml::radioButton('merchant_chip_pin_mode',
  $chip_pin_mode=="sandbox"?true:false
  ,array(
    'value'=>"sandbox"    
  ))
  ?>
  <?php echo t("Sandbox")?> 
  <?php 
  echo CHtml::radioButton('merchant_chip_pin_mode',
  $chip_pin_mode=="live"?true:false
  ,array(
    'value'=>"live"  
  ))
  ?>	
  <?php echo t("Live")?> 
  </div>
</div>


 




<!-- Default Sandbox  -->


<div class="uk-form-row">
<label class="uk-form-label"><?php echo Yii::t("default","Card Fee")?></label>
<?php 
echo CHtml::textField('merchant_chip_pin_fee',
Yii::app()->functions->getOptionAdmin('merchant_chip_pin_fee')
,array(
'class'=>"uk-form-width-small numeric_only"
))
?>
</div>


<h3><?php echo Yii::t("default","Sandbox")?></h3>
<!-- <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Username")?></label>
  <?php 
  echo CHtml::textField('merchant_sanbox_chip_pin_user',
  Yii::app()->functions->getOptionAdmin('merchant_sanbox_chip_pin_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div> -->

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Shared Secret")?></label>
  <?php 
  echo CHtml::textField('merchant_sanbox_chip_pin_pass',
  Yii::app()->functions->getOptionAdmin('merchant_sanbox_chip_pin_pass')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin User Id")?></label>
  <?php 
  echo CHtml::textField('merchant_sanbox_chip_pin_user_id',
  Yii::app()->functions->getOptionAdmin('merchant_sanbox_chip_pin_user_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Password")?></label>
  <?php 
  echo CHtml::textField('merchant_sanbox_chip_pin_password',
  Yii::app()->functions->getOptionAdmin('merchant_sanbox_chip_pin_password')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Client Id")?></label>
  <?php 
  echo CHtml::textField('merchant_sanbox_chip_pin_client_id',
  Yii::app()->functions->getOptionAdmin('merchant_sanbox_chip_pin_client_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

 <!-- Default Live   -->

<h3><?php echo Yii::t("default","Live")?></h3>
<!-- <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Username")?></label>
  <?php 
  echo CHtml::textField('merchant_live_chip_pin_user',
  Yii::app()->functions->getOptionAdmin('merchant_live_chip_pin_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div> -->

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Shared Secret")?></label>
  <?php 
  echo CHtml::textField('merchant_live_chip_pin_pass',
  Yii::app()->functions->getOptionAdmin('merchant_live_chip_pin_pass')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin User Id")?></label>
  <?php 
  echo CHtml::textField('merchant_live_chip_pin_user_id',
  Yii::app()->functions->getOptionAdmin('merchant_live_chip_pin_user_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Password")?></label>
  <?php 
  echo CHtml::textField('merchant_live_chip_pin_password',
  Yii::app()->functions->getOptionAdmin('merchant_live_chip_pin_password')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Client Id")?></label>
  <?php 
  echo CHtml::textField('merchant_live_chip_pin_client_id',
  Yii::app()->functions->getOptionAdmin('merchant_live_chip_pin_client_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

 <!-- Mobile -->
<hr>
<h3><?php echo t("Mobile Chip Pin payment Settings")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Chip Pin")?>?</label>
  <?php 
  echo CHtml::checkBox('mt_chip_pin_mobile_enabled',
  getOptionA('mt_chip_pin_mobile_enabled')=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>

<!-- <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Mode")?></label>
  <?php 
  echo CHtml::radioButton('mt_chip_pin_mobile_mode',
  getOptionA('mt_chip_pin_mobile_mode')=="sandbox"?true:false
  ,array(
    'value'=>"sandbox",
    'class'=>"icheck"
  ))
  ?>
  <?php echo t("Sandbox")?>
  <?php 
  echo CHtml::radioButton('mt_chip_pin_mobile_mode',
  getOptionA('mt_chip_pin_mobile_mode')=="live"?true:false
  ,array(
    'value'=>"live",
    'class'=>"icheck"
  ))
  ?>	
  <?php echo t("Live")?> 
</div>  -->


<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Mode")?></label>
  <div class="col-lg-6">
  <?php 
  echo CHtml::radioButton('mt_chip_pin_mobile_mode',
  getOptionA('mt_chip_pin_mobile_mode')=="sandbox"?true:false
  ,array(
    'value'=>"sandbox"    
  ))
  ?>
  <?php echo t("Sandbox")?> 
  <?php 
  echo CHtml::radioButton('mt_chip_pin_mobile_mode',
  getOptionA('mt_chip_pin_mobile_mode')=="live"?true:false
  ,array(
    'value'=>"live"  
  ))
  ?>  
  <?php echo t("Live")?> 
  </div>
</div>



<!--
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Client ID")?></label>
  <?php 
  echo CHtml::textField('mt_chip_pin_mobile_clientid',
  getOptionA('mt_chip_pin_mobile_clientid')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div> -->


<h3><?php echo Yii::t("default","Sandbox")?></h3>
<!-- <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Username")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_sandbox_chip_pin_user',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_sandbox_chip_pin_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div> -->

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Shared Secret")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_sanbox_chip_pin_pass',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_sanbox_chip_pin_pass')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin User Id")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_sanbox_chip_pin_user_id',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_sanbox_chip_pin_user_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Password")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_sanbox_chip_pin_password',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_sanbox_chip_pin_password')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Client Id")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_sanbox_chip_pin_client_id',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_sanbox_chip_pin_client_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

 

<h3><?php echo Yii::t("default","Live")?></h3>
<!-- <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Username")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_live_chip_pin_user',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_live_chip_pin_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div> -->

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Shared Secret")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_live_chip_pin_pass',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_live_chip_pin_pass')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin User Id")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_live_chip_pin_user_id',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_live_chip_pin_user_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Password")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_live_chip_pin_password',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_live_chip_pin_password')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Chip Pin Client Id")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_live_chip_pin_client_id',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_live_chip_pin_client_id')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>




<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>