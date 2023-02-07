<?php

function genSelectManual($nom=NULL, $data, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni='Select'){
	//Version 3.2 
	/* PARAMS
	$nom. attrib 'name' for <select>
	$data. Data Recordset
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
	*/
	if($data){	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value=""';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$valIni.'</option>';	
	}
	foreach($data as $xid => $xval){
		echo '<option value="'.$xval.'"'; 
		if(is_array($sel)){ if(in_array($xval,$sel)) echo 'selected="selected"'; }
		else{ if (!(strcmp($xval, $sel))) echo 'selected="selected"'; }
		echo '>'.$xid.'</option>';
	}
	echo '</select>';
	}else{
		echo '<span class="label label-danger">Error genSelectManual : '.$nom.'</span>';
	}
}


function detRowGCheck($table,$fieldID,$fieldVal,$field,$param,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE %s=%s %s',
	SSQL($fieldID,''),
	stripslashes($fieldVal),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($orderBy,''));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

//FUNCION PARA GENERAR CHECKBOX MULTIPLE
function genCheck($nom=NULL, $RS, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL){
	/* Version 1.0.1
	PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected array list items selected in checkbox
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select> */
	if($RS){
		$dRS = mysql_fetch_assoc($RS);
		$tRS = mysql_num_rows($RS);
		$retVal.='<div>';
		if($tRS>0){
			do {
				echo ' <label class="checkbox-inline"><input type="checkbox" name="'.$nom.'" value="'.$dRS['sID'].'"'; 
				if(is_array($sel)){ if(in_array($dRS['sID'],$sel)){ echo 'checked="checked"'; }
				}else{ if (!(strcmp($dRS['sID'], $sel))) {echo 'checked="checked"';} }
				echo '> '.$dRS['sVAL'].' </label>';
			} while ($dRS = mysql_fetch_assoc($RS));
			$rows = mysql_num_rows($RS);
			if($rows > 0) {
				mysql_data_seek($RS, 0);
				$dRSe = mysql_fetch_assoc($RS);
			}
		}	
		mysql_free_result($RS);
		$retVal.='</div>';
	
	}else{
		$retVal.='<span class="label label-danger">Error genCheck : '.$nom.'</span>';
	}
	return($retVal);
}

function verifyCheckUserMenu($idm,$idu){

	$q=sprintf('SELECT * FROM db_menus_user WHERE men_id=%s AND user_cod=%s',

	SSQL($idm,'int'),

	SSQL($idu,'int'));

	$RS=mysql_query($q);

	echo mysql_error();

	$tRS=mysql_num_rows($RS);

	if($tRS>0) return 'checked';

	else return NULL;

}

function insRow($table,$params){//v.0.1

	$pIndex=implode(',',array_keys($params));

	$pValue=implode(',',array_values($params));

	$qry=sprintf('INSERT INTO %s (%s) VALUES (%s)',

				SSQL($table,''),

				SSQL($pIndex,''),

				SSQL($pValue,''));

	if(@mysql_query($qry)){

		$ret['est']=TRUE;

		$ret['id']=@mysql_insert_id();

		$ret['log']='Creado correctamente';

	}else{

		$ret['est']=FALSE;

		$ret['log']='Error. '.mysql_error();

	}

	return($ret);

}



function genStatus($dest,$params,$css=NULL){//v.2.0

$firstP=TRUE;

foreach($params as $x => $xVal) {

    if($x=='val'){

		if($xVal==1){

			$xVal=0;

			$cssST='btn btn-success btn-xs';

			$txtST='<span class="glyphicon glyphicon-ok"></span>';

		}else{

			$xVal=1;

			$cssST='btn btn-warning btn-xs';

			$txtST='<span class="glyphicon glyphicon-remove"></span>';

		}

	}

	if($firstP==TRUE){

		$lP.='?'.$x.'='.$xVal;

		$firstP=FALSE;

	}else $lP.='&'.$x.'='.$xVal;

}

$st='<a href="'.$dest.$lP.'" class="'.$cssST.' '.$css.'">'.$txtST.'</a>';

return $st;

}



function edadC($dateBorn){

	if($dateBorn){

	$dateAct = $GLOBALS['sdate']; // separamos en partes las fechas 

	$array_nacimiento = explode ( "-", $dateBorn ); 

	$array_actual = explode ( "-", $dateAct ); 

	$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 

	$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 

	$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 

	//ajuste de posible negativo en $días 

	if ($dias<0){

		--$meses; 

		//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 

		switch ($array_actual[1]) { 

			   case 1:     $dias_mes_anterior=31; break; 

			   case 2:     $dias_mes_anterior=31; break; 

			   case 3:  

					if (bisiesto($array_actual[0])) 

					{ 

						$dias_mes_anterior=29; break; 

					} else { 

						$dias_mes_anterior=28; break; 

					} 

			   case 4:     $dias_mes_anterior=31; break; 

			   case 5:     $dias_mes_anterior=30; break; 

			   case 6:     $dias_mes_anterior=31; break; 

			   case 7:     $dias_mes_anterior=30; break; 

			   case 8:     $dias_mes_anterior=31; break; 

			   case 9:     $dias_mes_anterior=31; break; 

			   case 10:     $dias_mes_anterior=30; break; 

			   case 11:     $dias_mes_anterior=31; break; 

			   case 12:     $dias_mes_anterior=30; break; 

		}

		$dias=$dias + $dias_mes_anterior; 

	} 

	//ajuste de posible negativo en $meses 

	if ($meses<0){

		--$anos; 

		$meses=$meses + 12; 

	}

	$ret=$anos." años <br> ".$meses." meses <br> ".$dias." días ";

	}else $ret;

	return($ret);

}



function bisiesto($anio_actual){ 

    $bisiesto=false; 

    //probamos si el mes de febrero del año actual tiene 29 días 

      if (checkdate(2,29,$anio_actual)) 

      { 

        $bisiesto=true; 

    } 

    return $bisiesto; 

}



//Validar URL Retorno

function urlr($urlf=NULL){

	//$urlf :: URL proveniente de un FORM

	//$urla :: URL anterior proveniente de una Session declarada en el Header $_SESSION['urlp']

	//$urlc :: URL actual de el archivo que solicita la validacion de url

//echo '<h4>entra a verurlr</h4>';

$urlp=$_SESSION['urlp'];//URL Previa

$urlc=$_SESSION['urlc'];//URL Actual

//Verifico si tengo una URL retorno de formulario (urlf)

if(isset($urlf)){ $urlr=$urlf;

}else{//NO TENGO URL de FORM 

	//echo '<h4>No tengo URL de FORM</h4>';

	if((compUrl($urlc,$urlp))||(!isset($urlp))){ $urlr=$GLOBALS['RAIZ'];//Comparo si no son iguales la URL

	}else{ $urlr=$urlp; }

}

return $urlr;

}

function genPageNavbar($MOD, $tit=NULL, $des='',$icon=NULL,$css='navbar-fixed-top'){

	$banMod=FALSE;

	if($MOD){

		$rowMod=detMod($MOD);

		if($rowMod){$banMod=TRUE;}

	}

	if ($banMod==FALSE){

		$rowMod['mod_nom']=$tit;

		$rowMod['mod_des']=$des;

		$rowMod['mod_icon']=$icon;

	}

	$returnTit;

	$returnTit.='<nav class="navbar navbar-default">';

	$returnTit.='<div class="container-fluid">';

	$returnTit.='<div class="navbar-header">';

    $returnTit.='<a class="navbar-brand" href="#">'.$rowMod['mod_nom'];

	$returnTit.=' <small class="label label-default">'.$rowMod['mod_des'].'</small></a>';

	$returnTit.='</div>';

    $returnTit.='</div></nav>';

	return $returnTit;

}

function compUrl($url1,$url2){

	if($url1==$url2) return TRUE;

	else return FALSE;

}

//BEG FUNCION LOGIN

function login($username, $password, $accesscheck){

if (isset($username)) {

	$loginUsername=$username;

	$password=md5($password);

	

	if ($accesscheck) $MM_redLS = $accesscheck;

	else $MM_redLS = $GLOBALS['RAIZc']."com_index/";

	$MM_redLF = $GLOBALS['RAIZ']."index.php";

	$MM_redRF = true;

  	

	$qryLOGIN=sprintf("SELECT user_cod AS u_id, user_username AS u_user, user_password, user_status AS u_est, user_theme AS u_theme, id_aud AS u_aud 

	FROM db_user_system 

	WHERE user_username=%s AND user_password=%s",

	SSQL($loginUsername, "text"), 

	SSQL($password, "text"));

	

	$LoginRS = mysql_query($qryLOGIN) or die(mysql_error());

	$loginFoundUser = mysql_num_rows($LoginRS);

	$dLogin = mysql_fetch_assoc($LoginRS);

	if ($loginFoundUser){

		if($dLogin['u_est']==1){

			if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}

			$_SESSION['autentificacion']=TRUE;

			$_SESSION[dU]=$dLogin;

			

			$_SESSION[dU] = $dLogin;

			$_SESSION['bsTheme'] = $dLogin['u_theme'];

			$tLOG='<h4>Usuario Identificado</h4>';

			header("Location: ".$MM_redLS.'?LOG='.$tLOG);

		}else{

			$tLOG='<h4>Usuario Deshabilitado</h4>Comuniquese con el Administrador';

			header("Location: ".$MM_redLF.'?LOG='.$tLOG);

		}

	}else{

		$tLOG='<h4>Error de Nombre de Usuario - Contraseña</h4>Intente de nuevo';

		header("Location: ".$MM_redLF.'?LOG='.$tLOG);

	}

	

}//END IF username

}

//END FUNCION LOGIN



//BEG GENERACION MENU

function genMenu($refMC,$css=NULL,$vrfUL=TRUE){

	//Consulta para Menus Principales

	$qry=sprintf("SELECT * FROM db_menus_items 

	INNER JOIN db_menus_user ON db_menus_items.men_id = db_menus_user.men_id 

	INNER JOIN db_menus on db_menus_items.men_idc=db_menus.id 

	WHERE db_menus.ref = %s 

	AND db_menus_items.men_padre = %s AND db_menus_user.user_cod = %s 

	AND db_menus_items.men_stat = %s 

	ORDER BY men_orden ASC",

	SSQL($refMC,'text'),

	SSQL('0','int'),

	SSQL($_SESSION[dU][u_id],'int'),

	SSQL('1','text'));

	$RSmp = mysql_query($qry) or die(mysql_error());

	$dRSmp = mysql_fetch_assoc($RSmp);

	$tRSmp = mysql_num_rows($RSmp);

	if($tRSmp > 0){

		do{

			//Consulta para Submenus

			$qry2 = sprintf("SELECT * FROM db_menus_items 

			INNER JOIN db_menus_user ON db_menus_items.men_id = db_menus_user.men_id 

			WHERE db_menus_items.men_padre = %s AND db_menus_user.user_cod = %s AND db_menus_items.men_stat = %s 

			ORDER BY men_orden ASC",

			SSQL($dRSmp['men_id'],'int'),

			SSQL($_SESSION[dU][u_id],'int'),

			SSQL(1,'int'));

			$RSmi = mysql_query($qry2) or die(mysql_error());

			$dRSmi = mysql_fetch_assoc($RSmi);

			$tRSmi = mysql_num_rows($RSmi);

			if($tRSmi>0) $cssSM="dropdown"; 

			else $cssSM="";

			if($dRSmp['men_link']) $link = $GLOBALS['RAIZc'].$dRSmp['men_link'];

			else $link = "#";

			if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];

			$ret.='<li class="'.$cssSM.'">'; 

			if($tRSmi > 0){

				$ret.='<a href="'.$link.'" class="dropdown-toggle"';

				if($tRSmi > 0){ $ret.='data-toggle="dropdown"';

			}

			$ret.='>';

			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';

			$ret.=$dRSmp['men_tit'];

			if($tRSmi > 0){

				$ret.=' <b class="caret"></b>';

			}

			$ret.='</a>';

			$ret.='<ul class="dropdown-menu">';

			do{

				if($dRSmi['men_link']){ 

					$link = $GLOBALS['RAIZc'].$dRSmi['men_link'];

				}else{

					$link = "#"; 

				}

			if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];

			$ret.='<li><a href="'.$link.'">';

			if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';

			$ret.=$dRSmi['men_tit'].'</a></li>';

			if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];

			}while($dRSmi = mysql_fetch_assoc($RSmi));

			mysql_free_result($RSmi);

			$ret.='</ul>';

		}else{

			

			$ret.='<a href="'.$link.'">';

			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';

			$ret.=$dRSmp['men_tit'].'</a>';

		}                             	                    

		$ret.='</li>';

		if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];

	}while($dRSmp = mysql_fetch_assoc($RSmp));

	mysql_free_result($RSmp);

	}else{

		$ret.='<li>No existen menus para <strong>'.$refMC.'</strong></li>';

	}

	//Verifica si solicito UL, si no devolveria solo LI

	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';

	return $ret;

}

//END GENERACION MENU

//Funcion para visualizar status v.2.0

function fncStat($dest,$params,$css=NULL){

$firstP=TRUE;

foreach($params as $x => $xVal) {

    if($x=='val'){

		if($xVal==1){

			$xVal=0;

			$cssST='btn btn-success btn-xs';

			$txtST='<span class="glyphicon glyphicon-ok"></span>';

		}else{

			$xVal=1;

			$cssST='btn btn-warning btn-xs';

			$txtST='<span class="glyphicon glyphicon-remove"></span>';

		}

	}

	if($firstP==TRUE){

		$lP.='?'.$x.'='.$xVal;

		$firstP=FALSE;

	}else $lP.='&'.$x.'='.$xVal;

}

$st='<a href="'.$dest.$lP.'" class="'.$cssST.' '.$css.'">'.$txtST.'</a>';

return $st;

}



//GENERATE PAGE HEADER MODULE COMPONENT

function genPageHeader($MOD, $tip='page-header', $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL,$pullL=NULL,$pullR=NULL){//duotics_lib->v.0.5

	$banMod=FALSE;

	if($MOD){

		$dM=detMod($MOD);

		if($dM) $banMod=TRUE;

	}//Manual

	if(!$banMod){

		$dM['mod_nom']=$tit;

		$dM['mod_cod']=$id;

		$dM['mod_des']=$des;

		$dM['mod_icon']=$icon;

	}

	if($tag==null) $tag='h1';

	$ret;

	switch($tip){

		case 'page-header':

			$ret.='<div class="page-header">';

			$ret.='<'.$tag.'>';

			if ($pullL) $ret.='<div class="pull-left">'.$pullL.'</div>';

			if($dM['mod_icon']) $ret.=' <i class="'.$dM['mod_icon'].'"></i> ';

			if($id) $ret.=' <span class="label label-primary">'.$dM['mod_cod'].'</span> ';

			$ret.=$dM['mod_nom'];

			$ret.=' <small>'.$dM['mod_des'].'</small>';

			if ($pullR) $ret.='<div class="pull-right">'.$pullR.'</div>';

			$ret.='</'.$tag.'>';

			$ret.='</div>';

		break;

		case 'navbar':

			$ret.='<nav class="navbar navbar-default">';

			$ret.='<div class="container-fluid">';

			$ret.='<div class="navbar-header">';

			$ret.='<a class="navbar-brand" href="#"><i class="'.$dM['mod_icon'].'"></i> '.$dM['mod_nom'];

			$ret.=' <small class="label label-default">'.$dM['mod_des'].'</small></a>';

			$ret.='</div>';

			$ret.='<div class="navbar-left">';

			$ret.=$pullL;

	  		$ret.='</div>';

			$ret.='<div class="navbar-right">';

			$ret.=$pullR;

	  		$ret.='</div>';

			

			$ret.='</div></nav>';

		break;

		default:

			$ret.='<div>';

			if($id) $ret.=' <span class="label label-default">'.$dM['mod_cod'].'</span> ';

			$ret.=$dM['mod_nom'];

			$ret.='<div>';

		break;

	}

	return $ret;

}



function genPageHead($MOD, $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL){

	$banMod=FALSE;

	if($MOD){

		$rowMod=detMod($MOD);

		if($rowMod){$banMod=TRUE;}

	}

	if ($banMod==FALSE){

		$rowMod['mod_nom']=$tit;

		$rowMod['mod_cod']=$id;

		$rowMod['mod_des']=$des;

		$rowMod['mod_icon']=$icon;

	}

	$returnTit;

	$returnTit.='<div class="page-header">';

    $returnTit.='<'.$tag.'>';

	if($rowMod['mod_icon']){ $returnTit.=' <i class="'.$rowMod['mod_icon'].'"></i> ';	}

	if($id){ $returnTit.=' <span class="label label-primary">'.$rowMod['mod_cod'].'</span> ';	}

	$returnTit.=$rowMod['mod_nom'];

    $returnTit.=' <small>'.$rowMod['mod_des'].'</small>';

	$returnTit.='</'.$tag.'>';

	$returnTit.='</div>';

	

	return $returnTit;

}



//AUTHORIZED LOGIN USERS



//FUNCTIONS ACCESS USERS

function vLogin($mSel=NULL){//,$accesscheck=FALSE){

	if($mSel){

		$qry=sprintf('SELECT * FROM db_menus_items 

		INNER JOIN db_menus_user ON db_menus_items.men_id=db_menus_user.men_id

		LEFT JOIN db_componentes ON db_menus_items.mod_cod=db_componentes.mod_cod

		WHERE db_menus_user.user_cod=%s AND db_menus_items.men_nombre=%s',

		SSQL($_SESSION[dU][u_id],'int'),

		SSQL($mSel,'text'));

		$RS=mysql_query($qry);

		$dRS=mysql_fetch_assoc($RS);

		$tRS=mysql_num_rows($RS);

		if($tRS>0) $vVM=TRUE;

		else $vVM=FALSE;

	}else $vVM=TRUE;

	$MM_authorizedUsers = "";

	$MM_donotCheckaccess = "true";

	$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";

	if (!((isset($_SESSION[dU])) && ($vVM) && (isAuthorized($MM_authorizedUsers, $_SESSION[dU])))) {   

 

	  $MM_qsChar = "?";

	  $MM_referrer = $_SERVER['PHP_SELF'];

	  

	  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";

	  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];

	  

	  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);

	  header("Location: ". $MM_restrictGoTo); 

	  exit;

	}

	if($mSel) return($dRS);

}



function detNumConAct($idc,$idp){



	$qryRTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<=%s',

	SSQL($idp,'int'),

	SSQL($idc,'int'));

	$RSRtot=mysql_query($qryRTot);

	$row_RSRtot=mysql_fetch_assoc($RSRtot);

	$numRTot=mysql_num_rows($RSRtot);

	

	echo $numRTot;

}

function gebBtnHis($idc,$idp){

	$qryTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s',

	SSQL($idp,'int'));

	$RStot=mysql_query($qryTot);

	$row_RStot=mysql_fetch_assoc($RStot);

	$numTot=mysql_num_rows($RStot);

	

	$qryRTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<=%s',

	SSQL($idp,'int'),

	SSQL($idc,'int'));

	$RSRtot=mysql_query($qryRTot);

	$row_RSRtot=mysql_fetch_assoc($RSRtot);

	$numRTot=mysql_num_rows($RSRtot);

	

	$qryIni=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num ASC LIMIT 1',

	SSQL($idp,'int'));

	$RSini=mysql_query($qryIni);

	$row_RSini=mysql_fetch_assoc($RSini);

	$idIni=$row_RSini['con_num'];

	

	$qryFin=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num DESC LIMIT 1',

	SSQL($idp,'int'));

	$RSfin=mysql_query($qryFin);

	$row_RSfin=mysql_fetch_assoc($RSfin);

	$idFin=$row_RSfin['con_num'];

	

	$qryAnt=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s and con_num<%s ORDER BY con_num DESC LIMIT 1',

	SSQL($idp,'int'),

	SSQL($idc,'int'));

	$RSant=mysql_query($qryAnt);

	$row_RSant=mysql_fetch_assoc($RSant);

	$idAnt=$row_RSant['con_num'];

	

	$qrySig=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s and con_num>%s ORDER BY con_num ASC LIMIT 1',

	SSQL($idp,'int'),

	SSQL($idc,'int'));

	$RSsig=mysql_query($qrySig);

	$row_RSsig=mysql_fetch_assoc($RSsig);

	$idSig=$row_RSsig['con_num'];



	if($idIni==$idc){

		$cssIni='disabled';

		$cssAnt='disabled';

	}else{

		$link_ini='form.php?idc='.$row_RSini['con_num'];

	}

	if($idFin==$idc){

		$cssFin='disabled';

		$cssSig='disabled';

	}else{

		$link_fin='form.php?idc='.$row_RSfin['con_num'];

	}



	$link_ant='form.php?idc='.$idAnt;

	$link_sig='form.php?idc='.$idSig;

	

	$btn_ini='<a href="'.$link_ini.'" class="btn btn-default btn-sm '.$cssIni.'"><i class="fa fa-fast-backward"></i>';

	$btn_ini.='</a>';

	$btn_fin='<a href="'.$link_fin.'" class="btn btn-default btn-sm '.$cssFin.'"><i class="fa fa-fast-forward"></i>';

	$btn_fin.='</a>';

	$btn_ant='<a href="'.$link_ant.'" class="btn btn-default btn-sm '.$cssAnt.'"><i class="fa fa-step-backward"></i>';

	$btn_ant.='</a>';

	$btn_sig='<a href="'.$link_sig.'" class="btn btn-default btn-sm '.$cssSig.'"><i class="fa fa-step-forward"></i>';

	$btn_sig.='</a>';

	if($idc) $btnRet=$btn_ini.$btn_ant.'<span class="label label-default">'.$numRTot.' / '.$numTot.'</span>'.$btn_sig.$btn_fin;

	else $btnRet=$btn_ini.'<span class="label label-default">'.$numRTot.' / '.$numTot.'</span>'.$btn_fin;

	return $btnRet;

}





function fnc_genthumb($path, $file, $pref, $mwidth, $mheight){

	$obj = new img_opt(); // Crear un objeto nuevo

	$obj->max_width($mwidth); // Decidir cual es el ancho maximo

	$obj->max_height($mheight); // Decidir el alto maximo

	$obj->image_path($path,$file,$pref); // Ruta, archivo, prefijo

	$obj->image_resize(); // Y finalmente cambiar el tamaño

}



function fncImgExist($ruta,$nombre){

	if (!(isset($nombre))) $nombre="error";

	if (file_exists(RAIZ.$ruta.$nombre)){

		$dirImg = $GLOBALS['RAIZ'].$ruta.$nombre;

	} else {

		$dirImg=$GLOBALS['RAIZa'].'images/struct/no_image.jpg';

	}

	return ($dirImg);	

} 

function vImg($ruta,$nombre,$thumb=TRUE,$pthumb='t_',$retHtml=FALSE){//v1.5

	//$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)

	//$nombre. Nombre del Archivo

	//$thumb. TRUE o FALSE en caso de querer recuperar thumb

	//$pthumb PREFIJO de Thumb

	//RAIZ must be named RAIZ depends the root folder

	$imgRet['n']=$GLOBALS['RAIZi'].'struct/no_image.jpg';

	$imgRet['t']=$imgRet['n'];

	$imgRet['s']=FALSE;//Verify if file exist is default FALSE

	if($nombre){

		//echo '<hr>RAIZ. '.RAIZ.$ruta.$nombre;

		//echo '<hr>$RAIZ. '.$RAIZ.$ruta.$nombre;

		if (file_exists(RAIZ.$ruta.$nombre)){

			$imgRet['s']=TRUE;//FILE EXIST RETURN TRUE AND ALL DATA (link normal, link thumb, file name original)

			$imgRet['f']=$nombre;

			$imgRet['n']=$GLOBALS['RAIZ'].$ruta.$nombre;

			$imgRet['t']=$imgRet['n'];

			if ($thumb==TRUE){

				if (file_exists(RAIZ.$ruta.$pthumb.$nombre)){

					$imgRet['t']=$GLOBALS['RAIZ'].$ruta.$pthumb.$nombre;

				}

			}

		}

	}

	//Direct Return HTML Code *********** TERMINAR ESTE CODIGO

	if($retHtml){

		foreach($retHtml as $key => $valor){

			if($key!='tip') $paramCode=' '.$key.' = '.'"'.$valor.'"';

		}

		switch($retHtml['tip']){

			case 'imgn':

				$imgRet['code']='<img src="'.$imgRet['n'].'" '.$paramCode.'>';

			break;

			case 'imgt':

				$imgRet['code']='<img src="'.$imgRet['t'].'" '.$paramCode.'>';

			break;

			case 'aimg':

				$imgRet['code']='<a href="'.$imgRet['n'].'" '.$paramCode.'><img src="'.$imgRet['t'].'"></a>';

			break;

		}

		

	}

	return $imgRet;

}

//uploadfile() :: Carga de Archivos al Servidor

function uploadfile($params, $file){

	$code = md5(uniqid(rand()));

	$prefijo = $params['pre'].'_'.$code;

	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension

	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension

	$filename = $prefijo.$ext; // Obtiene el nombre del archivo, y su extension.

	$aux_grab=FALSE;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos

	// Verifica si la extension es valida

	if(!in_array($ext,$params['ext'])) $LOG.='<h4>Archivo no valido</h4>';

	else{ // Verifica el tamaño maximo

		if(filesize($file['tmp_name']) > $params['siz']) $LOG.='<h4>Archivo Demasiado Grande :: maximo '.($params['siz']/1024/1024).' MB</h4>';

		else{ // Verifica Permisos de Carpeta, Si Carpeta Existe.

			if(!is_writable($params['pat'])) $LOG.='<h4>Permisos Folder Insuficientes, contacte al Administrador del Sistema</h4>';

			else{// Mueve el archivo a su lugar correpondiente.

				if(!move_uploaded_file($file['tmp_name'],$params['pat'].$filename)) $LOG.='<h4>Error al Cargar el Archivo</h4>';

				else{

					$aux_grab=TRUE;

					$LOG.='<p>Archivo Cargado Correctamente</p>';

				}

			}

		}

	}

	$auxres['LOG']=$LOG;

	$auxres['EST']=$aux_grab;

	$auxres['FILE']=$filename;

	return $auxres; 

}



function urlReturn($urlr,$urld=NULL){

//$urlr -> URL para retornar

//$urld -> URL defecto para el Modulo

	$urla=$_SESSION['urlp'];

	$urlc=$_SESSION['urlc'];

	if (($urlr)&&($urlr != $urlc)){

		$urlf=$urlr;

	}else if(($urla)&&($urla != $urlc)){

		$urlf=$urla;

	}else if(($urld)&&($urld != $urlc)){

		$urlf=$urld;

	}else { $urlf=$GLOBALS['RAIZ'].'com_index/'; }

	return $urlf;

}

/*

function vLOG(){

	session_start();

	if(isset($_SESSION['LOG'])) echo '<div id="log">

	<div class="alert alert-warning">

	<button type="button" class="close" data-dismiss="alert">&times;</button>

	'.$_SESSION['LOG'].'</div></div>';

	unset($_SESSION['LOG']);

	unset($_SESSION['LOGr']);

}

*/

//fnc_log() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)

function sLOG($type='a'){

	//SESSION_LOG: Vector ['m']=Mensaje; ['t']=Titulo; ['c']=class, ['i']=imagen

	$LOG=$_SESSION['LOG'];

	if(!$LOG['c']) $LOG['c']='alert-warning';

	if(isset($LOG['m'])){

		if($type=='a'){

			$sLog='<div id="log">';

			$sLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';

			$sLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';

			$sLog.=$LOG['m'];

			$sLog.='</div></div>';

		}else if($type=='g'){

			if($LOG['m']){

			$sLog='<script type="text/javascript">

			logGritter("'.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");</script>';

			}

		}else{

			$sLog='<div>'.$LOG['m'].'</div>';

		}

		echo $sLog;

	}

	unset($_SESSION['LOG']);

	unset($_SESSION['LOG']['m']);

}



if (!function_exists("SSQL")) {

function SSQL($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;



  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}

}

?>