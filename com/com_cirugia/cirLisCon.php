<?php 
$qry=sprintf('SELECT * FROM db_cirugias WHERE con_num=%s OR pac_cod=%s ORDER BY id_cir DESC',
SSQL($idc,'int'),
SSQL($idp,'int'));
$RSc=mysql_query($qry);
$dRSc=mysql_fetch_assoc($RSc);
$tr_RSc=mysql_num_rows($RSc);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-medkit fa-lg"></i> CIRUGIAS
	  <a data-src="<?php echo $RAIZc ?>com_cirugia/cirugiaForm.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default btn-xs fancyR" data-fancybox data-type="iframe" data-touch="false" href="javascript:;">
		  <i class="fas fa-plus-square fa-lg"></i> NUEVO
	  </a>
  </div>
  <div class="panel-body">
  
<?php if ($tr_RSc>0){ ?>
<div>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Diagnostico</th>
		<th colspan="2">Cirugia Programada</th>
        <th colspan="2">Cirugia Realizada</th>
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
	
	if($dRSt['con_num']==$idc) $css['tr']='info';
	else $css['tr']='' ?>
	<tr class="<?php echo $css['tr'] ?>">
        	<td><?php echo $dRSc['id_cir'] ?></td>
			<td><?php echo $dRSc['diagnostico'] ?></td>
			<td><?php if($dRSc['fechar']){ ?><abbr title="<?php echo $dRSc['fechar'] ?>"><i class="fas fa-calendar fa-lg"></i></abbr><?php } ?></td>
            <td><?php echo $dRSc['cirugiar'] ?></td>
			<td><?php if($dRSc['fechap']){ ?><abbr title="<?php echo $dRSc['fechap'] ?>"><i class="fas fa-calendar fa-lg"></i></abbr><?php } ?></td>    
			<td><?php echo $dRSc['cirugiap'] ?></td>
            <td><div class="readmore"><?php echo $dRSc['protocolo'] ?></div></td>
            <td><?php echo $dRSc['evolucion'] ?></td>
            <td><?php echo totRowsTab('db_cirugias_media','id_cir',$dRSc['id_cir']) ?></td>
            <td>
            <div class="btn-group">
				<a class="btn btn-primary btn-xs fancyR" data-type="iframe" href="<?php echo $RAIZc ?>com_cirugia/cirugiaForm.php?idr=<?php echo $dRSc['id_cir'] ?>">
					<i class="fas fa-edit fa-lg"></i> Modificar
				</a>
				<a class="btn btn-danger btn-xs fancyRP" data-type="iframe" href="<?php echo $RAIZc; ?>com_cirugia/actions.php?idr=<?php echo $dRSc['id_cir'] ?>&acc=<?php echo md5(DELc) ?>">
					<i class="fas fa-trash fa-lg"></i> Eliminar
				</a>
            </div>
            </td>
        </tr>
        <?php } while ($dRSc = mysql_fetch_assoc($RSc));?>
        </tbody>
        </table>
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSc ?></div>
</div>