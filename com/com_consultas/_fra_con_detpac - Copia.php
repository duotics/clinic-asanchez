<?php
$detPac_fullnom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
$detPac_ced=$detPac['pac_ced'];
$detPac_edad=edad($detPac['pac_fec']);
$detPac_edadpar=edad($detPac['pac_fecpar']);
$typ_tsan=fnc_datatyp($detPac['pac_tipsan']);
$typ_tsanpar=fnc_datatyp($detPac['pac_tipsanpar']);
$typ_eciv=fnc_datatyp($detPac['pac_estciv']);
$typ_sexo=fnc_datatyp($detPac['pac_sexo']);
$typ_tp=fnc_datatyp($detPac['pac_tipst']);
//Signos Vitales
$detPacSig=detSigLast($id_pac);
$IMC=$detPacSig['imc'];
$IMC=calcIMC(NULL,$detPacSig['peso'],$detPacSig['talla']);
?>
<div class="miniDetPac">
    <table class="table table-condensed">
    <tr>
        <td><label title="ID. <?php echo $detPac['pac_cod']?>" class="tooltips">Paciente</label></td>
        <td style="font-size:16px;">
			<span title="Ver Ficha" class="tooltips"><a href="<?php echo $RAIZc ?>com_pacientes/form.php?id=<?php echo $id_pac ?>"><?php echo $detPac_fullnom ?></a></span>
            <span title="Tipo Paciente" class="label label-default tooltips"><?php echo $typ_tp['typ_val'] ?></span>
            <span title="Nacimiento. <?php echo $detPac['pac_fec']; ?>" class="label label-default tooltips"><?php echo $detPac_edad ?> años</span> 
            <span title="Cédula de Identidad" class="label label-default tooltips"><?php echo $detPac_ced ?></span>
        </td>
    </tr>
    <tr>
        <td><label>Detalles</label></td>
        <td>
        <span title="Tipo Sangre" class="label label-default tooltips"><?php echo $typ_tsan['typ_val'] ?></span> 
        <span title="Estado Civil" class="label label-default tooltips"><?php echo $typ_eciv['typ_val'] ?></span> 
        <span title="Sexo" class="label label-default tooltips"><?php echo $typ_sexo['typ_val'] ?></span> 
		<?php if($detPac['pac_lugp']){ ?>
        <span title="Procedencia" class="label label-default tooltips">
		<i class="fa fa-map-marker"></i> <?php echo $detPac['pac_lugp'] ?></span>
        <?php } ?>
		<?php if($detPac['pac_lugr']){ ?>
        <span title="Residencia. <?php echo $detPac['pac_dir'] ?>" class="label label-default tooltips">
		<i class="fa fa-map-marker"></i> <?php echo $detPac['pac_lugr'] ?></span> 
        <?php } ?>
        <span title="Ocupación" class="label label-default tooltips"><?php echo $detPac['pac_ocu'] ?></span> 
        </td>
    </tr>
    <tr>
        <td><label title="<?php echo $detPacSig['fecha'] ?>" class="tooltips">Signos</label> <a href="<?php echo $RAIZc ?>com_comun/gest_hist.php?id=<?php echo $detPac['pac_cod']; ?>" class="label label-info fancybox fancybox.iframe fancyreload"><i class="fas fa-plus-square fa-lg"></i></a></td>
        <td>
        <span title="Peso" class="badge tooltips"><?php echo $detPacSig['peso'] ?> Kg.</span> 
        <span title="Estatura"  class="badge tooltips"><?php echo $detPacSig['talla'] ?> cm.</span> 
        <span title="IMC" class="badge tooltips"><?php echo $IMC['val'] ?></span><?php echo $IMC['inf'] ?>
        <span title="Presion Arterial"  class="badge tooltips"><?php echo $detPacSig['pa'] ?> p.a.</span> 
        
        <span title="Frecuencia Cardiaca"  class="badge tooltips"><?php echo $detPacSig['fc'] ?> f.c.</span> 
        <span title="Frecuencia Respiratoria" class="badge tooltips"><?php echo $detPacSig['fr'] ?> f.r.</span> 
        <span title="Presion Oxigeno" class="badge tooltips"><?php echo $detPacSig['po2'] ?> po2</span> 
        <span title="CO2" class="badge tooltips"><?php echo $detPacSig['co2'] ?> co2</span> 
        </td>
    </tr>
    </table>
</div>