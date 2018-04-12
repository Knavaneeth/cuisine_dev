<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<?php
				$query='last15';
				if (isset($_GET['query'])){
					$query=$_GET['query'];
				}
				if (isset($_GET['start_date'])){
					if (!empty($_GET['start_date'])){
						$query='period';
					}
				}

				$months=Yii::app()->functions->getLastTwoMonths();

				$order_stats=Yii::app()->functions->orderStatusList2(false);    

				$total_commission_status=Yii::app()->functions->getOptionAdmin('total_commission_status');
				if (!empty($total_commission_status)){
					$total_commission_status=json_decode($total_commission_status);
				} else {
					$total_commission_status=array('paid');
				}
				if (isset($_GET['merchant_id'])){	
					$total_commission_status=isset($_GET['stats_id'])?$_GET['stats_id']:'';
				}
				?>
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->createUrl('admin/merchantcommission',array('query'=>"all"))?>" class="btn btn-default selected_transaction_query all"><?php echo t("All")?></a>
					<a href="<?php echo Yii::app()->createUrl('admin/merchantcommission',array('query'=>"last15"))?>" class="btn btn-default selected_transaction_query last15"><?php echo t("Last 15 days")?></a>
					<a href="<?php echo Yii::app()->createUrl('admin/merchantcommission',array('query'=>"last30"))?>" class="btn btn-default selected_transaction_query last30"><?php echo t("Last 30 days")?></a>
					<?php if (is_array($months) && count($months)>=1):?>
					<?php foreach ($months as $key=>$months_val):?>
					<a href="<?php echo Yii::app()->createUrl('admin/merchantcommission',array('query'=>"month","date"=>$key))?>" class="btn btn-default selected_transaction_query <?php echo "selected-".$key;?>"><?php echo Yii::app()->functions->translateDate($months_val)?></a>
					<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="GET" class="report form-horizontal" >
					<?php echo CHtml::hiddenField('start_date',isset($_GET['start_date'])?$_GET['start_date']:"")?>
					<?php echo CHtml::hiddenField('end_date',isset($_GET['end_date'])?$_GET['end_date']:"")?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Merchant Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('merchant_id',
							isset($_GET['merchant_id'])?$_GET['merchant_id']:""
							,
							(array)Yii::app()->functions->merchantList2(true)
							,array(
							'class'=>'chosen form-control'
							))
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Start Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('start_date1',
							isset($_GET['start_date1'])?$_GET['start_date1']:""
							,array(
							'class'=>'form-control j_date',
							'data-id'=>'start_date'
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","End Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('end_date1',
							isset($_GET['end_date1'])?$_GET['end_date1']:""
							,array(
							'class'=>'form-control j_date',
							'data-id'=>'end_date'
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList('stats_id[]',$total_commission_status,(array)$order_stats,array(
							'class'=>"chosen form-control",
							'multiple'=>true
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Payment Type")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('payment_type',
							isset($_GET['payment_type'])?$_GET['payment_type']:1
							,array(
							1=>t("All payment type"),
							2=>t("Cash"),
							3=>t("Card")
							),
							array(
							'class'=>"form-control"
							));
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-2">
							<input type="submit" class="btn btn-primary btn-block" value="<?php echo t("Search")?>" >
						</div>
						<div class="col-lg-2">
							<a href="javascript:;" rel="rptmerchantcommission" class="export_btn btn btn-default btn-block"><?php echo t("Export")?></a>
						</div>
					</div>
					<input type="hidden" name="action" id="action" value="merchantCommission">
					<input type="hidden" name="tbl" id="tbl" value="merchant">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="merchant_id">
					<input type="hidden" name="slug" id="slug" value="merchantAdd">
					<?php 
					echo CHtml::hiddenField('query',$query);
					echo CHtml::hiddenField('query_date',isset($_GET['date'])?$_GET['date']:'' );
					?>
					<table id="table_list" class="table table-striped table-bordered">
					   <thead>
							<tr>
								<th width="3%"><?php echo Yii::t("default","ID")?></th>
								<th width="7%"><?php echo Yii::t("default","Merchant Name")?></th>
								<th width="6%"><?php echo Yii::t("default","Total Price")?></th>
								<th width="5%"><?php echo Yii::t("default","Commission")?></th>            
								<th width="5%"></th>            
							</tr>
						</thead>
						<tbody>    
						</tbody>
					</table>
					<table class="table">
						<thead>
							<tr>            
								<th width="3%"></th>
								<th width="7%"></th>                        
								<th width="6%"><?php echo t("Total Commission Price")?>:</th>            
								<th width="5%"><div class="total_commission"></div></th>  
								<th width="5%"></th>  
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