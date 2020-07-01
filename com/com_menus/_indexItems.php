<?php
$param['idmc']['v']=vParam('idmc',$_GET['idmc'],$_POST['idmc']);
$TR=totRowsTab('db_menus_items','1','1');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	if($param['idmc']['v']) $param['idmc']['q']='AND men_idc='.$param['idmc']['v']; 
	$query_RSd = sprintf('SELECT * FROM  db_menus_items WHERE 1=1 %s ORDER BY men_padre ASC, men_id ASC, men_orden ASC '.$pages->limit,
	SSQL($param['idmc']['q'],''));
	$RSd = mysql_query($query_RSd) or die(mysql_error());
	$dRSd = mysql_fetch_assoc($RSd);
	$totalRows_RSd = mysql_num_rows($RSd);
}
?>
<div class="container">

<div class="btn-group pull-right">
       	<a href="index.php" class="btn btn-default"><i class="far fa-eye fa-lg"></i> Gestionar Contenedores</a>
    	<a href="formItems.php" class="btn btn-primary fancyR" data-type="iframe"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>
    </div>

<?php echo genPageHead($dC['mod_cod'])?>

<?php sLOG('g');?>
<div class="well well-sm">
<form class="form-inline">
<span class="label label-default">Filtros</span> 
<div class="form-group">
    <label for="exampleInputName2">Menu Contenedor</label>
    <?php genSelect('idmc',detRowGSel('db_menus','id','nom','stat','1'),$param['idmc'],'form-control input-sm'); ?>
  </div>
	<button type="submit" class="btn btn-default btn-xs">Consultar</button>
</form>
</div>
<?php if($totalRows_RSd>0){ ?>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>MENU</th>
	<th>Padre</th>
    <th>Nombre</th>
    <th>Link</th>
    <th>Titulo</th>
    <th>Icon</th>
    <th>Orden</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$id=$dRSd['men_id'];
	$ids=md5($id);
	$detMC=detRow('db_menus','id',$dRSd['men_idc']);
	//if($det_parent_id==0) $css_tr='info'; else unset($css_tr);
	$detMP=detRow('db_menus_items','men_id',$dRSd['men_padre']);
	$btnStat=fncStat('_acc.php',array("ids"=>$ids, "val"=>$dRSd['men_stat'],"acc"=>md5('STmi'),"url"=>$urlc));
	?>
	  <tr class="<?php echo $css_tr ?>">
        <td><?php echo $id ?></td>
		<td><?php echo $btnStat ?></td>
        <td><span class="label label-info"><?php echo $detMC['nom'] ?></span></td>
		<td><?php echo $detMP['men_nombre'] ?></td>
        <td><?php echo $dRSd['men_nombre'] ?></td>
        <td><?php echo $dRSd['men_link'] ?></td>
        <td><?php echo $dRSd['men_tit'] ?></td>
        <td><i class="<?php echo $dRSd['men_icon'] ?>"></i></td>
        <td><?php echo $dRSd['men_orden'] ?></td>        
        <td><div class="btn-group">
          <a href="formItems.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
            <i class="fas fa-edit fa-lg"></i> Editar</a>
          <a href="_acc.php?ids=<?php echo $ids ?>&acc=<?php echo md5(DELmi) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs vAccL">
            <i class="fas fa-trash fa-lg"></i></a></div>
        </td>
	    </tr>
	  <?php } while ($dRSd = mysql_fetch_assoc($RSd)); ?>
</tbody>
</table>
</div>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
        <div class="col-md-6">
			<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
</html>