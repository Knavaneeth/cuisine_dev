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

echo CHtml::hiddenField('mobile_country_code',Yii::app()->functions->getAdminCountrySet(true));
?>
<div class="page-content order-progress-page">
	<div class="container">
		<div class="row step2-row">  
			<div class="col-md-8 col-sm-8 col-xs-7 col-lg-8">
				<div class="white-box-shadow">
				<?php if (is_array($data) && count($data)>=1):?>
					<form class="forms form-horizontal" id="forms" onsubmit="return false;">
					<?php echo CHtml::hiddenField('action','merchantSignUp')?>
					<?php echo CHtml::hiddenField('currentController','store')?>
					<?php echo CHtml::hiddenField('package_id',$data['package_id'])?>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Selected Package")?></div>
							<div class="col-md-9 bold"><?php echo $data['title']?></div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Price")?></div>
							<div class="col-md-9 bold">
								<?php if ( $data['promo_price']>=1):?>
									<span class="strike-price"><?php echo FunctionsV3::prettyPrice($data['price'])?></span>
									<?php echo FunctionsV3::prettyPrice($data['promo_price'])?> 
								<?php else :?>
									<?php echo FunctionsV3::prettyPrice($data['price'])?> 
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Membership Limit")?></div>
							<div class="col-md-9 bold">
								<?php if ( $data['expiration_type']=="year"):?>
									<?php echo $data['expiration']/365?> <?php echo Yii::t("default",ucwords($data['expiration_type']))?>
								<?php else :?>
									<?php echo $data['expiration']?> <?php echo Yii::t("default",ucwords($data['expiration_type']))?>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3"><?php echo t("Usage")?></div>
							<div class="col-md-9 bold">
								<?php if ( $data['unlimited_post']==2):?>
									<?php echo $limit_post[$data['unlimited_post']]?>
								<?php else :?>
									<?php echo $limit_post[$data['unlimited_post']] . " (".$data['post_limit']." item )"?>
								<?php endif;?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label"><?php echo t("Restaurant name")?></label>
							<div class="col-lg-9">
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
								'class'=>'form-control mobile_inputs',
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
							<div class="col-md-3"><?php echo t("Parish")?></div>
							<div class="col-md-9">
								<?php echo CHtml::dropDownList('Parish',
								getOptionA('Parish'),
								(array)Yii::app()->functions->ParishListMerchant(),          
								array(
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
							<div class="col-md-3"><?php echo t("Post code")?></div>
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
								<?php 
								$cuisine_list=Yii::app()->functions->Cuisine(true);
								$cuisine_1='';
								if ( Yii::app()->functions->multipleField()==2){
									foreach ($cuisine_list as $cuisine_id=>$val) {
									   $cuisine_info=Yii::app()->functions->GetCuisine($cuisine_id);
									   $cuisine_json['cuisine_name_trans']=!empty($cuisine_info['cuisine_name_trans'])?
									   json_decode($cuisine_info['cuisine_name_trans'],true):'';
									   $cuisine_1[$cuisine_id]=qTranslate($val,'cuisine_name',$cuisine_json);
									}
									$cuisine_list=$cuisine_1;
								}
								echo CHtml::dropDownList('cuisine[]',
								isset($data['cuisine'])?(array)json_decode($data['cuisine']):"",
								(array)$cuisine_list,          
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
						<?php if ($kapcha_enabled==2):?>      
							<div class="form-group">    
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div id="kapcha-1"></div>
								</div>
							</div>
						<?php endif;?>
      
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
						<div class="form-group">
							<div class="col-md-3"></div>
							<div class="col-md-4">
								<input type="submit" value="<?php echo t("Next")?>" class="btn btn-primary btn-block">
							</div>
						</div>
					</form>
					<?php else :?>
						<div class="text-danger alert alert-danger"><?php echo t("Sorry but we cannot find what you are looking for.")?></div>
					<?php endif;?>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-5 col-lg-4 rightsidebar">
			   <div class="white-box-shadow" id="change-package-wrap">
					<?php 
					$p_list='';
					if (is_array($package_list) && count($package_list)>=1){
						foreach ($package_list as $val) {
							$p_list[$val['package_id']]=$val['title'];
						}
					}    
					echo CHtml::hiddenField('change_package_url',
						Yii::app()->createUrl('/store/merchantsignup?do=step2&package_id=')
					) ;
					?>
					<?php FunctionsV3::sectionHeader('Change Package');?>
					<div class="form-group">
						<?php 
						echo CHtml::dropDownList('change_package',
						isset($_GET['package_id'])?$_GET['package_id']:''
						,(array)$p_list,array(
						'class'=>'form-control',
						));
						?>          
					</div>
					<h3 class="title-1 text-center">Or</h3>
					<div class="text-center">
						<a href="<?php echo Yii::app()->createUrl('/store/merchantsignup')?>" class="btn btn-primary btn-block">
							<?php echo t("Back")?>
						</a>
					</div>
			   </div>
			</div>
		</div>
	</div>
</div>