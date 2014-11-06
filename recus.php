<?php

include_once('includes/fpdf/fpdf.php');
include_once('includes/database.php');
include_once('includes/functions.php');

class PDF extends FPDF
  {
 
public function __construct()
{
parent::__construct('L','mm',array(180,260));

}


function Header()
{
$this->Image('img/jarchive.jpg',0,0,260,180);
$this->Image('img/esto_logo.jpg',3,2,20,20);
$this->Image('img/ump_logo.jpg',235,2,20,20);

}
function FancyTable($header,$proj,$doc_id)
{
	global $connect;
    $this->SetFont('Arial','B',23);
    $this->setXY(50,10);

 
    $this->Cell(90,50, utf8_decode('Ecole Supérieure de Technologie Oujda'));

    $this->SetFont('Arial','B',14);
    $this->setXY(8,30);

    $this->Cell(90,50,'projet : '.$proj);

    $this->setXY(8,50);

    $this->Cell(90,50, utf8_decode('par le(s) étudiant(s) :'));


    $this->setXY(115,105);
    $this->Cell(90,50, utf8_decode('N° du bon : '.$doc_id));

    $this->SetFont('Arial','B',12);
    $this->SetFillColor(128,128,128);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // En-tête

    $this->setXY(10,80);
    $w = array(40, 35, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
       

     $this->Ln();

   
    $this->SetFillColor(212,212,212);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données
	$fill = false;
	
    $query = mysql_query("select user_id from archive where doc_id ='".$doc_id."'",$connect);
    $rCount = mysql_num_rows($query);
    
	
       if($rCount==0)
	{
        die("Erreur 404!");
	}
	 else{
   
    for($i = 0;$i < $rCount;$i++)
			{
				$row = mysql_fetch_assoc($query);
				$user_id = $row['user_id'];
				$query2 = mysql_query("select nom,prenom,filiere from etudiants where id = '$user_id'",$connect);
				$row2 = mysql_fetch_assoc($query2);
                $this->Cell($w[0],6,ucfirst($row2['nom']),'LR',0,'R',$fill);
                $this->Cell($w[1],6,ucfirst($row2['prenom']),'LR',0,'R',$fill);
        		$this->Cell($w[2],6,$row2['filiere'],'LR',0,'R',$fill);
                $this->Ln();
                $fill = !$fill;
    }

	}

    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');


$this->SetFont('Arial','B',14);
    $this->setXY(135,50);

    $this->Cell(90,50, utf8_decode('encadré par :'));

$fill = false;
$qu = mysql_query("select encadrant from archive_2 where doc_id ='".$doc_id."'",$connect);
    $rc = mysql_num_rows($qu);
   $this->setXY(200,80);
$this->SetFont('Arial','B',12);
    $this->SetFillColor(128,128,128);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
$this->Cell(40,8,'encadrant(s) : ',1,0,'C',true);
        $this->Ln();
$try = 88;
   $this->SetFillColor(212,212,212);
    $this->SetTextColor(0);
    $this->SetFont('');
if($rc == 0)
	{
        die("Erreur 404!");
	}
	 else{
for($i = 0;$i < $rc;$i++)
    {
$rw = mysql_fetch_assoc($qu);
   $this->setXY(200,$try);
   $this->Cell(40,7, ucfirst($rw['encadrant']),'LR',0,'R',$fill);
        $this->Ln();
   $try+=7;
$fill=!$fill;
    }
}
$this->setXY(200,$try);
$this->Cell(40,0,'','T');

}


function Footer()
{
    $this->setXY(50,150);
    $this->Cell(70,30,"copyright : j'Archive/ESTO                                                                   ".date("d/m/Y"));
}
  }
if(!isset($_GET['doc_id'])){die("Erreur 404!");}

$header = array('nom', 'prenom','filiere');


$pdf = new PDF();
$pdf->AddPage();

$query=mysql_query("select sujet from documents where id='".$_GET['doc_id']."'",$connect);
$row=mysql_fetch_assoc($query);
$pdf->FancyTable($header,$row['sujet'],$_GET['doc_id']);
$pdf->Output();

?>