<?php
//                     1st item is ActiVid - (actid)
//										 2nd item is ActTypeid - (typeID)
//										 3rd item is read / write (readid) - 0=read, 1=write, 2, update, 3=delete
include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
$aid=$_POST['id'];
$tid=$_POST['name'];
$rd=$_POST['pst'];

		if ( $rd=='0') {	$sql="SELECT * FROM RiskType ORDER BY risk_type";}
		if ( $rd=='1') {	$sql="INSERT INTO RiskType (risk_type) VALUES ('".$tid."')";}
		if ( $rd=='2') {	$sql="UPDATE RiskType SET risk_type='".$tid."' WHERE idTypeE=".intval($aid);}
		if ( $rd=='3') {  $sql="DELETE FROM RiskType WHERE idTypeE=".$aid." AND risk_type=".$tid;}
//	 echo $sql;
		if ($rd==0) {
			if ($query = mysqli_query($con,$sql)) {
				$rowcnt=mysqli_num_rows($query);
				//	echo 'rows '.$rowcnt;
				while($row= mysqli_fetch_assoc($query)) {
					$cldata[]=$row;
				}
				//	$cldata=array('clnts'=>$cldata);
			} else {
				// Check connection
				if (mysqli_connect_errno())	{
					echo "Failed to connect to MySQL " . mysqli_connect_error();
				};
			}
			mysqli_free_result($query);
		} else {
			$query = mysqli_query($con,$sql);
			$cldata='[{'.$sql.':1}]';
//			$cldata='[{"a":1}]';
		}
	echo json_encode($cldata);

?>
