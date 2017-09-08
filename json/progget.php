<?php
//                     1st item is Activity ID - (activ)
//										 2nd item is Date - (dat)

include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
$activ=$_POST['activ'];
$dat=$_POST['dat'];
$dat=substr($dat,4,4)."-".substr($dat,2,2)."-".substr($dat,0,2);
$sql="SELECT * FROM program WHERE idact=".$activ." AND act_date='".$dat."' ORDER BY act_time ASC, act_type DESC";
if ($query = mysqli_query($con,$sql)) {
	$rowcnt=mysqli_num_rows($query);
  if ($rowcnt>0) {
	  while($row= mysqli_fetch_assoc($query)) {
		  $cldata[]=$row;
	  }
  } else {$cldata[]='[{result:0}]';}
}

//$cldata='[{'.$sql.':1}]';
echo json_encode($cldata);
?>
