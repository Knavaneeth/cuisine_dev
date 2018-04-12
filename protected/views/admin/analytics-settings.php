<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<div id="error-message-wrapper"></div>
				<form class="form-horizontal forms" id="forms">
					<?php echo CHtml::hiddenField('action','analyticsSetting')?>
					<p class="text-muted">
					<?php echo Yii::t("default","You can add your google analytics code here or any snippet code.")?>
					</p>
					<div class="form-group">
						<label class="col-lg-2"><?php echo Yii::t("default","Code")?></label>
						<div class="col-lg-6">
							<?php 
							echo CHtml::textArea('admin_header_codes',
							Yii::app()->functions->getOptionAdmin('admin_header_codes'),
							array('class'=>'form-control'))
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