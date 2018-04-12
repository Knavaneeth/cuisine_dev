<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Cuisine/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/Cuisine" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->GetCuisine($_GET['id'])){
						echo "<div class=\"alert alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                              
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addCuisine')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/Cuisine/Do/Add")?>
					<?php endif;?>
					<?php if ( Yii::app()->functions->multipleField()==2):?>
					<ul data-uk-tab="{connect:'#tab-content'}" class="uk-tab uk-active">
						<li class="uk-active" ><a href="#"><?php echo t("English")?></a></li>
						<?php if ( $fields=Yii::app()->functions->getLanguageField()):?>  
						<?php foreach ($fields as $f_val): ?>
						<li class="" ><a href="#"><?php echo $f_val;?></a></li>
						<?php endforeach;?>
						<?php endif;?>
					</ul>
					<ul class="uk-switcher" id="tab-content">
						<li class="uk-active"> 
							<div class="form-group">
								<label class="col-lg-2"><?php echo Yii::t("default","Cuisine Name")?></label>
								<div class="col-lg-6">
									<?php echo CHtml::textField('cuisine_name',
									isset($data['cuisine_name'])?stripslashes($data['cuisine_name']):""
									,array(
									'class'=>'form-control',
									'data-validation'=>"required"
									))?>  
								</div>
							</div>
						</li>
						<?php 
						$cuisine_name_trans=isset($data['cuisine_name_trans'])?json_decode($data['cuisine_name_trans'],true):'';   
						?>
						<?php if (is_array($fields) && count($fields)>=1):?>
						<?php foreach ($fields as $key_f => $f_val): ?>
						<li>
							<div class="form-group">
								<label class="col-lg-2"><?php echo Yii::t("default","Cuisine Name")?></label>
								<div class="col-lg-6">
									<?php echo CHtml::textField("cuisine_name_trans[$key_f]",
									array_key_exists($key_f,(array)$cuisine_name_trans)?$cuisine_name_trans[$key_f]:''
									,array(
									'class'=>'form-control',
									))?>  
								</div>
							</div>
						</li>
					<?php endforeach;?>
					<?php endif;?>
					</ul>
					<?php else :?>
 					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Cuisine Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('cuisine_name',
							isset($data['cuisine_name'])?$data['cuisine_name']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
					<?php endif;?>
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