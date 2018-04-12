<?php $mtid=Yii::app()->functions->getMerchantID();	 ?>
<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','shipppingRates')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>



<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver to All Parish")?>?</label>
  <?php
  echo CHtml::checkBox('deliver_all_parish',
  Yii::app()->functions->getOption("deliver_all_parish",$mtid)==2?true:false
  ,array(
  'class'=>"icheck",
  'value'=>2
  ));
  ?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Minimum Order Required")?>?</label>
  <?php
  echo CHtml::checkBox('minimum_order_req',
  Yii::app()->functions->getOption("minimum_order_req",$mtid)==2?true:false
  ,array(
  'class'=>"icheck",
  'value'=>2
  ));
  ?>
</div> 

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Free delivery above Minimum Order Amount")?></label>
  <?php
  echo CHtml::textField('free_delivery_above_price',
  Yii::app()->functions->getOption("free_delivery_above_price",$mtid)
  ,array('class'=>"numeric_only"));  
  ?>
  <span style="padding-left:8px;"><?php echo adminCurrencySymbol();?></span>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Fee")?></label>
  <?php
  echo CHtml::textField('delivery_fee',
  Yii::app()->functions->getOption("delivery_fee",$mtid)
  ,array('class'=>"numeric_only"));  
  ?>
  <span style="padding-left:8px;"><?php echo adminCurrencySymbol();?></span>
</div>

<h3><?php echo t("Rates")?></h3>

<div class="uk-panel uk-panel-box">
<table class="uk-table table-shipping-rates">
<thead>
<tr>
 <th><?php echo t("Parish")?></th>
 <th><?php echo t("Charges")?></th>
 <th><?php echo t("Price")?></th> 
</tr>
</thead>

<tbody>
 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

 <tr>
 <td>St Helier</td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Deliver Fee")?>?</label>
     <?php  
      $chk_box1_sts = true;
      $chk_box2_sts = false;
      if(($data['status'])!=""&&($data['status'])==1):
      $chk_box1_sts = false;
      $chk_box2_sts = true;
      endif;
      echo "<label> Free </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box1_sts , array(
      'value'=>'0',
      'name'=>'btnname',
      'uncheckValue'=>null
      ));
      echo "&emsp;";
      echo "<label> Chargable </label>";
      echo "&emsp;";
      echo CHtml::radioButton('status', $chk_box2_sts, array(
          'value'=>'1',
          'name'=>'btnname',
          'uncheckValue'=>null
      )); 
      ?>    
</div> </td>
 <td> <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Delivery Charges")?></label>
  <?php echo CHtml::textField('deal_title',
  isset($data['title'])?$data['title']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
  </div></td>
 </tr>

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