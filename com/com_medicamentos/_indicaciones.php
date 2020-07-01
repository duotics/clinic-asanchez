<?php
$param=$_POST;
if($p){
	if($param[nom]) $paramSQL.=' AND des LIKE "%'.$param[nom].'%"';
	
}
$TR=totRowsTab('db_indicaciones');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->items = 50;
	$pages->paginate();
	$qry='SELECT * FROM db_indicaciones WHERE 1=1 '.$paramSQL.' ORDER BY id DESC '.$pages->limit;
	$RSd=mysql_query($qry);
	$dRSd=mysql_fetch_assoc($RSd);
	$tr_RSd=mysql_num_rows($RSd);
}
$btnNew='<a href="indicacionesForm.php" class="btn btn-default fancybox fancybox.iframe fancyreload" data-type="iframe">
        <i class="fas fa-plus-square fa-lg"></i> NUEVA INDICACION
        </a>';
?>
	<?php echo genPageHeader($dC['mod_cod'],'page-header',null,null,null,null,null,null,$btnNew) ?>

<div class="">
	<div class="well well-sm">
		<form action="<?php echo $urlc ?>" method="post">
		<fieldset class="form-inline">
			<span class="label label-default">Filtros</span>
			<label class="control-label">Nombre</label>
			<input type="text" name="nom" value="<?php echo $p[nom] ?>" class="form-control input-sm">
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
			<th width="40%">Descripción</th>
			<th>Estado</th>
			<th>Destacado</th>
			<?php if($tr_RSd<=10){ ?><th><abbr title="Consultas relacionadas">Recetas</abbr></th><?php } ?>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
		<?php
		$id=$dRSd[id];
		$ids=md5($id);
		$TMC=NULL;
		if($tr_RSd<=10) $TMC=totRowsTabP('db_tratamientos_detalle','AND idref='.$id.' AND tip="I"');	
		$btnStat=genStatus('actions.php',array('ids'=>$ids, 'val'=>$dRSd[est],'acc'=>md5(STi),"url"=>$urlc));
		$btnFeat=genStatus('actions.php',array('ids'=>$ids, 'val'=>$dRSd[feat],'acc'=>md5(FTi),"url"=>$urlc));
		?>
		<tr>
			<td><?php echo $id ?></td>
			<td><?php echo $dRSd['des'] ?></td>
            <td><?php echo $btnStat ?></td>
            <td><?php echo $btnFeat ?></td>
			<?php if($tr_RSd<=10){ ?> <td><?php echo $TMC ?></td><?php } ?>
			<td>
				<a href="indicacionesForm.php?ids=<?php echo $ids ?>" class="btn btn-success btn-xs fancybox fancybox.iframe fancyreload"><i class="fas fa-edit fa-lg"></i> Modificar</a>
				<?php if($id>1){ ?>
				<a href="actions.php?ids=<?php echo $ids ?>&acc=<?php echo md5(DELi)?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash fa-lg"></i> Eliminar</a>
				<?php } ?>
			</td>
		</tr>
	<?php } while ($dRSd = mysql_fetch_assoc($RSd));?>
	</tbody>
	</table>
	<?php include(RAIZf.'paginator.php') ?>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Resultados</h4></div>'; }?>
</div>