<?php include('../../init.php');
include(RAIZf.'head.php');?>
<body class="cero">
<div class="container">
<div class="page-header"><h1>db_indicaciones <small>Mantenimiento Base de Datos</small></h1></div>
<div class="">
<?php

$vP=TRUE;

mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

$qrypa=sprintf('SELECT * FROM bck_indica');
$RS=mysql_query($qrypa);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
$RES.='<table class="table table-bordered table-condensed"><tr>';
$RES.='<td>ID</td>';
$RES.='<td>Descripción</td>';
$RES.='<td>Estado</td>';
$RES.='</tr>';
do{
	$det=$dRS; //ASOCIO EL ROW a la variable $det
	$det_id=$det['CODIND'];
	$det_des=$det['INDICA01'];
	$detAnt=detRow('db_indicaciones','id_ant',$det_id);
	$detAnt_id=$detAnt['id'];
	
	if($det_des){
		
	$RES.='<tr>';
	$RES.='<td>'.$det_id.'</td> ';
	$RES.='<td>'.$det_des.'</td> ';
	
	$est=NULL;
	if($detAnt){//Verifico si el paciente ya ha sido migrado
		$est='Indicación Existente: '.$det_id.' - Sistema Nuevo: '.$detAnt_id;
		$contO++;
	}else{//Si no ha sido migrado lo registro
		$contC++;
		$est='Crear Indicacion';
		$qIns=sprintf('INSERT INTO db_indicaciones (id_ant,des,est) VALUES (%s,%s,%s)',
		SSQL($det_id,'int'),
		SSQL($det_des,'text'),
		SSQL(1,'int'));
		if(@mysql_query($qIns)){
			$idTemp=mysql_insert_id();
			$RES.='* Creo indicación: '.$det_id.' - Sistema nuevo: '.$idTemp.'<br>';
		}else{
			$vP=FALSE;
			$RES.='Error al crear indicación: '.$det_id.'<br>'.mysql_error();
			break;
		}
	}
	$RES.='<td>'.$est.'</td> ';
	$RES.='</tr>';
	$contT++;
	}else{
		$contTO++;
	}
}while($dRS=mysql_fetch_assoc($RS));
$RES.='</table>';
	
$RES.='<div>Registros tratados. '.intval($contT).' - Registros sin nombre medicamento (omitidos). '.intval($contTO).'</div>';
	
$RES.='<div>Registros Creados. '.intval($contC).' - Registros existentes. '.intval($contO).'</div>';

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