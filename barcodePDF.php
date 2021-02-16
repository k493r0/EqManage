<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit();
}
if ($_SESSION['username'] != 'administrator'){
    header('Location: index.php?adminonly=1');
}
// Include the main TCPDF library (search for installation path).
require __DIR__ . '/vendor/autoload.php';
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Yuki Kume');
$pdf->SetTitle('EqManage Barcode Print');
$pdf->SetSubject('Barcode Print');
$pdf->SetKeywords('Barcode Print');
// set default header data
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('dejavusans', '', 10);
// add a page
$pdf->AddPage();

$html = '
';

$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
$redColor = [255, 0, 0];
include('serverconnect.php');

$getbarcode = mysqli_query($db,"select * from equipment");
$html .= '
<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <th colspan="3">Equipment Barcode</th>
 </tr>
 <tr nobr="true">
';

$index = 0;
while ($row = mysqli_fetch_array($getbarcode)){
    if ($index%3 == 0 && $index!=0){
        $html .= "</tr><tr nobr='true'>";
    }//If three columns are filled with barcode, it creates a new row
    $equipment_name = $row['equipment'];
    $barcodeID = $row['barcodeID'];
    $html .= "<td>".$equipment_name."<br />";
    $params = $pdf->serializeTCPDFtagParameters(array($barcodeID, 'C128', '', '', 58, 30, 0.4,
        array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>4), 'N'));
    $html .= '<tcpdf method="write1DBarcode" params="'.$params.'" /></td>';//^Generating barcode, and concatenating it into the html variable
    $index++;
}
if ($index%3 != 0){
    $html .= "</tr>";
}
$html .= '</table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document
$pdf->Output('barcode.pdf', 'I');

