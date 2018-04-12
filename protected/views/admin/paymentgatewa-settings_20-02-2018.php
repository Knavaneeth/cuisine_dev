<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<form class="form-horizontal admin-settings-page forms" id="forms">
					<?php echo CHtml::hiddenField('action','paymentgatewaySettings')?>
					<?php 
					$paymentgateway=Yii::app()->functions->getMerchantListOfPaymentGateway();
					$list=FunctionsV3::PaymentOptionList();
					/* print_r($paymentgateway);
					echo "\n\n";
					print_r($list); */
					?>
					<h4 class="mt-0 header-title"><b><?php echo t("list of enabled payment gateway on merchant")?></b></h4>
					<div class="form-group">  
						<div class="col-lg-6">
							<ul>
							<?php foreach ($list as $key=>$val):?>
								<li class="checkbox"><?php 
								echo CHtml::checkBox('paymentgateway[]',
								in_array($key,(array)$paymentgateway)?true:false
								,array(
								'class'=>"check",
								'value'=>$key
								));
								echo "<label>".$val."</label>";
								?>
								</li>
							<?php endforeach;?>
							</ul>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-3">
							<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="btn btn-primary btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>