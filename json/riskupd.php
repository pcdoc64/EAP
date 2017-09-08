<?php
//                     1st item is type = S,P,E (Site, Program, Event)
//										 2nd item is partnid=id or site,program or event
//                     3rd item is riskid=riskID number
//										 4th item is read / write (readit) - 0=read, 1=write, 3=delete
//                     5th item is dat= if 0 no data, if 1 data to display risk item
include '../resource/dbinclude.inc';
  // check if session is active
if (!(isset($_SESSION['realname']))) {
  $_SESSION['realname']=', please login';
}

$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$dat=array();
$cldata=array();
$type=$_POST['type'];
$partnid=intval($_POST['partnid']);
$riskid=intval($_POST['riskid']);
$readit=$_POST['readit'];
$dat=$_POST['dat'];

if ($readit=='0') {
  switch ($type) {
    case "P":
      $sql="SELECT a.idrisk,r.risk_name, r.task, r.risk, r.matrix_before, a.matrix_after, a.mitigation, a.refer, a.notes, a.QBSI, a.PR, a.other, a.QBSOA FROM `RiskActV` as a inner join risk as r on a.idrisk=r.idrisk WHERE a.idact=".$partnid." AND a.idrisk=".$riskid;
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Program Risk', 'Add Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "C":
      $sql="SELECT a.idrisk, r.risk_name, r.task, r.risk, r.matrix_before, a.matrix_after, a.mitigation, a.refer, a.notes, a.QBSI, a.PR, a.other, a.QBSOA FROM `RiskAAP` as a inner join risk as r on a.idrisk=r.idrisk WHERE a.idAAP=".$partnid." AND a.idrisk=".$riskid;
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Event Risk', 'Add Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "E":
      $sql="SELECT a.idrisk, r.risk_name, r.task, r.risk, r.matrix_before, a.matrix_after, a.mitigation, a.refer, a.notes, a.QBSI, a.PR, a.other, a.QBSOA FROM `RiskAAP` as a inner join risk as r on a.idrisk=r.idrisk WHERE a.idAAP=".$partnid." AND a.idrisk=".$riskid;
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Event Risk', 'Add Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "S":
      $sql="SELECT a.idrisk, r.risk_name, r.task, r.risk, r.matrix_before, a.matrix_after, a.mitigation, a.refer, a.notes, a.QBSI, a.PR, a.other, a.QBSOA FROM `RiskSite` as a inner join risk as r on a.idrisk=r.idrisk WHERE a.siteid=".$partnid." AND a.idrisk=".$riskid;
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Site Risk', 'Add Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "T":
      $sql="SELECT a.idrisk, r.risk_name, r.task, r.risk, r.matrix_before, a.matrix_after, a.mitigation, a.refer, a.notes, a.QBSI, a.PR, a.other, a.QBSOA FROM `RiskActT` as a inner join risk as r on a.idrisk=r.idrisk WHERE a.idact_type=".$partnid." AND a.idrisk=".$riskid;
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Risk Type', 'Add Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
  }
  $query=mysqli_query($con, $sql);
  $query2=mysqli_query($con, $sql2);

  while($row= mysqli_fetch_assoc($query)) {
    $cldata[]=$row;
  }
} else {
  switch ($type) {
    case "P":
      $sql="UPDATE RiskActV SET matrix_after='".$dat[0]."', mitigation='".$dat[1]."', refer='".$dat[2]."', notes='".$dat[3]."', QBSI='".$dat[4]."', PR='".$dat[5]."', other='".$dat[6]."' WHERE idrisk=".intval($riskid)." AND idact=".intval($partnid);
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Program Risk', 'Upd Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "C":
      $sql="UPDATE RiskAAP SET matrix_after='".$dat[0]."', mitigation='".$dat[1]."', refer='".$dat[2]."', notes='".$dat[3]."', QBSI='".$dat[4]."', PR='".$dat[5]."', other='".$dat[6]."' WHERE idrisk=".intval($riskid)." AND idAAP=".intval($partnid);
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Event Risk', 'Upd Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "E":
      $sql="UPDATE RiskAAP SET matrix_after='".$dat[0]."', mitigation='".$dat[1]."', refer='".$dat[2]."', notes='".$dat[3]."', QBSI='".$dat[4]."', PR='".$dat[5]."', other='".$dat[6]."' WHERE idrisk=".intval($riskid)." AND idAAP=".intval($partnid);
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Event Risk', 'Upd Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "S":
      $sql="UPDATE RiskSite SET matrix_after='".$dat[0]."', mitigation='".$dat[1]."', refer='".$dat[2]."', notes='".$dat[3]."', QBSI='".$dat[4]."', PR='".$dat[5]."', other='".$dat[6]."' WHERE idrisk=".intval($riskid)." AND siteid=".intval($partnid);
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Site Risk', 'Upd Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
    case "T":
      $sql="UPDATE RiskActT SET matrix_after='".$dat[0]."', mitigation='".$dat[1]."', refer='".$dat[2]."', notes='".$dat[3]."', QBSI='".$dat[4]."', PR='".$dat[5]."', other='".$dat[6]."' WHERE idrisk=".intval($riskid)." AND idact_type=".intval($partnid);
      $sql2 ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES ('Risk Type', 'Upd Record', 'all', 'all', 'all', '".$_SESSION['realname']."')";break;
  }
  $query=mysqli_query($con, $sql);
  $query2=mysqli_query($con, $sql2);
}


//$cldata=$data[0][1];
//$cldata='[{'.$type.':1},{'.$riskid.':2},{'.$partnid.':3},{'.$type.':4}]';
echo json_encode($cldata);
?>
