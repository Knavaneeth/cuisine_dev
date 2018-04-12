<?php FunctionsV3::sectionHeader('Payment Information')?>
<?php // print_r($payment_list); exit; 
  $citypay_available = '' ;
?>
<?php if (is_array($payment_list) && count($payment_list)>=1):?>
<?php 
/* echo "<pre>";
print_r($payment_list);
echo "</pre>"; */
foreach ($payment_list as $key => $val):   
$payment_gateway_name = '';
$controller_name = Yii::app()->controller->action->id;
$restricted_payment = 'Citypay'; 
?>

    <div class="row">
    <?php 
    $payment_logo = "fa-gbp";
    if(($controller_name=="PaymentOption")||($controller_name=="paymentoption")||($controller_name=="guestcheckout"))
    {
      $restricted_payment = '';
    }
    if($val!=$restricted_payment) 
    {   
    if($val=="paypal"||$val=="Citypay"||$val=="Chippin")          
    {       
      if($val=="paypal") { $check_string = "enabled_paypal"; $payment_logo = "fa-cc-paypal"; $val = " Paypal (Also credit cards) "; } 
      if($val=="Citypay") { $payment_logo = "fa-credit-card-alt";  $check_string = "merchant_enabled_citypay";  $val = " Credit / Debit Cards ";         }
      if(trim($val)=="Chippin") {         
         $check_string = "merchant_enabled_chip_pin"; $payment_logo = "fa fa-credit-card"; $val = " Chip & PIN (Credit / Debit Cards) "; }   
        //print_r($citypay_available);
    
      $allow_loop =  Yii::app()->functions->getOption($check_string,$merchant_id);      
    }    
    if($allow_loop=="yes"||$val=="Cash On delivery")
    {
      if($check_string=="merchant_enabled_citypay")
      {
        $citypay_available   = array('available'=>'true');   
      }
     ?>
    
    <div class="col-xs-12 col-sm-12">
        <div class="radio radio-success">
            <!--<input type="radio" name="radio" id="radio-0">-->             
            <?php if(isset($delivery_type)&&(trim($delivery_type)=="pickup")&&($val=="Cash On delivery")) 
             { $val = "Cash on Takeaway"; } ?>
             <?php echo CHtml::radioButton('payment_opt',false,array('class'=>"payment_option",'value'=>$key))?>             
            <label for="radio-0" class="control-label payment-select"> <i class="fa <?php echo $payment_logo; ?> payment_choices" aria-hidden="true"></i> <?php echo $val?> </label>
        </div>
    </div> 
    <?php
    }
     } ?>
    </div> 
    
    <?php if ( $key=="cod"):?>
      <div class="row top10 indent20 change_wrap">
        <?php echo CHtml::textField('order_change','',array(
          'placeholder'=>t("change? For how much?"),
          'class'=>"form-control"
         ))?>
      </div>
      <?php endif;?>      
     <?php if ( $key=="pyr"):?>
	  <?php   
      $provider_list=Yii::app()->functions->getPaymentProviderMerchant($merchant_id);
      if ( Yii::app()->functions->isMerchantCommission($merchant_id)){	          	
          $provider_list=Yii::app()->functions->getPaymentProviderListActive();         	
      }	         
      ?>
      <div class="payment-provider-wrap top10">  
       <?php if (is_array($provider_list) && count($provider_list)>=1):?>
           <?php foreach ($provider_list as $val_provider_list):           
            ?>
           <div class="row">	       	       
                <div class="col-md-3 relative">
                <div class="checki">
                <?php echo CHtml::radioButton('payment_provider_name',false,array(
                  'class'=>"icheck checki",
                  'value'=>$val_provider_list['payment_name']
                ))?>	        
                </div>
                <img class="logo-small" src="<?php echo uploadURL()."/".$val_provider_list['payment_logo']?>">
                </div>
            </div>     
           <?php endforeach;?>	   
        <?php else :?>   
          <p class="uk-text-danger"><?php echo t("no type of payment")?></p>  
        <?php endif;?>  
      </div> <!--payment-provider-wrap-->
  <?php endif;?>
    
    
    
<?php endforeach;?>
<?php else:?>
<div class="alert alert-danger text-center">
	<?php echo t("No payment option available")?>
</div>
<?php endif;?>
<?php   
if(isset($citypay_available['available'])&&($citypay_available['available']=="true"))
  { ?>
<span class="payment_notes_span"> <b>*</b> Credit / Debit Card are powered by Citypay . </span>
<?php } ?>