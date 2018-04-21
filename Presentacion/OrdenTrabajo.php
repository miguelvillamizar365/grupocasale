<?php 

/*
*
*manejo de la presentacion de la orden de trabajo
*@autor Miguel Villamizar
*@copyrigth 17/03/2018
*
*/

class OrdenTrabajo
{
	function mostrarOrdenTrabajo()
	{
		?> 
        <meta charset="iso-8859-1" />
        
        <input type="hidden" id="id_orden" name="id_orden" value="" /> 
        <div class="content-wrapper" style="width: 70% !important;">
            <h3 class="text-primary mb-4">Ordenes de Trabajo</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearOrden()">Crear Nueva</button>
                            <br />
                            <br />
                            
                            <table id="table_Ordenes" class="display" cellspacing="0"></table>
							
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
                <button onclick="eliminarOrden()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>   
		<?php
	}
	
	function CrearOrdenTrabajo()
	{
		?>
		<meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Agregar Orden Trabajo</h3>
            
           <form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_placa">Placa</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-automobile"></i></span>
							<input id="TB_placa" maxlength="6" name="TB_placa" type="text" class="form-control p_input" placeholder="Placa" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="TB_fecha" name="TB_fecha" type="text" class="form-control p_input" placeholder="Fecha" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_kilometraje">Kilometraje</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tachometer"></i></span>
							<input id="TB_kilometraje" name="TB_kilometraje" type="text" class="form-control p_input" placeholder="Kilometraje" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_conductor">Conductor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_conductor" name="id_conductor" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
				</div>
				
				<div class="row">					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_mecanico" name="id_mecanico" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_observaciones">Observaciones</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-thumbs-o-up"></i></span>
							<textarea id="TB_observaciones" 
							name="TB_observaciones" 
							class="form-control p_input" 
							placeholder="Observaciones" 
							style="width:90%; height:100px;">
							</textarea>
						  </div>
						</div>
					</div>
				</div>
                <div class="text-center">
                    <button type="button" onclick="mostrarOrdenes(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarOrdenes()" class="btn btn-primary">Guardar</button>
                </div>
			</form>
		</div>
		<script>
		
			$("#TB_kilometraje").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8)    {
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
			
			$('input#TB_kilometraje').keyup(function(event) {
			  // skip for arrow keys
			  if(event.which >= 37 && event.which <= 40)
				  return;

			  // format number
			  $(this).val(function(index, value) {
				return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			  });			  
			});
		</script>
		<?php
	}
	
	
	function EditarOrdenTrabajo($numeroOrden, $placa, $fecha, $kilometraje, $observaciones)
	{
		?>
		<meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Editar Orden Trabajo</h3>
            
           <form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="editarGuardarOrden" />                                              
				<input type="hidden" id="numeroOrden" name="numeroOrden" value="<?php echo $numeroOrden;?>" />                                              
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_placa">Placa</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-automobile"></i></span>
							<input id="TB_placa" maxlength="6" name="TB_placa" type="text" 
							class="form-control p_input" placeholder="Placa"
							value="<?php echo $placa;?>" />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="TB_fecha" name="TB_fecha" 
							type="text" class="form-control p_input"
							placeholder="Fecha" 
							value="<?php echo $fecha;?>"/>
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_kilometraje">Kilometraje</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tachometer"></i></span>
							<input id="TB_kilometraje" 
							name="TB_kilometraje" type="text" 
							class="form-control p_input" 
							placeholder="Kilometraje"
							value="<?php echo $kilometraje;?>"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_conductor">Conductor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_conductor" name="id_conductor" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
				</div>
				
				<div class="row">					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_mecanico" name="id_mecanico" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_observaciones">Observaciones</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-thumbs-o-up"></i></span>
							<textarea id="TB_observaciones" 
							name="TB_observaciones"
							class="form-control p_input" 
							placeholder="Observaciones"
							style="width:90%; height:100px;"><?php echo $observaciones;?></textarea>
						  </div>
						</div>
					</div>
				</div>
                <div class="text-center">
                    <button type="button" onclick="mostrarOrdenes(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="editarOrdenes()" class="btn btn-primary">Guardar</button>
                </div>
			</form>
		</div>
		<script>
		
			$("#TB_kilometraje").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8)    {
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
			
			$('input#TB_kilometraje').keyup(function(event) {
			  // skip for arrow keys
			  if(event.which >= 37 && event.which <= 40)
				  return;

			  // format number
			  $(this).val(function(index, value) {
				return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			  });			  
			});
		</script>
		<?php
	}
		
    function mensajeRedirect($mensaje, $url)
    {
        ?>
        
        <div class="modal fade" id="mensajeEmergenteRedirect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" >Mensaje de aplicación</h4>
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
	
	function verReferencias($noOrden)
	{
		?>		
        <input type="hidden" id="id_orden" name="id_orden" value="<?php echo $noOrden;?>" /> 
        <div class="content-wrapper" style="width: 80% !important;">
            <h3 class="text-primary mb-4">Detalle Orden de Trabajo</h3>
			<br />
			<h3 class="text-primary mb-4">Repuestos y materiales</h3>
            
				<div class="col-lg-6">
			<div class="row mb-2">
					<div class="form-group">
					  <label for="id_referencia" style="font-weight: bold;">El usuario debe ingresar el No referencia:</label> 
					  <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-search"></i></span>
						<input id="id_referencia" 
						name="id_referencia" type="text" 
						class="form-control p_input" 
						placeholder="Buscar"/>
					  </div>
					</div>
				</div>
				<div class="col-lg-6">
				</div>
			</div>
			
			<br />
			<br />
				   
            <div class="row mb-2">
                <div class="col-lg-12">                     
                    <div class="card">
                        <div class="card-block">							
                            <table id="table_OrdenesReferencia" class="display" cellspacing="0"></table>							
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
                <button onclick="eliminarReferenciaOrden()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>  
		<?php
	}	
	
	function verReferenciaInfo($noOrden, $id_referencia)
	{
		?>                
		<meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Agregar Referencia</h3>
            
			<form id="referencia">  
				<input type="hidden" id="id_orden" name="id_orden" value="<?php echo $noOrden;?>" /> 
				<input type="hidden" id="id_referencia" name="id_referencia" value="<?php echo $id_referencia;?>" /> 
				<input type="hidden" id="desea" name="desea" value="" /> 
					  
				<div class="row mb-2">
					<div class="col-lg-12">
						
						<div class="card">
							<div class="card-block">
								<table id="table_referencia" class="display" cellspacing="0"></table>
							</div>
						</div>
					</div>                    
				</div>       
			
			
			  <div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="TB_cantidad">Cantidad</label>   
						<input id="TB_cantidad" 
							name="TB_cantidad" type="text" 
							class="form-control p_input" 
							placeholder="Cantidad"/>                                                 
					</div>
				</div>
				<div class="col-md-6">
					
				</div>
			  </div>	
			  <div class="text-center">
				<button onclick="mostrarReferenciasOrden(<?php echo $noOrden;?>, 0)" type="button" class="btn btn-secondary" >Cancelar</button>
				<button onclick="agregarReferencia()" type="button" class="btn btn-primary" >Aceptar</button>
			  </div>
            </form>
        </div>
        <script>                    	
			$("#TB_cantidad").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8)    {
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