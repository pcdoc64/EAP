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
$vers=phpversion();

if (isset($_POST["cancel"])) {header("Location:index.php?pg=aap");};

if (isset($_POST["delete"])) {
  $conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  if (!$conaap) {echo 'access denied<br>';}
  $queryact="SELECT activity_name FROM activities WHERE idact=".$_POST["C5_activ"];
  $result= mysqli_query($conaap,$queryact);
  $rowact= mysqli_fetch_array($result,MYSQLI_ASSOC);
  if ($rowact) {
    $query="DELETE FROM AAP WHERE idAAP=".$_POST['idAAP'];
    if (mysqli_query($conaap,$query)) {
      echo "deleted record";
      $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
      ('Event', 'Delete', '".$rowact["activity_name"]."', 'all', 'all', '".$_SESSION['realname']."')";
      $query=mysqli_query($conaap, $sql);
    } else {
      echo "error ".$query." - ".$conaap->error;
    }
    header("Location:../index.php?pg=aap");
  }
}

$site_location=$adacttype=$group=$datefrom=$timefrom=$dateto=$timeto=$nearest_medical=$incharge=$incharge_appt=$incharge_addr=$incharge_phone='';
$joeys=$cubs=$scouts=$vents=$rovers=$leaders=$others=$C4_assemble=$C4_ass_time=$C4_return=$C4_ret_time=$C4_cost=$C4_bring=$safety=$qual=$firstaid='';
$approv_apoint=$approv=$approv_cond=$approv_condit=$napprov_res=$napprov_reason=$require_sub=$approv_name=$approv_apoint=$approv_date=$effectiv_method=$changes=$further_action=$action_detail=$monitor_name=$monitor_appt=$monitor_date='';

//echo var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sec="00000000";
  $joeys=test_input($_POST["C5_joeys"]);if ($joeys=="") {$joeys=0;} else {$sec[0]='1';}
  $cubs=test_input($_POST["C5_cubs"]);if ($cubs=="") {$cubs=0;} else {$sec[1]='1';}
  $scouts=test_input($_POST["C5_scouts"]);if ($scouts=="") {$scouts=0;} else {$sec[2]='1';}
  $vents=test_input($_POST["C5_vents"]);if ($vents=="") {$vents=0;} else {$sec[3]='1';}
  $rovers=test_input($_POST["C5_rovers"]);if ($rovers=="") {$rovers=0;} else {$sec[4]='1';}
  $leaders=test_input($_POST["C5_leaders"]);if ($leaders=="") {$leaders=0;} else {$sec[5]='1';}
  $others=test_input($_POST["C5_others"]);if ($others=="") {$others=0;} else {$sec[6]='1';}

  $C4_section=$sec;
  $siteid=$_POST["siteid"];
  $idact=$_POST["C5_activ"];
  $idacttype=$_POST["C5_type"];
  $site_location=test_input($_POST["C5_locat"]);
  $groupname=test_input($_POST["C5_group"]);
  $datefrom=test_input($_POST["C5_datefrom"]);
  $timefrom=test_input($_POST["C5_timefrom"]);
  $dateto=test_input($_POST["C5_dateto"]);
  $timeto=test_input($_POST["C5_timeto"]);
  if (strpos($datefrom,"/")==2) {
    $datefrom=str_replace("/","-",$datefrom);
    $dateto=str_replace("/","-",$dateto);
    $datefrom=substr($datefrom,-4,4)."-".substr($datefrom,3,2)."-".substr($datefrom,0,2);
    $dateto=substr($dateto,-4,4)."-".substr($dateto,3,2)."-".substr($dateto,0,2);
  }
  $nearest_medical=test_input($_POST["C5_medical"]);
  $incharge=$_POST["C5_incharge"];
  $incharge_appt=$_POST["C5_incharge_appt"];
  $incharge_addr=$_POST["C5_incharge_addr"];
  $incharge_phone=$_POST["C5_incharge_ph"];
  $C4_assemble=$_POST["C4_assemble"];
  $C4_ass_time=$_POST["C4_ass_time"];
  $C4_return=$_POST["C4_return"];
  $C4_ret_time=$_POST["C4_ret_time"];
  $C4_cost=$_POST["C4_cost"];
  $C4_bring=$_POST["C4_bring"];
  if (isset($_POST["F31_safety"])) $safety=test_input($_POST["F31_safety"]);
  if (isset($_POST["F31_firstaid"])) {$firstaid=$_POST["F31_firstaid"];} else {$firstaid=0;}
  if (isset($_POST["F31_qual_leaders"])) {$qual=$_POST["F31_qual_leaders"];} else {$qual=0;}
  $idAAP=$_POST["idAAP"];
//                                                  Need to change from ( ) to [ ] when we get to php 7 or above
  $minar=array('3','3','3','3','3','3','3','3','3','3','3','3');$cmtar=array();
  if (isset($_POST["min"])) {$mins=$_POST["min"];} else {$mins=$minar;}
  if (isset($_POST["cmnt"])) {$cmnt=$_POST["cmnt"];} else {$cmnt=$cmtar;}
  if (isset($_POST["approv"])) {if ($_POST["approv"]=='on') {$approv=1;};} else {$approv=0;}
  if (isset($_POST["approv_cond"])) {if ($_POST["approv_cond"]=='on') {$approv_cond=1;};} else {$approv_cond=0;}
  if (isset($_POST["napprov_res"])) {if ($_POST["napprov_res"]=='on') {$napprov_res=1;};} else {$napprov_res=0;}
  if (isset($_POST["require_sub"])) {if ($_POST["require_sub"]=='on') {$require_sub=1;};} else {$require_sub=0;}
  if (isset($_POST["approv_condit"])) $approv_condit=test_input($_POST["approv_condit"]);
  if (isset($_POST["napprov_reason"])) $napprov_reason=test_input($_POST["napprov_reason"]);
  if (isset($_POST["approv_name"])) $approv_name=test_input($_POST["approv_name"]);
  if (isset($_POST["approv_apoint"])) $approv_apoint=test_input($_POST["approv_apoint"]);
  if (isset($_POST["approv_date"])) $approv_date=test_input($_POST["approv_date"]);if ($approv_date=='' || $approv_date=='0000-00-00') {$approv_date='2017-01-01';}
  if (isset($_POST["effectiv_method"])) {$effectiv_method=$_POST["effectiv_method"];} else {$effectiv_method=0;}
  if (isset($_POST["changes"])) {$changes=$_POST["changes"];} else {$changes=0;}
  if (isset($_POST["further_action"])) {$further_action=$_POST["further_action"];} else {$further_action=0;}
  if (isset($_POST["action_detail"])) $action_detail=test_input($_POST["action_detail"]);
  if (isset($_POST["monitor_name"])) $monitor_name=test_input($_POST["monitor_name"]);
  if (isset($_POST["monitor_appt"])) $monitor_appt=test_input($_POST["monitor_appt"]);
  if (isset($_POST["monitor_date"])) $monitor_date=test_input($_POST["monitor_date"]);if ($monitor_date=='' || $monitor_date=='0000-00-00') {$monitor_date='2017-01-01';}
  $uid=$_SESSION["user"];
}
$conaap = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if (!$conaap) {echo 'access denied<br>';}

$resulteq=mysqli_query($conaap,"SELECT comments FROM F31equip order by idequip");
while ($roweq=mysqli_fetch_array($resulteq)) {$cmnt[]=$roweq[0];}

if (isset($_POST["add"])&& $site_location>"") {
  $query="INSERT INTO `AAP`(`siteid`, `site_location`, `idact`, `idacttype`, `groupname`, `incharge`, `incharge_appt`, `incharge_date`, `incharge_addr1`, `incharge_addr2`, `incharge_phone`, `joeys`, `cubs`, `scouts`, `vents`, `rovers`, `leaders`, `others`, `from_date`, `from_time`, `to_date`, `to_time`, `nearest_medical`, `C4_section`, `C4_activity`, `C4_assemble`, `C4_ass_time`, `C4_return`, `C4_ret_time`, `C4_cost`, `C4_bring`, `F31_safety_officer`, `F31_qual_leaders`, `F31_firstaid_leaders`,`approv`, `approv_cond`, `approv_condit`, `napprov_res`, `napprov_reason`, `require_sub`, `approv_name`, `approv_apoint`, `approv_date`, `effectiv_method`, `changes`, `further_action`, `action_detail`, `monitor_name`, `monitor_appt`, `monitor_date`)
  VALUES ($siteid, '$site_location', '$idact', '$idacttype', '$groupname', '$incharge', '$incharge_appt', '2017-01-01', '$incharge_addr', '.','$incharge_phone', '$joeys', '$cubs', '$scouts', '$vents', '$rovers', '$leaders', '$others', '$datefrom', '$timefrom', '$dateto', '$timeto', '$nearest_medical', '$C4_section','0', '$C4_assemble', '$C4_ass_time', '$C4_return', '$C4_ret_time', '$C4_cost', '$C4_bring', '$safety', '$qual', '$firstaid' , '$approv', '$approv_cond', '$approv_condit', '$napprov_res', '$napprov_reason', '$require_sub', '$approv_name', '$approv_apoint','$approv_date', '$effectiv_method', '$changes', '$further_action', '$action_detail', '$monitor_name', '$monitor_appt', '$monitor_date')";

  if (mysqli_query($conaap,$query)) {
    echo "new record<br>";
    $AAPid=mysqli_insert_id($conaap);
    $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
    ('Event', 'Add Record', '$AAPid', 'all', 'all', '".$_SESSION['realname']."')";
    $query=mysqli_query($conaap, $sql);
  } else {
    echo "error ".$query." - ".$conaap->error.'<br>';
  }

  $queryse="INSERT INTO shareevent (idAAP, uid, rights) VALUES ($AAPid,'$uid',1)";
  if ($query=mysqli_query($conaap, $queryse)) {
    echo $uid;
  } else {
    echo "error ".$query." - ".$conaap->error.'<br>';
  }

  for ($tn=1;$tn<=12;$tn++) {
    $mn=$tn-1;
//    echo $tn. " - ".$mins[$mn]." - ".$cmnt[$mn]."<br>";
    $querya="INSERT INTO AAPequip (idAAP, idequip, req, comments) VALUES ($AAPid, $tn, $mins[$mn], '$cmnt[$mn]')";
    if (mysqli_query($conaap,$querya)) { echo "new equip record <br>";} else {echo "error ".$querya." - ".$conaap->error;}
  }
  $querys="SELECT * from RiskSite where siteid=".$siteid;
  $queryrs = mysqli_query($conaap,$querys);
  while ($rowrs= mysqli_fetch_array($queryrs)) {
    $queryra="INSERT INTO RiskAAP VALUES ($rowrs[0],$AAPid,'$rowrs[2]','$rowrs[3]','$rowrs[4]','$rowrs[5]','$rowrs[6]','$rowrs[7]','$rowrs[8]','$rowrs[9]')";
    if (mysqli_query($conaap,$queryra)) {echo "new idAAP from site record <br>";} else {echo "error ".$queryra." - ".$conaap->error;}
  }
  $querys="SELECT * from RiskActV where idact=".$idact;
  $queryrs = mysqli_query($conaap,$querys);
  while ($rowrs= mysqli_fetch_array($queryrs)) {
    $queryra="INSERT INTO RiskAAP VALUES ($rowrs[0],$AAPid,'$rowrs[2]','$rowrs[3]','$rowrs[4]','$rowrs[5]','$rowrs[6]','$rowrs[7]','$rowrs[8]','$rowrs[9]')";
    if (mysqli_query($conaap,$queryra)) {echo "new idAAP from program record <br>";} else {echo "error ".$queryra." - ".$conaap->error;}
  }
}

if (isset($_POST["update"])) {
  if ($dateto=='0000-00-00') {$dateto='2017-01-01';}
  if ($datefrom=='0000-00-00') {$datefrom='2017-01-01';}
  if ($monitor_date=='0000-00-00') {$monitor_date='2017-01-01';}

  $query="UPDATE AAP SET siteid=$siteid, site_location='$site_location', idact=$idact, idacttype=$idacttype, groupname='$groupname', incharge='$incharge', incharge_appt='$incharge_appt', incharge_date='2017-01-01', incharge_addr1='$incharge_addr', incharge_addr2='', incharge_phone='$incharge_phone', joeys=$joeys, cubs=$cubs, scouts=$scouts, vents=$vents, rovers=$rovers, leaders=$leaders, others=$others,
   from_date='$datefrom', from_time='$timefrom', to_date='$dateto', to_time='$timeto', nearest_medical='$nearest_medical', C4_section='$C4_section', C4_activity='.', C4_assemble='$C4_assemble', C4_ass_time='$C4_ass_time', C4_return='$C4_return', C4_ret_time='$C4_ret_time', C4_cost='$C4_cost', C4_bring='$C4_bring',
   F31_safety_officer='$safety', F31_qual_leaders=$qual, F31_firstaid_leaders=$firstaid, approv=$approv, approv_cond=$approv_cond, approv_condit='$approv_condit', napprov_res=$napprov_res, napprov_reason='$napprov_reason', require_sub=$require_sub, approv_name='$approv_name', approv_apoint='$approv_apoint', approv_date='$approv_date', effectiv_method=$effectiv_method, changes=$changes, further_action=$further_action, action_detail='$action_detail', monitor_name='$monitor_name', monitor_appt='$monitor_appt', monitor_date='$monitor_date'
   WHERE idAAP='$idAAP'";
  if (mysqli_query($conaap,$query)) {
    echo "update record";
    $sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
    ('Event', 'Upd Record', '$siteid', 'all', 'all', '".$_SESSION['realname']."')";
    $query=mysqli_query($conaap, $sql);
  } else {
    echo "error ".$query." - ".$conaap->error;}

  for ($tn=1;$tn<13;$tn++) {
    $mn=$tn-1;
//    echo $tn. " - ".$mins[$tn]." - ".$cmnt[$tn]."<br>";
    $query="UPDATE AAPequip SET req=$mins[$tn], comments='$cmnt[$tn]' WHERE idAAP='$idAAP' AND idequip='$tn'";
    if (mysqli_query($conaap,$query)) { echo "updated equip record"."<br>";} else {echo "error ".$query." - ".$conaap->error;}
  }
}

mysqli_close($conaap);
if (isset($_POST["add"])) {
  if ($site_location>"") {
    header("Location:../index.php?pg=aap_edit&id=".$AAPid);
  } else {
    header("Location:../index.php?pg=aap");  
  }
 } else {
   header("Location:../index.php?pg=aap");
}
?>
