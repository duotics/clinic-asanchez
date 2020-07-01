<?php include_once('../../init.php');
if(!$id) $id=vParam('id',$_GET['id'],$_POST['id']);
$det=detRow('db_iess','id',$id);
$dPac=detRow('db_pacientes','pac_cod',$det['pac_cod']);
$dPac_sex=detRow('db_types','typ_cod',$dPac['pac_sexo']);
$detSuc=detRow('db_sucursales','id_suc',$det['id_suc']);
if($dPac) $dPac_nom=$dPac['pac_nom'].' '.$dPac['pac_ape'];
else $dPac_nom=$det['nomDif'];
$dMed=detRow('db_empleados','emp_cod',$det['emp_cod']);
$det_fecha=date_ame2euro($det['fecha']);
?>
<style type="text/css">
<!--
table{ width:  100%; border: solid 1px #5544DD; border-collapse: collapse;}
table.tabMin{ font-size: 11px; }
table.tabHead{}
table.tabHead tr th{background: #DAF4DA}
table.tabCont{}
table.tabCont tr th{background: #D6CEF1; font-size: 15px;}
table.tabCont tr td{padding: 4px 8px;}
th, td{ border: 1px solid #ccc; padding: 3px 4px; min-height: 15px;}
tr.trMini{ font-size: 9px;}
td.tdMini, th.tdMini{font-size: 10px;}
td.tdMiniA, th.tdMiniA{font-size: 9px;}
td.tdMiniB, th.tdMiniB{font-size: 8px;}
td.tdMiniC, th.tdMiniC{font-size: 7px;}
tr.trAux{background: #E4E9F7; vertical-align: middle;}
.gen{ background:#FFF; font-size: 12px; }
	.text-center{text-align: center}
	.text-right{text-align: right}
-->
</style>
<page class="gen">
	<!--BEG REPORTE IESS-->
	<!--0 HEAD-->
	<table class="tabMin tabHead">
		<col style="width: 18%" class="col1">
    	<col style="width: 26%">
    	<col style="width: 26%">
    	<col style="width: 6%">
    	<col style="width: 6%">
    	<col style="width: 18%">
		<tr>
			<th>ESTABLECIMIENTO</th>
			<th>NOMBRE</th>
			<th>APELLIDO</th>
			<th>SEXO</th>
			<th>EDAD</th>
			<th>N. HISTORIA CLÍNICA</th>
		</tr>
		<tr>
			<td><?php echo $detSuc['nom_suc'] ?></td>
			<td><?php echo $dPac['pac_nom'] ?></td>
			<td><?php echo $dPac['pac_ape'] ?></td>
			<td><?php echo substr($dPac_sex['typ_val'],0,1);  ?></td>
			<td><?php echo edad($dPac['pac_fec']) ?></td>
			<td><?php echo $dPac['pac_ced'] ?></td>
		</tr>
	</table>
   	<br>
   <!--1 MOTIVO DE LA CONSULTA-->
   	<table class="tabCont">
		<col style="width: 100%" class="col1">
   		<tr>
			<th>1 MOTIVO DE LA CONSULTA</th>
		</tr>
		<tr>
			<td style="vertical-align: top;"><?php echo $det['mot_con'] ?></td>
		</tr>
	</table>
   	<br>
   	<!--2 ANTECEDENTES PERSONALES-->
   	<table class="tabCont">
		<col style="width: 100%" class="col1">
   		<tr>
			<th>2 ANTECEDENTES PERSONALES</th>
		</tr>
		<tr>
			<td style="vertical-align: top; height: 30px;"><?php echo $det['ant_per'] ?></td>
		</tr>
	</table>
   	<br>
	<!--3 ANTECEDENTES FAMILIARES-->
   	<?php 
	$RSaf=detRowGSel('db_types','typ_cod','typ_val','typ_ref','RIESS-AF');
	$dRSaf=mysql_fetch_assoc($RSaf);
	$tRSaf=mysql_num_rows($RSaf);
	?>
	<table class="tabCont">
		<?php 
		$Paf_w=8;
		for($xaf_col=0;$xaf_col<=($tRSaf*2)-1;$xaf_col++){
			echo '<col style="width: '.$Paf_w.'%">';
			if($Paf_w==8)$Paf_w=2;
			else $Paf_w=8;
		}
		?>
   		<tr>
			<th colspan="20">3 ANTECEDENTES FAMILIARES</th>
		</tr>

		<tr>
			<?php 
			$arrayEA=explode(',',$det['ant_fam_sel']);
			do{
				$Caf++;
				echo '<td class="tdMiniC text-center">'.$Caf.'. '.$dRSaf['sVAL'].'</td>';
				if(in_array($dRSaf['sID'],$arrayEA)) echo '<td>'.'X'.'</td>';
				else echo '<td></td>';
			}while($dRSaf=mysql_fetch_assoc($RSaf));
			?>
	   	</tr>
		<tr>
			<td colspan="20" style="vertical-align: top; height: 20px;"><?php echo $det['ant_fam_des'] ?></td>
		</tr>
	</table>
	<br>
	<!--4 ENFERMEDAD O PROBLEMA ACTUAL-->
	<table class="tabCont">
		<col style="width: 100%" class="col1">
   		<tr>
			<th>4 ENFERMEDAD O PROBLEMA ACTUAL</th>
		</tr>
		<tr>
			<td style="vertical-align: top; height: 60px;"><?php echo $det['enf_act'] ?></td>
		</tr>
	</table>
	<br>
	<!--5 REVISION ACTUAL DE ORGANOS Y SISTEMAS-->
	<?php
	$qROS=sprintf('SELECT * FROM `db_types` WHERE `typ_ref`=%s GROUP BY `typ_val` ORDER BY typ_ord',
				   SSQL('RIESS-ROS','text'));
	$RSros=mysql_query($qROS);
	$dRSros=mysql_fetch_assoc($RSros);
	?>
	<table class="tabCont">
		<col style="width: 14%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 14%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 14%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 14%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 14%">
		<col style="width: 3%">
		<col style="width: 3%">

   		<tr>
			<th colspan="7">5 REVISION ACTUAL DE ÓRGANOS Y SISTEMAS</th>
			<th colspan="5" class="tdMiniC">
				CP = CON EVIDENCIA DE PATOLOGÍA MARCAR CON ¨X¨ Y DESCRIBIR ABAJO ANOTANDO EL NÚMERO Y LETRA CORRESPONDIENTE
			</th>
			<th colspan="3" class="tdMiniC">
				SP = SIN EVIDENCIA DE PATOLOGÍA MARCAR ¨X¨ Y NO DESCRIBIR
			</th>
		</tr>
		<tr class="trMini trAux">
			<td></td>
			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
	   	</tr>
	   	<tr>
	   	<?php
		$Cros=1;
		$Crost=1;
		$arrayRO=explode(',',$det['rev_org_sel']);
		do{
			echo '<td class="tdMiniB">'.$Cros.'. '.$dRSros['typ_val'].'</td>';
			
			$qROSt=sprintf('SELECT * FROM db_types WHERE typ_ref=%s AND typ_val=%s',
						  SSQL('RIESS-ROS','text'),
						  SSQL($dRSros['typ_val'],'text'));
			$RSrost=mysql_query($qROSt);
			$dRSrost=mysql_fetch_assoc($RSrost);
			$tRSrost=mysql_num_rows($RSrost);
			do{
				if(in_array($dRSrost['typ_cod'],$arrayRO)) echo '<td>X</td>';
				else echo '<td></td>';	
			}while($dRSrost=mysql_fetch_assoc($RSrost));
			
			//echo '<td></td>';
			//echo '<td></td>';
			
			if($Crost>=5){
				$Crost=0;
				echo '</tr><tr>';
			}else $Crost++;
			$Cros++;
		}while($dRSros=mysql_fetch_assoc($RSros));
		?>
		</tr>
		
		<tr>
			<td colspan="15" style="vertical-align: top; height: 20px;"><?php echo $det['rev_org_des'] ?></td>
		</tr>
	</table>
	<br>
	<!--6 SIGNOS VITALES Y ANTROPOMETRIA-->
	<?php
	$qRs=sprintf('SELECT * FROM db_iess_sig WHERE id_rep=%s ORDER BY id ASC LIMIT 4',
				SSQL($id,'int'));
	$RSsig=mysql_query($qRs);
	$dRSsig=mysql_fetch_assoc($RSsig);
	$tRSsig=mysql_num_rows($RSsig);
	$Csig=0;
	if($tRSsig>0){
		do{
			$arraySIG['fecha'][$Csig]=$dRSsig['fecha'];
			$arraySIG['temp'][$Csig]=$dRSsig['temp'];
			$arraySIG['presA'][$Csig]=$dRSsig['presA'];
			$arraySIG['presB'][$Csig]=$dRSsig['presB'];
			$arraySIG['puls'][$Csig]=$dRSsig['puls'];
			$arraySIG['frec'][$Csig]=$dRSsig['frec'];
			$arraySIG['peso'][$Csig]=$dRSsig['peso'];
			$arraySIG['talla'][$Csig]=$dRSsig['talla'];
			$Csig++;	
		}while($dRSsig=mysql_fetch_assoc($RSsig));
	}
	?>
	<table class="tabCont">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
		<col style="width: 10%">
   		<tr>
			<th colspan="10">6 SIGNOS VITALES Y ANTROPOMETRÍA</th>
		</tr>
		<tr>
			<td colspan="2" class="tdMiniB">FECHA DE MEDICIÓN</td>
   			<?php
				for($xSF=0;$xSF<=3;$xSF++){
					echo '<td colspan="2">'.$arraySIG['fecha'][$xSF].'</td>';
				}
			?>
	   	</tr>
	   	<tr>
			<td colspan="2" class="tdMiniB">TEMPERATURA °C</td>
   			<?php
				for($xST=0;$xST<=3;$xST++){
					echo '<td colspan="2">'.$arraySIG['temp'][$xST].'</td>';
				}
			?>
	   	</tr>
	   	<tr>
			<td colspan="2" class="tdMiniB">PRESIÓN ARTERIAL</td>
   			<?php
				for($xSP=0;$xSP<=3;$xSP++){
					echo '<td>'.$arraySIG['presA'][$xSP].'</td>';
					echo '<td>'.$arraySIG['presB'][$xSP].'</td>';
				}
			?>
	   	</tr>
	   	<tr>
			<td class="tdMiniB">PULSO / min</td>
			<td class="tdMiniB">FRECUENCIA RESPIRATORIA</td>
   			<?php
				for($xSPF=0;$xSPF<=3;$xSPF++){
					echo '<td>'.$arraySIG['puls'][$xSPF].'</td>';
					echo '<td>'.$arraySIG['frec'][$xSPF].'</td>';
				}
			?>
	   	</tr>
	   	<tr>
			<td class="tdMiniB">PESO / Kg</td>
			<td class="tdMiniB">TALLA / cm</td>
   			<?php
				for($xSPT=0;$xSPT<=3;$xSPT++){
					echo '<td>'.$arraySIG['peso'][$xSPT].'</td>';
					echo '<td>'.$arraySIG['talla'][$xSPT].'</td>';
				}
			?>
	   	</tr>
	   	
	</table>
	<br>
	<!--7 EXAMEN FISICO REGIONAL-->
	<?php
	$qREF=sprintf('SELECT * FROM `db_types` WHERE `typ_ref`=%s GROUP BY `typ_val` ORDER BY typ_ord',
				   SSQL('RIESS-EFR','text'));
	$RSref=mysql_query($qREF);
	$dRSref=mysql_fetch_assoc($RSref);
	$tRSref=mysql_num_rows($RSref);
	?>
	<table class="tabCont">
		<col style="width: 10%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 10%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 11%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 11%">
		<col style="width: 3%">
		<col style="width: 3%">
		<col style="width: 11%">
		<col style="width: 3%">
		<col style="width: 3%">
 		<col style="width: 11%">
 		<col style="width: 3%">
 		<col style="width: 3%">
   		<tr>
			<th colspan="18">7 EXAMEN FÍSICO REGIONAL</th>
		</tr>
		<tr class="trMini">
			<td></td>
			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
   			<td></td>
   			<td>CP</td>
   			<td>SP</td>
	   	</tr>
		<tr>
			<?php
			$Cref=1;
			$arrayEF=explode(',',$det['exa_fis_sel']);
			do{
				echo '<td class="tdMiniC">'.$Cref.'. '.$dRSref['typ_val'].'</td>';
				$qREFt=sprintf('SELECT * FROM db_types WHERE typ_ref=%s AND typ_val=%s',
							  SSQL('RIESS-EFR','text'),
							  SSQL($dRSref['typ_val'],'text'));
				$RSreft=mysql_query($qREFt);
				$dRSreft=mysql_fetch_assoc($RSreft);
				$tRSreft=mysql_num_rows($RSreft);
				do{
					if(in_array($dRSreft['typ_cod'],$arrayEF)) echo '<td>X</td>';
					else echo '<td></td>';	
				}while($dRSreft=mysql_fetch_assoc($RSreft));
				$Cref++;
			}while($dRSref=mysql_fetch_assoc($RSref));
			?>
	   	</tr>
		<tr>
			<td colspan="18" style="vertical-align: top; height: 30px;"><?php echo $det['exa_fis_des'] ?></td>
		</tr>
	</table>
	<br>
	<!--8 DIAGNOSTICO-->
	<?php
	$qRd=sprintf('SELECT * FROM db_iess_diag WHERE id_rep=%s ORDER BY id ASC LIMIT 4',
				SSQL($id,'int'));
	$RSd=mysql_query($qRd);
	$dRSd=mysql_fetch_assoc($RSd);
	$tRSd=mysql_num_rows($RSd);
	$Cd=0;
	if($tRSd>0){
		do{
			$arrayDIAG['diag'][$Cd]=$dRSd['diag'];
			$arrayDIAG['cie'][$Cd]=$dRSd['cie'];
			$arrayDIAG['tip'][$Cd]=$dRSd['tip'];
			$Cd++;	
		}while($dRSd=mysql_fetch_assoc($RSd));
	}
	?>
	<table class="tabCont">
		<col style="width: 5%">
		<col style="width: 25%">
		<col style="width: 10%">
		<col style="width: 5%">
		<col style="width: 5%">
		<col style="width: 5%">
		<col style="width: 25%">
		<col style="width: 10%">
		<col style="width: 5%">
		<col style="width: 5%">
   		<tr>
			<th colspan="5">8 DIANÓSTICO</th>
			<th colspan="5" class="tdMiniC">
			PRE = PRESUNTIVO<br>
			DEF = DEFINITIVO
			</th>
		</tr>
		<tr class="trMini trAux">
			<td></td>
			<td></td>
			<td>CIE</td>
			<td>PRE</td>
			<td>DEF</td>
			<td></td>
			<td></td>
			<td>CIE</td>
			<td>PRE</td>
			<td>DEF</td>
		</tr>
		<tr>
			<td>1</td>
			<td><?php echo $arrayDIAG['diag'][0] ?></td>
			<td><?php echo $arrayDIAG['cie'][0] ?></td>
			<td><?php if($arrayDIAG['tip'][0]=='P') echo 'X' ?></td>
			<td><?php if($arrayDIAG['tip'][0]=='D') echo 'X' ?></td>
			<td>3</td>
			<td><?php echo $arrayDIAG['diag'][2] ?></td>
			<td><?php echo $arrayDIAG['cie'][2] ?></td>
			<td><?php if($arrayDIAG['tip'][2]=='P') echo 'X' ?></td>
			<td><?php if($arrayDIAG['tip'][2]=='D') echo 'X' ?></td>
		</tr>
		<tr>
			<td>2</td>
			<td><?php echo $arrayDIAG['diag'][1] ?></td>
			<td><?php echo $arrayDIAG['cie'][1] ?></td>
			<td><?php if($arrayDIAG['tip'][1]=='P') echo 'X' ?></td>
			<td><?php if($arrayDIAG['tip'][1]=='D') echo 'X' ?></td>
			<td>4</td>
			<td><?php echo $arrayDIAG['diag'][3] ?></td>
			<td><?php echo $arrayDIAG['cie'][3] ?></td>
			<td><?php if($arrayDIAG['tip'][3]=='P') echo 'X' ?></td>
			<td><?php if($arrayDIAG['tip'][3]=='D') echo 'X' ?></td>
		</tr>
		<!--
		<tr>
			<td colspan="2" class="tdMiniB">FECHA DE MEDICIÓN</td>
   			<?php
				for($xSF=0;$xSF<=3;$xSF++){
					echo '<td colspan="2">'.$arraySIG['fecha'][$xSF].'</td>';
				}
			?>
	   	</tr>
	   	<tr>
			<td colspan="2" class="tdMiniB">TEMPERATURA °C</td>
   			<?php
				for($xST=0;$xST<=3;$xST++){
					echo '<td colspan="2">'.$arraySIG['temp'][$xST].'</td>';
				}
			?>
	   	</tr>
	   	-->
	</table>
	<br>
	<!--9 PLANES DE TRATAMIENTO-->
	<table class="tabCont">
		<col style="width: 100%" class="col1">
   		<tr>
			<th>9 PLANES DE TRATAMIENTO</th>
		</tr>
		<tr>
			<td style="vertical-align: top; height: 40px;"><?php echo $det['planes'] ?></td>
		</tr>
	</table>
	<br>
	<!--0 FOOT-->
	<table class="tabMin tabHead">
		<col style="width: 7%" class="col1">
    	<col style="width: 10%">
    	<col style="width: 6%">
    	<col style="width: 8%">
    	<col style="width: 12%">
    	<col style="width: 15%">
    	<col style="width: 8%">
    	<col style="width: 8%">
    	<col style="width: 15%">
    	<col style="width: 7%">
    	<col style="width: 4%">
		<tr>
			<th>FECHA</th>
			<td><?php echo $det['fecha'] ?></td>
			<th>HORA</th>
			<td><?php echo $det['hora'] ?></td>
			<th>NOMBRE DEL PROFESIONAL</th>
			<td><?php echo $dMed['emp_nom'].' '.$dMed['emp_ape'] ?></td>
			<td style="vertical-align: top">CODIGO<br>
			</td>
			<th>FIRMA</th>
			<td></td>
			<th>NUM. HOJA</th>
			<td></td>
		</tr>
	</table>
	<!--END REPORTE IESS-->
	<br>
	<table>
		<col style="width: 40%" class="col1">
    	<col style="width: 60%">
		<tr>
			<td style="text-align: left">SNS-MSP / HCU-form.002 / 2008</td>
			<th style="text-align: right">CONSULTA EXTERNA - ANAMNESIS Y EXAMEN FISICO</th>
		</tr>
	</table>
</page>
<page>
	<!--BEG REPORTE IESS POSTERIOR-->
	<table style="height: 92%">
		<col style="width: 55%">
    	<col style="width: 45%">
		<tr>
			<!--10 EVOLUCION-->
			<td style="height: 100%; vertical-align: top;">
				<?php
				$qEVO=sprintf('SELECT * FROM db_iess_evo WHERE id_rep=%s ORDER BY id ASC LIMIT 40',
							 SSQL($id,'int'));
				$RSevo=mysql_query($qEVO);
				$dRSevo=mysql_fetch_assoc($RSevo);
				$tRSevo=mysql_num_rows($RSevo);
				?>
				<table style="height: 100%" class="tabCont">
					<col style="width: 20%" class="col1">
					<col style="width: 10%">
					<col style="width: 70%">
					<tr>
						<th colspan="2">10 EVOLUCION</th>
						<th class="tdMiniC text-right">FIRMAR AL PIE DE CADA NOTA</th>
					</tr>
					<tr class="trMini trAux text-center">
						<td>FECHA<br>(DIA/MES/AÑO)</td>
						<td>HORA</td>
						<td>NOTAS DE EVOLUCION</td>
					</tr>
					<?php if($tRSevo>0){ ?>
					<?php $Cevo=0; ?>
					<?php do{ ?>
					<tr>
						<td class="tdMini"><?php echo $dRSevo['fecha'] ?></td>
						<td class="tdMini"><?php echo $dRSevo['hora'] ?></td>
						<td class="tdMini"><?php echo $dRSevo['notas'] ?></td>
					</tr>
					<?php $Cevo++; ?>
					<?php }while($dRSevo=mysql_fetch_assoc($RSevo)); ?>
					<?php } ?>
					<?php for($xEVO=0;$xEVO<=40-$Cevo;$xEVO++){ ?>
					<tr>
						<td>&nbsp;</td>
						<td></td>
						<td></td>
					</tr>
					<?php } ?>
				</table>
			</td>
			<!--11 PRESCRIPCIONES-->
			<td style="height: 100%; vertical-align: top;">
				<?php
				$qPRE=sprintf('SELECT * FROM db_iess_pres WHERE id_rep=%s ORDER BY id ASC LIMIT 40',
							 SSQL($id,'int'));
				$RSpre=mysql_query($qPRE);
				$dRSpre=mysql_fetch_assoc($RSpre);
				$tRSpre=mysql_num_rows($RSpre);
				?>
				<table style="height: 100%" class="tabCont">
					<col style="width: 75%" class="col1">
					<col style="width: 25%">
					<tr>
						<th>11 PRESCRIPCIONES</th>
						<th class="tdMiniC text-right">FIRMAR AL PIE DE CADA PRESCRIPCION</th>
					</tr>
					<tr class="trMini trAux">
						<td>FARMACOTERAPIA E INDICACIONES</td>
						<td>ADMINISTR. FARMACOS Y OTROS</td>
					</tr>
					<?php if($tRSpre>0){ ?>
					<?php $Cpre=0; ?>
					<?php do{ ?>
					<tr>
						<td class="tdMini"><?php echo $dRSpre['farmaco'] ?></td>
						<td class="tdMini"><?php echo $dRSpre['admin'] ?></td>
					</tr>
					<?php $Cpre++; ?>
					<?php }while($dRSpre=mysql_fetch_assoc($RSpre)); ?>
					<?php } ?>
					<?php for($xPRE=0;$xPRE<=40-$Cpre;$xPRE++){ ?>
					<tr>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<table>
		<col style="width: 40%" class="col1">
    	<col style="width: 60%">
		<tr>
			<td style="text-align: left">SNS-MSP / HCU-form.002 / 2008</td>
			<th style="text-align: right">CONSULTA EXTERNA - EVOLUCIÓN Y PRESCRIPCIONES</th>
		</tr>
	</table>
	<!--END REPORTE IESS POSTERIOR-->
</page>