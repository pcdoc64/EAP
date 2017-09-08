<?php
$pdf->SetMargins(9,10);
$pdf->SetFont('Times','',14);
$pdf->AddPage('P');

// Header -------------------------------------------------------------------------------------
$pdf->Image('../../resource/scout_logo.gif',12,7,12);
// Calculate width of title and position
$w = $pdf->GetPageWidth()-18;
$h = $pdf->GetPageHeight()-15;
$pdf->SetLineWidth(0.5);
$pdf->Rect(9,7,$w,19);
$head1="The Scout Association of Australia, Queensland Branch Inc.";
$head2="Notification Of Camp / Outdoor Activity";
$hw1=$pdf->GetStringWidth($head1)+3;
$hw2=$pdf->GetStringWidth($head2)+3;
$pdf->SetFont('Times','B',12);
$pdf->SetXY(($w-$hw1)/2,8);
$pdf->Cell($hw1,5,$head1,0,0,'C',false);
$pdf->SetFont('Times','',11);
$pdf->SetXY(170,8);
$pdf->MultiCell(0,6,"Form:    C4\nIssue:     10\nDate:     03/15",'','L',0);
$pdf->SetFont('Times','B',14);
$pdf->SetXY(($w-$hw2)/2,16);
$pdf->Cell($hw2,9,$head2,0,0,'C',false);
//		main ---------------------------------------------------------------------------------
$w=$w+9;
$pdf->SetLineWidth(0.2);
$pdf->SetFont('Times','B',12);
$pdf->SetXY(9,32);$pdf->Cell(65,5,'Part A               PARENTS COPY',0,0,'L');
$pdf->Line(9,37,$w,37);
$pdf->SetXY(9,88);$pdf->Cell(65,5,'Part B               LEADERS COPY',0,0,'L');
$pdf->Line(9,93,$w,93);
$pdf->SetXY(9,85);$pdf->Cell(120,4,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -',0,0,'L');
$pdf->SetFont('Times','B',10);
$pdf->SetXY(11,94);$pdf->Cell(165,5,'This Form To Be Filled In By Parent(S) Or Guardian(S) And Returned, Together With Camp Fee To The Leader-in-Charge',0,0,'L');
$pdf->SetXY(11,98);$pdf->Cell(165,5,'By _________________________________________________________________________________________________________',0,0,'L');
$pdf->SetFont('Times','',10);
$pdf->SetXY(9,40);$pdf->Cell(120,4,'Dear Parent/Guardian, The following are arrangements for the next ',0,0,'L');$pdf->Cell(30,4,$row['activ_name'],0,0);
$pdf->SetXY(11,45);$pdf->Cell(20,4,'Place:',0,0,'L');$pdf->Line(25,49,$w,49);
$pdf->SetXY(11,50);$pdf->Cell(160,4,'DURATION                    From:   _____________________________________     To:                         ________________',0,0,'L');
$pdf->SetXY(11,56);$pdf->Cell(160,4,'ASSEMBLY                    Location   ___________________________________    Time:                      ________________',0,0,'L');
$pdf->SetXY(11,61);$pdf->Cell(160,4,'RETURN                         Location   ___________________________________     Time:                      ________________',0,0,'L');
$pdf->SetXY(11,65);$pdf->Cell(160,4,'Activity under control of Adult Leader / Patrol Leader:  ___________________     Cost:                     $________________',0,0,'L');
$pdf->SetXY(11,70);$pdf->MultiCell(0,4,'Once this amount is paid and provisions purchased, no refund will be made through non-attendance at the respective activity except in special circumstances','','L',0);
$pdf->SetXY(11,107);$pdf->Cell(30,4,'I approve of',0,0,'L');
$pdf->SetXY(114,107);$pdf->Cell(30,4,'<-(Scouts Name)     (Member number)->',0,0,'L');
$pdf->Line(48,111,$w,111);
$pdf->SetXY(11,112);$pdf->Cell(30,4,'Address:',0,0,'L');
$pdf->Line(48,116,$w,116);
$pdf->SetXY(11,117);$pdf->Cell(30,4,'Attending                                                               from:                                                                 to',0,0,'L');
$pdf->Line(28,121,80,121);$pdf->Line(91,121,143,121);$pdf->Line(152,121,$w,121);
$pdf->SetXY(11,122);$pdf->Cell(30,4,'Should the necessity arise, I can be contacted at:',0,0,'L');
$pdf->SetXY(11,127);$pdf->Cell(30,4,'Phone                                                                                                            Mobile',0,0,'L');
$pdf->Line(48,131,113,131);$pdf->Line(130,131,$w,131);
$pdf->SetXY(11,137);$pdf->Cell(30,4,'I submit the following details for your attention:',0,0,'L');
$pdf->SetXY(11,142);$pdf->Cell(30,4,'Medicare No.                                                                                 Date of last Tetanus Injection',0,0,'L');
$pdf->Line(48,146,100,146);$pdf->Line(148,146,$w,146);
$pdf->SetXY(11,147);$pdf->Cell(30,4,'Points in the Scouts health or behaviour requiring some special attention:',0,0,'L');
$pdf->Rect(10,151,$w-9,20);
$pdf->SetXY(11,172);$pdf->Cell(30,4,'Details of any medication and dosage that will be carried:',0,0,'L');
$pdf->Rect(10,176,$w-9,19);
$pdf->SetXY(11,195);$pdf->Cell(30,4,'The program will contain the indicated adventurous activities requiring specific approval. Initial adjacent to activity',0,0,'L');
$pdf->SetXY(18,200);$pdf->Cell(30,4,'Swimming',0,0,'L');$pdf->SetXY(88,200);$pdf->Cell(30,4,'Pioneering',0,0,'L');$pdf->SetXY(152,200);$pdf->Cell(30,4,'Archery',0,0,'L');
$pdf->Rect(11,200,3,3);$pdf->Line(42,204,79,204);$pdf->Rect(81,200,3,3);$pdf->Line(113,204,143,204);$pdf->Rect(145,200,3,3);$pdf->Line(170,204,$w,204);
$pdf->SetXY(18,205);$pdf->Cell(30,4,'Canoe/Kayak',0,0,'L');$pdf->SetXY(88,205);$pdf->Cell(30,4,'Bushwalking',0,0,'L');$pdf->SetXY(152,205);$pdf->Cell(30,4,'4WD',0,0,'L');
$pdf->Rect(11,205,3,3);$pdf->Line(42,209,79,209);$pdf->Rect(81,205,3,3);$pdf->Line(113,209,143,209);$pdf->Rect(145,205,3,3);$pdf->Line(170,209,$w,209);
$pdf->SetXY(18,210);$pdf->Cell(30,4,'Abseiling',0,0,'L');$pdf->SetXY(88,210);$pdf->Cell(30,4,'Snorkelling',0,0,'L');$pdf->SetXY(152,210);$pdf->Cell(30,4,'Boating',0,0,'L');
$pdf->Rect(11,210,3,3);$pdf->Line(42,214,79,214);$pdf->Rect(81,210,3,3);$pdf->Line(113,214,143,214);$pdf->Rect(145,210,3,3);$pdf->Line(170,214,$w,214);
$pdf->SetXY(18,215);$pdf->Cell(30,4,'Rock Climbing',0,0,'L');$pdf->SetXY(88,215);$pdf->Cell(30,4,'Caving',0,0,'L');$pdf->SetXY(152,215);$pdf->Cell(30,4,'',0,0,'L');
$pdf->Rect(11,215,3,3);$pdf->Line(42,219,79,219);$pdf->Rect(81,215,3,3);$pdf->Line(113,219,143,219);$pdf->Rect(145,215,3,3);$pdf->Line(155,219,$w,219);
$pdf->SetXY(9,225);$pdf->MultiCell(0,4,'In the event of injury to the Youth Members, where reasonable attempts to contact me are unsuccessful I give authority for such medical treatment to be given to the youth member as is recommended by a medical practitioner and seems in the opinion of the leader in charge to be reasonable and appropriate. I undertake to be responsible for any fees or charges with respect to that treatment and to pay those costs on demand by the Association.','','L',0);
$pdf->SetXY(11,248);$pdf->Cell(30,4,'Signature of parent, caregiver or guardian:',0,0,'L');$pdf->SetXY(150,248);$pdf->Cell(30,4,'Date:',0,0,'L');
$pdf->Line(75,253,145,253);$pdf->Line(160,253,$w,253);
$pdf->SetXY(11,263);$pdf->Cell(30,4,'Signature of parent, caregiver or guardian:',0,0,'L');$pdf->SetXY(150,263);$pdf->Cell(30,4,'Date:',0,0,'L');
$pdf->Line(75,267,145,267);$pdf->Line(160,267,$w,267);
$pdf->SetXY(31,272);$pdf->Cell(30,4,'(If no second signature, please state a reason. for example, single parent, partner on deployment)',0,0,'L');

//  -----------------------  ADD Data  --------------------------------
$pdf->SetFont('Times','B',10);
$pdf->SetXY(26,45);$pdf->Cell(150,4,$rowp['activity_name']." - ".$rows['site_name'],0,0,'C');
$pdf->SetXY(80,50);$pdf->Cell(30,4,date('d/m/Y',strtotime($row['from_date'])),0,0,'L');
$pdf->SetXY(160,50);$pdf->Cell(30,4,date('d/m/Y',strtotime($row['to_date'])),0,0,'L');
$pdf->SetXY(65,56);$pdf->Cell(80,4,$row['C4_assemble'],0,0,'L');
$pdf->SetXY(160,56);$pdf->Cell(30,4,date('g:i A',strtotime($row['C4_ass_time'])),0,0,'L');
$pdf->SetXY(65,61);$pdf->Cell(80,4,$row['C4_return'],0,0,'L');
$pdf->SetXY(160,61);$pdf->Cell(30,4,date('g:i A',strtotime($row['C4_ret_time'])),0,0,'L');
$pdf->SetXY(90,65);$pdf->Cell(30,4,$row['incharge'],0,0,'L');
$pdf->SetXY(160,65);$pdf->Cell(30,4,$row['C4_cost'],0,0,'L');
$pdf->SetFont('Times','',9);
$pdf->SetXY(48,74);$pdf->MultiCell(155,4,$row['C4_bring'],1,'L',0);
$pdf->SetFont('Times','B',10);
$pdf->SetXY(28,117);$pdf->Cell(40,4,$rowp['activity_name'],0,0);
$pdf->SetXY(100,117);$pdf->Cell(30,4,date('g:i A',strtotime($row['from_time']))." - ".date('d/m/Y',strtotime($row['from_date'])),0,0);
$pdf->SetXY(160,117);$pdf->Cell(30,4,date('g:i A',strtotime($row['to_time']))." - ".date('d/m/Y',strtotime($row['to_date'])),0,0);
// Find activities from selection, mark crosses
$acts=$rowp['activs'];
if ($acts[0]=='1') {$pdf->SetXY(10.5,199.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[1]=='1') {$pdf->SetXY(80.5,199.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[2]=='1') {$pdf->SetXY(144.5,199.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[3]=='1') {$pdf->SetXY(10.5,204.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[4]=='1') {$pdf->SetXY(80.5,204.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[5]=='1') {$pdf->SetXY(144.5,204.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[6]=='1') {$pdf->SetXY(10.5,209.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[7]=='1') {$pdf->SetXY(80.5,209.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[8]=='1') {$pdf->SetXY(144.5,209.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[9]=='1') {$pdf->SetXY(10.5,214.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[10]=='1') {$pdf->SetXY(80.5,214.5);$pdf->Cell(2,4,'X',0,0);}
if ($acts[11]=='1') {$pdf->SetXY(144.5,214.5);$pdf->Cell(2,4,'X',0,0);}


 ?>
