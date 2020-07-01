<?php
if($detCon['con_fec']){
	$detCon_fec=date("d M Y",strtotime($detCon['con_fec']));
}else{
	$detCon_fec=date("d M Y");
}
?>
<nav class="navbar navbar-inverse" style="margin:0px">
<div class="container-fluid">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-cons-dat">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Fecha</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-cons-dat">
        <ul class="nav navbar-nav">
        	<li style="font-size:120%"><a><abbr title="Actualizada. <?php echo $detCon['con_upd']; ?>">
             <?php echo $detCon_fec ?></abbr></a></li>
             <li><a><abbr title="Porque motivo viene ">
             Tipo Consulta</abbr></a></li>
		</ul>
		<div class="navbar-form navbar-left">
		<div class="form-group">
			<?php generarselect('con_typvis',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPVIS'),$detCon['con_typvis'],'form-control input-sm', ' onChange="setDB(this.name,this.value,'.$id_cons.','."'con'".')"'); ?>
		</div>
		</div>
        <div class="navbar-form navbar-right">
		<div class="form-group">
			<?php generarselect('con_typ',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPCON'),$detCon['con_typ'],'form-control input-sm', ' onChange="setDB(this.name,this.value,'.$id_cons.','."'con'".')"'); ?>
		</div>
        <div class="form-group">
			<input name="con_val" type="text" value="<?php echo $detCon['con_val']; ?>" class="form-control input-sm" placeholder="Valor" onChange="setDB(this.name,this.value,'<?php echo $id_cons ?>','con')"/>
        </div>
        <div class="form-group">
        	<?php generarselect('tip_pag',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPPAG'),$detCon['tip_pag'],'form-control input-sm', ' onChange="setDB(this.name,this.value,'.$id_cons.','."'con'".')"'); ?>        </div>
        
		</div>
        <ul class="nav navbar-nav navbar-right">
        	<li><a><abbr title="Actualizada. ">
             Origen</abbr></a></li>
		</ul>
	</div>
</div>
</nav>