<?php
$sbr=vParam('sBr', $_GET['sBr'], $_POST['sBr'],FALSE);
$qry=genCadSearchPac($sbr);
$RSpt = mysql_query($qry) or die(mysql_error());
$dRSpt = mysql_fetch_assoc($RSpt);
$tRSpt = mysql_num_rows($RSpt);
if ($tRSpt>0){
	$pages = new Paginator;
	$pages->items_total = $tRSpt;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSp = mysql_query($qry.$pages->limit) or die(mysql_error());
	$dRSp = mysql_fetch_assoc($RSp);
	$tRSp = mysql_num_rows($RSp);
?>
<?php if($sbr){ ?>
<div class="alert alert-info alert-dismissable" id="log">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Mostrando Su Busqueda: <strong>"<?php echo $sbr ?>"</strong>
</div>
<?php } ?>
<table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
    	<th></th>
		<th><abbr title="Historia Clinica">H.C.</abbr></th>
    	<th>Nombres</th>
        <th>Apellidos</th>
		<th>Edad</th>
        <th>Detalle</th>
        <th>Contacto</th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$idp=$dRSp['pac_cod'];
	$dPac=detRow('db_pacientes','pac_cod',$idp);
	$typ_tsan=dTyp($dPac['pac_tipsan']);$typ_tsan=$typ_tsan['typ_val'];
	$typ_eciv=dTyp($dPac['pac_estciv']);$typ_eciv=$typ_eciv['typ_val'];
	$typ_sexo=dTyp($dPac['pac_sexo']);$typ_sexo=$typ_sexo['typ_val'];
	if($typ_sexo=='Masculino') $classsexo=' label-info';
	if($typ_sexo=='Femenino') $classsexo=' label-women';
	?>
    <tr>
    	<td>
        	<?php if ($dM['mod_ref']=="PAC"){ ?>
			<a href="form.php?id=<?php echo $idp ?>" title="Modificar Paciente" class="btn btn-primary btn-xs">
           <i class="fas fa-user fa-fw"></i> Ficha</a>
           <?php } ?>
           <?php if ($dM['mod_ref']=="CON"){ ?>
           <a href="<?php echo $RAIZc ?>com_consultas/form.php?idp=<?php echo $idp?>" class="btn btn-primary btn-xs">
           <i class="fas fa-stethoscope"></i> Consulta</a>
           <a href="<?php echo $RAIZc ?>com_calendar/reservaForm.php?idp=<?php echo $idp?>" class="btn btn-default btn-xs fancyR" data-type="iframe">
           <i class="fas fa-calendar"></i> Reserva</a>
           <?php } ?>
        </td>
		<td><?php echo $idp ?></td>
		<td><?php echo strtoupper($dRSp['pac_nom'])?></td>
		<td><?php echo strtoupper($dRSp['pac_ape'])?></td>
        
		<td><?php echo edad($dRSp['pac_fec']) ?></td>
        <td>
        <?php //echo "***".$typ_sexo ?>
        <small>
		<?php
		if ($typ_sexo) echo '<span class="label '.$classsexo.'">'.$typ_sexo.'</span> ';
		if ($typ_eciv) echo '<span class="badge">'.$typ_eciv.'</span> ';
		if ($typ_tsan) echo '<span class="badge">'.$typ_tsan.'</span> ';
		?>
		</small></td>
        <td><?php
		if ($dPac['pac_lugr']) echo '<abbr title="'.$dPac['pac_lugr'].'"><i class="fas fa-map-marker fa-lg fa-fw"></i></abbr> ';
		if ($dPac['pac_tel1']) echo '<abbr title="'.$dPac['pac_tel1'].'"><i class="fas fa-phone fa-lg fa-fw"></i></abbr> ';
		if ($dPac['pac_tel2']) echo '<abbr title="'.$dPac['pac_tel2'].'"><i class="fas fa-phone fa-lg fa-fw"></i></abbr> ';
		if ($dPac['pac_email']) echo '<abbr title="'.$dPac['pac_email'].'"><i class="fas fa-envelope fa-lg fa-fw"></i></abbr> ';
		?></td>
    </tr>
    <?php } while ($dRSp = mysql_fetch_assoc($RSp)); ?>
</tbody>
</table>
<div class="well well-sm">
    <div class="row">
    	<div class="col-md-8">
			<ul class="pagination" style="margin:2px;"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
    </div>
<?php mysql_free_result($RSp);?>
<?php }else{
	echo '<div class="alert alert-info"><h4>Sin Coincidencias de Busqueda</h4></div>';
} ?>