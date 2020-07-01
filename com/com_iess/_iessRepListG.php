<?php 
$qry='SELECT * FROM db_iess ORDER BY id DESC ';
$RS = mysql_query($qry) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$tRS = mysql_num_rows($RS);
$TR=$tRS;
if($tRS>0){
	$pages = new Paginator;
	$pages->items_total = $tRS;
	$pages->mid_range = 7;
	$pages->paginate();
	$RSr=mysql_query($qry.$pages->limit);
	$dRSr=mysql_fetch_assoc($RSr);
	$trRSr=mysql_num_rows($RSr);
}
?>
<div>
<?php if ($tRS>0){ ?>
	<?php include(RAIZf.'paginator.php') ?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha</th>
		<th>Paciente</th>
		<th>Establecimiento</th>
		<th>Responsable</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
		<?php
		$dSuc=detRow('db_sucursales','id_suc',$dRSr['id_suc']);
		$dPac=detRow('db_pacientes','pac_cod',$dRSr['pac_cod']);
		$dEmp=detRow('db_empleados','emp_cod',$dRSr['emp_cod']);
		?>
		<tr>
			<td><?php echo $dRSr[id] ?></td>
        	<td><?php echo infAud($dRSr[id_aud]) ?></td>
        	<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
			<td><?php echo $dSuc['nom_suc'] ?></td>
			<td><?php echo $dEmp['emp_nom'].' '.$dEmp['emp_ape'] ?></td>
            <td>
            <div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_iess/iessRepForm.php?idr=<?php echo $dRSr['id'] ?>" data-type="iframe" class="btn btn-xs btn-primary fancyR">
            	<i class="fa fa-edit fa-lg"></i> Modificar</a>
            <a href="<?php echo $RAIZc ?>com_iess/iessRep_print.php?id=<?php echo $dRSr['id'] ?>" data-type="iframe" class="btn btn-xs btn-default fancyR">
            	<i class="fa fa-print fa-lg"></i> Imprimir</a>
            <a href="<?php echo $RAIZc ?>com_iess/iessRepForm.php?idr=<?php echo $dRSr['id'] ?>&acc=<?php echo md5('DELRI') ?>" rel="shadowbox:options={relOnClose:true}" class="btn btn-xs btn-danger">
            	<i class="fa fa-trash fa-lg"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($dRSr = mysql_fetch_assoc($RSr));?>
        </tbody>
        </table>
		<?php include(RAIZf.'paginator.php') ?>
<?php }else { ?>
	<div class="alert alert-info">No Existen Registros</div>
<?php } ?>
</div>