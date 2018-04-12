<?php
class ApiController extends CController
{	
	public $data;
	public $code=2;
	public $msg='';
	public $details='';
	
	public function __construct()
	{
		$this->data=$_GET;
		
		$website_timezone=Yii::app()->functions->getOptionAdmin("website_timezone");		 
	    if (!empty($website_timezone)){
	 	   Yii::app()->timeZone=$website_timezone;
	    }		 
	}
	
	public function beforeAction($action)
	{				
		/*check if there is api has key*/		
		$action=Yii::app()->controller->action->id;				
		if(isset($this->data['api_key'])){
			if(!empty($this->data['api_key'])){			   
			   $continue=true;
			   if($action=="getLanguageSettings" || $action=="registerMobile"){
			   	  $continue=false;
			   }
			   if($continue){
			   	   $key=getOptionA('merchant_app_hash_key');
				   if(trim($key)!=trim($this->data['api_key'])){
				   	 $this->msg=$this->t("api hash key is not valid");
			         $this->output();
			         Yii::app()->end();
				   }
			   }			
			}
		}		
		return true;
	}	
	
	public function actionIndex(){
		//throw new CHttpException(404,'The specified url cannot be found.');
	}		
	
	private function q($data='')
	{
		return Yii::app()->db->quoteValue($data);
	}
	
	private function t($message='')
	{
		return Yii::t("default",$message);
	}
		
    private function output()
    {
	   $resp=array(
	     'code'=>$this->code,
	     'msg'=>$this->msg,
	     'details'=>$this->details,
	     'request'=>json_encode($this->data)		  
	   );		   
	   if (isset($this->data['debug'])){
	   	   dump($resp);
	   }
	   
	   if (!isset($_GET['callback'])){
  	   	   $_GET['callback']='';
	   }    
	   
	   if (isset($_GET['json']) && $_GET['json']==TRUE){
	   	   echo CJSON::encode($resp);
	   } else echo $_GET['callback'] . '('.CJSON::encode($resp).')';		    	   	   	  
	   Yii::app()->end();
    }	
    
    public function actionLogin()
    {
        $Validator=new Validator;
		$req=array(
		  'username'=>$this->t("username is required"),
		  'password'=>$this->t("password is required")		  
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::login($this->data['username'],md5(urlencode(base64_decode($this->data['password'])))))
			{				
				if ($res['status']=="active" || $res['status']=="expired")
				{
					
					/*get device information and update*/
					if (isset($this->data['merchant_device_id']))
					{
						if ( $resp=merchantApp::getDeviceInfo($this->data['merchant_device_id']))
						{							
							$record_id=$resp['id'];
							
							$params['merchant_id']=$res['merchant_id'];		
							$params['user_type']=$res['user_type'];
							$params['date_modified']=date('c');
							$params['status']='active';
							
							if ( $res['user_type']=="admin"){
							    $params['merchant_user_id']=0;
							} else {								
								$params['merchant_user_id']=$res['merchant_user_id'];
							}											
							$DbExt=new DbExt;
							$DbExt->updateData('{{mobile_device_merchant}}',$params,'id',$record_id);
							
							/*now update all device previous use by user
							if ( $res['user_type']=="admin")
							{								
								$stmt_update="UPDATE
								{{mobile_device_merchant}}																
								SET status='inactive'
								WHERE
								merchant_id =".merchantApp::q($res['merchant_id'])."
								AND
								user_type ='admin'
								AND id NOT IN ('$record_id')
								";
								$DbExt->qry($stmt_update);
							} else 
							{								
								$stmt_update="UPDATE
								{{mobile_device_merchant}}																
								SET status='inactive'
								WHERE
								merchant_user_id  =".merchantApp::q($res['merchant_user_id'])."
								AND
								user_type ='user'
								AND id NOT IN ('$record_id')
								";
								$DbExt->qry($stmt_update);
							} */												
						}
					}
					
					$bookingtable = 'false';
					if(isset($res['merchant_id'])&&!empty($res['merchant_id']))
					{
						$bookingtable_result = Yii::app()->functions->getOption('merchant_table_booking',$res['merchant_id']);		
						if($bookingtable_result=='')
						{
							$bookingtable = 'true';
						}
					}
					

					$this->msg=$this->t("Successul");
					$this->code=1;					

 					$street =	isset($res['street'])?$res['street']:'';
 					$city   =   isset($res['city'])?$res['city']:'';
 					$state  =   isset($res['state'])?$res['state']:'';
 					$post_code = isset($res['post_code'])?$res['post_code']:'';
 					$restaurant_phone = isset($res['restaurant_phone'])?$res['restaurant_phone']:'';
 					$contact_phone    = isset($res['contact_phone'])?$res['contact_phone']:'';
 					$contact_name     = isset($res['contact_name'])?$res['contact_name']:'';
 					$restaurant_slug  = isset($res['restaurant_slug'])?$res['restaurant_slug']:'';
					
					$merchant_delivery_estimation = Yii::app()->functions->getOption('merchant_delivery_estimation',$res['merchant_id']);
					$merchant_pickup_estimation = Yii::app()->functions->getOption('merchant_pickup_estimation',$res['merchant_id']);

					$this->details=array(
					  'token'=>$res['token'],
					  'info'=>array(
					    'username'=>$res['username'],
					    'restaurant_name'=>$res['restaurant_name'],					    
					    'contact_email'=>$res['contact_email'],
					    'user_type'=>$res['user_type'],
					    'merchant_id'=>$res['merchant_id'],
					    'table_booking_available'=>$bookingtable,
					    'street'=>$street,
					    'city'=>$city,
					    'state'=>$state,
					    'post_code'=>$post_code,
					    'restaurant_phone'=>$restaurant_phone,
					    'contact_phone'=>$contact_phone,
					    'contact_name'=>$contact_name,
					    'delivery_estimation'=>$merchant_delivery_estimation,
					    'pickup_estimation'=>$merchant_pickup_estimation ,
					    'restaurant_slug'=>Yii::app()->getBaseUrl(true)."/store/menu/merchant/".$restaurant_slug
					  )
					);	
									
				} else $this->msg=$this->t("Login Failed. You account status is")." ".$res['status'];
			} else $this->msg=$this->t("either username or password is invalid");
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();
    }
    
    public function actionUpdateMerchantTimings()
    {
    	$merchant_delivery_estimation = '';
       	$Validator=new Validator;
		$req=array(		   
		  'merchant_id'=>$this->t("merchant id is required")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate())
		{	    		
              $merchant_delivery_estimation = $this->data['time'];
              /* if($this->data['time']>59)
              {
                $merchant_delivery_estimation =	Yii::app()->functions->convertToHoursMins($this->data['time'],'%02d hrs %02d min'); 
              } */
              Yii::app()->functions->updateOptionMerchant('merchant_delivery_estimation',$this->data['merchant_id'],$merchant_delivery_estimation);
               
				$this->code=1;
				$this->msg="Updated successfully";
				$this->details=$merchant_delivery_estimation;

			  /* $params=array('viewed'=>2);
			  $DbExt=new DbExt;
			  $DbExt->updateData("{{order}}",$params,'order_id',$this->data['order_id']);
			  if ( $res=$DbExt->rst($stmt))
			  {					
				$this->code=1; $this->msg="OK";							
				$this->code=1;
				$this->msg="OK";
				$this->details=$data;
			 } 
			 else 
			 {
			 	$this->msg=$this->t("no current orders");
			 }			 */
		} else { $this->msg=merchantApp::parseValidatorError($Validator->getError());	 }
		$this->output();  

    }



        public function actionUpdatePickupTimings()
    {
    	$merchant_delivery_estimation = '';
       	$Validator=new Validator;
		$req=array(		   
		  'merchant_id'=>$this->t("merchant id is required")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate())
		{	    		
              $merchant_delivery_estimation = $this->data['time'];
              /* if($this->data['time']>59)
              {
                $merchant_delivery_estimation =	Yii::app()->functions->convertToHoursMins($this->data['time'],'%02d hrs %02d min'); 
              } */
              Yii::app()->functions->updateOptionMerchant('merchant_pickup_estimation',$this->data['merchant_id'],$merchant_delivery_estimation);
               
				$this->code=1;
				$this->msg="Updated successfully";
				$this->details=$merchant_delivery_estimation;

			  /* $params=array('viewed'=>2);
			  $DbExt=new DbExt;
			  $DbExt->updateData("{{order}}",$params,'order_id',$this->data['order_id']);
			  if ( $res=$DbExt->rst($stmt))
			  {					
				$this->code=1; $this->msg="OK";							
				$this->code=1;
				$this->msg="OK";
				$this->details=$data;
			 } 
			 else 
			 {
			 	$this->msg=$this->t("no current orders");
			 }			 */
		} else { $this->msg=merchantApp::parseValidatorError($Validator->getError());	 }
		$this->output();  

    }




    public function actionAcceptedOrderList()
    {
    	$merchant_delivery_estimation = '';
       	$Validator=new Validator;
		$req=array(		   
		  'merchant_id'=>$this->t("merchant id is required"),
		  'date'=>$this->t("date is required"),
		);
		$data['accepted_order'] = '';
		$accepted_order_total = 0;
		$accepted_order_count = 0;

		$declined_order_count = 0 ;

		$citypay_total = 0;
		$citypay_count = 0;

		$paypal_total = 0;
		$paypal_count = 0;

		$cash_total = 0;
		$cash_count = 0;


		$data['declined_order'] = '';
		$Validator->required($req,$this->data);
		if ($Validator->validate())
		{	   

                if($merchant_accepted_orders = Yii::app()->functions->getAcceptedOrders($this->data['merchant_id'],$this->data['date']))
                {                	 
                	foreach ($merchant_accepted_orders as $orders_value) 
                	{                		 
                		if(strtolower($orders_value['status'])=="accepted"||strtolower($orders_value['status'])=="assigned")
                		{
                			$data['accepted_order'][] = $orders_value;
                			$accepted_order_total += $orders_value['total_w_tax'];
                			$accepted_order_count += 1;
                			if($orders_value['payment_type']=="cash")
                			{
                				$cash_total += $orders_value['total_w_tax'];
								$cash_count += 1;
                			}
                			else if($orders_value['payment_type']=="paypal")
                			{
                				$paypal_total += $orders_value['total_w_tax'];
								$paypal_count += 1;
                			}
                			else
                			{
                				$citypay_total += $orders_value['total_w_tax'];
								$citypay_count += 1;
                			}
                		}
                		else
                		{
                			// $data['declined_order'] = '';
                			$data['declined_order'][] = $orders_value;
                			$declined_order_count += 1;
                		}
                	}
                	$data['accepted_order_count'] = $accepted_order_count; 
                	$data['declined_order_count'] = $declined_order_count; 

                	$data['cash_total'] = $cash_total; 
                	$data['cash_count'] = $cash_count; 
                	$data['paypal_total'] = $paypal_total; 
                	$data['paypal_count'] = $paypal_count; 
                	$data['citypay_total'] = $citypay_total; 
                	$data['citypay_count'] = $citypay_count;                 	                	
                }
                
				$this->code=1;
				$this->msg="Updated successfully";
				$this->details=$data;
	 
		} else { $this->msg=merchantApp::parseValidatorError($Validator->getError());	 }
		$this->output();  
    }
    

    public function actionGetIpAddr()
    {
    	$Validator=new Validator;
    	$primary_ip	= '';
    	$kitchen_ip	= '';
		$req=array(		   
		  'merchant_id'=>$this->t("merchant id is required")	 
		);
		if ($Validator->validate())
		{
				$data['primary_ip']	=	yii::app()->functions->getOption('primary_ip',$this->data['merchant_id']); 				 
				$data['kitchen_ip']	=	yii::app()->functions->getOption('kitchen_ip',$this->data['merchant_id']); 				 
				 
				$this->code=1;
				$this->msg="success";
				$this->details=$data;
		}
		else { $this->msg=merchantApp::parseValidatorError($Validator->getError());	 }
		$this->output();  

    }

	public function actionUpdateIpAddr()
    {
    	$Validator=new Validator;
    	$primary_ip	= '';
    	$kitchen_ip	= '';
		$req=array(		   
		  'merchant_id'=>$this->t("merchant id is required")	 
		);
		$data = array();
		if ($Validator->validate())
		{
				$primary_ip	= $this->data['primary_ip'];
    			$kitchen_ip	= $this->data['kitchen_ip']; 

    			$data['primary_ip'] = $primary_ip;	
    			$data['kitchen_ip']	=	$kitchen_ip;
    			 
				if(yii::app()->functions->updateOption('primary_ip',$primary_ip,$this->data['merchant_id']))
				{
					$data['primary_ip'] = $primary_ip;
				}
    			
				 
				if(yii::app()->functions->updateOption('kitchen_ip',$kitchen_ip,$this->data['merchant_id']))
				{
					$data['kitchen_ip']	=	$kitchen_ip;
				}
												
				 
				$this->code=1;
				$this->msg="Updated Successfully";
				$this->details=$data;
		}
		else { $this->msg=merchantApp::parseValidatorError($Validator->getError());	 }
		$this->output();  

    }    

    public function actionconvertToHoursMins($time, $format = '%02d:%02d') 
    {
	    if ($time < 1) 
	    {
	        return;
	    }
	    $hours = floor($time / 60);
	    $minutes = ($time % 60);
	    return sprintf($format, $hours, $minutes);
	}

 

    public function actionGetTodaysOrder()
    {    	
    	
    	$Validator=new Validator;
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    	
			    $DbExt=new DbExt;	
				$stmt="
				SELECT a.*,
				(
				select concat(first_name,' ',last_name)
				from 
				{{client}}
				where
				client_id=a.client_id
				limit 0,1				
				) as customer_name
				
				FROM
				{{order}} a
				WHERE
				merchant_id=".$this->q($res['merchant_id'])."				
				AND
				date_created LIKE '".date("Y-m-d")."%'						
				AND 
				status NOT IN ('initial_order')					
				ORDER BY date_created DESC
				LIMIT 0,100
				";				 		
				if ( $res=$DbExt->rst($stmt)){					
					$this->code=1; $this->msg="OK";							
					foreach ($res as $val) {

						if(empty($val['customer_name']))
						{
							$client_name_qry = "SELECT `client_name` FROM `mt_guest_details` WHERE `order_id` = ".$val['order_id'];
							$client_name_res=$DbExt->rst($client_name_qry);
							if(isset($client_name_res[0]['client_name']))
							{
								$val['customer_name'] = $client_name_res[0]['client_name'];
							}
						}

						$data[]=array(						  
						  'order_id'=>$val['order_id'],
						  'new_order'=>$val['order_type'],
						  'viewed'=>$val['viewed'],
						  'status_raw'=>strtolower($val['status']),
						  'status'=>t($val['status']),			
						  'trans_type_raw'=>$val['trans_type'],			  
						  'trans_type'=>t($val['trans_type']),						  
						  'total_w_tax'=>$val['total_w_tax'],						  
						  'total_w_tax_prety'=>merchantApp::prettyPrice($val['total_w_tax']),
						  'transaction_date'=>Yii::app()->functions->FormatDateTime($val['date_created'],true),
						  'transaction_time'=>Yii::app()->functions->timeFormat($val['date_created'],true),
						  'delivery_time'=>Yii::app()->functions->timeFormat($val['delivery_time'],true),
						  'delivery_asap'=>$val['delivery_asap']==1?t("ASAP"):'',
						  'delivery_date'=>Yii::app()->functions->FormatDateTime($val['delivery_date'],false),
						  'customer_name'=>!empty($val['customer_name'])?$val['customer_name']:$this->t('No name')
						);
					}					
					$this->code=1;
					$this->msg="OK";
					$this->details=$data;
				} else $this->msg=$this->t("no current orders");
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();    	    
    }
    
    public function actionGetPendingOrders()
    {    	    
    	$Validator=new Validator;
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    	
			    $_in="'pending'";
			    $pending_tabs=getOptionA('merchant_app_pending_tabs');
				if(!empty($pending_tabs)){
				   $pending_tabs=json_decode($pending_tabs,true);
				   if(is_array($pending_tabs) && count($pending_tabs)>=1){
				   	  $_in='';
				   	  foreach ($pending_tabs as $key=>$val) {
				   	      $_in.="'$val',";
				   	  }
				   	  $_in=substr($_in,0,-1);
				   }
				}		
								
			    $DbExt=new DbExt;	
				$stmt="
				SELECT a.*,				
				(
				select concat(first_name,' ',last_name)
				from 
				{{client}}
				where
				client_id=a.client_id
				limit 0,1				
				) as customer_name

				FROM
				{{order}} a
				WHERE
				merchant_id=".$this->q($res['merchant_id'])."
				AND
				status IN ($_in)							
				ORDER BY date_created DESC
				LIMIT 0,100
				";
				if(isset($_GET['debug'])){
					dump($stmt);
				}
				if ( $res=$DbExt->rst($stmt)){					
					$this->code=1; $this->msg="OK";					
					foreach ($res as $val) {	

						$client_details = '';
						if($val['customer_name']=='')
						{
							$select_query = " SELECT `client_name`,`client_contact_number`,`client_address` FROM `mt_guest_details` 
											  WHERE `order_id` =  ".$val['order_id'];
							if($client_details = $DbExt->rst($select_query))
							{
								$val['customer_name'] = isset($client_details[0]['client_name'])?$client_details[0]['client_name']:'';		
							}
						}	

						$data[]=array(
						  'order_id'=>$val['order_id'],
						  'new_order'=>$val['order_type'],
						  'viewed'=>$val['viewed'],
						  'status'=>t($val['status']),
						  'status_raw'=>strtolower($val['status']),
						  'trans_type'=>t($val['trans_type']),
						  'trans_type_raw'=>$val['trans_type'],
						  'total_w_tax'=>$val['total_w_tax'],						  
						  'total_w_tax_prety'=>merchantApp::prettyPrice($val['total_w_tax']),
						  'transaction_date'=>Yii::app()->functions->FormatDateTime($val['date_created'],true),
						  'transaction_time'=>Yii::app()->functions->timeFormat($val['date_created'],true),
						  'delivery_time'=>Yii::app()->functions->timeFormat($val['delivery_time'],true),
						  'delivery_asap'=>$val['delivery_asap']==1?t("ASAP"):'',
						  'delivery_date'=>Yii::app()->functions->FormatDateTime($val['delivery_date'],false),
						  'customer_name'=>!empty($val['customer_name'])?$val['customer_name']:$this->t('No name')
						);
					}					
					$this->code=1;
					$this->msg="OK";
					$this->details=$data;
				} else $this->msg=$this->t("no pending orders");
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();    	    
    }    
    
    public function actionGetAllOrders()
    {
    	$Validator=new Validator;
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    	
			    $DbExt=new DbExt;
				$stmt="
				SELECT a.*,
				(
				select concat(first_name,' ',last_name)
				from 
				{{client}}
				where
				client_id=a.client_id
				limit 0,1				
				) as customer_name
				
				FROM
				{{order}} a
				WHERE
				merchant_id=".$this->q($res['merchant_id'])."	
				AND status NOT IN ('initial_order')			
				ORDER BY date_created DESC
				LIMIT 0,100
				";			
				if ( $res=$DbExt->rst($stmt)){					
					$this->code=1; $this->msg="OK";					
					foreach ($res as $val) {	
						$client_details = '';
						if($val['customer_name']=='')
						{
							$select_query = " SELECT `client_name`,`client_contact_number`,`client_address` FROM `mt_guest_details` 
											  WHERE `order_id` =  ".$val['order_id'];
							if($client_details = $DbExt->rst($select_query))
							{
								$val['customer_name'] = isset($client_details[0]['client_name'])?$client_details[0]['client_name']:'';		
							}
						}

						$data[]=array(
						  'order_id'=>$val['order_id'],
						  'viewed'=>$val['viewed'],
						  'status'=>t($val['status']),
						  'status_raw'=>strtolower($val['status']),
						  'trans_type'=>t($val['trans_type']),
						  'trans_type_raw'=>$val['trans_type'],
						  'total_w_tax'=>$val['total_w_tax'],						  
						  'total_w_tax_prety'=>merchantApp::prettyPrice($val['total_w_tax']),
						  'transaction_date'=>Yii::app()->functions->FormatDateTime($val['date_created'],true),
						  'transaction_time'=>Yii::app()->functions->timeFormat($val['date_created'],true),
						  'delivery_time'=>Yii::app()->functions->timeFormat($val['delivery_time'],true),
						  'delivery_asap'=>$val['delivery_asap']==1?t("ASAP"):'',
						  'delivery_date'=>Yii::app()->functions->FormatDateTime($val['delivery_date'],false),
						  'customer_name'=>!empty($val['customer_name'])?$val['customer_name']:$this->t('No name')
						);
					}					
					$this->code=1;
					$this->msg="OK";
					$this->details=$data;
				} else $this->msg=$this->t("no orders found");
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();    	    
    }
    
    public function actionOrderdDetails()
    {        
    	$DbExt=new DbExt;	   	    	
        $Validator=new Validator;
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		  'order_id'=>$this->t("order id is required")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    	
			    if ( $data=Yii::app()->functions->getOrder2($this->data['order_id'])){
			    	//dump($data);			    	 

			    	if($data['full_name']=='')
			    	{
			    		$client_name_qry = "SELECT `client_name`,client_address,client_contact_number FROM `mt_guest_details` WHERE `order_id` = ".$this->data['order_id'];
							$client_name_res=$DbExt->rst($client_name_qry);
							if(isset($client_name_res[0]['client_name']))
							{
								$data['full_name'] = $client_name_res[0]['client_name'];
								$data['client_full_address'] = $client_name_res[0]['client_address'];						     
						     	$data['contact_phone'] = $client_name_res[0]['client_contact_number'];
							}
			    	}

			    	$json_details=!empty($data['json_details'])?json_decode($data['json_details'],true):false;			    	 

			    	Yii::app()->functions->displayOrderHTMLOriginal(
			    	array(
					  'merchant_id'=>$data['merchant_id'],
					  'delivery_type'=>$data['trans_type'],
					  'delivery_charge'=>$data['delivery_charge'],
					  'packaging'=>$data['packaging'],
					  'cart_tip_value'=>$data['cart_tip_value'],
					  'cart_tip_percentage'=>$data['cart_tip_percentage'],
					  'card_fee'=>$data['card_fee']					  
					  ),
					  $json_details,true);
					  
					  if ( Yii::app()->functions->code==1){					  	  
					  	  $data_raw=Yii::app()->functions->details['raw'];	



					  	  //dump($data_raw);
					  	  
					  	  /*fixed sub item*/
					  	  $new_sub_item='';
					  	
					  	$stmt = "SELECT mt_delivery_boys.`driver_name` FROM `mt_delivery_boys`	
								 INNER JOIN mt_driver_task ON mt_driver_task.driver_id = mt_delivery_boys.`id` AND mt_driver_task.order_id =  ".$this->data['order_id'];
					  					  	
						if($driver_name = $DbExt->rst($stmt))
						{
							$data_raw['driver_name'] = $driver_name[0]['driver_name'];
						}


					   	if(isset($data['discount_details'])&&!empty($data['discount_details']))
				    	{				    		
				    		$data_raw['discount_details'] = json_decode($data['discount_details'],true);				    	
				    	}
				    	

				    	if(isset($data['free_details'])&&!empty($data['free_details']))
				    	{
				    		$free_items_array = array();
				    		// $free_details_list = json_decode($data['free_details'],true);
				    		$data_raw['free_details'] = json_decode($data['free_details'],true);
				    		/* foreach ($free_details_list as $key => $free_details) 
				    		{
				    			echo $key."\n\n";	
				    			print_r($free_details);
				    		} */
				    	}

					  	  foreach ($data_raw['item'] as $key=>$item) 
					  	  {					  	  	
					  	  	if(is_int($key))
					  	  	{ 					  	  		
						  	  	 /*fixed for item total price*/
						  	  	 $item_price=$item['normal_price'];
						  	  	 $item_qty=$item['qty'];
						  	  	 if ( $item['discounted_price']>0){
						  	  	 	 $item_price=$item['discounted_price'];
						  	  	 }					  	  					  	  	 					  	  	 
						  	  	 $data_raw['item'][$key]['total_price'] = merchantApp::prettyPrice($item_qty*$item_price);
						  	  	 /*fixed for item total price*/
						  	  	 
						  	  	 if (isset($item['sub_item'])){
						  	  	     if (is_array($item['sub_item']) && count($item['sub_item'])>=1){
						  	  	     	foreach ($item['sub_item'] as $sub_item) {					
						  	  	     		$sub_item['total'] = merchantApp::prettyPrice(
						  	  	     		$sub_item['addon_qty']*$sub_item['addon_price']);
						  	  	     		
						  	  	     		if(!is_numeric($sub_item['addon_price'])){
						  	  	     			$sub_item['addon_price']=0;
						  	  	     		}
						  	  	     		$new_sub_item[$sub_item['addon_category']][]=$sub_item;
						  	  	     	}
						  	  	     }					  	  	 
						  	  	     $data_raw['item'][$key]['sub_item_new']=$new_sub_item;
						  	  	     unset($new_sub_item);
						  	  	 }
					  	  	 }					  	  					  	  	 
					  	  }
					  	  					  	  
					  	  $sub_total=$data_raw['total']['subtotal'];
					  	  
						  $data_raw['total']['subtotal']=merchantApp::prettyPrice($data_raw['total']['subtotal']);
						  $data_raw['total']['subtotal1']=$data['sub_total'];
						  $data_raw['total']['subtotal2']=merchantApp::prettyPrice($data['sub_total']);
						  
						  $data_raw['total']['taxable_total']=merchantApp::prettyPrice($data['taxable_total']);
						  $data_raw['total']['delivery_charges']=merchantApp::prettyPrice($data_raw['total']['delivery_charges']);
						  
						  $data_raw['total']['total']=merchantApp::prettyPrice($data['total_w_tax']);
						  
						  
						  $data_raw['total']['tax_amt']=$data_raw['total']['tax_amt']."%";
						  $data_raw['total']['merchant_packaging_charge']=merchantApp::prettyPrice($data_raw['total']['merchant_packaging_charge']);
						  						 						  
						  if ($data['order_change']>0){
						     $data_raw['total']['order_change']= merchantApp::prettyPrice($data['order_change']);
						  }
						  
						  //dump($data);
						  if ($data['voucher_amount']>0){
						  	  if ( $data['voucher_type']=="percentage"){
						  	  	  $data_raw['total']['voucher_percentage']=number_format($data['voucher_amount'],0)."%";
						  	  	  $data['voucher_amount']=$sub_total * ($data['voucher_amount']/100);
						  	  }						  	  
						      $data_raw['total']['voucher_amount']=$data['voucher_amount'];
						      $data_raw['total']['voucher_amount1']=merchantApp::prettyPrice($data['voucher_amount']);
						      												      
						      $data_raw['total']['voucher_type']=$data['voucher_type'];						      
						  }
						  
						  if ($data['discounted_amount']>0){
						  	 $data_raw['total']['discounted_amount']=$data['discounted_amount'];
						  	 $data_raw['total']['discounted_amount1']=merchantApp::prettyPrice($data['discounted_amount']);
						  	 $data_raw['total']['discount_percentage']=number_format($data['discount_percentage'],0)."%";
						  	 $data_raw['total']['subtotal']=merchantApp::prettyPrice($data['sub_total']+$data['voucher_amount']);						  	 
						  }		
						  
						  /*less points_discount*/						  
						  if (isset($data['points_discount'])){						  	 
						  	 if ( $data['points_discount']>0){						  	 	
						  	 	$data_raw['total']['points_discount']=$data['points_discount'];
						  	 	$data_raw['total']['points_discount1']=merchantApp::prettyPrice($data['points_discount']);						  	 	$data_raw['total']['subtotal']=merchantApp::prettyPrice($data['sub_total']);
						  	 }						  
						  }			
						  						  
						  /*tips*/						  
						  if ( $data['cart_tip_value']>0){						  	  
						  	  $data_raw['total']['cart_tip_value']=$data['cart_tip_value'];
						  	  $data_raw['total']['cart_tip_value']=merchantApp::prettyPrice($data['cart_tip_value']);
						  	  $data_raw['total']['cart_tip_percentage']=number_format($data['cart_tip_percentage'],0)."%";
						  }					  
						  
						  $pos = Yii::app()->functions->getOptionAdmin('admin_currency_position'); 
						  $data_raw['currency_position']=$pos;					  
						  
						  $delivery_date=$data['delivery_date'];
						  						  						  
						  $data_raw['transaction_date']	= Yii::app()->functions->FormatDateTime($data['date_created']);						          $data_raw['delivery_date'] = Yii::app()->functions->FormatDateTime($delivery_date,false);
						  //$data_raw['delivery_time'] = $data['delivery_time'];
						  
						  $data_raw['delivery_time'] = Yii::app()->functions->timeFormat($data['delivery_time'],true);
						  $data_raw['delivery_asap'] = $data['delivery_asap']==1?t("Yes"):"";
						  $data_raw['status']=t($data['status']);
						  $data_raw['status_raw']=strtolower($data['status']);
						  $data_raw['trans_type_raw']=$data['trans_type'];
						  $data_raw['trans_type']=t($data['trans_type']);						  
						  $data_raw['payment_type']=strtoupper(t($data['payment_type']));
						  $data_raw['viewed']=$data['viewed'];
						  $data_raw['order_id']=$data['order_id'];
						  $data_raw['payment_provider_name']=$data['payment_provider_name'];
						  
						  $data_raw['delivery_instruction']=$data['delivery_instruction'];
						  
						  
						  $data_raw['client_info']=array(
						    'full_name'=>$data['full_name'],
						    'email_address'=>$data['email_address'],
						    'address'=>$data['client_full_address'],
						    'location_name'=>$data['location_name1'],
						    'contact_phone'=>$data['contact_phone']
						  );			
						  						  
						  if ( $data['trans_type']=="delivery"){		
						  	  if (!empty($data['contact_phone1'])){
						  	  	  $data_raw['client_info']['contact_phone']=$data['contact_phone1'];
						  	  }						  	  
						  }
						  
						  if ( $data['trans_type']=="delivery"){
						  	  if($delivery_info=merchantApp::getDeliveryAddressByOrderID($this->data['order_id'])){
						  	  	 if(isset($delivery_info['google_lat'])){
						  	  	 	if(!empty($delivery_info['google_lat'])){						  	  	 		
						  	  	 		$data_raw['client_info']['delivery_lat']=$delivery_info['google_lat'];
						  	  	 		$data_raw['client_info']['delivery_lng']=$delivery_info['google_lng'];
						  	  	 		$data_raw['client_info']['address']=$delivery_info['formatted_address'];
						  	  	 	} else {
						  	  	 		$res_lat=Yii::app()->functions->geodecodeAddress($data['client_full_address']);
						  	  	 		if ($res_lat){
						  	  	 			$data_raw['client_info']['delivery_lat']=$res_lat['lat'];
						  	  	 		    $data_raw['client_info']['delivery_lng']=$res_lat['long']; 
						  	  	 		} else {
						  	  	 			$data_raw['client_info']['delivery_lat']=0;
						  	  	 		    $data_raw['client_info']['delivery_lng']=0;
						  	  	 		}
						  	  	 	}
						  	  	 }
						  	  }
						  }
						  
						  if (merchantApp::hasModuleAddon("driver")){						  	
						  	  if($data_raw['trans_type_raw']=="delivery"){
						  	  	 if ( $task_info=merchantApp::getTaskInfoByOrderID($data['order_id'])){
						  	  	 	//dump($task_info);
						  	  	 	
						  	  	 	$data_raw['driver_app']=1;
				  	  	 			$data_raw['driver_id']=$task_info['driver_id'];
				  	  	 			$data_raw['task_id']=$task_info['task_id'];
				  	  	 			$data_raw['task_status']=$task_info['status'];
				  	  	 			
				  	  	 			$data_raw['icon_location']=websiteUrl()."/protected/modules/merchantapp/assets/images/racing-flag.png";
                                    $data_raw['icon_driver']=websiteUrl()."/protected/modules/merchantapp/assets/images/car.png";
                                    
                                    $data_raw['driver_profilepic']=websiteUrl()."/protected/modules/merchantapp/assets/images/user.png";
				  	  	 			
				  	  	 			$driver_infos='';
				  	  	 			$driver_info=Driver::driverInfo($task_info['driver_id']);
				  	  	 			if($driver_info){
				  	  	 				unset($driver_info['username']);
				  	  	 				unset($driver_info['password']);
				  	  	 				unset($driver_info['forgot_pass_code']);
				  	  	 				unset($driver_info['token']);
				  	  	 				unset($driver_info['date_created']); unset($driver_info['date_modified']);
				  	  	 				$driver_infos=$driver_info;
				  	  	 				
				  	  	 				$driver_address=merchantApp::latToAdress(
				  	  	 				  $driver_info['location_lat'] , $driver_info['location_lng']
				  	  	 				);
				  	  	 				if($driver_address){
				  	  	 					$driver_infos['formatted_address']=$driver_address['formatted_address'];
				  	  	 				} else $driver_infos['formatted_address']='';
				  	  	 			}						  	  	 
						  	  	 			
						  	  	 	switch ($task_info['status']) {							  	  	 		
						  	  	 		case "successful":
						  	  	 			break;
						  	  	 	
						  	  	 		default:
						  	  	 			$data_raw['task_info']=$task_info;							  	  	 		
						  	  	 			$data_raw['driver_info']=$driver_infos;
						  	  	 			
						  	  	 			$task_distance_resp = merchantApp::getTaskDistance(
											  isset($driver_infos['location_lat'])?$driver_infos['location_lat']:'',
											  isset($driver_infos['location_lng'])?$driver_infos['location_lng']:'',
											  isset($task_info['task_lat'])?$task_info['task_lat']:'',
											  isset($task_info['task_lng'])?$task_info['task_lng']:'',
											  isset($task_info['transport_type_id'])?$task_info['transport_type_id']:''
											);
											
											if($task_distance_resp){
											   $data_raw['time_left']=$task_distance_resp;
											} else $data_raw['time_left']=t("N/A");
											
						  	  	 			
						  	  	 			break;
						  	  	 	}
						  	  	 }						         
						  	  }
						  } else $data_raw['driver_app']=2;
						  						  						  
						  if ($data_raw['payment_type']=="OCR" || $data_raw['payment_type']=="ocr"){
						  	 $_cc_info=Yii::app()->functions->getCreditCardInfo($data['cc_id']);
						  	 $data_raw['credit_card_number']=Yii::app()->functions->maskCardnumber(
						  	    $_cc_info['credit_card_number']
						  	 );						  	 
						  } else $data_raw['credit_card_number']='';
 
						  $this->code=1;
						  $this->msg="OK";				  
						  $this->details=$data_raw;
						  
						  // update the order id to viewed						  
						  $params=array(
						    'viewed'=>2
						  );
						  $DbExt=new DbExt;
						  $DbExt->updateData("{{order}}",$params,'order_id',$this->data['order_id']);
						  
					  } else $this->msg=$this->t("order details not available");
			    } else $this->msg=$this->t("order details not available");
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();    	    	
    }
    
    public function actionAcceptOrdes()
    {
    	
    	$Validator=new Validator;
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		  'order_id'=>$this->t("order id is required")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    				    
			    $merchant_id=$res['merchant_id'];
			    $order_id=$this->data['order_id'];			    
			    
			    if ( Yii::app()->functions->isMerchantCommission($merchant_id)){  
	    	    	if ( FunctionsK::validateChangeOrder($order_id)){
	    	    		$this->msg=t("Sorry but you cannot change the order status of this order it has reference already on the withdrawals that you made");
	    	    		$this->output();	    	    		
	    	    	}    	    
    	        }	        
    	        
    	        /*check if merchant can change the status*/
	    	    $can_edit=Yii::app()->functions->getOptionAdmin('merchant_days_can_edit_status');	    	    
	    	    if (is_numeric($can_edit) && !empty($can_edit)){
	    	    	
		    	    $date_now=date('Y-m-d');
		    	    $base_option=getOptionA('merchant_days_can_edit_status_basedon');	
		    	    
		    	    $resp=Yii::app()->functions->getOrderInfo($order_id);	    	   
		    	    
		    	    if ( $base_option==2){	    					
						$date_created=date("Y-m-d",
						strtotime($resp['delivery_date']." ".$resp['delivery_time']));		
					} else $date_created=date("Y-m-d",strtotime($resp['date_created']));
					    			
					
					$date_interval=Yii::app()->functions->dateDifference($date_created,$date_now);					
	    			if (is_array($date_interval) && count($date_interval)>=1){		    				
	    				if ( $date_interval['days']>$can_edit){
	    					$this->msg=t("Sorry but you cannot change the order status anymore. Order is lock by the website admin");
	    					$this->details=json_encode($date_interval);
	    					$this->output();
	    				}		    			
	    			}	    		
	    	    }
    	        
	    	    //$order_status='pending';
	    	    $order_status='accepted';	    	    
	    	    
    	        if ( $resp=Yii::app()->functions->verifyOrderIdByOwner($order_id,$merchant_id) ){     	        	
    	        	$params=array( 
    	        	  'status'=>$order_status,
    	        	  'date_modified'=>date('c'),
    	        	  'viewed'=>2
    	        	);    	        	
    	        	
    	        	$DbExt=new DbExt;
    	        	if ($DbExt->updateData('{{order}}',$params,'order_id',$order_id)){
    	        		$this->code=1;
    	        		$this->msg=t("Order ID").":$order_id ".t("has been accepted");
    	        		$this->details=array(
    	        		 'order_id'=>$order_id
    	        		);
    	        		
    	        	//	$this->actionNewJsonRequest($order_id,$merchant_id);

    	        		/*Now we insert the order history*/	    		
	    				$params_history=array(
	    				  'order_id'=>$order_id,
	    				  'status'=>$order_status,
	    				  'remarks'=>isset($this->data['remarks'])?$this->data['remarks']:'',
	    				  'date_created'=>date('c'),
	    				  'ip_address'=>$_SERVER['REMOTE_ADDR']
	    				);	    				
	    				$DbExt->insertData("{{order_history}}",$params_history);
	    				
	    				/*now we send email and sms*/
	    				merchantApp::sendEmailSMS($order_id);
	    				
	    				// send push notification to client mobile app when order status changes
	    				if(merchantApp::hasModuleAddon("mobileapp")){	    				   
	    				   $push_log='';
	    				   $push_log['order_id']=$order_id;
                           $push_log['status']=$order_status;
                           $push_log['remarks']=$this->data['remarks'];  
                                                      
                           Yii::app()->setImport(array(			
						    'application.modules.mobileapp.components.*',
					       ));      
                                                    
                           AddonMobileApp::savedOrderPushNotification($push_log);
	    				}
	    				
	    				/*Driver app*/
						if (merchantApp::hasModuleAddon("driver")){
						   Yii::app()->setImport(array(			
							  'application.modules.driver.components.*',
						   ));
						   //Driver::addToTask($order_id);
						   merchantApp::addToTask($order_id);
						}						
    	        		
    	        	} else $this->msg=t("ERROR: cannot update order.");    	        	
    	        } else $this->msg=$this->t("This Order does not belong to you");
    	            	        	    
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}  	
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();    	    	
    }
    


    public function actionNewJsonRequest($order_id,$merchant_id)
    {
    	$order_list_query = 'SELECT `mt_order`.`order_id` as order_id ,`mt_order`.`json_details`, `mt_client`.`first_name` , `mt_client`.`last_name`, `mt_order`.`delivery_charge`, `mt_order`.`trans_type`, `mt_order`.`card_fee` , `mt_order`.`discounted_amount`,`mt_order`.`payment_type`,`mt_order`.`total_w_tax`,`mt_order`.`date_created`, `mt_order_delivery_address`.* FROM `mt_order`

			INNER JOIN `mt_order_delivery_address` ON `mt_order_delivery_address`.`order_id` = `mt_order`.`order_id`

			INNER JOIN `mt_client`  ON `mt_client`.`client_id` = `mt_order_delivery_address`.`client_id`

			WHERE `mt_order`.`order_id` = '.$order_id;

			$DbExt=new DbExt;
			$order_item = $DbExt->rst($order_list_query); 
			$order_detail = json_decode($order_item[0]['json_details']);
			$responding_json = array();
			$total_amount = 0;

			$responding_json['id']					 = $order_id;
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
							$change_sizename = str_replace("__","\"",$size_name[1]);			    					 	
							$get_size_query = "SELECT size_id FROM `mt_size` WHERE `size_name` = '".trim($change_sizename)."'";
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
							$stmt3 = "SELECT * FROM `mt_subcategory_item` WHERE `sub_item_id` = ".$sub_itm_id." ";
							$res3=$DbExt->rst($stmt3);		

							if(!empty($res3[0]['cat_size_item_price']))
    						{ 
							$add_ons_array = ($res3[0]['cat_size_item_price']);
							//$add_ons_array->size->; 
							$add_ons_array = json_decode(json_encode(json_decode($add_ons_array)),True);
							
							
							$array_key = array_search($size_key[0]['size_id'],$add_ons_array['size']);
							 $array_key; 
							$options[] = array('menuNumber'=>$add_ons_array['add_on_item_number'][$array_key],'price'=>$add_ons_array['add_on_item_price'][$array_key]);			     
							}
							//$size_key[0]['size_id'];
							else
							{
								$options[] = array('menuNumber'=>$res3[0]['item_number'],'price'=>$sub_itm_details[1]);			    	
							}
														
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
			$responding_json['total'] 				=	 number_format($order_item[0]['total_w_tax'], 2, '.', '');	
			$responding_json['discount'] = isset($order_item[0]['discounted_amount'])?round($order_item[0]['discounted_amount'], 2):0;
			$responding_json['payment'] = array('type'=>$order_item[0]['payment_type'],'amount'=>number_format($order_item[0]['total_w_tax'], 2, '.', ''));	
			//				 print_r($responding_json); exit;			
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
		    					    $this->actionCallExternalScript($url,$responding_json);	
		    					}		    					
		    					
		    				}

    }


    public function actionCallExternalScript($url,$responding_json)
    {
    	require(getcwd()."/curl_function.php");     	
    	 $result = curl_file($url,$responding_json);
    }

    public function actionDeclineOrders()
    {
    	
    	$Validator=new Validator;
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		  'order_id'=>$this->t("order id is required")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    				    
			    $merchant_id=$res['merchant_id'];
			    $order_id=$this->data['order_id'];		 

			    if ( Yii::app()->functions->isMerchantCommission($merchant_id)){  
	    	    	if ( FunctionsK::validateChangeOrder($order_id)){
	    	    		$this->msg=t("Sorry but you cannot change the order status of this order it has reference already on the withdrawals that you made");
	    	    		$this->output();	    	    		
	    	    	}    	    
    	        }	        
    	        
    	        /*check if merchant can change the status*/
	    	    $can_edit=Yii::app()->functions->getOptionAdmin('merchant_days_can_edit_status');	    	    
	    	    if (is_numeric($can_edit) && !empty($can_edit)){
	    	    	
		    	    $date_now=date('Y-m-d');
		    	    $base_option=getOptionA('merchant_days_can_edit_status_basedon');	
		    	    
		    	    $resp=Yii::app()->functions->getOrderInfo($order_id);
		    	    
		    	    if ( $base_option==2){	    					
						$date_created=date("Y-m-d",
						strtotime($resp['delivery_date']." ".$resp['delivery_time']));		
					} else $date_created=date("Y-m-d",strtotime($resp['date_created']));
					    			
					$date_interval=Yii::app()->functions->dateDifference($date_created,$date_now);					
	    			if (is_array($date_interval) && count($date_interval)>=1){		    				
	    				if ( $date_interval['days']>$can_edit){
	    					$this->msg=t("Sorry but you cannot change the order status anymore. Order is lock by the website admin");
	    					$this->details=json_encode($date_interval);
	    					$this->output();
	    				}		    			
	    			}	    		
	    	    }			   
			    
			    $order_status='decline';
			    
			    if ( $resp=Yii::app()->functions->verifyOrderIdByOwner($order_id,$merchant_id) ){     	        	
    	        	$params=array( 
    	        	  'status'=>$order_status,
    	        	  'date_modified'=>date('c'),
    	        	  'viewed'=>2
    	        	);    	    
    	        
    	        	$DbExt=new DbExt;
    	        	if ($DbExt->updateData('{{order}}',$params,'order_id',$order_id)){
    	        		$this->code=1;
    	        		//$this->msg=t("order has been declined");
    	        		$this->msg=t("Order ID").":$order_id ".t("has been declined");
    	        		$this->details=array(
    	        		 'order_id'=>$order_id
    	        		);
    	        		
    	        		/*Now we insert the order history*/	    		
	    				$params_history=array(
	    				  'order_id'=>$order_id,
	    				  'status'=>$order_status,
	    				  'remarks'=>isset($this->data['remarks'])?$this->data['remarks']:'',
	    				  'date_created'=>date('c'),
	    				  'ip_address'=>$_SERVER['REMOTE_ADDR']
	    				);	    				
	    				$DbExt->insertData("{{order_history}}",$params_history);
	    				
	    				/*now we send email and sms*/
	    				merchantApp::sendEmailSMS($order_id);
	    				
	    				// send push notification to client mobile app when order status changes
	    				if(merchantApp::hasModuleAddon("mobileapp")){	    				   
	    				   $push_log='';
	    				   $push_log['order_id']=$order_id;
                           $push_log['status']=$order_status;
                           $push_log['remarks']=$this->data['remarks'];       
                                                      
                           Yii::app()->setImport(array(			
						   'application.modules.mobileapp.components.*',
					       ));                          
                           AddonMobileApp::savedOrderPushNotification($push_log);
	    				}
    	        		
    	        	} else $this->msg=t("ERROR: cannot update order.");    	        	
    	        	
			    } else $this->msg=$this->t("This Order does not belong to you");
			    
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}  	
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();   
    }
    
    public function actionChangeOrderStatus()
    {
    	$Validator=new Validator;
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		  'order_id'=>$this->t("order id is required"),
		  'status'=>$this->t("order status is required")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    				    
			    $merchant_id=$res['merchant_id'];
			    $order_id=$this->data['order_id'];		 

			    if ( Yii::app()->functions->isMerchantCommission($merchant_id)){  
	    	    	if ( FunctionsK::validateChangeOrder($order_id)){
	    	    		$this->msg=t("Sorry but you cannot change the order status of this order it has reference already on the withdrawals that you made");
	    	    		$this->output();	    	    		
	    	    	}    	    
    	        }
    	            	        
    	        /*check if merchant can change the status*/
	    	    $can_edit=Yii::app()->functions->getOptionAdmin('merchant_days_can_edit_status');	    	    
	    	    if (is_numeric($can_edit) && !empty($can_edit)){
	    	    	
		    	    $date_now=date('Y-m-d');
		    	    $base_option=getOptionA('merchant_days_can_edit_status_basedon');	
		    	    
		    	    $resp=Yii::app()->functions->getOrderInfo($order_id);
		    	    
		    	    if ( $base_option==2){	    					
						$date_created=date("Y-m-d",
						strtotime($resp['delivery_date']." ".$resp['delivery_time']));		
					} else $date_created=date("Y-m-d",strtotime($resp['date_created']));
					    			
					$date_interval=Yii::app()->functions->dateDifference($date_created,$date_now);					
	    			if (is_array($date_interval) && count($date_interval)>=1){		    				
	    				if ( $date_interval['days']>$can_edit){
	    					$this->msg=t("Sorry but you cannot change the order status anymore. Order is lock by the website admin");
	    					$this->details=json_encode($date_interval);
	    					$this->output();
	    				}		    			
	    			}	    		
	    	    }			   
			    
			    $order_status=$this->data['status'];			    
			    if ( $resp=Yii::app()->functions->verifyOrderIdByOwner($order_id,$merchant_id) ){     	        	
			    	
    	        	$params=array( 
    	        	  'status'=>$order_status,
    	        	  'date_modified'=>date('c'),
    	        	  'viewed'=>2
    	        	);    	    
    	        
    	        	$DbExt=new DbExt;
    	        	if ($DbExt->updateData('{{order}}',$params,'order_id',$order_id)){
    	        		$this->code=1;
    	        		$this->msg=t("order status successfully changed");
    	        		
    	        		/*Now we insert the order history*/	    		
	    				$params_history=array(
	    				  'order_id'=>$order_id,
	    				  'status'=>$order_status,
	    				  'remarks'=>isset($this->data['remarks'])?$this->data['remarks']:'',
	    				  'date_created'=>date('c'),
	    				  'ip_address'=>$_SERVER['REMOTE_ADDR']
	    				);	    				
	    				$DbExt->insertData("{{order_history}}",$params_history);
	    				
	    				/*now we send email and sms*/
	    				merchantApp::sendEmailSMS($order_id);
	    				
	    				// send push notification to client mobile app when order status changes
	    				if(merchantApp::hasModuleAddon("mobileapp")){	    				   
	    				   $push_log='';
	    				   $push_log['order_id']=$order_id;
                           $push_log['status']=$order_status;
                           $push_log['remarks']=$this->data['remarks'];
                                                       
                           Yii::app()->setImport(array(			
						   'application.modules.mobileapp.components.*',
					       ));                  
                           AddonMobileApp::savedOrderPushNotification($push_log);
	    				}
	    				
	    				/*Driver app*/
						if (merchantApp::hasModuleAddon("driver")){
						   Yii::app()->setImport(array(			
							  'application.modules.driver.components.*',
						   ));						   				  
						   merchantApp::addToTask($order_id,$order_status);
						   						   						   
						   /*if ( $task_info=Driver::getTaskByOrderID($order_id)){						   	   
						   	   if ( $task_info['status']!="unassigned"){
							   	   $task_id=$task_info['task_id'];
							   	   $DbExt->updateData("{{driver_task}}",array(
							   	     'status'=>$order_status
							   	   ),'task_id',$task_id);
						   	   }
						   }*/
						}		
    	        		
    	        	} else $this->msg=t("ERROR: cannot update order.");    	        	
    	        	
			    } else $this->msg=$this->t("This Order does not belong to you");			    
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}  	
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();   
    }
    
    public function actionForgotPassword()
    {
    	
    	if (isset($this->data['email_address'])){
    		if (empty($this->data['email_address'])){
    			$this->msg=t("email address is required");
    			$this->output();
    		}
    		
    		if ($res=merchantApp::getUserByEmail($this->data['email_address'])){
    		   
    		   $tbl="merchant";
    		   if ( $res['user_type']=="user"){
    		   	   $tbl="merchant_user";
    		   }    		
    		   $params=array('lost_password_code'=> yii::app()->functions->generateCode());	 
    		   
    		   $DbExt=new DbExt;
    		   if ( $DbExt->updateData("{{{$tbl}}}",$params,'merchant_id',$res['merchant_id'])){
    		   	   $this->code=1;
    		   	   $this->msg=t("We have sent verification code in your email.");
    		   	       		   	   
    		   	   $tpl=EmailTPL::merchantForgotPass($res[0],$params['lost_password_code']);
    			   $sender=Yii::app()->functions->getOptionAdmin('website_contact_email');
	               $to=$res['contact_email'];	               
	               if (!sendEmail($to,$sender,t("Merchant Forgot Password"),$tpl)){		    	
	                	$email_stats="failed";
	                } else $email_stats="ok mail";
	                
	                $this->details=array(
	                  'email_stats'=>$email_stats,
	                  'user_type'=>$res['user_type'],
	                  'email_address'=>$this->data['email_address']
	                );
	                
    		   } else $this->msg=t("ERROR: Cannot update");
    		   
    		} else $this->msg=t("sorry but the email address you supplied does not exist in our records");
    		
    	} else $this->msg=t("email address is required");
    	$this->output();   
    }
    
    public function actionChangePasswordWithCode()
    {        
    	
    	
        $Validator=new Validator;
		$req=array(
		  'code'=>$this->t("code is required"),
		  'newpass'=>$this->t("new passwords is required"),		  
		  'user_type'=>t("user type is missing"),
		  'email_address'=>$this->t("email address is required")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			
			if ( $res=merchantApp::getMerchantByCode($this->data['code'],$this->data['email_address'],
			$this->data['user_type'])){
								
				$params=array(
				  'password'=>md5($this->data['newpass']),
	    		  'date_modified'=>date('c'),
	    	      'ip_address'=>$_SERVER['REMOTE_ADDR']
				);			
								
				$DbExt=new DbExt;
				if ( $this->data['user_type']=="admin"){
					// update merchant table
					if ($DbExt->updateData("{{merchant}}",$params,'merchant_id',$res['merchant_id'])){
						$this->msg=t("You have successfully change your password");
	    				$this->code=1;
					} else $this->msg=t("ERROR: cannot update records.");
				} else {
					// update merchant user table merchant_user_id
					if ($DbExt->updateData("{{merchant_user}}",$params,'merchant_user_id',$res['merchant_user_id'])){
						$this->msg=t("You have successfully change your password");
	    				$this->code=1;
					} else $this->msg=t("ERROR: cannot update records.");
				}				
			} else $this->msg=t("verification code is invalid");
			
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output(); 
    }
    
    public function actionRegisterMobile()
    {    	
    	$DbExt=new DbExt;
		$params['device_id']=isset($this->data['registrationId'])?$this->data['registrationId']:'';
		$params['device_platform']=isset($this->data['device_platform'])?$this->data['device_platform']:'';
		$params['ip_address']=$_SERVER['REMOTE_ADDR'];
				
		$user_type='admin';
		if (!empty($this->data['token'])){
			if ( $info=merchantApp::getUserByToken($this->data['token'])){				
				$user_type=$info['user_type'];
				$params['merchant_id']=$info['merchant_id'];
				$params['user_type']=$user_type;
				if ($user_type=="user"){
				   	$params['merchant_user_id']=$info['merchant_user_id'];
				} else $params['merchant_user_id']=0;
			}
		}					
		if ( $res=merchantApp::getDeviceInfo($this->data['registrationId'])){
			$params['date_modified']=date('c');				
			$DbExt->updateData('{{mobile_device_merchant}}',$params,'id',$res['id']);
			$this->code=1;
			$this->msg="Updated";
		} else {
			$params['date_created']=date('c');
			$DbExt->insertData('{{mobile_device_merchant}}',$params);
			$this->code=1;
			$this->msg="OK";
		}
		$this->output(); 
    }
    
    public function actionStatusList()
    {    	        	
    	if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
			    				    				 
			 if (!$order_info = Yii::app()->functions->getOrder($this->data['order_id'])){
			 	$this->msg=t("order records not found");
			 	$this->output(); 
			 }			    
			 
			 if ( $res=merchantApp::orderStatusList($this->data['mtid']) ) {  				 	
			 	$this->details=array(
			 	  'status'=>$order_info['status'],
			 	  'status_list'=>$res
			 	);
			 	$this->code=1;
			 	$this->msg="OK";
			 } else $this->msg=t("Status list not available");
        } else {
		    $this->code=3;
		    $this->msg=$this->t("you session has expired or someone login with your account");
		}    
		$this->output(); 
    }
    

    public function actiontest_function()
    {
		echo "Hi";    	
    }

	public function actionGetLanguageSelection()
	{
		if ($res=Yii::app()->functions->getLanguageList()){
			$set_lang_id=Yii::app()->functions->getOptionAdmin('set_lang_id');		
			//dump($res);
			//if (preg_match("/-9999/i", $set_lang_id)) {
				$eng[]=array(
				  'lang_id'=>"en",
				  'country_code'=>"US",
				  'language_code'=>"English"
				);
				$res=array_merge($eng,$res);
			//}						
			$this->code=1;
			$this->msg="OK";
			$this->details=$res;
		} else $this->msg=$this->t("no language available");
		$this->output();
	}    
	
	public function actionSaveSettings()
	{		
		
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		  'merchant_device_id'=>t("mobile device id is empty please restart the app")
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
				
			    $params=array(
			      'merchant_id'=>$this->data['mtid'],
				  'enabled_push'=>isset($this->data['enabled_push'])?1:2,
				  'date_modified'=>date('c'),
				  'ip_address'=>$_SERVER['REMOTE_ADDR'],			  
				);		
				
				$DbExt=new DbExt;
				if ( $resp=merchantApp::getDeviceInfo($this->data['merchant_device_id'])){					
					if ( $DbExt->updateData('{{mobile_device_merchant}}',$params,'id',$resp['id'])){
						$this->msg=$this->t("Setting saved");
						$this->code=1;
						
						$merchant_id=$this->data['mtid'];
						if (isset($this->data['food_option_not_available'])){
							Yii::app()->functions->updateOption("food_option_not_available",1,$merchant_id);  
						}
						if (isset($this->data['food_option_not_available_disabled'])){
							Yii::app()->functions->updateOption("food_option_not_available",2,$merchant_id);  
						}
						if(!isset($this->data['food_option_not_available']) && !isset($this->data['food_option_not_available_disabled'])){
							Yii::app()->functions->updateOption("food_option_not_available","",$merchant_id);  
						}
						
						Yii::app()->functions->updateOption("merchant_close_store",
						isset($this->data['merchant_close_store'])?"yes":""
						,$merchant_id);  
						
						Yii::app()->functions->updateOption("merchant_show_time",
						isset($this->data['merchant_show_time'])?"yes":""
						,$merchant_id);  
						
						Yii::app()->functions->updateOption("merchant_disabled_ordering",
						isset($this->data['merchant_disabled_ordering'])?"yes":""
						,$merchant_id);  
						
						Yii::app()->functions->updateOption("merchant_enabled_voucher",
						isset($this->data['merchant_enabled_voucher'])?"yes":""
						,$merchant_id);  
						
						Yii::app()->functions->updateOption("merchant_required_delivery_time",
						isset($this->data['merchant_required_delivery_time'])?"yes":""
						,$merchant_id);  
						
						Yii::app()->functions->updateOption("merchant_enabled_tip",
						isset($this->data['merchant_enabled_tip'])?"2":""
						,$merchant_id);  
						
						Yii::app()->functions->updateOption("merchant_table_booking",
						isset($this->data['merchant_table_booking'])?"yes":""
						,$merchant_id);  
						
						
						Yii::app()->functions->updateOption("accept_booking_sameday",
						isset($this->data['accept_booking_sameday'])?"2":""
						,$merchant_id);  
												
					} else $this->msg=$this->t("ERROR: Cannot update");
				} else $this->msg=$this->t("Device id not found please restart the app");
								
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();
	}
    
	public function actionGetSettings()
	{		
		if (isset($this->data['device_id'])){
			if ( $resp=merchantApp::getDeviceInfo($this->data['device_id'])){					
				$this->code=1;
				$this->msg="OK";
				$resp['food_option_not_available']=getOption($resp['merchant_id'],'food_option_not_available');
				$resp['merchant_close_store']=getOption($resp['merchant_id'],'merchant_close_store');
				$resp['merchant_show_time']=getOption($resp['merchant_id'],'merchant_show_time');
				$resp['merchant_disabled_ordering']=getOption($resp['merchant_id'],'merchant_disabled_ordering');
				$resp['merchant_enabled_voucher']=getOption($resp['merchant_id'],'merchant_enabled_voucher');
				$resp['merchant_required_delivery_time']=getOption($resp['merchant_id'],'merchant_required_delivery_time');
				$resp['merchant_enabled_tip']=getOption($resp['merchant_id'],'merchant_enabled_tip');
				
				$resp['merchant_table_booking']=getOption($resp['merchant_id'],'merchant_table_booking');
				$resp['accept_booking_sameday']=getOption($resp['merchant_id'],'accept_booking_sameday');
				
				$this->details=$resp;
			} else $this->msg=$this->t("Device id not found please restart the app");
		} else $this->msg=$this->t("Device id not found please restart the app");
		$this->output();
	}
	
	public function actiongeoDecodeAddress()
	{
	
		if (isset($this->data['address'])){
			if ($res=Yii::app()->functions->geodecodeAddress($this->data['address'])){
				$this->code=1;
				$this->msg="OK";
				$res['address']=$this->data['address'];
				$this->details=$res;
			} else $this->msg=t("Error: cannot view location");
		} else $this->msg=$this->t("address is required");
		$this->output();
	}
	
	public function actionOrderHistory()
	{
		if (!isset($this->data['order_id'])){
			$this->msg=$this->t("order is missing");
			$this->output();
		}	
		
		if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    	
			 
			 if ( $res=merchantApp::getOrderHistory($this->data['order_id'])){
			 	  $data='';
			 	  foreach ($res as $val) {
			 	  	$data[]=array(
			 	  	  'id'=>$val['id'],
			 	  	  'status'=>t($val['status']),
			 	  	  'status_raw'=>strtolower($val['status']),
			 	  	  'remarks'=>$val['remarks'],
			 	  	  'date_created'=>Yii::app()->functions->FormatDateTime($val['date_created'],true),
			 	  	  'ip_address'=>$val['ip_address']
			 	  	);
			 	  }
			 	  $this->code=1;
			 	  $this->msg="OK";
			 	  $this->details=array(
			 	    'order_id'=>$this->data['order_id'],
			 	    'data'=>$data
			 	  );
			 } else {
			 	$this->msg=$this->t("No history found");			    	
			 	$this->details=$this->data['order_id'];
			 }
         } else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
				$this->details=$this->data['order_id'];
		}
		$this->output();
	}
	
	public function actionsaveProfile()
	{
		
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),
		  'password'=>$this->t("password is required"),
		  'cpassword'=>$this->t("confirm password is required")
		);
		
		if (isset($this->data['password']) && isset($this->data['cpassword'])){
			if ( $this->data['password']!=$this->data['cpassword']){
				$Validator->msg[]=$this->t("Confirm password does not match");
			}
		}
		
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){
					    
			    $params=array(
			      'password'=>md5($this->data['password']),
			      'date_modified'=>date('c'),
			      'ip_address'=>$_SERVER['REMOTE_ADDR']
			    );			    
			    
			    $DbExt=new DbExt;	
			    switch ($res['user_type']) {
			    	case "user":
			    		if ( $DbExt->updateData('{{merchant_user}}',$params,'merchant_user_id',$res['merchant_user_id'])){
			    			$this->code=1;
			    			$this->msg=$this->t("Profile saved");
			    		} else $this->msg=$this->t("ERROR: Cannot update profile");
			    		break;
			    			    	
			    	default:
			    		if ( $DbExt->updateData('{{merchant}}',$params,'merchant_id',$res['merchant_id'])){
			    			$this->code=1;
			    			$this->msg=$this->t("Profile saved");
			    		} else $this->msg=$this->t("ERROR: Cannot update profile");
			    		break;
			    }
			} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();	    	
	}
	
	public function actionGetProfile()
	{
		
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),		  
		);
						
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    			    
			    $this->code=1;
			    $this->msg="OK";
			    $this->details=$res;			    	
	    } else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();	 
	}
	
	public function actionGetLanguageSettings()
	{
		
		$mobile_dictionary=getOptionA('merchant_mobile_dictionary');
		$mobile_dictionary=!empty($mobile_dictionary)?json_decode($mobile_dictionary,true):false;
		if ( $mobile_dictionary!=false){
			$lang=$mobile_dictionary;
		} else $lang='';
		
		$mobile_default_lang='en';
		$default_language=getOptionA('default_language');
		if(!empty($default_language)){
			$mobile_default_lang=$default_language;
		}	
		
		if ( $mobile_default_lang=="en" || $mobile_default_lang=="-9999")
		{
			$this->details=array(
			  'settings'=>array(
			    //'default_lang'=>"ph"		    
			  ),
			  'translation'=>$lang
			);
		} else {
			$this->details=array(
			  'settings'=>array(
			    'default_lang'=>$mobile_default_lang		    
			  ),
			  'translation'=>$lang
			);
		}
		
		$this->code=1;
		$this->output();		
	}
	
	public function actiongetNotification()
	{
		
	    $Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),		  
		);
						
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    			    
			   
			   if ( $resp=merchantApp::getMerchantNotification($res['merchant_id'],
			       $res['user_type'], isset($res['merchant_user_id'])?$res['merchant_user_id']:'' )){
			   		
			       	$data='';
			       	foreach ($resp as $val) {			       		
			       		$val['date_created']=Yii::app()->functions->FormatDateTime($val['date_created'],true);
			       		$data[]=$val;
			       	}
			       	
			       	$this->code=1;
			       	$this->msg="OK";
			       	$this->details=$data;
			       	
			    } else $this->msg=$this->t("no notifications");
			   
             } else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();	 			    	
	}
	
	public function actionsearchOrder()
	{
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),		  
		);
						
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    			    
			   			    
			    if ( $resp=merchantApp::searchOrderByMerchantId(
			    $this->data['order_id_customername'] , $this->data['mtid'])){
			    	 
			    	$this->code=1; $this->msg="OK";					
					foreach ($resp as $val) {												
						//dump($val);
						$data[]=array(
						  'order_id'=>$val['order_id'],
						  'customer_name'=>'',
						  'viewed'=>$val['viewed'],
						  'status'=>t($val['status']),
						  'status_raw'=>strtolower($val['status']),
						  'trans_type'=>t($val['trans_type']),
						  'trans_type_raw'=>$val['trans_type'],
						  'total_w_tax'=>$val['total_w_tax'],						  
						  'total_w_tax_prety'=>merchantApp::prettyPrice($val['total_w_tax']),
						  'transaction_date'=>Yii::app()->functions->FormatDateTime($val['date_created'],true),
						  'transaction_time'=>Yii::app()->functions->timeFormat($val['date_created'],true),
						  'delivery_time'=>Yii::app()->functions->timeFormat($val['delivery_time'],true),
						  'delivery_asap'=>$val['delivery_asap']==1?t("ASAP"):'',
						  'delivery_date'=>Yii::app()->functions->FormatDateTime($val['delivery_date'] ." ". $val['delivery_time'] ,true)
						);
					}					
					$this->code=1;
					$this->msg=$this->t("Search Results") ." (".count($data).") ".$this->t("Found records");
					$this->details=$data;
			    	 
			    } else $this->msg=$this->t("no results");
			   
             } else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();	 			 
	}
	
	public function actionPendingBooking()
	{
		
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),		  
		);
						
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    			    
 			    	
			    if ( $res=merchantApp::getPendingTables($this->data['mtid'])){
			    	$this->code=1;
			    	$this->msg="OK";
			    	$data='';
			    	foreach ($res as $val) {	

			    		$time_of_booking = '';
			    		$time_of_booking = explode("-",$val['booking_time']);
			    		$booking_time = '';
			    		if(isset($time_of_booking[0]))
			    		{
			    			$booking_time = $time_of_booking[0];
			    		}

			    		$val['status_raw']=strtolower($val['status']);
			    		$val['status']=$this->t($val['status']);
			    		$val['date_of_booking']=Yii::app()->functions->FormatDateTime($val['date_booking'].
			    		" ".$booking_time,true);
			    		$data[]=$val;
			    	}
			    	$this->details=$data;
			    } else $this->msg=$this->t("no pending booking");
			    
		     } else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();	 			 	    	
	}
	
	public function actionAllBooking()
	{
		
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),		  
		);
						
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    			    
 			    	
			    if ( $res=merchantApp::getAllBooking($this->data['mtid'])){
			    	$this->code=1;
			    	$this->msg="OK";
			    	$data='';			    	 
			    	foreach ($res as $val) {			    		
			    		$time_of_booking = '';
			    		$time_of_booking = explode("-",$val['booking_time']);
			    		$booking_time = '';
			    		if(isset($time_of_booking[0]))
			    		{
			    			$booking_time = $time_of_booking[0];
			    		}
			    		$val['status_raw']=strtolower($val['status']);
			    		$val['status']=$this->t($val['status']);
			    		$val['date_of_booking']=Yii::app()->functions->FormatDateTime($val['date_booking'].
			    		" ".$booking_time,true);
			    		$data[]=$val;
			    	}
			    	$this->details=$data;
			    } else $this->msg=$this->t("no current booking");
			    
		     } else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output();	 			 	    	
	}	
	
	public function actionGetBookingDetails()
	{
		
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),		  
		);
						
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    			    
			    				    	
			    if ( $res=merchantApp::getBookingDetails($this->data['mtid'],$this->data['booking_id'])){
			    	$res['status_raw']=strtolower($res['status']);
			    	$res['date_of_booking']=Yii::app()->functions->FormatDateTime($res['date_booking'].
			    		" ".$res['booking_time'],true);
			    		
			    	$res['transaction_date']=  Yii::app()->functions->FormatDateTime($res['date_created'],true);
			    	$res['date_booking']=  Yii::app()->functions->FormatDateTime($res['date_booking'],false);
			    		
			    	$this->code=1;
			    	$this->msg="OK";
			    	$this->details=array( 
			    	  'booking_id'=>$this->data['booking_id'],			    	  
			    	  'data'=>$res
			    	);
			    	
			    	$params=array(
			    	  'viewed'=>2
			    	);
			    	$DbExt=new DbExt; 
			    	$DbExt->updateData('{{bookingtable}}',$params,'booking_id',$this->data['booking_id']);
			    	
			    } else $this->msg=$this->t("booking details not available");
			    
		} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output(); 			    	
	}
	

	/* public function bookingApproved()
	{
		print_r($this->data);	
	} */

	public function actionBookingChangeStats()
	{		
		/*$this->code=1;
		$this->msg="ok";
		$this->output(); 		
		Yii::app()->end();*/
		
		$Validator=new Validator;		
		$req=array(
		  'token'=>$this->t("token is required"),
		  'mtid'=>$this->t("merchant id is required"),
		  'user_type'=>$this->t("user type is required"),		  
		);
						
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
			if ( $res=merchantApp::validateToken($this->data['mtid'],
			    $this->data['token'],$this->data['user_type'])){			    			    
			    				 
			   if ( $res=merchantApp::getBookingDetails($this->data['mtid'],$this->data['booking_id'])){   	
				   			   	
				   $params=array(
				     'status'=>$this->data['status'],
				     'date_modified'=>date('c'),
				     'ip_address'=>$_SERVER['REMOTE_ADDR']
				   );
				   
				   /*dump($this->data);			
				   dump($res);*/
				   				   

				   $DbExt=new DbExt; 
			       if ($DbExt->updateData('{{bookingtable}}',$params,'booking_id',$this->data['booking_id'])){
			       	   $this->code=1;
			       	   $this->msg= $this->t("Booking id #").$this->data['booking_id'].
			       	   " ".$this->t($this->data['status']);
			       	   			       	   
			       	   switch ($this->data['status']) {
			       	   	case "approved":
			       	   		$subject=getOptionA('tpl_booking_approved_title');
			       	   		$content=getOptionA('tpl_booking_approved_content');
			       	   					       	   		
			       	   		break;
			       	   
			       	   	default:
			       	   		$subject=getOptionA('tpl_booking_denied_title');
			       	   		$content=getOptionA('tpl_booking_denied_content');
			       	   		break;
			       	   }
			       	   
			       	   			       	   
			       	   /*send push to customer*/
			       	   if (isset($res['client_id'])){
			       	   	   merchantApp::sendPushBookingTable($res['client_id'],
			       	   	   $res,
			       	   	   $this->data['status'],
			       	   	   $this->data['remarks']
			       	   	   );
			       	   }			       	   			       	  
			       	   
			       	   if ( !empty($res['email'])){
				       	   $subject=smarty('merchant_name',$res['restaurant_name'],$subject);
				       	   $subject=smarty('booking_name',$res['booking_name'],$subject);
				       	   $subject=smarty('booking_date',
				       	   Yii::app()->functions->FormatDateTime($res['date_booking'],false),$subject);
				       	   $subject=smarty('booking_time',$res['booking_time'],$subject);
				       	   $subject=smarty('number_of_guest',$res['number_guest'],$subject);
				       	   $subject=smarty('booking_id',$res['booking_id'],$subject);
				       	   $subject=smarty('remarks',$this->data['remarks'],$subject);
				       	   
				       	   $content=smarty('merchant_name',$res['restaurant_name'],$content);
				       	   $content=smarty('booking_name',$res['booking_name'],$content);
				       	   $content=smarty('booking_date',
				       	   Yii::app()->functions->FormatDateTime($res['date_booking'],false),$content);
				       	   $content=smarty('booking_time',$res['booking_time'],$content);
				       	   $content=smarty('number_of_guest',$res['number_guest'],$content);
				       	   $content=smarty('booking_id',$res['booking_id'],$content);
				       	   $content=smarty('remarks',$this->data['remarks'],$content);
				       	   				       	   
				       	   if (!empty($subject) && !empty($content)){				       	   	
				       	   	   sendEmail( trim($res['email']),'',$subject,$content );
				       	   }
			       	   }
   					
   					if(!empty($this->data['remarks']))
   					{
   						$res['remarks'] = $this->data['remarks'];
   					}

	     	  	   if(merchantApp::sendBookatableSms($this->data['mtid'],$res)==0)
				    {
				    	$this->msg=t("Sms Sent.");
				    }
				    else
				    {
				    	$this->msg=t("Sms Not Sent.");
				    }  
			       	   			       	   			       	   			       	   
			       } else $this->msg=t("ERROR: Cannot update");
			    	
			   } else $this->msg=$this->t("booking details not available");
			    
		} else {
				$this->code=3;
				$this->msg=$this->t("you session has expired or someone login with your account");
			}
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	    	
		$this->output(); 			    	
	}
	
	public function actionloadTeamList()
	{
		if($res=merchantApp::getTeamByMerchantID($this->data['mtid'])){		   
		   $this->msg="OK"; $this->code=1;
		   $this->details=$res;
		} else $this->msg=$this->t("You dont have current team");
		$this->output();
	}
	
	public function actionDriverList()
	{		
		/* if (merchantApp::hasModuleAddon("driver")){
			Yii::app()->setImport(array(			
			  'application.modules.driver.components.*',
		   ));
		   if ( $res = Driver::getDriverByTeam($this->data['team_id'])){		   	  
		   	  $this->code=1;
		   	  $this->msg="OK";
		   	  $this->details=$res;
		   } else $this->msg=$this->t("Team selected has no driver");
		} else $this->msg=$this->t("Missing addon driver app");
		$this->output(); */
		$mtid = $this->data['mtid'];
		$stmt = " SELECT `id`,`driver_name` FROM `mt_delivery_boys` WHERE `merchant_id` = ".$mtid." AND `status` = 'active' ";

		$DbExt=new DbExt; 		
		if ($res=$DbExt->rst($stmt))
		{	  
		   	  $this->code=1;
		   	  $this->msg="OK";
		   	  $this->details=$res;
		} else $this->msg=$this->t("Restaurant has no driver");
		$this->output();
	}
	
/*	public function actionAssignTask()
	{
		$Validator=new Validator;
		$req=array(
		  'driver_id'=>$this->t("Please select a driver")
		  ,'team_id'=>$this->t("Please select a team")		  
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
		
			$DbExt=new DbExt; 
			$assigned_task='assigned';
			$params=array(
			  'team_id'=>$this->data['team_id'],
			  'driver_id'=>$this->data['driver_id'],
			  'status'=>$assigned_task,
			  'date_modified'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);			
			if ( $DbExt->updateData("{{driver_task}}",$params,'task_id',$this->data['task_id'])){
				
				$this->code=1;
				$this->msg=merchantApp::t("Successfully Assigned");
				$this->details='';
				
				
				$DbExt->updateData("{{order}}",array(
				  'status'=>$assigned_task
				  ),'order_id',$this->data['order_id']);
				
				// add to history 
				if ( $res=Driver::getTaskId($this->data['task_id'])){					
					$status_pretty = Driver::prettyStatus($res['status'],$assigned_task);
					
					$remarks_args=array(
					  '{from}'=>$res['status'],
					  '{to}'=>$assigned_task
					);
					$params_history=array(
					  'order_id'=>$res['order_id'],
					  'remarks'=>$status_pretty,
					  'status'=>$assigned_task,
					  'date_created'=>date('c'),
					  'ip_address'=>$_SERVER['REMOTE_ADDR'],
					  'task_id'=>$this->data['task_id'],
					  'remarks2'=>"Status updated from {from} to {to}",
					  'remarks_args'=>json_encode($remarks_args)
					);							
					$DbExt->insertData('{{order_history}}',$params_history);
				}				
				
				// send notification to driver
		        Driver::sendDriverNotification('ASSIGN_TASK',$res=Driver::getTaskId($this->data['task_id']));		        
		        if($res['order_id']>0){
			         if (FunctionsV3::hasModuleAddon("mobileapp")){
						// Mobile save logs for push notification 
						Yii::app()->setImport(array(			
						  'application.modules.mobileapp.components.*',
						));
						AddonMobileApp::savedOrderPushNotification(array(
						  'order_id'=>$res['order_id'],
						  'status'=>$res['status'],
						));
					 }
		        }
				
			} else $this->msg=Merchant::t("failed cannot update record");
			
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	  
		$this->output();
	} */

	public function actionDriversCollectionList()
	{

				$Validator=new Validator;
				$driver_collection_list = '';
				$return_array = '';
				$req=array(
				  'merchant_id'=>$this->t("Merchant ID is Mandatory !"),
				  'delivery_date'=>$this->t("Delivert date is required !")		  	  
				);
				$drivers_name = array();
				$Validator->required($req,$this->data);

				if ($Validator->validate())
				{				
					if($driver_collection_list = Yii::app()->functions->get_driver_collection_list($this->data['merchant_id'],$this->data['delivery_date']))
					{
							foreach($driver_collection_list as $drivers_list)
							{
								if(!in_array($drivers_list['driver_name'],$drivers_name))
								{
									array_push($drivers_name,$drivers_list['driver_name']);							
									$return_array[$drivers_list['driver_name']][$drivers_list['payment_type']] = 1;	
									$return_array[$drivers_list['driver_name']]['total_delivery'] = 1;

									if($drivers_list['payment_type']=="cash"||$drivers_list['payment_type']=="cod")
									{
										$return_array[$drivers_list['driver_name']]['cash_on_hand'] = $drivers_list['total_w_tax'];	
									}


									$return_array[$drivers_list['driver_name']][] = array('total'=>$drivers_list['total_w_tax'],'payment_type'=>$drivers_list['payment_type'],'parish'=>$drivers_list['state'],'delivery_time'=>$drivers_list['delivery_time'],'order_id'=>$drivers_list['order_id']);
								}	
								else
								{
									if(isset($return_array[$drivers_list['driver_name']][$drivers_list['payment_type']]))
									{
										$return_array[$drivers_list['driver_name']][$drivers_list['payment_type']] += 1;
									}
									else
									{
										$return_array[$drivers_list['driver_name']][$drivers_list['payment_type']] = 1;	
									}
									$return_array[$drivers_list['driver_name']]['total_delivery'] += 1;
									if($drivers_list['payment_type']=="cash"||$drivers_list['payment_type']=="cod")
									{
										$return_array[$drivers_list['driver_name']]['cash_on_hand'] += $drivers_list['total_w_tax'];	
									}
									$return_array[$drivers_list['driver_name']][] = array('total'=>$drivers_list['total_w_tax'],'payment_type'=>$drivers_list['payment_type'],'parish'=>$drivers_list['state'],'delivery_time'=>$drivers_list['delivery_time'],'order_id'=>$drivers_list['order_id']);
								}
							}
							$this->code=1;
							$this->msg=merchantApp::t("Success");
							$this->details=$driver_collection_list;
							$this->output();
							return;
					}
					else
					{
							$this->code=2;
							$this->msg=merchantApp::t("No Details Found !");
							$this->details='';
							$this->output();
							return;	
					}
				}

	}

	public function actionAssignTask()
	{
		$Validator=new Validator;
		$req=array(
		  'driver_id'=>$this->t("Please select a driver")		  	  
		);
		$Validator->required($req,$this->data);
		if ($Validator->validate()){
		
			$DbExt=new DbExt; 
			$assigned_task='assigned';

			$merchant_id =  $this->data['mtid'];
			$order_id  = $this->data['order_id'];  
		$stmt = "SELECT 
					mt_order_delivery_address.street,
					mt_order_delivery_address.city,
					mt_order_delivery_address.state,
					mt_order_delivery_address.zipcode,
					mt_order_delivery_address.formatted_address,
					mt_order_delivery_address.google_lat,
					mt_order_delivery_address.google_lng,
					mt_merchant.street as merchant_street,
					mt_merchant.city as merchant_city,
					mt_merchant.state as merchant_state,
					mt_merchant.post_code as merchant_post_code,
					mt_order.delivery_date,
					mt_order.delivery_time,					
					mt_order.merchant_id FROM `mt_order` 
					LEFT JOIN mt_order_delivery_address ON mt_order_delivery_address.order_id = mt_order.order_id
					LEFT JOIN mt_merchant ON mt_merchant.merchant_id = mt_order.merchant_id 
					WHERE mt_order.`order_id` = ".$order_id  ;					
		$db_ext=new DbExt;
		$mannual_address = '';
		$merchant_address = '';
		$address_details = array();

		$delivery_date = ''; 
		$delivery_time = ''; 

		$delivery_date_time = "SELECT `delivery_date`,`delivery_time` FROM `mt_order` WHERE `order_id` = ".$order_id;
		if($delivery_date_time_res=$db_ext->rst($delivery_date_time))
		{
			$delivery_date = $delivery_date_time_res[0]['delivery_date']; 
			$delivery_time = $delivery_date_time_res[0]['delivery_time']; 
		}


		if($res=$db_ext->rst($stmt))
		{	
			if(isset($res[0]))
			{
				// $location_name  = $res[0]['location_name'];
				$street 		= $res[0]['street'];
				$city 			= $res[0]['city'];
				$state 			= $res[0]['state'];
				$zipcode 		= $res[0]['zipcode'];

				$formatted_address = $res[0]['formatted_address'];

				$google_lat = $res[0]['google_lat'];
				$google_lng = $res[0]['google_lng'];

				$merchant_street	 = $res[0]['merchant_street'];
				$merchant_city 		 = $res[0]['merchant_city'];
				$merchant_state 	 = $res[0]['merchant_state'];
				$merchant_post_code  = $res[0]['merchant_post_code'];

				// $mannual_address =  $street.",".$city.",".$state.",".$zipcode;
				$mannual_address =  $street.",".$city.",".$state;

				// $merchant_address = $merchant_street.",".$merchant_city.",".$merchant_state.",".$merchant_post_code;
				$merchant_address = $merchant_street.",".$merchant_city.",".$merchant_state;


			}
		}

		$params=array(			  
			  'driver_id'=>$this->data['driver_id'],
			  'merchant_id'=>$merchant_id,
			  'order_id'=>$order_id,
			  'delivery_date'=>$delivery_date,
			  'delivery_time'=>$delivery_time,
			  'status'=>$assigned_task,
			  'date_modified'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);	


		$address_book = '';

		// $address =  '2/20, S.R Ave, Sesi West Extension, Cheran ma Nagar, Coimbatore, Tamil Nadu 641035'; // Google HQ
		// $address =  'St. Johns Road, Mont à lAbbe, St Helier, Jersey JE2 3LE, Jersey';

		// echo $mannual_address;

		 $address = urlencode($mannual_address);
       // $prepAddr = str_replace(' ','+',$address);

        $key = '';
        $latitude = '';
        $longitude = '';

        if($google_key = yii::app()->functions->getOptionAdmin('google_geo_api_key'))
        {
			$key = '&key='.$google_key;        	
        }

        //  echo 'https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false'.$key;

         $geocode =file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false'.$key);        
        /* print_r($geocode);
         exit;  */
         
        if($geocode =file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false'.$key))
        {        	 
        	$output = json_decode($geocode);                 	        	

        	if(isset($output->results[0]))
        	{
        		$latitude = $output->results[0]->geometry->location->lat;
	        	$longitude = $output->results[0]->geometry->location->lng; 
        	}
        	else
	        { 
	        	$address = urlencode($city.",".$state);
				if($geocode =file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false'.$key))
		        {
		        	$output = json_decode($geocode);                 	        	
		        	if(isset($output->results[0]))
		        	{
		        		$latitude = $output->results[0]->geometry->location->lat;
			        	$longitude = $output->results[0]->geometry->location->lng; 
		        	}	        
		        } 
	        }       	        
        } 

        if($latitude!=''&&$longitude!='')
        {
        	$address_details['client_address'] = array('latitude'=>$latitude,'longitude'=>$longitude);         	
        	$address_details['client_street'] = $address;

        	$merchant_address = urlencode($merchant_address);
        	
        	if($merchantgeocode =file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$merchant_address.'&sensor=false'.$key))
	        {
	        	$merchant_output = json_decode($merchantgeocode);                 	        	
	        	if(isset($merchant_output->results[0]))
	        	{
	        		$merchant_latitude = $merchant_output->results[0]->geometry->location->lat;
		        	$merchant_longitude = $merchant_output->results[0]->geometry->location->lng; 

		        	$address_details['merchant_address'] = array('latitude'=>$merchant_latitude,'longitude'=>$merchant_longitude); 
		        	$address_details['mercahnt_street'] =  $merchant_address;
	        	}	        
	        }  
	       	// print_r($address_details);
        }
        else
        {
        	// Wrong Address return 

        	$stmt = "SELECT mt_delivery_boys.`driver_name`,`mt_delivery_boys`.`mobile_no` FROM `mt_delivery_boys` WHERE id = ".$this->data['driver_id']; 
			$DbExt=new DbExt;					  	
			if($driver_name = $DbExt->rst($stmt))
			{
				$client_num_query = " SELECT contact_phone FROM `mt_order_delivery_address` WHERE `order_id` =  ".$order_id ;
				if($client_num = $DbExt->rst($client_num_query))
				{
					$driver_data['contact_phone'] = $client_num[0]['contact_phone'];
				}
				$driver_data['driver_name']  = $driver_name[0]['driver_name'];
				$driver_data['mobile_no']    = $driver_name[0]['mobile_no'];
				$driver_data['short_url']    = Yii::app()->getBaseUrl(true)."/directions/".$this->data['order_id'];
			}


			$driver_data['order_id'] = $order_id;
        	merchantApp::sendDriverSmswrongaddress($merchant_id,$driver_data);
    	/*	$this->code=1;
			$this->msg=merchantApp::t("Client Address Not Reachable");
			$this->details='';
			$this->output();
			return;  */
        }

 


			
			if(isset($this->data['reassigned'])&&!empty($this->data['reassigned']))
			{				
				$params['status'] = "reassigned";
				/* echo $this->data['order_id'];
				print_r($params); */
				if($DbExt->updateData("{{driver_task}}",$params,'order_id',$this->data['order_id']))
				{					
					$stmt = "SELECT mt_delivery_boys.`driver_name`,`mt_delivery_boys`.`mobile_no`,`mt_short_urls`.`short_code` FROM `mt_delivery_boys` 
							INNER JOIN `mt_driver_task`  ON `mt_driver_task`.driver_id = mt_delivery_boys.id AND order_id = ".$this->data['order_id']."
							INNER JOIN mt_short_urls ON `mt_short_urls`.`driver_task_id` = `mt_driver_task`.`id` "; 
					$DbExt=new DbExt;					  	
					if($driver_name = $DbExt->rst($stmt))
					{
						$data['driver_name']  = $driver_name[0]['driver_name'];
						$data['mobile_no']    = $driver_name[0]['mobile_no'];
						// $data['short_url']    = Yii::app()->getBaseUrl(true)."/directions/".$driver_name[0]['short_code'];						
						$data['short_url']    = Yii::app()->getBaseUrl(true)."/directions/".$this->data['order_id'];						
					} 
					merchantApp::sendDriverSms($merchant_id,$data);
					$this->code=1;
					$this->msg=merchantApp::t("Successfully Re-assigned");
					$this->details='';
					$this->output();
					return;
				}
				else
				{
					$this->code=1;
					$this->msg=merchantApp::t("No Update done !");
					$this->details='';
					$this->output();
					return;
				}				
			}			 
			if(empty($this->data['reassigned']))
			{
					if ($DbExt->insertData("{{driver_task}}",$params))
					{
						 $last_inserted_id = Yii::app()->db->getLastInsertID();
						 
						$data['short_code'] = $this->string_shuffle();
						// $data['short_url']  = Yii::app()->getBaseUrl(true)."/directions/".$data['short_code'];
						$data['short_url']  = Yii::app()->getBaseUrl(true)."/directions/".$this->data['order_id'];						
						$data['address_details'] = json_encode($address_details);
						$data['long_url'] = '';
						$data['driver_task_id'] = $last_inserted_id;
 

						$DbExt->insertData("{{short_urls}}",$data);


					 	$stmt = "SELECT mt_delivery_boys.`driver_name`,`mt_delivery_boys`.`mobile_no` FROM `mt_delivery_boys` WHERE id = ".$this->data['driver_id']; 
						$DbExt=new DbExt;					  	
						if($driver_name = $DbExt->rst($stmt))
						{
							$data['driver_name']  = $driver_name[0]['driver_name'];
							$data['mobile_no']    = $driver_name[0]['mobile_no'];
						}

						merchantApp::sendDriverSms($merchant_id,$data);

						$this->code=1;
						$this->msg=merchantApp::t("Successfully Assigned");
						$this->details='';
						
						
						$DbExt->updateData("{{order}}",array(
						  'status'=>$assigned_task
						  ),'order_id',$this->data['order_id']);
						
						 
						
					} else $this->msg=Merchant::t("failed cannot update record");

			}			
			
		} else $this->msg=merchantApp::parseValidatorError($Validator->getError());	  
		$this->output();
	}
	

	public function string_shuffle()
	{
		$str_chars		 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$shuffled_chars  = substr(str_shuffle($str_chars),0,12);		
		return $this->check_shortcode($shuffled_chars);
	}

	public function check_shortcode($short_code='')
	{
		$stmt 	= "SELECT * FROM `mt_short_urls` WHERE `short_url` = '".$short_code."'";
		$DbExt  = new DbExt;
		if(!$res=$DbExt->rst($stmt))
		{
			return $short_code;
		}
		else
		{
			$this->string_shuffle();
		}
	}

	public function actionPendingBookingTab()
	{
		$this->actionPendingBooking();
	}
	
} /*end class*/