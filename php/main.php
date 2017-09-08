
<?php
include "dbcheck.php";
// Check if logged in, if not, break to login.php
// If logged in, show menu
$rights=0;
if (!isset($_GET['pg'])) {
  $PageName='main';
  include "php/login.php";
} else {
  $PageName=$_GET['pg'];
  if (!isset($_SESSION['user'])) {$PageName='log';}
  if ($PageName=='log') {
    $con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
    ('logout', 'Successful', 'none', 'none', 'none', 'none', '".$_SESSION['realname']."')";
    $query=mysqli_query($con, $sql);
    include "php/login.php";
  } else {
    include "php/menu.php";
    switch ($PageName) {
      case 'aap': // Activity Pack
        include "php/aap.php";
        break;
      case 'aap_add': // Activity Pack
        include "php/aap_edit.php";
        break;
      case 'aap_edit': // Activity Pack
        include "php/aap_edit.php";
        break;
      case 'site': // Sites
        include "php/sites.php";
        break;
      case 'site_add': // Sites add
        include "php/sites_edit.php";
        break;
      case 'site_edit': // Sites edit
        include "php/sites_edit.php";
        break;
      case 'actv': // Activities
        include "php/actv.php";
        break;
      case 'actv_add': // Activities add
        include "php/actv_edit.php";
        break;
      case 'actv_edit': // Activities edit
        include "php/actv_edit.php";
        break;
      case 'risk': // Risk Assessment
        include "php/risk.php";
        break;
      case 'risk_add': // Risk add
        include "php/risk_edit.php";
        break;
      case 'risk_edit': // Risk edit
        include "php/risk_edit.php";
        break;
      case 'cmenu': // Camp Menus
        include "php/cmenu.php";
        break;
      case 'menu_add': // Menu add
        include "php/cmenu_edit.php";
        break;
      case 'menu_edit': // Menu edit
        include "php/cmenu_edit.php";
        break;
      case 'admin': // Camp Menus
        include "php/admin.php";
        break;
      case 'welc': // Camp Menus
        include "php/welcome.php";
        break;
      case 'profile': // Camp Menus
        include "php/profile.php";
        break;
      case 'dir': // Camp Menus
        include "php/directions.php";
        break;

      default: // Log out
  //      echo 'destroy session';
        session_unset();
        session_destroy();
        $_SESSION = array();
        header("location:index.php");
        break;
    };
  }
//  if (!isset($_SESSION)) {header("Location:../index.php?pg=log");}
}
?>
