<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/ManageCurrency/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/ManageCurrency" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="currencyList">
					<input type="hidden" name="tbl" id="tbl" value="currency">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="currency_code">
					<input type="hidden" name="slug" id="slug" value="ManageCurrency">
					<table id="table_list" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th><?php echo Yii::t("default","Currency Code")?></th>
								<th><?php echo Yii::t("default","Currency Symbol")?></th>
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