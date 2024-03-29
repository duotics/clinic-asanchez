<?php

function genSelectG($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL){
	//$nom. name selselector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales	
	
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	if (!$nom) $nom="select";		
	echo '<select name="'.$nom.'" id="'.$nom.'" class="'.$class.'" '.$opt.'>';
	echo '<option value=""';	
	if (!(strcmp(-1, $sel))) {echo "selected=\"selected\"";} ?>	
	<?php echo '>- Seleccione -</option>';	
	if ($totalRows_RS_datos>0){	
		$grpSel=NULL; $banG=false;
		do {
			$grpAct=$row_RS_datos['sGRUP'];
			if($grpSel!=$grpAct){		
				if($banG==true) echo '</optgroup>'; 
				echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
				$grpSel=$grpAct;
				$banG=true;
			}
			echo '<option value="'.$row_RS_datos['sID'].'"';	
			if (!(strcmp($row_RS_datos['sID'], $sel))) {echo "selected=\"selected\"";} ?>	
			<?php echo '>'.$row_RS_datos['sVAL'].'</option>';	
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
		if($banG==true) echo '</optgroup>';
	}	
	$rows = mysql_num_rows($RS_datos);	
	if($rows > 0) {	
		mysql_data_seek($RS_datos, 0);	
		$row_RSe = mysql_fetch_assoc($RS_datos);	
	}
	echo '</select>';	
	mysql_free_result($RS_datos);
	
}



function genSelect($nom=NULL, $RS, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni="Select"){
	//Version 3.3.1
	/* PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
	*/
	if($RS){
	$dRS = mysql_fetch_assoc($RS);
	$tRS = mysql_num_rows($RS);
		
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value="'.$valIni.'"';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$nomIni.'</option>';	
	}
	
	if($tRS>0){
	do {
		$grpAct=$dRS['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$dRS['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$dRS['sID'].'"'; 
		if(is_array($sel)){ if(in_array($dRS['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($dRS['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$dRS['sVAL'].'</option>';
	} while ($dRS = mysql_fetch_assoc($RS));
	if($banG==true) echo '</optgroup>';
	$rows = mysql_num_rows($RS);
	if($rows > 0) {
		mysql_data_seek($RS, 0);
		$dRSe = mysql_fetch_assoc($RS);
	}
	}
	echo '</select>';
	
	mysql_free_result($RS);
	}else{
		echo '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
}

function clsRO($val){
			$valFin=eregi_replace("[\n|\r|\n\r]", " ", $val);
			return $valFin;
		}
		function datefRO($val){
			$newDate = date("Y-m-d", strtotime($val));
			return($newDate);
		}

function calcIMC($IMC=NULL, $pesoKG=NULL, $talla=NULL){
	$talla=$talla/100;
	if((!$IMC)||($IMC==NULL)||($IMC==0)){
		if(($talla>0)&&($pesoKG>0)){
			$IMC=$pesoKG / ($talla*$talla);
		}
	}

	if($IMC<=0) $infIMC=' <span class="label label-default"> IMC </span> ';
	if(($IMC>0)&&($IMC<18)){$infIMC='<span class="label label-danger">Peso Bajo</span>';}
	if(($IMC>=18)&&($IMC<25)){$infIMC='<span class="label label-info">Normal</span>';}
	if(($IMC>=25)&&($IMC<30)){$infIMC='<span class="label label-success">Sobrepeso</span>';}
	if(($IMC>=30)&&($IMC<35)){$infIMC='<span class="label label-warning">Obesidad I</span>';}
	if(($IMC>=35)&&($IMC<40)){$infIMC='<span class="label label-warning">Obesidad II</span>';}
	if($IMC>=40){$infIMC='<span class="label label-danger"> Obesidad III</span>';}

	$retIMC['val']=number_format($IMC,2);
	$retIMC['inf']=$infIMC;
	
	return $retIMC;
}

function generarselectG($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL){
	//$nom. name selselector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales	
	
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	if (!$nom) $nom="select";		
	echo '<select name="'.$nom.'" id="'.$nom.'" class="'.$class.'" '.$opt.'>';
	echo '<option value=""';	
	if (!(strcmp(-1, $sel))) {echo "selected=\"selected\"";} ?>	
	<?php echo '>- Seleccione -</option>';	
	if ($totalRows_RS_datos>0){	
		$grpSel=NULL; $banG=false;
		do {
			$grpAct=$row_RS_datos['sGRUP'];
			if($grpSel!=$grpAct){		
				if($banG==true) echo '</optgroup>'; 
				echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
				$grpSel=$grpAct;
				$banG=true;
			}
			echo '<option value="'.$row_RS_datos['sID'].'"';	
			if (!(strcmp($row_RS_datos['sID'], $sel))) {echo "selected=\"selected\"";} ?>	
			<?php echo '>'.$row_RS_datos['sVAL'].'</option>';	
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
		if($banG==true) echo '</optgroup>';
	}	
	$rows = mysql_num_rows($RS_datos);	
	if($rows > 0) {	
		mysql_data_seek($RS_datos, 0);	
		$row_RSe = mysql_fetch_assoc($RS_datos);	
	}
	echo '</select>';	
	mysql_free_result($RS_datos);
	
}


//FUNCTION TO GENERATE SELECT (FORM html)
function generarselect($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE){
	//Version 3.0 (Multiple con soporte choses, selected multiple)
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	if($RS_datos){
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value=""';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>- Seleccione -</option>';	
	}
	
	if($totalRows_RS_datos>0){
	do {
		$grpAct=$row_RS_datos['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$row_RS_datos['sID'].'"'; 
		if(is_array($sel)){ if(in_array($row_RS_datos['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($row_RS_datos['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$row_RS_datos['sVAL'].'</option>';
	} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	if($banG==true) echo '</optgroup>';
	$rows = mysql_num_rows($RS_datos);
	if($rows > 0) {
		mysql_data_seek($RS_datos, 0);
		$row_RSe = mysql_fetch_assoc($RS_datos);
	}
	}
	echo '</select>';
	
	mysql_free_result($RS_datos);
	}else{
		echo '<span class="label label-danger">Error generarSelect : '.$nom.'</span>';
	}
}

?>