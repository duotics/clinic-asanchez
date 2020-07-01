<?php //SELECT formatos
$qrydf='SELECT * FROM  db_documentos_formato ORDER BY id_df ASC';
$RSdf=mysql_query($qrydf);
$dRSdf=mysql_fetch_assoc($RSdf);
$tr_RSdf=mysql_num_rows($RSdf);
//SELECT documentos
$qryd=sprintf('SELECT * FROM db_documentos WHERE pac_cod=%s ORDER BY id_doc DESC',
SSQL($idp,'int'));
$RSd=mysql_query($qryd);
$dRSd=mysql_fetch_assoc($RSd);
$tr_RSd=mysql_num_rows($RSd);
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fas fa-file fa-lg"></i> DOCUMENTOS 
		<?php if($tr_RSdf>0){ ?>
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
			NUEVO <i class="fas fa-plus-square fa-lg"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
			<?php do{?>
			<?php $btnDN=$RAIZc.'com_docs/documentoForm.php?iddf='.$dRSdf['id_df'].'&idp='.$idp.'&idc='.$idc; ?>
				<li>
					<a href="<?php echo $btnDN ?>" class="btn btn-default fancyR" data-type="iframe"><?php echo $dRSdf['nombre'] ?></a>
				</li>
			<?php }while ($dRSdf = mysql_fetch_assoc($RSdf)); ?>
			</ul>
		</div>
		<?php }?>
	</div>
	<div class="panel-body">

	<?php if ($tr_RSd>0){ ?>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
			<th>ID</th>
			<th>Fecha</th>
			<th>Documento</th>
			<th>Documento</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
		<?php do{ ?>
		<?php $idDoc=$dRSd['id_doc']; ?>
			<tr>
			<td><?php echo $idDoc ?></td>
			<td><?php echo $dRSd['fecha'] ?></td>
			<td><?php echo $dRSd['nombre'] ?></td>
			<td>
				<div class="btn-group">
					<a href="<?php echo $RAIZc ?>com_docs/print_doc.php?idd=<?php echo $idDoc ?>" class="btn btn-default btn-xs fancyRP" data-type="iframe">
					<i class="fa fa-eye"></i> Ver</a>
					<a class="printerButton btn btn-default btn-xs" data-id="<?php echo $idDoc ?>" data-rel="<?php echo $RAIZc ?>com_docs/docPrintJS.php">
					<i class="fas fa-print fa-lg"></i> Imprimir</a>
				</div>
				<div id="docprint<?php echo $idDoc ?>" style="display:none;"><?php echo ($dRSd['contenido']) ?></div></td>
			<td>
				<div class="btn-group">
				<a href="<?php echo $RAIZc ?>com_docs/documentoForm.php?idd=<?php echo $idDoc ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
				<i class="fas fa-edit fa-lg"></i> Modificar</a>
				<a href="<?php echo $RAIZc; ?>com_docs/documentoForm.php?idd=<?php echo md5($idDoc) ?>&acc=<?php echo md5(DELd) ?>" class="btn btn-danger btn-xs fancyR" data-type="iframe">
				<i class="fas fa-trash fa-lg"></i> Eliminar</a>
				</div>
			</td>
			</tr>
		<?php } while ($dRSd = mysql_fetch_assoc($RSd));?>
		</tbody>
	</table>
	<?php }else { ?>
		<div class="alert alert-warning"><h4>Sin Registros</h4></div>
	<?php } ?>
	</div>
	<div class="panel-footer">Resultados. <?php echo $tr_RSd ?></div>
</div>