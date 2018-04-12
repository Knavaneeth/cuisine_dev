<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/packagesAdd" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/packages" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->getPackagesById($_GET['id'])){
						echo "<div class=\"uk-alert uk-alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                          
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','packagesAdd')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/packagesAdd")?>
					<?php endif;?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Title")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField('title',
							isset($data['title'])?$data['title']:""
							,array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Description")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textArea('description',
							isset($data['description'])?$data['description']:""
							,array(
							'class'=>'form-control',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Price")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('price',
							isset($data['price'])?standardPrettyFormat($data['price']):""
							,array(
							'class'=>'form-control numeric_only',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Promo Price")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('promo_price',
							isset($data['promo_price'])?standardPrettyFormat($data['promo_price']):""
							,array(
							'class'=>'form-control numeric_only'  
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Type")?></label>
						<div class="col-lg-3">
							<?php
							echo CHtml::dropDownList('expiration_type',
							isset($data['expiration_type'])?$data['expiration_type']:'',
							Yii::app()->functions->ExpirationType(),array(
							'class'=>'form-control',
							'data-validation'=>"required"
							));
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Expiration (no. of days or Year)")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('expiration',
							isset($data['expiration'])?$data['expiration']:""
							,array(
							'class'=>'form-control numeric_only',
							'data-validation'=>"required"
							))?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Usage")?></label>
						<div class="col-lg-3">
							<?php
							echo CHtml::dropDownList('unlimited_post',
							isset($data['unlimited_post'])?$data['unlimited_post']:'',
							Yii::app()->functions->ListlimitedPost(),array(
							'data-validation'=>"required",
							'class'=>"unlimited_post form-control"
							));
							?>
						</div>
					</div>
					<div class="form-group post_limit_wrap">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Number of Food Item Can Add")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('post_limit',
							isset($data['post_limit'])?$data['post_limit']:""
							,array(
							'class'=>'form-control numeric_only',
							//'data-validation'=>"required"
							))?>
						</div>
					</div>
					<?php 
					$limit_sell=isset($data['sell_limit'])?$data['sell_limit']:"";
					$limit_sell=$limit_sell<=0?"":$limit_sell;
					?>
					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Limit merchant by sell")?></label>
						<div class="col-lg-3">
							<?php echo CHtml::textField('sell_limit',
							$limit_sell
							,array(
							'class'=>'form-control numeric_only',
							//'data-validation'=>"required"
							))?>
							<?php echo Yii::t("default","Per month")?>
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