<?php

//                     item is ActVID - (typeID)
include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
$tid=$_POST['typeid'];

$sql="SELECT idact_type, act_name FROM act_class v WHERE NOT EXISTS (select null from acttypelist t where v.idact_type=t.idact_type and t.idact=".intval($tid).") ORDER BY v.act_name";
//	echo $sql;
if ($query = mysqli_query($con,$sql)) {
	$rowcnt=mysqli_num_rows($query);
//	echo 'rows '.$rowcnt;
	while($row= mysqli_fetch_assoc($query)) {
		$cldata[]=$row;
	}
	mysqli_free_result($query);
} else {
				// Check connection
	if (mysqli_connect_errno())	{
		echo "Failed to connect to MySQL " . mysqli_connect_error();
	};
}

echo json_encode($cldata);

?>
