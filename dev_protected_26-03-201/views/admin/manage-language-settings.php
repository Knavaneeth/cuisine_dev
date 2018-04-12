<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/ManageLanguage/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/ManageLanguage" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/ManageLanguage/Do/Settings" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","Settings")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				$translated_text='';
				$new_raw_msg='';

				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->languageInfo($_GET['id'])){
						echo "<div class=\"uk-alert uk-alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}	
				}
				$langauge_list=yii::app()->functions->availableLanguage();
				$set_lang_id=Yii::app()->functions->getOptionAdmin('set_lang_id');
				if ( !empty($set_lang_id)){
					$set_lang_id=json_decode($set_lang_id);
				}
				?>

				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','languageSettings')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Language on front end")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('show_language',
							Yii::app()->functions->getOptionAdmin('show_language')
							,array(
							'class'=>"icheck"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Language bar on Admin/Merchant")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('show_language_backend',
							Yii::app()->functions->getOptionAdmin('show_language_backend')
							,array(
							'class'=>"icheck"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled Multiple Field Translation")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('enabled_multiple_translation',
							Yii::app()->functions->getOptionAdmin('enabled_multiple_translation')==2?true:false  
							,array(
							'class'=>"icheck",
							'value'=>2
							))
							?>
						</div>
						<div class="col-lg-12">
							<p class="text-muted"><?php echo t("this will add a field on food item and category for multiple language")?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Set Language")?></label>
						<div class="col-lg-6">
							<?php if (is_array($langauge_list) && count($langauge_list)>=1):?>
						</div>
						<div class="col-lg-12">
							<p class="text-muted"><?php echo Yii::t("default","Select language that will be added on front end.")?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3">Default Language</label>
						<div class="col-lg-6">
							<ul class="uk-list uk-list-striped">
							<?php foreach ($langauge_list as $key=>$val):?>
								<li>
								<?php echo CHtml::checkBox('set_lang_id[]',
								in_array($key,(array)$set_lang_id)?true:false
								,array('class'=>"icheck",'value'=>$key))?>
								<?php echo ucwords($val);?></li>
							<?php endforeach;?>
							<?php endif;?>
							</ul>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Default Language on front end")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('default_language',
							Yii::app()->functions->getOptionAdmin('default_language'),
							(array)Yii::app()->functions->availableLanguage()
							,array(
							'class'=>"form-control",'data-validation'=>""
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Default Language on Admin/Merchant")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('default_language_backend',
							Yii::app()->functions->getOptionAdmin('default_language_backend'),
							(array)Yii::app()->functions->availableLanguage()
							,array(
							'class'=>"form-control",'data-validation'=>""
							))
							?>
						</div>
					</div>
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