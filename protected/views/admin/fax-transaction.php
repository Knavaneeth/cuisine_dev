<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faxtransaction/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faxtransaction" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="faxTransactionList">
					<input type="hidden" name="tbl" id="tbl" value="fax_package_trans">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="id">
					<input type="hidden" name="slug" id="slug" value="faxtransaction">
					<table id="table_list" class="table table-striped table-bordered">
					  <caption><?php echo Yii::t("default","Merchant List")?></caption>
					   <thead>
							<tr>
								<th><?php echo Yii::t("default","ID")?></th>
								<th><?php echo Yii::t("default","Merchant Name")?></th>
								<th><?php echo Yii::t("default","Fax Package")?></th>
								<th><?php echo Yii::t("default","Price")?></th>
								<th><?php echo Yii::t("default","Credits")?></th>
								<th><?php echo Yii::t("default","Payment Type")?></th>
								<th><?php echo Yii::t("default","Date Created")?></th>            
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