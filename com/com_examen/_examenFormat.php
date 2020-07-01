<?php
$TR=totRowsTab('db_examenes_format','1','1');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qRSd = sprintf('SELECT * FROM db_examenes_format ORDER BY id DESC '.$pages->limit);
	$RSd = mysql_query($qRSd) or die(mysql_error());
	$dRSd = mysql_fetch_assoc($RSd);
	$totalRows_RSd = mysql_num_rows($RSd);
}
?>
<div class="container">
	<div class="btn-group pull-right">
    	<a href="examenFormatForm.php" class="btn btn-primary fancyR" data-type="iframe">
			<i class="fas fa-plus-square fa-lg"></i> Nuevo
		</a>
    </div>
	<?php echo genPageHead($dM['mod_cod'])?>

	<?php if($totalRows_RSd>0){ ?>
	<?php include(RAIZf.'paginator.php') ?>
	<div class="table-responsive">   
	<table class="table table-hover table-bordered" id="itm_table">
	<thead><tr>
		<th>ID</th>
		<th>Creado</th>
		<th></th>
		<th>Nombre</th>
		<th>Preview</th>
		<th>Cantidad</th>
		<th></th>
	</tr></thead>
	<tbody>
		<?php do{ ?>
		<?php $id=$dRSd['id'];
		$dA=dataAud($dRSd['idA']);
		if($dA){
			$date = date_create($dA['audd_datet']);
			$date = date_format($date, 'Y-m-d');
		}else $date=NULL;
		$btnStat=fncStat('actions.php',array("id"=>$id, "val"=>$dRSd['stat'],"acc"=>md5('STef'),"url"=>$urlc));
		$btnView=NULL;
		if($dRSd['des']) $btnView='<a href="examenFormatPreview.php?id='.$id.'" class="btn btn-default btn-xs fancybox.iframe fancyreload"><i class="fa fa-eye"></i></a>';
		$TRr=totRowsTab('db_examenes','id_ef',$id);
		?>
		  <tr>
			<td><?php echo $id ?></td>
			<td><?php echo $date ?></td>
			<td><?php echo $btnStat ?></td>
			<td><?php echo $dRSd['nom'] ?></td>
			<td><?php echo $btnView ?></td>
			<td><?php echo $TRr ?></td>
			<td align="center"><div class="btn-group">
			  <a href="examenFormatForm.php?id=<?php echo $id ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
				<i class="fa fa-edit fa-lg"></i> Editar</a>
			  <a href="actions.php?id=<?php echo $id ?>&acc=<?php echo md5(DELef) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs fancyR vAccL" data-type="iframe">
				<i class="fas fa-trash fa-lg"></i></a></div>
			</td>
			</tr>
		  <?php } while ($dRSd = mysql_fetch_assoc($RSd)); ?>
	</tbody>
	</table>
	</div>
	<?php include(RAIZf.'paginator.php') ?>
<?php }else{ echo '<div class="alert alert-warning"><h4>No se encontraron resultados !</h4></div>'; } ?>
</div>
</html>