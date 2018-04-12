<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/OrderStatus/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/OrderStatus" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addOrderStatus')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php echo CHtml::hiddenField('is_admin',1);?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/OrderStatus/Do/Add")?>
					<?php endif;?>
					<?php 
					if (isset($_GET['id'])){
						if (!$data=Yii::app()->functions->getOrderStatus($_GET['id'])){
							echo "<div class=\"uk-alert uk-alert-danger\">".
							Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
							return ;
						}	
					}
					?>                                 
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('description',
							isset($data['description'])?$data['description']:""
							,array(
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