<?php //DET GINECOLOGIA
$qryG=sprintf('SELECT * FROM db_pacientes_gin WHERE pac_cod=%s',
GetSQLValueString($id_pac,'int'));
$RSg=mysql_query($qryG);
$row_RSg=mysql_fetch_assoc($RSg);
$tr_RSg=mysql_num_rows($RSg);
?>
<legend>Ginecologia</legend>
<div class="row">
		<div class="col-md-5">
    	<div class="well well-sm" style="background:#FFF;">
			<fieldset class="form-horizontal">
            <div class="form-group">
            	<label for="gin_men" class="col-md-4 control-label">Menarca</label>
                <div class="col-md-8">
      				<input name="gin_men" type="text" class="form-control" id="gin_men" value="<?php echo $row_RSg['gin_men'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
   				</div>            	
			</div>			
			<div class="form-group">
            	<label for="gin_mes" class="col-md-4 control-label">Menopausia</label>
                <div class="col-md-8">
  					<input name="gin_mes" type="text" class="form-control" id="gin_mes"  value="<?php echo $row_RSg['gin_mes'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
             	</div>
			</div>
            <div class="form-group">
            	<label for="gin_fun" class="col-md-4 control-label">FUM</label>
                <div class="col-md-8">
  					<input name="gin_fun" type="date" class="form-control" id="gin_fun" value="<?php echo $row_RSg['gin_fun'] ?>" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
               	</div>
			</div>
            <div class="form-group">
            	<label for="gin_cicm" class="col-md-4 control-label">CM</label>
                <div class="col-md-8">
  					<input name="gin_cicm" type="text" class="form-control" id="gin_cicm" value="<?php echo $row_RSg['gin_cicm'] ?>" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
               	</div>
			</div>
            </fieldset>
		</div>
    </div>
    	<div class="col-md-4">  
	<div class="well well-sm" style="background:#FFF;">
        <fieldset class="form-horizontal">
            <div class="form-group">
            	<label class="col-md-4 control-label">Gestaciones</label>
                <div class="col-md-8">
      				<input name="gin_ges" type="text" class="form-control" id="gin_ges" value="<?php echo $row_RSg['gin_ges'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
   				</div>            	
			</div>
            </fieldset>
        <div class="well well-sm">
        
        <div class="row">    
    		<div class="col-md-4">
  				<a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Partos normales">Vaginal</a>
  				<input name="gin_pnor" type="text" class="form-control" id="gin_pnor" value="<?php echo $row_RSg['gin_pnor'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
			</div>
			<div class="col-md-4">
  				<a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Cesareas Realizadas">Cesareas</a>
  				<input name="gin_pces" type="text" class="form-control" id="gin_pces" value="<?php echo $row_RSg['gin_pces'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
			</div>
			<div class="col-md-4">
  				<a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Cantidad de Abortos">Abortos</a>
  				<input name="gin_abo" type="text" class="form-control" id="gin_abo" value="<?php echo $row_RSg['gin_abo'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
			</div>    
    	</div>
    	</div>
        <div class="well well-sm">
        <div class="row">    
    		<div class="col-md-6">
  				<a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Hijos vivos">Vivos</a>
  				<input name="gin_hviv" type="text" class="form-control" id="gin_hviv" value="<?php echo $row_RSg['gin_hviv'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
			</div>   
    		<div class="col-md-6">
  				<a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Hijos muertos">Muertos</a>
  				<input name="gin_hmue" type="text" class="form-control" id="gin_hmue" value="<?php echo $row_RSg['gin_hmue'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"/>
			</div>    
    	</div>
		</div>
        <div style="clear:both"></div>
    </div>
    </div>
    	<div class="col-md-3">
    	<div class="well well-sm" style="background:#FFF">
        <label>Observaciones</label>
            <textarea name="gin_obs" rows="11" class="form-control" id="gin_obs" onKeyUp="setDB(this.name,this.value,<?php echo $row_RSg['gin_id'] ?>,'gin')"><?php echo $row_RSg['gin_obs'] ?></textarea>
        </div>
    </div>
		</div>