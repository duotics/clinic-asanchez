<?php 
if($idr){
	$det=detRow('db_iess','id',$idr);
	if($det){
		$idp=$det['pac_cod'];
		$dPac=detRow('db_pacientes','pac_cod',$idp);
		$acc=md5('UPDr');
		$btnAcc='<button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-refresh fa-lg"></i> Actualizar Reporte</button>';
		$btnPrt='<a class="btn btn-default navbar-btn pull-right" href="iessRep_print.php?id='.$idr.'"><i class="fa fa-print fa-lg"></i> Imprimir</a>';
		$vE=TRUE;
	}else $vM='Reporte no Existente'.$idr;
}else{
	if($idp){
		$dPac=detRow('db_pacientes','pac_cod',$idp);
		if($dPac){
			$acc=md5('INSr');
			$btnAcc='<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-floppy-o fa-lg"></i> Grabar Reporte</button>';
			$det['fecha']=$sdate;
			$det['hora']=$stime;
			$det['emp_cod']=$_SESSION['MM_EmpID'];
			$vE=TRUE;
		}else $vM='Paciente Inexistente';
	}else $vM='No Existen Parametros';
}
?>

<?php if($vE==TRUE){ ?>
<?php $dPac_sex=detRow('db_types','typ_cod',$dPac['pac_sexo']); ?>
<!--BEG GENERAL CONTENT-->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<a class="navbar-brand" href="#">REPORTE IESS <span class="label label-primary"><?php echo $idr ?></span></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<p class="navbar-text"><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></p>
		<p class="navbar-text">Consulta <span class="label label-default"><?php echo $idc ?></span></p>
		<p class="navbar-text"><?php echo $sdate ?></p>
		<a class="btn btn-info navbar-btn pull-right" href="<?php echo $urlc ?>?idp=<?php echo $idp ?>"><i class="fa fa-plus fa-lg"></i> NUEVO</a>
   		<?php echo $btnPrt ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
<div>
 <ul class="nav nav-tabs" id="myTab" style="margin: 0">
  <li class="<?php if((!$tabS)||($tabS=='tA')) echo 'active' ?>"><a href="#tA" rel="riess" title="tA" onClick="setTab(this.rel, this.title)">FRENTE</a></li>
  <li class="<?php if($tabS=='tB') echo 'active' ?>"><a href="#tB" rel='riess' title='tB' onClick="setTab(this.rel, this.title)">POSTERIOR</a></li>
</ul>
 <?php sLOG('a') ?>
	<div class="tab-content" style="padding: 10px">
		<div class="tab-pane <?php if((!$tabS)||($tabS=='tA')) echo 'active' ?>" id="tA">
			<?php require('_iessRepFormA.php') ?>
		</div>
		
		<div class="tab-pane <?php if($tabS=='tB') echo 'active' ?>" id="tB">
			<?php require('_iessRepFormB.php') ?>
		</div>
	</div>

</div>
</div>
<!--END GENERAL CONTENT-->
<?php }else{ ?>
	<div class="alert alert-danger"><h4><?php echo $vM ?></h4></div>
<?php } ?>
<script type="text/javascript"> $('#myTab a').click(function (e) { e.preventDefault(); $(this).tab('show'); })</script>
