<?php if (is_array($gallery) && count($gallery)>=1):?>
<div class="panel">
    <div class="panel-body">
          <div class="gallery-sec"> 
            <div id="photos" class="merchant-gallery-wrap">
            <?php foreach ($gallery as $val):?>
            <a href="<?php echo uploadURL()."/".$val?>" title="" class="gallery-img">
              <img src="<?php echo uploadURL()."/".$val?>" alt="">
            </a>
            <?php endforeach;?>	  
            </div> 
          </div>  
    </div>
</div>
<?php else :?>
  <div class="text-center alert alert-danger mb-0"> <?php echo t("Gallery not available")?> </div>
<?php endif;?> 
<?php /* if (is_array($gallery) && count($gallery)>=1):?>
    <div class="row" id="photos">
   <?php foreach ($gallery as $val):?>
            <div class="col-md-3">
                <a href="<?php echo uploadURL()."/".$val?>">
                    <img src="<?php echo uploadURL()."/".$val?>" alt="" class="img-responsive">
                </a>
            </div> 
	<?php endforeach;?>	  
	</div>
 <?php else :?>
  <p class="text-danger"><?php echo t("gallery not available")?></p>
 <?php endif;*/?> 

 
