var ajax_url= krms_config.ApiUrl ;
var ajax_request;
document.addEventListener("deviceready", onDeviceReady, false);

function onDeviceReady() {

}

jQuery.fn.exists = function(){return this.length>0;}
jQuery.fn.found = function(){return this.length>0;}


document.addEventListener("offline", noNetConnection, false);


function noNetConnection()
{
	swal("Internet connection lost","net_connection_lost");
}

if (!empty(getStorage("merchant_token"))){
	getSettings();
	dump('has token');
		dump( getStorage("merchant_token") );
} else {
	dump('no token');
	window.location.href='index.html';
}

function callAjax(action,params)
{

params+="&lang_id="+getStorage("mt_default_lang");
	if(!empty(krms_config.APIHasKey)){
		params+="&api_key="+krms_config.APIHasKey;
	}
	var acn_chk = action;
	dump("Action=>"+action);
	dump(ajax_url+"/"+action+"?"+params);
	if(action == "getNewPendingOrders") action = 'getPendingOrders';
	ajax_request = $.ajax({
	 url: ajax_url+"/"+action,
	 data: params,
	 type: 'post',
	 async: false,
	 dataType: 'jsonp',
	 timeout: 5000,
	 crossDomain: true,
	 beforeSend: function() {
		if(ajax_request != null) {
		   /*abort ajax*/
		   //hideAllModal();
           ajax_request.abort();
		} else {
			/*show modal*/
			switch(action)
			{

				case "none":
				   break;
				default:
				   break;
			}
		}
	},
	complete: function(data) {
		ajax_request=null;

		view_order_page_bol = undefined;
		view_booking_page_bol = undefined;
	},
	success: function (data) {
		if (data.code==1){

			dump('actions=>' + action);

			switch (action)
			{
				case "registerMobile":
				case "none":
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

			}
		}
		else if(data.code==3){

		} else {
			// failed response
			swal(data.msg);
		}
	},
	error: function (request,error) {
		//hideAllModal();
		view_order_page_bol = undefined;
		dump("MY CALL ERROR=>" + action);
		switch (action)
		{


			default:
			swal("Network error has occurred please try again!",'network_error');
		    break;
		}
	}
   });

} /*end callajax*/



function getMerchantInfoStorage()
{
	var info =  JSON.parse( getStorage("merchant_info") );
	return info;
}

function logout()
{
   removeStorage("merchant_token");
   removeStorage("merchant_info");
	 window.location.href="index.html";
}

function getSettings(){
					var info=getMerchantInfoStorage();
					var params='';
					params+="&token="+getStorage("merchant_token");
					params+="&user_type="+info.user_type;
					params+="&mtid="+info.merchant_id;
					params+="&device_id="+getStorage("merchant_device_id");
				  callAjax('getSettings',params);
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
