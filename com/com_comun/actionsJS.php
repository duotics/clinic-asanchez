<?php include('../../init.php');
$tbl=$_REQUEST['tbl'];
$field=$_REQUEST['campo'];
$param=$_REQUEST['valor'];
$id=$_REQUEST['cod'];
//PACIENTE
if($tbl=='pac'){
	$_SESSION['tab']['con']=NULL;
	$qryUpd=sprintf('UPDATE db_pacientes SET %s=%s WHERE pac_cod=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Paciente Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error al Actualizar Paciente';
		$LOG.=mysql_error();
		$res=FALSE;
	}	
}
//EXAMEN
if($tbl=='exa'){
	$_SESSION['tab']['con']='cEXA';
	$qryUpd=sprintf('UPDATE db_examenes SET %s=%s WHERE id_exa=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Resultado de Examen Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error al actualizar examenes';
		$LOG.=mysql_error();
		$res=FALSE;
	}	
}
//EXAMEN
if($tbl=='exadet'){
	$_SESSION['tab']['con']='cEXA';
	$qryUpd=sprintf('UPDATE db_examenes_det SET %s=%s WHERE id=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Resultado de Examen Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error al actualizar examenes';
		$LOG.=mysql_error();
		$res=FALSE;
	}	
}
//CONSULTA
if($tbl=='con'){
	if($id){
	$_SESSION['tab']['con']='cCON';
	$qryUpd=sprintf('UPDATE db_consultas SET %s=%s WHERE con_num=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Consulta Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error al Actualizar Consulta';
		$LOG.=mysql_error();
		$res=FALSE;
	}
	}else{
		$res=FALSE;
		$LOG.='No hay Consulta, Guardar Consulta';
	}
}
//CONSULTA DIAGNOSTICOS
if($tbl=='condiag'){
	if($id){
		if($field=='sel'){
			$qryIns=sprintf('INSERT INTO db_consultas_diagostico (con_num, id_diag) VALUES (%s,%s)',
			SSQL($id,'int'),
			SSQL($param,'int'));
			//$LOG.=$qryIns;
			if(mysql_query($qryIns)){
				$LOG.='Diagnóstico Guardado';
				$res=TRUE;
			}else{
				$LOG.='Error al Guardar Diagnóstico';
				$LOG.=mysql_error();
				$res=FALSE;
			}
		}else if($field=='otro'){
			$qryIns=sprintf('INSERT INTO db_consultas_diagostico (con_num, id_diag, obs) VALUES (%s,%s,%s)',
			SSQL($id,'int'),
			SSQL(1,'int'),
			SSQL($param,'text'));
			//$LOG.=$qryIns;
			if(mysql_query($qryIns)){
				$LOG.='Diagnóstico Guardado';
				$res=TRUE;
			}else{
				$LOG.='Error al Guardar Diagnóstico';
				$LOG.=mysql_error();
				$res=FALSE;
			}
		}else if($field=='des'){
			$qryDel=sprintf('DELETE FROM db_consultas_diagostico WHERE con_num=%s AND id_diag=%s LIMIT 1',
			SSQL($id,'int'),
			SSQL($param,'int'));
			//$LOG.=$qryDel;
			if(mysql_query($qryDel)){
				$LOG.='Diagnóstico Eliminado';
				$res=TRUE;
			}else{
				$LOG.='Error al Eliminar Diagnóstico';
				$LOG.=mysql_error();
				$res=FALSE;
			}
		}else{
			$res=FALSE;
			$LOG.='Error, Diagnostico Consulta ExP000';
		}
	/*$_SESSION['tab']['con']='cCON';
	$qryIns=sprintf('INSERT INTO db_consultas_diagostico (con_num, id_diad) VALUES (%s,%s)',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Consulta Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error al Actualizar Consulta';
		$LOG.=mysql_error();
		$res=FALSE;
	}*/
		//$LOG.=$field.'-'.$param;
	}else{
		$res=FALSE;
		$LOG.='No hay Consulta, Guardar Consulta';
	}
}
//GINECOLOGIA
if($tbl=='gin'){
	$_SESSION['tab']['con']=NULL;
	$qryUpd=sprintf('UPDATE db_pacientes_gin SET %s=%s WHERE gin_id=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Ginecologia Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error al Actualizar Ginecologia';
		$LOG.=mysql_error();
		$res=FALSE;
	}	
}
//HISTORIA CLINICA
if($tbl=='hc'){
	$_SESSION['tab']['con']=NULL;
	$qryUpd=sprintf('UPDATE db_paciente_hc SET %s=%s WHERE hc_id=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Historia Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error al Actualizar Historia Clínica';
		$LOG.=mysql_error();
		$res=FALSE;
	}	
}
echo json_encode( array( "cod"=>$id,"res"=>$res,"inf"=>$LOG) );
?>