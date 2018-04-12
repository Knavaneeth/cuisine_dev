<header class="header">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-lg-3 col-sm-3 col-xs-3 logo hidden-xs">
            <?php if ( $theme_hide_logo<>2):?>
				<div class="navbar-brand"> 
                    <a href="/">
                        <img src="<?php echo FunctionsV3::getDesktopLogo();?>" alt="Logo" class="img-responsive" width="163" height="40">
                    </a>
                </div>
            <?php endif;?>
			<div class="app-icons">
				<ul>
				<li><a href="<?php  echo getOptionA('theme_app_ios'); ?>" target="_blank"><img src="<?php echo  Yii::app()->request->baseUrl; ?>/assets/images/apple-icon.png" alt="Download from Appstore" title="Cuisine in your pocket , download from App Store" width="29" height="29"></a></li>
				<li><a href="<?php echo getOptionA('theme_app_android'); ?>" target="_blank"><img src="<?php echo  Yii::app()->request->baseUrl; ?>/assets/images/android-icon.png" alt="Play Store" title="Cuisine in your pocket , download from Play Store" width="29" height="29"></a></li>  
				</ul>
			</div>
			</div>
			<?php if ( Yii::app()->controller->action->id =="menu"):?>
			<div class="col-xs-1 cart-mobile-handle border relative">
				<a href="javascript:;"><i class="ion-ios-cart"></i></a>
			</div>
			<?php endif;?>
			<div class="col-md-9 col-lg-9 col-sm-9 col-xs-12 menu-section">
				<div class="navigation">
					<div class="menu-button">
						<a href="/">
							<img src="<?php echo FunctionsV3::getMobileLogo();?>" class="logo-mobile img-responsive" alt="Logo">
						</a>
					</div>
					<ul data-breakpoint="767" class="flexnav">
						<li class="active"><a href="/">Home</a></li>
						<?php 
						$enabled_commission=getOptionA('admin_commission_enabled');		
						$signup_link="/merchantsignup";
						if ($enabled_commission=="yes"){
						   $signup_link="/merchantsignupselection";	
						}?>
						<li class="takeaway-btn"><a class="btn btn-success" href="<?php echo Yii::app()->getBaseUrl(true); ?>/searcharea?parish=0&zipcode=&filter_cuisine=">Take Away</a></li>
						<?php $admin_permission = FunctionsV3::chk_admin_tbl_sts();  if($admin_permission[0]['option_value']!=2) {  ?>
						<li class="book-table"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('/searcharea/?book-a-table=')?>">Book a Table</a></li>
                        <?php } 
                        if(isset($_SESSION['basket-url']))
                        {
                        	$basket_url = $_SESSION['basket-url'];
                        }
                        else
                        {
                        	$basket_url = Yii::app()->baseUrl."/searcharea?parish=0&zipcode=&filter_cuisine=";	
                        }
                        ?>
                        <li><a href="<?php echo $basket_url ; ?>"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart </a></li>  
						<li class="deals-menu"> 
							<a href="<?php echo Yii::app()->createUrl('/deals')?>">Deals</a>
                        </li>
                        <?php if (Yii::app()->functions->isClientLogin()){ 
						   $avatar_img = FunctionsV3::getAvatar( Yii::app()->functions->getClientId());
						   $rand  = rand(100,999);
						?> 
                        <li class="user-menu">
                            <a href="<?php echo Yii::app()->createUrl('/profile')?>">
                            <!-- <img src="<?php echo $avatar_img.'?random='.$rand; ?>" alt="" width="28" height="28" class="img-circle">-->
                            	<?php if(isset($_SESSION['kr_client']['first_name'])&&!empty($_SESSION['kr_client']['first_name'])) { ?>
                            	<span id="client-name"> Hi <?php echo $_SESSION['kr_client']['first_name']." !";?> </span>
                            	<?php } ?>
                            </a>
							<ul>
								<li><a href="<?php echo Yii::app()->createUrl('/profile')?>">My profile</a></li>
								<li><a href="<?php echo Yii::app()->createUrl('/profile?val=order')?>">My Orders</a></li>
								<li><a href="<?php echo Yii::app()->createUrl('/profile?val=booking_order')?>">My Bookings</a></li>
								<li><a href="<?php echo Yii::app()->createUrl('/logout')?>">Logout</a></li>
							</ul>
						</li>
						<?php }else{ ?>
						<li> 
							<a href="<?php echo Yii::app()->createUrl('/signup')?>">Log In</a>
                        </li>
                        <?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>    
<?php  if (!Yii::app()->functions->isClientLogin()){
} ?>