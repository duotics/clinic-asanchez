<?php
if($idh){
	$dSig=detRow('db_signos','id',$idh);
}
if($dSig){
	$acc=md5(UPDs);
	$btnAcc='<button type="submit" class="btn btn-success btn-sm btn-block"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else{
	$acc=md5(INSs);
	$btnAcc='<button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
}//END Verifico si manipulo un registro
?>
<form method="post" action="_acc.php">
	<fieldset>
		<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
		<input name="idh" type="hidden" id="idh" value="<?php echo $idh ?>">
		<input name="form" type="hidden" id="form" value="hispac">
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="url" type="hidden" value="<?php echo $urlc ?>">
	</fieldset>
	<div class="row well well-sm">
    	<div class="col-md-10">
        <fieldset class="form-inline">
        <div class="form-group">
        	<span class="help-block"><small>Peso en Kilogramos</small></span>
            <input name="hpeso" type="number" step="any" class="form-control input-sm" placeholder="Peso en Kg." value="<?php echo $dSig[peso] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Talla en centimetros</small></span>
            <input name="htalla" type="number" step="any" class="form-control input-sm" placeholder="Talla en cm." value="<?php echo $dSig[talla] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Índice de Masa Corporal</small></span>
            <input name="himc" type="number" step="any" class="form-control input-sm" placeholder="Indice de Masa Corporal" value="<?php echo $dSig[imc] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Temperatura</small></span>
            <input name="htemp" type="text" class="form-control input-sm" placeholder="0,00" value="<?php echo $dSig[temp] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Presión Arterial</small></span>
            <input name="hpa" type="text" class="form-control input-sm" placeholder="Presion Arterial" value="<?php echo $dSig[pa] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Frecuencia Cardiaca</small></span>
            <input name="hfc" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[fc] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Frecuencia Respiratoria</small></span>
            <input name="hfr" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[fr] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>Saturación de Oxigeno</small></span>
            <input name="hpo2" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[po2] ?>">
        </div>
        <div class="form-group">
        	<span class="help-block"><small>CO2</small></span>
            <input name="hco2" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[co2] ?>">
        </div>
        </fieldset>
        </div>
        <div class="col-md-2"><?php echo $btnAcc ?><?php echo $btnNew ?></div>  
    </div>
</form>