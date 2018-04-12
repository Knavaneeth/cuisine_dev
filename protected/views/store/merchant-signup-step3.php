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
<div class="page-content section-merchant-payment">
	<div class="container">
		<div class="row">   
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">	
				<div class="payment-options">       
					<h1 class="package-title"><?php echo t("Choose Payment option")?></h1>
					<div class="white-box-shadow">	  
					<?php if ($merchant):?>
					<?php 
						$merchant_id=$merchant['merchant_id']; 
						if ($renew==TRUE){
							$merchant['package_price']=1;
						}               
					?>
					<?php if ($merchant['package_price']>=1):?>
						<form class="uk-form uk-form-horizontal forms" id="forms" onsubmit="return false;">
						<?php echo CHtml::hiddenField('action','merchantPayment')?>
						<?php echo CHtml::hiddenField('currentController','store')?>
						<?php echo CHtml::hiddenField('token',$_GET['token'])?>  
							<?php if ($renew==TRUE):?>
								<?php echo CHtml::hiddenField("renew",1);?>
								<?php echo CHtml::hiddenField("package_id",$package_id);?>
								<?php if (is_numeric($package_id)):?>
							 
									<?php 
									$this->renderPartial('/front/payment-list',array(
									'merchant_id'=>$merchant_id,
									'payment_list'=>FunctionsV3::getAdminPaymentList(),						   
									));
									?>  
								<?php else :?>
									<p class="text-warning"><?php echo t("No Selecetd Membership package. Please go back.")?></p>
								<?php endif;?>
							<?php else :?>
								<?php 
								$this->renderPartial('/front/payment-list',array(
								'merchant_id'=>$merchant_id,
								'payment_list'=>FunctionsV3::getAdminPaymentList(),						   
								));
								?>
							<?php endif;?>
							<div class="mt-10">
								<input type="submit" value="<?php echo t("Next")?>" class="btn btn-primary">
							</div>    
						</form>
						<?php 
						$this->renderPartial('/front/credit-cart-merchant',array(
						   'merchant_id'=>$merchant_id	   
						));
						?>
						<?php else :?>
							<div class="alert alert-success text-center">
								<strong><?php echo t("You have selected a package which is free of charge. You can now proceed to next steps.")?></strong>
							</div>
							<div class="mt-10">
								<input type="submit" data-token="<?php echo $_GET['token']?>" value="<?php echo t("Next")?>" class="next_step_free_payment btn btn-primary">
							</div>    
						<?php endif;?>
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
</div>