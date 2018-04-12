/*version 2.4*/

var $ = jQuery.noConflict();
var hl_end_content_pos;
var locations;
var global_plot_marker=[];

jQuery.fn.exists = function(){return this.length>0;}

jQuery(document).ready(function() {	
	//hl_end_content_pos = parseFloat($('.footer-wrap').position().top)+50;		
	//New Works start

  if($.trim($('.default_address_book_slt :selected').text()).length>0)
  {
      var selected_addr_val = $('.default_address_book_slt :selected').text();
      $('#formatted_address').val(selected_addr_val);
  }

  if($('.show_lightgallery').exists())
  {
	  if ($('#lightgallery').exists())
	  {
		  $('#lightgallery').lightGallery();  
	  }  
	  
	  if ($('#spl_lightgallery').exists()) 
	  {
		  $('#spl_lightgallery').lightGallery();  
	  }      
  
  }
  
  if($('#order_history_dataTable').exists())
  {
    // $('#order_history_dataTable').DataTable({"order": [[ 1, 'desc' ]]});
    $('#order_history_dataTable').DataTable({"aaSorting": []});
  } 
  

  $(document).on('change','.default_address_book_slt',function()
  {   
        var $option = $(this).find('option:selected');     
        var value = $.trim($option.val());
        var base_url = $('#base_url').val();  
         
        if(value!='')
        {
          if($.trim($('.default_address_book_slt :selected').text()).length>0)
          {
              var selected_addr_val = $('.default_address_book_slt :selected').text();
              $('#formatted_address').val('');
              $('#formatted_address').val(selected_addr_val);
          }
          $.ajax({    
            type: "POST",
            url: base_url+"/store/Check_parish",
            data: {parish:value},                 
            success: function(data)
            {               
              if($.trim(data)!='')
              {
                $('.check_out_parish_select').remove();
                $('#parish').val(data);



                        var base_url     = $('#base_url').val();
                        var url          =  base_url+'/store/delivery_price'; 
                        var merchant_id  =  $('#merchant_id').val();
                        var selected_val =  data;
                        $.ajax({
                                type:'POST',
                                url : url , 
                                data: {parish:selected_val,merchant_id:merchant_id},
                                success:function(response)
                                {                                  
                                     $('#require_parish').val('yes');  
                                     var response = response.split('|');                              
                                     if(response[0]=="success")
                                     {     

                                        $('#merchant_non_deliverable_addr').css('display','none');      
										$('.btn-primary').removeAttr('disabled','disabled');                       
										$(".place_order").prop('disabled', false);										  
                                        $('.check_out_parish_select').remove();
										$('#parish').val(response[1]);
										if (response[2].length > 0) 
										{
											 $('#minimum_order').val(response[2]);
										}
                                        load_item_cart();  
                                        $('#require_parish').val('no');
                                     }       

                                     if($.trim(response)=='')
                                     {
                                          var empty_session_url = base_url+'/store/empty_parish_session';
                                          $.ajax({
                                          type:'POST',
                                          url : empty_session_url ,                                        
                                          success:function(sucess_response)
                                          {
                                            if(sucess_response==1)
                                            {
                                                $('#merchant_non_deliverable_addr').css('display','block');
												load_item_cart();  												
												$('.place_order').find('a').attr('disabled','disabled');
												$(".place_order").prop('disabled', true);											     
                                            }                     
                                          }
                                          });             
                                     }                                                                                            
                                }
                        });










              }
            }
          });
        }

    });    
        $(document).on('click','.search_addr',function()
    {        
        var postcode = $.trim($('.postcode').val());
        var htm = '';
        
        if(postcode!='')
        {
            $('#user_slt_address').html('');             
            var url="https://api.getaddress.io/find/"+postcode+"?api-key=iew8IndDYEuCA4ef5_5oRw11062";
            busy(true);
            $.getJSON(url, function (data) {   

             $('#wrong_pin').html('');              
             $('#wrong_pin').css('display','none');   

             if(data == '')
             {  
                $('#user_profile_addr').css('display','none');
                $('#location_name').val('');
                $('#street').val('');
                $('#city').val('');   
                $('#state').val('');    
                $('#zipcode').val('');          
                $('#location_name').val('');                
             }             
             else
             {
                $('.user_slt_address').attr('data-validation','required');
                $(".get_address_div").show();               
                $("#user_slt_address").append("<option value='' disabled selected>Select Address</option>")
                $.each( data.addresses, function( key, value ) 
                {
                    var val = value;
                    val = val.replace(/,/g, "");               
                    htm +='<option value="'+value+'">'+val+'</option>';
                });
                $('#user_slt_address').append(htm);
                $('.get_address_div').css('display','block');
                $('#user_profile_addr').css('display','block');
                busy(false);
            }   
              
            }).fail(function(jqXHR, textStatus, errorThrown) 
            {
              $('#user_profile_addr').css('display','none');
                $('#location_name').val('');
                $('#street').val('');
                $('#city').val('');   
                $('#state').val('');    
                $('#zipcode').val('');          
                $('#location_name').val('');  
              $('#wrong_pin').html('Invalid Pincode');               
              $('#wrong_pin').css('display','block');
                busy(false);
            })         

        }        

    }); 

    $(document).on('change','#user_slt_address',function()
        {
            var chngeval=this.value;                         
            chngeval=chngeval.split(',');

			// alert(chngeval[0] +"  "+chngeval[1]+"  "+chngeval[2] +"  "+chngeval[3]+"  "+chngeval[4]+"  "+chngeval[5]+"  "+chngeval[6]);
			// alert(chngeval[0]+" "+chngeval[1]+" "+chngeval[2]+" "+chngeval[3]);
            $("#street").val(chngeval[0]+" "+chngeval[1]+" "+chngeval[2]+" "+chngeval[3]);
             
		    $("#city").val(chngeval[4] + "," + chngeval[5]);
		    

		    $("#state").val(chngeval[4]);	

            /* $("#location_name").val(chngeval[0]);
            $("#street").val(chngeval[1]);
            $("#city").val(chngeval[5]);
            $("#state").val(chngeval[4]); */
            if($("#zipcode").exists())
            {
              $("#zipcode").val($('#postcode').val());
            }

        });       
  

  if($('#facebook_exist').exists())
  {
    if($('#facebook_exist').val()=="true")
    { 
        var  fb_params ="first_name="+$("#first_name").val()+"&last_name="+$("#last_name").val()+"&email="+$("#email").val()+"&id="+$("#id").val();
        var params="action=FBRegister&currentController=store&"+fb_params;
   $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',        
        success: function(data){          
          busy(false);
          if (data.code==1){
            load_top_menu();                      

            if ( $(".section-checkout").exists() ){             
              alert("section-checkout        "+$("#redirect").val());           
              window.location.href = $("#redirect").val();
            } 
                                  
            if ( $("#single_page").exists() ){
              alert("single_page    "+home_url);
              window.location.href=home_url;
            }   

            $("#first_name").val('');
            $("#last_name").val('');
            $("#email").val('');
            $("#id").val('');
            $("#facebook_exist").val('');

            data.msg = "Login Successful";
            uk_msg(data.msg);
            setTimeout(function(){ busy(true); }, 2000);
            window.location.href = $("#redirect_page").val();
          } else {
            uk_msg(data.msg);
          }
        }, 
        error: function(){                
          busy(false);
        }   
   });
    }
  }







	$( document ).on( "click", ".merchant_menu_sel", function() {
 		 $('.merchant_menu_sel').removeClass('active');
		 $(this).addClass('active');
		 var id = $(this).attr('cat-id');
		 $('.cat_list_cls').hide(500);
		 $('.cat-id-'+id).show(500); 
     	 //alert('function ok');
    });
	         var nt_example1 = $('#deals-list').newsTicker({
                row_height: 48,
                max_rows: 2,
                duration: 4000
            });


	/*$(".deals-list").bootstrapNews({
		newsPerPage: 5,
		autoplay: true,
		pauseOnHover:true,
		direction: 'up',
		newsTickerInterval: 4000,
		onToDo: function () {
			//console.log(this);
		}
	});*/
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
    $('#delivery_type').exists();
    var delivery_type = $('#delivery_type').val();
                 if(($('#action').val()=="placeOrder")&&(delivery_type!="pickup"))
                  {
                     if($('#parish').val()!='')
                     {
                        var base_url     = $('#base_url').val();
                        var url          =  base_url+'/store/delivery_price'; 
                        var merchant_id  =  $('#merchant_id').val();
                        var selected_val =  $('#parish').val();
                        $.ajax({
                                type:'POST',
                                url : url , 
                                data: {parish:selected_val,merchant_id:merchant_id},
                                success:function(response)
                                {                                  
                                     $('#require_parish').val('yes');  
                                     var response = response.split('|');                              
                                     if(response[0]=="success")
                                     {                                    
                                        $('.check_out_parish_select').remove();
										$('#parish').val(response[1]);
										if (response[2].length > 0) 
										{
										  $('#minimum_order').val(response[2]);
										}
                                        load_item_cart();  
                                        $('#require_parish').val('no');
                                     }       

                                     if($.trim(response)=='')
                                     {
                                          var empty_session_url = base_url+'/store/empty_parish_session';
                                          $.ajax({
                                          type:'POST',
                                          url : empty_session_url ,                                        
                                          success:function(sucess_response)
                                          {
                                            if(sucess_response==1)
                                            {
                                                $('#merchant_non_deliverable_addr').css('display','block');
                                                load_item_cart();  
												$('.place_order').find('a').attr('disabled','disabled');
												$(".place_order").prop('disabled', true);
                                            }                     
                                          }
                                          });             
                                     }                                                                                            
                                }
                        });

                     }
                  }
	});

	//New Works End   

    $(document).on('click','.price_cls',function()
    {        
        var size =  ($(this).val()).split('|');
        size     =  $.trim((size[1]));
        var base_url = $('#base_url').val();  
        var item_id  = $('#item_id').val();  
        var merchant_id = $('#merchant_id').val();  
        var url  = base_url+'/store/GetaddOnPrice'; ;
        $('input:checkbox').removeAttr('checked');
        $.ajax({
                type:'POST',
                url : url , 
                data: {size:size,item_id:item_id,merchant_id:merchant_id},
                success:function(response)
                {
                    if($.trim(response)!='')
                    {
                        $('.food-addons').html('');
                        $('.food-addons').html(response);
                    }
                    else
                    {
                        $('.food-addons').html('');
                    }
                }
        })

    });         


    $(document).on('click','.search_address',function()
    {        
        var postcode = $.trim($('.postcode').val());
        var htm = '';
        
        if(postcode!='')
        {
            $('#slt_address').html('');
            // var url  = "https://api.getaddress.io/find/"+postcode+"?api-key=n8CeAMV30kGh_PAOKmT5bg10390";         
            // var url  = "https://api.getaddress.io/find/JE38HE?api-key=n8CeAMV30kGh_PAOKmT5bg10390";         


            var url="https://api.getaddress.io/find/"+postcode+"?api-key=iew8IndDYEuCA4ef5_5oRw11062";

            busy(true);
            $.getJSON(url, function (data) {   

             $('#wrong_pin').html('');            	
             $('#wrong_pin').css('display','none');		

             if(data == '')
             {                
                // $('.get_address_div').hide();
                $('#location_name').val('');
                $('#street').val('');
                $('#city').val('');                
             }             
             else
             {
                $('.slt_address').attr('data-validation','required');
                $(".get_address_div").show();               
                $("#slt_address").append("<option value='' disabled selected>Select Address</option>")
                $.each( data.addresses, function( key, value ) 
                {
                    var val = value;
                    val = val.replace(/,/g, "");               
                    htm +='<option value="'+value+'">'+val+'</option>';
                });
                $('#slt_address').append(htm);
                $('.get_address_div').css('display','block');
                busy(false);
            }   
              
            }).fail(function(jqXHR, textStatus, errorThrown) 
            {
            	$('#wrong_pin').html('INVALID Pincode');
            	// $("#slt_address").append("<option value='' disabled selected>INVALID Pincode</option>")
            	$('#wrong_pin').css('display','block');
                busy(false);
            })         

       /*     jQuery.getJSON(handlerURL + "&callback=?", 
    function(jsonResult){
        alert("Success!");
    })
.done(function() { alert('getJSON request succeeded!'); })
.fail(function(jqXHR, textStatus, errorThrown) { alert('getJSON request failed! ' + textStatus); })
.always(function() { alert('getJSON request ended!'); }); */


        }        

    });        



        $(document).on('change','#slt_address',function()
        {
            var chngeval=this.value;                
            if($.trim(chngeval).length>0)
            {
                var selected_addr_val = chngeval;
                $('#formatted_address').val('');
                $('#formatted_address').val(selected_addr_val);
            }                      
            chngeval=chngeval.split(',');
/*            $("#location_name").val(chngeval[0]);
            $("#street").val(chngeval[1]);
            $("#city").val(chngeval[4]+","+chngeval[5]);
            $("#state").val(chngeval[4]); */

            $("#location_name").val(chngeval[0]+" "+chngeval[1]+" "+chngeval[2]+" "+chngeval[3]);
            $("#street").val(chngeval[1]);
		    $("#city").val(chngeval[4] + "," + chngeval[5]);
		    

		    $("#state").val(chngeval[4]);	

          //  alert(chngeval[0] +"  "+chngeval[1]+"  "+chngeval[2] +"  "+chngeval[3]+"  "+chngeval[4]+"  "+chngeval[5]+"  "+chngeval[6]);

              if($.trim($('#delivery_type').val())=="pickup")
              {
                return ;
              }  

               if(chngeval[4]!='')
               {
                    var base_url     = $('#base_url').val();
                    var url          =  base_url+'/store/delivery_price'; 
                    var merchant_id  =  $('#merchant_id').val();
                    var selected_val =  chngeval[4] ;
                    $.ajax({
                            type:'POST',
                            url : url , 
                            data: {parish:selected_val,merchant_id:merchant_id},
                            success:function(response)
                            {                                  
                                 $('#require_parish').val('yes');  
                                 var response = response.split('|');                              
                                 if(response[0]=="success")
                                 {       
                                    $('#merchant_non_deliverable_addr').css('display','none');      
									$('.btn-primary').removeAttr('disabled','disabled');   
									$(".place_order").prop('disabled', false);                    
                                    $('.check_out_parish_select').remove();
									$('#parish').val(response[1]);
									 if (response[2].length>0)
									 {
										 $('#minimum_order').val(response[2]);
									 }
									
                                    load_item_cart();  
                                    $('#require_parish').val('no');
                                 }                                    
                                 if(refresh_page=='yes')
                                 {
                                  // location.reload(true);
                                  $('#state').val(selected_text);
                                 } 
                                 if($.trim(response)=='')
                                 {
                                      var empty_session_url = base_url+'/store/empty_parish_session';
                                      $.ajax({
                                      type:'POST',
                                      url : empty_session_url ,                                        
                                      success:function(sucess_response)
                                      {
                                        if(sucess_response==1)
                                        {
                                            $('#merchant_non_deliverable_addr').css('display','block');
                                            load_item_cart();  
											$('.place_order').find('a').attr('disabled','disabled');
											$(".place_order").prop('disabled', true);
                                        }                     
                                      }
                                      });             
                                 }                          
                            }
                    });
               }
        }); 

    $(document).on('click','.save_as_member',function()
    {   

         if ($(this).is(':checked')) 
         {
                $('#email_address').attr('data-validation','required');
                $('#password').attr('data-validation','required');
                $('#save_as_member_div').css('display','block');  

                $('#email_address1').attr('data-validation','required');
                 $('#email_address1').attr('data-validation','email');
                $('#password1').attr('data-validation','required');
                $('#password1').attr('data-validation',"length");
                $('#password1').attr('data-validation-length',"min8");
         } 
         else 
         {
                $('#email_address').attr('data-validation','');
                $('#password').attr('data-validation','');
                $('#save_as_member_div').css('display','none');

                $('#email_address1').attr('data-validation','');
                $('#password1').attr('data-validation','');
          }              
    });         


    $(document).on('change','.check_out_parish_select',function()
    {  
      var selected_val = $.trim($( ".check_out_parish_select option:selected" ).val());
      var selected_text = $.trim($( ".check_out_parish_select option:selected" ).text());
      //alert(selected_text);
      var merchant_id  = $('#merchant_id').val();
      var base_url     = $('#base_url').val();  
      var refresh_page = $('#refresh_page').val();
      if(selected_val>0)
      {
                var url  = base_url+'/store/Selected_parish_delivery'; 
                $.ajax({
                        type:'POST',
                        url : url , 
                        data: {parish:selected_val,merchant_id:merchant_id},
                        success:function(response)
                        {
                             load_item_cart();  
                             if(refresh_page=='yes')
                             {
                              // location.reload(true);
                              $('#state').val(selected_text);
                             }                           
                        }
                })

	  }
	  if(selected_val==0)
	  {
		    $("#minimum_order").val('')
			$("#minimum_order_pretty").val('');
	  }
    });     

    $(document).on('click','#flip',function()
    {
        var size = $("input[name='price']:checked").val().split('|');
        size     =  $.trim((size[1]));        
        var base_url = $('#base_url').val();  
        var item_id  = $('#item_id').val();  
        var merchant_id = $('#merchant_id').val();  
        var url  = base_url+'/store/GetaddOnPrice'; ;

        $.ajax({
                type:'POST',
                url : url , 
                data: {size:size,item_id:item_id,merchant_id:merchant_id},
                success:function(response)
                {
                    if($.trim(response)!='')
                    {
                        $('#flip').css('display','none'); 
                        $('.food-addons').html('');
                        $('.food-addons').css('display','block');
                        $('.food-addons').html(response);

                    }
                    else
                    {
                        $('.food-addons').html('');
                    }
                }
        })
      
    });

    $( document ).on('keypress',".mobile_number_val",function(event) {   
                    var keyCode = event.keyCode || event.which;                  

                    if($('.mobile_number_val').val().length<3)
                        {
                            $('.mobile_number_val').val('');
                            $('.mobile_number_val').val('+44');
                        }  


                    if(keyCode!=9)
                    {                
                        var regex = new RegExp("^[0-9+ \b]+$");
                        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);                   
                        if (!regex.test(key)) 
                        {                    
                            event.preventDefault();
                            return false;
                        }
                    }
                    });

       $( document ).on('keypress',".name_validation",function(event) {   
                    var keyCode = event.keyCode || event.which;                  
                    if(keyCode!=9)
                    {                   
                        var regex = new RegExp("^[a-zA-Z. \b]+$");
                        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);                   
                        if (!regex.test(key)) 
                        {                    
                            event.preventDefault();
                            return false;
                        }
                    }
                    });



       $(document).on('change','#no_of_guests',function()
       {
          $('#booking_details_div').css('display','none');
       });

       $(document).on('change','#table_booking_time',function()
       {
          $('#booking_details_div').css('display','none');
       });

      $( document ).on('click',".search_table_booking",function(event) 
      {   
      		$('.booking_error_message').html('');
            var no_of_guests = $("#no_of_guests").val();                
            var date_booking = $('.date_booking').val();  
            var time_slot    = $.trim($('#table_booking_time option:selected').val());
            if(time_slot=='')
            {              
              return ;
            }
            var base_url     = $('#baseurl').val(); 
            var merchant_id  = $('#merchant_id').val();








            var url  = base_url+'/store/check_seat_availability'; 
            $('#timing_slots').html('');
            $('#booking_details_div').css('display','none');
            $.ajax({
                    type:'POST',
                    url : url , 
                    data: {no_of_guests:no_of_guests,date_booking:date_booking,time_slot:time_slot,merchant_id:merchant_id},
                    dataType:'json',
                    success:function(response)
                    {
                        if($.trim(response.Error_msg)!='')
                        {                          
                          $('.booking_error_message').html(response.Error_msg);
                          return;
                        }
                        if($.trim(response)!='')
                        {
                          $('#timing_slots').html('');
                          $('#user_already_visited').val('yes');
                          $('#timing_slots').css('display','block');		
                          var timing_html = '';
                          // alert(response.toSource);

                            $.each(response, function( key, value ) 
                            {                                
                                    /*  alert(key);                
                                      alert(value.toSource());                 */

                                      var disabled_type = '';

                                      var seats_available = value.seating_capacity+" seat Available";
                                     if(value.seating_capacity>1)
                                     {
                                        seats_available = value.seating_capacity+" seats Available";
                                     } 

                                     if(value.seating_capacity==0)
                                     {
                                     	seats_available = "No Seats Available";
                                     	disabled_type = 'disabled';
                                     }
                                      
                            timing_html +='<div class="col-lg-2">  <input value="'+value.slot_starting+'" class="btn btn-primary btn-block booking_buttons" onclick="select_booking_time(\''+key+'\',\''+value.seating_capacity+'\',\''+no_of_guests+'\')" type="button" '+disabled_type+' >  <span class="available_seats_span">'+seats_available+'</span>  </div>';

                            });

                            $('#timing_slots').append(timing_html);
                          /*   <div class="col-lg-2">
                                   <input value="Search" class="btn btn-primary btn-block search_table_booking" type="button">
                              </div> */

                        }
                        else
                        {
                             $('.booking_error_message').html("Sorry ! Please select a valid slot ");
                        }
                    }
            })   
      });
	
	var website_date_picker_format="yy-mm-dd";
    if ( $("#website_date_picker_format").exists()){
    	website_date_picker_format= $("#website_date_picker_format").val();
    }
    dump(website_date_picker_format);
    
    jQuery(".j_date").datepicker({ 
    	//dateFormat: 'yy-mm-dd' ,
    	dateFormat: website_date_picker_format,        
        altFormat: "yy-mm-dd",       
    	changeMonth: true,
    	changeYear: true ,	   
	    minDate: 0,
	    prevText: js_lang.datep_1,
		nextText: js_lang.datep_2,
		currentText: js_lang.datep_3,
		monthNames: [js_lang.January,js_lang.February,js_lang.March,js_lang.April,js_lang.May,js_lang.June,
		js_lang.July,js_lang.August,js_lang.September,js_lang.October,js_lang.November,js_lang.December],
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
		js_lang.Jul, js_lang.Aug, js_lang.Sep, js_lang.Oct, js_lang.Nov, js_lang.Dec],
		dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		dayNamesMin: [js_lang.Su,js_lang.Mo,js_lang.Tu,js_lang.We,js_lang.Th,js_lang.Fr,js_lang.Sa],						
		isRTL: false,
		onSelect : function( element, object ) {
			var original_id=$(this).data("id");
			dump(original_id);
			var altFormat = $(this).datepicker('option', 'altFormat');
			var currentDate = $(this).datepicker('getDate');
			var formatedDate = $.datepicker.formatDate(altFormat, currentDate);
			dump(formatedDate);
			$("#"+original_id).val(formatedDate);
		}
	});	
	jQuery(".j_date2").datepicker({ 
    	//dateFormat: 'yy-mm-dd' ,
    	dateFormat: website_date_picker_format,        
        altFormat: "yy-mm-dd",       
    	changeMonth: true,
    	changeYear: true ,	   
	    //minDate: 0,
	    prevText: js_lang.datep_1,
		nextText: js_lang.datep_2,
		currentText: js_lang.datep_3,
		monthNames: [js_lang.January,js_lang.February,js_lang.March,js_lang.April,js_lang.May,js_lang.June,
		js_lang.July,js_lang.August,js_lang.September,js_lang.October,js_lang.November,js_lang.December],
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
		js_lang.Jul, js_lang.Aug, js_lang.Sep, js_lang.Oct, js_lang.Nov, js_lang.Dec],
		dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		dayNamesMin: [js_lang.Su,js_lang.Mo,js_lang.Tu,js_lang.We,js_lang.Th,js_lang.Fr,js_lang.Sa],						
		isRTL: false,
		onSelect : function( element, object ) {
			var original_id=$(this).data("id");
			dump(original_id);
			var altFormat = $(this).datepicker('option', 'altFormat');
			var currentDate = $(this).datepicker('getDate');
			var formatedDate = $.datepicker.formatDate(altFormat, currentDate);
			dump(formatedDate);
			$("#"+original_id).val(formatedDate);
		}
	});	
	
	/** update 2.4 */
	var booking_mindate=1;	
	if ( $("#accept_booking_sameday").exists() ){
		if ( $("#accept_booking_sameday").val()==2){		
			booking_mindate=0;
		}
	}	
	/** update 2.4 */
	
	jQuery(".date_booking").datepicker({ 
		//dateFormat: 'yy-mm-dd' ,
		dateFormat: website_date_picker_format,        
        altFormat: "yy-mm-dd",       
		changeMonth: true,
		changeYear: true ,	   
	    minDate: booking_mindate,
        maxDate: '+1Y',
	    prevText: js_lang.datep_1,
		nextText: js_lang.datep_2,
		currentText: js_lang.datep_3,
		monthNames: [js_lang.January,js_lang.February,js_lang.March,js_lang.April,js_lang.May,js_lang.June,
		js_lang.July,js_lang.August,js_lang.September,js_lang.October,js_lang.November,js_lang.December],
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
		js_lang.Jul, js_lang.Aug, js_lang.Sep, js_lang.Oct, js_lang.Nov, js_lang.Dec],
		dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		dayNamesMin: [js_lang.Su,js_lang.Mo,js_lang.Tu,js_lang.We,js_lang.Th,js_lang.Fr,js_lang.Sa],						
		isRTL: false,
		onSelect : function( element, object ) {
      busy(true);    
			$('#timing_slots').css('display','none');
			$('.booking_error_message').html('');
			var original_id=$(this).data("id");
			dump(original_id);
			var altFormat = $(this).datepicker('option', 'altFormat');
			var currentDate = $(this).datepicker('getDate');
			var formatedDate = $.datepicker.formatDate(altFormat, currentDate);
			dump(formatedDate);
			$("#"+original_id).val(formatedDate);      

			if($("#hiddenFunction").exists())
			{			
              $('#booking_details_div').css('display','none');		  	
				      var booking_date = $('#date_booking1').val(); 
				      var merchant_id  = $('#merchant-id').val();
				      var base_url     = $('#baseurl').val();				       
				      var url          = base_url+"/store/get_merchant_timings";
				      var html         = '';
				      $.ajax({
				        url: url, // point to server-side PHP script 				        				        
				        type: 'post',
				        data: {booking_date:booking_date,merchant_id:merchant_id}, 	
//				        dataType: 'json',			        
				        success: function(php_script_response)
				        {
				          // alert(php_script_response.toSource()); // display response from the PHP script, if any


                  /* 
				          if($.trim(php_script_response)=='')
				          {
				          		   $("#booking_error_text").html(php_script_response.msg);
               			  		$("#booking_error").css('display','block'); 
				          }
				          else
				          {
				          	  
				          	  $('#table_booking_time').html('');
					          $.each(php_script_response, function( key, value ) 
					          { 
                       
					          	 if(key!="msg"||key!="opening_time")
					          	 {                            
                          if(value!='')
                          {
                            html += '<option value="'+key+'">'+value+'</option>';  
                          } 					          	   	
					          	 }	  					          	 
					          });

					          if(php_script_response.msg!='')
					          { 
					          	html += '<option value="">'+php_script_response.msg+'</option>';
					          }
					          $('#table_booking_time').html(html);
				          } */
					          
                    $('#table_booking_time').html('');
                    $('#table_booking_time').append(php_script_response);
				            busy(false);    

				        }
				      });
			}
		}
	});	
	
	
	var show_period=false;
	if ( $("#website_time_picker_format").exists() ){		
		if ( $("#website_time_picker_format").val()=="12"){
			show_period=true;
		}
	}
	
	if ( $("#theme_time_pick").val() ==""){		

    
		jQuery('.timepick').timepicker({              
      showPeriod: show_period,
			showMeridian:false,
			hourText: js_lang.Hour,       
			minuteText: js_lang.Minute,  
			amPmText: [js_lang.AM, js_lang.PM],
	    });	        

       jQuery('#booking_time').timepicker({
          /*showPeriod: true,
          showLeadingZero: true*/
        }); 


        var merchant_timings = $.trim($('.merchant_open_close_timings').val());             
        if(merchant_timings!='')
        {
            var result            = merchant_timings.split(',');               
            var current_time      = $.trim($('#delivery_time').val());               
            var d               = new Date();
            var month           = d.getMonth()+1;
            var day             = d.getDate();
            var current_date    = 
                ((''+month).length<2 ? '0' : '') + month + '/' +
                ((''+day).length<2 ? '0' : '') + day + '/' +
                d.getFullYear();        
            var minutes = ('0' + d.getMinutes()).slice(-2);                          
            var current_time = d.getHours() + ":" + minutes;    
             
            if(result[0]!='')
            {
                var merchant_timings_1 = result[0].split('-'); 
                /* alert(merchant_timings_1[0])  ;
                alert(merchant_timings_1[1])  ; */
                var current_date_time    = new Date(current_date +" " + current_time);
                var merchant_open   = new Date(current_date +" " + merchant_timings_1[0]);   
                var merchant_close  = new Date(current_date +" " + merchant_timings_1[1]);           
                 
                if(current_date_time<=merchant_open)
                {                      
                      var time = Date.parse(merchant_timings_1[0], "hh:mm tt");  
                      var newtime = time.addMinutes(50);
                      var newHour = newtime.getHours();
                      var newMins = newtime.getMinutes();
                      var newTT = 'AM';
                      if(newHour >= 12){
                         newHour = newHour - 12;
                         newTT = 'PM';
                      }
                     
                      if(newHour < 10){     
                         newHour ='0'+newHour;
                      }

                      if(newMins < 10){         
                         newMins ='0'+newMins;
                      }                      
                     //$('#delivery_time').val(newHour+':'+newMins+' '+newTT);   
                     // alert(newHour+':'+newMins+' '+newTT); 
                     $('.merchant_manual_changed_time').val(newHour+':'+newMins+' '+newTT);                       
                      ConvertTimeformat("24", newHour+':'+newMins+' '+newTT);   
                      $('.merchant_opening_time').val(merchant_timings_1[0]);                 
                     return ;  
                }                
                else if((current_date_time>=merchant_open)&&(current_date_time<=merchant_close)) 
                {
                     
                      var temp_time = Date.parse(current_time, "hh:mm tt");  
                      var time      = Date.parse(current_time, "hh:mm tt");  
                      var temp_newtime = temp_time.addMinutes(50);                                                                  
                      if(temp_newtime>merchant_close)
                      { 
                       var newtime = time.addMinutes(0);
                      }
                      else
                      {
                        var newtime = time.addMinutes(50);                                            
                      }                      
                      var newHour = newtime.getHours();
                      var newMins = newtime.getMinutes();
                      var newTT = 'AM';
                      if(newHour >= 12){
                         newHour = newHour - 12;
                         newTT = 'PM';
                      }                     
                      if(newHour < 10){     
                         newHour ='0'+newHour;
                      }
                      if(newMins < 10){         
                         newMins ='0'+newMins;
                      }
                      $('.merchant_manual_changed_time').val(newHour+':'+newMins+' '+newTT);   
                     //  alert(newHour+':'+newMins+' '+newTT); 
                     // $('#delivery_time').val(newHour+':'+newMins+' '+newTT);                                               
                     ConvertTimeformat("24", newHour+':'+newMins+' '+newTT);                    
                     return ; 
                }
              /*  var diff = (timeStart - timeEnd) / 60000; //dividing by seconds and milliseconds
                var minutes = diff % 60;
                var hours = (diff - minutes) / 60;   
                alert(hours +"   "+ minutes);                
                if(parseInt(hours)&&parseInt(minutes)>=0)                
                {                    
                    if(parseInt(hours)>0)
                    {                 
                      /*   var total_minutes = (parseInt(hours)*60)+minutes;
                        if(total_minutes>30)
                        {
                            
                        } */

                    /*   var time = Date.parse(current_time, "hh:mm tt");  
                      var newtime = time.addMinutes(50);
                      var newHour = newtime.getHours();
                      var newMins = newtime.getMinutes();
                      var newTT = 'AM';
                      if(newHour > 12){
                         newHour = newHour - 12;
                         newTT = 'PM';
                      }
                     
                      if(newHour < 10){     
                         newHour ='0'+newHour;
                      }

                      if(newMins < 10){         
                         newMins ='0'+newMins;
                      }
                     // alert(newHour+':'+newMins+' '+newTT); 
                     $('#delivery_time').val(newHour+':'+newMins+' '+newTT);  */
                     // $('#delivery_time').val();
                  /*   return ;
                    }                     
                } */
              }        
        if(typeof result[1]!='undefined'&result[1]!='')         
        {
            //var merchant_timings_1 = result[1].split('-'); 
            /* alert(merchant_timings_1[0])  ;
            alert(merchant_timings_1[1])  ; */
          /*  var timeStart           = new Date(current_date +" " + current_time);
            var merchant_start_time = new Date(current_date +" " + merchant_timings_1[0]);
            var timeEnd             = new Date(current_date +" " + merchant_timings_1[1]);               
            var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds
            var merchant_start_time_diff = ( merchant_start_time - timeStart) / 60000;            
            var minutes = diff % 60;
            var hours = (diff - minutes) / 60;                                                                                                      
            alert(hours +"   "+ minutes);
            if(parseInt(hours)&&parseInt(minutes)>0)                
            {
              if(parseInt(hours)>0)
              {                  
                      var time = Date.parse(merchant_timings_1[0], "hh:mm tt");  
                      var newtime = time.addMinutes(50);
                      var newHour = newtime.getHours();
                      var newMins = newtime.getMinutes();
                      var newTT = 'AM';
                      if(newHour > 12){
                         newHour = newHour - 12;
                         newTT = 'PM';
                      }
                     
                      if(newHour < 10){     
                         newHour ='0'+newHour;
                      }

                      if(newMins < 10){         
                         newMins ='0'+newMins;
                      }
                     // alert(newHour+':'+newMins+' '+newTT);
                     $('#delivery_time').val(newHour+':'+newMins+' '+newTT);
                     return; 


              } 
            } */
 
                var merchant_timings_1 = result[1].split('-'); 
                /* alert(merchant_timings_1[0])  ;
                alert(merchant_timings_1[1])  ; */
                var current_date_time    = new Date(current_date +" " + current_time);
                var merchant_open   = new Date(current_date +" " + merchant_timings_1[0]);   
                var merchant_close  = new Date(current_date +" " + merchant_timings_1[1]);                   
                if(current_date_time<merchant_open)
                {
                      var time = Date.parse(merchant_timings_1[0], "hh:mm tt");  
                      var newtime = time.addMinutes(50);
                      var newHour = newtime.getHours();
                      var newMins = newtime.getMinutes();
                      var newTT = 'AM';
                      if(newHour >= 12){
                         newHour = newHour - 12;
                         newTT = 'PM';
                      }
                     
                      if(newHour < 10){     
                         newHour ='0'+newHour;
                      }

                      if(newMins < 10){         
                         newMins ='0'+newMins;
                      }                      
                    // $('#delivery_time').val(newHour+':'+newMins+' '+newTT);        
                    $('.merchant_manual_changed_time').val(newHour+':'+newMins+' '+newTT);   
                    //  alert(newHour+':'+newMins+' '+newTT); 
                    ConvertTimeformat("24", newHour+':'+newMins+' '+newTT);      
                    $('.merchant_opening_time').val(merchant_timings_1[0]);               
                     return ;  
                }
                else 
                { 

                  if(merchant_close<merchant_open)
                  {                    
                     var days = 1;
                     merchant_close = new Date(merchant_close.getTime() + days*24*60*60*1000);
                  }


                  if((current_date_time>=merchant_open)&&(current_date_time<=merchant_close)) 
                  {                     
                        var temp_time = Date.parse(current_time, "hh:mm tt");  
                        var time      = Date.parse(current_time, "hh:mm tt");  
                        var temp_newtime = temp_time.addMinutes(50);                                                                  
                        if(temp_newtime>merchant_close)
                        { 
                         var newtime = time.addMinutes(0);
                        }
                        else
                        {
                          var newtime = time.addMinutes(50);                                            
                        }                      
                        var newHour = newtime.getHours();
                        var newMins = newtime.getMinutes();
                        var newTT = 'AM';
                        if(newHour >= 12){
                           newHour = newHour - 12;
                           newTT = 'PM';
                        }                     
                        if(newHour < 10){     
                           newHour ='0'+newHour;
                        }
                        if(newMins < 10){         
                           newMins ='0'+newMins;
                        }
                        $('.merchant_manual_changed_time').val(newHour+':'+newMins+' '+newTT);   
                       //  alert(newHour+':'+newMins+' '+newTT); 
                       // $('#delivery_time').val(newHour+':'+newMins+' '+newTT);                                               
                       ConvertTimeformat("24", newHour+':'+newMins+' '+newTT);                    
                       return ;
                  }
               } 

        }
        }
	   
	}
});	

$(window).scroll(function() {   
	
	if ( hl_get_scroll_position() ) {		
		$(".back-top").show();
	} else {		
		$(".back-top").fadeOut("slow");
	}
});

function ConvertTimeformat(format, str) {
    var time = str;
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = time.match(/\s(.*)$/)[1];
    if (AMPM == "PM" && hours < 12) hours = hours + 12;
    if (AMPM == "AM" && hours == 12) hours = hours - 12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if (hours < 10) sHours = "0" + sHours;
    if (minutes < 10) sMinutes = "0" + sMinutes;
    $('#delivery_time').val(sHours + ":" + sMinutes);
    // alert($('#merchant_manual_changed_time').val());
}


function select_booking_time(timings,seat_available,no_of_guests)
{
   
  $('.booking_error_message').html("");

  var display_time =  timings.split('-');
  var display_hours = '';
  hours = 0;
  if(display_time[0].length>0)
  { 	
  		display_hours =  display_time[0];
		hours = display_time[0].split(":");		
		if(hours[0].length>0)
		{
			hours = hours[0];
		}
  } 
  
  var ampm = hours >= 12 ? 'pm' : 'am'; 

  var no_of_guests = $("#no_of_guests").val();  
  seat_available = parseInt(seat_available);
  if(no_of_guests>seat_available)
  {
  	if(seat_available==0)
  	{
  		$('.booking_error_message').html("Sorry ! No Seats Available ");
  		// alert("Sorry ! No Seats Available ");
  	}
  	else
  	{
  		$('.booking_error_message').html(" Only "+seat_available+" seats Available");
  		// alert(" Only "+seat_available+" seats Available");	
      $('#booking_details_div').css('display','none'); 
  	}    
  }
  else
  {
   
   /*  02-10-2017 
   $('#no_of_guests').prop('disabled', 'disabled');
   $('.date_booking	').prop('disabled', 'disabled');
   $('#table_booking_time').prop('disabled', 'disabled');
   $('.search_table_booking').prop('disabled', 'disabled');
   $('.booking_buttons').prop('disabled', 'disabled'); */
   
   var booking_date = $('.date_booking').val();
   var booking_time = $("#table_booking_time option:selected").text();
   var user_time    = $("#table_booking_time option:selected").val();
   // var date_time    = booking_date+" "+display_hours+" "+ampm; 
   var date_time    = booking_date+" "+display_hours; 

   $('#user_selected_time').val(timings);
   $('#booking_date_time').val(date_time);
   $('#txt_no_of_guests').val(no_of_guests);
   $('#booking_date_time').prop('disabled', 'disabled');
   $('#txt_no_of_guests').prop('disabled', 'disabled');
   $('#booking_details_div').css('display','block'); 
  }
  // $('#booking_details_div').css('display','block');
}


function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}


function show_menu_div(display_type)
{
  $('.menu-right-content').css('display',display_type);
}


function validate() {     
  $("#result").text("");
  var email = $.trim($("#email").val());
  if (validateEmail(email)) {
    $("#result").text(" ");
    /*$("#result").css("color", "green"); */
  } else {
    $("#result").text(email + " is not a valid Mail ID");
    $("#result").css("color", "red");
    $('#result').css("margin-left","390px");
    return false;
  }
  
}



function hl_get_scroll_position()
{					
	var total_scrol_height=$(window).scrollTop() + $(window).height();				
	
	if( $(window).scrollTop() + $(window).height() == $(document).height()) {       		
	}			
	if ( total_scrol_height >= hl_end_content_pos){
		return true;
	}	
	return false;
}

function clear_elements(ele) {	
    $("#"+ele).find(':input').each(function() {						    	
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;            
            
        }
   });
   
   $(".preview").remove();
}

$.validate({ 	
	language  : jsLanguageValidator,
    form      : '#forms',    
    onError   : function() {      
    },
    onSuccess : function() { 
      var element = $("#forms").hasClass("profile-forms");  
      if(element)
      {
        form_submit('forms'); // Navaneeth change for not retrieving profile update form_submit();  
      }
      else
      {
        form_submit(); 
      }
      return false;
    }  
});

$.validate({ 	
	language  : jsLanguageValidator,
    form      : '#contact_forms',    
    onError   : function() {      
    },
    onSuccess : function() {     
      form_submit('contact_forms');
      return false;
    }  
});

/*$.validate({ 	
	language : jsLanguageValidator,
    form : '#forms-search',    
    onError : function() {      
    },
    onSuccess : function() {           
      return true;
    }  
});*/

$.validate({ 	
	language : jsLanguageValidator,
    form : '.form-signup',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('form-signup');
      return false;
    }  
});

$.validate({ 	
	language : jsLanguageValidator,
    form : '#frm-creditcard',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('frm-creditcard');
      return false;
    }  
});

$.validate({ 	
	language : jsLanguageValidator,
    form : '#frm-resume-signup',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('frm-resume-signup');
      return false;
    }  
});

$.validate({ 	
	language : jsLanguageValidator,
    form : '#frm-book',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('frm-book');
      return false;
    }  
});

/*$.validate({ 	
    form : '#frm-fooditem',    
    onError : function() {      
    },
    onSuccess : function() {           
      alert('d2');
      form_submit('frm-fooditem');
      return false;
    }  
});*/

$.validate({ 	
	language : jsLanguageValidator,
    form : '#frm-delivery',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('frm-delivery');
      return false;
    }  
});

function busy(e)
{
    if (e) {
        $('body').css('cursor', 'wait');	
    } else $('body').css('cursor', 'auto');        

    if (e) {    
        NProgress.set(0.0);		
        NProgress.inc();
    } else {    	
    	NProgress.done();
    }       
}

function scroll(id){
   if( $('#'+id).is(':visible') ) {	
      $('html,body').animate({scrollTop: $("#"+id).offset().top-100},'slow');
   }
}

function scroll_class(id){
   if( $('.'+id).is(':visible') ) {	
      $('html,body').animate({scrollTop: $("."+id).offset().top-100},'slow');
   }
}

function toogle(id , bool , caption)
{
    $('#'+id).attr("disabled", bool );
    $("#"+id).val(caption);
}

function rm_notices()
{
	$(".uk-alert").remove();		    
}

function form_submit(formid)
{		 
 	rm_notices();
	if ( formid ) {
		var form_id=formid;
	} else {
		var form_id=$("form").attr("id");    
	}    	    

	var btn=$('#'+form_id+' input[type="submit"]');   	
    var btn_cap=btn.val();
    btn.attr("disabled", true );
    btn.val(js_lang.processing);
    busy(true);    
    
    var params=$("#"+form_id).serialize();	
    
    var action=$('#'+form_id).find("#action").val(); 
    if ( action == "placeOrder" ){
    	params+="&cc_id="+$(".cc_id:checked").val();
      params+="&deals_discount="+$("#hidden_deals_discount").val();
    }    	
    
    if ( action == "merchantPayment" ){
    	params+="&cc_id="+$(".cc_id:checked").val();
    }    	

    if ( action=="addReviews"){
    	if ( $("#initial_review_rating").val()=="" ){
    		uk_msg(js_lang.trans_1);    		
    		busy(false);  
        	btn.attr("disabled", false );
        	btn.val(btn_cap);        	
    		return;
    	}    	
    }              
    switch(action)
    {    	
    	case "clientLogin":
    	case "clientLoginModal":
    	case "merchantSignUp":    	
    	case "merchantSignUp2":
    	if ( $("#RecaptchaField1").exists() ){
    		var googleResponse = $("#RecaptchaField1").find(".g-recaptcha-response").val();    		
    		if (!googleResponse) {
    			busy(false); 
	    		uk_msg(js_lang.trans_52);                 
	            btn.attr("disabled", false );
		        btn.val(btn_cap);
		        busy(false);        	    	
		    	return;
    		}
    	}
    	break;
    	    	
    	case "clientRegistrationModal":
    	case "clientRegistration":
    	if ( $("#RecaptchaField2").exists() ){
    		var googleResponse = $("#RecaptchaField2").find(".g-recaptcha-response").val();    		
    		dump(googleResponse);
    		if (!googleResponse) {
    			busy(false); 
	    		uk_msg(js_lang.trans_52);                 
	            btn.attr("disabled", false );
		        btn.val(btn_cap);
		        busy(false);        	    	
		    	return;
    		}
    	}
    	break;
    	
    	case "placeOrder":
    	  $(".place_order").css({ 'pointer-events' : 'none' });
    	break;
    }
    
    if(action=="price_promise")
    {
      var formData = new FormData();
      formData.append('file', $('input[type=file]')[0].files[0]);
      params+="&formData="+formData;
    } 
 	
 	if(action=="bookATableNewconcept")
    {      
      $('#invalid_mobile_number').html("");
      $('#invalid_email').html("");


      var email = $('#email').val();
      if(!validateEmail(email))
      {
        busy(false); 
        $('#invalid_email').html("Please enter valid Email");
        $('.btn-primary').prop("disabled", false); 
        $('.btn-primary').attr('value','Submit'); 
        return ;
      }  




      var mobile_number = $('.mobile_number_val').val().replace(/ /g,'');
      if(mobile_number.length<13)
      {
         busy(false); 
         $('#invalid_mobile_number').html("Please enter valid Number");
         $('.btn-primary').prop("disabled", false); 
         $('.btn-primary').attr('value','Submit'); 
         return;
      }    

      var user_selected_time = $('#user_selected_time').val();
      var selected_date      = $('.date_booking').val();
      var no_of_guests       = $('#txt_no_of_guests').val();   
      params+="&user_selected_time="+user_selected_time+"&selected_date="+selected_date+"&no_of_guests="+no_of_guests;
    } 

    dump(action);
     
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){  
        	busy(false);  
        	btn.attr("disabled", false );
        	btn.val(btn_cap);        	
        	//scroll(form_id);

        	if (data.code==1){
        		
        		/*$("#"+form_id).before("<p class=\"uk-alert uk-alert-success\">"+data.msg+"</p>");
        		setTimeout(function () {
                   $(".uk-alert-success").fadeOut();
                }, 4000);  */
        		
        		uk_msg_sucess(data.msg);
        		
        		if(action=="ItemBankDepositVerification"){
        			$(".box-grey").html( "<p class=\"bg-success\">"+data.msg+"</p>"  );
        			return;
        		}  		
        		if (action=="forgotPassword"){
              $("#username-email").val('');
        			if ( $(".checkout-page").exists()){
         				$(".section-forgotpass").hide();        				
        				return;
        			}else{ 
					   //$(".modal-backdrop").hide();
 					    $("#login-popup").modal('hide');
						$("#register-popup").modal('hide');
						$("#forgot-popup").modal('hide');
						//setTimeout(function(){ window.location.href = window.location.href},2000); username-email
					}
        		} 
				if ( action=="addAddressBook"){
					 $("#add_address").modal('hide');
        			 window.location.href=sites_url+"/store/profile";
        		} 
        		if ( action=="clientRegistration"){
        			if ( $("#verification").exists() ){
        				window.location.href=sites_url+"/store/verification/checkout/true/id/"+data.details;
        				return;
        			}  
        			if ( $("#theme_enabled_email_verification").exists() ){
        				window.location.href=sites_url+"/store/emailverification/checkout/true/id/"+data.details;
        				return;
        			}  
        		} 
        		if ( $("#redirect").length>=1 ){
        			if (typeof data.details === "undefined" || data.details==null ) {        			    		
        			    window.location.replace(  $("#redirect").val() );
        			} else {
        				window.location.replace(  $("#redirect").val()+"/id/"+data.details );
        			}
        		}
        		
        		if( action=="verifyMobileCode" || action=="verifyEmailCode"){        			
        			if ( $("#redirect").exists() ){
        				window.location.href=$("#redirect").val();
        				return;
        			}          			
        			window.location.href=home_url;
        			return;
        		} 
        		if ( action=="clientLogin"){
        			if ( $("#single_page").exists() ){
	        			window.location.href=sites_url+"/store";
	        			return;
        			}
        		}  
        		if ( action=="subscribeNewsletter"){
        			$("#subscriber_email").val("");
        		}        	
        		
        		if ( action=="bookATable" || action=="bankDepositVerification" ){
        			clear_elements('frm-book');
              //$('#booking_success').html('Your Table Booking Order has been sent to Merchant ... ');
              if (action=="bookATable")
              {
                $('#booking_error').css('display','none');  
                $('#booking_success').css('display','block');  
              }
              
        		}
        		if (action=="bankDepositVerification"){
        			clear_elements('forms');
        		}        	
        		
        		if(action=="bookATableNewconcept")
			    {
			    	//  window.location.reload(true);
           /*      setTimeout(function() 
                 {
                    window.location.reload(true);
				 }, 2000); */
					window.location.href = sites_url +"/store/Booking_confirmation";
                 // setTimeout(function () { if (self.name != 'refreshed'){ self.name = 'refreshed'; window.location.reload(true); } else { self.name = ''; } }, 3000);
			    }

        		if ( action=="addToCart" ){
        			
        			if (  $(".back-mobile").exists() ){
        				dump('back-mobile');
        				var back_url=$(".back-mobile").attr("href");
        				dump(back_url);
        				window.location.href=back_url;
        				return;
        			} 
        			close_fb();
					$('#myModal_add_cart').modal('hide');
        			load_item_cart();
        		}        		        	
        		
        		if ( action=="addCreditCard"){
        			load_cc_list();
        		}
        		
        		if ( action=="addCreditCardMerchant"){
        			load_cc_list_merchant();
        		}
        		
        		if ( action == "placeOrder" ){
        			console.debug(data.details.payment_type);
        			if ( data.details.payment_type =="pyp" || data.details.payment_type =="paypal"){
        				window.location.replace(sites_url+"/store/paypalInit/id/"+data.details.order_id);
        			}
					else if(data.details.payment_type =="cpy" || data.details.payment_type =="CityPay" )	{
        				window.location.replace(sites_url+"/store/citypayInit/id/"+data.details.order_id);
        			}  
					
					else if (data.details.payment_type == "cpn" || data.details.payment_type == "chippin") {
						window.location.replace(sites_url + "/store/chippinInit/id/" + data.details.order_id);
					}

					 else if(data.details.payment_type =="stp" || data.details.payment_type =="stripe" )	{
        				window.location.replace(sites_url+"/store/stripeInit/id/"+data.details.order_id);
        			} else if(data.details.payment_type =="mcd" || data.details.payment_type =="mercadopago" )	{
        				window.location.replace(sites_url+"/store/mercadoInit/id/"+data.details.order_id);	
        			} else if(data.details.payment_type =="pyl")	{
        				window.location.replace(sites_url+"/store/paylineinit/id/"+data.details.order_id);		
        			} else if(data.details.payment_type =="ide")	{
        				window.location.replace(sites_url+"/store/sisowinit/id/"+data.details.order_id);			
        			} else if(data.details.payment_type =="payu")	{
        				window.location.replace(sites_url+"/store/payuinit/id/"+data.details.order_id);			
        			} else if(data.details.payment_type =="pys")	{
        				window.location.replace(sites_url+"/store/payserainit/id/"+data.details.order_id);					
        			} else if(data.details.payment_type =="bcy")	{
        				window.location.replace(sites_url+"/store/bcyinit/id/"+data.details.order_id);					
        			} else if(data.details.payment_type =="epy")	{
        				window.location.replace(sites_url+"/store/epyinit/id/"+data.details.order_id);						
        			} else if(data.details.payment_type =="atz")	{
        				window.location.replace(sites_url+"/store/atzinit/id/"+data.details.order_id);	
        			/*braintree*/	
        			} else if(data.details.payment_type =="btr")	{
        				window.location.replace(sites_url+"/store/btrinit/id/"+data.details.order_id);						
        			} else{
        				window.location.replace(sites_url+"/store/receipt/id/"+data.details.order_id);
        			}        			
        		}        		        
        		
        		if ( action=="clientLoginModal"){        			
        			load_top_menu();
        			close_fb();
        		}
        		
        		if ( action=="clientRegistrationModal"){
        			        			
        			if ( $("#verification").exists() ){
        				window.location.href=sites_url+"/store/verification/id/"+data.details;
        				return;
        			}                			
        			if ($("#theme_enabled_email_verification").exists()){
        				window.location.href=home_url+"/emailverification/id/"+data.details;
        				return;
        			}		
        			
        			if ( $("#single_page").exists() ){
        				window.location.href=sites_url;
        			} else {        		
	        			load_top_menu();
	        			close_fb();
        		    }
        		}
        		        		        		
        		if ( action=="addReviews"){
        			//uk_msg_sucess(data.msg);
        			load_reviews();
        			//load_ratings();
        			//$(".write-review").addClass("active");
        			$(".review-input-wrap").slideToggle("fast");
        			$("#review_content").val('');
        			$('.raty-stars').raty({ 
        			   score:0,
					   readOnly: false, 		
					   path: sites_url+'/assets/vendor/raty/images',
					   click: function (score, evt) {
					   	   $("#initial_review_rating").val(score);
					   }
			        });    
        			return;
        		}
        		
        		if ( action=="updateReview"){        			
        			load_reviews();
        			close_fb();
        		}
        		
        		if ( action=="paypalCheckoutPayment"){
        			window.location.replace(sites_url+"/store/receipt/id/"+data.details.order_id);
        		}
        		
        		/*merchant signup*/
        		
        		if (action=="merchantSignUp"){
        			window.location.replace(sites_url+"/store/merchantsignup/Do/step3/token/"+data.details);
        			/*if ( $("#merchant_email_verification").val()=="yes" ){
        				window.location.replace(sites_url+"/store/merchantSignup/Do/thankyou/token/"+data.details);
        			} else {
        				window.location.replace(sites_url+"/store/merchantSignup/Do/step3/token/"+data.details);
        			}*/
        		}
        		
        		if ( action=="merchantSignUp2"){
        			window.location.replace(sites_url+"/store/merchantsignup/Do/thankyou2/token/"+data.details);
        		}
        		        		
        		if ( action=="merchantPayment"){        			
        			if ($("#renew").val()==1 && $("#payment_opt:checked").val() =="ocr" ){
        				window.location.replace(sites_url+"/store/renewSuccesful");
        			} else {
	        			/*if ( $("#merchant_email_verification").val()=="yes" ){   	        				
window.location.replace(sites_url+"/store/merchantSignup/Do/thankyou2/token/"+$("#token").val());
	        			} else {        			           			          			   	        			   */
	        			   switch ( $("#payment_opt:checked").val() )
	        			   {
	        			   	   case "pyp":
	        			   	   case "stp":
	        			   	   case "mcd":
	        			   	   case "pyl":
	        			   	   case "ide":
	        			   	   case "payu":
	        			   	   case "obd":
	        			   	   case "pys":
	        			   	   case "bcy":
	        			   	   case "epy":
	        			   	   case "atz":
	        			   	   case "btr":
	        			   	   //window.location.replace(data.details);
	        			   	   window.location.href=data.details;
	        			   	   break;
	        			   	   default:
	        			   	   //window.location.replace(sites_url+"/store/merchantSignup/Do/step4/token/"+data.details);
	        			   	   window.location.href=sites_url+"/store/merchantsignup/Do/step4/token/"+data.details;
	        			   	   break;
	        			   }
	        			//}        			
        			}	
        		}

                if(action=="contacUsSubmit")
                {
                    setTimeout(function(){ window.location.reload(); }, 3000);
                }
        		
        		if ( action=="merchantPaymentPaypal"){
        		    if ($("#renew").val()==1){
        				window.location.replace(sites_url+"/store/renewSuccesful");
        		    } else {		
	        			if ( $("#merchant_email_verification").val()=="yes" ){
	        				window.location.replace(sites_url+"/store/merchantsignup/Do/thankyou2/token/"+data.details);
	        			} else {
	        				window.location.replace(sites_url+"/store/merchantsignup/Do/step4/token/"+data.details);
	        			}
        		    }
        		}
        		
        		if (action=="activationMerchant"){
        			window.location.replace(sites_url+"/store/merchantsignup/Do/thankyou1/token/"+data.details);
        		}
        		
        		if ( action=="changePassword"){
                    var base_url = $('#base_url').val();                     
        			$(".change-pass-btn").attr("disabled",true);
        			$(".change-pass-btn").css({"opacity":"0.5"});
                    setTimeout(function(){ window.location.href=base_url; }, 3000);
        		}        		
        		        	
        		if ( action=="merchantResumeSignup"){
        			window.location.replace(data.details);
        			return;
        		}
        		
        		if (action=="setAddress"){
        			//console.debug("setAddress");
        			window.location.reload();
        			return;
        		}
        			
        	} else if ( data.code==3 ) {           //  data.code==1 closes here
        		 if ( action=="clientLogin"){
        		 	window.location.href=sites_url+"/store/verification/id/"+data.details;
        		 } else {
        		 	uk_msg(data.msg);
        		 }
        	} else if ( data.code==4 ) {
        		 if ( action=="clientLogin"){
        		 	window.location.href=sites_url+"/store/emailverification/id/"+data.details;
        		 } else {
        		 	uk_msg(data.msg);
        		 }
        	} else {
        		//$("#"+form_id).before("<p class=\"uk-alert uk-alert-danger\">"+data.msg+"</p>");
        		/*$("#"+form_id).before("<p class=\"uk-alert uk-alert-danger\">"+data.msg+"</p>");
        		setTimeout(function () {
                   $(".uk-alert-danger").fadeOut();
                }, 4000);        	*/
        		
        		if ( action=="bookATable"){
              $('#booking_success').css('display','none');  
               $("#booking_error_text").html('');
               $("#booking_error_text").html(data.msg);
               $("#booking_error").css('display','block');        		   
        		}
        		
            if ( action=="placeOrder"){
               $(".place_order").css({ 'pointer-events' : 'auto' });
            }

        		uk_msg(data.msg);
        	}
        	//scroll_class('uk-alert');
        }, //success function closing 
        error: function()
        {	                 	
        	btn.attr("disabled", false );
        	btn.val(btn_cap);
        	busy(false);        	
        	//$("#"+form_id).before("<p class=\"uk-alert uk-alert-danger\">ERROR:</p>");
        	/*$("#"+form_id).before("<p class=\"uk-alert uk-alert-danger\">ERROR</p>");
    		setTimeout(function () {
               $(".uk-alert-danger").fadeOut();
            }, 4000);        	
        	scroll_class('uk-alert');*/
        	$(".place_order").css({ 'pointer-events' : 'auto' });
        	uk_msg("ERROR");
        }		// error message closing 
    });
} // function closes

var otable;

jQuery(document).ready(function() {	



  $('#upload').on('click', function() 
  {
      var file_data = $('#sortpicture').prop('files')[0]; 
      var form_data = new FormData(); 
      form_data.append('file', file_data);       
      $.ajax({
        url: 'upload.php', // point to server-side PHP script 
        dataType: 'text', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data, 
        type: 'post',
        success: function(php_script_response)
        {
          alert(php_script_response); // display response from the PHP script, if any
        }
      });
  });

  /* var bootstrapTooltip = $.fn.tooltip.noConflict();
  $.fn.bstooltip = bootstrapTooltip;
  // bootstrapTooltip => Bootstrap; $.fn.tooltip => jQuery UI Tooltip
  console.log(bootstrapTooltip, $.fn.tooltip); 
    $( document ).bstooltip(); */
  $( document ).tooltip();

	if( $('#table_list').exists() ) {    	
    	table();    	
    } 
        
    if( $('.chosen').is(':visible') ) {     
     //$(".chosen").chosen(); 
       $(".chosen").chosen({
       	  allow_single_deselect:true,
       	  no_results_text: js_lang.trans_33,
          placeholder_text_single: js_lang.trans_32, 
          placeholder_text_multiple: js_lang.trans_32
       });     
    } 
    
    /*if ( $(".icheck").exists() ) {
	     $('.icheck').iCheck({
	       checkboxClass: 'icheckbox_minimal',
	       radioClass: 'iradio_flat'
	     });
    }*/
    
    if( $('#bar-rating').is(':visible') ) {	
    	
	    $('#bar-rating').barrating('show', {
	    	initialRating: $("#initial_rating").val(),
	        showValues:false,
	        showSelectedRating:true,        
	        onSelect:function(value, text) {	            
	        	if( $('#review_content').is(':visible') ) {		        	
	        		$("#initial_review_rating").val(value)
	        	} else {	        		
	        		$("#initial_review_rating").val(value)
	        		//add_rating(value, $("#merchant_id").val() );
	        	}		        	           
	        }
	    });
	            
	    var x=1;
        $( ".br-widget a" ).each(function( index ) {
        	$(this).addClass("level-"+x++);
        });
    }
           
    $( document ).on( "click", ".menu-category", function() {
    	var i=$(this).find("i");
    	if (i.hasClass("fa-chevron-up")){
    		i.removeClass("fa-chevron-up");
    		i.addClass("fa-chevron-down");
    	} else {
    		i.addClass("fa-chevron-up");
    		i.removeClass("fa-chevron-down");
    	}
        var parent=$(this).parent();
    	var ul=parent.find("ul");    	
    	ul.slideToggle("fast");
    });
    
    $( document ).on( "click", ".menu-item", function() {
    	
    	/*if ( !$(".order-list-wrap").exists()){
    		return;
    	} */
    	    	
    	/** check if the item is available*/
		
		//alert('1');
		
    	if ( $(this).hasClass("item_not_available")){
    		uk_msg(js_lang.trans_51);
    		return;
    	}    
    	    	
    	if ( $("#merchant_close_store").exists() ){	
    		if  (  $("#merchant_close_store").val()=="yes"){
    			var close_msg=$("#merchant_close_msg").val();
		        uk_msg(close_msg);
		        return;
    		}
    	}	
    	
    	/** auto add item if food is single  if(strcmp(strtolower($price['size']), $selected_item)||($size_words==$price['size'])) { $checked_box  = true; echo $selected_item }*/
    	var id=$(this).attr("rel");
    	
    	var single=$(this).data("single");  

      var identity = $(this).data("identity");         

    	if ( single==2){    
    		if ( $("#website_disbaled_auto_cart").val()!="yes"){		    			
    			if ( $("#disabled_website_ordering").val()=="yes"){    				 		
    				return;
    			}    	
	    		single_food_item_add(id, $(this).data("price"), $(this).data("size") );	
	    		return;
    		}
    	}

    	    
    	if ( $(this).hasClass("mbile")){      
    	    var mbile_url=home_url+"/item/?item_id="+id+"&mtid="+ $("#merchant_id").val();
    	    mbile_url+= "&slug="+$("#restaurant_slug").val();          
    	    window.location.href=mbile_url;
    		return;
    	}
    	
    	var params="action=viewFoodItem&currentController=store&item_id="+id+"&tbl=viewFoodItem&source=clicking&identity="+identity;
    	//open_fancy_box(params);
		open_modal_box(params);
    }); 
	
	
	//this is for address add and edit
	$( document ).on( "click", ".address_add_btn", function() { 

          //  $('#enter_zipcode_div').css('display','none');     
           
          $('#user_slt_address').html('<option value="" disabled="" selected="">Select Address</option>');       
  	        $('#frm-addressbook').on('reset', function() {
				  var $form = $(this);
				  $form.find('.error,.valid').css('border-color', '').removeClass('error').removeClass('valid');
				  $form.find('.form-error').remove();
			});
 			document.getElementById('frm-addressbook').reset();  
 			$('.addr_save_btn').text('Submit');
  	        var tbl_id = $(this).attr('tbl_id');
 	        if(tbl_id == 0){
				$('#add_address').modal('show');
        $('#user_profile_addr').css('display','none');
			}else if(tbl_id > 0){
        $('#user_profile_addr').css('display','block');

        $("#postcode").removeAttr("data-validation");        

				$('.addr_save_btn').text('Update');
				var params="action=addressDetails&currentController=store&tbl_id="+tbl_id;       
				busy(true);
				$.ajax({    
					type     : "POST",
					url      : ajax_url,
					data     : params,     
					dataType : 'json', 
					success  : function(data){ 
						       busy(false);  
							  // var detls = data.details;
 							  $('#add_tbl_update_id').val(data.id);
 							  $('#street').val(data.street);
							  $('#city').val(data.city);
							  $('#state').val(data.state);
							  $('#zipcode').val(data.zipcode);
							  $('#location_name').val(data.location_name);
 							  //$('#country_code').selectpicker('val', data.country_code); 
 							  $('#country_code').val(data.country_code);
							  if(data.as_default == 2){ 								  
								  $('#as_default').parent().addClass('checked');
							  } 							  
							  $('#add_address').modal('show');
 					}, 
					error: function(){	        	    	
						busy(false); 
					}		
				});  
			} 
    });  
	
	//this is for address add and edit
	$( document ).on( "click", ".clientcc_add_btn", function() { 
 	        //$('#addnew_card').modal('show'); exit();
   	        $('#frm-cc').on('reset', function() {
				  var $form = $(this);
				  $form.find('.error,.valid').css('border-color', '').removeClass('error').removeClass('valid');
				  $form.find('.form-error').remove();
			});
 			document.getElementById('frm-cc').reset();  
 			$('.ccaddbtn').text('Submit');
  	        var tbl_id = $(this).attr('tbl_id');
 	        if(tbl_id == 0){
				$('#addnew_card').modal('show');
			}else if(tbl_id > 0){
				$('.ccaddbtn').text('Update');
				var params="action=ClientCcDetails&currentController=store&tbl_id="+tbl_id;
				busy(true); 
 				$.ajax({    
					type     : "POST",
					url      : ajax_url,
					data     : params,     
					dataType : 'json', 
					success  : function(data){ 
						       busy(false);  
							  // var detls = data.details;
 							  $('#addcc_tbl_update_id').val(data.cc_id);
 							  $('#card_name').val(data.card_name);
							  $('#credit_card_number').val(data.credit_card_number);
							 // $('#expiration_month').selectpicker('val', data.expiration_month); 
							  //$('#expiration_yr').selectpicker('val', data.expiration_yr); 
 							  $('#billing_address').val(data.billing_address);
							  $('#cvv').val(data.cvv);  				  
							  $('#addnew_card').modal('show');
 					}, 
					error: function(){	        	    	
						busy(false); 
					}		
				});  
			} 
    });  
	 
    
    $( document ).on( "click", ".edit_item", function() { 
    	if ( $(".pts_amount").is(':visible') ){
    		uk_msg_sucess(js_lang.you_cannot_edit_order);
    		return;
    	}    
    	var id=$(this).attr("rel");
      var identity=$(this).attr("identity");
    	var row=$(this).data("row");
    	var params="action=viewFoodItem&currentController=store&item_id="+id+"&tbl=viewFoodItem&row="+row+"&identity="+identity;
    	//open_fancy_box(params);
		open_modal_box(params);
    });
    
   /* $(".view-item-wrap").niceScroll( {
    	cursorcolor:"#E57871",
    	cursorwidth:"7px",
    	autohidemode:"leave"  
    });
    
   $(".view-item-wrap").mouseover(function() {
      $(".view-item-wrap").getNiceScroll().resize();
   });*/
    
   //$('.numeric_only').keyup(function () {     
   $( document ).on( "keyup", ".numeric_only", function() {
      this.value = this.value.replace(/[^0-9\.]/g,'');
   });	 
      
   $( document ).on( "click", ".special-instruction", function() {
   	  $(".notes-wrap").slideToggle("fast");
   });
      
   $( document ).on( "click", ".qty-plus", function() 
   {    
      if(parseFloat($("#qty").val()) < 99999)  
       { 
       	  var qty=parseFloat($("#qty").val())+1;
         	////console.debug(qty);
        	if (isNaN(qty)){qty=1;} 
        	$("#qty").val(qty);                                     
          $(".sub_item_name:checked").each(function() 
            { 
               $(this).parent().next("div").find(".quantity-wrap-small").find(".addon_qty").val(qty);
            });
       }
       else
       {
        
       } 
   });
    
   $( document ).on( "click", ".qty-minus", function() 
   {
   	    var qty=$("#qty").val()-1;
     	if (qty<=0){qty=1;}
    	$("#qty").val(qty);       
      $(".sub_item_name:checked").each(function() 
      { 
         $(this).parent().next("div").find(".quantity-wrap-small").find(".addon_qty").val(qty);
      });
   }); 
   
   $( document ).on( "click", ".qty-addon-plus", function() {
   	   var parent=$(this).parent().parent();   	   
   	   var child=parent.find(".addon_qty");   	   
   	   var qty=parseFloat(child.val())+1;   	   
   	   if (isNaN(qty)){
    	    qty=1;
       }
       child.val( qty );
   });
   
   $( document ).on( "click", ".qty-addon-minus", function() {
   	   var parent=$(this).parent().parent();   	   
   	   var child=parent.find(".addon_qty");   	      
   	   var qty=parseFloat(child.val())-1;
       if (qty<=0){
    		qty=1;
       }
       child.val( qty );
   });
      
   $( document ).on( "click", ".sub_item_name", function() 
   {   	   
   	   var addon_type=$(this).attr("rel");
   	   
   	   if ( addon_type=="multiple"){
	   	   var parent=$(this).parent().parent();	   	    
		   var child=parent.find(".quantity-wrap-small");
	   	   if ($(this).is(":checked")){   	   	  
		   	    child.show();
	   	   } else {
	   	   	  //  child.hide();
	   	   }   
   	   }
   	      	     
   	   if ( addon_type=="custom")
       {   	   	 
   	   	  var data_id=$(this).data("id");
   	   	  var data_option=$(this).data("option");   	   	  
   	   	  var total_multi_selected=$(".sub_item_name_"+data_id+":checked").length;   	   	  
   	   	  if ( data_option == ""){
   	   	  	  return;
   	   	  }   	   
   	   	  if ( total_multi_selected > data_option  ){   	   	  	  
	       	  uk_msg(js_lang.trans_2+" "+" "+ data_option +" "+js_lang.trans_3);  	  
   	   	  	  $(this).attr("checked",false);
   	   	  }   	   
   	   }   

       $(this).parent().next("div").find(".quantity-wrap-small").find(".addon_qty").val($('#qty').val());
   });
   
   
   $( document ).on( "click", ".add_to_cart", function() {   	   
   	   //var price=$("#price:checked").length;

       if($('.qty').val()>0)
       {
   	   var price=$(".item_price:checked").length;   	   
   	   console.debug(price);
   	   if (price<=0){
   	   	   if ( !$("#two_flavors").exists()) {
   	   	      uk_msg(js_lang.trans_29);
   	   	      $("#price_wrap").focus();
   	   	      return;
   	   	   }
   	   }  
   	   
   	   /** two flavors 
   	   if ( $("#two_flavors").exists()) {   	   	  
   	   	  var sub_item=$(".sub_item:checked").length;   	   	  
   	   	  dump(sub_item);
   	   	  if ( sub_item<2){
   	   	  	  uk_msg(js_lang.trans_46);   	   	      
   	   	      return;
   	   	  }   	   
   	   }
   	   
   	   /** check if addon is required */
   	   if ( $(".require_addon").exists()){
   	   	   
   	   	   $(".req_addon_msg").remove();
   	   	   
   	   	   var addon_err='';
   	   	   $('.require_addon').each(function () {
   	   	   	   if ( $(this).val()==2 ) {
	   	   	   	   var required_addon_id=$(this).data("id");
	   	   	   	   var required_addon_name=$(this).data("name");
	   	   	   	   dump(required_addon_id);
	   	   	   	   var required_addon_selected=$(".sub_item_name_"+required_addon_id+":checked").length; 
	   	   	   	   dump(required_addon_selected);
	   	   	   	   if ( required_addon_selected <=0){
	   	   	   	   	   addon_err=js_lang.trans_47+" - "+required_addon_name +"<br/>";
	   	   	   	   	   $(".require_addon_"+required_addon_id).after(
	   	   	   	   	   "<p class=\"req_addon_msg text-danger text-small top10\">"+addon_err+"</p>").fadeIn("slow");
	   	   	   	   }   	   	   	   
   	   	   	   }
   	   	   });
   	   	   
   	   	   if ( addon_err!=""){
   	   	   	   uk_msg(addon_err);
   	   	   	   return;
   	   	   }   	   
   	   }   	      	   
   	   form_submit('frm-fooditem');
    }
    else
    {
        return false;
    }
   });
   
   if( $('.item-order-wrap').is(':visible') ) {	    
      load_item_cart();
   }
      
   $( document ).on( "click", ".delete_item", function() {    	
   	
        if ( $(".pts_amount").is(':visible') ){
    		uk_msg_sucess(js_lang.you_cannot_edit_order);
    		return;
    	}    
    	
   	   var ans=confirm(js_lang.trans_4); 
   	   if (ans){      
   	       var row=$(this).data("row");   	   
   	       delete_item(row);
   	   }
   });

  

   $( document ).on( "click", ".delete_sub_item", function() {      
    
        if ( $(".pts_amount").is(':visible') ){
        uk_msg_sucess(js_lang.you_cannot_edit_order);
        return;
      }    
      
       var ans=confirm(js_lang.trans_4); 
       //alert(ans);
       if (ans){      
           var row=$(this).data("row");    
           var cat_id=$(this).data("rel");        
           delete_topping_item(row,cat_id);
       }
   });

     
      
   $( document ).on( "click", ".edit_item", function() { 
   	   var row=$(this).data("row");
   	   ////console.debug(row);
   });
      
   /************** CHECK OUT ***************/
   
   $( document ).on( "click", ".checkout", function() {    	  
   	 
     $('.has-error').html('');  	

   	 var subtotal= parseFloat($("#subtotal_order").val());
   	 
   	 /*check if delivery/pickup date is empty*/   	 
   	
   	 if ( $("#delivery_type").val()=="delivery"){
	   	  if ( $("#minimum_order").length>=1){   	  	  
	   	  	  var minimum= parseFloat($("#minimum_order").val());	   	  	  
	   	  	  if (isNaN(subtotal)){
	   	  	  	  subtotal=0;
	   	  	  }   	     	  	  
	   	  	  if (isNaN(minimum)){
	   	  	  	  minimum=0;
	   	  	  }   	     	  	  
	   	  	  if ( minimum>subtotal){                    	  	
	              uk_msg(js_lang.trans_5+" "+ $("#minimum_order_pretty").val());
                $('.has-error').html(js_lang.trans_5+" "+ $("#minimum_order_pretty").val());
	   	  	  	  return;
	   	  	  }      	  	  
	   	  	  
	          if ( $("#merchant_maximum_order").exists() ){
	    	      console.debug("max");
	    	      var merchant_maximum_order= parseFloat($("#merchant_maximum_order").val());    	      
	    	      if ( subtotal>merchant_maximum_order){
	    	      	  uk_msg(js_lang.trans_31+" "+ $("#merchant_maximum_order_pretty").val());
                  $('.has-error').html(js_lang.trans_31+" "+ $("#merchant_maximum_order_pretty").val());
	   	  	  	      return;
	    	      }              	      
	          }   	  	     	  	  
	   	  }  
   	 }
   	 
   	 if ( $("#delivery_type").val()=="pickup"){   	     
   	 	   	 	 
   	     if ( $("#merchant_minimum_order_pickup").exists()){
   	     	  var minimum= parseFloat($("#merchant_minimum_order_pickup").val());	   	  	  
	   	  	  if (isNaN(subtotal)){
	   	  	  	  subtotal=0;
	   	  	  }   	     	  	  
	   	  	  if (isNaN(minimum)){
	   	  	  	  minimum=0;
	   	  	  }   	     	  	  
	   	  	  if ( minimum>subtotal){   	  	  	
	              uk_msg(js_lang.trans_5+" "+ $("#merchant_minimum_order_pickup_pretty").val());
                $('.has-error').html(js_lang.trans_5+" "+ $("#merchant_minimum_order_pickup_pretty").val());
	   	  	  	  return;
	   	  	  }      	  	  
   	     }   	 
   	     
   	     if ( $("#merchant_maximum_order_pickup").exists() ){
   	     	  var merchant_maximum_order= parseFloat($("#merchant_maximum_order_pickup").val());    	      
    	      if ( subtotal>merchant_maximum_order){
    	      	  uk_msg(js_lang.trans_31+" "+ $("#merchant_maximum_order_pickup_pretty").val());
                $('.has-error').html(js_lang.trans_31+" "+ $("#merchant_maximum_order_pickup_pretty").val());
   	  	  	      return;
    	      }              	      
   	     }   	 
   	 }   
   	  
   	  if ( $("#delivery_type").val()=="delivery" ){   	  	  
	   	  if ( $("#is_ok_delivered").val()==2){	   	  	 
	   	  	 uk_msg(js_lang.trans_15+" "+$("#merchant_delivery_miles").val() + " "+$("#unit_distance").val());   	  
           $('.has-error').html(js_lang.trans_15+" "+$("#merchant_delivery_miles").val() + " "+$("#unit_distance").val());
	   	  	 return;
	   	  }   
	   	  if ( $("#delivery_date").val()==""){
   	  	 	uk_msg(js_lang.trans_43);  	  	 
          $('.has-error').html(js_lang.trans_43);
   	  	 	$("#delivery_date").focus();
   	  	 	return;
   	  	  }   	  
   	  	 
   	  	  if ( $("#merchant_required_delivery_time").exists()){
   	  	 	if ( $("#merchant_required_delivery_time").val()=="yes"){   	  	 		   	  	 	
   	  	 		if ( $("#delivery_time").val()==""){
   	  	 			var delivery_asap=$("#delivery_asap:checked").val();
   	  	 			dump(delivery_asap);
   	  	 			if ( delivery_asap!=1){
			   	  	 	uk_msg(js_lang.trans_44);  	  	 
                $('.has-error').html(js_lang.trans_44);
			   	  	 	$("#delivery_time").focus();
			   	  	 	return;
   	  	 			}
		   	  	 }   	  
   	  	 	}   	  	 
   	  	 }   	  
   	  	 
   	  } else {   	  	 
   	  	 if ( $("#delivery_date").val()==""){
   	  	 	uk_msg(js_lang.trans_42);  	  
          $('.has-error').html(js_lang.trans_42);	 
   	  	 	$("#delivery_date").focus();
   	  	 	return;
   	  	 }   	  
   	  	 if ( $("#delivery_time").val()==""){
   	  	 	uk_msg(js_lang.trans_41);  	  	 
          $('.has-error').html(js_lang.trans_41);
   	  	 	$("#delivery_time").focus();
   	  	 	return;
   	  	 }   	  
   	  }   	  
   	  

   	  var params="delivery_type="+$("#delivery_type").val()+"&delivery_date="+$("#delivery_date").val();
		  params+="&delivery_time="+$("#delivery_time").val();
		  params+="&delivery_asap="+$("#delivery_asap:checked").val();
		  params+="&merchant_id="+$("#merchant_id").val();
   	  params+="&order_type="+$("#order_type").val();      
   	    busy(true);
	    $.ajax({    
	    type: "POST",
	    url: ajax_url,
	    data: "action=setDeliveryOptions&currentController=store&tbl=setDeliveryOptions&"+params,
	    dataType: 'json',       
	    success: function(data){ 
	    	busy(false);      		
	    	if (data.code==1) {
	    	   //window.location.replace(sites_url+"/store/checkout/");
               
	    		window.location.href=sites_url+"/store/checkout/";
	    	} else if (data.code==2) {  
				//this is for login modal
				$('#login-popup').modal('show');
        uk_msg(data.msg);
			}else{ 
				  $('.has-error').html(data.msg);
	    		uk_msg(data.msg);
	    	}	    
	    }, 
	    error: function(){	        	    	
	    	busy(false); 
	    }		
	    });   	     	  
   });
   
   $('#delivery_asap').on('ifChecked', function(event){
      $("#delivery_time").val('');
   });
   
   $('.payment_opt').on('ifChecked', function(event){   	   
       $(".credit_card_wrap").slideToggle("fast");
   });
   
   $('.payment_opt').on('ifUnchecked', function(event){
       $(".credit_card_wrap").slideToggle("fast");
   });
   
   
   $( document ).on( "click", ".cc-add", function() {    	  
   	   $(".cc-add-wrap").slideToggle("fast");
   });
   
   if( $('.payment-option-page').is(':visible') ) {	
       load_cc_list();
   }
   
   if( $('.merchant-payment-option').is(':visible') ) {	
       load_cc_list_merchant();
   }
   
   /************ PLACE ORDER ***************/
   
   $( document ).on( "click", ".place_order", function() {    	  
   	   	   	   
   	   	$("#street").removeAttr("data-validation");   	   
   		var atLeastOneIsChecked = $('input[name="save_as_member"]:checked').length > 0;
   		if(!atLeastOneIsChecked)
   		{
   			$('#email_address1').removeAttr('required');
   			$('#email_address1').removeAttr('data-validation');
   			$('#password1').removeAttr('data-validation');
   			$('#password1').removeAttr('data-validation-length');
   		} 

   	   if ( $("#minimum_order").length>=1){   	  	  
   	  	  var minimum= parseFloat($("#minimum_order").val());
		  var subtotal= parseFloat($("#subtotal_order").val());		  
   	  	  if (isNaN(subtotal)){
   	  	  	  subtotal=0;
   	  	  }   	     	  	  
   	  	  if (isNaN(minimum)){
   	  	  	  minimum=0;
   	  	  }   	     	  	  
   	  	  if ( minimum>subtotal){   	  	  	
        	  uk_msg(js_lang.trans_5+" "+ $("#minimum_order_pretty").val());
   	  	  	  return;
   	  	  }      	  	  
   	   }  
   	   
   	   if ( $("#maximum_order").exists() ){
   	   	  var subtotal= parseFloat($("#subtotal_order").val());
   	   	  var maximum_order = parseFloat($("#maximum_order").val());   	   	  
   	   	  if(!empty(subtotal)){   	   	  	 
   	   	  	 if ( maximum_order<subtotal){   	  	  	   	   	  	 	
                uk_msg(js_lang.trans_31+" "+ $("#maximum_order_pretty").val());
   	  	  	    return;
   	  	     }      	  	  
   	   	  }   	   
   	   }
   	      	     
   	   /** if checkout is guest type */
   	   if ( $("#is_guest_checkout").exists() ){   	   	   
   	   	   if ( $("#map_address_toogle").exists()){   	   	   	   	   	  
   	          if ( $("#map_address_toogle").val()==2 ){
   	          	  $("#street").removeAttr("data-validation");
   	          	  $("#city").removeAttr("data-validation");
   	          	  $("#state").removeAttr("data-validation");
                  $("#zipcode").removeAttr("data-validation");
   	          }
   	   	   }  
   	   }   
   	
   	   var payment_type=$(".payment_option:checked").val();
   	   
   	   if ( $(".payment_option:checked").length<=0 ){
   	   	   uk_msg(js_lang.trans_6);
   	   	   return;
   	   }
	   
   	   if ( $(".place_order_contact_phone").exists() ){
	   	   var p = $(".place_order_contact_phone").val();   	      	      	   
	   	   if ( p.length <=6){
	   	   	   uk_msg(js_lang.trans_7);
	   	   	   $(".place_order_contact_phone").focus();
	   	   	   return;
	   	   }   
   	   }  
   	   /*if ( $("#contact_phone").exists() ){
	   	   var p = $("#contact_phone").val();   	      	      	   
	   	   if ( p.length <=6){
	   	   	   uk_msg(js_lang.trans_7);
	   	   	   $("#contact_phone").focus();
	   	   	   return;
	   	   }   
   	   }*/
   	      	      	   
   	   if ( payment_type =="ccr" || payment_type =="ocr"){   	   	   
   	   	   if ( $(".cc_id:checked").length<=0 ){
   	   	   	   uk_msg(js_lang.trans_8);   	   	  
   	   	   	   return;
   	   	   }   	   
   	   }        	   
   	      	   
   	   if ( payment_type=="pyr"){
   	   	   var selected_payment_provider_name=$("#payment_provider_name:checked").length;   	   	   
   	   	   if ( selected_payment_provider_name<=0){
   	   	   	   uk_msg(js_lang.trans_40);   	   	   
   	   	   	   return;
   	   	   }   	   
   	   }   
   	   
   	   /** check if client move the marker */
   	   if ( $("#map_address_toogle").exists()){   	   	
   	      if ( $("#map_address_toogle").val()==2 ){
	   	   	   if ( $("#map_address_lat").val()==""){
	   	   	   	  uk_msg(js_lang.trans_48);    	   	   
	   	   	   	  return;
	   	   	   }   	   
   	      }
   	   }   
   	      	   
   	   if ( $(".capcha-wrapper").exists() ){
   	   	   var google_resp = $(".capcha-wrapper").find(".g-recaptcha-response").val();    		
   	   	   dump(google_resp);
   	   	   if (!google_resp) {
   	   	   	   uk_msg(js_lang.trans_52); 
   	   	   	   return;
   	   	   }
   	   } 
   	      	   
   	   /*check if merchant sms oder verification is required*/
   	   if ( $("#order_sms_code").exists()){
   	   	    if ( $("#order_sms_code").val()=="" ){
   	   	    	uk_msg(js_lang.trans_53);    	  
   	   	    	$("#order_sms_code").focus();  
   	   	    	return;
   	   	    } else {
   	   	    	$("#client_order_sms_code").val( $("#order_sms_code").val() );
   	   	    	$("#client_order_session").val( $(".send-order-sms-code").data("session"));
   	   	    } 	      	   
   	   }   
   	   /* alert("Here");
       return;*/
   	   $("#frm-delivery").submit();   	   
   	   //form_submit('frm-delivery');   	   
   });
   
   
   /*ANIMATE*/
  /* $('.animated').appear(function(){             
      var element = $(this);
      var animation = element.data('animation');
      var animationDelay = element.data('delay');      
      if (animationDelay) {
        setTimeout(function(){
          element.addClass( animation + " visible" );
          element.removeClass('hiding');
          if (element.hasClass('counter')) {          
          }
        }, animationDelay);
      }else {
        element.addClass( animation + " visible" );
        element.removeClass('hiding');
        if (element.hasClass('counter')) {         
        }
      }    
    },{accY: -1});*/
      
    /*LOOP THRU STEPS*/
    $( ".order-steps li" ).each(function( index ) {
    	var current=$(this);    	
    	var link= current.find("a");
    	if ( current.hasClass("active") ){  
    	} else {    	    
    	    link.attr("href","javascript:;")    	   
    	    link.addClass("inactive");
    	}    
    });
        
    
   $('.filter_by').on('ifChecked', function(event){
   	   dump('d2');
       research_merchant();       
   });
   
   $('.filter_by').on('ifUnchecked', function(event){
   	   dump('d3');
       research_merchant();   
   });     
      
   $('.filter_by_radio').on('ifChecked', function(event){  
       $(".filter_minimum_clear").show();   
       research_merchant();   
   });     
         
   $( document ).on( "click", ".button_filter", function() {
   	   $(".frm_search_name_clear").show();
   	   research_merchant(); 
   });
      
   $( document ).on( "change", ".sort-results", function() {
   	   var sort_filter=$(this).val();   	   
   	   if (!empty(sort_filter)){
   	   	  dump(sort_filter);   	   
   	      $("#sort_filter").val(sort_filter);      	   
   	      research_merchant();   	  
   	   }   	   
   });
    
   
   $( document ).on( "click", ".login-link", function() {    	     	  
   	  $(".section1").hide();
   	  $(".section2").fadeIn();
   });	
   
   
   $( document ).on( "click", ".signup-link", function() {    	     	     	  
   	  $(".section3").fadeIn();
   	  $(".section2").hide();
   	  $(".section1").hide();
   });	
      
   $( document ).on( "click", ".back-link", function() {    	  
   	  $(".section1").fadeIn();
   	  $(".section2").hide();
   	  $(".section3").hide();
   	  $(".section-forgotpass").hide();
   });	
   
   $( document ).on( "click", ".fc-close", function() {    	  
      close_fb();
   });	     
      
   $( document ).on( "click", ".remove-rating", function() {    	  
       var params="action=removeRating&currentController=store&merchant_id="+$("#merchant_id").val();
		busy(true);
	    $.ajax({    
	    type: "POST",
	    url: ajax_url,
	    data: params,
	    dataType: 'json',       
	    success: function(data){ 
	    	busy(false);      
	    	if (data.code==1){	  	    		
	    		load_ratings();
	    		$('#bar-rating').barrating('clear'); 
	    		$(".br-widget a").removeClass("br-selected");
	    		$(".rating_handle").addClass("hide");
	    	} else {
	    		uk_msg(data.msg);
	    	}	    
	    }, 
	    error: function(){	        	    	
	    	busy(false); 
	    }		
	    });
   });	     
   
  
   $( document ).on( "click", ".write-review", function() {    	  
   	   if ( $(this).hasClass("active") ){
   	   	   ////console.debug('d2');
   	   	   $(".review-content-wrap").slideToggle("fast");
   	   } else {   
   	       $(".review-content-wrap").slideToggle("fast");
   	   }
   });	
      
   /*if ( $(".merchant-review-wrap").exists() ){
   	   load_reviews();
   }*/
      
   $( document ).on( "click", ".map-li", function() {    	     	  
   	  var locations;
   	  if ( $("#google_map_wrap").text()=="" ){
   	  	 
   	  	 if (typeof $("#merchant_map_latitude").val() === "undefined" || $("#merchant_map_latitude").val()==null || $("#merchant_map_latitude").val()=="" ) {  
   	  	 	$("#google_map_wrap").html("<p class=\"uk-text-muted\">"+js_lang.trans_9+"</p>");
   	  	 	return;
   	  	 }	
         locations=[[$("#map_title").val(),$("#merchant_map_latitude").val(),$("#merchant_map_longtitude").val(),16]];
         initializeMarker(locations);      
   	  }
   });
         
   $( document ).on( "click", ".uk-tab-responsive a", function() {    	     	  
   	  var locations;
   	  if ( $("#google_map_wrap").text()=="" ){
   	  	 
   	  	 if (typeof $("#merchant_map_latitude").val() === "undefined" || $("#merchant_map_latitude").val()==null || $("#merchant_map_latitude").val()=="" ) {  
   	  	 	$("#google_map_wrap").html("<p class=\"uk-text-muted\">"+js_lang.trans_9+"</p>");
   	  	 	return;
   	  	 }	
         locations=[[$("#map_title").val(),$("#merchant_map_latitude").val(),$("#merchant_map_longtitude").val(),16]];
         initializeMarker(locations);      
   	  }
   });
    
   $( document ).on( "click", ".top_sigin", function() {    	  
   	   var params="action=loginModal&tbl=loginModal&do-action=sigin&currentController=store";
       open_fancy_box(params);
   });
      
   $( document ).on( "click", ".top_signup", function() {    	  
   	   var params="action=loginModal&tbl=loginModal&do-action=sigin&currentController=store";
       open_fancy_box(params);
   });
   
   $( document ).on( "click", ".edit-review", function() {    	  
   	   var id=$(this).data("id");
   	   var params="action=editReview&currentController=store&tbl=editReview&id="+id+"&web_session_id="+$("#web_session_id").val();
       // open_fancy_box(params);
	   open_edit_review_winbox(params);
   });	

     
   $( document ).on( "click", ".delete-review", function() {    	  
   	   var id=$(this).data("id");
   	   var q=confirm(js_lang.trans_10);
   	   if (q){
   	   	   delete_review(id);
   	   }   
   });

     
   $( document ).on( "click", ".print-receipt", function() {  
       $('#receipt-content').printElement();
   });	
   
   $( document ).on( "click", ".view-receipt", function() {    	       	 	
   	   var params="action=viewReceipt&currentController=store&tbl=viewReceipt&id="+ $(this).data("id");
       open_fancy_box(params);
   });	
   
   $( document ).on( "click", ".add-to-cart", function() {    	       	 	
      var id=$(this).data("id");
      var a=confirm(js_lang.trans_11);
      if (a){
      	 add_to_order(id);      
      }
   });	
      
   $( document ).on( "click", ".search-box-wrap	 a", function() {    	       	 	
   	  if ( $(this).hasClass("filter_minimum_clear") ){
   	  	 return;
   	  }   
   	  if ( $(this).hasClass("frm_search_name_clear") ){
   	  	 return;
   	  }   
   	  var i=$(this).find(".fa");
   	  if ( i.hasClass("fa-caret-up") ){
   	  	  i.removeClass("fa-caret-up");
   	  	  i.addClass("fa-caret-down");
   	  } else {
   	  	  i.removeClass("fa-caret-down");
   	  	  i.addClass("fa-caret-up");
   	  }   
     	 
   	  var parent=$(this).parent();   	  
   	  var child=parent.find(".uk-list");
   	  child.slideToggle("fast");
   });	
   
   $( document ).on( "click", ".next_step_free_payment", function() {    	       	 	
   	  next_step_free_payment($(this).data("token"));
   });	   
   
   $( document ).on( "click", ".row_del", function() {
        var ans=confirm(js_lang.deleteWarning);        
        if (ans){        	
        	row_delete( $(this).attr("rev"),$("#tbl").val(), $(this)); 
        }
    });
    
    $( document ).on( "click", ".filter_minimum_clear", function() {    	
    	$(".filter_minimum").attr("checked",false);
    	$('.filter_minimum').iCheck('update'); 
    	$(this).hide();
    	research_merchant();  
    });            
       
    $( document ).on( "click", ".frm_search_name_clear", function() {    	
    	$(".filter_name").val('');
    	$(this).hide();
    	research_merchant();  
    });
            
    /*contact map*/
    if ( $("#map_latitude").length>=1 ){
    	if (typeof $("#map_latitude").val() === "undefined" || $("#map_longitude").val()==null  ) {  
   	  	 	$("#google_map_wrap").html("<p class=\"uk-text-muted\">Map not available</p>");
   	  	 	return;
   	  	 }	
         locations=[[$("#map_title").val(),$("#map_latitude").val(),$("#map_longitude").val(),16]];         
         initializeMarker(locations);      
    }
    
   
    $( document ).on( "click", ".fb-link-login", function() {    	
    	////console.debug('d2');
    	checkLoginState();
    });
    
    $( document ).on( "click", ".forgot-pass-link", function() {    	    
    	  $(".section-forgotpass").fadeIn();
    	  $(".section3").hide();
   	      $(".section2").hide();
   	      $(".section1").hide();
    });
    
    next_bg();
        
    $( document ).on( "click", ".resume-app-link", function() {    	    
    	$(".frm-resume-signup").slideToggle("fast");
    });	
        
    $( document ).on( "click", ".resend-activation-code", function() {    	    
    	resend_activation_code( $("#token").val() );
    });	
    
    
    if ( $("#merchant_header").length>=1 ){
    	var merchant_header=upload_url+"/"+$("#merchant_header").val();
    	//console.debug(merchant_header);
    	$('#menu-with-bg').css('background-image', 'url(' + merchant_header + ')');
    }
    
    $( document ).on( "click", ".apply_voucher", function() {
    	if ( $("#voucher_code").val()!="" ){
    		apply_voucher();
    	} else {
    		uk_msg(js_lang.trans_22);
    	}        
    });    
    
    
    if( $('#restaurant-mini-list').is(':visible') ) {	    	
    	var t=$("#tab-left-content li:first-child").find(".links");      	
    	//geocode_address(t.data("id"));
    	var lat=t.data("lat");
    	var lng=t.data("long");    	
    	if (isNaN(lat) && isNaN(lng)){
    	    geocode_address(t.data("id"));
    	} else {
    		//locations=[['test',lat,lng,18]];    		
    		locations=[['',lat,lng,18]];
            geocode_address2(locations);      
    	}    
    }	
        
    $( document ).on( "click", ".view-map", function() {     	
    	var lat=$(this).data("lat");
    	var lng=$(this).data("long");    	
    	if (isNaN(lat) && isNaN(lng)){
    	    geocode_address($(this).data("id"));
    	} else {
    		var merchantname=$(this).data("merchantname");   	
    		locations=[[merchantname,lat,lng,18]];
            geocode_address2(locations);      
    	}    
    });	            
            
}); /*END DOCU*/

function table()
{			 

	var action=$("#action").val();	
	dump(action);
	var params=$("#frm_table_list").serialize();
 	var sInfo=js_lang.trans_12;	
 	if ( action=="ClientCCList"){	
		params+="&action=ClientCCList";
		sInfo=js_lang.trans_13;
		sEmptyTable=js_lang.tablet_1;
		
	} else if( action=="addressBook"){
		params+="&action=addressBook";
		sEmptyTable=js_lang.tablet_1;
		
	} else {		
		sInfo=js_lang.trans_13;
		sEmptyTable=js_lang.tablet_1;
	}
		
	if ( action=="searchArea"){
		 epp_table = $('#table_list').dataTable({
		       "bProcessing": true, 
		       "bServerSide": true,	    
		       "bFilter":false,
		       "bLengthChange":false,
		       "sAjaxSource": ajax_url+"?"+params,	       		       
		       "bDeferRender": true,
		       "iDisplayLength": 10,
		       "pagingType": "full_numbers",
		       "oLanguage":{
		       	 "sInfo": sInfo,
		       	 "sInfoEmpty":  js_lang.tablet_3,
		       	 "sEmptyTable": sEmptyTable,
		       	 "sProcessing": "<p>"+js_lang.tablet_7+" <i class=\"fa fa-spinner fa-spin\"></i></p>",
		       	 "oPaginate": {
				        "sFirst":    js_lang.tablet_10,
				        "sLast":     js_lang.tablet_11,
				        "sNext":     js_lang.tablet_12,
				        "sPrevious": js_lang.tablet_13
				  }
		       },
		       "fnInitComplete": function (oSettings, json) {  		       	  		       	  		       	  
	              if ( oSettings._iRecordsTotal<=0){
	              	  $(".ops_notification").show();
	              }
	           },
	           "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {	      	           	
	            	global_plot_marker[iDisplayIndex]=[ucwords(aData[7]),parseFloat(aData[5]),parseFloat(aData[6]),iDisplayIndex,aData[8],aData[9],aData[10] ];
	            		            	
	           },
	           "fnDrawCallback": function( oSettings ) {
	           	  plotMerchantLocationNew(global_plot_marker);
	           }
	    });		
	} else {
 	    epp_table = $('#table_list').dataTable({
		       "bProcessing"   : true, 
		       "bServerSide"   : false,	    
		       "bFilter"       : false,
		       "bLengthChange" : false,
		       "sAjaxSource"   : ajax_url+"?"+params,	       
		       //"aaSorting": [[ 0, "desc" ]],
		       "oLanguage":{
		       	 "sInfo": sInfo,
		       	 "sEmptyTable": sEmptyTable,
		       	 "sInfoEmpty":  js_lang.tablet_3,
		       	 "sProcessing": "<p>"+js_lang.tablet_7+" <i class=\"fa fa-spinner fa-spin\"></i></p>",
		       	 "oPaginate": {
				        "sFirst":    js_lang.tablet_10,
				        "sLast":     js_lang.tablet_11,
				        "sNext":     js_lang.tablet_12,
				        "sPrevious": js_lang.tablet_13
				  }
		       },
		       "fnInitComplete": function (oSettings, json) {                                                   
	              if ( json.iTotalRecords <=0){
	              	 $(".ops_notification").show();
	              } else {
	              	 if ( action=="searchArea"){                     	 	              	 	
	              	 	plotMerchantLocation(json);
	              	 }
	              }
	           }
	    });		
	}
}

function table_reload()
{
	epp_table.fnReloadAjax(); 
}

function table_reload_with_params(new_params)
{
	var params=$("#frm_table_list").serialize();
	epp_table.fnReloadAjax(  ajax_url+"?"+params+new_params ); 
}

function research_merchant()
{
	var filter_delivery_type ='';
	var filter_special_offer ='';
	var delivery_free  ='';
	var filter_cuisine ='';
	var filter_promo ='';
	var filter_minimum ='';
	var filter_name ='';
	
	/*$('input:checkbox.filter_delivery_type').each(function () {
        var sThisVal = (this.checked ? $(this).val() : "");
        if ( sThisVal !=""){
            filter_delivery_type+=sThisVal+",";
        }
    });*/	
	filter_delivery_type = $(".filter_delivery_type:checked").val(); 
	
	filter_special_offer = $(".filter_special_offer:checked").val(); 
    if (typeof filter_special_offer === "undefined" || filter_special_offer==null ) {  
    	filter_special_offer ='';
    }
	
	filter_delivery_free_chkbx = $(".filter_delivery_free_chkbx:checked").val(); 
    if (typeof filter_delivery_free_chkbx === "undefined" || filter_delivery_free_chkbx==null ) {  
    	filter_delivery_free_chkbx ='';
    }
	
    $('input:checkbox.filter_cuisine').each(function () {
        var sThisVal = (this.checked ? $(this).val() : "");
        if ( sThisVal !=""){
            filter_cuisine+=sThisVal+",";
        }
    });
        
    $('input:checkbox.filter_promo').each(function () {
        var sThisVal = (this.checked ? $(this).val() : "");
        if ( sThisVal !=""){
            filter_promo+=sThisVal+",";
        }
    });
    
    
    filter_minimum = $(".filter_minimum:checked").val(); 
    filter_name    = $("#filter_name").val();
    if (typeof filter_name === "undefined" || filter_name==null ) {  
    	filter_name='';
    }	     
    var new_params='';
    if (!empty(filter_delivery_type)){
        new_params+="&filter_delivery_type="+filter_delivery_type;
    }
	if (!empty(filter_special_offer)){
        new_params+="&filter_special_offer="+filter_special_offer;
    }
	if (!empty(filter_delivery_free_chkbx)){
        new_params+="&filter_delivery_free_chkbx="+filter_delivery_free_chkbx;
    } 
    if (!empty(filter_cuisine)){
        new_params+="&filter_cuisine="+filter_cuisine;
    } 
    if (!empty(filter_promo)){
       new_params+="&filter_promo="+filter_promo;
    } 
    if (!empty(filter_minimum)){
       new_params+="&filter_minimum="+filter_minimum;
    } 
    if (!empty(filter_name)){
       new_params+="&filter_name="+filter_name;
    } 
    sort_filter=$("#sort_filter").val();    
    if (!empty(sort_filter)){
        new_params+="&sort_filter="+sort_filter;   
    } 
    if (!empty( $("#display_type").val() )){
    	new_params+="&display_type="+$("#display_type").val();
    } 
    if (!empty( $("#restaurant_name").val() )){
    	new_params+="&restaurant_name="+$("#restaurant_name").val();
    } 
    dump(new_params);
    window.location.href= $("#current_page_url").val() + new_params ;
    return false;    
} 

function open_modal_box(params)
  {   
		busy(true);
		$.ajax({    
			type   : "POST",
			url    : ajax_url,
			data   : params,      
			success: function(data){ 
				busy(false);     
				$('#myModal_add_cart_content').html(data); 
				$('#myModal_add_cart').modal('show');
				//alert(data);  
			}, 
			error: function(){	        	    	
				busy(false); 
			}		
		});  	  	  	 
  }   

function open_fancy_box(params)
  {  	  	  	  	
  	dump(params);
	var URL=ajax_url+"/?"+params;
		$.fancybox({        
		maxWidth:800,
		closeBtn : false,          
		autoSize : true,
		padding :0,
		margin :2,
		modal:false,
		type : 'ajax',
		href : URL,
		openEffect :'elastic',
		closeEffect :'elastic',
		helpers: {
		    overlay: {
		      locked: false
		    }
		 }
	});   
}

function open_modal_winbox(params)
  {       
  	dump(params);
	var URL=ajax_url+"/?"+params;	
	$.ajax({
		type:'post',
		url:URL,
		success: function(data){
			$('#append-add-mod').html(data);
			$('#change-address-modal').modal('show');
			}
		});	
}


function open_edit_review_winbox(params)
  {       
  	dump(params);
	var URL=ajax_url+"/?"+params;	
	$.ajax({
		type:'post',
		url:URL,
		success: function(data){
			$('#edit-review-mod').html(data);
			$('#edit-review-modal').modal('show');
			}
		});	
}



function open_fancy_box2(params)
  {  	  	  	  	
	var URL=ajax_url+"/?"+params;
	$.fancybox({        
	maxWidth:800,
	closeBtn : false,          
	autoSize : true,
	padding :0,
	margin :2,
	modal:true,
	type : 'ajax',
	href : URL,
	openEffect :'elastic',
	closeEffect :'elastic'	
	});   
}

function close_fb()
{
	//alert('Here will modal close');
	$('#edit-review-modal').modal('hide'); 
	$.fancybox.close(); 
}

function uk_msg(msg)
{
	var n = noty({
		 text: msg,
		 type        : "warning" ,		 
		 theme       : 'relax',
		 layout      : 'topCenter',		 
		 timeout:8000,
		 animation: {
	        open: 'animated fadeInDown', // Animate.css class names
	        close: 'animated fadeOut', // Animate.css class names	        
	    }
	});
}

function uk_msg_sucess(msg)
{
	var n = noty({
		 text: msg,
		 type        : "success" ,		 
		 theme       : 'relax',
		 layout      : 'topCenter',		 
		 timeout:5000,
		 animation: {
	        open: 'animated fadeInDown', // Animate.css class names
	        close: 'animated fadeOut', // Animate.css class names	        
	    }
	});	  
}

function load_item_cart()
{	
	var params="action=loadItemCart&currentController=store&merchant_id="+$("#merchant_id").val();
	params+="&delivery_type="+$("#delivery_type").val();
	busy(true);
    $.ajax({    
    type: "POST",
    url : ajax_url,
    data: params,
    dataType: 'json',       
    success : function(data){ 
    	busy(false);      	
    	if (data.code==1){			 
			if ((data.details.parish_min_amt).length>0)
			{				 
				$('#minimum_order').val(data.details.parish_min_amt);
				$("#minimum_order_pretty").val(data.details.parish_min_amt_pretty);
			}
			 
    		$(".item-order-wrap").html(data.details.html);
    		$(".checkout").attr("disabled",false);    		
    		$(".checkout").css({ 'pointer-events' : 'auto' });
    		//$(".checkout").addClass("uk-button-success");
    		$(".checkout").removeClass("disabled-button");
    		$(".voucher_wrap").show();
    		clearCartButton(1); 
    		$(function () {
               $('[data-toggle="tooltip"]').tooltip()
            }); 
    	} else { 
    		$(".item-order-wrap").html('<div class="center alert alert-danger"><b>'+data.msg+'</b></div>');
    		$(".checkout").attr("disabled",true);
    		$(".checkout").css({ 'pointer-events' : 'none' });
    		//$(".checkout").removeClass("uk-button-success");
    		$(".checkout").addClass("disabled-button");
    		$(".voucher_wrap").hide();
    		clearCartButton(2);
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function delete_item(row)
{
	var params="action=deleteItem&row="+row;    
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      	
    	if (data.code==1){    		
    		load_item_cart();
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}


function delete_topping_item(row,rel)
{  
  var params="action=deleteToppingItem&row="+row+"&rel="+rel;
  busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
      busy(false);        
      if (data.code==1){        
        load_item_cart();
      }
    }, 
    error: function(){                  
      busy(false); 
    }   
    });
}

function load_cc_list()
{
	var htm='';
	var params="action=loadCreditCardList&currentController=store";
	params+="&is_guest_checkout="+$("#is_guest_checkout").val();
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      	
    	if (data.code==1){    		    		    		    	
    		$.each(data.details, function( index, val ) {
    			$(".uk-list-cc tr").remove(); 
    			/*htm+='<li>';
	              htm+='<div class="uk-grid">';
	                htm+='<div class="uk-width-1-2">'+val.credit_card_number+'</div>';
	                htm+='<div class="uk-width-1-2">&nbsp;<input type="radio" name="cc_id" class="cc_id" value="'+val.cc_id+'"></div>';
	              htm+='</div>';
	            htm+='</li>';*/
    			
    			htm+='<tr>';
				  htm+='<td>'+val.credit_card_number+'</td>';
				  htm+='<td><input type="radio" name="cc_id" class="cc_id" value="'+val.cc_id+'"></td>';
				htm+='</tr>';
    			
    		});
    		$(".uk-list-cc").append(htm);
    		$(".cc-add-wrap").hide();
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function load_cc_list_merchant()
{
	var htm='';
	var params="action=loadCreditCardListMerchant&currentController=store";
	params+="&merchant_id="+$("#merchant_id").val();
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      	
    	if (data.code==1){    		    		    		    	
    		$.each(data.details, function( index, val ) {
    			$(".uk-list-cc tr").remove(); 
    			    			
    			/*$(".uk-list-cc li").remove(); 
    			htm+='<li>';
	              htm+='<div class="uk-grid">';
	                htm+='<div class="uk-width-1-2">'+val.credit_card_number+'</div>';
	                htm+='<div class="uk-width-1-2">&nbsp;<input type="radio" name="cc_id" class="cc_id" value="'+val.mt_id+'"></div>';
	              htm+='</div>';
	            htm+='</li>';*/
	            
	            htm+='<tr>';
				  htm+='<td>'+val.credit_card_number+'</td>';
				  htm+='<td><input type="radio" name="cc_id" class="cc_id" value="'+val.mt_id+'"></td>';
				htm+='</tr>';
				
    		});
    		$(".uk-list-cc").append(htm);
    		$(".cc-add-wrap").hide();
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function add_rating(value,merchant_id)
{
    var params="action=addRating&currentController=store&value="+value+"&merchant_id="+merchant_id;
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      		
    	if (data.code==1){    
    		$(".rating_handle").removeClass("hide");
    		load_ratings();
            close_fb();
    	} else if( data.code==3) {
    		uk_msg(data.msg);
    	} else {
    		$('#bar-rating').barrating('clear'); 		
    		var params="action=loginModal&tbl=loginModal&currentController=store&do-action=rating&rating="+value;
    	    open_fancy_box(params);
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function load_ratings()
{
	var params="action=loadRatings&currentController=store&merchant_id="+$("#merchant_id").val();
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if (data.code==1){    		
    		$(".votes_counter").html(data.details.votes+" Votes");
    		$(".rate-wrap h6").html(data.details.ratings);
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}


function load_top_menu()
{
	var params="action=loadTopMenu&currentController=store";
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if (data.code==1){
    		$(".section-to-menu-user").append(data.details);
    		$(".top_signup").remove();
    		$(".top_sigin").remove();
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}


function load_reviews()
{
	var params="action=loadReviews&currentController=store&merchant_id="+$("#merchant_id").val();
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if (data.code==1){
    	   $(".merchant-review-wrap").html(data.details);
    	   initRating();   
    	   initReadMore();  	   
    	} else {
    	   $(".merchant-review-wrap").html("<div class=\"uk-text-muted\">"+data.msg+"</div>");
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function delete_review(id)
{
	var params="action=deleteReview&currentController=store&id="+id+"&web_session_id="+$("#web_session_id").val();
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if (data.code==1){    	   
            load_reviews();            
            close_fb();
    	} else {
    	   uk_msg(data.msg);
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function add_to_order(order_id)
{
	var params="action=addToOrder&currentController=store&order_id="+order_id;
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if (data.code==1){       			              
    		window.location.replace(sites_url+"/store/menu/merchant/"+data.details.restaurant_slug);
    	} else {
    	   uk_msg(data.msg);
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function next_step_free_payment(token)
{
	var params="action=merchantFreePayment&currentController=store&token="+token;
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if ( $("#merchant_email_verification").val()=="yes" ){
		   window.location.replace(sites_url+"/store/merchantsignup/Do/thankyou2/token/"+token);
		} else {
		   window.location.replace(sites_url+"/store/merchantsignup/Do/step4/token/"+token);
		}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });	
}

function row_delete(id,tbl,object)
{		
	var form_id=$("form").attr("id");
	rm_notices();	
	busy(true);
	var params="action=rowDelete&tbl="+tbl+"&row_id="+id+"&whereid="+$("#whereid").val();	
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){
        	busy(false);
        	if (data.code==1){       
        		$("#"+form_id).before("<div class=\"uk-alert uk-alert-success\">"+data.msg+"</div>");         		
        		tr=object.closest("tr");
                tr.fadeOut("slow");
        	} else {      
        		$("#"+form_id).before("<div class=\"uk-alert uk-alert-danger\">"+data.msg+"</div>");
        	}        	        	
        }, 
        error: function(){	        	        	
        	busy(false);
        	$("#"+form_id).before("<div class=\"uk-alert uk-alert-danger\">"+js_lang.trans_14+"</div>");
        }		
    });
}

/*=============================================================
START GOOGLE MAP MARKER
=============================================================*/
function initializeMarker(locations){	

    window.map = new google.maps.Map(document.getElementById('google_map_wrap'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
        //styles: [ {stylers: [ { "saturation":-100 }, { "lightness": 0 }, { "gamma": 0.5 }]}]
    });
        
    var infowindow = new google.maps.InfoWindow();

    var bounds = new google.maps.LatLngBounds();

    for (i = 0; i < locations.length; i++) {
    	    	                
        if ( $("#map_marker").exists() ){
        	var image=upload_url+"/"+$("#map_marker").val(); 
        	marker = new google.maps.Marker({
	            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	            map: map ,
	            icon:image
	        });
        } else {
	        marker = new google.maps.Marker({
	            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	            map: map           
	        });
        }

        bounds.extend(marker.position);

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function () {
        map.setZoom(16);
        google.maps.event.removeListener(listener);
    });
}

function initializeMarkerNew(locations,divname,zoom_value){		
		
	window.map = new google.maps.Map(document.getElementById(divname), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
    });
        
    var contentString=[];
       
    for (i = 0; i < locations.length; i++) {
        //dump(locations);
    	contentString[i]='<div class="marker-info-wrap">';
    	contentString[i]+=locations[i][6];
    	contentString[i]+="<div>"+js_lang.trans_35+" : "+locations[i][0]+"</div>";
    	contentString[i]+="<div>"+js_lang.trans_36+" : "+locations[i][4]+"</div>";
    	contentString[i]+="<a href=\""+sites_url+"/store/menu/merchant/"+locations[i][5]+"\" >"+js_lang.trans_37+"</a>";
    	contentString[i]+="</div>";
    	
    	
    	var infowindow = new google.maps.InfoWindow({
           content: contentString[i]
        });

        
        var bounds = new google.maps.LatLngBounds();
    
        var image=upload_url+"/"+$("#map_marker").val();        
                
        if ( $("#map_marker").exists() ){
	        marker = new google.maps.Marker({
	            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	            map: map,
	            icon: image     
	        });
        } else {
        	marker = new google.maps.Marker({
	            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	            map: map	           
	        });
        }

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {   
            	infowindow.setContent(contentString[i]);             
                infowindow.open(map,marker);
            }
        })(marker, i));

        
        bounds.extend(marker.position);
        
    }
    

    dump("zoom=>"+zoom_value);
    if (typeof zoom_value === "undefined" || zoom_value==null ) { 
    	zoom_value=10;
    }
    dump("zoom=>"+zoom_value);
    
    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function () {
        map.setZoom(zoom_value);
        
        /** focus on the map location */
        if ( focus_lat!=""){        	
        	dump("focus_lat->"+focus_lat);
            dump("focus_lng->"+focus_lng);
            var position = new google.maps.LatLng(focus_lat,focus_lng);
            map.setCenter(position);   
        }                
        
        google.maps.event.removeListener(listener);
    });
	
}
/*=============================================================
END GOOGLE MAP MARKER
=============================================================*/

function fb_register(object)
{
	var fb_params='';
	$.each( object, function( key, value ) {      
      fb_params+=key+"="+value+"&";
    });
		
    rm_notices();	
	busy(true);
	
	var params="action=FBRegister&currentController=store&"+fb_params;
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',        
        success: function(data){         	
        	busy(false);
        	if (data.code==1){
        		load_top_menu();
        		
        		alert("Inside");        		

        		if ( $(".section-checkout").exists() ){        			
        			alert("section-checkout        "+$("#redirect").val());        		
        			window.location.href = $("#redirect").val();
        		}	
        		            		    	
        		if ( $("#single_page").exists() ){
        			alert("single_page    "+home_url);
        			window.location.href=home_url;
        		}		
        		
        		close_fb();
        	} else {
        		uk_msg(data.msg);
        	}
        }, 
        error: function(){	             	
        	busy(false);
        }		
   });
}


/*CHANGE BACKGROUND*/
//var handle_bg=setInterval(next_bg, 5000);
var backgrounds = [
sites_url+"/assets/images/b-1.jpg",
sites_url+"/assets/images/b-2.jpg",
sites_url+"/assets/images/b-3.jpg",
sites_url+"/assets/images/b-4.jpg",
sites_url+"/assets/images/b-5.jpg",
sites_url+"/assets/images/b-6.jpg",
];
      
function next_bg()
{	
	var numLow = 1;
    var numHigh = 6;    
    var adjustedHigh = (parseFloat(numHigh) - parseFloat(numLow)) + 1;    
    var numRand = Math.floor(Math.random()*adjustedHigh) + parseFloat(numLow);        
    var bg_img=backgrounds[numRand];
    ////console.debug(bg_img);
    if (typeof bg_img === "undefined" || bg_img==null ) { 
    } else {	
       $(".banner-wrap").addClass("bg-fadein");
       $(".banner-wrap").css('background', 'url(' + bg_img + ')');       
    }
    
}

function resend_activation_code(token)
{
	$(".resend-activation-code").css({ 'pointer-events' : 'none' });
	var params="action=resendActivationCode&currentController=store&token="+token;
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	$(".resend-activation-code").css({ 'pointer-events' : 'auto' });
    	busy(false);      	
    	if (data.code==1){    		    	
    	}
    	uk_msg(data.msg);
    }, 
    error: function(){	        	    	
    	$(".resend-activation-code").css({ 'pointer-events' : 'auto' });
    	busy(false); 
    }		
    });
}

function apply_voucher()
{
	var action="applyVoucher";
	if ( $(".apply_voucher").text()==js_lang.trans_23 ){
		action="removeVoucher";
	}
	
	if ( action=="removeVoucher"){
		var a=confirm("Are you sure?");
		if (!a){
			return;
		}
	}
	
	var code = $("#voucher_code").val();
	var params="action="+action+"&currentController=store&voucher_code="+code+"&merchant_id="+$("#merchant_id").val();
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){     	
    	busy(false);      	
    	if (data.code==1){    	
    		//console.debug(action);
    		load_item_cart();
    		if ( action=="removeVoucher"){
    			$(".apply_voucher").text(js_lang.trans_24);    		
    			$("#voucher_code").show();
    		} else {    			
    		    $("#voucher_code").hide();
    			$(".apply_voucher").text(js_lang.trans_23);
    		}    		
    	} else {
           uk_msg(data.msg);
    	}
    }, 
    error: function(){	        	    	    	
    	busy(false); 
    }		
    });	
}

/***************************************
GET CURRENT LOCATION 
***************************************/

jQuery(document).ready(function() {	
	
	if ( $("#google_auto_address").val()=="yes" ){		
	} else {
		if ( $("#google_default_country").val()=="yes" ){			
			$("#s").geocomplete({
			  country: $("#admin_country_set").val()			
		   });			   
		} else {			
			$("#s").geocomplete();	
		}
	}
	$("#origin").geocomplete({
		country: $("#admin_country_set").val()
	});
	
	function success_geo(position) {	

		/*
		alert(position.coords.latitude);
		alert(position.coords.longitude);	


		if ( $("#s").val()!=""){
			alert("Fails");
		 	 return;
		 }	
		console.debug(position.coords.latitude);
		console.debug(position.coords.longitude);		*/
		//getAddress(position.coords.latitude,position.coords.longitude);
		var lat=position.coords.latitude;
		var lng=position.coords.longitude;
		var latlng = new google.maps.LatLng(lat, lng);		
		var geocoder = new google.maps.Geocoder();

		// alert("success");

		geocoder.geocode({'latLng': latlng}, function(results, status) {						

			if (status == google.maps.GeocoderStatus.OK) {
				 //dump(results[0]);
				// alert("Results ok "); 
				// alert(results[0].toSource());
				var pincode = '';
				jQuery.each(results[0].address_components, function() 
				{
				  
				  if(this.types[0]=='postal_code')
				  {
				  	pincode = this.long_name;
				  }
				 // alert(this.types[0].toSource());

				 });
				 $('#zipcode').val(pincode);
				 // alert(results[1].formatted_address.toSource());
				 // alert(results[0].formatted_address.toSource());
				 if (results[1]) {				
				 	if (typeof results[0].formatted_address === "undefined" || results[0].formatted_address==null ) { 
				 		$("#s").val(results[1].formatted_address);
				 		$(".st").val(results[1].formatted_address);
				 	} else {	     				 						 		
				        $("#s").val(results[0].formatted_address);
				        $(".st").val(results[0].formatted_address);
				 	} 
				 } else {
				 	 uk_msg(js_lang.trans_27);
				 }
			} else {
				alert("Results Not ok ");
				uk_msg(js_lang.trans_28 + " " + status);
			}
		});
	}
	
		
	/*auto get geolocation*/
	if ( $(".cont-how-it-works").exists() ) {		
		if (navigator.geolocation) {
			// alert("navigator.geolocation");
		   if ( $("#disabled_share_location").val()==""){
		   	/* alert("disabled_share_location");
		   	 alert(success_geo);
		   	 console.log(success_geo); */
	          navigator.geolocation.getCurrentPosition(success_geo);
		   } 
	    } else {           
	        //error('Geo Location is not supported');
	    }
	}
	
    function getAddress(lat,lng)
    {
    	var params="action=geoReverse&currentController=store&lat="+lat+"&lng="+lng;
		busy(true);
	    $.ajax({    
	    type: "POST",
	    url: ajax_url,
	    data: params,
	    dataType: 'json',       
	    success: function(data){     	
	    	busy(false);      	
	    	if (data.code==1){    	
	    		if ( $("#s").val()==""){
	    		   $("#s").val(data.details);
	    		}
	    	} else {	           
	    		uk_msg(data.msg);
	    	}
	    }, 
	    error: function(){	        	    	    	
	    	busy(false); 
	    }		
	    });	
    }
        
    $( document ).on( "click", ".get_direction_btn", function() {    	
    	if ( $("#origin").val() ==""){
    		uk_msg(js_lang.trans_25);
    	} else {
    		$(".direction_output").css({"display":"none"});	
    		display_direction();
    	}    	
    });
    
    
    //if( $('.rating-wrapper').is(':visible') ) {	
    if ( $(".menu-left-content").exists() ) {
    	if ( $("#from_address").val()=="" ){
    		if ( $("#customer_ask_address").val()!=2){
    		   var params="action=enterAddress&currentController=store&tbl=enterAddress";
    	       open_fancy_box2(params);    		    	
    		}	
    	}
    }	    
    
    $( document ).on( "click", ".change-address", function() {    	
    	var params="action=enterAddress&currentController=store&tbl=enterAddress";
    	// open_fancy_box(params);    
		open_modal_winbox(params);    
				
    });	    
    
           
    if ( $("#sisowbank").exists() ){
    	$("#sisowbank").addClass("grey-fields full-width");
    }
    
    
    if ( $("#payuForm").exists() ){
    	if ( $("#hash").val()=="" ){    		    	
    	} else {
    		$(".uk-button").attr("disabled",true);    		
    		$(".uk-button").css({ 'pointer-events' : 'none' });
    		$("#payuForm").submit();
    	}
    }
    if ( $("#payu_status").exists() ){
    	$(".uk-button").attr("disabled",true);    		
        $(".uk-button").css({ 'pointer-events' : 'none' });
    }    
    
    jQuery.fn.exists = function(){return this.length>0;}
    
    if ( $("#is_merchant_open").exists() ){
    	if ( $("#is_merchant_open").val()==2 ){
    		var merchant_close_msg=$("#merchant_close_msg").val();    		
    		if (typeof merchant_close_msg === "undefined" || merchant_close_msg==null ) { 
    			merchant_close_msg(js_lang.trans_30);
    		} else {
    			uk_msg(merchant_close_msg);
    		}	
    	}
    }
    
    $( document ).on( "click", "a.share", function(ev) {
		social_popup( $(this).attr("rel") );
		ev.preventDefault();
		return;
	});
		
	$( document ).on( "change", "#delivery_type", function() {    	
		var delivery_type=$(this).val();				
		if ( delivery_type=="pickup"){
			$(".delivery-asap").hide();			
			$("#delivery_time").attr("placeholder",js_lang.trans_38);
			$(".delivery-fee-wrap").hide();	
			$(".delivery-min").hide();
			$(".pickup-min").show();
		} else {
			$(".delivery-asap").show();			
			$("#delivery_time").attr("placeholder",js_lang.trans_39);
			$(".delivery-fee-wrap").show();	
			$(".delivery-min").show();
			$(".pickup-min").hide();
		}
    	load_item_cart();
    });	    
    
    if( jQuery('#photo').is(':visible') ) {    	
       createUploader('photo','photo');
    }     
    
    if ( $("#search-tabs").exists()){
    	$( "#search-tabs" ).show();
        $( "#search-tabs" ).tabs();
    }
        
    if ( $(".fancybox").exists() ){
       $(".fancybox").fancybox();
    }
    
    $('.payment_cod').on('ifChecked', function(event){   	   
       $(".change_wrap").slideToggle("fast");
   });
   
   $('.payment_cod').on('ifUnchecked', function(event){
       $(".change_wrap").slideToggle("fast");
   });
   
   if ( $(".is_holiday").exists()){
   	   //uk_msg( $(".is_holiday").val() );
   }  
    
   if ( $(".merchant-gallery-wrap").exists()){
   	    $('.merchant-gallery-wrap').magnificPopup({
          delegate: 'a',
          type: 'image',
          closeOnContentClick: false,
          closeBtnInside: false,
          mainClass: 'mfp-with-zoom mfp-img-mobile',
          image: {
            verticalFit: true,
            titleSrc: function(item) {
              return '';
            }
          },
          gallery: {
            enabled: true
          },
          zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
              return element.find('img');
            }
          }
          
        });
   }
   
   $('.payment_pyr').on('ifChecked', function(event){   	   
       $(".payment-provider-wrap").slideToggle("fast");
   });
   
   $('.payment_pyr').on('ifUnchecked', function(event){
       $(".payment-provider-wrap").slideToggle("fast");
   });
           
   //isImageLoaded('featured-restaurant-list');
    
    $( document ).on( "click", ".goto-category", function(ev) {
		var class_name= $(this).data("id");		
		dump(class_name);
		scroll_class(class_name);
	});
   
}); /*END DOCU*/

function featuredListing()
{
	if ( $(".bxslider").exists() ){  
		$(".bxslider").show();
		$(".feature-merchant-loader").remove();
    	$('.bxslider').bxSlider({
          minSlides: 8,
		  maxSlides: 9,
		  slideWidth: 150,
		  slideMargin: 10,
		  pager:false,
		  onSliderLoad:function(currentIndex){		  	
		  }		  
    	});
    }
}
function featuredListingMobile()
{	
	if ( $(".bxslider2").exists() ){  		
    	$('.bxslider2').bxSlider({
          minSlides: 2,
		  maxSlides: 3,
		  slideWidth: 150,
		  slideMargin: 10,
		  pager:false,
		  onSliderLoad:function(currentIndex){		  	
		  }		  
    	});
    }
    if ( $(".bxslider3").exists() ){  		
    	$('.bxslider3').bxSlider({
          minSlides: 1,
		  maxSlides: 1,
		  slideWidth: 150,
		  slideMargin: 10,
		  pager:false,
		  onSliderLoad:function(currentIndex){		  	
		  }		  
    	});
    }
}

function isImageLoaded(classname)
{
	  $('.'+classname).imagesLoaded()
	  .always( function( instance ,image ) {
	     //console.log('all images loaded');
	     featuredListing();
	     featuredListingMobile();
	  })
	  .done( function( instance ) {
	     //console.log('all images successfully loaded');	     	     
	  })
	  .fail( function() {
	    //console.log('all images loaded, at least one is broken');	     
	  })
	  .progress( function( instance, image ) {	  	 	  	 
	     var result = image.isLoaded ? 'loaded' : 'broken';	     
	     var $item = $( image.img ).parent();	     
	     //dump($item);
	     $item.removeClass('isloading');	     
	     //console.log( 'image is ' + result + ' for ' + image.img.src );	     
    });	
}

function social_popup(url)
{	
	w=700;
    h=436;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
       	
	window.open(url, 'sharer','toolbar=0,status=0,width=700,height=436'+', top='+top+', left='+left);	  
}

/*$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 100,
    itemMargin: 5
  });
});*/

function display_direction()
{
	
	$(".direction_output").html('');
	$(".direction_output").css({"min-height":"300px","display":"block"});	
	 var directionsService = new google.maps.DirectionsService();
     var directionsDisplay = new google.maps.DirectionsRenderer();

     var map = new google.maps.Map(document.getElementById('merchant-map'), {
       zoom:7,
       mapTypeId: google.maps.MapTypeId.ROADMAP,
       scrollwheel: false
     });

     directionsDisplay.setMap(map);
     directionsDisplay.setPanel(document.getElementById('direction_output'));
     
     var destination_location= $("#merchant_map_latitude").val()+","+$("#merchant_map_longtitude").val();
     dump(destination_location);

     switch( $("#travel_mode").val() )
     {
     	case "DRIVING":
     	var request = {
	       origin: $("#origin").val(), 
	       destination: destination_location ,
	       travelMode: google.maps.DirectionsTravelMode.DRIVING
	     };
     	break;
     	
     	case "WALKING":
     	var request = {
	       origin: $("#origin").val(), 
	       destination:destination_location ,
	       travelMode: google.maps.DirectionsTravelMode.WALKING
         };
     	break;
     	
     	case "BICYCLING":
     	var request = {
	       origin: $("#origin").val(), 
	       destination: destination_location ,
	       travelMode: google.maps.DirectionsTravelMode.BICYCLING
	     };	     
     	break;
     	
     	case "TRANSIT":
     	var request = {
	       origin: $("#origin").val(), 
	       destination: destination_location ,
	       travelMode: google.maps.DirectionsTravelMode.TRANSIT
	     };
     	break;
     }          
     
     directionsService.route(request, function(response, status) {       
       if (status == google.maps.DirectionsStatus.OK) {
         directionsDisplay.setDirections(response);
       } else {
       	  uk_msg(js_lang.trans_26+" "+status)
       	  $(".direction_output").css({"display":"none"});	
       }
     });
}

function geocode_address(address)
{
 
	var geocoder;
    var map;
    geocoder = new google.maps.Geocoder(); 
    var mapOptions = {
	   scrollwheel: false,	
	   zoom: 18,
	   //center: latlng,
	   mapTypeId: google.maps.MapTypeId.ROADMAP
	 }
	 map = new google.maps.Map(document.getElementById('maps_side'), mapOptions);
	 
	 geocoder.geocode( { 'address': address}, function(results, status) {	 	   	 
	 	  //console.debug(results[0].geometry.location.k);
	 	  //console.debug(results[0].geometry.location.B);
	 	  if (status == google.maps.GeocoderStatus.OK) {
		      map.setCenter(results[0].geometry.location);
		      
		      if ( $("#map_marker").exists() ){
		      	var image=upload_url+"/"+$("#map_marker").val();    
		      	 var marker = new google.maps.Marker({    	
				     map: map,
				     position: results[0].geometry.location,
				     icon: image    
				  });
		      } else {
				  var marker = new google.maps.Marker({    	
				     map: map,
				     position: results[0].geometry.location
				  });
		      }
	 	  } else {
	 	  	 uk_msg(status);
	 	  }
	 });
}

function geocode_address2(locations)
{	
     window.map = new google.maps.Map(document.getElementById('maps_side'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false       
    });
        
    var infowindow = new google.maps.InfoWindow();

    var bounds = new google.maps.LatLngBounds();

    for (i = 0; i < locations.length; i++) {
    	
    	if ( $("#map_marker").exists() ){
	      	var image=upload_url+"/"+$("#map_marker").val();    
	      	marker = new google.maps.Marker({
	            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	            map: map ,
	            icon: image         
	        });
	      } else {
	        marker = new google.maps.Marker({
	            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	            map: map            
	        });
		 }

        bounds.extend(marker.position);

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function () {
        map.setZoom(18);
        google.maps.event.removeListener(listener);
    });
}

function dump(data)
{
  // alert(data.toSource());
	console.debug(data);
}

function photo(data)
{
	var img='';	
	$(".preview").show();
	img+="<img src=\""+upload_url+"/"+data.details.file+"\" alt=\"\" title=\"\" class=\"uk-thumbnail uk-thumbnail-mini\" >";
	img+="<input type=\"hidden\" name=\"photo\" value=\""+data.details.file+"\" >";
	img+="<p><a href=\"javascript:rm_preview();\">"+js_lang.removeFeatureImage+"</a></p>";
	$(".image_preview").html(img);

	$("#branch_code").removeAttr("data-validation");
	$("#date_of_deposit").removeAttr("data-validation");
	$("#time_of_deposit").removeAttr("data-validation");
	$("#amount").removeAttr("data-validation");
}

function rm_preview()
{
	$(".image_preview").html('');
	
	$("#branch_code").attr("data-validation",'required');
	$("#date_of_deposit").attr("data-validation",'required');
	$("#time_of_deposit").attr("data-validation",'required');
	$("#amount").attr("data-validation",'required');
}

function plotMerchantLocation(json)
{		
	if ( $(".search-map-wrap").exists() ){
		var s=[];
		var x=0;
		var y=1;		
	    $.each(json.aaData, function( index, val ) {        
	        s[x]=[ucwords(val[7]),parseFloat(val[5]),parseFloat(val[6]),y,val[8],val[9],val[10] ]
	        x++;
	        y++;
	    });        	    	    
	    $(".search-map-wrap").show();	    
	    initializeMarkerNew(s,'search-map-wrap');
	}
}

function ucwords(str) {  
  return (str + '')
    .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
      return $1.toUpperCase();
  });
}

$.validate({ 	
	language : jsLanguageValidator,
    form : '#frm-subscribe',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('frm-subscribe');
      return true;
    }  
});

jQuery(document).ready(function() {	
	
	if ( $("#hide_foodprice").exists() ){		
		if ( $("#hide_foodprice").val()=="yes"){
			$(".food-price-wrap").hide();			
			$(".hide-food-price").hide();				
			//$(".right-menu-content").hide();
			//$("#menu-wrap .grid-1").css({"width":"100%"});
		}
	}	
			
	$( document ).on( "click", ".close-receipt", function() {
		close_fb();
	});
			
	if ( $(".mobile_inputs").exists()){
		if ( $("#mobile_country_code").exists()){
			$(".mobile_inputs").intlTelInput({      
		        autoPlaceholder: false,
		        defaultCountry: $("#mobile_country_code").val(),    
		        autoHideDialCode:true,    
		        nationalMode:false,
		        autoFormat:false,
		        utilsScript: sites_url+"/assets/vendor/intel/lib/libphonenumber/build/utils.js"
		     });
		} else {
			 $(".mobile_inputs").intlTelInput({      
		        autoPlaceholder: false,		        
		        autoHideDialCode:true,    
		        nationalMode:false,
		        autoFormat:false,
		        utilsScript: sites_url+"/assets/vendor/intel/lib/libphonenumber/build/utils.js"
		     });
		}
	}
	

	$( document ).on( "click", ".ui-timepicker a", function() {		
		if ( $("#frm-book").exists()){
			$("#booking_time").removeAttr("style");
			var parent=$("#booking_time").parent();		
			parent.find(".form-error").remove();
		}
	});
	
	if ( $("#delivery_type").exists()){
		var delivery_type=$("#delivery_type").val();		
		if ( delivery_type=="pickup"){
			$(".delivery-asap").hide();			
			$("#delivery_time").attr("placeholder",js_lang.trans_38);
			$(".delivery-fee-wrap").hide();	
			$(".delivery-min").hide();	
			$(".pickup-min").show();	
		} else {
			$(".delivery-asap").show();			
			$("#delivery_time").attr("placeholder",js_lang.trans_39);
			$(".delivery-fee-wrap").show();	
			$(".delivery-min").show();	
			$(".pickup-min").hide();	
		}
    	//load_item_cart();
	}
	
	/*if ( $("#merchant_close_store").exists() ){				
		if  (  $("#merchant_close_store").val()=="yes"){
		   var close_msg=$("#merchant_close_msg").val();
		   uk_msg(close_msg);
		   $(".order-list-wrap").after('<p class="uk-alert uk-alert-warning">'+close_msg+'</p>');
		   $(".book-table-button").attr("disabled",true);
		   $(".checkout").hide();
		}
	}*/
	
}); /*END doc*/

function plotMerchantLocationNew(s)
{	
	if ( $(".search-map-wrap").exists() ){				
		if ( s.length >=1){
			$(".search-map-wrap").show();		
	        initializeMarkerNew(s,'search-map-wrap');
		}
	}
}

function single_food_item_add(item_id,price,size)
{
	/*dump("item_id:"+item_id);
	dump("price:"+price);
	dump("size:"+size);*/
	
	var params='';
	params="merchant_id="+$("#merchant_id").val();
	params+="&item_id="+item_id	
	if ( size==""){
		params+="&price="+price;
	} else {
	    params+="&price="+price+"|"+size;
	}
	params+="&qty=1";		
	params+="&discount=";
	params+="&notes=";
	params+="&row=";	
		
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: "action=addToCart&currentController=store&"+params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      		
    	if (data.code==1) {    	   
    		uk_msg_sucess(data.msg);
    		load_item_cart();
    	} else {
    		uk_msg(data.msg);
    	}	    
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });   	     	  
}


jQuery(document).ready(function() {	
	$( document ).on( "click", ".tips", function() {		
		
		$("#tip_value").val('');
		
		var type=$(this).data("type");
		
		$(".tips").removeClass("active");
		$(this).addClass("active");
			
		if ( type=="tip"){		
		    var tip=$(this).data("tip");			
		    		    						
			var tip_percentage = tip*100;
			$(".tip_percentage").html(tip_percentage+"%");
			
			var cart_subtotal=$("#subtotal_order2").val()
			var tip_raw = tip*cart_subtotal;
			dump(tip_raw.toFixed(2));		
			
			display_tip(tip_percentage,tip_raw.toFixed(2));
		} else {
			//$(".tip_percentage").html(0+"%");			
			$(".tip_percentage").html(0+"%");
			display_tip(0,0);			
			$(".added_tip_wrap").remove();
		}
	});
			
	$( "#tip_value" ).keyup(function() {
		 var tip_raw=parseFloat($(this).val());		 
		 if (isNaN(tip_raw)){
		 	tip_raw=0;
		 }
		 dump(tip_raw);
		 $(".tips").removeClass("active");
		 
		 var cart_subtotal=parseFloat($("#subtotal_order2").val());
		 dump(cart_subtotal);
		 
		 var reverse_percentage= (tip_raw/cart_subtotal)*100;
		 dump(reverse_percentage);
		 $(".tip_percentage").html(reverse_percentage.toFixed()+"%");
		 		 
		 display_tip(reverse_percentage.toFixed(),tip_raw.toFixed(2));
	});
	
	
	if ( $("#default_tip").exists() ){
		var default_tip=$("#default_tip").val();		
		$( ".tips" ).each(function( index ) {
			var tip=$(this).data("tip");
			dump(tip);
			if ( default_tip == tip){				
				
				$(".tips").removeClass("active");
		        $(this).addClass("active");
				
				var tip_percentage = tip*100;
				$(".tip_percentage").html(tip_percentage+"%");
								
				setTimeout(function() { 
					var cart_subtotal=$("#subtotal_order2").val();
					var tip_raw = tip*cart_subtotal;
					dump("->"+tip_raw.toFixed(2));							
					display_tip(tip_percentage,tip_raw.toFixed(2));				
				},2100);
				
				return false;
			}
		});
	}
		
}); /*end docu*/

function display_tip(tip_percentage,amount)
{
	$("#cart_tip_percentage").val(tip_percentage);
	$("#cart_tip_value").val(amount);
	
	var admin_currency_set=$("#admin_currency_set").val();
	
	var sub_total= $("#subtotal_order2").val();
	var subtotal_extra_charge= parseFloat($("#subtotal_extra_charge").val()) + 0;	
	
	if (isNaN(subtotal_extra_charge)){
		subtotal_extra_charge=0;
	}
	if (isNaN(amount)){
		amount=0;
	}
	if (isNaN(subtotal_extra_charge)){
		subtotal_extra_charge=0;
	}	
	
	dump(sub_total);
	dump(amount);
	dump(subtotal_extra_charge);
	
	var cart_total= parseFloat(sub_total) + parseFloat(amount) + parseFloat(subtotal_extra_charge);
	dump(cart_total);
	cart_total=cart_total.toFixed(2);
	
	var cart_total_display='';
	var amount_display='';
	
	if ( $("#admin_currency_position").val()=="right" ){
		cart_total_display=cart_total+" "+admin_currency_set;
		amount_display = amount+" "+admin_currency_set;
	} else {
		cart_total_display=admin_currency_set+" "+cart_total
		amount_display = admin_currency_set+" "+amount;
	}
		
	
	var html='';
	/*html+='<div class="added_tip_wrap">';
	html+='<div class="a">'+js_lang.trans_45+' ('+tip_percentage+'%)</div>';
	html+='<div class="manage">';
	  html+='<div class="b">'+amount_display+'</div>';
	html+='</div>';
	html+='<div>';*/
	
    html+='<div class="row added_tip_wrap">';
	    html+='<div class="col-md-6 col-xs-6 text-right">';
	    html+= js_lang.trans_45+" ("+tip_percentage+"%)";
	    html+='</div>';
	    html+='<div class="col-md-6 col-xs-6 text-right">';
	    html+= amount_display;
	    html+='</div>';
    html+='</div>';
	
	$(".added_tip_wrap").remove();
	$(".cart_total_wrap").before(html);
		
	$(".cart_total").html(cart_total_display);
}

$.validate({ 	
	language : jsLanguageValidator,
    form : '#forms-normal',    
    onError : function() {      
    },
    onSuccess : function() {     
      return true;
    }  
});

/***  SIGNUP AND LOGING PAGE*/
$.validate({ 	
	language : jsLanguageValidator,
    form : '#frm-modal-forgotpass',    
    onError : function() {      
    },
    onSuccess : function() {           
      form_submit('frm-modal-forgotpass');

      return false;
    }  
});

jQuery(document).ready(function() {	
	$( document ).on( "click", ".resend-code", function() {		
		busy(true);
	    $.ajax({    
	    type: "POST",
	    url: ajax_url,
	    data: "action=resendMobileCode&currentController=store&tbl=resendMobileCode&id="+$("#client_id").val(),
	    dataType: 'json',       
	    success: function(data){ 
	    	busy(false);      		
	    	if (data.code==1) {	    	   
	    		uk_msg_sucess(data.msg);
	    	} else {
	    		uk_msg(data.msg);
	    	}	    
	    }, 
	    error: function(){	        	    	
	    	busy(false); 
	    }		
	    });   	     	  		
	});	
}); /*end docu*/


/** START VERSION 2.1.1 added code*/
jQuery(document).ready(function() {	
	
	if ( $(".full_map_page").exists()){
		getAllMerchantCoordinates();		
		if ( $("#google_default_country").val()=="yes" ){		
		    $("#geo_address").geocomplete({
		    	country: $("#admin_country_set").val(),
		    	details:'form'
		    });  	   
		} else {			
			$("#geo_address").geocomplete({		    	
		    	details:'form'
		    });  	   
		}
	}	
	
	$( document ).on( "click", ".reset-geo", function() {		
		getAllMerchantCoordinates();	
	});
	
	$.validate({ 	
	language : jsLanguageValidator,
	    form : '#form_map',    
	    onError : function() {      
	    },
	    onSuccess : function() {     
	      searchGeoByAddress();
	      return false;
	    }  
	});
	
		
    if ( $(".new-merchant-header").exists() ){
    	var merchant_header=upload_url+"/"+$("#merchant_header_new").val();    
    	$('.new-merchant-header').css('background-image', 'url(' + merchant_header + ')');
    }	
	
});/* end docu*/

function getAllMerchantCoordinates()
{
	var map_zoom=parseInt($("#view_map_default_zoom").val());	
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: "action=getAllMerchantCoordinates&currentController=store&tbl=getAllMerchantCoordinates",
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if (data.code==1){     		  
    		focus_lat=data.msg.lat;		
    		focus_lng=data.msg.lng;
    		initializeMarkerNew(data.details,'map_area',map_zoom);
    	} else {
    		uk_msg(data.msg);
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });   	     	
}

var focus_lat='';
var focus_lng='';

function searchGeoByAddress()
{
	var params_geo="action=findGeo&currentController=store&tbl=findGeo&geo_address="+$("#geo_address").val();
    params_geo+="&lat="+$("#lat").val();
    params_geo+="&lng="+$("#lng").val();	
	
    busy(true);
    
    var map_zoom=parseInt($("#view_map_default_zoom_s").val());	    
    
	$.ajax({    
    type: "POST",
    url: ajax_url,
    data: params_geo,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);      
    	if (data.code==1){        		
    		focus_lat=data.msg.lat;
    		focus_lng=data.msg.lng;    		
    		initializeMarkerNew(data.details,'map_area',map_zoom); 
    	} else {
    		uk_msg(data.msg);
    	}
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });   	     	
}


/*SCROLLING DIV STARTS HERE*/
jQuery(document).ready(function($){
	
	if ( $(".separate-category-menu").exists()){				
		var h=$(".col-category").height();		
		$(".scroll-parent").css({"min-height":h+"px"});
	}	
	
	if ( $(".scroll-parent2").exists()){				
		var h=$(".right-menu-content").height();		
		$(".scroll-parent2").css({"min-height":h+"px"});
	}		
	
	if ( $("#disabled_cart_sticky").val()==""){
	if ( $(".scroll-parent").exists()){						
		
		var $window = $(window);
		var $container = $(".scroll-child");
		var $main = $(".scroll-parent");
		var window_min = 0;
		var window_max = 0;
		var threshold_offset = 50;
	
	
	function set_limits(){
		//max and min container movements
		var max_move = $main.offset().top + $main.height() - $container.height() - 2*parseInt($container.css("top") );
		var min_move = $main.offset().top;
		//save them
		$container.attr("data-min", min_move).attr("data-max",max_move);
		//window thresholds so the movement isn't called when its not needed!
		//you may wish to adjust the freshhold offset
		window_min = min_move - threshold_offset;
		window_max = max_move + $container.height() + threshold_offset;
	}
	
	//sets the limits for the first load
	set_limits();
	
	function window_scroll(){
		//if the window is within the threshold, begin movements
		if( $window.scrollTop() >= window_min && $window.scrollTop() < window_max ){
			//reset the limits (optional)
			set_limits();
			//move the container
			container_move();
		}
	}
	
	$window.bind("scroll", window_scroll);
	
	function container_move(){
		var wst = $window.scrollTop();
		//if the window scroll is within the min and max (the container will be "sticky";
		if( wst >= $container.attr("data-min") && wst <= $container.attr("data-max") ){
			//work out the margin offset
			var margin_top = $window.scrollTop() - $container.attr("data-min");
			//margin it down!
			$container.css("margin-top", margin_top);
			$container.addClass("scroll-active");
		//if the window scroll is below the minimum 
		}else if( wst <= $container.attr("data-min") ){
			//fix the container to the top.
			$container.css("margin-top",0);
			$container.removeClass("scroll-active");
		//if the window scroll is above the maximum 
		}else if( wst > $container.attr("data-max") ){
			//fix the container to the top
			$container.css("margin-top", $container.attr("data-max")-$container.attr("data-min")+"px" );
			$container.addClass("scroll-active");
		}
	}
	//do one container move on load
	container_move();	
	}
	}

	/** START CART*/	
	if ( $("#disabled_cart_sticky").val()==""){
	if ( $(".scroll-parent2").exists()){				
						
		var $window2 = $(window);
		var $container2 = $(".scroll-child2");
		var $main2 = $(".scroll-parent2");
		var window_min2 = 0;
		var window_max2 = 0;
		var threshold_offset2 = 50;
		
	function set_limits2(){
		//max and min container movements
		var max_move = $main2.offset().top + $main2.height() - $container2.height() - 2*parseInt($container2.css("top") );
		var min_move = $main2.offset().top;
		//save them
		$container2.attr("data-min", min_move).attr("data-max",max_move);
		//window thresholds so the movement isn't called when its not needed!
		//you may wish to adjust the freshhold offset
		window_min2 = min_move - threshold_offset2;
		window_max2 = max_move + $container2.height() + threshold_offset2;
	}
	
	//sets the limits for the first load
	set_limits2();
	
	function window_scroll2(){
		//if the window is within the threshold, begin movements
		if( $window2.scrollTop() >= window_min2 && $window2.scrollTop() < window_max2 ){
			//reset the limits (optional)
			set_limits2();
			//move the container
			container_move2();
		}
	}
	
	$window2.bind("scroll", window_scroll2);
	
	function container_move2(){
		var wst = $window2.scrollTop();
		//if the window scroll is within the min and max (the container will be "sticky";
		if( wst >= $container2.attr("data-min") && wst <= $container2.attr("data-max") ){
			//work out the margin offset
			var margin_top = $window2.scrollTop() - $container2.attr("data-min");
			//margin it down!
			$container2.css("margin-top", margin_top);
			$container2.addClass("scroll-active");
		//if the window scroll is below the minimum 
		}else if( wst <= $container2.attr("data-min") ){
			//fix the container to the top.
			$container2.css("margin-top",0);
			$container2.removeClass("scroll-active");
		//if the window scroll is above the maximum 
		}else if( wst > $container2.attr("data-max") ){
			//fix the container to the top
			$container2.css("margin-top", $container2.attr("data-max")-$container2.attr("data-min")+"px" );
			$container2.addClass("scroll-active");
		}
	}
	//do one container move on load
	container_move2();	
	}	
	}
	/** END CART*/
	
	
	$( document ).on( "click", ".back-top-menu", function() {
		scroll_class('opening-hours-wrap');
	});
	
	if ( $("#address_book_id").exists() ){		
		$(".address-block").hide();
		$(".saved_address_block").hide();
				
	    	$("#street").removeAttr("data-validation");
  	    $("#city").removeAttr("data-validation");
  	    $("#state").removeAttr("data-validation");
        $("#zipcode").removeAttr("data-validation");
	}
		
	$( document ).on( "click", ".edit_address_book", function() {


    $('#zipcode').val('');
    $('#location_name').val('');
    $('#street').val('');
    $('#city').val('');
    $('.check_out_parish_select').val(0);


		$(".address_book_wrap").remove();
		$(".address-block").show();
		$(".saved_address_block").show();
				
	     //	$("#street").attr("data-validation",'required');
  	    $("#city").attr("data-validation",'required');
  	    $("#state").attr("data-validation",'required');
        $("#zipcode").attr("data-validation",'required');
	});
	
	$( document ).on( "click", ".map-address", function() {
		$(this).hide();
		
		$("#street").removeAttr("data-validation");
  	    $("#city").removeAttr("data-validation");
  	    $("#state").removeAttr("data-validation");
   	    $("#zipcode").removeAttr("data-validation");
              	  
		$(".address_book_wrap").hide();
		$(".address-block").hide();
		$("#map_address_toogle").val(2);
		$(".map-address-wrap-inner").show();
		
		$(".back-map-address").show();
		
		uk_msg_sucess(js_lang.trans_48);
		mapAddress();
	});
			
	$( document ).on( "click", ".paypal_paynow", function() {
		$(this).val(js_lang.processing);
		$(".paypal_paynow").css({ 'pointer-events' : 'none' });
	});
	
	/** set default if payment option is only */
	if ( $(".payment-option-page").exists() ){
		var c=$(".payment_option").length;
		if ( c==1){			
			$(".payment_option").attr("checked",true);
			$('.payment_option').iCheck('update');
						
			if ( $(".payment_option:checked").val()=="cod" ){
				$(".change_wrap").show();
			}		
			if ( $(".payment_option:checked").val()=="ccr" || $(".payment_option:checked").val()=="ocr" ){
				$(".credit_card_wrap").show();
			}	
		}
	}
	
}); /*end docu*/
/*SCROLLING DIV ENDS HERE*/

var temp_geocoder = new google.maps.Geocoder();

function mapAddress()
{		 
	  $("#temporary_address").geocomplete({
          map: ".map_address",           
          markerOptions: {
            draggable: true             
          }       
      });        
      $("#temporary_address").trigger("geocode");          
      
     $("#temporary_address").bind("geocode:dragged", function(event, latLng){            
	      $("#map_address_lat").val( latLng.lat() );
	      $("#map_address_lng").val( latLng.lng() );
	      /*codeLatLng(latLng.lat(),latLng.lng());*/
     });
}

/** END VERSION 2.1.1 added code*/


/** START ADDED CODE VERSION 2.3*/
jQuery(document).ready(function() {	
	$( document ).on( "click", ".filter-search-bar", function() {
		$(".filter-options").slideToggle("fast");
	});
	
    $( document ).on( "click", ".forgot-pass-link2", function() {    	    
    	  $(".section-forgotpass").fadeIn();    	  
    });
        	
}); /*end docu*/	
/** END CODE VERSION 2.3*/


/** START ADDED CODE VERSION 2.4*/
jQuery(document).ready(function() {	
	$( document ).on( "click", ".clear-cart", function() {
		clearCart();
	});
	
	if ( $("#disabled_cart_sticky").exists() ){
		if ( $("#disabled_cart_sticky").val()==2){
		    $(".scroll-parent2 .order-list-wrap").removeClass("scroll-child2");
		}
	}
}); /*end docu*/	

function clearCart()
{	
	var ans=confirm(js_lang.trans_4); 
	if (!ans){
		return;
	}
	var params="action=clearCart&currentController=store";	
	busy(true);
    $.ajax({    
    type: "POST",
    url: ajax_url,
    data: params,
    dataType: 'json',       
    success: function(data){ 
    	busy(false);
    	load_item_cart();    	
    }, 
    error: function(){	        	    	
    	busy(false); 
    }		
    });
}

function clearCartButton(option)
{	
	if ( option==1){
		$(".clear-cart").show();
	} else {
		$(".clear-cart").hide();
	}
}

var recaptcha1; // for customer signup
var recaptcha2; // for customer login

var KMRSCaptchaCallback = function(){
	dump('init recaptcha');
	if ( !$(".recaptcha").exists()){
		return;
	}
	if (typeof captcha_site_key === "undefined" || captcha_site_key==null || captcha_site_key=="") {   
		return;
	}			
	if ( $("#RecaptchaField1").exists() ){
		dump('RecaptchaField1');
        recaptcha1=grecaptcha.render('RecaptchaField1', {'sitekey' : captcha_site_key});    
	}
	if ( $("#RecaptchaField2").exists() ){
        recaptcha2=grecaptcha.render('RecaptchaField2', {'sitekey' : captcha_site_key});    
	}
};
/** START ADDED CODE VERSION 2.4*/


/** START ADDED CODE VERSION 2.5*/
jQuery(document).ready(function() {	
	$( document ).on( "click", ".view-order-history", function() {		
		var parent=$(this).parent().parent();
		var i=parent.find("i");		
		$(".show-history-"+ $(this).data("id") ).slideToggle("fast",function() {     
			if (i.hasClass("ion-android-arrow-dropright")){
			i.removeClass("ion-android-arrow-dropright");
				i.addClass("ion-android-arrow-dropdown");
			} else{
				i.addClass("ion-android-arrow-dropright");
				i.removeClass("ion-android-arrow-dropdown");
			} 
        });		
	});

    $( document ).on( "click", ".send-order-sms-code", function() {    	
    	    	
    	var sosc=$(this);
    	sosc.css({ 'pointer-events' : 'none' });
		var params="action=sendOrderSMSCode&currentController=store&session="+sosc.data("session")+"&mobile="+$("#contact_phone").val()+"&mtid="+$("#merchant_id").val();	
		busy(true);
	    $.ajax({    
	    type: "POST",
	    url: ajax_url,
	    data: params,
	    dataType: 'json',       
	    success: function(data){ 
	    	busy(false);	    	
	    	sosc.css({ 'pointer-events' : 'auto' });
	    	if (data.code==1){
	    		uk_msg_sucess(data.msg);
	    	} else {
	    		uk_msg(data.msg);
	    	}
	    }, 
	    error: function(){	        	    	
	    	busy(false); 
	    	sosc.css({ 'pointer-events' : 'auto' });
	    }		
	    });
	});
}); /*end ready*/

/** END ADDED CODE VERSION 2.5*/


/** START ADDED CODE VERSION 2.6*/
jQuery(document).ready(function() {		
	
	$( document ).on( "change", ".s_city", function() {    	
		var selected=$(this).val();				
		if ( selected!="-1"){
			$(".s_area").val("-1");
			$(".areas").addClass("area-hidden");
			$("."+selected).removeClass("area-hidden");
		} else {
			$(".areas").addClass("area-hidden");
		}
	});	
		
}); /*end ready*/
/** END ADDED CODE VERSION 2.6*/

function empty(data)
{
	if (typeof data === "undefined" || data==null || data=="" ) { 
		return true;
	}
	return false;
}