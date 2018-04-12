<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deals/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deals" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
</div>


<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','merchant_add_deals')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php echo CHtml::hiddenField('bogo_multi_size',"");?>
<?php if (!isset($_GET['id'])):?>
<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/merchant/deals/Do/Add")?>
<?php endif;?>

<?php 
 


 		$chk_box1_sts = true;
		$chk_box2_sts = false;
		$chk_box3_sts = false;
		$buy_one_get_one_style  = "display:block";
		$spend_amount_style 	= "display:none";
		$discount_deals_style 	= "display:none";



if (isset($_GET['id']))
{
	if (!$data=Yii::app()->functions->getmerchant_deal($_GET['id']))
	{
		echo "<div class=\"uk-alert uk-alert-danger\">".
		Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
		return ;
	}	 	
		/* print_r($data);
		exit; */
		$chk_box1_sts = false;
		$chk_box2_sts = false;
		$chk_box3_sts = false;
		$buy_one_get_one_style  = "display:none";
		$spend_amount_style 	= "display:none";
		$discount_deals_style 	= "display:none";
		if(($data['deal_type'])!=""&&($data['deal_type'])==0)
		{
			$chk_box1_sts = true;				
			$buy_one_get_one_style  = "display:block";
		}
		else if (($data['deal_type'])!=""&&($data['deal_type'])==1)
		{				
			$chk_box2_sts = true;			
			$spend_amount_style 	= "display:block";
			$buy_one_get_one_style  = "display:block";
		}
		else if (($data['deal_type'])!=""&&($data['deal_type'])==2)
		{				
			$chk_box3_sts = true;
			$spend_amount_style 	= "display:block";
			$discount_deals_style 	= "display:block";
		}


}
?>                                 


<div class="uk-grid">
    <div class="uk-width-1-1">
    <div class="uk-form-row">	
		<div class="col-lg-12">
			<label class="uk-form-label"><?php echo Yii::t("default","Deal Type")?></label>
			<?php  		
			echo "<label> Buy One Get One </label>";
			echo "&emsp;";
			echo CHtml::radioButton('deals_type', $chk_box1_sts , array(
			'value'=>'0',
			'name'=>'btnname',
			'class'=>'select_deal',
			'uncheckValue'=>null
			));
			echo "&emsp;";
			echo "<label> Spend Over and Get Products </label>";
			echo "&emsp;";
			echo CHtml::radioButton('deals_type', $chk_box2_sts, array(
		    'value'=>'1',
		    'name'=>'btnname',
		    'class'=>'select_deal',
		    'uncheckValue'=>null
			)); 
			echo "&emsp;";
			echo "<label> Spend Over and Get Discounts </label>";
			echo "&emsp;";
			echo CHtml::radioButton('deals_type', $chk_box3_sts, array(
		    'value'=>'2',
		    'name'=>'btnname',
		    'class'=>'select_deal',
		    'uncheckValue'=>null
			));
			?>							 
		</div>
</div>	




 
	<div class="uk-form-row">
	<label class="uk-form-label"><?php echo Yii::t("default","Deal Title")?></label>
	<?php echo CHtml::textField('deal_title',
	isset($data['title'])?$data['title']:""
	,array(
	'class'=>'uk-form-width-large',
	'data-validation'=>"required"
	))?>
	</div>

	<div class="uk-form-row">
	<label class="uk-form-label"><?php echo Yii::t("default","Deal Description")?></label>
	<?php echo CHtml::textArea('deal_description',
	isset($data['description'])?$data['description']:""
	,array(
	'class'=>'uk-form-width-large big-textarea'	,
	'data-validation'=>"required"
	))?>
	</div>	 
	<?php 

	//	print_r(Yii::app()->functions->getFoodItemdropdownDeals(Yii::app()->functions->getMerchantID()));

	
	$option_id_value   = '';
	$option_attr_value = '';
	if($food_items = Yii::app()->functions->getFoodItemdropdownDeals(Yii::app()->functions->getMerchantID()))
	{
		foreach ($food_items as $food_item) 
		{ 
			$option_id_value[$food_item['item_id']]=$food_item['item_name'];
			$option_attr_value[$food_item['item_id']]['single_item']=$food_item['single_item'];
			$option_attr_value[$food_item['item_id']]['id']=$food_item['item_id'];
		}
	} 
	//print_r($option_id_value);
	// print_r($option_attr_value);
	//print_r(Yii::app()->functions->getFoodItemdropdown(Yii::app()->functions->getMerchantID()));
	 ?>
	<div class="uk-form-row" id="buy_one_get_one" style="<?php echo $buy_one_get_one_style; ?>">     
	  <label class="uk-form-label"><?php echo Yii::t("default","Item")?></label>
	  <?php echo CHtml::dropDownList('item[]',isset($data['item_list'])?json_decode($data['item_list']):"",
	   //(array)Yii::app()->functions->getFoodItemdropdown(Yii::app()->functions->getMerchantID()),   
	  (array)$option_id_value,array(
	  'class'=>'uk-form-width-large chosen',
	  'multiple'=>true,
	  'options'=>(array)$option_attr_value)) ?>
	</div>		

	<div class="uk-form-row" id="spend_amount" style="<?php echo $spend_amount_style; ?>">     
	  <label class="uk-form-label"><?php echo Yii::t("default","Spend for ")?>£</label>
	  <?php echo CHtml::textField('spend_amount',
	  isset($data['spend_for'])?$data['spend_for']:""
	  ,array(
	  'class'=>'uk-form-width-large numeric_only'
	  ))?>
	</div>

	<div class="uk-form-row" id="discount_deals" style="<?php echo $discount_deals_style; ?>">     
	  <label class="uk-form-label"><?php echo Yii::t("default","Discount % ")?></label>
	  <?php echo CHtml::textField('discount_percent',
	  isset($data['discount'])?$data['discount']:""
	  ,array(
	  'class'=>'uk-form-width-large numeric_only'
	  ))?>
	</div>		


	 <div class="uk-form-row">
		  <label class="uk-form-label"><?php echo Yii::t("default","From Date")?></label>
		  <?php //  echo CHtml::hiddenField('date_booking',isset($data['from_date'])?$data['from_date']:'')?>
		  <?php echo CHtml::textField('from_date',
		  isset($data['from_date'])?$data['from_date']:''			 
		  ,array(
		  'class'=>'j_date',
		  'data-id'=>'date_booking',
		  'data-validation'=>"required"
		  ))?>
	 </div>
	
     <div class="uk-form-row">
		  <label class="uk-form-label"><?php echo Yii::t("default","To Date")?></label>
		  <?php // echo CHtml::hiddenField('date_booking',isset($data['to_date'])?$data['to_date']:'')?>
		  <?php echo CHtml::textField('to_date',
		  isset($data['to_date'])?$data['to_date']:''			 
		  ,array(
		  'class'=>'j_date',
		  'data-id'=>'date_booking',
		  'data-validation'=>"required"
		  ))?>
	 </div>


<div class="uk-form-row">
	<label class="uk-form-label"><?php echo Yii::t("default","Status")?></label>
		<div class="col-lg-6">
			<?php  
			$chk_box1_sts = true;
			$chk_box2_sts = false;
			if(($data['status'])!=""&&($data['status'])==1):
			$chk_box1_sts = false;
			$chk_box2_sts = true;
			endif;
			echo "<label> Active </label>";
			echo "&emsp;";
			echo CHtml::radioButton('status', $chk_box1_sts , array(
			'value'=>'0',
			'name'=>'btnname',
			'uncheckValue'=>null
			));
			echo "&emsp;";
			echo "<label> InActive </label>";
			echo "&emsp;";
			echo CHtml::radioButton('status', $chk_box2_sts, array(
			    'value'=>'1',
			    'name'=>'btnname',
			    'uncheckValue'=>null
			)); 
			?>							 
		</div>
</div>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>	 
	
    </div> <!--END uk-width-1-2-->
    

<div class="spacer"></div>



</form>

<div class="modal custom-modal fade" id="myModal_add_cart" data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <!--    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  -->
                <h4 class="modal-title"> Select Details </h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                	<div class="col-md-12" id="myModal_add_cart_content">
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>