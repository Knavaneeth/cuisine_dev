function statusChangeCallback(response) {
    console.log(response);
    if (response.status === 'connected') {
        fbResultAPI();
        console.debug("login OK");
    } else if (response.status === 'not_authorized') {
        console.debug("please login");
    } else {
        console.debug("please login");
    }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}
window.fbAsyncInit = function() {
    FB.init({
        appId: $("#fb_app_id").val(),
        cookie: true,
        xfbml: true,
        version: 'v2.4'
    });
};
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function fbResultAPI() {
    FB.api('/me?fields=email,first_name,last_name', function(response) {
    	// alert(response.toSource());
        console.debug(response);
        fb_register(response);
    });
}

function fbLogout() {
    FB.logout(function(response) {
        console.debug("Person is now logged out");
    });
}

function fbcheckLogin() {
    FB.login(function(response) {
        dump(response);
        if (response.status === 'connected') {
            uk_msg_sucess(js_lang.login_succesful);
            fbResultAPI();
            window.location.reload()
        } else if (response.status === 'not_authorized') {
            uk_msg(js_lang.not_authorize);
        } else {
            uk_msg(js_lang.not_login_fb);
        }
    }, {
        scope: 'public_profile,email'
    });
}