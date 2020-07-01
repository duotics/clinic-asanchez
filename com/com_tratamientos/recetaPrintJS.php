<?php include_once('../../init.php');
$idt=vParam('id',$_GET['id'],$_POST['id']);
$dettrat=detRow('db_tratamientos','tid',$idt);//fnc_datatrat($idt);
$detCon=detRow('db_consultas','con_num',$dettrat['con_num']);//fnc_datatrat($idt);
//$detpac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);//dPac($dettrat['pac_cod']);
$dPac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);
$dettrat_fecha=date_ame2euro($dettrat['fecha']);
if($dettrat){
	$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
				SSQL($dettrat['con_num'],'int'));
	$RSld=mysql_query($qLD);
	$dRSld=mysql_fetch_assoc($RSld);
	$tRSld=mysql_num_rows($RSld);
}
$css[body]='cero';
include(RAIZf.'head.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>css/cssPrint_02-03.css" />
<div class="print print-receta">
	<!-- ENCABEZADO -->
	<table class="tabMin tabHead tabClear">
		<col style="width: 10%" class="col1">
    	<col style="width: 40%">
    	<col style="width: 14%">
    	<col style="width: 36%">
		<tr>
			<td></td>
			<td><?php echo $dettrat_fecha ?></td>
			<td></td>
			<td><?php echo $dettrat_fecha ?></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
			<td></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
		</tr>
	</table>
	<!-- DIAGNOSTICOS -->
	<?php
	if($tRSld>0){
		do{ 
			if($dRSld[id_diag]>1){
				$dDiag=detRow('db_diagnosticos','id_diag',$dRSld[id_diag]);
				$dDiag_cod=$dDiag[codigo].'-';
				$dDiag_nom=$dDiag[nombre];
			}else{
				$dDiag_cod=NULL;
				$dDiag_nom=$dRSld[obs];
			}
			$resDiag.='<td>Dx. '.$dDiag_cod.$dDiag_nom.'</td>';		
		}while($dRSld=mysql_fetch_assoc($RSld));
	}
	if($tRSld==1){
		$colDiagW='44%';
	}else if($tRSld==2){
		$colDiagW='22%';
	}
	?>
	<div style="display: block">
	<table class="tabMinA tabDiag tabClear">
    	<tr>
		<?php echo $resDiag ?>
		<td></td>
		<?php echo $resDiag ?>
		
		</tr>
	</table>
	</div>
	<!-- MEDICAMENTOS -->
	
	<div class="divider"></div>
	
    <?php
    //$qrytl=sprintf('SELECT * FROM db_tratamientos_detalle WHERE tid=%s AND tip="M" ORDER BY id ASC',
	//SSQL($idt,'int'));
	$qrytl=sprintf('SELECT * FROM db_tratamientos_detalle WHERE tid=%s ORDER BY id ASC',
	SSQL($idt,'int'));
	$RStl=mysql_query($qrytl);
	$dRStl=mysql_fetch_assoc($RStl);
	$tRStl=mysql_num_rows($RStl);
	$contmed=1;
	$contind=1;
	if($tRStl>0){
		do{
			if($dRStl[tip]=='G'){
				$resReceta.='<tr>';
				$resReceta.='<td>*</td>';
				$resReceta.='<td><strong style="text-decoration: underline;">'.strtoupper($dRStl[generico]).'</strong></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td>*</td>';
				$resReceta.='<td><strong style="text-decoration: underline;">'.strtoupper($dRStl[generico]).'</strong><br>
				<span style="font-size:10px;">'.$dRStl[descripcion].'</span></td>';
				$resReceta.='</tr>';
			}
			if($dRStl[tip]=='M'){
				$NE=new EnLetras();
				$medCantLT=$NE->ValorEnLetras($dRStl[numero],'');
				$resReceta.='<tr>';
				$resReceta.='<td>•</td>';
				$resReceta.='<td><strong>'.strtoupper($dRStl[generico]).' ('.strtoupper($dRStl[comercial]).') '.$dRStl[presentacion].' '.$dRStl[cantidad].' - # '.$dRStl[numero].' ('.$medCantLT.')'.'</strong></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td>•</td>';
				$resReceta.='<td><strong>'.strtoupper($dRStl[generico]).' ('.strtoupper($dRStl[comercial]).') '.$dRStl[presentacion].' '.$dRStl[cantidad].' - # '.$dRStl[numero].' ('.$medCantLT.')'.'</strong><br>
				<span style="font-size:10px;">'.$dRStl[descripcion].'</span></td>';
				$resReceta.='</tr>';
			}
			if($dRStl[tip]=='I'){
				if($contind==1){
					$resReceta.='<tr>';
					$resReceta.='<td></td>';
					$resReceta.='<td></td>';
					$resReceta.='<td></td>';
					$resReceta.='<td colspan="2"><div class="divider"></div><strong>INDICACIONES</strong></td>';
					$resReceta.='</tr>';
				}
				$resReceta.='<tr>';
				$resReceta.='<td></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td style="font-size:10px;">'.strtoupper($dRStl[indicacion]).'</td>';
				$resReceta.='</tr>';
				$contind++;
			}
			$contmed++;
		}while ($dRStl = mysql_fetch_assoc($RStl));
	}
	?>
	<?php
	if($detCon[con_diapc]){
		$nuevafecha = strtotime('+'.intval($detCon[con_diapc]).' day',strtotime($sdate));
		$verifPrx=date('w',$nuevafecha);
		if($verifPrx==6) $addDayS=$addDayS+2;
		else if($verifPrx==0) $addDayS++;
		if($addDayS){
			$fechaProcesa=date('Y-m-j' ,$nuevafecha );
			$nuevafecha = strtotime('+'.intval($addDayS).' day',strtotime($fechaProcesa));
		}
		setlocale(LC_ALL,"es_ES");
		$nuevafecha = date ( 'Y-m-d', $nuevafecha );
		$nuevafecha = utf8_encode(strftime("%A %d de %B del %Y", strtotime($nuevafecha)));
		//$finalfecha=strftime("%A %d de %B del %Y",strtotime($nuevafecha));
		
	}
	$proxima.='<strong>PROXIMA VISITA. '.$nuevafecha.'</strong>';
	if($detCon[con_typvisP]){
		$detTyp=detRow('db_types','typ_cod',$detCon[con_typvisP]);
		$proxima.='<br>Tipo Visita. <strong>'.$detTyp['typ_val'].'</strong>';
	}
	?>
	<div style="height: 300px; display: block">
	<table class="tabDet tabClear">
		<col style="width: 2%" class="col1">
    	<col style="width: 44%">
    	<col style="width: 6%">
    	<col style="width: 2%">
    	<col style="width: 46%">
		<?php echo $resReceta ?>
	</table>
	</div>
	<!--
	<table class="tabMinA tabClear">
		<col style="width: 5%" class="col1">
    	<col style="width: 43%">
    	<col style="width: 4%">
    	<col style="width: 5%">
    	<col style="width: 43%">
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo $proxima ?></td>
		</tr>
	</table>
-->
	<div class="sello">
		<div class="selloR1"><img src="<?php echo $RAIZ.$cfg[sello][A] ?>" alt="" style="width: 100%"></div>
	</div>
	<div class="sello">
		<div class="selloR2"><img src="<?php echo $RAIZ.$cfg[sello][A] ?>" alt="" style="width: 100%"></div>
	</div>
</div>