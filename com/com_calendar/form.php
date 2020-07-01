<?php include('../../init.php');
$datefc=vParam('datefc',$_GET['datefc'],$_POST['datefc']);//start
$datefe=vParam('datefe',$_GET['datefe'],$_POST['datefe']);//end
$id=vParam('id',$_GET['id'],$_POST['id']);
$detRes=detRow('db_fullcalendar','id',$id);
if($detRes){
	$acc=md5(UPDr);
	$accBtn='<button type="button" class="btn btn-success navbar-btn" id="vAcc"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	$accBtn.='<a class="btn btn-danger navbar-btn vAccL" href="actions.php?id='.$id.'&acc='.md5(DELr).'"><i class="fas fa-trash fa-lg"></i> ELIMINAR</a>';
	$dfc_fechai=$detRes['fechai'];
	$dfc_horai=$detRes['horai'];
	$dfc_fechaf=$detRes['fechaf'];
	$dfc_horaf=$detRes['horaf'];
}else{
	$acc=md5(INSr);
	$accBtn='<button type="button" class="btn btn-primary navbar-btn" id="vAcc"><i class="fas fa-save fa-lg"></i> GRABAR</button>';
	$dfc=explode("T", $datefc);
	$dfe=explode("T", $datefe);	
	$dfc_fechai=$dfc[0];
	$dfc_horai=$dfc[1];
	$dfc_fechaf=$dfe[0];
	$dfc_horaf=$dfe[1];
	if(!$datefe){
		$dfc_fechaf=$dfc[0];
		if($dfc_horai){
			$dfc_horaf=strtotime ('+30 mins',strtotime($dfc_horai));
			$dfc_horaf=date('H:i:s',$dfc_horaf);
		}
	}
}
$qryLP=sprintf('SELECT pac_cod as sID, CONCAT(pac_nom," ",pac_ape) as sVAL FROM db_pacientes');
$RSLP=mysql_query($qryLP);
$css['body']='cero';
include(RAIZf.'head.php');
?>
<?php sLOG('g') ?>
<form action="actions.php" method="post">
<fieldset>
	<input name="form" type="hidden" id="form" value="<?php echo md5(AGE)?>">
	<input name="acc" type="hidden" id="acc" value="<?php echo $acc?>">
	<input name="id" type="hidden" id="id" value="<?php echo $id?>">
    <input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
</fieldset>
<nav class="navbar navbar-default navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">RESERVAS</a>
    </div>

      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?php echo $id ?></a></li>
        <li><a href="#"><?php echo $datefc ?></a></li>
      </ul>
      <div class="btn-group pull-right">
      <?php echo $accBtn ?>
      <a href="<?php echo $urlc ?>" class="btn btn-default navbar-btn "><i class="fas fa-plus-square fa-lg"></i> Nuevo</a>
      </div>

  </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">
	<div class="row">
    	<div class="col-sm-3">
        	<div class="panel panel-default">
            	<div class="panel-heading"><h3 class="panel-title">Datos Inicio</h3></div>
            	<div class="panel-body">
                <fieldset class="">
                <div class="form-group">
                <label for="fechai" class="control-label">Fecha</label>
                <input name="fechai" type="date" class="form-control" id="fechai" value="<?php echo $dfc_fechai ?>" placeholder="Fecha Inicio">
                </div>
                <div class="form-group">
                <label for="horai" class="control-label">Hora</label>
                <input name="horai" type="time" class="form-control" id="horai" value="<?php echo $dfc_horai ?>" placeholder="Hora Inicio">
                </div>
            </fieldset>
            	</div>
            </div>
        </div>
        <div class="col-sm-3">
        	<div class="panel panel-default">
            	<div class="panel-heading"><h3 class="panel-title">Datos Fin</h3></div>
            	<div class="panel-body">
                <fieldset class="">
                <div class="form-group">
                <label for="fechaf" class="control-label">Fecha</label>
                <input name="fechaf" type="date" class="form-control" id="fechaf" value="<?php echo $dfc_fechaf ?>" placeholder="Email">
                </div>
                <div class="form-group">
                <label for="horaf" class="control-label">Hora</label>
                <input name="horaf" type="time" class="form-control" id="horaf" value="<?php echo $dfc_horaf ?>" placeholder="Email">
                </div>
            </fieldset>
            	</div>
            </div>
        </div>
        <div class="col-sm-6">
        	<fieldset class="well form-horizontal">
            	<div class="form-group">
                <label for="horaf" class="col-sm-3 control-label">Paciente</label>
                <div class="col-sm-9">
                <?php genSelect('idp',$RSLP,$detRes['pac_cod'],' form-control '); ?>
                </div>
                </div>
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
                </div>
                </div>
                <div class="form-group">
                <label for="horaf" class="col-sm-3 control-label">Observaciones</label>
                <div class="col-sm-9">
                <textarea name="obs" id="obs" class="form-control"><?php echo $detRes['obs'] ?></textarea>
                </div>
                </div>
                
                <div class="form-group">
                <label for="horaf" class="col-sm-3 control-label">Estado</label>
                <div class="col-sm-9">
                <table width="200">
                  <tr>
                    <td><label>
                      <input type="radio" name="est" value="1" id="est_0"
                      <?php if($detRes['est']=='1') echo ' checked ' ?>>
                      Pendiente</label></td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="radio" name="est" value="2" id="est_1"
                      <?php if($detRes['est']=='2') echo ' checked ' ?>>
                      Atendido</label></td>
                  </tr>
                  <tr>
                    <td><label>
                      <input type="radio" name="est" value="0" id="est_2"
                      <?php if($detRes['est']=='0') echo " checked "?>>
                      Eliminar</label></td>
                  </tr>
                </table>
                </div>
                </div>
                
            </fieldset>
        </div>
    </div>
</div>
</form>
<script type="text/javascript" src="js/js.js"></script>
<?php include(RAIZf.'footerC.php') ?>