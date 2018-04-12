<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/merchantAdd" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<!--<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/merchantAddBulk" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Upload Bulk CSV")?></a>-->
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/merchant" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Merchant List")?></b></h4>
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="merchantList">
					<input type="hidden" name="tbl" id="tbl" value="merchant">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="merchant_id">
					<input type="hidden" name="slug" id="slug" value="merchantAdd">
					<table id="table_list" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th><?php echo Yii::t("default","Merchant ID")?></th>
								<th><?php echo Yii::t("default","Merchant Name")?></th>            
								<?php if (getOptionA('home_search_mode')!="postcode"):?>
								<th><?php echo Yii::t("default","Address")?></th>
								<th><?php echo Yii::t("default","City")?></th>
								<th><?php echo Yii::t("default","Country")?></th>
								<?php else :?>
								<th><?php echo Yii::t("default","Street address")?></th>
								<th><?php echo Yii::t("default","post code")?></th>
								<?php endif;?>
								<th><?php echo Yii::t("default","Contact")?></th>
								<th><?php echo Yii::t("default","Package")?></th>
								<th><?php echo Yii::t("default","Activation Code")?></th>
								<th><?php echo Yii::t("default","Charges Type")?></th>
								<th><?php echo Yii::t("default","Status")?></th>            
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