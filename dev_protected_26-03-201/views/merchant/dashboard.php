<?php if ( Yii::app()->functions->hasMerchantAccess("DashBoard")):?>
<div class="row">
	<div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
		<div class="card-box tilebox-one">
			<i class="fa fa-money pull-right text-muted"></i>
			<h6 class="text-muted text-uppercase m-b-20"><?php echo t("Your balance")?></h6>
			<h2 class="mb-0"><span class="merchant_total_balance commission_loader"></span></h2>
		</div>
	</div>

	<div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
		<div class="card-box tilebox-one">
			<i class="fa fa-money pull-right text-muted"></i>
			<h6 class="text-muted text-uppercase m-b-20"><?php echo t("SMS balance")?></h6>
			<h2 class="mb-0"><?php Widgets::smsBalance();?></h2>
		</div>
	</div>

	<div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
		<div class="card-box tilebox-one">
			<i class="fa fa-money pull-right text-muted"></i>
			<h6 class="text-muted text-uppercase m-b-20"><?php echo t("Fax balance")?></h6>
			<h2 class="mb-0"><?php Widgets::FaxBalance();?></h2>
		</div>
	</div>

	<div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
		<div class="card-box tilebox-one">
			<i class="fa fa-cutlery pull-right text-muted"></i>
			<h6 class="text-muted text-uppercase m-b-20">View Website</h6>
			<a href="<?php echo Yii::app()->request->baseUrl."/store/menu/merchant/".$merchant_info[0]->restaurant_slug;?>" target="_blank" class="btn btn-primary btn-block">View Website</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive m-b-30">
			<form id="frm_table_list" method="POST" class="report uk-form uk-form-horizontal merchant-dashboard" >
				<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","New Order List For Today")?> <?php echo FormatDateTime(date('c'),false); ?></b></h4>
				<input type="hidden" name="action" id="action" value="recentOrder">
				<input type="hidden" name="tbl" id="tbl" value="item">
				<table id="table_list" class="table table-striped table-bordered">
				   <thead>
						<tr> 
							<th><?php echo Yii::t('default',"Ref#")?></th>
							<th><?php echo Yii::t('default',"Name")?></th>
							<th><?php echo Yii::t('default',"Contact#")?></th>
							<th><?php echo Yii::t('default',"Item")?></th>            
							<th><?php echo Yii::t('default',"TransType")?></th>
							<th><?php echo Yii::t('default',"Payment Type")?></th>
							<th><?php echo Yii::t('default',"Total")?></th>
							<th><?php echo Yii::t('default',"Tax")?></th>
							<th><?php echo Yii::t('default',"Total W/Tax")?></th>
							<th><?php echo Yii::t('default',"Status")?></th>
							<th><?php echo Yii::t('default',"Date")?></th>
						</tr>
					</thead>
					<tbody>    
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="panel table-responsive">
			<div id="total_sales_chart" class="chart"></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel table-responsive">
			<div id="total_sales_chart_by_item" class="chart"></div>
		</div>
	</div>
</div>
<?php else :?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<h2><?php echo Yii::t("default","Welcome")?></h2>
		</div>
	</div>
</div>
<?php endif; ?>
