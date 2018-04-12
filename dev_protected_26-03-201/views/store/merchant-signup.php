<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Restaurant Signup"),
   'sub_text'=>t("Please select one of our package")
));

/*PROGRESS ORDER BAR*/
$this->renderPartial('/front/progress-merchantsignup',array(
   'step'=>1,
   'show_bar'=>true
));
?>


<div class="page-content">
	<div class="container">
		<div class="row">
		<?php if (is_array($list) && count($list)>=1):?>    
		<?php foreach ($list as $val):?>
			<div class="col-sm-4">
				<div class="panel b-light price-box text-center mt-15">
					<div class="panel-heading bg-white b-light">
						<h3><?php echo $val['title']?></h3>
					</div>
					<ul class="list-group">
						<li class="list-group-item text-center bg-light"> <span class="text-primary bold h1">	<?php if ( $val['promo_price']>=1):?>
							<span class="strike-price"><?php echo FunctionsV3::prettyPrice($val['price'])?></span>
						<?php echo FunctionsV3::prettyPrice($val['promo_price'])?>
						<?php else :?>
							<?php echo FunctionsV3::prettyPrice($val['price'])?>
						<?php endif;?></span></li>
						<li class="list-group-item"><span class="ion-checkmark-round"></span> <?php echo $val['description']?></li>
						<li class="list-group-item">
							<span class="ion-checkmark-round"></span> 
							<?php if ( $val['expiration_type']=="year"):?>
								<?php echo t("Membership Limit")?> <?php echo $val['expiration']/365;?> <?php echo t($val['expiration_type'])?>
							<?php else :?>
								<?php echo t("Membership Limit")?> <?php echo $val['expiration']?> <?php echo t($val['expiration_type'])?>
							<?php endif;?>
						</li>
						<li class="list-group-item">
							<span class="ion-checkmark-round"></span> 
							<?php if ( $val['sell_limit'] <=0):?>
								<?php echo Yii::t("default","Sell limit")?> : <?php echo Yii::t("default","Unlimited")?>
							<?php else :?>
								<?php echo Yii::t("default","Sell limit")?> : <?php echo $val['sell_limit']?>
							<?php endif;?>
						</li>
						<li class="list-group-item">
							<span class="ion-checkmark-round"></span> 
							<?php echo Yii::t("default","Usage:")?> <?php echo $limited_post[$val['unlimited_post']]?>
						</li>
					</ul>
					<div class="panel-footer">
						<a href="<?php echo Yii::app()->createUrl('/store/merchantsignup/',array(
						'do'=>"step2",
						'package_id'=>$val['package_id']
						))?>" class="btn btn-primary m-t m-b">
						<?php echo t("Sign up")?>
						</a>
					</div>
				</div>
			</div>
		<?php endforeach;?>
		<?php else:?>
			<p class="text-danger text-center">
				<?php echo t("No package available")?><br/>
				<?php echo t("come back again later")?>
			</p>
		<?php endif;?>
		</div>
		<?php if (is_array($list) && count($list)>=1):?>    
		<div class="resume-signup">
			<?php echo FunctionsV3::sectionHeader('Resume Sign Up?');?>
			<a class="resume-app-link btn btn-primary" href="javascript:;">
				<?php echo Yii::t("default","Click here")?>
			</a>
			<form onsubmit="return false;" method="POST" class="frm-resume-signup uk-form has-validation-callback" id="frm-resume-signup">
				<input type="hidden" id="action" name="action" value="merchantResumeSignup">
				<input type="hidden" id="do-action" name="do-action" value="sigin">         
				<?php echo CHtml::hiddenField('currentController','store')?>  
				<div class="row mt-15">		  
					<div class="col-md-4">
					<?php echo CHtml::textField('email_address','',array(
					'data-validation'=>'required',		    
					'class'=>'form-control',
					'placeholder'=>t("Email")
					))?>
					</div>
				</div>
				<div class="row mt-15">	
					<div class="col-md-4">
						<input type="submit" class="btn btn-primary" value="<?php echo Yii::t("default","Submit")?>">
					</div>
				</div>
			</form>
		</div>
		<?php endif;?>
	</div>
</div>