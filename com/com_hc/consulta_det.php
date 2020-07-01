<?php include_once('../../init.php');
if(!$vVT){
	$idc=vParam('idc', $_GET['idc'], $_POST['idc']);
	$idp=vParam('idp', $_GET['idp'], $_POST['idp']);
}
$detCon=detRow('db_consultas','con_num',$idc);
?>

<div class="row">
	<div class="col-sm-9">
	
		<?php if ($idc){ ?>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tabCA" aria-controls="home" role="tab" data-toggle="tab">Datos de la Consulta</a></li>
			<li role="presentation"><a href="#tabCB" aria-controls="profile" role="tab" data-toggle="tab">Examen Físico</a></li>
		</ul>
  		<!-- Tab panes -->
  		<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tabCA">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<h3 class="panel-title"><i class="fa fa-user-md fa-lg"></i> Motivo de la Consulta</h3>
            </div>
            <div class="panel-body">
            	<div class="row">
            		<div class="col-sm-3">
            		<label>Motivos de la Consulta</label>
            		<textarea name="dcon_mot" rows="6" class="form-control input-sm" id="dcon_mot" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $detCon['dcon_mot'] ?></textarea></div>
					
					
					<div class="col-sm-3">
            		<label>Enfermedad Actual</label>
            		<textarea name="dcon_enfa" rows="6" class="form-control input-sm" id="dcon_enfa" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $detCon['dcon_enfa'] ?></textarea></div>
					
            		<div class="col-sm-6">
            		<label>Evolución</label>
            		<textarea name="dcon_obs" rows="6" class="form-control input-sm" id="dcon_obs" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $detCon['dcon_obs'] ?></textarea></div>
            	</div>
    		
    		
            
            </div>
        </div>
		<div class="panel panel-primary">
        	<div class="panel-heading">
            <h3 class="panel-title">
            <i class="fa fa-user-md fa-lg"></i> Diagnosticos
            <a href="<?php echo $RAIZc ?>com_comun/gest_diag.php" class="btn btn-info btn-xs fancybox fancybox.iframe fancyreload pull-right" onClick="ansclose=false;"><i class="fas fa-plus-square fa-lg"></i> Gestionar Diagnosticos</a>
            </h3>
            </div>
            <div class="panel-body">
            	<div class="row">
            		<div class="col-sm-6">
            			<fieldset>
            			<?php 
							$param='1';
							$query_RSd = sprintf("SELECT id_diag as sID, CONCAT_WS(' - ',codigo,nombre) as sVAL FROM db_diagnosticos WHERE estado=%s ORDER BY id_diag ASC",
							SSQL($param,'int'));
							$RSd = mysql_query($query_RSd) or die(mysql_error()); 
							$tr_RSd=mysql_num_rows($RSd);
							//var_dump($listCats);
							   ?>
							<div class="form-group">
							<? genSelect("diagSel[]",$RSd,NULL,'form-control', '', 'chosDiag',NULL,TRUE,NULL,'- Seleccione Diagnóstico -');?>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="diagD" id="diagD" placeholder="Otros Diagnósticos">
							</div>
							<div class="form-group">
								<button type="button" class="setConDiagOtro btn btn-info btn-xs">AGREGAR</button>
							</div>
						</fieldset>
            		</div>
            		<div class="col-sm-6">
            			<div id="consDiagDet">
            			<?php 
			   			$idcP=$idc;
			   			include('consulta_diag_det.php');
						?>
            			</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="tabCB">
    	<div class="">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<h3 class="panel-title">
                	<i class="fa fa-stethoscope fa-lg"></i> Examen Fisico 
                </h3>
            </div>
            <div class="panel-body">
            
            <div class="row">
        	<div class="col-sm-6">
            
            <fieldset class="form-horizontal">
            
            <div class="form-group">
            	<label class="control-label col-sm-5">Apariencia General</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_agen" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_agen'] ?>"/>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">Estado Nutricional</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_estn" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_estn'] ?>"/>
                </div>
            </div>
				
			<div class="form-group">
            	<label class="control-label col-sm-5"><strong>Región Inguino Genital</strong></label>
                <div class="col-sm-7">
					<textarea name="dcon_ef_muco" class="form-control setDB" data-id="<?php echo $idc ?>" data-rel="con" rows="3"><?php echo $detCon['dcon_ef_muco'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5"><strong>Abdomino Pélvica</strong></label>
                <div class="col-sm-7">
					<textarea name="dcon_ef_cavo" class="form-control setDB" data-id="<?php echo $idc ?>" data-rel="con" rows="3"><?php echo $detCon['dcon_ef_cavo'] ?></textarea>
                </div>
            </div>
				
			<!--
            <div class="form-group">
            	<label class="control-label col-sm-5">Mucosas</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_muco" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_muco'] ?>"/>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">Cavidad Oral</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_cavo" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_cavo'] ?>"/>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">Conductos Auditivos</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_caud" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_caud'] ?>"/>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">Fosas Nasales</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_fosn" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_fosn'] ?>"/>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">Cuello</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_cue" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_cue'] ?>"/>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">Orofaringe</label>
                <div class="col-sm-7">
                <input type="text" class="form-control setDB" name="dcon_ef_oro" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_oro'] ?>"/>
                </div>
            </div>
            -->
            </fieldset>
            
            </div>
            <div class="col-sm-6">
            <fieldset class="form-horizontal">
            <legend>REGION PELVICA</legend>
            <div class="form-group">
            	<label class="control-label col-sm-5">INSPECCION</label>
                <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_ins" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_ins'] ?>"/></div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">PERCUCION</label>
                <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_per" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_per'] ?>"/></div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">PALPACION</label>
                <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_pal" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_pal'] ?>"/></div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-5">AUSCULTACION</label>
                <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_aus" data-id="<?php echo $idc ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_aus'] ?>"/></div>
            </div>
            </fieldset>
            </div>
        </div>            
            </div>
        </div>
    </div>
    </div>
  </div>
		<?php }else{ ?>
			<div class="alert alert-warning">
				<br>
				<h4>Para modificar los datos de le Consulta, primero debe <strong>GUARDAR</strong></h4>
				<br>
			</div>
		<?php } ?>
		
	</div>
	<div class="col-sm-3">
	
		<div>
        <?php
				$qrlLCA=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<>%s ORDER BY con_num DESC LIMIT 5',
							   SSQL(intval($idp),'int'),
							   SSQL(intval($idc),'int'));
			   	$RSlca=mysql_query($qrlLCA);
			   	$dRSlca=mysql_fetch_assoc($RSlca);
			   	$tRSlca=mysql_num_rows($RSlca);
			   	if($tRSlca>0){
					$resDiag.='<table class="table">';
			   		do{
						$resDiag.='<tr>';
						$resDiag.='<td>'.utf8_encode(strftime("%d-%B-%Y",strtotime($dRSlca[con_fec]))).'</td>';
						$resDiag.='<td>';
						$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
									 SSQL($dRSlca['con_num'],'int'));
						$RSld=mysql_query($qLD);
						$dRSld=mysql_fetch_assoc($RSld);
						$tRSld=mysql_num_rows($RSld);
						if($tRSld>0){
							//$resDiag.='<ul class="">';
							do{
								if($dRSld[id_diag]>1){
								$dDiag=detRow('db_diagnosticos','id_diag',$dRSld[id_diag]);
								$dDiag_cod=$dDiag[codigo].'-';
								$dDiag_nom=$dDiag[nombre];
								}else{
									$dDiag_cod=NULL;
									$dDiag_nom=$dRSld[obs];
								}
								//$resDiag.='<li class="">'.$dDiag_cod.$dDiag_nom.'</li>';
								$resDiag.=' <span class="btn btn-default btn-xs">'.$dDiag_cod.$dDiag_nom.'</span> ';
							}while($dRSld=mysql_fetch_assoc($RSld));
							//$resDiag.='</ul>';
						}
						$resDiag.='</td></tr>';
			   		}while($dRSlca=mysql_fetch_assoc($RSlca));
					$resDiag.='</table>';
				}else $resDiag='<div class="panel-body">Sin resultados anteriores</div>';
				?>
        		<div class="panel panel-default">
					<div class="panel-heading">Historial Diagnósticos anteriores</div>
					<?php echo $resDiag ?>					
				</div>
        	</div>
	
	</div>
</div>

<?php
//mysql_free_result($RSd);
//mysql_free_result($RSdc); ?>
<script type="text/javascript">
$(document).ready(function(){
	//loadConDiag(<?php echo $idc ?>);
	function do_something(evt, params){
		var  target = $(event.target),
		priorDataSet = target.data("chosen-values"),
		currentDataSet = target.val();
		//Diff and compare the delta here.    
		target.data("chosen-values", currentDataSet);
	};
	
	$('#chosDiag').chosen({
		placeholder_text_multiple: "Seleccione los Diagnosticos Posibles"
	});
	
	$('#chosDiag').on('change', function(evt, params) {
		var valSel=params['selected'];
		var valDes=params['deselected'];
		var accC;
		if(valSel){
			accC='sel';
			valC=valSel;
		}
		if(valDes){
			accC='des';
			valC=valDes;
		}
		//alert(valC);
		if(valC>1){
			setDB(accC,valC,'<?php echo $idc ?>','condiag');
			loadConDiag(<?php echo $idc ?>);
		}else{ 
			//alert ('OTRO');
			//$("#diagD").focus();
			$("#diagD").focus();
		}
	});
	$('.setConDiagOtro').on('click', function () {
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var cod = $(this).attr("data-id");
		var tbl = $(this).attr("data-rel");
		var desDiag = $('#diagD');
		//alert(desDiag.val());
		setDB('otro',desDiag.val(),'<?php echo $idc ?>','condiag');
		desDiag.val('');
		loadConDiag(<?php echo $idc ?>);
	});
});
	
</script>