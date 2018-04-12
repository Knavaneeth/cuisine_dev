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
			<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
				<div class="contact-form">
					<!-- <h2>Leave a Message</h2>
					<p> We are always happy to hear from our clients and visitors, you may contact us anytime  </p> -->









<h1> We guarantee you’ll pay the same price for a delivery meal ordered on Cuisine.Je as you would ordering from the restaurant direct*. </h1>

<p> So, if your order from Cuisine.Je is advertised by the restaurant for less somewhere else (such as in a takeaway menu or on their own website, for example) then we’ll send you double the difference in the form of a Cuisine.Je voucher. </p>

<p> That’s our Price Promise to you.

<p> Making a claim couldn’t be easier. Simply pop your Cuisine.Je order number into the form below and upload any links or photos that show your order’s been advertised by the restaurant cheaper elsewhere. We’ll get in touch with you within five working days to sort everything out. It’s as easy as that!

<p>* Excludes card payment, delivery and or any other fees, special offers, collection and dine in orders (if you place a collection order on Cuisine.Je or order directly with the restaurant and collect your order from the restaurant or eat/dine in at the restaurant). Price Promise claims must be made within 14 days of the date of the relevant order.

<h1> Submit a Price Promise claim </h1>



  <!-- <form class="uk-form uk-form-horizontal forms" id="forms" onsubmit="return false;" enctype="multipart/form-data">    -->
  <form class="uk-form uk-form-horizontal" action="<?php echo  Yii::app()->createUrl('/store/price_promise'); ?>" method="POST" enctype="multipart/form-data">   
                     <?php echo CHtml::hiddenField('action','price_promise')?>
                     <?php echo CHtml::hiddenField('currentController','store')?>

                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Your email address registered with Cuisine.Je  <span class="required_class">*</span> </label>
                                     <?php echo CHtml::textField('email_address',''
                                     ,array(
                                     'class'=>'form-control',
                                       'placeholder'=>Yii::t("default","Email address"),
                                       'data-validation'=>"email"
                                      ))?>
                                </div>
                            </div>
                    </div> 


                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Restaurant name <span class="required_class">*</span> </label>
                                     <?php echo CHtml::textField('restaurant_name',''
                                     ,array(
                                     'class'=>'form-control',
                                       'placeholder'=>Yii::t("default","Restaurant name"),
                                       'data-validation'=>"required"
                                      ))?>
                                </div>
                            </div>
                    </div> 


                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Order number <span class="required_class">*</span> </label>
                                     <?php echo CHtml::textField('order_number',''
                                     ,array(
                                     'class'=>'form-control',
                                       'placeholder'=>Yii::t("default","Order number"),
                                       'data-validation'=>"required"
                                      ))?>
                                </div>
                            </div>
                    </div> 


                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tell us what happened  <span class="required_class">*</span> </label>
                                     <?php echo CHtml::textArea('comments',''
                                     ,array(
                                     'class'=>'form-control',
                                       'placeholder'=>Yii::t("default","Tell us what happened"),
                                       'data-validation'=>"required"
                                      ))?>
                                </div>
                            </div>
                    </div> 

                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"> Attachments </label>
                                     <?php echo CHtml::fileField('attachments',''
                                     ,array(
                                     'class'=>'form-control',                                       
                                       'data-validation'=>""
                                      ))?>
                                </div>
                            </div>
                    </div>                                 

                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"> To help us process your claim, please upload any photo evidence to show your order advertised by the restaurant cheaper elsewhere. </label>                                     
                                </div>
                            </div>
                    </div>                                 

                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <?php echo CHtml::checkBox('accept_terms',''
                                     ,array(
                                     'class'=>'form-control accept_claims_terms_conditions',                                       
                                       'data-validation'=>"required"
                                      ))?>
                                    <label class="control-label"> I accept the Price Promise Terms and Conditions <span class="required_class">*</span> </label>                                     
                                </div>
                            </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">claim</button>
                        </div>
                     </div> 
                     
                     </form>  

<br /><br />
<h1> Price Promise Terms and Conditions </h1>
<h3> Important Legal Notice </h3>

<p> These Cuisine.Je price promise Terms and Conditions("Cuisine.Je Price Promise Terms") are supplemental to and should be read in conjuction with the Cuisine.Je website terms and conditions (“Cuisine.Je Website Terms”) In the event of any conflict between these Cuisine.Je Price Promise Terms and the Cuisine.Je Website Terms, the latter shall prevail. </p>

<p> These Cuisine.Je Price Promise Terms set out the terms and conditions relating to the Cuisine.Je price promise (“Cuisine.Je Price Promise”). Please read these Cuisine.Je Price Promise Terms carefully before claiming on the Cuisine.Je Price Promise. By claiming on the Cuisine.Je Price Promise (whether now or in the future), you agree to be bound by these Cuisine.Je Price Promise Terms.</p>

<p> We reserve the right to change these Cuisine.Je Price Promise Terms from time to time by changing them on this page. We advise you to print a copy of these Cuisine.Je Price Promise Terms for future reference. These Cuisine.Je Price Promise Terms are only in the English language. Use of your personal information submitted via the Cuisine.Je Price Promise is governed by our  Privacy Policy and Cookies Policy .</p>

<h3> Conditions of the Cuisine.Je Price Promise </h3>
<p> 1.  The Cuisine.Je Price Promise is available in respect of orders made at any time after 15th October, 2017.</p>
<p> 2.  In order to claim on the Cuisine.Je Price Promise (a “Cuisine.Je Price Promise Claim”), you must complete and submit a Cuisine.Je Price Promise Claim Form with a copy of the current Restaurant Menu or a link to the website where the Restaurant's Menu is available.</p>
<p> 3.  Cuisine.Je Price Promise Claims may only be submitted against Menu Items that you have ordered on the Cuisine.Je website and will not be valid in respect of delivery charges, special offers or discounts offered by restaurants. Your order must have been completed, paid for and delivered.</p>
<p> 4.  Your order must have been completed, paid for and delivered.</p>
<p> 5.  Cuisine.Je Price Promise Claims must be submitted within 15 days of the relevant order.</p>
<p> 6.  Each Customer may make a maximum of one Cuisine.Je Price Promise Claim per Restaurant in any 30 day period.</p>
<p> 7.  We will investigate each Cuisine.Je Price Promise Claim and reserve the right to confirm with the Restaurant whether the Restaurant Menus submitted are valid.</p>
<p> 8.  Following our investigation, we will decide whether a Cuisine.Je Price Promise Claim is valid and notify you of our decision. Our decision is final and binding in all matters relating to the Cuisine.Je Price Promise.</p>
<p> 9.  We will aim to process Cuisine.Je Price Promise Claims within five working days of receipt of a Cuisine.Je Price Promise Claim Form.</p>
<p> 10. In the event of we approve your Cuisine.Je Price Promise Claim, we shall offer you a Cuisine.Je voucher code with a value of at least double the difference between the two menu prices.</p>
<p> 11. The Cuisine.Je vouchers code are subject to the Cuisine.Je Voucher Terms and Conditions. Vouchers will expire after 30 days. No replacements will be provided once the voucher has expired.</p>
<p> 12. We reserve the right to withdraw the Cuisine.Je Price Promise at any time without prior written notice and/or to alter or amend these Cuisine.Je Price Promise Terms at any time.</p>
<p> 13. By Completing a Cuisine.Je Price Promise Claim Form you will be deemed to have accepted these Cuisine.Je Price Promise Terms.</p>
<p> 14. These Price Promise Terms shall be governed by the laws of England and Wales and are subject to the exclusive jurisdiction of the English courts.</p>































                    
                   
				</div>
			</div> 
		</div>
	</div>
</div>