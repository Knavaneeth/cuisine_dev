<footer class="footer">
	<div class="footer-wrap">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-lg-3 col-sm-3 col-xs-6 footer-widget">
				<?php if ($theme_hide_footer_section1!=2):?>
					<h2>Company</h2>
					<ul>
						<?php if (is_array($menu) && count($menu)>=1):?>
						<?php foreach ($menu as $val):?>
							<li><a href="<?php echo FunctionsV3::customPageUrl($val)?>" <?php FunctionsV3::openAsNewTab($val)?> ><?php echo $val['page_name']?></a></li>
						<?php endforeach;?>
						<?php endif;?>
						<?php if (is_array($others_menu) && count($others_menu)>=1):?>
						<?php foreach ($others_menu as $val):?>
							<li><a href="<?php echo FunctionsV3::customPageUrl($val)?>" <?php FunctionsV3::openAsNewTab($val)?> ><?php echo $val['page_name']?></a></li>
					   <?php endforeach;?>
					   <?php endif;?>
					</ul>
				<?php endif;?>
				</div>
				<div class="col-md-3 col-lg-3 col-sm-3 col-xs-6 footer-widget">
				<?php if ($theme_hide_footer_section1!=2):?>
				<h2>Restaurant Login</h2>				
					<ul>
						<li><a href="<?php echo Yii::app()->createUrl('/merchant')?>">Restaurant Login</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/store/page/join-our-network')?>">Join our network</a></li>
					</ul>
				<?php endif;?>  
				</div>
				<div class="col-md-3 col-lg-3 col-sm-3 col-xs-6 footer-widget">
				<?php if ($theme_hide_footer_section1!=2):?>
					<?php if ($social_flag<>1):?>
					<div class="social-icon">
						<h2>Follow me on</h2>
						<ul>
							<li><a href="<?php echo FunctionsV3::prettyUrl($twitter_page)?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/twitter.png" alt="Twitter" title="Twitter" width="48" height="48"></a></li>
							<li><a href="<?php echo FunctionsV3::prettyUrl($fb_page)?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/facebook.png" alt="Facebook" title="Facebook" width="48" height="48"></a></li>
						<li><a href="<?php echo FunctionsV3::prettyUrl($intagram_page)?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/instagram.png" alt="instagram" title="Instagram" width="48" height="48"></a></li>
						</ul>
					</div>
					<?php endif;?>
				<?php endif;?> 
				</div>
				<div class="col-md-3 col-lg-3 col-sm-3 col-xs-6 footer-widget">
				<?php if ($theme_hide_footer_section1!=2):?>
					<?php if ( getOptionA('disabled_subscription') == ""):?>
					<form method="POST" id="frm-subscribe" class="frm-subscribe form-inline" onsubmit="return false;">
					<?php echo CHtml::hiddenField('action','subscribeNewsletter')?>
						<div class="subscription">
							<h2><?php echo t("Subscribe") ?></h2>
							<div class="input-group">
								<?php echo CHtml::textField('subscriber_email','',array(
								'placeholder'=>t("Enter Email"),
								'required'=>true,
								'class'=>"email form-control"
								))?>
								<span class="input-group-btn">
									<button class="btn btn-suscribe btn-primary btn-block" type="submit"><?php echo t("Subscribe")?></button> 
								</span>
							</div>
						</div>
					</form>
					<?php endif;?>
				<?php endif;?> 
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
			<hr class="footer-line">
			<div class="row">
			<div class="col-md-12"> © 2017. Cuisine.je is an innovative online food/table booking service provided by<a href="http://www.eshci.com/"  target="_blank"> ESH Solutions Ltd 
			</a> - All rights reserved. </div>
			</div>
	  </div>
	</div>
</footer>