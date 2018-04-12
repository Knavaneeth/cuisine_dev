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
				<?php if ($res=Yii::app()->functions->getCustomPageList()):?>
				<?php 
				$position=array(
				  //'top'=>t("Top"),
				  'bottom'=>t("bottom column 1"),
				  'bottom2'=>t("bottom column 2")
				);
				?>
				<form class="uk-form uk-form-horizontal forms assignpage-form" id="forms">
					<?php echo CHtml::hiddenField('action','assignCustomPage')?>
					<ul class="uk-list uk-list-striped sortable-jquery form-group">
						<?php foreach ($res as $val):?>
						<li>
							<div class="uk-grid">
								<div class="uk-width-1-2"> 
									<?php echo CHtml::hiddenField('id[]',$val['id'])?>
									<?php echo $val['page_name']?>
								</div>
								<div class="uk-width-1-2">
									<?php echo Yii::t("default","Assign to")?> <?php echo CHtml::dropDownList('assign_to[]',$val['assign_to'],$position)?>
								</div>
							</div>
						</li>
						<?php endforeach;?>
					</ul>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
				<?php else :?>
					<div class="alert alert-danger"><?php echo Yii::t("default","No custom page found.")?></div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>