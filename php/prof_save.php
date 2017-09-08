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
if (isset($_POST["cancel"])) { header("Location:../index.php?pg=welc");}

$uid=$name=$pos=$brnch=$regn=$district=$group=$phone1=$phone2=$email1=$email2=$emerg_name=$emerg_phone='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name=test_input($_POST["name"]);
  $_SESSION['realname']=$name;
  $pos=test_input($_POST["pos"]);
  $_SESSION['role']=$pos;
  $brnch=test_input($_POST["brnch"]);
  $regn=test_input($_POST["regn"]);
  $district=test_input($_POST["district"]);
  $group=test_input($_POST["group"]);
  $_SESSION['group']=$group;
  $phone1=test_input($_POST["phone1"]);
  $_SESSION['phone1']=$phone1;
  $phone2=test_input($_POST["phone2"]);
  $email1=test_input($_POST["email1"]);
  $email2=test_input($_POST["email2"]);
  $emerg_name=test_input($_POST["emerg_name"]);
  $emerg_phone=test_input($_POST["emerg_phone"]);
  $uid=$_POST["uid"];
}

$conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
if (isset($_POST["add"])) {
//  $query="INSERT INTO oc_users (uid, displayname, position, group_leader, section, group, district, region, branch, phone1, phone2, email1, email2, emergency_contact, emergency_phone)
  $query="INSERT INTO oc_users (uid, displayname, position, groupname, district, region, branch, phone1, phone2, email1, email2, emergency_contact, emergency_phone)
  VALUES('$uid', '$name', '$pos', '$group', '$district', '$regn', '$brnch', '$phone1', '$phone2', '$email1', '$email2', '$emerg_name', '$emerg_phone')";
  if (mysqli_query($conaap,$query)) {
    echo "new record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}
//echo $refs;
if (isset($_POST["update"])) {
  $query="UPDATE oc_users SET displayname='$name', position='$pos', groupname='$group', district='$district', region=$regn, branch=$brnch, phone1='$phone1', phone2='$phone2', email1='$email1', email2='$email2', emergency_contact='$emerg_name', emergency_phone='$emerg_phone' WHERE uid='$uid'";
//  echo $query;
  if (mysqli_query($conaap,$query)) {
    echo "update record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}
//mysqli_close($conaap);
$_SESSION['email1']=$email1;
header("Location:../index.php?pg=welc");
?>
