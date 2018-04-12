<?php
/*POINTS PROGRAM*/

if (FunctionsV3::hasModuleAddon("pointsprogram")){
	unset($_SESSION['pts_redeem_amt']);
	unset($_SESSION['pts_redeem_points']);
}

$merchant_photo_bg=getOption($merchant_id,'merchant_photo_bg');
if ( !file_exists(FunctionsV3::uploadPath()."/$merchant_photo_bg")){
	$merchant_photo_bg='';
} 

/*RENDER MENU HEADER FILE*/
$ratings=Yii::app()->functions->getRatings($merchant_id);   
$merchant_info=array(   
  'merchant_id'=>$merchant_id ,
  'minimum_order'=>$data['minimum_order'],
  'ratings'=>$ratings,
  'merchant_address'=>$data['merchant_address'],
  'cuisine'=>$data['cuisine'],
  'restaurant_name'=>$data['restaurant_name'],
  'background'=>$merchant_photo_bg,
  'merchant_website'=>$merchant_website,
  'merchant_logo'=>FunctionsV3::getMerchantLogo($merchant_id)
);
$this->renderPartial('/front/menu-header',$merchant_info);

/*ADD MERCHANT INFO AS JSON */
$cs = Yii::app()->getClientScript();
$cs->registerScript(
  'merchant_information',
  "var merchant_information =".json_encode($merchant_info)."",
  CClientScript::POS_HEAD
);		

/*PROGRESS ORDER BAR*/
/*$this->renderPartial('/front/order-progress-bar',array(
   'step'=>3,
   'show_bar'=>true
));*/

$now      = date('Y-m-d');
$now_time = '';
$checkout=FunctionsV3::isMerchantcanCheckout($merchant_id); 


 $menu=Yii::app()->functions->getMerchantMenu($merchant_id); 
//$menu=Yii::app()->functions->getMerchantNewMenu($merchant_id);


echo CHtml::hiddenField('is_merchant_open',isset($checkout['code'])?$checkout['code']:'' );
/*hidden TEXT*/
echo CHtml::hiddenField('base_url',Yii::app()->baseUrl); 
echo CHtml::hiddenField('refresh_page','no');
echo CHtml::hiddenField('restaurant_slug',$data['restaurant_slug']);
echo CHtml::hiddenField('merchant_id',$merchant_id);
echo CHtml::hiddenField('is_client_login',Yii::app()->functions->isClientLogin());
echo CHtml::hiddenField('website_disbaled_auto_cart',
Yii::app()->functions->getOptionAdmin('website_disbaled_auto_cart'));
$hide_foodprice=Yii::app()->functions->getOptionAdmin('website_hide_foodprice');
echo CHtml::hiddenField('hide_foodprice',$hide_foodprice);
echo CHtml::hiddenField('accept_booking_sameday',getOption($merchant_id
,'accept_booking_sameday'));
echo CHtml::hiddenField('customer_ask_address',getOptionA('customer_ask_address'));
echo CHtml::hiddenField('merchant_required_delivery_time',
  Yii::app()->functions->getOption("merchant_required_delivery_time",$merchant_id));   
/** add minimum order for pickup status*/
$merchant_minimum_order_pickup=Yii::app()->functions->getOption('merchant_minimum_order_pickup',$merchant_id);
if (!empty($merchant_minimum_order_pickup)){
	  echo CHtml::hiddenField('merchant_minimum_order_pickup',$merchant_minimum_order_pickup);
	  echo CHtml::hiddenField('merchant_minimum_order_pickup_pretty',
         displayPrice(baseCurrency(),prettyFormat($merchant_minimum_order_pickup)));
}
$merchant_maximum_order_pickup=Yii::app()->functions->getOption('merchant_maximum_order_pickup',$merchant_id);
if (!empty($merchant_maximum_order_pickup)){
	  echo CHtml::hiddenField('merchant_maximum_order_pickup',$merchant_maximum_order_pickup);	  
	  echo CHtml::hiddenField('merchant_maximum_order_pickup_pretty',
         displayPrice(baseCurrency(),prettyFormat($merchant_maximum_order_pickup)));
}  
/*add minimum and max for delivery*/
$minimum_order=Yii::app()->functions->getOption('merchant_minimum_order',$merchant_id);
if (!empty($minimum_order)){
	echo CHtml::hiddenField('minimum_order',unPrettyPrice($minimum_order));
	echo CHtml::hiddenField('minimum_order_pretty',
	 displayPrice(baseCurrency(),prettyFormat($minimum_order))
	);
}
$merchant_maximum_order=Yii::app()->functions->getOption("merchant_maximum_order",$merchant_id);
if (is_numeric($merchant_maximum_order)){
 	echo CHtml::hiddenField('merchant_maximum_order',unPrettyPrice($merchant_maximum_order));
    echo CHtml::hiddenField('merchant_maximum_order_pretty',baseCurrency().prettyFormat($merchant_maximum_order));
}
$is_ok_delivered=1;
if (is_numeric($merchant_delivery_distance)){
	if ( $distance>$merchant_delivery_distance){
		$is_ok_delivered=2;
		/*check if distance type is feet and meters*/
		if($distance_type=="ft" || $distance_type=="mm" || $distance_type=="mt"){
			$is_ok_delivered=1;
		}
	}
} 
echo CHtml::hiddenField('is_ok_delivered',$is_ok_delivered);
echo CHtml::hiddenField('merchant_delivery_miles',$merchant_delivery_distance);
echo CHtml::hiddenField('unit_distance',$distance_type);
echo CHtml::hiddenField('from_address', FunctionsV3::getSessionAddress() );
echo CHtml::hiddenField('merchant_close_store',getOption($merchant_id,'merchant_close_store'));
/*$close_msg=getOption($merchant_id,'merchant_close_msg');
if(empty($close_msg)){
	$close_msg=t("This restaurant is closed now. Please check the opening times.");
}*/
echo CHtml::hiddenField('merchant_close_msg',
isset($checkout['msg'])?$checkout['msg']:t("Sorry merchant is closed."));
echo CHtml::hiddenField('disabled_website_ordering',getOptionA('disabled_website_ordering'));
echo CHtml::hiddenField('web_session_id',session_id());
echo CHtml::hiddenField('merchant_map_latitude',$data['latitude']);
echo CHtml::hiddenField('merchant_map_longtitude',$data['lontitude']);
echo CHtml::hiddenField('restaurant_name',$data['restaurant_name']); 
echo CHtml::hiddenField('checkout_redirect',"123"); 

/*add meta tag for image*/
Yii::app()->clientScript->registerMetaTag(
Yii::app()->getBaseUrl(true).FunctionsV3::getMerchantLogo($merchant_id),'og:image');
/* Deals scrolling part start  */
$deals_list = Yii::app()->functions->get_deals_list_merchant($merchant_id);

if(!empty($deals_list))
{
?>  
 
	<div class="container">
		<div class="row deals-row">
			<div class="col-sm-3">
				<div class="deals-img">
					<img src="<?php echo Yii::app()->createUrl();?>/assets/images/deals.gif" alt="" width="100" height="100"> <!--<span class="deals-title">Deals</span>-->
				</div>
			</div>
			<div class="col-sm-9">
				<ul id="deals-list" class="deals-list">
					<?php foreach($deals_list as $deals) { ?> 
					<li><a href="#" data-toggle="modal" data-target="#myModal"><?php echo $deals['title']; ?></a></li>
					<?php } ?> 
				</ul>
			</div>
		</div>
	</div>    

<?php } 
/* Deals scrolling part End */
?>


<div class="page-content menu-page">
	<div class="container">
		<div class="row row-sm">
			<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
				<div class="custom-tab">
					<ul class="nav nav-tabs menu-tabs">
                    <?php 
                      	$default_active = 'active';
                      	$menu_div_display = ' style="display:block;" ';
                        if(isset($_GET['book-a-table'])) {  $default_active = '';  $menu_div_display = ' style="display:none;" ';  } ?>
						<li class="<?php echo $default_active; ?>"><a href="#food_menu" onclick="show_menu_div('block')" data-toggle="tab"><span>Menu</span> <i class="ion-fork"></i></a></li>	
						<li><a href="#food_splmenu" onclick="show_menu_div('block')" data-toggle="tab"><span>Special Menu</span> <i class="ion-fork"></i></a></li>						
                         <?php if ($theme_hours_tab==""):?>
						<li><a href="#opening_hours" onclick="show_menu_div('block')" data-toggle="tab"><span>Opening Hours</span> <i class="ion-clock"></i></a></li>
                        <?php endif;?>
                        <?php if ($theme_reviews_tab==""):?>
						<li><a href="#merchant_reviews" onclick="show_menu_div('block')" class="view-reviews" data-toggle="tab"><span>Reviews</span> <i class="ion-ios-star-half"></i></a></li>
                        <?php endif;?>
                        <?php if ($theme_map_tab==""):?>
						<li class="view-merchant-map"><a href="#merchant_map" onclick="show_menu_div('block')" data-toggle="tab"><span>Map</span> <i class="ion-ios-navigate-outline"></i></a></li>
                        <?php endif;?>
						<?php if ($booking_enabled): 
						$active_class = '';
                        if(isset($_GET['book-a-table'])) { $active_class = 'active';}
						?>
						<li class="<?php echo $active_class ; ?>" ><a href="#booking_table" onclick="show_menu_div('none')" data-toggle="tab"><span>Book a Table</span> <i class="ion-coffee"></i></a></li>
						<?php endif;?>
                        <?php if ($photo_enabled):?>
						<li><a href="#merchant_photos" class="view-merchant-photos" onclick="show_menu_div('block')" data-toggle="tab"><span>Gallery</span> <i class="ion-images"></i></a></li>
                        <?php endif;?>
                        <?php if ($theme_info_tab==""):?>
						<li><a href="#merchant_info" data-toggle="tab" onclick="show_menu_div('block')" ><span>Information</span> <i class="ion-ios-information-outline"></i></a></li>
                        <?php endif;?>
                        <?php if ( $promo['enabled']==2 && $theme_promo_tab==""):?>
						<li><a href="#promos" data-toggle="tab" onclick="show_menu_div('block')" ><span>Promos</span> <i class="ion-pizza"></i></a></li>
                        <?php endif;?>
                        <?php // if ( $promo['enabled']==2 && $theme_promo_tab==""):?>
						<!-- <li><a href="#promos" data-toggle="tab" onclick="show_menu_div('block')" ><span>Delivery Rates</span> <i class="ion-pizza"></i></a></li> -->
                        <?php // endif;?>
					</ul>
					<div class="tab-content">
						<div class="tab-pane <?php echo $default_active ; ?>" id="food_menu">
							 <?php  
                             $this->renderPartial('/front/menu-category',array(
                              'merchant_id'=>$merchant_id,
                              'menu'=>$menu,
                              'restaurant_name'=>$data['restaurant_name'],
                              'disabled_addcart'=>$disabled_addcart		  
                             ));
                                    
                             /*$this->renderPartial('/front/menu-merchant-1',array(
                                                  'merchant_id'=>$merchant_id,
                                                  'menu'=>$menu,
                                                  'disabled_addcart'=>$disabled_addcart,
                                                  'tc'=>$tc
                                                 ));*/	 
                              ?>   
						</div>

						<div class="tab-pane" id="food_splmenu">
							 <?php  
                             $this->renderPartial('/front/menu-category',array(
                              'merchant_id'=>$merchant_id,
                              'menu'=>$menu,
                              'restaurant_name'=>$data['restaurant_name'],
                              'disabled_addcart'=>$disabled_addcart,
                              'spl_menu'=>'true'		  
                             ));
                                    
                             /*$this->renderPartial('/front/menu-merchant-1',array(
                                                  'merchant_id'=>$merchant_id,
                                                  'menu'=>$menu,
                                                  'disabled_addcart'=>$disabled_addcart,
                                                  'tc'=>$tc
                                                 ));*/	 
                              ?>   
						</div>

                        <?php if ($theme_hours_tab==""):?>
						<div class="tab-pane" id="opening_hours">
							<?php
							$this->renderPartial('/front/merchant-hours',array(
							  'merchant_id'=>$merchant_id
							)); 
							?> 
						</div>
                        <?php endif;?>
						<div class="tab-pane" id="merchant_reviews"> 
                            <?php $this->renderPartial('/front/merchant-review',array(
							  'merchant_id'=>$merchant_id
							)); ?>   
						</div>
						<?php if ($theme_map_tab==""):?>
						<div class="tab-pane" id="merchant_map">
							<div class="panel">
								<div class="panel-body">
                                    <?php $this->renderPartial('/front/merchant-map'); ?>
								</div>
							</div>
						</div>
						<?php endif;?>
						<?php if ($booking_enabled):?>
						<div class="tab-pane <?php echo $active_class ; ?>" id="booking_table">
						<?php $this->renderPartial('/front/merchant-book-table',array(
						  'merchant_id'=>$merchant_id
						)); ?>        
						</div>
						<?php endif;?>
                        <?php if ($photo_enabled):?>
						<div class="tab-pane" id="merchant_photos">
							<?php 
							$gallery=Yii::app()->functions->getOption("merchant_gallery",$merchant_id);
							$gallery=!empty($gallery)?json_decode($gallery):false;
							$this->renderPartial('/front/merchant-photos',array(
							  'merchant_id'=>$merchant_id,
							  'gallery'=>$gallery
							)); ?> 
						</div>
                        <?php endif;?>
                        <?php if ($theme_info_tab==""):?>
						<div class="tab-pane" id="merchant_info">
                        <?php if (getOption($merchant_id,'merchant_information') != ''):?>
 							<div class="panel">
								<div class="panel-body">
									<p> <?php echo getOption($merchant_id,'merchant_information')?></p>
								</div>
							</div>
                        <?php else :?>
                         <div class="text-center alert alert-danger mb-0"><?php echo t("No information available.")?></div>
                        <?php endif;?>   
						</div>
                        <?php endif;?>
                        <?php if ( $promo['enabled']==2 && $theme_promo_tab==""):?>
						<div class="tab-pane" id="promos">
							<div class="panel">
								<div class="panel-body">
                                    <?php $this->renderPartial('/front/merchant-promo',array(
									  'merchant_id'=>$merchant_id,
									  'promo'=>$promo
									)); ?>  
								</div>
							</div>
						</div>
                        <?php endif;?>
					</div>
				</div>
			</div>
			<?php // if(!isset($_GET['book-a-table'])) {  ?>
			<div id="menu-right-content" class="col-md-3  col-sm-3 col-lg-3 col-xs-12 rightsidebar menu-right-content <?php echo $disabled_addcart=="yes"?"hide":''?>" <?php echo $menu_div_display; ?> >
            <?php if (getOptionA('disabled_website_ordering')!="yes"):?>
					<div class="sidebar">
						<h3 class="sidebar-title">My Order</h3>
						<h3 class="delivery-title"> <a href="" data-toggle="modal" data-target="#delivery_price" > Delivery Price </a> </h3>
						<a href="javascript:;" class="clear-cart btn btn-primary"><?php echo t("Clear Order")?></a>
						<!--<div class="est-delivery">
                            <div>Estimated Delivery:  <?php 
							$estimat_time = $estimate_str = '';
							if(FunctionsV3::getDeliveryEstimation($merchant_id) != 'not available'){ 
							$exp = explode(' ',FunctionsV3::getDeliveryEstimation($merchant_id)); ?>
								<span class="est-duration"><?php echo $exp[0]; ?></span><span> <?php echo $exp[1]; ?></span>
							<?php }else{ ?>
							<p><?php echo ucfirst(FunctionsV3::getDeliveryEstimation($merchant_id)); ?> </p>
							<?php } ?> </div> 
                           
							<div class="deli-info">
								<p>
								<?php 
								if ($distance){
									echo t("Distance").": ".number_format($distance,1)." $distance_type";
								} else echo  t("Distance").": ".t("not available");
								?>
								</p>
								<p class="delivery-fee-wrap">
								<?php 
								if (!empty($merchant_delivery_distance)){
									echo t("Delivery Distance Covered").": ".$merchant_delivery_distance." $distance_type_orig";
								} else echo  t("Delivery Distance Covered").": ".t("not available");
								?>
								</p>
								
								<p class="delivery-fee-wrap">
								<?php 
								if ($delivery_fee){
									 echo t("Delivery Fee").": ".FunctionsV3::prettyPrice($delivery_fee);
								} else echo  t("Delivery Fee").": ".t("Free Delivery");
								?>
								</p>
								
								<a href="javascript:;" class="btn btn-block btn-default btn-sm change-address">
									<?php echo t("Change Your Address here")?>
								</a>
							</div>
						</div>-->
						<div class="est-delivery">
                            <div>Estimated Delivery</div> 
                            <?php 
							$estimat_time = $estimate_str = '';
							if(FunctionsV3::getDeliveryEstimation($merchant_id) != 'not available'){ 
							$exp = explode(' ',FunctionsV3::getDeliveryEstimation($merchant_id)); 
							$deliver_time = $exp[0];
				            $deliver_time = $exp[0];
				            $hours =  floor($deliver_time/60);  
				            $mins =   $deliver_time % 60;  
				            $hrs  = "hr";
				            $minutes = "";
				            if($hours>0)
				            {
				                if($hours>1) { $hrs  = "hrs"; }
				                if($mins>0) { $minutes = "Mins"; $deliver_time = $hours . " ".$hrs." " . $mins . " ".$minutes." ";  }
				                else { $deliver_time = $hours . " ".$hrs;  }                
				            }
				            else
				            {   
				            		if($mins>0) { $minutes = "Mins"; }
				                    $deliver_time = $mins . " ".$minutes." "; 
				            }  ?> 

								<div class="est-duration"><?php echo $deliver_time ; ?></div><div> <?php echo $exp[1]; ?></div>
							<?php }else{ ?>
							<p><?php echo ucfirst(FunctionsV3::getDeliveryEstimation($merchant_id)); ?> <p>
							<?php } ?> 
						</div>

						<div class="cart-box">
							<div class="choose-parish2">
								  <?php echo CHtml::dropDownList('parish','',
								  (array)Yii::app()->functions->listOnlyDeliverableParish($merchant_id),          
								  array(
								  'class'=>'form-control check_out_parish_select' 
								  ))?>
							</div>						
                            <div class="item-order-wrap sidebar-cart table-responsive">
							 <?php  ?>
                            </div> 
                            <div class="relative delivery-option text-center">
                                   <p class="bold"><?php echo t("Delivery Options")?></p>
                                   <?php echo CHtml::dropDownList('delivery_type',$now,
                                   (array)Yii::app()->functions->DeliveryOptions($merchant_id),array(
                                     'class'=>'form-control'
                                   ))?> 
                                   <?php echo CHtml::hiddenField('delivery_date',$now) ;
                                   		 echo CHtml::hiddenField('allow_custom_date','ok')	;
                                   ?>
                                   <div class="cal-icon">
									<i class="fa fa-calendar"></i><?php echo CHtml::textField('delivery_date1',
                                   FormatDateTime($now,false),array('class'=>"j_date form-control",'data-id'=>'delivery_date'))?>
								   </div>
								    <?php if ($checkout['code']==1):								    	
								    	$full_booking_time	= $now;
										$full_booking_day	= strtolower(date("D",strtotime($full_booking_time)));	
 										$today_date         = date('l', strtotime($full_booking_time)); 										 
										 $business_hours=Yii::app()->functions->getBusinnesHours($merchant_id,$today_date);
										 $selected_date = '';
									   //dump($business_hours);	
									   // print_r($business_hours); 
									if (is_array($business_hours) && count($business_hours)>=1)
									{
										// print_r($business_hours);
			
										if (!array_key_exists($full_booking_day,$business_hours))
										{
											// echo " Its inside " .$full_booking_day ; exit;
											// return false;
										} 
										else 
										{
											// echo " Its else " .$full_booking_day ; 
											if (array_key_exists($full_booking_day,$business_hours))
											{						
												$selected_date=$business_hours[$full_booking_day];	

											}											 	
										}
									}									 
										 echo CHtml::hiddenField('merchant_open_close_timings',$selected_date,array('class'=>'merchant_open_close_timings')); 

										 echo CHtml::hiddenField('merchant_manual_changed_time','',array('class'=>'merchant_manual_changed_time')); 

										 echo CHtml::hiddenField('merchant_opening_time','',array('class'=>'merchant_opening_time')); 

								   	 endif;?>                                 	
                                   <div class="delivery_asap_wrap"> 
									<div class="cal-icon">
									<i class="fa fa-clock-o"></i>
                                     <?php echo CHtml::textField('delivery_time','',
                                      array('class'=>"timepick form-control",'placeholder'=>Yii::t("default","Delivery Time")))?>	 
									</div>
                                      <span class="delivery-asap">
                                          <?php echo CHtml::checkBox('delivery_asap',false,array('class'=>"styled"))?>
                                          <span class="text-muted"><?php echo Yii::t("default","Delivery ASAP?")?></span>	          
                                      </span>     	         	        
                                   </div>


                                   <?php if ( $checkout['code']==1):  $order_status = 1 ;?>
                                   <?php if($checkout['button']=="Pre-Order") { $order_status = 2 ; } ?>
                                   	<input type="hidden" id="order_type" name="order_type" value="<?php echo $order_status; ?>" >
                                      <a href="javascript:;" class="btn btn-primary checkout"><?php echo $checkout['button']?></a>
                                   <?php else :?>
                                      <?php if ( $checkout['holiday']==1):?>
                                         <?php echo CHtml::hiddenField('is_holiday',$checkout['msg'],array('class'=>'is_holiday'));?>
                                         <p class="text-danger"><?php echo $checkout['msg']?></p>
                                      <?php else :?>
                                         <p class="text-danger"><?php echo $checkout['msg']?></p>
                                         <p class="small">
                                         <?php echo Yii::app()->functions->translateDate(date('F d l')."@".timeFormat(date('c'),true));?></p>
                                      <?php endif;?>
                                   <?php endif;?>   
                                   <br />
                                   <span class="has-error" id="minimum_order_error"></span>                             
                            </div>   
						</div>
					</div>
                <?php endif;?>
			</div>  
			<?php // } ?> 
		</div>
	</div>
</div>
<div class="modal custom-modal fade" id="myModal_add_cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Add Order </h4>
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
<!--<div class="modal custom-modal fade" id="change-address-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" data-backdrop="static" data-keyboard="false" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">   
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Address</h4>                 
			</div>
            <div id="append-add-mod" class="modal-body">
			</div>
		</div>
	</div>
</div>-->
<div class="modal custom-modal fade" id="edit-review-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" data-backdrop="static" data-keyboard="false" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">   
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Review</h4>                 
			</div>
            <div id="edit-review-mod" class="modal-body">            
			</div>
		</div>
	</div>
</div>



 
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Deals</h4>
        </div>
        <div class="modal-body">

			<div class="info_content popup_content">
			    <div class="deal_info_holder">
			        <h1>Deals</h1>
			        
			        <div class="deal_headlines deal_container">
			            <ul class="deals">
			                	<?php 
			                	$appending_div = '';
			                	foreach($deals_list as $deals) { 	?>
			                    <li class="deal_title"><?php echo $deals['title']; ?></li>
			                	<?php 
			                	$appending_div .= $deals['description']."<br /><br />";
			                	} ?>
			            </ul>
			        </div>
			        
			        
			            <div class="deal_terms">
			                <h3>Deals Terms and Conditions</h3>			                
			                <div class="terms_content">
			                	<?php echo $appending_div ; ?>
			                </div>
			            </div>
			        
			    </div>
			</div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
   


   <div class="modal fade" id="delivery_price" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delivery Price List</h4>             
			 <h4 class="modal-note has-error">Note : The Delivery Charges will be Applicable, When the order amount is less than the minimum order amount .  </h4>
        </div>
        <div class="modal-body">
          <p><?php
          	$data = Yii::app()->functions->get_parish_deliver_settings($merchant_id); 
 			// print_r($data);
 			if($data['deliver_to_all_parish']==2)
 			{ ?>

 			<div >				  
				  <p>This Merchant Delivers all the Parishes .</p>            
				  <table class="table">
				    <thead>
				      <tr>
				        <th>Parish List</th>
				        <th>Minimum Order</th>
				        <th>Delivery Fee</th>
				      </tr>
				    </thead>
				    <tbody>
				       <?php $parish_list = Yii::app()->functions->ParishListDropdown(); 
				       		 foreach($parish_list as $parishes)
				       		 { 
				       		 	$minimum_order_amount =  isset($data['minimum_order_amount'])?$data['minimum_order_amount']:0;
				       		 	$delivery_fee         =  isset($data['delivery_fee'])?$data['delivery_fee']:0;
				       		 	?>
				       		 <tr><td><?php print_r($parishes); ?></td><td><?php echo " £ " .number_format((float)$minimum_order_amount, 2, '.', ''); ?></td><td><?php echo " £ " .number_format((float)$delivery_fee, 2, '.', ''); ?></td></tr>	
				       	<?php
				       } 
				       ?>
				    </tbody>
				  </table>
			</div>

 		<?php	} 
 		else
 		{
 			$services = json_decode($data['services'],true); 			 
 			if (sizeof($services)>0)
			{	?>

				<div >				  				              
				  <table class="table">
				    <thead>
				      <tr>
				        <th>Parish List</th>
				        <th>Minimum Order</th>
				        <th>Delivery Price</th>
				      </tr>
				    </thead>
				    <tbody>
		    <?php  
				$parish_list = Yii::app()->functions->ParishListMerchant(); 	       		 
       			foreach ($services as $parish_id => $value) 
       			{ 
       				$parish_min_amt = isset($value['parish_min_amt'])?$value['parish_min_amt']:0;
       				$delivery_fee 	= isset($value['delivery_fee'])?$value['delivery_fee']:0;
       				?>
       				 <tr><td><?php echo $parish_list[$parish_id]; ?></td><td><?php echo " £ " .number_format((float)$parish_min_amt, 2, '.', ''); ?></td><td><?php echo " £ " .number_format((float)$delivery_fee, 2, '.', ''); ?></td></tr> 
       		<?php } ?>
       		      </tbody>
				  </table>
				</div>
				
 		<?php	} 
 		}
           ?></p> 		
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div> 