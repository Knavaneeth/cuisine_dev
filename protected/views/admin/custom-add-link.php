<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage/Do/AddCustom" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New Custom Link")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage/Do/Assign" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","Assign Page")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->getCustomPage($_GET['id'])){
						echo "<div class=\"uk-alert uk-alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addCustomPageLink')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/customPage/Do/AddCustom")?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Link Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('page_name',
							isset($data['page_name'])?$data['page_name']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Link")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('content',
							isset($data['content'])?$data['content']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Open in new window")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('open_new_tab',
							$data['open_new_tab']==2?true:false
							,array('class'=>'icheck','value'=>2));
							?>
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