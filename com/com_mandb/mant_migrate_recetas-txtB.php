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
			for($x=1;$x<=7;$x++){
				$xV=sprintf("%02d", $x);
				if($det[RECETA.$xV]){
					if($contM>0) $qryV.=' , ';
					$qryV.=sprintf(' (LAST_INSERT_ID(),%s,%s,%s,%s,%s,%s)',
					  SSQL($det[DOSIS.$xV],'int'),
					  SSQL('M','text'),
					  SSQL($det[RECETA.$xV],'text'),
					  SSQL($det[CANTR.$xV],'text'),
					  SSQL($det[INDICA.$xV],'text'),
					  SSQL('NULL',''));
					$contM++;
				}
			}
			for($x=15;$x<=18;$x++){
				if($det[INDICA.$x]){
					if($contM>0) $qryV.=' , ';
					$qryV.=sprintf(' (LAST_INSERT_ID(),%s,%s,%s,%s,%s,%s)',
					  SSQL('NULL',''),
				      SSQL('I','text'),
				      SSQL('NULL',''),
				      SSQL('NULL',''),
				      SSQL('NULL',''),
				      SSQL($det[INDICA.$x],'text'));
					$contM++;
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
$nomFile='qry_recetas_'.$ini.'-'.$lim.' - B.txt';
$file = fopen(RAIZ.$nomFile, "w");
fwrite($file, $qry . PHP_EOL);
fclose($file);
	echo 'Archivo Creado. '.$sdatet;
}else{
	echo 'Error no data LIMIT 0,0';
}
?>