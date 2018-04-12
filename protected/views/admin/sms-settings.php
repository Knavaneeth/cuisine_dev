<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','smsSettings')?>
					<h4 class="mt-0 header-title"><b><?php echo t("Merchant SMS Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Disabled SMS on merchant")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('mechant_sms_enabled',
							Yii::app()->functions->getOptionAdmin('mechant_sms_enabled')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<!-- <div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Disabled Purchase SMS Credit")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('mechant_sms_purchase_disabled',
							Yii::app()->functions->getOptionAdmin('mechant_sms_purchase_disabled')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div> 
					</div>-->
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use admin SMS credits to send SMS")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('mechant_sms_purchase_disabled',
							Yii::app()->functions->getOptionAdmin('mechant_sms_purchase_disabled')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("SMS Gateway to use when sending SMS")?></b></h4>
					<div class="form-group">  
						<label class="col-lg-2"></label>
						<div class="col-lg-6">
							<ul>
								<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="twilio"?true:false
								,array(
								'class'=>"icheck",
								'value'=>"twilio"
								));
								echo "<span>".t("use twilio")."</span>";
								?>
								</li>
								<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="nexmo"?true:false
								,array(
								'class'=>"icheck",
								'value'=>'nexmo'
								));
								echo "<span>".t("use Nexmo")."</span>";
								?></li>
								<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="clickatell"?true:false
								,array(
								'class'=>"icheck",
								'value'=>'clickatell'
								));
								echo "<span>".t("use Clickatell")."</span>";
								?></li>
								<!--<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="private"?true:false
								,array(
								'class'=>"icheck",
								'value'=>'private'
								));
								echo "<span>".t("use Private SMS")."</span>";
								?></li>-->
								<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="bhashsms"?true:false
								,array(
								'class'=>"icheck",
								'value'=>'bhashsms'
								));
								echo "<span>".t("use BHASHSMS")."</span>";
								?></li>
								<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="smsglobal"?true:false
								,array(
								'class'=>"icheck",
								'value'=>'smsglobal'
								));
								echo "<span>".t("use SMSGlobal")."</span>";
								?></li>
								<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="swift"?true:false
								,array(
								'class'=>"icheck",
								'value'=>'swift'
								));
								echo "<span>".t("use Swift SMS gateway")."</span>";
								?></li>
								<li><?php 
								echo CHtml::radioButton('sms_provider',
								Yii::app()->functions->getOptionAdmin('sms_provider')=="solutionsinfini"?true:false
								,array(
								'class'=>"icheck",
								'value'=>'solutionsinfini'
								));
								echo "<span>".t("use Solutionsinfini")."</span>";
								?></li>
							</ul>
						</div>
					</div>
					<hr/>
					<div class="twillio-logo"></div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Sender ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('sms_sender_id',
							Yii::app()->functions->getOptionAdmin('sms_sender_id')
							,array(
							'class'=>"form-control",
							//'data-validation'=>"required"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Account SID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('sms_account_id',
							Yii::app()->functions->getOptionAdmin('sms_account_id')
							,array(
							'class'=>"form-control",
							//'data-validation'=>"required"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","AUTH Token")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('sms_token',
							Yii::app()->functions->getOptionAdmin('sms_token')
							,array(
							'class'=>"form-control",
							//'data-validation'=>"required"
							))
							?>
						</div>
					</div>
					<p class="text-muted"><?php echo t("get your account on")?> <a target="_blank"a href="https://www.twilio.com/">https://www.twilio.com/</a></p>
					<hr/>
					<div class="nexmo-logo"></div>	
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Sender")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('nexmo_sender_id',
							Yii::app()->functions->getOptionAdmin('nexmo_sender_id')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('nexmo_key',
							Yii::app()->functions->getOptionAdmin('nexmo_key')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Secret")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('nexmo_secret',
							Yii::app()->functions->getOptionAdmin('nexmo_secret')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use CURL")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('nexmo_use_curl',
							Yii::app()->functions->getOptionAdmin('nexmo_use_curl')==1?true:false
							,array(
							'value'=>1,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use Unicode")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('nexmo_use_unicode',
							Yii::app()->functions->getOptionAdmin('nexmo_use_unicode')==1?true:false
							,array(
							'value'=>1,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<p class="text-muted"><?php echo t("get your account on")?> <a target="_blank"a href="https://www.nexmo.com/">https://www.nexmo.com/</a></p>
					<hr/>
					<div class="clickatel-logo"></div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('clickatel_user',
							Yii::app()->functions->getOptionAdmin('clickatel_user')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('clickatel_password',
							Yii::app()->functions->getOptionAdmin('clickatel_password')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Sender")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('clickatel_sender',
							Yii::app()->functions->getOptionAdmin('clickatel_sender')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","API ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('clickatel_api_id',
							Yii::app()->functions->getOptionAdmin('clickatel_api_id')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use CURL")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('clickatel_use_curl',
							Yii::app()->functions->getOptionAdmin('clickatel_use_curl')==1?true:false
							,array(
							'value'=>1,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use Unicode")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('clickatel_use_unicode',
							Yii::app()->functions->getOptionAdmin('clickatel_use_unicode')==1?true:false
							,array(
							'value'=>1,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<p class="text-muted"><?php echo t("get your account on")?> <a target="_blank"a href="https://www.clickatell.com/">https://www.clickatell.com/</a></p>
					<!--<h4 class="mt-0 header-title"><b><?php echo t("Private SMS")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Username")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('privatesms_username',
							Yii::app()->functions->getOptionAdmin('privatesms_username')
							,array(
							'value'=>1,
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('privatesms_password',
							Yii::app()->functions->getOptionAdmin('privatesms_password')
							,array(
							'value'=>1,
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Sender")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('privatesms_sender',
							Yii::app()->functions->getOptionAdmin('privatesms_sender')
							,array(
							'value'=>1,
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>-->
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("BHASHSMS")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('bhashsms_user',
							Yii::app()->functions->getOptionAdmin('bhashsms_user')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('bhashsms_pass',
							Yii::app()->functions->getOptionAdmin('bhashsms_pass')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Sender ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('bhashsms_senderid',
							Yii::app()->functions->getOptionAdmin('bhashsms_senderid')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SMS Type")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('bhashsms_smstype',Yii::app()->functions->getOptionAdmin('bhashsms_smstype'),array(
							'normal'=>t("normal"),
							'flash'=>t("flash"),
							'unicode'=>t("unicode"),
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Priority")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('bhashsms_priority',Yii::app()->functions->getOptionAdmin('bhashsms_priority'),array(
							'ndnd'=>t("ndnd"),
							'dnd'=>t("dnd")    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use CURL")?>?</label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::checkBox('bhashsms_use_curl',
							Yii::app()->functions->getOptionAdmin('bhashsms_use_curl')==1?true:false
							,array(
							'value'=>1,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("SMSGlobal")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Sender ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('smsglobal_senderid',
							Yii::app()->functions->getOptionAdmin('smsglobal_senderid')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","API username")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('smsglobal_username',
							Yii::app()->functions->getOptionAdmin('smsglobal_username')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","API password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('smsglobal_password',
							Yii::app()->functions->getOptionAdmin('smsglobal_password')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<p class="text-muted"><?php echo t("get your account on")?> <a target="_blank"a href="https://www.smsglobal.com/">https://www.smsglobal.com/</a></p>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Swift SMS Gateway")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Account Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('swift_accountkey',
							Yii::app()->functions->getOptionAdmin('swift_accountkey')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use CURL")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('swift_usecurl',
							Yii::app()->functions->getOptionAdmin('swift_usecurl')==2?true:false
							,array(
							'value'=>2,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<p class="text-muted"><?php echo t("get your account on")?> <a target="_blank"a href="http://smsgateway.ca">http://smsgateway.ca</a></p>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Solutionsinfini")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","API Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('solutionsinfini_apikey',
							Yii::app()->functions->getOptionAdmin('solutionsinfini_apikey')
							,array(
							'class'=>"uk-form-width-large"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Sender ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('solutionsinfini_sender',
							Yii::app()->functions->getOptionAdmin('solutionsinfini_sender')
							,array(
							'class'=>"form-control"    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use CURL")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('solutionsinfini_usecurl',
							Yii::app()->functions->getOptionAdmin('solutionsinfini_usecurl')==2?true:false
							,array(
							'value'=>2,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Use Unicode")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('solutionsinfini_useunicode',
							Yii::app()->functions->getOptionAdmin('solutionsinfini_useunicode')==2?true:false
							,array(
							'value'=>2,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<p class="text-muted"><?php echo t("get your account on")?> <a target="_blank"a href="http://solutionsinfini.com/">http://solutionsinfini.com/</a></p>
					<hr/>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-2">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
						<div class="col-lg-2">
							<a href="javascript:;" class="btn btn-default btn-block test-sms"><?php echo t("Test SMS")?></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
