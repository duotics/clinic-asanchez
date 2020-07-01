<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_cirugias <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

/*
db_examenes		MAIN TABLE
tbl_examenes	TABLE REFERENCE
*/	
	
$vP=TRUE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
$qry=sprintf('SELECT * FROM tbl_cirugias');//old table hugoortiz system v.1
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
echo 'Rows. '.$tRS;
//var_dump($dRS);
do{
$contN++;
$det=$dRS; //ASOCIO EL ROW a la variable $det
$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';
$paramsN=NULL;
$paramsN[]=array(
	array("cond"=>"AND","field"=>"id_ant","comp"=>"=","val"=>$det[con_num]),
	array("cond"=>"AND","field"=>"pac_cod","comp"=>'=',"val"=>$det[pac_cod]));
$detC=detRowNP('db_consultas',$paramsN);
	$qryIC=sprintf('INSERT INTO db_cirugias 
	(id_cir, con_num, pac_cod, fecha, diagnostico, cirugiap, fechap, cirugiar, fechar, protocolo, evolucion) 
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
				   SSQL($det[id],'int'),
				   SSQL($detC[con_num],'int'),
				   SSQL($det[pac_cod],'int'),
				   SSQL($det[fecha],'text'),
				   SSQL($det[diagnostico],'text'),
				   SSQL($det[cirugiap],'text'),
				   SSQL($det[fechap],'text'),
				   SSQL($det[cirugiar],'text'),
				   SSQL($det[fechar],'text'),
				   SSQL($det[protocolo],'text'),
				   SSQL($det[evolucion],'text'));
	if(@mysql_query($qryIC)){
		$idT=mysql_insert_id();
		$LOG.='* Creo CIRUGIA: '.$idT.'<br>';
		//SELECT DETALLES CONSULTA OLD
		$vP=TRUE;
	}else{
		$LOG.='Error al Crear CIRUGIA. '.mysql_error().'<br>'.$qryIC;
		$vP=FALSE;
		break;
	}
$LOG.='</div>';
}while($dRS=mysql_fetch_assoc($RS));
///////////////////////////////////////////
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOG_T='<h2>TODO CORRECTO</h2>';
}else{
	mysql_query("ROLLBACK;");
	$LOG_T='<h2>ALGUN PROBLEMA</h2>';
	$LOG_T.=mysql_error();
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
echo $LOG_T;
?>
</div>
<div class="well">
	<span class="label label-default">Insertado. <?php echo $contN ?></span> 
	<span class="label label-default">Omitidos. <?php echo $contO ?></span>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
<div><?php echo $LOG ?></div>
</div>
</body>
</html>