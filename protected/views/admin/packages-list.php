<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/packagesAdd" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/packages" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/packages/Do/Sort" class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>
				</div>
			</div>
			<div class="panel-body">
				<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Packages List")?></b></h4>
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="packagesList">
					<input type="hidden" name="tbl" id="tbl" value="packages">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="package_id">
					<input type="hidden" name="slug" id="slug" value="packagesAdd">
					<table id="table_list" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th><?php echo Yii::t("default","ID")?></th>
								<th><?php echo Yii::t("default","Title")?></th>
								<th><?php echo Yii::t("default","Description")?></th>
								<th><?php echo Yii::t("default","Price")?></th>
								<th><?php echo Yii::t("default","Promo Price")?></th>
								<th><?php echo Yii::t("default","Expiration time(day)")?></th>
								<th><?php echo Yii::t("default","Usage")?></th>
								<th><?php echo Yii::t("default","Limit merchant by sell")?></th>
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