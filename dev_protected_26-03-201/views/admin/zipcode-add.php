<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/zipcode/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/zipcode" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addZipCode')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/zipcode/Do/Add")?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Post code")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('zipcode',
							isset($data['zipcode'])?$data['zipcode']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Country")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('country_code',
							isset($data['country_code'])?$data['country_code']:getOptionA('admin_country_set')
							,(array)Yii::app()->functions->CountryList(),array(
							'class'=>"chosen form-control"
							));
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Street name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('stree_name',
							isset($data['stree_name'])?$data['stree_name']:""
							,array('class'=>"form-control"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Area")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('area',
							isset($data['area'])?$data['area']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","City")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('city',
							isset($data['city'])?$data['city']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::dropDownList('status',
							isset($data['status'])?$data['status']:"",
							(array)statusList(),          
							array(
							'class'=>'form-control',
							'data-validation'=>"required"
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