<?php include('../../init.php');
set_time_limit(1800);//30minutos*60segundo=1800
$fecBP=$sdatet;
function convIDtoANTID($ID){
	$contT1=strlen($ID);
	$IDN.=$ID;
	for($x=0;$x<5-$contT1;$x++){
		$IDN='0'.$IDN;
	}
	return($IDN);
}
$vP=FALSE;
$contGen=0;

$ini=$_GET[i];
$lim=$_GET[l];
if($lim>0){
$qryS='SELECT id_ant,pac_cod,con_num FROM db_consultas LIMIT '.intval($ini).','.intval($lim);
	echo $qryS;
$RS=mysql_query($qryS);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
if($tRS>0){
	do{
		$ID=$dRS[pac_cod];
		$IDMOD=convIDtoANTID($ID);
		$VISITA=$dRS[id_ant];
		$CONS=$dRS[con_num];
		$paramsN=NULL;
		$paramsN[]=array(
			array("cond"=>"AND","field"=>"NROCODIGO","comp"=>"=","val"=>$IDMOD),
			array("cond"=>"AND","field"=>"NROVISITA","comp"=>'=',"val"=>$VISITA));
		$det=detRowNP('bck_recetas',$paramsN);
		$fechaREC = date_create($det[FECHAREC]);
		$fechaREC = date_format($fechaREC, 'Y-m-d');
	
		if($det){//CREO LA RECETA
			$contM=0;
			$qryV=NULL;
			//TRATAMIENTO DETALLE MEDICAMENTOS
			$MEDICAMENTOS=array(
			'01'=>array($det[RECETA01],$det[CANTR01],$det[DOSIS01],$det[INDICA01],$det[INDICA02]),
			'02'=>array($det[RECETA02],$det[CANTR02],$det[DOSIS02],$det[INDICA03],$det[INDICA04]),
			'03'=>array($det[RECETA03],$det[CANTR03],$det[DOSIS03],$det[INDICA05],$det[INDICA06]),
			'04'=>array($det[RECETA04],$det[CANTR04],$det[DOSIS04],$det[INDICA07],$det[INDICA08]),
			'05'=>array($det[RECETA05],$det[CANTR05],$det[DOSIS05],$det[INDICA09],$det[INDICA10]),
			'06'=>array($det[RECETA06],$det[CANTR06],$det[DOSIS06],$det[INDICA11],$det[INDICA12]),
			'07'=>array($det[RECETA07],$det[CANTR07],$det[DOSIS07],$det[INDICA13],$det[INDICA14]),
			
			'08'=>array('INDICA',NULL,NULL,NULL,$det[INDICA15]),
			'09'=>array('INDICA',NULL,NULL,NULL,$det[INDICA16]),
			'10'=>array('INDICA',NULL,NULL,NULL,$det[INDICA17]),
			'11'=>array('INDICA',NULL,NULL,NULL,$det[INDICA18])
			);
			
			foreach($MEDICAMENTOS as $key => $val){
				if($val[0]=='INDICA'){
					if($val[4]){
						
						if($contM>0) $qryV.=' , ';
						$qryV.=sprintf(' (LAST_INSERT_ID(),%s,%s,%s,%s,%s,%s)',
								   SSQL('NULL',''),
								   SSQL('I','text'),
								   SSQL('NULL',''),
								   SSQL('NULL',''),
								   SSQL('NULL',''),
								   SSQL($val[4],'text'));
						$contM++;
					}
				}else{
					if($val[0]){
						if($contM>0) $qryV.=' , ';
						$qryV.=sprintf(' (LAST_INSERT_ID(),%s,%s,%s,%s,%s,%s)',
								  SSQL($val[2],'int'),
								  SSQL('M','text'),
								  SSQL($val[0],'text'),
								  SSQL($val[1],'text'),
								  SSQL($val[3].$val[4],'text'),
								  SSQL('NULL',''));
						$contM++;
					}
				}
			}
			if($contM>0){
				$contGen++;
				$qry.=sprintf('INSERT INTO db_tratamientos (con_num,pac_cod,fecha) VALUES (%s,%s,%s); ',
						  SSQL($CONS,'int'),
						  SSQL($ID,'int'),
						  SSQL($fechaREC,'date'));
				$qry.='INSERT INTO db_tratamientos_detalle (tid,idref,tip,generico,cantidad,descripcion,indicacion) VALUES '.$qryV.'; ';
			}
		}//NO RECETA
	}while($dRS=mysql_fetch_assoc($RS));
}
$nomFile='qry_recetas_'.$ini.'-'.$lim.'.txt';
$file = fopen(RAIZ.$nomFile, "w");
fwrite($file, $qry . PHP_EOL);
fclose($file);
	echo 'Archivo Creado. '.$sdatet;
}else{
	echo 'Error no data LIMIT 0,0';
}
?>