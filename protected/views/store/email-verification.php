<?php
$this->renderPartial('/front/default-header',array(
   'h1'=>t("Email Verification"),
   'sub_text'=>t("Your registration is almost complete")
));?>

<?php 
if (isset($_GET['checkout'])){
	$this->renderPartial('/front/order-progress-bar',array(
	   'step'=>4,
	   'show_bar'=>true
	));
}
?>
<div class="page-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">	
				<div class="payment-options">
					<h1 class="package-title"><?php echo t("We have sent verification code to your email address")?></h1>
					<div class="white-box-shadow">	     	     	    
						<form class="forms bottom20" id="forms" onsubmit="return false;">
							<?php echo CHtml::hiddenField('action','verifyEmailCode')?>         
							<?php echo CHtml::hiddenField('client_id',$data['client_id']) ?>
							<?php echo CHtml::hiddenField('currentController','store')?>
							<?php if (isset($_GET['checkout'])):?>
							<?php echo CHtml::hiddenField('redirect', Yii::app()->createUrl('/store/paymentoption') )?>
							<?php endif;?>
							<?php FunctionsV3::sectionHeader('Please enter you verification code');?>
							<div class="row activation-code">
								<div class="col-lg-9">
									<?php 
									echo CHtml::textField('code','',array(
									'class'=>"form-control",
									'data-validation'=>"required",
									'maxlength'=>14
									));
									?>
								</div>
								<div class="col-lg-3 ">
									<input type="submit" value="<?php echo t("Submit")?>" class="btn btn-primary btn-block">
								</div>
							</div>
						</form>
						<p class="text-center">
							<?php echo t("Did not receive your verification code")?>? <a href="javascript:;" class="resend-email-code"><?php echo t("Click here to resend")?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>