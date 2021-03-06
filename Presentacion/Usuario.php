<?php

/**
 * presentación de  Usuarios
 * @author miguel villamizar
 * @copyright 2018/08/30
 */

class Usuarios{
    
    function mostrarUsuarios(){
    
		header('Content-Type:text/html; charset=iso-8859-1');
		?>  
        
        <input type="hidden" id="id_usuario" name="id_usuario" value="" /> 
        <div class="">
            <h3 class="text-primary mb-4">Usuarios</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">                    
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearUsuarios()">Crear Nuevo</button>
                            <br />
                            <br />
                            <div class="table-responsive">
								<table id="table_usuarios" class="display table table-striped table-bordered nowrap" cellspacing="0"></table>
							</div>
                        </div>
                    </div>
                </div>                    
            </div>               
        </div>     
        
        <div class="modal fade" id="mensajeConfirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div id="mensajeConf">
                
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button onclick="eliminarUsuario()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>      
         
		<?php
    }
	
	
    function mensajeRedirect($mensaje, $url)
    {
        ?>
        
		<div class="modal fade" id="mensajeEmergenteRedirect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div id="mensaje">
                
                </div>
              </div>
              <div class="modal-footer">
                <button onclick="<?php echo $url?>" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
          </div>
        </div>   
        <script>
        
             $("#mensajeEmergenteRedirect")
            .find('.modal-body > div[id="mensaje"]')
            .html(<?php echo $mensaje?>);
            	
    		$("#mensajeEmergenteRedirect").modal("show");
            
        </script>
        <?php
    }
    
		
    function formularioCrear()
    {
        ?>
        
        <div class="">
            <h3 class="text-primary mb-4">Agregar Usuario</h3>            
          
			 <form id="registro">
				
				<input type="hidden" id="desea" name="desea" value="" />                                              
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">                                
						  <label for="TB_nombre">Nombre</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input id="TB_nombre" name="TB_nombre" type="text" class="form-control p_input" placeholder="Nombre" maxlength="50" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_apellido">Apellido</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input id="TB_apellido" name="TB_apellido" type="text" class="form-control p_input" placeholder="Apellido" maxlength="50" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_documento">Documento</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-drivers-license-o"></i></span>
							<input id="TB_documento" name="TB_documento" type="text" class="form-control p_input" placeholder="Número de Documento" maxlength="50" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_telefono">Teléfono</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-phone"></i></span>
							<input id="TB_telefono" name="TB_telefono" type="text" class="form-control p_input" placeholder="Teléfono" maxlength="50" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">                                
						<div class="form-group">
							
						  <label for="id_rol">Rol</label>            
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-users"></i></span>                                    
								<select style="width: 400px!important;" id="id_rol" name="id_rol" class="show-tick form-control">                                   
								</select>
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div id="valorHora" class="form-group">
						  <label for="TB_valor">Valor Hora Mecánico</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valor" name="TB_valor" type="text" class="form-control p_input" placeholder="Valor"  maxlength="11" />
						  </div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_direccion">Dirección</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-home"></i></span>
							<input id="TB_direccion" name="TB_direccion" type="text" class="form-control p_input" placeholder="Dirección"  maxlength="50" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_email">Email</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope-open"></i></span>
							<input id="TB_email" name="TB_email" type="text" class="form-control p_input" placeholder="Email"  maxlength="50" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						
						  <label for="TB_clave">Clave</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" id="TB_clave" name="TB_clave" type="text" class="form-control p_input" placeholder="Clave"  maxlength="50" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						
						  <label for="TB_confirmaclave">Confirmar Clave</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" id="TB_confirmaclave" name="TB_confirmaclave" type="text" class="form-control p_input" placeholder="Confirmar Clave"  maxlength="50" />
						  </div>
						</div>
					</div>
				</div>
										
				<div class="text-center">
					<button type="button" onclick="mostrarUsuarios(0)" class="btn btn-secondary">Atrás</button>
					<button type="button" onclick="guardarUsuario()" class="btn btn-primary">Guardar</button>
				</div>
			 </form>
        </div>           
		<script>
			
			$('input#TB_valor').keyup(function(event) {
			  // skip for arrow keys
			  if(event.which >= 37 && event.which <= 40)
				  return;

			  // format number
			  $(this).val(function(index, value) {
					var number = value.replace(",", ""),
					thousand_separator = ',',
					decimal_separator = '.';

					var	number_string = number.toString(),
					split	  = number_string.split(decimal_separator),
					result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						
					result = split[1] != undefined ? result + decimal_separator + split[1] : result;
					
					return result;
			  });			  
			});
			$("#TB_valor").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 37 || event.keyCode == 39)    {
				}
				else {
					if (event.keyCode < 95) {
					  if (event.keyCode < 48 || event.keyCode > 57) {
							event.preventDefault();
					  }
					} 
					else {
						  if (event.keyCode < 96 || event.keyCode > 105) {
							  event.preventDefault();
						  }
					}
				  }
			});   		
					
		</script>
        <?php
    }
	
	
    function formularioEditar($id_usuario, 
							  $nombre,
							  $apellido,
							  $documento, 
							  $telefono,
							  $direccion,
							  $email,
							  $valorHora)
    {
        ?>
        
        <div class="">
            <h3 class="text-primary mb-4">Editar Usuario</h3>            
          
			 <form id="registro">
				
				<input type="hidden" id="desea" name="desea" value="" />
				<input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario;?>" />				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">                                
						  <label for="TB_nombre">Nombre</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input id="TB_nombre" name="TB_nombre" type="text" 
							class="form-control p_input" placeholder="Nombre" 
							maxlength="50" value="<?php echo $nombre;?>" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_apellido">Apellido</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input id="TB_apellido" name="TB_apellido" type="text" 
							class="form-control p_input" placeholder="Apellido" 
							maxlength="50" value="<?php echo $apellido;?>" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_documento">Documento</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-drivers-license-o"></i></span>
							<input id="TB_documento" name="TB_documento" 
							type="text" class="form-control p_input" 
							placeholder="Número de Documento" maxlength="50"
							value="<?php echo $documento;?>"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_telefono">Teléfono</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-phone"></i></span>
							<input id="TB_telefono" name="TB_telefono" type="text" 
							class="form-control p_input" placeholder="Teléfono" 
							maxlength="50" value="<?php echo $telefono;?>" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">                                
						<div class="form-group">
							
						  <label for="id_rol">Rol</label>            
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-users"></i></span>                                    
								<select style="width: 400px!important;" id="id_rol" name="id_rol" class="show-tick form-control">                                   
								</select>
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div id="valorHora" class="form-group">
						  <label for="TB_valor">Valor Hora Mecánico</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valor" name="TB_valor" type="text" class="form-control p_input" 
							placeholder="Valor"  maxlength="11"
							value="<?php echo $valorHora;?>"/>
						  </div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_direccion">Dirección</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-home"></i></span>
							<input id="TB_direccion" name="TB_direccion" type="text" 
							class="form-control p_input" placeholder="Dirección"  
							maxlength="50" value="<?php echo $direccion;?>" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_email">Email</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope-open"></i></span>
							<input id="TB_email" name="TB_email" type="text" 
							class="form-control p_input" placeholder="Email"  
							maxlength="50" value="<?php echo $email;?>" />
						  </div>
						</div>
					</div>
				</div>
							
				<div class="text-center">
					<button type="button" onclick="mostrarUsuarios(0)" class="btn btn-secondary">Atrás</button>
					<button type="button" onclick="guardarUsuarioEditar()" class="btn btn-primary">Guardar</button>
				</div>
			 </form>
        </div>    
         
		<script>
			
			$('input#TB_valor').keyup(function(event) {
			  // skip for arrow keys
			  if(event.which >= 37 && event.which <= 40)
				  return;

			  // format number
			  $(this).val(function(index, value) {
					var number = value.replace(",", ""),
					thousand_separator = ',',
					decimal_separator = '.';

					var	number_string = number.toString(),
					split	  = number_string.split(decimal_separator),
					result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						
					result = split[1] != undefined ? result + decimal_separator + split[1] : result;
					
					return result;
			  });			  
			});
			$("#TB_valor").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 37 || event.keyCode == 39)    {
				}
				else {
					if (event.keyCode < 95) {
					  if (event.keyCode < 48 || event.keyCode > 57) {
							event.preventDefault();
					  }
					} 
					else {
						  if (event.keyCode < 96 || event.keyCode > 105) {
							  event.preventDefault();
						  }
					}
				  }
			});  
		</script>			
        <?php
    }
}

?>