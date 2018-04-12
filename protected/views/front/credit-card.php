
<div class="credit_card_wrap">    
<form id="frm-creditcard" class="frm-creditcard" method="POST" onsubmit="return false;">

<?php FunctionsV3::sectionHeader('Credit Card information')?>
 <a href="javascript:;" class="cc-add orange-text">
 [ <i class="ion-ios-compose-outline"></i> <?php echo t("Add new card")?>]
 </a>
 
<?php FunctionsV3::sectionHeader('select credit card below')?> 
<table class="table table-striped">
<tbody class="uk-list-cc"> 
</tbody>
</table>

<div class="cc-add-wrap">
  <p class="bold"><?php echo Yii::t("default","New Card")?></p>
  <?php echo CHtml::hiddenField('action','addCreditCard')?>
  <?php echo CHtml::hiddenField('currentController','store')?>
  
  <div class="row top10">
    <div class="col-md-12">
      <?php echo CHtml::textField('card_name','',array(
       'class'=>'form-control full-width',
       'placeholder'=>Yii::t("default","Card name"),
       'data-validation'=>"required"  
      ))?>
     </div> 
  </div>

 <div class="row top10">
    <div class="col-md-12">
	<?php echo CHtml::textField('credit_card_number','',array(
	   'class'=>'numeric_only form-control full-width',
	   'placeholder'=>Yii::t("default","Credit Card Number"),
	   'data-validation'=>"required",
	   'maxlength'=>16
	  ))?>     
     </div> 
 </div>
 
 <div class="row top10">
    <div class="col-md-12">
    <?php echo CHtml::dropDownList('expiration_month','',
      Yii::app()->functions->ccExpirationMonth()
      ,array(
       'class'=>'form-control full-width',
       'placeholder'=>Yii::t("default","Exp. month"),
       'data-validation'=>"required"  
      ))?>     
     </div> 
 </div> 

<div class="row top10">
<div class="col-md-12">
 <?php echo CHtml::dropDownList('expiration_yr','',
  Yii::app()->functions->ccExpirationYear()
  ,array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Exp. year") ,
   'data-validation'=>"required"  
  ))?>     
</div> 
</div>

<div class="row top10">
<div class="col-md-12">
<?php echo CHtml::textField('cvv','',array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","CVV"),
   'data-validation'=>"required",
   'maxlength'=>4
  ))?>     
</div> 
</div>   

<div class="row top10">
<div class="col-md-12">
<?php echo CHtml::textField('billing_address','',array(
   'class'=>'form-control full-width',
   'placeholder'=>Yii::t("default","Billing Address"),
   'data-validation'=>"required"  
  ))?> 
 </div> 
</div>

<div class="top25">
<input type="submit" value="<?php echo t("Add Credit Card")?>" class="btn btn-success medium inline block">
</div>
  
</div>
</form>
</div>