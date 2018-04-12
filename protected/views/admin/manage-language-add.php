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
					/*$raw_msg = require_once Yii::getPathOfAlias('webroot')."/protected/messages/default/raw_msg.php";
					if (is_array($raw_msg) && count($raw_msg)>=1){
					   foreach ($raw_msg as $val_raw_msg) {		   
						   $new_raw_msg[$val_raw_msg]=$val_raw_msg;
					   }	   
					}       
					$translated_text=!empty($data['source_text'])?(array)json_decode($data['source_text']):array();    */
				}
				?>                          
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addLanguage')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/ManageLanguage/Do/Add")?>
					<?php endif;?>

					<?php if (isset($_GET['id'])):?>
					<!--<p class="uk-text-success"><?php echo Yii::t("default","Start Translating..")?></p>-->
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Country")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('country_code',
							isset($data['country_code'])?$data['country_code']:'',
							(array)Yii::app()->functions->CountryList()
							,array(
							'class'=>"form-control",'data-validation'=>"required"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Enter language Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('language_code',
							isset($data['language_code'])?$data['language_code']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Upload language file")?></label>
						<div class="col-lg-6">
							<div style="display:inline-table;margin-left:1px;" class="button uk-button" id="files"><?php echo Yii::t('default',"Browse")?></div>	  
							<div  style="display:none;" class="files_chart_status" >
								<div id="percent_bar" class="files_percent_bar"></div>
								<div id="progress_bar" class="files_progress_bar">
									<div id="status_bar" class="files_status_bar"></div>
								</div>
							</div>
						</div>
					</div>
					<p class="uk-text-muted uk-text-small">
					<?php echo Yii::t("default","Important Notice: Language filename must be unique")?>.
					<?php echo Yii::t("default","You can find the language file to translate on the root folder filename is mt_language_file.php")?><br/>
					<a target="_blank" href="<?php echo Yii::app()->request->baseUrl."/admin/showLanguage"?>"><?php echo Yii::t("default","or Click here to download the file")?></a>
					</p>
					<p class="uk-text-muted uk-text-small"><?php echo Yii::t("default","Validate your language file on this link")?> http://phpcodechecker.com/</p>
					<?php if (isset($data['source_text'])) :?>
					<?php echo CHtml::hiddenField('language_file',$data['source_text'])?>
					<div class="image_preview">
						<p class="uk-text-muted"><a target="_blank" href="<?php echo Yii::app()->request->baseUrl."/admin/ViewFile/fileName/".$data['source_text']?>"><?php echo $data['source_text']?></a></p>
						<p><a href="javascript:rm_preview();"><?php echo Yii::t("default","Remove Files")?></a></p>
					</div>
					<?php else :?>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-6">
							<div class="image_preview"></div>
						</div>
					</div>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList('status',
							isset($data['status'])?$data['status']:"",
							(array)statusList(),          
							array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<!--<?php if (is_array($new_raw_msg) && count($new_raw_msg)>=1):?>
					<?php foreach ($new_raw_msg as $key=>$val):?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo $val;?></label>
						<div class="col-lg-6">
						<?php 
						echo CHtml::textField("source_text[$val]",
						Yii::app()->functions->inArray($val,$translated_text)
						,array('class'=>"form-control"))
						?>
						</div>
					</div>
					<?php endforeach;?>
					<?php endif;?>
					-->
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>