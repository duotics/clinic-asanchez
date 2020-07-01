<?php
$TR = totRowsTab('db_componentes',1,1);
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$query_RSc = "SELECT * FROM db_componentes ORDER BY mod_cod DESC ".$pages->limit;
	$RSc = mysql_query($query_RSc) or die(mysql_error());
	$dRSc = mysql_fetch_assoc($RSc);
	$trRSc = mysql_num_rows($RSc);
}
$btnNew='<a data-type="iframe" href="form.php" class="btn btn-primary fancyR"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>'; ?>
<div>
	<?php echo genPageHeader($dM['mod_cod'],'page-header',null,null,null,null,null,null,$btnNew)?>
	<?php sLOG('g');
if($trRSc>0){ ?>
<?php include(RAIZf.'paginator.php')?>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Ref</th>
    <th>Name</th>
    <th>Description</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$id=$dRSc['mod_cod'];
	$ids=md5($id);
	$btnStat=fncStat('_acc.php',array("ids"=>$ids, "val"=>$dRSc['mod_stat'],"acc"=>md5(STc),"url"=>$urlc));
	?>
	  <tr>
        <td><?php echo $id ?></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $dRSc['mod_ref'] ?></td>
        <td><a href="form.php?ids=<?php echo $ids ?>" class="fancyR" data-type="iframe"><?php echo $dRSc['mod_nom'] ?></a></td>
        <td><?php echo $dRSc['mod_des'] ?></td>
        <td><div class="btn-group">
          <a href="form.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
            <i class="fas fa-edit fa-lg"></i> Editar</a>
          <a href="_acc.php?ids=<?php echo $ids ?>&acc=<?php echo md5(DELc) ?>" class="vAccL btn btn-warning btn-xs">
            <i class="fas fa-trash fa-lg"></i></a></div>
        </td>
	    </tr>
	  <?php } while ($dRSc = mysql_fetch_assoc($RSc)); ?>
</tbody>
</table>
</div>
<?php }else{ ?>
	<div class="alert alert-warning"><h4>Not Found Items !</h4></div>
<?php } ?>
</div>