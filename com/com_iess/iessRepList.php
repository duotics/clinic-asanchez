<?php 
$qry=sprintf('SELECT * FROM db_iess WHERE pac_cod=%s ORDER BY id DESC',
			SSQL($idp,'int'));
$RSri=mysql_query($qry);
$dRSri=mysql_fetch_assoc($RSri);
$tRSri=mysql_num_rows($RSri);
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fas fa-hospital fa-lg"></i> REPORTES IESS
		<a data-src="<?php echo $RAIZc ?>com_iess/iessRepForm.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default btn-xs fancyR" data-fancybox data-type="iframe" data-touch="false" href="javascript:;">
			  <i class="fas fa-plus-square fa-lg"></i> Nuevo Reporte
		  </a>
	</div>
	<div class="panel-body">
	<?php if ($tRSri>0){ ?>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
		<tr>
			<th>Fecha</th>
			<th>Establecimiento</th>
			<th>Responsable</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php do{ ?>
		<?php
		$dSuc=detRow('db_sucursales','id_suc',$dRSri['id_suc']);
		$dEmp=detRow('db_empleados','emp_cod',$dRSri['emp_cod']);
		$id_rep=$dRSri['id'];
		?>
		<tr <?php echo $classtr?>>
				<td><?php echo infAud($dRSri['id_aud']) ?></td>
				<td><?php echo $dSuc['nom_suc'] ?></td>
				<td><?php echo $dEmp['emp_nom'].' '.$dEmp['emp_ape'] ?></td>
				<td>
				<div class="btn-group">
				<a href="<?php echo $RAIZc ?>com_iess/iessRepForm.php?idr=<?php echo $id_rep ?>" data-type="iframe" class="btn btn-primary btn-xs fancyR">
				<i class="fa fa-edit fa-lg"></i> Modificar</a>
				<a href="<?php echo $RAIZc ?>com_iess/iessRepForm.php?ids=<?php echo md5($id_rep) ?>&acc=<?php echo md5('DELRI') ?>" data-type="iframe" class="btn btn-xs btn-danger fancyR">
				<i class="fa fa-trash fa-lg"></i></a>
				</div>
				</td>
			</tr>
			<?php } while ($dRSri = mysql_fetch_assoc($RSri));?>
			</tbody>
			</table>
	<?php }else { ?>
		<div class="alert alert-warning"><h4>Sin Registros</h4></div>
	<?php } ?>
	</div>
</div>