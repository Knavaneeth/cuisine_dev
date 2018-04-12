<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage/Do/AddCustom" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New Custom Link")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/customPage/Do/Assign" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","Assign Page")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="customPageList">
					<input type="hidden" name="tbl" id="tbl" value="custom_page">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="id">
					<input type="hidden" name="slug" id="slug" value="customPage">
					<table id="table_list" class="table table-striped table-bordered">  
					   <thead>
							<tr>
								<th><?php echo Yii::t("default","ID")?></th>
								<th><?php echo Yii::t("default","Slug")?></th>
								<th><?php echo Yii::t("default","Page Title")?></th>
								<th><?php echo Yii::t("default","Content")?></th>
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