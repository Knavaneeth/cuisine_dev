<form id="frm_table_list" method="GET" class="report uk-form uk-form-horizontal" >

<?php 
$order_stats=Yii::app()->functions->orderStatusList(false);    
 
?>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Start Date")?></label>
  <?php echo CHtml::hiddenField('start_date',isset($_GET['start_date'])?$_GET['start_date']:'')?>
  <?php echo CHtml::textField('start_date1',
  isset($_GET['start_date'])?FormatDateTime($_GET['start_date'],false):''
  ,array(
  'class'=>'uk-form-width-large j_date' ,
  'data-id'=>'start_date',
  ))?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","End Date")?></label>
  <?php echo CHtml::hiddenField('end_date',isset($_GET['end_date'])?$_GET['end_date']:'')?>
  <?php echo CHtml::textField('end_date1',
  isset($_GET['end_date'])?FormatDateTime($_GET['end_date'],false):''
  ,array(
  'class'=>'uk-form-width-large j_date',
  'data-id'=>'end_date',
  ))?>
</div>

		<?php 

	//	print_r(Yii::app()->functions->getFoodItemdropdownDeals(Yii::app()->functions->getMerchantID()));

	
	$option_id_value   = '';
	$option_attr_value = '';
	if($booking_status = Yii::app()->functions->get_booking_status())
	{     
		foreach ($booking_status as $booking_status_key => $booking_status_value) 
		{ 
			$option_id_value[$booking_status_key]=$booking_status_value;			 
		}
	}	  
	  
	 ?> 
	  

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Status")?></label>   
  <input type="hidden" name="bookingStatus" id="bookingStatus" value="<?php echo isset($_GET['booking_status'])?($_GET['booking_status']):''; ?>" >
  <?php /* echo CHtml::dropDownList('booking_status[]',isset($data['item_category_id'])?json_decode($data['item_category_id']):"",
	   //(array)Yii::app()->functions->getFoodItemdropdown(Yii::app()->functions->getMerchantID()),   
	  (array)$option_id_value,array(
	  'class'=>'uk-form-width-large chosen',
    'multiple'=>true)); */
    
    echo CHtml::dropDownList('booking_status',isset($_GET['booking_status'])?($_GET['booking_status']):'',	
    (array)$option_id_value,          
    array(
    'class'=>'uk-form-width-large',
    'data-validation'=>"required"
    ))    
    
    ?>

   

</div>


<div class="uk-form-row">
  <label class="uk-form-label">&nbsp;</label>
  <input type="submit" class="uk-button uk-form-width-medium uk-button-success" value="<?php echo t("Search")?>" >  
  <a href="javascript:;" rel="booking-summary-report" class="export_btn uk-button"><?php echo Yii::t("default","Export")?></a>
</div>  

<div style="height:20px;"></div>


<h3 style="text-align:center;"><?php echo t("Booking Summary Report")?></h3>
<?php if (isset($_GET['start_date']) || isset($_GET['end_date'])):?>
<p style="text-align:center;"><?php echo FormatDateTime($_GET['start_date'],false)." ".t("and")." ".FormatDateTime($_GET['end_date'],false)?></p>
<?php else :?>
<p style="text-align:center;"><?php echo t("As of")." ".FormatDateTime(date('F d Y'),false)?></p>
<?php endif;?>

<input type="hidden" name="action" id="action" value="bookingSummaryReport">
<input type="hidden" name="tbl" id="tbl" value="item">
<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
  <!--<caption>Merchant List</caption>-->
   <thead>
        <tr>                         
           <th><?php echo Yii::t('default',"Booking Id")?></th> 
           <th><?php echo Yii::t('default',"Booking Time")?></th> 
           <th><?php echo Yii::t('default',"Name")?></th> 
           <th><?php echo Yii::t('default',"No Of Guest")?></th> 
           <th><?php echo Yii::t('default',"Booking Date")?></th> 
           <th><?php echo Yii::t('default',"status")?></th> 
        </tr>
    </thead>
    <tbody>    
    </tbody>
</table>
<div class="clear"></div>
</form>