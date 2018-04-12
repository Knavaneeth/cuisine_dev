<?php $mtid=Yii::app()->functions->getMerchantID();	 ?>
<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','parish_delivery_prices')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php 
$mtid=Yii::app()->functions->getMerchantID();	
echo CHtml::hiddenField('merchant_id',$mtid);
$data = Yii::app()->functions->get_parish_deliver_settings($mtid); 
echo CHtml::hiddenField('hidden_delivery_fee',isset($data['delivery_fee'])?$data['delivery_fee']:0);
/* print_r($data);
exit;  */
?>


<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver to All Parish")?>?</label>
  <?php
  $deliver_all_parish = 0 ;
  if(isset($data['deliver_to_all_parish'])) 
  { 
    $deliver_all_parish = $data['deliver_to_all_parish']; 
    // echo "Hi".$deliver_all_parish;
  }
  echo CHtml::checkBox('deliver_all_parish',
  $deliver_all_parish==2?true:false
  ,array(
  'class'=>"icheck deliver_all_parish",
  'value'=>2
  ));
  ?>
</div>

<div class="uk-form-row"  >
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php       
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['merchant_delivery_type'])!=""&&($data['merchant_delivery_type'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('merchant_delivery_type', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'class'=>'merchant_delivery_type',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('merchant_delivery_type', $chk_box2_sts, array(
          'value'=>'1',           
      'class'=>'merchant_delivery_type',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Minimum Order Required")?>?</label>
  <?php
  $minimum_order_req = 0 ;
  if(isset($data['minimum_order_req'])) { $minimum_order_req = $data['minimum_order_req']; }
  echo CHtml::checkBox('minimum_order_req',
  $minimum_order_req==2?true:false
  ,array(
  'class'=>"icheck",
  'value'=>2
  ));
  ?>
</div> 

<?php 
      $default_display_minimum_order_amount = 'style="display:none;"';
      if($minimum_order_req==2)
      {
          $default_display_minimum_order_amount = 'style="display:block;"';
      }
?>

<div class="uk-form-row minimum_order_amount_row" <?php echo $default_display_minimum_order_amount ; ?> >
  <label class="uk-form-label"><?php echo Yii::t("default","Minimum Order Amount")?></label>
  <?php
  $minimum_order_amount = 0 ;
  if(isset($data['minimum_order_amount'])) { $minimum_order_amount = $data['minimum_order_amount']; }
  echo CHtml::textField('free_delivery_above_price',
  $minimum_order_amount
  ,array('class'=>"numeric_only"));  
  ?>
  <span style="padding-left:8px;"><?php echo adminCurrencySymbol();?></span>
</div>

<div class="uk-form-row delivery_fee_row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Fee")?></label>
  <?php
  $delivery_fee = 0 ;
  if(isset($data['delivery_fee'])) { $delivery_fee = $data['delivery_fee']; }
  echo CHtml::textField('delivery_fee',
  $delivery_fee
  ,array('class'=>"numeric_only"));  
  ?>
  <span style="padding-left:8px;"><?php echo adminCurrencySymbol();?></span>
</div>

<?php
    $default_display_delivery_charges_table = 'style="display:block;"';
    if($deliver_all_parish==2)
    {
        $default_display_delivery_charges_table = 'style="display:none;"';
    }
?>

<h3 class="delivery_charges_table" <?php echo $default_display_delivery_charges_table; ?> ><?php echo t("Delivery Rates")?></h3>

<div class="uk-panel uk-table-middle uk-table-divider delivery_charges_table" <?php echo $default_display_delivery_charges_table; ?> >
<table class="table table-bordered">
<thead>
<tr>
 <th><?php echo t("Service Available")?></th>
 <th><?php echo t("Parish")?></th>
 <th><?php echo t("Charges")?></th>
 <th><?php echo t("Minimum Amount Required")?></th>
 <th><?php echo t("Min Sub Total")?></th>
 <th><?php echo t("Delivery Price")?></th> 
</tr>
</thead>

<tbody>
<?php $parish_list = Yii::app()->functions->ParishListMerchant();
foreach($parish_list as $key=>$parishes)
if($key!=0)
{
 ?>  
 <tr>
 <td>
   <?php
   $available_services = array();
   if(isset($data['services'])&&sizeof($data['services']>0))
   {
      $available_services = json_decode($data['services'],true);      
   }
   // print_r($available_services);
  echo CHtml::checkBox('service_available['.$key.']',
  isset($available_services[$key])?true:false
  ,array(
  'class'=>"uk-form",
  'value'=>2
  ));
  ?> 
 </td>
 <td><?php echo $parishes; ?></td>
 <td> <div class="uk-form-row">  
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(isset($available_services[$key]['chargable_type'])!=""&&($available_services[$key]['chargable_type'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('parish_delivery_fee_'.$key, $chk_box1_sts , array(
      'value'=>'0',
      'class'=>'parish_delivery_fee',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('parish_delivery_fee_'.$key, $chk_box2_sts, array(
          'class'=>'parish_delivery_fee',
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>



<td>  
<?php 	 
     $default_display_minimum_order_req_parish = 'style="display:none;"';
    //  if($available_services[$key]['minimum_order_req_parish']==2)
     if($chk_box2_sts)
      {
          $default_display_minimum_order_req_parish = 'style="display:block;"';
      }     
 ?>

<div class="uk-form-row" id="parish_min_amt_div_<?php echo $key; ?>" <?php echo $default_display_minimum_order_req_parish; ?> >
  <label><?php echo Yii::t("default","Required")?>?</label>
  <?php
  $minimum_order_req_parish = 0 ;
  if(isset($available_services[$key]['minimum_order_req_parish'])) { $minimum_order_req_parish = $available_services[$key]['minimum_order_req_parish']; }
  echo CHtml::checkBox('minimum_order_req_parish_'.$key,
  $minimum_order_req_parish==2?true:false
  ,array(
  'class'=>"minimum_order_req_parish",
  'value'=>2
  ));
  ?>
</div> 

 </td>




<td>


<?php 	 
     $default_display_parish_min_amt = 'style="display:none;"';
      if(isset($available_services[$key]['parish_min_amt']))
      {
          $default_display_parish_min_amt = 'style="display:block;"';
      }     
 ?>
 <div class="uk-form-row parish_delivery_amt_<?php echo $key; ?>" <?php  echo $default_display_parish_min_amt; ?> >  
  <?php echo CHtml::textField('parish_min_amt_'.$key,
  isset($available_services[$key]['parish_min_amt'])?$available_services[$key]['parish_min_amt']:""
  ,array(
  'class'=>'uk-form',
  // 'data-validation'=>"required"
  ))?>
  </div>







 </td>











 <td> 
 <?php 
     $default_display_parish_delivery_amt = 'style="display:none;"';
      if($available_services[$key]['chargable_type']==1)
      {
          $default_display_parish_delivery_amt = 'style="display:block;"';
      }     
 ?>
 <div class="uk-form-row parish_delivery_amt_<?php echo $key; ?>" <?php  echo $default_display_parish_delivery_amt; ?> >  
  <?php echo CHtml::textField('delivery_fee_'.$key,
  isset($available_services[$key]['delivery_fee'])?$available_services[$key]['delivery_fee']:""
  ,array(
  'class'=>'uk-form',
  // 'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>
<?php } ?>

</tbody>

</table>
<!-- <a class="uk-button add-table-rate" href="javascript:;">+ <?php echo t("Add Table Rate")?></a> -->
</div>


<div class="spacer"></div>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>