<form action="acc.php" method="post">
	<input type="hidden" name="id" value="<?php echo $idr ?>">
	<input type="hidden" name="idp" value="<?php echo $idp ?>">
	<input type="hidden" name="idc" value="<?php echo $idc ?>">
	<input type="hidden" name="acc" value="<?php echo $acc ?>">
	<input type="hidden" name="mod" value="<?php echo md5('regGEN') ?>">
	<input type="hidden" name="url" value="<?php echo $urlc ?>">

	<table class="table table-bordered table-condensed">
		<thead>
		<tr class="success">
			<th>Fecha</th>
			<th>Hora</th>
			<th>Establecimiento</th>
			<th>Responsable</th>
			<th>Nombres y Apellidos</th>
			<th>Sexo</th>
			<th>Edad</th>
			<th>N. Historia Clinica</th>
		</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="date" name="fecha" value="<?php echo $det['fecha'] ?>" class="form-control input-sm"></td>
				<td><input type="time" name="hora" value="<?php echo $det['hora'] ?>" class="form-control input-sm"></td>
				<td><?php genSelect('emp_cod', detRowGSel('db_empleados','emp_cod','CONCAT(emp_nom, emp_ape)','typ_cod','35',TRUE,'emp_ape'), $det['emp_cod'], 'form-control input-sm', NULL, NULL, NULL,TRUE, NULL, "- Medico Responsable -"); ?></td>
				<td><?php genSelect('id_suc', detRowGSel('db_sucursales','id_suc','nom_suc','est_suc','A',TRUE,'nom_suc'), $det['id_suc'], 'form-control input-sm', NULL, NULL, NULL,TRUE, NULL, "- Establecimientos -"); ?></td>
				<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
				<td><?php echo $dPac_sex['typ_val']  ?></td>
				<td><?php echo edad($dPac['pac_fec'],' Años') ?></td>
				<td><?php echo $dPac['pac_ced'] ?></td>
			</tr>
		</tbody>
	</table>
	<!--MOTIVO DE CONSULTA-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">1</span> MOTIVO DE CONSULTA</div>
		<table class="table table-bordered table-condensed">
			<tr>
				<td><textarea name="mot_con" rows="1" class="form-control"><?php echo $det['mot_con'] ?></textarea></td>
			</tr>
		</table>
	</div>
	<!--ANTECEDENTES PERSONALES-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">2</span> ANTECEDENTES PERSONALES</div>
		<table class="table table-bordered table-condensed">
		<tbody>
			<tr>
				<td><textarea name="ant_per" rows="2" class="form-control"><?php echo $det['ant_per'] ?></textarea></td>
			</tr>
		</tbody>
		</table>
	</div>
	<!--ANTECEDENTES FAMILIARES-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">3</span> ANTECEDENTES FAMILIARES</div>
		<table class="table table-bordered table-condensed">
		<tbody>
			<tr>
				<td><?php echo genCheck("ant_fam_sel[]",detRowGSel('db_types','typ_cod','typ_val','typ_ref','RIESS-AF'),explode(",", $det['ant_fam_sel']),'form-control', NULL, NULL); ?></td>
			</tr>
			<tr>
				<td><textarea name="ant_fam_des" rows="2" class="form-control"><?php echo $det['ant_fam_des'] ?></textarea></td>
			</tr>
		</tbody>
		</table>
	</div>
	<!--ENFERMEDAD O PROBLEMA ACTUAL-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">4</span> ENFERMEDAD O PROBLEMA ACTUAL</div>
		<table class="table table-bordered table-condensed">
		<tbody>
			<tr>
				<td><textarea name="enf_act" rows="3" class="form-control"><?php echo $det['enf_act'] ?></textarea></td>
			</tr>
		</tbody>
		</table>
	</div>
	<!--REVISION ACTUAL DE ORGANOS Y SISTEMAS-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">5</span> REVISION ACTUAL DE ORGANOS Y SISTEMAS</div>
		<table class="table table-bordered table-condensed">
		<tbody>
			<tr>
				<td><?php echo genCheck("rev_org_sel[]",detRowGCheck('db_types','typ_cod','CONCAT_WS('."'-'".', typ_val, typ_aux)','typ_ref','RIESS-ROS'),explode(",", $det['rev_org_sel']),'form-control', NULL, NULL); ?></td>
			</tr>
			<tr>
				<td><textarea name="rev_org_des" rows="2" class="form-control"><?php echo $det['rev_org_des'] ?></textarea></td>
			</tr>
		</tbody>
		</table>
	</div>
	<!--SIGNOS VITALES Y ANTROPOMETRIA-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">6</span> SIGNOS VITALES Y ANTROPOMETRIA</div>
		<table class="table table-bordered table-condensed">
			<thead>
			<tr>
				<th></th>
				<th>FECHA DE MEDICIÓN</th>
				<th>TEMPERATURA C</th>
				<th>PRESION ARTERIAL</th>
				<th>PULSO / min</th>
				<th>FRECUENCIA RESPIRATORIA</th>
				<th>PESO / Kg</th>
				<th>TALLA / cm</th>
			</tr>
			</thead>
			<tbody>
			<?php for($xSVO=0;$xSVO<=3;$xSVO++){ ?>
			<?php
				$qryS=sprintf('SELECT db_iess_sig.id as ID, db_iess_sig.fecha as FEC, db_iess_sig.temp as TEMP, db_iess_sig.presA as PA, db_iess_sig.presB as PB, 
				db_iess_sig.puls as PUL, db_iess_sig.frec as FREC, db_iess_sig.peso as PESO, db_iess_sig.talla as TALLA 
				FROM db_iess_sig 
				LEFT JOIN db_iess 
				ON db_iess_sig.id_rep = db_iess.id 
				WHERE db_iess_sig.id_rep=%s LIMIT %s,1',
							 SSQL($idr,'int'),
							 SSQL($xSVO,'int'));
				$RSs=mysql_query($qryS);
				$dRSs=mysql_fetch_assoc($RSs);
				$tRSs=mysql_num_rows($RSs);
				$btnDelSig=NULL;
				if($tRSs>0) $btnDelSig='<a class="btn btn-danger btn-xs" href="acc.php?id='.$idr.'&ids='.$dRSs['ID'].'&acc='.md5('DELrepSIG').'"><i class="fa fa-trash fa-lg"></i></a>';
			?>

			<tr>
				<td><input type="hidden" name="sigID[]" value="<?php echo $dRSs['ID'] ?>">
					<?php echo $btnDelSig ?></td>
				<td><input type="date" class="form-control" name="sigFEC[]" value="<?php echo $dRSs['FEC'] ?>"></td>
				<td><input type="text" class="form-control" name="sigTEMP[]" value="<?php echo $dRSs['TEMP'] ?>"></td>
				<td>
					<div class="row">
						<div class="col-xs-6">
							<input type="number" class="form-control" name="sigPA[]" value="<?php echo $dRSs['PA'] ?>">
						</div>
						<div class="col-xs-6">
							<input type="number" class="form-control" name="sigPB[]" value="<?php echo $dRSs['PB'] ?>">
						</div>
					</div>
				</td>
				<td><input type="number" class="form-control" name="sigPULS[]" value="<?php echo $dRSs['PUL'] ?>"></td>
				<td><input type="number" class="form-control" name="sigFREC[]" value="<?php echo $dRSs['FREC'] ?>"></td>
				<td><input type="text" class="form-control" name="sigPESO[]" value="<?php echo $dRSs['PESO'] ?>"></td>
				<td><input type="text" class="form-control" name="sigTALLA[]" value="<?php echo $dRSs['TALLA'] ?>"></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<!--EXAMEN FISICO REGIONAL-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">7</span> EXAMEN FISICO REGIONAL</div>
		<table class="table table-bordered table-condensed">
		<tbody>
			<tr>
				<td><?php echo genCheck("exa_fis_sel[]",detRowGCheck('db_types','typ_cod','CONCAT_WS('."'-'".', typ_val, typ_aux)','typ_ref','RIESS-EFR'),explode(",", $det['exa_fis_sel']),'form-control', NULL, NULL); ?></td>
			</tr>
			<tr>
				<td><textarea name="exa_fis_des" rows="3" class="form-control"><?php echo $det['exa_fis_des'] ?></textarea></td>
			</tr>
		</tbody>
	</table>
	</div>
	<!--DIAGNOSTICO-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">8</span> DIAGNOSTICO</div>
		<table class="table table-bordered table-condensed">
			<thead>
			<tr>
				<th></th>
				<th>DIAGNOSTICO</th>
				<th>CIE</th>
				<th>PRE / DEF</th>
			</tr>
			</thead>
			<tbody>
			<?php for($xD=0;$xD<=3;$xD++){ ?>
			<?php
				$qryD=sprintf('SELECT db_iess_diag.id as ID, db_iess_diag.diag as DIAG, db_iess_diag.cie as CIE, db_iess_diag.tip as TIP 
				FROM db_iess_diag 
				LEFT JOIN db_iess 
				ON db_iess_diag.id_rep = db_iess.id 
				WHERE db_iess_diag.id_rep=%s LIMIT %s,1',
							 SSQL($idr,'int'),
							 SSQL($xD,'int'));
				$RSd=mysql_query($qryD);
				$dRSd=mysql_fetch_assoc($RSd);
				$tRSd=mysql_num_rows($RSd);
				$btnDelDiag=NULL;
				if($tRSd>0) $btnDelDiag='<a class="btn btn-danger btn-xs" href="acc.php?id='.$idr.'&ids='.$dRSd['ID'].'&acc='.md5('DELrepDIAG').'"><i class="fa fa-trash fa-lg"></i></a>';
			?>
			<tr>
				<td><input type="hidden" name="diagID[]" value="<?php echo $dRSd['ID'] ?>">
					<?php echo $btnDelDiag ?></td>
				<td><input type="text" class="form-control" name="diagDIAG[]" value="<?php echo $dRSd['DIAG'] ?>"></td>
				<td><input type="text" class="form-control" name="diagCIE[]" value="<?php echo $dRSd['CIE'] ?>"></td>
				<td>
					<?php $data=array("PRE"=>"P", "DEF"=>"D");
					genSelectManual('diagTIP[]', $data, $dRSd['TIP'], 'form-control', NULL, NULL, NULL, TRUE, NULL, 'Seleccione'); ?>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<!--PLANES DE TRATAMIENTO-->
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="badge">9</span> PLANES DE TRATAMIENTO</div>
		<table class="table table-bordered table-condensed">
		<tbody>
			<tr>
				<td><textarea name="planes" rows="3" class="form-control"><?php echo $det['planes'] ?></textarea></td>
			</tr>
		</tbody>
		</table>
	</div>

	<div class="well well-sm text-center"><?php echo $btnAcc ?></div>
</form>