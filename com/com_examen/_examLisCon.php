<?php 
$qry=sprintf('SELECT * FROM db_examenes WHERE con_num=%s OR pac_cod=%s ORDER BY con_num DESC, id_exa DESC',
SSQL($idc,'int'),
SSQL($idp,'int'));
$RSe=mysql_query($qry);
$dRSe=mysql_fetch_assoc($RSe);
$tr_RSe=mysql_num_rows($RSe);
?>
<div>
	<?php if ($tr_RSe>0){ ?>
	<table class="table table-bordered table-hover table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha</th>
		<th>Detalle</th>
		<th>Ver</th>
		<th>Imagenes</th>
		<th></th>
		<th></th>
		<th>Consulta</th>
	</tr>
	</thead>
	<tbody>
	<?php $contCG=0; ?>
	<?php do{ ?>
	<?php
	$tEFD=totRowsTab('db_examenes_det','ide',$dRSe['id_exa']);
	//Total de Examenes con esta consulta
	$tECG=totRowsTab('db_examenes','con_num',$dRSe['con_num']);
	$ExaResGen=NULL;
	$btnPEC=NULL;
	$vPEC=FALSE;
	if($tEFD>0){
		$qryLTEF=sprintf('SELECT * FROM db_examenes_det WHERE ide=%s',
				  SSQL($dRSe['id_exa'],'int'));
		$RSltef=mysql_query($qryLTEF);
		$dRSltef=mysql_fetch_assoc($RSltef);
		$tRSltef=mysql_num_rows($RSltef);
	}else{
		$ExaResGen='<input type="text" class="form-control input-sm setDB" name="resultado" data-id="'.$dRSe['id_exa'].'" data-rel="exa" value="'.$dRSe['resultado'].'" placeholder="resultado NF"/>';
	}
	$dEF=detRow('db_examenes_format','id',$dRSe['id_ef']);
	$btnView=NULL;
	if($dRSe['des']) $btnView='<a href="'.$RAIZc.'com_examen/examenPreview.php?id='.$dRSe['id_exa'].'" class="btn btn-default btn-xs fancybox.iframe fancyreload"><i class="fa fa-eye"></i></a>';
	$idc_act=$dRSe['con_num'];
	if($idc_act==$id_ant){
		$contCG++;
		//$btnPEC='<td colspan="2"></td>';
	}else{ 
		$contCG=0;
		$id_ant=$idc_act;
		$vPEC=TRUE;
		$btnPEC='<td style="vertical-align:middle; text-align: center" rowspan="'.$tECG.'">';
		$btnPEC.='<a class="printerButton btn btn-default btn-sm" data-id="'.$dRSe['con_num'].'" data-rel="'.$RAIZc.'com_examen/examenGPrintJS.php">
		<i class="fas fa-print fa-lg"></i> Imprimir Grupo Examenes</a>';
		$btnPEC.='</td>';
		$btnPEC.='<td style="vertical-align:middle; text-align: center" rowspan="'.$tECG.'">';
		$btnPEC.=$dRSe['con_num'];
		$btnPEC.='</td>';
	}
	if($dRSe['con_num']==$idc) $css['tr']='info';
	else $css['tr']='' ?>
	<tr class="<?php echo $css['tr'] ?>">
		<td><?php echo $dRSe['id_exa'] ?></td>
		<td><?php echo $dRSe['fecha'] ?></td>
		<td>
			<fielset class="form-horizontal">
			<?php if(!$tEFD){ ?>
				<div class="form-group">
					<label class="control-label col-sm-6">
					<?php if($dRSe['obs']){ ?>
					<?php if($dEF['nom']) echo '<br>';
					echo $dRSe['obs'] ?>
					<?php } ?>
					<span class="label label-default"><?php echo $dEF['nom'] ?></span>
					</label>
					<div class="col-sm-6"><?php echo $ExaResGen ?></div>
				</div>
			<?php } ?>
			<?php if($tEFD>0){ ?>
			<?php do{ ?>
			<?php $detEFN=detRow('db_examenes_format_det','id',$dRSltef[idefd]); ?>
				<div class="form-group">
				<label class="control-label col-sm-6"><?php echo $detEFN[nom] ?> 
				<span class="label label-default"><?php echo $dEF['nom'] ?></span></label>
				<div class="col-sm-6">
				<input type="text" class="form-control input-sm setDB" name="res" data-id="<?php echo $dRSltef['id'] ?>" data-rel="exadet" value="<?php echo $dRSltef['res'] ?>" placeholder="resultado"/>
				</div>
				</div>
			<?php }while($dRSltef=mysql_fetch_assoc($RSltef)) ?>
			<?php } ?>
			</fielset>
		</td>
		<td><?php echo $btnView ?></td>
		<td><?php echo totRowsTab('db_examenes_media','id_exa',$dRSe['id_exa']) ?></td>
		<td>
			<div class="btn-group">
				<a href="<?php echo $RAIZc ?>com_examen/examenForm.php?ide=<?php echo $dRSe['id_exa'] ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
					<i class="fas fa-edit fa-lg"></i> Editar
				</a>
				<a class="printerButton btn btn-default btn-xs" data-id="<?php echo $dRSe['id_exa'] ?>" data-rel="<?php echo $RAIZc ?>com_examen/examenPrintJS.php">
				<i class="fas fa-print fa-lg"></i></a>
				
				<a class="btn btn-danger btn-xs fancyRP" data-type="iframe" href="<?php echo $RAIZc; ?>com_examen/_fncts.php?ide=<?php echo $dRSe['id_exa'] ?>&acc=<?php echo md5(DELe) ?>">
					<i class="fas fa-trash fa-lg"></i>
				</a>
				
			</div>
		</td>
	<?php if($vPEC){
	echo $btnPEC;
	$vPEC=FALSE;
	} ?>
	</tr>
	<?php } while ($dRSe = mysql_fetch_assoc($RSe));?>
	</tbody>
	</table>
	<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
	</div>