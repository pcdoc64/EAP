<?php
// code to strip any malicious scripts from input
function test_input($data) {
  $qt="'";
  $qtr="''";
  $data = str_replace($qt,$qtr,$data);
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

ini_set('display_errors', 'On');
include '../resource/dbinclude.inc';
if (isset($_POST["cancel"])) {header("Location:../index.php?pg=admin&sel=equip");};
$equipid=$equip_name=$comment=$type='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $equip_name=test_input($_POST["equipitem"]);
  $comment=test_input($_POST["equip_comment"]);
  $equipid=$_POST["equipid"];
}

$conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
if (isset($_POST["add"])) {
  $query="INSERT INTO F31equip (item, comments)
  VALUES('$equip_name', '$comment')";
  if (mysqli_query($conaap,$query)) { echo "new record";} else {echo "error ".$query." - ".$conaap->error;}
}

if (isset($_POST["update"])) {
  $query="UPDATE F31equip SET item='$equip_name', comments='$comment' WHERE idequip='$equipid'";
  if (mysqli_query($conaap,$query)) {echo "update record";} else {echo "error ".$query." - ".$conaap->error;}
}
mysqli_close($conaap);
header("Location:../index.php?pg=admin&sel=equip");
?>
