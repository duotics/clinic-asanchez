<?php include_once('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$dCon=detRow('db_consultas','con_num',$id);
if($dCon){//SI EXISTE CONSULTA
	//BUSCO LOS DIAGNOSTICOS
	$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
				SSQL($id,'int'));
	$RSld=mysql_query($qLD);
	$dRSld=mysql_fetch_assoc($RSld);
	$tRSld=mysql_num_rows($RSld);
	if($tRSld>0){
		do{
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
	}
	//BUSCO LOS EXAMENES
	$qLE=sprintf('SELECT * FROM db_examenes WHERE con_num=%s ORDER BY id_exa ASC',
				SSQL($id,'int'));
	$RSle=mysql_query($qLE);
	$dRSle=mysql_fetch_assoc($RSle);
	$tRSle=mysql_num_rows($RSle);
	//BUSCO DATOS PACIENTE
	$dPac=detRow('db_pacientes','pac_cod',$dCon['pac_cod']);
	$dPac_edad=edad($dPac['pac_fec']);
	$dPacSig=detSigLast($dCon[pac_cod]);
}
$css[body]='cero';
include(RAIZf.'head.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>css/cssPrint_01.css" />
<?php if($tRSle>0){ ?>
<?php do{ ?>
<?php
$ide=$dRSle[id_exa];
$dRSle_fecha=date_ame2euro($dRSle['fechae']);
//BUSCO FORMATO EXAMEN
$dRSleF=detRow('db_examenes_format','id',$dRSle[id_ef]);
$qlED=sprintf('SELECT db_examenes_det.res as eRes, db_examenes_format_det.nom as eNom
FROM db_examenes_det 
INNER JOIN db_examenes_format_det ON db_examenes_det.idefd=db_examenes_format_det.id
WHERE db_examenes_det.ide=%s',
			SSQL($ide,'int'));
$RSled=mysql_query($qlED);
$dRSled=mysql_fetch_assoc($RSled);
$tRSled=mysql_num_rows($RSled);
?>
<div class="print print-examen">
	<!-- ENCABEZADO -->
	<table class="tabMin tabHead tabClear">
		<col style="width: 10%" class="col1">
    	<col style="width: 40%">
    	<col style="width: 14%">
    	<col style="width: 36%">
		<tr>
			<td></td>
			<td><?php echo $dRSle_fecha ?> <strong>Ficha. <?php echo $dCon['pac_cod'] ?></strong></td>
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
	<table class="tabMinA tabDiag tabClear">
		<col style="width: 5%" class="col1">
    	<col style="width: 43%">
    	<col style="width: 4%">
    	<col style="width: 5%">
    	<col style="width: 43%">
		
		<tr>
			<td colspan="2"><strong>Diagnosticos</strong></td>
			<td></td>
			<td colspan="2"><strong>Diagnosticos</strong></td>
		</tr>
		
		<?php echo $resDiag ?>
	</table>
	<?php } ?>
	<!-- EXAMENES -->
	<div class="divider"></div>    
	<!-- SUBTIPOS EXAMEN -->
	<?php if($tRSled>0){
	$resED=NULL;
	do{
		$resED.='<tr>';
		$resED.='<td><span style="font-size:10px; color:#ccc">'.$dRSleF[nom].'</span></td>';
		$resED.='<td style="text-align:center; font-size:14px;">'.$dRSled['eNom'].'</td>';
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
	<?php if($dRSleF[enc]){ ?>
	<div>
		<?php echo $dRSleF[enc] ?>
	</div>
	<?php } ?>
	<?php if($dRSle[des]){ ?>
	<div style="padding: 0px; font-size: 10px">
		<div style="padding: 20px; margin: 20px; border: 1px solid #eee"><?php echo $dRSle[des] ?></div>
	</div>
	<?php } ?>
	<?php if($dRSleF[pie]){ ?>
	<?php $dRSleF[pie] = str_replace('{RAIZ}',$RAIZ,$dRSleF[pie]); ?>
	<?php echo $dRSleF[pie] ?>
	<?php } ?>
	<div class="sello">
		<div class="selloEA"><img src="<?php echo $RAIZa ?>images/struct/selloA-02.jpg" alt="" style="width: 100%"></div>
	</div>
</div>
<?php }while($dRSle=mysql_fetch_assoc($RSle)); ?>
<?php }else{ ?>
<h1>No examenes</h1>
<?php } ?>