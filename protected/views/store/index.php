<div id="slides" class="hero2">
	<div class="slides-container"> 
		<?php 
		$background_img = Yii::app()->functions->getBackground_img(); 	 
		 if(empty($background_img)) { ?>

		<img src="<?php echo Yii::app()->createUrl();?>/assets/images/banner1.jpg" alt="">
		<img src="<?php echo Yii::app()->createUrl();?>/assets/images/banner2.jpg" alt="">
		<img src="<?php echo Yii::app()->createUrl();?>/assets/images/banner3.jpg" alt="">
		<?php } else { 

		  foreach ($background_img as $val): ?>
		  <img src="<?php echo Yii::app()->createUrl("/upload/".$val['src']) ?>" alt="<?php echo $val['img_alt'] ?>">
		 <?php endforeach;   
					 }
		 ?>
	</div>
<div class="tint"></div>
	<div class="search-section">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10 finder-block">
                    <?php 
					$home_search_text=Yii::app()->functions->getOptionAdmin('home_search_text');
					if (empty($home_search_text)){
						$home_search_text=Yii::t("default","Table Booking And Food Delivery Online in Jersey");
					} 
					$home_search_subtext=Yii::app()->functions->getOptionAdmin('home_search_subtext');
					if (empty($home_search_subtext)){
						$home_search_subtext=Yii::t("default","Table Booking And Food Delivery Online in Jersey");
					}
                   ?> 
					<div class="search-caption">
						<h1> <?php echo $home_search_text; ?></h1>
					</div> 
					<div class="searchform clearfix">
						<form name="home_srch_form" id="home_srch_form" method="GET" action="<?php echo Yii::app()->createUrl('store/searcharea')?>">
							<div class="top-input input-middle">
								<div class="choose-parish">
									<span class="eat">Your Parish</span>
								</div>
								<div class="post-code">
									  <?php echo CHtml::dropDownList('parish',
									  isset($data['parish'])?$data['parish']:"",
									  (array)Yii::app()->functions->ParishListMerchant('Parish'),          
									  array(
									  'class'=>'form-control' 
									  ))?>
								</div>
								<input name="zipcode" class="form-control" id="zipcode" placeholder="Enter your post code" type="hidden">
							</div> 
                            <div class="top-input input-middle">
								<div class="choose-parish">
									<span class="eat">Your Cuisine</span>
								</div>
								<div class="post-code">
									<select class="form-control" name="filter_cuisine">
										<option value="">All Cuisines</option> 
                                        <?php if ( $list=FunctionsV3::getCuisine() ): ?>
										<?php foreach ($list as $val): ?> 
                                            <option value="<?php echo $val['cuisine_id']; ?>"> <?php echo $val['cuisine_name']; ?> </option>
                                        <?php endforeach;?>  
                                        <?php endif;?>   
									</select>
								</div>
							</div>  
							<div class="explore-btn">
								<button type="submit" class="btn btn-primary btn-lg btn-block">Explore</button>
							</div>
							<?php if(isset($_SESSION['fb_login'])&&$_SESSION['fb_login']=="true") 
							{ 
								?>
							<input type="hidden" name="email" id="email" value="<?php echo isset($_SESSION['FACEBOOK_EMAIL'])?$_SESSION['FACEBOOK_EMAIL']:''; ?>">
							<input type="hidden" name="first_name" id="first_name" value="<?php echo isset($_SESSION['first_name'])?$_SESSION['first_name']:''; ?>">
							<input type="hidden" name="last_name" id="last_name" value="<?php echo isset($_SESSION['last_name'])?$_SESSION['last_name']:''; ?>">
							<input type="hidden" name="facebook_exist" id="facebook_exist" value="<?php echo isset($_SESSION['fb_login'])?$_SESSION['fb_login']:''; ?>">
							<input type="hidden" name="id" id="id" value="<?php echo isset($_SESSION['FBID'])?$_SESSION['FBID']:''; ?>">

							<?php 
							    $location = "https://www.cuisine.je/";
								if(isset($_SESSION['kr_item'])&&sizeof($_SESSION['kr_item'])>0)
							    {
							    		$location = "https://www.cuisine.je/PaymentOption";
							    }
						    ?>
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $location; ?>">


							<?php } ?>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ($theme_hide_how_works<>2):?>
<section class="section-pad80 feature-section parallax">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title cont-how-it-works mb60 text-center">
					<h1><?php echo t("This easy ..")?></h1>
				</div>
			</div>
		</div>
		<div class="row feature-row">
			<!--<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="feature-box">
					<div class="feature-icon"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/icon-04.png" alt="" width="50" height="50"></div>
					<h2>Step 1</h2>
					<p>Mobile App or Visit Cuisine.Je</p>
				</div>
			</div>-->
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="feature-box">
					<div class="feature-icon"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/icon-01.png" alt="" width="50" height="50"></div>
					<h2>Step 1</h2>
					<p>Select your cuisine and order food </p>
					<p>Select your Restaurant and book a Table.</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="feature-box">
					<div class="feature-icon"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/icon-02.png" alt="" width="50" height="50"></div>
					<h2>Step 2</h2>
					<p>Pay with cash or card and get food</p>
					<p> Reserve your table for free.</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="feature-box">
					<div class="feature-icon"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/icon-03.png" alt="" width="50" height="50"></div>
					<h2>Step 3</h2>
					<p>Get updates on your order</p>
					<p> Instant booking confirmation of your table.</p>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;?>
<?php if ($disabled_featured_merchant==""):?>
<?php if ( getOptionA('disabled_featured_merchant')!="yes"):?>
<?php if ($res=Yii::app()->functions->getFeatureMerchant2()):?>
<section class="section-pad80 bg-grey featured-products">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title mb60 text-center">
				<h1>Featured Restaurants</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="featured-products-carousel">
					<div class="owl-carousel" id="featured-products-carousel">
                        <?php //print_r($featured_list);   
						?>
                        <?php if ($featured_list && !empty($featured_list)): ?>
	                    <?php foreach ($featured_list['list'] as $val):  
 								 $merchant_id=$val['merchant_id'];             
								 $ratings=Yii::app()->functions->getRatings($merchant_id);   
								 /*get the distance from client address to merchant Address*/             
								 $distance_type = FunctionsV3::getMerchantDistanceType($merchant_id); 
								 $distance_type_orig = $distance_type;
								 /*dump("c lat=>".$data['client']['lat']);         
								   dump("c lng=>".$data['client']['long']);	             
								   dump("m lat=>".$val['latitude']);
								   dump("c lng=>".$val['lontitude']);*/
								 $distance=FunctionsV3::getDistanceBetweenPlot(
									isset($data['client']['lat']),isset($data['client']['long']),
									$val['latitude'],$val['lontitude'],$distance_type
								 );      
								 $distance_type_raw  = $distance_type=="M"?"miles":"kilometers";
								 $distance_type      = $distance_type=="M"?t("miles"):t("kilometers");
								 $distance_type_orig = $distance_type_orig=="M"?t("miles"):t("kilometers");
								 if(!empty(FunctionsV3::$distance_type_result)){
									$distance_type_raw=FunctionsV3::$distance_type_result;
									$distance_type=t(FunctionsV3::$distance_type_result);
								 } 	             
								 $merchant_delivery_distance=getOption($merchant_id,'merchant_delivery_miles');             
								 $delivery_fee=FunctionsV3::getMerchantDeliveryFee(
											  $merchant_id,
											  $val['delivery_charges'],
											  $distance,
											  $distance_type_raw); ?>
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
                                        <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>" class="btn btn-primary"> Order Now </a>
                                    </div>
                                 </div>	 
						 <?php   endforeach;   
                         else : ?>
						<div class="alert alert-danger text-center">
							<?php echo t("No results with your selected filters")?>
						</div>
                         <?php endif;?>   
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;?>
<?php endif;?>
<?php endif;?>
<?php if ($theme_hide_cuisine<>2):?>
<?php if ( $list=FunctionsV3::getCuisine() ): ?>
<section class="categories-section section-pad80">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title mb60 text-center">
				<h1>Cuisines</h1>
			</div>
			</div>
		</div>
		<div class="row cat-row">  
             <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="cat-wrap">
					<div class="cat-list-wrap">
						<ul class="cat-list row">
                            <?php $x=1;?>
							<?php foreach ($list as $val): ?> 
                                <li class="col-md-3 col-sm-6 col-xs-6">
                                 <a href="<?php echo Yii::app()->createUrl('/store/searcharea?zipcode=&filter_cuisine='.$val['cuisine_id'].',&display_type=listview')?>"> 
                                  <?php 
                                  $cuisine_json['cuisine_name_trans']=!empty($val['cuisine_name_trans'])?json_decode($val['cuisine_name_trans'],true):'';	 
                                  echo qTranslate($val['cuisine_name'],'cuisine_name',$cuisine_json);
                                  if($val['total']>0){ echo "  <span>(".$val['total'].")</span>"; } 
								  ?> 
                                 </a>
                                </li> 
                            <?php $x++;?>
                            <?php endforeach;?> 
						</ul>
					</div>
				</div>
			</div> 
		</div>
	</div>
</section>
<?php endif;?>
<?php endif;?>

<?php if ($theme_show_app==2):?>
<section class="section-pad80 bg-white download-section">
	<div class="container">
		<div class="row ">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-5">
						<div class="">
							<h2>Download.</h2>
							<h3><a href="<?php echo Yii::app()->getBaseUrl(true); ?>" target="_blank"> Cuisine.JE </a> in your pocket!!</h3>
							<ul class="app-link">
								<li><a href="<?php echo $theme_app_ios?>" target="_blank"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/button-app-store.png" alt="App store" width="192" height="57"></a></li>
								<li><a href="<?php echo $theme_app_android?>" target="_blank"><img src="<?php echo Yii::app()->createUrl();?>/assets/images/button-google-play.png" alt="Google play store" width="192" height="57"></a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-7">
					<ul class="sec-list">
						<li>Deals page with all deals at a glance</li>
						<li>Order as guest without an account</li>
						<li>Registering will give more power to your profile and makes your future orders faster</li>
						<li>Cuisine.je is safe and secure, we protect your data</li>						 
					</ul>
					<img src="<?php echo Yii::app()->createUrl();?>/assets/images/payment.png" alt="Payment">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;?>