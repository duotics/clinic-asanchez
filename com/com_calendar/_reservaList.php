<?php
$qRSr = sprintf("SELECT * FROM db_fullcalendar WHERE est=%s ORDER BY id DESC",
			   SSQL(1,'int'));
$RSr = mysql_query($qRSr) or die(mysql_error());
$dRSr = mysql_fetch_assoc($RSr);
$tRSr = mysql_num_rows($RSr);
?>
<div>
<?php echo genPageHeader($dC['mod_cod'],'page-header')?>
<?php if ($tRSr>0){?>
<table id="mytable" class="table table-bordered table-striped">
<thead>
	<tr>
		<th>Codigo</th>
    	<th></th>
    	<th>Fecha Hora Reserva</th>
      	<th>Paciente</th>
		<th>Auditoria</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <?php
	$detPac_cod=$dRSr['pac_cod'];
    $detPac=detRow('db_pacientes','pac_cod',$detPac_cod);
	$detAud_inf=infAud($dRSr['id_aud']);
	$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
	$btnAcc=NULL;
	if($detPac){
		$btnAcc='<a class="btn btn-default btn-xs" target="_parent" href="'.$RAIZc.'com_consultas/form.php?idp='.$detPac_cod.'">
		Tratar Consulta <i class="fa fa-chevron-right"></i></a>';
	}
	
	?>
    <tr>
    	<td><?php echo $dRSr['id']; ?></td>
		<td><?php echo $btnAcc ?></td>
		<td><?php echo $dRSr['fechai']?> <span class="badge"><?php echo $dRSr['horai'] ?></span></td>
		<td><?php echo $detPac_nom ?></td>
		<td><?php echo $detAud_inf ?></td>
    </tr>
    <?php } while ($dRSr = mysql_fetch_assoc($RSr)); ?>    
</tbody>
</table>
<?php } else { ?>
	<div class="alert alert-block"><h4>No hay reservas pendientes!</h4></div>
<?php } ?>
</div>
<?php mysql_free_result($RSr); ?>