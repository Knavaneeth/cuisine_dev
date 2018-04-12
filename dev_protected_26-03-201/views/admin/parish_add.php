<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			
			<div class="panel-heading">
				<div class="merchant-btns">
				<!-- 	<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/deals/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Background_image" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a> -->
				</div>
			</div>

			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->edit_parish($_GET['id'])){
						echo "<div class=\"alert alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                              
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','add_parish')?>	
                    <?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
                   <div class="form-group">
							<div class="col-md-3"><?php echo t("Parish Name")?></div>
							<div class="col-md-9">
								<?php 
									echo CHtml::textField('parish_name',
									isset($data['parish_name'])?$data['parish_name']:'',
									array(
									'class'=>"form-control"
									));
							?>         
							</div>
						</div>                                           
                      <div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-6">
							 <?php  
							 $chk_box1_sts = true;
							 $chk_box2_sts = false;
							 if(($data['status'])!=""&&($data['status'])==1):
							 	$chk_box1_sts = false;
							 	$chk_box2_sts = true;
							 endif;
	                            echo "<label> Active </label>";
	                            echo CHtml::radioButton('status', $chk_box1_sts , array(
							    'value'=>'0',
							    'name'=>'btnname',
							    'uncheckValue'=>null
							));
							 echo "<label> InActive </label>";
							echo CHtml::radioButton('status', $chk_box2_sts, array(
							    'value'=>'1',
							    'name'=>'btnname',
							    'uncheckValue'=>null
							)); ?>							 
						</div>
					</div>					 
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>