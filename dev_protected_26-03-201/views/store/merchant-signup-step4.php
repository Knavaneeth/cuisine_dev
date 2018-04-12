<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Restaurant Signup"),
   'sub_text'=>t("step 4 of 4")
));

/*PROGRESS ORDER BAR*/
$this->renderPartial('/front/progress-merchantsignup',array(
   'step'=>4,
   'show_bar'=>true
));

?>
<div class="page-content">
	<div class="container">
		<div class="row">    
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">	
				<div class="payment-options">       
					<?php if ($continue==TRUE):?>
					<h1 class="package-title"><?php echo t("Almost Done")?></h1>
					<div class="white-box-shadow">
						<div class="alert alert-success text-center">
							<strong><?php echo t("Your merchant registration is successfull. An email was sent to your email with activation code.")?></strong>
						</div>
						<form class="forms" id="forms" onsubmit="return false;">
							<?php echo CHtml::hiddenField('action','activationMerchant')?> 
							<?php echo CHtml::hiddenField('currentController','store')?>
							<?php echo CHtml::hiddenField('token',$_GET['token'])?> 
							<?php FunctionsV3::sectionHeader('Enter Activation Code');?>
							<div class="row activation-code">
								<div class="col-lg-9 col-md-9 col-xs-12 col-sm-9">
									<?php echo CHtml::textField('activation_code',
									''
									,array(
									'class'=>'form-control',
									'data-validation'=>"required",
									'maxlength'=>10,
									'placeholder'=>t("Enter Activation Code")
									))?> 
								</div>
								<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
									<input type="submit" value="<?php echo t("Submit")?>" class="btn btn-primary btn-block">
								</div>
							</div>
							<div class="mt-15">
								<p><?php echo t("Did not receive activation code? click")?> <a class="resend-activation-code"href="javascript:;"><?php echo t("here")?></a> <?php echo Yii::t("default","to resend again.")?></p>
							</div>
						</form>
					</div>
					<?php else :?>
						<div class="alert alert-danger text-center">
							<strong><?php echo t("Sorry but we cannot find what you are looking for.")?></strong>
						</div>
					<?php endif;?>
				</div>
			</div>  
		</div>   
	</div>
 </div>