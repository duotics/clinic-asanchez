<?php include_once('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$det=detRow('db_documentos','id_doc',$id);//fnc_datatrat($id);
$detCon=detRow('db_consultas','con_num',$det['con_num']);//fnc_datatrat($id);
//$detpac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);//dPac($det['pac_cod']);
$dPac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);
$css[body]='cero';
include(RAIZf.'head.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>css/cssPrint_01.css" />
<div class="print print-documento">
	
	<?php
	//if($det[contenido]) $contenido = str_replace('{RAIZ}',$RAIZ,$det[contenido]);
	echo $det[contenido]//$contenido;
	?>
</div>