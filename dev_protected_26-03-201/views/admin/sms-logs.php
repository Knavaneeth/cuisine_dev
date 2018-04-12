<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/smslogs" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="smsLogs">
					<input type="hidden" name="tbl" id="tbl" value="sms_broadcast_details">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="id">
					<input type="hidden" name="slug" id="slug" value="smslogs">
					<table id="table_list" class="table table-striped table-bordered">  
					   <thead>
							<tr>
								<th><?php echo Yii::t("default","ID")?></th>
								<th><?php echo Yii::t("default","Gateway")?></th>
								<th><?php echo Yii::t("default","Merchant Name")?></th>
								<th><?php echo Yii::t("default","Mobile Number")?></th>
								<th><?php echo Yii::t("default","SMS Message")?></th>
								<th><?php echo Yii::t("default","Gateway Response")?></th>
								<th><?php echo Yii::t("default","Status")?></th>
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