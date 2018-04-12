<?php
unset($_SESSION['pts_earn']);
unset($_SESSION['pts_redeem_amt']);

$this->renderPartial('/front/default-header',array(
   'h1'=>t("Thank You"),
   'sub_text'=>t("Your order has been placed.")
));

$data='';
$ok=false;
if ($data=Yii::app()->functions->getOrder2($_GET['id']))
{	  
	$merchant_id=$data['merchant_id'];
	$json_details=!empty($data['json_details'])?json_decode($data['json_details'],true):false;
	if ( $json_details !=false){
		Yii::app()->functions->displayOrderHTML(array(
		  'merchant_id'=>$data['merchant_id'],
		  'delivery_type'=>$data['trans_type'],
		  'delivery_charge'=>$data['delivery_charge'],
		  'packaging'=>$data['packaging'],
		  'cart_tip_value'=>$data['cart_tip_value'],
		  'cart_tip_percentage'=>$data['cart_tip_percentage'],
		  'card_fee'=>$data['card_fee'],
		  'points_discount'=>isset($data['points_discount'])?$data['points_discount']:'' 
		  ),$json_details,true);
		if ( Yii::app()->functions->code==1){
			$ok=true;
		}
	}

	 
	if(($data['full_name']==''))
	{		
			$guestdetails = array();
			if(isset($_SESSION['kr_client_details']))
			{
					$data['full_name'] 		= $_SESSION['kr_client_details']['first_name']." ".$_SESSION['kr_client_details']['last_name'];
					$data['contact_phone']  = $_SESSION['kr_client_details']['contact_phone'];
					$data['full_address']	= $_SESSION['kr_client_details']['street']." ".$_SESSION['kr_client_details']['city']. " ".$_SESSION['kr_client_details']['state']." ".$_SESSION['kr_client_details']['post_code'];
					// $data['orderid'] = $_GET['id']

					$guestdetails['client_name'] = $data['full_name'];
					$guestdetails['client_address'] = $data['full_address'];
					$guestdetails['client_contact_number'] = $data['contact_phone'];
					$guestdetails['order_id'] = $_GET['id'];
					Yii::app()->functions->saveGuestdetails($guestdetails);
			}
	}	

	$cash_mode = 'Paypal';
	$delivery_type = " Takeaway ";
	$delivery_pickup_time = $data['delivery_date']." ".$data['delivery_time'];
	if($data['payment_type']=="cash")
	{
		$cash_mode = 'COD';
	}
	if($data['trans_type']=="delivery")
	{
		$delivery_type = " Delivery ";
	}
} 
 
if(isset($_GET['citypay_success']))
{
	$cash_mode = 'Citypay';
	Yii::app()->functions->update_order($_GET['id']);
}

	$msg = "An order with Order id #".$data['order_id']." has been placed from Web by ".$data['full_name']." for ".$delivery_type." , Date / Time : ".$delivery_pickup_time." , Payment Type :  ".$cash_mode." , Amount : ".$data['bill_total'];
	$url = "https://hooks.slack.com/services/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";
	$useragent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
	$payload = 'payload={"channel": "#orders", "username": "Cuisine.JE", "text": "'.$msg.'", "icon_emoji": ":moneybag:"}';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent); //set our user agent
	curl_setopt($ch, CURLOPT_POST, TRUE); //set how many paramaters to post
	curl_setopt($ch, CURLOPT_URL,$url); //set the url we want to use
	curl_setopt($ch, CURLOPT_POSTFIELDS,$payload); 

    $result = curl_exec($ch); //execute and get the ingres_result_seek(result, position) 
	curl_close($ch);

// unset($_SESSION['kr_item']);
unset($_SESSION['kr_merchant_id']);
unset($_SESSION['voucher_code']);
unset($_SESSION['less_voucher']);
unset($_SESSION['shipping_fee']);
unset($_SESSION['kr_client_details']);

$print='';

$order_ok=true;

$merchant_info=Yii::app()->functions->getMerchant(isset($merchant_id)?$merchant_id:'');
$full_merchant_address=$merchant_info['street']." ".$merchant_info['city']. " ".$merchant_info['state'].
" ".$merchant_info['post_code'];


?>
<div class="page-content">
	<div class="container">
	<?php if ($ok==TRUE):?>
	<div class="row" id="receipt-content">
		<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
			<h1 class="order-title"><?php echo t("Order Details")?> <a href="javascript:;" class="print-receipt pull-right"><i class="fa fa-print"></i></a></h1>
			<table class="table table-striped order-det-table bg-white">
				<tbody>
					<tr>
						<td><?php echo Yii::t("default","Customer Name")?></td>
						<td class="text-right"><?php echo $data['full_name']?></td>
					</tr>	       
					<?php $print[]=array( 'label'=>Yii::t("default","Customer Name"), 'value'=>$data['full_name'] );?>	       
					<tr>
						<td><?php echo Yii::t("default","Merchant Name")?></td>
						<td class="text-right"><?php echo clearString($data['merchant_name'])?></td>
					</tr>       
					<?php $print[]=array( 'label'=>Yii::t("default","Merchant Name"), 'value'=>$data['merchant_name']); ?>
					<?php if (isset($data['abn']) && !empty($data['abn'])):?>	       
					<tr>
						<td><?php echo Yii::t("default","ABN")?></td>
						<td class="text-right"><?php echo $data['abn']?></td>
					</tr> 
					<?php 	       
					$print[]=array(
					 'label'=>Yii::t("default","ABN"),
					 'value'=>$data['abn']
					);
					?>
					<?php endif;?>
					<tr>
						<td><?php echo Yii::t("default","Telephone")?></td>
						<td class="text-right"><?php echo $data['merchant_contact_phone']?></td>
					</tr>	       
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Telephone"),
					'value'=>$data['merchant_contact_phone']
					);
					?>
					<tr>
						<td><?php echo Yii::t("default","Address")?></td>
						<td class="text-right"><?php echo $full_merchant_address?></td>
					</tr>    
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Address"),
					'value'=>$full_merchant_address
					);
					?>
					<tr>
						<td><?php echo Yii::t("default","TRN Type")?></td>
						<td class="text-right"><?php echo Yii::t("default",$data['trans_type'])?></td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","TRN Type"),
					'value'=>$data['trans_type']
					);
					?>
					<tr>
						<td><?php echo Yii::t("default","Payment Type")?></td>
						<td class="text-right"><?php echo strtoupper(t($data['payment_type']))?></td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Payment Type"),
					'value'=>strtoupper($data['payment_type'])
					);
					?>
					<?php if ( $data['payment_provider_name']):?>	      
					<tr>
						<td><?php echo Yii::t("default","Card#")?></td>
						<td class="text-right"><?php echo $data['payment_provider_name']?></td>
					</tr>
					<?php 	       
					$print[]=array(
					 'label'=>Yii::t("default","Card#"),
					 'value'=>strtoupper($data['payment_provider_name'])
					);
					?>
					<?php endif;?>	       	       
					<?php if ( $data['payment_type'] =="pyp"):?>
					<?php 
					$paypal_info=Yii::app()->functions->getPaypalOrderPayment($data['order_id']);	       
					?>	       
					<tr>
						<td><?php echo Yii::t("default","Paypal Transaction ID")?></td>
						<td class="text-right"><?php echo isset($paypal_info['TRANSACTIONID'])?$paypal_info['TRANSACTIONID']:'';?></td>
					</tr>
					<?php 	       
					$print[]=array(
					 'label'=>Yii::t("default","Paypal Transaction ID"),
					 'value'=>isset($paypal_info['TRANSACTIONID'])?$paypal_info['TRANSACTIONID']:''
					);
					?>
					<?php endif;?>
					<tr>
						<td><?php echo Yii::t("default","Reference #")?></td>
						<td class="text-right"><?php echo Yii::app()->functions->formatOrderNumber($data['order_id'])?></td>
					</tr>
					<?php 	       
					$print[]=array(
					 'label'=>Yii::t("default","Reference #"),
					 'value'=>Yii::app()->functions->formatOrderNumber($data['order_id'])
					);
					?>
					<?php if ( !empty($data['payment_reference'])):?>	      
					<tr>
						<td><?php echo Yii::t("default","Payment Ref")?></td>
						<td class="text-right"><?php echo $data['payment_reference']?></td>
					</tr>
					<?php
					$print[]=array(
					 'label'=>Yii::t("default","Payment Ref"),
					 'value'=>Yii::app()->functions->formatOrderNumber($data['order_id'])
					);
					?>
					<?php endif;?>
					<?php if ( $data['payment_type']=="ccr" || $data['payment_type']=="ocr"):?>	       
					<tr>
						<td><?php echo Yii::t("default","Card #")?></td>
						<td class="text-right"><?php echo $card=Yii::app()->functions->maskCardnumber($data['credit_card_number'])?></td>
					</tr>
					<?php 	       
					$print[]=array(
					 'label'=>Yii::t("default","Card #"),
					 'value'=>$card
					);
					?>
					<?php endif;?>
					<tr>
						<td><?php echo Yii::t("default","TRN Date")?></td>
						<td class="text-right">
						<?php 
						$trn_date=date('M d,Y G:i:s',strtotime($data['date_created']));
						echo Yii::app()->functions->translateDate($trn_date);
						?>
						</td>
					</tr>
					<?php 	       
					$print[]=array(
					 'label'=>Yii::t("default","TRN Date"),
					 'value'=>$trn_date
					);
					?>
					<?php if ($data['trans_type']=="delivery"):?>
					<?php if (isset($_SESSION['kr_delivery_options']['delivery_date'])):?>		       
					<tr>
						<td><?php echo Yii::t("default","Delivery Date")?></td>
						<td class="text-right">
						<?php 
						$deliver_date=prettyDate($_SESSION['kr_delivery_options']['delivery_date']);
						echo Yii::app()->functions->translateDate($deliver_date);
						?>
						</td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Delivery Date"),
					'value'=>$deliver_date
					);
					?>
					<?php endif;?>
					<?php if (isset($_SESSION['kr_delivery_options']['delivery_time'])):?>
					<?php if ( !empty($_SESSION['kr_delivery_options']['delivery_time'])):?>		       
					<tr>
						<td><?php echo Yii::t("default","Delivery Time")?></td>
						<td class="text-right"><?php echo Yii::app()->functions->timeFormat($_SESSION['kr_delivery_options']['delivery_time'],true)?></td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Delivery Time"),
					'value'=>Yii::app()->functions->timeFormat($_SESSION['kr_delivery_options']['delivery_time'],true)
					);
					?>
					<?php endif;?>
					<?php endif;?>
					<?php if (isset($_SESSION['kr_delivery_options']['delivery_asap'])):?>
					<?php if ( !empty($_SESSION['kr_delivery_options']['delivery_asap'])):?>		       
					<tr>
						<td><?php echo Yii::t("default","Deliver ASAP")?></td>
						<td class="text-right">
							<?php echo $delivery_asap=$_SESSION['kr_delivery_options']['delivery_asap']==1?t("Yes"):'';?>
						</td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Deliver ASAP"),
					'value'=>$delivery_asap
					);
					?>
					<?php endif;?>
					<?php endif;?>
					<tr>
						<td><?php echo Yii::t("default","Deliver to")?></td>
						<td class="text-right">
							<?php 		         
							if (!empty($data['client_full_address'])){
							echo $delivery_address=$data['client_full_address'];
							} else echo $delivery_address=$data['full_address'];		         
							?>
						</td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Deliver to"),
					'value'=>$delivery_address
					);
					?>
					<tr>
						<td><?php echo Yii::t("default","Delivery Instruction")?></td>
						<td class="text-right"><?php echo $data['delivery_instruction']?></td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Delivery Instruction"),
					'value'=>$data['delivery_instruction']
					);
					?>
					<tr>
						<td><?php echo Yii::t("default","Location Name")?></td>
						<td class="text-right">
						<?php 
						if (!empty($data['location_name1'])){
						$data['location_name']=$data['location_name1'];
						}
						echo $data['location_name'];
						?>
						</td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Location Name"),
					'value'=>$data['location_name']
					);
					?>
					<tr>
						<td><?php echo Yii::t("default","Contact Number")?></td>
						<td class="text-right">
						<?php 
						if ( !empty($data['contact_phone1'])){
						$data['contact_phone']=$data['contact_phone1'];
						}
						echo $data['contact_phone'];?>
						</td>
					</tr>       
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Contact Number"),
					'value'=>$data['contact_phone']
					);
					?>
					<?php if ($data['order_change']>=0.1):?>					
					<tr>
						<td><?php echo Yii::t("default","Change")?></td>
						<td class="text-right">
						<?php echo displayPrice( baseCurrency(), normalPrettyPrice($data['order_change']))?>
						</td>
					</tr>     
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Change"),
					'value'=>normalPrettyPrice($data['order_change'])
					);
					?>
					<?php endif;?>
					<?php else :?>
					<?php 
					if (isset($data['contact_phone1'])){
					if (!empty($data['contact_phone1'])){
						$data['contact_phone']=$data['contact_phone1'];
					}
					}
					?>		      
					<tr>
						<td><?php echo Yii::t("default","Contact Number")?></td>
						<td class="text-right"><?php echo $data['contact_phone']?></td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Contact Number"),
					'value'=>$data['contact_phone']
					);
					?>
					<?php if (isset($_SESSION['kr_delivery_options']['delivery_date'])):?>		       
					<tr>
						<td><?php echo Yii::t("default","Pickup Date")?></td>
						<td class="text-right">
						<?php echo $_SESSION['kr_delivery_options']['delivery_date']?>
						</td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Pickup Date"),
					'value'=>$_SESSION['kr_delivery_options']['delivery_date']
					);
					?>
					<?php endif;?>
					<?php if (isset($_SESSION['kr_delivery_options']['delivery_time'])):?>
					<?php if ( !empty($_SESSION['kr_delivery_options']['delivery_time'])):?>		       
					<tr>
						<td><?php echo Yii::t("default","Pickup Time")?></td>
						<td class="text-right"><?php echo $_SESSION['kr_delivery_options']['delivery_time']?></td>
					</tr>
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Pickup Time"),
					'value'=>$_SESSION['kr_delivery_options']['delivery_time']
					);
					?>
					<?php endif;?>
					<?php endif;?>
					<?php if ($data['order_change']>=0.1):?>					
					<tr>
						<td><?php echo Yii::t("default","Change")?></td>
						<td class="text-right">
						<?php echo displayPrice( baseCurrency(), normalPrettyPrice($data['order_change']))?>
						</td>
					</tr>  
					<?php 	       
					$print[]=array(
					'label'=>Yii::t("default","Change"),
					'value'=>$data['order_change']
					);
					?>
					<?php endif;?>
					<?php endif;?>
					<!--<tr>
					<td colspan="2"></td>
					</tr>-->
				</tbody>
			</table>
			<div class="receipt-wrap order-list-wrap">
				<?php echo $item_details=Yii::app()->functions->details['html'];?>
			</div>
		</div>
	</div>
	<?php else :?>
	<p class="text-warning"><?php echo t("Sorry but we cannot find what you are looking for.")?></p>
	<?php $order_ok=false;?>
	<?php endif;?>
	</div>
</div>

<?php 

$data_raw=Yii::app()->functions->details['raw'];

 


// $receipt=EmailTPL::salesReceipt($print,Yii::app()->functions->details['raw']);

$receipt=EmailTPL::salesReceiptmanual($print,$item_details);

//dump($receipt); 
$tpl=Yii::app()->functions->getOption("receipt_content",$merchant_id);
if (empty($tpl)){
	$tpl=EmailTPL::receiptTPL();
}
$tpl=Yii::app()->functions->smarty('receipt',$receipt,$tpl);
$tpl=Yii::app()->functions->smarty('customer-name',$data['full_name'],$tpl);
$tpl=Yii::app()->functions->smarty('receipt-number',Yii::app()->functions->formatOrderNumber($data['order_id']),$tpl);

$receipt_sender=Yii::app()->functions->getOption("receipt_sender",$merchant_id);
$receipt_subject=Yii::app()->functions->getOption("receipt_subject",$merchant_id);
if (empty($receipt_subject)){	
	$receipt_subject=getOptionA('receipt_default_subject');
	if (empty($receipt_subject)){
	    $receipt_subject="We have receive your order";
	}
}
if (empty($receipt_sender)){
	$receipt_sender='no-reply@'.$_SERVER['HTTP_HOST'];
}
$to=isset($data['email_address'])?$data['email_address']:'';

if (!isset($_SESSION['kr_receipt'])){
	$_SESSION['kr_receipt']='';
}

if (!in_array($data['order_id'],(array)$_SESSION['kr_receipt'])){	
	
	if ( $order_ok==false){
		return ;
	}
	

    sendEmail($to,$receipt_sender,$receipt_subject,$tpl);    
    
    /*send email to merchant address*/
    $merchant_notify_email=Yii::app()->functions->getOption("merchant_notify_email",$merchant_id);    
    $enabled_alert_notification=Yii::app()->functions->getOption("enabled_alert_notification",$merchant_id);    
    /*dump($merchant_notify_email);
    dump($enabled_alert_notification);   */
    if ( $enabled_alert_notification==""){   
    	 	
    	$merchant_receipt_subject=Yii::app()->functions->getOption("merchant_receipt_subject",$merchant_id);
    	
    	$merchant_receipt_subject=empty($merchant_receipt_subject)?t("New Order From").
    	" ".$data['full_name']:$merchant_receipt_subject;
    	
    	$merchant_receipt_content=Yii::app()->functions->getMerchantReceiptTemplate($merchant_id);
    	
    	$final_tpl='';    	
    	if (!empty($merchant_receipt_content)){
    		$merchant_token=Yii::app()->functions->getMerchantActivationToken($merchant_id);
    		$confirmation_link=Yii::app()->getBaseUrl(true)."/store/confirmorder/?id=".$data['order_id']."&token=$merchant_token";
    		$final_tpl=smarty('receipt-number',Yii::app()->functions->formatOrderNumber($data['order_id'])
    		,$merchant_receipt_content);    		
    		$final_tpl=smarty('customer-name',$data['full_name'],$final_tpl);
    		$final_tpl=smarty('receipt',$receipt,$final_tpl); 
    		$final_tpl=smarty('confirmation-link',$confirmation_link,$final_tpl); 
    	} else $final_tpl=$tpl;
    	    	
    	$global_admin_sender_email=Yii::app()->functions->getOptionAdmin('global_admin_sender_email');
    	if (empty($global_admin_sender_email)){
    		$global_admin_sender_email=$receipt_sender;
    	}     	
    	    	
    	// fixed if email is multiple
    	$merchant_notify_email=explode(",",$merchant_notify_email);    	
    	if (is_array($merchant_notify_email) && count($merchant_notify_email)>=1){
    		foreach ($merchant_notify_email as $merchant_notify_email_val) {    			
    			if(!empty($merchant_notify_email_val)){
    			sendEmail(trim($merchant_notify_email_val),$global_admin_sender_email,$merchant_receipt_subject,$final_tpl);
    			}
    		}
    	}    	    	
    }   
    
    // send SMS    
    Yii::app()->functions->SMSnotificationMerchant($merchant_id,$data,$data_raw);
        
    // SEND FAX
    Yii::app()->functions->sendFax($merchant_id,$_GET['id']);
    
}
$_SESSION['kr_receipt']=array($data['order_id']);
file_get_contents('https://www.cuisine.je/merchantapp/cron/getneworder');	

/*$merchant_json_list = Yii::app()->session['merchant_json_list']; 

if(isset($merchant_json_list)&&!empty($merchant_json_list))
{	
	$DbExt=new DbExt;
	file_get_contents('https://www.cuisine.je/merchantapp/cron/getneworder');		
	$external_json_stmt = 'SELECT * FROM mt_external_json WHERE `merchant_list` LIKE \'%"'.$merchant_id.'"%\'';							
			    			$json_res=$DbExt->rst($external_json_stmt);
			    			$merchant_lists = array(); 			    			
		    				foreach($json_res as $link_explore)
		    				{		    					
		    					if(!in_array($link_explore['websiteaddress'],$merchant_lists))
		    					{			    						
		    						$merchant_lists[] = $link_explore['websiteaddress'];
		    						$url = "https://int.robinhood.je/cjenewpost";		 		    						
		    						// $curl_response = Yii::app()->functions->getData($url,$merchant_json_list);	
		    					}		    					
		    					
		    				}
		    			//	unset(Yii::app()->session['merchant_json_list']);  
}   


$order_list_query = 'SELECT `mt_order`.`order_id` as order_id ,`mt_order`.`json_details`, `mt_client`.`first_name` , `mt_client`.`last_name`, `mt_order`.`delivery_charge`, `mt_order`.`trans_type`, `mt_order`.`card_fee` , `mt_order`.`discounted_amount`,`mt_order`.`payment_type`,`mt_order`.`total_w_tax`,`mt_order`.`date_created`, `mt_order_delivery_address`.* FROM `mt_order`

INNER JOIN `mt_order_delivery_address` ON `mt_order_delivery_address`.`order_id` = `mt_order`.`order_id`

INNER JOIN `mt_client`  ON `mt_client`.`client_id` = `mt_order_delivery_address`.`client_id`

WHERE `mt_order`.`order_id` = 347 ';


$order_item = $DbExt->rst($order_list_query); 
$order_detail = json_decode($order_item[0]['json_details']);
$responding_json = array();
$total_amount = 0;

$responding_json['id']					 = 347;
$responding_json['source']    		     = "cuisine.je";
$responding_json['acceptedAt'] 		     = date("d/m/Y H:i:s", time());
$responding_json['first_name']		     = $order_item[0]['first_name'];
$responding_json['surname'] 			 = $order_item[0]['last_name'];	
$responding_json['phone']                = $order_item[0]['contact_phone'];
$responding_json['fulfilment'] 			 = $order_item[0]['trans_type'];
$responding_json['address']['line1']	 = $order_item[0]['street']; 
$responding_json['address']['line2']	 = $order_item[0]['city'];
$responding_json['address']['parish'] 	 = $order_item[0]['state'];
$responding_json['address']['postcode']  = $order_item[0]['zipcode'];
$responding_json['address']['directions']=$order_item[0]['location_name'];

foreach( $order_detail as $order_details)
{	
	
	$get_item_num_query = " SELECT `item_num_by_size` FROM `mt_item` WHERE `item_id` =   ".$order_details->item_id."  ";
		$item_num_key=$DbExt->rst($get_item_num_query);				    					
		if($item_num_key[0]['item_num_by_size']!='')
		{				    						
			$item_numbers_list = json_decode($item_num_key[0]['item_num_by_size']);
			$get_item_number = 
			$size_name = '';
			if(isset($order_details->price)&&!empty($order_details->price))
			{
				$size_name = explode('|', $order_details->price);
			}
			if($size_name[1]!='')
			{			    					 	
				$get_size_query = "SELECT size_id FROM `mt_size` WHERE `size_name` = '".trim($size_name[1])."'";
				$size_key=$DbExt->rst($get_size_query); 
				if(isset($size_key[0]['size_id'])&&!empty($size_key[0]['size_id']))
				{					    							
					$item_number = $item_numbers_list->$size_key[0]['size_id'];
				}
			}
		}
			else
			{	 											
				$stmt2 = " SELECT `item_number` FROM `mt_item` WHERE `item_id` =  "
			.$order_details->item_id."  ";
			$res2=$DbExt->rst($stmt2);
		$item_number = isset($res2[0]['item_number'])?$res2[0]['item_number']:'';	
			}				    					 
	 
	  
	$total = 0 ;			    					 
	$item_price  = explode("|",$order_details->price);
	$item_pricing = '';
	if(isset($item_price[0])&&!empty($item_price[0]))
	{
			$item_pricing = $item_price[0];
	} 
	$total +=    ($order_details->qty * $item_pricing);
	$notes = '';
	if(isset($order_details->notes)&&!empty($order_details->notes))
	{
		$notes = $order_details->notes;
	}

	$options = '';
	if(isset($order_details->sub_item)&&sizeof($order_details->sub_item)>0)
	{
		foreach($order_details->sub_item as $sub_item_list)
		{
			foreach($sub_item_list as $sub_itm_lst)
			{
				$sub_itm_details = explode('|',$sub_itm_lst);	
				$sub_itm_id = $sub_itm_details[0];
				// echo $sub_itm_details[0] ."  ".$sub_itm_details[1]."  ".$sub_itm_details[2] ;
				$total += 1 * $sub_itm_details[1] ;
				$stmt3 = "SELECT `item_number` FROM `mt_subcategory_item` WHERE `sub_item_id` = ".$sub_itm_id." ";
				$res3=$DbExt->rst($stmt3);		    								
				$options[] = array('menuNumber'=>$res3[0]['item_number'],'price'=>$sub_itm_details[1]);			    							
				//$responding_json['items']['options'] = $options;	
			//	$responding_json['items']['options'] = 
			}
		}
	}
 
	$responding_json['items'][] = array('menuNumber'=>$item_number,'quantity'=>$order_details->qty,'unitPrice'=>$item_pricing,'options'=>$options,'notes'=>$notes,'total'=>$total);	
	$total_amount += $total;		    					 
}

$responding_json['deliveryCharge'] = isset($order_item[0]['delivery_charge'])?$order_item[0]['delivery_charge']:0;
$responding_json['paymentSurcharge'] = isset($order_item[0]['card_fee'])?$order_item[0]['card_fee']:0;
$responding_json['total'] 				=	 number_format($order_item[0]['total_w_tax'], 2, '.', ''));	
$responding_json['discount'] = isset($order_item[0]['discounted_amount'])?round($order_item[0]['discounted_amount'], 2):0;
$responding_json['payment'] = array('type'=>$order_item[0]['payment_type'],'amount'=>number_format($order_item[0]['total_w_tax'], 2, '.', ''));	
//print_r(json_encode($responding_json));



/*	


 {
	"id": 347,
	"source": "cuisine.je",
	"acceptedAt": "14\/06\/2017 08:33:05",
	"first_name": "Vadakkumalai",
	"surname": "Venkatachalam",
	"phone": "+44 7438 823475",
	"fulfilment": "delivery",
	"address": {
		"line1": "Hotel La Place ",
		"line2": "La Route Du Coin, ",
		"parish": "St Brelade ",
		"postcode": "JE3 8BT",
		"directions": "1990"
	},
	"items": [{
		"menuNumber": "22",
		"quantity": "1",
		"unitPrice": "6.5",
		"options": "",
		"notes": "",
		"total": 6.5
	}, {
		"menuNumber": "21",
		"quantity": "1",
		"unitPrice": "5.8",
		"options": "",
		"notes": "",
		"total": 5.8
	}, {
		"menuNumber": "23",
		"quantity": "1",
		"unitPrice": "7",
		"options": "",
		"notes": "",
		"total": 7
	}],
	"deliveryCharge": "0.0000",
	"paymentSurcharge": "0.0000",
	"discount": 0,
	"payment": {
		"type": "cod",
		"amount": "20.27"
	}
}




		    				
} */