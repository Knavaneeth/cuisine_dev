<?php 
require_once 'fbConfig.php';
$this->renderPartial('/front/default-header',array(
   'h1'=>t("Login & Signup"),
   'sub_text'=>t("sign up to start ordering")
));   
echo CHtml::hiddenField('mobile_country_code',Yii::app()->functions->getAdminCountrySet(true));
?> 
<div class="page-content signup-page">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="well-box login-form">
					<h2 class="block-title-2">Login</h2>
					<form id="forms" class="forms" method="POST">
                      <?php echo CHtml::hiddenField('action','clientLogin')?>
					  <?php echo CHtml::hiddenField('currentController','store')?>     
                      <?php if ($google_login_enabled==2 || $fb_flag==2 ) :?>
                      <?php if ( $fb_flag==2):?>
                        <!--  <a href="javascript:fbcheckLogin();" class="fb-button orange-button medium rounded">   -->

                        <?php

							if (isset($accessToken))
								{
								if (isset($_SESSION['facebook_access_token']))
									{
									$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
									}
								  else
									{

									// Put short-lived access token in session

									$_SESSION['facebook_access_token'] = (string)$accessToken;

									// OAuth 2.0 client handler helps to manage access tokens

									$oAuth2Client = $fb->getOAuth2Client();

									// Exchanges a short-lived access token for a long-lived one

									$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
									$_SESSION['facebook_access_token'] = (string)$longLivedAccessToken;

									// Set default access token to be used in script

									$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
									}

								// Redirect the user back to the same page if url has "code" parameter in query string

								if (isset($_GET['code']))
									{
									header('Location: ./');
									}

								// Getting user facebook profile info

								try
									{
										$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
										$fbUserProfile = $profileRequest->getGraphNode()->asArray();									 
									}

								catch(FacebookResponseException $e)
									{
									echo 'Graph returned an error: ' . $e->getMessage();
									session_destroy();

									// Redirect user back to app login page

									header("Location: ./");
									exit;
									}

								catch(FacebookSDKException $e)
									{
									echo 'Facebook SDK returned an error: ' . $e->getMessage();
									exit;
									}

								// Initialize User class
								//	$user = new User();
								// Insert or update user data to the database

									$fbUserData = array(
										'oauth_provider' => 'facebook',
										'oauth_uid' => $fbUserProfile['id'],
										'first_name' => $fbUserProfile['first_name'],
										'last_name' => $fbUserProfile['last_name'],
										'email' => $fbUserProfile['email'],
										'gender' => $fbUserProfile['gender'],
										'locale' => $fbUserProfile['locale'],
										'picture' => $fbUserProfile['picture']['url'],
										'link' => $fbUserProfile['link']
									);
									 
									$userData = Yii::app()->functions->checkUser($fbUserProfile['email']);
									$_SESSION['FBID'] = $fbUserProfile['id'];           
								    $_SESSION['FULLNAME'] = $fbUserProfile['first_name']." ".$fbUserProfile['last_name'];
							        if($femail!='')
							        {
							        	$_SESSION['FACEBOOK_EMAIL'] =  $fbUserProfile['email'];  
							        }
									else
								    {
								        $_SESSION['FACEBOOK_EMAIL'] =  $fbUserProfile['first_name']."_".$fbUserProfile['last_name']."@facebook.com";
								    }
								    $_SESSION['first_name'] = $fbUserProfile['first_name'];
								    $_SESSION['last_name'] =  $fbUserProfile['last_name'];
								    $_SESSION['fb_login'] = "true";
							        $location = "https://www.cuisine.je/";     
  									header("Location: ".$location);
								}
							  else
								{
							//	print_r($fbPermissions);

								$loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);

								// Render facebook login button

								// $output = '<a href="' . htmlspecialchars($loginURL) . '"><img src="images/fblogin-btn.png"></a>'; ?>

							<!--	<a href="<?php echo htmlspecialchars($loginURL); ?>" class="fb-button orange-button medium rounded">
		                           <i class="ion-social-facebook"></i><?php echo t("login with Facebook")?>
		                        </a>  -->

							<?php	}

							?>

                    <!--    <a href="https://www.cuisine.je/facebook_login/fbconfig.php" class="fb-button orange-button medium rounded">
                           <i class="ion-social-facebook"></i><?php echo t("login with Facebook")?>
                        </a>  -->
                      <?php endif;?> 
                      <?php if ($google_login_enabled==2):?>
                          <div class="top10"></div>
                          <a href="<?php echo Yii::app()->createUrl('/store/googleLogin')?>" 
                          class="google-button orange-button medium rounded">
                            <i class="ion-social-googleplus-outline"></i><?php echo t("Sign in with Google")?>
                          </a> 
                      <?php endif;?>
                        <!--    <div class="login-or">
                          	<span><?php echo t("Or")?></span>  
                          </div> -->
                      <?php endif;?>
						<div class="form-group">
							<label class="control-label" for="email">E-mail<span class="required">*</span></label>
                            <?php echo CHtml::textField('username','',
							array('class'=>'form-control',
							'placeholder'=>t("Email"),
						    'required'=>true,
						    'data-validation'=>"email"
						    ))?> 
						</div>
						<div class="form-group">
							<label class="control-label" for="password">Password<span class="required">*</span></label>
							<?php echo CHtml::passwordField('password','',
							array('class'=>'form-control',
							'placeholder'=>t("Password"),
						   'required'=>true
						    ))?>
						</div>
                        <?php if ($captcha_customer_login==2):?>
                           <div class="top10">
                             <div id="kapcha-1"></div>
                           </div>
                        <?php endif;?> 
						<div class="form-group mb-0">
							<button type="submit" id="submit" name="submit" class="btn btn-primary">Login</button>
                            <a href="javascript:;" class="forgot-pass-link2 pull-right">
							 <?php echo t("Forgot Password?");?>
                            </a>  
						</div>
					</form>
				</div>
				<div class="section-forgotpass well-box forgot-pwd-form " style="display:none">
					<h2 class="block-title-2">Forgot Password</h2>
                        <form id="frm-modal-forgotpass" class="frm-modal-forgotpass" method="POST" onsubmit="return false;" >
                        <?php echo CHtml::hiddenField('action','forgotPassword')?>
                        <?php echo CHtml::hiddenField('do-action', isset($_GET['do-action'])?$_GET['do-action']:'' )?>
						<div class="form-group">
							<?php echo CHtml::textField('username-email','',
							  array('class'=>'form-control',
							  'placeholder'=>t("Email address"),
						      'required'=>true,
						      'data-validation'=>"email"
						     ))?>
						</div>
						<div class="form-group mb-0">
							<button type="submit" id="submit" name="submit" class="btn btn-primary">Reset Password</button> 
                            <a href="javascript:;" onclick="$('.section-forgotpass').fadeOut();" class="pull-right forgot-close">Close</a>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="well-box signup-form">
					<h2 class="block-title-2">Sign Up</h2>
					<form id="form-signup" class="form-signup uk-panel uk-panel-box uk-form" method="POST">
						<?php echo CHtml::hiddenField('action','clientRegistrationModal')?>
                        <?php echo CHtml::hiddenField('currentController','store')?>
                        <?php echo CHtml::hiddenField('single_page',2)?>    
                        <?php 
                        $verification=Yii::app()->functions->getOptionAdmin("website_enabled_mobile_verification");	    
                        if ( $verification=="yes"){
                            echo CHtml::hiddenField('verification',$verification);
                        }
                        if (getOptionA('theme_enabled_email_verification')==2){
                            echo CHtml::hiddenField('theme_enabled_email_verification',2);
                        }
                        ?>
						<div class="form-group">
							<?php echo CHtml::textField('first_name','',
							array('class'=>'form-control name_validation',
							'placeholder'=>t("First Name"),
						    'required'=>true,
						    'data-validation'=>"length",
						    'data-validation-length'=>"min4"               
						   ))?>
						</div>
						<div class="form-group">
							<?php echo CHtml::textField('last_name','',
							array('class'=>'form-control name_validation',
							'placeholder'=>t("Last Name"),
						    'required'=>true,
						    'data-validation'=>"length",
						    'data-validation-length'=>"min1"               
						   ))?> 
						</div>
						<div class="form-group">
							<?php echo CHtml::textField('contact_phone','',
							array('class'=>'form-control mobile_number_val',
							'placeholder'=>t("Mobile"),
						   'required'=>true
						   ))?>
						</div>
						<div class="form-group">
							<?php echo CHtml::textField('email_address','',
							array('class'=>'form-control',
							'placeholder'=>t("Email address"),
						    'required'=>true,
						    'data-validation'=>"email"
						    ))?>
						</div>
						<div class="form-group">
							<?php echo CHtml::passwordField('password','',
							array('class'=>'form-control password_text',
							'placeholder'=>t("Password"),
						   'required'=>true,
						    //'minlength'=>"5" 
						   	    'data-validation'=>"length",
						     'data-validation-length'=>"min8"
						   ))?>
						</div>
						<span class="has-error" id="password_text_err"></span>
						<div class="form-group">
							<?php echo CHtml::passwordField('cpassword','',
							array('class'=>'form-control cpassword_text',
							'placeholder'=>t("Confirm Password"),
						    'required'=>true,
						        'data-validation'=>"length",
						     'data-validation-length'=>"min8"
						    ))?>
						</div>
						<span class="has-error" id="cpassword_text_err"></span>
                         <?php 
						 $FunctionsK=new FunctionsK();
						 $FunctionsK->clientRegistrationCustomFields();
						 ?>  
						 <?php if ($captcha_customer_signup==2):?>         		 
						 <div class="top10">
							 <div id="kapcha-2"></div>
						 </div>
						 <?php endif;?>  
						 <p class="text-muted">By creating an account, you agree to receive sms from vendor.</p>
                         <?php if ($terms_customer=="yes"): ?> 
                         <div class="form-group">
							<div class="checkbox checkbox-success">
								<?php 
                                echo CHtml::checkBox('terms_n_condition',false,array(
                                 'value'=>2,
                                 'class'=>"styled",
                                 'required'=>true
                                ));?>
                                <label class="control-label"> 
                                <?php 
                                  echo " ". t("I Agree To")." <a href=\"$terms_customer_url\" target=\"_blank\">".t("The Terms & Conditions")."</a>";
                                ?>
                                </label>
							</div>
						</div>  
                         <?php endif;;?> 
						<div class="form-group mb-0">
							<button type="submit" id="submit" name="submit" class="btn btn-primary">Create Account</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</div>