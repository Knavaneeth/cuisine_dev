<?php
if (!isset($_SESSION)) { session_start(); }
class DirectionsController extends CController
{
	public $layout='store_tpl';	
	public $crumbsTitle='';
	public $theme_compression='';
	
	public function beforeAction($action)
	{
		//$cs->registerCssFile($baseUrl.'/css/yourcss.css'); 		
		if( parent::beforeAction($action) ) {			
			
			/** Register all scripts here*/
			if ($this->theme_compression==2){
				ScriptManagerCompress::RegisterAllJSFile();
			    ScriptManagerCompress::registerAllCSSFiles();
			   
				$compress_css = require_once 'assets/css/css.php';
			    $cs = Yii::app()->getClientScript();
			    Yii::app()->clientScript->registerCss('compress-css',$compress_css);
			} else {
			    ScriptManager::RegisterAllJSFile();
			    ScriptManager::registerAllCSSFiles();
			}
			return true;
		}
		return false;
	}

	public function actionIndex()
	{							
		$this->render('map/directions');
	}	
?>