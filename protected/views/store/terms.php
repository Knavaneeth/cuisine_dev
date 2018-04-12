<?php
/* $this->renderPartial('/front/banner-contact',array(
   'h1'=>t("Contact Us"),
   'sub_text'=>$address." ".$country,
   'contact_phone'=>$contact_phone,
   'contact_email'=>$contact_email
)); 
$sub_text = $address." ".$country;

$fields=yii::app()->functions->getOptionAdmin('contact_field');
if (!empty($fields)){
	$fields=json_decode($fields);
} */
?>
<div class="page-content contact-page">
	<div class="container">
		<div class="row row-sm">
		<!--	<div class="col-md-8 col-sm-8 col-lg-8 col-xs-6">  -->
                <div class=" col-md-12 col-sm-12 col-lg-12 col-xs-12 ">
				<div class="contact-form">
					                
				</div>
			</div>
		<!-- 	<div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
				<div class="contact-widget">
                    <h3>Customer care</h3> 
						<strong>Phone number</strong> : <?php echo $contact_phone?>  <br>
						<strong>Email us</strong> : <?php echo $contact_email?>
					</p>
                </div>   <br>
				<div class="contact-widget">
					<h3>Get in touch</h3>
                    <p> For any other enquiries please give our team a ring or send us an email to admin@cuisine.je or use the form below. </p>
					<p> 
						<?php if (!empty($sub_text)):?>
                        <?php echo $sub_text?> <br> 
                        <?php endif;?> 
                    </p>
                    <p><?php echo $contact_content?></p>
				</div>
			</div> -->
		</div>
	</div>
</div>