<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','FaxSettings')?>
					<h4 class="mt-0 header-title"><b><?php echo t("Fax Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Enabled Fax Services from merchant")?>:</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('fax_enabled',
							yii::app()->functions->getOptionAdmin('fax_enabled')==2?true:false,
							array(
							 'class'=>"icheck",
							 'value'=>2
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Use admin Fax credits to send Fax on merchant")?>:</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('fax_user_admin_credit',
							yii::app()->functions->getOptionAdmin('fax_user_admin_credit')==2?true:false,
							array(
							'class'=>"icheck",
							'value'=>2
							))?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Faxage Account")?></b></h4>
					<p class="text-muted"><?php echo t("Get your faxage.com account on")?>  http://www.faxage.com </p>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Company")?>:</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('fax_company',yii::app()->functions->getOptionAdmin('fax_company'),array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Username")?>:</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('fax_username',yii::app()->functions->getOptionAdmin('fax_username'),array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Password")?>:</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('fax_password',yii::app()->functions->getOptionAdmin('fax_password'),array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Notificaton")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Email Address")?>:</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('fax_email_notification',yii::app()->functions->getOptionAdmin('fax_email_notification'),array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<p class="text-muted"><?php echo t("Email Address that will receive notification when there is new payment")?></p>
					<div class="form-group">
						<label class="col-lg-3 control-label"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>