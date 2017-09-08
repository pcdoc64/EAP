<div id="menu2a">
  <div id='menu2'>
    <ul>
      <li><a href="index.php?pg=admin&sel=actclass">Activity Class</a></li>
      <li><a href="index.php?pg=admin&sel=actT">Activity Type</a></li>
      <li><a href="index.php?pg=admin&sel=risktype">Risk Types</a></li>
      <li><a href="index.php?pg=admin&sel=branch">Branch / Regions</a></li>
      <li><a href="index.php?pg=admin&sel=equip">F31 Equipment</a></li>
      <li><a href="index.php?pg=admin&sel=logger">Logging</a></li>
    </ul>
  </div>
</div>
<div><p> .</p></div>
<?php
  if (isset($_GET['sel'])) {
    $slct=$_GET['sel'];
    switch ($slct) {
      case 'actclass': // Activity Types
        include "php/actclass.php";
        break;
      case 'actclass_add': // NewActivity Type
        include "php/actclass_edit.php";
        break;
      case 'actclass_edit': // Edit Activity Type
        include "php/actclass_edit.php";
        break;
      case 'actT': // Risk Type
        include "php/acttype.php";
        break;
      case 'risktype': // Risk Type
        include "php/risktype.php";
        break;
      case 'branch': // Branch > Region > District setup
        include "php/branch.php";
        break;
      case 'equip': // F31 Equipment Items
        include "php/equip.php";
        break;
      case 'equip_add': // New F31 Item
        include "php/equip_edit.php";
        break;
      case 'equip_edit': // Edit F31 Item
        include "php/equip_edit.php";
        break;
      case 'logger': // F31 Equipment Items
        include "php/logger.php";
        break;
    }
  } else {
    include('php/admin_welc.php');
  }
 ?>

 <script>
 $( document ).ready(function() {
   if (document.querySelector("#m6")) {document.querySelector("#m6").style="Background-Color:black";}
});
</script>
