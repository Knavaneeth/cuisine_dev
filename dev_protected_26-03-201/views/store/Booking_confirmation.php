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
          <h1><?php echo t("Thank You")?></h1>
          <div class="box-grey rounded">	         
           
           <p><?php echo t("Please await confirmation from the Restaurant.")?></p>
           
               
          </div> <!--box-->
       </div> <!--inner-->
    </div> <!--row-->
  </div> <!--container-->
</div><!-- sections-->
