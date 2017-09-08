<?php
include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

$sect=$_POST['sectn'];        // what section did the action occur in - max 15 varchar
$actn=$_POST['actn'];         // what was the action - max 70 varchar
$orgField=$_POST['orgf'];     // what field was changed - varchar 30
$orgVal=$_POST['orgv'];       // original value         - varchar 150
$chngVal=$_POST['chngval'];   // what was the value changed to  - varchar 150
$uid=$_POST['uid'];           // which user did this    - varchar 60


$sql ="INSERT INTO logged (`sectn`, `actn`, `orgfield`, `orgval`, `chngval`, `uid`) VALUES
('".$sect."', '".$actn."', '".$orgField."', '".$orgVal."', '".$chngVal."', '".$uid."')";
$query=mysqli_query($con, $sql);
echo $sql;
 ?>
