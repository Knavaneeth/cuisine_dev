<?php
/**
 * MerchantController Controller
 *
 */
if (!isset($_SESSION)) { session_start(); }

class MerchantController extends CController
{
	public $layout='merchant_tpl';	
	public $crumbsTitle='';
	
	public function accessRules()
	{		
		
	}
	
	public function beforeAction($action)
    {    	
    	$action_name= $action->id ;

    	$accept_controller=array('login','ajax','autologin','terms_and_conditions');
	    //if(!Yii::app()->functions->isMerchantLogin() )
	    if(!Yii::app()->functions->validateMerchantSession() )
	    {
	    	if (!in_array($action_name,$accept_controller)){	 	           
	           if ( Yii::app()->functions->has_session){
	    	   	    $message_out=t("You were logout because someone login with your account");
	    	   	    $this->redirect(array('merchant/login/?message='.urlencode($message_out)));
	    	   } else $this->redirect(array('merchant/login'));	           
	    	}
	    }		    
	    
	    if ($action_name=="autologin"||$action_name=="terms_and_conditions"){
	    	return true;
	    }
	    /*echo $this->uniqueid;
	    echo '<br/>';
	    echo $action_name;*/
	    if ( $this->uniqueid=="merchant"){
	    	if ( !Yii::app()->functions->hasMerchantAccess($action_name)){
	    		if ( $action_name!="login"){
	    			if ( $action_name!="index"){
	    				$this->crumbsTitle=Yii::t("default","No Access");		
	    		        $this->render('noaccess');
	    		        return ;
	    			}    
	    		}
	    	}
	    }
	    return true;	    
    }	
        	
	public function init()
	{		
		 $name=Yii::app()->functions->getOptionAdmin('website_title');
		 if (!empty($name)){		 	
		 	 Yii::app()->name = $name;
		 }		 
		 
		 
		 $mtid=Yii::app()->functions->getMerchantID();		 
		 // set website timezone
		 $website_timezone=Yii::app()->functions->getOptionAdmin("website_timezone");		 
		 if (!empty($website_timezone)){		 	
		 	Yii::app()->timeZone=$website_timezone;
		 }		 		 
		 $mt_timezone=Yii::app()->functions->getOption("merchant_timezone",$mtid);	   	   	    	
    	 if (!empty($mt_timezone)){    	 	
    		Yii::app()->timeZone=$mt_timezone;
    	 }		     	 
	}
				  
	public function actionIndex()
	{					
		if ( !Yii::app()->functions->isMerchantLogin()){						
			$this->layout='login_tpl';
			$this->render('login');
		} else {											
			$this->crumbsTitle=Yii::t("default","Dashboard");		
			$this->render('dashboard');			
		}		
	}	
	
	 public function actionImage_upload()
        {    
            ini_set('max_execution_time', 3000); 
  			ini_set('memory_limit', '-1');                        
			$html=$error_msg= $shop_ad_id='';
			$error_sts=0;
			$image_data = $_POST['img_data'];
 
				$base64string = str_replace('data:image/png;base64,', '', $image_data);
				$base64string = str_replace(' ', '+', $base64string);
				$data = base64_decode($base64string);                                
				$img_name = time();
				$file_name_final='img_'.$img_name.".png";
				$img_name2 = "original_".$file_name_final; 
				file_put_contents('upload/'.$img_name2, $data); 				
				//$imageFileType= 'png';
				//$rawname='gig_'.$img_name;
				$source_image= 'upload/'.$img_name2; 
				$blog_themb = $this->actionimage_resize(100,100,$source_image,$file_name_final);
				$blog_themb_one = $this->actionimage_resize(50,50,$source_image,$file_name_final);                                
                                
                          $html =    "<img class=\"uk-thumbnail uk-thumbnail-mini\" title=\"merchant logo\" alt=\"merchant logo\" src=\"".Yii::app()->request->baseUrl."/".$source_image."\"><input type=\"hidden\" value=\"".$img_name2."\" name=\"photo\"><p><a href=\"javascript:rm_preview();\">Remove image</a></p>";					
		    
		    $response = array(
								'state'  => 200,
								'message' => $error_msg,
								'result' => $html,								
								'sub_html' => $img_name2,
								'sts' => $error_sts
		    );
  		    echo json_encode($response); 
            
        }
        
         	public function actionImage_resize($width=0,$height=0,$image_url,$filename)
	{          
                    
		$source_path = $image_url;
		list($source_width, $source_height, $source_type) = getimagesize($source_path);
		/*switch ($source_type) {
			case IMAGETYPE_GIF:
				$source_gdim = imagecreatefromgif($source_path);
				break;
			case IMAGETYPE_JPEG:
				$source_gdim = imagecreatefromjpeg($source_path);
				break;
			case IMAGETYPE_PNG:
				$source_gdim = imagecreatefrompng($source_path);
				break;
		}*/
		$source_gdim = imagecreatefrompng($source_path);
		$source_aspect_ratio = $source_width / $source_height;
		 
		 $desired_aspect_ratio = $width / $height; 
		
		if ($source_aspect_ratio > $desired_aspect_ratio) {
			/*
			 * Triggered when source image is wider
			 */
			 
			$temp_height = $height;
			$temp_width = ( int ) ($height * $source_aspect_ratio);
		} else {
			/*
			 * Triggered otherwise (i.e. source image is similar or taller)
			 */
			$temp_width = $width;
			$temp_height = ( int ) ($width / $source_aspect_ratio);
		}
		
		/*
		 * Resize the image into a temporary GD image
		 */
		$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
		imagecopyresampled(
			$temp_gdim,
			$source_gdim,
			0, 0,
			0, 0,
			$temp_width, $temp_height,
			$source_width, $source_height
		);
		
		/*
		 * Copy cropped region from temporary image into the desired GD image
		 */
		
		$x0 = ($temp_width - $width) / 2;
		$y0 = ($temp_height - $height) / 2;
		$desired_gdim = imagecreatetruecolor($width, $height);
		imagecopy(
			$desired_gdim,
			$temp_gdim,
			0, 0,
			$x0, $y0,
			$width, $height
		);
		
		/*
		 * Render the image
		 * Alternatively, you can save the image in file-system or database
		 */
		//$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
		 
		   $image_url =  "upload/".$width."_".$height."_".$filename."";    
		imagepng($desired_gdim,$image_url);
		
		return $image_url;
		
		/*
		 * Add clean-up code here
		 */
	}
	
	
	public function actionDashBoard()
	{					
		$this->crumbsTitle=Yii::t("default","Dashboard");
		
		if ( !Yii::app()->functions->isMerchantLogin()){						
			$this->layout='login_tpl';
			$this->render('login');
		} else {									
			$this->crumbsTitle=Yii::t("default","Dashboard");
			$this->render('dashboard');			
		}		
	}	
	
	public function actionTerms_and_conditions($restaurant_slug='')
	{

		$DbExt=new DbExt;		
		$merchant_id = '';
		$restaurant_slug = key($_GET);
		$return_array = '';
		if($restaurant_slug!='')
		{
			$merchant_slug_query = "SELECT `merchant_id` FROM `mt_merchant` WHERE `restaurant_slug`  LIKE '%".$restaurant_slug."%'";		 		 			 
			if($merchant_slug = $DbExt->rst($merchant_slug_query))
			{	
				if(isset($merchant_slug[0]['merchant_id']))
				{
					$merchant_id = $merchant_slug[0]['merchant_id'];
					$url_stmt="SELECT `option_value` FROM `mt_option` WHERE `option_name` LIKE '%merchant_terms_conditions%' AND `merchant_id` = ".$merchant_id;
					if($url_res = $DbExt->rst($url_stmt))
					{
						if(isset($url_res[0]['option_value']))
						{
							$return_array = $url_res[0]['option_value'];
						}						
					}	
				}
			}
		}		
		 
		$this->renderPartial('/payment_tpl/custom-page',array('content'=>$return_array)); 	
	}
	
	public function actionLogin()
	{		
		if (isset($_GET['logout'])){
			//Yii::app()->request->cookies['kr_merchant_user'] = new CHttpCookie('kr_merchant_user', ""); 			
			unset($_SESSION['kr_merchant_user']);
		}		
		$this->layout='login_tpl';
	    $this->render('login');
	}
	
	public function actionAjax()
	{			
		if (isset($_REQUEST['tbl'])){
		   $data=$_REQUEST;	
		} else $data=$_POST;
				
		if (isset($data['debug'])){
			dump($data);
		}
		$class=new AjaxAdmin;
	    $class->data=$data;
	    $class->$data['action']();	    
	    echo $class->output();
	    yii::app()->end();
	}	
	
	public function actionCategoryList()
	{	    
		$this->crumbsTitle=Yii::t("default","Category");
		
	    if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->render('category_add');
			} elseif ( $_GET['Do'] =="Sort" ){	
			   $this->render('category_sort');
			} else $this->render('category_list');
		} else $this->render('category_list');
	}
	
	public function actionsubCategoryList()
	{	    
		$this->crumbsTitle=Yii::t("default","Sub Category");
		
	    if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->render('subcategory_add');
			} elseif ( $_GET['Do'] =="Sort" ){	
			   $this->render('category_sort');
			} else $this->render('subcategory_list');
		} else $this->render('subcategory_list');
	}



	public function actiondeliveryboys()
	{		
		$this->crumbsTitle=Yii::t("default","Delivery Drivers List");		
	    if (isset($_GET['Do']))
	    {
			if ( $_GET['Do']=="Add")
			{
				$this->render('drivers_add');
			} 
			elseif ( $_GET['Do'] =="Sort" )
			{	
			   $this->render('category_sort');
			} else $this->render('drivers_list');
		} 
		else 
		{
			$this->render('drivers_list');
		}
	}

		public function actiontablebooking_exception()
	{		
		$this->crumbsTitle=Yii::t("default","Table Booking Exception List");		
	    if (isset($_GET['Do']))
	    {
			if ( $_GET['Do']=="Add")
			{
				$this->render('exception_add');
			} 
			elseif ( $_GET['Do'] =="Sort" )
			{	
			   $this->render('category_sort');
			} else $this->render('drivers_list');
		} 
		else 
		{
			$this->render('exception_list');
		}
	}

	public function actionupdate_status()
	{
		$id = $_POST['id'];
		$sts = $_POST['sts'];
		$return_value = 1 ;
		$params_update = array('status'=>'active');
		if($sts==1)
		{
			$params_update = array('status'=>'deactive');
		}		
		$db_ext      = new DbExt;
		if($db_ext->updateData("{{delivery_boys}}",$params_update,'id',$id))
		{
			$return_value = 0;
		}
		echo $return_value;
	}

	public function actionAddOnCategory()
	{
				
		$this->crumbsTitle=Yii::t("default","Addon Category");
		
		if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->render('addon_category_add');
			} elseif ( $_GET['Do'] =="Sort" ){					
			   $this->render('addon_category_sort');		
			} else $this->render('addon_category_list');
		} else $this->render('addon_category_list');
	}		
	
	public function actionAddOnItem()
	{		
		$this->crumbsTitle=Yii::t("default","Addon Item");
		
		if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->render('addon_item_new');		
            } elseif ( $_GET['Do'] =="Sort" ){	
			   $this->render('addon_item_sort');	
			} else $this->render('addon_item_list');		
		} else $this->render('addon_item_list');		
	}

	public function actionSize()
	{
		$this->crumbsTitle=Yii::t("default","Size");
		
		if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->render('size_add');			
           } elseif ( $_GET['Do'] =="Sort" ){	
			   $this->render('size_sort');	
			} else $this->render('size');		
		} else $this->render('size');		
	}
	
	 public function actionCitypay()
	{
		$py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('cpy',(array)$py))
                        {
	    	$this->crumbsTitle=Yii::t("default","Citypay Settings");
	    	$this->render('citypay-settings');
                        } 
                        else 
                $this->render('noaccess');
	}
	

	public function actionChippin()
	{		 
		$py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('cpy',(array)$py))
                        {
	    	$this->crumbsTitle=Yii::t("default","Chippin Settings");
	    	$this->render('chip_pin-settings');
                        } 
                        else 
                $this->render('noaccess');
	}

	public function actionCookingRef()
	{			
		$this->crumbsTitle=Yii::t("default","Cooking Reference");
		
		if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->render('cooking-ref-add');			
            } elseif ( $_GET['Do'] =="Sort" ){	
			   $this->render('cooking_ref_sort');	
			} else $this->render('cooking-ref');		
		} else $this->render('cooking-ref');
	}
	
	public function actionFoodItem()
	{
		$this->crumbsTitle=Yii::t("default","Food Item");
		
		if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->render('food-item-add');
			} elseif ( $_GET['Do'] =="Sort" ){	
			   $this->render('food_item_sort');	
			} else $this->render('food-item-list');		
		} else $this->render('food-item-list');
	}
	
	 public function actionItemCategoryImage()
	{
            if (isset($_GET['Do']))
                {
                if ($_GET['Do']=="Add")
                    {
			   $this->crumbsTitle=Yii::t("default","Add Background Image");
                           $this->render('item-category-image-add');
                    } 
                    else 
                    {
	   	   	   $this->crumbsTitle=Yii::t("default","Background Image Sort");
                         $this->render('bgimg-sort');
                    }
		} 
                else 
                {
                            $this->crumbsTitle=Yii::t("default","Item Category Image");
                            $this->render('category-img-list');		     
		}       	
	}	


	public function actionsetNewtableBookingtime()
	{
		$current_date = $_POST['currentDate'];
		$val = strtolower(date('l',strtotime($current_date)));
		$merchant_id  = Yii::app()->functions->getMerchantID();


		if($table_booking_settings =Yii::app()->functions->get_merchant_table_booking_settings($merchant_id,$current_date))
		{

		}	
		else
		{

		}



		if($result = Yii::app()->functions->get_merchant_splitup_time($merchant_id))
	    {
	        foreach ($result as $check_merchant_open) 
	        {
	          if($check_merchant_open['option_name']=="stores_open_day")
	          {
	            $restaurant_opening_days = isset($check_merchant_open['option_value'])?json_decode(str_replace("\\","",$check_merchant_open['option_value']),true):'';
	          }
	        }         
	    } 


	    if(in_array($val,$restaurant_opening_days))
	    {

	    
			foreach ($result as $key=>$merchant_timings) 
	          { 
	            $weekday  = $val;
	            if($merchant_timings['option_name']=="stores_open_starts")
	            { 
	              $decoded_option_value = isset($merchant_timings['option_value'])?json_decode(str_replace("\\","",$merchant_timings['option_value']),true):'';
	              
	              if(!empty($decoded_option_value))
	              {           
	                 $merchant_open_close["stores_open_starts"] = $decoded_option_value[$weekday];
	              }          
	            }
	            if($merchant_timings['option_name']=="stores_open_ends")
	            { 
	              $decoded_option_value = isset($merchant_timings['option_value'])?json_decode(str_replace("\\","",$merchant_timings['option_value']),true):'';
	              if(!empty($decoded_option_value))
	              {           
	                 $merchant_open_close["stores_open_ends"] = $decoded_option_value[$weekday];
	              }          
	            }
	            if($merchant_timings['option_name']=="stores_open_pm_start")
	            { 
	              $decoded_option_value = isset($merchant_timings['option_value'])?json_decode(str_replace("\\","",$merchant_timings['option_value']),true):'';
	              if(!empty($decoded_option_value))
	              {           
	                 $merchant_open_close["stores_open_pm_start"] = $decoded_option_value[$weekday];
	              }          
	            }
	            if($merchant_timings['option_name']=="stores_open_pm_ends")
	            { 
	              $decoded_option_value = isset($merchant_timings['option_value'])?json_decode(str_replace("\\","",$merchant_timings['option_value']),true):'';
	              if(!empty($decoded_option_value))
	              {           
	                 $merchant_open_close["stores_open_pm_ends"] = $decoded_option_value[$weekday];
	              }          
	            }                  
	          }


	          $mannual_today_start = '';
	          if(isset($merchant_open_close["stores_open_starts"])&&(!empty($merchant_open_close["stores_open_starts"])))
	          {
	            $mannual_today_start = $date.' '.$merchant_open_close["stores_open_starts"];        
	            $mannual_today_start = date('Y-m-d H:i:s',strtotime($mannual_today_start));
	          }
	          $mannual_today_ends = '';
	          if(isset($merchant_open_close["stores_open_ends"])&&(!empty($merchant_open_close["stores_open_ends"])))
	          {
	            $mannual_today_ends = $date.' '.$merchant_open_close["stores_open_ends"];       
	            $mannual_today_ends = date('Y-m-d H:i:s',strtotime($mannual_today_ends));
	          }

	          $mannual_today_pm_start = '';
	          if(isset($merchant_open_close["stores_open_pm_start"])&&(!empty($merchant_open_close["stores_open_pm_start"])))
	          {
	            $mannual_today_pm_start = $date.' '.$merchant_open_close["stores_open_pm_start"];       
	            $mannual_today_pm_start = date('Y-m-d H:i:s',strtotime($mannual_today_pm_start));
	          }
	          $mannual_today_pm_ends = '';
	          if(isset($merchant_open_close["stores_open_pm_ends"])&&(!empty($merchant_open_close["stores_open_pm_ends"])))
	          {
	            $mannual_today_pm_ends = $date.' '.$merchant_open_close["stores_open_pm_ends"];       
	            $mannual_today_pm_ends = date('Y-m-d H:i:s',strtotime($mannual_today_pm_ends));
	          }   
	             
	           $timings_array = array();

	          $temp_closing_time = '';
	          $temp_current_time = '';
	          $temp_today_ends   = '';             
	          while($mannual_today_ends>=$mannual_today_start)
	          { 
	            $temp_current_time  = $mannual_today_start ;            
	            $temp_closing_time  = strtotime($temp_current_time.'+30 minutes');            
	            $temp_today_ends    = strtotime($mannual_today_ends);                     
	            if(($temp_closing_time<=$temp_today_ends))
	            {
	              $timings_array['start_time'][] = $mannual_today_start;
	              $mannual_today_start = date('Y-m-d H:i:s',strtotime($mannual_today_start.'+30 minutes'));
	              $timings_array['end_time'][] = $mannual_today_start;              
	            }
	            else
	            {
	              $mannual_today_start = date('Y-m-d H:i:s',strtotime($mannual_today_start.'+30 minutes'));
	            }                      
	             
	          }


	          $temp_pm_closing_time = '';
	          $temp_pm_current_time = '';
	          $temp_pm_today_ends   = ''; 
	          while($mannual_today_pm_ends>=$mannual_today_pm_start)
	          {   
	            $temp_pm_current_time   = $mannual_today_pm_start ;           
	            $temp_pm_closing_time = strtotime($temp_pm_current_time.'+30 minutes');           
	            $temp_pm_today_ends     = strtotime($mannual_today_pm_ends);
	            if(($temp_pm_closing_time<=$temp_pm_today_ends))
	            {
	              $timings_array['start_time'][] = $mannual_today_pm_start;
	              $mannual_today_pm_start = date('Y-m-d H:i:s',strtotime($mannual_today_pm_start.'+30 minutes'));
	              $timings_array['end_time'][] = $mannual_today_pm_start;
	            }
	            else
	            {
	              $mannual_today_pm_start = date('Y-m-d H:i:s',strtotime($mannual_today_pm_start.'+30 minutes'));
	            }
	          } 

	          $select_option = array();
	          
	          if(sizeof($timings_array['start_time'])>0&&sizeof($timings_array['end_time'])>0)
	          {
	            foreach ($timings_array['start_time'] as $key=>$timings) 
	            {
	              
	              if(isset($timings_array['start_time'][$key]))
	              {
	                $select_option[date('H:i',strtotime($timings))."-".date('H:i',strtotime($timings_array['end_time'][$key]))] =   date('H:i  A',strtotime($timings))." - ".date('H:i A',strtotime($timings_array['end_time'][$key]));
	              }
	              // $select_option[date('H:i',strtotime($timings))."-".date('H:i',strtotime($timings_array['start_time']))
	              
	            }
	          }     
        }  
        else
        {
        	$select_option = array();
        }
          $html = '';
          if(sizeof($select_option)>0)
          {
          	foreach ($select_option as $timing_key => $timing_value) 
          	{




          		  		$available_checked = '';
				  		$seating_capacity  = '';
					 	$table_booking_timings = array();
					 	$table_booking_seat_capacity = array();
					 	if(isset($table_booking_settings['timings'])&&sizeof($table_booking_settings['timings'])>0)
					 	{
					  		$table_booking_timings = json_decode($table_booking_settings['timings'],true);
					  	}


					 	if(isset($table_booking_settings['seat_capacity'])&&sizeof($table_booking_settings['seat_capacity'])>0)
					 	{
					  		$table_booking_seat_capacity = json_decode($table_booking_settings['seat_capacity'],true);
					  	}

					 	if(isset($table_booking_timings[$val]))
					  	{ 
					  		if($table_booking_timings[$val][$timing_key]==2)
					  		{
					  			$available_checked = "checked='checked'";
					  		}
					  	}	

						if(isset($table_booking_seat_capacity[$val]))
					  	{
					  		if($table_booking_seat_capacity[$val][$timing_key]!='')
					  		{

					  			$seating_capacity = $table_booking_seat_capacity[$val][$timing_key];
					  		}
					  	}		  	








          		$start_time   = '';
          		$end_time     = '';
          		$timing_value = explode("-", $timing_value);	
          		if(isset($timing_value[0]))
          		{
          			$start_time   = $timing_value[0];
          		}
          		if(isset($timing_value[1]))
          		{
          			$end_time     = $timing_value[1];
          		}
          		$html .= "<tr> <td> <input type='checkBox' name='enable_slot[".$val."][".$timing_key."]' value='2' ".$available_checked." > </td>";
          		$html .= "<td><input type='text' name='opening_hours' value='".$start_time."' readonly='readonly'></td>";
          		$html .= "<td><input type='text' name='closing_hours' value='".$end_time."' readonly='readonly'></td>";
          		$html .= "<td><input type='text' name='seating_capacity[".$val."][".$timing_key."]' value='".$seating_capacity."'></td></tr>";
          	}
          }
          else
          {
          			$html .= "<tr> <td id='mandatory-fields'> Sorry ! The restaurant is closed Today </td><td> </td><td> </td><td> </td> </tr>";
          }

          echo $html ;
	}


	/* public function actionItemCategoryImage()
	{
		$this->crumbsTitle=Yii::t("default","Add Food Category Image");
		$this->render('item-category-image-add');
	} */


	public function actionMerchant()
	{
		$this->crumbsTitle=Yii::t("default","Merchant");
		$this->render('merchant-info');
	}
	
	public function actionSettings()
	{
		$this->crumbsTitle="Settings";
		$this->render('settings');
	}
	
	public function actiondeals()
	{
	  if (isset($_GET['Do']))
	    {
		    if ($_GET['Do']=="Add")
	        {
			    $this->crumbsTitle=Yii::t("default","  Add Deals  ");
		        $this->render('deals-add');
	        }             
		}
		else
		{
			$this->crumbsTitle="Deals";
			$this->render('deals-list');		
		} 
		
	}

	public function actionadd_bogo_multi_size()
	{		
		// print_r($_POST);
		$status      = 1 ;
		$item_id 	 = $_POST['item_id'];
		$size    	 = $_POST['size']; 
		//$size    	 = implode(",",$size);
		$size_names  = '';
		$appending_sizes = '';
		$extract_size= array();
		foreach ($size as $each_size) 
		{
			$size_only = explode("|",$each_size);
			if(isset($size_only[1])&&!empty($size_only[1]))
			{
				$size_only = $size_only[1];
			}
			array_push($extract_size,$size_only);
		}
		if(!empty($extract_size))
		{
			$size_names	 = implode(",",$extract_size);
			$initial_value = 1 ;
			foreach($extract_size as $sizes)
			{
				if($initial_value == 1 )
				{
					$appending_sizes .= " `size_name` LIKE '%".$sizes."%' ";
				}
				else
				{
					$appending_sizes .= " OR `size_name` LIKE '%".$sizes."%' ";	
				}
				$initial_value += 1 ;
			}
		}		
		$merchant_id = $_POST['merchant_id'];
		$return_value= '';
		$db_ext      = new DbExt;
		$stmt        = "SELECT `size_id` FROM `mt_size` WHERE ".$appending_sizes." AND `merchant_id` = ".$merchant_id." AND `status` = 'publish' "; 
		
		$res		 = $db_ext->rst($stmt);		
		if(!empty($res))
		{			
			$multi_size_array = array();
			foreach($res as $invidual_size)
			{				
				array_push($multi_size_array,$invidual_size['size_id']);
			}  			
			$return_value = json_encode(array('item_id'=>$item_id,'size'=>$size,'size_id'=>$multi_size_array));				
		}
		echo $return_value;
	}

	public function actionSocialSettings()
	{
		$this->crumbsTitle=t("Social Settings");
		$this->render('social-settings');
	}
	
	public function actionAlertSettings()
	{
		$this->crumbsTitle=Yii::t("default","Alert Settngs");
		$this->render('alert-settings');
	}
	
	public function actionSMSSettings()
	{
		$mechant_sms_enabled=Yii::app()->functions->getOptionAdmin('mechant_sms_enabled');
		if ( $mechant_sms_enabled=="yes"){
			$this->render('noaccess');
		} else {		
			
			$ha_sms_credits=Yii::app()->functions->hasSMSCredits();	
			$mechant_sms_purchase_disabled=Yii::app()->functions->getOptionAdmin('mechant_sms_purchase_disabled');		
			if ( $mechant_sms_purchase_disabled=="yes"){
				$ha_sms_credits=true;
			}
			//if (Yii::app()->functions->hasSMSCredits()){
			if ($ha_sms_credits){
			   $this->crumbsTitle=Yii::t("default","SMS Settings");		
			   $this->render('sms-settings');
			} else {
			   $this->crumbsTitle=Yii::t("default","SMS Purchase Credits");
			   $this->render('sms-purchase');
			}
		}
	}
	
	public function actionPaypalSettings()
    {
    	$py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('paypal',(array)$py) || in_array('pyp',(array)$py) ){
	    	$this->crumbsTitle=Yii::t("default","Paypal Settings");
	    	$this->render('paypal-settings');
        } else $this->render('noaccess');
    }
    
    public function actionSalesReport()
    {
    	$this->crumbsTitle=Yii::t("default","Sales Report");
    	$this->render('sales-report');
    }
    
    public function actionSalesSummaryReport()
    {
    	$this->crumbsTitle=Yii::t("default","Sales Summary Report");
    	$this->render('sales-summary-report');
    }
    
    public function actionOrderStatus()
    {
    	if (isset($_GET['Do'])){
    		if ( getOptionA('merchant_status_disabled')!=2){
	    	   $this->crumbsTitle=Yii::t("default","Order Status");
	    	   $this->render('order-status-add');
    		} else $this->render('error',array('message'=>t("This options is disabled by website owner")));
    	} else {
    	   $this->crumbsTitle=Yii::t("default","Order Status");
    	   $this->render('order-status');
    	}
    }
    
    public function actionMerchantStatus()
    {
    	$mt_id=Yii::app()->functions->getMerchantID();
    	if ( $res=Yii::app()->functions->isMerchantCommission($mt_id)){
    		$this->crumbsTitle=Yii::t("default","404 page");
    		$this->render('error',array('message'=>t("Sorry but your not allowed to access this page")));
    	} else {
	    	$this->crumbsTitle=Yii::t("default","Merchant Status");
	    	$this->render('merchant-status');
    	}
    }
    
    public function actionReceiptSettings()
    {
    	$this->crumbsTitle=Yii::t("default","Receipt Settings");
    	$this->render('receipt-settings');
    }
    
    public function actionStripeSettings()
    {
    	$py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('stripe',(array)$py) || in_array('stp',(array)$py) ){
    	    $this->crumbsTitle=Yii::t("default","Stripe Settings");
    	   $this->render('stripe-settings');
    	} else $this->render('noaccess');
    }
    
	public function actionSetlanguage()
	{		
		if (isset($_GET['Id'])){			
			Yii::app()->request->cookies['kr_merchant_lang_id'] = new CHttpCookie('kr_merchant_lang_id', $_GET['Id']);						
			$id=Yii::app()->functions->getMerchantID();			
			Yii::app()->functions->updateMerchantLanguage($id,$_GET['Id']);
			
			if (!empty($_SERVER['HTTP_REFERER'])){
					header('Location: '.$_SERVER['HTTP_REFERER']);
					die();
		    } else {
		    	header('Location: '.Yii::app()->request->baseUrl);
		    	die();
		    }
		}
		header('Location: '.Yii::app()->request->baseUrl);
	}	    
	
	public function actionCreditCardInit()
	{
		$this->crumbsTitle=Yii::t("default","Purchase using Offline Credit Card");
		$this->render('select-cc');
	}
	
	public function actionSmsReceipt()
	{
		$this->crumbsTitle=Yii::t("default","Receipt");
		$this->render('sms-receipt');
	}
	
	public function actionPaypalInit()
	{		
		if ( $info=Yii::app()->functions->getSMSPackagesById($_GET['package_id']) ){
			
			$price=$info['price'];
    	    if ( $info['promo_price']>0){
                 $price=$info['promo_price'];
    		}	    	
    		
    		$paypal_con=Yii::app()->functions->getPaypalConnectionAdmin();    		
    		
    		$type=isset($_GET['type'])?$_GET['type']:'';
    		$getparams="type/".$type."/package_id/".$_GET['package_id'];
    		
	        $params='';
			$x=1;
			$params['L_NAME'.$x]=isset($info['title'])?$info['title']:Yii::t("default","No description");
	        $params['L_NUMBER'.$x]=$info['package_id'];
	        $params['L_DESC'.$x]=isset($info['title'])?$info['title']:Yii::t("default","No description");
	        $params['L_AMT'.$x]=normalPrettyPrice($price);
	        $params['L_QTY'.$x]=1;					
				        
			$params['AMT']=normalPrettyPrice($price);
		    $params['RETURNURL']="http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl."/merchant/paypalPurchase/$getparams";
		    $params['CANCELURL']="http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl."/merchant/smsSettings/";	  	  
		    $params['NOSHIPPING']='1';
	        $params['LANDINGPAGE']='Billing';
	        $params['SOLUTIONTYPE']='Sole';
	        $params['CURRENCYCODE']=adminCurrencyCode();
	        
	        
	        $paypal=new Paypal($paypal_con);
	  	    $paypal->params=$params;
	  	    $paypal->debug=false;
	  	    if ($resp=$paypal->setExpressCheckout()){  	   	  			  	  	  
	  	  	  header("Location: ".$resp['url']);
	  	    } else {
	  	    	$this->render('error',array('message'=>"ERROR: ".$paypal->getError() ));
	  	    }
    		
		} else {
			$this->render('error',array('message'=>Yii::t("default","ERROR: Cannot get package information")));
		}
	}
	
	public function actionPaypalPurchase()
	{
		$this->crumbsTitle=Yii::t("default","Paypal Confirm Purchase");
		$this->render('paypal-confirmation');
	}
	
	public function actionStripeInit()
	{
		$this->crumbsTitle=Yii::t("default","Stripe Payment");
		$this->render('stripe-init');
	}
	
	public function actionSmsBroadcast()
	{
		if (Yii::app()->functions->hasSMSCredits()){
			if (isset($_GET['Do'])){
				if ($_GET['Do']=="view"){
					$this->crumbsTitle=Yii::t("default","SMS BroadCast Details". " ($_GET[bid])");
			        $this->render('sms-broadcast-details');
				} else {
				    $this->crumbsTitle=Yii::t("default","Add SMS BroadCast");
			        $this->render('sms-broadcast');
				}
			} else {		
				$this->crumbsTitle=Yii::t("default","SMS BroadCast");
			    $this->render('sms-broadcast-list');
			}
		} else {
		   $this->crumbsTitle=Yii::t("default","SMS Purchase Credits");
		   $this->render('sms-purchase');
		}
	}
	
	public function actionPurchaseSMS()
	{
		$this->crumbsTitle=Yii::t("default","SMS Purchase Credits");
        $this->render('sms-purchase');
	}
	
	public function actionMercadopagoInit()
	{		
		$this->crumbsTitle=Yii::t("default","Mercadopago Payment");
		$this->render('mercadopago-init');
	}
	
	public function actionmercadopagoSettings()
	{
		$py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('mercadopago',(array)$py) || in_array('mcd',(array)$py)){
		   $this->crumbsTitle=Yii::t("default","Mercadopago");
		   $this->render('mercadopago-settings');
		} else $this->render('noaccess');
	}	
	
	public function actionUser()
	{
		$this->crumbsTitle=Yii::t("default","User List");
		if (isset($_GET['Do'])){
			$this->crumbsTitle=Yii::t("default","User Add/Update");
			$this->render('user-add');		
		} else $this->render('user-list');		
	}
	
	public function actionVoucher()
	{
		$this->crumbsTitle=Yii::t("default","Voucher List");
		if (isset($_GET['Do'])){
			$this->crumbsTitle=Yii::t("default","Voucher Add/Update");
			$this->render('voucher-add');		
		} else $this->render('voucher-list');		
	}
	
	public function actionReview()
	{
		$this->crumbsTitle=Yii::t("default","Customer reviews");		
		if (isset($_GET['Do'])){
			if ( Yii::app()->functions->getOptionAdmin('merchant_can_edit_reviews')=="yes"){			
				$this->render('error',array(
				 'message'=>t("Sorry but you don't have access this page.")
				));
			} else {				
				$this->crumbsTitle=Yii::t("default","Customer reviews Update");
				$this->render('review-add');
			}
		} else $this->render('review-list');				
	}
	
	public function actionPaylineSettings()
	{
		$this->crumbsTitle=Yii::t("default","Payline Settings");
		$this->render('payline-settings');
	}
	
	public function actionPaylineInit()
	{
		$this->crumbsTitle=Yii::t("default","Payline Payment");
		$this->render('payline-init');
	}
	
	public function actionSisowSettings()
	{		
	    $py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('ide',(array)$py)){
		   $this->crumbsTitle=Yii::t("default","Sisow Settings");
		   $this->render('sisow-settings');
		} else $this->render('noaccess');
	}	
	
	public function actionSisowInit()
	{
		$this->crumbsTitle=Yii::t("default","SMS Purchase Credits");
		$this->render('sisow-init');
	}
	
	public function actionpayumoneysettings()
	{		
	    $py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('payu',(array)$py)){
		$this->crumbsTitle=Yii::t("default","PayUMoney Settings");		
		$this->render('payumoney-settings');
		} else $this->render('noaccess');
	}
	
	public function actionPayuInit()
	{
		$this->crumbsTitle=Yii::t("default","Pay using PayUMoney");		
		$this->render('payuinit');
	}
	
	public function actionTableBooking()
	{
		if (isset($_GET['Do'])){
			if ($_GET['Do']=="settings"){
				$this->crumbsTitle=Yii::t("default","Table Booking Settings");		
			    $this->render('tablebooking-settings');
			} else {
			   $this->crumbsTitle=Yii::t("default","Table Booking");		
			   $this->render('tablebooking-add');
			}
		} else {
			$this->crumbsTitle=Yii::t("default","Table Booking");		
			$this->render('tablebooking');
		}
	}
	
	public function actionPayseraSettings()
	{
		$py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('pys',(array)$py)){
			$this->crumbsTitle=Yii::t("default","paysera settings");		
			$this->render('paysera-settings');
		} else $this->render('noaccess');
	}
	
	public function actionPysinit()
	{				
		$db_ext=new DbExt;
				
		$error='';
		$package_id=isset($_GET['package_id'])?$_GET['package_id']:'';	
		$amount_to_pay=0;
		
		$back_url=Yii::app()->request->baseUrl."/merchant/purchasesms";
		$payment_ref=Yii::app()->functions->generateCode()."TT".Yii::app()->functions->getLastIncrement('{{sms_package_trans}}');		
		$package_id=isset($_GET['package_id'])?$_GET['package_id']:'';
		
		$merchant_id=Yii::app()->functions->getMerchantID();		
		
		if ( $res=Yii::app()->functions->getSMSPackagesById($package_id) ){
			$amount_to_pay=$res['price'];
			if ( $res['promo_price']>0){
				$amount_to_pay=$res['promo_price'];
			}	    										
			$amount_to_pay=is_numeric($amount_to_pay)?normalPrettyPrice($amount_to_pay):'';	
			$payment_description.=isset($res['title'])?$res['title']:'';		
			
			/*dump($payment_description);
			dump($amount_to_pay);
			dump($payment_ref);*/
						
			$amount_to_pay=number_format($amount_to_pay,2,'.','');	
			
            $cancel_url=Yii::app()->getBaseUrl(true)."/merchant/purchasesms";
            
            $accepturl=Yii::app()->getBaseUrl(true)."/merchant/pysinit/?type=purchaseSMScredit&package_id=".
            $package_id."&mode=accept&mtid=$merchant_id";	
                                                
            $callback=Yii::app()->getBaseUrl(true)."/paysera/?type=purchaseSMScredit&package_id=".
            $package_id."&mode=callback&mtid=$merchant_id";	
			
			$country=Yii::app()->functions->getOptionAdmin('admin_paysera_country');
		    $mode=Yii::app()->functions->getOptionAdmin('admin_paysera_mode');
		    $lang=Yii::app()->functions->getOptionAdmin('admin_paysera_lang');
		    $currency=Yii::app()->functions->adminCurrencyCode();	  
		    $projectid=Yii::app()->functions->getOptionAdmin('admin_paysera_project_id');		  
		    $password=Yii::app()->functions->getOptionAdmin('admin_paysera_password');
					    
		    if (isset($_GET['mode'])){				    	
		    	
		    	if ($_GET['mode']=="accept"){
		    		
	    		    $payment_code=Yii::app()->functions->paymentCode("paysera");
				  	$params=array(
						  'merchant_id'=>$_GET['mtid'],
						  'sms_package_id'=>$package_id,
						  'payment_type'=>$payment_code,
						  'package_price'=>$amount_to_pay,
						  'sms_limit'=>isset($res['sms_limit'])?$res['sms_limit']:'',
						  'date_created'=>date('c'),
						  'ip_address'=>$_SERVER['REMOTE_ADDR'],
						  'payment_gateway_response'=>json_encode($_GET),						  
						  //'payment_reference'=>$response['orderid']
					 );							 					
					 $db_ext->insertData("{{sms_package_trans}}",$params);		    		
		    		 header('Location: '.Yii::app()->request->baseUrl."/merchant/smsReceipt/id/".Yii::app()->db->getLastInsertID());
		    		 die();		    		 
		    	}
		    			    			    			    			    	   
		    	try {
		    		
		    		$response = WebToPay::checkResponse($_GET, array(
		              'projectid'     => $projectid,
		              'sign_password' => $password,
		            ));      
		            		            
		            if (is_array($response) && count($response)>=1){  
		            	
		            	if ($response['status']==0){
		            		die("payment has no been executed");
		            	}
		            	if ($response['status']==3){
		            		die("additional payment information");
		            	}		    
		            			            			            	 
		            	$stmt="SELECT * FROM
		            	{{sms_package_trans}}
		            	WHERE
		            	merchant_id ='".$_GET['mtid']."'
		            	AND
		            	sms_package_id='".$_GET['package_id']."'
		            	ORDER BY id DESC
		            	LIMIT 0,1
		            	";		            	
		            	if ( $res2=$db_ext->rst($stmt)){		            		
		            		$current_id=$res2[0]['id'];
		            		$params_update=array('status'=>"paid");
		            		$db_ext->updateData("{{sms_package_trans}}",$params_update,'id',$current_id);
		            	}		            
						echo 'OK';
            	        die();
            	         		            	
		            } else $error=t("ERROR: api returns empty");	
		    		
		    	} catch (WebToPayException $e) {
	               $error=t("ERROR: Something went wrong").". ".$e;
	            }    			    	
		    } else {
				try {									
					$params_request=array(
				        'projectid'     => $projectid,
				        'sign_password' => $password,
				        'orderid'       => $payment_ref,
				        'amount'        => $amount_to_pay*100,
				        'currency'      => $currency,
				        'country'       => $country,
				        'accepturl'     => $accepturl,
				        'cancelurl'     => $cancel_url,
				        'callbackurl'   => $callback,
				        'test'          => $mode,
				        'lang'          =>$lang
				       );	
				     if ($mode==2){
				       	unset($params_request['test']);
				     }       
				     				     				     				     				    
				     $request = WebToPay::redirectToPayment($params_request);
					
				} catch (WebToPayException $e) {
		           $error=t("ERROR: Something went wrong").". ".$e;
		        }    			
		    }
		} else $error=Yii::t("default","Failed. Cannot process payment");  
				
		if (!empty($error)){
			$this->render('error',array('message'=>$error));
		}		
	}	
	
	public function actionOBDinit()
	{		
		$db_ext=new DbExt;
		
		$this->crumbsTitle=Yii::t("default","SMS Purchase Credits");
		
		$error='';
		$package_id=isset($_GET['package_id'])?$_GET['package_id']:'';	
		$amount_to_pay=0;
		$merchant_id=Yii::app()->functions->getMerchantID();			
		
		$back_url=Yii::app()->request->baseUrl."/merchant/purchasesms";
		$payment_ref=Yii::app()->functions->generateCode()."TT".Yii::app()->functions->getLastIncrement('{{sms_package_trans}}');			
		if ( $res=Yii::app()->functions->getSMSPackagesById($package_id) ){
			$amount_to_pay=$res['price'];
			if ( $res['promo_price']>0){
				$amount_to_pay=$res['promo_price'];
			}	    										
			$amount_to_pay=is_numeric($amount_to_pay)?normalPrettyPrice($amount_to_pay):'';	
			$payment_description.=isset($res['title'])?$res['title']:'';		
									
			$merchant_info=Yii::app()->functions->getMerchantInfo();			
			$merchant_email=$merchant_info[0]->contact_email;			
			if (!empty($merchant_email)){				
				
				$subject=Yii::app()->functions->getOptionAdmin('admin_deposit_subject');
		    	$from=Yii::app()->functions->getOptionAdmin('admin_deposit_sender');
		    	
		    	if (empty($from)){
		    	    $from='no-reply@'.$_SERVER['HTTP_HOST'];
		    	}
		    	if (empty($subject)){
		    	    $subject=Yii::t("default","Bank Deposit instructions");
		    	}    	
		    			    	
		    	
		    	$link=Yii::app()->getBaseUrl(true)."/merchant/bankdepositverify/?ref=".$payment_ref;
    	        $links="<a href=\"$link\" target=\"_blank\" >".Yii::t("default","Click on this link")."</a>";
    	        $tpl=Yii::app()->functions->getOptionAdmin('admin_deposit_instructions');
		    	if (!empty($tpl)){   
		    		$tpl=Yii::app()->functions->smarty('amount',
    	            Yii::app()->functions->adminCurrencySymbol().Yii::app()->functions->standardPrettyFormat($amount_to_pay),$tpl);
    	            $tpl=Yii::app()->functions->smarty('verify-payment-link',$links,$tpl);    	            
    	            
    	            if (Yii::app()->functions->sendEmail($merchant_email,$from,$subject,$tpl)){
    	            	
    	            	$payment_code=Yii::app()->functions->paymentCode("bankdeposit");
					  	$params=array(
							  'merchant_id'=>$merchant_id,
							  'sms_package_id'=>$package_id,
							  'payment_type'=>$payment_code,
							  'package_price'=>$amount_to_pay,
							  'sms_limit'=>isset($res['sms_limit'])?$res['sms_limit']:'',
							  'date_created'=>date('c'),
							  'ip_address'=>$_SERVER['REMOTE_ADDR'],
							  'payment_gateway_response'=>json_encode($_GET),						  
							  'payment_reference'=>$payment_ref
						 );							
						 		
						 $db_ext->insertData("{{sms_package_trans}}",$params);		    		
			    		 header('Location: '.Yii::app()->request->baseUrl."/merchant/smsReceipt/id/".Yii::app()->db->getLastInsertID());
			    		 die();		    		 
    	            	
    	            } else $error=t("ERROR: cannot send email to")." ".$merchant_email;
		    	} else $error=Yii::t("bank deposit instruction not yet available");
    					
			} else $error=t("please correct your email address. we cannot sent bank instruction with empty merchant email address");
		} else $error=Yii::t("default","Failed. Cannot process payment");  	
		
		if (!empty($error)){
			$this->render('error',array('message'=>$error));
		}				
	}
	
	public function actionBankDepositVerify()
	{
		$this->render('bank-deposit-verification');
	}
	
	public function actionAutoLogin()
	{
		$DbExt=new DbExt;
		$data=$_GET;		
		$stmt="SELECT * FROM
		       {{merchant}}
		       WHERE
		       merchant_id=".Yii::app()->db->quoteValue($data['id'])."
		       AND
		       password=".Yii::app()->db->quoteValue($data['token'])."
		       LIMIT 0,1
		";							
		if ( $res=$DbExt->rst($stmt)){										
			$_SESSION['kr_merchant_user']=json_encode($res);
			
			$session_token=Yii::app()->functions->generateRandomKey().md5($_SERVER['REMOTE_ADDR']);				
			 $params=array(
			  'session_token'=>$session_token,
			  //'last_login'=>date('c')
			 );
			 $DbExt->updateData("{{merchant}}",$params,'merchant_id',$res[0]['merchant_id']);
			 
			 $_SESSION['kr_merchant_user_session']=$session_token;
			 $_SESSION['kr_merchant_user_type']='admin';
			
			$this->redirect(baseUrl()."/merchant",true);			
		} else $msg=t("Login Failed. Either username or password is incorrect");
		echo $msg;
	}
		
	public function actionGallerySettings()
	{
		$this->crumbsTitle=Yii::t("default","gallery settings");		
		$this->render('gallery-settings');
	}
	
	public function actionPayOnDelivery()
	{		
		$py=Yii::app()->functions->getMerchantListOfPaymentGateway();		
		if (in_array('pyr',(array)$py)){
			$merchant_switch_master_pyr=Yii::app()->functions->getOption("merchant_switch_master_pyr",
			Yii::app()->functions->getMerchantID()); 			
			if ( $merchant_switch_master_pyr==2){
				 $this->render('noaccess');
			} else {
		    	$this->crumbsTitle=Yii::t("default","Pay On Delivery");		
			    $this->render('payondelivery');
			}
        } else $this->render('noaccess');
	}
	
	public function actionOffers()
	{
		$this->crumbsTitle=Yii::t("default","Offers");		
		if (isset($_GET['Do'])){
			if ( $_GET['Do']=="Add"){
				$this->crumbsTitle=Yii::t("default","Offers - add");		
				$this->render('offers_add');			
			} else $this->render('category_list');
		} else 	$this->render('offers');		
	}
	
	public function actionBarclay()
	{
		$this->crumbsTitle=Yii::t("default","Barclay settings");		
		$this->render('barclay-settings');
	}
	
	public function actionEpagbg()
	{
		$this->crumbsTitle=Yii::t("default","EpayBg settings");		
		$this->render('epaybg-settings');
	}	
	
	public function actionStatement()
	{
		$this->crumbsTitle=Yii::t("default","Statement");		
		$this->render('statement');
	}
	
	public function actionEarnings()
	{
		$this->crumbsTitle=Yii::t("default","Earnings");		
		$this->render('earnings');
	}
	
	public function actionIngredients()
	{
		$this->crumbsTitle=Yii::t("default","Ingredients");		
		if (isset($_GET['Do'])){
			if ($_GET['Do']=="Add"){
				$this->crumbsTitle=Yii::t("default","Ingredients Add");		
				$this->render('ingredients-add');		
			} else {
				$this->crumbsTitle=Yii::t("default","Ingredients Sort");		
				$this->render('ingredients-sort');		
			}		
		} else $this->render('ingredients');		
	}
	
	public function actionWithdrawals()
	{
		$wd_enabled_paypal=getOptionA('wd_enabled_paypal');
		$wd_bank_deposit=getOptionA('wd_bank_deposit');		
		if ( $wd_enabled_paypal==2 || $wd_bank_deposit==2 ){
			$stats=yii::app()->functions->getOptionAdmin('wd_payout_disabled');		
			if ($stats==2){
				$this->crumbsTitle=Yii::t("default","Withdrawals");		
				$this->render('error',array('message'=>t("Sorry but widthrawal is disabled by the site owner")));
			} else {
				$this->crumbsTitle=Yii::t("default","Withdrawals");		
				$this->render('withdrawals');
			}
		} else {
			$this->render('error',array('message'=>t("Sorry but withdrawals is not available this time. admin has not yet set any payment method")));
		}
	}
	
	public function actionWithdrawalStep2()
	{
		$this->crumbsTitle=Yii::t("default","Withdrawals Complete");		
		$this->render('withdrawals-step2');
	}
	
	public function actionWithdrawalsHistory()
	{
		$this->crumbsTitle=Yii::t("default","Withdrawal History");		
		$this->render('withdrawals-history');
	}
	
	public function actionFaxSettings()
	{
		$this->crumbsTitle=Yii::t("default","Fax Settings");		
		$this->render('fax-settings');
	}
	
	public function actionFaxPurchase()
	{
		$this->crumbsTitle=Yii::t("default","Fax Purchase Credits");		
		$this->render('fax-purchase');
	}
	
	public function actionPay()
	{
		$get=$_GET;
		$raw=base64_decode(isset($_GET['raw'])?$_GET['raw']:'');
		parse_str($raw,$raw_decode);		
		$price='';		
		$description='';
		
		/*dump($get);
		dump($raw_decode);*/
		$package_id=$get['package_id'];
		
		if (is_array($raw_decode) && count($raw_decode)>=1){
			$price=isset($raw_decode['price'])?$raw_decode['price']:'';
			$description=isset($raw_decode['description'])?$raw_decode['description']:'';
		}
		
		$get_params="&method=".$get['method'];
		$get_params.="&purchase=".$get['purchase'];
		$get_params.="&package_id=".$get['package_id'];
		$get_params.="&raw=".$get['raw'];					
		
		if (!empty($price)){
			switch ($get['method']) {
				case "pyp":
					$paypal_con=Yii::app()->functions->getPaypalConnectionAdmin();  
										
					$params='';
					$x=0;
					$params['L_NAME'.$x]=$description;
			        $params['L_NUMBER'.$x]=$get['package_id'];
			        $params['L_DESC'.$x]=$description;
			        $params['L_AMT'.$x]=normalPrettyPrice($price);
			        $params['L_QTY'.$x]=1;					
						        
					$params['AMT']=normalPrettyPrice($price);
$params['RETURNURL']="http://".$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl."/merchant/paymentconfirm/?$get_params";
				    $params['CANCELURL']=$get['return_url'];	  	  
				    $params['NOSHIPPING']='1';
			        $params['LANDINGPAGE']='Billing';
			        $params['SOLUTIONTYPE']='Sole';
			        $params['CURRENCYCODE']=adminCurrencyCode();			        
			        
			        $paypal=new Paypal($paypal_con);
			  	    $paypal->params=$params;
			  	    $paypal->debug=false;
			  	    if ($resp=$paypal->setExpressCheckout()){  	   	  			  	  	  
			  	  	    header("Location: ".$resp['url']);
			  	    } else {
			  	    	$this->render('error',array('message'=>"ERROR: ".$paypal->getError() ));
			  	    }
																	
					break;
					
				case "stp":				
				    $this->crumbsTitle=Yii::t("default","Fax Purchase Credits");			    
				    $this->render('pay_stripe',array(
				      'package_id'=>$package_id,
				      'price'=>$price,
				      'description'=>$description,
				      'redirect'=>"faxreceipt",
				      'payment_type'=>$get['method']
				    ));
				    break;
			
				default:
					break;
			}
		} else $this->render('error',array('message'=>t("Price is not define")));
	}
	
	public function actionPaymentConfirm()
	{
		$get=$_GET;				
		$raw=base64_decode($_GET['raw']);
		parse_str($raw,$raw_decode);		
		$price='';		
		$description='';
		
		//dump($raw_decode);
		if (is_array($raw_decode) && count($raw_decode)>=1){
			$price=isset($raw_decode['price'])?$raw_decode['price']:'';
			$description=isset($raw_decode['description'])?$raw_decode['description']:'';
		}
		
		//dump($get);
		if (!empty($price)){
			switch ($get['method']) {
				case "pyp":
					$this->crumbsTitle=Yii::t("default","Payment Confirmation");		
					$this->render('payment-paypal');
					break;
			
				default:
					$this->render('error',array(
					'message'=>t("Sorry but we cannot find what you are looking for.")));
					break;
			}
		} else $this->render('error',array('message'=>t("Price is not define")));		
	}
	
	public function actionfaxreceipt()
	{
		$this->crumbsTitle=Yii::t("default","Receipt");		
		$this->render('fax-receipt');
	}
	
	public function actionfaxbankdepositverification()
	{
		$this->crumbsTitle=Yii::t("default","Bank Deposit Verification");		
		$this->render('fax-deposit-verify');
	}
	
	public function actionFaxStats()
	{
		$this->crumbsTitle=Yii::t("default","Fax Stats");		
		$this->render('faxstats');
	}
	
	public function actionProfile()
	{
		$merchant_info=Yii::app()->functions->getMerchantInfo();
		$user_id=$merchant_info[0]->merchant_user_id;
		$data=Yii::app()->functions->getMerchantUserInfo($user_id);
		if (is_array($data) && count($data)>=1){
		    $this->crumbsTitle=Yii::t("default","Profile");		
			$this->render('profile',array('data'=>$data));
		} else {
			$this->crumbsTitle=Yii::t("default","Error");		
			$this->render('error',array('message'=>t("Error session has expired")));
		}
	}
	
	public function actionFaxPurchaseTrans()
	{
		$this->crumbsTitle=Yii::t("default","Purchase Credit Transactions");		
		$this->render('fax-purchasetrans');
	}
	
	public function actionPurchaseSmsTransaction()
	{
		$this->crumbsTitle=Yii::t("default","Purchase Credit Transactions");		
		$this->render('sms-purchasetrans');
	}
	
	public function actionShippingRate()
	{
		$this->crumbsTitle=Yii::t("default","Delivery Charges Rates");		
		$this->render('shippingrate');
	}
	
	public function actionDeliverableparish()
	{
		$this->crumbsTitle=Yii::t("default","Delivering Parishes");		
		$this->render('deliverableparish');
	}

	public function actionBookingReport()
	{
		$this->crumbsTitle=Yii::t("default","Booking Summary Report");		
		$this->render('rpt-bookingreport');
	}
	
	public function actionCashStatement()
	{
		$this->crumbsTitle=Yii::t("default","Cash Statement");
		$this->render('statement-cash');
	}
	
	public function actionAuthorize()
	{
		$this->crumbsTitle=Yii::t("default","Authorize.net");
		$this->render('authorize-settings');
	}
	
	public function actionAtzinit()
	{		
		$this->crumbsTitle=Yii::t("default","Pay using Authorize.net");
		$this->render('atz-init');
	}
	
	public function actionEpyinit()
	{
		$this->crumbsTitle=Yii::t("default","Pay using EpayBg");
		$this->render('epy-init');
	}
	
	public function actionEpaybg()
	{
		$post=$_POST;
		$get=$_GET;		
		$error='';
		
			
		switch ($get['mode']) {
			case "accept":
				if ( $res=Yii::app()->functions->barclayGetTokenTransaction($get['token'])){
					
					if ( $package_info=Yii::app()->functions->getSMSPackagesById($res['param1']) ){
						
						$amount_to_pay=$package_info['price'];
						if ( $package_info['promo_price']>0){
							$amount_to_pay=$package_info['promo_price'];
						}	    
						
						$db_ext=new DbExt;
						$payment_code=Yii::app()->functions->paymentCode("epaybg");
	        	        
				        $params=array(
						  'merchant_id'=>Yii::app()->functions->getMerchantID(),
						  'sms_package_id'=>$package_info['sms_package_id'],
						  'payment_type'=>$payment_code,
						  'package_price'=>$amount_to_pay,
						  'sms_limit'=>isset($package_info['sms_limit'])?$package_info['sms_limit']:'',
						  'date_created'=>date('c'),
						  'ip_address'=>$_SERVER['REMOTE_ADDR'],
						  'payment_reference'=>$res['orderid']
						  /*'payment_gateway_response'=>json_encode($chargeArray),
						  'status'=>"paid"*/
						);	    	
						
						if ( $db_ext->insertData("{{sms_package_trans}}",$params)){				
header('Location: '.Yii::app()->request->baseUrl."/merchant/smsReceipt/id/".Yii::app()->db->getLastInsertID());
				           die();
			            } else $error=Yii::t("default","ERROR: Cannot insert record.");	
					}
				} else $error=t("Transaction token not found");
				header('Location: '.websiteUrl()."/merchant/purchasesms?error=".$error); 
				break;
				
			case "cancel":
				header('Location: '.websiteUrl()."/merchant/purchasesms"); 
				break;
			default:
				header('Location: '.websiteUrl()."/merchant/purchasesms"); 
				break;
		}
	}
	
	public function actionOBD()
	{
		$this->crumbsTitle=Yii::t("default","Offline Bank Deposit");
		$this->render('obd-settings');
	}
	
	public function actionOBDReceive()
	{
		$this->crumbsTitle=Yii::t("default","Receive Bank Deposit");
		$this->render('obd-deposit-receive');
	}
	
	public function actionBrainTreeSettings()
	{
		$this->render('braintree-settings');
	}

}
/*END CONTROLLER*/
