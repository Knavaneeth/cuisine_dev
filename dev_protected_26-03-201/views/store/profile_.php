<?php
$this->renderPartial('/front/default-header',array(
   'h1'=>t("Profile"),
   'sub_text'=>t("Manage your profile,address book, credit card and more")
));
echo CHtml::hiddenField('mobile_country_code',Yii::app()->functions->getAdminCountrySet(true));
?> 
 <div class="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="profile-widget">
					<!--<div class="profile-img">
                        <div class="avatar-img-appnd">
							<img alt="" src="<?php echo $avatar;?>" class="img-responsive img-circle" width="150" height="150">
						</div>
                        <div class="caption">
							<span>
								<a class="btn btn-primary btn-xs" href="javascript:;" id="uploadavatar">
                                	<i class="fa fa-plus"></i>
                                </a>
							</span>
						</div>
					</div>-->
                    
                    
                    
                <div id="crop-avatar">                	
                    <div id="profile-avatar"> 
                        <div class="avatar-view" id="img_view" title="Click to change picture">
                        <?php      
                        $uploadPath = Yii::getPathOfAlias('webroot'); 
                        $image =  baseUrl().'assets/images/default_user_lg.jpg' ;
							if(!empty($avatar))
							{
								$image = $avatar;
							}                               
						?>
                      	<img src="<?php echo $image; ?>" alt="Avatar" class="img-responsive img-circle profile_img" width="150" height="150">
                        <input type="hidden" name="hidden_image_value" id="hidden_image_value" value="<?php echo $image; ?>" />
                     	</div>        			 
                     	<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                	</div> 
                <!-- Cropping modal -->
                <div class="modal custom-modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form class="avatar-form" action="<?php echo baseUrl().'/cropping/prf_crop';?>" enctype="multipart/form-data" method="post">
                        <div class="modal-header">
                          <button class="close" data-dismiss="modal" type="button">&times;</button>
                          <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                        </div>
                        <div class="modal-body">
                          <div class="avatar-body">
            
                            <!-- Upload image and data -->
                            <div class="avatar-upload">
                              <input class="avatar-src" name="avatar_src" type="hidden">
                              <input class="avatar-data" name="avatar_data" type="hidden">
                              <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                            </div>
				            <input type="file" id="default_image" value="<?php echo $image; ?>" style="display:none">
                            <!-- Crop and preview -->
                            <div class="row">
                              <div class="col-md-12">
                                <div class="avatar-wrapper">                            
                                
                                </div>
                              </div>
                            </div>
                             <div class="row avatar-btns"> 
                              <div class="col-md-3 pull-right">
                                <button class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
                              </div>
                            </div>
                          </div>
                        </div> 
                      </form>
                    </div>
                  </div>
                </div><!-- /.modal -->
                 <!-- Loading state -->
                <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div> 
            
		</div>
                    
                    
                    
					<div class="text-center">
						<h3 class="username"><?php echo $info['first_name'].' '.$info['last_name']; ?> </h3>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-12">
						<div class="custom-tab">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#profile_tab" data-toggle="tab">Profile</a></li>
								<li><a href="#address_book" data-toggle="tab">Address Book</a></li>
								<li><a href="#order_history" data-toggle="tab">Order History</a></li>
								<li><a href="#credit_cards" data-toggle="tab">Credit Cards</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="profile_tab">
									<div class="panel">
										<div class="panel-body">
                                            <?php $this->renderPartial('/front/profile',array('data'=>$info));?>
 										</div>
									</div>
								</div>
								<div class="tab-pane" id="address_book">
									<div class="panel panel-flat">
                                        <?php $this->renderPartial('/front/address-book',array(
										   'client_id'=>Yii::app()->functions->getClientId(),
										   'data'=>Yii::app()->functions->getAddressBookByID( isset($_GET['id'])?$_GET['id']:'' ),
										   'tabs'=>$tabs
										));?> 
									</div>
								</div>
								<div id="order_history" class="tab-pane">
									<div class="panel panel-flat">
										<div class="panel-heading">
											<h5 class="panel-title">Your Recent Order</h5>
										</div>
										<div class="panel-body">
											<div class="table-responsive">
                                                <?php $this->renderPartial('/front/order-history',array(           
												   'data'=>Yii::app()->functions->clientHistyOrder( Yii::app()->functions->getClientId() )
												 ));?> 
											</div>
										</div>
									</div>
								</div>									
								<div id="credit_cards" class="tab-pane">
									<div class="panel panel-flat">
										<div class="panel-heading">
											<button type="button" class="btn btn-primary clientcc_add_btn" tbl_id="0">Add New</button>
										</div>
										<div class="panel-body">
											<div class="table-responsive">
                                                <?php
												$this->renderPartial('/front/manage-credit-card',array(
												   'tabs'=>$tabs
											    ));  
												?> 
											</div>
										</div>
									</div>
								</div>
								<div id="add_address" class="modal custom-modal fade" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Add Address Details</h4>
											</div>
											<div class="modal-body" id="add_address_form_appnd">
												 <form id="frm-addressbook" class="frm-addressbook" onsubmit="return false;">
													 <?php echo CHtml::hiddenField('action','addAddressBook')?>
                                                     <?php echo CHtml::hiddenField('currentController','store')?>  
                                                     <?php echo CHtml::hiddenField('add_tbl_update_id','')?>  
                                                     <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo t("Address")?></label>
                                                                <?php 
                                                                  echo CHtml::textField('street','',
																  array(
                                                                   'class'=>'form-control',
                                                                   'data-validation'=>"required"  
                                                                  ))?> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo t("City")?></label>
                                                                <?php echo CHtml::textField('city',
                                                                  ''
                                                                  ,array(
                                                                   'class'=>'form-control',   
                                                                   'data-validation'=>"required"  
                                                                  ))?>	 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo t("State")?></label>
                                                                <?php echo CHtml::textField('state',
                                                                  ''
                                                                  ,array(
                                                                   'class'=>'form-control',           
                                                                   'data-validation'=>"required"  
                                                                  ))?> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo t("Zip code")?></label>
                                                                <?php echo CHtml::textField('zipcode',
                                                                  ''
                                                                  ,array(
                                                                   'class'=>'form-control',           
                                                                   'data-validation'=>"required"  
                                                                  ))?> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo t("Location Name")?></label>
                                                                <?php echo CHtml::textField('location_name',
                                                                  ''
                                                                  ,array(
                                                                   'class'=>'form-control',           
                                                                  ))?> 
                                                            </div>
                                                        </div>
                                                        <?php $merchant_default_country=Yii::app()->functions->getOptionAdmin('merchant_default_country'); ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo t("Country")?></label>
                                                                <?php 
                                                                  echo CHtml::dropDownList('country_code',
                                                                  ''
                                                                  ,(array)Yii::app()->functions->CountryListMerchant(),array(
                                                                    'class'=>'form-control',
                                                                    'data-validation'=>"required"  
                                                                  ));
                                                                  ?> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?php 
                                                                  echo CHtml::checkBox('as_default',
                                                                  $data['as_default']==2?true:false
                                                                  ,array('class'=>"icheck",'value'=>2));
                                                                  echo " ".t("Default");
                                                                  ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary btn-block addr_save_btn"><?php echo t("Submit")?></button>
                                                        </div>
                                                    </div>
                                                </form> 
											</div>
										</div>
									</div>
								</div> 
								<div id="addnew_card" class="modal custom-modal fade" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Credit Card Details</h4>
											</div>
											<div class="modal-body">
                                                    <form class="krms-forms" id="frm-cc"  onsubmit="return false;">
                                                    <?php echo CHtml::hiddenField('action','updateClientCC')?>
                                                    <?php 
                                                    if (isset($data['cc_id'])){
                                                        echo CHtml::hiddenField('cc_id', $data['cc_id']);
                                                    }?>
                                                    <?php echo CHtml::hiddenField('addcc_tbl_update_id','')?> 
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Card Name</label>
                                                                <?php 
																  echo CHtml::textField('card_name',isset($data['card_name'])?$data['card_name']:'',
																  array(
																	'class'=>'form-control',
																	'data-validation'=>"required"
																  ));
																 ?>  
																<!--<input class="form-control" type="text">-->
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Credit Card Number</label>
                                                                <?php 
																echo CHtml::textField('credit_card_number',
																isset($data['credit_card_number'])?$data['credit_card_number']:''
																,
																array(
																'class'=>'form-control numeric_only',
																'data-validation'=>"required",
																'maxlength'=>16
																));
																?>
																<!--<input class="form-control" type="text">-->
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Exp. month</label>
                                                                <?php echo CHtml::dropDownList('expiration_month',
																  isset($data['expiration_month'])?$data['expiration_month']:''
																 , 
																  Yii::app()->functions->ccExpirationMonth()
																  ,array(
																   'class'=>'form-control',
																   'placeholder'=>Yii::t("default","Exp. month"),
																   'data-validation'=>"required"  
																  ))?>
																<!--<select class="form-control">
																	<option>1</option>
																	<option>2</option>
																	<option>3</option>
																	<option>4</option>
																</select>-->
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Exp. year</label>
                                                                <?php echo CHtml::dropDownList('expiration_yr',
																   isset($data['expiration_yr'])?$data['expiration_yr']:''
																   ,
																	  Yii::app()->functions->ccExpirationYear()
																	  ,array(
																	   'class'=>'form-control',
																	   'placeholder'=>Yii::t("default","Exp. year") ,
																	   'data-validation'=>"required"  
																	  ))?>
																<!--<select class="form-control">
																	<option>1</option>
																	<option>2</option>
																	<option>3</option>
																	<option>4</option>
																</select>-->
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Billing Address</label>
                                                                <?php 
																  echo CHtml::textField('billing_address',isset($data['billing_address'])?$data['billing_address']:'',
																  array(
																	'class'=>'form-control',
																	'data-validation'=>"required"
																  ));
																  ?>     
																<!--<input class="form-control" type="text">-->
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>CVV</label>
                                                                <?php 
																echo CHtml::textField('cvv',
																isset($data['cvv'])?$data['cvv']:''
																,
																array(
																'class'=>'form-control',
																'data-validation'=>"required"
																));
																?>
																<!--<input class="form-control" type="text">-->
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-3">
															<button type="submit" class="btn btn-primary btn-block ccaddbtn">Save</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								 
								<div id="order_details" class="modal custom-modal order-det-popup fade" role="dialog">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Order Details</h4>
											</div>
											<div class="modal-body" id="order_details_appnd">
												 
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>