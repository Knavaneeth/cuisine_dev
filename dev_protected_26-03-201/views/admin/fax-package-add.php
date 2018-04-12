<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faxpackage/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faxpackage" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faxpackage/Do/Sort" class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				$FunctionsK=new FunctionsK;
				if (isset($_GET['id'])){
					if (!$data=$FunctionsK->getSMSPackagesById($_GET['id'])){
						echo "<div class=\"uk-alert uk-alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','FaxPackageAdd')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/faxpackage/Do/Add")?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Title")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('title',
							isset($data['title'])?$data['title']:""
							,array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Description")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textArea('description',
							isset($data['description'])?$data['description']:""
							,array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Price")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('price',
							isset($data['price'])?standardPrettyFormat($data['price']):""
							,array(
							'class'=>'form-control numeric_only',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Promo Price")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('promo_price',
							isset($data['promo_price'])?standardPrettyFormat($data['promo_price']):""
							,array(
							'class'=>'form-control numeric_only'  
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Fax Credit Limit")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('fax_limit',
							isset($data['fax_limit'])?$data['fax_limit']:""
							,array(
							'class'=>'form-control numeric_only',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Status")?></label>
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