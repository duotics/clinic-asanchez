<?php 
$qry=sprintf('SELECT * FROM db_rep_eco WHERE pac_cod=%s OR con_num=%s ORDER BY id DESC',
GetSQLValueString($id_pac,'int'),
GetSQLValueString($id_cons,'int'));
$RSr=mysql_query($qry);
$row_RSr=mysql_fetch_assoc($RSr);
$tr_RSr=mysql_num_rows($RSr);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-stethoscope fa-lg"></i> REPORTE ECOGRAFICO
    <a href="<?php echo $RAIZc ?>com_reps/eco_form.php?idp=<?php echo $id_pac ?>&idc=<?php echo $id_cons ?>" class="btn btn-default btn-xs fancybox.iframe fancyreload"> <i class="fas fa-plus-square fa-lg"></i> NUEVO </a>
    
  </div>
  <div class="panel-body">
<?php if ($tr_RSr>0){
$classlast=TRUE;
$classtr;
?>
<div>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha Registro</th>
        <th>Fecha Ecografía</th>
        <th>Multimedia</th>
		<th>Responsable</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	
	<tr <?php echo $classtr?>>
        	<td><?php echo $row_RSr['id'] ?></td>
			<td><?php echo $row_RSr['fechar'] ?></td>
            <td><?php echo $row_RSr['fechae'] ?></td>
			<td><?php echo totRowsTab('db_rep_eco_media','id_eco',$row_RSr['id']) ?></td>
            <td></td>
            <td><div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_reps/eco_form.php?idr=<?php echo $row_RSr['id'] ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload fancyfull">
            <i class="fas fa-edit fa-lg"></i> Modificar</a>
            <a href="<?php echo $RAIZc ?>com_reps/eco_print.php?id=<?php echo $row_RSr['id'] ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
            <i class="fas fa-print fa-lg"></i> Imprimir</a>
            <a href="<?php echo $RAIZc ?>com_reps/actions.php?idr=<?php echo $row_RSr['id'] ?>&idc=<?php echo $id_cons ?>&acc=DELRE" class="btn btn-danger btn-xs fancybox fancybox.iframe">
            <i class="fas fa-trash fa-lg"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($row_RSr = mysql_fetch_assoc($RSr));?>
        </tbody>
        </table>
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSr ?></div>
</div>
