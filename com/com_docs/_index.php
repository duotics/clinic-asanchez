<?php
$idTyp=vParam('typ',$_GET['typ'],$_POST['typ']);
if($idTyp) $param=' AND id_ef='.$idTyp;
$TR=totRowsTabP('db_documentos',$param);
$query_RSd=sprintf('SELECT * FROM db_documentos WHERE 1=1 '.$param.' ORDER BY id_doc DESC');
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
	$pages->mid_range = 7;
	$pages->paginate();
	$RSd = mysql_query($query_RSd.' '.$pages->limit) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RSd);
	$totalRows_RSd = mysql_num_rows($RSd);
?>

<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
			<th>ID</th>
			<th>Paciente</th>
			<th>Fecha</th>
			<th>Documento</th>
			<th>Documento</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
		<?php do{ ?>
		<?php
				 $dPac=detRow('db_pacientes','pac_cod',$dRS[pac_cod]);
				 $idDoc=$dRS['id_doc'];
		?>
			<tr>
			<td><?php echo $idDoc ?></td>
			<td><?php echo $dPac[pac_nom].' '.$dPac[pac_ape] ?></td>
			<td><?php echo $dRS['fecha'] ?></td>
			<td><?php echo $dRS['nombre'] ?></td>
			<td>
				<div class="btn-group">
					<a href="<?php echo $RAIZc ?>com_docs/print_doc.php?idd=<?php echo $idDoc ?>" class="btn btn-default btn-xs fancyRP" data-type="iframe">
					<i class="fa fa-eye"></i> Ver</a>
					<a class="printerButton btn btn-default btn-xs" data-id="<?php echo $idDoc ?>" data-rel="<?php echo $RAIZc ?>com_docs/docPrintJS.php">
					<i class="fas fa-print fa-lg"></i> Imprimir</a>
				</div>
				<div id="docprint<?php echo $idDoc ?>" style="display:none;"><?php echo ($dRS['contenido']) ?></div></td>
			<td>
				<div class="btn-group">
				<a href="<?php echo $RAIZc ?>com_docs/documentoForm.php?idd=<?php echo $idDoc ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
				<i class="fas fa-edit fa-lg"></i> Modificar</a>
				<a href="<?php echo $RAIZc; ?>com_docs/_acc.php?ids=<?php echo md5($idDoc) ?>&acc=<?php echo md5(DELd) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs vAccL">
				<i class="fas fa-trash fa-lg"></i></a>
				</div>
			</td>
			</tr>
		 <?php } while ($dRS = mysql_fetch_assoc($RSd)); ?>
		</tbody>
	</table>

<?php include(RAIZf.'paginator.php') ?>
<?php mysql_free_result($RSd);?>

<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>

<?php }else{ ?>
	<div class="alert alert-warning"><h4>Sin Coincidencias de Busqueda</h4></div>
<?php } ?>
<script type="text/javascript">
	$("#typ_cod").change(function(){
	window.location.href = "?typ="+$("#typ_cod").val();//alert("The text has been changed.");
});
</script>