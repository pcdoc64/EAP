<?php
// receive POST data - 1st item is type of query V=activity, T=Act Type, S=site, C=C5 (into)
//                     2nd item is RiskID (riskid)
//                     3rd item is TypeID - ID from V, T, S or C (typeID)
//										 4th is siteid
//										 5th is AAPid
//                     6th is 0 for read, 1 for insert, 3 for delete (readit)
//										 7th is for risk name (name)
include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$cldata=array();
//$sql="SELECT * FROM branch WHERE idCountry=".intval($_POST['id']);
$typet=$_POST['into'];
$rid=$_POST['riskid'];
$tid=$_POST['typeid'];
$sid=$_POST['siteid'];
$cid=$_POST['AAPid'];
$rd=$_POST['readit'];
$nm=$_POST['name'];
//echo ($typet."-".$rid."-".$tid."-".$rd."-".$nm);
switch ($typet) {
	case 'V': //Program
		if ( $rd=='0') {	$sql="SELECT risk.risk_name, risk.task, risk.risk, risk.matrix_before, risk.idrisk, risk.typeE, RT.risk_type, risk.refer, RV.idrisk, RV.matrix_after, RV.mitigation, RV.idact FROM RiskActV AS RV INNER JOIN risk ON RV.idrisk=risk.idrisk INNER JOIN RiskType AS RT ON risk.typeE=RT.idTypeE WHERE RV.idact=".intval($tid)." ORDER by risk.risk_name";}
		if ( $rd=='1') {
										$sqlq="SELECT idrisk, matrix_before, matrix_after, mitigation, refer, notes, QBSI, PR, other FROM risk WHERE idrisk=".intval($rid);
										$queryq = mysqli_query($con,$sqlq);
										$rowq= mysqli_fetch_assoc($queryq);
										$sqlT="SELECT idact, pr, qbsi FROM activities WHERE idact=".intval($tid);
										$queryT = mysqli_query($con,$sqlT);
										$rowT= mysqli_fetch_assoc($queryT);
// *****  					echo ("q -".$rowq["QBSI"]." - p -".$rowq["PR"]." riskid -".$rid." typeid -".$tid);
										if (strlen($rowT["qbsi"])==0){$TQBSI=$rowq["QBSI"];} else {$TQBSI=$rowT["qbsi"].", ".$rowq["QBSI"];}
										if (strlen($rowT["pr"])==0) {$TPR=$rowq["PR"];} else {$TPR=$rowT["pr"].", ".$rowq["PR"];}
										$sqlT="UPDATE act_class SET pr='".$TPR."', qbsi='".$TQBSI."' WHERE idact=".intval($tid);
										$queryT = mysqli_query($con,$sqlT);
										$arrT=array();
										$arrT=array('qbsi'=>$TQBSI,'pr'=>$TPR);
//										$arrT[]=['pr'=>$TPR];
										$cldata=$arrT;
//***** 							echo json_encode("[{'qbsi':'".$TQBSI."', 'pr':'".$TPR."'}]");
										$sql="INSERT INTO RiskActV (idrisk, idact, matrix_after, mitigation, refer, notes, QBSI, PR, other) VALUES ('".$rid."', '".$tid."', '".$rowq['matrix_after']."', '".$rowq['mitigation']."', '".$rowq['refer']."', '".$rowq['notes']."', '".$rowq['QBSI']."', '".$rowq['PR']."', '".$rowq['other']."')";
									}
		if ( $rd=='3') {  $sql="DELETE FROM RiskActV WHERE idrisk=".$rid." AND idact=".$tid;}
		break;
	case 'T': //Act Type
	  if ( $rd=='0') {$sql="SELECT risk.idrisk, RiskActT.idrisk, RiskActT.idact_type, risk.risk_name, risk.matrix_before, risk.QBSI, risk.PR, risk.other FROM RiskActT INNER JOIN risk ON RiskActT.idrisk=risk.idrisk WHERE RiskActT.idact_type=".intval($tid)." ORDER BY risk.risk_name";}
		if ( $rd=='1') {$sqlq="SELECT idrisk, matrix_after, mitigation, refer, notes, QBSI, PR, other FROM risk WHERE idrisk=".intval($rid);
										$queryq = mysqli_query($con,$sqlq);
										$rowq= mysqli_fetch_assoc($queryq);
										$sqlT="SELECT idact_type, pr, qbsi FROM act_class WHERE idact_type=".intval($tid);
										$queryT = mysqli_query($con,$sqlT);
										$rowT= mysqli_fetch_assoc($queryT);
// ***										echo ("q -".$rowq["QBSI"]." - p -".$rowq["PR"]." riskid -".$rid." typeid -".$tid);
										if (strlen($rowT["qbsi"])==0){$TQBSI=$rowq["QBSI"];} else {$TQBSI=$rowT["qbsi"].", ".$rowq["QBSI"];}
										if (strlen($rowT["pr"])==0) {$TPR=$rowq["PR"];} else {$TPR=$rowT["pr"].", ".$rowq["PR"];}
										$sqlT="UPDATE act_class SET pr='".$TPR."', qbsi='".$TQBSI."' WHERE idact_type=".intval($tid);
										$queryT = mysqli_query($con,$sqlT);
										$arrT=array();
										$arrT=array('qbsi'=>$TQBSI,'pr'=>$TPR);
//										$arrT[]=['pr'=>$TPR];
										$cldata=$arrT;
//*****								echo json_encode("[{'qbsi':'".$TQBSI."', 'pr':'".$TPR."'}]");
										$sql="INSERT INTO RiskActT (idrisk, idact_type, matrix_after, mitigation, refer, notes, QBSI, PR, other) VALUES ('".$rid."', '".$tid."', '".$rowq['matrix_after']."', '".$rowq['mitigation']."', '".$rowq['refer']."', '".$rowq['notes']."', '".$rowq['QBSI']."', '".$rowq['PR']."', '".$rowq['other']."')";
										}
		if ( $rd=='3') {  $sql="DELETE FROM RiskActT WHERE idrisk=".$rid." AND idact_type=".$tid;}
		break;
	case 'S': //site
if ( $rd=='0') {	$sql="SELECT risk.idrisk, RiskSite.idrisk, RiskSite.siteid, risk.risk_name, risk.task, risk.risk, risk.matrix_before, risk.matrix_after, RiskType.risk_type, risk.QBSI, risk.PR, risk.other FROM RiskSite INNER JOIN risk ON RiskSite.idrisk=risk.idrisk INNER JOIN RiskType ON risk.typeE=RiskType.idTypeE WHERE RiskSite.siteid=".intval($sid)." ORDER BY risk.risk_name";}
	if ( $rd=='1') {$sqlq="SELECT idrisk, matrix_after, mitigation, refer, notes, QBSI, PR, other FROM risk WHERE idrisk=".intval($rid);
									$queryq = mysqli_query($con,$sqlq);
									$rowq= mysqli_fetch_assoc($queryq);
									$sqlT="SELECT idact_type, pr, qbsi FROM act_class WHERE idact_type=".intval($tid);
									$queryT = mysqli_query($con,$sqlT);
									$rowT= mysqli_fetch_assoc($queryT);
									if (strlen($rowT["qbsi"])==0){$TQBSI=$rowq["QBSI"];} else {$TQBSI=$rowT["qbsi"].", ".$rowq["QBSI"];}
									if (strlen($rowT["pr"])==0) {$TPR=$rowq["PR"];} else {$TPR=$rowT["pr"].", ".$rowq["PR"];}
									$arrT=array();
									$arrT=array('qbsi'=>$TQBSI,'pr'=>$TPR);
									$cldata=$arrT;
									$sql="INSERT INTO RiskSite (idrisk, siteid, matrix_after, mitigation, refer, notes, QBSI, PR, other) VALUES ('".$rid."', '".$sid."', '".$rowq['matrix_after']."', '".$rowq['mitigation']."', '".$rowq['refer']."', '".$rowq['notes']."', '".$rowq['QBSI']."', '".$rowq['PR']."', '".$rowq['other']."')";
								}
	if ( $rd=='3') {  $sql="DELETE FROM RiskSite WHERE idrisk=".$rid." AND siteid=".$sid;}
	break;
	case 'C': // Event
//		if ( $rd=='0') {$sql="SELECT * FROM risk WHERE risk.idrisk in (SELECT idrisk FROM RiskAAP where idAAP=".intval($cid).") UNION SELECT * FROM risk WHERE risk.idrisk in (select idrisk from RiskSite WHERE siteid=".intval($sid).") UNION SELECT * FROM risk WHERE risk.idrisk in (select idrisk from RiskActV where idact=".intval($tid).") order by risk_name";}
//			SELECT * FROM risk INNER JOIN RiskType ON risk.typeE=RiskType.idTypeE WHERE risk.idrisk IN (SELECT idrisk FROM RiskAAP WHERE idAAP=".intval($cid).") ORDER BY risk.risk_name";}
		if ( $rd=='0') {	$sql="SELECT * FROM risk INNER JOIN RiskType ON risk.typeE=RiskType.idTypeE WHERE risk.idrisk IN (SELECT idrisk FROM RiskActV WHERE idact=".intval($tid)." UNION DISTINCT SELECT idrisk FROM RiskAAP WHERE idAAP=".intval($cid)." UNION DISTINCT SELECT idrisk FROM RiskSite WHERE siteid=".intval($sid).") ORDER BY risk.risk_name";}
//	echo $sql;
		if ( $rd=='1') {$sqlq="SELECT idrisk, matrix_after, mitigation, refer, notes, QBSI, PR, other FROM risk WHERE idrisk=".intval($rid);
									$queryq = mysqli_query($con,$sqlq);
									$rowq= mysqli_fetch_assoc($queryq);
									$sqlT="SELECT idact_type, pr, qbsi FROM act_class WHERE idact_type=".intval($tid);
									$queryT = mysqli_query($con,$sqlT);
									$rowT= mysqli_fetch_assoc($queryT);
									if (strlen($rowT["qbsi"])==0){$TQBSI=$rowq["QBSI"];} else {$TQBSI=$rowT["qbsi"].", ".$rowq["QBSI"];}
									if (strlen($rowT["pr"])==0) {$TPR=$rowq["PR"];} else {$TPR=$rowT["pr"].", ".$rowq["PR"];}
									$arrT=array();
									$arrT=array('qbsi'=>$TQBSI,'pr'=>$TPR);
									$cldata=$arrT;
									$sql="INSERT INTO RiskAAP (idrisk, idAAP, matrix_after, mitigation, refer, notes, QBSI, PR, other) VALUES ('".$rid."', '".$cid."', '".$rowq['matrix_after']."', '".$rowq['mitigation']."', '".$rowq['refer']."', '".$rowq['notes']."', '".$rowq['QBSI']."', '".$rowq['PR']."', '".$rowq['other']."')";
									$sql1="INSERT INTO RiskEvent (idrisk, idAAP, matrix_after, mitigation, refer, notes, QBSI, PR, other) VALUES ('".$rid."', '".$cid."', '".$rowq['matrix_after']."', '".$rowq['mitigation']."', '".$rowq['refer']."', '".$rowq['notes']."', '".$rowq['QBSI']."', '".$rowq['PR']."', '".$rowq['other']."')";
//									echo $sql;
								}
	if ( $rd=='3') {  $sql="DELETE FROM RiskAAP WHERE idrisk=".$rid." AND idAAP=".$cid;
										$sqlv="DELETE FROM RiskActV WHERE idrisk=".$rid." AND idact=".$tid;
										$sqls="DELETE FROM RiskSite WHERE idrisk=".$rid." AND switeid=".$sid;
									}
	break;
}
//	 echo $sql;
		if ($rd==0) {
			If ($typet=='V' || $typet=='T' || $typet=='S') {
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
			}
			If ($typet=='C') {
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
			}
			mysqli_free_result($query);
		} else {
			$query = mysqli_query($con,$sql);
			if ($typet=='C') {$query = mysqli_query($con,$sql1);}
			if (mysqli_connect_errno())	{
				echo "Failed to connect to MySQL " . mysqli_connect_error();}

			if ($rd==3) {
				If ($typet=='C') {
					$query = mysqli_query($con,$sqlv);
					$query = mysqli_query($con,$sqls);
				}
				$cldata="";
//				$cldata='[{"a":1}]';
			}
		}
	echo json_encode($cldata);


?>
