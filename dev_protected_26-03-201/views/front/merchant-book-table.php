<?php if ( $res=FunctionsV3::getMerchantOpeningHours($merchant_id)):?>

<?php

 $client_name = '';	
 $client_email = '';
 if(isset($_SESSION['kr_client']))
 {
 	$first_name = '';
 	$last_name  = '';
 	if(isset($_SESSION['kr_client']['first_name']))
 	{
 		$first_name = $_SESSION['kr_client']['first_name'];
 	}
 	if(isset($_SESSION['kr_client']['last_name']))
 	{
 		$last_name  = $_SESSION['kr_client']['last_name'];
 	}
 	$client_name = $first_name." ".$last_name;	
 }	

 if(isset($_SESSION['kr_client']['email_address']))
 {
 	$client_email = $_SESSION['kr_client']['email_address'];
 }			

 $date_picker_date  = '';	
 $timings_array 	= array();
 $select_option 	= array();
 if(getOption($merchant_id,'accept_booking_sameday'))
	{	
	 if($result = Yii::app()->functions->get_merchant_splitup_time($merchant_id))
			{
				date_default_timezone_set('Europe/Jersey');
	 			$date 				= date('d-m-Y') ;	 			 			
	 			$date_picker_date 	= date('d-m-Y') ;
	 			$replaced_date 		= str_replace("-","/",$date); 
				$weekday 			= strtolower(date('l', strtotime($date)));			
				$merchant_open_close = array();
				$decoded_option_value = '';
				
				/* foreach ($result as $key=>$merchant_timings) 
				{				
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
										
				/* while($mannual_today_ends>=$mannual_today_start)
				{				
					$timings_array['start_time'][] = $mannual_today_start;
					$mannual_today_start = date('Y-m-d H:i:s',strtotime($mannual_today_start.'+30 minutes'));
					$timings_array['end_time'][] = $mannual_today_start;
				}

				while($mannual_today_pm_ends>=$mannual_today_pm_start)
				{				
					$timings_array['start_time'][] = $mannual_today_pm_start;
					$mannual_today_pm_start = date('Y-m-d H:i:s',strtotime($mannual_today_pm_start.'+30 minutes'));
					$timings_array['end_time'][] = $mannual_today_pm_start;
				} 

					$temp_closing_time = '';
					$temp_current_time = '';
					$temp_today_ends   = '';						 
					while($mannual_today_ends>=$mannual_today_start)
					{	
						$temp_current_time  = $mannual_today_start ;						
						$temp_closing_time	= strtotime($temp_current_time.'+30 minutes');						
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
						$temp_pm_closing_time	= strtotime($temp_pm_current_time.'+30 minutes');						
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


				
				if(sizeof($timings_array['start_time'])>0&&sizeof($timings_array['end_time'])>0)
				{
					foreach ($timings_array['start_time'] as $key=>$timings) 
					{
						
						if(isset($timings_array['start_time'][$key]))
						{
							$select_option[date('H:i',strtotime($timings))."-".date('H:i',strtotime($timings_array['end_time'][$key]))] = 	date('H:i  A',strtotime($timings))." - ".date('H:i A',strtotime($timings_array['end_time'][$key]));
						}
						// $select_option[date('H:i',strtotime($timings))."-".date('H:i',strtotime($timings_array['start_time']))
						
					}
				}	 
				//print_r($select_option); */ 


				$merchant_closed = false ;			
				$select_option	 = array();
				$msg             = '';
				$opening_time    = '';

				foreach ($result as $check_merchant_open) 
				{
					if($check_merchant_open['option_name']=="stores_open_day")
					{
						$decoded_option_value = isset($check_merchant_open['option_value'])?json_decode(str_replace("\\","",$check_merchant_open['option_value']),true):'';						 
						if(!in_array($weekday,$decoded_option_value))
						{							
							$merchant_closed = true;
							$msg             = "Sorry the Merchant is closed ";
						}
					}
				}
				if(!$merchant_closed)
				{					 
					foreach ($result as $key=>$merchant_timings) 
					{	 
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

					$temp_closing_time = '';
					$temp_current_time = '';
					$temp_today_ends   = '';						 
					while($mannual_today_ends>=$mannual_today_start)
					{	
						$temp_current_time  = $mannual_today_start ;						
						$temp_closing_time	= strtotime($temp_current_time.'+30 minutes');						
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
						$temp_pm_closing_time	= strtotime($temp_pm_current_time.'+30 minutes');						
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

					 
					if(sizeof($timings_array['start_time'])>0&&sizeof($timings_array['end_time'])>0)
					{
						foreach ($timings_array['start_time'] as $key=>$timings) 
						{
							
							if(isset($timings_array['start_time'][$key]))
							{
								$select_option[date('H:i',strtotime($timings))."-".date('H:i',strtotime($timings_array['end_time'][$key]))] = 	date('H:i  A',strtotime($timings))." - ".date('H:i A',strtotime($timings_array['end_time'][$key]));
								$opening_time[date('H:i',strtotime($timings))."-".date('H:i',strtotime($timings_array['end_time'][$key]))] = date('H:i A',strtotime($timings));
							}
							// $select_option[date('H:i',strtotime($timings))."-".date('H:i',strtotime($timings_array['start_time']))
							
						}
					}
				}					
				if(!empty($msg))
				{
					$select_option['msg'] = $msg;
				}
				array_filter($select_option);				
			}
	}
?>

 


<div class="panel">
	<div class="panel-body">
		<form class="forms form-horizontal" id="frm-book" onsubmit="return false;" autocomplete="off">
			<?php echo CHtml::hiddenField('action','bookATableNewconcept')?>
			<?php echo CHtml::hiddenField('hiddenFunction','bookATable')?>
			<?php echo CHtml::hiddenField('currentController','store')?>
			<?php echo CHtml::hiddenField('merchant-id',$merchant_id)?>
			<?php echo CHtml::hiddenField('baseurl',websiteUrl());  ?>
			<?php echo CHtml::hiddenField('user_selected_time','');  ?>
			<?php echo CHtml::hiddenField('user_already_visited','no');  ?>
			<div class="row">
				<div class="col-lg-12">
					<h2 class="block-title-2"><?php echo t("Booking Information")?></h2>
					<div class="alert alert-success alert-dismissable text-center " id="booking_success" style="display: none;">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  <strong>Thank you !</strong> Your Table Booking has been Recieved ....
					</div>
					<div class="alert alert-danger alert-dismissable text-center " id="booking_error" style="display: none;">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  <p id="booking_error_text"></p>
					</div>
				</div>
			</div>
			<div class="form-group">
			<!--	<label class="col-lg-3 control-label"><?php echo t("Number Of Guests")?></label>
				<div class="col-lg-9">
					<?php echo CHtml::textField('number_guest',''			 
					,array(
					'class'=>'numeric_only form-control',
					'required'=>true
					))?>
				</div> -->

				<div class="col-lg-3">
					 <?php 
					 echo CHtml::dropDownList('no_of_guests','',
								  (array)Yii::app()->functions->get_number_of_guest(),          
								  array(
								  'class'=>'form-control' 
								  ));
					 ?>
				</div>	
				<div class="col-lg-3">
					 <?php echo CHtml::textField('date_booking1',$date_picker_date			 
						,array(
						'class'=>'date_booking form-control',
						'required'=>true,
						'data-id'=>'date_booking'
						))?>
				</div> 
			 
				<div class="col-lg-3">				
					  <?php 			
					if(isset($opening_time))
					{
						if(sizeof($opening_time)>0)
						{
							$stmt = "SELECT * FROM `mt_table_booking` WHERE `mercahnt_id`  = ".$merchant_id;
							$db_ext=new DbExt;
							if($res=$db_ext->rst($stmt))
							{							
								$date_booking = strtotime(date('Y-m-d',strtotime($date_picker_date)));										
								$day = strtolower(date('l', $date_booking));
								
								$available_timing  = json_decode($res[0]['timings'],true);			
								$option_html       = '';

								if(isset($available_timing[$day]))
								{
									// print_r($available_timing[$day]);
									$merchant_enabled_timings = array_keys($available_timing[$day]);
									// print_r($merchant_enabled_timings);
									if(sizeof($available_timing[$day]>0))
									{
										foreach($opening_time as $key=>$mannual_splitted_timings)
										{	
											if(in_array($key, $merchant_enabled_timings))
											{
												$option_html .= '<option value="'.$key.'">'.$mannual_splitted_timings.'</option>'; 
											} 
											else
											{
												$option_html .= '<option value="'.$key.'" disabled>'.$mannual_splitted_timings.'</option>'; 	
											}
										}
									}
								}
								else
								{
									$option_html .= '<option value="" disabled> No Slots for the day </option>'; 	
								}							
							}
						}  
					}


					  /*echo CHtml::dropDownList('table_booking_time','',
								  (array)$opening_time,          
								  array(
								  'class'=>'form-control' 
								  )) */
					  ?>
					  <select id="table_booking_time" name="table_booking_time" class="form-control">
					  	<?php echo $option_html;  ?>
					  </select>
				</div>	
				<div class="col-lg-3">
					   <input type="button" value="<?php echo t("Search")?>" class="btn btn-primary btn-block search_table_booking">
				</div>	
			</div>
			<div class="form-group" id="timing_slots">
			<!--	<label class="col-lg-3 control-label"><?php echo t("Date Of Booking")?></label>
				<div class="col-lg-9">
						<?php // echo date('Y-m-d', strtotime( $date_picker_date )); ?>
						<?php echo CHtml::hiddenField('date_booking',date('Y-m-d',strtotime($date_picker_date)))?>
						<?php echo CHtml::textField('date_booking1',$date_picker_date			 
						,array(
						'class'=>'date_booking form-control',
						'required'=>true,
						'data-id'=>'date_booking'
						))?>
				</div> -->
			</div>
			<div class="form-group">
			<!--	<label class="col-lg-3 control-label"><?php echo t("Booking Time")?></label>
				<div class="col-lg-9">
					<?php /* echo CHtml::textField('booking_time',''			 
					,array(
					'class'=>'form-control',
					'required'=>true,
					)) */

					echo CHtml::dropDownList('table_booking_time','',
								  (array)$select_option,          
								  array(
								  'class'=>'form-control' 
								  ))


					 ?>
				</div> -->
				<span class="booking_error_message"></span>
			</div>
			<div id="booking_details_div" style="display:none;">
			<div class="row">
				<div class="col-lg-12">
					<h2 class="block-title-2"><?php echo t("Contact Information")?></h2>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo t("Booking Date / Time ")?></label>
				<div class="col-lg-9">
					<?php echo CHtml::textField('booking_date_time',''			 
					,array(
					'class'=>'form-control name_validation',
					'required'=>true,
					))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo t("No.of Guest")?></label>
				<div class="col-lg-9">
					<?php echo CHtml::textField('txt_no_of_guests',''			 
					,array(
					'class'=>'form-control name_validation',
					'required'=>true,
					))?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo t("Name")?></label>
				<div class="col-lg-9">					
					<?php echo CHtml::textField('booking_name',$client_name			 
					,array(
					'class'=>'form-control name_validation',
					'required'=>true,
					))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo t("Email")?></label>
				<div class="col-lg-9">
					<?php echo CHtml::textField('email',$client_email			 
					,array(
					'class'=>'form-control email_validation',
					'required'=>true,					
					))?>
				</div>
				<span id="invalid_email" class="has-error" > </span>
			</div>
			<h5 id='result'></h5>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo t("Mobile")?></label>
				<div class="col-lg-9">
					<?php echo CHtml::textField('mobile','+44'			 
					,array(
					'class'=>'form-control mobile_number_val',
					'required'=>true,
					))?>
				</div>
				<span id="invalid_mobile_number" class="has-error" > </span>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label"><?php echo t("Your Instructions")?></label>
				<div class="col-lg-9">
					<?php echo CHtml::textArea('booking_notes',''			 
					,array(
					'class'=>'form-control'			 
					))?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 "></div>
				<div class="col-md-3 "><input type="submit" value="<?php echo t("Book a Table")?>" class="btn btn-primary btn-block"></div>
			</div>
			</div>
		</form>
	</div>
</div>
<?php else :?>
<div class="text-center alert alert-danger mb-0"> <?php echo t("Merchant Opening Hours Not available.")?> </div>
<?php endif;?>
