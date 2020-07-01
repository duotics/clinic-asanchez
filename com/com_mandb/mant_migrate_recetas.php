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
$vP=TRUE;
$vR=TRUE;//Verificacion para truncate tablas relacionadas
$contGen=0;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

$qry=sprintf('SELECT * FROM db_consultas LIMIT 0,100');
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tRS=mysql_num_rows($RS);
?>

<?php if($vR){ ?>
<div class="well">
	<h1>RESETEO TABLAS</h1>
	<?php
	mysql_query('SET FOREIGN_KEY_CHECKS=0;');
	
	$qT='TRUNCATE TABLE db_tratamientos_detalle;';
	mysql_query($qT) or die(mysql_error());
	
	$qT='TRUNCATE TABLE db_tratamientos;';
	mysql_query($qT) or die(mysql_error());

	mysql_query('SET FOREIGN_KEY_CHECKS=1;');
	?>
</div>
<?php } ?>

<?php
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
	
		$RES=NULL;
		if($det){
		//CREO LA RECETA
			$qryIT=sprintf('INSERT INTO db_tratamientos (con_num,pac_cod,fecha) VALUES (%s,%s,%s); ',
						  SSQL($CONS,'int'),
						  SSQL($ID,'int'),
						  SSQL($fechaREC,'date'));
			if(@mysql_query($qryIT)){
				$IDT=mysql_insert_id();
			}else{
				$vP=FALSE;
				break;
			}
			//TRATAMIENTO DETALLE MEDICAMENTOS
			$MEDICAMENTOS=array(
			'01'=>array($det[RECETA01],$det[CANTR01],$det[DOSIS01],$det[INDICA01],$det[INDICA02]),
			'02'=>array($det[RECETA02],$det[CANTR02],$det[DOSIS02],$det[INDICA03],$det[INDICA04]),
			'03'=>array($det[RECETA03],$det[CANTR03],$det[DOSIS03],$det[INDICA05],$det[INDICA06]),
			'04'=>array($det[RECETA04],$det[CANTR04],$det[DOSIS04],$det[INDICA07],$det[INDICA08]),
			'05'=>array($det[RECETA05],$det[CANTR05],$det[DOSIS05],$det[INDICA09],$det[INDICA10]),
			'06'=>array($det[RECETA06],$det[CANTR06],$det[DOSIS06],$det[INDICA11],$det[INDICA12]),
			'07'=>array($det[RECETA07],$det[CANTR07],$det[DOSIS07],$det[INDICA13],$det[INDICA14])
			);
			foreach($MEDICAMENTOS as $key => $val){
				if($val[0]){
					$detRM=detRow('db_medicamentos','id_form',intval($val[2]));
					if($detRM){
					$qryITD=sprintf('INSERT INTO db_tratamientos_detalle (tid,idref,tip,generico,cantidad,descripcion) 
					VALUES (%s,%s,%s,%s,%s,%s); ',
								  SSQL($IDT,'int'),
								  SSQL($val[2],'int'),
								  SSQL('M','text'),
								  SSQL($val[0],'text'),
								  SSQL($val[1],'text'),
								  SSQL($val[3].$val[4],'text'));
					mysql_query($qryITD) or die(mysql_error());
					}
				}
			}
			//TRATAMIENTO DETALLE INDICACIONES
			$INDICACIONES=array('INDICA15'=>$det[INDICA15],
								'INDICA16'=>$det[INDICA16],
								'INDICA17'=>$det[INDICA17],
								'INDICA18'=>$det[INDICA18]);
			foreach($INDICACIONES as $key => $val){
				if($val){
					$qryITD=sprintf('INSERT INTO db_tratamientos_detalle (tid,tip,indicacion) VALUES (%s,%s,%s); ',
								  SSQL($IDT,'int'),
								  SSQL('I','text'),
								  SSQL($val,'text'));
					mysql_query($qryITD) or die(mysql_error());
				}
			}
			$contGen++;
			echo $contGen.'. ';
		}//NO RECETA
	}while($dRS=mysql_fetch_assoc($RS));
	echo 'Recetas Creadas. '.$contGen;
}else{
echo 'Sin Registos de Recetas. ';
}
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
?>
<div class="alert alert-info"><h4>Tarea Finalizada</h4>
Inicia. <?php echo $fecBP ?><br>
Finaliza. <?php echo $sdatet ?></div>