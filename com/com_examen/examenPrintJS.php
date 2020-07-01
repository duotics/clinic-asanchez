<?php include_once('../../init.php');

$id=vParam('id',$_GET['id'],$_POST['id']);
$dExa=detRow('db_examenes','id_exa',$id);//fnc_datatrat($idt);
$detCon=detRow('db_consultas','con_num',$dExa['con_num']);//fnc_datatrat($idt);
//$detpac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);//dPac($dExa['pac_cod']);
$dPac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);
$dExa_fecha=date_ame2euro($dExa['fechae']);
if($dExa){
	$dExaF=detRow('db_examenes_format','id',$dExa[id_ef]);
	$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
				SSQL($dExa['con_num'],'int'));
	//echo $qLD.'<br>';
	$RSld=mysql_query($qLD);
	$dRSld=mysql_fetch_assoc($RSld);
	$tRSld=mysql_num_rows($RSld);
	
	$qlED=sprintf('SELECT db_examenes_det.res as eRes, db_examenes_format_det.nom as eNom
	FROM db_examenes_det 
	INNER JOIN db_examenes_format_det ON db_examenes_det.idefd=db_examenes_format_det.id
	WHERE db_examenes_det.ide=%s',
				SSQL($id,'int'));
	//echo $qlED.'<br>';
	$RSled=mysql_query($qlED);
	$dRSled=mysql_fetch_assoc($RSled);
	$tRSled=mysql_num_rows($RSled);
	
	$dPac_edad=edad($dPac['pac_fec']);
	
	$dPacSig=detSigLast($detCon[pac_cod]);
}
$css[body]='cero';
?>
<?php include(RAIZf.'head.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>css/cssPrint_01.css" />
<div class="print print-examen">
	<!-- ENCABEZADO -->
	<table class="tabMin tabHead tabClear">
		<col style="width: 10%" class="col1">
    	<col style="width: 40%">
    	<col style="width: 14%">
    	<col style="width: 36%">
		<tr>
			<td></td>
			<td><?php echo $dExa_fecha ?> <strong>Ficha. <?php echo $detCon['pac_cod'] ?></strong></td>
			<td></td>
			<td><strong>F.Nac. <?php echo $dPac['pac_fec'] ?></strong> - <?php echo $dPac_edad ?> años</td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
			<td></td>
			<td>
				<span title="Peso" class="badge tooltips"><?php echo $dPacSig['peso'] ?> Kg.</span> 
				<span title="Estatura"  class="badge tooltips"><?php echo $dPacSig['talla'] ?> cm.</span> 
			</td>
		</tr>
	</table>
	<hr>
	<!-- DIAGNOSTICOS -->
	<?php if($tRSld>0){ ?>
	<?php
		$resDiag.='<tr>';
		$resDiag.='<td colspan="2"><strong>Diagnosticos</strong></td>';
		$resDiag.='<td></td>';
		$resDiag.='<td colspan="2"><strong>Diagnosticos</strong></td>';
		$resDiag.='</tr>';
	?>
	<?php do{ ?>
	<?php
		if($dRSld[id_diag]>1){
			$dDiag=detRow('db_diagnosticos','id_diag',$dRSld[id_diag]);
			$dDiag_cod=$dDiag[codigo];
			$dDiag_nom=$dDiag[nombre];
		}else{
			$dDiag_cod=NULL;
			$dDiag_nom=$dRSld[obs];
		}
		
		$resDiag.='<tr>';
		$resDiag.='<td>'.$dDiag_cod.'</td>';
		$resDiag.='<td>'.$dDiag_nom.'</td>';
		$resDiag.='<td></td>';
		$resDiag.='<td>'.$dDiag_cod.'</td>';
		$resDiag.='<td>'.$dDiag_nom.'</td>';
		$resDiag.='</tr>';
	
	}while($dRSld=mysql_fetch_assoc($RSld));
	?>
	<table class="tabMinA tabDiag tabClear">
		<col style="width: 5%" class="col1">
    	<col style="width: 43%">
    	<col style="width: 4%">
    	<col style="width: 5%">
    	<col style="width: 43%">
		<?php echo $resDiag ?>
	</table>
	<?php } ?>
	<!-- EXAMENES -->
	
	<div class="divider"></div>    
	<!-- SUBTIPOS EXAMEN -->
	<?php if($tRSled>0){ ?>
	<?php do{ ?>

	<?php
		$resED.='<tr>';
		$resED.='<td><span style="font-size:10px; color:#ccc">'.$dExaF[nom].'</span></td>';
		$resED.='<td style="text-align:left; font-size:14px;">'.$dRSled['eNom'].'</td>';
		$resED.='<td></td>';
		$resED.='</tr>';
	
	}while($dRSled=mysql_fetch_assoc($RSled));
	?>
	<table class="tabMinA tabDiag tabClear">
		<col style="width: 15%" class="col1">
    	<col style="width: 70%">
    	<col style="width: 15%">
		<tr>
			<td><strong>Examenes</strong></td>
			<td></td>
			<td></td>
		</tr>
		<?php echo $resED ?>
	</table>
	<?php } ?>
	<?php if($dExaF[enc]){ ?>
	<div>
		<?php echo $dExaF[enc] ?>
	</div>
	<?php } ?>
	<?php if($dExa[des]){ ?>
	<div style="padding: 0px; font-size: 10px">
		<div style="padding: 20px; margin: 20px; border: 1px solid #eee"><?php echo $dExa[des] ?></div>
	</div>
	<?php } ?>
	<?php if($dExaF[pie]){ ?>
	<?php $dExaF[pie] = str_replace('{RAIZ}',$RAIZ,$dExaF[pie]); ?>
	<?php echo $dExaF[pie] ?>
	<?php } ?>
	<div class="sello">
		<div class="selloEA"><img src="<?php echo $RAIZa ?>images/struct/selloA-02.jpg" alt="" style="width: 100%"></div>
	</div>
</div>