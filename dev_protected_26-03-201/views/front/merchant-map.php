<div>
  <div id="merchant-map"></div>	          
  <div class="row mt-10 direction-action">
    <div class="col-md-6">
       <?php echo CHtml::textField('origin',
       isset($_SESSION['kr_search_address'])?$_SESSION['kr_search_address']:''
       ,array('class'=>'form-control'))?>
    </div>
    <div class="col-md-3">
        <?php echo CHtml::dropDownList('travel_mode','',
        Yii::app()->functions->travelMmode()
         ,array('class'=>'form-control'))?>
    </div>
    <div class="col-md-3">
       <input type="button" 
       class="get_direction_btn btn btn-primary btn-block" 
       value="<?php echo t("Get directions")?>">
    </div>
  </div> 
</div>
<div class="direction_output" id="direction_output"></div>	       