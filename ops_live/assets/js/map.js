var ajax_url= krms_config.ApiUrl ;
var ajax_request;
var loader=$("#loader-wrap");
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
	var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
var address = getUrlParameter('address');
	viewLocation(address);
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

				case "geoDecodeAddress":
				var locations={
				"name":data.address ,
				"lat":data.details.lat,
				"lng":data.details.long
				};
				initMap(locations);
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

function viewLocation(address)
{
		loader.show();
				dump(address);
      	  $("#location-address").html(address);
      	  var params="address="+address;
      	  callAjax("geoDecodeAddress",params);
}

function initMap(data)
{
	loader.css("display","none");
	dump(data);
	if(data.lat == "" || data.long == "")
	{
			var map = new GoogleMap();
			$("#location_error").show();
			console.log("Inside if");			
			map.initialize('location-map', "49.217231", "-2.140589" , 18);

	}
	else if ( !empty(data.lat)){
		console.log("Inside if else");
		var map = new GoogleMap();
	    map.initialize('location-map', data.lat, data.lng , 18);
	} else {
		//$("#location-map").hide(); // Still show the map for the restaurant manager to search
		swal("location not available",'error' );
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
