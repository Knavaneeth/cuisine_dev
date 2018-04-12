<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/smstransaction/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/smstransaction" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->getSMSTransaction($_GET['id'])){
						echo "<div class=\"alert alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','updateSMSTransaction')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/smstransaction/Do/Add")?>
					<?php endif;?>
					<?php if (isset($_GET['id'])):?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Merchant Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo $data['merchant_name'];
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SMS Package")?></label>
						<div class="col-lg-6">
							<?php 
							echo $data['sms_package_name'];
							?>
						</div>
					</div>
					<?php else: ?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Merchant Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('merchant_id','',
							(array)Yii::app()->functions->merchantList(true)
							,array(
							'class'=>'form-control'
							))
							?>
						</div>
					</div>
					<?php 
					$sms_pack=Yii::app()->functions->getSMSPackage();
					$sms_drop[]=t("Please Select");
					if (is_array($sms_pack) && count($sms_pack)>=1){
						foreach ($sms_pack as $sms_val) {		
							$sms_drop[$sms_val['sms_package_id']]=ucwords($sms_val['title']);
						}
					}
					?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SMS Package")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('sms_package_id','',
							(array)$sms_drop
							,array(
							'class'=>'form-control'
							))
							?>
						</div>
					</div>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","SMS Credits")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('sms_limit',
							isset($data['sms_limit'])?$data['sms_limit']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList("status",
							isset($data['status'])?$data['status']:''
							,(array)paymentStatus(),array(
							'class'=>"form-control"
							));
							?>
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