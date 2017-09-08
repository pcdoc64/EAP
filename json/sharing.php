<?php
//                     1st item is ID - either program (V) or Event (C)   - typid
//										 2nd item is type - V=program - C=Event             - typee
//                     3rd item is sende - S= Share, C= Copy              - sende
//										 4th item is uid name of who its being shared with  - lname
//                     5th item is for copy - rename - new name of events - rname
//                     6th item is for sharing - type 0 = copy, 1=master, 2=common, 3=duplicate
include '../resource/dbinclude.inc';
$conaap=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

$typid=$_POST['typid'];
$typee=$_POST['typee'];
$sende=$_POST['sende'];
$lname=$_POST['lname'];
$rname=$_POST['rname'];
$shar=$_POST['shar'];

if ($typee=='V') {  $rlt="";
                    foreach ($lname as $lnamea) {
                      $query="SELECT `activity_name`,`activity_type`,`fromdate`,`fromtime`,`todate`,`totime`,`section`,`req_woodbead`,`req_special`,`cost`,`notes`,`pr`,`qbsi`,`qbsoa`,`other`,`activs` FROM `activities` WHERE `idact`=".$typid;
                      $result=mysqli_query($conaap,$query);
                      $row=$result->fetch_row();

                      $row[16]=$lnamea;
  		                if ($sende=='C') {$row[0]=$rname;}
                      $recnum=0;
                      if ($sende=='C' || $shar=='3') {
                        $query2="INSERT INTO activities (`activity_name`,`activity_type`,`fromdate`,`fromtime`,`todate`,`totime`,`section`,`req_woodbead`,`req_special`,`cost`,`notes`,`pr`,`qbsi`,`qbsoa`,`other`,`activs`) VALUES ('";
                        if ($rname>"") {
                          $query2.=$rname;
                        } else {
                          $query2.=$row[0];
                        }
                        $query2.="',".$row[1].",'".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."',".$row[7].",".$row[8].",'".$row[9]."','".$row[10]."','".$row[11]."','".$row[12]."','".$row[13]."','".$row[14]."','".$row[15]."')";
                        if ($conaap->query($query2) === TRUE) {$rlt= "New record created successfully";$recnum=mysqli_insert_id($conaap);} else {$rlt=$query2." failed";}
                      }
                      if ($recnum==0) {$recnum=$typid;}
                      if ($shar=='2'||$shar=='3') {$rights=1;} else {$rights=0;}

                      $querysp="INSERT INTO shareprog (idact, uid, rights) VALUES ($recnum,'$lnamea',$rights)";
  //                    echo $querysp."\n";
                      if ($query=mysqli_query($conaap, $querysp)) {
  //                      echo $recnum, $uid;
                      } else {
                        $rlt.= "error ".$query." - ".$conaap->error."/n";
                      }

                      $tst1=$row[0];
                      $tst2=$row[1];
                      if ($sende=='C' || $shar=='3') {
                        $query="SELECT * FROM RiskActV WHERE idact=".$typid;
                        $result=mysqli_query($conaap,$query);
                        $cnti=mysqli_num_rows($result);
                        if ($cnti>0) {
                          while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            $querya="INSERT INTO RiskActV (`idrisk`,`idact`,`matrix_after`,`mitigation`,`refer`,`notes`,`QBSI`,`PR`,`other`)
                            VALUES (".$row['idrisk'].",".$recnum.",'".$row['matrix_after']."','".$row['mitigation']."',".$row['refer'].",'".$row['notes']."','".$row['QBSI']."','".$row['PR']."','".$row['other']."')";
                            if ($conaap->query($querya) === TRUE) {$rlt.= "<br>New Risk - Prog (RiskActV) record created successfully<br>";} else {$rlt.='<br>RiskActv record fail';}
                        } }
                        $queryb="SELECT * FROM program WHERE idact=".$typid;
                        $resultb=mysqli_query($conaap,$queryb);
                        $cnti=mysqli_num_rows($resultb);
                        if ($cnti>0) {
                          while($row= mysqli_fetch_array($resultb,MYSQLI_ASSOC)) {
                            $queryab="INSERT INTO program (`idact`, `act_date`, `act_time`, `act_type`, `class`, `act_numb`, `location`, `equip`, `tobring`, `leaders`)
                            VALUES (".$recnum.",'".$row['act_date']."','".$row['act_time']."','".$row['act_type']."','".$row['class']."',".$row['act_numb'].",'".$row['location']."','".$row['equip']."','".$row['tobring']."','".$row['leaders']."')";
                            if ($conaap->query($queryab) === TRUE) {$rlt.= "\nNew Program timeline (program) record created successfully\n";} else {$rlt.="\nprogram record fail";}
                        } }
                    } }
                }
if ($typee=='C') {  $rlt="";
                    foreach ($lname as $lnamea) {
                      $query="SELECT `siteid`,`site_location`,`idact`,`idacttype`,`groupname`,`incharge`,`incharge_appt`,`incharge_date`,`incharge_addr1`,`incharge_addr2`,`incharge_phone`,`joeys`,`cubs`,`scouts`,`vents`,`rovers`,`leaders`,`others`,`from_date`,`from_time`,`to_date`,`to_time`,`nearest_medical`,`C4_section`, `C4_activity`,`C4_assemble`,`C4_ass_time`,`C4_return`,`C4_ret_time`,`C4_cost`,`C4_bring`,`F31_safety_officer`,`F31_qual_leaders`,`F31_firstaid_leaders`,`approv`,`approv_cond`,`approv_condit`,`napprov_res`,`napprov_reason`,`require_sub`,`approv_name`,`approv_apoint`,`approv_date`,`effectiv_method`,`changes`,`further_action`,`action_detail`,`monitor_name`,`monitor_appt`,`monitor_date` FROM `AAP` WHERE idAAP=".$typid;
                      $result=mysqli_query($conaap,$query);
                      $row=$result->fetch_row();
              		    $row[34]=$lnamea;
              		    if ($row[43]=="" || $row[43]=="0000-00-00") {$row[43]='2099-09-09';}
              		    $row[7]='2017-01-01';
            //		    $rlt='record = '.$row[34].'-'.$rname;
                      if ($sende=='C' || $shar=='3') {
                        $row[18]=$rname;
                        $query="INSERT INTO AAP (`siteid`,`site_location`,`idact`,`idacttype`,`groupname`,`incharge`,`incharge_appt`,`incharge_date`,`incharge_addr1`,`incharge_addr2`,`incharge_phone`,`joeys`,`cubs`,`scouts`,`vents`,`rovers`,`leaders`,`others`,`from_date`,`from_time`,`to_date`,`to_time`,`nearest_medical`,`C4_section`, `C4_activity`,`C4_assemble`,`C4_ass_time`,`C4_return`,`C4_ret_time`,`C4_cost`,`C4_bring`,`F31_safety_officer`,`F31_qual_leaders`,`F31_firstaid_leaders`,`approv`,`approv_cond`,`approv_condit`,`napprov_res`,`napprov_reason`,`require_sub`,`approv_name`,`approv_apoint`,`approv_date`,`effectiv_method`,`changes`,`further_action`,`action_detail`,`monitor_name`,`monitor_appt`,`monitor_date`) VALUES (".$row[0].",'".$row[1]."',".$row[2].",".$row[3].",'".$row[4]."','".$row[5]."','".$row[6]."','".$row[7]."','".$row[8]."','".$row[9]."','".$row[10]."',".$row[11].",".$row[12].",".$row[13].",".$row[14].",".$row[15].",".$row[16].",".$row[17].",'".$row[18]."','".$row[19]."','".$row[20]."','".$row[21]."','".$row[22]."','".$row[23]."',".$row[24].",'".$row[25]."','".$row[26]."','".$row[27]."','".$row[28]."','".$row[29]."','".$row[30]."','".$row[31]."',".$row[32].",".$row[33].",'".$row[34]."',".$row[36].",'".$row[37]."',".$row[38].",'".$row[39]."',".$row[40].",'".$row[41]."','".$row[42]."','".$row[43]."',".$row[44].",".$row[45].",".$row[46].",'".$row[47]."','".$row[48]."','".$row[49]."','".$row[50]."')";
                        $rlt=$query;
                        if ($conaap->query($query) === TRUE) {
                          $rlt.= "New record created successfully";
                          $recnum=mysqli_insert_id($conaap);
                        } else {
                          $rlt.="fail\n";
                            $recnum=0;
                        }

                        $query="SELECT * FROM AAPequip WHERE idAAP=".$typid;
                        $result=mysqli_query($conaap,$query);
                        $cnti=mysqli_num_rows($result);
                        if ($cnti>0) {
                          while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            $querya="INSERT INTO AAPequip (`idAAP`,`idequip`,`req`,`comments`) VALUES (".$recnum.",".$row['idequip'].",".$row['req'].",'".$row['comments']."')";
                            if ($conaap->query($querya) === TRUE) {$rlt.= "<br>New AAP equip (AAPequip) record created successfully<br>";}
                        } }
                        $query="SELECT * FROM RiskAAP WHERE idAAP=".$typid;
                        $result=mysqli_query($conaap,$query);
                        $cnti=mysqli_num_rows($result);
                        if ($cnti>0) {
                          while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            $querya="INSERT INTO RiskAAP (`idrisk`,`idact`,`matrix_after`,`mitigation`,`refer`,`notes`,`QBSI`,`PR`,`other`) VALUES (".$row['idrisk'].",".$recnum.",'".$row['matrix_after']."','".$row['mitigation']."',".$row['refer'].",'".$row['QBSI']."','".$row['other']."')";
                            if ($conaap->query($querya) === TRUE) {$rlt.= "<br>New Risk-AAP (RiskAAP) record created successfully<br>";}
                        } }
                      }
                      if ($recnum==0) {$recnum=$typid;}
                      if ($shar=='2'||$shar=='3') {$rights=1;} else {$rights=0;}

                      $querysp="INSERT INTO shareevent (idAAP, uid, rights) VALUES ($recnum,'$lnamea',$rights)";
  //                    echo $querysp."\n";
                      if ($query=mysqli_query($conaap, $querysp)) {
  //                      echo $recnum, $uid;
                      } else {
                        $rlt.= "error ".$query." - ".$conaap->error."/n";
                      }
                    }
                  }


//echo json_encode($rlt);
//echo json_encode($query2);
echo json_encode($typid);
?>
