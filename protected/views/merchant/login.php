<div class="login_wrap">
<div class="admin-logo"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/logo.png" class="img-responsive" alt="" width="300" height="123"></div>
	<div class="panel login-form">

   <?php $name=Yii::app()->functions->getOptionAdmin('website_title');?>
   
   <h3 class="uk-h3"><?php echo !empty($name)?$name:"";?> <?php echo Yii::t("default","Restaurant Administration")?></h3>   
     
   <form id="forms" class="uk-form forms" onsubmit="return false;" method="POST">   
   <?php echo CHtml::hiddenField("action",'merchantLogin')?>
   <?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/merchant")?>
   
   
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
   
   <?php if (getOptionA('captcha_merchant_login')==2):?>
   <?php GoogleCaptcha::displayCaptcha()?>
   <?php endif;?>
   
   <div class="form-group">  
   <button class="btn btn-primary btn-block"><?php echo Yii::t("default","Sign In")?></button>
   </div>
   
   <p><a href="javascript:;" class="mt-fp-link"><?php echo Yii::t("default","Forgot Password")?>?</a></p>

  <div class="alert alert-danger">
    <strong> Warning box: </strong> This is a very powerful tool to change your menu settings. Please use it with caution. Do not share password and unauthorized access is illegal.
  </div>
   
   </form>
   
   <form id="mt-frm" class="uk-form mt-frm" onsubmit="return false;" method="POST">   
   <?php echo CHtml::hiddenField("action",'merchantForgotPass')?>
   <h4><?php echo Yii::t("default","Forgot Password")?></h4>
   
   <div class="form-group">
       <?php echo CHtml::textField('email_address','',array('class'=>"form-control",'placeholder'=>Yii::t("default","Email address"),
       'data-validation'=>"required"
       ));?>
   </div>   
      
   <div class="form-group">  
   <button class="btn btn-primary btn-block"><?php echo Yii::t("default","Submit")?></button>
   </div>
   
   <p><a href="javascript:;" class="mt-login-link"><?php echo Yii::t("default","Login")?></a></p>
   
   </form>
   
   
   <form id="mt-frm-activation" class="uk-form mt-frm-activation" onsubmit="return false;" method="POST">   
   <?php echo CHtml::hiddenField("action",'merchantChangePassword')?>
   <?php echo CHtml::hiddenField("email",'')?>
   <h4><?php echo Yii::t("default","Enter Verification Code & Your New Password")?></h4>
   
   <div class="form-group">
       <?php echo CHtml::textField('lost_password_code','',array('class'=>"form-control",'placeholder'=>Yii::t("default","Code"),
       'data-validation'=>"required"
       ));?>
   </div>
   <div class="form-group">
       <?php echo CHtml::passwordField('new_password','',array('class'=>"form-control",'placeholder'=>Yii::t("default","New Password"),
       'data-validation'=>"required"
       ));?>
   </div>   
    
   <div class="form-group">
   <button class="btn btn-primary btn-block"><?php echo Yii::t("default","Submit")?> <i class="uk-icon-chevron-circle-right"></i></button>
   </div>
    
   <p><a href="javascript:;" class="mt-login-link"><?php echo Yii::t("default","Login")?></a></p>
   
   </form>
   
   
</div>
</div> <!--END login_wrap-->