<?php


$pdf->SetMargins(9,10);
$pdf->SetFont('Times','',14);
$w = $pdf->GetPageWidth()-18;
$h = $pdf->GetPageHeight()-15;
$pdf->AddPage('P');


// Header -------------------------------------------------------------------------------------
$pdf->Image('../../resource/scout_logo.gif',12,7,12);
// Calculate width of title and position
$pdf->SetLineWidth(0.5);
$pdf->Rect(9,7,$w,20);
$head1="The Scout Association of Australia, Queensland Branch Inc.";
$head2="ACTIVITY ADVICE and APPROVAL";
$hw1=$pdf->GetStringWidth($head1)+3;
$hw2=$pdf->GetStringWidth($head2)+3;
$pdf->SetFont('Times','B',12);
$pdf->SetXY(($w-$hw1)/2,8);
$pdf->Cell($hw1,5,$head1,0,0,'C',false);
$pdf->SetFont('Times','',11);
$pdf->SetXY(170,8);
$pdf->MultiCell(0,6,"Form:    C5\nIssue:     8\nDate:     12/13",'','L',0);
$pdf->SetFont('Times','B',14);
$pdf->SetXY(($w-$hw2)/2,16);
$pdf->Cell($hw2,9,$head2,0,0,'C',false);
//		main ---------------------------------------------------------------------------------
$nw=28;$na=10;$nb=46;
$pdf->SetFont('Times','',13);
$note='ADVICE OF ACTIVITY';
$pdf->SetXY(($nw),28);
$pdf->Cell(100,5,$note,0,0,'L',false);
$note='APPROVAL';
$pdf->SetXY(($nw),190);
$pdf->Cell(100,5,$note,0,0,'L',false);
$note='NOTIFICATION TO BRANCH SUPPORT OFFICE';
$pdf->SetXY(($nw),264);
$pdf->Cell(100,5,$note,0,0,'L',false);
$pdf->SetFont('Times','',10);
$pdf->SetXY(($na),35);
$pdf->MultiCell(0,3,"1. Members\n     involved\n(indicate numbers)");
$pdf->SetFont('Times','',11);
$pdf->SetXY(43,35);
$pdf->Cell(55,4,"Group",0,0,'C');
$pdf->SetXY(120,35);
$pdf->Cell(40,4,"District");
$pdf->SetXY(168,35);
$pdf->Cell(40,4,"Region");
$pdf->SetXY(43,52);
$pdf->Cell(40,4,"Joey Scouts");
$pdf->SetXY(65,52);
$pdf->Cell(40,4,"Cub Scouts");
$pdf->SetXY(90,52);
$pdf->Cell(40,4,"Scouts");
$pdf->SetXY(114,52);
$pdf->Cell(42,4,"Venturers");
$pdf->SetXY(142,52);
$pdf->Cell(43,4,"Rovers");
$pdf->SetXY(166,52);
$pdf->Cell(40,4,"Leaders");
$pdf->SetXY(187,52);
$pdf->Cell(40,4,"Others");
$pdf->SetFont('Times','',10);
$pdf->SetXY(($na),74);
$pdf->Cell(40,4,"2. Type of Activity");
$pdf->SetXY(($na),81);
$pdf->Cell(40,4,"3. Activity Site");
$pdf->SetFont('Times','',11);
$pdf->SetXY(($nb),83);
$pdf->MultiCell(0,6,"a. Name of Site ........................................................................................\nb. Location of Site....................................................................................\nc. Map Name ............................................................................................\nd. Grid Reference .....................................................................................\ne. Scout District ........................................................................................\nf. Nearest Town ........................................................................................");
$pdf->SetFont('Times','',10);
$pdf->SetXY(($na),123);
$pdf->Cell(40,4,"4. Period Involved");
$pdf->SetXY(44,125);
$pdf->SetFont('Times','',11);
$pdf->Cell(40,4,"From: ..............................................................      To: ..............................................................");
$pdf->SetFont('Times','',10);
$pdf->SetXY(58,128);
$pdf->Cell(40,4,"(Time and Date)                                                               (Time and Date)");
$pdf->SetXY(($na),134);
$pdf->MultiCell(0,3,"5. Name and Address of Nearest Medical Help\n (Doctor or Hospital)");
$pdf->SetXY(95,136);
$pdf->Cell(40,4,"...................................................................................................................");
$pdf->SetXY(($na),146);
$pdf->MultiCell(0,3,"6. Person in Charge\n  of Activity");
$pdf->SetXY(($nb),146);
$pdf->MultiCell(0,3,"I acknowledge that I am responsible to ensure that this activity is conducted in accordance with the Policy & Rules of Scouts Australia (P&R), Queensland Branch Scouting Instructions (QBSI), State and Local Government Regulations.");
$pdf->SetFont('Times','',11);
$pdf->SetXY(($nb),160);
$pdf->MultiCell(0,7,"Name: ......................................................                   Appointment: ..................................\n\nSignature: .................................................                  Date: ...................................................\nAddress: .....................................................                Telephone: (........).................................");
$pdf->SetFont('Times','',10);
$pdf->SetXY(($na),196);
$pdf->Cell(40,4,"Activity Approval");
$pdf->SetXY(($nb),196);
$pdf->MultiCell(0,3,"I am satisfied that this proposed activity is planned in accordance with P&R, QBSI, State and Local Government Regulations. The activity is'APPROVED / NOT APPROVED; (*delete one)\n(Refer QBSI Section 2.9)");
$pdf->SetFont('Times','',11);
$pdf->SetXY(($nb),212);
$pdf->MultiCell(0,7,"Name: ......................................................                   Appointment: ..................................\n\nSignature: .................................................                Telephone: (........).................................");
$pdf->SetFont('Times','',10);
$pdf->SetXY(($na),235);
$pdf->Cell(40,4,"Advice");
$pdf->SetXY(($nb),235);
$pdf->Cell(40,4,"Noted By");
$pdf->SetFont('Times','',11);
$pdf->SetXY(($nb),242);
$pdf->MultiCell(0,7,"Name: ......................................................                   Appointment: ..................................\n\nSignature: .................................................                Telephone: (........).................................");
$pdf->SetFont('Times','',10);
$pdf->SetLineWidth(0.2);
$pdf->Rect(9,7,$w,274);
$pdf->Rect(9,34,$w,38);
$pdf->Rect(9,80,$w,42);
$pdf->Rect(9,133,$w,12);
$pdf->Rect(9,189,$w,7);
$pdf->Rect(9,234,$w,28);
$pdf->Line(9,271,$w+9,271);

$pdf->Line(42,34,42,133);
$pdf->Line(42,50,$w+9,50);
$pdf->Line(100,34,100,50);
$pdf->Line(152,34,152,50);
$pdf->Line(64,50,64,72);
$pdf->Line(87,50,87,72);
$pdf->Line(110,50,110,72);
$pdf->Line(138,50,138,72);
$pdf->Line(164,50,164,72);
$pdf->Line(185,50,185,72);
$pdf->Line(90,133,90,145);
$pdf->Line(42,145,42,189);
$pdf->Line(42,196,42,262);
$pdf->Line(42,271,42,281);

//   Fill in C5 form from here //
$pdf->SetFont('Times','',12);
$pdf->SetXY(43,43);$pdf->Cell(55,4,$row['groupname'],0,0,'C');
$pdf->SetXY(153,43);$pdf->Cell($w-144,4,'Kennedy Region',0,0,'C');
$pdf->SetXY(43,59);$pdf->Cell(20,4,$row['joeys'],0,0,'C');
$pdf->SetXY(65,59);$pdf->Cell(20,4,$row['cubs'],0,0,'C');
$pdf->SetXY(88,59);$pdf->Cell(21,4,$row['scouts'],0,0,'C');
$pdf->SetXY(111,59);$pdf->Cell(26,4,$row['vents'],0,0,'C');
$pdf->SetXY(139,59);$pdf->Cell(24,4,$row['rovers'],0,0,'C');
$pdf->SetXY(165,59);$pdf->Cell(19,4,$row['leaders'],0,0,'C');
$pdf->SetXY(186,59);$pdf->Cell(14,4,$row['others'],0,0,'C');
$pdf->SetXY(85,83);$pdf->Cell(80,4,$rows['site_name'],0,0,'L');
$pdf->SetXY(85,89);$pdf->Cell(80,4,$row['site_location'],0,0,'L');
$pdf->SetXY(85,95);$pdf->Cell(80,4,$rows['map_name'],0,0,'L');
$pdf->SetXY(85,101);$pdf->Cell(80,4,$rows['grid_ref'],0,0,'L');
$pdf->SetXY(85,113);$pdf->Cell(80,4,$rows['nearest_town'],0,0,'L');
$pdf->SetXY(57,123);$pdf->Cell(45,4,date('g:i A',strtotime($row['from_time']))." - ".date('d/m/Y',strtotime($row['from_date'])),0,0,'L');
$pdf->SetXY(130,123);$pdf->Cell(45,4,date('g:i A',strtotime($row['to_time']))." - ".date('d/m/Y',strtotime($row['to_date'])),0,0,'L');
$pdf->SetXY(98,134);$pdf->Cell(80,4,$row['nearest_medical'],0,0,'L');
$pdf->SetXY(60,161);$pdf->Cell(60,4,$row['incharge'],0,0,'L');
$pdf->SetXY(151,161);$pdf->Cell(30,4,$row['incharge_appt'],0,0,'L');
//$pdf->SetXY(151,175);$pdf->Cell(30,4,date('d/m/Y',strtotime($row['incharge_date'])),0,0,'L');date('d/m/Y');
$pdf->SetXY(151,175);$pdf->Cell(30,4,date('d/m/Y',strtotime($row['from_date'])),0,0,'L');
$pdf->SetXY(63,182);$pdf->Cell(65,4,$row['incharge_addr1'].', '.$row['incharge_addr2'],0,0,'L');
$pdf->SetXY(157,182);$pdf->Cell(30,4,$row['incharge_phone'],0,0,'L');
$pdf->SetXY(60,213);$pdf->Cell(60,4,$row['approv_name'],0,0,'L');
$pdf->SetXY(151,213);$pdf->Cell(30,4,$row['approv_apoint'],0,0,'L');
//  *****************  PAGE 2  **********************
//$pdf->enableheader = 'header5';
$pdf->SetMargins(9,10);
$pdf->AddPage('P');
// Header -------------------------------------------------------------------------------------
$pdf->Image('../../resource/scout_logo.gif',12,7,12);
// Calculate width of title and position
$pdf->SetLineWidth(0.5);
$pdf->Rect(9,7,$w,20);
$head1="The Scout Association of Australia, Queensland Branch Inc.";
$head2="ACTIVITY ADVICE and APPROVAL";
$hw1=$pdf->GetStringWidth($head1)+3;
$hw2=$pdf->GetStringWidth($head2)+3;
$pdf->SetFont('Times','B',12);
$pdf->SetXY(($w-$hw1)/2,8);
$pdf->Cell($hw1,5,$head1,0,0,'C',false);
$pdf->SetFont('Times','',11);
$pdf->SetXY(170,8);
$pdf->MultiCell(0,6,"Form:    C5\nIssue:     8\nDate:     12/13",'','L',0);
$pdf->SetFont('Times','B',14);
$pdf->SetXY(($w-$hw2)/2,16);
$pdf->Cell($hw2,9,$head2,0,0,'C',false);

//   Start Page 2 here --------------------------------------------------------
$pdf->SetLineWidth(0.2);
$pdf->Rect(9,33,$w,$h-31);
$pdf->Rect(9,120,$w,57);
$pdf->Line(9,234,$w+9,234);
$pdf->Rect(9,33,24,$h-31);

$note='NOTES';
$nw=$pdf->GetStringWidth($note)+3;
$pdf->SetFont('Times','',11);
$pdf->SetXY(($w-$nw+9)/2,27);
$pdf->Cell($nw,5,$note,0,0,'C',false);
$pdf->SetFont('Times','B',11);
$pdf->SetXY(9,35);
$pdf->Cell(24,0,'General');
$pdf->SetXY(9,122);
$pdf->MultiCell(0,3,"Notes for\nCompletion");
$pdf->SetXY(9,179);
$pdf->MultiCell(0,3,"Activity\nApproval");
$pdf->SetXY(9,237);
$pdf->Cell(24,0,'Notification');
$pdf->SetFont('Times','',9);
$pdf->SetXY(33,34);
$pdf->MultiCell(0,3,"This Form is to be used for all overnight and/or Specialist Outdoor Activities within Queensland for Joey Scouts, Cub Scouts, Scouts, Venturer Scouts, Rovers and Scout Fellowships.\n\n A parent notification form must be used for all activities away from the den.\n\nIt must be used for any Specialist Outdoor Activities including:\n\n* Abseiling                                           * Four Wheel Driving                        * Rock Climbing\n* Air Activities                                     * Horse Riding                                   * Snow Ski Touring (Cross Country)\n* Bushwalking                                      *Pioneering                                        * Water Activities\n* Caving                                                *Range Archery\n");
$pdf->SetXY(33,69);
$pdf->MultiCell(0,3,"Leaders should refer to the 'Queensland Branch Specialist Outdoor Activities Policies and Procedures' regarding participation in specific activities.\n\nUse Form C2 'Application to Camp or Travel Interstate' for interstate and overseas activities.  Form C2 is available from the website.\n\nOriginal and three copies of Form C5 should be prepared by the Activity Organiser for routing to the Approving Leader. The Approving Leader will distribute the three copies.\n\nTransport: Leaders responsible for activities involving road transport by motor vehicle (whether private or commercial) have an obligation to ensure that:");
$pdf->SetXY(51,103);
$pdf->MultiCell(0,3,"a) the vehicle has current registration and is suitable for the purpose and;\nb) each driver holds a current Blue Card and a current Driver's Licence (which must be sighted by the Leader) and which must be appropriate for the particular type of vehicle to be used and;\nc) applicable blue card requirements are met.");
$pdf->SetXY(33,116);
$pdf->MultiCell(0,3,"Refer: P & R- R12.2; QBSI Section 2.9 and Queensland Branch Adventurous Activities Policy and Procedures. ");
$pdf->SetXY(33,122);
$pdf->MultiCell(0,3,"Form C5 1-6 should be completed by the person(s) organising the activity, and should be signed by the person responsible to Scouts Australia for the staging of the activity.\n\nAll Youth Program Leaders should submit a proposed program for Camps or overnight Activities with the Form C5 for the approving Leader to assess whether the proposed activity is suitable for the Youth Members involved and that the activity conforms with prescribed safety and supervision standards.\n\nThe approving Leader will then consider the details provided and give approval if confident that the activity is suitable.\n\nYouth Members who are conducting activities must prepare and sign for their own activities by completing Part 1 Section 6. This form should then be given to their Leader, with the Program and other details to assess whether all aspects of the activity are suitable and safe; and the Youth Member has the training and responsibility to conduct the activity. This Leader will countersign after consideration and pass on to the Formation Leader for approval.");
$pdf->SetXY(33,163);
$pdf->MultiCell(0,3,"Section 3 Activity Site - A full description of the activity site(s), the location, or route details, with overnight stops must be given so that participants may be readily located in the event of an emergency. If space on the form is insufficient, attach a separate list and/or map. A map and grid reference is only required when the activity is not at a well known camping ground, holiday shelter, National Park, or other location readily identified by name.  ");
$pdf->SetXY(33,179);
$pdf->MultiCell(0,3,"Details of the proposed activity should be checked by the Approving Leader to ensure that the activity is a proper Scouting activity; that it is correctly planned in accordance with the rules of Scouts Australia (P&R), Queensland Branch Scouting Instructions (QBSI), State and Local Government Regulations; that adequate leader and resource personnel are available; that qualified technical specialists are available where necessary; and that all specified safety measures have been taken.\n\nForm C5 should be prepared sufficiently far in advance of the proposed activity, and be dispatched to reach the Approving Leader two weeks in advance of a Mob/Pack holiday, and one week in advance of other activities.\n\nThe Approving Leader will be for:-\n* Activities/Camps within the Group - Group Leader (Where a Group has a Group Leader in Training or a Leader in Charge then approval will occur by the District Commissioner.)\n* Group Family Camps, District Training Camps and Activities - District Commissioner (if no District Commissioner then Regional Commissioner.)\n\n* Region Activities/Camps - Regional Commissioner.\n\n* Branch Activities/Events - Chief Commissioner.");
$pdf->SetXY(33,236);
$pdf->MultiCell(0,3,"The Approving Leader may, if satisfied that all planned requirements have been met, give approval for the proposed activity to be conducted as a Scout Association activity. If the Approving Leader feels the Activity is outside his/her expertise, then counsel may be sought from an appropriate source.\n\nWhen the Approving Leader approves the Activity, copies of the Form C5 should be distributed as follows:-\n\n* Original – to the person responsible for conducting the activity.\n\n* Copy 1 – retained by the Approving Leader.\n\n* Copy 2 – sent to the District or Regional Commissioner for noting.\n\n* Copy 3 – to the host District or Region or to Branch Headquarters who will forward to host District/Region.");
 ?>