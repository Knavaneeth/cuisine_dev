<div class="view-food-item-wrap">
<?php if ( $res=Yii::app()->functions->getReviewsById($this->data['id']) ):?>
<form id="frm-modal-update-review" class="frm-modal-update-review" method="POST" onsubmit="return false;" >
<?php echo CHtml::hiddenField('action','updateReview');?>
<?php echo CHtml::hiddenField('id',$this->data['id']);?>
<?php echo CHtml::hiddenField('web_session_id',$this->data['web_session_id']);?>

<h2 class="block-title-2"><?php echo t("Edit your review")?></h2>
<div class="row">
<div class="col-md-12">
<?php  
 echo CHtml::textArea('review_content',$res['review'],array(
  'class'=>"form-control"
 ));
 ?>
 </div>
</div>
<div class="row food-item-actions mt-10">
  <div class="col-md-6 "></div>
  <div class="col-md-3 ">
  <input type="submit" class="btn btn-primary btn-block" value="<?php echo t("Submit")?>">
  </div>
  <div class="col-md-3">
  <a href="javascript:close_fb();" class="btn btn-danger btn-block" >
  <?php echo t("Cancel")?>
  </a>
  </div>
</div>
</form>
<?php else :?>
 <p class="text-danger"><?php echo t("Error: review not found.")?></p>
<?php endif;?>
</div>
<script type="text/javascript">
$.validate({ 	
    form : '#frm-modal-update-review',    
    onError : function() {      
    },
    onSuccess : function() {     
      form_submit('frm-modal-update-review');
      return false;
    }  
})
</script>