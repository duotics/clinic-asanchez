<?php 
$idp=vParam('idp',$_GET['idp'],$_POST['idp'],FALSE);
$id=vParam('id',$_GET['id'],$_POST['id'],FALSE);
$dRes=detRow('db_fullcalendar','id',$id);
if($dRes){
	$idp=$dRes['pac_cod'];
	$acc=md5(UPDr);
	$btnAcc='<button class="btn btn-success btn-xs navbar-btn"><i class="fas fa-save fa-lg"></i></button>';
	$btnAcc.='<a class="btn btn-danger btn-xs navbar-btn" href="actions.php?id='.$id.'&acc='.md5(DELE).'"><i class="fas fa-trash fa-lg"></i></a>';
}else{
	$acc=md5(INSr);
	$btnAcc='<button class="btn btn-primary btn-xs navbar-btn"><i class="fas fa-save fa-lg"></i></button>';
}
$btnNew='<a href="'.$urlc.'?idp='.$idp.'" class="btn btn-default btn-xs navbar-btn "><i class="fas fa-plus-square fa-lg"></i></a>';
$dPac=detRow('db_pacientes','pac_cod',$idp);
$qrylr=sprintf('SELECT * FROM db_fullcalendar WHERE pac_cod=%s ORDER BY id DESC',
			   SSQL($idp,'int'));
$RSlr=mysql_query($qrylr) or die(mysql_error());
$row_RSlr=mysql_fetch_assoc($RSlr);
$tr_RSlr=mysql_num_rows($RSlr); ?>
<div>
	<?php
	$pHead[des]=$dPac['pac_nom'].' '.$dPac['pac_ape'].' <span class="label label-info">'.$dPac['pac_cod'].'</span>';
	echo genPageHeader(null,'page-header',$dC[mod_nom],'h1',null,$pHead[des],$dC[mod_icon],null,null) ?>
<div class="row">
	<div class="col-sm-7">
    	<form action="actions.php" method="post">
		<fieldset>
			<input name="id" type="hidden" value="<?php echo $id?>">
			<input name="acc" type="hidden" value="<?php echo $acc?>">
			<input name="form" type="hidden" value="<?php echo md5(AGE) ?>">
			<input name="idp" type="hidden" value="<?php echo $idp?>">
			<input name="url" type="hidden" value="<?php echo $urlc?>">
		</fieldset>
		
		<?php
		$pHead[conL]='<ul class="nav navbar-nav">
      	<li><a><span class="label label-primary">'.$id.'</span></a></li>
        <li><a>'.$dRes[fechai].'</a></li>
    </ul>';
		echo genPageHeader($dC[mod_cod],'navbar',null,null,null,null,null,$pHead[conL],$btnAcc.$btnNew) ?>
		<div class="row">
				<div class="col-sm-5">
					<fieldset>
						<div class="form-group">
						<label for="fechai" class="control-label">Fecha Inicio</label>
						<input name="fechai" type="date" class="form-control" id="fechai" value="<?php echo $dRes['fechai'] ?>" placeholder="Fecha Inicio" required>
						</div>
						<div class="form-group">
						<label for="horai" class="control-label">Hora Inicio</label>
						<input name="horai" type="time" class="form-control" id="horai" value="<?php echo $dRes['horai'] ?>" placeholder="Hora Inicio">
						</div>
						<div class="form-group">
						<label for="fechaf" class="control-label">Fecha Fin</label>
						<input name="fechaf" type="date" class="form-control" id="fechaf" value="<?php echo $dRes['fechaf'] ?>" placeholder="Email" required>
						</div>
						<div class="form-group">
						<label for="horaf" class="control-label">Hora Fin</label>
						<input name="horaf" type="time" class="form-control" id="horaf" value="<?php echo $dRes['horaf'] ?>" placeholder="Email">
						</div>
					</fieldset>
				</div>
				<div class="col-sm-7">
					<fieldset class="well form-horizontal">
						<div class="form-group">
						<label for="horaf" class="col-sm-3 control-label">Tipo Visita</label>
						<div class="col-sm-9">
							<?php
							$paramsN[]=array(
							array("cond"=>"AND","field"=>"typ_ref","comp"=>"=","val"=>'MOTCON'),
							array("cond"=>"AND","field"=>"typ_stat","comp"=>'=',"val"=>1)
							);
							$RS=detRowGSelNP('db_types','typ_cod','typ_val',$paramsN,TRUE,'typ_val','ASC');
							genSelect('typ_cod',$RS,$detRes['typ_cod'],' form-control ');
							?>
						<?php //genSelect('typ_cod',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPVIS'),$dRes['typ_cod'],' form-control '); ?>
						</div>
						</div>
						<div class="form-group">
						<label for="horaf" class="col-sm-5 control-label">Observaciones</label>
						<div class="col-sm-7">
						<textarea name="obs" id="obs" class="form-control" rows="4"><?php echo $dRes['obs'] ?></textarea>
						</div>
						</div>

						<div class="form-group">
						<label for="horaf" class="col-sm-3 control-label">Estado</label>
						<div class="col-sm-9">
						<table width="200">
						  <tr>
							<td><label>
							  <input type="radio" name="est" value="1" id="est_0"
							  <?php if($dRes['est']=='1') echo ' checked ' ?>>
							  Pendiente</label></td>
						  </tr>
						  <tr>
							<td><label>
							  <input type="radio" name="est" value="2" id="est_1"
							  <?php if($dRes['est']=='2') echo ' checked ' ?>>
							  Atendido</label></td>
						  </tr>
						  <tr>
							<td><label>
							  <input type="radio" name="est" value="0" id="est_2"
							  <?php if($dRes['est']=='0') echo " checked "?>>
							  Eliminar</label></td>
						  </tr>
						</table>
						</div>
						</div>

					</fieldset>
				</div>
			</div>
			</form>
	</div>
	<div class="col-sm-5">
        <?php if($tr_RSlr>0){ ?>
        <div class="panel panel-info">
        	<div class="panel-heading">Historial Reservas del Paciente</div>
            <table class="table table-bordered">
            	<thead>
                	<tr>
                    	<th>ID</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Tipo</th>
                        <th>Obs</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php do{ ?>
                <?php
                $btnAcc=NULL;
				$valEst=NULL;
				$detTyp=detRow('db_types','typ_cod',$row_RSlr['typ_cod']);
				$detTyp_val=$detTyp['typ_val'];
				$estado=$row_RSlr['est'];
				if($estado==0){
					$valEst='<span class="label label-danger">Anulado</span>';
				}else if($estado==1){
					$valEst='<span class="label label-default">Pendiente</span>';
					$btnAcc='<a href="reservaForm.php?idp='.$row_RSlr['pac_cod'].'&id='.$row_RSlr['id'].'" class="btn btn-info btn-xs">
						<i class="fas fa-edit fa-lg"></i></a>';
					$btnAcc.='<a href="actions.php?id='.$row_RSlr['id'].'&acc='.md5(DELEL).'" class="btn btn-danger btn-xs">
						<i class="fas fa-trash fa-lg"></i></a>';
				}else if($estado==2){
					$valEst='<span class="label label-success">Atendido</span>';
				}else{
					$valEst='<span class="label label-warning">Error</span>';
				}
				?>
                	<tr>
                    	<td><?php echo $row_RSlr['id'] ?></td>
                        <td><?php echo $row_RSlr['fechai'] ?></td>
                        <td><?php echo $row_RSlr['horai'] ?></td>
                        <td><?php echo $detTyp_val ?></td>
                        <td><?php echo $row_RSlr['obs'] ?></td>
                        <td><?php echo $valEst ?></td>
                        <td><?php echo $btnAcc ?></td>
                    </tr>
                <?php }while($row_RSlr = mysql_fetch_assoc($RSlr)); ?>
                </tbody>
            </table>
			<div class="panel-footer">Registros. <?php echo $tr_RSlr ?></div>
        </div>	
		<?php }else{ ?>
        <div class="alert alert-warning"><h4>Sin Historial de Reservas</h4></div>
		<?php } ?>
    </div>
</div>

</div>