<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<title>Take Away & Delivery Jersey</title>
<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/assets/images/fav.png" type="image/x-icon">
<?php 
		$curpage = Yii::app()->getController()->getAction()->controller->action->id;
		if($curpage=="menu")
		{
			$merchant_slug = basename($_SERVER['REQUEST_URI']);

			$merchant_id = Yii::app()->functions->get_merchant_details($merchant_slug);		
		 	
		 	$booking_array = array(4,5);
		 	if(in_array(Yii::app()->functions->get_merchant_service($merchant_id),$booking_array))
		 	{	 

				 $gallery=Yii::app()->functions->getOption("merchant_table_menu",$merchant_id);
  				 $gallery=!empty($gallery)?json_decode($gallery):false;
  				 $images = implode(",",$gallery); 
				echo "<script> var in_housemenu = '".$images."';  </script>";				 

		 	}		 	 
		} 


?>
</head>
<body>