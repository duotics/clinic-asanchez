<?php include('../../init.php');
set_time_limit(300);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_tratamientos <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

/*
db_diagnosticos		MAIN TABLE
tbl_diagnosticos	TABLE REFERENCE
*/	
	
$vP=TRUE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
///////////////////////////////////////////
$qry=sprintf('SELECT * FROM tbl_tratamientos');//old table hugoortiz system v.1
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
echo 'Rows. '.$tRS;
//var_dump($dRS);
do{
	$contN++;
	$det=$dRS; //ASOCIO EL ROW a la variable $det
	$LOG.='<div style="border-bottom:1px solid #ccc; padding:5px 0;">';
	if(($det[con_num]>0)&&($det[pac_cod]>0)){
		$paramsN=NULL;
		$paramsN[]=array(
			array("cond"=>"AND","field"=>"id_ant","comp"=>"=","val"=>$det[con_num]),
			array("cond"=>"AND","field"=>"pac_cod","comp"=>'=',"val"=>$det[pac_cod]));
		$detC=detRowNP('db_consultas',$paramsN);
		if($detC){
			$qryIT=sprintf('INSERT INTO db_tratamientos 
			(con_num, pac_cod, diagnostico, fecha) 
			VALUES (%s,%s,%s,%s)',
			SSQL($detC[con_num],'int'),
			SSQL($det[pac_cod],'int'),
			SSQL($det[diagnostico],'text'),
			SSQL($det[fecha],'text'));

			if(@mysql_query($qryIT)){
				$idT=mysql_insert_id();
				$LOG.='* Creo TRATAMIENTO: '.$idT.'<br>';
				//SELECT DETALLES CONSULTA OLD
				$qryTD=sprintf('SELECT * FROM tbl_tratamientos_det WHERE tid=%s',
							SSQL($det[tid],'int'));//old table hugoortiz system v.1
				$RStd=mysql_query($qryTD);
				$dRStd=mysql_fetch_assoc($RStd);
				$tRStd=mysql_num_rows($RStd);
				//echo 'Rows TD. '.$tRStd;
				if($tRStd>0){//Si existen tratamientos detalle procedo
					do{
						//CREO DETALLES DE LA CONSULTA
						$detTD=$dRStd;
						$qryITD=sprintf('INSERT INTO db_tratamientos_detalle 
						(tid, idref, tip, generico, presentacion, numero, descripcion)
						VALUES (%s,%s,%s,%s,%s,%s,%s)',
									   SSQL($idT,'int'),
									   SSQL(1,'text'),//db_medicamentos id=1 es un registro general
									   SSQL('M','text'),//Tipo: M=Medicamento, I=Indicacion
									   SSQL($detTD[medicamento],'text'),
									   SSQL($detTD[presentacion],'text'),
									   SSQL($detTD[numero],'text'),
									   SSQL($detTD[instrucciones],'text'));
						if(@mysql_query($qryITD)){
							$vP=TRUE;
							$LOG.='* Creo DETALLE DE TRATAMIENTO: '.$idT.'<br>';
						}else{
							$LOG.='Error al Crear DETALLE DE TRATAMIENTO. '.mysql_error().'<br>'.$qryID;
							$vP=FALSE;
							break;
						}

					}while($dRStd=mysql_fetch_assoc($RStd));
					if($vP==FALSE) break;
				}
			}else{
				$LOG.='Error al Crear TRATAMIENTO. '.mysql_error().'<br>'.$qryID;
				$vP=FALSE;
				break;
			}
		$LOG.='</div>';

		}
	}else{
		$contO++;
	}
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