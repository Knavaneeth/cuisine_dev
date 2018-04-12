<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<?php 
				$list=Yii::app()->functions->Cuisine();
				?>
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Cuisine/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Cuisine" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Cuisine/Do/Sort" class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','sortItem')?>
					<?php echo CHtml::hiddenField('table','cuisine')?>
					<?php echo CHtml::hiddenField('whereid','cuisine_id')?>
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Sort")?></b></h4>
					<p class="text-muted"><?php echo Yii::t("default","Drag the item below to sort")?></p>
					<?php if (is_array($list) && count($list)>=1):?>
					<ul class="uk-sortable" data-uk-sortable>
					<?php foreach ($list as $key_id=>$val): ?>
					<li class="uk-panel uk-panel-box" style="list-style:none;margin-bottom:5px;">
					<?php echo CHtml::hiddenField('sort_field[]',$key_id)?>
					<i class="fa fa-arrows-alt"></i>
					<?php echo ucfirst($val)?>
					</li>
					<?php endforeach;?>
					</ul>
					<?php else :?>
					<p class="text-danger"><?php echo Yii::t("default","No results")?></p>
					<?php endif;?>
					<div class="form-group">
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>