<?php
return array(
	'name'=>'Food App',
	
	// 'defaultController'=>'store',
		
	'import'=>array(
		'application.models.*',
		'application.models.admin.*',
		'application.components.*',
		'application.vendor.*',
		'application.modules.pointsprogram.components.*',
		'application.modules.mobileapp.components.*',
		'application.modules.merchantapp.components.*',
		'application.modules.driver.components.*',
		'ext.YiiMailer.YiiMailer',
	),
	
	'language'=>'default',		
	
	'modules'=>array(		
		'mobileapp'=>array(
		  'require_login'=>true
		),
		'merchantapp'=>array(
		  'require_login'=>true
		)
	),
	// only enabled the addon if you have them
	
	'modules'=>array(		
		'ExportManager'=>array(
		  'require_login'=>true
		),
		'mobileapp'=>array(
		  'require_login'=>true
		),
		'pointsprogram'=>array(
		  'require_login'=>true
		),
		'merchantapp'=>array(
		  'require_login'=>true
		),
		'driver'=>array(
		  'require_login'=>true
		)
	),
		
	'components'=>array(
		/*'urlManager'=>array(
			'urlFormat'=>'path',			
		),*/
	    'urlManager'=>array(
		    'urlFormat'=>'path',
		    'rules'=>array(	
		    	''=>'store/home',	                       
		    			'check/'=>'check/index',
                        'merchantapp'=>'merchantapp/index',
                        'merchantapp/<controller:\w+>/<id:\d+>'=>'merchantapp/<controller>/view',
		        'merchantapp/<controller:\w+>'=>'merchantapp/<controller>/index',
		        'merchantapp/<controller:\w+>/<action:\w+>/<id:\d+>'=>'merchantapp/<controller>/<action>',
		        'merchantapp/<controller:\w+>/<action:\w+>'=>'merchantapp/<controller>/<action>',
				'mobileapp'=>'mobileapp/index',
				'ops'=>'ops',

		        'directions/<id:\w+|\d+>'=>'store/directions',

		        'deals/'=>'store/deals',

                'mobileapp/<controller:\w+>/<id:\d+>'=>'mobileapp/<controller>/view',
		        'mobileapp/<controller:\w+>'=>'mobileapp/<controller>/index',
		        'mobileapp/<controller:\w+>/<action:\w+>/<id:\d+>'=>'mobileapp/<controller>/<action>',
		        'mobileapp/<controller:\w+>/<action:\w+>'=>'mobileapp/<controller>/<action>',		        
		    	'<controller:store>'=>'<controller>', 			
		    	'<controller:admin>'=>'<controller>',
		    	'<controller:merchant>'=>'<controller>',
		    	'<controller:update>'=>'<controller>',
		    	'<controller:paysera>'=>'<controller>',
		    	'<controller:external>'=>'<controller>',
		    	'<controller:cropping>'=>'<controller>',
		    	'<controller:cron>'=>'<controller>',
		    	'<controller:ajax>'=>'<controller>',
		    	'<action:\w+>'=>'store/<action>',	 			    			    			    	   		    	
		        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
		        '<controller:\w+>'=>'<controller>/index',
		        '<controller:\w+>/<action:\w+>/<id:\w+|\d+>'=>'<controller>/<action>',
		        //'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',		        
		        '<controller:\w+>/<action:\w+>/<id:\d+>/<citypay_success:\w+>'=>'<controller>/<action>',	      	
		        	      	
		                	        	 		        
		    ),
		    'showScriptName'=>false,
		),
				
		 /* 	'db'=>array(	        
		    'class'            => 'CDbConnection' ,
			'connectionString' => 'mysql:host=onlineservice.db.10326617.hostedresource.com;dbname=onlineservice',
			'emulatePrepare'   => true,
			'username'         => 'onlineservice',
			'password'         => 'Admin!21',
			'charset'          => 'utf8',
			'tablePrefix'      => 'mt_',
	    ), */


          'db'=>array(	        
		    'class'            => 'CDbConnection' ,
			'connectionString' => 'mysql:host=localhost;dbname=food_development',
			'emulatePrepare'   => true,
			'username'         => 'food5erv1ce',
			'password'         => 'Adm1nf00d',
			'charset'          => 'utf8',
			'tablePrefix'      => 'mt_',
	    ),		
	    
	    'functions'=> array(
	       'class'=>'Functions'	       
	    ),
	    'validator'=>array(
	       'class'=>'Validator'
	    ),
	    'widgets'=> array(
	       'class'=>'Widgets'
	    ),
	    	    
	    'Smtpmail'=>array(
	        'class'=>'application.extension.smtpmail.PHPMailer',
	        'Host'=>"YOUR HOST",
            'Username'=>'YOUR USERNAME',
            'Password'=>'YOUR PASSWORD',
            'Mailer'=>'smtp',
            'Port'=>587, // change this port according to your mail server
            'SMTPAuth'=>true,   
            'ContentType'=>'UTF-8'
	    ), 
	    
	    'GoogleApis' => array(
	         'class' => 'application.extension.GoogleApis.GoogleApis',
	         'clientId' => '', 
	         'clientSecret' => '',
	         'redirectUri' => '',
	         'developerKey' => '',
	    ),
	),
);

function statusList()
{
	return array(
	 'publish'=>Yii::t("default",'Publish'),
	 'pending'=>Yii::t("default",'Pending for review'),
	 'draft'=>Yii::t("default",'Draft')
	);
}

function driverList()
{
	return array(
	 'active'=>Yii::t("default",'active'),
	 'deactive'=>Yii::t("default",'deactive')	 
	);
}

function clientStatus()
{
	return array(
	  'pending'=>Yii::t("default",'pending for approval'),
	 'active'=>Yii::t("default",'active'),	 
	 'suspended'=>Yii::t("default",'suspended'),
	 'blocked'=>Yii::t("default",'blocked'),
	 'expired'=>Yii::t("default",'expired')
	);
}

function paymentStatus()
{
	return array(
	 'pending'=>Yii::t("default",'pending'),
	 'paid'=>Yii::t("default",'paid'),
	 'draft'=>Yii::t("default",'Draft')
	);
}

function dump($data=''){
    echo '<pre>';print_r($data);echo '</pre>';
}