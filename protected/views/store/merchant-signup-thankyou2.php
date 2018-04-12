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
				<div class="payment-options">
					<h1 class="package-title"><?php echo t("Congratulations")?>!</h1>
					<div class="white-box-shadow">
						<div class="alert alert-success text-center">
							<?php echo t("Congratulation for signing up. Please wait while our administrator validated your request.")?>
						</div>
						<div class="alert alert-success text-center">
							<?php echo t("You will receive email once your merchant has been approved. Thank You.")?>
						</div>
						<a href="<?php echo Yii::app()->createUrl('/store')?>" class="btn btn-primary"><?php echo t("back to homepage")?></a>
					</div>   
				</div>
				<?php else :?>
					<?php 
					$this->renderPartial('/front/404-page');
					?>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>