<?php
//echo 'first line <br>';
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

//echo 'starting button press check <br>';
if (!isset($_SESSION)) {header("Location:../index.php?pg=log");}
ini_set('display_errors', 'On');
include '../resource/dbinclude.inc';
//echo "loaded actv save<br>";
//var_dump($_POST);

if (isset($_POST["cancel"])) {header("Location:index.php?pg=actv");};
if (isset($_POST["delete"])) {
  $conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  if (!$conaap) {echo 'access denied<br>';}
  $query="DELETE FROM activities WHERE idact=".$_POST['actvid'];
  if (mysqli_query($conaap,$query)) {
    echo "deleted record";
    $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
    ('Program', 'Delete', 'all', 'all', 'all', '".$_SESSION['realname']."')";
    $query=mysqli_query($conaap, $sql);
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
  $query="DELETE FROM RiskActV WHERE idact=".$_POST['actvid'];
  if (mysqli_query($conaap,$query)) {
    echo "deleted record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
  $query="DELETE FROM program WHERE idact=".$_POST['actvid'];
  if (mysqli_query($conaap,$query)) {
    echo "deleted record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
  header("Location:../index.php?pg=actv");
}
$actvid=$actv_name=$actv_type=$fromdate=$fromtime=$todate=$totime=$sectn=$wood=$spec=$costpp=$pr=$qbsi=$qbsoa=$other=$notes=$activ='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $actv_name=test_input($_POST["actv"]);
//  $actv_type=intval(test_input($_POST["actv_type"]));
  $actv_type=0;
  $fromdate=test_input($_POST["fromdate"]);
  $fromtime=test_input($_POST["fromtime"]);
  $todate=test_input($_POST["todate"]);
  $totime=test_input($_POST["totime"]);
  if (strpos($fromdate,"/")==2) {
    $fromdate=str_replace("/","-",$fromdate);
    $todate=str_replace("/","-",$todate);
    $fromdate=substr($fromdate,-4,4)."-".substr($fromdate,3,2)."-".substr($fromdate,0,2);
    $todate=substr($todate,-4,4)."-".substr($todate,3,2)."-".substr($todate,0,2);
  }
  if (isset($_POST["woodbead"])) {$wood='1';} else {$wood='0';}
  if (isset($_POST["special"])) {$spec='1';} else {$spec='0';}
  $costpp=test_input($_POST["cost"]);
  $pr=test_input($_POST["acttypepr"]);
  if ($pr=='') {$pr='';}
  $qbsi=test_input($_POST["acttypeqbsi"]);
  $qbsoa=test_input($_POST["acttypeqbsoa"]);
  $other=test_input($_POST["acttypeother"]);
  $notes=test_input($_POST["notes"]);
  $actvid=$_POST["actvid"];
  $sec='000000000';
  echo 'First big done, now section <br>';
  if (isset($_POST["section"])) {
    $sectn=$_POST["section"];
    foreach ($sectn as $sectype) {
      if ($sectype=='joeys') {$sec[0]='1';}
      if ($sectype=='cubs') {$sec[1]='1';}
      if ($sectype=='scouts') {$sec[2]='1';}
      if ($sectype=='vents') {$sec[3]='1';}
      if ($sectype=='rovers') {$sec[4]='1';}
      if ($sectype=='leaders') {$sec[5]='1';}
      if ($sectype=='family') {$sec[6]='1';}
    }
  }
  $activ="000000000000";
  if (isset($_POST["activs"])) {
    $sectn=$_POST["activs"];
    foreach ($sectn as $sectype) {
      if ($sectype=='swim') {$activ[0]='1';}
      if ($sectype=='pion') {$activ[1]='1';}
      if ($sectype=='arch') {$activ[2]='1';}
      if ($sectype=='cano') {$activ[3]='1';}
      if ($sectype=='bush') {$activ[4]='1';}
      if ($sectype=='4WD0') {$activ[5]='1';}
      if ($sectype=='abse') {$activ[6]='1';}
      if ($sectype=='snor') {$activ[7]='1';}
      if ($sectype=='boat') {$activ[8]='1';}
      if ($sectype=='rock') {$activ[9]='1';}
      if ($sectype=='cavi') {$activ[10]='1';}
    }
  }
}

$uid=$_SESSION['uid'];
$conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
echo 'readying..<br>';
if (isset($_POST["add"])) {
  echo 'into add. <br>';
  $query="INSERT INTO activities (activity_name, activity_type, fromdate, fromtime, todate, totime, section, req_woodbead, req_special, cost, pr, qbsi, qbsoa, other, notes, activs)
  VALUES('$actv_name', '$actv_type', '$fromdate', '$fromtime', '$todate', '$totime', '$sec', '$wood', '$spec', '$costpp','$pr', '$qbsi', '$qbsoa', '$other', '$notes', '$activ')";
//  echo 'rec -'.$recnum.' - adding';
  if (mysqli_query($conaap,$query)) {
    $recnum=mysqli_insert_id($conaap);
    echo "new record";
    $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
    ('Program', 'Add Record', '$actv_name', 'all', 'all', '".$_SESSION['realname']."')";
    $query=mysqli_query($conaap, $sql);
  } else {
    echo "error ".$query." - ".$conaap->error;
  }

  if ($recnum==0) {$recnum=$_POST['actvid'];}
  $querysp="INSERT INTO shareprog (idact, uid, rights) VALUES ($recnum,'$uid',1)";
  echo $querysp."\n";
  if ($query=mysqli_query($conaap, $querysp)) {
    echo $recnum, $uid;
  } else {
    echo "error ".$query." - ".$conaap->error.'<br>';
  }
}
if (isset($_POST["update"])||isset($_POST["update1"])) {
//  echo $site."<br>".$addr1."<br>".$addr2."<br>".$city." ".$state." ".$pcode;
  $query="UPDATE activities SET activity_name='$actv_name', activity_type='$actv_type', fromdate='$fromdate', fromtime='$fromtime', todate='$todate', totime='$totime', section='$sec', req_woodbead='$wood', req_special='$spec', cost='$costpp', pr='$pr', qbsi='$qbsi', qbsoa='$qbsoa', other='$other', notes='$notes', activs='$activ',uid='$uid' WHERE idact='$actvid'";
  if (mysqli_query($conaap,$query)) {
    echo "update record";
    $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
    ('Program', 'Upd Record', '$actv_name', 'all', 'all', '".$_SESSION['realname']."')";
    $query=mysqli_query($conaap, $sql);
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}
//echo "<script>alert('".mysql_real_escape_string($query)."');</script>";
mysqli_close($conaap);
if (isset($_POST["add"])) {
//echo $recnum;
  header("Location:../index.php?pg=actv_edit&id=".$recnum);
  } else {
  header("Location:../index.php?pg=actv");
  }
?>
