<?php
$merchant_id=Yii::app()->functions->getMerchantID();
$enabled_citypay=Yii::app()->functions->getOption('merchant_enabled_citypay',$merchant_id);
$citypay_mode=Yii::app()->functions->getOption('merchant_citypay_mode',$merchant_id); 
?>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','saveMerchantcitypaySettings')?>

<!--<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Citypay?")?></label>
  <?php 
  echo CHtml::checkBox('merchant_enabled_citypay',
  $enabled_citypay=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>-->
  
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Citypay")?>?</label>
  <?php 
  echo CHtml::checkBox('merchant_enabled_citypay',
  Yii::app()->functions->getOption('merchant_enabled_citypay',$merchant_id)=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>

<?php echo  "citypay_mode   ".$citypay_mode;  ?>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Mode")?></label>
  <div class="col-lg-6">
  <?php 
  echo CHtml::radioButton('merchant_citypay_mode',
  $citypay_mode=="sandbox"?true:false
  ,array(
    'value'=>"sandbox"    
  ))
  ?>
  <?php echo t("Sandbox")?> 
  <?php 
  echo CHtml::radioButton('merchant_citypay_mode',
  $citypay_mode=="live"?true:false
  ,array(
    'value'=>"live"  
  ))
  ?>	
  <?php echo t("Live")?> 
  </div>
</div>


 







<div class="uk-form-row">
<label class="uk-form-label"><?php echo Yii::t("default","Card Fee")?></label>
<?php 
echo CHtml::textField('merchant_citypay_fee',
Yii::app()->functions->getOptionAdmin('merchant_citypay_fee')
,array(
'class'=>"uk-form-width-small numeric_only"
))
?>
</div>


<h3><?php echo Yii::t("default","Sandbox")?></h3>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay User")?></label>
  <?php 
  echo CHtml::textField('merchant_sanbox_citypay_user',
  Yii::app()->functions->getOptionAdmin('merchant_sanbox_citypay_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay License Key")?></label>
  <?php 
  echo CHtml::textField('merchant_sanbox_citypay_pass',
  Yii::app()->functions->getOptionAdmin('merchant_sanbox_citypay_pass')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>
 

<h3><?php echo Yii::t("default","Live")?></h3>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay User")?></label>
  <?php 
  echo CHtml::textField('merchant_live_citypay_user',
  Yii::app()->functions->getOptionAdmin('merchant_live_citypay_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay License Key")?></label>
  <?php 
  echo CHtml::textField('merchant_live_citypay_pass',
  Yii::app()->functions->getOptionAdmin('merchant_live_citypay_pass')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>
 
<hr>
<h3><?php echo t("Mobile Citypay payment Settings")?></h3>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Enabled Citypay")?>?</label>
  <?php 
  echo CHtml::checkBox('mt_citypay_mobile_enabled',
  getOptionA('mt_citypay_mobile_enabled')=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>

<!-- <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Mode")?></label>
  <?php 
  echo CHtml::radioButton('mt_citypay_mobile_mode',
  getOptionA('mt_citypay_mobile_mode')=="sandbox"?true:false
  ,array(
    'value'=>"sandbox",
    'class'=>"icheck"
  ))
  ?>
  <?php echo t("Sandbox")?>
  <?php 
  echo CHtml::radioButton('mt_citypay_mobile_mode',
  getOptionA('mt_citypay_mobile_mode')=="live"?true:false
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
  echo CHtml::radioButton('mt_citypay_mobile_mode',
  getOptionA('mt_citypay_mobile_mode')=="sandbox"?true:false
  ,array(
    'value'=>"sandbox"    
  ))
  ?>
  <?php echo t("Sandbox")?> 
  <?php 
  echo CHtml::radioButton('mt_citypay_mobile_mode',
  getOptionA('mt_citypay_mobile_mode')=="live"?true:false
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
  echo CHtml::textField('mt_citypay_mobile_clientid',
  getOptionA('mt_citypay_mobile_clientid')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div> -->


<h3><?php echo Yii::t("default","Sandbox")?></h3>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay User")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_sandbox_citypay_user',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_sandbox_citypay_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay License Key")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_sanbox_citypay_pass',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_sanbox_citypay_pass')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>
 

<h3><?php echo Yii::t("default","Live")?></h3>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay User")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_live_citypay_user',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_live_citypay_user')
  ,array(
    'class'=>"uk-form-width-large"
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Citypay License Key")?></label>
  <?php 
  echo CHtml::textField('merchant_mobile_live_citypay_pass',
  Yii::app()->functions->getOptionAdmin('merchant_mobile_live_citypay_pass')
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