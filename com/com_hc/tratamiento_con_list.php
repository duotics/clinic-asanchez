<?php 
$qryConLst=sprintf('SELECT * FROM db_tratamientos WHERE con_num=%s OR pac_cod=%s ORDER BY tid DESC',
GetSQLValueString($id_cons,'int'),
GetSQLValueString($id_pac,'int'));
$RSt=mysql_query($qryConLst);
$row_RSt=mysql_fetch_assoc($RSt);
$tr_RSt=mysql_num_rows($RSt);
?>

<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-columns fa-lg"></i> TRATAMIENTOS
    <a href="<?php echo $RAIZc ?>com_hc/tratamiento_form.php?idp=<?php echo $id_pac ?>&idc=<?php echo $id_cons ?>" class="btn btn-default btn-xs fancybox.iframe fancyreload"> <i class="fas fa-plus-square fa-lg"></i> NUEVO </a>
    
  </div>
  <div class="panel-body">
    <?php if ($tr_RSt>0){?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha</th>
		<th style="width:50%">Detalle Tratamiento</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
	$qrytl='SELECT * FROM db_tratamientos_detalle WHERE tid='.$row_RSt['tid'].' ORDER BY id ASC';
		$RStl=mysql_query($qrytl);
		$row_RStl=mysql_fetch_assoc($RStl);
		$tr_RStl=mysql_num_rows($RStl);
		if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}
	?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $row_RSt['tid'] ?></td>
			<td><?php echo $row_RSt['fecha'] ?></td>
			<td>
            <?php if ($tr_RStl>0){?>
			<table class="table table-condensed table-bordered" style="font-size:0.8em; margin-bottom:0px;">
			<thead><tr><th>Medicamento</th>
            <th>Presentacion</th>
            <th>Cantidad</th>
            <th>Indicaciones</th></tr></thead>
			<tbody>
			<?php do{?>
            <?php $detTdet_med=$row_RStl['generico'].' ( '.$row_RStl['comercial'].' )'; ?>
			<tr><td><?php echo $detTdet_med ?></td>
            <td><?php echo $row_RStl['presentacion'] ?></td>
            <td><?php echo $row_RStl['cantidad'] ?></td>
            <td><?php echo $row_RStl['descripcion'] ?></td></tr>
			<?php }while ($row_RStl = mysql_fetch_assoc($RStl));?>
            </tbody></table>
			<?php }else echo '<div>No hay Medicamentos Prescritos</div>'?>
            </td>
            <td><div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_hc/tratamiento_form.php?idt=<?php echo $row_RSt['tid'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fas fa-edit fa-lg"></i> Modificar</a>
            <a href="<?php echo $RAIZc; ?>com_hc/receta_print.php?idt=<?php echo $row_RSt['tid'] ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
            <i class="fas fa-print fa-lg"></i> Imprimir</a>
            <a href="<?php echo $RAIZc; ?>com_hc/tratamiento_form.php?idt=<?php echo $row_RSt['tid'] ?>&action=DELTF" class="btn btn-danger btn-xs fancybox fancybox.iframe">
            <i class="fas fa-trash fa-lg"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($row_RSt = mysql_fetch_assoc($RSt));?>
        </tbody>
        </table>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSt ?></div>
</div>
<?php mysql_free_result($RSt); ?>