<!--<p>Hello there <?php //echo $first_name . ' ' . $last_name; ?>!<p>

<p>You successfully landed on the home page. Congrats!</p>
-->
<?php
	if(isset($_POST['EnviarUsuario']))
	{
		if ( !isset($_FILES["foto"]) || $_FILES["foto"]["error"] > 0){
			$errTyp = "danger";
			$errMSG = "Algo ha salido mal, intente de nuevo..."; 	        	
  		}
  		else{
  			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
	        $limite_kb = 16384;
	        if (in_array($_FILES['foto']['type'], $permitidos) && $_FILES['foto']['size'] <= $limite_kb * 1024){
	          	$imagen_temporal  = $_FILES['foto']['tmp_name'];          
	          	$tipo = $_FILES['foto']['type'];
	          	$fp     = fopen($imagen_temporal, 'r+b');
	          	$data = fread($fp, filesize($imagen_temporal));
	          	fclose($fp);
        	  	$data = mysql_escape_string($data);

          	   	Pages::ingresarUsuario(trim($_POST['codigo']), trim($_POST['nombres']), trim($_POST['apellidos']), trim($_POST['tipoU']), trim($_POST['telefono']), trim($_POST['direccion']), trim($_POST['email']), trim($_POST['passWord']), trim($_POST['turno']), $data);
          	   	$errTyp = "success";
				$errMSG = "Registro ingresado con éxito.";
	       	}
	       	else {
	       		$errTyp = "danger";
				$errMSG = "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
			}
  		}
	} 
	if (isset($_POST['EnviarHorario'])) {
		$nombreHorario = trim($_POST['nombreHorario']);
	  	$nombreHorario = strip_tags($nombreHorario);
		$nombreHorario = htmlspecialchars($nombreHorario);
		$HoraInicio = trim($_POST['HoraInicio']);
	  	$HoraInicio = strip_tags($HoraInicio);
		$HoraInicio = htmlspecialchars($HoraInicio);
		$HoraFin = trim($_POST['HoraFin']);
	  	$HoraFin = strip_tags($HoraFin);
		$HoraFin = htmlspecialchars($HoraFin);
		Pages::ingresarHorario($nombreHorario, $HoraInicio." - ". $HoraFin);

		$errTyp = "success";
		$errMSG = "Registro ingresado con éxito.";	       	
	} 
	if (isset($_POST['EnviarTurno'])) {
		$tipohorario = trim($_POST['tipohorario']);
	  	$tipohorario = strip_tags($tipohorario);
		$tipohorario = htmlspecialchars($tipohorario);

		$nombreTurno = trim($_POST['nombreTurno']);
	  	$nombreTurno = strip_tags($nombreTurno);
	  	$nombreTurno = htmlspecialchars($nombreTurno);

	  	if(isset($_POST['lunes'])){$lunes = 1;}
		else{$lunes = 0;}
		if(isset($_POST['martes'])){$martes = 1;}
		else{$martes=0;}
		if(isset($_POST['miercoles'])){$miercoles = 1;}
		else{$miercoles=0;}
		if(isset($_POST['jueves'])){$jueves = 1;}
		else{$jueves=0;}
		if(isset($_POST['viernes'])){$viernes = 1;}
		else{$viernes=0;}
		if(isset($_POST['sabado'])){$sabado = 1;}
		else{$sabado=0;}

		Pages::ingresarTurno($tipohorario, $nombreTurno, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado);
	} 
	if (isset($_POST['EnviarTipoU'])) {
		$nombreTipo = trim($_POST['nombreTipo']);
	  	$nombreTipo = strip_tags($nombreTipo);
		$nombreTipo = htmlspecialchars($nombreTipo);
		Pages::ingresarTipoUser($nombreTipo);
	}
	if (isset($_POST['EnviarEspecial'])) {
		$nombreEsp = trim($_POST['nombreEspecialidad']);
	  	$nombreEsp = strip_tags($nombreEsp);
		$nombreEsp = htmlspecialchars($nombreEsp);

		$Descripcion = trim($_POST['Descripcion']);
	  	$Descripcion = strip_tags($Descripcion);
		$Descripcion = htmlspecialchars($Descripcion);
		Pages::ingresarEspecialidad($nombreEsp,$Descripcion);
	}
	if (isset($_POST['EnviarDoctor'])) {
		$CodDoctor = trim($_POST['CodDoctor']);
	  	$CodDoctor = strip_tags($CodDoctor);
		$CodDoctor = htmlspecialchars($CodDoctor);

		$UsuarioDoc = trim($_POST['UsuarioDoc']);
	  	$UsuarioDoc = strip_tags($UsuarioDoc);
		$UsuarioDoc = htmlspecialchars($UsuarioDoc);

		$EspeDoc = trim($_POST['EspeDoc']);
	  	$EspeDoc = strip_tags($EspeDoc);
		$EspeDoc = htmlspecialchars($EspeDoc);

		Pages::ingresarDoctor($CodDoctor,$UsuarioDoc, $EspeDoc);
	}
?>


<?php
	if ( isset($errMSG) ) {              
?>
	<div class="form-group">
    	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?> fade in">
    	<button type="button" class="close" data-dismiss="alert">×</button><strong>
	      	<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
	    </div>
  	</div>
<?php
    }
?>    

<!-- ************************ BUTTONS ************************ -->

<center>
	<button href="#ModalNuevoUsuario" data-toggle="modal" type="button" class="btn btn-default btn-lg">  
		<span><i class="fa fa-user-plus fa-4x"></i> 
		<br>Crear Usuario</span>
	</button>

	<button href="#ModalCrearHorarios" data-toggle="modal" type="button" class="btn btn-default btn-lg">  
		<span><i class="fa fa-clock-o fa-4x"></i> 
		<br>Crear Horarios</span>
	</button>

	<button href="#ModalCrearTurnos" data-toggle="modal" type="button" class="btn btn-default btn-lg">  
		<span><i class="fa fa-calendar fa-4x"></i> 
		<br>Crear Turnos</span>
	</button>

	<button href="#ModalNuevoTipoUsuario" data-toggle="modal" type="button" class="btn btn-default btn-lg">  
		<span><i class="fa fa-users fa-4x"></i> 
		<br>Nuevo Tipo Usuario</span>
	</button>

	<button href="#ModalNuevoMedico" data-toggle="modal" type="button" class="btn btn-default btn-lg">  
		<span><i class="fa fa-user-md fa-4x"></i> 
		<br>Agregar Medico</span>
	</button>

	<button href="#ModalNuevaEspecialidad" data-toggle="modal" type="button" class="btn btn-default btn-lg">  
		<span><i class="fa fa-briefcase fa-4x"></i> 
		<br>Agregar especialidad</span>
	</button>
</center>  

<!-- ************************ MODALS ************************ -->

<!--modal crear nuevo usuario start-->
<div id="ModalNuevoUsuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="myModalLabel">Crear Nuevo Usuario</h3>
			</div>
			<form id="FormNuevoUsuario" method="post" onsubmit="return validarNuevoUsuario(this)" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				<div class="modal-body">	
					<div class="row">												
				        <div class="col-md-4 form-group">
			        		<label for="recipient-name" class="control-label">código:</label>
				            <input id="codigo" name="codigo" type="text" class="form-control" id="recipient-name" required>
			          	</div>
          			</div>		
          			<div class="row">			
			          	<div class="col-md-6 form-group">
				            <label for="recipient-name" class="control-label">Nombres:</label>
				            <input id="nombres" name="nombres" type="text" class="form-control" id="recipient-name" required>
			          	</div>		        
			          	<div class="col-md-6 form-group">
				            <label for="recipient-name" class="control-label">Apellidos:</label>
				            <input id="apellidos" name="apellidos" type="text" class="form-control" id="recipient-name" required>
			          	</div>		
		          	</div>
		          	<div class="row">		
	          			<div class="col-md-6 form-group">
				            <label for="recipient-name" class="control-label">Tipo Usuario:</label>
				            <select id="tipoU" name="tipoU" class="selectpicker show-tick form-control">
				            <?php foreach($tiposU as $ListTipos) { 
				            	echo '<option value="'.$ListTipos->id.'">'.$ListTipos->tipoUsuario.'</option>';
			            	}?>		          	
					        </select>
			          	</div>		
			          	<div class="col-md-6 form-group">
				            <label for="recipient-name" class="control-label">Telefono:</label>
				            <input id="telefono" name="telefono" type="text" class="form-control" id="recipient-name" required>
			          	</div>	
		          	</div>		
		          	<div class="form-group">
			            <label for="recipient-name" class="control-label">Dirección:</label>
			            <input id="direccion" name="direccion" type="text" class="form-control" id="recipient-name" required>
		          	</div>			
		          	<div class="form-group">
			            <label for="recipient-name" class="control-label">Correo electronico:</label>
			            <input id="email" name="email" type="text" class="form-control" id="recipient-name" required>
		          	</div>		
		          	<div class="form-group">
			            <label for="recipient-name" class="control-label">Contraseña:</label>
			            <input id="passWord" name="passWord" type="password" class="form-control" id="recipient-name" required>
		          	</div>		
		          	<div class="form-group">
			            <label for="recipient-name" class="control-label">Foto:</label>
			            <input id="foto" name="foto" type="file" class="file" required>
		          	</div>
		          	<div class="form-group">
			            <label for="recipient-name" class="control-label">Turno:</label>
			            <select id="turno" name="turno" class="selectpicker show-tick form-control">
			            <?php foreach($turnos as $ListTurnos) { 
			            	echo '<option value="'.$ListTurnos->id.'">'.$ListTurnos->tipoUsuario.'</option>';
		            	}?>		          	
				        </select>
		          	</div>		
				</div>
				<div id="MensajeFormularioUsuario"></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>					
					<input name="EnviarUsuario" id="EnviarUsuario" type="submit" class="btn btn-primary" value="Aceptar">
				</div>
			</form>
		</div>
	</div>
</div>
<!--modal crear nuevo usuario end-->

<!-- MODAL CREAR NUEVO TURNO -->
<div id="ModalCrearTurnos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="myModalLabel">Crear Nuevo Turno</h3>
			</div>
			<form id="FormNuevoUsuario" method="post" onsubmit="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				<div class="modal-body">		
          			<div class="col-md-6 form-group">
			            <label for="recipient-name" class="control-label">Turno:</label>
			            <select id="tipohorario" name="tipohorario" class="selectpicker show-tick form-control">
			            <?php foreach($horarios as $ListHora) { 
			            	echo '<option value="'.$ListHora->id.'">'.$ListHora->tipoUsuario.'</option>';
		            	}?>		          	
				        </select>
		          	</div> 	
		          	<div class="col-md-6 form-group">
			            <label for="recipient-name" class="control-label">Nombre del turno:</label>
			            <input id="nombreTurno" name="nombreTurno" type="text" class="form-control" id="recipient-name" required>
		          	</div>	   
			        <div class="row">      
			          	<div class="col-md-2 form-group">
				            <label for="recipient-name" class="control-label">Lunes:</label><br>
							<input type="checkbox" id="lunes" name="lunes" checked>				            
			          	</div>		
			          	<div class="col-md-2 form-group">
				            <label for="recipient-name" class="control-label">Martes:</label><br>
							<input type="checkbox" id="martes" name="martes" checked>				            
			          	</div>		          		
			          	<div class="col-md-2 form-group">
				            <label for="recipient-name" class="control-label">Miercoles:</label><br>
							<input type="checkbox" id="miercoles" name="miercoles" checked>				            
			          	</div>
			          	<div class="col-md-2 form-group">
				            <label for="recipient-name" class="control-label">Jueves:</label><br>
							<input type="checkbox" id="jueves" name="jueves" checked>				            
			          	</div>
			          	<div class="col-md-2 form-group">
				            <label for="recipient-name" class="control-label">Viernes:</label><br>
							<input type="checkbox" id="viernes" name="viernes" checked>				            
			          	</div>
			          	<div class="col-md-2 form-group">
				            <label for="recipient-name" class="control-label">Sabado:</label><br>
							<input type="checkbox" id="sabado" name="sabado" checked>				            
			          	</div>			          	
					</div>					
				</div>
				<div id="MensajeFormularioUsuario"></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>					
					<input name="EnviarTurno" id="EnviarTurno" type="submit" class="btn btn-primary" value="Aceptar">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL CREAR NUEVO TURNO -->

<!-- MODAL CREAR NUEVO HORARIO -->
<div id="ModalCrearHorarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="myModalLabel">Crear Nuevo Horario</h3>
			</div>
			<form id="FormNuevoUsuario" method="post" onsubmit="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				<div class="modal-body">		
          			<div class="row">		
          			<div class="col-md-1"></div>	
			          	<div class="col-md-10 form-group">
				            <label for="recipient-name" class="control-label">Nombre del horario:</label>
				            <input id="nombreHorario" name="nombreHorario" type="text" class="form-control" id="recipient-name" required>
			          	</div>	
			        </div>	  
			        <div class="row"> 
						<label for="recipient-name" class="control-label">Hora Inicio:</label>
						<div class="form-group input-group bootstrap-timepicker timepicker">							
				            <input id="timepicker1" name="HoraInicio" type="text" class="form-control input-small">
				            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
				        </div>						
			        </div>
					<div class="row"> 
						<label for="recipient-name" class="control-label">Hora Fin:</label>
						<div class="col-md-2 form-group input-group bootstrap-timepicker timepicker">							
				            <input id="timepicker2" name="HoraFin" type="text" class="form-control input-small">
				            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
				        </div>						
			        </div>
				</div>
				<div id="MensajeFormularioUsuario"></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>					
					<input name="EnviarHorario" id="EnviarHorario" type="submit" class="btn btn-primary" value="Aceptar">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL CREAR NUEVO HORARIO -->

<!-- MODAL CREAR NUEVO TIPO USUARIO-->
<div id="ModalNuevoTipoUsuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="myModalLabel">Nuevo tipo de usuario</h3>
			</div>
			<form id="FormNuevoUsuario" method="post" onsubmit="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				<div class="modal-body">		
          			<div class="row">		
          			<div class="col-md-1"></div>	
			          	<div class="col-md-10 form-group">
				            <label for="recipient-name" class="control-label">Nombre:</label>
				            <input id="nombreTipo" name="nombreTipo" type="text" class="form-control" id="recipient-name" required>
			          	</div>	
			        </div>	  			        
				</div>
				<div id="MensajeFormularioUsuario"></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>					
					<input name="EnviarTipoU" id="EnviarTipoU" type="submit" class="btn btn-primary" value="Aceptar">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL CREAR NUEVO TIPO USUARIO -->

<!-- MODAL CREAR DOCTOR -->
<div id="ModalNuevoMedico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="myModalLabel">Agregar Nuevo Doctor</h3>
			</div>
			<form method="post" onsubmit="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				<div class="modal-body">		
          			<div class="row">		
          			<div class="col-md-1"></div>	
			          	<div class="col-md-10 form-group">
				            <label for="recipient-name" class="control-label">Codigo de Doctor:</label>
				            <input id="CodDoctor" name="CodDoctor" type="text" class="form-control" id="recipient-name" required>
			          	</div>	
			        </div>
			        <div class="row">		
	          			<div class="col-md-10 col-md-offset-1 form-group">
				            <label for="recipient-name" class="control-label">Usuario:</label>
				            <select id="UsuarioDoc" name="UsuarioDoc" class="selectpicker show-tick form-control">
				            <?php foreach($DatosUsuario as $ListUserDatos) { 
				            	echo '<option value="'.$ListUserDatos->id.'">'.$ListUserDatos->Var1.' '.$ListUserDatos->Var2.'</option>';
			            	}?>		          	
					        </select>
			          	</div>					          	
		          	</div>	  			        
		          	<div class="row">		
	          			<div class="col-md-10 col-md-offset-1 form-group">
				            <label for="recipient-name" class="control-label">Especialidad:</label>
				            <select id="EspeDoc" name="EspeDoc" class="selectpicker show-tick form-control">
				            <?php foreach($Especialidad as $ListEspecial) { 
				            	echo '<option value="'.$ListEspecial->id.'">'.$ListEspecial->tipoUsuario.'</option>';
			            	}?>		          	
					        </select>
			          	</div>					          	
		          	</div>
				</div>
				<div id="MensajeFormularioUsuario"></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>					
					<input name="EnviarDoctor" id="EnviarDoctor" type="submit" class="btn btn-primary" value="Aceptar">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL CREAR DOCTOR -->

<!-- MODAL AGREGAR ESPECIALIDAD USUARIO-->
<div id="ModalNuevaEspecialidad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="myModalLabel">Nueva Especialidad</h3>
			</div>
			<form id="FormNuevoUsuario" method="post" onsubmit="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				<div class="modal-body">		
          			<div class="row">		
          			<div class="col-md-1"></div>	
			          	<div class="col-md-10 form-group">
				            <label for="recipient-name" class="control-label">Nombre:</label>
				            <input id="nombreEspecialidad" name="nombreEspecialidad" type="text" class="form-control" id="recipient-name" required>
			          	</div>	
			        </div>	  			        
			        <div class="row">		
          			<div class="col-md-1"></div>	
			          	<div class="col-md-10 form-group">
				            <label for="recipient-name" class="control-label">Descripción:</label>
				            <textarea id="Descripcion" name="Descripcion" type="text" class="form-control" id="recipient-name" required></textarea>
			          	</div>	
			        </div>	  			        
				</div>
				<div id="MensajeFormularioUsuario"></div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>					
					<input name="EnviarEspecial" id="EnviarEspecial" type="submit" class="btn btn-primary" value="Aceptar">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL AGREGAR ESPECIALIDAD USUARIO -->



<!-- ************************ TABLES ************************ -->

<!--Tabla Usuarios start-->
<div class=" panel-body1">
	<div class="table-responsive">
		<table class="table table-striped">
	 		<thead>
				<tr>
			  		<th>Codigo Usuario</th>
			  		<th>Nombres</th>
			  		<th>Apellidos</th>
			  		<th>Email</th>
			  		<th>Telefono</th>
			  		<th>Tipo Usuario</th>
				</tr>
		  	</thead>
		  	<tbody>
			  	<?php foreach($usuarios as $ListUsers) { 
			  		echo '<tr>';
			  		echo '<th scope="row">'.$ListUsers->codigoUsuario.'</th>';
			  		echo '<td>'.$ListUsers->nombres.'</td>';
			  		echo '<td>'.$ListUsers->apellidos.'</td>';
			  		echo '<td>'.$ListUsers->correo.'</td>';
			  		echo '<td>'.$ListUsers->telefono.'</td>';
			  		echo '<td>'.$ListUsers->tipousuario.'</td>';
			  		echo '</tr>';
				}?>	
		  	</tbody>
		</table>
	</div>
</div>
<!--Tabla Usuarios end-->


<!--Tabla Horarios start-->
<div class="col-md-6">
	<div class=" panel-body1">
		<div class="table-responsive">
			<table class="table table-striped">
			 	<thead>
					<tr>
						<th>#</th>
				  		<th>Nombre Horario</th>
				  		<th>Horario</th>
					</tr>
			  	</thead>
			  	<tbody>
				  	<?php foreach($TableHorario as $ListHorarios) { 
				  		echo '<tr>';
				  		echo '<th scope="row">'.$ListHorarios->id.'</th>';
				  		echo '<td>'.$ListHorarios->Nombre.'</td>';
				  		echo '<td>'.$ListHorarios->Horario.'</td>';
				  		echo '</tr>';
					}?>	
			  	</tbody>
			</table>
		</div>
	</div>
</div>
<!--Tabla Horarios end-->

<!--Tabla tipo usuarios start-->
<div class="col-md-6">
	<div class=" panel-body1">
		<div class="table-responsive">
			<table class="table table-striped">
			 	<thead>
					<tr>
						<th>#</th>
				  		<th>Tipo de usuario</th>
					</tr>
			  	</thead>
			  	<tbody>
				  	<?php foreach($TableTipoU as $ListTipoUser) { 
				  		echo '<tr>';
				  		echo '<th scope="row">'.$ListTipoUser->id.'</th>';
				  		echo '<td>'.$ListTipoUser->tipoUsuario.'</td>';
				  		echo '</tr>';
					}?>	
			  	</tbody>
			</table>
		</div>
	</div>
</div>
<!--Tabla tipo usuarios end-->