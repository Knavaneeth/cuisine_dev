//Soosai Raj
var $drawerOverlay = $(".sidebar-overlay");
$(".toggle-menu").on("click", function(e) {
	var $target = $($(this).attr("href"));
	if ($target.length) {
		$target.toggleClass("opened");
		$drawerOverlay.toggleClass("opened");
		$drawerOverlay.attr("data-reff", $(this).attr("href"))
	}
	e.preventDefault()
});
$drawerOverlay.on("click", function(e) {
	var $target = $($(this).attr("data-reff"));
	if ($target.length) {
		$target.removeClass("opened");
		$(this).removeClass("opened")
	}
	e.preventDefault()
});
//For Overlay menu-dont touch it--End Here

var ajax_url= krms_config.ApiUrl ;
var SoundUrl= krms_config.SoundUrl ;
var dialog_title_default= krms_config.DialogDefaultTitle;
var search_address;
var ajax_request;
var networkState;

var translator;
var dictionary;

var map;
var map_marker;

var altpopup;
var altpopuptwo;
var loader=$("#loader-wrap");
var modalloader=$(".modal-load");
var modalloaderbook=$("#modal-load-book");
document.addEventListener("deviceready", onDeviceReady, false);

function onDeviceReady() {
	console.log("ok");
	isLogin();
	$(".actions-1").hide();
	$(".actions-2").hide();
	$(".actions-3").hide();
	$(".actions-4").hide();
	$(".actions-5").hide();


}

jQuery.fn.exists = function(){return this.length>0;}
jQuery.fn.found = function(){return this.length>0;}


document.addEventListener("offline", noNetConnection, false);


function noNetConnection()
{
	hideAllModal();
    ajax_request.abort();
	toastMsg( getTrans("Internet connection lost","net_connection_lost") );
}


function dump(data)
{
	console.debug(data);
}

function setStorage(key,value)
{
	localStorage.setItem(key,value);
}

function getStorage(key)
{
	return localStorage.getItem(key);
}

function removeStorage(key)
{
	localStorage.removeItem(key);
}

function explode(sep,string)
{
	var res=string.split(sep);
	return res;
}

function urlencode(data)
{
	return encodeURIComponent(data);
}

function empty(data)
{
	if (typeof data === "undefined" || data==null || data=="" ) {
		return true;
	}
	return false;
}

$( document ).on( "keyup", ".numeric_only", function() {
  this.value = this.value.replace(/[^0-9\.]/g,'');
});

/*onsen ready*/
//ons.bootstrap();
//ons.ready(function() {

	// $('#allorders-orders').on('scroll', function(){
  //   	swal("ok");
  // });

	dump("ready");

	refreshConnection();
	if (!empty(getStorage("merchant_token"))){
		dump('has token');
		var mName= getMerchantInfoStorage();
		$("#merchant-name").html(mName.restaurant_name);
		//dump(mName.restaurant_name);
		if(getStorage("table_book_show") == "false")
		 {
				$(".table_booking").css({"display":"none"});
				$(".take_away").css({"display":"none"});
		 }
		 if(getStorage("merchant_delivery_time")=="")
		 {
			 $("#delivery_time").val("0");
			 $("#merchnt_dlvry_time").html("0");

			 $("#pickup_time").val("0");
			 $("#merchnt_pickup_time").html("0");

		 }
		 else{
		 $("#delivery_time").val(getStorage("merchant_delivery_time"));
		 $("#merchnt_dlvry_time").html(getStorage("merchant_delivery_time"));
		 $("#pickup_time").val(getStorage("merchant_pickup_time"));
		 $("#merchnt_pickup_time").html(getStorage("merchant_pickup_time"));
		 }


		loader.show();
	    dump( getStorage("merchant_token") );
	    //showHomePage();
			//setTimeout(function(){getNewPendingOrders();},4000);
		//then get the pending orders
		getPendingOrders();

		setTimeout(() => {
			GetPrinterIP();
		}, 2000);
		// Above function fails without timeout setting.. please check @mubarak

		
	   /* if(typeof NeworderPopUpDialog === "undefined" || NeworderPopUpDialog==null || NeworderPopUpDialog=="")
		   {
			   if (isLogin() ){
						ons.createDialog('NeworderPopUp.html').then(function(dialog) {
						 setTimeout(function(){getNewPendingOrders();},4000);
						dialog.show();
					}); }
		   }else {
				NeworderPopUpDialog.show();
			}*/
			/*if (isLogin() ){
						ons.createDialog('NeworderPopUp.html').then(function(dialog) {
						 //setTimeout(function(){getNewPendingOrders();},4000);
						dialog.show();
					}); }*/

	} else {
		dump('no token');
		window.location.href='index.html';
		//$("#page-login").show();
	}


function refreshConnection()
{
	if ( !hasConnection() ){
	} else {
	}
}

function hasConnection()
{
	/*myconn*/
	if(isDebug()){
		return true;
	}
	/*networkState = navigator.network.connection.type;
	if ( networkState=="Connection.NONE" || networkState=="none"){
		return false;
	}	*/
	return true;
}

function createElement(elementId,elementvalue)
{
   var content = document.getElementById(elementId);
   content.innerHTML=elementvalue;
   //$(elementId).append(elementvalue);
	$(elementvalue).after(elementId);
   //ons.compile(content);
}

/*PAGE INIT*/
document.addEventListener("pageinit", function(e) {
	dump("pageinit");
	dump("pagname => "+e.target.id);

	switch (e.target.id)
	{
		case "page-acceptOrderForm":
		initMobileScroller();
		translatePage();
		break;

		case "page-declineOrderForm":
		case "page-displayOrder":
		case "page-forgotpass":
		case "page-lostPassword":
		case "page-orderHistory":
		case "page-changesStatus":
		case "page-location-map":
		case "page-showNotification":
		case "page-SearchPopUp":
		case "page-searchResults":
		case "page-map":
		case "page-assignDriver":
		translatePage();
		break;

		case "page-orderstoday":
		$(".tab-action").val('GetTodaysOrder');
		$(".display-div").val('new-orders');
		$(".tab-active-page").html( getTrans('New Orders','new_order') );

		/*ons.createDialog('NeworderPopUp.html').then(function(dialog) {
			 setTimeout(function(){getNewPendingOrders();},4000);
	        dialog.show();
	    }); 	*/
		if ( !empty( getStorage("notification_push_type")  )){
			if (  getStorage("notification_push_type")=="order" ){

		         $(".tab-action").val('GetTodaysOrder');
                 $(".display-div").val('new-orders');
                 $(".tab-active-page").html( getTrans('New Orders','new_order') );
                 tabbar.setActiveTab(0);
		       	 removeStorage("notification_push_type");

		       	 showNotificationBadge(1);

			} else if ( getStorage("notification_push_type")=="booking" ){

				   $("#display-div").val('booking-pending');
				   $(".tab-active-page").html( getTrans("Booking","booking") );
				   tabbar.setActiveTab(3);
				   removeStorage("notification_push_type");

				   showNotificationBadge(1);

			} else {
				GetTodaysOrder();
			}
		} else {
			GetTodaysOrder();
		}


		translatePage();
		break;

		case "page-pendingorders":
		$(".tab-action").val('GetPendingOrders');
		$(".display-div").val('pending-orders');
		$(".tab-active-page").html( getTrans('Pending Orders','pending_orders') );
		getPendingOrders();
		break;

		case "page-allorders":
		$(".tab-action").val('GetAllOrders');
		$(".display-div").val('allorders-orders');
		$(".tab-active-page").html( getTrans('All Orders','all_orders') );
		getGetAllOrders();
		break;


		case "page-languageoptions":
	    callAjax('getLanguageSelection','');
	    break;

	   case "page-settings":

	    $(".device_id_val").html( getStorage("merchant_device_id") );
	    if (isDebug()){
	    	$(".software_version_text").html( "1.0" );
	    } else {
	    	$(".software_version_text").html( BuildInfo.version );
	    }

	    callAjax("getSettings",
	     "device_id="+getStorage("merchant_device_id")
	    );
	    translatePage();
	    break;

	   case "page-profile":
	      var info=getMerchantInfoStorage();
	      var params='';
		  params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	     callAjax('getProfile',params);
	     translatePage();
	    break;

	   case "page-slidemenu":
	   menu.on('preopen', function() {
          //console.log("Menu page is going to open");
          translatePage();
       });
	   break;

	   case "page-tablePending":
	      var info=getMerchantInfoStorage();
	      var params='';
		  params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax('PendingBooking',params);
	      translatePage();

	      $("#tab-action").val('pendingBooking');
	      $("#display-div").val('table-pending');
	      $(".page_label_book").html( getTrans("Pending Booking","pending_booking") );
	   break;

	   case "page-tableAll":
	      var info=getMerchantInfoStorage();
	      var params='';
		  params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax('AllBooking',params);
	      translatePage();

	      $("#tab-action").val('AllBooking');
	      $("#display-div").val('table-all');
	      $(".page_label_book").html( getTrans("All Booking","all_booking") );
	   break;

	   case "page-bookingtab":
	      $(".tab-active-page").html( getTrans("Booking","booking") );
	      $("#display-div").val('booking-pending');

	      var info=getMerchantInfoStorage();
	      var params='';
		  params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax('PendingBookingTab',params);
	      translatePage();

	   break;

	}

}, false);


function onsenswal(message,dialog_title)
{
	if (typeof dialog_title === "undefined" || dialog_title==null || dialog_title=="" ) {
		dialog_title=dialog_title_default;
	}
	swal(message);
	// ons.notification.swal({
  //     message: message,
  //     title:dialog_title
  //   });
}

function hideAllModal()
{
	//setTimeout('kloader.hide()', 1);
	loader.hide();
}

/*mycallajax*/
function callAjax(action,params)
{
	if ( !hasConnection() ){
		if ( action!="registerMobile"){
		    //onsenswal(  getTrans("CONNECTION LOST",'connection_lost') );
		    notyswal(  getTrans("CONNECTION LOST",'connection_lost'),'error' );
		}
		return;
	}

	params+="&lang_id="+getStorage("mt_default_lang");
	if(!empty(krms_config.APIHasKey)){
		params+="&api_key="+krms_config.APIHasKey;
	}
	var acn_chk = action;
	dump("Action=>"+action);
	dump(ajax_url+"/"+action+"?"+params);
	//if(action == "getNewPendingOrders") action = 'GetPendingOrders';
	ajax_request = $.ajax({
	 url: ajax_url+"/"+action,
	 data: params,
	 type: 'post',
	 async: true,
	 dataType: 'jsonp',
	// timeout: 5000,
	 crossDomain: true,
	 beforeSend: function() {
		if(ajax_request != null) {
		   /*abort ajax*/
		   hideAllModal();
           ajax_request.abort();
		} else {
			/*show modal*/
			switch(action)
			{
				case "none":
				   break;
				default:
				   //kloader.show();
				   break;
			}
		}
	},
	complete: function(data) {
		ajax_request=null;
		hideAllModal();
		view_order_page_bol = undefined;
		view_booking_page_bol = undefined;
	},
	success: function (data) {
		// dump(data);
		//if(action == "getNewPendingOrders") action = 'GetPendingOrders';
		if (data.code==1){

			dump('actions=>' + action);

			switch (action)
			{
				case "registerMobile":
				case "none":
				break;

				case "login":
				//    dump(data.details.token);
				//    setStorage("merchant_token",data.details.token);
				//    setStorage("merchant_info",JSON.stringify(data.details.info));
				//    showHomePage();
				// break;

				case "GetTodaysOrder":

				    displayTodayOrders(data.details,'today-orders');
				break;
					case "AcceptedOrderList":
						setStorage("orderSummary",JSON.stringify(data.details));
						displayTodayOrdersSummary(data.details,'TodaySummary');
						console.log(JSON.parse( getStorage("orderSummary")));
						break;
				case "DriversCollectionList":
					setStorage("driverSummary",JSON.stringify(data.details));
					displayDriverSummary(data.details,'DriverSummary');
					console.log(JSON.parse( getStorage("driverSummary")));
				break;
						case "GetIpAddr":
							setStorage("primaryip",data.details.primary_ip);
							setStorage("kitchenip",data.details.kitchen_ip);
							displayPrinter(data.details);
							break;

				case "GetPendingOrders":
				   displayOrders(data.details,'pending-orders');
				break;
				case "getPendingOrders":
				  displayNewOrders(data.details,'pending-order');
				break;

				case "UpdateMerchantTimings":
				setStorage("merchant_delivery_time",data.details);
				$("#merchnt_dlvry_time").html(getStorage("merchant_delivery_time"));
				swal(data.msg);
				break;

				case "UpdatePickupTimings":
				setStorage("merchant_pickup_time",data.details);
				$("#merchnt_pickup_time").html(getStorage("merchant_pickup_time"));
				swal(data.msg);
				break;

				case "GetAllOrders":
				   displayAllOrders(data.details,'allorders-orders');
				break;

				case "OrderdDetails":
				displayOrderDetails(data.details);
				break;

				case "DeclineOrders":
				swal({
				 title: krms_config.DialogDefaultTitle,
				 text: data.msg,
				 type: "success"
			 }).then(function() {
				 	modalloader.css("display","none");
					location.reload();
				 });
				//swal(data.msg);
				//location.reload();
				// var options = {
				//    animation: 'none',
				//    onTransitionEnd: function() {
				//    }
				//  };
				// kNavigator.resetToPage('slidemenu.html',options);
				break;
				case "UpdateIpAddr":
					console.log(data.details.kitchen_ip);
					setStorage("primaryip",data.details.primary_ip);
					setStorage("kitchenip",data.details.kitchen_ip);
					swal(data.msg);
				break;
				case "AcceptOrdes":
					printOrder();
					swal({
					 title: krms_config.DialogDefaultTitle,
					 text: data.msg,
					 type: "success"
				 }).then(function() {
					 	modalloader.css("display","none");
						//location.reload();
						location.reload();
					 });

				break;
				case "ChangeOrderStatus":
				swal({
				 title: krms_config.DialogDefaultTitle,
				 text: data.msg,
				 type: "success"
			 }).then(function() {
					location.reload();
				 });


				break;

				case "StatusList":
				statusList(data.details);
				break;

				case "getLanguageSelection":
				displayLanguageSelection(data.details);
				break;


				case "getSettings":
			       if ( data.details.enabled_push==1){
			       	   enabled_push.setChecked(true);
			       } else {
			       	   enabled_push.setChecked(false);
			       }

			       dump(data.details.food_option_not_available);
			       switch (data.details.food_option_not_available)
			       {
			       	   case 1:
			       	   case "1":
			       	   food_option_not_available.setChecked(true);
			       	   food_option_not_available_disabled.setChecked(false);
			       	   break;

			       	   case 2:
			       	   case "2":
			       	   food_option_not_available.setChecked(false);
			       	   food_option_not_available_disabled.setChecked(true);
			       	   break;

			       	   default:
			       	   food_option_not_available.setChecked(false);
			       	   food_option_not_available_disabled.setChecked(false);
			       	   break;
			       }

			       if (data.details.merchant_close_store=="yes"){
			       	   merchant_close_store.setChecked(true);
			       } else {
			       	   merchant_close_store.setChecked(false);
			       }

			       if (data.details.merchant_show_time=="yes"){
			       	   merchant_show_time.setChecked(true);
			       } else {
			       	   merchant_show_time.setChecked(false);
			       }

			       if (data.details.merchant_disabled_ordering=="yes"){
			       	   merchant_disabled_ordering.setChecked(true);
			       } else {
			       	   merchant_disabled_ordering.setChecked(false);
			       }

			       if (data.details.merchant_enabled_voucher=="yes"){
			       	   merchant_enabled_voucher.setChecked(true);
			       } else {
			       	   merchant_enabled_voucher.setChecked(false);
			       }

			       if (data.details.merchant_required_delivery_time=="yes"){
			       	   merchant_required_delivery_time.setChecked(true);
			       } else {
			       	   merchant_required_delivery_time.setChecked(false);
			       }

			       if (data.details.merchant_enabled_tip=="2"){
			       	   merchant_enabled_tip.setChecked(true);
			       } else {
			       	   merchant_enabled_tip.setChecked(false);
			       }

			       if (data.details.merchant_table_booking=="yes"){
			       	   merchant_table_booking.setChecked(true);
			       } else {
			       	   merchant_table_booking.setChecked(false);
			       }

			       if (data.details.accept_booking_sameday=="2"){
			       	   accept_booking_sameday.setChecked(true);
			       } else {
			       	   accept_booking_sameday.setChecked(false);
			       }

			     break;

			    case "geoDecodeAddress":
				  var locations={
					"name":data.address ,
					"lat":data.details.lat,
					"lng":data.details.long
					};
					//window.open('https://support.wwf.org.uk', '_blank');
				  //initMap(locations);
			    break;

			    case "ForgotPassword":
			    dialogForgotPass.hide();

			    var options = {
			      animation: 'none',
			      onTransitionEnd: function() {
			      	 $(".changepass-msg").html( data.msg );
			      	 $(".email_address").val( data.details.email_address );
			      	 $(".user_type").val( data.details.user_type );
			      }
			    };
			    kNavigator.pushPage("lostPassword.html", options);
			    break;

			    case "OrderHistory":
			    $(".order-history-title").html( getTrans('Order history #','order_history')  + data.details.order_id);
			    displayHistory(data.details.data);
			    break;

			    case "ChangePasswordWithCode":
			    onsenswal(data.msg);
			    kNavigator.popPage({cancelIfRunning: true});
			    break;

			    case "getProfile":
			    $(".username").val(data.details.username);
			    break;

			    case "getLanguageSettings":
			      setStorage("mt_translation",JSON.stringify(data.details.translation));

			      var device_set_lang=getStorage("mt_default_lang");
			      dump("device_set_lang=>"+device_set_lang);

			      if (empty(device_set_lang)){
			       	   dump('proceed');
				       if(!empty(data.details.settings.default_lang)){
				          setStorage("mt_default_lang",data.details.settings.default_lang);
				       } else {
				       	  setStorage("mt_default_lang","");
				       }
			       }
			       translatePage();
			    break;


			    case "getNotification":
			    displayNotification(data.details);
			    break;

			    case "searchOrder":
			    //$(".search_results_found").html( data.msg);
			    displayOrders(data.details,'search-resuls');
			    break;

			    case "PendingBooking":
			       displayBooking(data.details,'table-pending');
			    break;

			    case "AllBooking":
			       displayAllBooking(data.details,'table-all');
			    break;

			    case "GetBookingDetails":
			    $("#booking-view-title").html( getTrans("Booking Details #",'booking_details') + data.details.booking_id );
			    displayBookingDetails(data.details.data);
			  //  translatePage();
			    break;

				case "bookingChangeStats":
				    printTable();
			        var options = {
				      animation: 'none',
				      onTransitionEnd: function() {
				      }
				    };
					//notyswal(data.msg,'error');
					//swal(data.msg);
					//kNavigator.resetToPage('bookingHome.html',options);

					if(data.msg=="Sms Sent.")
					{
						swal("Sms sent");
						swal({
						 title: krms_config.DialogDefaultTitle,
						 text: data.msg,
						 type: "success"
					 }).then(function() {
							location.reload();
						 });
					}
					else
					{
						//swal("Sms Not Sent");
						swal({
						 title: krms_config.DialogDefaultTitle,
						 text: data.msg,
						 type: "success"
					 }).then(function() {
							location.reload();
						 });
					}
			    break;

			    case "loadTeamList":
			       $(".driver_selected").html( getTrans('Assigned Driver','assigned_driver') );
			       $(".driver_id").val('');
			       displayTeamList(data.details);
			    break;

			    case "driverList":
			       displayDriverList(data.details);
			    break;

			    case "assignTask":
				  // swal(data.msg);
					modalloader.css("display","none");
					 swal({
            title: krms_config.DialogDefaultTitle,
            text: data.msg,
            type: "success"
					}).then(function() {
             //location.reload();
						  window.location = "order-list.html";
        		});

			       //toastMsg(data.msg);
						 // var options = {
		 				 //   animation: 'none',
		 				 //   onTransitionEnd: function() {
		 				 //   }
		 				 // };
		 				//kNavigator.resetToPage('slidemenu.html',options);
          	//kNavigator.popPage({cancelIfRunning: true});
			    break;

			    case "PendingBookingTab":
			       displayBooking(data.details,'newbooking-list');
			    break;

			    case "saveSettings":
			      toastMsg(data.msg);
			    break;

				default:
				   dump('default');
				   onsenswal(data.msg);
				break;
			}

		} else if(data.code==3){

			removeStorage("merchant_token");
            removeStorage("merchant_info");
			onsenswal(data.msg);
			swal(data.msg);
			//kNavigator.popPage();
			window.location.href="index.html";

		} else {
			// failed response
			switch (action)
			{
				case "registerMobile":
				case "none":
				case "getLanguageSettings":
				break;
				case "UpdateIpAddr":
					swal(data.msg);
				break;
				case "AcceptedOrderList":
				swal(data.msg);
				break;
				case "GetPendingOrders":
				//notyswal(data.msg,"error");
				$("#pending-orders-msg").html(data.msg);
				//swal(data.msg);
				GetTodaysOrder();
				break;

				case "getPendingOrders":
				$("#pending-orders-msg").html(data.msg);
				setTimeout(function(){getNewPendingOrders();},10000);
				break;

				case "UpdateMerchantTimings":
				$("#merchnt_dlvry_time").html(getStorage("merchant_delivery_time"));
				swal(data.msg);

				case "UpdatePickupTimings":
				$("#merchnt_pickup_time").html(getStorage("merchant_pickup_time"));
				swal(data.msg);

				break;
				case "GetAllOrders":
				case "getNotification":
				case "searchOrder":
				case "PendingBooking":
				case "AllBooking":
				$("#all-booking-error").html(data.msg);
				break;
				case "PendingBookingTab":
				$("#new-booking-error").html(data.msg);
				getAllBooking();
				break;

				case "GetTodaysOrder":
				//notyswal(data.msg,"error");
				$("#new-orders").html(' Waiting for order...');
				getGetAllOrders();
				break;

				case "OrderdDetails":
				onsenswal(data.msg);
				kNavigator.popPage({cancelIfRunning: true});
				break;

				case "OrderHistory":
				//onsenswal(data.msg);
				notyswal(data.msg,"error");
			    $(".order-history-title").html( getTrans('Order history #','order_history') + data.details);
			    break;

			    case "GetBookingDetails":
			    $("#booking-view-title").html( getTrans("Booking Details #",'booking_details') );
			    notyswal(data.msg,"error");
			    break;

			    case "getSettings":
			    onsenswal(data.msg);
			    break;

			    case "loadTeamList":
			      $(".team_selected").html( getTrans('Select Team','select_team') );
			      onsenswal(data.msg);
			      createElement("team-list",'');
			      teamListDialog.hide();
			    break;

			    case "driverList":
			       $(".driver_selected").html( getTrans('Assigned Driver','assigned_driver') );
			       onsenswal(data.msg);
			       createElement("driver-list",'');
			       driverListDialog.hide();
			    break;

				default:
				onsenswal(data.msg);
				break;
			}
		}
	},
	error: function (request,error) {
		//if(action == "getNewPendingOrders") action = 'GetPendingOrders';
		hideAllModal();
		view_order_page_bol = undefined;
		dump("MY CALL ERROR=>" + action);
		switch (action)
		{
			case "getLanguageSettings":
			case "registerMobile":
			case "getLanguageSettings":
			break;
			case "GetIpAddr":
			GetPrinterIP();
			//swal("Set the printer settings..");
			break;
			case "OrderdDetails":
			swal("Something unusual happened. Pull down to refresh");
			break;
			case "GetTodaysOrder":
			notyswal( getTrans("Network error. Try again!",'network_error')  ,"error");
			break;

			default:
			//swal("Error Occurs");
			//onsenswal( getTrans("Network error has occurred please try again!",'network_error') );
			notyswal( getTrans("Network error . Try again!",'network_error')  ,"error");
		    break;
		}
	}
   });

} /*end callajax*/

function getTrans(words,words_key)
{
	return words;
}
function changedeliveryTime()
{
	var time=$("#delivery_time").val();
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	params+="&time="+time;
	var params;
	params+="&merchant_device_id="+getStorage("merchant_device_id");
	callAjax("UpdateMerchantTimings",params);
	return false;
}

function changePickupTime()
{
	var time=$("#pickup_time").val();
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	params+="&time="+time;
	var params;
	params+="&merchant_device_id="+getStorage("merchant_device_id");
	callAjax("UpdatePickupTimings",params);
	return false;
}

function savePrinterIPs() {
	var primaryIP = $("#primary_ip").val();
	var kitchenIP = $("#kitchen_ip").val();
	setStorage("primaryip",primaryIP);
	setStorage("kitchenip",kitchenIP);
	var params = $( "#frm_printer").serialize();
	var info=getMerchantInfoStorage();
	params+="&token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	callAjax("UpdateIpAddr",params);

	//	return false;
	if(kitchenIP != '' || kitchenIP == undefined) { //we should validate the IP format is correct or not..
		//business logic
	}
	dump(primaryIP);
	dump(kitchenIP);

	//Once saved, try to connect the printer
	connect();
}


function login()
{
	var uname=$("#uname").val();
	var pass=$("#upass").val();
	if(uname == "")
	{
		swal("Username is mandatory");
	}
	else if(pass == ""){
		swal("Password is mandatory");
	}
	else{
		var params = $("#frm-login").serialize();
		var split_params = params.split("&");
		params = '';
		for(var i=0;i<split_params.length;i++){
				var sub_params = split_params[i].split("=");
				if(sub_params[0] == "password")
				params += sub_params[0]+"="+window.btoa(sub_params[1])+"&";
				else
				params += split_params[i]+"&";
		}
		params+="merchant_device_id="+getStorage("merchant_device_id");
		callAjax("login",params);
		return false;
	}
	// $.validate({
  //       form : '#frm-login',
  //       borderColorOnError:"#FF0000 ",
  //       onError : function() {
	// 				console.log("Error");
  //       },
  //       onSuccess : function() {
	// 				console.log("Success");
  //         var params = $("#frm-login").serialize();
  //         var split_params = params.split("&");
  //         params = '';
  //         for(var i=0;i<split_params.length;i++){
  //             var sub_params = split_params[i].split("=");
  //             if(sub_params[0] == "password")
  //             params += sub_params[0]+"="+window.btoa(sub_params[1])+"&";
  //             else
  //             params += split_params[i]+"&";
  //         }
  //         params+="merchant_device_id="+getStorage("merchant_device_id");
  //         callAjax("login",params);
  //         return false;
  //       }
  //   });
}

function showForgotPass()
{
	$(".email_address").val('');
	if (typeof dialogForgotPass === "undefined" || dialogForgotPass==null || dialogForgotPass=="" ) {
		ons.createDialog('forgotPassword.html').then(function(dialog) {
	        dialog.show();
	        $(".email_address").attr("placeholder",  getTrans('Email Address','email_address') );
	    });
	} else {
		dialogForgotPass.show();
	}
}

function showHomePage()
{
	window.location.href="order-list.html";
  if (isLogin() ){

	//setTimeout(function(){getNewPendingOrders();},2000);
	}
}

function setHome()
{
    var options = {
  	   closeMenu:true,
       animation: 'slide',
       //callback:GetTodaysOrder
    };
    menu.setMainPage('home.html',options);
}

function logout()
{
   removeStorage("merchant_token");
   removeStorage("merchant_info");
	 window.location.href="index.html";
   // var pages = kNavigator.getPages();
   // dump(pages);
   // dump(pages.length);
   //
   // if ( pages.length<=1){
   //    kNavigator.resetToPage('pageLogin.html', {
  	//    closeMenu:true,
   //     animation: 'none',
   //     onTransitionEnd: function() {
   //     	  $("#page-login").show();
   //     	  $("#frm-login").reset();
   //     }
   //    });
   // } else {
   // 	  kNavigator.popPage();
   // }
   //kNavigator.resetToPage('slidemenu.html',options);
	//NeworderPopUpDialog.hide();
}

function load(done)
{
	dump('pull');

	if ( !hasConnection() ){
		notyswal(  getTrans("CONNECTION LOST",'connection_lost'),'error' );
		done();
		return;
	}

	//var action="GetTodaysOrder";
	var action= $(".tab-action").val();
	var div_id= $(".display-div").val();

	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	params+="&lang_id="+getStorage("mt_default_lang");

    if(!empty(krms_config.APIHasKey)){
		params+="&api_key="+krms_config.APIHasKey;
	}

	dump(ajax_url+"/"+action+"/?"+params);

    ajax_request = $.ajax({
	 url: ajax_url+"/"+action,
	 data: params,
	 type: 'post',
	 async: true,
	 dataType: 'jsonp',
	// timeout: 5000,
	 crossDomain: true,
	 beforeSend: function() {
		if(ajax_request != null) {
		   /*abort ajax*/
		   hideAllModal();
           ajax_request.abort();
		}
	},
	complete: function(data) {
		ajax_request=null;
	},
	success: function (data) {
		dump(data);
		done();
		if (data.code==1){
			displayOrders(data.details,div_id);
		} else if(data.code==3){

		} else {
			// failed response
			notyswal(data.msg,"error");
			$("#new-orders").html('Pull down to refresh. Something went wrong');
		}
	},
	error: function (request,error) {

	}
   });
}

function GetTodaysOrder()
{
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	callAjax("GetTodaysOrder",params);
}
var today = new Date();

    var weekday = new Array(7);
    weekday[0] = "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";

var current_day = weekday[today.getDay()];
console.log(current_day);
var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
var month=monthNames[today.getMonth()];
console.log(month);
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){
    dd='0'+dd;
}
if(mm<10){
    mm='0'+mm;
}
var today = current_day +", "+ dd +" "+ month +" "+ yyyy ;
setStorage("dates",today);
console.log(today);

function GetPrinterIP()
{
	dump("Getting printer IPs from backend");
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	callAjax("GetIpAddr",params);
}

function GetTodaysOrderSummary()
{
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	params+="&date="+today;
	callAjax("AcceptedOrderList",params);
}

function GetTodaysOrderSummaryDate(date)
{
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	params+="&date="+date;
	callAjax("AcceptedOrderList",params);
}

function GetDriverSummary()
{
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	params+="&delivery_date="+today;
	callAjax("DriversCollectionList",params);
}

function GetDriverSummaryDate(date)
{
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&merchant_id="+info.merchant_id;
	params+="&delivery_date="+date;
	callAjax("DriversCollectionList",params);
}

function get_new_order()
{
		var params="action=getNewOrder";
		 $.ajax({
			 type: "POST",
				url: ajax_url,
				data: params,
				dataType: 'json',
				success: function(data){
					 if (data.code==1){
						 console.log(data);
							 //  if ( $(".merchant-dashboard").exists() ) {
							 //      table_reload();
							 //  }
							 //  if( $('.uk-notify').is(':visible') ) {
							 // } else {
							 //     if ( $("#alert_off").val()=="" ){
							 //        $("#jquery_jplayer_1").jPlayer("play");
							 //     } else {
							 //     }
							 //      $.UIkit.notify({
							 //               message : data.msg+" "+js_lang.NewOrderStatsMsg+data.details
							 //         });
							 // }
						}
				},
				error: function(){
			 }
	 });
}
function getPendingOrders()
{
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	callAjax("GetPendingOrders",params);
}

function getNewPendingOrders(){
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	callAjax("getPendingOrders",params);
}



function getGetAllOrders()
{
	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	callAjax("GetAllOrders",params);
}


function getNewBooking(){
	var info=getMerchantInfoStorage();
	  var params='';
	  params+="&token="+getStorage("merchant_token");
	  params+="&user_type="+info.user_type;
	  params+="&mtid="+info.merchant_id;
	  callAjax('PendingBookingTab',params);
}

function getAllBooking(){
	var info=getMerchantInfoStorage();
	  var params='';
	  params+="&token="+getStorage("merchant_token");
	  params+="&user_type="+info.user_type;
	  params+="&mtid="+info.merchant_id;
	  callAjax('AllBooking',params);
		//console.log(getStorage("merchant_info"));
}

function getMerchantInfoStorage()
{
	var info =  JSON.parse( getStorage("merchant_info") );
	return info;
	//console.log(info);
}

function displayTodayOrders(data,div_id)
{ //new-orders
	var icon_trans_type=''; var icons=''; var icons2='';
	var htm='';
	$.each( data, function( key, val ) {
		//dump(val);
		htm+='<li class="media">';
		htm+='<a class="media-link" href="#" data-toggle="modal" data-target="#orderDetails" data-id="'+val.order_id+'" onclick="geetOrderId('+val.order_id+');">';

		icon_trans_type = getTransactionTypeIcons( val.trans_type_raw );

		var new_tag='';
		if (val.viewed==1){

			new_tag='<div class="new-icon"><span class="new-ordr">New</span></div>';
		}

		htm+='<div class="media-left media-middle">';
		   htm+= new_tag;
			htm+='<div class="truck-icon"><img src="assets/images/'+icon_trans_type+'.png" alt=""></div>';
		htm+='</div>';

		/*icons='fa-exclamation-triangle';
		icons2='';*/
		var icon=getOrderIcons(val.status_raw);
		var icons=icon.icons;
		var icons2=icon.classname;

		htm+='<div class="media-body media-middle">';
		   htm+='<div class="order-title">'+val.customer_name+'</div>';
		   htm+='<div class="order-number">'+ getTrans("Order No",'order_no') +'. <b>#'+val.order_id+'</b></div>';
		   htm+='<div class="order-date">'+val.delivery_date+'</div>';
		   htm+='<div class="order-status"> <span class="label status '+ val.status_raw +'"> ';
		   //htm+='<ons-icon icon="'+icons+'" class="icon '+icons2+'"></ons-icon>';
		   htm+=val.status;
		   htm+='</span></div>';
		 htm+='</div>';





		 htm+='<div class="media-right media-middle">';
		   htm+='<div class="order-det">	<div class="order-amount"><b>'+val.bill_total+'</b></div>';
		   htm+='<div class="order-time">';
		   if (!empty(val.delivery_time)){
		     htm+='<i class="fa fa-clock-o fa-lg"></i>';
		     htm+=' <b>'+val.delivery_time+'</b> ';
		   }
		   if (!empty(val.delivery_asap)){
		     htm+=' <b>'+val.delivery_asap+'</b> ';
		   }
		   htm+='</div>';
		 htm+='</div></div>';

		htm+='</a>';
		htm+='</li>';
	});
	//createElement('new-orders',htm);

	createElement(div_id,htm);
	//setTimeout(function(){getNewPendingOrders();},4000);
	getGetAllOrders();
}
var total;

function displayPrinter(data)
{
	$("#primary_ip").val(data.primary_ip);
	$("#kitchen_ip").val(data.kitchen_ip);
}


function displayTodayOrdersSummary(data,div_id,date)
{
	var htm='';
	var total=0;

	$("#summary").html(getStorage("dates"));
	$("#accpt_cnt").html(data.accepted_order_count);
	$("#decln_cnt").html(data.declined_order_count);
	$("#totl_paid").html(parseFloat(data.cash_total+data.citypay_total+data.paypal_total).toFixed(2)); // Adding up all to get the total sum
	//$("#vochr_pymnts").html(data.citypay_total); // Vouchers is not coming. this has to be fixed
	$("#city_pymnts").html(data.citypay_total); //Backend has to send us rate in two decimals. Citypay is 14.4 but it has to be 14.40 to display
	$("#paypal_pymnts").html(data.paypal_total);
	$("#csh_pymnts").html(data.cash_count);

	if(data.accepted_order.length > 0)
	{
		$("#accepted_orders_table").show();
		$("#summaryerror_accptd").html('');
	$.each( data.accepted_order , function( key, val ) {
		total += parseFloat(val.total_w_tax);
		htm+='<tr>';
		htm+='<td>'+val.ordered_time+'</td>';
		htm+='<td><b>#'+val.order_id+'</td>';
		htm+='<td></td>'; //This is always Channel Isles, when the shipping address bugs are fixed, we can enable this //val.state
		
		if(val.payment_type == "cod" || val.payment_type == "cash")
		{
		htm+='<td>Cash</td>';
		}
		htm+='<td>£ '+parseFloat(val.total_w_tax).toFixed(2)+'</td>'
		htm+='</tr>';
	});

	htm+='<tr><td class="font-bold">Total</td><td></td><td></td><td></td><td class="font-bold">£ '+total.toFixed(2)+'</td></tr>';
	console.log('£ '+total);
	createElement(div_id,htm);
	}
	else{
		$("#summaryerror_accptd").html("None");
		$("#accepted_orders_table").hide();

		$("#accpt_cnt").html('');
		$("#decln_cnt").html('');
		$("#totl_paid").html(''); // Adding up all to get the total sum
		$("#city_pymnts").html(''); //Backend has to send us rate in two decimals. Citypay is 14.4 but it has to be 14.40 to display
		$("#paypal_pymnts").html('');
		$("#csh_pymnts").html('');

	}
	var html='';
	var total1=0;
	if(data.declined_order.length > 0){
		$("#TodaySummaryDeclined").html('');
		$("#decline_orders_table").show();
		$("#summaryerror_decline").html('');
	$.each( data.declined_order, function( key, val ) {
		total1 += parseFloat(val.total_w_tax);
		html+='<tr>';
		html+='<td>'+val.ordered_time+'</td>';
		html+='<td><b>#'+val.order_id+'</td>';
		//htm+='<td></td>'; //This is always Channel Isles, when the shipping address bugs are fixed, we can enable this //val.state
		if(val.payment_type == "cod" || val.payment_type == "cash")
		{
		html+='<td>Cash</td>';
		}
		html+='<td>£ '+parseFloat(val.total_w_tax).toFixed(2)+'</td>'
		html+='</tr>';
	});

	html+='<tr><td class="font-bold">Total</td><td></td><td></td><td class="font-bold">£ '+total1.toFixed(2)+'</td></tr>';
	console.log('£ '+total1);

	$("#TodaySummaryDeclined").append(html);
}
else{
	$("#summaryerror_decline").html("None");
	$("#decline_orders_table").hide();
}
}


function displayDriverSummary(data,div_id)
{
	var htm='';
	var total=0;
	$("#summary_driver").html(getStorage("dates"));

	if(data.length > 0)
	{
	$.each( data , function( key, val ) {
		total += parseFloat(val.total_w_tax);
		htm+='<tr>';
		htm+='<td>'+val.driver_name+'</td>';
		htm+='<td>'+val.delivery_time+'</td>';
		htm+='<td><b>#'+val.order_id+'</td>';
		htm+='<td>'+val.state+'</td>'; //This is always Channel Isles, when the shipping address bugs are fixed, we can enable this //val.state
		htm+='<td>'+val.payment_type+'</td>';
		htm+='<td>£ '+parseFloat(val.total_w_tax).toFixed(2)+'</td>'
		htm+='</tr>';
	});
	htm+='<tr><td class="font-bold">Total</td><td></td><td></td><td></td><td></td><td class="font-bold">£ '+total.toFixed(2)+'</td></tr>';
	console.log('£ '+total);
	createElement(div_id,htm);
	}
	else{
		$("#summaryerror_driver").html("None");
		$("#accepted_orders_table").hide();
	}
}


function displayAllOrders(data,div_id)
{ //new-orders
	var icon_trans_type=''; var icons=''; var icons2='';
	var htm='';
	$.each( data, function( key, val ) {
		//dump(val);
		htm+='<li class="media">';
		htm+='<a class="media-link" data-toggle="modal" data-target="#orderDetails" data-id="'+val.order_id+'"  onclick="geetOrderId('+val.order_id+');">';

		icon_trans_type = getTransactionTypeIcons( val.trans_type_raw );

		var new_tag='';
		if (val.viewed==1){

			new_tag='<div class="new-icon"><span class="new-ordr">New</span></div>';
		}

		htm+='<div class="media-left media-middle">';
		   htm+= new_tag;
			htm+='<div class="truck-icon"><img src="assets/images/'+icon_trans_type+'.png" alt=""></div>';
		htm+='</div>';

		/*icons='fa-exclamation-triangle';
		icons2='';*/
		var icon=getOrderIcons(val.status_raw);
		var icons=icon.icons;
		var icons2=icon.classname;

		htm+='<div class="media-body media-middle">';
		   htm+='<div class="order-title">'+val.customer_name+'</div>';
		   htm+='<span class="order-number">'+ getTrans("Order No",'order_no') +'. <b>#'+val.order_id+'</b></span>';
		   htm+='<span class="order-date">'+val.delivery_date+'</span>';
		   htm+='<span class="order-status"> <span class="label status '+ val.status_raw +'"> ';
		   //htm+='<ons-icon icon="'+icons+'" class="icon '+icons2+'"></ons-icon>';
		   htm+=val.status;
		   htm+='</span></span>';
		 htm+='</div>';




		 htm+='<div class="media-right media-middle">';
		   htm+='<div class="order-det">	<div class="order-amount"><b>'+val.bill_total+'</b></div>';
		   htm+='<div class="order-time">';
		   if (!empty(val.delivery_time)){
		     htm+='<i class="fa fa-clock-o fa-lg"></i>';
		     htm+=' <b>'+val.delivery_time+'</b> ';
		   }
		   if (!empty(val.delivery_asap)){
		     htm+=' <b>'+val.delivery_asap+'</b> ';
		   }
		   htm+='</div>';
		 htm+='</div></div>';

		htm+='</a>';
		htm+='</li>';
	});
	//createElement('new-orders',htm);

	createElement(div_id,htm);
	//setTimeout(function(){getNewPendingOrders();},4000);
	loader.css("display", "none");
	setTimeout(function(){getNewPendingOrders();},10000);
}

var orderID;

$('#orderSummary').on('show.bs.modal', function (e) {
	GetTodaysOrderSummary();
	$("#datetimepicker_summary").val("");
	$("#TodaySummary").html("");
	$("#TodaySummaryDeclined").html("");

});

$('#driverSummary').on('show.bs.modal', function (e) {
	GetDriverSummary();
	$("#datetimepicker_driver").val("");
	$("#TodaySummary").html("");
	$("#TodaySummaryDeclined").html("");

});


$("#print").on('show.bs.modal', function (e) {
	GetPrinterIP();
});

function geetOrderId(data_id){
    orderID=data_id;
		$("#pending-orders li a[data-id=" + orderID + "] .new-icon").remove();// this will remove the new tag--Mubarak
		$("#pending-order li a[data-id=" + orderID + "] .new-icon").remove();// this will remove the new tag--Mubarak
		$("#pending-orders li ." + orderID).show();
		$("#pending-order li ." + orderID).hide();// this will remove the new tag--Mubarak

}

$('#orderDetails').on('show.bs.modal', function (e) {
		modalloader.css("display","table");
    $(this).find('#orderID').text(orderID);
		$("#take_away_details").show();
		$("#take_away_accept_form").hide();
		$("#take_away_decline_form").hide();
		$("#take_away_change_status").hide();
		$("#take_away_assign_driver").hide();
		viewOrder(orderID);
		$(".actions-1").hide();
	 $(".actions-2").hide();
	 $(".actions-3").hide();
	 $(".actions-4").hide();
	 $(".actions-5").hide();
		$("#order-details-page-title").html("");
		$("#order-details").html("");
		$("#order-details-item").html("");

});


//For Booking ID
var BookingID;

function getBookingId(data_id){
    BookingID=data_id;
}

$('#BookingDetails').on('show.bs.modal', function (e) {
		modalloaderbook.show();
    $(this).find('#orderID').text(BookingID);
		$("#booking_details_view").show();
		$("#booking_acceptance_form").hide();
		viewBooking(BookingID);
});



function displayOrders(data,div_id)
{ //new-orders
	loader.show();
	var icon_trans_type=''; var icons=''; var icons2='';
	var htm='';
	$.each( data, function( key, val ) {
		//dump(val);
		htm+='<li class="media '+val.order_id+'">';
		htm+='<a class="media-link" data-toggle="modal" data-target="#orderDetails" data-id="'+val.order_id+'" onclick="geetOrderId('+val.order_id+');">';

		icon_trans_type = getTransactionTypeIcons( val.trans_type_raw );

		var new_tag='';
		if (val.viewed==1){
			playSound('bing');
			new_tag='<div class="new-icon"><span class="new-ordr">New</span></div>';
		}

		htm+='<div class="media-left media-middle">';
		   htm+= new_tag;
			htm+='<div class="truck-icon"><img src="assets/images/'+icon_trans_type+'.png" alt=""></div>';
		htm+='</div>';

		/*icons='fa-exclamation-triangle';
		icons2='';*/
		var icon=getOrderIcons(val.status_raw);
		var icons=icon.icons;
		var icons2=icon.classname;

		htm+='<div class="media-body media-middle">';
		   htm+='<div class="order-title">'+val.customer_name+'</div>';
		   htm+='<div class="order-number">'+ getTrans("Order No",'order_no') +'. <b>#'+val.order_id+'</b></div>';
		   htm+='<div class="order-date">'+val.delivery_date+'</div>';
		   htm+='<div class="order-status"> <span class="label status '+ val.status_raw +'"> ';
		   //htm+='<ons-icon icon="'+icons+'" class="icon '+icons2+'"></ons-icon>';
		   htm+=val.status;
		   htm+='</span></div>';
		 htm+='</div>';





		 htm+='<div class="media-right media-middle">';
		   htm+='<div class="order-det">	<div class="order-amount"><b>'+val.bill_total+'</b></div>';
		   htm+='<div class="order-time">';
		   if (!empty(val.delivery_time)){
		     htm+='<i class="fa fa-clock-o fa-lg"></i>';
		     htm+=' <b>'+val.delivery_time+'</b> ';
		   }
		   if (!empty(val.delivery_asap)){
		     htm+=' <b>'+val.delivery_asap+'</b> ';
		   }
		   htm+='</div>';
		 htm+='</div></div>';

		htm+='</a>';
		htm+='</li>';
	});
	//createElement('new-orders',htm);

	createElement(div_id,htm);
	//setTimeout(function(){getNewPendingOrders();},4000);
	GetTodaysOrder();

}
var term;
function displayNewOrders(data,div_id)
{
	//new-orders
	//	loader.show();
		var icon_trans_type='';
		var icons='';
		var icons2='';
		var htm='';
		$.each( data, function( key, val ) {
			if (val.viewed==1){
			//dump(val);
			htm+='<li class="media '+val.order_id+'">';
			htm+='<a class="media-link" data-toggle="modal" data-target="#orderDetails" data-id="'+val.order_id+'" onclick="geetOrderId('+val.order_id+');">';

			icon_trans_type = getTransactionTypeIcons( val.trans_type_raw );

			var new_tag='';

			playSound('bing');
			$( ".pending-orders").addClass("new-pending-order");
				$("li ." + val.order_id).hide();

				//$("#pending-orders li a[data-id=" + val.order_id + "]");
				if(term == val.order_id)
				{
					alert("Ok-Matched");
				}
				new_tag='<div class="new-icon"><span class="new-ordr">New</span></div>';


			htm+='<div class="media-left media-middle">';
			   htm+= new_tag;
				htm+='<div class="truck-icon"><img src="assets/images/'+icon_trans_type+'.png" alt=""></div>';
			htm+='</div>';

			/*icons='fa-exclamation-triangle';
			icons2='';*/
			var icon=getOrderIcons(val.status_raw);
			var icons=icon.icons;
			var icons2=icon.classname;

			htm+='<div class="media-body media-middle">';
			   htm+='<div class="order-title">'+val.customer_name+'</div>';
			   htm+='<div class="order-number">'+ getTrans("Order No",'order_no') +'. <b>#'+val.order_id+'</b></div>';
			   htm+='<div class="order-date">'+val.delivery_date+'</div>';
			   htm+='<div class="order-status"> <span class="label status '+ val.status_raw +'"> ';
			   //htm+='<ons-icon icon="'+icons+'" class="icon '+icons2+'"></ons-icon>';
			   htm+=val.status;
			   htm+='</span></div>';
			 htm+='</div>';

			 htm+='<div class="media-right media-middle">';
			   htm+='<div class="order-det">	<div class="order-amount"><b>'+val.total_w_tax_prety+'</b></div>';
			   htm+='<div class="order-time">';
			   if (!empty(val.delivery_time)){
			     htm+='<i class="fa fa-clock-o fa-lg"></i>';
			     htm+=' <b>'+val.delivery_time+'</b> ';
			   }
			   if (!empty(val.delivery_asap)){
			     htm+=' <b>'+val.delivery_asap+'</b> ';
			   }
			   htm+='</div>';
			 htm+='</div></div>';

			htm+='</a>';
			htm+='</li>';
		}
		});

		//console.log(htm);


		//$(htm).insertAfter( "#pending-orders" );
		createElement(div_id,htm);
		setTimeout(function(){getNewPendingOrders();},10000);
}

function getOrderIcons(status_raw)
{
	icons='fa-exclamation-triangle';
	icons2='';
	switch (status_raw)
	{
		case "decline" :
		case "Declined" :
		case "declined":
	    icons='ion-close-circled';
	    icons2='icon-red';
		break;

		case "accepted":
		icons='ion-checkmark-round';
		icons2='icon-green';
		break;

		case "delivered":
		icons='ion-ios-checkmark';
		icons2='icon-green';
		break;

		case "pending":
		icons='fa-exclamation-triangle';
		icons2='icon-orange';
		break;

		default:
		icons='';
		icons2='';
		break;

	}
	return {
		'icons':icons,
		'classname':icons2
	};
}

function getTransactionTypeIcons(trans_type_raw)
{
	var icon_trans_type='';
	if ( trans_type_raw=="delivery"){
		icon_trans_type='delivery';
	} else {
		icon_trans_type='pickup';
	}
	return icon_trans_type;
}

function notyswal(msg,alert_type)
{

	if (!isDebug()){
		toastMsg( msg );
		return ;
	}

	// type = warning or success
	var n = noty({
		 text: msg,
		 type        : alert_type ,
		 theme       : 'relax',
		 layout      : 'bottomCenter',
		 timeout:3000,
		 killer: true,
		 animation: {
	        open: 'animated fadeInUp', // Animate.css class names
	        close: 'animated fadeOut', // Animate.css class names
	    }
	});
}

var view_order_page_bol;

function viewOrder(order_id)
{


	dump(order_id);

      	//$("#order-details-page-title").html( getTrans("Getting order details..",'getting_order_details') );
      	 var info=getMerchantInfoStorage();
				// console.log(info);
		 var params="token="+getStorage("merchant_token");
	 	 params+="&user_type="+info.user_type;
	 	 params+="&mtid="+info.merchant_id;
	 	 params+="&order_id="+order_id;
	 	 params+="&backend=true";
	 	 $("#orderID").val(order_id);
		 callAjax("OrderdDetails",params);


   //kNavigator.pushPage("displayOrder.html", options);
  //clearTimeout(altpopup);
}

function acceptOrder()
{
	var order_id=$(".order_id").val();
	var trans_type=$(".trans_type").val();
	$("#take_away_details").fadeOut(500);
	$("#take_away_accept_form").fadeIn(500);
	dump("order_id->"+order_id);
	dump("trans_type->"+trans_type);


      	   $(".order_id").val(order_id);
      	   if ( trans_type=="delivery"){
      	   	   $(".delivery-notes").html( getTrans("We'll send a confirmation including delivery time to your customer",'send_confirm_msg') );
      	   	   $(".delivery_time").attr("placeholder", getTrans("Delivery Time",'delivery_time') );
      	   } else {
      	   	   $(".delivery-notes").html( getTrans("We'll send a confirmation including pickup time to your customer",'send_cinfirm_pickup'));
      	   	   $(".delivery_time").attr("placeholder",getTrans("Pickup Time",'pickup_time') );
      	   }

      	   if(!empty(getStorage("delivery_time") && getStorage("delivery_time")!="false" )){
      	      $(".delivery_time").val( getStorage("delivery_time") );
      	   }


   /* var params="order_id="+order_id;
   callAjax("trigger_json",params);	 */

   //kNavigator.pushPage("acceptOrderForm.html", options);
}

function displayOrderDetails(data)
{	 	 
	setStorage("printdetails",JSON.stringify(data));
	modalloader.css("display","table");
	var header='';
	var icons='';
	var html='';
	var icon = getTransactionTypeIcons( data.trans_type_raw );
	var header='<h4 class="search-title text-center"><img src="assets/images/'+icon+'.png" alt="">';
	header+=data.transaction_date+"</h4>";
	$("#order-details-page-title").append(header);
	//createElement("order-details-page-title",header);

	/*client and orderinfo*/
	var icons=getOrderIcons(data.status_raw);

	if(data.status_raw=="assigned")
	{
		$("#reassigned").val("true");
	}
	$(".order_id").val( data.order_id ) ;
	$(".trans_type").val( data.trans_type_raw ) ;

	if (data.trans_type_raw=="delivery"){
		setStorage("delivery_time",data.delivery_time);
	} else {
		setStorage("delivery_time",'');
	}

	var html='';
	var html='<ul class="view-table">';
        html+='<li class="view-header">';
        html+='<div class="row"><div class="col-sm-7"><span class="label  status '+data.status_raw+' ">'+data.status+'</span></div>';
        html+='<div class="col-sm-5 text-right font-bold">'+getTrans("Order No",'order_no')+' : '+data.order_id+'</div>';
        html+='</div>';
     html+='</li>';

     html+='<li>';
     html+='<div class="row"><div class="col-sm-7"><i class="fa fa-user fa-lg m-r-5"></i> '+data.client_info.full_name+'</div>';
		 if ( !empty(data.client_info.contact_phone)){
		 html+='<div class="col-sm-5 text-right"><a href="tel:'+data.client_info.contact_phone+'">'+ data.client_info.contact_phone+'</a></div></div>';
	 	}
     html+='</li>';

     // if ( !empty(data.client_info.contact_phone)){
     // html+='<li>';
     // html+='<div class="row">';
     // html+='<div class="col-sm-7">';
     // html+='<i class="fa fa-phone fa-lg m-r-5" aria-hidden="true"></i><a href="tel:'+data.client_info.contact_phone+'">'+ data.client_info.contact_phone+"</a>";
     // html+='</div><div class="col-sm-5 text-right"></div>';
     // html+='</div>';
     // html+='</li>';
     // }

     //if ( !empty(data.client_info.address)){
     dump(data.trans_type_raw);
     if (data.trans_type_raw=="delivery"){
	     var address = data.client_info.address;
	     var lat_lng = "'"+data.client_info.delivery_lat+"'," + "'"+data.client_info.delivery_lng+"'," + "'"+data.client_info.address+"'";
	     html+='<li>';
	     html+='<div class="row">';
	        html+='<div class="col-sm-7">';
	        html+='<i class="fa fa-map-marker fa-lg m-r-5" aria-hidden="true"></i>'+data.client_info.address+'</div>';
	        html+='<div class="col-sm-5 text-right">';
			//  html+='<ons-button modifier="quiet" onclick="viewLocationNew('+lat_lng+')" class="view-location">';
				var urls="'map.html?address="+address+"','_blank'"
				html+='<button class="view-location btn btn-custom" type="button" onclick="window.open('+urls+');">';
	          html+= getTrans("View Location",'view_location') + '</button>';
	        html+='</div>';
	       html+='</div>';
	     html+='</li>';
     }

     html+=TPLorderRow( getTrans("Order Type",'trn_type') ,  data.trans_type);
	 if(data.status_raw=="assigned" || data.status_raw=="delivered")
	 {
	 html+=TPLorderRow( getTrans("Driver Name",'drvr_name') ,  data.driver_name);
	 }
     html+=TPLorderRow( getTrans("Payment Type",'payment_type') ,  data.payment_type);

     if( data.payment_type=="PYR" || data.payment_type=="pyr"){
     	html+=TPLorderRow( getTrans("Card#",'card_number') ,  data.payment_provider_name);
     }
     if( data.payment_type=="OCR" || data.payment_type=="ocr"){
     	html+=TPLorderRow( getTrans("Card#",'card_number') , data.credit_card_number );
     }

     if ( data.trans_type_raw=="delivery"){
        html+=TPLorderRow( getTrans("Delivery Date",'delivery_date') ,  data.delivery_date);
     } else {
     	html+=TPLorderRow( getTrans("Pickup Date",'pickup_date') ,  data.delivery_date);
     }

     if (!empty(data.delivery_time)){
     	 if ( data.trans_type_raw=="delivery"){
            html+=TPLorderRow( getTrans("Delivery Time",'delivery_time') ,  data.delivery_time);
     	 } else {
     	 	html+=TPLorderRow( getTrans("Pickup Time",'pickup_time') ,  data.delivery_time);
     	 }
     }
     if (!empty(data.delivery_asap)){
         html+=TPLorderRow( getTrans("Delivery Asap",'delivery_asap') ,  data.delivery_asap);
     }

     if ( data.trans_type_raw=="delivery"){
        html+=TPLorderRow( getTrans("Delivery Instruction",'delivery_instructions') ,  data.delivery_instruction);
      //  html+=TPLorderRow( getTrans("Location Name",'location_name') ,  data.client_info.location_name);
     }

     if (!empty(data.total.order_change)){
         html+=TPLorderRow( getTrans("Change",'change') ,  data.total.order_change );
     }

		 $("#order-details").append(html);



     //createElement("order-details",html);


     /*display the order items*/
     var html='';
     /*html+='<ons-list-header class="header">';
        html+='<ons-row>';
        html+='<ons-col>'+ getTrans("Total",'total') +'</ons-col>';
        html+='<ons-col class="text-right">'+data.total.total+'</ons-col>';
        html+='</ons-row>';
     html+='</ons-list-header>';*/

     html+='<ul class="view-table"><li class="view-header"><div class="row"></div>';
        html+='<div class="row">';
        html+='<div class="col-sm-12">'+ getTrans("Order Details",'order_details') +'</div>';
        html+='</div>';
     html+='</li>';

     if (!empty(data.item)){
     	$.each( data.item , function( key, val ) {     		 
			if(val.item_name!= null)
			{
     		  //dump(val);
     		  var price=val.normal_price;
     		  if (val.discounted_price>0){
     		  	  price=val.discounted_price
     		  }

     		  //var final_price=parseInt(val.qty)*parseFloat(price)
     		  var final_price = val.total_price;
     		  /*if (isNaN(final_price)){
     		  	 final_price=0;
     		  }*/

     		  description = val.qty+"x "+ price+ " " + val.item_name ;
     		  if (!empty(val.size_words)){
     		  	 description+=" ("+val.size_words+")";
     		  }

     		  if (!empty(val.cooking_ref)){
     		  	 description+='<br/>'+val.cooking_ref
     		  }

     		  if (!empty(val.order_notes)){
     		  	 description+='<br/>'+val.order_notes
     		  }

     		  //final_price=displayPrice(data.currency_position, data.total.curr , final_price);
     		  html+=TPLorderRow( description ,  final_price , 'fixed-col bold' );

     		  /*ingredients*/
     		  if (!empty(val.ingredients)){
     		  	  if ( val.ingredients.length>0){
	     		  	  html+='<li>'+ getTrans("Ingredients",'ingredients') +'</li>';
	     		  	  $.each( val.ingredients , function( key1, ingredients ) {
	     		  	  	  html+=TPLorderRow( ingredients ,  '' );
	     		  	  });
     		  	  }
     		  }

     		  /*sub item*/
     		  var addon='';
     		  if (!empty(val.sub_item_new)){
 		  	  	  $.each( val.sub_item_new , function( key2, sub_item ) {
 		  	  	  	  html+='<li>'+key2+'</li>';
 		  	  	  	  if ( sub_item.length>0){
 		  	  	  	  	  $.each( sub_item , function( key3, sub_items ) {
									   if(sub_items.total != 0 ) {
										t_desc='&emsp;&emsp;&emsp;&emsp;'+sub_items.addon_qty+"x "+sub_items.addon_price+" "+sub_items.addon_name;
										html+=TPLorderRow( t_desc ,  sub_items.total , 'fixed-col' );
									   }
									   else {
										t_desc= '&emsp;&emsp;&emsp;&emsp;'+sub_items.addon_name;
										html+=TPLorderRow( t_desc , 'Free' , 'fixed-col' );
									   }


 		  	  	  	  	  });
 		  	  	  	  }
 		  	  	  });
     		  }
		}
     	});
     }

     

      if (!empty(data.free_details))
      {
	     	$.each( data.free_details , function( key, val ) 
	     	{    
				    var size_words = '';   
				    var item_total = (parseInt(val.qty)*val.discounted_price);
				    var free_type = ' - ( BOGO )';
				    if($.trim(val.size_words).length>0)
				    {
				    	size_words = '( '+val.size_words+' )';
				    } 
				    if(val.free_type=='BOGP')
				    {
				    	free_type = ' - ( BOGP )';
				    }

					html+= '<li><div class="row"><div class="col-sm-7 fixed-col bold">'+val.qty+'x '+val.discounted_price+' '+val.item_name+size_words+'</div><div class="col-sm-5 text-right">'+free_type+' £ '+item_total.toFixed(2)+'</div></div></li>';

				 
			});
      }
    

        html+='<li class="view-footer">';
        html+='<div class="row">';
        html+='<div class="col-sm-7 font-bold">'+ getTrans("SubTotal",'Subtotal') +'</div>';
        html+='<div class="col-sm-5 text-right font-bold">'+data.total.total+'</div>';
        html+='</div>';
        html+='</li>';

        var all_items_total = parseFloat(data.total.total.replace('£',''));
       
     if (!empty(data.discount_details))
     {
     	//alert(data.discount_details[0].discount_percentage);
     	//alert(data.discount_details[0].discount_price);
	    html+=TPLorderRow( getTrans("Discount",'discount') +" - "+ data.discount_details[0].discount_percentage , "("+data.discount_details[0].discount_price.toFixed(2) +")"); 	 	    
	    all_items_total -= parseFloat(data.discount_details[0].discount_price.toFixed(2));
	 }   
     
//	     alert(data.discount_details.discount_percentage);   

    /* if(!empty(data.discount_price))
     {
     	alert(data.discount_details.discount_price);
     	alert(data.discount_details.discount_percentage);
     	html+=TPLorderRow( getTrans("Discount",'discount') +" "+ data.discount_details.discount_percentage , "("+data.discount_details.discount_price +")");
     }   */

     if ( !empty(data.total)){

     	if (!empty(data.total.discounted_amount)){
     		html+=TPLorderRow( getTrans("Discount",'discount') +" "+ data.total.discount_percentage , "("+data.total.discounted_amount1 +")");

     		if (!empty(data.total.points_discount)){
     			if (data.total.points_discount>0){
     				html+=TPLorderRow( getTrans("Points Discount",'point_discount'),"("+data.total.points_discount1 +")");
     			}
     		}

     //		html+=TPLorderRow( getTrans("Sub Total",'sub_total') ,  data.total.subtotal );

     	} else {

     		if (!empty(data.total.points_discount)){
     			if (data.total.points_discount>0){
     				html+=TPLorderRow( getTrans("Points Discount",'point_discount'),"("+data.total.points_discount1 +")");
     			}
     		}

     	//	html+=TPLorderRow( getTrans("Sub Total",'sub_total') ,  data.total.subtotal );
     	}

        if (!empty(data.total.delivery_charges))
        {
			 if(data.total.delivery_charges == '£ 0.00')
			 	html+=TPLorderRow( getTrans("Delivery Fee",'delivery_fee') ,  'Free' );
			 else
			 	html+=TPLorderRow( getTrans("Delivery Fee",'delivery_fee') ,  data.total.delivery_charges );			 	 
			 	all_items_total += parseFloat(data.total.delivery_charges.replace('£',''));
         }

         
        if (!empty(data.total.voucher_amount))
        {
         	if (data.total.voucher_amount>0)
         	{
         		if ( data.total.voucher_type=="percentage")
         		{
	         	   all_items_total -= parseFloat(data.total.voucher_amount1.replace('£',''));         		 	         	    
         		   html+=TPLorderRow( getTrans("Less Voucher",'less_voucher') + " " + data.total.voucher_percentage , "("+data.total.voucher_amount1 +")");
         		} 
         		else 
         		{
         			all_items_total -= parseFloat(data.total.voucher_amount1.replace('£',''));                			 
         		   html+=TPLorderRow( getTrans("Less Voucher",'less_voucher') , "("+data.total.voucher_amount1 +")");
         		}
        // 		html+=TPLorderRow( getTrans("Sub Total (after less voucher)",'sub_total_after_voucher') ,  data.total.subtotal2 ,'fixed-col');
         	}
         }


    /*    if (!empty(data.total.voucher_amount)){
         	if (data.total.voucher_amount>0){         		          		
         		if(data.total.voucher_percentage!=null)
         		{
         			var voucher_total = ((all_items_total*(data.total.voucher_percentage.replace('%','')))/100).toFixed(2);
	         		all_items_total -= parseFloat(voucher_total);         		 
	         		if ( data.total.voucher_type=="percentage")
	         		{
	         		   html+=TPLorderRow( getTrans("Less Voucher",'less_voucher') + " " + data.total.voucher_percentage , "("+ voucher_total +")");
	         		} else {
	         		   html+=TPLorderRow( getTrans("Less Voucher",'less_voucher') , "("+data.total.voucher_amount1 +")");
	         		}
         		}
        // 		html+=TPLorderRow( getTrans("Sub Total (after less voucher)",'sub_total_after_voucher') ,  data.total.subtotal2 ,'fixed-col');
         	}
        }  */


         if (!empty(data.total.merchant_packaging_charge)){
             html+=TPLorderRow( getTrans("Packaging",'packaging') ,  data.total.merchant_packaging_charge );  
             all_items_total += parseFloat(data.total.merchant_packaging_charge.replace('£',''));                			             
             // all_items_total += parseFloat(data.total.merchant_packaging_charge) ;
         }

        /* if (!empty(data.total.taxable_total)){
             html+=TPLorderRow( getTrans("Tax",'tax') +" " +  data.total.tax_amt ,  data.total.taxable_total );
         }*/

         if (!empty(data.total.cart_tip_value)){
             html+=TPLorderRow( getTrans("Tips",'tips')  ,  data.total.cart_tip_value );              
             all_items_total += parseFloat(data.total.cart_tip_value.replace('£',''));    
            // all_items_total += parseFloat(data.total.cart_tip_value);
         }
     }

     html+='<li class="view-footer">';
        html+='<div class="row">';
        html+='<div class="col-sm-7 font-bold">'+ getTrans("Total",'total') +'</div>';
        html+='<div class="col-sm-5 text-right font-bold"> £ '+all_items_total.toFixed(2)+'</div>';
        html+='</div>';
     html+='</li>';


     // button d2
	 //console.log("Status"+data.status_raw);
	 //console.log("Deriver "+data.driver_app);

     if ( data.status_raw=="pending"){
     	$(".actions-1").show(); //Accept & Decline
     	$(".actions-2").hide(); //Change, Print & Assign
     	$(".actions-3").hide(); //Change & Assign
     	$(".actions-4").hide(); //Change & Track(disabled)
     	$(".actions-5").hide(); //Change , Print & Reassign
     }
	else if ( data.status_raw=="assigned"){
     	$(".actions-1").hide();
     	$(".actions-2").hide();
     	$(".actions-3").hide();
     	$(".actions-4").hide();
     	$(".actions-5").show(); //ReAssign Driver
     }
	 else if ( data.status_raw=="delivered" || data.status_raw=="decline" || data.status_raw=="Declined" || data.status_raw=="declined" || data.status_raw=="cancelled"){
     	$(".actions-1").hide();
     	$(".actions-2").hide();
     	$(".actions-3").hide();
     	$(".actions-4").show();
     	$(".actions-5").hide();
	 }
	 else {
		if ( data.trans_type_raw=="pickup"){
			$(".actions-1").hide();
			$(".actions-2").hide();
			$(".actions-3").hide();
			$(".actions-4").show();
			$(".actions-5").hide();
		 }
		 else if ( data.driver_app==1){

     	   $(".task_id").val( data.task_id );

     	   setStorage("icon_location", data.icon_location);
     	   setStorage("icon_driver", data.icon_driver);
     	   setStorage("driver_profilepic", data.driver_profilepic);
     	   setStorage("time_left", data.time_left);

     	   switch ( data.task_status)
     	   {
     	   	  case "unassigned":
			  case "assigned":
			  case "declined":
			  case "Declined":
			  case "decline":
				  if (data.driver_id>0){
		     	   	  $(".assign_driver_label").html( getTrans("Re-assigned Driver",'re_assigned_driver') );
		     	   	  $("#assign_driver_label").val( getTrans("Re-assigned Driver",'re_assigned_driver') );
		     	   } else {
		     	   	  $(".assign_driver_label").html( getTrans("Assigned Driver",'assigned_driver') );
		     	   	  $("#assign_driver_label").val( getTrans("Assigned Driver",'assigned_driver') );
		     	   }

		     	   $(".actions-3").show();
     	           $(".actions-2").hide();
     	           $(".actions-1").hide();
     	           $(".actions-4").hide();
     	           $(".actions-5").hide();
			  break;

			  case "acknowledged":
			  case "started":
			  case "inprogress":

			  //   $(".assign_driver_label").html( getTrans("Track Order",'track_order') );
		     //	 $("#assign_driver_label").val( getTrans("Track Order",'track_order') );

		     	 $(".actions-4").show();
		     	 $(".actions-3").hide();
     	         $(".actions-2").hide();
     	         $(".actions-1").hide();
     	         $(".actions-5").hide();

     	         if ( !empty(data.task_info) ){
     	         	$(".task_lat").val( data.task_info.task_lat);
     	         	$(".task_lng").val( data.task_info.task_lng);
     	         	$(".task_address").val( data.task_info.delivery_address);
     	         }
     	         if ( !empty(data.driver_info) ){
     	         	$(".driver_lat").val( data.driver_info.location_lat);
     	         	$(".driver_lng").val( data.driver_info.location_lng);

     	         	var driver_name='';
     	         	if (!empty(data.driver_info.first_name)){
     	         		driver_name=data.driver_info.first_name + " ";

     	         	}
     	         	if (!empty(data.driver_info.last_name)){
     	         		driver_name+=data.driver_info.last_name;

     	         	}
     	         	$(".driver_name").val( driver_name );
     	         	$(".driver_phone").val( data.driver_info.phone);
     	         	$(".driver_location").val( data.driver_info.formatted_address);
     	         }
			  break;

			  default:
			    $(".actions-1").hide();
     	        $(".actions-2").show();
     	        $(".actions-3").hide();
     	        $(".actions-4").hide();
     	        $(".actions-5").hide();
			  break;
     	   }

     	} else {
     	   $(".actions-2").show();
     	   $(".actions-1").hide();
     	   $(".actions-3").hide();
     	   $(".actions-4").hide();
     	   $(".actions-5").hide();
     	}
     }

		 $("#order-details-item").append(html);
     //createElement("order-details-item",html);
		 modalloader.css("display","none");
}

function TPLorderRow(label , value, label_class)
{
	 var html='';
	 html+='<li>';
       html+='<div class="row">';
        html+='<div class="col-sm-7 '+label_class+'">'+label+'</div>';
        html+='<div class="col-sm-5 text-right">'+value+'</div>';
       html+='</div>';
     html+='</li>';
     return html
}

function displayPrice(currency_position, currency ,price)
{
	if ( currency_position=="right"){
		return price+" "+currency;
	} else {
		return currency+" "+price;
	}
}

/*
function printerStatus()
{
	var btPrinter="";
	if(getStorage("bt_con_dev")) {
		btPrinter = getStorage("bt_con_dev");
	}
	else {
		btPrinter = "Offline";
	}
	$("#printer-name").val(btPrinter);
	return btPrinter;
}*/

function setPrinter(){
	var bt = new bluetooth(0);
	if(!bt.isEnabled()){bt.enable(); }
	var connectedPrinter ="None";
	if(getStorage("bt_con_dev")){
		//swal("Printer is online"+getStorage("bt_con_dev"));
		$("#printer-name").val(getStorage("bt_con_dev")); //this is not working right now. need to be fixed
		connectedPrinter = getStorage("bt_con_dev");
	}

	bt.startScan(); // scan the devices and show the popup after 5 seconds

	$('#popupdevice ul').empty().append("<li>Connected:  "+connectedPrinter+"</li>"+getStorage("device_list"));
	$('#popupdevice, #popupdevice ons-dialog').show();


}


function orderConfirm()
{
var time=$(".delivery_time").val();
if(time == "")
{
	swal("Please enter the collection time for this Order");
}
else {
				modalloader.show();
	      var params = $( "#frm-acceptorder").serialize();
	      var info=getMerchantInfoStorage();
	      params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax("AcceptOrdes",params);
	      return false;
}
}

function declineOrder()
{
	var order_id=$(".order_id").val();
	var trans_type=$(".trans_type").val();
	$("#take_away_details").fadeOut(500);
	$("#take_away_decline_form").fadeIn(500);
	dump("order_id->"+order_id);
	dump("trans_type->"+trans_type);

	var options = {
      animation: 'none',
      onTransitionEnd: function() {
      	  $(".order_id").val( order_id );
      }
   };
   //kNavigator.pushPage("declineOrderForm.html", options);
}

function declineConfirm()
{
modalloader.css("display","table");
	var params = $( "#frm-decline").serialize();
    var info=getMerchantInfoStorage();
    params+="&token="+getStorage("merchant_token");
    params+="&user_type="+info.user_type;
    params+="&mtid="+info.merchant_id;

    callAjax("DeclineOrders",params);	   //setTimeout(function(){window.location.reload();},500);
  //  kNavigator.pushPage("home.html", options); //After declining take to home page

}

function changeOrderStatus()
{
	var order_id=$(".order_id").val();
	var trans_type=$(".trans_type").val();
	$("#take_away_details").fadeOut(500);
	$("#take_away_change_status").fadeIn(500);
	dump("order_id->"+order_id);
	dump("trans_type->"+trans_type);

	// var options = {
  //     animation: 'none',
  //     onTransitionEnd: function() {
      	  $(".order_id").val( order_id );
      	  var info=getMerchantInfoStorage();
		  var params="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
		  params+="&order_id="+order_id;
		 callAjax("StatusList",params);
   //    }
   // };
  // kNavigator.pushPage("changesStatus.html", options);

}

function statusList(data)
{
	var htm='';
	htm+='<ul class="view-table"><li class="view-header"><div class="row"><div class="col-sm-7"><span class="label  status">'+ getTrans('Select Status','select_status') +'</span></div><div class="col-sm-5 text-right font-bold"></div></div></li>';

	htm+='';
	var radio='1';
	var stat=data.status;
	$.each( data.status_list, function( key, val ) {
		ischecked='';
		if (key == stat){
			ischecked='checked="checked"';
		}
		htm+='<li><div class="row">';
		 htm+='<div class="col-sm-12"><div class="radio radio-primary">';
			htm+='<input type="radio" id="radio'+radio+'" name="status" class="status" value="'+key+'" '+ischecked+' >';
			htm+='<label for="radio'+radio+'">';
			htm+=' '+val;
		  htm+='</label></div></div>';
		htm+='</div></li>';
		radio++;
	});
	htm+='</ul>';

	$("#status-list").append(htm);
	//createElement('status-list',htm);
}

function changeStatus()
{
	var stats=$("input[name=status]").val();
	if(stats == "")
	{
		swal("Status should not be empty");
	}
	else{
		var params = $( "#frm-changestatus").serialize();
		var info=getMerchantInfoStorage();
		params+="&token="+getStorage("merchant_token");
		params+="&user_type="+info.user_type;
		params+="&mtid="+info.merchant_id;
		callAjax("ChangeOrderStatus",params);
	}
	// $.validate({
	//     form : '#frm-changestatus',
	//     borderColorOnError:"#FF0000",
	//     onError : function() {
	//     },
	//     onSuccess : function() {
	//       var params = $( "#frm-changestatus").serialize();
  //
	//       var info=getMerchantInfoStorage();
	//       params+="&token="+getStorage("merchant_token");
	// 	  params+="&user_type="+info.user_type;
	// 	  params+="&mtid="+info.merchant_id;
  //
	//       callAjax("ChangeOrderStatus",params);
	//     //  return false;
	//     }
	// });
	//kNavigator.resetToPage('home.html',params);
}

function showLanguageList()
{
	if (typeof languageOptions === "undefined" || languageOptions==null || languageOptions=="" ) {
		ons.createDialog('languageOptions.html').then(function(dialog) {
	        dialog.show();
	        translatePage();
	    });
	} else {
		languageOptions.show();
	}
}


function displayLanguageSelection(data)
{
	var selected = getStorage("mt_default_lang");
	dump("selected=>"+selected);
	var htm='';
	htm+='<ons-list>';
	htm+='<ons-list-header class="list-header trn" data-trn-key="language">'+ getTrans("Language",'language') +'</ons-list-header>';
	$.each( data, function( key, val ) {
		dump(val.lang_id);
		ischecked='';
		if ( val.lang_id==selected){
			ischecked='checked="checked"';
		}
		htm+='<ons-list-item modifier="tappable" onclick="setLanguage('+"'"+val.lang_id+"'"+');">';
		 htm+='<label class="radio-button checkbox--list-item">';
			htm+='<input type="radio" name="country_code" class="country_code" value="'+val.lang_id+'" '+ischecked+' >';
			htm+='<div class="radio-button__checkmark checkbox--list-item__checkmark"></div>';
			htm+=' '+val.language_code;
		  htm+='</label>';
		htm+='</ons-list-item>';
	});
	htm+='</ons-list>';
	createElement('language-options-list',htm);
	translatePage();
}

function setLanguage(lang_id)
{
	dump(lang_id);
	dump( getStorage("translation") );
	if (typeof getStorage("mt_translation") === "undefined" || getStorage("mt_translation")==null || getStorage("mt_translation")=="" ) {
	   languageOptions.hide();
       ons.notification.confirm({
		  message: 'Language file has not been loaded, would you like to reload?',
		  title: dialog_title_default ,
		  buttonLabels: ['Yes', 'No'],
		  animation: 'none',
		  primaryButtonIndex: 1,
		  cancelable: true,
		  callback: function(index) {
		     if ( index==0 || index=="0"){
		     	getLanguageSettings();
		     }
		  }
		});
		return;
	}

	if ( getStorage("mt_translation").length<=5 ){
		onsenswal("Translation file is not yet ready.");
		return;
	}

	if ( !empty(lang_id) ){
	   setStorage("mt_default_lang",lang_id);
	   if ( !empty(translator)){
	       translator.lang(lang_id);
	   } else {
	   	   translator = $('body').translate({lang: lang_id, t: dictionary});
	   }
	}
}

function saveSettings()
{
	var params = $( "#frm-settings").serialize();

	var info=getMerchantInfoStorage();
	params+="&token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	params+="&merchant_device_id="+getStorage("merchant_device_id");

	callAjax("saveSettings",params);
}

function viewLocation(address)
{
	dump(address);
	// var options = {
  //     animation: 'none',
  //     onTransitionEnd: function() {
      	  $("#location-address").html(address);
      	  var params="address="+address;
      	  callAjax("geoDecodeAddress",params);
   //    }
   // };
  // kNavigator.pushPage("map.html", options);
}

function initMap(data)
{
	dump(data);
	if ( !empty(data)){
		var map = new GoogleMap();
	    map.initialize('location-map', data.lat, data.lng , 18);
	} else {
		//$("#location-map").hide(); // Still show the map for the restaurant manager to search
		notyswal("location not available",'error' );
	}
}

function forgotPassword()
{
	$.validate({
	    form : '#frm-forgotpass',
	    borderColorOnError:"#FF0000",
	    onError : function() {
	    },
	    onSuccess : function() {
	      var params = $( "#frm-forgotpass").serialize();
	      callAjax("ForgotPassword",params);
	      return false;
	    }
	});
}

function changePassWord()
{
    $.validate({
	    form : '#frm-changepassword',
	    borderColorOnError:"#FF0000",
	    onError : function() {
	    },
	    onSuccess : function() {
	      var params = $( "#frm-changepassword").serialize();
	      callAjax("ChangePasswordWithCode",params);
	      return false;
	    }
	});
}

function viewHistory()
{
   var order_id=$("#order_id").val();
    dump(order_id);


	var options = {
      animation: 'none',
      onTransitionEnd: function() {
      	 $(".order-history-title").html('Getting history...');
      	 var info=getMerchantInfoStorage();
      	 var params='';
			 params+="&token="+getStorage("merchant_token");
			 params+="&user_type="+info.user_type;
			 params+="&mtid="+info.merchant_id;
			 params+="&order_id="+order_id;
	     callAjax("OrderHistory",params);
      }
   };
   kNavigator.pushPage("orderHistory.html", options);
}

function displayHistory(data)
{
	var htm='<ons-list-header class="header">';
	htm+='<ons-row>';
	  htm+='<ons-col class="fixed-col">'+ getTrans("Date/Time",'date_time')  +'</ons-col>';
	  htm+='<ons-col class="fixed-col">'+ getTrans("Status",'status') +'</ons-col>';
	  htm+='<ons-col class="fixed-col">'+ getTrans("Remarks",'remarks') +'</ons-col>';
	htm+='</ons-row>';
	htm+='</ons-list-header>';

	$.each( data, function( key, val ) {

		htm+='<ons-list-item>';
		   htm+='<ons-row>';
			htm+='<ons-col class="fixed-col">'+val.date_created+'</ons-col>';
			htm+='<ons-col class="fixed-col"><span class="status margin2 '+val.status_raw+' " >'+val.status+'</span></ons-col>';
			htm+='<ons-col class="fixed-col">'+val.remarks+'</ons-col>';
		  htm+='</ons-row>';
		htm+='</ons-list-item>';

	});

	createElement('order-history',htm);
}

function saveProfile()
{
	$.validate({
	    form : '#frm-profile',
	    borderColorOnError:"#FF0000",
	    onError : function() {
	    },
	    onSuccess : function() {
	      var params = $( "#frm-profile").serialize();
	      var info=getMerchantInfoStorage();
		  params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax("saveProfile",params);
	      return false;
	    }
	});
}

function getLanguageSettings()
{
	if ( !hasConnection() ){
		return;
	}
	//callAjax("getLanguageSettings",'');
	var action = 'getLanguageSettings';
	var params='';

	dump("Action=>"+action);
	dump(ajax_url+"/"+action+"?"+params);

	 var ajax_request2 = $.ajax({
	 url: ajax_url+"/"+action,
	 data: params,
	 type: 'post',
	 async: true,
	 dataType: 'jsonp',
	// timeout: 6000,
	 crossDomain: true,
	 beforeSend: function() {
		if(ajax_request2 != null) {
		   /*abort ajax*/
		   hideAllModal();
           ajax_request2.abort();
		} else {
			/*show modal*/
			switch(action)
			{
				case "none":
				   break;
				default:
				   kloader.show();
				   break;
			}
		}
	},
	complete: function(data) {
		ajax_request2=null;
		hideAllModal();
	},
	success: function (data) {
	     if (data.code==1){
	     	  dump('getLanguageSettings OK');
	     	  setStorage("mt_translation",JSON.stringify(data.details.translation));
		      var device_set_lang=getStorage("mt_default_lang");
		      dump("device_set_lang=>"+device_set_lang);

		      if (empty(device_set_lang)){
		       	   dump('proceed');
			       if(!empty(data.details.settings.default_lang)){
			          setStorage("mt_default_lang",data.details.settings.default_lang);
			       } else {
			       	  setStorage("mt_default_lang","");
			       }
		       }
		       translatePage();
	     }
    },
	error: function (request,error) {
		hideAllModal();
	}
   });
}

function translatePage()
{
	dump("TranslatePage Functions");
	if (typeof getStorage("mt_translation") === "undefined" || getStorage("mt_translation")==null || getStorage("mt_translation")=="" ) {
		return;
	} else {
		dictionary =  JSON.parse( getStorage("mt_translation") );
	}
	if (!empty(dictionary)){
		dump(dictionary);
		var default_lang=getStorage("mt_default_lang");
		dump(default_lang);
		if (default_lang!="undefined" && default_lang!=""){
			dump("INIT TRANSLATE");
			translator = $('body').translate({lang: default_lang, t: dictionary});
			translateValidationForm();
	        translateForms();
		}
	}
}

function getTrans(words,words_key)
{
	var temp_dictionary='';
	/*dump(words);
	dump(words_key);	*/
	if (getStorage("mt_translation")!="undefined"){
	   temp_dictionary =  JSON.parse( getStorage("mt_translation") );
	}
	if (!empty(temp_dictionary)){
		//dump(temp_dictionary);
		var default_lang=getStorage("mt_default_lang");
		//dump(default_lang);
		if (default_lang!="undefined" && default_lang!=""){
			//dump("OK");
			if ( array_key_exists(words_key,temp_dictionary) ){
				//dump('found=>' + words_key +"=>"+ temp_dictionary[words_key][default_lang]);
				if(!empty(temp_dictionary[words_key][default_lang])){
				   return temp_dictionary[words_key][default_lang];
				}
			}
		}
	}
	return words;
}

function array_key_exists(key, search) {
  if (!search || (search.constructor !== Array && search.constructor !== Object)) {
    return false;
  }
  return key in search;
}

function translateValidationForm()
{
	$.each( $(".has_validation") , function() {
		var validation_type = $(this).data("validation");

		switch (validation_type)
		{
			case "number":
			$(this).attr("data-validation-error-msg",getTrans("The input value was not a correct number",'validation_numeric') );
			break;

			case "required":
			$(this).attr("data-validation-error-msg",getTrans("this field is mandatory!",'validaton_mandatory') );
			break;

			case "email":
			$(this).attr("data-validation-error-msg",getTrans("You have not given a correct e-mail address!",'validation_email') );
			break;
		}

	});
}

function translateForms()
{
	var t='';
	$.each( $(".text-input") , function() {
		var placeholder = $(this).attr("placeholder");
		t = getTrans(placeholder, $(this).data("trn-key") );
	    $(this).attr("placeholder",t);
	});
}

function showNotification(title, message, order_id)
{
	if ( !isLogin() ){
		return;
	}
	if (typeof pushDialog === "undefined" || pushDialog==null || pushDialog=="" ) {
		ons.createDialog('pushNotification.html').then(function(dialog) {
			$(".push-title").html(title);
	        $(".push-message").html(message);
	        dialog.show();
	        $("#order_id").val( order_id );
	    });
	} else {
		$(".push-title").html(title);
	    $(".push-message").html(message);
	    $("#order_id").val( order_id );
		pushDialog.show();
	}
}

function showNotificationCampaign(title,message)
{
	if ( !isLogin() ){
		return;
	}
	if (typeof pushcampaignDialog === "undefined" || pushcampaignDialog==null || pushcampaignDialog=="" ) {
		ons.createDialog('pushNotificationCampaign.html').then(function(dialog) {
			$("#page-notificationcampaign .push-title").html(title);
	        $("#page-notificationcampaign .push-message").html(message);
	        dialog.show();
	    });
	} else {
		$("#page-notificationcampaign .push-title").html(title);
	    $("#page-notificationcampaign .push-message").html(message);
		pushcampaignDialog.show();
	}
}

function setHome2()
{
	pushDialog.hide();
    var options = {
  	   closeMenu:true,
       animation: 'slide'
    };
    menu.setMainPage('home.html',options);
}

function isLogin()
{
	if (!empty(getStorage("merchant_token"))){
		return true;
	}

	else{
		swal("Your session has expired or someone login with your account");
		window.location.href='index.html';
	}
}

function showNotificationPage()
{
   var options = {
      animation: 'none',
      onTransitionEnd: function() {

      	  clearBadge();

      	  var params='';
      	  var info=getMerchantInfoStorage();
		  params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax("getNotification",params);
	      return false;
      }
   };
   kNavigator.pushPage("showNotification.html", options);
}

function displayNotification(data)
{
	var htm='';
	$.each( data, function( key, val ) {

		  /*if ( val.push_type=="order"){
		  	  var action='onclick="viewOrder('+val.order_id+')" ';
		  } else {

		  	  var str = nl2br(val.push_message);
		  	  var campaign="'"+val.push_title+"',"+"'"+ str +"'" ;
		  	  var action='onclick="showNotificationCampaign('+campaign+')" ';
		  }*/

		  htm+='<ons-list-item modifier="tappable" class="notification-action" data-text="'+val.push_message+'" data-type="'+val.push_type+'" data-orderid="'+val.order_id+'" data-bookingid="'+val.booking_id+'" data-title="'+val.push_title+'" >';
            htm+='<ons-row>';
              htm+='<ons-col width="90px" class="fixed-col" >';
              htm+=val.date_created
              htm+='</ons-col>';
              htm+='<ons-col class="fixed-col" >';
              htm+=val.push_title
              htm+='</ons-col>';
            htm+='</ons-row>';
         htm+='</ons-list-item>';
	});
	createElement('notification',htm);
}

function pullNotification(done)
{
	dump('pull');

	if ( !hasConnection() ){
		notyswal(  getTrans("CONNECTION LOST",'connection_lost'),'error' );
		done();
		return;
	}

	var action= 'getNotification';
	var div_id= 'notification';

	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	params+="&lang_id="+getStorage("mt_default_lang");

	if(!empty(krms_config.APIHasKey)){
		params+="&api_key="+krms_config.APIHasKey;
	}

	dump(ajax_url+"/"+action+"/?"+params);

    ajax_request = $.ajax({
	 url: ajax_url+"/"+action,
	 data: params,
	 type: 'post',
	 async: true,
	 dataType: 'jsonp',
	// timeout: 5000,
	 crossDomain: true,
	 beforeSend: function() {
		if(ajax_request != null) {
		   /*abort ajax*/
		   hideAllModal();
           ajax_request.abort();
		}
	},
	complete: function(data) {
		ajax_request=null;
	},
	success: function (data) {
		dump(data);
		done();
		if (data.code==1){
			displayNotification(data.details);
		} else if(data.code==3){
			notyswal(data.msg,"error");
		} else {
			// failed response
			notyswal(data.msg,"error");
		}

	},
	error: function (request,error) {

	}
   });
}

function showSearchPopUp()
{
	if (typeof SearchPopUpDialog === "undefined" || SearchPopUpDialog==null || SearchPopUpDialog=="" ) {
		ons.createDialog('SearchPopUp.html').then(function(dialog) {
	        dialog.show();
	    });
	} else {
		$(".order_id_customername").val('');
		SearchPopUpDialog.show();
	}
}

function searchOrder()
{
	$.validate({
	    form : '#frm-search',
	    borderColorOnError:"#FF0000",
	    onError : function() {
	    },
	    onSuccess : function() {
	      SearchPopUpDialog.hide();
	      var options = {
           animation: 'none',
		      onTransitionEnd: function() {
		      	  var params = $( "#frm-search").serialize();
			      var info=getMerchantInfoStorage();
				  params+="&token="+getStorage("merchant_token");
				  params+="&user_type="+info.user_type;
				  params+="&mtid="+info.merchant_id;
			      callAjax("searchOrder",params);
		      }
		   };
		   kNavigator.pushPage("searchResults.html", options);

	      return false;
	    }
	});
}

function deviceBackButton()
{
	ons.notification.confirm({
	  message: getTrans('Do you want to logout?','do_you_want_to_logout') ,
	  title: dialog_title_default ,
	  buttonLabels: [ getTrans('Yes','yes') ,  getTrans('No','no') ],
	  animation: 'default', // or 'none'
	  primaryButtonIndex: 1,
	  cancelable: true,
	  callback: function(index) {
	  	   //swal(index);
	  	   // -1: Cancel
           // 0-: Button index from the left
	  	   if (index==0){
	  	   	   removeStorage("merchant_token");
               removeStorage("merchant_info");
               kNavigator.popPage();
	  	   }
	  }
	});
}

function loadTable(done)
{
	dump('pull');

	if ( !hasConnection() ){
		notyswal(  getTrans("CONNECTION LOST",'connection_lost'),'error' );
		done();
		return;
	}

	var action= $(".tab-action").val();
	var div_id= $(".display-div").val();

	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	params+="&lang_id="+getStorage("mt_default_lang");

    if(!empty(krms_config.APIHasKey)){
		params+="&api_key="+krms_config.APIHasKey;
	}

	dump(ajax_url+"/"+action+"/?"+params);

    ajax_request = $.ajax({
	 url: ajax_url+"/"+action,
	 data: params,
	 type: 'post',
	 async: true,
	 dataType: 'jsonp',
	// timeout: 5000,
	 crossDomain: true,
	 beforeSend: function() {
		if(ajax_request != null) {
		   /*abort ajax*/
		   hideAllModal();
           ajax_request.abort();
		}
	},
	complete: function(data) {
		ajax_request=null;
	},
	success: function (data) {
		dump(data);
		done();
		if (data.code==1){
			displayBooking(data.details,div_id);
		} else if(data.code==3){

		} else {
			// failed response
			notyswal(data.msg,"error");
		}
	},
	error: function (request,error) {

	}
   });
}

// function displayBooking(data,div_id)
// {
// 	var html='',row_cnt=0;
// 	$.each( data, function( key, val ) {
//
// 		var icon=getBookingIcons(val.status_raw);
// 		// if(val.viewed == 1 && row_cnt==0){
// 		// 	showNotificationBooking( "New Table Booking","<b>"+val.booking_name+ "</b><br /><br /> request for table booking", val.booking_id );
// 		// 	row_cnt++;
// 		// }
// 		html+='<li class="media">';
// 		html+='<a class="media-link" href="booking-view.html">';
//
//              html+='<div class="media-left media-middle">';
//              html+='<b>Booking #</b>' + val.booking_id +'<br/>';
//              html+=val.date_of_booking
//              html+='<p class="status margin2 '+val.status_raw+' ">';
// 	             //html+='<ons-icon class="icon '+icon.classname+'" icon="'+icon.icons+'"></ons-icon>';
// 	             html+=' '+val.status;
// 	             if ( val.viewed==1){
// 	                html+= '&nbsp;<span class="new-tags">'+ getTrans('new','new') +'</span>'
// 	             }
// 	             html+='</p>';
//              html+='</ons-col>';
//
//              html+='<ons-col width="38%" class="fixed-col " >';
//              html+=val.booking_name;
//              html+='</ons-col >';
//
//              html+='<ons-col class="fixed-col text-right" > ';
//              html+= '<b>'+val.number_guest+'</b> ';
//
//              html+='<ons-icon icon="'+ getBookingGuestIcon(val.number_guest) +'"></ons-icon>';
//              html+='</ons-col> ';
//
//           html+='</a>';
//        html+='</li>';
// 	});
//
// 	createElement(div_id,html);
// }


function displayBooking(data,div_id)
{ //new-orders
	$("#newbooking-list").html("");
	loader.show();
	var htm='',row_cnt=0;
	$.each( data, function( key, val ) {
		//dump(val);
		htm+='<li class="media">';
		htm+='<a class="media-link" href="#" data-toggle="modal" data-target="#BookingDetails" data-id="'+val.booking_id+'" onclick="getBookingId('+val.booking_id+');">';

		icon_trans_type = getTransactionTypeIcons( val.trans_type_raw );

		var new_tag='';
		if (val.viewed==1){

			new_tag='<div class="new-icon"><span class="new-ordr">New</span></div>';
		}

		htm+='<div class="media-left media-middle">';
		   htm+= new_tag;
			htm+='<div class="truck-icon"><img src="assets/images/'+icon_trans_type+'.png" alt=""></div>';
		htm+='</div>';

		/*icons='fa-exclamation-triangle';
		icons2='';*/
		var icon=getOrderIcons(val.status_raw);
		var icons=icon.icons;
		var icons2=icon.classname;

		htm+='<div class="media-body media-middle">';
		   htm+='<div class="order-title">'+val.booking_name+'</div>';
		   htm+='<div class="order-number">'+ getTrans("Booking No",'booking_no') +'. <b>#'+val.booking_id+'</b></div>';
		   htm+='<div class="order-date"> '+val.date_of_booking+'</div>';
		   htm+='<div class="order-status"> <span class="label status '+ val.status_raw +'"> ';
		   //htm+='<ons-icon icon="'+icons+'" class="icon '+icons2+'"></ons-icon>';
		   htm+=val.status;
		   htm+='</span></div>';
		 htm+='</div>';


		 htm+='<div class="media-right media-middle">';
		   htm+='<div class="order-det">';
		   htm+='<div class="booking-count">';
			 htm+='<i class="fa fa-user" aria-hidden="true"></i>';
			 htm+=' <b>'+val.number_guest+'</b> ';
			 htm+='</div>';
			 htm+='</div>';
		   htm+='</div>';
		 htm+='</div></div>';

		htm+='</a>';
		htm+='</li>';
	});
	//createElement('new-orders',htm);

	createElement(div_id,htm);
	//setTimeout(function(){getNewPendingOrders();},4000);
	//getGetAllOrders();
	getAllBooking();
}

function displayAllBooking(data,div_id)
{ //new-orders
	var htm='',row_cnt=0;
	$.each( data, function( key, val ) {
		//dump(val);
		htm+='<li class="media">';
		htm+='<a class="media-link" href="#" data-toggle="modal" data-target="#BookingDetails" data-id="'+val.booking_id+'" onclick="getBookingId('+val.booking_id+');">';

		icon_trans_type = getTransactionTypeIcons( val.trans_type_raw );

		var new_tag='';
		if (val.viewed==1){

			new_tag='<div class="new-icon"><span class="new-ordr">New</span></div>';
		}

		htm+='<div class="media-left media-middle">';
		   htm+= new_tag;
			htm+='<div class="truck-icon"><img src="assets/images/'+icon_trans_type+'.png" alt=""></div>';
		htm+='</div>';

		/*icons='fa-exclamation-triangle';
		icons2='';*/
		var icon=getOrderIcons(val.status_raw);
		var icons=icon.icons;
		var icons2=icon.classname;

		htm+='<div class="media-body media-middle">';
		   htm+='<div class="order-title">'+val.booking_name+'</div>';
		   htm+='<div class="order-number">'+ getTrans("Booking No",'booking_no') +'. <b>#'+val.booking_id+'</b></div>';
		   htm+='<div class="order-date"> '+val.date_of_booking+'</div>';
		   htm+='<div class="order-status"> <span class="label status '+ val.status_raw +'"> ';
		   //htm+='<ons-icon icon="'+icons+'" class="icon '+icons2+'"></ons-icon>';
		   htm+=val.status;
		   htm+='</span></div>';
		 htm+='</div>';


		 htm+='<div class="media-right media-middle">';
		   htm+='<div class="order-det">';
		   htm+='<div class="booking-count">';
			 htm+='<i class="fa fa-user" aria-hidden="true"></i>';
			 htm+=' <b>'+val.number_guest+'</b> ';
			 htm+='</div>';
			 htm+='</div>';
		   htm+='</div>';
		 htm+='</div></div>';

		htm+='</a>';
		htm+='</li>';
	});
	//createElement('new-orders',htm);

	createElement(div_id,htm);
	//setTimeout(function(){getNewPendingOrders();},4000);
	//getGetAllOrders();
	//getAllBooking();
	loader.css("display", "none");
}


function getBookingIcons(status_raw)
{
    icons='fa-exclamation-triangle';
	icons2='';
	switch (status_raw)
	{
		case "denied":
	    icons='ion-close-circled';
	    icons2='icon-red';
		break;

		case "approved":
		icons='ion-checkmark-round';
		icons2='icon-green';
		break;

		case "pending":
		icons='fa-exclamation-triangle';
		icons2='icon-orange';
		break;

		default:
		icons='fa-exclamation-triangle';
		icons2='icon-orange';
		break;

	}
	return {
		'icons':icons,
		'classname':icons2
	};
}

function getBookingGuestIcon(number_guest)
{
	icon='ion-android-contact';
	if ( number_guest>1){
		icon='ion-android-contacts';
	}
	return icon;
}

var view_booking_page_bol;

function viewBooking(booking_id)
{

					dump(booking_id);
      	  var info=getMerchantInfoStorage();
		  var params="token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
		  params+='&booking_id='+booking_id
		  callAjax("GetBookingDetails",params);
}


function displayBookingDetails(data)
{
	setStorage("tabledetails",JSON.stringify(data));
	modalloaderbook.show();
	if ( data.status_raw=="pending"){
		$(".booking-action").show();
		$(".booking-print").hide();
	} else {
		$(".booking-action").hide();
		$(".booking-print").show();
	}

	dump(data);
	var html='';

	$("#booking_id").val( data.booking_id);
	$("#booking_status").val( data.status_raw);

	var icon=getBookingIcons(data.status_raw);

	 var html=' <ul class="view-table">';
	 		 html+='<li class="view-header">';

        html+='<div class="row">';
        //html+='<ons-icon class="icon '+icon.classname+'" icon="'+icon.icons+'"></ons-icon>';
        //html+='&nbsp;&nbsp;'+data.status
        html+='<div class="col-sm-12"><span class="label status '+data.status_raw+' ">'+data.status+'</span></div>';
        html+='</div>';
     html+='</li>';

      if ( !empty(data.booking_name)){
	     html+='<li>';
			 	html+='<div class="row"><div class="col-sm-12">';
	       html+='<i class="fa fa-user fa-lg m-r-5"></i>'+ data.booking_name;
				 html+='</div></div>';
			 html+='</li>';
      }

       if ( !empty(data.email)){
	     html+='<li>';
			 html+='<div class="row"><div class="col-sm-12">';
				html+='<i class="fa fa-envelope  fa-lg m-r-5"></i>'+ data.email;
				html+='</div></div>';
	     html+='</li>';
       }

     if ( !empty(data.mobile)){
	     html+='<li>';
			 html+='<div class="row"><div class="col-sm-12">';
	     //html+='<ons-icon icon="ion-ios-telephone"></ons-icon> '+data.mobile;
			 html+='<i class="fa fa-phone  fa-lg m-r-5"></i><a href="tel:'+data.mobile+'">'+ data.mobile+"</a>";
			 html+='</div></div>';
	     html+='</li>';
     }

     if ( !empty(data.booking_notes)){
	     html+='<li>';
			 html+='<div class="row"><div class="col-sm-12">';
			 html+='<i class="fa fa-comments  fa-lg m-r-5"></i>'+data.booking_notes;
			  html+='</div></div>';
	     html+='</li>';
     }

     if ( !empty(data.transaction_date)){
			 html+='<li>';
			html+='<div class="row"><div class="col-sm-12">';
			html+='<i class="fa fa-calendar  fa-lg m-r-5"></i>'+data.transaction_date;
			 html+='</div></div>';
			html+='</li>';
			html+='</ul>';
     }
		 html+='<ul class="view-table">';
     html+='<li class="view-header font-bold">';
        html+='<div class="row"><div class="col-sm-12">';
        html+= getTrans( 'Details','details' ) ;
        html+='</div></div>';
     html+='</li>';

     html+=TPLorderRow( getTrans("Number Of Guests",'number_of_guest') , data.number_guest);
     html+=TPLorderRow( getTrans("Date Of Booking",'date_of_booking') , data.date_booking);
     html+=TPLorderRow( getTrans("Time",'time') , data.booking_time);

	 createElement('booking-details',html);
	 modalloaderbook.css("display","none");
}

function bookingApproved()
{
	var booking_id= $("#booking_id").val();
	//callAjax("bookingApproved",booking_id);
	$("#booking_details_view").fadeOut(500);
	$("#booking_acceptance_form").fadeIn(500);

      	  $(".booking-form-title").html( getTrans("Booking #", 'booking_nos') +" "+ booking_id);
      	  $(".booking-btn").html( getTrans("Accept & Confirm", 'accept_n_confirm') );
      	  $(".booking-notes").html( getTrans( "will send a booking confirmation to your customer",'booking_confirm_msg') );

      	  $(".booking_id").val( booking_id );
      	  $(".status").val( 'approved' );
}

function bookingDenied()
{
	var booking_id=$("#booking_id").val();
	$("#booking_details_view").fadeOut(500);
	$("#booking_acceptance_form").fadeIn(500);

      	  $(".booking-form-title").html( getTrans("Booking #", 'booking_nos') +" "+ booking_id);
      	  $(".booking-btn").html( getTrans("Decline Booking", 'decline_booking') );
      	  $(".booking-notes").html( getTrans( "will send an email to your customer",'booking_denied_msg') );
      	  $(".booking_id").val( booking_id );
      	  $(".status").val( 'denied' );

		//kNavigator.pushPage("bookingForm.html", options);
}

function bookingChangeStats()
{

	// $.validate({
	//     form : '#frm-booking',
	//     borderColorOnError:"#FF0000",
	//     onError : function() {
	//     },
	//     onSuccess : function() {
	      var params = $( "#frm-booking").serialize();
	      var info=getMerchantInfoStorage();
	      params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax("bookingChangeStats",params);

	      return false;
	//     }
	// });
}

function setHomeBooking()
{
	dump('setHomeBooking');
    var options = {
  	   closeMenu:true,
       animation: 'none',
    };

    var pages = kNavigator.getPages();
    if ( pages.length<=1){
    	kNavigator.resetToPage("slidemenu.html", options);
    } else {
    	menu.setMainPage('home.html',options);
    }
}

jQuery(document).ready(function() {
	dump('jquery ready');
	$( document ).on( "click", ".notification-action", function() {
		 var push_type= $(this).data("type");
		 dump( push_type );
		 if ( push_type=="order"){
		 	 viewOrder( $(this).data("orderid") );
		 } else if ( push_type =="booking" ) {
		    viewBooking( $(this).data("bookingid")  );
		 } else {
		 	showNotificationCampaign( $(this).data("title") ,  $(this).data("text"));
		 }
	});
});

function viewOrders()
{
	pushDialog.hide();
	var order_id= $("#order_id").val();
	viewOrder(order_id);
}

function showNotificationBooking(title, message, booking_id)
{
	if ( !isLogin() ){
		return;
	}
	if (typeof pushDialogBooking === "undefined" || pushDialogBooking==null || pushDialogBooking=="" ) {
		ons.createDialog('pushNotificationBooking.html').then(function(dialog) {
			$(".push-title").html(title);
	        $(".push-message").html(message);
	        dialog.show();
	        $("#booking_id").val( booking_id );
	    });
	} else {
		$(".push-title").html(title);
	    $(".push-message").html(message);
	    $("#booking_id").val( booking_id );
		pushDialogBooking.show();
	}
}

function viewBookings(booking_id)
{
	pushDialogBooking.hide();
	var booking_id= $("#booking_id").val();
	viewBooking(booking_id);
}

function initMobileScroller()
{
	if ( $('.mobiscroll_time').exists()){
		$('.mobiscroll_time').mobiscroll().time({
			theme: 'android-holo-light',
			mode: "scroller",
			display: "modal",
			dateFormat : "yy-mm-dd",
			/*timeFormat:"HH:ii",
			timeWheels:"HHii"*/
		});
	}
}

function isDebug()
{
	//return true;
	return false;
}

function toastMsg( message )
{
	if (isDebug()){
		onsenswal( message );
		return ;
	}

    /*window.plugins.toast.showWithOptions(
      {
        message: message ,
        duration: "long",
        position: "bottom",
        addPixelsY: -40
      },
      function(args) {

      },
      function(error) {
      	onsenswal( message );
      }
    );*/
}

/*MEDIA SOUNDS STARTS HERE*/

var my_media;

function playNotification()
{
	 var sound_url= SoundUrl;
	 dump(sound_url);
	 if(!empty(sound_url)){
        playAudio(sound_url);
	 }
}

function playAudio(url) {
    my_media = new Media(url,
        // success callback
        function () {
            dump("playAudio():Audio Success");
            my_media.stop();
            my_media.release();
        },
        // error callback
        function (err) {
            dump("playAudio():Audio Error: " + err);
        }
    );
    my_media.play();
}

	function playNewNotification(){
	 var sound_url= SoundUrl;
	 //var sound_url= "file:///C:/dev/merchant/audio/fb-alert.mp3"; //For firefox testing
	 dump(sound_url);
	 my_media = new Media(sound_url);
     my_media.play();
	 altpopup = setTimeout(function(){ playNewNotification();},5000);
}
function stopNotification()
{
	my_media.stop();
    my_media.release();
}
/*MEDIA SOUNDS ENDS HERE*/

function assignDriver()
{
	var options = {
      animation: 'none',
      onTransitionEnd: function() {
      	  $(".assign-driver-title").html( getTrans('Assigned Driver','assigned_driver') +
      	  " - " + getTrans('Order No','order_no') +":"+ $(".order_id").val() );

      	  $(".task_id").val( $(".task_id").val() );
      }
    };
    kNavigator.pushPage("assignDriver.html", options);
}


function reassignDriver()
{
	var options = {
      animation: 'none',
      onTransitionEnd: function() {
      	  $(".assign-driver-title").html( getTrans('Resign Driver','assigned_driver') +
      	  " - " + getTrans('Order No','order_no') +":"+ $(".order_id").val() );

      	  $(".task_id").val( $(".task_id").val() );
      }
    };
    kNavigator.pushPage("reassignDriver.html", options);
}


function showTeamList()
{
	if (typeof teamListDialog === "undefined" || teamListDialog==null || teamListDialog=="" ) {
		ons.createDialog('teamList.html').then(function(dialog) {
		   var info=getMerchantInfoStorage();
	       params="mtid="+info.merchant_id;
	       callAjax("loadTeamList",params);
	       teamListDialog.show();
	       translatePage();
	    });
	} else {
		var info=getMerchantInfoStorage();
	    params="mtid="+info.merchant_id;
	    callAjax("loadTeamList",params);
	    teamListDialog.show();
	}
}

function showDriverList()
{
	$("#take_away_details").fadeOut(500);
	$("#take_away_assign_driver").fadeIn(500);
	$("#driver-list").html("");
	/*if ( $(".team_id").val()==""){
		toastMsg( getTrans('Please select a team','select_team')  );
		return;
	}*/
	// if (typeof driverListDialog === "undefined" || driverListDialog==null || driverListDialog=="" ) {
	// 	ons.createDialog('driverList.html').then(function(dialog) {

		   var info=getMerchantInfoStorage();
		   params="mtid="+info.merchant_id;
		   params+="&team_id="+$(".team_id").val();
	     callAjax("driverList",params);

	// 	   driverListDialog.show();
	// 	   translatePage();
	//     });
	// } else {
	// 	var info=getMerchantInfoStorage();
	//     params="mtid="+info.merchant_id;
	//     params+="&team_id="+$(".team_id").val();
  //       callAjax("driverList",params);
  //
	// 	driverListDialog.show();
	// }
}

function displayTeamList(data)
{
	dump(data);
	var html='';
	if ( data.length>=1){
		$.each( data, function( key, val ) {
			 dump(val);
			 //onclick="setLanguage('+"'"+val.lang_id+"'"+');"
			 html+='<ons-list-item modifier="tappable" onclick="setTeam('+val.team_id+', '+"'"+val.team_name+"'"+' );" >';
             html+=val.team_name;
             html+='</ons-list-item>';
		});
		createElement("team-list",html);
	}
}

function setTeam(team_id, team_name)
{
	$(".team_id").val( team_id );
	$(".team_selected").html( team_name );
	teamListDialog.hide();
}

function displayDriverList(data)
{
	dump(data);
	var html='';
	if ( data.length>=1){
		$.each( data, function( key, val ) {
			 dump(val);
			 driver_name=val.driver_name;
			 html+='<ul class="view-table"><li onclick="setDriver('+val.id+', '+"'"+val.driver_name+"'"+' );" ><div class="col-sm-7">';
             html+=driver_name;
             html+='</div></li></ul>';
		});
		$("#driver-list").append(html);
		//createElement("driver-list",html);
	}
}

function setDriver(driver_id, driver_name)
{
	modalloader.css("display","table");
	//$(".driver_id").val( driver_id );
	//$(".driver_selected").html( driver_name );
	if($("#reassigned").val())
		  {
			var info=getMerchantInfoStorage();
			var params = "team_id=1&driver_id="+driver_id+"&reassigned=true";
			params+="&mtid="+info.merchant_id;
			params+="&order_id="+$(".order_id").val();
			callAjax("assignTask",params);
			//driverListDialog.hide();
			return false;
		  }
		  else{
				var info=getMerchantInfoStorage();
				var params = "team_id=1&driver_id="+driver_id;
				params+="&mtid="+info.merchant_id;
				params+="&order_id="+$(".order_id").val();
				callAjax("assignTask",params);
				//driverListDialog.hide();
				return false;
		  }
}

function assignTask()
{
	$.validate({
	    form : '#frm-assigntask',
	    borderColorOnError:"#FF0000",
	    onError : function() {
	    },
	    onSuccess : function() {
	      var info=getMerchantInfoStorage();

	      var params = $( "#frm-assigntask").serialize();
	      params+="&mtid="+info.merchant_id;
	      params+="&order_id="+$(".order_id").val();
	      callAjax("assignTask",params);
		  return false;

	    }
	});
}

function reassignTask()
{
	$.validate({
	    form : '#frm-reassigntask',
	    borderColorOnError:"#FF0000",
	    onError : function() {
	    },
	    onSuccess : function() {
	      var info=getMerchantInfoStorage();
	      var params = $( "#frm-reassigntask").serialize();
	      params+="&mtid="+info.merchant_id;
	      params+="&order_id="+$(".order_id").val();
	      callAjax("assignTask",params);
	      return false;
	    }
	});
}

function viewLocationNew(lat, lng, address)
{
	dump(lat); dump(lng); dump(address);
	setStorage("map_lat", lat );
	setStorage("map_lng", lng );
	setStorage("map_address", address );
	setStorage("map_actions",'view_location');

	var options = {
      animation: 'none',
      onTransitionEnd: function() {
      	  $(".map_title").html( getTrans("Location",'location') );
      	  InitMap();
      }
   };
   kNavigator.pushPage("map.html", options);
}

function TrackOrder()
{
	dump('TrackOrder');

	setStorage("map_lat", $(".task_lat").val() );
	setStorage("map_lng", $(".task_lng").val() );
	setStorage("map_address", $(".task_address").val() );

	setStorage("driver_lat", $(".driver_lat").val() );
	setStorage("driver_lng", $(".driver_lng").val() );
	setStorage("driver_name", $(".driver_name").val() );
	setStorage("driver_phone", $(".driver_phone").val() );
	setStorage("driver_location", $(".driver_location").val() );

	setStorage("map_actions",'track_order');

	var options = {
      animation: 'none',
      onTransitionEnd: function() {
      	  $(".map_title").html( getTrans("Track Order",'track_order') );
      	  InitMap();
      }
   };
   kNavigator.pushPage("map-driver.html", options);
}

function InitMap()
{
	if (empty(getStorage("map_lat"))){
		toastMsg( getTrans("Invalid coordinates",'invalid_coordinates') );
		return;
	}

	kloader.show();
	var map_actions =  getStorage("map_actions");
	//var div = document.getElementById("map_canvas_div");
	//$('#map_canvas_div').css('height', $(window).height() - $('#map_canvas_div').offset().top);

	setTimeout(function(){

	     if (!isDebug()){
	        var location = new plugin.google.maps.LatLng( getStorage("map_lat") , getStorage("map_lng") );
	     }

	     switch ( map_actions )
	     {
	     	case "view_location":
	     	  dump("view_location");

	     	  $(".map-bottom-wrapper").hide();

	     	  if (!isDebug()){
		     	  map = plugin.google.maps.Map.getMap(div, {
			         'camera': {
			         'latLng': location,
			         'zoom': 17
			        }
			      });

			      map.setBackgroundColor('white');
			      map.clear();
	        	  map.off();
	        	  map.setCenter(location);
	        	  map.setZoom(17);

			      map.addEventListener(plugin.google.maps.event.MAP_READY, function(map) {

	        	     map.addMarker({
	        	     	 'position': location ,
						  'title': getStorage("map_address") ,
						 'snippet': getTrans( "Delivery ddress" ,'delivery_address'),
						  }, function(marker) {
						     marker.showInfoWindow();
						     marker.setAnimation(plugin.google.maps.Animation.BOUNCE);
	        	         }
	        	     );

			     });
	     	  }

	     	break;

	     	case "track_order":

	     	   $(".map-bottom-wrapper").show();

	     	   /*swal( getStorage("driver_lat") );
	     	   swal( getStorage("driver_lng") );*/

	     	   $(".driver_avatar").attr("src", getStorage("driver_profilepic") );
	     	   $("._driver_name").html( getStorage("driver_name") );
	     	   $(".call_driver").attr("href","tel:"+ getStorage("driver_phone") );

	     	   if(!empty(getStorage("time_left"))){
	     	      $(".time_left").html( getStorage("time_left") );
	     	   }

	     	   if (!isDebug()){

	     	   	  var driver_location = new plugin.google.maps.LatLng( getStorage("driver_lat") , getStorage("driver_lng") );
	     	   	  map = plugin.google.maps.Map.getMap(div, {
			         'camera': {
			         'latLng': location,
			         'zoom': 17
			        }
			      });
			      map.setBackgroundColor('white');

			      map.clear();
        	      map.off();
        	      map.setCenter(location);
        	      map.setZoom(17);

			      map.addEventListener(plugin.google.maps.event.MAP_READY, function(map) {

	        	       var data = [
						 {
					        'title': getStorage("driver_location") ,
					        'position': driver_location ,
					        'snippet': getTrans( "Driver Location" ,'driver_location'),
					        'icon': {
						       'url': getStorage("icon_driver")
						    }
					      },{
					        'title': getStorage("map_address") ,
					        'position': location ,
					        'snippet': getTrans( "Delivery Address" ,'delivery_address'),
					        'icon': {
						       'url': getStorage("icon_location")
						    }
					      }
					   ];

					   addMarkers(data, function(markers) {
					    	map.addPolyline({
							points: [
							  driver_location,
							  location
							],
							'color' : '#AA00FF',
							'width': 10,
							'geodesic': true
							}, function(polyline) {

								 map.animateCamera({
								 	  'target': driver_location ,
								 	  'zoom': 17,
								 	  'tilt': 30
								 });

							});
					    });

			      });
	     	   }
	     	break;

	     	default:
	     	 toastMsg(  getTrans("Undefined map action",'undefined_map_action') );
	     	break;
	     }

		 hideAllModal();
	}, 500);

}

function addMarkers(data, callback) {
  var markers = [];
  function onMarkerAdded(marker) {
    markers.push(marker);
    if (markers.length === data.length) {
      callback(markers);
    }
  }
  data.forEach(function(markerOptions) {
    map.addMarker(markerOptions, onMarkerAdded);
  });
}

function setButtonTask()
{
	dump('setButtonTask');
	var task_id=$(".task_id").val();
	if (task_id>0){
	    $(".assign_driver_label").html( $("#assign_driver_label").val() );
	}
}

function setButtonTask2()
{
	kNavigator.popPage({cancelIfRunning: true});
	setButtonTask();
}

function loadBooking(done)
{
	dump('pull');

	if ( !hasConnection() ){
		notyswal(  getTrans("CONNECTION LOST",'connection_lost'),'error' );
		done();
		return;
	}

	var action= "PendingBookingTab";
	var div_id= 'newbooking-list';

	var info=getMerchantInfoStorage();
	var params="token="+getStorage("merchant_token");
	params+="&user_type="+info.user_type;
	params+="&mtid="+info.merchant_id;
	params+="&lang_id="+getStorage("mt_default_lang");

    if(!empty(krms_config.APIHasKey)){
		params+="&api_key="+krms_config.APIHasKey;
	}

	dump(ajax_url+"/"+action+"/?"+params);

    ajax_request = $.ajax({
	 url: ajax_url+"/"+action,
	 data: params,
	 type: 'post',
	 async: true,
	 dataType: 'jsonp',
	// timeout: 5000,
	 crossDomain: true,
	 beforeSend: function() {
		if(ajax_request != null) {
		   /*abort ajax*/
		   hideAllModal();
           ajax_request.abort();
		}
	},
	complete: function(data) {
		ajax_request=null;
	},
	success: function (data) {
		dump(data);
		done();
		if (data.code==1){
			displayBooking(data.details,div_id);
		} else if(data.code==3){

		} else {
			// failed response
			//$("#newbooking-list").html('');
			$("#new-booking-error").html(data.msg);
			notyswal(data.msg,"error");
		}
	},
	error: function (request,error) {

	}
   });
}

function OrderRefresh()
{
	dump('OrderRefresh()');
	//altpopup = setTimeout(function(){ playNewNotification(); },1000);
	var tab_action = $("#display-div").val();
	dump(tab_action);
	switch (tab_action)
	{
		case "new-orders":
		GetTodaysOrder();
		break;

		case "pending-orders":
		getPendingOrders();
		break;

		case "allorders-orders":
		getGetAllOrders();
		break;

		case "booking-pending":
          var info=getMerchantInfoStorage();
	      var params='';
		  params+="&token="+getStorage("merchant_token");
		  params+="&user_type="+info.user_type;
		  params+="&mtid="+info.merchant_id;
	      callAjax('PendingBookingTab',params);
	      translatePage();
		break;
	}
}

function foodOptions(action)
{
	switch(action){
		case 1:
		if ( food_option_not_available.isChecked()){
		   food_option_not_available_disabled.setChecked(false);
		}
		break;

		case 2:
		if ( food_option_not_available_disabled.isChecked()){
		   food_option_not_available.setChecked(false);
		}
		break;
	}
}

function showNotificationBadge(counter)
{
	var badge_count=0;

	if (empty(getStorage("badge_count"))){
		setStorage("badge_count",0);
		badge_count=0;
	}

	if (isNaN(getStorage("badge_count"))){
		setStorage("badge_count",1);
		badge_count=1;
	} else {
		badge_count=parseInt(getStorage("badge_count")) + parseInt(counter);
		setStorage("badge_count", badge_count );
	}


	if ( badge_count>0 ){
		$(".notification-count").css({ "display":"inline-block","position":"absolute","margin-left":"-8px" });
		$(".notification-count").text(badge_count);
	} else {
		$(".notification-count").hide();
	}
}

function clearBadge()
{
	removeStorage("badge_count");
	$(".notification-count").hide();
}

var hue = 1,
    logo1 = $(".flashing-banner"); //deprecated , using pulse animation. check app.css by Raj on 21.10.17
function color() {
	var alpha = 0,
		  s = 1,
		  v = 1,
		  c, h, x, r1, g1, b1, m,
		  red, blue, green;
	hue %= 360;
	h = hue / 60;
	if (hue < 0) {
	    hue += 360;
	}
	c = v * s;
	h = hue / 60;
	x = c * (1 - Math.abs(h % 2 - 1));
	m = v - c;
	switch (Math.floor(h)) {
		case 0: r1 = c; g1 = x; b1 = 0; break;
		case 1: r1 = x; g1 = c; b1 = 0; break;
		case 2: r1 = 0; g1 = c; b1 = x; break;
		/*case 3: r1 = 0; g1 = x; b1 = c; break;
		case 4: r1 = x; g1 = 0; b1 = c; break;
		case 5: r1 = c; g1 = 0; b1 = x; break;*/
	}
	red = Math.floor((r1 + m) * 255);
	green = Math.floor((g1 + m) * 255);
	blue = Math.floor((b1 + m) * 255);

 // $(".flashing-banner").css('backgroundColor', 'rgba(' + red + ',' + green + ',' + blue + ',' + 1 + ')'); // commented on 21.10.17
  hue++;
}
window.setInterval(color, 10);

$(document).on('click','ons-back-button',function(){
	if($(this).parent().parent().parent().attr('id') == "page-bookingView"){
		setTimeout(function(){getNewBooking();},2000);
	}
});
	$(function () {
		if($('.datetimepicker').length > 0 ){
			$('.datetimepicker').datetimepicker({
				format: 'YYYY-MM-DD',
				maxDate: new Date()
			});
			$("#datetimepicker_driver").on("dp.change", function (e) {
				var date=$(this).val();
				var todays = new Date(date);

						var weekdays = new Array(7);
						weekday[0] = "Sunday";
						weekday[1] = "Monday";
						weekday[2] = "Tuesday";
						weekday[3] = "Wednesday";
						weekday[4] = "Thursday";
						weekday[5] = "Friday";
						weekday[6] = "Saturday";

				var current_days = weekday[todays.getDay()];
				console.log(current_days);
				var monthNamess = ["January", "February", "March", "April", "May", "June",
					"July", "August", "September", "October", "November", "December"
				];
				var months=monthNamess[todays.getMonth()];
				console.log(months);
				var dds = todays.getDate();
				var mms = todays.getMonth()+1; //January is 0!

				var yyyys = todays.getFullYear();
				if(dds<10){
						dds='0'+dds;
				}
				if(mms<10){
						mms='0'+mms;
				}
				var todays = yyyys+'-'+mms+'-'+dds;
				console.log(todays);

				var todays = current_days +", "+ dds +" "+ months +" "+ yyyys ;
				$("#summary_driver").html(todays);
							setStorage("dates",todays);
		           GetDriverSummaryDate(date);
		  });

			$("#datetimepicker_summary").on("dp.change", function (e) {
							 var date=$(this).val();
							 var todays = new Date(date);

							     var weekdays = new Array(7);
							     weekday[0] = "Sunday";
							     weekday[1] = "Monday";
							     weekday[2] = "Tuesday";
							     weekday[3] = "Wednesday";
							     weekday[4] = "Thursday";
							     weekday[5] = "Friday";
							     weekday[6] = "Saturday";

							 var current_days = weekday[todays.getDay()];
							 console.log(current_days);
							 var monthNamess = ["January", "February", "March", "April", "May", "June",
							   "July", "August", "September", "October", "November", "December"
							 ];
							 var months=monthNamess[todays.getMonth()];
							 console.log(months);
							 var dds = todays.getDate();
							 var mms = todays.getMonth()+1; //January is 0!

							 var yyyys = todays.getFullYear();
							 if(dds<10){
							     dds='0'+dds;
							 }
							 if(mms<10){
							     mms='0'+mms;
							 }
							 var todays = yyyys+'-'+mms+'-'+dds;
							 console.log(todays);
							 $("#summary").html(todays);
							 var todays = current_days +", "+ dds +" "+ months +" "+ yyyys ;
							 setStorage("dates",todays);
		           GetTodaysOrderSummaryDate(date);
		  });
		}
	});

	//$('.datetimepicker').on('changeDate', GetDriverSummaryDate());
