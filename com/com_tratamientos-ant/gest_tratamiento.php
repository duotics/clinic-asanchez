<?php require('../../init.php');
$dM=vLogin('TERTRAT');
$id=vParam('id',$_GET['id'],$_POST['id']);
$dT=detRow('db_terapiastrata','id_trat',$id);
if($dT){
	$acc='UPD';
	$btnAcc='<button type="submit" class="btn btn-success btn-large"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
}else{
	$acc='INS';
	$btnAcc='<button type="submit" class="btn btn-primary btn-large"><i class="fas fa-save fa-lg"></i> CREAR</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default navbar-btn"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';
$qry='SELECT * FROM db_terapiastrata ORDER BY id_trat DESC';
$RSd=mysql_query($qry);
$row_RSd=mysql_fetch_assoc($RSd);
$tr_RSd=mysql_num_rows($RSd);
include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php sLOG('g'); ?>
    <?php echo genPageHead($dM['mod_cod']) ?>
	<div class="well well-sm">
	<form method="post" action="tratamiento_save.php" role="form">
    <fieldset class="form-inline">
        <input name="form" type="hidden" value="fTtrat">
        <input name="id" type="hidden" value="<?php echo $id?>">
        <input name="acc" type="hidden" value="<?php echo $acc?>">
		<div class="form-group">
        <label for="generico" class="">Nombre</label>
		<input name="nom_trat" type="text" class="form-control" id="nom_trat"  value="<?php echo $dT['nom_trat'] ?>" required>
        </div>
        <div class="form-group">
        <label for="descripcion" class="">Observacion</label>
        <textarea name="des_trat" rows="2" class="form-control" id="des_trat"><?php echo $dT['obs_trat'] ?></textarea>
        </div>
       	<?php echo $btnAcc ?>
    	<?php echo $btnNew ?>
    </fieldset>
	</form>
	</div>
<?php if ($tr_RSd>0){ ?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Observacion</th>                       			
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
		<tr>
			<td><?php echo $row_RSd['id_trat'] ?></td>
			<td><?php echo $row_RSd['nom_trat'] ?></td>
			<td><?php echo $row_RSd['obs_trat']?></td>                   			
			<td>
				<a href="<?php echo $_SESSION['urlc'] ?>?id=<?php echo $row_RSd['id_trat'] ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i> Modificar</a>
				<a href="tratamiento_save.php?id=<?php echo $row_RSd['id_trat'] ?>&acc=DEL" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
			</td>
		</tr>
	<?php } while ($row_RSd = mysql_fetch_assoc($RSd));?>
	</tbody>
	</table>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Terapias Generadas</h4></div>'; }?>
</div>
<?php include(RAIZf.'footer.php') ?>