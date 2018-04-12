<?php

header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");

$this->renderPartial('/front/default-header',array(
   'h1'=>t("Payment Option"),
   'sub_text'=>t("choose your payment")
));?>

<?php 
/*$this->renderPartial('/front/order-progress-bar',array(
   'step'=>4,
   'show_bar'=>true
));*/

$search_parish = '';
if($address_book)
{
	//	Yii::app()->functions->Default_address_parish_delivery($address_book['parish_id'],$merchant_id);
	 $search_parish = Yii::app()->functions->getClientdefaultCity(Yii::app()->functions->getClientId());
}
// echo "Hello".$search_parish;
$s=$_SESSION;
$continue=false;

$merchant_address='';		
if ($merchant_info=Yii::app()->functions->getMerchant($s['kr_merchant_id'])){	
	$merchant_address=$merchant_info['street']." ".$merchant_info['city']." ".$merchant_info['state'];
	$merchant_address.=" "	. $merchant_info['post_code'];
}

$client_info='';

if (isset($is_guest_checkout)){
	$continue=true;	
} else {	
	$client_info = Yii::app()->functions->getClientInfo(Yii::app()->functions->getClientId());	 
	if (isset($s['kr_search_address'])){	
		$temp=explode(",",$s['kr_search_address']);		
		if (is_array($temp) && count($temp)>=2){
			$street=isset($temp[0])?$temp[0]:'';
			$city=isset($temp[1])?$temp[1]:'';
			$state=isset($temp[2])?$temp[2]:'';
		}
		if ( isset($client_info['street'])){
			if ( empty($client_info['street']) ){
				$client_info['street']=$street;
			}
		}
		if ( isset($client_info['city'])){
			if ( empty($client_info['city']) ){
				$client_info['city']=$city;
			}
		}
		if ( isset($client_info['state'])){
			if ( empty($client_info['state']) ){
				$client_info['state']=$state;
			}
		}
	}	
	
	if (isset($s['kr_merchant_id']) && Yii::app()->functions->isClientLogin() && is_array($merchant_info) )
	{
		$continue=true;
	}
}
$client_info = '';
echo CHtml::hiddenField('mobile_country_code',Yii::app()->functions->getAdminCountrySet(true));
echo CHtml::hiddenField('admin_currency_set',getCurrencyCode());
echo CHtml::hiddenField('admin_currency_position',
Yii::app()->functions->getOptionAdmin("admin_currency_position"));

?> 
<div class="page-content">
	<div class="container">
	    <?php if ( $continue==TRUE):?>
        <?php 
        $merchant_id=$s['kr_merchant_id'];
        echo CHtml::hiddenField('merchant_id',$merchant_id);
        ?>
		<div class="row row-sm">
			<div class="col-md-7">
				<div class="delivery-info"> 
				<!--	<form id="frm-delivery" class="frm-delivery" method="POST" onsubmit="return false;" autocomplete="off"> -->
				<form id="frm-delivery" class="frm-delivery" method="POST" autocomplete="off">
                     <?php 
					 echo CHtml::hiddenField('action','placeOrder');
					 echo CHtml::hiddenField('base_url',Yii::app()->getBaseUrl(true)); 
					 echo CHtml::hiddenField('require_parish',''); 
					 echo CHtml::hiddenField('state',''); 
					 echo CHtml::hiddenField('parish',$search_parish); 
					 echo CHtml::hiddenField('country_code',$merchant_info['country_code']);
					 echo CHtml::hiddenField('currentController','store');
					 echo CHtml::hiddenField('delivery_type',$s['kr_delivery_options']['delivery_type']);
					 echo CHtml::hiddenField('cart_tip_percentage','');
					 echo CHtml::hiddenField('cart_tip_value','');
					 echo CHtml::hiddenField('client_order_sms_code');
					 echo CHtml::hiddenField('client_order_session');
					 echo CHtml::hiddenField('order_type',$_SESSION['kr_delivery_options']['order_type']);

					 echo CHtml::hiddenField('refresh_page','yes');

					 if (isset($is_guest_checkout)){
						echo CHtml::hiddenField('is_guest_checkout',2);
					 }     
					 ?> 
                     <?php if ( $s['kr_delivery_options']['delivery_type']=="pickup"):?>  
                          <h3><?php echo Yii::t("default","Pickup information")?></h3>
                          <p class="uk-text-bold"><?php echo $merchant_address;?></p> 
                          <?php if (!isset($is_guest_checkout)):?> 
                          <?php if ( getOptionA('mechant_sms_enabled')==""):?>
                          <?php if ( getOption($merchant_id,'order_verification')==2):?>
                          <?php $sms_balance=Yii::app()->functions->getMerchantSMSCredit($merchant_id);?>
                          <?php if ( $sms_balance>=1):?>
                                 <div class="row top10">
                                    <div class="col-md-10">
                                      <?php echo CHtml::textField('contact_phone',isIsset($client_info['contact_phone']),array(
                                       'class'=>'mobile_inputs form-control',
                                       'placeholder'=>Yii::t("default","Mobile Number"),
                                       'data-validation'=>"required"  
                                      ))?>
                                     </div>             
                                </div>  
                          <?php endif;?>
                          <?php endif;?>
                          <?php endif;?>
                          <?php endif;?> 
                          <?php if (isset($is_guest_checkout)):?>
                          <?php 
                           $this->renderPartial('/front/guest-checkou-form',array(
                             'merchant_id'=>$merchant_id,	
                             'is_guest_checkout'=>$is_guest_checkout	   
                           ));
                          ?>                     
                          <?php endif;?>
                   <?php else :?>
						<div class="row del-information">
							<div class="col-lg-12">
								<h2 class="block-title-2"> Delivery information </h2>
							</div>
							<div class="col-xs-12 col-sm-12">
								<p>
                                <?php echo clearString(ucwords($merchant_info['restaurant_name']))?> <?php echo Yii::t("default","Restaurant")?> 
								<?php echo "<span class='bold'>".Yii::t("default",ucwords($s['kr_delivery_options']['delivery_type'])) . "</span> ";
                                if ($s['kr_delivery_options']['delivery_asap']==1){
                                    $s['kr_delivery_options']['delivery_date']." ".Yii::t("default","ASAP");
                                } else {
                                  echo '<span class="bold">'.date("M d Y",strtotime($s['kr_delivery_options']['delivery_date'])).
                                  " ".t("at"). " ". $s['kr_delivery_options']['delivery_time']."</span> ".t("to");
                                }?>
                                </p>
							</div>
						</div>
						<div class="row address-info">
							<div class="col-lg-12">
								<h2 class="block-title-2"> Address </h2>
							</div>
							<div class="col-xs-12 col-sm-12">
                               <?php if (isset($is_guest_checkout)):?>
                               <div class="form-group">
									<?php echo CHtml::textField('first_name','',array(
									   'class'=>'form-control',
									   'placeholder'=>Yii::t("default","First Name"),
									   'data-validation'=>"required"
									))?>
							   </div>
                               <div class="form-group">
									<?php echo CHtml::textField('last_name','',array(
									   'class'=>'form-control',
									   'placeholder'=>Yii::t("default","Last Name"),
									   'data-validation'=>"required"
								    ))?>
							   </div> 
                               <?php endif;?>
                               <?php if ( $website_enabled_map_address==2 ):?>
                                <div class="address-map-sec">
                                <?php Widgets::AddressByMap()?>
                                </div>
                               <?php endif;?>
                               <?php // print_r($_SESSION['kr_item']); ?>
                               <?php if ($address_book):                                                               	
                               ?>
							   <div class="address_book_wrap">
								<div class="form-group">
									<?php 
								    $address_list=Yii::app()->functions->client_addressBook_dropdown(Yii::app()->functions->getClientId());
								    $address_array = '';
								    foreach ($address_list as $address_key => $address_value) 
								    {
								    	// echo $address_value."<br />";
								    	if(!in_array($address_value,$address_array))
					   					{
					   						$address_array[] = $address_value;
					   						$address_list[$address_key] = $address_value;
					   					}
					   					else
					   					{
					   						$key = array_search($address_value,$address_list); 
					   						unset($address_list[$key]);
					   						$address_array[] = $val['address'];
					   						$address_list[$address_key] = $address_value;
					   					}
								    }
								     
								    echo CHtml::dropDownList('address_book_id',$address_book['id'],
								    (array)$address_list,array(
									  'class'=>"form-control default_address_book_slt"
								    ));
								    ?>
                                    <a href="javascript:;" class="edit_address_book block top10"><i class="fa fa-pencil-square-o"></i> Edit</a>
								</div>
								</div>
                               <?php endif;?> 
                               <input type="hidden" id="formatted_address" name="formatted_address" value="">
							   <div class="address-block">

							<!--   <div class="form-group">
									<?php echo CHtml::textField('zipcode',
									  isset($client_info['zipcode'])?$client_info['zipcode']:''
									  ,array(
									   'class'=>'postcode',
									   'placeholder'=>Yii::t("default","postcode"),
									   'data-validation'=>"required"
									  ))?>
									  <input type="button" name="search_address" class="search_address" value="search">
								</div>  -->


								<div class="input-group">
										<?php echo CHtml::textField('zipcode',
										  isset($client_info['zipcode'])?$client_info['zipcode']:''
										  ,array(
										   'class'=>'postcode form-control',
										   'placeholder'=>Yii::t("default","postcode"),
										   'data-validation'=>"required"
										  ))?>
										<div class="input-group-btn">
											<input name="search_address" class="search_address btn btn-primary" value="search " type="button">
										</div>
								</div>
								<br />
								<span class="has-error" id="wrong_pin" style="display:none;"></span>
								<div class="form-group get_address_div" style="display:none;">
	                                <?php 
	                                echo CHtml::dropDownList('slt_address','','',          
									  array(
									  'class'=>'form-control slt_address'									  
									  ))?>
								</div> 

							   <div class="form-group">
									<?php echo CHtml::textField('location_name',
									 isset($client_info['location_name'])?$client_info['location_name']:''
									 ,array(
									   'class'=>'form-control',
									   'placeholder'=>Yii::t("default","Apartment suite, unit number, or company name")	               
									  ))?>
								</div>
							<div class="form-group">
									<?php echo CHtml::hiddenField('street', isset($client_info['street'])?$client_info['street']:'' ,array(
									   'class'=>'form-control',
									   'placeholder'=>Yii::t("default","Street"),
									   'data-validation'=>"required"
									  ))?>
								</div>  
								<div class="form-group">
									<?php echo CHtml::textField('city',
									 isset($client_info['city'])?$client_info['city']:''
									 ,array(
									   'class'=>'form-control',
									   'placeholder'=>Yii::t("default","City"),
									   'data-validation'=>"required"
									))?>
								</div>
								<div class="form-group">
								<!--	<?php echo CHtml::textField('state',
									 isset($client_info['state'])?$client_info['state']:''
									 ,array(
									 'class'=>'form-control',
									   'placeholder'=>Yii::t("default","State")									   
									  ))?>  -->

									    <?php 
									if(isset($_SESSION['kr_item']['parish_delivery_rate']['delivering_paish']))
									{
										$parish_id = $_SESSION['kr_item']['parish_delivery_rate']['delivering_paish'];
										if(!empty($parish_id))
										{									 
											$address_book['parish_id'] = $parish_id;
										}
									}    

							    echo CHtml::dropDownList('parish',
								  isset($address_book['parish_id'])?$address_book['parish_id']:"",
								  (array)Yii::app()->functions->ParishListMerchant('Choose Parish'),          
								  array(
								  'class'=>'form-control check_out_parish_select' ,
								  'data-validation'=>"required"
								  ))?>
								</div>
								</div>
                                
                                <div class="form-group">
									<?php echo CHtml::textField('contact_phone',
									 isset($client_info['contact_phone'])?$client_info['contact_phone']:''
									 ,array(
									   'class'=>'form-control mobile_inputs',
									   'placeholder'=>Yii::t("default","Mobile Number"),
									   'data-validation'=>"required"  
									  ))?>
								</div>
                                
                                <div class="form-group">
									<?php echo CHtml::textField('delivery_instruction','',array(
									   'class'=>'form-control',
									   'placeholder'=>Yii::t("default","Delivery instructions")   
									  ))?>
								</div>

								<?php if (isset($is_guest_checkout)):?>
									<div class="form-group">
										<span class="guest_checkout_registeration"> You are just a couple of steps away from registering your membership .  </span>
										<br /><br />
										<?php echo CHtml::checkBox('save_as_member',false,array('class'=>"save_as_member",'value'=>2));  ?>
									<label for="saved_address" class="control-label"> Save as member </label>	
									</div>
								<?php endif; ?>	

								<?php if(!isset($is_guest_checkout)): ?>
	                            <!--    <div class="checkbox checkbox-success">
	                                    <?php	    echo CHtml::checkBox('saved_address',false,array('class'=>"styled",'value'=>2)); ?> 
	                                    <label for="saved_address" class="control-label"> Save to my address book</label>
									</div>   -->
								<?php endif; ?>								

                                <?php if (isset($is_guest_checkout)):?>
                                	<div id="save_as_member_div" style="display:none;">
	                                <?php FunctionsV3::sectionHeader('Required')?>
	                                 <div class="form-group">
										<?php echo CHtml::textField('email_address1','',
											array('class'=>'form-control',
							'placeholder'=>t("Email address"),
						    'required'=>true,
						    'data-validation'=>"email"
						    ))?>
									 </div>                    								
	                                  <div class="form-group">
	                                     <?php echo CHtml::passwordField('password1','',array(
	                                       'class'=>'form-control',
	                                       'placeholder'=>Yii::t("default","Password"),     
	                                        'data-validation'=>"length",
						     				'data-validation-length'=>"min8"          
	                                      ))?> 
	                                  </div>                                
		                            </div>  
	                            <?php endif; ?>   
							</div> 
						</div>
                        <?php endif;?>
						<div class="row payment-info">
							<div class="col-md-12">
								<?php 
								 $this->renderPartial('/front/payment-list',array(
								   'merchant_id'=>$merchant_id,
								   'payment_list'=>FunctionsV3::getMerchantPaymentList($merchant_id),
								   'delivery_type'=>trim($s['kr_delivery_options']['delivery_type'])
								 ));
								 ?>   
							</div>
						</div>
						 <?php if ( Yii::app()->functions->getOption("merchant_enabled_tip",$merchant_id)==2):?>
                         <?php 
                         $merchant_tip_default=Yii::app()->functions->getOption("merchant_tip_default",$merchant_id);
                         if ( !empty($merchant_tip_default)){
                            echo CHtml::hiddenField('default_tip',$merchant_tip_default);
                         }        
                         $FunctionsK=new FunctionsK();
                         $tips=$FunctionsK->tipsList();        
                         ?>	   
                           <div class="row tip-amount">
                                <div class="col-lg-12">
                                    <h2 class="block-title-2"> Tip Amount (<span class="tip_percentage">0%</span>)</h2>
                                </div>
						   </div>    
                            <div class="uk-panel uk-panel-box">
                             <ul class="tip-wrapper">
                               <?php foreach ($tips as $tip_key=>$tip_val):?>           
                               <li>
                                   <a class="tips" href="javascript:;" data-type="tip" data-tip="<?php echo $tip_key?>">
                                   	<?php echo $tip_val?>
                                   </a> 
                               </li>
                               <?php endforeach;?>           
                               <li><a class="tips" href="javascript:;" data-type="cash" data-tip="0"><?php echo t("Tip cash")?></a></li>
                               <li><?php echo CHtml::textField('tip_value','',array(
                                 'class'=>"numeric_only form-control tips-input",
                                 'style'=>"width:70px;display:inline-block;"
                               ));?></li>
                             </ul>
                            </div>
                         <?php endif;?>
					 </form>
					 <?php 
                     $this->renderPartial('/front/credit-card',array(
                       'merchant_id'=>$merchant_id	   
                     ));
                     ?>
				</div>
			</div>
			<div class="col-md-5 rightsidebar">
				<div class="sidebar">
					<div class="order-box pay-order-box">
						<h3 class="title-1 text-center">Your Order</h3>
						<div class="order-list-wrap">    
	         				<div class="item-order-wrap"></div> 
                        </div>
						<div class="voucher">       
                            <?php  Widgets::applyVoucher($merchant_id); ?>       
						</div>
                        <?php 
						 if (!empty($minimum_order)){
							echo CHtml::hiddenField('minimum_order',unPrettyPrice($minimum_order));
							echo CHtml::hiddenField('minimum_order_pretty',baseCurrency().prettyFormat($minimum_order));
							?>
                            <p class="small text-danger text-center">Subtotal must exceed <?php echo baseCurrency().prettyFormat($minimum_order,$merchant_id)?></p>
 						 <?php
						 }
						 if(isset($maximum_order))
						 {	
							 if($maximum_order>0)
							 {
								echo CHtml::hiddenField('maximum_order',unPrettyPrice($maximum_order));
								echo CHtml::hiddenField('maximum_order_pretty',baseCurrency().prettyFormat($maximum_order));
							 }
						}
						 ?>  
                         <?php if ( getOptionA('captcha_order')==2 || getOptionA('captcha_customer_signup')==2):?>             
                         <div class="top10 capcha-wrapper">
                         <?php //GoogleCaptcha::displayCaptcha()?>
                         <div id="kapcha-1"></div>
                         </div>
                         <?php endif;?> 
                         
                          
						  <?php if ( getOptionA('mechant_sms_enabled')==""):?>
                          <?php if ( getOption($merchant_id,'order_verification')==2):?>
                          <?php $sms_balance=Yii::app()->functions->getMerchantSMSCredit($merchant_id);?>
                          <?php if ( $sms_balance>=1):?>
                          <?php $sms_order_session=Yii::app()->functions->generateCode(50);?>
                          <p class="top20 center">
                          <?php echo t("This merchant has required SMS verification")?><br/>
                          <?php echo t("before you can place your order")?>.<br/>
                          <?php echo t("Click")?> <a href="javascript:;" class="send-order-sms-code" data-session="<?php echo $sms_order_session;?>">
                             <?php echo t("here")?></a>
                          <?php echo t("receive your order sms code")?>
                          </p>
                          <div class="top10 text-center">
                          <?php 
                          echo CHtml::textField('order_sms_code','',array(	            
                            'placeholder'=>t("SMS Code"),
                            'maxlength'=>8,
                            'class'=>'grey-fields text-center'
                          ));
                          ?>
                          </div>
                          <?php endif;?>
                          <?php endif;?>
                          <?php endif;?>
                          <!--END SMS Order verification-->  
						<div class="text-center place_order"><a class="btn btn-primary">Place Order</a></div>
						<span class="has-error" id="merchant_non_deliverable_addr" style="display: none"> This Restaurant will not deliver to this Address. </span>
					</div>
				</div>
			</div>
		</div>
        <?php else :?>      
           <div class="alert alert-danger text-center"> 
            <?php echo t("Something went wrong Either your visiting the page directly or your session has expired.")?> 
           </div>
        <?php endif;?> 
	</div>
</div> 
 
<div class="modal custom-modal pay-add-cart fade" id="myModal_add_cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:40%">
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

