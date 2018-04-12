<?php
$this->renderPartial('/front/default-header',array(
   'h1'=>t("Forgot Password"),
	'sub_text'=>t("Enter password details")
));?>
<div class="page-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<div class="well-box">
					<h2 class="block-title-2"><?php echo t("Forgot Password")?></h2>

					<form class="forms forgot-password" id="forms" onsubmit="return false;">
						<?php echo CHtml::hiddenField('action','changePassword')?>
						<?php echo CHtml::hiddenField('token',$_GET['token'])?>
						<?php echo CHtml::hiddenField('currentController','store')?>
						<?php echo CHtml::hiddenField('base_url','http://www.cuisine.je')?>
						<div class="form-group">
							<?php 
							echo CHtml::passwordField('password',''  
							,array('class'=>'form-control password_text',
							'placeholder'=>t("Password"),
						   'required'=>true,
						    //'minlength'=>"5" 
						   	    'data-validation'=>"length",
						     'data-validation-length'=>"min8"
						   ))
							?>
						</div>
						<div class="form-group">
							<?php 
							echo CHtml::passwordField('confirm_password',''  
							,array('class'=>'form-control cpassword_text',
							'placeholder'=>t("Confirm Password"),
						    'required'=>true,
						        'data-validation'=>"length",
						     'data-validation-length'=>"min8"
						    ))
							?>
						</div>
						<div class="form-group mb-0">
							<input type="submit" value="<?php echo t("Submit")?>" class="btn btn-primary">
						</div>
					</form>
				</div>  
			</div>
		</div>
	</div>
</div>