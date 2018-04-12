<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Restaurant Signup"),
   'sub_text'=>t("step 2 of 4")
));

/*PROGRESS ORDER BAR*/
$this->renderPartial('/front/progress-merchantsignup',array(
   'step'=>2,
   'show_bar'=>true
));

?>
<div class="page-content">
	<div class="container">
		<div class="row">  
			<div class="col-md-8">
				<div class="white-box-shadow">
					<form class="forms form-horizontal" id="forms" onsubmit="return false;">
						<?php echo CHtml::hiddenField('action','merchantSignUp2')?>
						<?php echo CHtml::hiddenField('currentController','store')?>	 
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Restaurant name")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('restaurant_name',
								isset($data['restaurant_name'])?$data['restaurant_name']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>
							</div>
						</div>
						<?php if ( getOptionA('merchant_reg_abn')=="yes"):?>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("ABN")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('abn',
								isset($data['restaurant_name'])?$data['abn']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>
							</div>
						</div>
						<?php endif;?>      
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Restaurant phone")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('restaurant_phone',
								isset($data['restaurant_phone'])?$data['restaurant_phone']:""
								,array(
								'class'=>'form-control',
								))?>    
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Contact name")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('contact_name',
								isset($data['contact_name'])?$data['contact_name']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Contact phone")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('contact_phone',
								isset($data['contact_phone'])?$data['contact_phone']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Contact email")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('contact_email',
								isset($data['contact_email'])?$data['contact_email']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"email"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<p class="text-muted text-small"><?php echo t("Important: Please enter your correct email. we will sent an activation code to your email")?></p>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Street address")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('street',
								isset($data['street'])?$data['street']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("City")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('city',
								isset($data['city'])?$data['city']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Post code/Zip code")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('post_code',
								isset($data['post_code'])?$data['post_code']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Country")?></div>
							<div class="col-md-9">
								<?php echo CHtml::dropDownList('country_code',
								getOptionA('merchant_default_country'),
								(array)Yii::app()->functions->CountryListMerchant(),          
								array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("State/Region")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('state',
								isset($data['state'])?$data['state']:""
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Cuisine")?></div>
							<div class="col-md-9">
								<?php echo CHtml::dropDownList('cuisine[]',
								isset($data['cuisine'])?(array)json_decode($data['cuisine']):"",
								(array)Yii::app()->functions->Cuisine(true),          
								array(
								'class'=>'form-control chosen',
								'multiple'=>true,
								'data-validation'=>"required"  
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Services Pick Up or Delivery?")?></div>
							<div class="col-md-9">
								<?php echo CHtml::dropDownList('service',
								isset($data['service'])?$data['service']:"",
								(array)Yii::app()->functions->Services(),          
								array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div>
							<?php FunctionsV3::sectionHeader('Login Information');?>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Username")?></div>
							<div class="col-md-9">
								<?php echo CHtml::textField('username',
								''
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Password")?></div>
								<div class="col-md-9">
								<?php echo CHtml::passwordField('password',
								''
								,array(
								'class'=>'form-control',
								'data-validation'=>"required"
								))?>           
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Confirm Password")?></div>
							<div class="col-md-9">
							<?php echo CHtml::passwordField('cpassword',
							''
							,array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?>           
							</div>
						</div>
						<?php if ( $terms_merchant=="yes"):?>
						<?php $terms_link=Yii::app()->functions->prettyLink($terms_merchant_url);?>
						<div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<?php 
								echo CHtml::checkBox('terms_n_condition',false,array(
								'value'=>2,
								'class'=>"",
								'data-validation'=>"required"
								));
								echo " ". t("I Agree To")." <a href=\"$terms_link\" target=\"_blank\">".t("The Terms & Conditions")."</a>";
								?>  
							</div>
						</div>
						<?php endif;?>
						<?php if ($kapcha_enabled==2):?>
						<div class="form-group">    
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<div id="kapcha-1"></div>
							</div>
						</div>
						<?php endif;?>
						<div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-4">
								<input type="submit" value="<?php echo t("Next")?>" class="btn btn-primary btn-block">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>