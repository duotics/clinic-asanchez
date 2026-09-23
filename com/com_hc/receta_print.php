<?php require_once('../../init.php');
$idt=vParam('idt', isset($_GET['idt']) ? $_GET['idt'] : NULL, isset($_POST['idt']) ? $_POST['idt'] : NULL);
    // GET HTML
	ob_start();
    include('receta.php');
    $content = ob_get_clean();
    // convert in PDF
    try{
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('Receta.pdf');
    }catch(HTML2PDF_exception $e) { echo $e; exit; }
	ob_end_flush();
?>