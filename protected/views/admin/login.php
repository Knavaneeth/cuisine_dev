<div class="login_wrap">
	<div class="admin-logo"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/logo.png" class="img-responsive" alt="" width="300" height="123"></div>
	<div class="panel login-form">
		<?php $name=Yii::app()->functions->getOptionAdmin('website_title');?>
		<h3 class="uk-h3"><?php echo !empty($name)?$name:"Admin";?> <?php echo Yii::t("default","Administration")?></h3>   
		<form id="forms" class="forms" onsubmit="return false;" method="POST">   
			<?php echo CHtml::hiddenField("action",'login')?>
			<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin")?>
			<?php if (isset($_GET['message'])):?>
			<p class="uk-text-danger"><?php echo $_GET['message']?></p>
			<?php endif;?>
			<div class="form-group">
				<?php echo CHtml::textField('username','',array('class'=>"form-control",'placeholder'=>Yii::t("default","Username"),
				'data-validation'=>"required"
				));?>
			</div>
			<div class="form-group">
				<?php echo CHtml::passwordField('password','',array('class'=>"form-control",'placeholder'=>Yii::t("default","Password"),
				'data-validation'=>"required"
				));?>
			</div>
			<?php if (getOptionA('captcha_admin_login')==2):?>
			<?php GoogleCaptcha::displayCaptcha()?>
			<?php endif;?>
			<div class="form-group">
				<button class="btn btn-primary btn-block"><?php echo Yii::t("default","Signin")?></button>
			</div>
			<p><a href="javascript:;" class="mt-fp-link"><?php echo Yii::t("default","Forgot Password")?>?</a></p>
		</form>
		<form id="mt-frm" class="mt-frm" onsubmit="return false;" method="POST">   
			<?php echo CHtml::hiddenField("action",'adminForgotPass')?>
			<h4><?php echo Yii::t("default","Forgot Password")?></h4>
			<div class="form-group">
				<?php echo CHtml::textField('email_address','',array('class'=>"form-control",'placeholder'=>Yii::t("default","Email address"),
				'data-validation'=>"required"
				));?>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-block"><?php echo Yii::t("default","Signin")?></button>
			</div>
			<p><a href="javascript:;" class="mt-login-link"><?php echo Yii::t("default","Login")?></a></p>
		</form>
	</div>
</div>