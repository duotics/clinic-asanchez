<?php require('../../init.php');
$_SESSION['tab']['con']='cTRA';
$idc=vParam('idc',$_GET['idc'],$_POST['idc']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$idt=vParam('idt',$_GET['idt'],$_POST['idt']);
$acc=vParam('acc',$_GET['acc'],$_POST['acc']);
//Eliminar Tratamiento
if($acc==md5(DELtf)) header(sprintf("Location: %s", '_fncts.php?idt='.$idt.'&acc='.$acc));
if($acc==md5(NEWt)) header(sprintf("Location: %s", '_fncts.php?idc='.$idc.'&idp='.$idp.'&acc='.$acc.'&url='.$urlc));
//FORM
$detTrat=detRow('db_tratamientos','tid',$idt);
if($detTrat){
	$fechaReceta=$detTrat['fecha'];
	$dCon=detRow('db_consultas','con_num',$detTrat[con_num]);
	$acc='UPDt';
	$btnAcc='<button name="btnA" type="submit" class="btn btn-success btn-narvar"><i class="fa fa-refresh"></i> GUARDAR</button>';
	$btnP='<button name="btnP" type="submit" class="btn btn-default btn-navbar"><i class="fas fa-print fa-lg"></i> GUARDAR E IMPRIMIR</button>';
	$idc=$detTrat['con_num'];
	$detCon=detRow('db_consultas','con_num',$idc);
	$detDiag_nom=$detTrat['diagnostico'];
	//LISTADO DE MEDICAMENTOS
	$qRSlm = sprintf('SELECT id_form AS sID, CONCAT_WS(" ",generico," ( ",comercial," ) "," : ",presentacion, cantidad) as sVAL FROM db_medicamentos WHERE estado=1 OR generico IS NULL OR comercial IS NULL OR presentacion IS NULL OR cantidad IS NULL');
	$RSlm = mysql_query($qRSlm) or die(mysql_error());
	
	$idtd=vParam('idtd',$_GET['idtd'],$_POST['idtd']);
	$detTD=detRow('db_tratamientos_detalle','id',$idtd);
	if($detTD){//Detalle Tratamiento
		$accTD=md5(UPDtd);
		$btnAccTD='<button name="btnA" id="dtAG" class="btn btn-success btn-block btn-sm" type="submit"><i class="fas fa-save fa-lg"></i> Actualizar en la receta</button>';
	}else{
		$accTD=md5(INStd);
		$btnAccTD='<button id="dtAG" class="btn btn-primary btn-block btn-sm" type="submit"><i class="fas fa-save fa-lg"></i> Agregar a la receta</button>';
	}
}else{
	$fechaReceta=$sdate;
	$acc='INSt';
	$btnAcc='<button type="submit" class="btn btn-large btn-info"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
	$detCon=detRow('db_consultas','con_num',$idc);
	$detDiag=detRow('db_diagnosticos','id_diag',$detCon['con_diagd']);
	$detDiag_nom=$detDiag['nombre'];
}
$detCon=detRow('db_consultas','con_num',$idc);
$idp=$detCon['pac_cod'];
$detPac=detRow('db_pacientes','pac_cod',$idp);//dPac($idp);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<?php sLOG('g'); ?>
<style>
	.current-row{background-color:#B24926;color:#FFF;}
	.current-col{background-color:#1b1b1b;color:#FFF;}
	.tbl-qa{width: 100%;font-size:0.9em;background-color: #f5f5f5;}
	.tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;}
	.tbl-qa .table-row td {padding:10px;background-color: #FDFDFD;}
</style>
<form method="post" action="_fncts.php">
<fieldset>
    <input name="idt" type="hidden" id="idt" value="<?php echo $idt ?>">
    <input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
    <input name="acc" type="hidden" id="acc" value="<? echo $acc?>">
    <input name="url" type="hidden" id="url" value="<? echo $urlc?>">
    <input name="form" type="hidden" id="form" value="tratdet">
</fieldset>
<nav class="navbar navbar-default cero" role="navigation">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-columns fa-lg"></i> TRATAMIENTO 
      <span class="label label-info"><?php echo $idt ?></span></a>
    </div>
	<div class="collapse navbar-collapse" id="navbar-collapse-2">
	<ul class="nav navbar-nav">
		<li class="active"><a><?php echo $detPac_nom ?></a></li>
        <li><a>Consulta <span class="label label-default"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $detTrat['fecha'] ?></a></li>
	</ul>
	<div class="navbar-right btn-group navbar-btn">
		<?php echo $btnAcc?>
        <?php echo $btnP ?>
		</li>
	</div>
	</div><!-- /.navbar-collapse -->
</nav>
<div class="container-fluid">
<div class="well well-sm">
	<fieldset class="form-inline">
	<label class="control-label">Fecha Receta</label>
	<input name="fecha" type="date" required class="form-control input-sm" id="fecha" value="<?php echo $fechaReceta ?>" autofocus>
    <label class="control-label">Observaciones</label>
    <input name="obs" type="text" class="form-control input-sm" id="obs" placeholder="otras indicaciones" value="<?php echo $detTrat['obs'] ?>">
    <label class="control-label">Proxima Consulta</label>
    <input name="con_diapc" type="number" class="form-control input-sm" id="con_diapc" value="<?php echo $dCon['con_diapc'] ?>"> 
    <label class="control-label">Tipo de Proxima Visita</label>
    <?php
	$paramsN[]=array(
	array("cond"=>"AND","field"=>"typ_ref","comp"=>"=","val"=>'MOTCON'),
	array("cond"=>"AND","field"=>"typ_stat","comp"=>'=',"val"=>1)
	);
	$RS=detRowGSelNP('db_types','typ_cod','typ_val',$paramsN,TRUE,'typ_val','ASC');
	genSelect('con_typvisP',$RS,$dCon['con_typvisP'],'form-control input-sm', ' onChange="setDB(this.name,this.value,'.$idc.','."'con'".')"','con_typvisP',NULL,TRUE,NULL,'- Seleccione -'); ?>    
    </fieldset>
</div>
</div>
</form>

<?php if($detTrat){?>


<div class="container-fluid">
<div class="row">

	<div class="col-sm-9">
   <form method="post" action="_fncts.php">
    
    <fieldset>
    <input name="trat_id" type="hidden" id="trat_id" value="<?php echo $idt ?>">
    <input name="idtd" type="hidden" id="idtd" value="<?php echo $idtd ?>">
	<input name="acc" type="hidden" id="acc" value="<?php echo $accTD ?>">
	<input name="form" type="hidden" id="form" value="tratdet">
	<input name="tipTD" type="hidden" id="tipTD" value="<?php echo $detTD['tip'] ?>">
	<input name="idref" type="hidden" id="idref" value="">
	<input name="url" type="hidden" value="<?php echo $urlc ?>">
	
	
	</fieldset>
	<fieldset class="form-horizontal" style="display: none;">
   	<div class="form-group">
    	<label for="generico" class="col-sm-2 control-label">Medicamento</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-6"><input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detTD['generico'] ?>"></div>
			<div class="col-sm-6"><input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detTD['comercial'] ?>"></div>
		</div>
	</div>
	</div>
   	
	<div class="form-group">
    	<label for="presentacion" class="col-sm-2 control-label">Información</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-4"><input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detTD['presentacion'] ?>"></div>
			<div class="col-sm-4"><input name="cantidad" type="text" class="form-control" id="cantidad" placeholder="Dosis" value="<?php echo $detTD['cantidad'] ?>"></div>
			<div class="col-sm-4"><input name="numero" type="text" class="form-control" id="numero" placeholder="#" value="<?php echo $detTD['numero'] ?>"></div>
		</div>
    </div>
	</div>
    <div class="form-group">
    	<label for="descripcion" class="col-sm-2 control-label" id="txtDesMod">Prescripción</label>
    	<div class="col-sm-10">
    	<textarea name="descripcion" rows="4" class="form-control" id="descripcion"><?php echo $detTD['descripcion'] ?></textarea>
    	</div>
	</div>
    <div class="form-group">
    	<label for="" class="col-sm-2 control-label"></label>
    	<div class="col-sm-10">
    	<?php echo $btnAccTD; ?>
    	</div>
	</div>
   	
   </fieldset>
	<fieldset class="form-horizontal">
    <div class="row">
    	<div class="col-sm-6">
			<div class="form-group">
				<label for="generico" class="col-sm-3 control-label">Listado Medicamentos</label>
				<div class="col-sm-9">
				<?php genSelect('listMed', $RSlm,NULL,'form-control input-sm', NULL, 'listMed', NULL, TRUE, NULL, 'Seleccione Medicamento') ?>
				</div>
			</div>
    	</div>
    	<div class="col-sm-6">
    		<div class="form-group">
			<label for="generico" class="col-sm-3 control-label">Listado Indicaciones</label>
			<div class="col-sm-9">
			<?php genSelect('listInd',detRowGSel('db_indicaciones','id','des','est','1',TRUE,'feat','DESC'),NULL,' form-control input-sm', NULL, NULL, 'Seleccione'); ?>
			</div>
		</div>
    	</div>
    </div>
    </fieldset>
    </form>
    <div class="panel panel-primary">
<?php
		$qrytl='SELECT * FROM db_tratamientos_detalle WHERE tid='.$idt.' ORDER BY tip DESC, id DESC';
		$RStl=mysql_query($qrytl);
		$dRStl=mysql_fetch_assoc($RStl);
		$tr_RStl=mysql_num_rows($RStl);
if($tr_RStl>0){
?>
<div class="panel-heading"><h4 class="panel-title"><i class="fa fa-columns fa-lg"></i> Receta Médica</h4></div>
<div class="table-responsive">
<table class="table table-bordered table-striped tbl-qa">
<thead><tr>
	<th class="table-header">Generico</th>
    <th class="table-header">Comercial</th>
	<th class="table-header">Pres</th>
    <th class="table-header">Dosis</th>
    <th class="table-header">#</th>
	<th class="table-header">Prescripción</th>
    <th class="table-header"></th>
</tr></thead>
<tbody>
<?php do{ ?>
<?php switch($dRStl[tip]){ ?>
<?php case 'G': ?>
<tr>
	<td contenteditable="true" onBlur="saveToDatabase(this,'generico','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[generico] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'comercial','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[comercial] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'presentacion','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[presentacion] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'cantidad','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[cantidad] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'numero','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[numero] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'descripcion','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[descripcion] ?></td>
    <td>
    <a href="_fncts.php?idt=<?php echo $idt ?>&idtd=<?php echo $dRStl['id'] ?>&acc=<?php echo md5(DELtd) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
    <i class="fas fa-trash fa-lg"></i> Quitar</a>
    </td>
</tr>
<?php break; ?>
<?php case 'M': ?>
<tr>
	<td contenteditable="true" onBlur="saveToDatabase(this,'generico','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[generico] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'comercial','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[comercial] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'presentacion','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[presentacion] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'cantidad','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[cantidad] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'numero','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[numero] ?></td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'descripcion','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[descripcion] ?></td>
    <td>
    <a href="_fncts.php?idt=<?php echo $idt ?>&idtd=<?php echo $dRStl['id'] ?>&acc=<?php echo md5(DELtd) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
    <i class="fas fa-trash fa-lg"></i> Quitar</a>
    </td>
</tr>
<?php break; ?>
<?php case 'I': ?>
<tr class="info">
    <td colspan="6" contenteditable="true" onBlur="saveToDatabase(this,'indicacion','<?php echo $dRStl[id] ?>')" onClick="showEdit(this);"><?php echo $dRStl[indicacion] ?></td>
    <td>
    <a href="_fncts.php?idt=<?php echo $idt ?>&idtd=<?php echo $dRStl['id'] ?>&acc=<?php echo md5(DELtd) ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
    <i class="fas fa-trash fa-lg"></i> Quitar</a>
    </td>
</tr>
<?php break; ?>
<?php } ?>
<?php }while ($dRStl = mysql_fetch_assoc($RStl));?>
</tbody>
</table>

</div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Medicamentos Registrados</h4></div>'; ?>
</div>
    
	</div>
	<div class="col-sm-3">
	<?php
	$qLTP=sprintf('SELECT * FROM db_tratamientos WHERE pac_cod = %s AND tid <> %s ORDER BY fecha DESC LIMIT 5',
				 SSQL($idp,'int'),
				 SSQL($idt,'int'));
	//echo $qLTP;
	$RS=mysql_query($qLTP);
	$dRS=mysql_fetch_assoc($RS);
	$tRS=mysql_num_rows($RS);
	//echo 'tRS. '.$tRS;
	?>
    <div class="panel panel-default">
    <div class="panel-heading">Historial Recetas</div>
    <!--<div class="panel-body">-->
        <?php if($tRS>0){ ?>
        <table class="table table-condensed">
        <?php do{ ?>
        <?php
		$qrytl='SELECT * FROM db_tratamientos_detalle WHERE tid='.$dRS['tid'].' AND tip="M" ORDER BY id ASC';
		$RStl=mysql_query($qrytl);
		$dRStl=mysql_fetch_assoc($RStl);
		$tr_RStl=mysql_num_rows($RStl);
	
		$qrytli='SELECT * FROM db_tratamientos_detalle WHERE tid='.$dRS['tid'].' AND tip="I" ORDER BY id ASC';
		$RStli=mysql_query($qrytli);
		$dRStli=mysql_fetch_assoc($RStli);
		$tr_RStli=mysql_num_rows($RStli);
		$resDiag=NULL;
		if($dRS['con_num']){
			$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
			SSQL($dRS['con_num'],'int'));
			$RSld=mysql_query($qLD);
			$dRSld=mysql_fetch_assoc($RSld);
			$tRSld=mysql_num_rows($RSld);
			
			if($tRSld>0){
				do{
				if($dRSld[id_diag]>1){
						$dDiag=detRow('db_diagnosticos','id_diag',$dRSld[id_diag]);
						$dDiag_cod=$dDiag[codigo].'-';
						$dDiag_nom=$dDiag[nombre];
					}else{
						$dDiag_cod=NULL;
						$dDiag_nom=$dRSld[obs];
					}
					$resDiag.=' <span class="btn btn-default btn-xs">'.$dDiag_cod.$dDiag_nom.'</span> ';
				}while($dRSld=mysql_fetch_assoc($RSld));
			}
		}
		
		?>
		<tr class="info">
       		<td colspan="2" class="">
       			<span class="btn btn-info btn-xs"><?php echo utf8_encode(strftime("%d-%B-%Y",strtotime($dRS['fecha']))) ?></span>
       			<?php echo $resDiag ?>
       		</td>
       	</tr>
       	<!--
       	<tr class="">
			<td colspan="2"></td>
       	</tr>-->
        <tr>
			
			<td>
            		
            		<?php if ($tr_RStl>0){?>
			<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
			
			<tbody>
			<?php do{?>
            <?php $detTdet_med=$dRStl['generico'].' ( '.$dRStl['comercial'].' )'; ?>
			<tr>
         		<td><?php echo $detTdet_med ?></td>
          		<td><?php echo $dRStl['numero'] ?></td>
           <!-- 
            <td><?php echo $dRStl['presentacion'] ?></td>
            <td><?php echo $dRStl['cantidad'] ?></td>
            <td><?php echo $dRStl['descripcion'] ?></td>
			-->
          </tr>
           <?php }while ($dRStl = mysql_fetch_assoc($RStl));?>
            </tbody></table>
			<?php }else echo '<div>No hay Medicamentos Prescritos</div>'?>
            		
				</td>
			
            <td>
            		
            		<?php if ($tr_RStli>0){?>
			<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
			
			<tbody>
			<?php do{?>
            <?php //$detTdet_med=$dRStl['generico'].' ( '.$dRStl['comercial'].' )'; ?>
			<tr><td><?php echo $dRStli['indicacion'] ?></td>
           
           <?php }while ($dRStli = mysql_fetch_assoc($RStli));?>
            </tbody></table>
			<?php }else echo '<div>No hay Indicaciones</div>'?>
            		
            	</td>
           
        </tr>
        	
        
        <?php }while($dRS=mysql_fetch_assoc($RS)); ?>
        </table>
        <?php }else{ ?>
		<div class="panel-body"><p>No hay recetas anteriores</p></div>
        <?php } ?>
    <!--</div>-->
    
	</div>
    
    </div>
</div>
</div>

<?php }?>

<?php if($detTrat){ ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#listMed').chosen({
		width: "100%"
	});
	$('#listMed').on('change', function(evt, params) {
    	doGetMedicamento(evt, params);
		$('#txtDesMod').html('Prescripcion');
		$('#txtDesMod').focus();
  	});
	$('#listInd').chosen({
		width: "100%"
	});
	$('#listInd').on('change', function(evt, params) {
    	doGetIndicaciones(evt, params);
		$('#txtDesMod').html('Indicaciones');
		$('#txtDesMod').focus();
  	});
	$("#printerButton").trigger("click");
});	
	function doGetMedicamento(evt, params){
		var id=params.selected;	
		$.getJSON( RAIZc+"com_medicamentos/json.medicamento.php?term="+id, function( data ) {
			$.each( data, function( key, val ) {

				$("#idref").val(val.id);
				$("#generico").val(val.generico);
				$("#comercial").val(val.comercial);
				$("#presentacion").val(val.presentacion);
				$("#cantidad").val(val.cantidad);
				$("#descripcion").val(val.descripcion);
				$("#tipTD").val('M');
				$("#dtAG").trigger("click");
			});
		});
	}
	function doGetIndicaciones(evt, params){
		var id=params.selected;	
		$.getJSON( RAIZc+"com_medicamentos/json.indicacion.php?term="+id, function( data ) {
			$.each( data, function( key, val ) {

				$("#idref").val(val.id);
				$("#descripcion").val(val.des);
				$("#tipTD").val('I');
				$("#dtAG").trigger("click");
			});
		});
	}
	function showEdit(editableObj) {
		$(editableObj).css("background","#FFF");
	} 

	function saveToDatabase(editableObj,column,id) {
		$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
		$.ajax({
			url: "saveDetTrat.php",
			type: "POST",
			data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
			success: function(data){
				$(editableObj).css("background","#FDFDFD");
			}        
	   });
	}
</script>

<?php }else{?>
<script type="text/javascript">$('#diagnostico').focus();</script>
<?php } ?>
<?php include(RAIZf.'footerC.php'); ?>