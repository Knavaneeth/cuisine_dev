<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/merchantcommission" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","Back")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="POST" class="report form-horizontal" >
					<input type="hidden" name="action" id="action" value="merchantCommissionDetails">
					<input type="hidden" name="tbl" id="tbl" value="merchant">
					<?php echo CHtml::hiddenField('start_date',isset($_GET['start_date'])?$_GET['start_date']:"")?>
					<?php echo CHtml::hiddenField('end_date',isset($_GET['end_date'])?$_GET['end_date']:"")?>
					<?php echo CHtml::hiddenField('mtid',
					isset($_GET['mtid'])?$_GET['mtid']:''
					);?>
					<?php echo CHtml::hiddenField('where',
					isset($_GET['where'])?$_GET['where']:''
					);?>
					<?php echo CHtml::hiddenField('and',
					isset($_GET['and'])?$_GET['and']:''
					);?>
					<?php 
					/*$commission=0;
					if (isset($_GET['mtid'])){
						echo $_GET['mtid'];	
						if ( $commission=Yii::app()->functions->getMerchantCommission($_GET['mtid'])){		
							$commission=standardPrettyFormat($commission);
						}
					}*/
					?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Start Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('start_date1',''  
							,array(
							'class'=>'form-control j_date',
							'data-id'=>'start_date'
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","End Date")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('end_date1',''  
							,array(
							'class'=>'form-control j_date' ,
							'data-id'=>'end_date'
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-2">
							<input type="button" class="btn btn-primary btn-block" value="<?php echo t("Search")?>" onclick="sales_summary_reload();">
						</div>
						<div class="col-lg-2">
							<a href="javascript:;" rel="rptmerchantcommissiondetails" class="export_btn btn btn-default btn-block"><?php echo t("Export")?></a>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("Merchant Name")?>: <span  class="merchant_name"></span></b></h4>
					<table id="table_list" class="table table-striped table-bordered">
					   <thead>
							<tr>            
								<th width="5%"><?php echo Yii::t("default","Reference #")?></th>
								<th width="5%"><?php echo Yii::t("default","Payment Type")?></th>                        
								<th width="5%"><?php echo Yii::t("default","Total Price")?></th>                        
								<th width="5%"><?php echo Yii::t("default","Commission (%)")?></th>            
								<th width="5%"><?php echo Yii::t("default","Commission price")?></th>  
								<th width="5%"><?php echo Yii::t("default","Date")?></th>  
							</tr>
						</thead>
						<tbody>    
						</tbody>
					</table>
					<table class="table">
						<thead>
							<tr>            
								<th width="5%"></th>
								<th width="5%"></th>                        
								<th width="5%"><?php echo t("Total Commission Price")?>:</th>            
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