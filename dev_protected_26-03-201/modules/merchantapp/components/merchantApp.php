<?php
class merchantApp
{	
	public static function moduleBaseUrl()
	{
		return Yii::app()->getBaseUrl(true)."/protected/modules/merchantapp";
	}
	
	public static function t($message='')
	{
		return Yii::t("default",$message);
	}
	
	public static function moduleName()
	{
		return self::t("Merchant Mobile App");
	}
	
	public static function parseValidatorError($error='')
	{
		$error_string='';
		if (is_array($error) && count($error)>=1){
			foreach ($error as $val) {
				$error_string.="$val\n";
			}
		}
		return $error_string;		
	}			
	
	public static function q($data)
	{
		return Yii::app()->db->quoteValue($data);
	}
	
	public static function generateUniqueToken($length,$unique_text=''){	
		$key = '';
	    $keys = array_merge(range(0, 9), range('a', 'z'));	
	    for ($i = 0; $i < $length; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }	
	    return $key.md5($unique_text);
	}
	
    public static function prettyPrice($amount='')
	{
		if(!empty($amount)){
			return displayPrice(getCurrencyCode(),prettyFormat($amount));
		}
		return 0;
	}	
		
	public static function login($username='',$password='')
	{
		$DbExt=new DbExt; 
		$stmt="SELECT * FROM
		{{merchant}}
		WHERE
		username=".self::q($username)."
		AND
		password=".self::q($password)."		
		AND
		status = 'active'	
		LIMIT 0,1
		";		 
		if ($res=$DbExt->rst($stmt)){			 
			$res=$res[0];
			$res['user_type']="admin";			
			
			// $token=self::generateUniqueToken(15,$res['username']);
			$token=$res['username'];
			$params=array(
			  'mobile_session_token'=>$token
			);					
			$DbExt->updateData("{{merchant}}",$params,'merchant_id',$res['merchant_id']);
			
			$res['token']=$token;			
			return $res;
		} else {					 
			$stmt=
			/*"SElECT * FROM
			{{merchant_user}}
			WHERE
			username=".self::q($username)."
			AND
			password=".self::q($password)."
			AND
			status = 'active'
			LIMIT 0,1";			 */
			"SElECT mt_merchant.restaurant_name, mt_merchant.street , mt_merchant.city , mt_merchant.state , mt_merchant_user.username , mt_merchant_user.merchant_user_id,mt_merchant_user.status,`mt_merchant`.`contact_name`,`mt_merchant`.`contact_phone` ,`mt_merchant`.`contact_email`,`mt_merchant`.`post_code`,`mt_merchant`.`merchant_id`,`mt_merchant`.`restaurant_phone`,`mt_merchant`.`restaurant_slug` , `mt_merchant`.service FROM mt_merchant_user	
			INNER JOIN mt_merchant ON mt_merchant.merchant_id = mt_merchant_user.`merchant_id`
			WHERE mt_merchant_user.username=".self::q($username)." AND mt_merchant_user.password=".self::q($password)." AND mt_merchant_user.status = 'active'	LIMIT 0,1"; 
			if ($res=$DbExt->rst($stmt)){				 
				$res=$res[0];
				
				// $token=self::generateUniqueToken(15,$res['username']);
				$token= $res['username'];
				$params=array(
				  'mobile_session_token'=>$token
				);					
				$DbExt->updateData("{{merchant_user}}",$params,'merchant_user_id',$res['merchant_user_id']);
			
			    $res['user_type']="user";
			    $res['token']=$token;			     
			    return $res;
			}
		}
		return false;
	}
	
	public static function validateToken($mtid='',$token='',$user_type='admin')
	{
		$DbExt=new DbExt;
		if ( $user_type=="admin"){
			$stmt="
			SELECT mobile_session_token,merchant_id,username FROM
			{{merchant}}
			WHERE
			merchant_id =".self::q($mtid)."
			AND
			mobile_session_token = ".self::q($token)."
			LIMIT 0,1
			";
			if ($res=$DbExt->rst($stmt)){
				$res[0]['user_type']="admin";
				return $res[0];
			}
		} else {
			$stmt="
			SELECT mobile_session_token,merchant_id,merchant_user_id,username   FROM
			{{merchant_user}}
			WHERE
			merchant_id =".self::q($mtid)."
			AND
			mobile_session_token = ".self::q($token)."
			LIMIT 0,1
			";
			if ($res=$DbExt->rst($stmt)){
				$res[0]['user_type']="user";
				return $res[0];
			}
		}
		return false;
	}
	
	public static function getUserByToken($token='')
	{
		$DbExt=new DbExt;
		
		$stmt="
		SELECT mobile_session_token,merchant_id  FROM
		{{merchant}}
		WHERE
		mobile_session_token = ".self::q($token)."
		LIMIT 0,1
		";
		if ($res=$DbExt->rst($stmt)){
			$res[0]['user_type']="admin";
			return $res[0];
		} else {		
			$stmt="
			SELECT merchant_user_id,mobile_session_token,merchant_id  FROM
			{{merchant_user}}
			WHERE			
			mobile_session_token = ".self::q($token)."
			LIMIT 0,1
			";
			if ($res=$DbExt->rst($stmt)){
				$res[0]['user_type']="user";
				return $res[0];
			}
		}
		return false;
	}	
	
	public static function getUserByEmail($email_address='')
	{
		$DbExt=new DbExt;
		$stmt="
		SELECT merchant_id,contact_email FROM
		{{merchant}}
		WHERE
		contact_email =".self::q($email_address)."
		LIMIT 0,1
		";
		if ($res=$DbExt->rst($stmt)){
			$res[0]['user_type']="admin";
			return $res[0];
		} else {
			$stmt="SELECT merchant_id,contact_email FROM
			{{merchant_user}}
			WHERE
			contact_email =".self::q($email_address)."
			LIMIT 0,1
			";
			if ($res=$DbExt->rst($stmt)){
				$res[0]['user_type']="user";
			    return $res[0];
			}
		}
		return false;
	}
	
	public static function getMerchantByCode($lost_pass_code='',$email_address='',$user_type='')
	{
		$DbExt=new DbExt;
		if ( $user_type=="admin"){
			$stmt="SELECT * FROM
			{{merchant}}
			WHERE
			contact_email =".self::q($email_address)."
			AND
			lost_password_code=".self::q($lost_pass_code)."
			LIMIT 0,1
			";
		}  else {
			$stmt="SELECT * FROM
			{{merchant_user}}
			WHERE
			contact_email =".self::q($email_address)."
			AND
			lost_password_code=".self::q($lost_pass_code)."
			LIMIT 0,1
			";
		}
		if( $res=$DbExt->rst($stmt)){
			return $res[0];
		}		
		return false;
	}	
	
	public static function getDeviceInfo($device_id='')
	{
		$DbExt=new DbExt;
		$stmt="
		SELECT * FROM
		{{mobile_device_merchant}}
		WHERE
		device_id=".self::q($device_id)."
		LIMIT 0,1
		";
		if( $res=$DbExt->rst($stmt)){
			return $res[0];
		}		
		return false;
	}
	
	public static function getDeviceByID($id='')
	{
		$DbExt=new DbExt;
		$stmt="
		SELECT * FROM
		{{mobile_device_merchant}}
		WHERE
		id=".self::q($id)."
		LIMIT 0,1
		";
		if( $res=$DbExt->rst($stmt)){
			return $res[0];
		}		
		return false;
	}	

	public static function paymentType()
	{
		return array(
		  'cod'=> t("Cash On delivery"),
		  'ocr'=> t("Offline Credit Card Payment"),
		  'pyp'=> t("Paypal"),
		  'pyr'=> t("Pay On Delivery"),
		  'stp'=> t("Stripe"),
		  'mcd'=> t("Mercadopago"),
		  'ide'=> t("Sisow"),
		  'payu'=> t("PayUMoney"),
		  'pys'=> t("Paysera"),
		  'bcy'=> t("Barclaycard"),
		  'epy'=> t("EpayBg"),
		  'atz'=> t("Authorize.net"),
		  'obd'=> t("Offline Bank Deposit ")
		);
	}	
	
    public static function orderStatusList($merchant_id='')
    {    	
    	$list='';    	
    	$db_ext=new DbExt;
    	$stmt="SELECT * FROM 
    	  {{order_status}} 
    	  WHERE
    	  merchant_id IN ('0','$merchant_id')
    	  ORDER BY stats_id";	    	
    	if ($res=$db_ext->rst($stmt)){
    		foreach ($res as $val) {       			
    			$list[$val['description']]=t($val['description']);
    		}
    		return $list;
    	}
    	return false;    
    }    	
    
    public static function getOrderHistory($order_id='')
    {
    	$db_ext=new DbExt;
    	$stmt="SELECT * FROM
    	{{order_history}}
    	WHERE
    	order_id =".self::q($order_id)."
    	ORDER BY date_created DESC
    	";
    	if ( $res=$db_ext->rst($stmt)){
    		return $res;
    	}
    	return false;
    }
    
    public static function availableLanguages()
    {
    	$lang['en']='English';
    	$stmt="
    	SELECT * FROM
    	{{languages}}
    	WHERE
    	status in ('publish','published')
    	";
    	$db_ext=new DbExt; 
    	if ($res=$db_ext->rst($stmt)){
    		foreach ($res as $val) {
    			$lang[$val['lang_id']]=$val['language_code'];
    		}    		
    	}
    	return $lang;
    }    
	
    public static function pushNewOrder($order_id='')
    {
    	   
    	if ( $res=Yii::app()->functions->getOrder($order_id)){
    		
    		if ($res['status']=="initial_order"){
    			return ;
    		}
    		
    		$merchant_id=$res['merchant_id'];
    		$client_id=$res['client_id'];    	
    		
    		$db_ext=new DbExt;
    		$stmt="
    		SELECT * FROM
    		{{mobile_device_merchant}}
    		WHERE
    		merchant_id =".self::q($merchant_id)."
    		AND
    		enabled_push ='1'
    		AND
    		status ='active'
    		
    		ORDER BY id ASC
    		LIMIT 0,20
    		";
    		    		
    		if ( $device=$db_ext->rst($stmt)){
    			
    			/*get the template*/
    			$title=getOptionA('push_tpl_new_order_title');    			
    			$content=getOptionA('push_tpl_new_order_content');  
    			  			
    			if ( empty($title) || empty($content)){
    				return ;
    			}

    			$title=smarty('order_id',$res['order_id'],$title);
    			$title=smarty('total_amount',self::prettyPrice($res['total_w_tax']),$title);
    			$title=smarty('merchant_name',$res['merchant_name'],$title);
    			$title=smarty('customer_name',$res['full_name'],$title);    			
    			$title=smarty('order_status',$res['status'],$title);
    			$title=smarty('trans_type',$res['trans_type'],$title);
    			$title=smarty('payment_type',$res['payment_type'],$title);
    			
    			$content=smarty('order_id',$res['order_id'],$content);
    			$content=smarty('total_amount',self::prettyPrice($res['total_w_tax']),$content);
    			$content=smarty('merchant_name',$res['merchant_name'],$content);
    			$content=smarty('customer_name',$res['full_name'],$content);    			
    			$content=smarty('order_status',$res['status'],$content);
    			$content=smarty('trans_type',$res['trans_type'],$content);
    			$content=smarty('payment_type',$res['payment_type'],$content);
    			    			
    			foreach ($device as $val) {    				
    				$params=array(
    				  'merchant_id'=>$val['merchant_id'],
    				  'user_type'=>$val['user_type'],
    				  'merchant_user_id'=>$val['merchant_user_id'],
    				  'device_platform'=>$val['device_platform'],
    				  'device_id'=>$val['device_id'],
    				  'push_title'=>$title,
    				  'push_message'=>$content,
    				  'date_created'=>date('c'),
    				  'ip_address'=>$_SERVER['REMOTE_ADDR'],
    				  'order_id'=>$order_id
    				);
    				$db_ext->insertData('{{mobile_merchant_pushlogs}}',$params);
    			}
    		} else echo 'no records';
    	}    	
    }
    
    public static function sendEmailSMS($order_id='')
    {
    	$_GET['backend']='';    	
    	    	    	
    	if ( $res=Yii::app()->functions->getOrder2($order_id)){    		
    		/*SEND EMAIL*/
    		
    		$tpl=self::getEmailTemplate($res['status']);    		    		
    		if (is_array($tpl) && count($tpl)>=1){
    			
    			$tpl['title']=smarty('customer_name',$res['full_name'],$tpl['title']);
    			$tpl['title']=smarty('order_id',$res['order_id'],$tpl['title']);
    			$tpl['title']=smarty('order_status',$res['status'],$tpl['title']);
    			$tpl['title']=smarty('remarks',$_GET['remarks'],$tpl['title']);
    			$tpl['title']=smarty('delivery_time',$_GET['delivery_time'],$tpl['title']);
    			
    			$tpl['content']=smarty('customer_name',$res['full_name'],$tpl['content']);
    			$tpl['content']=smarty('order_id',$res['order_id'],$tpl['content']);
    			$tpl['content']=smarty('order_status',$res['status'],$tpl['content']);
    			$tpl['content']=smarty('remarks',$_GET['remarks'],$tpl['content']);
    			$tpl['content']=smarty('delivery_time',$_GET['delivery_time'],$tpl['content']);
    			    			
    			$to=$res['email_address'];  
    			if (!empty($to)){
	    			if(sendEmail($to,'',$tpl['title'],$tpl['content'])){  
	    			} 
    			}
    		}
    		
    		
    		/*SEND SMS*/
    		$contact_phone=$res['contact_phone1'];    	
    		$sms_balance=Yii::app()->functions->getMerchantSMSCredit($res['merchant_id']);
    		/*dump($sms_balance);
    		dump($contact_phone); */
    		
    		/*check if merchant sms is enabled*/    		
    		$sms_enabled_alert=getOption($res['merchant_id'],'sms_enabled_alert');    

    		if  ( $sms_enabled_alert!=1){
    			return ;
    		}
    		

    		if (!empty($contact_phone) && $sms_balance>0 ){   

	    		$sms_tpl=self::getSMSTemplate($res['status']);	  

	    		if (!empty($sms_tpl)){	    			
	    			$sms_tpl=smarty('customer_name',$res['full_name'],$sms_tpl);
	    			$sms_tpl=smarty('order_id',$res['order_id'],$sms_tpl);
	    			$sms_tpl=smarty('order_status',$res['status'],$sms_tpl);
	    			$sms_tpl=smarty('remarks',$_GET['remarks'],$sms_tpl);
	    			$sms_tpl=smarty('delivery_time',$_GET['delivery_time'],$sms_tpl);
	    			if(isset($_GET['remarks'])&&!empty($_GET['remarks']))
	    			{
	    				$sms_tpl .= " Remarks : ".$_GET['remarks'];
	    			}	    			 
	    			$res_sms=Yii::app()->functions->sendSMS($contact_phone,$sms_tpl);	    			
	    			$params=array(
	    			  'client_id'=>isset($res['client_id'])?$res['client_id']:'',
	    			  'merchant_id'=>isset($res['merchant_id'])?$res['merchant_id']:'',
	    			  'client_name'=>isset($res['full_name'])?$res['full_name']:'',
					  'contact_phone'=>$contact_phone,
					  'sms_message'=>$sms_tpl,
					  'status'=>isset($res_sms['msg'])?$res_sms['msg']:'',
					  'gateway_response'=>isset($res_sms['raw'])?$res_sms['raw']:'',
					  'gateway'=>isset($res_sms['sms_provider'])?$res_sms['sms_provider']:'',
					  'date_created'=>date('c'),
					  'ip_address'=>$_SERVER['REMOTE_ADDR']
					);					
					$DbExt=new DbExt;
			        $DbExt->insertData("{{sms_broadcast_details}}",$params);
	    		}
	    		else
	    		{	    			
	    			/* $sms_tpl=smarty('customer_name',$res['full_name'],$sms_tpl);
	    			$sms_tpl=smarty('order_id',$res['order_id'],$sms_tpl);
	    			$sms_tpl=smarty('order_status',$res['status'],$sms_tpl);
	    			$sms_tpl=smarty('remarks',$_GET['remarks'],$sms_tpl);
	    			$sms_tpl=smarty('delivery_time',$_GET['delivery_time'],$sms_tpl);  */

$sms_tpl = " Hi ".$res['full_name']." Your order ".$res['order_id']." status is now ".$res['status']."\n"." Cuisine.JE ".$_GET['remarks'] ;
	    			
	    			$res_sms=Yii::app()->functions->sendSMS($contact_phone,$sms_tpl);	    			
	    			$params=array(
	    			  'client_id'=>isset($res['client_id'])?$res['client_id']:'',
	    			  'merchant_id'=>isset($res['merchant_id'])?$res['merchant_id']:'',
	    			  'client_name'=>isset($res['full_name'])?$res['full_name']:'',
					  'contact_phone'=>$contact_phone,
					  'sms_message'=>$sms_tpl,
					  'status'=>isset($res_sms['msg'])?$res_sms['msg']:'',
					  'gateway_response'=>isset($res_sms['raw'])?$res_sms['raw']:'',
					  'gateway'=>isset($res_sms['sms_provider'])?$res_sms['sms_provider']:'',
					  'date_created'=>date('c'),
					  'ip_address'=>$_SERVER['REMOTE_ADDR']
					);					
					$DbExt=new DbExt;
			        $DbExt->insertData("{{sms_broadcast_details}}",$params);

	    		}    		
    		}
    	}    	 
    }


        public function sendBookatableSms($merchant_id,$params)
    {	    					 
    					$sts = 1 ;
    					$balance=Yii::app()->functions->getMerchantSMSCredit($merchant_id);	    				
	    				if (is_numeric($balance) && $balance>=1)
	    				{
	    						$sms_provider=Yii::app()->functions->getOptionAdmin('sms_provider');    	    	    	    	
            					$sms_provider=strtolower($sms_provider);
	    					 	$merchant_number = $params['mobile'];
	    					 	$client_fullname = $params['booking_name'];	    					 	

	    					 	$person = " person ";
	    					 	if($params['number_guest']>1)
	    					 	{
	    					 		$person = " persons ";
	    					 	}

	    					 	$booking_notes = '';
	    					 	if(!empty($params['booking_notes']))
	    					 	{
	    					 		$booking_notes = " Note : ".$params['booking_notes'];
	    					 	}
 								
								 $booking_status = trim($params['booking_status']);	 								 
								 
								 



								 $find_words      = ["{customer-name}", "{booking-date}", "{booking-time}","{no-of-person}"];
								 $replace_words   = [$client_fullname,$params['date_booking'],$params['booking_time'],$params['number_guest']];								 
								if($booking_status=="approved")
								{
									if(!$merchant_sms_tpl = str_replace($find_words,$replace_words,Yii::app()->functions->getOptionAdmin('sms_alert_tbl_accept')))
									{
										$merchant_sms_tpl = " Hi ".$client_fullname." Your Table booking on ".$params['date_booking']." for ".$params['number_guest'].$person." is ".$booking_status." .".$booking_notes ;
									}
								} 
								else if($booking_status=="denied")
								{
									if(!$merchant_sms_tpl = str_replace($find_words,$replace_words,Yii::app()->functions->getOptionAdmin('sms_alert_tbl_rej')))
									{
										$merchant_sms_tpl = " Hi ".$client_fullname." Your Table booking on ".$params['date_booking']." for ".$params['number_guest'].$person." is ".$booking_status." .".$booking_notes ;
									}
								} 								
							 
	    					 	if(!empty($params['remarks']))
	    					 	{
	    					 			$merchant_sms_tpl .= " \n Remarks : ".$params['remarks'];
	    					 	}
		    					$resp=Yii::app()->functions->sendSMS($merchant_number,$merchant_sms_tpl);
					        	$params=array(
					        	  'merchant_id'=>$merchant_id,
					        	  'broadcast_id'=>"999999999",
					        	  'client_id'=> 0,
					        	  'client_name'=>$client_fullname,
					        	  'contact_phone'=>$merchant_number,
					        	  'sms_message'=>$merchant_sms_tpl,
					        	  'status'=>$resp['msg'],
					        	  'gateway_response'=>$resp['raw'],
					        	  'date_created'=>date('c'),
					        	  'date_executed'=>date('c'),
					        	  'ip_address'=>$_SERVER['REMOTE_ADDR'],
					        	  'gateway'=>$sms_provider
					        	);		
					        	$db_ext=new DbExt; 		        	        
					        	if($db_ext->insertData("{{sms_broadcast_details}}",$params))
					        	{
					        		$sts = 0 ;
					        	}				        	
			        	}
			        	return $sts;
    }
    




    public static function sendDriverSms($merchant_id,$params)
    {	 
    					$sts = 1 ;
    					$balance=Yii::app()->functions->getMerchantSMSCredit($merchant_id);	    				
	    				if (is_numeric($balance) && $balance>=1)
	    				{	    						 
	    						$sms_provider=Yii::app()->functions->getOptionAdmin('sms_provider');    	    	    	    	
            					$sms_provider=strtolower($sms_provider);
	    					 	$merchant_number = $params['mobile_no'];
	    					 	$client_fullname = $params['driver_name'];	    					 	
	    					 	$merchant_sms_tpl = " Hi ".$client_fullname.", Please deliver this order. ".$params['short_url'] ;	    					 	 
		    					$resp=Yii::app()->functions->sendSMS($merchant_number,$merchant_sms_tpl);
					        	$params=array(
					        	  'merchant_id'=>$merchant_id,
					        	  'broadcast_id'=>"999999999",
					        	  'client_id'=> 0,
					        	  'client_name'=>$client_fullname,
					        	  'contact_phone'=>$merchant_number,
					        	  'sms_message'=>$merchant_sms_tpl,
					        	  'status'=>$resp['msg'],
					        	  'gateway_response'=>$resp['raw'],
					        	  'date_created'=>date('c'),
					        	  'date_executed'=>date('c'),
					        	  'ip_address'=>$_SERVER['REMOTE_ADDR'],
					        	  'gateway'=>$sms_provider
					        	);		
					        	$db_ext=new DbExt; 		        	        
					        	if($db_ext->insertData("{{sms_broadcast_details}}",$params))
					        	{
					        		$sts = 0 ;
					        	}				        	
			        	}
			        	return $sts;
    }

	    public static function sendDriverSmswrongaddress($merchant_id,$params)
    {	
    					$sts = 1 ;
    					$balance=Yii::app()->functions->getMerchantSMSCredit($merchant_id);	    				
	    				if (is_numeric($balance) && $balance>=1)
	    				{
	    						$db_ext=new DbExt; 		        
	    						$sms_provider=Yii::app()->functions->getOptionAdmin('sms_provider');    	    	    	    	
            					$sms_provider=strtolower($sms_provider);
	    					 	$merchant_number = $params['mobile_no'];
	    					 	$client_fullname = $params['driver_name'];	
	    					 	$contact_details = '';
	    					 	if(isset($params['contact_phone']))    					 	
	    					 	{
	    					 		$contact_details = ' Please contact : '.$params['contact_phone'];
	    					 	}
	    					 	// $merchant_sms_tpl = " Hi ".$client_fullname." the client address is not reachable ".$contact_details ;	    				
	    					 	$merchant_sms_tpl = " Hi ".$client_fullname.", Please deliver this order. ".$params['short_url'] ;		 	 
		    					$resp=Yii::app()->functions->sendSMS($merchant_number,$merchant_sms_tpl);
					        	$params=array(
					        	  'merchant_id'=>$merchant_id,
					        	  'broadcast_id'=>"999999999",
					        	  'client_id'=> 0,
					        	  'client_name'=>$client_fullname,
					        	  'contact_phone'=>$merchant_number,
					        	  'sms_message'=>$merchant_sms_tpl,
					        	  'status'=>$resp['msg'],
					        	  'gateway_response'=>$resp['raw'],
					        	  'date_created'=>date('c'),
					        	  'date_executed'=>date('c'),
					        	  'ip_address'=>$_SERVER['REMOTE_ADDR'],
					        	  'gateway'=>$sms_provider
					        	);		
					        		        
					        	if($db_ext->insertData("{{sms_broadcast_details}}",$params))
					        	{
					        		$sts = 0 ;
					        	}				        	
			        	}
			        	return $sts;
    }    


    public static function getEmailTemplate($status='')
    {
    	switch ($status) {
    		case 'accepted':
    			$title=getOptionA('tpl_order_accept_title');
    			$content=getOptionA('tpl_order_accept_content');
    			break;
    	
    		case "decline":
    			$title=getOptionA('tpl_order_denied_title');
    			$content=getOptionA('tpl_order_denied_content');
    			break; 
    				
    		default:
    			$title=getOptionA('tpl_order_change_title');
    			$content=getOptionA('tpl_order_change_content');
    			break;
    	}
    	if (!empty($title)){
	    	return array(
	    	  'title'=>$title,
	    	  'content'=>$content
	    	);
    	} 
    	return false;
    }
    
    public static function getSMSTemplate($status='')
    {
    	switch ($status) {
    		case 'accepted':    			
    			$content=getOptionA('sms_tpl_order_accept_content');
    			break;
    	
    		case "decline":    			
    			$content=getOptionA('sms_tpl_order_denied_content');
    			break; 
    				
    		default:    			
    			$content=getOptionA('sms_tpl_order_change_content');
    			break;
    	}
    	if (!empty($content)){
	    	return $content;
    	} 
    	return false;
    }    
    
    public static function sendPush($platform='Android',$api_key='',$device_id='',$message='')
    {    	
    	if (empty($api_key)){
    		return array(
    		  'success'=>0,
    		  'results'=>array(
    		     array(
    		       'error'=>'missing api key'
    		     )
    		  )
    		);
    	}
    	if (empty($device_id)){
    		return array(
    		  'success'=>0,
    		  'results'=>array(
    		     array(
    		       'error'=>'missing device id'
    		     )
    		  )
    		);
    	}
    	    	
    	//$url = 'https://android.googleapis.com/gcm/send';
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
           'registration_ids' => array($device_id),
           'data' => $message,
        );
        //dump($fields);
        
        $headers = array(
		  'Authorization: key=' . $api_key,
		  'Content-Type: application/json'
        );
        //dump($headers);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));		
		$result = curl_exec($ch);
		if ($result === FALSE) {
		    //die('Curl failed: ' . curl_error($ch));
		   return array(
    		  'success'=>0,
    		  'results'=>array(
    		     array(
    		       'error'=>'Curl failed: '. curl_error($ch)
    		     )
    		  )
    		);
		}
		
        curl_close($ch);
        //echo $result; exit;
        $result=!empty($result)?json_decode($result,true):false;
        //dump($result);
        if ($result==false){
        	return array(
    		  'success'=>0,
    		  'results'=>array(
    		     array(
    		       'error'=>'invalid response from push service'
    		     )
    		  )
    		);
        }
        return $result;   
    }
    
	public static function isArray($data='')
	{
		if (is_array($data) && count($data)>=1){
			return true;
		}
		return false;
	}	
	
	public static function getMerchantNotification($merchant_id='',$user_type='',$merchant_user_id='')
	{		
		if ( $user_type=="admin"){
			$stmt="SELECT * FROM
			{{mobile_merchant_pushlogs}}
			WHERE
			merchant_id = ".self::q($merchant_id)."
			AND
			user_type =".self::q($user_type)."
			ORDER BY date_created DESC
			LIMIT 0,50
			";
		} else {
			$stmt="SELECT * FROM
			{{mobile_merchant_pushlogs}}
			WHERE
			merchant_id = ".self::q($merchant_id)."
			AND
			user_type =".self::q($user_type)."
			AND
			merchant_user_id =".self::q($merchant_user_id)."
			ORDER BY date_created DESC
			LIMIT 0,50
			";
		}
		//dump($stmt);
		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			return $res;
		}
		return false;
	}
	
	public static function searchOrderByMerchantId($order_id='',$merchant_id='')
	{
		if (is_numeric($order_id)){
			$stmt="
		    SELECT * FROM
		    {{order}}
		    WHERE
		    merchant_id =".self::q($merchant_id)."
		    AND
		    order_id =".self::q($order_id)."
		    AND 
			status NOT IN ('initial_order')					
		    ORDER BY order_id ASC
		    LIMIT 0,100
		    ";
		} else {
			$stmt="		
			SELECT a.* FROM
		    {{order}} a
		    WHERE
		    merchant_id =".self::q($merchant_id)."
		    AND 
			status NOT IN ('initial_order')					
		    AND
		    client_id IN (
		       select client_id
		       from {{client}}
		       where
		       first_name LIKE '".$order_id."%'
		       OR 
		       last_name LIKE '".$order_id."%'
		    )
		    ORDER BY order_id ASC
		    LIMIT 0,100
		    ";
		}				
		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			return $res;
		}
		return false;
	}
	
	public static function getPendingTables($merchant_id='')
	{
		$stmt="SELECT * FROM
		{{bookingtable}}
		WHERE
		merchant_id=".self::q($merchant_id)."
		AND
		status IN ('pending')
		ORDER BY booking_id DESC
		LIMIT 0,100		
		";
		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			return $res;
		}
		return false;
	}
	
	public static function getAllBooking($merchant_id='')
	{
		$stmt="SELECT * FROM
		{{bookingtable}}
		WHERE
		merchant_id=".self::q($merchant_id)."
		ORDER BY booking_id DESC
		LIMIT 0,100		
		";
		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			return $res;
		}
		return false;
	}	
	
	public static function getBookingDetails($merchant_id='',$booking_id='')
	{
		$stmt="SELECT a.*,
		b.restaurant_name 
		FROM 
		{{bookingtable}} a
		left join {{merchant}} b
        ON
        a.merchant_id =  b.merchant_id
		
		WHERE
		a.merchant_id=".self::q($merchant_id)."
		
		AND
		booking_id =".self::q($booking_id)."		
		LIMIT 0,1
		";		

		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			return $res[0];
		}
		return false;
	}		
	
	public static function savePushTable($merchant_id='',$booking_id='')
	{
		if ( $res=merchantApp::getBookingDetails($merchant_id,$booking_id)){
			
			$subject=Yii::app()->functions->getOptionAdmin('push_tpl_booking_title');
			$content=Yii::app()->functions->getOptionAdmin('push_tpl_booking_content');
			
			
			$subject=smarty('merchant_name',$res['restaurant_name'],$subject);
       	    $subject=smarty('booking_name',$res['booking_name'],$subject);
       	    $subject=smarty('booking_date',
       	    Yii::app()->functions->FormatDateTime($res['date_booking'],false),$subject);
       	    $subject=smarty('booking_time',$res['booking_time'],$subject);
       	    $subject=smarty('number_of_guest',$res['number_guest'],$subject);
       	    $subject=smarty('booking_id',$res['booking_id'],$subject);       	    
       	    
       	    $content=smarty('merchant_name',$res['restaurant_name'],$content);
       	    $content=smarty('booking_name',$res['booking_name'],$content);
       	    $content=smarty('booking_date',
       	    Yii::app()->functions->FormatDateTime($res['date_booking'],false),$content);
       	    $content=smarty('booking_time',$res['booking_time'],$content);
       	    $content=smarty('number_of_guest',$res['number_guest'],$content);
       	    $content=smarty('booking_id',$res['booking_id'],$content);       	           	    
       	     

       	    if(isset($res['booking_name']))
       	    {
       	    	$subject = str_replace("{customer_name}",$res['booking_name'],$subject);
       	    	$content = str_replace("{customer_name}",$res['booking_name'],$content);
       	    }

       	    $params=array(       	      
       	      'push_title'=>$subject,
       	      'push_message'=>$content,
       	      'push_type'=>'booking',
       	      'date_created'=>date('c'),
       	      'ip_address'=>$_SERVER['REMOTE_ADDR'],
       	      'booking_id'=>$res['booking_id']
       	    );
       	    dump($params);
       	    
       	    if ( empty($subject) && !empty($content)){
       	    	return false;
       	    }
       	    
       	    $db_ext=new DbExt;
    		$stmt="
    		SELECT * FROM
    		{{mobile_device_merchant}}
    		WHERE
    		merchant_id =".self::q($res['merchant_id'])."
    		AND
    		enabled_push ='1'
    		AND
    		status='active'
    		
    		ORDER BY id ASC
    		LIMIT 0,20
    		";
    		    		
    		if ( $resp=$db_ext->rst($stmt)){
    			foreach ($resp as $val) {
    				$params['merchant_id']=$val['merchant_id'];
    				$params['user_type']=$val['user_type'];
    				$params['merchant_user_id']=$val['merchant_user_id'];
    				$params['device_id']=$val['device_id'];    				
    				$params['device_platform']=$val['device_platform'];
    				dump($params);
    				$db_ext->insertData('{{mobile_merchant_pushlogs}}',$params);
    			}
    		}
				       	   
		}
	}
		
	public static function hasModuleAddon($modulename='')
	{
		if (Yii::app()->hasModule($modulename)){
		   $path_to_upload=Yii::getPathOfAlias('webroot')."/protected/modules/$modulename";	
		   if(file_exists($path_to_upload)){
		   	   return true;
		   }
		}
		return false;
	}	
	
	public static function getTaskInfoByOrderID($order_id='')
	{
		$stmt="
		SELECT * FROM
		{{driver_task}}
		WHERE
		order_id=".self::q($order_id)."
		LIMIT 0,1
		";		
		
		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			return $res[0];
		}
		return false;
	}
	
	public static function getTeamByMerchantID($merchant_id='')
	{
		$stmt="
		SELECT * FROM
		{{driver_team}}
		WHERE
		user_id=".self::q($merchant_id)."
		AND
		user_type='merchant'
		AND
		status IN ('publish','published')
		ORDER BY team_name ASC	
		";				
		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			return $res;
		}
		return false;
	}
	
	public static function latToAdress($lat='' , $lng='')
	{
		$lat_lng="$lat,$lng";
		$protocol = isset($_SERVER["https"]) ? 'https' : 'http';
		if ($protocol=="http"){
			$api="http://maps.googleapis.com/maps/api/geocode/json?latlng=".urlencode($lat_lng);
		} else $api="https://maps.googleapis.com/maps/api/geocode/json?latlng=".urlencode($lat_lng);
		
		/*check if has provide api key*/
		$key=Yii::app()->functions->getOptionAdmin('google_geo_api_key');		
		if ( !empty($key)){
			$api="https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($lat_lng)."&key=".urlencode($key);
		}	
						
		if (!$json=@file_get_contents($api)){
			$json=Yii::app()->functions->Curl($api,'');
		}
		
		if (isset($_GET['debug'])){
			dump($api);		
			dump($json);    
		}
		
		$address_out='';
			
		if (!empty($json)){			
			$results = json_decode($json,true);				
			$parts = array(
			  'address'=>array('street_number','route'),			  
			  'city'=>array('locality'),
			  'state'=>array('administrative_area_level_1'),
			  'zip'=>array('postal_code'),
			  'country'=>array('country'),
			);		    
			if (!empty($results['results'][0]['address_components'])) {
			  $ac = $results['results'][0]['address_components'];
			  foreach($parts as $need=>$types) {
				foreach($ac as &$a) {		          					  
					  if (in_array($a['types'][0],$types)){
						  if (in_array($a['types'][0],$types)){
							  if($need=="address"){
								  if(isset($address_out[$need])) {
									 $address_out[$need] .= " ".$a['long_name'];
								  } else $address_out[$need]= $a['long_name'];
							  } else $address_out[$need] = $a['long_name'];			          	  	  
						  }
					  } elseif (empty($address_out[$need])) $address_out[$need] = '';	
				}
			  }
			  
			  if(!empty($results['results'][0]['formatted_address'])){
				 $address_out['formatted_address']=$results['results'][0]['formatted_address'];
			  }
			  
			  return $address_out;
			} 				
		}			
		return false;
	}
	
    public static function getDeliveryAddressByOrderID($order_id='')
	{
		$stmt="
		SELECT * FROM
		{{order_delivery_address}}
		WHERE
		order_id=".self::q($order_id)."
		LIMIT 0,1
		";				
		$DbExt=new DbExt; 
		if ( $res=$DbExt->rst($stmt)){
			unset($DbExt);
			return $res[0];
		}
		unset($DbExt);
		return false;
	}	
	
	public static function addToTask($order_id='' , $task_status='')
	{		
		$db=new DbExt;
		
		if($order_id<=0){
			return ;
		}
		$order_status=Yii::app()->functions->getOptionAdmin('drv_order_status');	
		if(empty($order_status)){
			$order_status='accepted';
		}
		
		$plus_hour=Yii::app()->functions->getOptionAdmin('drv_delivery_time');
		if(empty($plus_hour)){
			$plus_hour=0;
		}
		
		//check if the order has been cancel
		if (!empty($task_status)){
			$drv_order_cancel=Yii::app()->functions->getOptionAdmin('drv_order_cancel');
			if(empty($drv_order_cancel)){
				$drv_order_cancel='cancelled';
			}		
						
			if($task_status==$drv_order_cancel){
				if ( $ras=Driver::getTaskByOrderID($order_id)){					
					$params=array(
					    'status'=>'cancelled',
					    'date_modified'=>date('c'),
					    'ip_address'=>$_SERVER['REMOTE_ADDR']
					);				
					$db->updateData("{{driver_task}}",$params,'order_id',$order_id);
					
					/*update assigment*/
					$sql_assign="
					UPDATE {{driver_assignment}}
					SET task_status='cancelled'
					WHERE
					task_id =".self::q($ras['task_id'])."
					";							
					$db->qry($sql_assign);
					Driver::sendDriverNotification('CANCEL_TASK',$ras);					
					return ;
				}
			}
			
		}
						
		$stmt="
		SELECT a.*,
		concat(b.first_name,' ' ,b.last_name) as customer_name,
		b.email_address,
		concat( c.street,' ', c.city, ' ', c.state,' ',c.zipcode ,' ', c.country ) as delivery_address,
		c.contact_phone	as contact_number,
		c.formatted_address,
		c.google_lat,
		c.google_lng
		
		FROM
		{{order}} a
		
		left join {{client}} b
		ON
		b.client_id=a.client_id
		
		left join {{order_delivery_address}} c
		ON
		c.order_id=a.order_id
		
		WHERE
		a.order_id = '".$order_id."'
		AND
		a.status in ('$order_status','paid')
		AND
		a.trans_type in ('delivery')
		AND
		a.order_id NOT IN (
		  select order_id
		  from
		  {{driver_task}}
		  WHERE
		  order_id=a.order_id		  
		)
		
		LIMIT 0,1
		";		
		//dump($stmt);
		if ( $res=$db->rst($stmt)){
			foreach ($res as $val) {
				
				//dump($val);
				$lat=0;
				$long=0;			
				
				$delivery_date=!empty($val['delivery_date'])?$val['delivery_date']:date("Y-m-d");
				if(!empty($val['delivery_time'])){
					//$delivery_date.=" ".$val['delivery_time'];					
					$delivery_date=" ".date("Y-m-d G:i",strtotime($delivery_date." ".$val['delivery_time']." +$plus_hour hour" ));	
				} else {
					//$delivery_date.=" 23:00";					
					$delivery_date.= " ".date("G:i",strtotime("+$plus_hour hour"));
				}
	
				$driver_owner_task=getOptionA('driver_owner_task');
				if($driver_owner_task=="default"){
					$driver_owner_task='merchant';
				} 
				if(empty($driver_owner_task)){
				   $driver_owner_task='admin';	
				}
				
				$params=array(
				  'order_id'=>$val['order_id'],
				  //'user_type'=>'merchant',
				  'user_type'=>$driver_owner_task,
				  'user_id'=>$val['merchant_id'],
				  'trans_type'=>$val['trans_type'],				  
				  'email_address'=>isset($val['email_address'])?$val['email_address']:'',
				  'customer_name'=>isset($val['customer_name'])?$val['customer_name']:'',
				  'contact_number'=>isset($val['contact_number'])?$val['contact_number']:'',
				  'delivery_date'=>$delivery_date,
				  'delivery_address'=>isset($val['delivery_address'])?$val['delivery_address']:'' ,				  
				  'date_created'=>date('c'),
				  'ip_address'=>$_SERVER['REMOTE_ADDR']
				);
				
				if (!empty($val['google_lat']) && !empty($val['google_lng'])){
					$params['task_lat']=$val['google_lat'];
					$params['task_lng']=$val['google_lng'];
				} else {
					if ( $location=Driver::addressToLatLong($params['delivery_address'])){
						$params['task_lat']=$location['lat'];
						$params['task_lng']=$location['long'];
					}
				}
						
				if(!empty($val['formatted_address'])){
					$params['delivery_address']=addslashes($val['formatted_address']);
				}
				
				//dump($params);
				$db->insertData("{{driver_task}}",$params);
			}
		} //else echo 'no records';
	}	    
	
	
    public static function getTaskDistance($lat1='',$lon1='', $lat2='',$lon2='',
    $transport_type='')
    {    	 
    	 $use_curl=getOptionA('google_use_curl');    	
    	 $key=Yii::app()->functions->getOptionAdmin('google_geo_api_key');
    	 
    	 $units_params='imperial';    	 
    	 
    	 $home_search_unit_type=getOptionA('home_search_unit_type');    	 
    	 if(!empty($home_search_unit_type)){
    	 	if($home_search_unit_type=="km"){
    	 	   $units_params='metric';
    	 	} 
    	 }
    	 
    	 switch ($transport_type) {
    	 	case "truck":
    	 	case "car":
    	 	case "scooter":
    	 		$method='driving';
    	 		break;
    	 
    	 	case "bicycle":    	 		
    	 		$method='bicycling';
    	 		break;
    	 			
    	    case "walk":    	 		
    	 		$method='walking';
    	 		break;
    	 				
    	 	default:
    	 		$method='driving';
    	 		break;
    	 }
    	     	 
    	 $url="https://maps.googleapis.com/maps/api/distancematrix/json";
	  	 $url.="?origins=".urlencode("$lat1,$lon1");
	  	 $url.="&destinations=".urlencode("$lat2,$lon2");
	  	 $url.="&mode=".urlencode($method);    	  
	  	 $url.="&units=".urlencode($units_params);
	  	 if(!empty($key)){
	  	 	$url.="&key=".urlencode($key);
	  	 }
	  	 	  	
	  	 if (!$data=@file_get_contents($url)){
			$data=Yii::app()->functions->Curl($url,'');
		}
		
	  	 $data = json_decode($data,true);  
	  	 	  	 
	  	 if(is_array($data) && count($data)>=1){
	  	 	//dump($data);
	  	 	if($data['rows'][0]['elements'][0]['status']=="OK"){	  		
	  	 		return $data['rows'][0]['elements'][0]['duration']['text'];
	  	 	} 
	  	 }
	  	 return false;
    }	
    
    public static function sendPushBookingTable($client_id='', $data='' , $status='' , $remarks='')
    {
    	if (!merchantApp::hasModuleAddon("mobileapp")){	
    		return ;
    	}
    	
    	if($client_id<=0){
    		return ;
    	}
    	
    	if (!self::isTableExist("mobile_registered_view")){
    		return ;
    	}
    	
    	if (!self::isTableExist("mobile_push_logs")){
    		return ;
    	}
    	    	
    	$db=new DbExt;
    	$stmt="
    	SELECT client_id,device_id,device_platform,status,client_name FROM
    	{{mobile_registered_view}}
    	WHERE
    	client_id=".self::q($client_id)."
    	AND status='active'    	
    	LIMIT 0,1
    	";
    	if(!$customer_info=$db->rst($stmt)){
    		return ;
    	}
    	$customer_info=$customer_info[0];    	
    	    	    
    	$push_tpl_title=''; $push_tpl_content='';	     

    	switch ($status) {
    		case "approved":    			
    		    $push_tpl_title = getOptionA('push_booking_accepted_title');
    		    $push_tpl_content = getOptionA('push_booking_accepted_content');
    			break;
    			
    		case "denied":
    			$push_tpl_title = getOptionA('push_booking_decline_title');
    		    $push_tpl_content = getOptionA('push_booking_decline_content');
    			break;
    	
    		default:
    			break;
    	}
    	
    	if (!empty($push_tpl_title) && !empty($push_tpl_content)){
    		$push_tpl_title=smarty('booking_id',$data['booking_id'],$push_tpl_title);
    		$push_tpl_title=smarty('number_guest',$data['number_guest'],$push_tpl_title);
    		$push_tpl_title=smarty('date_booking',$data['date_booking'],$push_tpl_title);
    		$push_tpl_title=smarty('booking_time',$data['booking_time'],$push_tpl_title);
    		$push_tpl_title=smarty('booking_name',$data['booking_name'],$push_tpl_title);
    		$push_tpl_title=smarty('mobile',$data['mobile'],$push_tpl_title);
    		$push_tpl_title=smarty('booking_notes',$data['booking_notes'],$push_tpl_title);
    		$push_tpl_title=smarty('remarks',$remarks,$push_tpl_title);
    		
    		$push_tpl_content=smarty('booking_id',$data['booking_id'],$push_tpl_content);
    		$push_tpl_content=smarty('number_guest',$data['number_guest'],$push_tpl_content);
    		$push_tpl_content=smarty('date_booking',$data['date_booking'],$push_tpl_content);
    		$push_tpl_content=smarty('booking_time',$data['booking_time'],$push_tpl_content);
    		$push_tpl_content=smarty('booking_name',$data['booking_name'],$push_tpl_content);
    		$push_tpl_content=smarty('mobile',$data['mobile'],$push_tpl_content);
    		$push_tpl_content=smarty('booking_notes',$data['booking_notes'],$push_tpl_content);
    		$push_tpl_content=smarty('remarks',$remarks,$push_tpl_content);
    		
    	    //dump($push_tpl_title); dump($push_tpl_content);
    	    
    	    $params=array(
    	      'client_id'=>$client_id,
    	      'client_name'=>$customer_info['client_name'],
    	      'device_platform'=>$customer_info['device_platform'],
    	      'device_id'=>$customer_info['device_id'],
    	      'push_title'=>$push_tpl_title,
    	      'push_message'=>$push_tpl_content,
    	      'date_created'=>date("Y-m-d G:i:s"),
    	      'ip_address'=>$_SERVER['REMOTE_ADDR'],
    	      'push_type'=>"booking"
    	    );    	    
    	    $db->insertData("{{mobile_push_logs}}",$params);
    	}
    	
    }
    
    
    public static function isTableExist($table_name='')
    {
    	$db=new DbExt;
    	$prefix=Yii::app()->db->tablePrefix;		
    	$stmt="show tables like '".$prefix.$table_name."' ";    	
    	if ($res=$db->rst($stmt)){    		
    		unset($db);
    		return $res;
    	}
    	unset($db);
    	return false;
    }
    
} /*end class*/