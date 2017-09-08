<?php
// receive POST data - 1st item is number for 1=country, 2=branch, 3=region (type)
//                     2nd item is id for branch / region (id)
//                     3rd item is name (name)
//                     4th is 0 for read, 1 for update, 2 for new (pst)
include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
//$sql="SELECT * FROM branch WHERE idCountry=".intval($_POST['id']);
$typet=$_POST['type'];
$pstt=$_POST['pst'];

switch ($typet) {
	case '1': //country
		break;
	case '2': //branch
	  if ( $pstt=='0') {	$sql="SELECT * FROM branch WHERE idCountry=".intval($_POST['id']);}
		if ( $pstt=='1') {	$sql="UPDATE branch SET branch='".$_POST['name']."' WHERE idbranch=".intval($_POST['id']);}
		if ( $pstt=='2') {	$sql="INSERT INTO branch (branch, idCountry) VALUES ('".$_POST['name']."',".intval($_POST['id']).")";}
		break;
	case '3': //region
		if ( $pstt=='0') {$sql="SELECT * FROM region WHERE idbranch=".intval($_POST['id'])." ORDER BY region";}
		if ( $pstt=='1') {$sql="UPDATE region SET region='".$_POST['name']."' WHERE idregion=".intval($_POST['id']);}
		if ( $pstt=='2') {$sql="INSERT INTO region (region, idbranch) VALUES ('".$_POST['name']."',".intval($_POST['id']).")";}
		break;
	case '4': //district
		break;
}
//	 echo $sql;
		if ($pstt==0) {
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
			$cldata='[{"a":1}]';
		}
	echo json_encode($cldata);

?>
