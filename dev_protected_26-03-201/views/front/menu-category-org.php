<?php if(is_array($menu) && count($menu)>=1):?> 
<div class="row row-sm menu-cat-row"> 
	<div class="col-md-4 col-sm-4 col-xs-5 leftsidebar hidden-xs">
		<div class="theiaStickySidebar">
			<div class="category-sec">
				<h3 class="res-title"><?php echo $restaurant_name; ?></h3>
				<h3 class="menu-title">Menu</h3>
				<ul class="categorylist">
				<?php 
				$cnt = 0;
				foreach ($menu as $val):?>
				 <li><a href="javascript:;" class="<?php if($cnt == 0){?>active<?php } ?> merchant_menu_sel" cat-id="<?php echo $val['category_id']?>"><?php echo qTranslate($val['category_name'],'category_name',$val)?></a></li>
				<?php $cnt++; ?>  
				<?php endforeach;?>  
				</ul>
			</div>
		</div>   
	</div>   
<div class="col-md-8 col-sm-8 col-xs-12">
	<div class="row">
	<?php 
	$cnt = 0;
	foreach ($menu as $val): 

	//	print_r($val);

		?>  
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 menu-cat-lists cat_list_cls cat-id-<?php echo $val['category_id']; ?>" style="display:<?php if($cnt == 0){?> block <?php }else{ ?> none <?php } ?>" >
		<div class="menu-list">
			<div class="panel panel-default">
				<div class="panel-heading">
					 <h4 class="panel-title">
					  <?php echo qTranslate($val['category_name'],'category_name',$val)?>
					 </h4> 
				</div>
				<div class="panel-body">
					<div class="food-list">
					<?php if (is_array($val['item']) && count($val['item'])>=1):?>
						<ul class="layout-sorting">
						   <?php foreach ($val['item'] as $val_item):?>
						   <?php 
						/*   	print_r($val_item);
						   	echo "\n\n";   */
							$atts='';
							if ( $val_item['single_item']==2){
							  $atts.='data-price="'.$val_item['single_details']['price'].'"';
							  $atts.=" ";
							  $atts.='data-size="'.$val_item['single_details']['size'].'"';
							}
							?>    
							<li class="list-view">		
<div class=" row row-sm">
	<div class="col-xs-12 col-sm-12 col-lg-6">					
		<?php if($val_item['photo']!='') { ?>
		<div class="food-img">			 
			<img src="<?php echo FunctionsV3::getFoodDefaultImage($val_item['photo']);?>" alt="" width="50" >
		</div>
		<?php } ?>
		<div class="food-det">
			<h4><?php echo qTranslate($val_item['item_name'],'item_name',$val_item)?> 		<span class="food-cat-img">
			<?php 									
			$category_img = Yii::app()->functions->get_category_image($val_item['item_category_id']); 									
			?>
			<span class="food-desc">
			<img src="<?php 
			echo FunctionsV3::getFoodDefaultImage($category_img[0]['img_url']);
			 ?>" alt="<?php echo $category_img[0]['category_type']; ?>" height="16" title="<?php echo $category_img[0]['tooltip_text']; ?>"  >
			</span>
		</span>	</h4>
			<p class="food-desc"> <?php echo $val_item['item_description']; ?> </p>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-lg-6 pull-right">							
								<?php 
								 $show_price = true ;
								if(count($val_item['variety_list'])>0)
								{	
									foreach ($val_item['variety_list'] as $variety_list_key => $variety_list_value) 
									{
										foreach ($variety_list_value as $vlkey => $vlvalue) 
										{   											
											foreach ($vlvalue as $variety_name => $variety_price) 
											{ 
												$show_price = false;
												//$variety_name = str_replace('"','___',$variety_name);	
												?>
							    	  <a href="javascript:;" class="dsktop menu-item <?php echo $val_item['not_available']==2?"item_not_available":''?>" 
										rel="<?php echo $val_item['item_id']?>" data-identity="<?php echo strtolower(str_replace('"','___',$variety_name)); ?>" data-single="<?php echo $val_item['single_item']?>" >	
										<div class="food-varieties">											
											<div class="row"><div class="col-xs-10"><strong> <?php echo $variety_name . "</strong> <span class='food-price'> £ ".$variety_price; ?> </span> </div><div class="col-xs-2"><span class="add_icon">
											<!-- <i class="fa fa-plus-circle" aria-hidden="true"> </i>  -->
									   <img src="<?php 	echo Yii::app()->getBaseUrl(true)."/assets/images/menu-icon.png";	 ?>" />
											</span></div></div> 
									    </div>																				    
									  </a>
												
									<?php   $variety_name = '';
											}										
									    }
									}									 
								}			if($show_price)	 { ?>
								<div class="price-det">
								<div class="row">
									<div class="col-xs-10"><span class="food-price"> <?php echo FunctionsV3::getItemFirstPrice($val_item['prices'],$val_item['discount']) ?> </span></div>
									<div class="col-xs-2"><div class="order-btn">
									  <?php 									  
									  if ( $disabled_addcart==""):?>
									  <a href="javascript:;" title="Add Order" class="dsktop menu-item <?php echo $val_item['not_available']==2?"item_not_available":''?> " 
										rel="<?php echo $val_item['item_id']?>" data-identity="<?php echo strtolower($variety_name); ?>" data-single="<?php echo $val_item['single_item']?>" 
										<?php echo $atts;?>
									   >
									   <span class="add_icon">

									   <!-- <i class="fa fa-plus-circle" aria-hidden="true"> </i>  -->
									   <img src="<?php 	echo Yii::app()->getBaseUrl(true)."/assets/images/menu-icon.png";	 ?>" />

									   </span>
									  </a>
									  <?php endif;?>
									</div>
								</div></div></div>   <?php } ?>
								<div class="clear"></div>
</div>													
							</li>
							<?php endforeach;?> 
						</ul>
						<?php else :?> 
						  <div class="text-center alert alert-danger mb-0"><?php echo t("no item found on this category.")?></div>
						<?php endif;?>
					</div>
				</div>
			</div> 
		</div>
	</div>
<?php $cnt++; ?> 
<?php endforeach;?>       
</div>
</div>   
</div>     
<?php else :?>
<div class="text-center alert alert-danger mb-0"><?php echo t("This restaurant has not published their menu yet.")?></div>
<?php endif;?> 
<?php /*if(is_array($menu) && count($menu)>=1):?>
<div class="category">
<?php foreach ($menu as $val):?>
 <a href="javascript:;" class="category-child relative goto-category" data-id="cat-<?php echo $val['category_id']?>" >
  <?php echo qTranslate($val['category_name'],'category_name',$val)?>
  <span>(<?php echo is_array($val['item'])?count($val['item']):'0';?>)</span>
  <i class="ion-ios-arrow-right"></i>
 </a>
<?php endforeach;?>
</div>
<?php endif;*/?>