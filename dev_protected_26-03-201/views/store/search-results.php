<?php 
$search_address=isset($_GET['s'])?$_GET['s']:'';
if (isset($_GET['st'])){
	$search_address=$_GET['st'];
}
$this->renderPartial('/front/search-header',array(
   'search_address'=>$search_address,
   'total'=>$data['total']
));  
?> 
<?php 
/*$this->renderPartial('/front/order-progress-bar',array(
   'step'=>2,
   'show_bar'=>true
)); */ 
echo CHtml::hiddenField('clien_lat',$data['client']['lat']);
echo CHtml::hiddenField('clien_long',$data['client']['long']);
?> 

<div class="actions-bar tsticky">
     <div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 hidden-xs search-breadcrumb">
				<ul class="breadcrumb">
					<!--	<li><a href="#">Home</a></li> -->
				</ul>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="toggle-view view-format-choice pull-right">
					<div class="btn-group">
						<a href="<?php echo FunctionsV3::clearSearchParams('','display_type=listview')?>" class="btn btn-default <?php echo $display_type=="listview"?'active':''?>" id="results-list-view"><i class="fa fa-th-list"></i></a>
						<a href="<?php echo FunctionsV3::clearSearchParams('','display_type=gridview')?>" class="btn btn-default <?php echo $display_type=="gridview"?'active':''?>" id="results-grid-view"><i class="fa fa-th"></i></a>
						<a href="javascript:;" id="mobile-filter-handle" class="btn btn-default"><i class="fa fa-filter"></i></a>    
						<!--<?php if ( $enabled_search_map=="yes"):?>
						<a href="javascript:;" id="mobile-viewmap-handle" class="btn btn-default">
							<i class="fa fa-map-marker"></i>
						</a>    
						<?php endif;?>-->
					</div>  
				</div> 
				<div class="btn-group pull-right results-sorter">
                    <select class="form-control" id="sort_filter" onchange="research_merchant();">
                        <option value="">Sort by</option>
                        <option value="restaurant_name" <?php if($sort_filter == 'restaurant_name') echo 'selected'; ?>>Name</option>
                        <option value="ratings" <?php if($sort_filter == 'ratings') echo 'selected'; ?>>Rating</option>
                        <option value="minimum_order" <?php if($sort_filter == 'minimum_order') echo 'selected'; ?>>Min Order</option>
                    </select>
				</div>
			</div>
		</div>
    </div>
</div>   
<div class="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12 result-count">
            	   <?php if(isset($_GET['book-a-table'])) {  ?>
                <h2><?php if($data['total'] > 0){ echo $data['total']; ?> Restaurant(s) for book a table <?php } ?></h2>
                            <?php } else { ?>
                <h2><?php if($data['total'] > 0){ echo $data['total']; ?> Restaurant(s) can deliver <?php } ?></h2>
                            <?php } ?>
			</div>
			<div class="col-md-3 col-sm-4 search-left-content" id="mobile-search-filter">
			        <div class="filter-wrap rounded2 <?php echo $enabled_search_map==""?"no-marin-top":""; ?>">
                
          <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>  
				<div class="widget"> 
                    <h5>Search 
                    <?php if (!empty($restaurant_name)):?>
                    <a href="<?php echo FunctionsV3::clearSearchParams('restaurant_name')?>" class="pull-right" >Clear</a> 
                    <?php endif;?> 
                    </h5> 
					<div class="search-res"> 
						<form method="POST" onsubmit="return research_merchant();">
                            <?php echo CHtml::textField('restaurant_name',$restaurant_name,array(
							  'required'=>true,
							  'placeholder'=>t("Enter restaurant name"),
							  'class'=>'form-control'
							))?>
							<button class="link" type="submit"></button>
						</form>
					</div>
				</div>  
                <?php if(!isset($_GET['book-a-table'])) {  ?>  
                <div class="widget">
					<h5>Delivery Fee 
                    <?php if (isset($filter_delivery_free_chkbx) && !empty($filter_delivery_free_chkbx)):?>   
                    <a href="<?php echo FunctionsV3::clearSearchParams('filter_delivery_free_chkbx')?>" class="pull-right" >Clear</a> 
                    <?php endif;?>
                    </h5> 
					<ul>
						<li>Free Delivery
							<input type="checkbox" onclick="research_merchant();" class="filter_delivery_free_chkbx" name="filter_delivery_free_chkbx" value="1" 
							<?php if(isset($filter_delivery_free_chkbx) && $filter_delivery_free_chkbx == 1) echo 'checked="checked"'; ?>>
						</li>
					</ul>
				</div>
                <div class="widget">
					<h5>By Delivery 
                    <?php if (!empty($filter_delivery_type)):?>   
                    <a href="<?php echo FunctionsV3::clearSearchParams('filter_delivery_type')?>" class="pull-right" >Clear</a> 
                    <?php endif;?>  
                    </h5> 
                     <?php if ( $services=Yii::app()->functions->Services() ):?>
                        <ul class="<?php echo $fc==2?"hide":''?>">
                         <?php foreach ($services as $key=> $val):?>
                          <li> <?php echo $val;?>
							<input type="radio" onclick="research_merchant();" class="filter_delivery_type" name="delivery_type_chkbx" value="<?php echo $key; ?>" 
							<?php if($filter_delivery_type == $key) echo 'checked="checked"'; ?>>
						  </li> 
                         <?php endforeach;?> 
                       </ul> 
                   <?php endif;?>  
				</div> 
                <?php } ?>
            <!--    <div class="widget">
					<h5>Special Offers 
                    <?php if (isset($filter_special_offer) && !empty($filter_special_offer)):?>   
                    <a href="<?php echo FunctionsV3::clearSearchParams('filter_special_offer')?>" class="pull-right" >Clear</a> 
                    <?php endif;?>  
                    </h5>
					<ul>
						<li>Special Offers
							<input type="checkbox"  onclick="research_merchant();" class="filter_special_offer" value="1" 
							<?php if(isset($filter_special_offer) && $filter_special_offer == 1) echo 'checked="checked"'; ?>>
						</li>
					</ul>
				</div>   -->
				<div class="widget">
					<h5>By Cuisines 
                    <?php if (!empty($filter_cuisine)):?>    
                    <a href="<?php echo FunctionsV3::clearSearchParams('filter_cuisine')?>" class="pull-right" >Clear</a>
                    <?php endif;?> 
                    </h5>  
                    <?php if ( $cuisine=Yii::app()->functions->Cuisine(false)):?>  
                        <ul class="<?php echo $fc==2?"hide":''?>">
                         <?php foreach ($cuisine as $val): 
 						     $cuisine_json['cuisine_name_trans']=!empty($val['cuisine_name_trans'])?
                             json_decode($val['cuisine_name_trans'],true):'';
						     ?>
                             <li><?php echo ucfirst(qTranslate($val['cuisine_name'],'cuisine_name',$cuisine_json))?>
                                <input class="filter_cuisine" type="checkbox" onclick="research_merchant();"  value="<?php echo $val['cuisine_id']; ?>" 
								<?php if(in_array($val['cuisine_id'],(array)$filter_cuisine)) echo 'checked="checked"'; ?>>
                             </li>  
                         <?php endforeach;?> 
                       </ul> 
                    <?php endif;?> 
				</div> 
                <?php if(!isset($_GET['book-a-table'])) {  ?>  
                <div class="widget">
					<h5>Minimum Delivery 
                    <?php if (!empty($filter_minimum)):?>  
                    <a href="<?php echo FunctionsV3::clearSearchParams('filter_minimum')?>" class="pull-right" >Clear</a>
                    <?php endif;?> 
                    </h5> 
				    <?php if ( $minimum_list=FunctionsV3::minimumDeliveryFee()):?>
                        <ul class="<?php echo $fc==2?"hide":''?>">
                         <?php foreach ($minimum_list as $key=>$val):?>
                          <li> <?php echo str_replace("<","", $val);?>
                            <input type="radio" value="<?php echo $key; ?>" class="filter_minimum"  
                            <?php if($filter_minimum==$key) echo 'checked="checked"'; ?>
                            onclick="research_merchant();"  name="mate_name">
                          </li>   
                         <?php endforeach;?> 
                       </ul> 
                    <?php endif;?>  
				</div>  
                <?php } ?>
			</div>
			</div>
            <div class="col-md-9 col-sm-8">
            <div class="row">
            <?php echo CHtml::hiddenField('sort_filter',$sort_filter)?>
            <?php echo CHtml::hiddenField('display_type',$display_type)?>  
            <?php if ($data):
			
			//print_r($data); exit;
			?>
	             <?php foreach ($data['list'] as $val): 
 						 $merchant_id=$val['merchant_id'];             
						 $ratings=Yii::app()->functions->getRatings($merchant_id);   
						 /*get the distance from client address to merchant Address*/             
						 $distance_type=FunctionsV3::getMerchantDistanceType($merchant_id); 
						 $distance_type_orig=$distance_type;
						 /*dump("c lat=>".$data['client']['lat']);         
						 dump("c lng=>".$data['client']['long']);	             
						 dump("m lat=>".$val['latitude']);
						 dump("c lng=>".$val['lontitude']);*/
						 $distance=FunctionsV3::getDistanceBetweenPlot(
							$data['client']['lat'],$data['client']['long'],
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
									  $distance_type_raw);
										 
						 if ( $display_type=="listview"){
							 $this->renderPartial('/front/search-list-2',array(
							   'data'=>$data,
							   'val'=>$val,
							   'merchant_id'=>$merchant_id,
							   'ratings'=>$ratings,
							   'distance_type'=>$distance_type,
							   'distance_type_orig'=>$distance_type_orig,
							   'distance'=>$distance,
							   'merchant_delivery_distance'=>$merchant_delivery_distance,
							   'delivery_fee'=>$delivery_fee
							 ));
						 } else {
							 $this->renderPartial('/front/search-list-1',array(
							   'data'=>$data,
							   'val'=>$val,
							   'merchant_id'=>$merchant_id,
							   'ratings'=>$ratings,
							   'distance_type'=>$distance_type,
							   'distance_type_orig'=>$distance_type_orig,
							   'distance'=>$distance,
							   'merchant_delivery_distance'=>$merchant_delivery_distance,
							   'delivery_fee'=>$delivery_fee
							 ));
						 }
			       endforeach;   
                 else : ?>
				<div class="alert alert-danger text-center">
					<?php echo t("No results with your selected filters")?>
				</div>
                 <?php endif;?>   
                 <div class="search-result-loader">
                     <span></span>
                    <p><?php echo t("Loading more restaurant...")?></p>
                 </div>
                 <?php if($data['total']>0)
                 { ?>
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					 <?php                                              
                     require_once('pagination.class.php'); 
                     $attributes                 = array();
                     $attributes['wrapper']      = array('id'=>'pagination','class'=>'pagination');			 
                     $options                    = array();
                     $options['attributes']      = $attributes;
                     $options['items_per_page']  = FunctionsV3::getPerPage();
                     $options['maxpages']        = 10;
                     $options['jumpers']         = false;
                     $options['link_url']        = $current_page_link.'&page=##ID##';			
                     $pagination                 = new pagination( $data['total'] ,((isset($_GET['page'])) ? $_GET['page']:1),$options);		
                     $data                       = $pagination->render();
                     ?>    
                 </div>
                 <?php } 

                 if (!isset($current_page_url)){
                        $current_page_url = '';
                     }                      
                     echo CHtml::hiddenField('current_page_url',$current_page_url);

                 ?>
 			   </div>
 			   </div>
			</div>
		</div>
	</div>
</div>