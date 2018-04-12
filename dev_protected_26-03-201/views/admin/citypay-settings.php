<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<?php
				$enabled_citypay=Yii::app()->functions->getOptionAdmin('admin_enabled_citypay');
				$citypay_mode=Yii::app()->functions->getOptionAdmin('admin_citypay_mode');
				?>
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','saveAdminCitypaySettings')?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Disabled Citypay")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_enabled_citypay',
							Yii::app()->functions->getOptionAdmin('admin_enabled_citypay')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mode")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('admin_citypay_mode',
							$citypay_mode=="sandbox"?true:false
							,array(
							'value'=>"sandbox",
							'class'=>" "
							))
							?>
							<?php echo t("Sandbox")?> 
							<?php 
							echo CHtml::radioButton('admin_citypay_mode',
							$citypay_mode=="live"?true:false
							,array(
							'value'=>"live",
							'class'=>" "
							))
							?>	
							<?php echo t("Live")?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Card Fee")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('admin_citypay_fee',
							Yii::app()->functions->getOptionAdmin('admin_citypay_fee')
							,array(
							'class'=>"form-control numeric_only"
							))
							?>
						</div>
					</div>

					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Sandbox")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Citypay User ID ")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_sanbox_citypay_user',
							Yii::app()->functions->getOptionAdmin('admin_sanbox_citypay_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Citypay License Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_sanbox_citypay_pass',
							Yii::app()->functions->getOptionAdmin('admin_sanbox_citypay_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					 
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Live")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Citypay User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_live_citypay_user ID',
							Yii::app()->functions->getOptionAdmin('admin_live_citypay_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Citypay License Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_live_citypay_pass',
							Yii::app()->functions->getOptionAdmin('admin_live_citypay_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>					 
					<hr>
					<h4 class="mt-0 header-title"><b><?php echo t("Mobile Citypay payment Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Enabled Citypay")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('adm_citypay_mobile_enabled',
							getOptionA('adm_citypay_mobile_enabled')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mode")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('adm_citypay_mobile_mode',
							getOptionA('adm_citypay_mobile_mode')=="sandbox"?true:false
							,array(
							'value'=>"sandbox",
							'class'=>"icheck"
							))
							?>
							<?php echo t("Sandbox")?>
							<?php 
							echo CHtml::radioButton('adm_citypay_mobile_mode',
							getOptionA('adm_citypay_mobile_mode')=="live"?true:false
							,array(
							'value'=>"live",
							'class'=>"icheck"
							))
							?>	
							<?php echo t("Live")?> 
						</div>
					</div>

					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Mobile Sandbox")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Citypay User ID ")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_sanbox_citypay_user',
							Yii::app()->functions->getOptionAdmin('admin_mob_sanbox_citypay_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Citypay License Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_sanbox_citypay_pass',
							Yii::app()->functions->getOptionAdmin('admin_mob_sanbox_citypay_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					 
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Mobile Live")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Citypay User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_live_citypay_user',
							Yii::app()->functions->getOptionAdmin('admin_mob_live_citypay_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Citypay License Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_live_citypay_pass',
							Yii::app()->functions->getOptionAdmin('admin_mob_live_citypay_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>	


					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Client ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('adm_citypay_mobile_clientid',
							getOptionA('adm_citypay_mobile_clientid')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>