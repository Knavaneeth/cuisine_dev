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
	dump('has token');
	window.location.href='order-list.html';

		dump( getStorage("merchant_token") );
} else {
	dump('no token');
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
           ajax_request.abort();
		} else {
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
		 dump(data); if(acn_chk == "getNewPendingOrders") action = 'getNewPendingOrders';
		if (data.code==1){

			dump('actions=>' + action);

			switch (action)
			{
				case "registerMobile":
				case "none":
				break;

				case "login":					 
				   // alert(data.toSource());
					console.log(data.details);
				   dump(data.details.token);
				   setStorage("merchant_token",data.details.token);
				   setStorage("merchant_info",JSON.stringify(data.details.info));
					  var delivery_time=data.details.info.delivery_estimation;
					  setStorage("merchant_delivery_time",delivery_time);
						var pickup_time=data.details.info.pickup_estimation;
					  setStorage("merchant_pickup_time",pickup_time);
					  var trues=data.details.info.table_booking_available;
				   setStorage("table_book_show",trues);
					 showHomePage();
				break;

				case "ForgotPassword":
				swal(data.msg);
				$(".email_address").val( data.details.email_address );
				$(".user_type").val( data.details.user_type );
				$("#form_forget_pass").fadeOut(500);
				$("#forgot_pass_verify").fadeIn(500);
				break;

				case "ChangePasswordWithCode":
				swal(data.msg);
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
		view_order_page_bol = undefined;
		dump("MY CALL ERROR=>" + action);
		switch (action)
		{
			case "getLanguageSettings":
			case "registerMobile":
			case "getLanguageSettings":
			break;

			default:
			swal("Network error has occurred please try again!",'network_error');
		    break;
		}
	}
   });

} /*end callajax*/


function showHomePage()
{
	 window.location.href="order-list.html";
  if (isLogin() ){
  	 
	}
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
$('#forgot_password').on('show.bs.modal', function (e) {
		$("#form_forget_pass").show();
		$("#forgot_pass_verify").hide();
});

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
