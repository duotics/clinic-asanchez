<?php
$dD=detRow('db_documentos','id_doc',$idd);//fnc_datadoc($idd);
$dF=detRow('db_documentos_formato','id_df',$iddf);
if($idd) {
	$idp=$dD['pac_cod'];
	$idc=$dD['con_num'];
}
$dP=detRow('db_pacientes','pac_cod',$idp);
$dC=detRow('db_consultas','con_num',$idc);
if($dD){
	$acc=md5(UPDd);
	if ($iddf){
		$dD_nom=$dF['nombre'];
		$doc_con=$dF['formato'];
	}else{
		$dD_nom=$dD['nombre'];
		$doc_con=$dD['contenido'];
	}
	$btnAcc='<button type="submit" class="btn btn-success navbar-btn" name="btnA"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	$btnAccP='<button type="submit" class="btn btn-primary navbar-btn" name="btnP"><i class="fas fa-save fa-lg"></i> ACTUALIZAR E IMPRIMIR</button>';
}else{
	$acc=md5(INSd);
	$dD_nom=$dF['nombre'];
	$doc_con=$dF['formato'];
	
	$dat[pac]=$dP;
	$dat[con]=$dC;
	
	$doc_conG=genDoc($iddf,$dat);
	$doc_con=$doc_conG['format'];
	$btnAcc='<button type="submit" class="btn btn-info navbar-btn" name="btnA"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
	$btnAccP='<button type="submit" class="btn btn-primary navbar-btn" name="btnP"><i class="fas fa-save fa-lg"></i> GUARDAR E IMPRIMIR</button>';
}
$NE=new EnLetras();
$NumD=$NE->ValorEnLetras(date('d'),'');
$NumA=$NE->ValorEnLetras(date('Y'),''); ?>
<form action="_acc.php" method="post" enctype="multipart/form-data" style="margin-bottom:0px;">
<fieldset>
	<input name="idd" type="hidden" id="idd" value="<?php echo $idd ?>">
	<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
	<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
	<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
	<input name="form" type="hidden" id="form" value="<?php echo md5(fDocs) ?>">
	<input name="url" type="hidden" value="<?php echo $urlc ?>">
</fieldset>

	<?php
	$contL.='<ul class="nav navbar-nav">
      	<li><a><span class="label label-primary">'.$idd.'</span></a></li>
        <li><a><span class="label label-default">Paciente</span><span class="label label-primary">'.$detpac['pac_nom'].' '.$detpac['pac_ape'].'</span></a></li>
        <li><a><span class="label label-default">Consulta</span><span class="label label-primary">'.$idc.'</span></a></li>
        <li><a>'.$dD[fecha].'</a></li>
    </ul>';
	echo genPageHeader($dM['mod_cod'],'navbar',null,null,null,null,null,$contL,$btnAcc.$btnAccP.$btnNew) ?>
	

<?php sLOG(g) ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-8">
    	<fieldset>
    		
    	<?php $doc_con2 = str_replace('{RAIZ}',$RAIZ,$doc_con) ?>
			<textarea name="contenido" style="min-height: 575px" class="tinymce" id="contenido" placeholder="Resultados"><?php echo $doc_con2 ?></textarea>
    </fieldset>
    </div>
    <div class="col-sm-4">
    
    
    
		<div class="well well-sm">
    <fieldset class="form-horizontal">
        <div class="form-group">
        	<label for="fecha" class="control-label col-sm-3">Fecha Creación</label>
			<div class="col-sm-9"><span class="label label-default"><?php echo $dD[fecha] ?></span></div>
        </div>
        <div class="form-group">
            <label for="nombre" class="control-label col-sm-3">Nombre</label>
            <div class="col-sm-9"><input name="nombre" type="text" class="form-control" id="nombre" placeholder="Descripcion" value="<?php echo $dD_nom ?>"></div>
        </div>
	</fieldset>
    </div>
    <div class="panel panel-primary">
    	<div class="panel-heading"><h4 class="panel-title">Dias de Reposo</h4></div>
    	<div class="panel-body">
    		<fieldset class="form-horizontal">
    		<div class="form-group">
    			<label for="" class="control-label col-sm-2">Inicio del Reposo</label>
    			<div class="col-sm-10">
    				<input type="date" class="form-control" id="dpFec" value="<?php echo $sdate ?>">
    			</div>
    		</div>
			<div class="form-group">
    			<label for="" class="control-label col-sm-2">Dias de Reposo</label>
    			<div class="col-sm-10">
    				<input type="number" class="form-control input-lg" id="dpDia" value="1">
    			</div>
    		</div>
			<div class="form-group cero">
				<div class="col-sm-10 col-sm-offset-2"><a href="javascript:;" onClick="genDias()" class="btn btn-info btn-sm btn-block">Generar Dias Reposo</a></div>
			</div>
			
			</fieldset>
    	</div>
    </div>
	<div class="well well-sm text-center">
		<div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Fechas / Horas <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo strftime("%A %d de %B del %Y") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> <?php echo strftime("%A %d de %B del %Y") ?></a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo strftime("a los ".$NumD." dias del mes de %B de ".$NumA."") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> Fecha en letras</a></li>
            <li class="divider"></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo date("h:i:s") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> Hora /12</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo date("H:i:s") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> Hora /24</a></li>
		</ul>
		</div>
        <div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Paciente <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac_nom ?>');return false;">Nombre Paciente</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac['pac_ced'] ?>');return false;">Cedula</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo edad($detpac['pac_fec'])?>');return false;">Edad</a></li>
		</ul>
		</div>
        <div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Consulta <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<!--<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detDD_nom ?>');return false;">Diagnostico Definitivo</a></li>
            <li class="divider"></li>-->
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('Ricardo Ordoñez V.');return false;">Ricardo Ordoñez V.</a></li>
		</ul>
		</div>
    </div>
    <div class="well well-sm text-center">
    	<div class="btn-group">
  <a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Cambiar a <span class="caret"></span></a>
  <ul class="dropdown-menu">
		<?php
		//
		$qrydf='SELECT * FROM  db_documentos_formato ORDER BY nombre ASC';
		$RSdf=mysql_query($qrydf);
		$row_RSdf=mysql_fetch_assoc($RSdf);
		$tr_RSdf=mysql_num_rows($RSdf);
		//
		?>
	  <?php do{?>
        <li><a href="<?php echo $RAIZc ?>com_docs/documentoForm.php?idd=<?php echo $idd ?>&iddf=<?php echo $row_RSdf['id_df'] ?>&idp=<?php echo $idp ?>&idc=<?php echo $idc?>&action=NEW"><i class="icon-file"></i> <small>Cambiar a</small> <?php echo $row_RSdf['nombre'] ?></a></li>
	<?php }while ($row_RSdf = mysql_fetch_assoc($RSdf)); ?>  

  </ul>
</div>
    </div>
    </div>
</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
   async: false
 });
});
function genDias(){
	
	var dpFec=$('#dpFec').val();
	var dpDia=$('#dpDia').val();
	
	$.getJSON( "json.getDate.php?rFec="+dpFec+"&rDia="+dpDia, function( data ) {
		$.each( data, function( key, val ) {
			tinymce.activeEditor.insertContent(val.val);
  		});
	});
}
</script>