<?php
function genDocDataChange($field,$dat){
	switch($field){
		case "{fec}":
			$res=$GLOBALS[sdaten];
		break;
		case "{fecm}":
			$res=$GLOBALS[sdate];
		break;
		case "{pac_nom}":
			$res=$dat[pac][pac_nom];
		break;
		case "{pac_ape}":
			$res=$dat[pac][pac_ape];
		break;
		case "{pac_ced}":
			$res=$dat[pac][pac_ced];
		break;
		case "{pac_edad}":
			$res=edad($dat[pac][pac_fec],' años');
		break;
		case "{con_diag}":
			$res=$dat[con][diag];
		break;
		case "{con_diagm}":
			$res=$dat[con][diagm];
		break;
		case "{usu_nomape}":
			$res=$dat[emp][emp_nom].' '.$dat[emp][emp_ape];
		break;
		case "{usu_esp}":
			$res=$dat[emp][emp_esp];
		break;
		case "{usu_mail}":
			$res=$dat[emp][emp_mail];
		break;
		default:
			$res=null;
		break;
	}
	return $res;
}

function genDoc($id_df,$dat=NULL){
	//var_dump($_SESSION[dU]);
	$dE=detRow('db_empleados','emp_cod',$_SESSION[dU][u_id]);
	$dat[emp]=$dE;
	if($dat[con][con_num]){
		$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 5',
					SSQL($dat[con][con_num],'int'));
		$RSld=mysql_query($qLD);
		$dRSld=mysql_fetch_assoc($RSld);
		$tRSld=mysql_num_rows($RSld);
		
		if($tRSld>0){
			do{
				if($dRSld[id_diag]>1){
					$dDiag=detRow('db_diagnosticos','id_diag',$dRSld[id_diag]);
					$dDiag_cod=' ('.$dDiag[codigo].') ';
					$dDiag_nom=$dDiag[nombre];
				}else{
					$dDiag_cod=NULL;
					$dDiag_nom=$dRSld[obs];
				}
				if($contDE<1) $resDiagM=$dDiag_nom.$dDiag_cod;
				$resDiag.=' <span>'.$dDiag_nom.$dDiag_cod.'</span>';
				$contDE++;
				if(($contDE>0)&&($contDE<$tRSld)) $resDiag.=',';
				
			}while($dRSld=mysql_fetch_assoc($RSld));
		}	
	}
	$dat[con][diag]=$resDiag;
	$dat[con][diagm]=$resDiagM;
		
	//GENERACION Y CARGA DE DATOS EN FORMATO
	$dDF=detRow('db_documentos_formato','id_df',$id_df);
	$format=$dDF[formato];
	preg_match_all('/\{(.*?)\}/', $format, $res);
	$vecO=$res[0];
	foreach ($res[0] as $valor){
		$resField=genDocDataChange($valor,$dat);
		//echo 'field sale. '.$resField.'<br>';
		$vecP[$valor]=$valor;
		$vecN[$valor]=$resField;
	}
	$formatN = str_replace($vecP, $vecN, $format);	
	$docR['id']=$id;
	$docR['sel']=$sel;
	$docR['format']=$formatN;
	return $docR;
}//genDoc
?>