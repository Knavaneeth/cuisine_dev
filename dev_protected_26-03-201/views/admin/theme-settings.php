<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal admin-settings-page forms" id="forms">
				<?php echo CHtml::hiddenField('action','themeSettings')?>
					<h4 class="mt-0 header-title"><b><?php echo t("Website Compression")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Enabled")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_compression',getOptionA('theme_compression')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?>  
						</div>
					</div>
					<p class="text-muted"><?php echo t("this options will compress all your js and css and html for website fast loading")?></p>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Home page")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide website logo")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_hide_logo',getOptionA('theme_hide_logo')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?>  
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide how it works section")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_hide_how_works',getOptionA('theme_hide_how_works')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide featured restaurant section")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('disabled_featured_merchant',getOptionA('disabled_featured_merchant')=="yes"?true:false,array(
							'class'=>"icheck",
							'value'=>"yes"
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide browse by cuisine section")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_hide_cuisine',getOptionA('theme_hide_cuisine')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide subscription section")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('disabled_subscription',getOptionA('disabled_subscription')=="yes"?true:false,array(
							'class'=>"icheck",
							'value'=>"yes"
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide connect with us section")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('social_flag',getOptionA('social_flag')==1?true:false,array(
							'class'=>"icheck",
							'value'=>1
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide language bar")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('show_language',getOptionA('show_language')==1?true:false,array(
							'class'=>"icheck",
							'value'=>1
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Custom footer")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textArea('theme_custom_footer',getOptionA('theme_custom_footer'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Advance search options")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled search by address")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_search_merchant_address',getOptionA('theme_search_merchant_address')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled search by restaurant name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_search_merchant_name',getOptionA('theme_search_merchant_name')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled search by street name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_search_street_name',getOptionA('theme_search_street_name')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled search by cuisine")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_search_cuisine',getOptionA('theme_search_cuisine')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled search by food name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_search_foodname',getOptionA('theme_search_foodname')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Menu")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Top menu")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('theme_top_menu[]',(array)FunctionsV3::getTopMenuActivated(),array(
							'browse'=>t("Browse Restaurant"),
							'resto_signup'=>t("Restaurant Signup"),
							'contact'=>t("Contact"),
							'signup'=>t("Login & Signup")
							),array(
							'class'=>"chosen form-control",
							"multiple"=>"multiple"
							));
							?>
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Footer menu")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide Menu section")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_hide_footer_section1',getOptionA('theme_hide_footer_section1')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Hide Others section")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_hide_footer_section2',getOptionA('theme_hide_footer_section2')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Mobile App")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Enabled mobile app section")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_show_app',getOptionA('theme_show_app')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Google Play Link")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('theme_app_android',getOptionA('theme_app_android'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("App Store Link")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('theme_app_ios',getOptionA('theme_app_ios'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>
					<!--<div class="form-group">
						<label class="col-lg-3"><?php echo t("Windows Phone Link")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('theme_app_windows',getOptionA('theme_app_windows'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>-->
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Search Results")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Do not collapse all filters")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_filter_colapse',getOptionA('theme_filter_colapse')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Enabled Maps")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('enabled_search_map',getOptionA('enabled_search_map')=="yes"?true:false,array(
							'class'=>"icheck",
							'value'=>"yes"
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("List Style")?>?</label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('theme_list_style',getOptionA('theme_list_style'),array(
							'gridview'=>t("Grid View"),
							'listview'=>t("List View"),
							),array(
							'class'=>"form-control",
							));
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Food Menu")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Do not collapse menu")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_menu_colapse',getOptionA('theme_menu_colapse')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Restaurant menu")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled opening hours tab")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_hours_tab',getOptionA('theme_hours_tab')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled reviews tab")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_reviews_tab',getOptionA('theme_reviews_tab')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled table booking tab")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('merchant_tbl_book_disabled',getOptionA('merchant_tbl_book_disabled')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled map tab")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_map_tab',getOptionA('theme_map_tab')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled photos tab")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_photos_tab',getOptionA('theme_photos_tab')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled information tab")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_info_tab',getOptionA('theme_info_tab')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Disabled promo tab")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_promo_tab',getOptionA('theme_promo_tab')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Cookie law")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Enabled Cookie law")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('cookie_law_enabled',getOptionA('cookie_law_enabled')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Accept cookies button text")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('cookie_accept_text',getOptionA('cookie_accept_text'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("What are cookies button text")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('cookie_info_text',getOptionA('cookie_info_text'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Cookie Privacy message")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textArea('cookie_msg_text',getOptionA('cookie_msg_text'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("What are cookies link")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('cookie_info_link',getOptionA('cookie_info_link'),array(
							'class'=>"form-control"
							))
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Language bar position")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Position")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::dropDownList('theme_lang_pos',
							getOptionA('theme_lang_pos')
							,array(
							'bottom'=>t("bottom"),
							'top'=>t("top"),
							),array(
							'class'=>"form-control",
							));
							?> 
						</div>
					</div>
					<hr/>
					<h4 class="mt-0 header-title"><b><?php echo t("Time Picker")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo t("Enabled Time Picker UI")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('theme_time_pick',getOptionA('theme_time_pick')==2?true:false,array(
							'class'=>"icheck",
							'value'=>2
							));
							?> 
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<label class="col-lg-3"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>