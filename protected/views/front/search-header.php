<div class="parallax-header">
	<div class="parallax-bg3 parallax">
		<div class="parallax-wrap2">
			<div class="container"> 
				       <?php if(isset($_GET['book-a-table'])) {  ?>
                <h1> Restaurants for booking a table </h1>
                            <?php } else { ?>
                	<h1>Restaurants delivering</h1> 
                            <?php } ?>	
                <a href="javascript:;" class="btn btn-default" data-toggle="modal" data-target="#location-popup">Change location</a>
			</div>
		</div>
	</div>
</div>
<div id="location-popup" class="modal fade custom-popup location-modal" role="dialog">
	<div class="modal-dialog">
            <div class="searchform clearfix">
                <form method="GET" action="<?php echo Yii::app()->createUrl('store/searcharea')?>">
                  <?php  
                if(isset($_GET['book-a-table']))
                { ?>
                    <input type="hidden" name="book-a-table" id="book-a-table" value=" ">
                 <?php  }
                ?>
					<div class="top-input input-middle">
						<div class="choose-parish">
							<span class="eat">Your Parish</span>
						</div>
						<div class="post-code">
							<?php echo CHtml::dropDownList('parish',
							isset($data['parish'])?$data['parish']:"",
							(array)Yii::app()->functions->ParishListMerchant('Choose Parish'),          
							array(
							'class'=>'form-control' 
							))?>
						</div>
						<input name="zipcode" class="form-control" placeholder="Enter your post code" type="hidden">
					</div> 
                    <div class="top-input input-middle">
                         <div class="choose-parish">
                            <span class="eat">Your cuisine</span>
                        </div>
                        <div class="post-code">
                            <select class="form-control" name="filter_cuisine">
                                <option value="">All Categories</option> 
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
                </form>
            </div>
		</div>
	</div>
</div>