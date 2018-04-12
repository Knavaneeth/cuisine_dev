<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/ManageCurrency/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/ManageCurrency" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->getCurrencyDetails($_GET['id'])){
						echo "<div class=\"alert alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                             
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addCurrency')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/ManageCurrency/")?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Currency Code")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('currency_code',
							isset($data['currency_code'])?$data['currency_code']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Currency Symbol")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('currency_symbol',
							isset($data['currency_symbol'])?$data['currency_symbol']:"",
							array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<p class="text-muted"><?php echo Yii::t("default","To get symbol refer to")?> <a target="_blank" href="http://www.xe.com/symbols.php">http://www.xe.com/symbols.php</a></p>
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