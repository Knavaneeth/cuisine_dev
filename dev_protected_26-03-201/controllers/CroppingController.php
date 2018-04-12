<?php   
if (!isset($_SESSION)) { session_start(); }
class CroppingController extends CController
{	
public function actionPrf_crop() { 		                                
                        $error_msg       = '';                         
                         ini_set('display_errors', 1);
						 ini_set('display_startup_errors', 1);
						 error_reporting(E_ALL);			                           
                         $uploadPath 	  = Yii::getPathOfAlias('webroot');                                       
                         $user_id 		  = $_SESSION['kr_client']['client_id'];                           
						 $av_data         = json_decode(($_POST['avatar_data']),true);
						 $av_file         = $_FILES['avatar_file'];
						 $default_image   = $_POST['default_image_url'];
						 if(!empty($av_file['name']))
							{
								$src             = $uploadPath.'upload'.$av_file['name'];
								$imageFileType   = pathinfo($src,PATHINFO_EXTENSION);                                
								$src2            = $uploadPath.'/upload/profile_user_'.$user_id.'_original.'.$imageFileType; 
								move_uploaded_file( $av_file['tmp_name'],$src2);						
								$image_name      = 'profile_user_'.$user_id.'_original.'.$imageFileType;
								$new_name1       = "profile_user_".$user_id."_150x150.".$imageFileType; 
								$data['user_profile_image'] = $new_name1;
								$image1          = $this->prf_crop_call($image_name,$av_data,$new_name1,150,150);
							} 
							 else
                        	{ 
								$exloded_value   = explode("/",$default_image);								 
								foreach ($exloded_value as $explo_value)
								{                                
								} 
								$src             = $uploadPath.'upload'.$explo_value;
								$imageFileType   = pathinfo($src,PATHINFO_EXTENSION);
								$new_name1       = "profile_user_".$user_id."_150x150.".$imageFileType; 
								$data['user_profile_image'] = $new_name1;
								$image1          = $this->prf_crop_call($explo_value,$av_data,$new_name1,150,150);                            
	                        }
						                                   
			
 		/*
                        $new_name2       = "profile_image_".$user_id."_150x150.".$imageFileType; 
 	    	$image2          = $this->prf_crop_call($image_name,$av_data,$new_name2,150,150);
 			$new_name3       = "profile_image_".$user_id."_50x50.".$imageFileType; 
                        $data['user_thumb_image'] = 'assets/images/upload/profile_images/'.$new_name3;
 			$image3          = $this->prf_crop_call($image_name,$av_data,$new_name3,50,50);  */
  		    $rand = rand(100,999);                                                                
                     	$params_mobile=array('avatar'=> $data['user_profile_image'] );
                        $db_ext=new DbExt;
                        $db_ext->updateData("{{client}}",$params_mobile,'client_id',
			    				Yii::app()->functions->getClientId());
                                                        
		    $response = array(
								'state'  => 200,
								'message' => $error_msg,
								'result' => '/upload/'.$new_name1.'?dummy='.$rand,
								'img_name1' => $new_name1
		    );
            // if (file_exists($src2)) { unlink($src2);  } 
  		    echo json_encode($response); 
	} 
        
        
          public function prf_crop_call($image_name,$av_data,$new_name,$t_width,$t_height) { 
                        $uploadPath = Yii::getPathOfAlias('webroot');  
                        $baseUrl = $uploadPath;
  			$path              =  $baseUrl.'/upload/'; 
   			$w                 = $av_data['width'];
			$h                 = $av_data['height'];
			$x1                = $av_data['x'];
			$y1                = $av_data['y'];
 			list($imagewidth, $imageheight, $imageType) = getimagesize( $baseUrl.'/upload/'.$image_name);
			$imageType                                  = image_type_to_mime_type($imageType);
 			$ratio             = ($t_width/$w); 
			$nw                = ceil($w * $ratio);
			$nh                = ceil($h * $ratio);  
			$newImage          = imagecreatetruecolor($nw,$nh);
			switch($imageType) {
				case "image/gif"  : $source = imagecreatefromgif($baseUrl.'/upload/'.$image_name); 
									break;
				case "image/pjpeg":
				case "image/jpeg" :
				case "image/jpg"  : $source = imagecreatefromjpeg($baseUrl.'/upload/'.$image_name); 
									break;
				case "image/png"  :
				case "image/x-png": $source = imagecreatefrompng($baseUrl.'/upload/'.$image_name); 
									break;
			} 
			imagecopyresampled($newImage,$source,0,0,$x1,$y1,$nw,$nh,$w,$h);
			switch($imageType) {
				case "image/gif"  : imagegif($newImage,$path.$new_name); 
									break;
				case "image/pjpeg":
				case "image/jpeg" :
				case "image/jpg"  : imagejpeg($newImage,$path.$new_name,100); 
									break;
				case "image/png"  :
				case "image/x-png": imagepng($newImage,$path.$new_name);  
									break;
			} 
 	} 
	
	
	
	
	  public function actionMerchant_logo() 
	{    
             ini_set('display_errors', 1);
  			 ini_set('display_startup_errors', 1);
			 error_reporting(E_ALL);
			 ini_set('max_execution_time', 3000); 
   			 ini_set('memory_limit', '-1');                          
			 ini_set('upload_max_filesize', '4M');
			$html=$error_msg= $shop_ad_id='';                        
			$error_sts  =0;
			$row_id     = $_POST['select_row_id'];					
			$image_data = $_POST['img_data'];                                
                        $merchantid = json_decode($_SESSION['kr_merchant_user'],true);
                        $merchant_id =  $merchantid[0]['merchant_id'];                                
				$base64string = str_replace('data:image/png;base64,', '', $image_data);
				$base64string = str_replace(' ', '+', $base64string);
				$data = base64_decode($base64string);        			 
				$img_name = time();
				$file_name_final='merchant_logo_'.$merchant_id.'_'.$img_name.".png";
				$img_name2 = "400_240_".$file_name_final; 
                                 $uploadPath = Yii::getPathOfAlias('webroot');  
                                //echo $uploadPath.'/upload/'.$img_name2;
				file_put_contents($uploadPath.'/upload/'.$img_name2, $data);
                                
				//$imageFileType= 'png';
				//$rawname='gig_'.$img_name;
				$source_image= $uploadPath.'/upload/'.$img_name2; 
                                $hosting_url = Yii::app()->request->baseUrl.'/upload/'.$img_name2;
				$blog_themb = $this->image_resize(400,240,$source_image,$file_name_final);
				// $blog_themb_one = $this->image_resize(50,34,$source_image,$file_name_final);
                                
                                $html = '<img src="'.$hosting_url.'" alt="image" title="" class="uk-thumbnail uk-thumbnail-mini">'
                                        . '<input name="photo" '
                                        . 'value="'.$img_name2.'" type="hidden">'
                                        . '<p><a href="javascript:rm_preview();">Remove image</a></p>';
                                
		    $row_id = $row_id+1;
		    $response = array(
								'state'  => 200,
								'message' => $error_msg,
								'result' => $html,
								'row_id' => $row_id,
								'sub_html' => $blog_themb ,
								'sts' => $error_sts
		    );
  		    echo json_encode($response); 
	}
        
        	public function image_resize($width=0,$height=0,$image_url,$filename)
	{          
                    
                $uploadPath = Yii::getPathOfAlias('webroot');    
		$source_path = $image_url;
		list($source_width, $source_height, $source_type) = getimagesize($source_path);
		switch ($source_type) {
			case IMAGETYPE_GIF:
				$source_gdim = imagecreatefromgif($source_path);
				break;
			case IMAGETYPE_JPEG:
				$source_gdim = imagecreatefromjpeg($source_path);
				break;
			case IMAGETYPE_PNG:
				$source_gdim = imagecreatefrompng($source_path);
				break;
		}
		$source_aspect_ratio = $source_width / $source_height;
		 
		 $desired_aspect_ratio = $width / $height; 
		
		if ($source_aspect_ratio > $desired_aspect_ratio) {
			/*
			 * Triggered when source image is wider
			 */
			 
			$temp_height = $height;
			$temp_width = ( int ) ($height * $source_aspect_ratio);
		} else {
			/*
			 * Triggered otherwise (i.e. source image is similar or taller)
			 */
			$temp_width = $width;
			$temp_height = ( int ) ($width / $source_aspect_ratio);
		}
		
		/*
		 * Resize the image into a temporary GD image
		 */
		$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
		imagecopyresampled(
			$temp_gdim,
			$source_gdim,
			0, 0,
			0, 0,
			$temp_width, $temp_height,
			$source_width, $source_height
		);
		
		/*
		 * Copy cropped region from temporary image into the desired GD image
		 */
		
		$x0 = ($temp_width - $width) / 2;
		$y0 = ($temp_height - $height) / 2;
		$desired_gdim = imagecreatetruecolor($width, $height);
		imagecopy(
			$desired_gdim,
			$temp_gdim,
			0, 0,
			$x0, $y0,
			$width, $height
		);
		
		/*
		 * Render the image
		 * Alternatively, you can save the image in file-system or database
		 */
		//$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
		 
		   $image_url =  $uploadPath."/upload/".$width."_".$height."_".$filename."";    
		imagepng($desired_gdim,$image_url);
		
		return $image_url;
		
		/*
		 * Add clean-up code here
		 */
	}
    
      
    
        
        }
        
        ?>