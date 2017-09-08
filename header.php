<?php
ini_set('error_log', 'crapper.txt');
ini_set('log_errors_max_len', 0);
ini_set('log_errors', true);
ini_set('date.timezone','Australia/Brisbane');
ini_set('display_errors', 'On');
include 'resource/dbinclude.inc';

function protect($string){
    $string = trim(strip_tags(addslashes($string)));
    return $string;
}

?>

<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
        <title>Scouts - Event Approval Package</title>

		<meta name="description" content="Scouts Activity Approval Package">
		<meta name="author" content="IT Maintenance and support ITMAS.com.au">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">


    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>-->
    <script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/sorttable.js"></script>
    <script type="text/javascript" src="js/turn.js"></script>
    <script type="text/javascript" src="js/autosize.min.js"></script>
    <script type="text/javascript" src="js/date.js"></script>
    <script type="text/javascript" src="js/jquery.maxlength.js"></script>

        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"> <!--  ver 1.12.4 -->
        <link rel="stylesheet" href="css/style.css?d=<?php echo time(); ?>" />




        <!-- Enabling HTML5 support for Internet Explorer -->
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <basefont size="12"
    </head>
<body id="body-color" style="text-align:center">
  <script>
  var pageset=location.search.substr(1);
  if (pageset.length>0) {
    extr=pageset.indexOf('&');
    if (extr>0) {pageset=pageset.substring(3,extr);} else {pageset=pageset.substring(3,pageset.length);}
    if (!(pageset=='log' || pageset=='welc')) {
//      debugger;
      var rst=<?php if(isset($_SESSION['id'])) {echo '"TRUE"';} else {echo '"FALSE"';} ?>;
      var reslt=CheckUserSession('username');
      if (reslt == false) {
//        debugger;
        alert(reslt);
//        window.location.assign("index.php");
      }
  } }

  function CheckUserSession(requestr) {
  var userInSession = true;
  $.ajax({
      url: 'json/checksession.php',// It will return true/false based on session
      type: "post",
      datatype:'JSON',
      async:false,
      data:{
        req:requestr,
      },
      success: function (data) {
          if (data!=null) {
            userInSession = data.userInSession;
          } else {
            userInSession=false;
          }
      },
      error: function (request, status, error) {
        alert(request.responseText);
    }
    });
    return userInSession;
  }


    // detect browser
    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;
    // Chrome 1+
    var isChrome = !!window.chrome && !!window.chrome.webstore;
    // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;

    function logit(sectn, actn, orgfield, orgval, chngval, uid) {
  		$.ajax({
            url :"json/logger.php",
            type: "post",
            datatype:'JSON',
            data:{
              sectn:sectn,
              actn:actn,
  						orgf:orgfield,
  						orgv:orgval,
  						chngval:chngval,
              uid:uid
            },
            success:function(data){//  alert (data);
            },
            error: function(jqXHR,error, errorThrown) {
                if(jqXHR.status && (jqXHR.status==400 || jqXHR.status==500)){
                  if (jqXHR.status==400) alert(jqXHR.responseText);
                  if (jqXHR.status==500) alert(errorThrown);
                }else{
                  alert("Something weird went wrong");
                }
            },
            async:false
          });
        }

  </script>
	<header>
		<h2>Event Approval Package <i>online</i>
      <?php
        if (isset($_SESSION['realname'])) {
          echo ' - <a href="index.php?pg=welc">Welcome</a> '.$_SESSION['realname'];
        } else {
          $_SESSION['realname']=', please login';
          echo '<script type="text/javascript"> window.location = "index.php?pg=log";</script>';
        }
       ?>
    </h2>
	</header>
