<div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card-box tilebox-one">
                            <i class="fa fa-money pull-right text-muted"></i>
                            <h6 class="text-muted text-uppercase m-b-20"><?php echo t("Commission last 30 days")?></h6>
                            <h2 class="mb-0"><span class="commission_total_1 commission_loader"></span></h2>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card-box tilebox-one">
                            <i class="fa fa-money pull-right text-muted"></i>
                            <h6 class="text-muted text-uppercase m-b-20"><?php echo t("Commission today")?></h6>
                            <h2 class="mb-0"><span class="commission_total_2 commission_loader"></span></h2>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card-box tilebox-one">
                            <i class="fa fa-money pull-right text-muted"></i>
                            <h6 class="text-muted text-uppercase m-b-20"><?php echo t("Total Commission")?></h6>
                            <h2 class="mb-0"><span class="commission_total_3 commission_loader"></span></h2>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card-box tilebox-one">
                            <i class="fa fa-cutlery pull-right text-muted"></i>
                            <h6 class="text-muted text-uppercase m-b-20">View Website</h6>
							<a href="<?php echo Yii::app()->request->baseUrl;?>/store" target="_blank" class="btn btn-primary btn-block">View Website</a>
                        </div>
                    </div>
                </div>

<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","New Merchant Registration List For Today")?> <span class="uk-text-success"><?php echo FormatDateTime(date('c'),false); ?></span></b></h4>
			<p class="text-muted">
				<?php echo Yii::t("default","Merchant List")?>
			</p>
			<form id="frm_table_list" method="POST" class="report uk-form uk-form-horizontal" >
				<input type="hidden" name="action" id="action" value="newMerchantRegList">
				<input type="hidden" name="tbl" id="tbl" value="item">
				<table id="table_list" class="table table-striped table-bordered">
					<thead>
						<tr> 
							<th><?php echo Yii::t('default',"MerchantID")?></th>
							<th><?php echo Yii::t('default',"Merchant Name")?></th>
							<th><?php echo Yii::t('default',"Package Name")?></th>            
							<th><?php echo Yii::t('default',"Price")?></th>
							<th><?php echo Yii::t('default',"Payment Type")?></th>            
							<th><?php echo Yii::t('default',"Status")?></th>
							<th><?php echo Yii::t('default',"Date")?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>    
					</tbody>
				</table>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","New Merchant Payment List For Today")?> <span class="uk-text-success"><?php echo FormatDateTime(date('c'),false);//echo date('F d, Y')?></span></b></h4>
			<p class="text-muted">
				<?php echo Yii::t("default","Merchant Payment")?>
			</p>
			<form id="frm_table_list2" method="POST" class="report uk-form uk-form-horizontal" >
				<input type="hidden" name="action" id="action" value="rptMerchantPaymentToday">
				<input type="hidden" name="tbl" id="tbl" value="item">
				<table id="table_list2" class="table table-striped table-bordered">
					<thead>
						<tr> 
							<th><?php echo Yii::t('default',"TransID")?></th>
							<th><?php echo Yii::t('default',"Merchant Name")?></th>
							<th><?php echo Yii::t('default',"Package")?></th>            
							<th><?php echo Yii::t('default',"Price")?></th>
							<th><?php echo Yii::t('default',"Payment Type")?></th>
							<th><?php echo Yii::t('default',"Status")?></th>            
							<th><?php echo Yii::t('default',"Date")?></th> 
							<th></th> 
						</tr>
					</thead>
					<tbody>    
					</tbody>
				</table>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Incoming orders from merchant for today")?> <span class="uk-text-success"><?php echo FormatDateTime(date('c'),false); //echo date('F d, Y')?></span></b></h4>
			<form id="frm_table_list3" method="POST" class="report uk-form uk-form-horizontal" >
				<input type="hidden" name="action" id="action" value="rptIncomingOrders">
				<input type="hidden" name="tbl" id="tbl" value="item">
				<table id="table_list3" class="table table-striped table-bordered">  
				   <thead>
						<tr> 
							<th><?php echo Yii::t('default',"Ref#")?></th>
							<th><?php echo Yii::t('default',"Merchant Name")?></th>           
							<th><?php echo Yii::t('default',"Name")?></th>
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
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>