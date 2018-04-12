<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-body">
				<form id="frm_table_list" method="GET" class="report form-horizontal" >
					<?php echo CHtml::hiddenField('start_date',isset($_GET['start_date'])?$_GET['start_date']:"")?>
					<?php echo CHtml::hiddenField('end_date',isset($_GET['end_date'])?$_GET['end_date']:"")?>
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
							'class'=>'form-control j_date' ,
							'data-id'=>'end_date'
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-3">
							<input type="submit" class="btn btn-primary btn-block" value="Search" > 
						</div>
						<div class="col-lg-3">
							<a href="javascript:;" rel="merchanBbookingSummaryReport" class="export_btn btn btn-default btn-block"><?php echo Yii::t("default","Export")?></a>
						</div>
					</div>
					<h3 class="text-center"><?php echo t("Booking Summary Report")?></h3>
					<?php if (isset($_GET['start_date']) || isset($_GET['end_date'])):?>
					<p class="text-center"><?php echo prettyDate($_GET['start_date'])." ".t("and")." ".prettyDate($_GET['end_date'])?></p>
					<?php else :?>
					<p class="text-center"><?php echo t("As of")." ".date('F d Y')?></p>
					<?php endif;?>
					<input type="hidden" name="action" id="action" value="merchanBbookingSummaryReport">
					<input type="hidden" name="tbl" id="tbl" value="item">
					<table id="table_list" class="table table-striped table-bordered">
					   <thead>
							<tr>                         
							   <th><?php echo Yii::t('default',"Merchant Name")?></th> 
							   <th><?php echo Yii::t('default',"Total Approved")?></th> 
							   <th><?php echo Yii::t('default',"Total Denied")?></th> 
							   <th><?php echo Yii::t('default',"Total Pending")?></th> 
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