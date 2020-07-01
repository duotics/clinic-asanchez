<?php
$TR=totRowsTab('db_documentos_formato','1','1');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qRSd = sprintf('SELECT * FROM db_documentos_formato ORDER BY id_df DESC '.$pages->limit);
	$RSd = mysql_query($qRSd) or die(mysql_error());
	$dRSd = mysql_fetch_assoc($RSd);
	$tRSd = mysql_num_rows($RSd);
}
$btnNew='<a href="docFormatForm.php" class="btn btn-primary fancyR" data-type="iframe"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>';
?>
<div>
<?php echo genPageHeader($dC['mod_cod'],'page-header',null,null,null,null,null,null,$btnNew) ?>
<?php if($tRSd>0){ ?>
<?php include(RAIZf.'paginator.php') ?>
<div class="table-responsive">   
<table class="table table-hover table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
	<td></td>
    <th>Creado</th>
    <th width="35%">Nombre</th>
    <th>Previsualizar</th>
    <th>Cantidad</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do{ ?>
	<?php 
	$id=$dRSd['id_df'];
	$ids=md5($id);
	$dA=dataAud($dRSd['id_aud']);
	if($dA){
		$date = date_create($dA['audd_datet']);
		$date = date_format($date, 'Y-m-d');
	}else $date=NULL;
	$btnStat=fncStat('actions.php',array("ids"=>$ids, "val"=>$dRSd['status'],"acc"=>md5('STf'),"url"=>$urlc));
	$btnView='<a href="docFormatPreview.php?ids='.$ids.'" class="btn btn-default btn-xs fancyI" data-type="iframe"><i class="fa fa-eye"></i></a>';
	$TRd=totRowsTab('db_documentos','id_df',$id);
	?>
	<tr>
		<td><?php echo $id ?></td>
		<td><?php echo $btnStat ?></td>
		<td><?php $date ?></td>
		<td><?php echo $dRSd[nombre] ?></td>
		<td><?php echo $btnView ?></td>
        <td><?php echo $TRd ?></td>
        <td align="center">
			<div class="btn-group">
          <a href="docFormatForm.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
            <i class="fa fa-edit fa-lg"></i> Editar</a>
          <a href="actions.php?ids=<?php echo $ids ?>&acc=<?php echo md5(DELf) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
            <i class="fas fa-trash fa-lg"></i> Eliminar</a>
			</div>
        </td>
	    </tr>
	  <?php } while ($dRSd = mysql_fetch_assoc($RSd)); ?>
</tbody>
</table>
</div>
<?php include(RAIZf.'paginator.php') ?>
<?php }else{ ?>
	<div class="alert alert-warning">
		<h4>No se encontraron resultados !</h4>
	</div>
<?php } ?>
</div>