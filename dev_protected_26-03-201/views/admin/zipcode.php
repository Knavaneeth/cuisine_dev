<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/zipcode/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/zipcode" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<!--<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/zipcode/Do/Sort" class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>-->
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="ZipCodeList">
					<input type="hidden" name="tbl" id="tbl" value="zipcode">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="zipcode_id">
					<input type="hidden" name="slug" id="slug" value="zipcode">
					<table id="table_list" class="table table-striped table-bordered">  
					   <thead>
							<tr>
								<th><?php echo t("ID")?></th>
								<th><?php echo t("post code")?></th>
								<th><?php echo t("Country")?></th>
								<th><?php echo t("Street name")?></th>
								<th><?php echo t("City")?></th>
								<th><?php echo t("Area")?></th>
								<th><?php echo t("Date")?></th>
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