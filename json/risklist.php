<?php
// receive POST data - 1st item is type of query V=activity, T=Act Type, S=site, C=C5 (into)
//                     3rd item is TypeID - ID from V, T, S or C (typeID)
include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
$typet=$_POST['typ'];
$tid=$_POST['typeid'];

switch ($typet) {
	case 'V': //Activity
	  $sql="SELECT idrisk, risk_name FROM risk r WHERE NOT EXISTS (select null from RiskActV t where r.idrisk=t.idrisk and t.idact=".intval($tid).") ORDER BY r.risk_name";
		break;
	case 'T': //Act Type
	  $sql="SELECT idrisk, risk_name FROM risk r WHERE NOT EXISTS (select null from RiskActT t where r.idrisk=t.idrisk and t.idact_type=".intval($tid).") ORDER BY r.risk_name";
		break;
	case 'S': //site
		$sql="SELECT idrisk, risk_name FROM risk r WHERE NOT EXISTS (select null from RiskSite t where r.idrisk=t.idrisk and t.siteid=".intval($tid).") ORDER BY r.risk_name";
		break;
	case 'C': // C5
		$sql="SELECT idrisk, risk_name FROM risk r WHERE NOT EXISTS (select null from RiskAAP t where r.idrisk=t.idrisk and t.idAAP=".intval($tid).") ORDER BY r.risk_name";
		break;
	}
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
