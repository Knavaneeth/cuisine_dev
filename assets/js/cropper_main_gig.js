 var base_url = 'https://'+window.location.host+'/';
$( document ).ready(function() {
            $('#img_upload').on("click", function(){ 
	            $('.cropit-image-input').val('');
	            $('.cropit-preview-image').attr('src','');    
	            $('.cropit-preview-background').attr('src','');  
	            $(".modal-backdrop").remove();
				$("#avatar-gig-modal").css('display','block');
				$("#avatar-gig-modal").modal('show');
			
		});
		
	});

 $(function() {
        $('.image-editor').cropit({
          exportZoom: 0.92,
          imageBackground: true,
          imageBackgroundBorderWidth: 20,
         
        });

        $('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });
		$('#fileopen').on("change", function(){                
			var u = URL.createObjectURL(this.files[0]);		 
			var ext = $('#fileopen').val().split('.').pop().toLowerCase();
			$("#error_msg_model").html('');
			if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
			$('.error_msg').html('invalid extension!');
			$("#fileopen").val('');
			
			}
			else
        	{
				 var img = new Image;   
				img.src = u;	 
				img.onload = function() {								
					if(img.width >= 500 && img.height >=338 ) 
					{
						 //$(".cropit-preview-image").show();
						  //$(".cropit-preview-background").show();
					         	
					}
					else
					{                                       
					$("#error_msg_model").html("Please upload size more than 500*338  "); 		 
		    			$('#fileopen').val('');
					}
				}
			}
		 
		});
        $('.export').click(function() {
           var imageData = $('.image-editor').cropit('export');
		   var url=base_url+'merchant/image_upload';
		   var r_id= $('#select_row_id').val();
		   var dataString="img_data="+imageData+"&select_row_id="+r_id; 
		   var file1 = $('#fileopen').val(); 
		   $("#error_msg_model").html('');		   
		   if(file1.length>1){		   	
		   $.ajax( {
			   		url:url,
					type       : 'post',
					data       : dataString,
					enctype    : 'multipart/form-data',
					dataType   : 'json',
					beforeSend: function () {
						$(".export").html('<img width="16" height="16" src="'+base_url+'assets/images/loader.gif" alt="loading">');				
					},
					success: function (data) {                                            
						if (data.result) {  
                          $('.image_preview').html(data.result);  
                          $('.sell_service_submit').removeAttr('disabled');	
						  $('#image_video_error_msg').html(''); 
						  $('.uploaded-section').css('display','block');
						  $(".uploaded-section").append(data.result);
						  $('#select_row_id').val(data.row_id);
						  $('#error_msg_model').html('');
						  $(".cropit-preview-image").attr('src','');
						  $(".cropit-preview-background").attr('src','');
						  $("#fileopen").val("");
						  /* var v1= $( "#image_array" ).val();
							if(v1.length >0)
							{
							var v2 = [];
							v2.push(v1);
							v2.push(data.sub_html);
							$( "#image_array" ).val(v2);
							}
							else{
							var array = [];
							array.push(data.sub_html);
							$( "#image_array" ).val(array);
							}
                                <div class="image_preview" style="display: style;"><img class="uk-thumbnail uk-thumbnail-mini" title="" alt="" src="/food/upload/1485767825-food-wallpaper-5.jpg"><input type="hidden" value="1485767825-food-wallpaper-5.jpg" name="photo"><p><a href="javascript:rm_preview();">Remove image</a></p></div>
                                                 **/
						}
					$("#avatar-gig-modal").modal('hide');
				},
				complete: function () {
						$(".export").html('Done');
					}
      		});
		   }
		   else
			{
				$("#error_msg_model").html("Please select size more than 500*338 "); 		 
			}
        });
      });
	  
	  