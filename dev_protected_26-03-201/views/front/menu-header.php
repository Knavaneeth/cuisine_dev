<div class="shop-header shop-menu-header">
	<div class="shop-bg-img parallax" style="background-image: url('<?php echo empty($background)?assetsURL()."/images/b-2.jpg":uploadURL()."/$background"; ?>');">
	<div class="shop-info">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-lg-3 col-sm-4 col-xs-4">
					<div class="shop-details">
						<h2 class="detail-title"><?php echo clearString($restaurant_name)?></h2>
						<div class="shop-cate">
							<?php echo FunctionsV3::displayCuisine($cuisine);?>
						</div>
						<div class="ratings">
							<div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div>
 						</div>
                        <div class="ratings">
							<?php echo FunctionsV3::merchantOpenTag($merchant_id)?> 
						</div>
					</div>
				</div>
				<div class="col-md-9 col-lg-9 col-sm-8 col-xs-8">
					<div class="del-details">
						<div class="row del-details-row">
						<?php if(!isset($_GET['book-a-table'])) { ?>
							<div class="col-md-6 col-sm-6 col-lg-4 col-xs-6"><h3>Minimum Order</h3><span class="meta-address"><?php echo FunctionsV3::prettyPrice($minimum_order)?></span> </div>


								<?php 

								$deliver_time = FunctionsV3::getDeliveryEstimation($merchant_id);
		                        $hours =  floor($deliver_time/60);  
		                        $mins =   $deliver_time % 60;
							    $hrs  = "hr";
		                        $minutes = "";
		                        $delivery_time = "";
		                        if($hours>0)
		                        {
		                            if($hours>1) { $hrs  = "hrs"; }
		                            if($mins>0) { $minutes = "Mins"; $deliver_time = $hours . " ".$hrs." " . $mins . " ".$minutes." ";  }
		                            else { $delivery_time = $hours . " ".$hrs;  }                
		                        }
		                        else
		                        {   
	                        		if($mins>0) 
	                        		{
		                                $minutes = "Mins";
		                                $delivery_time = $mins . " ".$minutes." "; 
	                            	}
		                        }  

		                        if($delivery_time=="")
		                        {
		                        	$delivery_time = "Not Available";
		                        }

		                        ?> 



							<div class="col-md-6 col-sm-6 col-lg-4 col-xs-6"><h3>Estimated Delivery</h3><span class="meta-email"><?php echo $delivery_time;?></span></div>
						<!--	<div class="col-md-12 col-sm-12 col-lg-4 col-xs-12"><h3>Delivery</h3><span class="meta-call"><?php echo FunctionsV3::getFreeDeliveryTag($merchant_id)?></span></div> -->
							<?php 

								$deliver_time = FunctionsV3::getPickupEstimation($merchant_id);
		                        $hours =  floor($deliver_time/60);  
		                        $mins =   $deliver_time % 60;
							    $hrs  = "hr";
		                        $minutes = "";
		                        $pickup_time = "";
		                        if($hours>0)
		                        {
		                            if($hours>1) { $hrs  = "hrs"; }
		                            if($mins>0) { $minutes = "Mins"; $deliver_time = $hours . " ".$hrs." " . $mins . " ".$minutes." ";  }
		                            else { $pickup_time = $hours . " ".$hrs;  }                
		                        }
		                        else
		                        {   
	                        		if($mins>0) 
	                        		{
		                                $minutes = "Mins";
		                                $pickup_time = $mins . " ".$minutes." "; 
	                            	}
		                        }  

		                        if($pickup_time=="")
		                        {
		                        	$pickup_time = "Not Available";
		                        }

		                        ?> 
							<div class="col-md-12 col-sm-12 col-lg-4 col-xs-12"><h3>Estimated Pickup</h3><span class="meta-call"><?php echo $pickup_time; ?></span></div>
						<?php } ?>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    </div>
</div>