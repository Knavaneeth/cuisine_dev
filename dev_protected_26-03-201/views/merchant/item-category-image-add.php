<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/ItemCategoryImage/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/ItemCategoryImage" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->Get_category_img($_GET['id'])){
						echo "<div class=\"alert alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                              
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','add_category_image')?>	
                                        <?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
 					 
                                    <div class="form-group">
						<label class="col-lg-3"><?php echo Yii::t('default',"Category Image")?></label>
						<div class="col-lg-6">
							<div style="display:inline-table;margin-left:1px;" class="button uk-button" id="bgimage"><?php echo Yii::t('default',"Browse",array('class'=>"form-control",'data-validation'=>"required"))?></div>	  
							<div  style="display:none;" class="photo_chart_status" >
								<div id="percent_bar" class="photo_percent_bar"></div>
								<div id="progress_bar" class="photo_progress_bar">
									<div id="status_bar" class="photo_status_bar"></div>
								</div>
							</div>						
						</div>
					</div>
					 
					 
                    <?php if (!empty($data['img_url'])):?>                    	
					<div class="form-group"> 
					<?php else :?>
					<div class="form-group">
						<?php endif;?>
						<label class="col-lg-3"><?php echo Yii::t('default',"Preview")?></label>
						<div class="image_preview col-lg-6">
						<?php if (!empty($data['img_url'])):?>							
						<input type="hidden" name="bgimage" value="<?php echo $data['img_url'];?>">
						<img class="uk-thumbnail uk-thumbnail uk-thumbnail-mini" src="<?php echo Yii::app()->request->baseUrl."/upload/".$data['img_url'];?>?>" alt="" title="">
						<p><a href="javascript:rm_preview();"><?php echo Yii::t("default","Remove image")?></a></p>
						<?php endif;?>
						</div>
					</div>
                                            
                        <div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Category Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('category_type',
                                                        isset($data['category_type'])?$data['category_type']:""						 
							,array('class'=>"form-control",'data-validation'=>"required"))
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
                                                         echo CHtml::radioButton('img_status', $chk_box1_sts , array(
    'value'=>'0',
    'name'=>'btnname',
    'uncheckValue'=>null
));
 echo "<label> InActive </label>";
echo CHtml::radioButton('img_status', $chk_box2_sts, array(
    'value'=>'1',
    'name'=>'btnname',
    'uncheckValue'=>null
)); 
                                                         ?>
							
							 
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