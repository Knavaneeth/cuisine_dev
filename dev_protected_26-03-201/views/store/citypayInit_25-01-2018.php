<?php
 
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Payment"),
   'sub_text'=>t("")
));

$this->renderPartial('/front/order-progress-bar',array(
   'step'=>4,
   'show_bar'=>true
));

$data='';
		$data2='';
		$params='';
		$error='';
		$merchant_id='';
		$ok=false;
        $amount_details             = array();
        $request = array();
        $sbct_lst = array();
        
                                
		$dir = dirname(__FILE__);
		$host =getenv('REMOTE_ADDR');
        $applicationPath = $dir;		 
        $applicationEndpoint = $host.$applicationPath;
        $get_order_id = $_GET['id'];                
//		http://www.dreamguys.co.in/food/store/menu/merchant/

if ( $data=Yii::app()->functions->getOrder($_GET['id'])){     
  
	$failure_redirect_url = Yii::app()->request->baseUrl.'/store/menu/merchant/'.$data['restaurant_slug'];
	$merchant_id=$data['merchant_id'];	
	$json_details=!empty($data['json_details'])?json_decode($data['json_details'],true):false; 
    /*print_r($json_details);
    exit;  */
 /*    $subcat_list = Yii::app()->functions->getAddOnLists($merchant_id);                            
     
     foreach($subcat_list as $subcat_lists)
                  {
                  //   echo "<br /> " . $subcat_lists['subcategory_name'];
                    $sbct_lst[] =  $subcat_lists['subcategory_name'];
                  }
                  // print_r($sbct_lst);
                  $i = 0 ;
    foreach ($json_details as $json_detail) 
    { 
    /*  echo "item_id : ".$json_detail['item_id']." <br />";
      echo "<br /><br /><br />"; 
        
        $item_id = $json_detail['item_id'];
        $db_ext=new DbExt;
        $stmt="SELECT item_name
        FROM
        {{item}}
        WHERE
        item_id = ".$item_id."";
        $res=$db_ext->rst($stmt);
        $item_name = $res[0]['item_name'];        
    $price = strstr($json_detail['price'],'|',true);
    $size  = ltrim(strstr($json_detail['price'],'|'),'|');
    $qty   = $json_detail['qty'];
    $price = $price * $qty;
    $ter[] = array(
                    "amount"=>($price * 100),
                    "sku"=>"10",
                    "label"=>$item_name." ( ".$size." )",
                    "category"=>"10",
                    "brand"=>"1",
                    "variant"=>$size,
                    "count"=>$qty 
                    );   
            
           //  echo $item_name ."<br /><br /><br />" ;   
            /* echo "Sub items of item id  " . $item_id ."<br /><br />";
             print_r($json_detail['sub_item']);                                                               
            
      foreach($json_detail['sub_item'] as $key => $sub_item)
          {  

           /*  echo "each sub_item of item_id  " . $item_id;                                                             
             echo "<br /><br /><br />"; 
             print_r($sub_item);       
             echo "<br /><br /><br />";   
                           $j = 0 ;
                        foreach($sub_item as $key1 => $sb_itm)
                        {       
                            /*    echo "Key Value " . $key1;
                                echo " addon qty of item_id :" . $item_id;
                                echo "<br /><br /><br />";
                                print_r($json_detail['addon_qty']);
                                echo "<br /><br /><br />";                                    

                           $sub_item_price  = explode("|",$sb_itm); 
                           $sub_items_price =  $sub_item_price[1];
                           $sub_items_name  =  $sub_item_price[2];                           
                           $sub_items_qty   =  $json_detail['addon_qty'][$key][$key1];
                           $sub_items_price =  $sub_items_price  * $sub_items_qty;
                           //echo $sub_item_price[1].$sub_item_price[2]; 
                           // echo "<br /><br /><br />";                         
                           // print_r($json_detail['addon_qty'][$key][$j]);
                           //echo "Main addon" . $sbct_lst[$i] . " Qty : " .$json_detail['addon_qty'][$key][$j] ;

                           $ter[] = array(
                                                "amount"=>($sub_items_price * 100),
                                                "sku"=>"10",
                                                "label"=>$sbct_lst[$i]." ( ".$sub_items_name." )",
                                                "category"=>"10",
                                                "brand"=>"1",
                                                "variant"=>$sub_items_name,
                                                "count"=>$sub_items_qty 
                                          );

                           $j += 1;
                        }
                        $i +=1;      
                                     
          }

 
 
    }


       $ter[] = array(
                                                "amount"=>($data['sub_total'] * 100),
                                                "sku"=>"10",
                                                "label"=>"Sub Total",
                                                "category"=>"10",
                                                "brand"=>"1",
                                                "variant"=>"1",
                                                "count"=>"1" 
                                          );
          $ter[] = array(
                                                "amount"=>($data['delivery_charge'] * 100),
                                                "sku"=>"10",
                                                "label"=>"Delivery Fee :",
                                                "category"=>"10",
                                                "brand"=>"1",
                                                "variant"=>"1",
                                                "count"=>"1" 
                                          );
             $ter[] = array(
                                                "amount"=>($data['packaging'] * 100),
                                                "sku"=>"10",
                                                "label"=>"packaging Fee :",
                                                "category"=>"10",
                                                "brand"=>"1",
                                                "variant"=>"1",
                                                "count"=>"1" 
                                          );
                $ter[] = array(
                                               "amount"=>($data['taxable_total'] * 100),
                                                "sku"=>"10",
                                                "label"=>"Tax :",
                                                "category"=>"10",
                                                "brand"=>"1",
                                                "variant"=>"1",
                                                "count"=>"1" 
                                          );                 
                      $ter[] = array(
                                                "amount"=>($data['cart_tip_value'] * 100),
                                                "sku"=>"10",
                                                "label"=>"Cart tips value :",
                                                "category"=>"10",
                                                "brand"=>"1",
                                                "variant"=>"1",
                                                "count"=>"1" 
                                          );

    $total_amount = $data['sub_total']+$data['delivery_charge']+$data['taxable_total']+$data['packaging']+$data['cart_tip_value'];  
 
    $details = array(
                                                "mode"=>1,
                                                "contents"=> $ter ,
                                                                "productInformation"=>"product information",
                                                                "productDescription"=>"product description"
                                                                );

        $request['cart'] = $details; */


        // Deals Discount amount , amount will be added in total discounted amount in ajaxadmin / placeorder 21-08-2017
        $discount_amount = 0 ;         
        if(isset($data['deals_discount_amt'])&&!empty($data['deals_discount_amt']))
        {
            $discount_amount = Yii::app()->functions->prettyFormat($data['deals_discount_amt'],$mid);

        }
        
     //   echo 'sub_total : '.$data['sub_total'].' sub_total : '.$data['delivery_charge'].' sub_total : '.$data['taxable_total'].' sub_total : '.$data['packaging'].' sub_total : '.$data['cart_tip_value'];
   
   $total_amount = prettyFormat(($data['sub_total']+$data['delivery_charge']+$data['taxable_total']+$data['packaging']+$data['cart_tip_value']-$discount_amount),$data['merchant_id']);  

      $less_voucher = '';
      if(isset($data['voucher_type']))
      {
        if($data['voucher_type']!='')
        {
          if($data['voucher_type']=="fixed amount")
          {
            $less_voucher = $data['voucher_amount'];
          }
          else
          {
            $less_voucher = $total_amount*($data['voucher_amount']/100);           
          }
        }
      }
      if($less_voucher!='')
      {
        $total_amount -= $less_voucher;
        $total_amount = prettyFormat($total_amount,$data['merchant_id']);
      }
 
	if ( $json_details !=false){
		$p_arams=array( 
		   'merchant_id'=>$data['merchant_id'],
		   'delivery_type'=>$data['trans_type']
		);		
		Yii::app()->functions->displayOrderHTML($p_arams,$json_details,true);
		if ( Yii::app()->functions->code==1){
			$ok=true;
		}
	}	
}	




		 $citypay_con=Yii::app()->functions->getCityPayConnection($merchant_id);                     
                 $city_pay_merchant_id = '';
                 $city_pay_lisence_key = '';
  /* print_r($citypay_con); exit;
   /*get admin paypal connection if merchant is commission*/
   if ( Yii::app()->functions->isMerchantCommission($merchant_id)){       
   	   unset($citypay_con);   	   
   	   $citypay_con=Yii::app()->functions->getCityPayConnectionAdmin();   	   
         //  print_r($citypay_con);
   }          
 //  if ( !empty($citypay_con[$citypay_con['mode']]['user'])){   	     
	
       if ( !empty($citypay_con[$citypay_con['mode']]['user']) && !empty($citypay_con[$citypay_con['mode']]['psw']))
       {
         
           $city_pay_merchant_id = $citypay_con[$citypay_con['mode']]['user'];
           $city_pay_lisence_key = $citypay_con[$citypay_con['mode']]['psw'];
       }
       else
       {           
           $error = "Merchant Citypay Credential not yet been set";
           $this->render('citypay_error',array('error'=>$error));
             exit;
       }        
      
      /*  echo 'MERCHANT_ID '.$city_pay_merchant_id.' LICENCE_KEY ', $city_pay_lisence_key ;
        exit; */

        define('MERCHANT_ID', $city_pay_merchant_id); //31116985       wild card id 
        define('LICENCE_KEY', $city_pay_lisence_key);	// SMR4S4UNEX94HMQ1	wildcard license key 
                                
        //
        //  Assign values to the mandatory fields of the Payment Transaction Request
        //  and any optional fields as required. 
        //


        $city_pay_type = Yii::app()->functions->categorize_citypay_url($merchant_id);
        $citypay_merch_terms = '';
        if(isset($city_pay_type['url_value']))
        {
            $citypay_merch_terms = $city_pay_type['url_value'];
        }

        if(isset($city_pay_type['internal_url']))
        {
            $citypay_merch_terms = $city_pay_type['internal_url'];
        }          

        $request['merchantid'] = MERCHANT_ID;
        $request['licenceKey'] = LICENCE_KEY;
        $request['test'] = "false";
        $request['identifier'] = "php-integration-test";
        $request['amount'] = $total_amount * 100 ;
       // $request['merch_terms']  = $citypay_merch_terms; //this should be in config object as per 4.2.4 of Citypay paylink guidelines
       /* $request['expmonth'] = "12" ;
        $request['expyear'] = "2022" ;
        $request['cardnumber'] = "4000000000000002"; 
        $request['csc'] = "123" ; 
        $request['test'] = "true" ; */
        
        $address_details = array(); 
        $fname = '';
        $lname = '';
        $email = '';
        $full_name = '';
        $addr1 = '';
        $addr2 = '';
        $addr3 = '';
        $area = '';
        $zip = '';
        $country = 'GB';
        $db_ext=new DbExt;
        $stmt=" SELECT `location_name`,`street`,`city`,`state`,`zipcode`,`country` FROM `mt_order_delivery_address` WHERE `order_id` = ".$get_order_id."";
        if($res=$db_ext->rst($stmt))
        {  
          if(isset($data['full_name']))
          {
            $full_name = trim($data['full_name']);
            if($full_name=='')
            {                 
                $stmt = "SELECT * FROM `mt_guest_details` WHERE `order_id` =  ".$get_order_id;
                if($res=$db_ext->rst($stmt))
                {
                  if(isset($res[0]['client_name']))
                  {
                    $full_name = $res[0]['client_name'];                     
                  }
                }
            }             
            $full_name = explode(' ',$full_name);
            if(isset($full_name[0]))
            {
              $fname = $full_name[0];
            }
            if(isset($full_name[1]))
            {
               $lname = $full_name[1]; 
            }
          }
          if(isset($data['email_address']))
          {
              $email = $data['email_address'];
          }

          if(isset($res[0]['location_name']))
          {
            $area = $res[0]['location_name'] ;
          }
          if(isset($res[0]['street']))
          {
            $addr1 = $res[0]['street'];
          }
          if(isset($res[0]['city']))
          {
            $addr2 = $res[0]['city'];
          }
          if(isset($res[0]['state']))
          {
            $addr3 = $res[0]['state'];
          }
          if(isset($res[0]['zipcode']))
          {
            $zip = $res[0]['zipcode'];
          }           

          $address_details = array('firstName' => trim($fname),'lastName'  => trim($lname),'email'   => trim($email)); 
          $address_details['address'] = array('address1'=>trim($addr1),'address2'  => trim($addr2),'address3'  => trim($addr3),
            'area'=>trim($area),'postcode'=>trim($zip),'country'=>trim(strtoupper($country)));  
        }
        else
        {
         
        }
        
        $request['cardholder'] = $address_details;

        


         
     
      
        /*
        Default Working code
          $details = array(
                                                "mode"=>1,
                                                "contents"=>array(
                                                                array(
                                                                            "amount"=>"1",
                                                                            "sku"=>"1",
                                                                            "label"=>"Miscellaneous product",
                                                                            "category"=>"1",
                                                                            "brand"=>"1",
                                                                            "variant"=>"1",
                                                                            "count"=>"1"
                                                                            ),
                                                                array(
                                                                            "amount"=>"22",
                                                                            "sku"=>"22",
                                                                            "label"=>"Miscellaneous product",
                                                                            "category"=>"1",
                                                                            "brand"=>"1",
                                                                            "variant"=>"1",
                                                                            "count"=>"2"
                                                                            )
                                                                          ),
                                                                "productInformation"=>"product information",
                                                                "productDescription"=>"product description"
                                                                );

        $request['cart'] = $details;

 
           print_r($request);
        exit;  */

        //
        //  Assign the host, application path and application endpoint values
        //  to temporary variables to enable reuse.
        //
       
        //
        //  Construct an associative array for the Payment Transaction configuration,
        //  and assign it to the $request associative array with the index 'config'.
        //
        $request['config'] = array();

        //
        //  Assign values to the relevant fields of the Payment Transaction configuration
        //  associative array to guide processing and Merchant Application integration by
        //  the Paylink Payment Form and the Paylink server.
        //
        $request['config']['postback_policy'] = 'async';
        $request['config']['merch_terms'] = $citypay_merch_terms;
        //$request['config']['postback'] = 'http://'.$applicationEndpoint.'?postback=false';
        $request['config']['postback'] = Yii::app()->getBaseUrl(true).'/PaymentOption/';
        $request['config']['redirect_success'] = Yii::app()->getBaseUrl(true).'/store/receipt/id/'.$get_order_id.'/citypay_success/true';
        //$request['config']['redirect_failure'] = 'http://'.$applicationEndpoint.'?failure';
        $request['config']['redirect_failure'] = Yii::app()->getBaseUrl(true).'/PaymentOption/';
        // print_r($request); exit;
        //
        //  Generate a JSON representation of the $request associative array
        //  using PECL json.
        //

        $jsonEncodedRequest = json_encode($request);

        //
        //  Open a temporary stream for the purpose of collecting verbose connection
        //  information generated by cURL. This is useful for tracing into SSL
        //  certificate-related connectivity issues.
        //
        $curl_stderr = fopen('php://temp', 'w+');

        //
        //	Initialise an associative array containing the configuration required
        //  for the cURL-based request.
        //
        $curl_opts = array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $jsonEncodedRequest,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Content-Type: application/json;charset=UTF-8',
                        'Content-Length: '.strlen($jsonEncodedRequest)
                    ),
                CURLOPT_VERBOSE => true,
                CURLOPT_STDERR => $curl_stderr
            );

        //
        //  Initialise the cURL request.
        //
        $ch = curl_init('https://secure.citypay.com/paylink3/create');

        //
        //	Configure the cURL request with the configuration provided
        //  by the associative array.
        //
        curl_setopt_array($ch, $curl_opts);

        // 
        //	Open the cURL request and receive the response (if any)
        //
        $httpsResponse = curl_exec($ch);
        //
//  If cURL is unable to complete the HTTP request for whatever reason,
//  it will return FALSE (which may be tested using the PHP empty function).
//
//  If the cURL HTTP request was completed and the response generated is
//  not empty -
//
     // print_r($httpsResponse);   exit;
if (!empty($httpsResponse))
{
 // echo "Inside httpsResponse";
	//
	//	Close and dispose of the temporary stream used to receive connection-
	//  related output generated by cURL in the course of processing the
	//  HTTP request.
	//
	fclose($curl_stderr);

    //
    //  Get the HTTP response code received from the remote server and, if
	//  necessary, any further diagnostic or process-related information
	//	from the cURL request object.
    //
    $httpsResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    //
    //	Close the cURL request object to release system resources associated
	//	with it.
    //
    curl_close($ch);

    //
    //  If the HTTP POST request was reported as having been
    //  successfully completed by the Paylink server -
    //
    if ($httpsResponseCode == 200)
    {    
    //  echo "Inside httpsResponseCode";
        //
        //  1. De-serialize the JSON formatted message body to
        //     form an object, of an anonymous class, structured
        //     to contain properties that mirror those of the
        //     JSON packet.
        //
        $decodedResponse = json_decode($httpsResponse);      		 
		    // print_r($decodedResponse); exit;
        //
        //  2.  Process the Payment Transaction Response.
        //
        if ($decodedResponse->result == 0x01)
        {
         // echo "Inside decodedResponse";
            //
		    //  The Paylink server has generated and returned a Payment Token
            //  and a URL to which the Customer Browser may be referred to
            //  complete the Payment Transaction using the Paylink Payment Form.
            //
            // Yii::app()->functions->update_order($get_order_id);
            $token = $decodedResponse->id;
      
            $url = $decodedResponse->url;
            
            //
            //  TODO: Redirect Customer Browser to Paylink Payment Form (see below)
            //
            //  OR
            //
            //  TODO: Embed link to Paylink Payment Form in HTTP Response (see below)
            //
        }
        else
        {
           $error = "Merchant Citypay Credential has been wrongly set";
           $this->render('citypay_error',array('error'=>$error));
           exit;
            //
            //  The Paylink server has encountered Payment Transaction Request
            //  authentication, validation or other upstream errors while processing
            //  the Payment Transaction Request.
            //
            //  TODO: Handle Payment Transaction Request processing errors (see below)
            //
        }	

    }
	else
	{ 
        //
        //  The Paylink server has generated a HTTP response code that
        //  indicates that an error has occurred.
        //
        //  TODO: Handle Payment Transaction Request non-200 HTTP response codes (see below)
        //
	}
    }
    else
    {   

            //
            //	Move the file pointer associated with the temporary stream used to
            //  receive connection processing output generated by cURL back to the
            //  start of the file.
            //
        rewind($curl_stderr);

            //
            //	Get the contents of the temporary stream used to receive connection
            //	processing output generated by cURL.
            //
        $req_stderr = stream_get_contents($curl_stderr, 4096);

            //
            //	Close the dispose of the temporary stream used to receive connection 
            //  processing output generated by cURL.
            //
        fclose($curl_stderr);

        //
        //  Obtain any diagnostic information from the cURL request object.
        //
        $req_errno = curl_errno($ch);
        $req_error = curl_error($ch);

        //
        //	Close the cURL request object to release system resources associated
            //	with it.
        //
        curl_close($ch);

            //
        //  TODO: Handle cURL HTTP connection error and log any relevant
        //        diagnostic information to a log file, as appropriate.
        //  
    }	    	
	  $this->redirect($url);	


?>

<div class="sections section-grey2 section-orangeform">
  <div class="container">  
    <div class="row top30">
       <div class="inner">
          <h1><?php echo t("Pay using CityPay")?></h1>
          <div class="box-grey rounded">	
          
          <?php if ( !empty($error)):?>
           <p class="text-danger"><?php echo $error;?></p>  
          <?php else :?> 
           <p><?php echo t("Please wait while we redirect you to CityPay.")?></p>
          <?php endif;?>
               
          </div> <!--box-->
       </div> <!--inner-->
    </div> <!--row-->
  </div> <!--container-->
</div><!-- sections-->
