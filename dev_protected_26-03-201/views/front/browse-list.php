
<div class="row"> 
	<div class="all-restaurant">
	<?php foreach ($list['list'] as $val):?>
	<?php
	$merchant_id=$val['merchant_id'];
	$ratings=Yii::app()->functions->getRatings($merchant_id);   
	$merchant_delivery_distance=getOption($merchant_id,'merchant_delivery_miles');
	$distance_type='';

	/*fallback*/
	if ( empty($val['latitude'])){
		if ($lat_res=Yii::app()->functions->geodecodeAddress($val['merchant_address'])){        
			$val['latitude']=$lat_res['lat'];
			$val['lontitude']=$lat_res['long'];
		} 
	}
	?>
		<div class="col-md-3 col-sm-3">
			<div class="product grid">
				<?php if ( $val['is_sponsored']==2):?>
				   <div class="ribbon"><span>Sponsored</span></div>
				<?php endif;?>
				<div class="product-img">
					<a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>">
						<img src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>" alt="" width="400" height="270">
					</a>
				</div>
				<?php if($val['service']!=3 && FunctionsV3::getDeliveryEstimation($merchant_id) != 'not available'):?> 
				<div class="time-tag">
					<?php $exp = explode(' ',FunctionsV3::getDeliveryEstimation($merchant_id));  ?> 
					<span class="time-count"> <?php echo $exp[0]; ?> </span> 
					<span class="min"><?php echo $exp[1]; ?></span>
				</div> 
				<?php endif;?>   
				<div class="product-desc">
					<h3>
					<a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>"> 
					<?php echo clearString($val['restaurant_name'])?> 
					</a>
					</h3>
					<div class="type">
						<?php echo FunctionsV3::displayCuisine($val['cuisine']);?>
					</div>
					<span class="opening"> <?php echo FunctionsV3::merchantOpenTag($merchant_id)?> </span> 
					<div class="location">
						<?php echo $val['merchant_address']?>.  
					</div>
					<?php if($val['minimum_order'] != ''){ ?>
					<div class="min-order">
					 Minimum order : <?php echo FunctionsV3::prettyPrice($val['minimum_order'])?>  
					</div>
					<?php } ?>
					<div class="special-offer">
					<?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
						<span><?php echo 'Special offer : '.$offer;?> </span>
					<?php endif;?> 
					</div>
					<div class="ratings">
						<div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div> 
					</div>  
					<ul> 
						<?php echo FunctionsV3::displayServicesList($val['service'])?>
					</ul> 
					<div class="delivery-fee">
					<?php  
						if ($delivery_fee){
							 echo t("Delivery Fee")." : ".FunctionsV3::prettyPrice($delivery_fee);
						} else echo  t("Delivery Fee")." : ".t("Free Delivery"); 
					?> 
					</div>
					 <div class="del-distance">
						<?php 
						if($val['service']!=3){
							if (!empty($merchant_delivery_distance)){
								echo t("Delivery Distance").": ".$merchant_delivery_distance." $distance_type";
							} else echo  t("Delivery Distance").": ".t("not available");
						}
						?>
					</div>
					<div class="cash-delivery">
						<?php FunctionsV3::displayCashAvailable($merchant_id)?>
					</div>
					<a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>" class="btn btn-primary"> Order Now </a>
				</div>
			</div>
		</div>
<?php endforeach;?>
	</div>
</div>
<div class="search-result-loader">
    <span></span>
    <p><?php echo t("Loading more restaurant...")?></p>
</div>
<?php             
if (isset($cuisine_page)){
	//$page_link=Yii::app()->createUrl('store/cuisine/'.$category.'/?');
	$page_link=Yii::app()->createUrl('store/cuisine/?category='.urlencode($_GET['category']));
} else $page_link=Yii::app()->createUrl('store/browse/?tab='.$tabs);

 echo CHtml::hiddenField('current_page_url',$page_link);
 require_once('pagination.class.php'); 
 $attributes                 =   array();
 $attributes['wrapper']      =   array('id'=>'pagination','class'=>'pagination');			 
 $options                    =   array();
 $options['attributes']      =   $attributes;
 $options['items_per_page']  =   FunctionsV3::getPerPage_table();
 $options['maxpages']        =   10;
 $options['jumpers']=false;
 $options['link_url']=$page_link.'&page=##ID##';			
 $pagination =   new pagination( $list['total'] ,((isset($_GET['page'])) ? $_GET['page']:1),$options);		
 $data   =   $pagination->render();
 ?>             