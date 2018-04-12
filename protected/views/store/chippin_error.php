<?php 
$this->renderPartial('/front/order-progress-bar',array(
   'step'=>4,
   'show_bar'=>true
));
 ?>

<div class="sections section-grey2 section-orangeform">
  <div class="container">  
    <div class="row top30">
       <div class="inner">
          <h1><?php echo t("Pay using Chip & Pin")?></h1>
          <div class="box-grey rounded">	
          
          <?php if (!empty($error)):?>
           <p class="text-danger"><?php echo $error;?></p>  
          <?php else :?> 
           <p><?php echo t("Please wait while we redirect you to Chip & Pin.")?></p>
          <?php endif;?>
               
          </div> <!--box-->
       </div> <!--inner-->
    </div> <!--row-->
  </div> <!--container-->
</div><!-- sections-->
