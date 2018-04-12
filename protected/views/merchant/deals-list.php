<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deals?Do=Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>				
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deals" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
                        <!--                <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/background_image/Do/Sort" class="btn btn-default"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a> -->
				</div>
			</div>
			<div class="panel-body">
				<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Deals List")?></b></h4>
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="merchant_deals_list">
					<input type="hidden" name="tbl" id="tbl" value="merchant_deals">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
                    <input type="hidden" name="whereid"  id="whereid" value="id">
                    <input type="hidden" name="slug" id="slug" value="deals">
					<table id="table_list" class="table table-striped table-bordered">
						<thead>
							<tr>
								<tr>								 
								<th><?php echo Yii::t("default","Title")?></th>
								<th><?php echo Yii::t("default","Description")?></th>            
								<th><?php echo Yii::t("default","From Date")?></th>
								<th><?php echo Yii::t("default","To Date")?></th> 
								<th><?php echo Yii::t("default","Status")?></th>								
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