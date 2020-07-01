<?php 
$qryConLst=sprintf('SELECT * FROM db_tratamientos WHERE con_num=%s OR pac_cod=%s ORDER BY tid DESC',
SSQL($idc,'int'),
SSQL($idp,'int'));
$RSt=mysql_query($qryConLst);
$dRSt=mysql_fetch_assoc($RSt);
$tr_RSt=mysql_num_rows($RSt);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-columns fa-lg"></i> RECETAS
    <a href="<?php echo $RAIZc ?>com_tratamientos/tratamientoForm.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>&acc=<?php echo md5(NEWt) ?>" class="btn btn-default btn-xs fancybox.iframe fancyreload"> <i class="fas fa-plus-square fa-lg"></i> NUEVA RECETA </a>
    
  </div>
  <div class="panel-body">
    <?php if ($tr_RSt>0){?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha</th>
		<th>Diagnóstico</th>
		<th style="width:50%">Detalle Tratamiento</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
	$qrytl='SELECT * FROM db_tratamientos_detalle WHERE tid='.$dRSt['tid'].' AND tip="M" ORDER BY id ASC';
		$RStl=mysql_query($qrytl);
		$dRStl=mysql_fetch_assoc($RStl);
		$tr_RStl=mysql_num_rows($RStl);
	
	$qrytli='SELECT * FROM db_tratamientos_detalle WHERE tid='.$dRSt['tid'].' AND tip="I" ORDER BY id ASC';
		$RStli=mysql_query($qrytli);
		$dRStli=mysql_fetch_assoc($RStli);
		$tr_RStli=mysql_num_rows($RStli);
	
		//if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}
	
		if($dRSt['con_num']==$idc) $css['tr']='info';
		else $css['tr']='';
	?>
	<tr class="<?php echo $css['tr'] ?>">
        	<td><?php echo $dRSt['tid'] ?></td>
			<td><?php echo $dRSt['fecha'] ?></td>
			<td><?php echo $dRSt['diagnostico'] ?></td>
			<td>
           
            <div class="row">
            	<div class="col-sm-6">
            		
            		<?php if ($tr_RStl>0){?>
			<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
			<thead><tr>
           		<th width="90%">Medicamento</th>
           		<th width="10%">Cantidad</th>
            	<!--<th>Presentacion</th>
            	<th>Cantidad</th>
            	<th>Indicaciones</th>
            	-->
            </tr></thead>
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
            		
            	</div>
            	<div class="col-sm-6">
            		
            		<?php if ($tr_RStli>0){?>
			<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
			<thead><tr>
           		<th>Instrucciones</th>
            	<!--<th>Presentacion</th>
            	<th>Cantidad</th>
            	<th>Indicaciones</th>
            	-->
            </tr></thead>
			<tbody>
			<?php do{?>
            <?php //$detTdet_med=$dRStl['generico'].' ( '.$dRStl['comercial'].' )'; ?>
			<tr><td><?php echo $dRStli['indicacion'] ?></td>
           
           <?php }while ($dRStli = mysql_fetch_assoc($RStli));?>
            </tbody></table>
			<?php }else echo '<div>No hay Indicaciones</div>'?>
            		
            	</div>
            </div>
           
            </td>
            <td><div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_tratamientos/tratamientoForm.php?idt=<?php echo $dRSt['tid'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fas fa-edit fa-lg"></i> Modificar</a>
            <!--
            <a href="<?php echo $RAIZc; ?>com_tratamientos/receta_print.php?idt=<?php echo $dRSt['tid'] ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
            <i class="fas fa-print fa-lg"></i> Imprimir</a>
            -->
            <a class="printerButton btn btn-default btn-xs" data-id="<?php echo $dRSt['tid'] ?>" data-rel="<?php echo $RAIZc ?>com_tratamientos/recetaPrintJS.php">
            <i class="fas fa-print fa-lg"></i> Imprimir</a>
            
            <a href="<?php echo $RAIZc; ?>com_tratamientos/tratamientoForm.php?idt=<?php echo $dRSt['tid'] ?>&acc=<?php echo md5(DELtf) ?>" class="btn btn-danger btn-xs fancybox fancybox.iframe">
            <i class="fas fa-trash fa-lg"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($dRSt = mysql_fetch_assoc($RSt));?>
        </tbody>
        </table>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSt ?></div>
</div>
<?php mysql_free_result($RSt); ?>