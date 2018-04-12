<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<?php 
				$selected='incoming';
				if (isset($_GET['do'])){
					$selected=$_GET['do'];
				}
				?>
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal" class="w-list incoming btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","Incoming withdrawal")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal/?do=approved" class="w-list approved btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","Approved withdrawal")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal/?do=paid" class="w-list paid btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","Paid withdrawal")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal/?do=denied" class="w-list denied btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","Denied withdrawal")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal/?do=failed" class="w-list failed btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","Failed withdrawal")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal/?do=cancel" class="w-list cancel btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","Cancel withdrawal")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal/?do=reversal" class="w-list reversal btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","Reversal withdrawal")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/incomingwithdrawal/?do=all" class="w-list all btn btn-default btn-sm"><i class="fa fa-list"></i> <?php echo Yii::t("default","All withdrawal")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="GET" class="form-horizontal" >
					<?php echo CHtml::hiddenField('start_date',isset($_GET['start_date'])?$_GET['start_date']:"")?>
					<?php echo CHtml::hiddenField('end_date',isset($_GET['end_date'])?$_GET['end_date']:"")?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Merchant Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('merchant_id',
							isset($_GET['merchant_id'])?$_GET['merchant_id']:''
							,
							(array)Yii::app()->functions->merchantList3(true,true)
							,array(
							'class'=>'form-control'    
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Start Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('start_date1',isset($_GET['start_date1'])?$_GET['start_date1']:''
							,array(
							'class'=>'form-control j_date' ,
							'data-id'=>'start_date'
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","End Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('end_date1',isset($_GET['end_date1'])?$_GET['end_date1']:''
							,array(
							'class'=>'form-control j_date',
							'data-id'=>'end_date'
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-2">
							<input type="submit" class="btn btn-primary btn-block" value="<?php echo t("Search")?>">
						</div>
						<div class="col-lg-2">
							<a  href="javascript:;" rel="rpt_incomingwithdrawal" class="export_btn btn btn-default btn-block"><?php echo t("Export")?></a>
						</div>
					</div>
					<input type="hidden" name="action" id="action" value="incomingWithdrawals">
					<input type="hidden" name="tbl" id="tbl" value="withdrawal">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="withdrawal_id">
					<input type="hidden" name="slug" id="slug" value="incomingWithdrawals">
					<?php echo CHtml::hiddenField('w-list',$selected)?>
					<?php echo CHtml::hiddenField('do',$selected)?>
					<table id="table_list" class="table table-striped table-bordered">  
					   <thead>
							<tr>
								<th><?php echo Yii::t("default","ID")?></th>
								<th><?php echo Yii::t("default","Merchant Name")?></th>
								<th><?php echo Yii::t("default","Payment Method")?></th>
								<th><?php echo Yii::t("default","Amount")?></th>
								<th><?php echo Yii::t("default","From Balance")?></th>
								<th><?php echo Yii::t("default","Status")?></th>
								<th><?php echo Yii::t("default","Date Of Request")?></th>
								<th><?php echo Yii::t("default","Date to process")?></th>
								<th><?php echo Yii::t("default","Action")?></th>
							</tr>
						</thead>
						<tbody>    
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>