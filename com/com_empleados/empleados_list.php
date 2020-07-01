<?php if (($_GET['id_emp']==null)&&($_GET["action_form"]!="INSERT")) $_GET['id_emp']=$_SESSION['id_emp'];
$accion =$_GET["action_form"];	
$query_empleados ='SELECT * FROM db_empleados';
if (mysql_query($query_empleados)){
$RS_empleados_list = mysql_query($query_empleados);
$row_RS_empleados_list = mysql_fetch_assoc($RS_empleados_list);
?>
    <table class="table table-condensed table-bordered" id="mytable" >
    <thead>
    			<tr>
                	<th></th>	
                	<th>Codigo Empleado</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Direccion</th>
                    <th>Telefono 1</th>
                    <th>Telefono 2</th>
                    <th>Tipo</th>
                </tr>
                </thead>
                <tbody>
	<?php do { ?> 
            	<tr>
              	  <td align="center">
    	            <a href="empleados_form.php?id_emp=<?php echo $row_RS_empleados_list['emp_cod']; ?>&amp;action_form=UPDATE" rel="shadowbox" title="Modificar Empleado"><img src="../../images/struct/img_taskbar/add_user.png" border="0" alt="Reserva"/></a>
                  </td>
                  <td><?php echo $row_RS_empleados_list['emp_cod']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_nom']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_ape']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_dir']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_tel1']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_tel2']; ?></td>
                  <td><?php echo $row_RS_empleados_list['typ_cod']; ?></td>
                </tr>  
         <?php } while ($row_RS_empleados_list = mysql_fetch_assoc($RS_empleados_list)); 
}else echo mysql_error();?> 
            </tbody>
            </table>