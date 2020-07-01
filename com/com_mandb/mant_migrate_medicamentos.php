<?php include('../../init.php');
function findDataMed($cadena){
	$parte1=explode('(',$cadena);
	$parte2=explode(')',$parte1[1]);
	$data[0] = $parte1[0];
	$data[1] = $parte2[0];
	$data[2] = $parte2[1];
	return $data;	
}
include(RAIZf.'head.php');?>
<body class="cero">
<div class="container">
<div class="page-header"><h1>db_medicamentos <small>Mantenimiento Base de Datos</small></h1></div>
<div class="">
<?php

$vP=TRUE;

mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

$qrypa=sprintf('SELECT * FROM bck_medicame');
$RSma=mysql_query($qrypa);
$dRSma=mysql_fetch_assoc($RSma);
$tRSma=mysql_num_rows($RSma);
$RES.='<table class="table table-bordered table-condensed"><tr>';
$RES.='<td>Comercial</td>';
$RES.='<td>Generico</td>';
$RES.='<td>Presentacion</td>';
$RES.='<td>Dosis</td>';
$RES.='<td>Prescripcion1</td>';
$RES.='<td>Estado</td>';
$RES.='</tr>';
do{
	$det=$dRSma; //ASOCIO EL ROW a la variable $det
	$det_id=$det['CODMED'];
	$det_med=findDataMed($det['MEDICAMENT']);
	$det_med_com=$det_med[0];
	$det_med_gen=$det_med[1];
	$det_med_pre=$det_med[2];
	$det_pre=$det['INDICA01'].$det['INDICA02'];
	$det_dos=$det['DOSIS'];
	
	$detMed=detRow('db_medicamentos','id_ant',$det_id);
	$detMed_cod=$detMed['id_form'];
	
	if($det['MEDICAMENT']){
		
	$RES.='<tr>';
	$RES.='<td>'.$det_med_com.'</td> ';
	$RES.='<td>'.$det_med_gen.'</td> ';
	$RES.='<td>'.$det_med_pre.'</td> ';
	$RES.='<td>'.$det_dos.'</td> ';
	$RES.='<td>'.$det_pre.'</td> ';
	
	
	$est=NULL;
	if($detMed){//Verifico si el paciente ya ha sido migrado
		$est='Medicamento Existente: '.$det_id.' - Sistema Nuevo: '.$detMed_cod;
		$contMO++;
	}else{//Si no ha sido migrado lo registro
		$contMC++;
		$est='Crear Medicamento';
		$qIns=sprintf('INSERT INTO db_medicamentos 
		(id_ant,generico,comercial,presentacion,cantidad,descripcion,estado) 
		VALUES (%s,%s,%s,%s,%s,%s,%s)',
		SSQL($det_id,'int'),
		SSQL($det_med_gen,'text'),
		SSQL($det_med_com,'text'),
		SSQL($det_med_pre,'text'),
		SSQL($det_dos,'text'),
		SSQL($det_pre,'text'),
		SSQL(1,'int'));
		if(@mysql_query($qIns)){
			$idTemp=mysql_insert_id();
			$RES.='* Creo Medicamento: '.$det_id.' - Sistema Nuevo: '.$idTemp.'<br>';
		}else{
			$vP=FALSE;
			$RES.='Error al Crear Medicamento: '.$det_id.'<br>'.mysql_error();
			break;
		}
	}
	$RES.='<td>'.$est.'</td> ';
	$RES.='</tr>';
	$contMT++;
	}else{
		$contMTO++;
	}
}while($dRSma=mysql_fetch_assoc($RSma));
$RES.='</table>';
	
$RES.='<div>Registros tratados. '.intval($contMT).' - Registros sin nombre medicamento (omitidos). '.intval($contMTO).'</div>';
	
$RES.='<div>Medicamenos Creados. '.intval($contMC).' - Registros existentes. '.intval($contMO).'</div>';

	if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$RES_T='<h2>TODO CORRECTO</h2>';
}else{
	mysql_query("ROLLBACK;");
	$RES_T='<h2>ALGUN PROBLEMA</h2>';
	$RES_T.=mysql_error();
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
echo $RES_T;
echo $RES;
?>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
</body>
</html>