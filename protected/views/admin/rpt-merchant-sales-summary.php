<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-body">
				<form id="frm_table_list" method="GET" class="report form-horizontal" >
					<?php echo CHtml::hiddenField('start_date',isset($_GET['start_date'])?$_GET['start_date']:"")?>
					<?php echo CHtml::hiddenField('end_date',isset($_GET['end_date'])?$_GET['end_date']:"")?>
					<?php 
					$order_stats=Yii::app()->functions->orderStatusList2(false);    
					?>
  					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Merchant Name")?></label>
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
						<label class="col-lg-2"><?php echo Yii::t("default","Start Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('start_date1',
							isset($_GET['start_date1'])?$_GET['start_date1']:''
							,array(
							'class'=>'form-control j_date',
							'data-id'=>'start_date'
							))?>
						</div>
					</div>
  					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","End Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('end_date1',
							isset($_GET['end_date1'])?$_GET['end_date1']:''
							,array(
							'class'=>'form-control j_date',
							'data-id'=>'end_date'
							))?>
						</div>
					</div>
					<?php 
					$default=Yii::app()->functions->getCommissionOrderStatsArray();
					/*if (isset($_GET['stats_id'])){	
						if (is_array($_GET['stats_id']) && count($_GET['stats_id'])>=1){
							$default='';
							foreach ($_GET['stats_id'] as $stats_val) {
								$default[]=$stats_val;
							}
						}
					}*/
					if (isset($_GET['merchant_id'])){	
						$default=isset($_GET['stats_id'])?$_GET['stats_id']:'';
					}
					?>
  					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::dropDownList('stats_id[]',$default,(array)$order_stats,array(
							'class'=>"chosen form-control",
							'multiple'=>true
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-3">
							<!--<input type="button" class="btn btn-primary btn-block" value="Search" onclick="sales_summary_reload();">  -->
							<input type="submit" value="<?php echo t("Search")?>" class="btn btn-primary btn-block">
						</div>
						<div class="col-lg-3">
							<a href="javascript:;" rel="rptmerchantsalesummary" class="export_btn btn btn-default btn-block"><?php echo t("Export")?></a>
						</div>
					</div>
					<h3 style="text-align:center;"><?php echo t("Merchant Sales Summary Report")?></h3>
					<?php if (isset($_GET['start_date']) || isset($_GET['end_date'])):?>
					<p style="text-align:center;"><?php echo prettyDate($_GET['start_date'])." ".t("and")." ".prettyDate($_GET['end_date'])?></p>
					<?php else :?>
					<p style="text-align:center;"><?php echo t("As Of")?> <?php echo date("F d Y")?></p>
					<?php endif;?>
					<input type="hidden" name="action" id="action" value="rptMerchantSalesSummaryReport">
					<input type="hidden" name="tbl" id="tbl" value="item">
					<table id="table_list" class="table table-striped table-bordered">  
					   <thead>
							<tr> 
								<th><?php echo Yii::t('default',"Merchant Name")?></th>            
								<th><?php echo Yii::t('default',"Total Sales")?></th>                                    
								<th><?php echo Yii::t('default',"Total Commission")?></th>
								<th><?php echo Yii::t('default',"Merchant Earnings")?></th>
								<!--<th><?php echo Yii::t('default',"Approved No. Of Guests")?></th>-->
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