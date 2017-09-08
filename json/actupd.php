<?php
//session_start();
// receive POST data - 1st item is activity ID, activ
//                     2nd item is data array, data
function test_input($data) {
  $qt="'";
  $qtr="''";
  $data = str_replace($qt,$qtr,$data);
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//if ($_SESSION['username']!=null) {
  include '../resource/dbinclude.inc';
  $con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  if (!$con) {echo 'access denied<br>';}

  $cldata=array();
  $formd=$_POST['data'];

  $actvid=$actv_name=$actv_type=$fromdate=$fromtime=$todate=$totime=$sectn=$wood=$spec=$costpp=$pr=$qbsi=$qbsoa=$other=$notes=$activ='';

  $uid=$_SESSION['uid'];
  $actvid=$_POST['activ'];
  $actv_name=$formd[1];
  $actv_type=0;
  $fromdate=$formd[2];
  $fromtime=$formd[3];
  $todate=$formd[4];
  $totime=$formd[5];
  if (strpos($fromdate,"/")==2) {
    $fromdate=str_replace("/","-",$fromdate);
    $todate=str_replace("/","-",$todate);
    $fromdate=substr($fromdate,-4,4)."-".substr($fromdate,3,2)."-".substr($fromdate,0,2);
    $todate=substr($todate,-4,4)."-".substr($todate,3,2)."-".substr($todate,0,2);
  }
  $costpp=$formd[6];
  if ($formd[7]=='true') {$wood='1';} else {$wood='0';}
  if ($formd[8]=='true') {$spec='1';} else {$spec='0';}
  $sec='000000000';
  if ($formd[9]=='true') {$sec[0]='1';}
  if ($formd[10]=='true') {$sec[1]='1';}
  if ($formd[11]=='true') {$sec[2]='1';}
  if ($formd[12]=='true') {$sec[3]='1';}
  if ($formd[13]=='true') {$sec[4]='1';}
  if ($formd[14]=='true') {$sec[5]='1';}
  if ($formd[15]=='true') {$sec[6]='1';}
  $pr=$formd[16];
  $qbsi=$formd[17];
  $qbsoa=$formd[18];
  $other=$formd[19];
  $activ="000000000000";
  if ($formd[20]=='true') {$activ[0]='1';}
  if ($formd[21]=='true') {$activ[1]='1';}
  if ($formd[22]=='true') {$activ[2]='1';}
  if ($formd[23]=='true') {$activ[3]='1';}
  if ($formd[24]=='true') {$activ[4]='1';}
  if ($formd[25]=='true') {$activ[5]='1';}
  if ($formd[26]=='true') {$activ[6]='1';}
  if ($formd[27]=='true') {$activ[7]='1';}
  if ($formd[28]=='true') {$activ[8]='1';}
  if ($formd[29]=='true') {$activ[9]='1';}
  if ($formd[30]=='true') {$activ[10]='1';}
  $notes=$formd[31];

  $query="UPDATE activities SET activity_name='$actv_name', activity_type='$actv_type', fromdate='$fromdate', fromtime='$fromtime', todate='$todate', totime='$totime', section='$sec', req_woodbead='$wood', req_special='$spec', cost='$costpp', notes='$notes', pr='$pr', qbsi='$qbsi', qbsoa='$qbsoa', other='$other',  activs='$activ' WHERE idact='$actvid'";
  if (mysqli_query($con,$query)) {
  //  echo "update record";
  } else {
    echo "error ".$query." - ".$con->error;
    $query="error ".$query." - ".$con->error;
  }
  mysqli_close($con);
//} else {
//  $query='[{'.$_SESSION["uid"].':1}]';
//}
//$query="UPDATE activities SET activity_name='$actv_name', activity_type=$actv_type, fromdate=$fromdate, ";//fromtime='$fromtime', todate=$todate, totime='$totime', section='$sec', req_woodbead=$wood, req_special=$spec, cost='$costpp', notes='$notes', pr='$pr', qbsi='$qbsi', qbsoa='$qbsoa', other='$other',  activs='$activ' WHERE idact='$actvid";
echo json_encode($query);
?>
