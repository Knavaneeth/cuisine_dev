<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal admin-settings-page forms" id="forms">
					<?php echo CHtml::hiddenField('action','emailSettings')?>
					<?php 
					$email_provider=Yii::app()->functions->getOptionAdmin('email_provider');
					?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Email Type")?>:</label>
						<div class="col-sm-10">
							<div class="radio">
								<?php 
								echo CHtml::radioButton('email_provider',
								$email_provider=="phpmail"?true:false
								,array(
								'value'=>"phpmail"
								)) ?>
								<label><?php echo t("use php mail functions")?></label>
							</div>
							<div class="radio">
								<?php 
								echo CHtml::radioButton('email_provider',
								$email_provider=="smtp"?true:false
								,array(
								'value'=>'smtp'
								)) ?>
								<label><?php echo t("use SMTP")?></label>
							</div>
							<div class="radio">
								<?php 
								echo CHtml::radioButton('email_provider',
								$email_provider=="mandrill"?true:false
								,array(
								'value'=>'mandrill'
								)) ?>
								<label><?php echo t("use Mandrill API")?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SMTP host")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('smtp_host',
							Yii::app()->functions->getOptionAdmin('smtp_host'),
							array(
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SMTP port")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('smtp_port',
							Yii::app()->functions->getOptionAdmin('smtp_port'),
							array(
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Username")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('smtp_username',
							Yii::app()->functions->getOptionAdmin('smtp_username'),
							array(
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('smtp_password',
							Yii::app()->functions->getOptionAdmin('smtp_password'),
							array(
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="alert alert-danger">
								<?php echo t("Note: When using SMTP make sure the port number is open in your server")?>.<br/>
								<?php echo t("You can ask your hosting to open this for you")?>.
							</div>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Mandrill API")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","API KEY")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('mandrill_api_key',
							Yii::app()->functions->getOptionAdmin('mandrill_api_key'),
							array(
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-2">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
						<div class="col-lg-3">
							<a href="javascript:;" class="test-email btn btn-default btn-block"><?php echo t("Click here to send Test Email")?></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>