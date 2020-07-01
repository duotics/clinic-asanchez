<?php include_once('../../init.php');
if(!$vVT) $idc=vParam('idc', $_GET['idc'], $_POST['idc']);
$detCon=detRow('db_consultas','con_num',$idc);
?>
<?php if($idc){ ?>
<fieldset>
<div class="row">
	<div class="col-sm-4">
    	<div class="panel panel-primary cero">
        	<div class="panel-heading">
            	<h3 class="panel-title"><i class="fa fa-user-md fa-lg"></i> Motivo de la Consulta</h3>
            </div>
            <div class="panel-body">
    		<textarea name="dcon_mot" rows="3" class="form-control input-sm" id="dcon_mot" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $detCon['dcon_mot'] ?></textarea>
    		<label>Conclusion</label>
            <textarea name="dcon_obs" rows="3" class="form-control input-sm" id="dcon_obs" onKeyUp="setDB(this.name,this.value,'<?php echo $idc ?>','con')"><?php echo $detCon['dcon_obs'] ?></textarea>
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
            <?php 
			$param='1';
			$query_RSd = sprintf("SELECT id_diag as sID, nombre as sVAL FROM db_diagnosticos WHERE estado=%s ORDER BY nombre ASC",
			SSQL($param,'int'));
			$RSd = mysql_query($query_RSd) or die(mysql_error()); 
			$tr_RSd=mysql_num_rows($RSd);
			//echo $tr_RSd;
			$query_RSdc = sprintf('SELECT id_diag as sID FROM db_consultas_diagostico WHERE con_num=%s',
			SSQL($idc,'int'));
			$RSdc = mysql_query($query_RSdc) or die(mysql_error());
			$row_RSdc = mysql_fetch_assoc($RSdc);
			$tr_RSdc = mysql_num_rows($RSdc);
			//echo '-'.$tr_RSdc;
			if($tr_RSdc>0){
				$x=0;
				do{
					$listCats[$x]=$row_RSdc['sID'];
					$x++;
				} while ($row_RSdc = mysql_fetch_assoc($RSdc));
			}
			//var_dump($listCats);
			echo generarselect("diagSel[]",$RSd,$listCats,'form-control', 'multiple', 'chosDiag',NULL,FALSE);
			?>
            </div>
        </div>
        
    </div>
    <div class="col-sm-8">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<h3 class="panel-title">
                	<i class="fa fa-stethoscope fa-lg"></i> Examen Fisico 
                </h3>
            </div>
            <div class="panel-body">
            
            <div class="row">
        	<div class="col-sm-6">
            
            <fieldset class="form-horizontal form-min">
            
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
            
            </fieldset>
            
            </div>
            <div class="col-sm-6">
            <fieldset class="form-horizontal form-min">
            <legend>TORAX</legend>
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
</fieldset>
<?php
//mysql_free_result($RSd);
//mysql_free_result($RSdc); ?>
<script type="text/javascript">
$(document).ready(function(){
	function do_something(evt, params){
		var  target = $(event.target),
		priorDataSet = target.data("chosen-values"),
		currentDataSet = target.val();
		//Diff and compare the delta here.    
		target.data("chosen-values", currentDataSet);
	};
	
	//$( "body" ).delegate( "#cCONli", "click", function() {
  	//alert( $( this ).text() );
		//alert('vale');
		//testChosen();
	//});
	
	$('#chosDiag').chosen({
		placeholder_text_multiple: "Seleccione los Diagnosticos Posibles"
	});
	/*function testChosen(){
	alert('llama func');
	$('#chosDiag').chosen({
		placeholder_text_multiple: "Seleccione los Diagnosticos Posibles"
	});
	}*/
	
	//$("#chosDiag").live(function() { $(this).chosen(); });
	
	//$( "#cCONli" ).delegate( "click", function() {
  	//return false;
	//alert ('TEST');
	//});
	
	$('#chosDiag').on('change', function(evt, params) {
    	//alert("save");//do_something(evt, params);
		//do_something(evt, params);
		//alert(evt);
		//console.log(evt);
		//console.log(params);
		//console.log(params.propertyName);
		//console.log(params['selected']);
		//console.log(params['deselected']);
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
		console.log(accC+valC);
		setDB(accC,valC,'<?php echo $idc ?>','condiag')
		//for (var propName in params) {
		 //console.log(propName, params['deselected'])
		//}
		//alert(params.value);
	});
});
</script>
<?php }else{ ?>
<div class="alert alert-warning"><h4>Primero Guarde la Consulta</h4><?php echo $btn_action_form ?></div>
<?php } ?>