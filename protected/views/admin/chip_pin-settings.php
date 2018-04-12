<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<?php
				$enabled_chip_pin=Yii::app()->functions->getOptionAdmin('admin_enabled_chip_pin');
				$chip_pin_mode=Yii::app()->functions->getOptionAdmin('admin_chip_pin_mode');
				?>
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','saveAdminChippinSettings')?>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Disabled Chip Pin")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('admin_enabled_chip_pin',
							Yii::app()->functions->getOptionAdmin('admin_enabled_chip_pin')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mode")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('admin_chip_pin_mode',
							$chip_pin_mode=="sandbox"?true:false
							,array(
							'value'=>"sandbox",
							'class'=>" "
							))
							?>
							<?php echo t("Sandbox")?> 
							<?php 
							echo CHtml::radioButton('admin_chip_pin_mode',
							$chip_pin_mode=="live"?true:false
							,array(
							'value'=>"live",
							'class'=>" "
							))
							?>	
							<?php echo t("Live")?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Card Fee")?></label>
						<div class="col-lg-3">
							<?php 
							echo CHtml::textField('admin_chip_pin_fee',
							Yii::app()->functions->getOptionAdmin('admin_chip_pin_fee')
							,array(
							'class'=>"form-control numeric_only"
							))
							?>
						</div>
					</div>


					<!-- Sand Box  -->

					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Sandbox")?></b></h4>
				<!--	<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin User ID ")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_sanbox_chip_pin_user',
							Yii::app()->functions->getOptionAdmin('admin_sanbox_chip_pin_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div> -->
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin Shared Secret")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_sanbox_chip_pin_pass',
							Yii::app()->functions->getOptionAdmin('admin_sanbox_chip_pin_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>		
						</div>	
					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin User Id")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_sandbox_chip_pin_user_id',
					Yii::app()->functions->getOptionAdmin('admin_sandbox_chip_pin_user_id')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin Password")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_sandbox_chip_pin_password',
					Yii::app()->functions->getOptionAdmin('admin_sandbox_chip_pin_password')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin Client Id")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_sandbox_chip_pin_client_id',
					Yii::app()->functions->getOptionAdmin('admin_sandbox_chip_pin_client_id')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>


					 
					 <!-- Live  -->
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Live")?></b></h4>
				<!--	<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_live_chip_pin_user ID',
							Yii::app()->functions->getOptionAdmin('admin_live_chip_pin_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div> -->
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin Shared Secret")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_live_chip_pin_pass',
							Yii::app()->functions->getOptionAdmin('admin_live_chip_pin_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>	

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin User Id")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_live_chip_pin_user_id',
					Yii::app()->functions->getOptionAdmin('admin_live_chip_pin_user_id')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin Password")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_live_chip_pin_password',
					Yii::app()->functions->getOptionAdmin('admin_live_chip_pin_password')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Chip Pin Client Id")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_live_chip_pin_client_id',
					Yii::app()->functions->getOptionAdmin('admin_live_chip_pin_client_id')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>


					<hr>
					<h4 class="mt-0 header-title"><b><?php echo t("Mobile Chip Pin payment Settings")?></b></h4>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Enabled Chip Pin")?>?</label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::checkBox('adm_chip_pin_mobile_enabled',
							getOptionA('adm_chip_pin_mobile_enabled')=="yes"?true:false
							,array(
							'value'=>"yes",
							'class'=>"icheck"
							))
							?> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mode")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::radioButton('adm_chip_pin_mobile_mode',
							getOptionA('adm_chip_pin_mobile_mode')=="sandbox"?true:false
							,array(
							'value'=>"sandbox",
							'class'=>" "
							))
							?>
							<?php echo t("Sandbox")?>
							<?php 
							echo CHtml::radioButton('adm_chip_pin_mobile_mode',
							getOptionA('adm_chip_pin_mobile_mode')=="live"?true:false
							,array(
							'value'=>"live",
							'class'=>" "
							))
							?>	
							<?php echo t("Live")?> 
						</div>
					</div>


<!-- Mobile Sandbox  -->
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Mobile Sandbox")?></b></h4>
				<!--	<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin User ID ")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_sanbox_chip_pin_user',
							Yii::app()->functions->getOptionAdmin('admin_mob_sanbox_chip_pin_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div> -->
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin Shared Secret")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_sanbox_chip_pin_pass',
							Yii::app()->functions->getOptionAdmin('admin_mob_sanbox_chip_pin_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin User Id")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_mob_sandbox_chip_pin_user_id',
					Yii::app()->functions->getOptionAdmin('admin_mob_sandbox_chip_pin_user_id')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin Password")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_mob_sandbox_chip_pin_password',
					Yii::app()->functions->getOptionAdmin('admin_mob_sandbox_chip_pin_password')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>

					<div class="form-group">
					<label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin Client Id")?></label>
					<div class="col-lg-6">
					<?php 
					echo CHtml::textField('admin_mob_sandbox_chip_pin_client_id',
					Yii::app()->functions->getOptionAdmin('admin_mob_sandbox_chip_pin_client_id')
					,array(
					'class'=>"form-control"
					))
					?>
					</div>
					</div>

<!-- Mobile live  -->
					 
					<h4 class="mt-0 header-title"><b><?php echo Yii::t("default","Mobile Live")?></b></h4>
				<!--	<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin User")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_live_chip_pin_user',
							Yii::app()->functions->getOptionAdmin('admin_mob_live_chip_pin_user')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div> -->
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin Shared Secret")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('admin_mob_live_chip_pin_pass',
							Yii::app()->functions->getOptionAdmin('admin_mob_live_chip_pin_pass')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>	


				<!-- 	<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Client ID")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textField('adm_chip_pin_mobile_clientid',
							getOptionA('adm_chip_pin_mobile_clientid')
							,array(
							'class'=>"form-control"
							))
							?>
						</div>
					</div>
 -->

						<div class="form-group">
						  <label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin User Id")?></label>
						  <div class="col-lg-6">
						  <?php 
						  echo CHtml::textField('admin_mobile_live_chip_pin_user_id',
						  Yii::app()->functions->getOptionAdmin('admin_mob_live_chip_pin_user_id')
						  ,array(
						    'class'=>"form-control"
						  ))
						  ?>
						</div>
						</div>

						<div class="form-group">
						  <label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin Password")?></label>
						  <div class="col-lg-6">
						  <?php 
						  echo CHtml::textField('admin_mobile_live_chip_pin_password',
						  Yii::app()->functions->getOptionAdmin('admin_mob_live_chip_pin_password')
						  ,array(
						    'class'=>"form-control"
						  ))
						  ?>
						</div>
						</div>

						<div class="form-group">
						  <label class="col-lg-2"><?php echo Yii::t("default","Mobile Chip Pin Client Id")?></label>
						  <div class="col-lg-6">
						  <?php 
						  echo CHtml::textField('admin_mobile_live_chip_pin_client_id',
						  Yii::app()->functions->getOptionAdmin('admin_mob_live_chip_pin_client_id')
						  ,array(
						    'class'=>"form-control"
						  ))
						  ?>
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