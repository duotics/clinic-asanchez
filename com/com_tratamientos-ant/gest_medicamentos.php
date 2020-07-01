<?php require('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$detMed=detRow('db_medicamentos','id_form',$id);
if($detMed){
	$id=$detMed['id_form'];
	$acc=md5('UPDm');
	$btn_action='<button type="submit" class="btn btn-success btn-large"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else{
	$acc=md5('INSm');
	$btn_action='<button type="submit" class="btn btn-primary btn-large"><i class="fas fa-save fa-lg"></i> CREAR</button>';
}
$TR=totRowsTab('db_medicamentos');
if ($TR>0) {
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qry='SELECT * FROM db_medicamentos ORDER BY id_form DESC';
	$RS = mysql_query($qry.$pages->limit) or die(mysql_error());
	$dRS = mysql_fetch_assoc($RS);
	$tRS = mysql_num_rows($RS);
}

include(RAIZf.'head.php');
?>
<body class="cero">
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Medicamentos</a>
    </div>
  </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid">
	<?php sLOG('g'); ?>
	<div class="well well-sm">
	<form method="post" action="actions.php" role="form">
    <fieldset>
        <input name="form" type="hidden" id="form" value="fmed">
        <input name="id" type="hidden" id="id" value="<?php echo $id?>">
        <input name="acc" type="hidden" id="acc" value="<?php echo $acc?>">
        <input name="url" type="hidden" id="acc" value="<?php echo urlc?>">
    </fieldset>
    <div class="row">
    <div class="col-sm-6"><fieldset class="form-horizontal">
    <div class="form-group">
    	<label for="generico" class="col-sm-2 control-label">Medicamento</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-6">
            <input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detMed['generico'] ?>" required></div>
			<div class="col-sm-6">
            <input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detMed['comercial'] ?>"></div>
		</div>
	</div>
	</div>
	<div class="form-group">
    	<label for="presentacion" class="col-sm-2 control-label">Información</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-8"><input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detMed['presentacion'] ?>"></div>
			<div class="col-sm-4"><input name="cantidad" type="number" class="form-control" id="cantidad" placeholder="Cantidad" value="<?php echo $detMed['cantidad'] ?>"></div>
		</div>
    </div>
	</div>
    </fieldset></div>
    <div class="col-sm-3"><fieldset class="form-horizontal">
    
    <div class="form-group">
    	<label for="descripcion" class="col-sm-2 control-label">RP.</label>
    	<div class="col-sm-10">
    	<textarea name="descripcion" rows="3" class="form-control" id="descripcion"><?php echo $detMed['descripcion'] ?></textarea>
    	</div>
	</div>
    </fieldset></div>
    <div class="col-sm-3"><fieldset class="form-horizontal">
    <div class="form-group">
    	<label for="" class="col-sm-2 control-label"></label>
    	<div class="col-sm-10">
    	<?php echo $btn_action ?>
    	<a href="<?php echo $_SESSION['urlc']?>" class="btn btn-default navbar-btn"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>
    	</div>
	</div>
    </fieldset></div>
    </div>
            
	</form>
	</div>
<?php if ($TR>0){ ?>
	<div class="well well-sm">
    <div class="row">
    	<div class="col-md-3">
    	<span class="btn btn-default btn-xs disabled"><strong>Total Registros</strong> <?php echo $TR ?></span>
		</div>
    	<div class="col-md-5">
			<ul class="pagination" style="margin:2px;"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
    </div>
    
	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>ID</th>
			<th>Generico</th>
			<th>Comercial</th>
            <th>Presentacion</th>
            <th>Cantidad</th>
            <th style="width:35%">Prescripción</th>
			<th><abbr title="Consultas relacionadas">Recetas</abbr></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
		<tr>
			<td><?php echo $dRS['id_form'] ?></td>
			<td><?php echo $dRS['generico'] ?></td>
			<td><?php echo $dRS['comercial']?></td>
            <td><?php echo $dRS['presentacion']?></td>
            <td><?php echo $dRS['cantidad']?></td>
            <td><?php echo $dRS['descripcion']?></td>
			<td><?php echo totRowsTab('db_tratamientos_detalle','id_form',$dRS['id_form']) ?></td>
			<td>
				<a href="<?php echo $_SESSION['urlc'] ?>?id=<?php echo $dRS['id_form'] ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i> Modificar</a>
				<a href="actions.php?id=<?php echo $dRS['id_form'] ?>&acc=<?php echo md5('DELm')?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
			</td>
		</tr>
	<?php } while ($dRS = mysql_fetch_assoc($RS));?>
	</tbody>
	</table>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Medicamentos Generados</h4></div>'; }?>
</div>
</body>
</html>