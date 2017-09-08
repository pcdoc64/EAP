<?php

$dir = "../../../kids/html/data/admin/files/QBSI/";
$cldata=Array();
//$dir="../../../kids/QBSI/";                       // just for testing, change this before uploading to live server

foreach(scandir($dir) as $key => $value ){
  if (!($value=='.' || $value=='..')) {
    $dirct=$dir.$value;
    if(is_dir($dirct)){
      $dirpos=strpos($value,"-");
      $dirno=substr($value,8,$dirpos-9);
      if ($dirno<10) $dirno='0'.$dirno;
      $dname='DIR'.$dirno;
      $cldum[$dname]=$value;
    }
  }
}
foreach($cldum as $fkey => $fvalue) {
  $dirct=$dir.$fvalue;
//  echo $fkey." - ".$dirct.' \r\n';
  $cldum2=scandir($dirct);
  foreach(scandir($dirct) as $dkey => $dvalue) {
    if (!($dvalue=='.' || $dvalue=='..')) {
      if (!(is_dir($dirct . $dvalue))){
        $dirpos=strpos($dvalue," ");
        $fdvalue=substr($dvalue,$dirpos+1);
        $dirpos=strpos($fdvalue," ");
        $dkey=substr($fdvalue,0,$dirpos);
        if ($dkey<10) $dkey='0'.$dkey;
        $fname=$fkey.'F'.$dkey;
        $cldum[$fname]=$dvalue;
//        echo $fname.' - '.$dvalue.'\n';
      }
    }
  }
}
$cldata=$cldum;

echo json_encode($cldata);
?>
