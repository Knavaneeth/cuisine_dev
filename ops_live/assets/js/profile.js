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
	getprof();
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
				case "getProfile":
				$(".username").val(data.details.username);
				break;

				case "saveProfile":
				swal({
				 title: krms_config.DialogDefaultTitle,
				 text: data.msg,
				 type: "success"
			 		}).then(function() {
					window.location.href='order-list.html';
				 });
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
	//console.log(info);
}
function getprof(){
					var info=getMerchantInfoStorage();
					var params='';
					params+="&token="+getStorage("merchant_token");
					params+="&user_type="+info.user_type;
					params+="&mtid="+info.merchant_id;
				  callAjax('getProfile',params);
				}


				function saveProfile()
				{
						var pass=$("#password").val();
						var cpass=$("#cpassword").val();
						if(pass == "")
						{
							swal("Password should not be empty");
						}
						else if(cpass == ""){
							swal("Confirm Password should not be empty");
						}
						else if(pass != cpass)
						{
							swal("Password and confirm password should be same");
						}
						else{
					      var params = $( "#frm-profile").serialize();
					      var info=getMerchantInfoStorage();
						  params+="&token="+getStorage("merchant_token");
						  params+="&user_type="+info.user_type;
						  params+="&mtid="+info.merchant_id;
					      callAjax("saveProfile",params);
					       return false;
							 }
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
function logout()
{
   removeStorage("merchant_token");
   removeStorage("merchant_info");
	 window.location.href="index.html";
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
