<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/sponsoredMerchantList/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/sponsoredMerchantList" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->getMerchant($_GET['id'])){
						echo "<div class=\"alert alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                                   
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','sponsoreMerchantAdd')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/sponsoredMerchantList/")?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Merchant")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList('merchant_id',
							isset($data['merchant_id'])?$data['merchant_id']:''
							,(array)Yii::app()->functions->merchantList(),
							array('class'=>"form-control"))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Expiration Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::hiddenField('expiration',isset($data['sponsored_expiration'])?$data['sponsored_expiration']:"")?>
							<?php echo CHtml::textField('expiration1',
							isset($data['sponsored_expiration'])?$data['sponsored_expiration']:""
							,array(
							'class'=>'form-control j_date',
							'data-validation'=>"required",
							'data-id'=>"expiration"
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