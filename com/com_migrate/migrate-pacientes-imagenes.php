<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_pacientes_media <small>Migración Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

/*
db_pacientes-media		MAIN TABLE
db_media				RELATED TABLE (PK)

tbl_imagenes_pacientes	MAIN TABLE OLD
*/	

$vP=FALSE;

mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
$qry=sprintf('SELECT * FROM tbl_images_pacientes ORDER BY ima_pac_cod ASC');//old table hugoortiz system v.1
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
echo $qry.'<br>';
echo 'Rows. '.$tRS;
var_dump($dRS);
do{
	$contN++; //CONTADOR DE REGISTROS MIGRADOS
	$det=$dRS; //ASOCIO EL ROW a la variable $det
		
	$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';

		
		$qryIM=sprintf('INSERT INTO db_media 
		(file, estado) 
		VALUES (%s,%s)',
		SSQL($det[img_path],'text'),
		SSQL($det[img_status],'int'));
	
		if(@mysql_query($qryIM)){
			$idT=mysql_insert_id();
			$LOG.='* Creo MEDIA: '.$idT.'<br>';
			$qIMP=sprintf('INSERT INTO db_pacientes_media (cod_pac, id_med) VALUES (%s,%s)',
							  SSQL($det[pac_cod],'int'),
							  SSQL($idT,'int'));
			if(@mysql_query($qIMP)){
				$LOG.='* Creo Media Paciente.';
				$vP=TRUE;
			}else{
				$LOG.='Error al Crear Media Paciente. '.mysql_error();
				$vP=FALSE;
				break;
			}
		}else{
			$LOG.='Error al Crear Media: '.mysql_error().'<br>'.$qIMP;
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
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
<div><?php echo $LOG ?></div>
</div>
</body>
</html>