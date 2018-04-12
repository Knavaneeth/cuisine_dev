<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-body">
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="BankDepositList">
					<input type="hidden" name="tbl" id="tbl" value="bank_deposit">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="id">
					<input type="hidden" name="slug" id="slug" value="bankdeposit">
					<table id="table_list" class="table table-striped table-bordered"> 
						<thead>
							<tr>
								<th><?php echo Yii::t("default","ID")?></th>
								<th><?php echo Yii::t("default","TransType")?></th>
								<th><?php echo Yii::t("default","Merchant Name")?></th>
								<th><?php echo Yii::t("default","Branch Code")?></th>
								<th><?php echo Yii::t("default","Date")?></th>
								<th><?php echo Yii::t("default","Time")?></th>
								<th><?php echo Yii::t("default","Amount")?></th>
								<th><?php echo Yii::t("default","Scan Bank deposit slip")?></th>
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