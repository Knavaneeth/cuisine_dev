<div class="feedback-section">
    <div class="review-btn clearfix">
        <a href="javascript:;" class="write-review-new pull-right btn btn-primary">write a review</a>
    </div> 
</div> 
<div class="review-input-wrap mb-10 row">
    <form class="forms" id="forms" onsubmit="return false;">
    <?php echo CHtml::hiddenField('action','addReviews')?>
    <?php echo CHtml::hiddenField('currentController','store')?>
    <?php echo CHtml::hiddenField('merchant-id',$merchant_id)?>
    <?php echo CHtml::hiddenField('initial_review_rating','')?>	        
       <div class="col-md-12 border">
         <div>
         <div class="raty-stars" data-score="5"></div>   
         </div>
         <div>
         <?php echo CHtml::textArea('review_content','',array(
            'required'=>true,
            'class'=>"form-control"
         ))?>
         </div>
         <div class="top10">
            <button class="btn btn-sm btn-success" type="submit"><?php echo t("PUBLISH REVIEW")?></button>
         </div>
       </div>         
    </form>
</div>  
<div class="merchant-review-wrap"></div>