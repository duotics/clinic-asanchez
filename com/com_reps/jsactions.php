<?php include('../../init.php');
$LOG='';
$tbl=(isset($_REQUEST['tbl']) ? $_REQUEST['tbl'] : NULL);
$field=(isset($_REQUEST['campo']) ? $_REQUEST['campo'] : NULL);
$param=(isset($_REQUEST['valor']) ? $_REQUEST['valor'] : NULL);
$id=(isset($_REQUEST['cod']) ? $_REQUEST['cod'] : NULL);

if($tbl=='repObs'){
	$qryInsRepDet=sprintf('UPDATE db_rep_obs_detalle SET %s=%s WHERE id=%s',
	GetSQLValueString($field,''),
	GetSQLValueString($param,'text'),
	GetSQLValueString($id,'int'));
	if(mysql_query($qryInsRepDet)){
		$LOG.='Datos Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error Actualizar. ';
		$LOG.=mysql_error();
		$res=FALSE;
	}
}
if($tbl=='repEco'){
	if($id){
	$qryInsRepDet=sprintf('UPDATE db_rep_eco SET %s=%s WHERE id=%s',
	GetSQLValueString($field,''),
	GetSQLValueString($param,'text'),
	GetSQLValueString($id,'int'));
	if(mysql_query($qryInsRepDet)){
		$LOG.='Datos Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error Actualizar. ';
		$LOG.=mysql_error();
		$res=FALSE;
	}
	}else{
		$LOG.='No Olvide GUARDAR->';
	}
}
echo json_encode( array( "cod"=>$id,"res"=>$res,"inf"=>$LOG) );
?>