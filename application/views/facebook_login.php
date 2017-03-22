<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" charset="utf-8"></script>
  
 <div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {         //페이스북 sdk 초기화 작업
  FB.init({
    appId      : '앱 ID',
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });
 
  FB.Event.subscribe('auth.authResponseChange', function(response) {
    if (response.status === 'connected') {
 
      //FaceBookLoginAPI();                 // 페이스북 로그인 되었을 경우 바로 로그인 되게 할경우 주석 해지.
    } else if (response.status === 'not_authorized') {
      FB.login();
	} else {
 
      FB.login();
    }
  });
  };
 
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_KR/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));
 
  function FaceBookLoginAPI() {
   FB.login(function(logresponse){
            var fbname; 
            var accessToken = logresponse.authResponse.accessToken;
        FB.api('/me', function(response) {
                $.post("/login.php", { name: response.name, id: response.id+'__fac', facebook:"facebook"},
                    function(postphpdata) {
                     //alert(postphpdata);
                     if(accessToken){
                        location.replace('./index.php');
                     }
                });
          //alert('Good to see you, ' + response.name + '.'+ response.id);
        });
    }, {scope: 'publish_stream'});
}  
</script>
</head>
<body>
<img src="img/facebook.png" onclick="FaceBookLoginAPI()" style='cursor:pointer;'>
</body>
</html>
