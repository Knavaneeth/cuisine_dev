<div class="row">
	<div class="col-sm-12">
		<div class="panel table-responsive">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/subscriberlist" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
					<a href="javascript:;" rel="rptSubriberList" class="export_btn btn btn-default"><?php echo t("Export")?></a>
				</div>
			</div>
			<div class="panel-body">
				<form id="frm_table_list" method="POST" >
					<input type="hidden" name="action" id="action" value="subscriberList">
					<input type="hidden" name="tbl" id="tbl" value="newsletter">
					<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
					<input type="hidden" name="whereid"  id="whereid" value="id">
					<input type="hidden" name="slug" id="slug" value="subscriberlist">
					<table id="table_list" class="table table-striped table-bordered">  
						<thead>
							<tr>
								<th><?php echo Yii::t("default","ID")?></th>
								<th><?php echo Yii::t("default","Email address")?></th>                        
								<th><?php echo Yii::t("default","Date Created")?></th>            
								<th><?php echo Yii::t("default","I.P Address")?></th>            
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