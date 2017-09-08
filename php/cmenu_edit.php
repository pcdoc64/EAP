<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap || !$con) {echo 'access denied<br>';}
$remov='0';
if (isset($_GET['del'])) {$remov=$_GET['del'];}
if ($PageName=='menu_edit') {
  if ($remov=='1') {echo "<div id='PgTitle'>Delete Menu</div>";} else {echo "<div id='PgTitle'>Menu Edit</div>";}
//                                    Get details of Menu and add to $row
  $cnti=0;
  $query="SELECT * FROM menus WHERE idmenu=".$_GET['id'];
  $result=mysqli_query($conaap,$query);
  $cnti=mysqli_num_rows($result);
  if ((!$result)||($cnti==0)) {echo "no result";}
  $row=$result->fetch_row();
//                                    Get list of groups and name of ppl in groups select by name

  }
//  echo "<div id='PgTitle'>New Program</div>";
  $result=FALSE;
