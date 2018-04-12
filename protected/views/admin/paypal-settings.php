<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<?php
				$enabled_paypal=Yii::app()->functions->getOptionAdmin('admin_enabled_paypal');
				$paypal_mode=Yii::app()->functions->getOptionAdmin('admin_paypal_mode');
				?>
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','saveAdminPaypalSettings')?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Disabled Paypal")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_enabled_paypal',
							Yii::app()->functions->getOptionAdmin('admin_enabled_paypal')=="yes"?true:false
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
							echo CHtml::radioButton('admin_paypal_mode',
							$paypal_mode=="sandbox"?true:false
							,array(
							'value'=>"sandbox",
							'class'=>" "
							))
							?>
							<?php echo t("Sandbox")?> 
							<?php 
							echo CHtml::radioButton('admin_paypal_mode',
							$paypal_mode=="live"?true:false
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
							echo CHtml::textField('admin_paypal_fee',
							Yii::app()->functions->getOptionAdmin('admin_paypal_fee')
							,array(
							'class'=>"form-control numeric_only"
							))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Sandbox")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Paypal User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_sanbox_paypal_user',
							Yii::app()->functions->getOptionAdmin('admin_sanbox_paypal_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Paypal Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_sanbox_paypal_pass',
							Yii::app()->functions->getOptionAdmin('admin_sanbox_paypal_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Paypal Signature")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_sanbox_paypal_signature',
							Yii::app()->functions->getOptionAdmin('admin_sanbox_paypal_signature')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Live")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Paypal User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_live_paypal_user',
							Yii::app()->functions->getOptionAdmin('admin_live_paypal_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Paypal Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_live_paypal_pass',
							Yii::app()->functions->getOptionAdmin('admin_live_paypal_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Paypal Signature")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_live_paypal_signature',
							Yii::app()->functions->getOptionAdmin('admin_live_paypal_signature')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<hr>
					<h4 class="mt-0 header-title"><b><?php echo t("Mobile Paypal payment Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Enabled Paypal")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('adm_paypal_mobile_enabled',
							getOptionA('adm_paypal_mobile_enabled')=="yes"?true:false
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
							echo CHtml::radioButton('adm_paypal_mobile_mode',
							getOptionA('adm_paypal_mobile_mode')=="sandbox"?true:false
							,array(
							'value'=>"sandbox",
							'class'=>" "
							))
							?>
							<?php echo t("Sandbox")?>
							<?php 
							echo CHtml::radioButton('adm_paypal_mobile_mode',
							getOptionA('adm_paypal_mobile_mode')=="live"?true:false
							,array(
							'value'=>"live",
							'class'=>" "
							))
							?>	
							<?php echo t("Live")?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Client ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('adm_paypal_mobile_clientid',
							getOptionA('adm_paypal_mobile_clientid')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>