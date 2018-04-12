<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Ratings/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Ratings" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<p class="text-danger"><?php echo Yii::t("default","Note: Maximum rating is 5")?></p>
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="ratingList">
					<input type="hidden" name="tbl" id="tbl" value="rating_meaning">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="id">
					<input type="hidden" name="slug" id="slug" value="Ratings">
					<table id="table_list" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th><?php echo Yii::t("default","Range 1")?></th>
								<th><?php echo Yii::t("default","Range 2")?></th>
								<th><?php echo Yii::t("default","Ratings")?></th>            
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