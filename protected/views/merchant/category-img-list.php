<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/ItemCategoryImage/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>					
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/ItemCategoryImage" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
                                <!--        <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/background_image/Do/Sort" class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a> 	-->
				</div>
			</div>
			<div class="panel-body">
				<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Category Image List")?></b></h4>
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="categoryimageList">
					<input type="hidden" name="tbl" id="tbl" value="item_category">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
                                        <input type="hidden" name="whereid"  id="whereid" value="id">
                                        <input type="hidden" name="slug" id="slug" value="ItemCategoryImage">
					<table id="table_list" class="table table-striped table-bordered">
						<thead>
							<tr>
								<tr>								 
								<th><?php echo Yii::t("default","Image")?></th>
                                                                <th><?php echo Yii::t("default","Category Name")?></th>
								<th><?php echo Yii::t("default","status")?></th>            
							</tr>         
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