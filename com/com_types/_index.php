<?php $rTyp=vParam('ref',$_GET['ref'],$_POST['ref']);
if($rTyp){
	$param['typ']=array('typ_ref','=',$rTyp);
	$uTyp='&ref='.$rTyp;//Parametro para URL
}
$paramSQL=getParamSQLA($param);
$TR=totRowsTabP('db_types',$paramSQL);
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qry = 'SELECT * FROM db_types WHERE 1=1 '.$paramSQL.' ORDER BY typ_cod DESC '.$pages->limit;
	$RSl = mysql_query($qry) or die(mysql_error());
	$dRSl = mysql_fetch_assoc($RSl);
	$tRSl = mysql_num_rows($RSl);
}
?>
<div class="well well-sm">
<a href="form.php?<?php echo $uTyp ?>" class="btn btn-primary btn-sm pull-right fancyR" data-type="iframe"><i class="fas fa-plus-square fa-lg"></i> Nuevo Tipo</a>
<form class="form-inline">
	<span class="label label-default">Filtros</span> 
    <label class="control-label">Referencia</label>
	<?php genSelect('typ_cod', detRowGSel('db_types','typ_ref','DISTINCT (typ_ref)','1','1'), $rTyp, 'form-control', 'required', NULL, 'Seleccione', TRUE,NULL,'Todos')?>
</form>
</div>
<? if($tRSl>0){?>
<div>
<?php sLOG('g'); ?>
<div class="well well-sm">

<div class="row">
		<div class="col-sm-8"><ul class="pagination cero"><?php echo $pages->display_pages() ?></ul></div>
		<div class="col-sm-4"><?php echo $pages->display_items_per_page() ?></div>
	</div>

</div>
<div class="table-responsive">   
<table class="table table-hover table-condensed table-bordered" id="itm_table">
<thead><tr>
	<th>ID</th>
    <th></th>
    <th>Módulo</th>
    <th>Nombre</th>
    <th>Ref</th>
    <th>Valor</th>
    <th>Aux</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do {
	$row_cod=$dRSl['typ_cod'];
	$row_mref=$dRSl['mod_cod'];
	$row_ref=$dRSl['typ_ref'];
	$row_nom=$dRSl['typ_nom'];
	$row_val=$dRSl['typ_val'];
	$row_aux=$dRSl['typ_aux'];
	$btnStat=genStatus('fncts.php',array('ids'=>$row_cod, 'val'=>$dRSl['typ_stat'],'acc'=>md5('STt'),'ref'=>$rTyp,"url"=>$urlc));
	?>
	  <tr>
        <td><?php echo $row_cod ?></td>
		<td><?php echo $btnStat ?></td>
        <td><?php echo $row_mref ?></td>
        <td><?php echo $row_nom ?></td>
        <td><?php echo $row_ref ?></td>
        <td><?php echo $row_val ?></td>
        <td><?php echo $row_aux ?></td>
        <td><div class="btn-group">
          <a href="form.php?id=<?php echo $row_cod ?>" class="btn btn-info btn-xs fancyR" data-type="iframe">
            <i class="fa fa-edit fa-lg"></i> Editar</a>
          <a href="fncts.php?id=<?php echo $row_cod ?>&acc=<?php echo md5('DELt') ?>&url=<?php echo $urlc.$uTyp ?>" class="btn btn-danger btn-xs">
            <i class="fas fa-trash fa-lg"></i> Eliminar</a></div>
        </td>
	    </tr>
	  <?php } while ($dRSl = mysql_fetch_assoc($RSl)); ?>
</tbody>
</table>
</div>
<?php }else{ echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>'; } ?>
</div>
<script type="text/javascript">
	$("#typ_cod").change(function(){
	window.location.href = "?ref="+$("#typ_cod").val();
    //alert("The text has been changed.");
});
</script>