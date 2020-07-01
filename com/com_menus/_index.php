<?php
$TR=totRowsTab('db_menus','1','1');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->items = 50;
	$pages->paginate();
	$query_RSm = 'SELECT * FROM db_menus ORDER BY id DESC '.$pages->limit;
	$RSm = mysql_query($query_RSm) or die(mysql_error());
	$dRSm = mysql_fetch_assoc($RSm);
	$totalRows_RSm = mysql_num_rows($RSm);
}
$btnItems='<a href="indexItems.php" class="btn btn-default"><i class="far fa-eye"></i> Gestionar Items</a>';
$btnNew='<a href="form.php" class="btn btn-primary fancyR" data-type="iframe"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>';
?>
<div class="container">
<div class="btn-group pull-right">
    	
        
    </div>
<?php echo genPageHeader($dM['mod_cod'],'page-header',null,null,null,null,null,null,$btnItems.$btnNew)?>

<?php sLOG('g');
if($totalRows_RSm>0){ ?>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
        <div class="col-md-6">
			<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Nombre</th>
    <th>Ref</th>
    <th>Items</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$id=$dRSm['id'];
	$ids=md5($id);
	$btnStat=fncStat('_acc.php',array("ids"=>$ids, "val"=>$dRSm['stat'],"acc"=>md5(STmc),"url"=>$urlc));
	$totI=totRowsTab('db_menus_items','men_idc',$id);
	?>
	  <tr>
        <td><?php echo $id ?></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $dRSm['nom'] ?></td>
        <td><?php echo $dRSm['ref'] ?></td>
        <td><?php echo $totI ?></td>
        <td><div class="btn-group">
        	<a href="form.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
				<i class="fas fa-edit fa-lg"></i> Editar
			</a>
			<?php if(!($totI)){ ?>
        	<a href="_acc.php?ids=<?php echo $ids ?>&acc=<?php echo md5(DELmc) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs vAccL">
            	<i class="fas fa-trash fa-lg"></i>
			</a>
			<?php } ?>
			</div>
        </td>
	    </tr>
	  <?php } while ($dRSm = mysql_fetch_assoc($RSm)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</html>