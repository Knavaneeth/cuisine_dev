<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','withdrawalSettings')?>
					<?php 
					$payoutRequest=EmailTPL::payoutRequest();
					$payoutProcess=EmailTPL::payoutProcess();
					$paymode=yii::app()->functions->getOptionAdmin('wd_paypal_mode');

					$wd_template_payout_subject=yii::app()->functions->getOptionAdmin('wd_template_payout_subject');
					$wd_template_process_subject=yii::app()->functions->getOptionAdmin('wd_template_process_subject');
					if (empty($wd_template_payout_subject)){
						$wd_template_payout_subject=t("Your Request for Withdrawal was Received");
					}
					if (empty($wd_template_process_subject)){
						$wd_template_process_subject=t("Your Request for Withdrawal has been Processed");
					}
					?>
					<h4 class="mt-0 header-title"><b><?php echo t("Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Disabled Withdrawal from merchant")?>:</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('wd_payout_disabled',
							yii::app()->functions->getOptionAdmin('wd_payout_disabled')==2?true:false,
							array(
							'class'=>"icheck",
							'value'=>2
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Enabled Notification")?>?</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('wd_payout_notification',
							yii::app()->functions->getOptionAdmin('wd_payout_notification')==2?true:false,
							array(
							'class'=>"icheck",
							'value'=>2
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Days to process")?>:</label>
						<div class="col-lg-4">
							<div class="row">
								<div class="col-md-6">
									<?php 
									echo CHtml::textField('wd_days_process',yii::app()->functions->getOptionAdmin('wd_days_process'),array(
									 'class'=>"numeric_only form-control"
									))
									?>
								</div>
								<label class="col-md-6 control-label pl-0"><?php echo t("days")?></label>
								<div class="col-md-12"><p class="uk-text-muted"><?php echo t("How many days the payout will be process")?></p></div>
							</div>
						</div>
					</div>
					<hr></hr>
					<h4 class="mt-0 header-title"><b><?php echo t("Payment method")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><b><?php echo t("Enabled Paypal")?>:</b></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('wd_enabled_paypal',
							yii::app()->functions->getOptionAdmin('wd_enabled_paypal')==2?true:false,
							array(
							'class'=>"icheck",
							'value'=>2
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mode")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('wd_paypal_mode',
							$paymode=="Sandbox"?true:false
							,array(
							'value'=>"Sandbox",
							'class'=>"icheck"
							))
							?>
							<?php echo Yii::t("default","Sandbox")?>
							<?php 
							echo CHtml::radioButton('wd_paypal_mode',
							$paymode=="live"?true:false
							,array(
							'value'=>"live",
							'class'=>"icheck"
							))
							?>	
							<?php echo Yii::t("default","live")?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Minimum Payout Amount")?>:</label>
						<div class="col-lg-4">
							<div class="row">
								<div class="col-md-6">
									<?php 
									echo CHtml::textField('wd_paypal_minimum',yii::app()->functions->getOptionAdmin('wd_paypal_minimum'),array(
									'class'=>"numeric_only form-control"
									));
									?>
								</div>
								<label class="col-md-6 control-label pl-0"><?php echo Yii::app()->functions->adminCurrencySymbol();?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Paypal User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('wd_paypal_mode_user',
							Yii::app()->functions->getOptionAdmin('wd_paypal_mode_user')
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
							echo CHtml::textField('wd_paypal_mode_pass',
							Yii::app()->functions->getOptionAdmin('wd_paypal_mode_pass')
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
							echo CHtml::textField('wd_paypal_mode_signature',
							Yii::app()->functions->getOptionAdmin('wd_paypal_mode_signature')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<hr></hr>
					<div class="form-group">
						<label class="col-lg-2"><b><?php echo t("Enabled Bank Transfer")?>:</b></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('wd_bank_deposit',
							yii::app()->functions->getOptionAdmin('wd_bank_deposit')==2?true:false,
							array(
							'class'=>"icheck",
							'value'=>2
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><b><?php echo t("Bank Fields")?>:</b></label>
						<div class="col-sm-10">
							<div class="radio">
								<?php echo CHtml::radioButton('wd_bank_fields',
								yii::app()->functions->getOptionAdmin('wd_bank_fields')=="default"?true:false,array(
								'value'=>"default"
								))?>
								<label><?php echo t("Use Default")?></label>
							</div>
							<div class="radio">
								<?php echo CHtml::radioButton('wd_bank_fields',
								yii::app()->functions->getOptionAdmin('wd_bank_fields')=="au"?true:false,array(
								'value'=>"au"
								))?>
								<label><?php echo t("Use Australia Bank Fields")?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Minimum Payout Amount")?>:</label>
						<div class="col-lg-4">
							<div class="row">
								<div class="col-md-6">
									<?php 
									echo CHtml::textField('wd_bank_minimum',yii::app()->functions->getOptionAdmin('wd_bank_minimum'),array(
									'class'=>"numeric_only form-control"
									));
									?>
								</div>
								<label class="col-md-6 control-label pl-0"><?php echo Yii::app()->functions->adminCurrencySymbol();?></label>
							</div>
						</div>
					</div>
					<hr></hr>
					<h4 class="mt-0 header-title"><b><?php echo t("Email Template")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Subject")?>:</label> 
						<div class="col-lg-6"> 
							<?php 
							echo CHtml::textField('wd_template_payout_subject',$wd_template_payout_subject,array(
							 'class'=>"form-control"
							));
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-12"><?php echo t("Template Payout")?>:</label> 
						<div class="col-lg-12"> 
							<?php 
							echo CHtml::textArea('wd_template_payout',
							yii::app()->functions->getOptionAdmin('wd_template_payout')==""?$payoutRequest:yii::app()->functions->getOptionAdmin('wd_template_payout')
							,array(
							 'class'=>'big-textarea form-control'
							))
							?>
						</div>
						<label class="col-lg-2"><?php echo t("Available Tags")?>:</label> 
						<div class="col-lg-10"> 
							<ul class="tag-list">
								<li class="uk-badge">{<?php echo t("merchant-name")?>}</li>
								<li class="uk-badge">{<?php echo t("payment-method")?>}</li>
								<li class="uk-badge">{<?php echo t("payout-amount")?>}</li>
								<li class="uk-badge">{<?php echo t("account")?>}</li>
								<li class="uk-badge">{<?php echo t("cancel-date")?>}</li>
								<li class="uk-badge">{<?php echo t("cancel-link")?>}</li>
								<li class="uk-badge">{<?php echo t("process-date")?>}</li>  
							</ul>
						</div>
					</div>
					<hr></hr>
					<div class="form-group"> 
						<label class="col-lg-2"><?php echo t("Subject")?>:</label> 
						<div class="col-lg-6"> 
							<?php 
							echo CHtml::textField('wd_template_process_subject',$wd_template_process_subject,array(
							'class'=>"form-control"
							));
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-12"><?php echo t("Template Payment Process")?>:</label>  
						<div class="col-lg-12"> 
							<?php 
							echo CHtml::textArea('wd_template_process',
							yii::app()->functions->getOptionAdmin('wd_template_process')==""?$payoutProcess:yii::app()->functions->getOptionAdmin('wd_template_process')
							,array(
							'class'=>'big-textarea form-control'
							))
						?>
						</div>
						<label class="col-lg-2"><?php echo t("Available Tags")?>:</label>
						<div class="col-lg-10"> 
							<ul class="tag-list">
								<li class="uk-badge">{<?php echo t("merchant-name")?>}</li>
								<li class="uk-badge">{<?php echo t("payment-method")?>}</li>
								<li class="uk-badge">{<?php echo t("payout-amount")?>}</li> 
								<li class="uk-badge">{<?php echo t("acoount")?>}</li> 
							</ul>
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