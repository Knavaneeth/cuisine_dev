<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Restaurant Signup"),
   'sub_text'=>t("signup process completed")
));

?>
<div class="page-content">
	<div class="container">     
		<div class="row">     
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">    
				<?php if ($data):?>
				<div class="success-wrap">        
					<div class="text-center">
						<i class="ion-ios-checkmark-outline i-big-extra green-text"></i>
					</div>
					<h1 class="success-title">Congratulation<br/> your merchant is now ready</h1>  
					<div class="payment-options">
						<div class="white-box-shadow text-center">
							<p><?php echo t("login to your account")?></p>
							<a href="<?php echo Yii::app()->createUrl('/merchant')?>" class="btn btn-primary"><?php echo t("click here")?></a>
						</div>   
					</div>		   
				</div>
				<?php else :?>
					<?php $this->renderPartial('/front/404-page'); ?>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>