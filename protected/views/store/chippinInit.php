
<?php
$this->renderPartial('/front/banner-receipt', array(
	'h1' => t("Payment") ,
	'sub_text' => t("")
));
$this->renderPartial('/front/order-progress-bar', array(
	'step' => 4,
	'show_bar' => true
));
$data = '';
$data2 = '';
$params = '';
$error = '';
$merchant_id = '';
$ok = false;
$amount_details = array();
$request = array();
$sbct_lst = array();
$dir = dirname(__FILE__);
$host = getenv('REMOTE_ADDR');
$applicationPath = $dir;
$applicationEndpoint = $host . $applicationPath;
$get_order_id = $_GET['id']; 
$total_amount = 0;

if ($data = Yii::app()->functions->getOrder($_GET['id']))
{
	$merchant_id=$data['merchant_id'];	
	$chip_pin_con=Yii::app()->functions->getChipPinConnection($merchant_id);                     
	$chip_pin_merchant_id = '';
	$chip_pin_lisence_key = '';	 
	/*get admin paypal connection if merchant is commission*/
	if ( Yii::app()->functions->isMerchantCommission($merchant_id))
	{       
		unset($chip_pin_con);   	   
		$chip_pin_con=Yii::app()->functions->getChipPinConnectionAdmin();   	   	 
	}
	if(!empty($chip_pin_con[$chip_pin_con['mode']]['user'])&&!empty($chip_pin_con[$chip_pin_con['mode']]['psw'])&&!empty($chip_pin_con[$chip_pin_con['mode']]['SharedSecret'])&&!empty($chip_pin_con[$chip_pin_con['mode']]['client_id']))
	{
		$chip_pin_user_id  		= $chip_pin_con[$chip_pin_con['mode']]['user'];
		$chip_pin_password		= $chip_pin_con[$chip_pin_con['mode']]['psw'];
		$chip_pin_SharedSecret  = $chip_pin_con[$chip_pin_con['mode']]['SharedSecret'];
		$chip_pin_client_id     = $chip_pin_con[$chip_pin_con['mode']]['client_id'];
	}
	else
	{           
		$error = "Merchant Chip & Pin Credential not yet been set";
		$this->render('chippin_error',array('error'=>$error));
		exit;
	}    
 
 
	 
}

 
 
/*	$error = "Merchant Citypay Credential not yet been set";
	$this->render('citypay_error', array(
		'error' => $error
	));
	exit; */


 
 
 
 
 

 
?>

<div class="sections section-grey2 section-orangeform">
  <div class="container">  
    <div class="row top30">
       <div class="inner">
          <h1><?php
echo t("Pay using Chip & Pin") ?></h1>
          <div class="box-grey rounded text-center">	
          
          <?php

if (!empty($error)): ?>
           <p class="text-danger"><?php
	echo $error; ?></p>  
          <?php
else: ?> 
           <p><?php
	echo t("Please click on below button to Checkout .") ?></p>
	
<button type="button" id="payButtonId" class="btn btn-primary">Checkout Now</button>
          <?php
endif; ?>
               
          </div> <!--box-->
       </div> <!--inner-->
    </div> <!--row-->
  </div> <!--container-->
</div><!-- sections-->
<script src="/assets/rxp-js-master/jquery-1.11.3.min.js"></script>
<script src="/assets/rxp-js-master/dist/rxp-js.js"></script>
<script type="text/javascript"> 
	$(document).ready(function () {
		$.getJSON("http://dev.cuisine.je/store/Initiate_realex?order_id=<?php echo $get_order_id; ?>&merchant_id=<?php echo $merchant_id; ?>", function (jsonFromServerSdk) {
			RealexHpp.init("payButtonId", "http://dev.cuisine.je/store/Realexresponse?order_id=<?php echo $get_order_id; ?>&merchant_id=<?php echo $merchant_id; ?>", jsonFromServerSdk);
		});
	});
</script>