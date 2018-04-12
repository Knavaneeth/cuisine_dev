<div class="row">
	<div class="col-sm-12">
		<div class="card-box panel">
			<div class="panel-body">
				<form class="form-horizontal admin-settings-page forms" id="forms">
					<?php echo CHtml::hiddenField('action','emailTplSettings')?>
					<?php 
					$email_tpl_activation=Yii::app()->functions->getOptionAdmin('email_tpl_activation');
					if (empty($email_tpl_activation)){	
						$email_tpl_activation=EmailTPL::merchantActivationCodePlain();
					}

					$email_tpl_forgot=Yii::app()->functions->getOptionAdmin('email_tpl_forgot');
					if (empty($email_tpl_forgot)){		
						$email_tpl_forgot=EmailTPL::merchantForgotPassPlain();
					}
					?>
					<h4 class="mt-0 header-title"><b><?php echo t("customer welcome email template")?></b></h4>
					<div class="form-group">
						<div class="col-lg-6">
							<?php echo CHtml::textField('email_tpl_customer_subject',
							getOptionA('email_tpl_customer_subject'),array(
							'class'=>"form-control",
							"placeholder"=>t("Email Subject")
							))?>
						</div>
						<div class="col-lg-12">
							<?php  
							echo CHtml::textArea('email_tpl_customer_reg',
							getOptionA('email_tpl_customer_reg'),
							array(
							'class'=>"big-textarea form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Available Tags")?>:</label> 
						<div class="col-lg-10"> 
							<ul class="tag-list">
								<li class="uk-badge"><?php echo t("{website_name}")?></li>
								<li class="uk-badge"><?php echo t("{client_name}")?></li>
								<li class="uk-badge"><?php echo t("{email_address}")?></li>
							</ul>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("merchant activation email template")?></b></h4>
					<div class="form-group">
						<div class="col-lg-12">
							<?php 
							echo CHtml::textArea('email_tpl_activation',
							$email_tpl_activation,
							array(
							'class'=>"big-textarea form-control"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Available Tags")?>:</label> 
						<div class="col-lg-10"> 
							<ul class="tag-list">
								<li class="uk-badge"><?php echo t("{restaurant_name}")?></li>
								<li class="uk-badge"><?php echo t("{activation_key}")?></li>
								<li class="uk-badge"><?php echo t("{website_title}")?></li>
								<li class="uk-badge"><?php echo t("{website_url}")?></li>
							</ul>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("merchant forgot password email template")?></b></h4>
					<div class="form-group">
						<div class="col-lg-12">
							<?php 
							echo CHtml::textArea('email_tpl_forgot',
							$email_tpl_forgot,
							array(
							'class'=>"big-textarea"    
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo t("Available Tags")?>:</label> 
						<div class="col-lg-10"> 
							<ul class="tag-list">
								<li class="uk-badge"><?php echo t("{restaurant_name}")?></li>
								<li class="uk-badge"><?php echo t("{website_title}")?></li>
								<li class="uk-badge"><?php echo t("{verification_code}")?></li>
							</ul>
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