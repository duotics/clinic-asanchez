<?php
$qryRSu = "SELECT * FROM db_user_system 
LEFT JOIN db_empleados ON 	db_user_system.emp_cod = db_empleados.emp_cod";
$RSu = mysql_query($qryRSu) or die(mysql_error());
$dRSu = mysql_fetch_assoc($RSu);
$tRSu = mysql_num_rows($RSu);
?>
<?php if ($tRSu>0) { ?>
<table id="mytable" class="table table-bordered">
<thead>
	<tr>
    	
		<th>ID</th>
    	<th>username</th>
        <th>Nombres</th>
        <th>Estado</th>
        <th>Permisos</th>
        <th></th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <?php
	$btnStat=fncStat('actions.php',array("id"=>$dRSu['user_cod'], "val"=>$dRSu['user_status'],"acc"=>md5('STAT'),"url"=>$_SESSION['urlc']));?>
    <tr>
		<td><?php echo $dRSu['user_cod'] ?></td>
		<td><?php echo $dRSu['user_username'] ?></td>
		<td><?php echo $dRSu['emp_nom'].' '.$dRSu['emp_ape'] ?></td>
        <td class="texgt-center"><?php echo $btnStat ?></td>
        <td class="text-center"><a href="menus_permiso.php?id=<?php echo $dRSu['user_cod']; ?>" class="btn btn-info btn-xs fancyR" data-type="iframe">
        <i class="fa fa-edit fa-lg"></i> Permisos</a></td>
		<td class="text-center">
		<div class="btn-group">
        <a href="form.php?id=<?php echo $dRSu['user_cod'] ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-lg"></i> Editar</a>
		<a href="#" class="btn btn-danger btn-xs"><i class="fas fa-trash fa-lg"></i> Eliminar</a>
        </div>
		</td>
    </tr>
    <?php } while ($dRSu = mysql_fetch_assoc($RSu)); ?>    
</tbody>
</table>

<?php }else{ ?>
<div class="alert alert-warning"><h4>No Existen Usuarios</h4></div>
<?php }
mysql_free_result($RSu);
?>