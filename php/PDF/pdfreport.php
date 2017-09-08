<?php
require '../../resource/fpdf.php';
// receive POST data - 1st item is type of form - (5=C5, 4=C4,3=C3, F=F31, P=Program, M=Menu (frm)
//                     2rd item is EventID (idEv)
$prn_head=0;
ini_set('error_log', 'crapper.txt');
ini_set('log_errors_max_len', 0);
ini_set('log_errors', true);
ini_set('date.timezone','Australia/Brisbane');
ini_set('display_errors', 'On');

include '../../resource/dbinclude.inc';
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

$frm=$_GET['frm'];
$eid=$_GET['id'];
$OP=$_GET['OP'];
$email=$_GET['email'];

	// get Event information
$sql="SELECT * FROM AAP a INNER JOIN activType t ON a.idacttype=t.idacttype WHERE idAAP=".$eid;
if ($query = mysqli_query($con,$sql)) {
	$rowcnt=mysqli_num_rows($query);
//	echo 'rows '.$rowcnt;
	while($cldat= mysqli_fetch_assoc($query)) {
		$getit[]=$cldat;
	}
	$row=$getit[0];
//echo var_dump($row);
	mysqli_free_result($query);
}
 // get Site information for event

$sqls="SELECT site_name, address1, address2, city, notes, map_name, grid_ref, nearest_town FROM sites WHERE siteid=".$row['siteid'];
if ($query = mysqli_query($con,$sqls)) {
	$rows= mysqli_fetch_assoc($query);
}
  // get F31 info for Event

$sqlf="SELECT a.idequip, a.req, a.comments, f.item FROM AAPequip a INNER JOIN F31equip f ON f.idequip=a.idequip WHERE a.idAAP=".$eid;
  // get Program info for Event

$sqlp="SELECT activity_name, activity_type, section, activs FROM activities WHERE idact=".$row['idact'];
if ($query = mysqli_query($con,$sqlp)) {
	$rowp= mysqli_fetch_assoc($query);
}

$sqlrv="SELECT * FROM risk WHERE risk.idrisk in (SELECT idrisk FROM RiskAAP where idAAP=".$row['idAAP'].") UNION SELECT * FROM risk WHERE risk.idrisk in (select idrisk from RiskSite WHERE siteid=".$row['siteid'].") UNION SELECT * FROM risk WHERE risk.idrisk in (select idrisk from RiskActV where idact=".$row['idact'].") order by risk_name";
//echo $sqlrv;

// Create PDF footer - page number and PDF class
// position is across then down, in mm
class PDF extends FPDF {
	function header() {
		if(!empty($this->enableheader))
			call_user_func($this->enableheader,$this);
 	}

	function footer(){
		// Position at 1 cm from bottom
		$this->SetY(-10);
		// Arial italic 8
		$this->SetFont('Times','',8);
		// Text color in gray
		$this->SetTextColor(128);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}

	public $angle = 0;

	    function Rotate($angle,$x=-1,$y=-1) {

	        if($x==-1)
	            $x=$this->x;
	        if($y==-1)
	            $y=$this->y;
	        if($this->angle!=0)
	            $this->_out('Q');
	        $this->angle=$angle;
	        if($angle!=0) {
	            $angle*=M_PI/180;
	            $c=cos($angle);
	            $s=sin($angle);
	            $cx=$x*$this->k;
	            $cy=($this->h-$y)*$this->k;
	            $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	        }
	    }

}


$pdf = new PDF('P','mm','A4');
$formn='';
if (substr($frm,0,1)=="1") {include ('C5.php');$formn="C5";}
if (substr($frm,1,1)=="1") {include ('C4.php');if ($formn=="") {$formn=$formn."C4";} else {$formn=$formn."+C4";}}
if (substr($frm,2,1)=="1") {include ('F31.php');if ($formn=="") {$formn=$formn."F31";} else {$formn=$formn."+F31";}}
if (substr($frm,3,1)=="1") {include ('program.php');if ($formn=="") {$formn=$formn."Program";} else {$formn=$formn."+Program";}}
//if (substr($frm,4,1)=="1") {include ('menu.php')};if ($formn=="") {$formn=$formn."Menu"} else {$formn=$formn."+Menu"}}
//if (substr($frm,5,1)=="1") {include ('instr.php')};if ($formn=="") {$formn=$formn."Instructions"} else {$formn=$formn."+Instructions"}}
if (substr($frm,0,6)=="111111") {$formn="Event Pack";}
$filOP=$rowp['activity_name'].'-'.$rows['site_name']; //.'-'.$row['incharge']."'"; -
$subOP=$rowp['activity_name'].' at '.$rows['site_name']." - ".$row['incharge'].' in charge';

//$filOP=preg_replace("/[^a-zA-Z-]+/", "", $filOP);
$filOP=$formn."-".$filOP.".pdf";
if ($OP=='C') {
$pdf->Output('D',$filOP);
} else {
	$pdf->Output('F',$filOP);
	while (!file_exists($filOP)) sleep(1);
	if ($_SESSION['realname']>"") {$usern=$_SESSION['realname'];} else {$usern=$_SESSION['uid'];}
//	if ($_SESSION['email1']>"") {$emailad=$_SESSION['email1'];} else {$emailad="kids.admin@itmas.com.au.org.au";}
	if ($_SESSION['email1']>"") {$emailad=$_SESSION['email1'];} else {$emailad="kids.admin@kennedyscouts.org.au";}
	require_once '../../resource/class.phpmailer.php';
	include("../../resource/class.smtp.php");
	$mail=new PHPMailer(true);

	$mail->IsSMTP();
//	$mail->Host="mail.itmas.com.au";
	$mail->Host="mail.kennedyscouts.org.au";
	$mail->SMTPDebug=2;
	$mail->AddReplyTo($emailad,'Forms from '.$usern);
	$mail->AddAddress($email,'Event Forms from AAP');
	$mail->SetFrom($emailad,$usern);
	$mail->Subject=$formn.' forms for '.$rowp['activity_name'].' at '.$rows['site_name'];
	$mail->MsgHTML('Your Event Forms are attached<br>Cheers,<br><br>'.$usern);
	$mail->AddAttachment($filOP);
	if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	echo "Message sent!";
	};

}



function header2($pdf){
	// Header -------------------------------------------------------------------------------------
	$w = $pdf->GetPageWidth()-18;
	$h = $pdf->GetPageHeight()-15;
}

function headerF1($pdf){
	// Header -------------------------------------------------------------------------------------
	$w = $pdf->GetPageWidth()-18;
	$h = $pdf->GetPageHeight()-15;
	$pdf->Image('../../resource/scout_logo.gif',12,7,12);
	// Calculate width of title and position
	$pdf->SetLineWidth(0.5);
	$head1="THE SCOUT ASSOCIATION OF AUSTRALIA, QUEENSLAND BRANCH INC.";
	$head2="RISK ASSESSMENT";
	$hw1=$pdf->GetStringWidth($head1)+3;
	$hw2=$pdf->GetStringWidth($head2)+3;
	$pdf->SetFont('Times','B',10);
	$pdf->SetXY(($w-$hw1)/2,8);
	$pdf->Cell($hw1,5,$head1,0,0,'C',false);
	$pdf->SetFont('Times','',11);
	$pdf->SetXY($w-40,8);
	$pdf->MultiCell(40,6,"Form:    F31\nIssue:     1\nDate:     07/13",'','R',0);
	$pdf->SetFont('Times','B',10);
	$pdf->SetXY($w-40,24);$pdf->Cell(40,5,'To be attached to the C5',0,0,'R');
	$pdf->SetFont('Times','B',20);
	$pdf->SetXY(($w-$hw2)/2,12);
	$pdf->Cell($hw2,9,$head2,0,0,'C',false);
}

function headerF2($pdf){
	// Header -------------------------------------------------------------------------------------
	$w = $pdf->GetPageWidth()-18;
	$h = $pdf->GetPageHeight()-15;
	$pdf->Image('../../resource/scout_logo.gif',12,7,12);
	// Calculate width of title and position
	$pdf->SetLineWidth(0.5);
	$head1="THE SCOUT ASSOCIATION OF AUSTRALIA, QUEENSLAND BRANCH INC.";
	$head2="RISK ASSESSMENT";
	$hw1=$pdf->GetStringWidth($head1)+3;
	$hw2=$pdf->GetStringWidth($head2)+3;
	$pdf->SetFont('Times','B',10);
	$pdf->SetXY(($w-$hw1)/2,8);
	$pdf->Cell($hw1,5,$head1,0,0,'C',false);
	$pdf->SetFont('Times','',11);
	$pdf->SetXY($w-40,8);
	$pdf->MultiCell(40,6,"Form:    F31\nIssue:     1\nDate:     07/13",'','R',0);
	$pdf->SetFont('Times','B',10);
	$pdf->SetXY($w-40,24);$pdf->Cell(40,5,'To be attached to the C5',0,0,'R');
	$pdf->SetFont('Times','B',20);
	$pdf->SetXY(($w-$hw2)/2,12);
	$pdf->Cell($hw2,9,$head2,0,0,'C',false);
	// Additional headers section for Risks page of F31  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$pdf->SetFont('Times','B',10);
	$pdf->Rect(9,29,$w,28);
	$pdf->SetLineWidth(0.1);
	$pdf->SetXY(12,30);$pdf->MultiCell(38,4,"\n\nWhat are the activities, tasks or work hazards?",0,'C');
	$pdf->Line(52,29,52,57);$pdf->SetXY(54,30);$pdf->MultiCell(76,4,"\n\nWhat are the risks",0,'C');
	$pdf->Line(130,29,130,57);$pdf->SetXY(132,30);$pdf->MultiCell(22,4,"Risk level before mitigation",0,'C');
	$pdf->SetFont('Times','',10);$pdf->SetXY(132,30);$pdf->MultiCell(22,4,"\n\n\n(Refer Risk Analysis matrix)",0,'C');
	$pdf->Line(154,29,154,57);$pdf->SetFont('Times','B',10);$pdf->SetXY(156,30);$pdf->MultiCell(81,4,"\n\nMitigation strategies:",0,'C');
	$pdf->SetFont('Times','',10);$pdf->SetXY(156,30);$pdf->MultiCell(81,4,"\n\n\nWhat contrls are proposed to remove or reduce the risk?",0,'C');
	$pdf->Line(237,29,237,57);$pdf->SetFont('Times','B',10);$pdf->SetXY(238,30);$pdf->MultiCell(21,4,"Risk level after mitigation",0,'C');
	$pdf->SetFont('Times','',10);$pdf->SetXY(238,30);$pdf->MultiCell(21,4,"\n\n\n(Refer Risk Analysis matrix",0,'C');
	$pdf->Line(260,29,260,57);$pdf->SetFont('Times','B',10);$pdf->SetXY(261,30);$pdf->MultiCell(26,4,"*Refer to Branch? High or Extreme risk after mitigation?",0,'C');
}

function headerF3($pdf){
	// Header -------------------------------------------------------------------------------------
	$w = $pdf->GetPageWidth()-18;
	$h = $pdf->GetPageHeight()-15;
	$pdf->Image('../../resource/scout_logo.gif',12,7,12);
	// Calculate width of title and position
	$pdf->SetLineWidth(0.5);
	$head1="THE SCOUT ASSOCIATION OF AUSTRALIA, QUEENSLAND BRANCH INC.";
	$head2="EVENT PROGRAM";
	$hw1=$pdf->GetStringWidth($head1)+3;
	$hw2=$pdf->GetStringWidth($head2)+3;
	$pdf->SetFont('Times','B',10);
	$pdf->SetXY(($w-$hw1+9)/2,8);	$pdf->Cell($hw1,5,$head1,0,0,'C',false);
	$pdf->SetFont('Times','',11);
	$pdf->SetXY($w-32,8);	$pdf->MultiCell(40,6,"Form:      Pr1\nIssue:         1\nDate:     05/17",'','R',0);
	$pdf->SetFont('Times','B',20);
	$pdf->SetXY(($w-$hw2+9)/2,12);	$pdf->Cell($hw2,9,$head2,0,0,'C',false);
}


function footerF2($pdf) {
	// Position at 1 cm from bottom
	$this->SetY(-10);
	$this->SetFont('Times','B',10);
	$this->SetTextColor(128,0,0);
	$this->Cell(0,10,'Team Leaders approval',0,0,'R');
	$this->Cell(0,10,'Page number '.$this->PageNo(),0,0,'C');
	$this->SetY(-10);
	$this->SetFont('Times','',8);
	$this->SetTextColor(128);
	// Page number
	$this->Cell(0,10,'Page number'.$this->PageNo(),0,0,'C');
}



?>

<script>

	close();
</script>
