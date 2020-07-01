<?php
$TR=totRowsTabP('db_cirugias',$param);
$query_RSd=sprintf('SELECT * FROM db_cirugias WHERE 1=1 '.$param.' ORDER BY id_cir DESC');
?>
<?php if ($TR>0) {
$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSd = mysql_query($query_RSd.' '.$pages->limit) or die(mysql_error());
	$dRSc = mysql_fetch_assoc($RSd);
	$totalRows_RSd = mysql_num_rows($RSd);
?>
<?php include(RAIZf.'paginator.php') ?>
<table class="table table-striped table-bordered table-condensed">
	<colgroup>
		<col>
		<col width="10%">
		<col width="10%">
		<col width="10%">
		<col width="10%">
		<col width="20%">
		<col width="10%">
		<col>
		<col>
	</colgroup>
	<thead>
	<tr>
		<th>ID</th>
		<th>Paciente</th>
		<th>Diagnostico</th>
		<th>Cirugia Programada</th>
        <th>Cirugia Realizada</th>
        <th>Hallazgos</th>
        <th>Evolucion</th>
        <th>Multimedia</th>
        <th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
    $typexam=fnc_datatyp($dRSc['typ_cod']);
	$typexam=$typexam['typ_val'];
	$dPac=detRow('db_pacientes','pac_cod',$dRSc[pac_cod]) ?>
	<tr>
        	<td><?php echo $dRSc['id_cir'] ?></td>
			<td><?php echo $dPac[pac_nom].' '.$dPac[pac_ape] ?></td>
			<td><?php echo $dRSc['diagnostico'] ?></td>
            <td><abbr title="<?php echo $dRSc['fechar'] ?>"><?php echo $dRSc[cirugiar] ?></abbr></td>
			<td><abbr title="<?php echo $dRSc['fechap'] ?>"><?php echo $dRSc[cirugiap] ?></abbr></td>
            <td><div class="readmore"><?php echo $dRSc['protocolo'] ?></div></td>
            <td><?php echo $dRSc['evolucion'] ?></td>
            <td><?php echo totRowsTab('db_cirugias_media','id_cir',$dRSc['id_cir']) ?></td>
            <td>
            <div class="btn-group">
				<a class="btn btn-primary btn-xs fancyR" data-type="iframe" href="<?php echo $RAIZc ?>com_cirugia/cirugiaForm.php?idr=<?php echo $dRSc['id_cir'] ?>">
					<i class="fas fa-edit fa-lg"></i> Editar
				</a>
				<a class="btn btn-danger btn-xs fancyRP" data-type="iframe" href="<?php echo $RAIZc; ?>com_cirugia/actions.php?idr=<?php echo $dRSc['id_cir'] ?>&acc=<?php echo md5(DELc) ?>">
					<i class="fas fa-trash fa-lg"></i>
				</a>
            </div>
            </td>
        </tr>
         <?php } while ($dRSc = mysql_fetch_assoc($RSd)); ?>
	</tbody>
	</table>
		<?php include(RAIZf.'paginator.php') ?>
<?php mysql_free_result($RSd);?>
<?php }else{ ?>
	<div class="alert alert-warning"><h4>Sin Coincidencias de Busqueda</h4></div>
<?php } ?>