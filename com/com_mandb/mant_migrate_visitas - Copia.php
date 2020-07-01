<?php include('../../init.php');
set_time_limit(1800);//30minutos*60segundo=1800
include(RAIZf.'head.php');php?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_consultas <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php

$vP=TRUE;

mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

$qry=sprintf('SELECT pac_cod FROM db_pacientes WHERE 1=1 LIMIT 100,100');
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
?>

<div class="well">
	<h1>RESETEO TABLAS</h1>
	<?php
	mysql_query('SET FOREIGN_KEY_CHECKS=0;');
	
	$qT='TRUNCATE TABLE db_consultas_diagostico;';
	mysql_query($qT) or die(mysql_error());
	
	$qT='TRUNCATE TABLE db_examenes;';
	mysql_query($qT) or die(mysql_error());
	
	$qT='TRUNCATE TABLE db_signos;';
	mysql_query($qT) or die(mysql_error());
	
	$qT='TRUNCATE TABLE db_tratamientos_detalle;';
	mysql_query($qT) or die(mysql_error());
	
	$qT='TRUNCATE TABLE db_tratamientos;';
	mysql_query($qT) or die(mysql_error());

	$qT='TRUNCATE TABLE db_consultas;';
	mysql_query($qT) or die(mysql_error());
	
	mysql_query('SET FOREIGN_KEY_CHECKS=1;');
	?>
</div>
<?php if($vP==TRUE){ ?>
<table class="table table-bordered table-condensed">
	<tr>
		<th>idPac</th>
		<th>N. Vis</th>
		<th></th>
		
	</tr>
<?php do{ ?>
	<tr>
<?php
	$ID=$dRS[pac_cod];
	$qryB=sprintf('SELECT * FROM bck_visitas WHERE CODIGO=%s',
				 SSQL($ID,'int'));
	$RSb=mysql_query($qryB);
	$det=mysql_fetch_assoc($RSb);
	$tRSb=mysql_num_rows($RSb);
	$LOGa=NULL;
	?>
	<?php if($tRSb>0){ ?>
		<?php $LOGa.='<table class="table table-bordered table-condensed">';
			$LOGa.='<tr>
				<th width="20%">Fecha</th>
				<th width="20%">Tipo</th>
				<th width="20%">Signo</th>
				<th width="20%">Examen</th>
				<th width="20%">Diagnos</th>
			</tr>';
		?>
		<?php do{ ?>
		<?php
			/////////////////////////////
			/////////////////////////////
			/////////////////////////////
			//CONSULTA - VISITA DATA
			//FECHA GEN
			$RES=NULL;
			$fecha = date_create($det[FECHAVIS]);
			$fecha = date_format($fecha, 'Y-m-d');
			//MIGRACION FECHA
			$set[con_fec]=$det[FECHAVIS];
			//MIGRACION TIPO DE VISITA
			$det_TipVis=$det[TIPOVISITA];
			if($det_TipVis){
				switch($det_TipVis){
					//case '':
					case 'CONSU':
					case '1':
					case 'HVCM':
						$det_TipVis='85';//85 = Consulta
					break;
					case 'ESPIR':
						$det_TipVis='97';//97 = Espirometria
					break;
					case 'CONTR':
						$det_TipVis='96';//96 = Control
					break;
					case 'RP':
						$det_TipVis='122';//122 = Recéta Médica
					break;
					case 'EXAME':
						$det_TipVis='87';//87 = Entrega Resultados Examen
					break;
					case 'OTROS':
						$det_TipVis='123';//123 = OTROS
					break;
					case 'FBC':
						$det_TipVis='124';//124 = Video Fibrobroncoscopia
					break;
					default:
						$det_TipVis=NULL;
					break;
				}
			}else{
				$det_TipVis=NULL;
			}
			$set[con_typvis]=$det_TipVis;
			//MIGRACION MOTIVO
			$set[dcon_mot]=$det[MOTIVO01].'\n'.$det[MOTIVO02].'\n'.$det[MOTIVO03].'\n'.$det[MOTIVO04].'\n'.$det[MOTIVO05];
			//DETALLES CONSULTA
			$set[dcon_ef_cavo]=$det[CAM];
			$set[dcon_ef_fosn]=$det[FOSAS];
			$set[dcon_ef_oro]=$det[OROFARINGE];
			$set[dcon_ef_cue]=$det[CUELLO];
			$set[dcon_tor_ins]=$det[TORAX];
			$set[dcon_tor_pal]=$det[PALPACION];
			$set[dcon_tor_per]=$det[PERCUSION];
			$set[dcon_tor_aus]=$det[AUSCULTA].' - '.$det[AUSCULTA2];
			$set[dcon_ef_obs]=$det[EXAFIS01].' - '.$det[EXAFIS02];
			$set[con_diapc]=$det[DIAS];
			$set[con_val]=$det[VALOR];
			$visita=$det[NROVISITA];
			
			$qry=sprintf('INSERT INTO db_consultas (id_ant, pac_cod, con_fec, con_typvis, con_val, dcon_mot, 
			dcon_ef_cavo, dcon_ef_fosn, dcon_ef_oro, dcon_ef_cue, 
			dcon_tor_ins, dcon_tor_pal, dcon_tor_per, dcon_tor_aus,
			dcon_ef_obs, con_diapc) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
						SSQL($visita,'text'),
						SSQL($ID,'int'),
						SSQL($set[con_fec],'text'),
						SSQL($set[con_typvis],'int'),
						SSQL($set[con_val],'text'),
						SSQL($set[dcon_mot],'text'),//
						SSQL($set[dcon_ef_cavo],'text'),
						SSQL($set[dcon_ef_fosn],'text'),
						SSQL($set[dcon_ef_oro],'text'),
						SSQL($set[dcon_ef_cue],'text'),
						SSQL($set[dcon_tor_ins],'text'),//
						SSQL($set[dcon_tor_pal],'text'),
						SSQL($set[dcon_tor_per],'text'),
						SSQL($set[dcon_tor_aus],'text'),//
						SSQL($set[dcon_ef_obs],'text'),
						SSQL($set[con_diapc],'text')
						);
			//echo $qry.'<hr>';
			if(@mysql_query($qry)){
				$IDC=mysql_insert_id();
				$RES.='<p>CONSULTA CREADA</p>';
			}else{
				$vP=FALSE;
				echo '<p>Error al crear consulta</p>'.mysql_error();
				break;
			}
			/////////////////////////////
			/////////////////////////////
			//MIGRACION RECETA
			
			$paramsN[]=array(
				array("cond"=>"AND","field"=>"NROCODIGO","comp"=>"=","val"=>$ID),
				array("cond"=>"AND","field"=>"NROVISITA","comp"=>'=',"val"=>$visita));
			$detREC=detRowNP('bck_recetas',$paramsN);
			if($detREC){//SI en contramos regitro en bck_recetas, ingresamos en db_tratamientos/db_tratamientos_detalle
				
				
			}		
			
			/////////////////////////////
			/////////////////////////////
			//MIGRACION DE SIGNOS VITALES
			$setS[peso]=$det[PESO];
			$setS[talla]=$det[TALLA];
			$setS[pa]=$det[TENARTERIA];
			$setS[fc]=$det[FRECARDIAC];
			$setS[fr]=$det[FRERESPIRA];
			$setS[po2]=$det[O2];
			$setS[co2]=$det[CO2];
			$setS[temp]=$det[TEMPERA];
			
			if(($setS[peso])||($setS[pa])||($setS[fc])||($setS[fr])||($setS[po2])||($setS[co2])||($setS[talla])||($setS[temp])){
				$qryS=sprintf('INSERT INTO db_signos (pac_cod,fecha,peso,pa,fc,fr,po2,co2,talla,temp) 
				VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
							 SSQL($ID,'int'),
							 SSQL($fecha,'date'),
							 SSQL($setS[peso],'double'),
							 SSQL($setS[pa],'text'),
							 SSQL($setS[fc],'int'),
							 SSQL($setS[fr],'int'),
							 SSQL($setS[po2],'int'),
							 SSQL($setS[co2],'int'),
							 SSQL($setS[talla],'double'),
							 SSQL($setS[temp],'double'));
				if(@mysql_query($qryS)){
					$idSig=mysql_insert_id();
					$RES.='<p>Signos Creados</p>';
				}else{
					$vP=FALSE;
					echo '<p>Error al crear Signos</p>'.mysql_error();
					break;
				}
			}
			/////////////////////////////
			/////////////////////////////
			//MIGRACION DE EXAMENES
			$EXAPED=array('01'=>array($det[EXAPED01],$det[EXAMEN01]),
			 '02'=>array($det[EXAPED02],$det[EXAMEN02]),
			 '03'=>array($det[EXAPED03],$det[EXAMEN03]),
			 '04'=>array($det[EXAPED04],$det[EXAMEN04]),
			 '05'=>array($det[EXAPED05],$det[EXAMEN05]),
			 '06'=>array($det[EXAPED06],$det[EXAMEN06]));
			
			foreach($EXAPED as $key => $val){
				if($val[0]){
					$detEF=detRow('db_examenes_format','id',$val[0]);
					$qryE=sprintf('INSERT INTO db_examenes (id_ef,con_num,pac_cod,fecha,resultado) VALUES (%s,%s,%s,%s,%s)',
									SSQL($val[0],'int'),
								  	SSQL($IDC,'int'),
									SSQL($ID,'int'),
									SSQL($fecha,'date'),
									SSQL($val[1],'text'));
					if(@mysql_query($qryE)){
						$idExa=mysql_insert_id();
						$RES.='<p>Examen Creados</p>';
					}else{
						$vP=FALSE;
						echo '<p>Error al crear examen</p>'.mysql_error();
						break;
					}
				}
			}
			
			/////////////////////////////
			/////////////////////////////
			//MIGRACION DE DIAGNOSTICOS
			$DIAGNOS=array('DIAGNOS01'=>$det[DIAGNOS01],'DIAGNOS02'=>$det[DIAGNOS02],'DIAGNOS03'=>$det[DIAGNOS03],'DIAGNOS04'=>$det[DIAGNOS04]);
			foreach($DIAGNOS as $key => $val){
				if(($key)&&($val)){
					$qryD=sprintf('INSERT INTO db_consultas_diagostico (con_num,id_diag,obs) VALUES (%s,%s,%s)',
								 SSQL($IDC,'int'),
								 SSQL(1,'int'),
								 SSQL($val,'text'));
					if(@mysql_query($qryD)){
						$idDiag=mysql_insert_id();
						$RES.='<p>Diagnostico Consulta Creado</p>';
					}else{
						$vP=FALSE;
						echo '<p>Error al crear diagnostico examen</p>'.mysql_error();
						break;
					}
				}
			}
			
			/////////////////////////////
			/////////////////////////////
			$LOGa.='<tr>';
			$LOGa.='<td>'.$det[FECHAVIS].'</td>';
			$LOGa.='<td>'.$set[con_typvis].'</td>';
			$LOGa.='<td>'.$idSig.'</td>';
			$LOGa.='<td>'.$lExam.'</td>';
			$LOGa.='<td>'.$lDiag.'</td>';
			$LOGa.='<td>'.$RES.'</td>';
			$LOGa.='</tr>';
			
		?>
		<?php }while($det=mysql_fetch_assoc($RSb)); ?>
		<?php if($vP==FALSE) break; ?>
		<?php $LOGa.='</table>' ?>
	<?php } ?>
		<td><?php echo $ID ?></td>
		<td>Visitas. <?php echo $tRSb ?></td>
		<td><?PHP echo $LOGa ?></td>
	</tr>
<?php }while($dRS=mysql_fetch_assoc($RS)); ?>
</table>
<?php } ?>
<?php 
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
//echo $LOG;
?>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
</body>
</html>