<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deliveryboys/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deliveryboys" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
<!-- <a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/subCategoryList/Do/Sort" class="uk-button"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a> -->
</div>

<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','addDeliveryboys')?> 
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php if (!isset($_GET['id'])):?>
<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/merchant/deliveryboys/Do/Add")?>
<?php endif;?>

<?php 
if (isset($_GET['id'])){
	if (!$data=Yii::app()->functions->get_driver_details($_GET['id'])){
		echo "<div class=\"uk-alert uk-alert-danger\">".
		Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
		return ;
	}	
}
 // print_r($data);
?>                                 

<div class="uk-form-row"> 

<div class="uk-form-row">
<label class="uk-form-label"><?php echo Yii::t("default","Driver Name")?></label>
  <?php echo CHtml::textField('driver_name',
  isset($data['driver_name'])?stripslashes($data['driver_name']):""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>  
</div> 


<div class="uk-form-row">
<label class="uk-form-label"><?php echo Yii::t("default","Driver Mobile No")?></label>
  <?php echo CHtml::textField('driver_mobile',
  isset($data['mobile_no'])?stripslashes($data['mobile_no']):"+44"
  ,array(
  'class'=>'uk-form-width-large driver_mobile',
  'data-validation'=>"required"
  ))?>  
</div> 


<div class="uk-form-row">
<label class="uk-form-label"><?php echo Yii::t("default","Driver Email")?></label>
  <?php echo CHtml::textField('driver_email',
  isset($data['mailid'])?stripslashes($data['mailid']):""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>  
</div> 

<div class="uk-form-row">
<label class="uk-form-label"><?php echo Yii::t("default","Driver License No")?></label>
  <?php echo CHtml::textField('driver_license',
  isset($data['driving_license_no'])?stripslashes($data['driving_license_no']):""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>  
</div> 
 
 
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo t("Status")?></label>
  <?php echo CHtml::dropDownList('status',
  isset($data['status'])?$data['status']:"",
  (array)driverList(),          
  array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
</div>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>