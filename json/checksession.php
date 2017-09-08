<?php
session_start();

$cldata='[{"a":1}]';
$rqst=$_POST["req"];

if (isset($_SESSION[$rqst])) {
    // return requested value
    $cldata=$_SESSION[$rqst];

} else {
    // nothing requested, so return all values
    $cldata='sess';

}

echo json_encode($cldata);
?>
