<?php
$ids = vParam('ids', $_GET['ids'], $_POST['ids']);
$dF = detRow('db_documentos_formato', 'md5(id_df)', $ids);
if ($dF) {
	$id = $dF["id_df"];
	$acc = md5("UPDf");
	$btnAcc = '<button type="button" class="btn btn-success" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
} else {
	$acc = md5("INSf");
	$dF["status"] = 1;
	$btnAcc = '<button type="button" class="btn btn-primary" id="vAcc"><i class="fas fa-save fa-lg"></i> CREAR</button>';
}
$btnNew = '<a href="' . $urlc . '" class="btn btn-default"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';
?>
<div>
	<form action="actions.php" method="post" enctype="multipart/form-data">
		<?php echo genPageHeader($dC['mod_cod'], 'navbar', null, null, null, null, null, null, $btnAcc . $btnNew) ?>
		<fieldset>
			<input name="ids" type="hidden" id="ids" value="<?php echo $ids ?>">
			<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
			<input name="form" type="hidden" id="form" value="<?php echo md5("fFormat") ?>">
			<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
		</fieldset>

		<div class="row">
			<div class="col-sm-5">
				<div class="well">
					<fieldset class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-4" for="iNom">NOMBRE FORMATO</label>
							<div class="col-sm-8">
								<input name="iNom" id="iNom" type="text" class="form-control" placeholder="Nombre del Formato" value="<?php echo $dF[nombre] ?>" autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="control-label col-sm-4">ACTIVO</label>
							<div class="col-sm-8">
								<label class="radio-inline">
									<input type="radio" name="iStat" value="1" <?php if ($dF[status] == 1) echo 'checked' ?>> SI
								</label>
								<label class="radio-inline">
									<input type="radio" name="iStat" value="0" <?php if ($dF[status] == 0) echo 'checked' ?>> NO
								</label>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Campos Disponibles</div>
					<?php
					$qCF = sprintf(
						'SELECT * FROM db_types WHERE typ_ref=%s',
						SSQL('docFormat', 'text')
					);
					$RScf = mysql_query($qCF);
					$dRScf = mysql_fetch_assoc($RScf);
					$tRScf = mysql_num_rows($RScf);
					?>
					<?php if ($tRScf > 0) { ?>
						<table class="table table-condensed table-striped">
							<tr>
								<th>Campo</th>
								<th>Codigo</th>
								<th>ejemplo</th>
								<th>Observaciones</th>
								<th></th>
							</tr>
							<?php do { ?>
								<?php
								$valInsertContent = $dRScf['typ_aux'];
								if ($valInsertContent == 'img') {
									$valInsertContent = "<img src='{$dRScf['typ_val']}'>";
								}
								?>
								<tr>
									<td><?php echo $dRScf["typ_nom"] ?></td>
									<td><?php echo $dRScf["typ_val"] ?></td>
									<td><?php echo $dRScf["typ_aux"] ?></td>
									<td><?php echo $dRScf["mod_cod"] ?></td>
									<th><a href='javascript:;' onClick='tinymce.activeEditor.insertContent("<?php echo $valInsertContent ?>");return false;' class='btn btn-default btn-xs'>
											<i class="fa fa-chevron-right"></i>
										</a>
									</th>
								</tr>
							<?php } while ($dRScf = mysql_fetch_assoc($RScf)) ?>
						</table>
					<?php } ?>
				</div>
			</div>
			<div class="col-sm-6">
				<div>
					<textarea name="iFor" class="form-control tinymce" style="min-height: 650px"><?php echo $dF[formato] ?></textarea>
				</div>
			</div>
		</div>
	</form>
</div>