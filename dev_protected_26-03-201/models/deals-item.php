<?php
$row          = '';
$item_data    = '';
$price_select = '';
$size_select  = '';
if (array_key_exists("row",(array)$this->data))
{
	$row       = $this->data['row'];	
	$item_data = $_SESSION['kr_item'][$row];
	$price=Yii::app()->functions->explodeData($item_data['price']);
	if (is_array($price) && count($price)>=1){
		$price_select = isset($price[0])?$price[0]:'';
		$size_select  = isset($price[1])?$price[1]:'';
	}
	$row++;
}  
 

 $data=Yii::app()->functions->getItemById($this->data['item_id']); // Navaneeth 16-06-2017 
// $data=Yii::app()->functions->getCustomizedItemById($this->data['item_id']);
//dump($data);
$disabled_website_ordering = Yii::app()->functions->getOptionAdmin('disabled_website_ordering');
$hide_foodprice            = Yii::app()->functions->getOptionAdmin('website_hide_foodprice');
echo CHtml::hiddenField('hide_foodprice',$hide_foodprice);
?> 
<?php if (is_array($data) && count($data)>=1):?>
<?php 
$data=$data[0]; 
//dump($data);
?> 
<form class="frm-fooditem" id="frm-fooditem" method="POST" onsubmit="return false;">
<?php echo CHtml::hiddenField('action','addToCart')?>
<?php echo CHtml::hiddenField('item_id',$this->data['item_id'])?>
<?php echo CHtml::hiddenField('row',isset($row)?$row:"")?>
<?php echo CHtml::hiddenField('merchant_id',isset($data['merchant_id'])?$data['merchant_id']:'')?>  
<?php echo CHtml::hiddenField('discount',isset($data['discount'])?$data['discount']:"" )?>
<?php echo CHtml::hiddenField('currentController','store')?> 
<?php echo CHtml::hiddenField('base_url',Yii::app()->getBaseUrl(true))?> 
<?php 
//dump($data);
/** two flavores */
if ($data['two_flavors']==2){
	$data['prices'][0]=array(
	  'price'=>0,
	  'size'=>''
	);	
	echo CHtml::hiddenField('two_flavors',$data['two_flavors']);
}
//dump($data);
?>  
<div class="add-order-wrap">
  <div class="row food-details">
    <div class="col-md-3 ">              
       <img src="<?php echo FunctionsV3::getFoodDefaultImage($data['photo']);?>" alt="<?php echo $data['item_name']?>" title="<?php echo $data['item_name']?>" class="img-responsive">
    </div>
    <div class="col-md-9 ">
       <h3 class="food-name"><?php echo qTranslate($data['item_name'],'item_name',$data)?></h3>
       <p><?php echo qTranslate($data['item_description'],'item_description',$data)?></p>
       <div class="food-dish"><?php echo Widgets::displaySpicyIconNew($data['dish']);?> </div>
    </div>
  </div>
  <?php if (getOption($data['merchant_id'],'disabled_food_gallery')!=2):?>  
  <?php $gallery_photo=!empty($data['gallery_photo'])?json_decode($data['gallery_photo']):false; ?>
     <?php if (is_array($gallery_photo) && count($gallery_photo)>=1):?>
      <div class="food-gallery-wrap"> 
		<h6 class="add-order-title"><?php echo t("Gallery")?></h6>
        <div class="food-gallery clearfix">
          <?php foreach ($gallery_photo as $gal_val):?>
            <a href="<?php echo websiteUrl()."/upload/$gal_val"?>" class="gallery-link">
              <div class="food-pic" style="background:url('<?php echo websiteUrl()."/upload/$gal_val"?>')"></div>
              <img style="display:none;" src="<?php echo websiteUrl()."/upload/$gal_val"?>" alt="" title="">
            </a>    
          <?php endforeach;?>
        </div> 
      </div>
     <?php endif;?>
  <?php endif;?>
  <div class="food-prize">
	<h6 class="add-order-title"><?php echo t("Price")?></h6>	
    <div class="row">
    <?php     
    if (is_array($data['prices']) && count($data['prices'])>=1):?>  
      <?php foreach ($data['prices'] as $price):?>
          <?php $price['price']=Yii::app()->functions->unPrettyPrice($price['price'])?>
          <div class="col-md-4">
             <?php if ( !empty($price['size'])):?>
                 <?php echo CHtml::checkBox('price',
		          $size_select==$price['size']?true:false
		          ,array(
		            'value'=>$price['price']."|".$price['size'],
		            'class'=>"price_cls item_price"
		          ))?>
		          <?php echo qTranslate($price['size'],'size',$price)?>
              <?php else :?>
                  <?php echo CHtml::checkBox('price',
		            count($price['price'])==1?true:false
		            ,array(
		            'value'=>$price['price'],
		            'class'=>"item_price"
		          ))?>
             <?php endif;?>
             
             <?php if (isset($price['price'])):?>  
                <?php if (is_numeric($data['discount'])):?>
                    <span class="line-tru"><?php echo FunctionsV3::prettyPrice($price['price'])?></span>
                    <span class="text-danger"><?php echo FunctionsV3::prettyPrice($price['price']-$data['discount'])?></span>
                <?php else :?>
                    <?php echo FunctionsV3::prettyPrice($price['price'])?>
                 <?php endif;?>
             <?php endif;?>
          </div>
      <?php endforeach;?>
    <?php endif;?>
    </div>
  </div>
  <?php if (is_array($data['prices']) && count($data['prices'])>=1):?>
  <!--   <div class="food-quantity">
	<h6 class="add-order-title"><?php echo t("Quantity")?></h6>
    <div class="row">
       <div class="col-md-1 col-xs-1">
          <a href="javascript:;" class="btn btn-primary qty-minus"><i class="ion-minus"></i></a>
       </div>
       <div class="col-md-2 col-xs-2">
          <?php echo CHtml::textField('qty',
	      isset($item_data['qty'])?$item_data['qty']:1
	      ,array(
	      'class'=>"form-control numeric_only qty", 
	      'maxlength'=>5     
	      ))?>
       </div>
       <div class="col-md-1 col-xs-1">
         <a href="javascript:;" class="btn btn-primary qty-plus"><i class="ion-plus"></i></a>
       </div>
       <div class="col-md-6 col-xs-6">
         <a href="javascript:;" class="btn special-instruction btn-info"><?php echo t("Special Instructions")?></a>
       </div>
    </div>
  </div> 
  <div class="notes-wrap">
  <?php echo CHtml::textArea('notes',
  isset($item_data['notes'])?$item_data['notes']:""
  ,array(
   'class'=>'form-control',
   'placeholder'=>Yii::t("default","Special Instructions")
  ))?>
  </div>    -->
  
  <?php else :?>
  <?php endif;?>
  <?php if (isset($data['cooking_ref'])):?>
  <?php if (is_array($data['cooking_ref']) && count($data['cooking_ref'])>=1):?>
  <!-- <div class="cooking-pref">
	<h6 class="add-order-title"><?php echo t("Cooking Preference")?></h6>
    <div class="row">    
      <?php foreach ($data['cooking_ref'] as $cooking_ref_id=>$val):?>
      <div class="col-md-4">
         <?php $item_data['cooking_ref']=isset($item_data['cooking_ref'])?$item_data['cooking_ref']:''; ?>
         <?php echo CHtml::radioButton('cooking_ref',
	       $item_data['cooking_ref']==$val?true:false
	       ,array(
	         'value'=>$val
	       ))?>&nbsp;             
	       <?php 
	       $cooking_ref_trans=Yii::app()->functions->getCookingTranslation($val,$data['merchant_id']);
	       echo qTranslate($val,'cooking_name',$cooking_ref_trans);
	       ?>
      </div>
      <?php endforeach;?>
    </div>
  </div> -->
  <?php endif;?>
  <?php endif;?>
  <?php 
  if (!isset($item_data['ingredients'])){
  	  $item_data['ingredients']='';
  }  
  ?>
  <?php if (isset($data['ingredients'])):?>  
  <?php if (is_array($data['ingredients']) && count($data['ingredients'])>=1):?>
  <!-- <div class="food-ingredients">
	<h6 class="add-order-title"><?php echo t("Ingredients")?></h6>
     <div class="row">     
         <?php foreach ($data['ingredients'] as $ingredients_id =>  $val):
         $ingredients_name_trans='';
         $_ingredienst=Yii::app()->functions->getIngredients($ingredients_id);
         if ($_ingredienst){
         	$ingredients_name_trans['ingredients_name_trans']=!empty($_ingredienst['ingredients_name_trans'])?json_decode($_ingredienst['ingredients_name_trans'],true):'';
         }         
         ?>
         <?php $item_data['ingredients_id']=isset($item_data['ingredients_id'])?$item_data['ingredients_id']:''; ?>
         <div class="col-md-4">
           <?php echo CHtml::checkbox('ingredients[]',
	       in_array($val,(array)$item_data['ingredients'])?true:false
	       ,array(
	         'value'=>$val
	       ))?>&nbsp;             
	       <?php echo qTranslate($val,'ingredients_name',$ingredients_name_trans);?>
         </div>         
         <?php endforeach;?>
     </div>     
  </div>  -->
  <?php endif;?>
  <?php endif;?>
  <br />
  <!-- <div id="flip">
    <h4>
    <a href = "javascript:;"> Show Add-Ons <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> </a> 
    </h4>
  </div> -->
  <div class="food-addons" style="display: none">
  <?php if (isset($data['addon_item'])):?>
  <?php if (is_array($data['addon_item']) && count($data['addon_item'])>=1):?>
    <?php foreach ($data['addon_item'] as $val): //dump($val);?>
      <?php    ?>
     <?php echo CHtml::hiddenField('require_addon_'.$val['subcat_id'],$val['require_addons'],array(
     'class'=>"require_addon require_addon_".$val['subcat_id'],
     'data-id'=>$val['subcat_id'],
     'data-name'=>strtoupper($val['subcat_name'])
    ))?>
    <div class="addon-block">
		<div class="section-label">
			<h6 class="add-order-title"><?php echo qTranslate($val['subcat_name'],'subcat_name',$val)?></h6>		
		</div>  
	  <?php if (is_array($val['sub_item']) && count($val['sub_item'])>=1):?>
	  <?php $x=0;?>
	  <?php 
    $all_item_name = array();    
    foreach ($val['sub_item'] as $val_addon):?>    
	  <?php 
	    $subcat_id    =   $val['subcat_id'];
      $sub_item_id  =   $val_addon['sub_item_id'];
      $multi_option_val   =   $val['multi_option']; 
       /** fixed select only one addon*/
        if ( $val['multi_option']=="custom" || $val['multi_option']=="multiple")
        {
        	$sub_item_name="sub_item[$subcat_id][$x]";
        } else $sub_item_name="sub_item[$subcat_id][]"; 
        
        $sub_addon_selected='';
        $sub_addon_selected_id='';
        $item_data['sub_item']=isset($item_data['sub_item'])?$item_data['sub_item']:'';
        if (array_key_exists($subcat_id,(array)$item_data['sub_item'])){
        	$sub_addon_selected=$item_data['sub_item'][$subcat_id];
        	if (is_array($sub_addon_selected) && count($sub_addon_selected)>=1){
            	foreach ($sub_addon_selected as $val_addon_selected) {
            		$val_addon_selected=Yii::app()->functions->explodeData($val_addon_selected);
            		if (is_array($val_addon_selected)){
            		    $sub_addon_selected_id[]=$val_addon_selected[0];
            		}
            	}
        	}
        }
	  ?>	    
	 <!--   <div class="row mt-5">         <!-- Navaneeth 16-06-2017 
	        <div class="col-md-5 col-xs-5">
	        <?php 
	         if ( $val['multi_option']=="custom" || $val['multi_option']=="multiple"): 
                            
	            echo CHtml::checkBox($sub_item_name,
	            in_array($sub_item_id,(array)$sub_addon_selected_id)?true:false
	            ,array(
	              'value'=>$val_addon['sub_item_id']."|".$val_addon['price']."|".$val_addon['sub_item_name']."|".$val['two_flavor_position'],
	              'data-id'=>$val['subcat_id'],
	              'data-option'=>$val['multi_option_val'],
	              'rel'=>$val['multi_option'],
	              'class'=>'sub_item_name sub_item_name_'.$val['subcat_id']
	            ));
            else :            	                            
	            echo CHtml::radioButton($sub_item_name,
	            in_array($sub_item_id,(array)$sub_addon_selected_id)?true:false
	            ,array(
	              'value'=>$val_addon['sub_item_id']."|".$val_addon['price']."|".$val_addon['sub_item_name']."|".$val['two_flavor_position'],	             
	              'class'=>'sub_item sub_item_name_'.$val['subcat_id']	             
	            ));
            endif;
            
            echo "&nbsp;".qTranslate($val_addon['sub_item_name'],'sub_item_name',$val_addon);
	        ?>
	        </div>
	        <div class="col-md-4 col-xs-4">
	          <?php if ($val['multi_option']=="multiple"):?>
		      <?php             
	          $qty_selected=1;
	          if (!isset($item_data['addon_qty'])){
	           	 $item_data['addon_qty']='';
	          }
	          if (array_key_exists($subcat_id,(array)$item_data['addon_qty'])){            	            
	              $qty_selected=$item_data['addon_qty'][$subcat_id][$x];
	          }            
	          ?>
	          <div class="row quantity-wrap-small">
	            <div class="col-md-3 col-xs-3">
	            <!--   <a href="javascript:;" class="btn btn-primary qty-addon-minus"><i class="ion-minus"></i></a> -->
              <!--
	            </div>
	            <div class="col-md-5 col-xs-5">
	              <?php echo CHtml::textField("addon_qty[$subcat_id][$x]",$qty_selected,array(
		          'class'=>"numeric_only left addon_qty form-control",   
		          'maxlength'=>5 , "readonly"=>"readonly"
		          ))?>
	            </div>
	            <div class="col-md-3 col-xs-3">
	           <!--   <a href="javascript:;" class="btn btn-primary qty-addon-plus"><i class="ion-plus"></i></a> -->
	        <!--    </div>
	          </div>
	          <?php endif;?>
	        </div>
	        <div class="col-md-3 col-xs-3 text-right">
	        <span class="hide-food-price">
	        <?php echo !empty($val_addon['price'])? FunctionsV3::prettyPrice($val_addon['price']) :"-";?>
	        </span>
	        </div>
	    </div>      <!-- Navaneeth 16-06-2017 -->

        <?php if(!in_array(strtolower($val_addon['sub_item_name']),$all_item_name)) 
              {
               array_push($all_item_name,strtolower($val_addon['sub_item_name']));  ?>
        <div class="row mt-5">         <!-- Navaneeth 19-06-2017 -->
          <div class="col-md-5 col-xs-5">
          <?php                         
           if ( $val['multi_option']=="custom" || $val['multi_option']=="multiple"): 
              echo CHtml::checkBox($sub_item_name,
              in_array($sub_item_id,(array)$sub_addon_selected_id)?true:false
              ,array(
                'value'=>$val_addon['sub_item_id']."|".$val_addon['price']."|".$val_addon['sub_item_name']."|".$val['two_flavor_position'],
                'data-id'=>$val['subcat_id'],
                'data-option'=>$val['multi_option_val'],
                'rel'=>$val['multi_option'],
                'class'=>'sub_item_name sub_item_name_'.$val['subcat_id']
              ));
            else :                                          
              echo CHtml::radioButton($sub_item_name,
              in_array($sub_item_id,(array)$sub_addon_selected_id)?true:false
              ,array(
                'value'=>$val_addon['sub_item_id']."|".$val_addon['price']."|".$val_addon['sub_item_name']."|".$val['two_flavor_position'],              
                'class'=>'sub_item sub_item_name_'.$val['subcat_id']               
              ));
            endif;              
            echo "&nbsp;".qTranslate($val_addon['sub_item_name'],'sub_item_name',$val_addon);
          ?>
          </div>
          <div class="col-md-4 col-xs-4">
            <?php if ($val['multi_option']=="multiple"):?>
          <?php             
            $qty_selected=1;
            if (!isset($item_data['addon_qty'])){
               $item_data['addon_qty']='';
            }
            if (array_key_exists($subcat_id,(array)$item_data['addon_qty'])){                         
                $qty_selected=$item_data['addon_qty'][$subcat_id][$x];
            }            
            ?>
            <div class="row quantity-wrap-small">
              <div class="col-md-3 col-xs-3">
              <!--   <a href="javascript:;" class="btn btn-primary qty-addon-minus"><i class="ion-minus"></i></a> -->
              </div>
              <div class="col-md-5 col-xs-5">
                <?php echo CHtml::textField("addon_qty[$subcat_id][$x]",$qty_selected,array(
              'class'=>"numeric_only left addon_qty form-control",   
              'maxlength'=>5 , "readonly"=>"readonly"
              ))?>
              </div>
              <div class="col-md-3 col-xs-3">
             <!--   <a href="javascript:;" class="btn btn-primary qty-addon-plus"><i class="ion-plus"></i></a> -->
              </div>
            </div>
            <?php endif;?>
          </div>
          <div class="col-md-3 col-xs-3 text-right">
          <span class="hide-food-price">
          <?php echo !empty($val_addon['price'])? FunctionsV3::prettyPrice($val_addon['price']) :"-";?>
          </span>
          
          </div>
      </div> 
      <?php } ?>




	    <?php $x++;?>
	  <?php endforeach;?>	  
	  <?php endif;?>
	  </div> 
     <?php endforeach;?>
  <?php endif;?>
  <?php endif;?>
  </div>     <!-- Navaneeth commented 19-06-2017 -->

<?php if ($disabled_website_ordering==""):?>
            <div class="row food-item-actions">
              <div class="col-md-4 col-xs-4">
                 <input type="button" value="Add Item" 
                 class="btn add_bogo_multi_size btn-primary btn-block">
              </div>
              <!-- <div class="col-md-4 col-xs-4">
               <a href="javascript:close_fb();" data-dismiss="modal" class="btn btn-danger btn-block"><?php echo t("Close")?></a>
              </div> -->
            </div>
<?php endif;?>
</div>
</form>
<?php else :?>
<p class="text-danger"><?php echo Yii::t("default","Sorry but we cannot find what you are looking for.")?></p>
<?php endif;?>
<script type="text/javascript">
jQuery(document).ready(function() {	
	var hide_foodprice=$("#hide_foodprice").val();	
	if ( hide_foodprice=="yes"){
		$(".hide-food-price").hide();
		$("span.price").hide();		
		$(".view-item-wrap").find(':input').each(function() {			
			$(this).hide();
		});
	}
	var price_cls=$(".price_cls:checked").length; 	
	if ( price_cls<=0){
		var x=0
		$( ".price_cls" ).each(function( index ) {
			if ( x==0){
				dump('set check');
				$(this).attr("checked",true);
			}
			x++;
		});
	}
if ( $(".food-gallery-wrap").exists()){
	  $('.food-gallery-wrap').magnificPopup({
      delegate: 'a',
      type: 'image',
      closeOnContentClick: false,
      closeBtnInside: false,
      mainClass: 'mfp-with-zoom mfp-img-mobile',
      image: {
        verticalFit: true,
        titleSrc: function(item) {
          return '';
        }
      },
      gallery: {
        enabled: true
      },
      zoom: {
        enabled: true,
        duration: 300, // don't foget to change the duration also in CSS
        opener: function(element) {
          return element.find('img');
        }
      }      
    });
}
});
</script>