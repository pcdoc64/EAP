<?php

include '../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$idct=$_POST['typ'];

$sql="SELECT notes FROM activities WHERE idact=".intval($idct);
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
