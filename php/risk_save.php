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
$nom='Q';
ini_set('display_errors', 'On');
include '../resource/dbinclude.inc';
//echo "loaded risk save<br>";
if (isset($_POST['scr'])){
  if ($_POST['scr'].length>0){
  $nom=substr($_POST['scr'],0,1);
  $nomid=substr($_POST['scr'],1);
}}
if (isset($_POST['cancel'])) {
  echo ("cancelled -".$nom);
  if ($nom=='V') {header("Location:../index.php?pg=actv_edit&id=".$nomid);}
  if ($nom=='R'|| $nom=='Q') {header('Location:../index.php?pg=risk');}
  if ($nom=='S') {header("Location:../index.php?pg=site_edit&id=".$nomid);}
  if ($nom=='C') {header("Location:../index.php?pg=aap_edit&id=".$nomid);}
  if ($nom=='T') {header("Location:../index.php?pg=admin&sel=actclass_edit&id=".$nomid);}
}
if (isset($_POST["delete"])) {
  $conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  if (!$conaap) {echo 'access denied<br>';}
  $query="DELETE FROM risk WHERE idrisk=".$_POST['riskid'];
  if (mysqli_query($conaap,$query)) {
    echo "deleted record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
  if (isset($_POST['scr'])){
    if ($_POST['scr'].length>0){
    $nom=substr($_POST['scr'],0,1);
    $nomid=substr($_POST['scr'],1);
  }}

  if ($nom=='V') {header("Location:../index.php?pg=actv_edit&id=".$nomid);}
  if ($nom=='R') {header('Location:../index.php?pg=risk');}
  if ($nom=='S') {header("Location:../index.php?pg=site_edit&id=".$nomid);}
  if ($nom=='C') {header("Location:../index.php?pg=aap_edit&id=".$nomid);}
  if ($nom=="T") {header("Location:../index.php?pg=admin&sel=actclass_edit&id=".$nomid);}
}
$riskid=$riskname=$typeE=$task=$risk=$mat_before=$mitig=$mat_after=$refs=$notes=$qbsi=$pr=$other='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $riskname=test_input($_POST["riskname"]);
  $typeE=test_input($_POST["typeE"]);
  $task=test_input($_POST["task"]);
  $risk=test_input($_POST["risk"]);
  $mat_before=test_input($_POST["mat_before"]);
  $mitig=test_input($_POST["mitig"]);
  $mat_after=test_input($_POST["mat_after"]);
  $refs=0;
  if (isset($_POST["refsb"])){
    $refs=1;
  }
  if (isset($_POST["refsr"])){
    $refs+=2;
  }
  $notes=test_input($_POST["notes"]);
  $qbsi=test_input($_POST["qbsi"]);
  $pr=test_input($_POST["pr"]);
  $other=test_input($_POST["other"]);
  $riskid=$_POST["riskid"];
}

$conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
if (isset($_POST["add"])) {
  $query="INSERT INTO risk (risk_name, matrix_before, task, risk, matrix_after, mitigation, refer, typeE, notes, QBSI, PR, other)
  VALUES('$riskname', '$mat_before', '$task', '$risk', '$mat_after', '$mitig', '$refs', '$typeE', '$notes', '$qbsi', '$pr', '$other')";
  if (mysqli_query($conaap,$query)) {
    echo "new record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}
//echo $refs;
if (isset($_POST["update"])) {
  $query="UPDATE risk SET risk_name='$riskname', matrix_before='$mat_before', task='$task', risk='$risk', matrix_after='$mat_after', mitigation='$mitig', refer='$refs', typeE='$typeE', notes='$notes', QBSI='$qbsi', PR='$pr', other='$other' WHERE idrisk='$riskid'";
  if (mysqli_query($conaap,$query)) {
    echo "update record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}
//echo $query;

if ($nom=='V') {header("Location:../index.php?pg=actv_edit&id=".$nomid);}
if ($nom=='R'||$nom=='Q') {header('Location:../index.php?pg=risk');}
if ($nom=='S') {header("Location:../index.php?pg=site_edit&id=".$nomid);}
if ($nom=='C') {header("Location:../index.php?pg=aap_edit&id=".$nomid);}
if ($nom=='T') {header("Location:../index.php?pg=admin&sel=actclass_edit&id=".$nomid);}
?>
