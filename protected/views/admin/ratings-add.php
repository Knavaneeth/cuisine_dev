<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Ratings/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Ratings" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->getRatingInfo($_GET['id'])){
						echo "<div class=\"alert alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addRatings')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/Ratings/")?>
					<?php endif;?>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Range 1")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('rating_start',
							isset($data['rating_start'])?$data['rating_start']:""
							,array('class'=>"form-control numeric_only",'data-validation'=>"required"))
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Range 2")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('rating_end',
							isset($data['rating_end'])?$data['rating_end']:"",
							array('class'=>"form-control numeric_only",'data-validation'=>"required"))
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Ratings")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('meaning',
							isset($data['meaning'])?$data['meaning']:"",
							array('class'=>"form-control",'data-validation'=>"required"))
							?>
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