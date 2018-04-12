<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Restaurant Signup"),
   'sub_text'=>t("Please Choose A Package Below To Signup")
));
?>
<div class="page-content merchant-signup-page">
	<div class="container">
		<div class="row">
			<?php if ( $disabled_membership_signup!=1):?>
			<div class="col-md-6 col-sm-6 col-xs-6">       
				<?php if ( FunctionsK::hasMembershipPackage()):?>  
				<div class="well-box membership-box">
					<h2 class="block-title-2 text-center"><?php echo t("Membership")?></h2>
					<div class="well mb0">	     	     	               
						<p class="text-center">
						<?php echo t("You will be charged a monthly or yearly fee")?>
						</p>
						<div class="text-center">
							<a href="<?php echo Yii::app()->createUrl("/store/merchantsignup")?>" class="btn btn-primary">
								<?php echo t("click here")?>
							</a>
						</div>
					</div>
				</div> 
				<?php endif;?>
			</div>
			<?php endif;?>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="well-box commission-box">
					<h2 class="block-title-2 text-center"><?php echo t("Commission")?></h2>
					<div class="well mb0">	     	     	               
						<p class="text-center">           
							<?php 
							if ( $commision_type=="fixed"){
							echo displayPrice($currency,$percent)." ".t("commission per order");
							} else echo standardPrettyFormat($percent)."% ".t("commission per order")
							?>                
						</p>
						<div class="text-center">
							<a href="<?php echo Yii::app()->createUrl("/store/merchantsignupinfo")?>" class="btn btn-primary">
							<?php echo t("click here")?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>