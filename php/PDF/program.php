<?php

$pdf->enableheader = 'headerF3';
$pdf->SetMargins(9,10);
$pdf->SetFont('Times','',14);
$pdf->SetAutoPageBreak('auto',1);
$pdf->AddPage('P');

//		main body   ------------------------------------------------------------------------------
$w = $pdf->GetPageWidth()-18;
$h = $pdf->GetPageHeight()-15;


$days=(strtotime($row['to_date'])-strtotime($row['from_date']))/(60*60*24);
if ($days>0) {$days+=1;}
$dty=$row['from_date'];
for ($x=0;$x<=$days;$x++) {
	if ($x>=1 && $x<$days) {$pdf->AddPage('P');} else {if($x>0) break;}
	PrintHead($pdf,$row,$rows,$w,$h);
	$dy=date_format(date_create($dty),'l d F Y');
	$pdf->SetXY(30,65);$pdf->Cell(50,4,'Program for - '.$dy,0,0);
	// Fields header ----------------------------------------------------------------------------------
	$pdf->SetFont('Times','',12);
	$pdf->SetFillColor(210);$pdf->Rect(16,75,$w-9,6,'F'); //        activity                 location                    equipment            yth to bring             responsible
	$pdf->SetDrawColor(30,30,220);$pdf->Rect(16,75,$w-9,6);$pdf->Line(30,75,30,81);$pdf->Line(57,75,57,81);;$pdf->Line(88,75,88,81);$pdf->Line(128,75,128,81);$pdf->Line(168,75,168,81);
	$pdf->SetDrawColor(30);
	$pdf->SetXY(17,76);$pdf->Cell(14,4,'Time',0,0);$pdf->Cell(27,4,'Activity',0,0);$pdf->Cell(30,4,'Location',0,0);$pdf->Cell(40,4,'Equipment',0,0);$pdf->Cell(40,4,'Youth to bring',0,0);$pdf->Cell(20,4,'Responsible',0,0);
	//		body fields ---------------------------------------------------------------------------------
	$ln=82;
	$pdf->SetFont('Times','',10);
	$sqlpr="SELECT * FROM program WHERE idact=".$row['idact']." AND act_date='".$dty."' ORDER BY act_date ASC, act_time ASC, act_type DESC";
	if ($query = mysqli_query($con,$sqlpr)) {
		while($rowpr= mysqli_fetch_assoc($query)) {
			if ($rowpr['act_type']=='C') continue;

			$tm=substr($rowpr['act_time'],0,5);
			$pdf->SetXY(18,$ln);$pdf->Cell(14,4,$tm,0,0);
			// work out tallest cell from text //
			$jm20=GetHeight2($pdf,$rowpr['class'],39)+4;
			$jm21=GetHeight2($pdf,$rowpr['location'],39)+4;
			$jm22=GetHeight2($pdf,$rowpr['equip'],39)+4;
			$jm23=GetHeight2($pdf,$rowpr['tobring'],39)+4;
			$jm2=0;$jm2=max($jm20,$jm21,$jm22,$jm23)+4;

			$pdf->MultiCell(25,4,$rowpr['class'],0,'L');
			$pdf->SetXY(59,$ln);$pdf->MultiCell(30,4,$rowpr['location'],0,'L');
			$pdf->SetXY(90,$ln);$pdf->MultiCell(40,4,$rowpr['equip'],0,'L');
			$pdf->SetXY(130,$ln);$pdf->MultiCell(40,4,$rowpr['tobring'],0,'L');
			$pdf->SetXY(170,$ln);$pdf->MultiCell(30,4,$rowpr['leaders'],0,'L');
			$ln+=$jm2;
			$pdf->Line(16,$ln,$w+7,$ln);
		}
	}
	$dty=substr($dty,0,4).'-'.substr($dty,5,2).'-'.(substr($dty,8,2)+1);
}
    //                                  calculate heights of rows

function GetHeight2($pdf,$textt,$wdth) {
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

function PrintHead ($pdf,$row,$rows,$w,$h) {


	$pdf->SetLineWidth(0.2);
	$pdf->Rect(16,28,$w-9,34);$pdf->Line(16,41,$w+7,41);$pdf->Line(16,47,$w+7,47);
	$pdf->SetFont('Times','B',12);
	$pdf->SetXY(30,30);$pdf->Cell(40,4,$row['activ_name'],0,0);
	$pdf->SetXY(68,30);$pdf->Cell(40,4,$rows['site_name'],0,0);
	$pdf->SetXY(68,35);$pdf->Cell(40,4,$row['site_location'],0,0);
	$pdf->SetXY(30,42);$pdf->Cell(55,4,'Leader in Charge :  '.$row['incharge'],0,0);
	$pdf->SetXY(115,42);$pdf->Cell(40,4,'Safety Officer :  '.$row['F31_safety_officer'],0,0);
	$formt="";
	if ($row['joeys']>0) {$formt=$formt.'Joeys ';}
	if ($row['cubs']>0) {$formt.='Cubs ';}
	if ($row['scouts']>0) {$formt.='Scouts ';}
	if ($row['vents']>0) {$formt.='Venturers ';}
	if ($row['rovers']>0) {$formt.='Rovers ';}
	if ($row['cubs']>0 && $row['scouts']>0) {$formt='Group';}
	if ($row['leaders']>40) {$formt='Region';}
	$yth=$row['joeys']+$row['cubs']+$row['scouts']+$row['vents'];$adlt=$row['rovers']+$row['leaders']+$row['others'];
	$pdf->SetXY(30,48);$pdf->Cell(40,4,'This is a '.$formt.' event with -: '.$yth.' Members and '.$adlt.' Adults',0,0);
	$pdf->SetFont('Times','',12);
	$pdf->SetXY(30,55);$pdf->Cell(45,4,'From :  '.date('d/m/Y',strtotime($row['from_date']))." - ".date('g:i A',strtotime($row['from_time'])),0,0,'L');
	$pdf->SetXY(130,55);$pdf->Cell(45,4,'To   :  '.date('d/m/Y',strtotime($row['to_date']))." - ".date('g:i A',strtotime($row['to_time'])),0,0,'L');
	$pdf->SetFont('Times','B',12);

}
?>
