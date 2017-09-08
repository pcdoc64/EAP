<?php
ini_set('error_log', 'crapper.txt');
ini_set('log_errors_max_len', 0);
ini_set('log_errors', true);
ini_set('date.timezone','Australia/Brisbane');
ini_set('display_errors', 'On');
include 'resource/dbinclude.inc';
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$sqlAAP = "SELECT idAAP, uid FROM AAP ORDER BY idAAP";
$sqlidact = "SELECT idact, uid FROM activities ORDER BY idact";

$result = mysqli_query($con,$sqlAAP) or die ("error ".$sqlAAP." - ".$con->error."<br>");
$cldata=array();
if ($query = mysqli_query($con,$sqlAAP)) {
	$rowcnt=mysqli_num_rows($query);
  if ($rowcnt>0) {
	  while($row= mysqli_fetch_assoc($query)) {
		  $cldata[]=$row;
	  }
  }
}

$result = mysqli_query($con,$sqlidact) or die ("error ".$sqlidact." - ".$con->error."<br>");
$cldata2=array();
if ($query = mysqli_query($con,$sqlidact)) {
	$rowcnt=mysqli_num_rows($query);
  if ($rowcnt>0) {
	  while($row= mysqli_fetch_assoc($query)) {
		  $cldata2[]=$row;
	  }
  }
}
echo "AAP data\n";
for ($i=0; $i < count($cldata); $i++) {
  $ap=$cldata[$i]['idAAP']; $ui=$cldata[$i]['uid'];
  $query = "INSERT INTO shareevent (idAAP, uid, rights) VALUES ($ap,'$ui','1')";
  if (mysqli_query($con,$query))	{
    echo $ap.' - '.$ui."\n";
  } else {
    echo "error - ".$ap." - ".$ui."\n";
  }
}

echo "Program data\n";
for ($i=0; $i < count($cldata2); $i++) {
  $ap=$cldata2[$i]['idact']; $ui=$cldata2[$i]['uid'];
  $query = "INSERT INTO shareprog (idact, uid, rights) VALUES ($ap,'$ui','1')";
if (mysqli_query($con,$query))	{
    echo $ap.' - '.$ui."\n";
  } else {
    echo "error\n";
  }
}

 ?>
