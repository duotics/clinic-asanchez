<?php 
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$ide=vParam('ide',$_GET['ide'],$_POST['ide']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
$dExa=detRow('db_examenes','id_exa',$ide);//fnc_dataexam($ide);
if($ide) {$idp=$dExa['pac_cod']; $idc=$dExa['con_num'];}

if($acc==md5('DELe')) header(sprintf("Location: %s", '_fncts.php?ide='.$ide.'&acc='.$acc));

$detpac=detRow('db_pacientes','pac_cod',$idp);
$detpac_nom=$detpac['pac_nom'].' '.$detpac['pac_ape'];
if($dExa){
	$acc=md5('UPDe');
	$dateexam=$dExa['fechae'];
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	$RSe=detRowGSel('db_examenes_format','id','nom','1','1');
}else{
	$dateexam=date('Y-m-d');
	$acc=md5('INSe');
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
	$RSe=detRowGSel('db_examenes_format','id','nom','stat','1');
}
?>
<form action="_fncts.php" method="post" id="formexam" enctype="multipart/form-data" class="cero">
<fieldset>
	<input name="ide" type="hidden" value="<?php echo $ide ?>">
	<input name="idp" type="hidden" value="<?php echo $idp ?>">
	<input name="idc" type="hidden" value="<?php echo $idc ?>">
	<input name="acc" type="hidden" value="<?php echo $acc ?>">
	<input name="form" type="hidden" value="<?php echo md5('fExam') ?>">
	<input name="url" type="hidden" value="<?php echo $urlc ?>">
</fieldset>
<nav class="navbar navbar-default" role="navigation">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">EXAMEN</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li><a><span class="label label-info"><?php echo $ide ?></span></a></li>
        <li><a><?php echo $detpac_nom?></a></li>
        <li><a>Consulta: <span class="label label-default"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $dExa['fecha'] ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <?php echo $btnAcc ?>
      <a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
      </div>
	</div>
</div>
</nav>
<div class="container-fluid">
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#tabA" aria-controls="tabA" role="tab" data-toggle="tab">DATOS</a></li>
    <li role="presentation"><a href="#tabB" aria-controls="tabB" role="tab" data-toggle="tab">MULTIMEDIA</a></li>
    <li role="presentation"><a href="#tabC" aria-controls="tabC" role="tab" data-toggle="tab">OTROS</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tabA">
		<div class="row">
			<div class="col-sm-4">
			<fieldset class="form-horizontal well well-sm">
				<div class="form-group">
					<label class="control-label col-sm-3" for="resultado">Fecha</label>
					<div class="col-sm-9">
					<input name="fechae" type="date" id="fechae" value="<?php echo $dateexam; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="resultado">Formato</label>
					<div class="col-sm-9">
					<?php genSelect('idef', $RSe, $dExa['id_ef'], 'form-control', NULL, 'idEf', NULL, TRUE, NULL, "- Seleccione Formato -")?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="obs">Observaciones</label>
					<div class="col-sm-9">
					  <input name="obs" type="text" class="form-control" id="obs" placeholder="Observaciones" value="<?php echo $dExa['obs'] ?>" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="resultado">Resultados</label>
					<div class="col-sm-9">
					<textarea name="resultado" rows="8" class="form-control" id="resultado" placeholder="Resultados"><?php echo $dExa['resultado'] ?></textarea>
					</div>
				</div>
			</fieldset>
			</div>
			<div class="col-sm-8">
			<div class="form-group">
				<textarea name="descripcion" class="form-control tmceExam" id="desExa"><?php echo $dExa['descripcion'] ?></textarea>
			</div>

			</div>
		</div>
   	</div>
    <div role="tabpanel" class="tab-pane" id="tabB">
	<div class="well well-sm">
		<?php if($dExa){
			$qryfc=sprintf('SELECT * FROM db_examenes_media WHERE id_exa=%s ORDER BY id DESC',
			SSQL($ide,'int'));
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
					<?php $detMedia=detRow('db_media','id_med',$row_RSfc['id_med']);
					$detMedia_file=$RAIZ.'data/db/exam/'.$detMedia['file'];
					?>

		  <div class="col-sm-4">
			<div class="thumbnail">
			  <img src="<?php echo $detMedia_file ?>" alt="<?php echo $detMedia['des'] ?>" class="img-md">
			  <div class="caption text-center">
				<span class="label label-default"><?php echo $detMedia['des'] ?></span>
				<div>
				<a href="<?php echo $detMedia_file ?>" class="btn btn-primary btn-xs fancybox" rel="gall">
				<i class="fa fa-eye"></i> Ver</a> 
				<a href="_fncts.php?ide=<?php echo $ide ?>&id=<?php echo $row_RSfc['id'] ?>&acc=delEimg" class="btn btn-danger btn-xs">
				<i class="fas fa-trash fa-lg"></i> Eliminar</a>
				</div>
			  </div>
			</div>
		  </div>

			<?php }while ($row_RSfc = mysql_fetch_assoc($RSfc)); ?>
		</div>

		<?php }else echo '<div class="alert alert-warning">No han guardado archivos de este Examen</div>'; ?>

		<?php }else echo '<div class="alert alert-warning"><h4>No se puede cargar archivos</h4>Aun No Se ha Guardado el Examen</div>';?>
		</div>  
	</div>
    <div role="tabpanel" class="tab-pane" id="tabC">...</div>
  </div>

</div>

</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('#idEf').chosen();
	$('#idEf').on('change', function(evt, params) {
    doGetEF(evt, params);
  	});
});
function doGetEF(evt, params){
	var url=RAIZs+'fnc/getRow.php';
	var id=params.selected;	
		$.getJSON( url, { tab: "db_examenes_format", field: "id", param:id } )
		  .done(function( json ) {
			tinymce.activeEditor.setContent('');
			tinymce.activeEditor.insertContent(json.rVal.des);return false;
		  })
		  .fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			alert( "Request Failed: " + err );
		});
}
function uploadImage() { formexam.submit(); }
</script>

<script type="text/javascript">
$('#medicamento').focus();
$(document).ready(function(){
	
});	

</script>