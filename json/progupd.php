<?php
//                     1st item is ActClass - (actid)
//										 2nd item is ProgramID - (typeID)
//										 3rd item is read / write (readid) - 0=read, 1=write, 3=delete
include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
$activ=$_POST['activ'];
$dat=$_POST['dat'];
$dat=substr($dat,4,4)."-".substr($dat,2,2)."-".substr($dat,0,2);
$data=$_POST['data'];
$lined=array();
$sql="DELETE FROM program WHERE idact=".$activ." AND act_date='".$dat."'";
mysqli_query($con, $sql);
for ($i=0;$i<sizeof($data);$i++) {
  $lined=$data[$i];
  $cls=$lined[1];
  for ($k=0;$k<sizeof($cls);$k++) {
    $typ=$cls[$k][0];
    $actv=substr($cls[$k],1);
    if ($typ=="T") {
      $sql ="INSERT INTO program (`idact`, `act_date`, `act_time`, `act_type`, `class`, `location`, `equip`, `tobring`, `leaders`) VALUES (".$activ.", '".$dat."', '".$lined[0]."', '".$typ."', '".$actv."', '".$lined[2]."', '".$lined[3]."', '".$lined[4]."', '".$lined[5]."')";
    } else {
      $sqlr="SELECT * FROM  RiskActT WHERE idact_type=".$actv;
      $resultr=mysqli_query($con,$sqlr);
      while($rowr= mysqli_fetch_array($resultr,MYSQLI_ASSOC)) {
        $checkrec=mysqli_query($con,"SELECT idrisk, idact FROM RiskActV WHERE idrisk=".$rowr['idrisk']." AND idact=".$activ);
        $numrows=mysqli_num_rows($checkrec);
        if ($numrows==0) {
          $sqlt="INSERT INTO `RiskActV`(`idrisk`, `idact`, `matrix_after`, `mitigation`, `refer`, `notes`, `QBSI`, `PR`, `other`, `QBSOA`) VALUES (".$rowr['idrisk'].", ".$activ.", '".$rowr['matrix_after']."', '".$rowr['mitigation']."', ".$rowr['refer'].", '".$rowr['notes']."', '".$rowr['QBSI']."', '".$rowr['PR']."', '".$rowr['other']."', '".$rowr['QBSOA']."')";
          mysqli_query($con, $sqlt);
          $cldata[]='[{'.$sqlt.':1}]';
        }
      }
      $sql ="INSERT INTO program (`idact`, `act_date`, `act_time`, `act_type`, `act_numb`) VALUES (".$activ.", '".$dat."', '".$lined[0]."', '".$typ."', '".$actv."')";
    }

    mysqli_query($con, $sql);
    $cldata[]='[{'.$sql.':1}]';

  }
}

//$cldata='[{'.$sql.':1}]';
echo json_encode($cldata);
?>
