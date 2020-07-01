<?php 
$param=$_POST;
if($param){
	if($param[nomMed]) $paramSQL.=' AND generico LIKE "%'.$param[nomMed].'%" '.'OR comercial LIKE "%'.$param[nomMed].'%" ';
	if($param[nomLab]) $paramSQL.=' AND lab="'.$param[nomLab].'"';
}
$TR=totRowsTab('db_medicamentos');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->items = 50;
	$pages->paginate();
	$qry='SELECT * FROM db_medicamentos WHERE 1=1 '.$paramSQL.' ORDER BY id_form DESC '.$pages->limit;
	$RSd=mysql_query($qry);
	$dRSd=mysql_fetch_assoc($RSd);
	$tr_RSd=mysql_num_rows($RSd);
}
$btnNew='<a href="medicamentosForm.php" class="btn btn-default fancyR" data-type="iframe">
        <i class="fas fa-plus-square fa-lg"></i> NUEVO MEDICAMENTO
        </a>';
?>
	<?php echo genPageHeader($dC['mod_cod'],'page-header',null,null,null,null,null,null,$btnNew) ?>

<div class="">
	<div class="well well-sm">
		<form action="<?php echo $urlc ?>" method="post">
		<fieldset class="form-inline">
			<span class="label label-default">Filtros</span>
			<label class="control-label">Nombre</label>
			<input class="form-control input-sm" type="text" name="nomMed" value="<?php echo $param[nomMed] ?>">
			<label class="control-label">Laboratorio</label>
			<?php genSelect('nomLab',detRowGSel('db_types','typ_cod','typ_val','typ_ref','LABORATORIO'),$param['nomLab'],' form-control input-sm', NULL,'tlab',NULL, TRUE ,NULL, '- Todos -') ?>
			<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>
			<a class="btn btn-default btn-xs" href="<?php echo $urlc ?>">Eliminar Parámetros</a>
		</fieldset>
		</form>
	</div>
<?php if ($tr_RSd>0){ ?>
	<?php include(RAIZf.'paginator.php') ?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>ID</th>
			<th>Laboratorio</th>
			<th>Generico</th>
			<th>Comercial</th>
            <th>Presentacion</th>
            <th>Cantidad</th>
            <th width="35%">Prescripción</th>
            <th>Estado</th>
			<?php if($tr_RSd<=10){ ?><th><abbr title="Consultas relacionadas">Recetas</abbr></th><?php } ?>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
	<?php
			 $id=$dRSd['id_form'];
			 $ids=md5($id);
	
			 $TMC=NULL;
			 
			 if($tr_RSd<=10) $TMC=totRowsTabP('db_tratamientos_detalle','AND idref='.$id.' AND tip="M"');
			 $dLab=detRow('db_types','typ_cod',$dRSd['lab']);
			 $btnStat=genStatus('actions.php',array('ids'=>$ids, 'val'=>$dRSd['estado'],'acc'=>md5(STm),"url"=>$urlc));
		?>
		<tr>
			<td><?php echo $id ?></td>
			<td><?php echo $dLab['typ_val'] ?></td>
			<td><?php echo $dRSd['generico'] ?></td>
			<td><?php echo $dRSd['comercial']?></td>
            <td><?php echo $dRSd['presentacion']?></td>
            <td><?php echo $dRSd['cantidad']?></td>
            <td><?php echo $dRSd['descripcion']?></td>
            <td><?php echo $btnStat ?></td>
			<?php if($tr_RSd<=10){ ?> <td><?php echo $TMC ?></td><?php } ?>
			<td>
				<a href="medicamentosForm.php?ids=<?php echo $ids ?>" class="btn btn-success btn-xs fancyR" data-type="iframe"><i class="fas fa-edit fa-lg"></i> Modificar</a>
				<?php if($id>1){ ?>
				<a href="actions.php?ids=<?php echo $ids ?>&acc=<?php echo md5(DELm)?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash fa-lg"></i> Eliminar</a>
				<?php } ?>
			</td>
		</tr>
	<?php } while ($dRSd = mysql_fetch_assoc($RSd));?>
	</tbody>
	</table>
	<?php include(RAIZf.'paginator.php') ?>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Resultados</h4></div>'; }?>
</div>