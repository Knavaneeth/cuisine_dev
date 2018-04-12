<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Restaurant Signup"),
   'sub_text'=>t("step 3 of 4")
));

/*PROGRESS ORDER BAR*/
$this->renderPartial('/front/progress-merchantsignup',array(
   'step'=>3,
   'show_bar'=>true
));
?>
<?php 
$continue=true;
$msg="";
if ($merchant=Yii::app()->functions->getMerchantByToken($_GET['internal-token'])){			
} else {
	$continue=false;
	$msg=Yii::t("default",'Sorry but we cannot find what you are looking for.');
}

$paypal_con=Yii::app()->functions->getPaypalConnectionAdmin();   
$paypal=new Paypal($paypal_con);

if ($res_paypal=$paypal->getExpressDetail()){	
} else {
	 $continue=false;
	 $msg="Paypay Error: ".$paypal->getError();
}
?>
<div class="page-content section-merchant-payment">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">  
				<?php if ( $continue==TRUE):?>
				<h1 class="package-title"><?php echo Yii::t("default","Paypal Verification")?></h1>
				<div class="white-box-shadow">	
					<form class="forms" id="forms" onsubmit="return false;">
						<?php echo CHtml::hiddenField('action','merchantPaymentPaypal')?>
						<?php echo CHtml::hiddenField('currentController','store')?>
						<?php echo CHtml::hiddenField('internal-token',$_GET['internal-token'])?>
						<?php echo CHtml::hiddenField('token',$_GET['token'])?>    
						<?php if (isset($_GET['renew'])):?>
							<?php echo CHtml::hiddenField('renew',$_GET['renew'])?>    
							<?php echo CHtml::hiddenField('package_id',$_GET['package_id'])?>    
						<?php endif;?>
						<div class="row">
							<label class="control-label col-md-3"><?php echo Yii::t("default","Paypal Name")?></label>
							<span class="bold col-md-9"><?php echo $res_paypal['FIRSTNAME']." ".$res_paypal['LASTNAME']?></span>
						</div>
						<div class="row">
							<label class="control-label col-md-3"><?php echo Yii::t("default","Paypal Email")?></label>
							<span class="bold col-md-9"><?php echo $res_paypal['EMAIL']?></span>
						</div>
						<div class="row">
							<label class="control-label col-md-3"><?php echo Yii::t("default","Selected Package")?></label>
							<span class="bold col-md-9"><?php echo ucwords($merchant['package_name'])?></span>
						</div>
						<div class="row">
							<label class="control-label col-md-3"><?php echo Yii::t("default","Amount to pay")?></label>
							<span class="bold col-md-9"><?php echo $res_paypal['CURRENCYCODE']." ".$res_paypal['AMT']?></span>
						</div>
						<div class="text-left">   
							<input type="submit" value="<?php echo Yii::t("default","Pay Now")?>" class="btn btn-primary">
						</div>
					</form>
				</div>
				<?php else :?>
					<p class="text-danger"><?php echo $msg;?></p>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>