<div class="col-lg-12">
<div class="product list">
	<?php if ( $val['is_sponsored']==2):?>
	   <div class="ribbon"><span>Sponsored</span></div>
	<?php endif;?>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="product-img2">
            <!--    <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>">
                	<img src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>" alt="" width="400" height="270"> 
                </a>  -->

             <?php if(isset($_GET['book-a-table']))
                   {  ?>
                     <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'].'?book-a-table=true')?>" >
             <?php } else 
                   { ?>
                      <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>">
             <?php } ?>
                <img src="<?php echo FunctionsV3::getMerchantLogo($merchant_id);?>" alt="" width="400" height="270">
            </a>    
            </div>
            <?php if($val['service']!=3 && FunctionsV3::getDeliveryEstimation($merchant_id) != 'not available'):?> 
            <?php if(!isset($_GET['book-a-table']))
                   {  ?>    
            <div class="time-tag">
                   <?php $exp = explode(' ',FunctionsV3::getDeliveryEstimation($merchant_id)); 
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
                                $minutes = "Mins";
                                $deliver_time = $mins . " ".$minutes." "; 
                        }  ?> 

                <span class="time-count"> <?php echo $deliver_time; ?> </span> 
                <span class="min"><?php echo $exp[1]; ?></span>
            </div> 
	        <?php 
                }
            endif;?>   
        </div>
        <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 pad-0">
            <div class="product-desc">
                <h3>
                <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>"> 
					<?php echo clearString($val['restaurant_name'])?>
                </a>
                </h3>
                <div class="type">
                    <?php echo FunctionsV3::displayCuisine($val['cuisine']);?>
                </div>
                <?php if(!isset($_GET['book-a-table'])){  ?>
                <span class="opening"> <?php echo FunctionsV3::merchantOpenTag($merchant_id)?> </span> 
                <?php } ?>
                <?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?> 
                <?php endif;?> 
                <div class="location">
                    <?php echo $val['merchant_address']?>.   
                </div>
                <?php if($val['minimum_order'] != ''){ ?>
                <?php if(!isset($_GET['book-a-table'])){  ?>
                <div class="min-order">
                 Minimum order : <?php echo FunctionsV3::prettyPrice($val['minimum_order'])?>  
                </div>
                <?php } ?>
                <?php } ?>
                <div class="special-offer">
				<?php if ($offer=FunctionsV3::getOffersByMerchant($merchant_id)):?>
                    <span><?php echo 'Special offer : '.$offer;?> </span>
                <?php endif;?> 
                </div>
                <div class="ratings">
                    <div class="rating-stars" data-score="<?php echo $ratings['ratings']?>"></div>   
                </div>
                <?php if(!isset($_GET['book-a-table'])){  ?>
                <ul>
                    <?php echo FunctionsV3::displayServicesList($val['service'])?> 
                </ul> 
                <div class="delivery-fee">
                    <?php                           
                        $service_type = Yii::app()->functions->get_merchant_service($merchant_id);
                        if($service_type!=4)
                        {
                            if ($delivery_fee)
                            {
                                 echo t("Delivery Fee")." : ".FunctionsV3::prettyPrice($delivery_fee);
                            } else echo  t("Delivery Fee")." : ".t("Free Delivery"); 
                        }
                        else
                        {
                            echo '<div class="min-order">'.t("Table Booking Only").'</div>';  
                        }               
                    ?> 
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
            <div class="go_to text-right">
                <div>
                    <!-- <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>" class="btn btn-primary">View Menu</a> -->
                      <?php if(isset($_GET['book-a-table'])){  ?>
                        <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'].'?book-a-table=true')?>" class="btn btn-primary"> Book a Table </a>
                            <?php } else { 
                         $current_status = Yii::app()->functions->getMerchantCurrentStatus($merchant_id);
                        ?>
                    <a href="<?php echo Yii::app()->createUrl('store/menu/merchant/'.$val['restaurant_slug'])?>" class="btn btn-primary"> <?php echo $current_status; ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>