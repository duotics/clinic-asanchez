<?php require('../../init.php');
$idpac=vParam('idpac', $_GET['idpac'], $_POST['idpac']);
$idcon=vParam('idcon', $_GET['idcon'], $_POST['idcon']);
$detpac=dataPac($idpac);
$detcon=fnc_datacons($id_cons_det, $id_pac_det);


include(RAIZf.'head.php');
?>
<body class="cero">
<form>
<div class="container">
	<div class="page-header">
    <input name="idpac" type="hidden" id="idpac" value="<?php echo $idpac ?>">
	<input name="idcon" type="hidden" id="idcon" value="<?php echo $idcon ?>">
    <h1>Modificar Receta <small>Paciente: <strong><?php echo $detpac['pac_nom'].' '.$detpac['pac_ape'] ?></strong> - Consulta <strong><?php echo $idcon ?></strong></small></h1></div>
    <div class="well">

    	<legend>Fecha: <?php echo date('d F Y'); ?></legend>
          <div class="row-fluid">
          	<div class="span6"><label>Descripción.</label>
            <textarea rows="4" class="input-block-level"></textarea></div>
            <div class="span6"><label>Instrucciones.</label>
            <textarea rows="4" class="input-block-level"></textarea></div>
          </div>
          
          <div class="form-actions">
          
          <div class="btn-group">
    <input name="btns" type="submit" class="btn btn-large btn-primary" id="btns" value="Guardar Receta">
    <input name="btns" type="submit" class="btn btn-large btn-info" id="btns" value="Imprimir">
    <input name="btns" type="button" class="btn btn-large" id="btns" value="Salir" onClick="parent.Shadowbox.close();">  
    </div>
</div>
          
            
    </div>
</div>
</form>
</body>
</html>