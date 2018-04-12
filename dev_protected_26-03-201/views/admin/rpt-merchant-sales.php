<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-body">
				<form id="frm_table_list" method="POST" class="report form-horizontal" >
					<?php echo CHtml::hiddenField('start_date',isset($_GET['start_date'])?$_GET['start_date']:"")?>
					<?php echo CHtml::hiddenField('end_date',isset($_GET['end_date'])?$_GET['end_date']:"")?>
					<?php 
					$order_stats=Yii::app()->functions->orderStatusList2(false);    
					?>
    				<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Merchant Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::dropDownList('merchant_id','',
							(array)Yii::app()->functions->merchantList(true)
							,array(
							'class'=>'form-control',    
							))
							?>
						</div>
					</div>
    				<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Start Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('start_date1',''  
							,array(
							'class'=>'form-control j_date',
							'data-id'=>'start_date'
							))?>
						</div>
					</div>
    				<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","End Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('end_date1',''  
							,array(
							'class'=>'form-control j_date' ,
							'data-id'=>'end_date'
							))?>
						</div>
					</div>
    				<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList('stats_id[]',array(4),(array)$order_stats,array(
							'class'=>"chosen form-control",
							'multiple'=>true
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-3">
							<input type="button" class="btn btn-primary btn-block" value="<?php echo t("Search")?>" onclick="sales_summary_reload();">
						</div>
						<div class="col-lg-3">
							<a href="javascript:;" rel="rptAdminSalesMerchant" class="export_btn btn btn-default btn-block"><?php echo t("Export")?></a>
						</div>
					</div>
					<input type="hidden" name="action" id="action" value="rptAdminSalesRpt">
					<input type="hidden" name="tbl" id="tbl" value="item">
					<table id="table_list" class="table table-striped table-bordered">
					   <thead>
							<tr> 
								<th><?php echo Yii::t('default',"Ref#")?></th>
								<th><?php echo Yii::t('default',"Name")?></th>
								<th><?php echo Yii::t('default',"Item")?></th>            
								<th><?php echo Yii::t('default',"TransType")?></th>
								<th><?php echo Yii::t('default',"Payment Type")?></th>
								<th><?php echo Yii::t('default',"Total")?></th>
								<th><?php echo Yii::t('default',"Tax")?></th>
								<th><?php echo Yii::t('default',"Total W/Tax")?></th>
								<th><?php echo Yii::t('default',"Status")?></th>
								<th><?php echo Yii::t('default',"Date")?></th>
								<!--<th></th>-->
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