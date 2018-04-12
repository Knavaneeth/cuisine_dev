<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dishes/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dishes" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->GetDish($_GET['id'])){
						echo "<div class=\"uk-alert uk-alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                             
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addDish')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/dishes/Do/Add")?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Dish Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('dish_name',
							isset($data['dish_name'])?$data['dish_name']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<div class="form-group"> 
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Upload Icon")?></label>
						<div class="col-lg-6">
							<div style="display:inline-table;margin-left:1px;" class="btn btn-info" id="spicydish"><?php echo Yii::t('default',"Browse")?></div>	  
							<div  style="display:none;" class="spicydish_chart_status" >
								<div id="percent_bar" class="spicydish_percent_bar"></div>
								<div id="progress_bar" class="spicydish_progress_bar">
									<div id="status_bar" class="spicydish_status_bar"></div>
								</div>
							</div>		  
						</div>		  
					</div>
					<?php $spicydish=isset($data['photo'])?$data['photo']:'';?>
					<?php if (!empty($spicydish)):?>
					<div class="form-group"> 
					<?php else :?>
					<div class="form-group preview_spicydish">
					<?php endif;?>
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Preview")?></label>
						<div class="col-lg-6">
							<div class="image_preview_spicydish">
								<?php if (!empty($spicydish)):?>
								<input type="hidden" name="spicydish" value="<?php echo $spicydish;?>">
								<img class="uk-thumbnail" src="<?php echo Yii::app()->request->baseUrl."/upload/".$spicydish;?>?>" alt="" title="">
								<p><a href="javascript:rm_spicydish_preview();"><?php echo Yii::t("default","Remove image")?></a></p>
								<?php endif;?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Status")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::dropDownList('status',
							isset($data['status'])?$data['status']:"",
							(array)statusList(),          
							array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>