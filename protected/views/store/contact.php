<?php
/* $this->renderPartial('/front/banner-contact',array(
   'h1'=>t("Contact Us"),
   'sub_text'=>$address." ".$country,
   'contact_phone'=>$contact_phone,
   'contact_email'=>$contact_email
)); */
$sub_text = $address." ".$country;

$fields=yii::app()->functions->getOptionAdmin('contact_field');
if (!empty($fields)){
	$fields=json_decode($fields);
}
?>
<div class="page-content contact-page">
	<div class="container">
		<div class="row row-sm">
			<div class="col-md-8 col-sm-8 col-lg-8 col-xs-6">
				<div class="contact-form">
					<!-- <h2>Leave a Message</h2>
					<p> We are always happy to hear from our clients and visitors, you may contact us anytime  </p> -->
                    <h2> Do you want to talk to us about our services? </h2>
                    <p> For queries on the orders please get in touch with the restaurant. Details available on your order receipt and on Cuisine.je </p>
                     <form class="uk-form uk-form-horizontal forms" id="forms" onsubmit="return false;">   
					 <?php echo CHtml::hiddenField('action','contacUsSubmit')?>
                     <?php echo CHtml::hiddenField('currentController','store')?>
                     <?php if (is_array($fields) && count($fields)>=1):?>
                     <?php foreach ($fields as $val):?>
                     <?php  
                      $placeholder='';
                      $validate_default="required";
                      switch ($val) {
                        case "name":
                            $placeholder="Name";
                            break;
                        case "email":  
                            $placeholder="Email address";
                            $validate_default="email";
                            break;
                        case "phone":  
                            $placeholder="Order ID";
                            break;
                      
                        case "country":  
                            $placeholder="Country";
                            break;
                        case "message":  
                            $placeholder="Message";
                            break;	  	
                        default:
                            break;
                      }
                     ?>			 			 			
                     <?php if ( $val=="message"):?>
                         <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label"><?php echo $placeholder; ?></label>
									 <?php echo CHtml::textArea($val,'',array(
										'placeholder'=>t($placeholder),
										'class'=>'form-control'
									 ))?>
								</div>
							</div>
                        </div> 
                     <?php else :?>
                     <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label"><?php echo $placeholder; ?></label>
									 <?php echo CHtml::textField($val,'',array(
										'placeholder'=>t($placeholder),
										'class'=>'form-control',
										'data-validation'=>$validate_default
									  ))?>
								</div>
							</div>
                        </div> 
                     <?php endif;?> 
                     <?php endforeach;?>
                     <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                        </div>
                     </div> 
                     <?php endif;?>
                     </form> 
				</div>
			</div>
			<div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
				<div class="contact-widget">
                    <h3>Helpline</h3> 
						<strong>Phone number</strong> : <?php echo $contact_phone?>  <br>
						<strong>Email us</strong> : <?php echo $contact_email?>
					</p>
                </div>   <br>
				<div class="contact-widget">
				 <p> For any other enquiries please call or use the form beside. </p>
					<p> 
						<?php if (!empty($sub_text)):?>
                        <?php echo $sub_text?> <br> 
                        <?php endif;?> 
                    </p>
                    <p><?php echo $contact_content?></p>
				</div>
			</div>
		</div>
	</div>
</div>