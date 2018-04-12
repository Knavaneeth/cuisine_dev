<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','adminSocialSettings')?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Default Share text")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textArea('default_share_text',getOptionA('default_share_text'),array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<p class="uk-text-muted" style="margin-left:200px;"><?php echo t("Available tags {merchant-name}")?></p>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Disabled Social Icon")?>?</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('social_flag',yii::app()->functions->getOptionAdmin('social_flag'),
							array('value'=>1,'class'=>"icheck"))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Disabled restaurant share")?>?</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('admin_merchant_share',yii::app()->functions->getOptionAdmin('admin_merchant_share'),
							array('value'=>1,'class'=>"icheck"))?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t('default',"Facebook")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Disabled Facebook Login")?>?</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('fb_flag',yii::app()->functions->getOptionAdmin('fb_flag'),
							array('value'=>1,'class'=>"icheck"))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"App ID")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('fb_app_id',yii::app()->functions->getOptionAdmin('fb_app_id'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"App Secret")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('fb_app_secret',yii::app()->functions->getOptionAdmin('fb_app_secret'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Facebook Page URL")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('admin_fb_page',yii::app()->functions->getOptionAdmin('admin_fb_page'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t('default',"Twitter")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Twitter Page URL")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('admin_twitter_page',yii::app()->functions->getOptionAdmin('admin_twitter_page'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t('default',"Google")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Google Page URL")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('admin_google_page',yii::app()->functions->getOptionAdmin('admin_google_page'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Enabled Google Login")?>?</label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('google_login_enabled',yii::app()->functions->getOptionAdmin('google_login_enabled'),
							array('value'=>2,'class'=>"icheck"))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Client ID")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('google_client_id',
							yii::app()->functions->getOptionAdmin('google_client_id'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Client Secret")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('google_client_secret',
							yii::app()->functions->getOptionAdmin('google_client_secret'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<?php 
					$redirect_url=yii::app()->functions->getOptionAdmin('google_client_redirect_ulr');
					if (empty($redirect_url)){
						$redirect_url=websiteUrl()."/store/GoogleLogin";
					}
					?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Redirect Url")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('google_client_redirect_ulr',
							$redirect_url,array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<p class="uk-text-muted uk-text-small">
					<?php echo t("Redirect URL Must equal to")." ".websiteUrl()."/store/GoogleLogin"?><br>
					<?php echo t("Set this url to your google developer settings")?>
					</p>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t('default',"Instagram")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Instagram Page URL")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('admin_intagram_page',getOptionA('admin_intagram_page'),array(
							'class'=>"form-control"
							))?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t('default',"Youtube Channel")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Youtube Channel URL")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('admin_youtube_url',getOptionA('admin_youtube_url'),array(
							'class'=>"form-control"
							))?>
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