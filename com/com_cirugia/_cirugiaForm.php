<?php
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idr=vParam('idr',$_GET['idr'],$_POST['idr']);
$dCir=detRow('db_cirugias','id_cir',$idr);
if($idr) {$idp=$dCir['pac_cod']; $idc=$dCir['con_num'];}
$detpac=detRow('db_pacientes','pac_cod',$idp);//dataPac($idp);
if($dCir){
	$acc=md5(UPDc);
	$btnAcc='<button type="button" id="vAcc" class="btn btn-success navbar-btn"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	//$btnAccJS='<button type="submit" name="btnJ" class="btn btn-default" id=""><i class="fa fa-close fa-lg"></i> ACTUALIZAR & CERRAR</button>';
	$dCir_fecr=$dCir['fechar'];
}else{
	$acc=md5(INSc);
	$btnAcc='<button type="button" id="vAcc" class="btn btn-primary navbar-btn"><i class="fas fa-save fa-lg"></i> GRABAR</button>';
}
$btnNew='<a href="'.$urlc.'?idp='.$idp.'&idc='.$idc.'" class="btn btn-default navbar-btn"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';
 ?>
<form action="actions.php" method="post" id="formexam" enctype="multipart/form-data">
<fieldset>
    <input name="idr" type="hidden" id="idr" value="<?php echo $idr ?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
    <input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
    <input name="acc" type="hidden" id="acc" value="<?php echo $acc?>">
	<input name="url" type="hidden" id="url" value="<?php echo $urlc?>">
    <input name="form" type="hidden" id="form" value="<?php echo md5(fCir) ?>">
</fieldset>
<?php
	$contL.='<ul class="nav navbar-nav">
      	<li><a><span class="label label-primary">'.$idr.'</span></a></li>
        <li><a>'.$detpac['pac_nom'].' '.$detpac['pac_ape'].'</a></li>
        <li><a><span class="label label-default">Consulta</span><span class="label label-primary">'.$idc.'</span></a></li>
        <li><a>'.$dCir['fecha'].'</a></li>
    </ul>';
	echo genPageHeader($dC['mod_cod'],'navbar',null,null,null,null,null,$contL,$btnAcc.$btnAccJS.$btnNew) ?>

	<div class="container-fluid">
	
		<div class="row">
	<div class="col-sm-9">
    <fieldset class="form-horizontal well well-sm">
		<div class="form-group">
        <label class="control-label col-sm-4" for="diagnostico">Diagnostico</label>
			<div class="col-sm-8">
            <input name="diagnostico" type="text" id="diagnostico" value="<?php echo $dCir['diagnostico'] ?>" class="form-control" autofocus>
			</div>
		</div>
		
		<div class="form-group">
        	<label class="control-label col-sm-4" for="cirugiap"><strong>Cirugia Programada</strong></label>
			<div class="col-sm-8">
            <input name="cirugiap" type="text" id="cirugiap" value="<?php echo $dCir['cirugiap'] ?>" class="form-control">
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-4" for="fechap"><strong>Fecha Programada</strong></label>
			<div class="col-sm-8">
            <input type="date" name="fechap" id="fechap" value="<?php echo $dCir['fechap'] ?>" class="form-control">
			</div>
		</div>
		
        <div class="form-group">
        	<label class="control-label col-sm-4" for="cirugiar"><strong>Cirugia Realizada</strong></label>
			<div class="col-sm-8">
            <input name="cirugiar" type="text" id="cirugiar" value="<?php echo $dCir['cirugiar'] ?>" class="form-control">
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-4" for="fechar"><strong>Fecha Realizada</strong></label>
			<div class="col-sm-8">
            <input type="date" name="fechar" id="fechar" value="<?php echo $dCir['fechar'] ?>" class="form-control">
			</div>
		</div>
        
		<div class="form-group">
        	<label class="control-label col-sm-4" for="protocolo"><strong>HALLAZGOS</strong></label>
			<div class="col-sm-8">
			<textarea name="protocolo" rows="5" class="form-control" id="protocolo" placeholder="Descripcion"><?php echo $dCir['protocolo'] ?></textarea>
			</div>
		</div>
        <div class="form-group">
        	<label class="control-label col-sm-4" for="evolucion">Evolucion</label>
			<div class="col-sm-8">
            <input name="evolucion" type="text" id="evolucion" value="<?php echo $dCir['evolucion'] ?>" class="form-control">
			</div>
		</div>
    </fieldset>
	</div>

	<div class="col-sm-3">	
<div class="well well-sm">
<?php if($dCir){
	$qryfc=sprintf('SELECT * FROM db_cirugias_media WHERE id_cir=%s ORDER BY id DESC',
	SSQL($idr,'int'));
	$RSfc=mysql_query($qryfc);
	$row_RSfc=mysql_fetch_assoc($RSfc);
	$tr_RSfc=mysql_num_rows($RSfc);
?>
<div class="well well-sm" style="background:#FFF">
	
    <textarea name="dfile" rows="2" class="form-control" id="dfile" placeholder="Descripcion de la Imagen"></textarea>
	<input name="efile[]" id="efile" type="file" onChange="uploadImage();" class="form-control" accept="image/gif, image/jpeg, image/png, image/bmp" multiple/>
</div>
<?php	if($tr_RSfc>0){ ?>
<div class="row">
	<?php do{ ?>
            <?php $detMedia=detRow('db_media','id_med',$row_RSfc['id_med']) ?>
  <div class="col-sm-6">
    <div class="thumbnail">
      <img src="<?php echo $RAIZmdb?>cir/<?php echo $detMedia['file'] ?>" alt="...">
      <div class="caption">
        <h3><?php echo $detMedia['des'] ?></h3>
        <p>
        <a href="<?php echo $RAIZmdb?>cir/<?php echo $detMedia['file'] ?>" class="btn btn-primary btn-xs fancybox" role="button">
        <i class="fa fa-eye"></i> Ver</a> 
        <a href="_fncts.php?idr=<?php echo $idr ?>&id=<?php echo $row_RSfc['id'] ?>&action=delRimg" class="btn btn-danger btn-xs" role="button">
        <i class="fas fa-trash fa-lg"></i> Eliminar</a>
        </p>
      </div>
    </div>
  </div>
	<?php }while ($row_RSfc = mysql_fetch_assoc($RSfc)); ?>
</div>
<?php }else echo '<div class="alert alert-info">No han guardado archivos de esta Cirugia</div>'; ?>
<?php }else echo '<div class="alert alert-info"><h4>No se puede cargar archivos</h4>Guardar primero</div>';?>
</div>
</div>
</div>
		
	</div>
	
</form>
<script type="text/javascript"> function uploadImage() { formexam.submit(); } </script>