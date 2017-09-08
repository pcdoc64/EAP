<?php
// code to strip any malicious scripts from input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

ini_set('display_errors', 'On');
include '../resource/dbinclude.inc';
if (isset($_POST["cancel"])) {header("Location:index.php?pg=admin&sel=branch");};
$idacttype=$acttypename=$wood=$spec=$pr=$qbsi=$qbsoa='';

// foreach ($_POST as $key => $value) {
//   echo $key.' - ';
//   echo $value.'<br>';
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $acttypename=test_input($_POST["acttypename"]);
  if (isset($_POST["woodbeads"])) {$wood="W";}else{$wood="";};
  if (isset($_POST["special"])) {$spec="S";}else{$spec="";};
  $pr=test_input($_POST["acttypepr"]);
  $qbsi=test_input($_POST["acttypeqbsi"]);
  $qbsoa=test_input($_POST["acttypeqbsoa"]);
  $idacttype=$_POST["idact_type"];
}
echo "wood - ".$wood." special - ".$spec;
$conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
if (isset($_POST["add"])) {
  $query="INSERT INTO act_type (act_name, req_woodbead, req_special, pr, qbsi, qbsoa)
  VALUES('$acttypename', '$wood', '$spec', '$pr', '$qbsi', '$qbsoa')";
  if (mysqli_query($conaap,$query)) { echo "new record";} else {echo "error ".$query." - ".$conaap->error;}
}

if (isset($_POST["update"])) {
  $query="UPDATE act_type SET act_name='$acttypename', req_woodbead='$wood', req_special='$spec', pr='$pr', qbsi='$qbsi', qbsoa='$qbsoa' WHERE idact_type='$idacttype'";
  if (mysqli_query($conaap,$query)) {echo "update record";} else {echo "error ".$query." - ".$conaap->error;}
}
mysqli_close($conaap);
header("Location:index.php?pg=admin&sel=branch");
?>
