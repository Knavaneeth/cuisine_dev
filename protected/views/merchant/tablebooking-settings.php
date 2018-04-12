<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/tablebooking/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/tablebooking" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>

<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/tablebooking/Do/settings" class="uk-button"><i class="fa fa-cog"></i> <?php echo Yii::t("default","Settings")?></a>
</div>

<div class="spacer"></div>

<?php 
$merchant_id=Yii::app()->functions->getMerchantID();
$merchant_booking_alert=Yii::app()->functions->getOption("merchant_booking_alert",$merchant_id);
$tp1=Yii::app()->functions->getOption("merchant_booking_approved_tpl",$merchant_id);
$tp2=Yii::app()->functions->getOption("merchant_booking_denied_tpl",$merchant_id);
if ( empty($tp1)){
	$tp1=EmailTPL::bookingApproved();
}
if ( empty($tp2)){
	$tp2=EmailTPL::bookingDenied();
}
$subject=Yii::app()->functions->getOption("merchant_booking_subject",$merchant_id);
$sender=Yii::app()->functions->getOption("merchant_booking_sender",$merchant_id);
$merchant_booking_receiver=Yii::app()->functions->getOption("merchant_booking_receiver",$merchant_id);
$merchant_sms_booking_receiver = Yii::app()->functions->getOption("merchant_sms_booking_receiver",$merchant_id);
$merchant_booking_tpl=Yii::app()->functions->getOption("merchant_booking_tpl",$merchant_id);

if (empty($merchant_booking_tpl)){
	$merchant_booking_tpl=EmailTPL::bookingTPL();
}
$merchant_booking_receive_subject=Yii::app()->functions->getOption("merchant_booking_receive_subject",$merchant_id);

$days=Yii::app()->functions->getDays();

$max_booked=Yii::app()->functions->getOption("max_booked",$merchant_id);
if (!empty($max_booked)){
	$max_booked=json_decode($max_booked,true);
}

$fully_booked_msg=Yii::app()->functions->getOption("fully_booked_msg",$merchant_id);

$table_booking_settings =Yii::app()->functions->get_merchant_table_booking_settings($merchant_id);

?>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','bookingAlertSettings')?>
	
<h3 style="text-transform:capitalize;"><?php echo t("maximum tables that can be booked per day")?></h3>
<div class="uk-form-row">
<?php if (is_array($days) && count($days)>=1):?>
<ul>

<?php 
      
      $restaurant_opening_days = '';
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
 ?>

<?php foreach ($days as $key=>$val):?>
 <!-- <li>
   <div class="left" style="width:100px;"><?php  echo t($val)?></div>
   <div class="left"><?php echo CHtml::textField("max_booked[$key]",
   isset($max_booked[$key])?$max_booked[$key]:''
   ,array('class'=>''))  ?></div>
   <div class="clear"></div>
 </li> -->

<?php if(sizeof($restaurant_opening_days)>0) 
{ 
  if(in_array($val,$restaurant_opening_days))
  { 

    $date         = date('Y-m-d');
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
         
  ?>
    <li>
       <div class="left" style="width:100px;"><?php  echo ucfirst(t($val));?></div>
       <div class="left"> 

                   <table class="table">
    <thead>
      <tr>
        <th>Available</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Seats Available</th>
      <!--  <th>Seats Filled</th> -->
      </tr>
    </thead>
    <tbody>
    <?php 
     foreach($select_option as $key=>$open_close_times) { 
  		
  		$available_checked = '';
  		$seating_capacity  = '';

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
	  		/* echo $val;
	  		print_r($table_booking_timings[$val]); */
	  		if($table_booking_timings[$val][$key]==2)
	  		{
	  			$available_checked = 2;
	  		}
	  	}	



		if(isset($table_booking_seat_capacity[$val]))
	  	{
	  		/* echo $val;
	  		print_r($table_booking_timings[$val]); */
	  		// echo $table_booking_seat_capacity[$val][$key];
	  		if($table_booking_seat_capacity[$val][$key]!='')
	  		{

	  			$seating_capacity = $table_booking_seat_capacity[$val][$key];
	  		}
	  	}		  	

      $start_time = '';
      $end_time = '';
      $key_explode = explode("-",$key);
      if(isset($key_explode[0]))
      {
          $start_time = $key_explode[0];
      }
      if(isset($key_explode[1]))
      {
          $end_time = $key_explode[1];
      }
      ?>  
      <tr>
        <td><input type="checkBox" name="enable_slot[<?php echo $val; ?>][<?php echo $key; ?>]" value="2" <?php if($available_checked==2) { echo "checked"; } ?> ></td>
        <td><input type="text" name="opening_hours" value="<?php echo $start_time; ?>" readonly="readonly"></td>
        <td><input type="text" name="closing_hours" value="<?php echo $end_time; ?>" readonly="readonly"></td>
        <td><input type="text" name="seating_capacity[<?php echo $val; ?>][<?php echo $key; ?>]" value="<?php echo $seating_capacity; ?>" ></td>
        <!-- <td><input type="text" name="seats_filled" value="<?php  ?>" disabled="disabled" ></td> -->
      </tr> 
    <?php } 
    $select_option = '';
    ?>  
    </tbody>
  </table>


        </div>
       <div class="clear"></div>
    </li> 

<?php 
  }
  else
  { ?>
     <li>
        <div class="left" style="width:100px;"><?php  echo ucfirst(t($val))?></div>
       <div class="left"> Sorry Merchant is Closed ! </div>
       <div class="clear"></div>
     </li>      
<?php  }
} 
else
{ ?>
<li>
   <div class="left" style="width:100px;"> Merchant has no Opening / Closing Time </div>    
</li> 
<?php }
?>


<?php endforeach;?>

</ul>
<?php endif;?>
</div>

<?php // if(Yii::app()->functions->get_merchant_service()==4) {
  
  $gallery=Yii::app()->functions->getOption("merchant_table_menu",$merchant_id);
  $gallery=!empty($gallery)?json_decode($gallery):false;

   
  $spl_gallery=Yii::app()->functions->getOption("merchant_spl_table_menu",$merchant_id);
  $spl_gallery=!empty($spl_gallery)?json_decode($spl_gallery):false;

?>
 
  <div class="uk-form-row"> 
   <label class="uk-form-label"><?php echo Yii::t('default',"Add Inhouse Menu")?></label>
    <div style="display:inline-table;margin-left:1px;" class="button uk-button Inhouse_gallery" id="gallery"><?php echo Yii::t('default',"Browse")?></div>    
    <DIV  style="display:none;" class="gallery_chart_status" >
    <div id="percent_bar" class="gallery_percent_bar"></div>
    <div id="progress_bar" class="gallery_progress_bar">
      <div id="status_bar" class="gallery_status_bar"></div>
    </div>
    </DIV>      
  </div>

  <div class="image_preview" id="gallery-preview">
    <?php if (is_array($gallery) && count($gallery)>=1):?>
    <?php foreach ($gallery as $val):?>
    <?php $id=mktime()+$x++;?>
    <li>
    <img src="<?php echo uploadURL()."/$val"?>" class="uk-thumbnail uk-thumbnail-mini <?php echo $id;?>">
    <p class="<?php echo $id?>">
    <?php echo CHtml::hiddenField('photo[]',$val)?>
    <a href="javascript:rm_gallery('<?php echo $id;?>');"><?php echo t("Remove image")?></a>
    </p>
    </li>
    <?php endforeach;?>
    <?php endif;?>
  </div><!-- gallery-preview-->






  <div class="uk-form-row"> 
   <label class="uk-form-label"><?php echo Yii::t('default',"Add Special Menu")?></label>
    <div style="display:inline-table;margin-left:1px;" class="button uk-button spl_gallery" id="spl_gallery"><?php echo Yii::t('default',"Browse")?></div>    
    <DIV  style="display:none;" class="gallery_chart_status" >
    <div id="percent_bar" class="gallery_percent_bar"></div>
    <div id="progress_bar" class="gallery_progress_bar">
      <div id="status_bar" class="gallery_status_bar"></div>
    </div>
    </DIV>      
  </div>

  <div class="spl_gallery_preview" id="gallery-preview">
    <?php if (is_array($spl_gallery) && count($spl_gallery)>=1):?>
    <?php foreach ($spl_gallery as $spl_val):?>
    <?php $id=mktime()+$x++;?>
    <li>
    <img src="<?php echo uploadURL()."/$spl_val"?>" class="uk-thumbnail uk-thumbnail-mini <?php echo $id;?>">
    <p class="<?php echo $id?>">
    <?php echo CHtml::hiddenField('spl_photo[]',$spl_val)?>
    <a href="javascript:rm_gallery('<?php echo $id;?>');"><?php echo t("Remove image")?></a>
    </p>
    </li>
    <?php endforeach;?>
    <?php endif;?>
  </div><!-- gallery-preview-->


  <div class="spacer"></div>
 
<?php // } ?>


<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Table Booking")?>?</label>
  <?php 
  echo CHtml::checkBox('merchant_table_booking',
  Yii::app()->functions->getOption("merchant_table_booking",$merchant_id)=="yes"?true:false
  ,array(
    'value'=>"yes",
    'class'=>"icheck"
  ))
  ?> 
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo t("Accept booking same day")?>?</label>
  <?php 
  echo CHtml::checkBox('accept_booking_sameday',
  getOption($merchant_id,'accept_booking_sameday')==2?true:false
  ,array(
   'class'=>"icheck",
   'value'=>2
  ))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Fully booked message")?></label>
  <?php 
  echo CHtml::textArea('fully_booked_msg',$fully_booked_msg,array('class'=>'uk-form-width-large'))
  ?>
</div>


<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Disabled Alert Notification")?>?</label>
  <?php 
  echo CHtml::checkBox('merchant_booking_alert',
  $merchant_booking_alert==1?true:false
  ,array('value'=>1,'class'=>"icheck"))
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Email address")?></label>
  <?php 
  echo CHtml::textField('merchant_booking_receiver',$merchant_booking_receiver,array(
   'class'=>"uk-form-width-large",
   'data-validation'=>'email'
  ));
  ?>
</div>
<p class="uk-text-muted"><?php echo Yii::t("default","Email Address that will receive notification when there is new booking"
)?>.</p>

<!--
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Mobile Number")?></label>
  <?php 
  echo CHtml::textField('merchant_sms_booking_receiver',$merchant_sms_booking_receiver,array(
   'class'=>"uk-form-width-large",
   'data-validation'=>'required'
  ));
  ?>
</div>
<p class="uk-text-muted"><?php echo Yii::t("default","Mobile that will receive notification when there is new booking"
)?>.</p>
-->

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Subject")?></label>
  <?php 
  echo CHtml::textField('merchant_booking_receive_subject',$merchant_booking_receive_subject,array(
   'class'=>"uk-form-width-large",
   'data-validation'=>'required'
  ));
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Template")?></label>
  <?php 
  echo CHtml::textArea('merchant_booking_tpl',$merchant_booking_tpl,array(
   'class'=>"uk-form-width-large big-textarea"
  ));
  ?>
</div>

<p><?php echo Yii::t("default","Available Tags")?></p>
<p class="uk-text-muted">{booking-information}</p>

<hr></hr>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Email Sender")?></label>
  <?php 
  echo CHtml::textField('merchant_booking_sender',$sender,array(
   'class'=>"uk-form-width-large",
   'data-validation'=>'email'
  ));
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Email Subject")?></label>
  <?php 
  echo CHtml::textField('merchant_booking_subject',$subject,array(
   'class'=>"uk-form-width-large",
   'data-validation'=>'required'
  ));
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Approved Email Template")?></label>
  <?php 
  echo CHtml::textArea('merchant_booking_approved_tpl',$tp1,array(
   'class'=>"uk-form-width-large big-textarea"
  ));
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Denied Email Template")?></label>
  <?php 
  echo CHtml::textArea('merchant_booking_denied_tpl',$tp2,array(
   'class'=>"uk-form-width-large big-textarea"
  ));
  ?>
</div>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

<p><?php echo Yii::t("default","Available Tags")?></p>
<p class="uk-text-muted">{customer-name}</p>
<p class="uk-text-muted">{booking-information}</p>

</form>