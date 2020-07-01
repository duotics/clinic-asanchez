<?php include('../../init.php');
$dM=vLogin('CONSULTA');
$tabS=$_SESSION['tab']['con'];
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$idp=vParam('idp', $_GET['idp'], $_POST['idp']);
$idc=vParam('idc', $_GET['idc'], $_POST['idc']);
$idr=vParam('idr', $_GET['idr'], $_POST['idr']);
$dRes=detRow('db_fullcalendar', 'id', $idr);
$dCon=detRow('db_consultas','con_num',$idc);
if($dRes) $acc='NEW';
if($dCon) $idp=$dCon['pac_cod'];
$dPac=detRow('db_pacientes','pac_cod',$idp);
if($dPac){
	if($acc!='NEW'){
		if(!$dCon) $dCon=detRow('db_consultas','pac_cod',$idp,'con_num','DESC');
		$idc=$dCon['con_num'];
	}
}
if($dRes) $estCon=3;//Reservada
else $estCon=$dCon['con_stat'];
if($dCon){
	$acc=md5('UPDc');
	$btn_action_form='<button type="submit" class="btn btn-success navbar-btn"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else{	
	$acc=md5('INSc');
	$btn_action_form='<button type="submit" class="btn btn-info navbar-btn"><i class="fas fa-save fa-lg"></i> GUARDAR VISITA</button>';	
}
$dirimg=fncImgExist("data/db/pac/",lastImgPac($idp));
$stat=estCon($estCon);//Devuelve el estado de la Consulta en HTML
include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<?php if($dPac){ ?>
<form action="actions.php" method="post">
<fieldset>
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>" />
		<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>" />
		<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>" />
        <input name="idr" type="hidden" id="idr" value="<?php echo $idr ?>" />
		<input name="cons_stat" type="hidden" id="cons_stat" value="<?php echo $dCon['con_stat']; ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo md5('consForm') ?>" />
</fieldset>
<div class="container-fluid">
<!--NVBAR TOP-->
<nav class="navbar navbar-default cero">
<div class="container-fluid">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-cons-est">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="#"><?php echo $dM['mod_nom'] ?> <span class="label label-info"><?php echo $idc ?></span> 
    <span class="label label-default">Visita <?php echo detNumConAct($idc,$idp) ?></span></a>
	</div>
    <div class="collapse navbar-collapse" id="navbar-cons-est">
		<ul class="nav navbar-nav">
		<li><div class="btn-group">
        <?php echo $status_cons ?>
		<button type="button" class="btn btn-default navbar-btn disabled">Estado</button>
		<?php echo $stat['inf'] ?>
    </div></li>
	</ul>
      
    <ul class="nav navbar-nav">
		<li><div class="btn-group">
			<?php echo $btn_action_form ?>
			<a href="<?php echo $urlcurrent ?>?idp=<?php echo $dPac['pac_cod']; ?>&acc=NEW" class="btn btn-default navbar-btn">
            <i class="fas fa-file fa-lg"></i> NUEVA VISITA</a>
		</div></li>
        </ul>
        
	</div>
</div>
</nav>
<?php include('_fra_con_dat.php') ?>
<?php sLOG('g') ?>
    <div class="row">
		<div class="col-md-7">
			<div class="row">
        	<div class="col-md-2 text-center"><a href="<?php echo $dirimg?>" class="fancybox">
            <img src="<?php echo $dirimg?>" class="img-thumbnail img-responsive imgPacCons"/>
            </a></div>
            <div class="col-md-10">
            <?php include('_fra_con_detpac.php') ?>
            </div>
        </div>
		</div>
		<div class="col-md-5">
			<?php include('_fra_histCons.php') ?>
		</div>
    </div>
    
	<div class="well well-sm">
	<div class="tabbable">
    <div class="row">
	<div class="col-md-2">
    <ul class="nav nav-pills nav-stacked">
			<li class="<?php if(!$tabS) echo 'active' ?>">
            	<a href="#cHC" data-toggle="tab" title="" onClick="setTab(this.title)">
            	<i class="fa fa-book fa-lg"></i> Historia Clinica</a></li>
            <li class="<?php if($tabS=='cCON') echo 'active' ?>">
            	<a href="#cCON" data-toggle="tab" title="cCON" onClick="setTab(this.title)" id="loadConData">
            	<i class="fas fa-user-md fa-lg fa-fw"></i> Consulta</a></li>
			<li class="<?php if($tabS=='cTRA') echo 'active' ?>">
            	<a href="#cTRA" data-toggle="tab" title="cTRA" onClick="setTab(this.title)">
            	<i class="fa fa-columns fa-lg"></i> Medicacion</a></li>            
            <li class="<?php if($tabS=='cEXA') echo 'active' ?>">
            	<a href="#cEXA" data-toggle="tab" title="cEXA" onClick="setTab(this.title)">
            	<i class="fa fa-list-alt fa-lg"></i> Exámenes</a></li>
            <li class="<?php if($tabS=='cCIR') echo 'active' ?>">
            	<a href="#cCIR" data-toggle="tab" title="cCIR" onClick="setTab(this.title)">
            	<i class="fa fa-medkit fa-lg"></i> Cirugías</a></li>
            <li class="<?php if($tabS=='cDOC') echo 'active' ?>">
            	<a href="#cDOC" data-toggle="tab" title="cDOC" onClick="setTab(this.title)">
            	<i class="fas fa-file fa-lg"></i> Documentos</a></li>
			<li class="<?php if($tabS=='cIESS') echo 'active' ?>">
            	<a href="#cIESS" data-toggle="tab" title="cIESS" onClick="setTab(this.title)">
            	<i class="fas fa-hospital"></i> IESS</a></li>
            <li class="<?php if($tabS=='cANT') echo 'active' ?>">
            	<a href="#cANT" data-toggle="tab" title="cANT" onClick="setTab(this.title)">
            	<i class="fa fa-history fa-lg"></i> Historia Anterior</a></li>
		</ul>
	</div>
    <div class="col-md-10">
        <div class="tab-content">
            <div class="tab-pane <?php if(!$tabS) echo 'active' ?>" id="cHC">
				<?php include(RAIZc.'com_hc/historia_det.php')?>
            </div>
            <div class="tab-pane <?php if($tabS=='cCON') echo 'active' ?>" id="cCON">
				<div id="contCons"><?php $vVT=TRUE; ?>
				<?php include(RAIZc.'com_hc/consulta_det.php') ?>
				</div>
			</div>
            <div class="tab-pane <?php if($tabS=='cTRA') echo 'active' ?>" id="cTRA">
            	<?php include(RAIZc.'com_tratamientos/traLisCon.php') ?>
			</div>
            <div class="tab-pane <?php if($tabS=='cEXA') echo 'active' ?>" id="cEXA">
            	<?php include(RAIZc.'com_examen/examLisCon.php')?>
			</div>
            <div class="tab-pane <?php if($tabS=='cCIR') echo 'active' ?>" id="cCIR">
            	<?php include(RAIZc.'com_cirugia/cirLisCon.php')?>
			</div>
            <div class="tab-pane <?php if($tabS=='cDOC') echo 'active' ?>" id="cDOC">
            	<?php include(RAIZc.'com_docs/docLisCon.php')?>
			</div>
			<div class="tab-pane <?php if($tabS=='cIESS') echo 'active' ?>" id="cIESS">
            	<?php include(RAIZc.'com_iess/iessRepList.php')?>
			</div>
            <div class="tab-pane <?php if($tabS=='cANT') echo 'active' ?>" id="cANT">
            	<?php include(RAIZc.'com_hc/consulta_ant.php');?>
			</div>               
        </div>
	</div>

</div>
</div>
</div>
</div>
</form>
<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<?php }else{ ?>
<div class="alert alert-danger"><h4>Error Paciente No Existe</h4></div>
<?php } ?>
<script type="text/javascript" src="js/js_carga_list-cons-pac.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#con_diagd').chosen({});	
	var contlog = $("#log"); contlog.delay(3800).slideUp(200);
	//loadCon();
	$("#loadConData").on('click',loadCon);
	$('.setDB').keyup(function() {
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var cod = $(this).attr("data-id");
		var tbl = $(this).attr("data-rel");
		setDB(campo, valor, cod, tbl);
	});
});
function loadConDiag(idc){
	//$('#consDiagDet').load(RAIZc+'com_hc/consulta_diag_det.php',{idc:idc});
	//alert('aca');
	location.reload();
}	
function loadCon(){	
	$("#contCons").load(RAIZc+"com_hc/consulta_det.php?idc=<?php echo $idc ?>&idp=<?php echo $idp ?>");
}

function setDB(campo, valor, cod, tbl){
	$.get( RAIZc+"com_comun/actionsJS.php", { campo: campo, valor: valor, cod: cod, tbl: tbl}, function( data ) {
		showLoading();
		$("#logF").show(100).text(data.inf).delay(3000).hide(200);
		hideLoading();
	}, "json" );
}
function setTab(val){
	$.get( "setTabJS.php", { val: val}, function( data ) {});
}
</script>
<?php include(RAIZf."footerC.php");?>
