<?php require('../../init.php');
$LOG='';
//INSERT NEW
if(((isset($_GET['action']) ? $_GET['action'] : NULL))&&((isset($_GET['action']) ? $_GET['action'] : NULL)=='DEL')){
	$idh=(isset($_GET['idh']) ? $_GET['idh'] : NULL);
	$id=(isset($_GET['id']) ? $_GET['id'] : NULL);
	$qryDEL='DELETE FROM `db_signos` WHERE id='.$idh;
	if(@mysql_query($qryDEL)) $LOG.="Eliminado Correctamente:: ID = ".$idh;
	else $LOG.='<b>No se pudo Eliminar</b>';
	header("Location: ".$urlcurrent.'?id='.$id); 
}
if(((isset($_POST['form']) ? $_POST['form'] : NULL))&&((isset($_POST['form']) ? $_POST['form'] : NULL)=='hispac')){
	$id=(isset($_POST['id']) ? $_POST['id'] : NULL);
	$fecha=(isset($_POST['hfecha']) ? $_POST['hfecha'] : NULL);
	$peso=(isset($_POST['hpeso']) ? $_POST['hpeso'] : NULL);
	$paS=(isset($_POST['hpas']) ? $_POST['hpas'] : NULL);
	$paD=(isset($_POST['hpad']) ? $_POST['hpad'] : NULL);
	$talla=(isset($_POST['htalla']) ? $_POST['htalla'] : NULL);
	$temp=(isset($_POST['htemp']) ? $_POST['htemp'] : NULL);
	$fc=(isset($_POST['hfc']) ? $_POST['hfc'] : NULL);
	$fr=(isset($_POST['hfr']) ? $_POST['hfr'] : NULL);
	$sao2=(isset($_POST['hsao2']) ? $_POST['hsao2'] : NULL);
	
	$insertSQL = sprintf("INSERT INTO `db_signos`
	(`pac_cod`,`fecha`,`peso`,`paS`,`paD`,`talla`,`temp`,`fc`,`fr`,`SaO2`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
		GetSQLValueString($id, "int"),
		GetSQLValueString($fecha, "date"),
		GetSQLValueString($peso, "double"),
		GetSQLValueString($paS, "text"),
		GetSQLValueString($paD, "text"),
		GetSQLValueString($talla, "int"),
		GetSQLValueString($temp, "text"),
		GetSQLValueString($fc, "int"),
		GetSQLValueString($fr, "int"),
		GetSQLValueString($sao2, "int"));
	$ResultInsert = mysql_query($insertSQL) or die(mysql_error());
	header("Location: ".$urlcurrent.'?id='.$id);
}

$id=vParam('id', isset($_GET['id']) ? $_GET['id'] : NULL, isset($_POST['id']) ? $_POST['id'] : NULL);
$detpac=dataPac($id);
$qry='SELECT * FROM db_signos WHERE pac_cod='.$id.' ORDER BY id DESC';
$RSh=mysql_query($qry);
$row_RSh=mysql_fetch_assoc($RSh);
$tr_RSh=mysql_num_rows($RSh);
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container">
	<div class="page-header">
    <h2><?php echo $detpac['pac_nom'].' '.$detpac['pac_ape'] ?> <small>Registro Signos Vitales</small></h2>
    </div>
    <div class="row">
    <div class="col-md-4">
    <div class="well well-sm">
	<form method="post" action="<?php echo $urlcurrent; ?>" class="form-inline">
      <input name="hfecha" type="date" class="input-medium" id="hfecha" placeholder="Fecha" value="<?php echo date('Y-m-d') ?>" autofocus>
	  <input name="hpeso" type="number" class="input-small" id="hpeso" placeholder="Peso en Kg.">
		<input name="hpas" type="text" class="input-small" id="hpas" placeholder="TA Sistolica">
        <input name="hpad" type="text" class="input-small" id="hpad" placeholder="TA Diastólica">
		<input name="htalla" type="number" class="input-small" id="htalla" placeholder="Talla cm.">
        <input name="htemp" type="number" step="0.1" class="input-small" id="htemp" placeholder="Temperatura">
        <input name="hfc" type="number" class="input-small" id="hfc" placeholder="F. Cardiaca">
        <input name="hfr" type="number" class="input-small" id="hfr" placeholder="F. Respiratoria">
        <input name="hsao2" type="number" class="input-small" id="hsao2" placeholder="Saturacion O2">
		<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
        <input name="form" type="hidden" id="form" value="hispac">
		<button type="submit" class="btn btn-primary">Guardar</button>
	</form>
    </div>
    </div>
	<div class="col-md-8">
<?php if ($tr_RSh>0){ ?>
	  <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
        	<th>ID</th>
            <th>Fecha</th>
            <th>Peso</th>
            <th>Talla</th>
			<th>PA</th>
            <th><abbr title="Temperatura">Temp</abbr></th>
            <th><abbr title="Frecuencia Cardiaca">F.C</abbr></th>
            <th><abbr title="Frecuencia Respiratoria">F.R</abbr> <a href="grafico.php?id=<?php echo $id ?>&val=CO2" rel="shadowbox" class="btn btn-mini"><i class="icon-signal"></i></a></th>
            <th><abbr title="Saturación de Oxigeno">SaO2 <a href="grafico.php?id=<?php echo $id ?>&val=SaO2" rel="shadowbox" class="btn btn-mini"><i class="icon-signal"></i></a></abbr></th>
            <th>IMC</th>
            <th></th>
		</tr>
        </thead>
        <tbody>
        <?php do{
		$pesoKG=$row_RSh['peso'].' Kg.';
		$pesoLB=round($row_RSh['peso']*2.20462262, 2);
		$pesoLB.=' Lb.';
		$tallaCM=$row_RSh['talla'].' Cm.';
		$tallaM=$row_RSh['talla']/100;
		$tallaPL=round($row_RSh['talla']/2.54, 2);
		$tallaPL.=' "';
		if(($pesoKG>0)&&($tallaM>0)){
        	$IMC=number_format(($pesoKG/($tallaM*$tallaM)), 2);
		}
         ?>
        <tr>
			<td><?php echo $row_RSh['id'] ?></td>
			<td><?php echo $row_RSh['fecha'] ?></td>
			<td><?php echo $pesoKG.' / '.$pesoLB?></td>
			<td><?php echo $tallaCM.' / '.$tallaPL?></td>
			<td><?php echo $row_RSh['paS'].'/'.$row_RSh['paD'] ?></td>
            <td><?php echo $row_RSh['temp'] ?> °C</td>
            <td><?php echo $row_RSh['fc'] ?></td>
            <td><?php echo $row_RSh['fr'] ?></td>
            <td><?php echo $row_RSh['SaO2'] ?></td>
            <td><?php echo $IMC ?></td>
			<td><a href="<?php echo $urlcurrent; ?>?id=<?php echo $id ?>&idh=<?php echo $row_RSh['id'] ?>&action=DEL" class="btn"><i class="icon-trash"></i></a></td>
        </tr>
        <?php } while ($row_RSh = mysql_fetch_assoc($RSh));
		$rows = mysql_num_rows($RSh);
		if($rows > 0) {
			mysql_data_seek($RSh, 0);
			$row_RSh = mysql_fetch_assoc($RSh);
		}?>
        </tbody>
        </table>
<?php }else{
	echo '<div class="alert"><h4>No Existen Registros para este Paciente</h4></div>';
}?>
</div>
	</div>
</div>
</body>
</html>