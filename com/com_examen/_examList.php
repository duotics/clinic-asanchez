<?php
$idTyp=vParam('typ',$_GET['typ'],$_POST['typ']);
if($idTyp) $param=' AND id_ef='.$idTyp;

$TR=totRowsTabP('db_examenes',$param);
//echo $TR;

$query_RSd=sprintf('SELECT * FROM db_examenes WHERE 1=1 '.$param.' ORDER BY id_exa DESC');
//echo $query_RSd;
 ?>
<div class="well well-sm">
<fieldset class="form-inline">
		<span class="label label-primary">Resultados <?php echo $totalRows_RSt?></span> 
        <span class="label label-default">Filtros</span>
        <div class="form-group">
            <label for="typ_cod">Tipo Examen</label>
            <?php genSelect('typ_cod',detRowGSel('db_examenes_format','id','nom','1','1'),$idTyp,' form-control input-sm', NULL, NULL, 'Todos'); ?>
          </div>
        </fieldset>
</div>
<?php if ($TR>0) {
$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSd = mysql_query($query_RSd.' '.$pages->limit) or die(mysql_error());
	$row_RSd = mysql_fetch_assoc($RSd);
	$totalRows_RSd = mysql_num_rows($RSd);
?>
<table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
    	<th>ID</th>
		<th><abbr title="Fecha Registro">Fecha R.</abbr></th>
        <th><abbr title="Fecha Examen">Fecha E.</abbr></th>
		<th><abbr title="Historia Clinica">H.C.</abbr></th>
    	<th>Apellidos</th>
        <th>Nombres</th>
        <th>Tipo</th>
        <th>Descripcion</th>
        <th style="width:30%">Resultado</th>
        <th></th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$detPac=detRow('db_pacientes','pac_cod',$row_RSd['pac_cod']);
	$typ_typ=dTyp($row_RSd['typ_cod']);
	$typ_typ=$typ_typ['typ_val'];?>
    <tr>
    	<td><?php echo $row_RSd['id_exa'];?></td>
   		<td><?php echo $row_RSd['fecha']; ?></td>
        <td><?php echo $row_RSd['fechae']; ?></td>
		<td><?php echo $row_RSd['pac_cod'];?></td>
		<td><?php echo strtoupper($detPac['pac_nom'])?></td>
		<td><?php echo strtoupper($detPac['pac_ape'])?></td>
        <td><?php echo $typ_typ ?></td>
        <td><?php echo $row_RSd['descripcion']; ?></td>
        <td><div class="readmore"><?php echo $row_RSd['resultado']; ?></div></td>
        <td class="text-center">
        	<a class="btn btn-info btn-xs fancyR" data-type="iframe" href="<?php echo $RAIZc ?>com_examen/examenForm.php?ide=<?php echo $row_RSd['id_exa'];?>">
        	<i class="fa fa-heart fa-lg"></i> Editar</a>
            
            <a class="btn btn-default btn-xs" href="gestExa.php?id=<?php echo $row_RSd['pac_cod'];?>">
        	<i class="fa fa-history"></i> Historial</a>
		</td>
    </tr>
    <?php } while ($row_RSd = mysql_fetch_assoc($RSd)); ?>
</tbody>
</table>
<?php include(RAIZf.'paginator.php') ?>
<?php mysql_free_result($RSd);?>
<?php }else{ ?>
	<div class="alert alert-warning"><h4>Sin Coincidencias de Busqueda</h4></div>
<?php } ?>
<script type="text/javascript">
	$("#typ_cod").change(function(){
	window.location.href = "?typ="+$("#typ_cod").val();//alert("The text has been changed.");
});
</script>