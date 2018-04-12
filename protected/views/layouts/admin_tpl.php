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
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/rupee/rupyaINR.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin2.css" rel="stylesheet" />
</head>
<body id="admin" class="fixed-left admin-page">
<?php  $admin_info=(array)Yii::app()->functions->getAdminInfo(); ?>
            <div class="topbar">
                <div class="topbar-left">
                    <a href="" class="logo">
                        <span><?php echo Yii::t("default","ADMIN")?></span>
						</a>
                </div>
                <nav class="navbar navbar-custom">
                    <ul class="nav navbar-nav navbar-right pull-right">
						<li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle nav-link nav-user" data-toggle="dropdown"><?php echo $admin_info['username'] ?> <img src="<?php echo Yii::app()->createUrl();?>/assets/images/admin-img.png" class="" alt="" width="50" height="50"></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/profile"><?php echo Yii::t("default","Profile")?></a></li>
                                <li><a href="<?php echo Yii::app()->request->baseUrl."/admin/login/logout/true"?>"><?php echo Yii::t("default","Logout")?></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>

            </div>
<div class="" id="wrapper">
  <div class="left side-menu">
  <div class="sidebar-inner slimscroll">
      <div class="" id="sidebar-menu">
        <?php $this->widget('zii.widgets.CMenu', Yii::app()->functions->adminMenu());?>
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
       <div class="">
         <?php echo $content;?>
       </div> 
     </div>
  </div>
  <div class="clear"></div>
  
</div>
<?php echo CHtml::hiddenField("currentController","admin")?>
<?php echo CHtml::hiddenField("wd_payout_alert",yii::app()->functions->getOptionAdmin('wd_payout_notification'))?>
<?php 
$website_date_picker_format=yii::app()->functions->getOptionAdmin('website_date_picker_format');
if (!empty($website_date_picker_format)){
	echo CHtml::hiddenField('website_date_picker_format',$website_date_picker_format);
}
$website_time_picker_format=yii::app()->functions->getOptionAdmin('website_time_picker_format');
if ( !empty($website_time_picker_format)){
	echo CHtml::hiddenField('website_time_picker_format',$website_time_picker_format);
}?>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery-1.10.2.min.js" type="text/javascript"></script>  
<?php $js_lang           = Yii::app()->functions->jsLanguageAdmin(); ?>
<?php $js_lang_validator = Yii::app()->functions->jsLanguageValidator();?>
<script type="text/javascript">
var js_lang            = <?php echo json_encode($js_lang)?>;
var jsLanguageValidator= <?php echo json_encode($js_lang_validator)?>;
</script>
<script type="text/javascript">
var ajax_url   ='<?php echo Yii::app()->request->baseUrl;?>/admin/ajax';
var admin_url  ='<?php echo Yii::app()->request->baseUrl;?>/admin';
var sites_url  ='<?php echo Yii::app()->request->baseUrl;?>';
var upload_url ='<?php echo Yii::app()->request->baseUrl;?>/upload';
</script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/fnReloadAjax.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/JQV/form-validator/jquery.form-validator.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.ui.timepicker-0.0.8.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/js/uploader.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/ajaxupload/fileuploader.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/uikit.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/notify.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/sticky.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/sortable.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/iCheck/icheck.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/chosen/chosen.jquery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/admin/jquery.slimscroll.js" type="text/javascript"></script>  
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin.js?ver=1" type="text/javascript"></script> 
</body> 
</html>