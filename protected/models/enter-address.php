<div class="enter-address">
	<h2 class="block-title-2"><?php echo t("Enter your address below")?></h2>
    <form id="frm-modal-enter-address" class="frm-modal-enter-address" method="POST"  >
        <?php echo CHtml::hiddenField('action','setAddress');?> 
        <?php echo CHtml::hiddenField('web_session_id',
        isset($this->data['web_session_id'])?$this->data['web_session_id']:''
        );	 
		?> 
        <div class="row">
			<div class="col-md-12 ">
				<?php echo CHtml::textField('client_address',isset($_SESSION['kr_search_address'])?$_SESSION['kr_search_address']:''
				,array(
				'class'=>"form-control client_address",
				'data-validation'=>"required"
				))?>
			</div> 
        </div>
        <div class="row food-item-actions mt-10">
			<div class="col-md-9"></div>
			<div class="col-md-3">
				<input type="submit" class="btn btn-primary btn-block" value="<?php echo t("Submit")?>">
			</div>
        </div>
    </form> 
</div>
<script type="text/javascript">
$.validate({ 	
	language : jsLanguageValidator,
	language : jsLanguageValidator,
    form : '#frm-modal-enter-address',    
    onError : function() {  
 
    },
    onSuccess : function() {     
	 
      form_submit('frm-modal-enter-address');
      return false;
    }  
})  
jQuery(document).ready(function() {
	var google_auto_address= $("#google_auto_address").val();	
	if ( google_auto_address =="yes") {		
	} else {
		$("#client_address").geocomplete({
		    country: $("#admin_country_set").val()
		});	
	}
});
</script>
<?php
die();