<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','adminProfile')?>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t('default',"Profile")?></b></h4>
					<?php $admin_id=Yii::app()->functions->getAdminId(); ?>
					<?php if ( $res=Yii::app()->functions->getAdminUserInfo($admin_id)): ?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t('default',"Username")?></label>
						<div class="col-lg-6">
							<p class="text-mute"><?php echo $res['username']?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t('default',"First Name")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField("first_name",$res['first_name'],array(
							'class'=>"form-control",
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t('default',"Last Name")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField("last_name",$res['last_name'],array(
							'class'=>"form-control",
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t('default',"Email address")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField("email_address",$res['email_address'],array(
							'class'=>"form-control",
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t('default',"Language")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList("user_lang",$res['user_lang'],
							(array)Yii::app()->functions->availableLanguage(),
							array(
							'class'=>"form-control",
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t('default',"New Password")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::passwordField("password",'',array(
							'class'=>"form-control",
							//'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t('default',"Confirm New Password")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::passwordField("cpassword",'',array(
							'class'=>"form-control",
							//'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-2">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
					<?php else :?>
						<p class="uk-text-danger"><?php echo Yii::t("default","Profile not available")?></p>
					<?php endif;?>
				</form>
			</div>
		</div>
	</div>
</div>