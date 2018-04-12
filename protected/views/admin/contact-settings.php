<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','contactSettings')?>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Contact Content")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textArea("contact_content",yii::app()->functions->getOptionAdmin('contact_content'),
							array(
							'id'=>'contact_content',
							'class'=>"form-control",
							))?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t('default',"Map")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Display Google Map")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('contact_map',yii::app()->functions->getOptionAdmin('contact_map'),array(
							'class'=>"icheck"))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Latitude")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField("map_latitude",yii::app()->functions->getOptionAdmin('map_latitude'),array(
							'class'=>"form-control"))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Longitude")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField("map_longitude",yii::app()->functions->getOptionAdmin('map_longitude'),array(
							'class'=>"form-control"))?>
						</div>
					</div>
					<?php 
					$fields=yii::app()->functions->getOptionAdmin('contact_field');
					if (!empty($fields)){
						$fields=json_decode($fields);
					}
					?>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default",'Contact Fields')?></b></h4>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Name")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('contact_field[]',
							 in_array('name',(array)$fields)?true:false,array('value'=>'name','class'=>"icheck"))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Email")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('contact_field[]',
							 in_array('email',(array)$fields)?true:false,array('value'=>'email','class'=>"icheck"))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Phone")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('contact_field[]',
							 in_array('phone',(array)$fields)?true:false,array('value'=>'phone','class'=>"icheck"))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Country")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('contact_field[]',
							 in_array('country',(array)$fields)?true:false,array('value'=>'country','class'=>"icheck"))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Message")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::checkBox('contact_field[]',
							 in_array('message',(array)$fields)?true:false,array('value'=>'message','class'=>"icheck"))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Send To")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField("contact_email_receiver",yii::app()->functions->getOptionAdmin('contact_email_receiver'),
							array(
							'class'=>"form-control",
							'placeholder'=>Yii::t("default","Email address")
							))?>
						</div>
					</div>
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