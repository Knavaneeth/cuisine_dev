<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />
<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/assets/images/fav.png" type="image/x-icon">
<link href='//fonts.googleapis.com/css?family=Open+Sans|Podkova|Rosario|Abel|PT+Sans|Source+Sans+Pro:400,600,300|Roboto' rel='stylesheet' type='text/css'>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/uikit.almost-flat.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.addons.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.gradient.addons.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/colorpick/css/colpick.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/iCheck/skins/all.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/chosen/chosen.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/jqplot/jquery.jqplot.min.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/intel/build/css/intlTelInput.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/rupee/rupyaINR.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin2.css" rel="stylesheet" />
</head>
<body id="merchant" class="fixed-left merchant-page">
            <div class="topbar">
                <div class="topbar-left">
                    <a href="" class="logo">
                        <span><?php echo Yii::t("default","Merchant")?></span>
						</a>
                </div>
				<?php $merchant_info=(array)Yii::app()->functions->getMerchantInfo();?>
                <nav class="navbar navbar-custom">
					<ul class="nav navbar-nav left-nav">
						<li class="nav-item">
  <div class="mer-status">
    <?php //$merchant_info=(array)Yii::app()->functions->getMerchantInfo();?>
    <?php if (is_array($merchant_info) && count($merchant_info)>=1):?>
     <h4 class="uk-h3"> 
     <?php     
     if (strlen($merchant_info[0]->restaurant_name)>=15){
     	echo stripslashes(( substr($merchant_info[0]->restaurant_name,0,15)."..." ));  
     } else echo stripslashes(($merchant_info[0]->restaurant_name));      
      ?>
     <a class="merchant-status" href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/MerchantStatus" ></a>
     </h4>
    <?php endif;?>
  </div> <!--RIGHT-->
						</li>
						<li class="nav-item">
        <div class="pub-merchant">
  <div class="notice-wrap"></div>
  <h4 class="uk-h3"><?php echo Yii::t("default","Published Merchant")?>?
  <?php 
  echo CHtml::checkBox('is_ready',false,array(
    'class'=>"icheck is_ready"
  ))
  ?>
  <a href="javascript:;" data-uk-tooltip="{pos:'bottom-left'}" title="<?php echo Yii::t("default","Check this box to published your merchant, if this box is not check your merchant will not show on search result.")?>" ><i class="fa fa-info-circle"></i>
</a>
  </h4>
  </div>
						</li>
					</ul>
                    <ul class="nav navbar-nav navbar-right pull-right">
						<li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle nav-link nav-user" data-toggle="dropdown"><?php echo Yii::app()->functions->getMerchantUserName()?></a>
                            <ul class="dropdown-menu">
								<?php if (isset($merchant_info[0]->user_access)):?>
								<li><a href="<?php echo websiteUrl()."/merchant/profile"?>"><i class="fa fa-user"></i> Profile</a></li>
								<?php else :?>
								<li><a href="<?php echo websiteUrl()."/merchant/Merchant"?>"><i class="fa fa-user"></i> Profile</a></li>
								<?php endif;?>
								<li>
								<a href="<?php echo Yii::app()->request->baseUrl."/merchant/login/logout/true"?>">
								<i class="fa fa-sign-out"></i> <?php echo Yii::t("default","Logout")?>
								</a>
								</li>	
                            </ul>
                        </li>
                    </ul>
  <div class="clear"></div>
                </nav>
				

            </div>
<div class="main_wrapper" id="wrapper">
  <div class="left side-menu">
  <div class="sidebar-inner slimscroll">
      <div class="" id="sidebar-menu">
        <?php 
        $this->widget('zii.widgets.CMenu', Yii::app()->functions->merchantMenu());?>
      </div>
  </div>
  </div>
  <div class="content-page">
     <div class="content container-fluid">
       	   <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title"><?php echo $this->crumbsTitle;?></h4>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
       <div class="content_wrap">
         <?php echo $content;?>
       </div>
     </div>
  </div>
  <div class="clear"></div>
</div>

<?php echo CHtml::hiddenField("currentController","merchant")?>

<?php 
$website_date_picker_format=yii::app()->functions->getOptionAdmin('website_date_picker_format');
if (!empty($website_date_picker_format)){
	echo CHtml::hiddenField('website_date_picker_format',$website_date_picker_format);
}
$website_time_picker_format=yii::app()->functions->getOptionAdmin('website_time_picker_format');
if ( !empty($website_time_picker_format)){
	echo CHtml::hiddenField('website_time_picker_format',$website_time_picker_format);
}
?>

<?php 
$merchant_id=Yii::app()->functions->getMerchantID();
$enabled_alert_sound=Yii::app()->functions->getOption("enabled_alert_sound",$merchant_id);
$merchant_booking_alert=Yii::app()->functions->getOption("merchant_booking_alert",$merchant_id);
?>
<input type="hidden" id="alert_off" name="alert_off" value="<?php echo $enabled_alert_sound?>">
<?php echo CHtml::hiddenField("booking_alert",$merchant_booking_alert);?>
<?php //if ( $enabled_alert_sound==""):?>
<div style="display:none;">
<div id="jquery_jplayer_1"></div>
<div id="jp_container_1">
<a href="#" class="jp-play">Play</a>
<a href="#" class="jp-pause">Pause</a>
</div>
</div>
<?php //endif;?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/jquery-1.10.2.min.js" type="text/javascript"></script>  

<?php $js_lang=Yii::app()->functions->jsLanguageAdmin(); ?>
<?php $js_lang_validator=Yii::app()->functions->jsLanguageValidator();?>
<script type="text/javascript">
var js_lang=<?php echo json_encode($js_lang)?>;
var jsLanguageValidator=<?php echo json_encode($js_lang_validator)?>;
</script>

<script type="text/javascript">
var ajax_url='<?php echo Yii::app()->request->baseUrl;?>/admin/ajax';
var admin_url='<?php echo Yii::app()->request->baseUrl;?>/admin';
var sites_url='<?php echo Yii::app()->request->baseUrl;?>';
var upload_url='<?php echo Yii::app()->request->baseUrl;?>/upload';
var google_key = '<?php echo yii::app()->functions->getOption('google_geo_api_key'); ?>'; 
</script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/fnReloadAjax.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/JQV/form-validator/jquery.form-validator.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.ui.timepicker-0.0.8.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/js/uploader.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/ajaxupload/fileuploader.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/js/jquery.cropit.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/js/cropper_main_gig.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/uikit.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/notify.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/sticky.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/sortable.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/iCheck/icheck.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/chosen/chosen.jquery.min.js"></script>

<!--Google Maps
 <script src="//maps.googleapis.com/maps/api/js?v=3.exp&"></script>
<!--END Google Maps-->

<script>
 
var script = document.createElement('script');
script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&key="+google_key+"";
document.getElementsByTagName('script')[0].parentNode.appendChild(script);
</script> 

<!-- <script async defer src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key='+google_key  type="text/javascript"></script>  -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.printelement.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/jquery.jqplot.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/excanvas.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.barRenderer.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.categoryAxisRenderer.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.pointLabels.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.json2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jQuery.jPlayer.2.6.0/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/intel/build/js/intlTelInput.js?ver=2.1.5"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/admin/jquery.slimscroll.js" type="text/javascript"></script>  
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin.js?ver=1" type="text/javascript"></script>  
</body>
</html>