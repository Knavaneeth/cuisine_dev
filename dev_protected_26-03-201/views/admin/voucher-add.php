<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/voucher/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/voucher" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addVoucherNew')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<input type="hidden" name="voucher_owner" id="voucher_owner" value="admin">
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/voucher/Do/Add")?>
					<?php endif;?>
					<?php 
					$has_already_used=false;
					if (isset($_GET['id'])){
						if (!$data=Yii::app()->functions->getVoucherCodeByIdNew($_GET['id'])){
							echo "<div class=\"uk-alert uk-alert-danger\">".
							Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
							return ;
						} 	
						
						if (isset($data['found'])){
							if ( $data['found']>0){
								$has_already_used=true;
							}
						}
					}
					?> 
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Voucher name")?></label>
						<div class="col-lg-4">
							  <?php echo CHtml::textField('voucher_name',$data['voucher_name'],
							  array(
								'data-validation'=>'required' ,
								'class'=>"voucher_name form-control"
							  ))?>
						</div>
					</div>
					<?php if ($has_already_used):?>
					<p class="text-small text-danger"><?php echo t("This voucher has already been used editing the voucher name may cause error on the system")?></p>
					<?php echo CHtml::hiddenField('disabled_voucher_code')?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Type")?></label>
						<div class="col-lg-4">
							<?php
							echo CHtml::dropDownList('voucher_type',$data['voucher_type'],
							Yii::app()->functions->voucherType(),array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Discount")?></label>
						<div class="col-lg-4">
							<?php echo CHtml::textField('amount',
							normalPrettyPrice($data['amount'])
							,array('data-validation'=>'required','class'=>'form-control numeric_only'))?>
							<span class="text-muted"><?php echo Yii::t("default","Voucher amount discount.")?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Expiration")?></label>
						<div class="col-lg-4">
							<?php
							echo CHtml::hiddenField('expiration',$data['expiration']);
							echo CHtml::textField('expiration1',FormatDateTime($data['expiration'],false),
							array(
							'class'=>'j_date form-control' ,
							'data-id'=>'expiration',
							'data-validation'=>"required"
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Applicable to merchant")?></label>
						<div class="col-lg-4">
							<?php
							echo CHtml::dropDownList('joining_merchant[]',(array)$joining_merchant,
							Yii::app()->functions->merchantList(true),array(
							//'data-validation'=>"required",
							'multiple'=>true,
							'class'=>"chosen form-control"
							))
							?>
						</div>
					</div>
					<p class="text-muted text-small">
						<?php echo t("leave empty if you want to apply to all merchants")?>
					</p>
 					<div class="form-group">
						<label class="col-lg-2 control-label">Status</label>
						<div class="col-lg-4">
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
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Used only once")?></label>
						<div class="col-lg-4">
							<?php  
							echo CHtml::checkBox('used_once',
							$data['used_once']==2?true:false,
							array( 
							'class'=>"icheck",
							'value'=>2
							))
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