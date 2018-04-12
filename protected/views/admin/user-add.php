<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<div class="merchant-btns">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/userList/Do/Add" class="btn btn-default"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/userList" class="btn btn-default"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
				</div>
			</div>
			<div class="panel-body">
				<?php 
				if (isset($_GET['id'])){
					if (!$data=Yii::app()->functions->getAdminUserInfo($_GET['id'])){
						echo "<div class=\"uk-alert uk-alert-danger\">".
						Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
						return ;
					}
				}
				?>                                   
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','addAdminUser')?>
					<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
					<?php if (!isset($_GET['id'])):?>
					<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/admin/userList/Do/Add")?>
					<?php endif;?>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","First Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('first_name',
							isset($data['first_name'])?$data['first_name']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Last Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('last_name',
							isset($data['last_name'])?$data['last_name']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t('default',"Email address")?></label>
						<div class="col-lg-6">
							<?php echo CHtml::textField("email_address",$data['email_address'],array(
							'class'=>"form-control",
							'data-validation'=>"required"
							))?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","User Name")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('username',
							isset($data['username'])?$data['username']:""
							,array('class'=>"form-control",'data-validation'=>"required"))
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","New Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::passwordField('password',
							'',array('class'=>"form-control"))
							?>
						</div>
					</div>
 					<div class="form-group">
						<label class="col-lg-2 control-label"><?php echo Yii::t("default","Confirm Password")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::passwordField('cpassword',
							'',array('class'=>"form-control"))
							?>
						</div>
					</div>
					<h4 class="mt-0 header-title"><b><?php echo t("User Access")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"></label>
						<div class="col-lg-6">
							<?php $menu=Yii::app()->functions->adminMenu();
							$user_access='';
							if (isset($data['user_access'])){
								$user_access=!empty($data['user_access'])?json_decode($data['user_access'],true):'';
							}
							?>
							<a href="javascript:;" class="admin-select-access"><?php echo t("Select All")?></a>
							|
							<a href="javascript:;" class="admin-unselect-access"><?php echo t("Unselect All")?></a>
							<ul class="admin-access-list">
								<li>
								<?php  
								echo CHtml::checkBox('user_access[]',
								in_array('autologin',(array)$user_access)?true:false
								,array(
								'value'=>autologin,
								'class'=>"icheck admin-acess"
								)); 
								echo t("Merchant Auto login")?>

								</li>
								<?php foreach ($menu['items'] as $val):?>
								<li>
									<?php 
									if ( $val['tag']=="logout"){
									continue;
									}
									echo CHtml::checkBox('user_access[]',
									in_array($val['tag'],(array)$user_access)?true:false
									,array(
									'value'=>$val['tag'],
									'class'=>"icheck admin-acess"
									)); 
									echo $val['label']?>

									<?php if (is_array($val['items']) && count($val['items'])>=1 ):?>
										<ul>
										<?php foreach ($val['items'] as $sub_val):?>
										<li>
										<?php 
										echo CHtml::checkBox('user_access[]',
										in_array($sub_val['tag'],(array)$user_access)?true:false
										,array(
										'value'=>$sub_val['tag'],
										'class'=>"icheck admin-acess"
										)); 
										echo $sub_val['label']?>
										</li>
										<?php endforeach;?>
										</ul>
									<?php endif;?>
								</li>
								<?php endforeach;?>
							</ul>
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