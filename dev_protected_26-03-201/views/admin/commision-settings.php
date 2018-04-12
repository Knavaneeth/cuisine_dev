<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<?php
				$enabled=Yii::app()->functions->getOptionAdmin('admin_commission_enabled');
				$disabled_membership=Yii::app()->functions->getOptionAdmin('admin_disabled_membership');
				$admin_commision_ontop=Yii::app()->functions->getOptionAdmin('admin_commision_ontop');
				?>
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','commissionSettings')?>
					<h4 class="mt-0 header-title"><b><?php echo t("Admin Commission Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Exclude All Offline Payment from admin balance")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_exclude_cod_balance',
							Yii::app()->functions->getOptionAdmin('admin_exclude_cod_balance')==2?true:false
							,array(
							'value'=>2,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Merchant Signup Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Enabled Commission")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_commission_enabled',
							$enabled=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Membership Signup")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_disabled_membership_signup',
							getOptionA('admin_disabled_membership_signup')==1?true:false
							,array(
							'value'=>1,
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<!--<p class="text-muted"><?php echo t("This options only take affect if you enabled the commission signup")?></p>-->
					<!--<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Disabled Membership")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_disabled_membership',
							$disabled_membership=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>-->
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Include Cash Payment on merchant balance")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_include_merchant_cod',
							Yii::app()->functions->getOptionAdmin('admin_include_merchant_cod')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Commission on orders")?></label>
						<div class="col-lg-6">
							<div class="row">
								<div class="col-md-3">
									<?php 
									echo CHtml::dropDownList('admin_commision_type',
									Yii::app()->functions->getOptionAdmin('admin_commision_type')
									,array(   
									'percentage'=>t("Percentage"),
									'fixed'=>t("Fixed"),
									),array(
									'class'=>"form-control",
									));
									?>
								</div>
								<div class="col-md-3">
									<?php 
									echo CHtml::textField('admin_commision_percent',
									Yii::app()->functions->getOptionAdmin('admin_commision_percent')
									,array(
									'class'=>"form-control numeric_only"
									))
									?>
								</div>
							</div>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Set commission on")?></label>
						<div class="col-lg-9">
							<?php echo CHtml::radioButton('admin_commision_ontop',
							$admin_commision_ontop==1?true:false
							,array('value'=>1,'class'=>"icheck"))?>
							&nbsp;&nbsp;<?php echo t("Commission on Sub total order")?>
							
							<?php echo CHtml::radioButton('admin_commision_ontop',
							$admin_commision_ontop==2?true:false
							,array('value'=>2,'class'=>"icheck"))?>
							&nbsp;&nbsp;<?php echo t("Commission on Total order")?>

						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Total Commission")?></b></h4>
					<?php  
					$order_stats=Yii::app()->functions->orderStatusList2(false);
					$total_commission_status=Yii::app()->functions->getOptionAdmin('total_commission_status');
					if (!empty($total_commission_status)){
						$total_commission_status=json_decode($total_commission_status);
					} else {
						$total_commission_status=array('paid');
					}
					?>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Compute Total Commission base on the following order status")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList('total_commission_status[]',$total_commission_status,(array)$order_stats,array(
							'class'=>"chosen form-control",
							'multiple'=>true
							))?>
						</div>
					</div>
					<!--<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Invoice")?></b></h4>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","VAT No")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_vat_no',
							Yii::app()->functions->getOptionAdmin('admin_vat_no')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","VAT")?>(%)</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_vat_percent',
							Yii::app()->functions->getOptionAdmin('admin_vat_percent')
							,array(
							'class'=>"form-control numeric_only"
							))
							?>
						</div>
					</div>-->
					<div class="form-group">
						<label class="col-lg-3"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>