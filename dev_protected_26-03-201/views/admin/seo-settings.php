<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','SeoSettings')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo t("Available Tags")?>:</label>
						<div class="col-lg-6">
							<ul class="text-muted">
								<li><?php echo t("{website_title}")?></li>
								<li><?php echo t("{merchant_name}")?></li>
							</ul>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Home Page")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","SEO Title")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_home',
							Yii::app()->functions->getOptionAdmin('seo_home')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Meta Description")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_home_meta',
							Yii::app()->functions->getOptionAdmin('seo_home_meta')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Keywords")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_home_keywords',
							Yii::app()->functions->getOptionAdmin('seo_home_keywords')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Home Page")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SEO Title")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_search',
							Yii::app()->functions->getOptionAdmin('seo_search')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Description")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_search_meta',
							Yii::app()->functions->getOptionAdmin('seo_search_meta')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Keywords")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_search_keywords',
							Yii::app()->functions->getOptionAdmin('seo_search_keywords')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SEO Title")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_menu',
							Yii::app()->functions->getOptionAdmin('seo_menu')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Description")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_menu_meta',
							Yii::app()->functions->getOptionAdmin('seo_menu_meta')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Keywords")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_menu_keywords',
							Yii::app()->functions->getOptionAdmin('seo_menu_keywords')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Checkout Page")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SEO Title")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_checkout',
							Yii::app()->functions->getOptionAdmin('seo_checkout')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Description")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_checkout_meta',
							Yii::app()->functions->getOptionAdmin('seo_checkout_meta')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Keywords")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_checkout_keywords',
							Yii::app()->functions->getOptionAdmin('seo_checkout_keywords')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Contact Page")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SEO Title")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_contact',
							Yii::app()->functions->getOptionAdmin('seo_contact')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Description")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_contact_meta',
							Yii::app()->functions->getOptionAdmin('seo_contact_meta')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Keywords")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_contact_keywords',
							Yii::app()->functions->getOptionAdmin('seo_contact_keywords')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Merchant Signup Page")?></b></h4>
 					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SEO Title")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_merchantsignup',
							Yii::app()->functions->getOptionAdmin('seo_merchantsignup')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Description")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_merchantsignup_meta',
							Yii::app()->functions->getOptionAdmin('seo_merchantsignup_meta')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Meta Keywords")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('seo_merchantsignup_keywords',
							Yii::app()->functions->getOptionAdmin('seo_merchantsignup_keywords')
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>