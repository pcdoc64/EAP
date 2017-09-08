<?php
//                     1st item is Type - (typ) - C = C5
//										 2nd item is item ID - (typeID)

include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
$typs=$_POST['typ'];
$tid=$_POST['siteid'];

	$sql="SELECT site_name, address1, address2, city, max_ppl, cost, ph_hosp, district, region, branch FROM sites WHERE siteid=".intval($tid);
	if ($query = mysqli_query($con,$sql)) {
		$rowcnt=mysqli_num_rows($query);
		//	echo 'rows '.$rowcnt;
		while($row= mysqli_fetch_assoc($query)) {
			$cldata[]=$row;
		}
	} else {
			// Check connection
		if (mysqli_connect_errno())	{
			echo "Failed to connect to MySQL " . mysqli_connect_error();
		};
	}
	mysqli_free_result($query);
	echo json_encode($cldata);

?>
