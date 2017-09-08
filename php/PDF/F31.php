<?php



$pdf->enableheader = 'headerF1';
$pdf->SetMargins(2,-10);
$pdf->SetFont('Times','',14);
$pdf->SetAutoPageBreak('auto',1);
$pdf->AddPage('L');
;
//		main body   ------------------------------------------------------------------------------
$pdf->SetLineWidth(0.1);
$w = $pdf->GetPageWidth()-18;$h = $pdf->GetPageHeight()-50;
$pdf->SetDrawColor(190);$pdf->SetFont('Times','B',10);
$pdf->Rect(9,34,$w,$h);
$pdf->SetXY(10,35);$pdf->Cell(30,4,'Activity Description:',0,0,'L',false);
$pdf->SetXY(10,52);$pdf->Cell(30,4,'Activity Leaders name:',0,0,'L',false);$pdf->SetXY(160,50);$pdf->Cell(30,4,"Safety Officer's",0,0,'L',false);$pdf->SetXY(160,55);$pdf->Cell(30,4,"name",0,0,'L',false);
$pdf->SetFont('Times','',10);
$pdf->Rect(9,42,$w,7);$pdf->SetXY(10,43);$pdf->Cell(30,4,'Location:',0,0,'L',false);
$pdf->Rect(9,59,$w,7);$pdf->SetXY(10,60);$pdf->Cell(30,4,'Formation:',0,0,'L',false);
$pdf->SetXY(10,67);$pdf->Cell(30,4,'Start date and time:',0,0,'L',false);$pdf->SetXY(136,67);$pdf->Cell(30,4,'Finish date and time:',0,0,'L',false);
$pdf->Rect(9,73,$w,10);
$pdf->SetXY(10,78);$pdf->Cell(30,4,'Number of youth (approximately):',0,0,'L',false);$pdf->SetXY(136,74);$pdf->Cell(30,4,'Number of Leaders and Adults',0,0,'L',false);$pdf->SetXY(136,78);$pdf->Cell(30,4,'(approximately):',0,0,'L',false);
$pdf->SetFillColor(180);
$pdf->Rect(9,83,$w,5,'DF');$pdf->Rect(9,96,$w,5,'DF');$pdf->Rect(9,169,$w,5,'DF');$pdf->Rect(9,189,$w,5,'DF');
$pdf->SetFont('Times','B',10);
$pdf->SetXY(10,84);$pdf->Cell(30,4,'Minimum Supervision and Qualifications',0,0,'L',false);
$pdf->SetXY(10,97);$pdf->Cell(30,4,'Minimum Equipment/ Facilities for activity                                                         YES     NO     N/A     Comments / Further Information',0,0,'L',false);
$pdf->SetXY(10,170);$pdf->Cell(30,4,'Governing Bodies / Associations / Legislation                                                        YES     NO     N/A     Comments / Further Information',0,0,'L');
$pdf->SetXY(10,191);$pdf->Cell(120,2,'Scout-specific policies and rules                                                                               YES     NO     N/A     Comments / Further Information',0,0,'L');
$pdf->SetFont('Times','',10);
$pdf->SetXY(10,90);$pdf->Cell(30,4,'Are there sufficient leaders with minimum qualifications supervising the activity?           Yes       No             Sufficient leaders with current First Aid including CPR?       Yes        No',0,0,'L',false);
for ($i=109;$i<200;$i+=7.5) {if ($i==176.5 || $i==196.5) {$i=$i+5;} $pdf->Line(9,$i,$w+9,$i);}
$pdf->Line(158,49,158,59);$pdf->Line(195,49,195,59);
$pdf->Line(135,66,135,83);$pdf->Line(206,66,206,83);
$h = $pdf->GetPageHeight()-8;
$pdf->Line(126,96,126,$h);$pdf->Line(137,96,137,$h);$pdf->Line(147,96,147,$h);$pdf->Line(158,96,158,$h);

//		body fields ---------------------------------------------------------------------------------
$pdf->SetFont('Times','B',12);
$pdf->SetXY(50,35);$pdf->Cell(40,4,$row['activ_name'],0,0);
$pdf->SetXY(50,52);$pdf->Cell(148,4,$row['incharge'],0,0);;$pdf->Cell(40,4,$row['F31_safety_officer'],0,0);
$pdf->SetFont('Times','',12);
$pdf->SetXY(50,43);$pdf->Cell(40,4,$row['site_location'],0,0);
$formt="";
if ($row['joeys']>0) {$formt=$formt.'Joeys ';}
if ($row['cubs']>0) {$formt.='Cubs ';}
if ($row['scouts']>0) {$formt.='Scouts ';}
if ($row['vents']>0) {$formt.='Venturers ';}
if ($row['rovers']>0) {$formt.='Rovers ';}
if ($row['cubs']>0 && $row['scouts']>0 && $row['vents']>0) {$formt='Group';}
if ($row['leaders']>40) {$formt='Region';}
$pdf->SetXY(50,60);$pdf->Cell(40,4,$formt,0,0);
$pdf->SetXY(50,68);$pdf->Cell(45,4,date('g:i A',strtotime($row['from_time']))." - ".date('d/m/Y',strtotime($row['from_date'])),0,0,'L');
$pdf->SetXY(208,68);$pdf->Cell(45,4,date('g:i A',strtotime($row['to_time']))." - ".date('d/m/Y',strtotime($row['to_date'])),0,0,'L');
$yth=$row['joeys']+$row['cubs']+$row['scouts']+$row['vents'];$adlt=$row['rovers']+$row['leaders']+$row['others'];
$pdf->SetXY(60,78);$pdf->Cell(40,4,$yth,0,0);
$pdf->SetXY(208,78);$pdf->Cell(40,4,$adlt,0,0);
$pdf->SetDrawColor(30);
if ($row['F31_qual_leaders']==0) {$pdf->Line(136,93,142,91);} else {$pdf->Line(147,93,153,91);}
if ($row['F31_firstaid_leaders']==0) {$pdf->Line(249,93,255,91);} else {$pdf->Line(261,93,267,91);}

$ps=96;$lin=0;

if ($query = mysqli_query($con,$sqlf)) {
	while($rowf= mysqli_fetch_assoc($query)) {
     $pdf->SetXY(10,$ps+7.5); $ps=$ps+7.5;$lin=$lin+1;
     if ($lin==9 || $lin==11) {$ps=$ps+5;}
     $reqy=$reqn=$reqo="";
     if ($rowf['req']=='1') {$reqy='X';} else {if($rowf['req']=='2') {$reqn='X';} else {$reqo='X';};}
     $pdf->Cell(116,4,$rowf['item'],0,0);$pdf->Cell(11,4,$reqy,0,0,'C');$pdf->Cell(10,4,$reqn,0,0,'C');$pdf->Cell(11,4,$reqo,0,0,'C');$pdf->Cell(100,4,$rowf['comments'],0,0);
} }

// Page 2 -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
$pdf->AddPage('L');
$pdf->SetFont('Times','B',14);
$pdf->SetXY(11,34);$pdf->Cell(100,5,'Calculating the inherent risk level for your activity',0,0);
$pdf->SetFont('Times','',10);
$pdf->SetXY(11,40);$pdf->MultiCell(270,4,'The Risk Analysis Matrix below can be used as a guide to assist with quantifying the risk level. To use the matrix, map the likelihood and consequences occurring with your activity to arrive at the risk level. Keep in mind that when assessing risk value judgements need to be made; and when making value judgements sometimes the risk level is not clear cut. If undecided on a risk level for an activity, a conservative approach would be to settle on  the higher risk level being considered. Assessing the risk level is important. However, regardless of the assessed level of risk, we always have an obligation to do what is reasonably practicable to eliminate the risk, or if that is not possible, to minimise the risk to an acceptable level.',0,'J');
$pdf->Rect(9,58,262,115);$pdf->SetFillColor(30,30,230);$pdf->Rect(9,58,262,6,'DF');
$pdf->SetXY(11,59);$pdf->SetTextColor(250,250,250);$pdf->Cell(60,4,'RISK ANALYSIS MATRIX',0,0);$pdf->SetTextColor(0,0,0);
$pdf->Rect(9,64,78,48.4);
$pdf->Rect(87,64,184,6);
$pdf->SetFont('Times','B',12);
$pdf->SetXY(88,65);$pdf->Cell(182,5,'Consequences',0,0,'C');
$pdf->SetXY(88,71);$pdf->Cell(82,5,'Insignificant',0,0);$pdf->SetXY(126,71);$pdf->Cell(82,5,'Low',0,0);$pdf->SetXY(163,71);$pdf->Cell(82,5,'Medium',0,0);$pdf->SetXY(199,71);$pdf->Cell(182,5,'Major',0,0);$pdf->SetXY(236,71);$pdf->Cell(182,5,'Severe',0,0);
$pdf->SetXY(17,113);$pdf->Cell(42,5,'Almost Certain',0,0);$pdf->SetXY(17,125);$pdf->Cell(42,5,'Likely',0,0);$pdf->SetXY(17,137);$pdf->Cell(42,5,'Possible',0,0);$pdf->SetXY(17,149);$pdf->Cell(42,5,'Unlikely',0,0);$pdf->SetXY(17,161);$pdf->Cell(42,5,'Rare',0,0);
$pdf->Rotate(90);$pdf->SetXY(69,100);$pdf->Write(30,'Likelyhood');$pdf->Rotate(0);
$pdf->Rect(87,70,36.8,42.4);$pdf->Rect(123.8,70,36.8,42.4);$pdf->Rect(160.6,70,36.8,42.4);$pdf->Rect(197.4,70,36.8,42.4);$pdf->Rect(234.2,70,36.8,42.4);
$pdf->Rect(9,112.4,7,60.6);$pdf->Rect(16,112.4,71,12.1);$pdf->Rect(16,124.5,71,12.1);$pdf->Rect(16,136.6,71,12.1);$pdf->Rect(16,148.7,71,12.1);$pdf->Rect(16,160.8,71,12.2);
$pdf->SetFont('Times','',9);
$pdf->SetXY(88,76);$pdf->MultiCell(35,4,"Loss of life: Nil\nInjury/Illness:No\nmedical attention required.",0,'L');$pdf->SetXY(125,75);$pdf->MultiCell(35,4,"Loss of life:Nil\nInjury/Illness: Medical attention required.",0,'L');$pdf->SetXY(162,75);$pdf->MultiCell(35,4,"Loss of life:Nil.\nInjury/Illness: Minor medical or hospitalisation required with no long term effects",0,'L');$pdf->SetXY(198,75);$pdf->MultiCell(35,4,"Loss of life: A fatality.\nInjury/Illness: Serious injury/illness hospitalisation has occured. Some ongoing treatment required.",0,'L');$pdf->SetXY(235,75);$pdf->MultiCell(35,4,"Loss of life: Fatalities have occured.\nInjury/Illness:Significant injury/illness has occurred requiring hospitalisation and ongoing treatment.",0,'L');
$pdf->SetXY(17,119);$pdf->Cell(60,4,'Expected to occur in most circumstances.',0,0);$pdf->SetXY(17,131);$pdf->Cell(60,4,'Will probably occur in most circumstances.',0,0);$pdf->SetXY(17,143);$pdf->Cell(60,4,'Might occur at some time',0,0);$pdf->SetXY(17,155);$pdf->Cell(60,4,'Could occur at some time but it is improbably',0,0);$pdf->SetXY(17,167);$pdf->Cell(60,4,'May occur only in exceptional circumstances.',0,0);
$pdf->SetFont('Times','',10);
$pdf->SetXY(11,175);$pdf->Cell(100,4,'Each risk level has been grouped into categories, E=Extreme, H=High, M=Moderate, L=Low, and given a score between 2 and 50.',0,0);
$pdf->SetXY(11,188);$pdf->Cell(100,4,'For further explanations of the risk analysis matrix refer to the ScoutSafe Risk Assessment Handbook available from the Queensland Branch website',0,0);
// Risk Matrix in Colour
$pdf->SetFillColor(30,230,30); //green
$pdf->Rect(87,136.6,36.8,12.1,'DF');
$pdf->Rect(87,148.7,36.8,12.1,'DF');$pdf->Rect(123.8,148.7,36.8,12.1,'DF')
;$pdf->Rect(87,160.8,36.8,12.2,'DF');$pdf->Rect(123.8,160.8,36.8,12.2,'DF');$pdf->Rect(160.6,160.8,36.8,12.2,'DF');
$pdf->SetFillColor(240,240,0); //yellow
$pdf->Rect(87,112.4,36.8,12.1,'DF');
$pdf->Rect(87,124.5,36.8,12.1,'DF');$pdf->Rect(123.8,124.5,36.8,12.1,'DF');
$pdf->Rect(123.8,136.6,36.8,12.1,'DF');$pdf->Rect(160.6,136.6,36.8,12.1,'DF');
$pdf->Rect(160.6,148.7,36.8,12.1,'DF');$pdf->Rect(197.4,148.7,36.8,12.1,'DF');
$pdf->Rect(197.4,160.8,36.8,12.2,'DF');$pdf->Rect(234.2,160.8,36.8,12.2,'DF');
$pdf->SetFillColor(230,130,30); //orange
$pdf->Rect(123.8,112.4,36.8,12.1,'DF');$pdf->Rect(160.6,112.4,36.8,12.1,'DF');
$pdf->Rect(160.6,124.5,36.8,12.1,'DF');
$pdf->Rect(197.4,136.6,36.8,12.1,'DF');
$pdf->Rect(234.2,148.7,36.8,12.1,'DF');
$pdf->SetFillColor(230,30,30); //red
$pdf->Rect(197.4,112.4,36.8,12.1,'DF');$pdf->Rect(234.2,112.4,36.8,12.1,'DF');
$pdf->Rect(197.4,124.5,36.8,12.1,'DF');$pdf->Rect(234.2,124.5,36.8,12.1,'DF');
$pdf->Rect(234.2,136.6,36.8,12.1,'DF');
$pdf->SetFont('Times','B',12);
$pdf->SetXY(87,113);$pdf->Cell(36.8,10,'M-10',0,0,'C');$pdf->Cell(36.8,10,'H-20',0,0,'C');$pdf->Cell(36.8,10,'H-30',0,0,'C');$pdf->Cell(36.8,10,'E-40',0,0,'C');$pdf->Cell(36.8,10,'E-50',0,0,'C');
$pdf->SetXY(87,125);$pdf->Cell(36.8,10,'M-8',0,0,'C');$pdf->Cell(36.8,10,'M-16',0,0,'C');$pdf->Cell(36.8,10,'H-24',0,0,'C');$pdf->Cell(36.8,10,'E-32',0,0,'C');$pdf->Cell(36.8,10,'E-40',0,0,'C');
$pdf->SetXY(87,137);$pdf->Cell(36.8,10,'L-6',0,0,'C');$pdf->Cell(36.8,10,'M-12',0,0,'C');$pdf->Cell(36.8,10,'M-18',0,0,'C');$pdf->Cell(36.8,10,'H-24',0,0,'C');$pdf->Cell(36.8,10,'E-30',0,0,'C');
$pdf->SetXY(87,149);$pdf->Cell(36.8,10,'L-4',0,0,'C');$pdf->Cell(36.8,10,'L-8',0,0,'C');$pdf->Cell(36.8,10,'M-12',0,0,'C');$pdf->Cell(36.8,10,'M-16',0,0,'C');$pdf->Cell(36.8,10,'H-20',0,0,'C');
$pdf->SetXY(87,161);$pdf->Cell(36.8,10,'L-2',0,0,'C');$pdf->Cell(36.8,10,'L-4',0,0,'C');$pdf->Cell(36.8,10,'L-6',0,0,'C');$pdf->Cell(36.8,10,'M-8',0,0,'C');$pdf->Cell(36.8,10,'M-10',0,0,'C');


// Page 3 -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
$pdf->enableheader = 'headerF2';
$pdf->AddPage('L');
$pdf->SetFont('Times','',10);
$lin=$jmpold=57;$brd=0;

if ($query = mysqli_query($con,$sqlrv)) {
	while($rowrv= mysqli_fetch_assoc($query)) {
    //                                  calculate heights of rows

      $jm20=GetHeight($pdf,$rowrv['task'],39)+4;
      $jm21=GetHeight($pdf,$rowrv['risk'],76)+4;
      $jm22=GetHeight($pdf,$rowrv['mitigation'],81)+4;
//                                                          find out which is greater
      $jmp2=max($jm20,$jm21,$jm22);
      $jmp=$jmp2+4;
      $jmpold=$jmp2+$lin;
//                                                        Test if printed, will it go over page break? if yes, start new page.
      if ($jmpold>190) {$pdf->AddPage('L'); $lin=$jmpold=57;}
      $pdf->SetXY(11,$lin+1);
      $pdf->MultiCell(39,4,$rowrv['task'],0,'L');
      $pdf->SetXY(53,$lin+1);$pdf->MultiCell(76,4,$rowrv['risk'],0,'L');
			$mtra=substr($rowrv['matrix_before'],0,1);
			if ($mtra=='L') {$pdf->SetFillColor(30,230,30);}
			if ($mtra=='M') {$pdf->SetFillColor(240,240,0);}
			if ($mtra=='H') {$pdf->SetFillColor(230,130,30);}
			if ($mtra=='E') {$pdf->SetFillColor(230,30,30);}
			$pdf->Rect(130,$lin,24,$jmp,'DF');
			$pdf->SetXY(131,$lin+1);$pdf->MultiCell(22,4,$rowrv['matrix_before'],0,'C');
      $pdf->SetXY(155,$lin+1);$pdf->MultiCell(81,4,$rowrv['mitigation'],0,'L');
			$mtra=substr($rowrv['matrix_after'],0,1);
			if ($mtra=='L') {$pdf->SetFillColor(30,230,30);}
			if ($mtra=='M') {$pdf->SetFillColor(240,240,0);}
			if ($mtra=='H') {$pdf->SetFillColor(230,130,30);}
			if ($mtra=='E') {$pdf->SetFillColor(230,30,30);}
			$pdf->Rect(237,$lin,23,$jmp,'DF');
			$pdf->SetXY(238,$lin+1);$pdf->MultiCell(21,4,$rowrv['matrix_after'],0,'C');
      if ($mtra=='L') {$ref='None';}
			if ($mtra=='M') {$ref='Region';}
			if ($mtra=='H' || $mtra=='E') {$ref='Branch';}
      $pdf->SetXY(261,$lin+1);$pdf->MultiCell(33,4,$ref,0,'C');
//                                   Draw bars for row information after we calculate height of row data
      $pdf->SetLineWidth(0.5); $pdf->Line(9,$lin,9,$lin+$jmp); $pdf->Line($w+9,$lin,$w+9,$lin+$jmp);
      $pdf->SetLineWidth(0.1); $pdf->Line(52,$lin,52,$lin+$jmp); $pdf->Line(130,$lin,130,$lin+$jmp); $pdf->Line(154,$lin,154,$lin+$jmp); $pdf->Line(237,$lin,237,$lin+$jmp); $pdf->Line(260,$lin,260,$lin+$jmp); $pdf->Line(9,$lin+$jmp,$w+9,$lin+$jmp);
      $lin=$lin+$jmp; // if ($lin>190) {$pdf->AddPage('L'); $lin=$jmpold=57;$brd=0;} else {$brd=1;}
  }
}


// Page 4 -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

$pdf->enableheader = 'headerF1';
$pdf->AddPage('L');
$pdf->SetDrawColor(190);
$pdf->Rect(11,34,$w-5,70);$pdf->Rect(9,103,$w,70);
$pdf->Line(11,44,$w+6,44);$pdf->Line(11,58,$w+6,58);$pdf->Line(11,73,$w+6,73);$pdf->Line(11,83,$w+6,83);$pdf->Line(11,94,$w+6,94);
$pdf->SetFillColor(200);$pdf->Rect(9,103,$w,9,'DF');$pdf->SetDrawColor(190);
$pdf->Line(9,120,$w+9,120);$pdf->Line(9,128,$w+9,128);$pdf->Line(9,136,$w+9,136);$pdf->Line(9,154,$w+9,154);$pdf->Line(9,164,$w+9,164);
$pdf->Line(24,34,24,83);$pdf->Line(128,83,128,94);$pdf->Line(237,94,237,103);$pdf->SetDrawColor(150);$pdf->Line(237,103,237,112);$pdf->Line(265,103,265,112);$pdf->SetDrawColor(190);
$pdf->Line(237,112,237,136);$pdf->Line(265,112,265,136);$pdf->Line(128,154,128,164);$pdf->Line(237,164,237,173);
if ($row['approv']) {$aprov='X';} else {$aprov='[]';}
if ($row['approv_cond']) {$aprovc='X';} else {$aprovc='[]';}
if ($row['napprov_res']) {$naprov='X';} else {$naprov='[]';}
if ($row['require_sub']) {$reqsub='X';} else {$reqsub='[]';}
$pdf->SetXY(10,35);$pdf->Cell(15,4,$aprov,0,0,'C');$pdf->Cell(30,4,'Approved as submitted',0,0);
$pdf->SetXY(10,45);$pdf->Cell(15,4,$aprovc,0,0,'C');$pdf->Cell(70,4,'Approved with the following conditions:',0,0);$pdf->Cell(20,4,$row['approv_condit'],0,0);
$pdf->SetXY(10,59);$pdf->Cell(15,4,$naprov,0,0,'C');$pdf->Cell(70,4,'Not approved for the following reasons:',0,0);$pdf->Cell(20,4,$row['napprov_reason'],0,0);
$pdf->SetXY(10,74);$pdf->Cell(15,4,$reqsub,0,0,'C');$pdf->Cell(40,4,'Requires submission to Queensland Chief Commissioner and branch team because it contains high and extreme reisks that require approval.',0,0);
$pdf->SetXY(12,83);$pdf->Cell(15,4,'Name:',0,0);$pdf->Cell(101,4,$row['approv_name'],0,0);$pdf->Cell(25,4,'Appointment:',0,0);$pdf->Cell(20,4,$row['approv_apoint'],0,0);
$pdf->SetXY(12,94);$pdf->Cell(226,4,'Signed:',0,0);$pdf->Cell(15,4,'Date:',1,0);$pdf->Cell(40,4,$row['approv_date'],0,0);
$pdf->SetFont('Times','B',10);$pdf->SetXY(10,105);$pdf->Cell(227,4,'Monitor and review (To be completed during or after activity)',0,0);$pdf->Cell(28,4,'YES',0,0,'C');$pdf->Cell(22,4,'NO',0,0,'C');
$pdf->SetFont('Times','',10);$pdf->SetXY(10,113);$pdf->Cell(50,4,'Are the control methods still effective?',0,0);
$pdf->SetXY(10,121);$pdf->Cell(50,4,'Have there been any changes?',0,0);
$pdf->SetXY(10,129);$pdf->Cell(50,4,'Are any further action required?',0,0);
$pdf->SetXY(10,137);$pdf->Cell(50,4,'Details:',0,0);
$pdf->SetXY(10,155);$pdf->Cell(118,4,'Name:',0,0);$pdf->Cell(40,4,'Appointment:',0,0);
$pdf->SetXY(10,165);$pdf->Cell(228,4,'Signed:',0,0);$pdf->Cell(40,4,'Date:',0,0);

//  Revert back to no header  =-=-=-=-=-=-=-=-=-=-=-=-=-=-
$pdf->enableheader = 'header2';

function GetHeight($pdf,$textt,$wdth) {
  $description = $textt;           // MultiCell (multi-line) content.
  $column_width = $wdth;
  $total_string_width = $pdf->GetStringWidth($description);
  $number_of_lines = $total_string_width / ($column_width - 2);
  $number_of_lines = ceil( $number_of_lines );  // Round it up.
  $line_height = 4;                             // Whatever your line height is.
  $height_of_cell = $number_of_lines * $line_height;
  $height_of_cell = ceil( $height_of_cell );
  return $height_of_cell;
}

?>
