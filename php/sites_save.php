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
//echo "loaded sites save<br>";
if (isset($_POST["cancel"])) {header("Location:../index.php?pg=site");};
if (isset($_POST["delete"])) {
  $conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  if (!$conaap) {echo 'access denied<br>';}
  $query="DELETE FROM sites WHERE siteid=".$_POST['siteid'];
  if (mysqli_query($conaap,$query)) {
    echo "deleted record";
    $site=test_input($_POST["site"]);
    $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Sites', 'DEL Record', '".$site."', 'all', 'all', '".$_SESSION['realname']."')";
    mysqli_query($conaap, $sql2);
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}
$siteid=$site=$addr1=$addr2=$city=$state=$pcode=$longt=$latt=$maxppl=$timeopen=$timeclose=$cont1n=$cont1p=$cont1e=$cont2n=$cont2p=$cont2e=$cont3n=$cont3p=$cont3e=$costpp=$costtent=$costcabin=$costdorm=$phhosp=$phambl=$phpolc=$phrang=$brnch=$regn=$notes=$map_name=$grid_ref=$near_town=$sitetype='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $site=test_input($_POST["site"]);
  $addr1=test_input($_POST["addr1"]);
  $addr2=test_input($_POST["addr2"]);
  $city=test_input($_POST["city"]);
  $near_town=test_input($_POST["near_town"]);
  $state=test_input($_POST["state"]);
  $pcode=test_input($_POST["pcode"]);
  $longt=test_input($_POST["longt"]);
  $latt=test_input($_POST["latt"]);
  $maxppl=test_input($_POST["maxcamp"]);
  $timeopen=test_input($_POST["timeopen"]);
  $timeclose=test_input($_POST["timeclose"]);
  $cont1n=test_input($_POST["cont1n"]);
  $cont1p=test_input($_POST["cont1p"]);
  $cont1e=test_input($_POST["cont1e"]);
  $cont2n=test_input($_POST["cont2n"]);
  $cont2p=test_input($_POST["cont2p"]);
  $cont2e=test_input($_POST["cont2e"]);
  $cont3n=test_input($_POST["cont3n"]);
  $cont3p=test_input($_POST["cont3p"]);
  $cont3e=test_input($_POST["cont3e"]);
  $costpp=test_input($_POST["costpp"]);
  $costtent=test_input($_POST["costtent"]);
  $costcabin=test_input($_POST["costcabin"]);
  $costdorm=test_input($_POST["costdorm"]);
  $phhosp=test_input($_POST["phhosp"]);
  $phambl=test_input($_POST["phambl"]);
  $phpolc=test_input($_POST["phpolc"]);
  $phrang=test_input($_POST["phrang"]);
  $brnch=test_input($_POST["brnch_name"]);
  $regn=test_input($_POST["regn_name"]);
  $notes=test_input($_POST["notes"]);
  $map_name=test_input($_POST["map_name"]);
  $grid_ref=test_input($_POST["grid_ref"]);
  $siteid=$_POST["siteid"];
  $sitetype=$_POST["sitetype"];
  $acc='0000';
  if (isset($_POST["accom"])) {
    $accom=$_POST["accom"];
    foreach ($accom as $acctype) {
      if ($acctype=='tentb') {$acc[0]='1';}
      if ($acctype=='tents') {$acc[1]='1';}
      if ($acctype=='cabin') {$acc[2]='1';}
      if ($acctype=='dorms') {$acc[3]='1';}
    }
  }
}

$conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
if (isset($_POST["add"])) {
  $query="INSERT INTO sites (site_name, address1, address2, city, contact1_name, contact1_phone, contact1_email, contact2_name, contact2_phone, contact2_email, contact3_name, contact3_phone, contact3_email, longtude, lattude, max_ppl, time_open, time_close, accom, cost, costtent, costcabin, costdorm, ph_hosp, ph_ambl, ph_polc, ph_rang, region, branch, notes, map_name, grid_ref, nearest_town, sitetype)
  VALUES('$site', '$addr1', '$addr2', '$city $state $pcode', '$cont1n', '$cont1p', '$cont1e', '$cont2n', '$cont2p', '$cont2e', '$cont3n', '$cont3p', '$cont3e', '$longt', '$latt','$maxppl','$timeopen','$timeclose','$acc','$costpp','$costtent', '$costcabin', '$costdorm','$phhosp','$phambl','$phpolc','$phrang','$brnch','$regn','$notes','$map_name','grid_ref','$near_town','$sitetype')";
  $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Sites', 'Add Record', '".$site."', 'all', 'all', '".$_SESSION['realname']."')";
  mysqli_query($conaap,$sql2);
  if (mysqli_query($conaap,$query)) {
    echo "new record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}

if (isset($_POST["update"])) {
//  echo $site."<br>".$addr1."<br>".$addr2."<br>".$city." ".$state." ".$pcode;
  $query="UPDATE sites SET site_name='$site', address1='$addr1', address2='$addr2', city='$city $state $pcode', contact1_name='$cont1n', contact1_phone='$cont1p', contact1_email='$cont1e', contact2_name='$cont2n', contact2_phone='$cont2p', contact2_email='$cont2e', contact3_name='$cont3n', contact3_phone='$cont3p', contact3_email='$cont3e', longtude='$longt', lattude='$latt', max_ppl='$maxppl', time_open='$timeopen', time_close='$timeclose', accom='$acc', cost='$costpp', costtent='$costtent', costcabin='$costcabin', costdorm='$costdorm', ph_hosp='$phhosp', ph_ambl='$phambl', ph_polc='$phpolc', ph_rang='$phrang', region='$regn', branch='$brnch', notes='$notes', map_name='$map_name', grid_ref='$grid_ref', nearest_town='$near_town', sitetype='$sitetype' WHERE siteid='$siteid'";
  $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Sites', 'Upd Record', '".$site."', 'all', 'all', '".$_SESSION['realname']."')";
  mysqli_query($conaap,$sql2);
  if (mysqli_query($conaap,$query)) {
    echo "update record";
  } else {
    echo "error ".$query." - ".$conaap->error;
  }
}
//echo ($query);
mysqli_close($conaap);
header("Location:../index.php?pg=site");
?>
