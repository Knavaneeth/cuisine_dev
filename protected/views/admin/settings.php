<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal admin-settings-page forms" id="forms">
					<?php echo CHtml::hiddenField('action','adminSettings')?>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Website")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Title")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('website_title',
							Yii::app()->functions->getOptionAdmin('website_title'),
							array(
							'class'=>"form-control",
							'placeholder'=>"Title of the website"
							))
							?> 
						</div>
					</div>
					<?php 
					$country_list=require_once "CountryCode.php";
					$country_list2=$country_list;
					//array_unshift($country_list2,t("All"));

					$merchant_specific_country=Yii::app()->functions->getOptionAdmin('merchant_specific_country');
					if (!empty($merchant_specific_country)){
						$merchant_specific_country=json_decode($merchant_specific_country);
					}
					?>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Desktop Website Logo")?></label>
						<div class="col-lg-6">
							<div style="display:inline-table;margin-left:1px;" class="button uk-button" id="photo"><?php echo Yii::t('default',"Browse")?></div>	  
							<div  style="display:none;" class="photo_chart_status" >
								<div id="percent_bar" class="photo_percent_bar"></div>
								<div id="progress_bar" class="photo_progress_bar">
									<div id="status_bar" class="photo_status_bar"></div>
								</div>
							</div>
						<p class="text-muted"><?php echo Yii::t("default","Desktop Website logo")?> 352x139</p>
						</div>
					</div>
					<?php $website_logo=Yii::app()->functions->getOptionAdmin('website_logo');?>
					<?php if (!empty($website_logo)):?>
					<div class="form-group"> 
					<?php else :?>
					<div class="input_block preview form-group">
						<?php endif;?>
						<label class="col-lg-3"><?php echo Yii::t('default',"Preview")?></label>
						<div class="image_preview col-lg-6">
						<?php if (!empty($website_logo)):?>
						<input type="hidden" name="photo" value="<?php echo $website_logo;?>">
						<img id="logo-small" class="img-thumbnail" src="<?php echo Yii::app()->request->baseUrl."/upload/".$website_logo;?>?>">
						<p><a href="javascript:rm_preview();"><?php echo Yii::t("default","Remove image")?></a></p>
						<?php endif;?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Mobile Website Logo")?></label>
						<div class="col-lg-6">
							<div style="display:inline-table;margin-left:1px;" class="button uk-button" id="mobilelogo"><?php echo Yii::t('default',"Browse")?></div>	  
							<div  style="display:none;" class="mobilelogo_chart_status" >
								<div id="percent_bar" class="mobilelogo_percent_bar"></div>
								<div id="progress_bar" class="mobilelogo_progress_bar">
									<div id="status_bar" class="mobilelogo_status_bar"></div>
								</div>
							</div>
							<p class="text-muted"><?php echo Yii::t("default","Mobile Website logo")?> 342x129</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"></label>
						<div class="col-lg-6">
							<div class="MobileLogoPreview">
							<?php $mobilelogo=getOptionA('mobilelogo');?>
							<?php if (!empty($mobilelogo)):?>
							<img id="logo-small" class="img-thumbnail" src="<?php echo uploadURL()."/$mobilelogo"?>">
							<p><a href="javascript:rmMobileLogo();"><?php echo Yii::t("default","Remove image")?></a></p>
							<?php echo CHtml::hiddenField('mobilelogo',$mobilelogo)?>
							<?php endif;?>
							</div>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Google API Key")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Geocoding API Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('google_geo_api_key',
							Yii::app()->functions->getOptionAdmin('google_geo_api_key'),array(
							'class'=>"form-control"    
							));
							?>
							<p class="small text-muted">
								<span style="color:red;"><?php echo t("Note")?>:</span>
								<?php echo t("these section is now mandatory in order for your search functions will work 100%")?><br/>
								<?php echo t("enabled Google Maps Distance Matrix API, Google Maps Geocoding API and Google Maps JavaScript API in your google developer account")?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Method of distance calculation")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('google_distance_method',getOptionA('google_distance_method'),array(
							'straight_line'=>t("Straight line"),
							'driving'=>t("Driving"),
							'transit'=>t("Transit"),
							),array(
							'class'=>"form-control",
							));
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Use CURL")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('google_use_curl',
							Yii::app()->functions->getOptionAdmin('google_use_curl')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>  
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Google Recaptcha Settings")?></b></h4>
					<p class="small text-muted"><?php echo t("These section is optional")?></p>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Site Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('captcha_site_key',
							Yii::app()->functions->getOptionAdmin('captcha_site_key')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Secret Key")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('captcha_secret',
							Yii::app()->functions->getOptionAdmin('captcha_secret')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Language")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('captcha_lang',
							Yii::app()->functions->getOptionAdmin('captcha_lang')
							,array(
							'class'=>"form-control"
							));  
							?>
							<span class="text-muted"><?php echo t("default is = en");?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enable Customer signup")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('captcha_customer_signup',
							Yii::app()->functions->getOptionAdmin('captcha_customer_signup')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enable Merchant signup")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('captcha_merchant_signup',
							Yii::app()->functions->getOptionAdmin('captcha_merchant_signup')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>   
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enable Customer login")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('captcha_customer_login',
							Yii::app()->functions->getOptionAdmin('captcha_customer_login')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>    
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enable Merchant login")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('captcha_merchant_login',
							Yii::app()->functions->getOptionAdmin('captcha_merchant_login')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>     
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enable Admin login")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('captcha_admin_login',
							Yii::app()->functions->getOptionAdmin('captcha_admin_login')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>    
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enable Order")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('captcha_order',
							Yii::app()->functions->getOptionAdmin('captcha_order')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>     
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Customer popup address options")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled popup asking customer address")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('customer_ask_address',
							Yii::app()->functions->getOptionAdmin('customer_ask_address')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>      
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Merchant change order options")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled send sms/email after change order")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('merchant_changeorder_sms',
							Yii::app()->functions->getOptionAdmin('merchant_changeorder_sms')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>       
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Table Booking")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('merchant_tbl_book_disabled',
							Yii::app()->functions->getOptionAdmin('merchant_tbl_book_disabled')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>     
						</div>
					</div>
					<hr/>
					<!--
					<h2><?php echo Yii::t("default","View Restaurant by map options")?></h2>
					<div class="uk-form-row">
					  <label class="uk-form-label"><?php echo Yii::t("default","Disabled")?>?</label>  
					  <?php 
					  echo CHtml::checkBox('view_map_disabled',
					   Yii::app()->functions->getOptionAdmin('view_map_disabled')==2?true:false
					   ,array(
					   'class'=>"icheck",
					   'value'=>2
					  ))
					  ?>  
					</div>
					<div class="uk-form-row">
					  <label class="uk-form-label"><?php echo Yii::t("default","Map Default zoom")?></label>  
					  <?php 
					  echo CHtml::textField('view_map_default_zoom',getOptionA('view_map_default_zoom'),array(
						'class'=>"numeric_only"
					  ));
					  ?>
					  <span class="uk-text-muted"><?php echo t("default is 5")?></span>
					</div>  
					<div class="uk-form-row">
					  <label class="uk-form-label"><?php echo Yii::t("default","Map Default zoom after search")?></label>  
					  <?php 
					  echo CHtml::textField('view_map_default_zoom_s',getOptionA('view_map_default_zoom_s'),array(
						'class'=>"numeric_only"
					  ));
					  ?>
					  <span class="uk-text-muted"><?php echo t("default is 12")?></span>
					</div>  -->
					<!--<hr/>-->
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Receipt Options")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Default email subject")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('receipt_default_subject',
							getOptionA('receipt_default_subject'),array(
							'class'=>"form-control"
							))?>    
							<p class="text-muted"><?php echo t("the default receipt subject when someone purchase")?></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled logo on receipt")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_enabled_rcpt',
							Yii::app()->functions->getOptionAdmin('website_enabled_rcpt')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Receipt Logo")?></label>
						<div class="col-lg-6">
							<div style="display:inline-table;margin-left:1px;" class="button uk-button" id="rphoto"><?php echo Yii::t('default',"Browse")?></div>	  
							<div  style="display:none;" class="rphoto_chart_status" >
								<div id="percent_bar" class="rphoto_percent_bar"></div>
								<div id="progress_bar" class="rphoto_progress_bar">
									<div id="status_bar" class="rphoto_status_bar"></div>
								</div>
							</div>
						</div>
					</div>
					<?php $website_receipt_logo=Yii::app()->functions->getOptionAdmin('website_receipt_logo');?>
					<?php if (!empty($website_receipt_logo)):?>
					<div class="form-group"> 
					<?php else :?>
					<div class="input_block rc_preview form-group">
						<?php endif;?>
						<label class="col-lg-3"><?php echo Yii::t('default',"Preview")?></label>
						<div class="rc_image_preview col-lg-6">
						<?php if (!empty($website_receipt_logo)):?>
						<input type="hidden" name="website_receipt_logo" value="<?php echo $website_receipt_logo;?>">
						<img class="uk-thumbnail rc_logo" src="<?php echo Yii::app()->request->baseUrl."/upload/".$website_receipt_logo;?>?>" alt="" title="">
						<p><a href="javascript:rc_rm_preview();"><?php echo Yii::t("default","Remove image")?></a></p>
						<?php endif;?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Login & Signup")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Popup")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_disabled_login_popup',
							Yii::app()->functions->getOptionAdmin('website_disabled_login_popup')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?> 
						</div>
					</div>
					<p class="text-muted small"><?php echo t("disbaled popup instead use a page");?></p>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled Mobile Verification")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_enabled_mobile_verification',
							Yii::app()->functions->getOptionAdmin('website_enabled_mobile_verification')=="yes"?true:false
							,array(
							'class'=>"icheck website_enabled_mobile_verification",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled Email Verification")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_enabled_email_verification',
							Yii::app()->functions->getOptionAdmin('theme_enabled_email_verification')==2?true:false
							,array(
							'class'=>"icheck theme_enabled_email_verification",
							'value'=>2
							))
							?>  
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Registration custom fields")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Add New Custom Field")?></label>
						<div class="col-lg-6">
							<?php   
							echo CHtml::textField('client_custom_field_name1',
							Yii::app()->functions->getOptionAdmin('client_custom_field_name1')
							,array(
							'class'=>"form-control",
							'placeholder'=>t("Field name")
							));
							?>   
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Add New Custom Field")?></label>
						<div class="col-lg-6">
							<?php   
							echo CHtml::textField('client_custom_field_name2',
							Yii::app()->functions->getOptionAdmin('client_custom_field_name2'),
							array(
							'class'=>"form-control",
							'placeholder'=>t("Field name")
							));
							?>  
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Block email address list")?></b></h4>
 					<div class="form-group">
						<div class="col-lg-9">
							<?php 
							echo CHtml::textArea('blocked_email_add',getOptionA('blocked_email_add'),array(
							   'class'=>"form-control"
							))?>
						</div>
					</div>
					<p class="text-muted"><?php echo t("Multiple email separated by comma")?></p>
					<h4 class="mt-0 header-title"><b><?php echo t("Block mobile number list")?></b></h4>
 					<div class="form-group">
						<div class="col-lg-9">
							<?php 
							echo CHtml::textArea('blocked_mobile',getOptionA('blocked_mobile'),array(
							   'class'=>"form-control"
							))?>
						</div>
					</div>
					<p class="text-muted"><?php echo t("Multiple mobile separated by comma")?></p>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Terms and Conditions")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled On Merchant Signup")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_terms_merchant',
							Yii::app()->functions->getOptionAdmin('website_terms_merchant')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
 					<div class="form-group url_1">
						<label class="col-lg-3"><?php echo Yii::t("default","URL Link")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('website_terms_merchant_url',
							Yii::app()->functions->getOptionAdmin('website_terms_merchant_url'),array(
							'class'=>"form-control"
							));
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled On Customer Signup")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_terms_customer',
							Yii::app()->functions->getOptionAdmin('website_terms_customer')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
 					<div class="form-group url_2">
						<label class="col-lg-3"><?php echo Yii::t("default","URL Link")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('website_terms_customer_url',
							Yii::app()->functions->getOptionAdmin('website_terms_customer_url'),array(
							'class'=>"form-control"
							));
							?>   
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Reviews")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Allow only those who has actual purchases")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_reviews_actual_purchase',
							Yii::app()->functions->getOptionAdmin('website_reviews_actual_purchase')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>   
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Merchant can edit review or delete")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('merchant_can_edit_reviews',
							Yii::app()->functions->getOptionAdmin('merchant_can_edit_reviews')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Website Security")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Admin Do Not Allow User Multiple Sigin")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_admin_mutiple_login',
							Yii::app()->functions->getOptionAdmin('website_admin_mutiple_login')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Merchant Do Not Allow User Multiple Sigin")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_merchant_mutiple_login',
							Yii::app()->functions->getOptionAdmin('website_merchant_mutiple_login')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Guest Checkout")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Guest Checkout")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_disabled_guest_checkout',
							Yii::app()->functions->getOptionAdmin('website_disabled_guest_checkout')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
					<!--<h2><?php echo t("Spicy Dish")?></h2>

					<div class="uk-form-row"> 
					 <label class="uk-form-label"><?php echo Yii::t('default',"Upload Spicy Dish Icon")?></label>
					  <div style="display:inline-table;margin-left:1px;" class="button uk-button" id="spicydish"><?php echo Yii::t('default',"Browse")?></div>	  
					  <DIV  style="display:none;" class="spicydish_chart_status" >
						<div id="percent_bar" class="spicydish_percent_bar"></div>
						<div id="progress_bar" class="spicydish_progress_bar">
						  <div id="status_bar" class="spicydish_status_bar"></div>
						</div>
					  </DIV>		  
					</div>

					<?php $spicydish=Yii::app()->functions->getOptionAdmin('spicydish');?>
					<?php if (!empty($spicydish)):?>
					<div class="uk-form-row"> 
					<?php else :?>
					<div class="input_block preview_spicydish">
					<?php endif;?>
					<label><?php echo Yii::t('default',"Preview")?></label>
					<div class="image_preview_spicydish">
					 <?php if (!empty($spicydish)):?>
					 <input type="hidden" name="spicydish" value="<?php echo $spicydish;?>">
					 <img class="uk-thumbnail" src="<?php echo Yii::app()->request->baseUrl."/upload/".$spicydish;?>?>" alt="" title="">
					 <p><a href="javascript:rm_spicydish_preview();"><?php echo Yii::t("default","Remove image")?></a></p>
					 <?php endif;?>
					</div>
					</div>-->

					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Website Timezone")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Time Zone")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('website_timezone',
							Yii::app()->functions->getOptionAdmin("website_timezone")
							,Yii::app()->functions->timezoneList(),          
							array(
							'class'=>'form-control'
							))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Date Format")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('website_date_format',
							Yii::app()->functions->getOptionAdmin("website_date_format")
							,array(
							'class'=>'form-control',
							'placeholder'=>"M d,Y",
							"maxlength"=>20
							));
							echo " ".t("Default")." M d,Y"
							?>
							<p class="text-muted small"><?php echo t("Note: must be a valid php date format")?><br/><a target="_blank" href="http://php.net/manual/en/function.date.php">http://php.net/manual/en/function.date.php</a></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Time Format")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('website_time_format',
							Yii::app()->functions->getOptionAdmin("website_time_format")
							,array(
							'class'=>'form-control',
							'placeholder'=>"G:i:s",
							"maxlength"=>20
							));
							echo " ".t("Default")." G:i:s"
							?>
							<p class="text-muted small"><?php echo t("Note: must be a valid php time format")?> <br/><a target="_blank" href="http://php.net/manual/en/function.date.php">http://php.net/manual/en/function.date.php</a></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Date Picker Format")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('website_date_picker_format',
							Yii::app()->functions->getOptionAdmin("website_date_picker_format")
							,array(
							'yy-mm-dd'=>"yy-mm-dd - default",
							'mm-dd-yy'=>"mm-dd-yy",
							'dd-mm-yy'=>"dd-mm-yy",
							'yy-M-d'=>"yy-M-d",
							'M dd,yy'=>"M d, Y",
							),array(
							'class'=>"form-control",
							));
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Time Picker Format")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('website_time_picker_format',
							Yii::app()->functions->getOptionAdmin("website_time_picker_format")
							,array(
							'24'=>t("24 hour format"),
							'12'=>t("12 hour format"),
							),array(
							'class'=>"form-control",
							));
							?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Website Ordering")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('disabled_website_ordering',
							Yii::app()->functions->getOptionAdmin('disabled_website_ordering')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Hide food price")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_hide_foodprice',
							Yii::app()->functions->getOptionAdmin('website_hide_foodprice')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled single food item auto add to cart")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_disbaled_auto_cart',
							Yii::app()->functions->getOptionAdmin('website_disbaled_auto_cart')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Menu Options")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Allow merchant to change there own menu")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_menu_allowed_merchant',
							Yii::app()->functions->getOptionAdmin('admin_menu_allowed_merchant')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>   
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Default Menu")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('admin_activated_menu',
							Yii::app()->functions->getOptionAdmin("admin_activated_menu")==""?true:false
							,array(
							'value'=>"",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Activate Menu 1")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('admin_activated_menu',
							Yii::app()->functions->getOptionAdmin("admin_activated_menu")=="1"?true:false
							,array(
							'value'=>"1",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Activate Menu 2")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('admin_activated_menu',
							Yii::app()->functions->getOptionAdmin("admin_activated_menu")=="2"?true:false
							,array(
							'value'=>"2",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Cart Options")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Sticky Cart")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('disabled_cart_sticky',
							Yii::app()->functions->getOptionAdmin('disabled_cart_sticky')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled Map Address")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('website_enabled_map_address',
							Yii::app()->functions->getOptionAdmin('website_enabled_map_address')==2?true:false
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>   
						</div>
					</div>
					<p class="text-muted"><?php echo t("This options enabled the customer to select his/her address from the map during checkout")?></p>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Order Status")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Nos. of days merchant can change the order status")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('merchant_days_can_edit_status',
							Yii::app()->functions->getOptionAdmin('merchant_days_can_edit_status'),
							array(
							'class'=>"numeric_only form-control"    
							))
							?>    
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Based on the following")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('merchant_days_can_edit_status_basedon',
							Yii::app()->functions->getOptionAdmin('merchant_days_can_edit_status_basedon')
							,array(
							1=>t("On order creation date"),
							2=>t("On Delivery/Pickup Date"),
							),array(
							'class'=>"form-control",
							));
							?>   
						</div>
					</div>
					<p class="text-muted"><?php echo t("leave empty if you want merchant can change the order status anytime")?></p>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled Merchant can add their own status")?>?</label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::checkBox('merchant_status_disabled',
							getOptionA('merchant_status_disabled')==2?true:false
							,array(
							'value'=>2,
							'class'=>"icheck"
							))
							?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Credit Card Payment Management")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled")?>?</label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::checkBox('disabled_cc_management',
							Yii::app()->functions->getOptionAdmin('disabled_cc_management')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Featured Restaurants")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled")?>?</label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::checkBox('disabled_featured_merchant',
							Yii::app()->functions->getOptionAdmin('disabled_featured_merchant')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>   
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Subscription")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled")?>?</label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::checkBox('disabled_subscription',
							Yii::app()->functions->getOptionAdmin('disabled_subscription')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Merchant Registration")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Registration")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('merchant_disabled_registration',
							Yii::app()->functions->getOptionAdmin('merchant_disabled_registration')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>
							<p class="text-muted"><?php echo Yii::t("default","Check this if you want to disabled merchant registration")?></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled ABN")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('merchant_reg_abn',
							Yii::app()->functions->getOptionAdmin('merchant_reg_abn')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Registration Status")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('merchant_sigup_status',
							Yii::app()->functions->getOptionAdmin('merchant_sigup_status')
							,clientStatus(),array(
							'class'=>"form-control"
							));
							?>
							<p class="text-muted"><?php echo Yii::t("default","The status of the merchant after registration")?></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Default Country")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('merchant_default_country',
							Yii::app()->functions->getOptionAdmin('merchant_default_country')
							,$country_list,array(
							'class'=>'form-control'
							));
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Specific Country")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('merchant_specific_country[]',
							$merchant_specific_country
							,$country_list2,array(
							'class'=>"form-control chosen",
							"multiple"=>"multiple"
							));
							?> 
							<p class="text-muted"><?php echo t("leave empty to show all country")?></p> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Verification")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('merchant_email_verification',
							Yii::app()->functions->getOptionAdmin('merchant_email_verification')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>
							<p class="text-muted"><?php echo Yii::t("default","Check this if you want to disabled merchant Verification")?></p>
						</div>
					</div>
					<!--<div class="uk-form-row">
					  <label class="uk-form-label">Enabled Payment?</label>  
					  <?php 
					  echo CHtml::checkBox('merchant_payment_enabled',
					  Yii::app()->functions->getOptionAdmin('merchant_payment_enabled')=="yes"?true:false
					  ,array(
					   'class'=>"icheck",
					   'value'=>"yes"
					  ))
					  ?>
					  <p class="uk-text-muted">Check this if you want to collect payment during registration</p>  
					</div>-->
					  
					<!--<hr/>
					<h2><?php echo Yii::t("default","Payment Gateway")?></h2>
					<div class="uk-form-row">
					  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Paypal")?>?</label>
					  <?php 
					  echo CHtml::checkBox('admin_enabled_paypal',
					  Yii::app()->functions->getOptionAdmin('admin_enabled_paypal')=="yes"?true:false
					  ,array(
						'value'=>"yes",
						'class'=>"icheck"
					  ))
					  ?> 
					</div>

					<div class="uk-form-row">
					  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Card Payment")?>?</label>
					  <?php 
					  echo CHtml::checkBox('admin_enabled_card',
					  Yii::app()->functions->getOptionAdmin('admin_enabled_card')=="yes"?true:false
					  ,array(
						'value'=>"yes",
						'class'=>"icheck"
					  ));      
					  ?> 
					</div>-->

					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Address & Currency")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Country")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('admin_country_set',
							Yii::app()->functions->getOptionAdmin('admin_country_set')
							,$country_list,array(
							'class'=>"form-control",
							'data-validation'=>"required"
							));
							?> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Address")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('website_address',
							Yii::app()->functions->getOptionAdmin('website_address'),
							array(
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Contact Phone Number")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('website_contact_phone',
							Yii::app()->functions->getOptionAdmin('website_contact_phone'),
							array(
							'class'=>"form-control"    
							))
							?> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Contact email")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('website_contact_email',
							Yii::app()->functions->getOptionAdmin('website_contact_email'),
							array(
							'class'=>"form-control" ,
							//'data-validation'=>"email"
							))
							?> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Global Sender email")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('global_admin_sender_email',
							Yii::app()->functions->getOptionAdmin('global_admin_sender_email'),
							array(
							'class'=>"form-control" ,
							//'data-validation'=>"email"
							))
							?> 
							<p class="text-muted">(<?php echo t("This email address will be use when sending email")?>)</p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Currency Code")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('admin_currency_set',
							Yii::app()->functions->getOptionAdmin('admin_currency_set')
							,
							(array)Yii::app()->functions->currencyList()
							,array(
							'class'=>"form-control",
							'data-validation'=>"required"
							));
							?> 
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Currency code position")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('admin_currency_position',
							Yii::app()->functions->getOptionAdmin('admin_currency_position')
							,
							(array)Yii::app()->functions->currencyPosition()
							,array(
							'class'=>"form-control",
							'data-validation'=>"required"
							));
							?> 
						</div>
					</div>
					<?php $admin_decimal_place=Yii::app()->functions->getOptionAdmin('admin_decimal_place');?>
					<?php $admin_use_separators=Yii::app()->functions->getOptionAdmin('admin_use_separators');?>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Decimal Places")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList('admin_decimal_place',empty($admin_decimal_place)?0:$admin_decimal_place,Yii::app()->functions->decimalPlacesList()
							,array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Use 1000 Separators(,)")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_use_separators',
							$admin_use_separators=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Thousand Separators")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('admin_thousand_separator',
							Yii::app()->functions->getOptionAdmin('admin_thousand_separator'),array(
							'class'=>"form-control",
							'maxlength'=>1
							));
							?>
						</div>
					</div>
					<p class="text-muted">(<?php echo t("leave empty to use standard comma separators")?>)</p>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Decimal Separators")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('admin_decimal_separator',
							Yii::app()->functions->getOptionAdmin('admin_decimal_separator'),array(
							'class'=>"form-control",
							'maxlength'=>1
							));
							?>
						</div>
					</div>
					<p class="text-muted">(<?php echo t("leave empty to use standard decimal separators")?>)</p>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Home Search Area")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Map Icon Marker")?></label>
						<div class="col-lg-6">
							<div style="display:inline-table;margin-left:1px;" class="button uk-button" id="photo2"><?php echo Yii::t('default',"Browse")?></div>	  
							<DIV  style="display:none;" class="photo2_chart_status" >
								<div id="percent_bar" class="photo2_percent_bar"></div>
								<div id="progress_bar" class="photo2_progress_bar">
									<div id="status_bar" class="photo2_status_bar"></div>
								</div>
							</DIV>
							<p class="text-muted"><?php echo Yii::t("default","icon size 32x32 or 62x62")?></p>
						</div>
					</div>
					<?php $map_marker=Yii::app()->functions->getOptionAdmin('map_marker');?>
					<?php if (!empty($map_marker)):?>
					<div class="form-group"> 
					<?php else :?>
					<div class="input_block preview form-group">
						<?php endif;?>
						<label class="col-lg-3"><?php echo Yii::t('default',"Preview")?></label>
						<div class="image_preview2 col-lg-6">
						<?php if (!empty($map_marker)):?>
						<input type="hidden" name="photo2" value="<?php echo $map_marker;?>">
						<img class="" src="<?php echo Yii::app()->request->baseUrl."/upload/".$map_marker;?>?>" alt="" title="">
						<p><a href="javascript:rm_preview2();"><?php echo Yii::t("default","Remove image")?></a></p>
						<?php endif;?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled advance search")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('enabled_advance_search',
							Yii::app()->functions->getOptionAdmin('enabled_advance_search')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>
							<p class="text-muted"><?php echo Yii::t("default","Check this if you want to enabled advance search on homepage")?></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled Maps")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('enabled_search_map',
							Yii::app()->functions->getOptionAdmin('enabled_search_map')=="yes"?true:false
							,array(
							'class'=>"icheck",
							'value'=>"yes"
							))
							?>
							<p class="uk-text-muted"><?php echo Yii::t("default","Check this if you want to enabled maps in search result")?></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Share location")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('disabled_share_location',
							Yii::app()->functions->getOptionAdmin('disabled_share_location')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Google Auto Address")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('google_auto_address',
							Yii::app()->functions->getOptionAdmin('google_auto_address')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?>  
						</div>
					</div>
					<p class="text-muted"><?php echo Yii::t("default","This will disabled the google auto address fill")?></p>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Set Google Default Country On")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('google_default_country',
							Yii::app()->functions->getOptionAdmin('google_default_country')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?>   
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Search within radius")?></label>
						<div class="col-lg-6">
							<div class="row">
								<div class="col-lg-6">
									<?php 
									echo CHtml::textField('home_search_radius',
									Yii::app()->functions->getOptionAdmin('home_search_radius'),
									array(    
									"class"=>"numeric_only form-control",
									"placeholder"=>Yii::t("default","Default is 10")
									))
									?> 
								</div>
								<div class="col-lg-6">
									<?php 
									echo CHtml::dropDownList('home_search_unit_type',
									Yii::app()->functions->getOptionAdmin("home_search_unit_type"),Yii::app()->functions->distanceOption(),          
										array(
										'class'=>'form-control'
										))?> 
								</div>
							</div>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Sort result by distance")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('search_result_bydistance',
							Yii::app()->functions->getOptionAdmin('search_result_bydistance')==2?true:false
							,array(
							'value'=>2,
							'class'=>"icheck"
							))
							?>   
						</div>
					</div>
					<hr/>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Home Title Text")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('home_search_text',
							Yii::app()->functions->getOptionAdmin('home_search_text'),
							array(
							'class'=>"form-control",
							'placeholder'=>"Find restaurants near you"
							))
							?>   
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Home SubTitle Text")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('home_search_subtext',
							Yii::app()->functions->getOptionAdmin('home_search_subtext'),
							array(
							'class'=>"form-control",
							'placeholder'=>"Order Delivery Food Online From Local Restaurants"
							))
							?>  
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Search As Address")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('home_search_mode',
							Yii::app()->functions->getOptionAdmin('home_search_mode')=="address"?true:false
							,array(
							'value'=>"address",
							'class'=>"icheck"
							))
							?> 
							<p class="text-muted"><?php echo Yii::t("default","User will search restaurant using address (default)")?></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Search as post code")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('home_search_mode',
							Yii::app()->functions->getOptionAdmin('home_search_mode')=="postcode"?true:false
							,array(
							'value'=>"postcode",
							'class'=>"icheck"
							));      
							?> 
							<p class="uk-text-muted"><?php echo Yii::t("default","User will search restaurant using postcode/zipcode")?></p>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","post code search type")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('admin_zipcode_searchtype',getOptionA('admin_zipcode_searchtype'),
							(array)FunctionsK::zipcodeSearchType(),array(
							'class'=>"chosen form-control"   
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>