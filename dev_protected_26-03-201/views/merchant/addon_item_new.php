<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/AddOnItem/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/AddOnItem" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/AddOnItem/Do/Sort" class="uk-button"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>
</div>

<div class="spacer"></div>

<div id="error-message-wrapper"></div>

<form class="uk-form uk-form-horizontal forms" id="forms">
<?php echo CHtml::hiddenField('action','addOnItemNew')?>
<?php echo CHtml::hiddenField('id',isset($_GET['id'])?$_GET['id']:"");?>
<?php if (!isset($_GET['id'])):?>
<?php echo CHtml::hiddenField("redirect",Yii::app()->request->baseUrl."/merchant/AddOnItem/Do/Add")?>
<?php endif;?>

<?php 
if (isset($_GET['id'])){
	if (!$data=Yii::app()->functions->getAddonItem2($_GET['id'])){		
		echo "<div class=\"uk-alert uk-alert-danger\">".
		Yii::t("default","Sorry but we cannot find what your are looking for.")."</div>";
		return ;
	}	
}


Yii::app()->functions->data='list';
$subcat=Yii::app()->functions->getSubcategory();
$selected_cat=isset($data['category'])?json_decode($data['category']):false;
?>                                 

<div class="uk-grid">

<div class="uk-width-1-2">
<?php ?>

<!-- <div class="uk-form-row">    Navaneeth 20-06-2017
  <label class="uk-form-label"><?php echo Yii::t("default","Item")?></label>
  <?php echo CHtml::dropDownList('item',
  isset($data['main_item'])?$data['main_item']:"",
  (array)Yii::app()->functions->getFoodItemList(Yii::app()->functions->getMerchantID()),          
  array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
</div> -->

<?php $size_list = (Yii::app()->functions->getSizeList(Yii::app()->functions->getMerchantID())); 
  //echo sizeof($size_list);
  // print_r($size_list);
      
  if(is_array($size_list)&&sizeof($size_list)>0)
  {
    $iteration_value = 0 ;
    
    foreach ($size_list as  $value) {    
    
    if(!empty($value))  { 
    $add_on_array = json_decode(json_encode(json_decode($data['cat_size_item_price'])), True); 
     $add_on_size =  '';
     if(isset($add_on_array['size'][$iteration_value]) && !empty($add_on_array['size'][$iteration_value]))
     {
        $add_on_size = $add_on_array['size'][$iteration_value];
     }
     $add_on_item_number =  '';
     if(isset($add_on_array['add_on_item_number'][$iteration_value]) && !empty($add_on_array['add_on_item_number'][$iteration_value]))
     {
        $add_on_item_number = $add_on_array['add_on_item_number'][$iteration_value] ;
     }
     $add_on_price =  '';
     if(isset($add_on_array['add_on_item_price'][$iteration_value]) && !empty($add_on_array['add_on_item_price'][$iteration_value]))
     {
        $add_on_price =  $add_on_array['add_on_item_price'][$iteration_value];
     }
?>

<div class="uk-grid uk-grid-collapse">
  <label class="uk-form-label-width-small"><?php echo Yii::t("default","Size")?></label>
  <?php echo CHtml::dropDownList('size[]',$add_on_size,
  (array)Yii::app()->functions->getSizeList(Yii::app()->functions->getMerchantID()),          
  array(
  'class'=>'uk-width-1-6'
  ))?>
  <label class="uk-form-label-width-small"><?php echo Yii::t("default","Item Number")?></label>
  <?php echo CHtml::textField('add_on_item_number[]',$add_on_item_number
  ,array(
  'class'=>'uk-width-1-6'
  ))?>
  <label class="uk-form-label-width-small"><?php echo Yii::t("default","Price")?></label>
  <?php echo CHtml::textField('add_on_item_price[]',$add_on_price
  ,array(
  'class'=>'uk-width-1-6'
  ))?>
</div>

<?php 
$iteration_value = $iteration_value+1;
        }  
      } 
    }
?>

<?php if ( Yii::app()->functions->multipleField()==2):?>
<?php 
Widgets::multipleFields(array(
  'AddOn Item','Description'
),array(
  'sub_item_name','item_description'
),$data,array(true,false));
?>
<div class="spacer"></div>

<?php else :?>
<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","AddOn Item")?></label>
  <?php echo CHtml::textField('sub_item_name',
  isset($data['sub_item_name'])?$data['sub_item_name']:""
  ,array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Description")?></label>
  <?php echo CHtml::textField('item_description',
  isset($data['item_description'])?$data['item_description']:""
  ,array(
  'class'=>'uk-form-width-large'  
  ))?>
</div>
<?php endif;?>

  <div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Item Number")?></label>
  <?php echo CHtml::textField('item_number',
  isset($data['item_number'])?$data['item_number']:"" ,array(
  'class'=>'uk-form-width-large'  
  ))?>
  </div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Status")?></label>
  <?php echo CHtml::dropDownList('status',
  isset($data['status'])?$data['status']:"",
  (array)statusList(),          
  array(
  'class'=>'uk-form-width-large',
  'data-validation'=>"required"
  ))?>
</div>

</div>

<div class="uk-width-1-2">

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","AddOn Category")?></label>  
  <div class="clear"></div>
  <?php if (is_array($subcat) && count($subcat)>=1):?>
  <ul class="uk-list uk-list-striped">
  <?php foreach ($subcat as $key=>$val):?>
    <li>
    <?php echo CHtml::checkBox('category[]',
    in_array($key,(array)$selected_cat)?true:false,array(
      'value'=>$key,     
       'data-validation'=>"checkbox_group",
	   'data-validation-qty'=>'min1'
    ))?>
    <?php echo $val;?>
    </li>
  <?php endforeach;?>
  </ul>
  <?php endif;?>
</div>

<div class="uk-form-row">
  <label class="uk-form-label"><?php echo Yii::t("default","Price")?></label>
  <?php
  echo CHtml::textField('price',isset($data['price'])?$data['price']:"",array(
   'class'=>"numeric_only"
  ))
  ?>
</div>



<div class="uk-form-row"> 
 <label class="uk-form-label"><?php echo Yii::t('default',"Featured Image")?></label>
  <div style="display:inline-table;margin-left:1px;" class="button uk-button" id="photo"><?php echo Yii::t('default',"Browse")?></div>	  
  <DIV  style="display:none;" class="photo_chart_status" >
	<div id="percent_bar" class="photo_percent_bar"></div>
	<div id="progress_bar" class="photo_progress_bar">
	  <div id="status_bar" class="photo_status_bar"></div>
	</div>
  </DIV>		  
</div>

<?php if (!empty($data['photo'])):?>
<div class="uk-form-row"> 
<?php else :?>
<div class="input_block preview">
<?php endif;?>
<label><?php echo Yii::t('default',"Preview")?></label>
<div class="image_preview">
 <?php if (!empty($data['photo'])):?>
 <input type="hidden" name="photo" value="<?php echo $data['photo'];?>">
 <img class="uk-thumbnail uk-thumbnail-small" src="<?php echo Yii::app()->request->baseUrl."/upload/".$data['photo'];?>?>" alt="" title="">
 <?php endif;?>
</div>
</div>

</div> <!--END uk-width-1-2-->

</div> <!--END UK-GRID-->

<div class="spacer"></div>

<div class="uk-form-row">
<label class="uk-form-label"></label>
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-form-width-medium uk-button-success">
</div>

</form>