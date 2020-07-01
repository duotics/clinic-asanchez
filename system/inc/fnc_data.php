<?php
function detRowNP($table,$params){ //v1.0
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	$qry = sprintf("SELECT * FROM %s WHERE 1=1 ".$lP,
	SSQL($table, ''));
	$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS);
	mysql_free_result($RS);
	return ($dRS);
}
//Verifico la Reserva para Eliminarla
function verifyRESid($id){
	$detRes=detRow('db_fullcalendar','id',$id);
	if($detRes){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET est=%s WHERE id=%s LIMIT 1',
		SSQL('2', "text"),
		SSQL($id, "int"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Reserva Actualizada</p>';
		}else{
			$LOG.='<p>Error al Actualizar Reserva</p>';
		}
	}
	return $LOG;
}

//Verifico la Reserva para Eliminarla el dia actual
function verifyREShis($idp){
	//$qry=sprintf('SELECT * FROM ');
	//$detRes=detRow('db_fullcalendar','id',$id);
	//if($detRes){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET est=%s WHERE pac_cod=%s AND fechai=%s AND est=1 LIMIT 1',
		SSQL('2', "text"),
		SSQL($idp, "int"),
		SSQL($GLOBALS['sdate'], "date"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Reserva Actualizada</p>';
		}
		
		return $LOG;
		//else{
			//$LOG.='<p>Error al Actualizar Reserva</p>';
		//}
	//}
}



//Verifico la Reserva para Eliminarla
function verifyRES($idp){
	$detRes=detRow2P('db_fullcalendar','pac_cod',$idp,'est','1',' AND ');
	if($detRes){
		$qryUpd=sprintf('UPDATE db_fullcalendar SET est=%s WHERE id=%s LIMIT 1',
		SSQL('2', "text"),
		SSQL($detRes['id'], "int"));
		if(mysql_query($qryUpd)){
			$LOG.='<p>Reserva Actualizada</p>';
		}else{
			$LOG.='<p>Error al Actualizar Reserva</p>';
		}
	}
}

//Datos TYPES (db_types) [OK nueva version este si va]
function dTyp($param){ $qry = sprintf("SELECT * FROM  db_types WHERE typ_cod=%s",SSQL($param,'text'));
$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS); 
mysql_free_result($RS);return ($dRS);
}

function genCadSearchPac($term){

if ($term){
	$cadBus=fnc_cutblanck($term);
	$cadBusT=explode(" ",$cadBus);
  	$cadBusN=count($cadBusT);
	//echo $cadBusN;
	if($cadBusN>1){
		$qry=sprintf('SELECT *, MATCH (db_pacientes_nom.pac_nom, db_pacientes_nom.pac_ape) AGAINST (%s) AS Score FROM db_pacientes_nom
		INNER JOIN db_pacientes ON db_pacientes.pac_cod=db_pacientes_nom.pac_cod
		WHERE MATCH (db_pacientes_nom.pac_nom, db_pacientes_nom.pac_ape) AGAINST (%s)
		ORDER BY Score DESC ',
					 SSQL($cadBus,'text'),
					 SSQL($cadBus,'text'));
	}else{
		$qry=sprintf('SELECT * FROM db_pacientes_nom
		INNER JOIN db_pacientes ON db_pacientes.pac_cod=db_pacientes_nom.pac_cod
		WHERE db_pacientes.pac_nom LIKE %s OR db_pacientes.pac_ape LIKE %s OR db_pacientes.pac_cod LIKE %s ',
					 SSQL('%'.$cadBus.'%','text'),
					 SSQL('%'.$cadBus.'%','text'),
					 SSQL('%'.$cadBus.'%','text'));
	}
}else{
	$qry=sprintf('SELECT * FROM db_pacientes ORDER BY pac_cod DESC ');
}
return $qry;
}
//Datos Modulo Componente
function detMod($param1){ $qry = sprintf("SELECT * FROM db_componentes WHERE mod_cod=%s", SSQL($param1,'text'));
$RS=mysql_query($qry) or die(mysql_error()); $dRS=mysql_fetch_assoc($RS); 
return ($dRS); mysql_free_result($RS);
}
//ESTADO FACTURA
function estCon($est){
	switch($est){
		case '0':
			$stat['txt']='Anulada';
			$stat['inf']='<a class="btn disabled btn-danger navbar-btn">Anulada <i class="fa fa-check-square-o"></i></a>';
		break;
		case '1':
			$stat['txt']='Tratada';
			$stat['inf']='<a class="btn disabled btn-info navbar-btn">Tratada <i class="fa fa-check-square-o"></i></a>';
		break;
		case '2':
			$stat['txt']='Actualizada';
			$stat['inf']='<a class="btn disabled btn-info navbar-btn">Finalizada <i class="fa fa-check-square-o"></i></a>';
		break;
		case '3':
			$stat['txt']='Reservada';
			$stat['inf']='<a class="btn btn-info navbar-btn">Reservada <i class="fa fa-check-square-o"></i></a>';
		break;
		default:
			$stat['txt']='NO GUARDADA';
			$stat['inf']='<a class="btn disabled btn-danger navbar-btn">NO GUARDADA <i class="fa fa-arrow-circle-right"></i></a>';
	}
	return($stat);
}

function estCon_old($est){
	if($est=='0'){
		$stat['txt']='Pendiente';
		$stat['inf']='<a class="btn disabled btn-info navbar-btn">Pendiente <i class="fa fa-exclamation-circle"></i></a>';
	}else if($est=='1'){
		$stat['txt']='Tratada';
		$stat['inf']='<a class="btn disabled btn-info navbar-btn">Tratada <i class="fa fa-check-square-o"></i></a>';
	}else if($est=='2'){
		$stat['txt']='Finalizada';
		$stat['inf']='<a class="btn disabled btn-danger navbar-btn">Finalizada <i class="fa fa-check-square-o"></i></a>';
	}else if($est=='3'){
		$stat['txt']='Anulada';
		$stat['inf']='<a class="btn disabled btn-danger navbar-btn">Anulada <i class="fa fa-check-square-o"></i></a>';
	}else if($est=='5'){
		$stat['txt']='Reservada';
		$stat['inf']='<a class="btn btn-info navbar-btn">Reservada <i class="fa fa-check-square-o"></i></a>';
	}else if(!$est){
		$stat['txt']='NO GUARDADA';
		$stat['inf']='<a class="btn disabled btn-danger navbar-btn">NO GUARDADA <i class="fa fa-arrow-circle-right"></i></a>';
	}
	return($stat);
}

//ULTIMA IMAGEN DE UN PACIENTE
function lastImgPac($param1){
$detPacMed=detRow('db_pacientes_media','cod_pac',$param1,'id','DESC');
if($detPacMed){
	$detMed=detRow('db_media','id_med',$detPacMed['id_med']);
}
return $detMed['file'];
}

function paramsRepObs($file){
$archivo = file($file);
//echo $file.'<br>';
$valR='';
$contLines=0;
$banV=FALSE;
$iniBan=FALSE;
$contFetos=1;
$banFeto=FALSE;
foreach ($archivo as $linea_num => $linea){
	$str = $linea;
	$fc=substr($str, 0, 1);
	if(trim($fc)){//Verifica que la linea no sea vacia
		$findFet=substr($str, 1, 4);
	//echo "<h2>**FETO**".$findFet.'</h2>';
	if(($fc=='[')||($fc=='-')||($fc=='*')){
		//Sumon Feto
		if($fc=='*'){
			$banIniFet=TRUE;
			$contFetos=1;
			$banV=TRUE;
			$iniBan=FALSE;
			$contLines=0;
		}else{
			if($findFet=='Feto'){
				//echo "<h2>**FETO_ENCONTRADO**".$contFetos.'</h2>';
				if($banIniFet==TRUE){
					$contFetos=0;
					$banIniFet=FALSE;
				}
				$banFeto=TRUE;
				$banV=TRUE;
				$iniBan=FALSE;
				$contLines=0;
			}
		}
		
		if($contLines>1){			
			$banV=TRUE;
			$iniBan=TRUE;
			$strCor=$str;
   		}
		
	}else{
		if($iniBan==TRUE){
			$valR.=$str.'<br>';
			$val[0]=$strCor;
			$banV=FALSE;
			$acc=TRUE;
		}else{
			if($acc==TRUE){
				$acc=FALSE;
			}else{
				$banV=TRUE;
				$val=(explode(":",$str));
   				$contT=count($val);
   				if(($contT>1)&&($val[1])){
   					$valR=$val[1];
   				}
			}
   		}
	}//If direfente Corchete
	if($banV==TRUE){
		$val[0]=$contFetos.'_'.$val[0];
   		$return[$val[0]]['nom']=$val[0];
		$return[$val[0]]['val']=$valR;
   		$banV=FALSE;
		$valR='';
		
		if($banFeto==TRUE){
			$banFeto=FALSE;
			$contFetos++;
		}

		
	}  
	}
	$contLines++;
}
//echo "<h1>VER LA MATRIZ PRINCIPAL</h1>";
//var_dump($return);
//echo "<p>VER RESULTADOS</p>";

foreach ($return as $param => $valret){
	//$param=utf8_encode($param); REPORTES DE NUEVO ECOGRAFO YA VIENE EN UTF-8
	
	$param_orig=$param;
	$matrix=substr($param,0,1);
	$param=substr($param,2);
	//echo substr($param,0,-2).'<br>';
	$param=trim($param,"\0, \t, \n, \x0B, \r, ,[,]");
	$arrayParams=array("FUM","FEP(FUM)","EG(FUM)","EEUS","FEP(EEUS)","PFE","EG(PFE)",
	"Biometría fetal","Cociente","General","Cráneo fetal");
	if(in_array($param,$arrayParams)){
		$returnFin[$matrix.'_'.$param]['val']=$valret['val'];
	}
	//else echo $param_orig.'<input type="text" value="'.$param.'">'.$param.' : '.$valret['val'].'<hr>';
}


return $returnFin;
}

//ALGORITMO LECTURA ECOGRAFIA TRNASVAGINAL-ABDOMINAL
function paramsRepEco($file){
$archivo = file($file);
$valR='';
$contLines=0;
$banV=FALSE;
$iniBan=FALSE;
$contFetos=1;
$banFeto=FALSE;
foreach ($archivo as $linea_num => $linea){
	$str = $linea;
	$fc=substr($str, 0, 1);
	if(trim($fc)){//Verifica que la linea no sea vacia
		$findFet=substr($str, 1, 4);
	//echo "<h2>**FETO**".$findFet.'</h2>';
	if(($fc=='[')||($fc=='-')||($fc=='*')){
		//Sumon Feto
		if($fc=='*'){
			$banIniFet=TRUE;
			$contFetos=1;
			$banV=TRUE;
			$iniBan=FALSE;
			$contLines=0;
		}else{
			if($findFet=='Feto'){
				//echo "<h2>**FETO_ENCONTRADO**".$contFetos.'</h2>';
				if($banIniFet==TRUE){
					$contFetos=0;
					$banIniFet=FALSE;
				}
				$banFeto=TRUE;
				$banV=TRUE;
				$iniBan=FALSE;
				$contLines=0;
			}
		}
		
		if($contLines>1){			
			$banV=TRUE;
			$iniBan=TRUE;
			$strCor=$str;
   		}
		
	}else{
		if($iniBan==TRUE){
			$valR.=$str.'<br>';
			$val[0]=$strCor;
			$banV=FALSE;
			$acc=TRUE;
		}else{
			if($acc==TRUE){
				$acc=FALSE;
			}else{
				$banV=TRUE;
				$val=(explode(":",$str));
   				$contT=count($val);
   				if(($contT>1)&&($val[1])){
   					$valR=$val[1];
   				}
			}
   		}
	}//If direfente Corchete
	if($banV==TRUE){
		$val[0]=$contFetos.'_'.$val[0];
   		$return[$val[0]]['nom']=$val[0];
		$return[$val[0]]['val']=$valR;
   		$banV=FALSE;
		$valR='';
		
		if($banFeto==TRUE){
			$banFeto=FALSE;
			$contFetos++;
		}

		
	}  
	}
	$contLines++;
}
//echo "<h1>VER LA MATRIZ PRINCIPAL</h1>";
//var_dump($return);
//echo "<p>VER RESULTADOS</p>";

foreach ($return as $param => $valret){
	//$param=utf8_encode($param); //Nuevos Reportes ya estan codificados en UTF-8
	
	$param_orig=$param;
	$matrix=substr($param,0,1);
	$param=substr($param,2);
	//echo substr($param,0,-2).'<br>';
	$param=trim($param,"\0, \t, \n, \x0B, \r, ,[,]");
	$arrayParams=array("Exam. Date","Útero","Ovario der.","Ovario izq.",
	"Quiste","Folículos der.","Folículos izq.","Masa 1","Masa 2","Masa 3","Pólipo endo",
	"Masa ovárica der.","Masa ovárica izq.","Tumor Uterino 1","Tumor Uterino 2","Tumor Uterino 3","Tumor Cervical","Embarazo Ectópico");
	if(in_array($param,$arrayParams)){
		$returnFin[$matrix.'_'.$param]['val']=$valret['val'];
		//echo $param_orig.' *** '.$param.' *** '.$valret['val']; echo '<hr>';
	}
	//else echo $param_orig.'<input type="text" value="'.$param.'">'.$param.' : '.$valret['val'].'<hr>';
}

//var_dump($returnFin);
return $returnFin;
}

/************************************************************************************************************
	FUNCIONES DATOS (seleccionados), para seleccionarlos dento del Generar Select
************************************************************************************************************/
function detRowSel($table,$fielID,$field,$param){
	$query_RS_datos = sprintf('SELECT %s as sID FROM %s WHERE %s=%s',
	GetSQLValueString($fielID,''),
	GetSQLValueString($table,''),
	GetSQLValueString($field,''),
	GetSQLValueString($param,'text'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	if($totalRows_RS_datos>0){ $x=0;
		do{ $listCats[$x]=$row_RS_datos['sID']; $x++;
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	}
	mysql_free_result($RS_datos);
	return ($listCats);
}

function detRowGSel($table,$fieldID,$fieldVal,$field,$param,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v1.0
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=%s %s',
	SSQL($fieldVal,''),
	SSQL($fieldID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($orderBy,''));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

//
function detRowGSel_ant($table,$fieldID,$fieldVal,$field,$param){
$query_RS_datos = sprintf('SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=%s',
SSQL($fieldVal,''),
SSQL($fieldID,''),
SSQL($table,''),
SSQL($field,''),
SSQL($param,'text'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}

function detRowGSelNP($table,$fieldID,$fieldVal,$params,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v0.2
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 '.$lP.' %s',
	SSQL($fieldID,''),
	SSQL($fieldVal,''),
	SSQL($table,''),
	SSQL($orderBy,''));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

function detRow($table,$field,$param,$foN=NULL, $foF='ASC'){//v1.0
	if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
	$qry = sprintf("SELECT * FROM %s WHERE %s = %s ".$paramOrd.' LIMIT 1',
	SSQL($table, ''),
	SSQL($field, ''),
	SSQL($param, "text"));
	$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS); 
	mysql_free_result($RS); return ($dRS);
}

function detRow_ant($table,$field,$param){ $query_RS_datos = sprintf("SELECT * FROM %s WHERE %s = %s",
GetSQLValueString($table, ''),
GetSQLValueString($field, ''),
GetSQLValueString($param, "text"));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos de una TABLA / CAMPO / CONDICION
function detSigLast($id){ $query_RS_datos = sprintf("SELECT * FROM db_signos WHERE pac_cod = %s ORDER BY id DESC",
GetSQLValueString($id, "int"));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos de una TABLA / CAMPO / CONDICION
function detRow2P($table,$field1,$param1,$field2,$param2,$cond){
$query_RS_datos = sprintf("SELECT * FROM %s WHERE %s=%s %s %s=%s",
GetSQLValueString($table, ''),
GetSQLValueString($field1, ''),
GetSQLValueString($param1, "text"),
GetSQLValueString($cond, ""),
GetSQLValueString($field2, ""),
GetSQLValueString($param2, "text"));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Modulo
function fnc_datamod($param1){ $query_RS_datos = "SELECT * FROM db_componentes WHERE mod_ref='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos Empleados
function dataEmp($param1){
	$query_RS_datos = sprintf('SELECT * FROM db_empleados WHERE emp_cod=%s LIMIT 1',
	GetSQLValueString($param1,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos TYPES (db_types)
function fnc_datatyp($param1){ $query_RS_datos = "SELECT * FROM  db_types WHERE typ_cod='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos Usuario Systema
function dataUser($param1){
	$query_RS_datos = sprintf('SELECT * FROM db_user_system WHERE user_username=%s LIMIT 1',
	GetSQLValueString($param1,'text'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos paciente
function dataPac($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_pacientes WHERE db_pacientes.pac_cod = %s", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos paciente
function dataPachis($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_signos WHERE db_signos.pac_cod = %s ORDER BY id DESC LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Diagnostico Definitivo
function fnc_datadiagd($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_diagnosticos WHERE db_diagnosticos.id= %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Tratamiento
function fnc_datatrat($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_tratamientos WHERE tid= %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Tratamiento Detalle
function fnc_datatratd($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_tratamientos_detalle WHERE id= %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Obstetrico
function fnc_dataObs($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_obstetrico WHERE obs_id= %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Obstetrico Detalle
function fnc_dataObsd($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_obstetrico_detalle WHERE id= %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}


//Datos Examen
function fnc_dataexam($param1){
	$query_RS_datos = sprintf("SELECT * FROM  db_examenes WHERE id = %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Documento Formato
function fnc_datadocf($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_documentos_formato WHERE id_df = %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Documento
function fnc_datadoc($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_documentos WHERE id_doc = %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Cirugia
function fnc_datacir($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_cirugias WHERE id = %s LIMIT 1", GetSQLValueString($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
	
//TOT ROWS
function totRowsTab($table,$field=NULL,$param=NULL,$cond='='){//v.1.1
	// $table -> Table database
	// $field -> Campo cond
	if(($field)&&($param)){
		$qryCond=sprintf(' WHERE %s %s %s',
						SSQL($field,''),
						SSQL($cond,''),
						SSQL($param,'text'));
	}
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s '.$qryCond,
	SSQL($table,''));
	$RS = mysql_query($qry) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RS);
	//echo $qry.'<br>';
	return ($dRS['TR']);/*SHow me a integer value (count) of parameters*/
}
function totRowsTabP($table,$param=NULL){//v.1.1
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s WHERE 1=1 '.$param,
	SSQL($table,''));
	$RS = mysql_query(stripslashes($qry)) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RS);
	return ($dRS['TR']);
}

function totRowsTab_ant($table,$field,$param){
	$query_RS_datos = sprintf('SELECT * FROM %s WHERE %s=%s',
	GetSQLValueString($table,''),
	GetSQLValueString($field,''),
	GetSQLValueString($param,'text'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($totalRows_RS_datos);
}
function getParamSQLA($params){
	if($params){
		foreach($params as $val){
			if(!$val[3]) $val[3]=' AND ';
			$qryParam.=$val[3].' '.$val[0].' '.$val[1].' "'.$val[2].'"';
		}
	}
	return $qryParam;
}

?>