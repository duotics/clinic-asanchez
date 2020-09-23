<?php
//MISCELANEOUS
function detRepEco_hall(){
	$val='<strong>UTERO: EN AVF DE FORMA Y TAMAÑO NORMAL.</strong> <br>
	<strong>ENDOCERVIX: NORMAL</strong> <br>
	<strong>ENDOMETRIO: </strong> <br>
	<strong>MIOMETRIO: NORMAL</strong> <br>
	<strong>ANEXO DERECHO: NORMAL</strong> <br>
	<strong>ANEXO IZQUIERO: NORMAL</strong> <br>
	<strong>DOUGLAS: LIBRE</strong>';
	return ($val);
}

function detRepEco_Ohall($obt){
	
		//"Quiste der.","Quiste izq.","Folículos der.","Folículos izq.","Masa 1","Masa 2","Masa 3","Pólipo endo",
	//"Masa ovárica der.","Masa ovárica izq.","Tumor Uterino 1","Tumor Uterino 2","Tumor Uterino 3","Tumor Cervical","Embarazo Ectópico"
	//Otros Hallazgos
	if($obt['1_Quiste']['val']){
	$valOHall.="<br>[Quiste]<br>";
	$valOHall.=clsRO($obt['1_Quiste']['val']);
	}
	if($obt['1_Folículos der.']){
	$valOHall.="<br>[Folículos der.]<br>";
	$valOHall.=clsRO($obt['1_Folículos der.']['val']);
	}
	if($obt['1_Folículos izq.']['val']){
	$valOHall.="<br>[Folículos izq.]<br>";
	$valOHall.=clsRO($obt['1_Folículos izq.']['val']);
	}
	if($obt['1_Masa 1']['val']){
	$valOHall.="<br>[Masa 1]<br>";
	$valOHall.=clsRO($obt['1_Masa 1']['val']);
	}
	if($obt['1_Masa 2']['val']){
	$valOHall.="<br>[Masa 2]<br>";
	$valOHall.=clsRO($obt['1_Masa 2']['val']);
	}
	if($obt['1_Masa 3']['val']){
	$valOHall.="<br>[Masa 3]<br>";
	$valOHall.=clsRO($obt['1_Masa 3']['val']);
	}
	if($obt['1_Pólipo endo']['val']){
	$valOHall.="<br>[Pólipo endo]<br>";
	$valOHall.=clsRO($obt['1_Pólipo endo']['val']);
	}
	if($obt['1_Masa ovárica der.']['val']){
	$valOHall.="<br>[Masa Ovárica der.]<br>";
	$valOHall.=clsRO($obt['1_Masa ovárica der.']['val']);
	}
	if($obt['1_Masa ovárica izq.']['val']){
	$valOHall.="<br>[Masa Ovárica izq.]<br>";
	$valOHall.=clsRO($obt['1_Masa ovárica izq.']['val']);
	}
	if($obt['1_Tumor Uterino 1']['val']){
	$valOHall.="<br>[Tumor Uterino 1]<br>";
	$valOHall.=clsRO($obt['1_Tumor Uterino 1']['val']);
	}
	if($obt['1_Tumor Uterino 2']['val']){
	$valOHall.="<br>[Tumor Uterino 2]<br>";
	$valOHall.=clsRO($obt['1_Tumor Uterino 2']['val']);
	}
	if($obt['1_Tumor Uterino 3']['val']){
	$valOHall.="<br>[Tumor Uterino 3]<br>";
	$valOHall.=clsRO($obt['1_Tumor Uterino 3']['val']);
	}
	if($obt['1_Tumor Cervical']['val']){
	$valOHall.="<br>[Tumor Cervical]<br>";
	$valOHall.=clsRO($obt['1_Tumor Cervical']['val']);
	}
	if($obt['1_Embarazo Ectópico']['val']){
	$valOHall.="<br>[Embarazo Ectópico]<br>";
	$valOHall.=clsRO($obt['1_Embarazo Ectópico']['val']);
	}
	return ($valOHall);
}


//FUNCIONES REPORTE OBSTETRICO
function delRepObs($idr){
	$qryDel=sprintf('DELETE FROM db_rep_obs_detalle WHERE id_rep=%s',
	GetSQLValueString($idr,'int'));
	if(@mysql_query($qryDel)){
		$LOG.='<p>Detalles Reporte Eliminados</p>';
	}else{
		$LOG.='<p>Error Eliminar Detalles Reporte</p>';
		$LOG.=mysql_error();
	}
	$det['LOG']=$LOG;
	return $det;
}
function updRepObs($idr,$obt){
	$qryUpdRep=sprintf('UPDATE db_rep_obs SET fechar=%s, fechae=%s, fum=%s, file=%s, est=%s WHERE id=%s',
	GetSQLValueString($GLOBALS['sdate'],'date'),//recha registro
	GetSQLValueString($GLOBALS['sdate'],'date'),//recha ecografia
	GetSQLValueString(datefRO(clsRO($obt['1_FUM']['val'])),'date'),
	GetSQLValueString('','text'),
	GetSQLValueString('1','int'),
	GetSQLValueString($idr,'int'));
	if(mysql_query($qryUpdRep)){
		$LOG.='<h4>Reporte Actualizado</h4>';
		$selValA=0;
		foreach ($obt as $param => $valret){
			$selVal=substr($param, 0, 1);
			if($selVal!=$selValA){
				$selValA=$selVal;
				$contRows++;	
			}
		}
	}else{
		$LOG.=mysql_error();
	}
	$det['LOG']=$LOG;
	$det['rows']=$contRows;
return $det; 
}
function updRepEco($idr,$obt){
	$valHall=detRepEco_hall();
	$valOHall=detRepEco_Ohall($obt);
	
	$qryUpdRep=sprintf('UPDATE db_rep_eco SET 
	fechae=%s, rec_utero=%s, rec_ovder=%s, obs_ovder=%s, rec_ovizq=%s, obs_ovizq=%s, eco_hall=%s, eco_ohall=%s, eco_diag=%s, 
	file=%s, est=%s WHERE id=%s',

	GetSQLValueString(datefRO(clsRO($obt['1_Exam. Date']['val'])),'date'),
	GetSQLValueString(clsRO($obt['1_Útero']['val']),'text'),
	GetSQLValueString(clsRO($obt['1_Ovario der.']['val']),'text'),
	GetSQLValueString("",'text'),
	GetSQLValueString(clsRO($obt['1_Ovario izq.']['val']),'text'),
	GetSQLValueString("",'text'),
	GetSQLValueString($valHall,'text'),
	GetSQLValueString($valOHall,'text'),
	GetSQLValueString("",'text'),

	GetSQLValueString("",'text'),
	GetSQLValueString('1','int'),
	GetSQLValueString($idr,'int'));
	if(mysql_query($qryUpdRep)){
		$LOG.='<h4>Reporte Actualizado</h4>';
	}else{
		$LOG.=mysql_error();
	}
	$det['LOG']=$LOG;
return $det; 
}
function insRepObs($idc,$idp,$obt){
	if($obt['1_FUM']['val']) $obt_FUM=datefRO(clsRO($obt['1_FUM']['val']));
	$qryInsRep=sprintf('INSERT INTO db_rep_obs (con_num, pac_cod, fechar, fechae, fum, file, est) 
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
	GetSQLValueString($idc,'int'),//consulta
	GetSQLValueString($idp,'int'),//paciente
	GetSQLValueString($GLOBALS['sdate'],'date'),//recha registro
	GetSQLValueString($GLOBALS['sdate'],'date'),//recha ecografia
	GetSQLValueString($obt_FUM,'date'),
	GetSQLValueString('','text'),
	GetSQLValueString('1','int'));
			
	if(mysql_query($qryInsRep)){
		$LOG.='<p>Reporte Creado</p>';
		$idr=mysql_insert_id();
		$selValA=0;
		foreach ($obt as $param => $valret){
			$selVal=substr($param, 0, 1);
			if($selVal!=$selValA){
				$selValA=$selVal;
				$contRows++;	
			}
		}
	}else{
		$LOG.=mysql_error();
	}
	$det['id']=$idr;
	$det['LOG']=$LOG;
	$det['rows']=$contRows;
return $det; 
}

function insRepObsDet($idr,$obt,$contRows){
	for($x=1;$x<=$contRows;$x++){
		$obt_FEP_FUM;
		$obt_FEP_EEUS;
		if($obt[$x.'_FEP(FUM)']['val']) $obt_FEP_FUM=datefRO(clsRO($obt[$x.'_FEP(FUM)']['val']));
		if($obt[$x.'_FEP(EEUS)']['val']) $obt_FEP_EEUS=datefRO(clsRO($obt[$x.'_FEP(EEUS)']['val']));
		
	$qryInsRepObs=sprintf('INSERT INTO db_rep_obs_detalle 
	(id_rep, eg_fum, eg_us, fpp_fum, fpp_ga, pes_fet, num_fet, posicion, presentacion,
	val_bio, cocientes, fcf, 
	va_snc, va_cerebelo, va_vent_lat, va_estomago, va_par_abd, va_4camcar, va_vejiga, va_rin, va_col, va_cor_umb, va_ext,
	obs)
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s, 
	%s,%s,%s,
	%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,
	%s)',
		GetSQLValueString($idr,'int'),
		GetSQLValueString(clsRO($obt[$x.'_EG(FUM)']['val']),'text'),
		GetSQLValueString(clsRO($obt[$x.'_EEUS']['val']),'text'),
		GetSQLValueString($obt_FEP_FUM,'date'),
		GetSQLValueString($obt_FEP_EEUS,'date'),	
		GetSQLValueString(clsRO($obt[$x.'_PFE']['val']),'text'),
		GetSQLValueString('','text'),
		GetSQLValueString('','text'),
		GetSQLValueString('','text'),
		
		GetSQLValueString(clsRO($obt[$x.'_Biometría fetal']['val']),'text'),
		GetSQLValueString(clsRO($obt[$x.'_Cociente']['val']),'text'),
		GetSQLValueString(clsRO($obt[$x.'_General']['val']),'text'),
		
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		GetSQLValueString('59','int'),
		
		GetSQLValueString('Biometria Fetal acorde a ','text'));
		if(mysql_query($qryInsRepObs)){
			$LOG.='<p>Detalle Reporte Creado (Feto)</p>';
		}else{
			$LOG.=mysql_error();
		}
	}
	$det['LOG']=$LOG;
	return $det; 
}
//FIN FUNCIONES REPORTE OBSTETRICO

//FUNCIONES REPORTE ECOGRAFIA
function insRepEco($idc,$idp,$obt){
	$valHall=detRepEco_hall();
	$valOHall=detRepEco_Ohall($obt);
	$qryInsRep=sprintf('INSERT INTO db_rep_eco (con_num, pac_cod, fechar, fechae, 
	rec_utero, rec_ovder, obs_ovder, rec_ovizq, obs_ovizq, 
	eco_hall, eco_ohall, file, est) 
	VALUES (%s,%s,%s,%s,
	%s,%s,%s,%s,%s,
	%s,%s,%s,%s)',
	GetSQLValueString($idc,'int'),//consulta
	GetSQLValueString($idp,'int'),//paciente
	GetSQLValueString($GLOBALS['sdate'],'date'),//recha registro
	GetSQLValueString($GLOBALS['sdate'],'date'),//recha ecografia
	
	GetSQLValueString(clsRO($obt['1_Útero']['val']),'text'),
	GetSQLValueString(clsRO($obt['1_Ovario der.']['val']),'text'),
	GetSQLValueString('DE ASPECTO NORMAL','text'),
	GetSQLValueString(clsRO($obt['1_Ovario izq.']['val']),'text'),
	GetSQLValueString('DE ASPECTO NORMAL','text'),
	
	GetSQLValueString($valHall,'text'),//Hallazgos ecografia	
	GetSQLValueString($valOHall,'text'),//Otros Hallazgos ecografia	
	GetSQLValueString('','text'),
	GetSQLValueString('1','int'));
	
	if(mysql_query($qryInsRep)){
		$LOG.='<p>Reporte Ecografico Creado</p>';
		$idr=mysql_insert_id();
	}else{
		$LOG.=mysql_error();
	}
	$det['id']=$idr;
	$det['LOG']=$LOG;
return $det; 
}

//Verifico la Reserva para Eliminarla
/*
function verifyRES($id_pac){
	$detRes=detRow2P('db_fullcalendar','pac_cod',$id_pac,'est','1',' AND ');
	if($detRes){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET est=%s WHERE id=%s LIMIT 1',
		GetSQLValueString('2', "text"),
		GetSQLValueString($detRes['id'], "int"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Reserva Actualizada</p>';
		}else{
			$LOG.='<p>Error al Actualizar Reserva</p>';
		}
	}
}
*/
//Verifico La Existencia de GINECOLOGIA
function verifyGIN($id_pac,$data){
	$detGIN=detRow('db_pacientes_gin','pac_cod',$id_pac);
	if($detGIN){
		$qryUpd=sprintf('UPDATE db_pacientes_gin SET 
		gin_men=%s, gin_fun=%s, gin_ges=%s, gin_pnor=%s, gin_pces=%s, gin_abo=%s, gin_hviv=%s, gin_hmue=%s, gin_mes=%s, gin_obs=%s 
		WHERE gin_id=%s',
		GetSQLValueString($data['gin_men'], "text"),
		GetSQLValueString($data['gin_fun'], "date"),
		GetSQLValueString($data['gin_ges'], "int"),
		GetSQLValueString($data['gin_pnor'], "int"),
		GetSQLValueString($data['gin_pces'], "int"),
		GetSQLValueString($data['gin_abo'], "int"),
		GetSQLValueString($data['gin_hviv'], "int"),
		GetSQLValueString($data['gin_hmue'], "int"),
		GetSQLValueString($data['gin_mes'], "int"),
		GetSQLValueString($data['gin_obs'], "text"),
		GetSQLValueString($detGIN['gin_id'], "int"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Registro Ginecologico Actualizado</p>';
		}else{
			$LOG.='<p>Error al Actualizar Registro Ginecologico</p>';
		}
	}else{
		$qryIns=sprintf('INSERT INTO db_pacientes_gin 
		(pac_cod, gin_men, gin_fun, gin_ges, gin_pnor, gin_pces, gin_abo, gin_hviv, gin_hmue, gin_mes, gin_obs) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		GetSQLValueString($id_pac, "int"),
		GetSQLValueString($data['gin_men'], "text"),
		GetSQLValueString($data['gin_fun'], "date"),
		GetSQLValueString($data['gin_ges'], "int"),
		GetSQLValueString($data['gin_pnor'], "int"),
		GetSQLValueString($data['gin_pces'], "int"),
		GetSQLValueString($data['gin_abo'], "int"),
		GetSQLValueString($data['gin_hviv'], "int"),
		GetSQLValueString($data['gin_hmue'], "int"),
		GetSQLValueString($data['gin_mes'], "int"),
		GetSQLValueString($data['gin_obs'], "text"));
		if(mysql_query($qryIns)){
			$LOG.= '<p>Registro Ginecologico Creado</p>';
		}else{
			$LOG.= '<p>Error al Crear Registro Ginecologico</p>';
		}
	}
	$LOG.=mysql_error();
	return ($LOG);
}

//Verifico La Existencia de Historia Clinica
function verifyHC($id_pac,$data){
	$detHC=detRow('db_paciente_hc','pac_cod',$id_pac);
	if($detHC){
		$qryUpd=sprintf('UPDATE db_paciente_hc SET hc_cir_pre=%s, hc_antf=%s, hc_antf=%s, hc_antp=%s, hc_hab=%s, hc_ale=%s, hc_cau_inf=%s, hc_cic_ra=%s, hc_obs=%s WHERE hc_id=%s',
		GetSQLValueString($data['hc_cir_pre'], "text"),
		GetSQLValueString($data['hc_antf'], "text"),
		GetSQLValueString($data['hc_antf'], "text"),
		GetSQLValueString($data['hc_antp'], "text"),
		GetSQLValueString($data['hc_hab'], "text"),
		GetSQLValueString($data['hc_ale'], "text"),
		GetSQLValueString($data['hc_cau_inf'], "text"),
		GetSQLValueString($data['hc_cic_ra'], "text"),
		GetSQLValueString($data['hc_obs'], "text"),
		GetSQLValueString($detHC['hc_id'], "int"));
		//echo $qryUpd;
		if(mysql_query($qryUpd)){
			$LOG.= '<p>Historia Clinica Actualizado</p>';
		}else{
			$LOG.= '<p>Error al Actualizar Historia Clinica</p>';
		}
	}else{
		$qryIns=sprintf('INSERT INTO db_paciente_hc (pac_cod,hc_cir_pre,hc_antf,hc_antp,hc_hab,hc_ale,hc_cau_inf,hc_cic_ra,hc_obs) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		GetSQLValueString($id_pac, "int"),
		GetSQLValueString($data['hc_cir_pre'], "text"),
		GetSQLValueString($data['hc_antf'], "text"),
		GetSQLValueString($data['hc_antp'], "text"),
		GetSQLValueString($data['hc_hab'], "text"),
		GetSQLValueString($data['hc_ale'], "text"),
		GetSQLValueString($data['hc_cau_inf'], "text"),
		GetSQLValueString($data['hc_cic_ra'], "text"),
		GetSQLValueString($data['hc_obs'], "text"));
		//echo $qryIns;
		if(mysql_query($qryIns)){
			$LOG.= '<h4>Crear Historia Clinica</h4>';
		}else{
			$LOG.= '<h4>Error Crear Historia Clinica</h4>';
		}
	}
	$LOG.=mysql_error();
	return ($LOG);
}
//FUNCION AUDITORIA
function AUD($id=NULL,$des=NULL,$eve=NULL){
	//Generación Descrición ($des), dependiendo del Evento ($eve)
	switch ($eve) {
    	case 'sysacc':{
			$_SESSION['data_access']=$GLOBALS['sdatet'];
			$des='IP. '.getRealIP();
			break;
		}
		default:{
			
		}
	}
	
	//Pregunto si existe id_aud ($id)
	if($id){
		//Pregunto Si db_auditoria Existente
		$detAud=detRow('db_auditoria','id_aud',$id);
		if($detAud){
			$id_aud=$detAud['id_aud'];
			//INSERTO db_auditoria_Detalle
			$qry=sprintf('INSERT INTO db_auditoria_detalle (id_aud, user_cod, audd_datet, audd_eve, audd_des) 
			VALUES (%s,%s,%s,%s,%s)',
			SSQL($id,'int'),
			SSQL($_SESSION[dU][u_id],'int'),
			SSQL($GLOBALS['sdatet'],'text'),
			SSQL($eve,'text'),
			SSQL($des,'text'));
			@mysql_query($qry);
		}
	}else{
		//INSERT db_auditoria
		$qryAud=sprintf('INSERT INTO db_auditoria (aud_datet) 
		VALUES (%s)',
		SSQL($GLOBALS['sdatet'],'text'));
		@mysql_query($qryAud);
		$id_aud=mysql_insert_id();
		
		//INSERT db_auditoria_detalle
		$qryAudDet=sprintf('INSERT INTO db_auditoria_detalle (id_aud, user_cod, audd_datet, audd_eve, audd_des) 
		VALUES (%s,%s,%s,%s,%s)',
		SSQL($id_aud,'int'),
		SSQL($_SESSION[dU][u_id],'int'),
		SSQL($GLOBALS['sdatet'],'text'),
		SSQL($eve,'text'),
		SSQL($des,'text'));
		@mysql_query($qryAudDet);
	}
	return($id_aud);
}
//Datos AUDITORIA
function infAud($id){
	$detAudi=dataAud($id,'ASC');
	$detAudi_id=$detAudi['id'];
	$detAudi_user=$detAudi['emp_nom'].' '.$detAudi['emp_ape'];
	$detAudi_inf='<small>'.$detAudi_user.' '.$detAudi['audd_datet'].'</small>';

	$detAudf=dataAud($id,'DESC');
	$detAudf_id=$detAudf['id'];
	
	if($detAudi_id!=$detAudf_id){
		$detAudf_user=$detAudf['emp_nom'].' '.$detAudf['emp_ape'];
		$detAudf_inf="Actualización. ".$detAudf_user.' '.$detAudf['audd_datet'];
	}
	
	$infAud='<span title="'.$detAudf_inf.'" class="tooltips">'.$detAudi_inf.'</span>';
return $infAud;
}

function dataAud($param1,$ord='DESC'){
	$query_RS_datos = sprintf('SELECT * FROM db_auditoria_detalle 
	LEFT JOIN db_user_system ON db_auditoria_detalle.user_cod=db_auditoria_detalle.user_cod 
	INNER JOIN db_empleados ON db_user_system.emp_cod=db_empleados.emp_cod 
	WHERE db_auditoria_detalle.id_aud=%s ORDER BY db_auditoria_detalle.id %s LIMIT 1',
	SSQL($param1,'text'),
	SSQL($ord,''));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}
?>