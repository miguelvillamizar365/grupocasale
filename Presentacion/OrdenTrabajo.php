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
        <div class="content-wrapper" style="width: 60% !important;">
            <h3 class="text-primary mb-4">Ordenes de Trabajo</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearOrden()">Crear Nueva</button>
                            <br />
                            <br />
                            
                            <table id="table_OrdenesAll" class="cell-border display" cellspacing="0"></table>
							
                        </div>
                    </div>
                </div>                    
            </div>               
        </div>   
		<script>
		
			$('#table_OrdenesAll').DataTable({
				
				language: { url: '../datatables/Spanish.json' },
				data: null,
				scrollX: true,
				columns: [
					{ 
						title: "Editar",
						targets: -1,
						render: function (data, type, row) {
							if(row.EstadoId == 1)
							{
								return "<button class='A_editar btn btn-primary' >Editar</button>";
							}
							else
							{
								return "";
							}
						}
					},
					{ 
						title: "Referencias",
						targets: -1,
						render: function (data, type, row) {
							return "<button class='A_detalleRef btn btn-secondary' >Ver Detalle</button>";
						}  
					},
					{ 
						title: "Actividades",
						targets: -1,
						render: function (data, type, row) {
							return "<button class='A_detalleActi btn btn-outline-primary' >Ver Detalle</button>";
						}  
					},
					{ data: "Id",    title: "No. Orden Trabajo"},
					{ data: "id_vehiculo",    title: "id_vehiculo"},
					{ data: "Placas",    title: "Placa"},
					{ data: "Fecha",    title: "Fecha"},
					{ 
						data: "ValorTotalReferencia",
						title: "Valor Total Referencia",
						mRender: function (data, type, full) {
							  
								var number = data.replace(",", ""),
								thousand_separator = ',',
								decimal_separator = '.';

								var	number_string = number.toString(),
								split	  = number_string.split(decimal_separator),
								result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
										
								if(split[1] != "")
								{
									result = split[1] != undefined ? result + decimal_separator + split[1] : result;
								}

								return result;
							}
					},
					{ 
						data: "ValorTotalUtilidadReferencia",
						title: "Valor Total Utilidad Referencia",
						mRender: function (data, type, full) {
							  
								var number = data.replace(",", ""),
								thousand_separator = ',',
								decimal_separator = '.';

								var	number_string = number.toString(),
								split	  = number_string.split(decimal_separator),
								result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
										
								if(split[1] != "")
								{
									result = split[1] != undefined ? result + decimal_separator + split[1] : result;
								}

								return result;
							}
					},
					{ 
						data: "ValorTotalActividad",
						title: "Valor Total Actividad",
						mRender: function (data, type, full) {
							  
								var number = data.replace(",", ""),
								thousand_separator = ',',
								decimal_separator = '.';

								var	number_string = number.toString(),
								split	  = number_string.split(decimal_separator),
								result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
										
								if(split[1] != "")
								{
									result = split[1] != undefined ? result + decimal_separator + split[1] : result;
								}

								return result;
							}
					},
					{ 
						data: "ValorTotalUtilidadActividad",
						title: "ValorTotal Utilidad Actividad",
						mRender: function (data, type, full) {
							  
								var number = data.replace(",", ""),
								thousand_separator = ',',
								decimal_separator = '.';

								var	number_string = number.toString(),
								split	  = number_string.split(decimal_separator),
								result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
										
								if(split[1] != "")
								{
									result = split[1] != undefined ? result + decimal_separator + split[1] : result;
								}

								return result;
							}
					},
					{ 
						data: "Kilometraje",   
						title: "Kilometraje",
						mRender: function (data, type, full) {
						 var formmatedvalue = data.replace(/\D/g, "");
							formmatedvalue = formmatedvalue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						  return formmatedvalue;
						}
					},
					{ data: "id_mecanico", title: "Mecánico" },
					{ data: "mecanico", title: "Mecánico" },
					{ data: "id_conductor", title: "Conductor"},
					{ data: "conductor", title: "Conductor"},
					{ data: "Observaciones", title: "Observaciones"},
					{ data: "EstadoId", title: "EstadoId"},
					{ data: "Estado", title: "Estado"}
				],
				columnDefs: [
					{
						targets: [ 4 ],
						visible: false,
						searchable: false
					},
					{
						targets: [ 12 ],
						visible: false,
						searchable: false
					},
					{
						targets: [ 14 ],
						visible: false,
						searchable: false
					},
					{
						targets: [ 17 ],
						visible: false,
						searchable: false
					}
				]
			});
			
			$.ajax({
				url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
				type:  'post',
				dataType:'json',
				data: {'desea': 'cargaOrdenes'},
				success:  function (data) {
					 
					$('#table_OrdenesAll').DataTable().clear().draw().rows.add(data).draw();
					
				},
				complete: function()
				{
					
				},
				error: function(ex){
					console.log(ex);
				}
			}); 
		</script>
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
						  <label for="id_vehiculo">Placa</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>
								<select style="width: 400px!important;" id="id_vehiculo" name="id_vehiculo" class="show-tick form-control" >                                   
                                </select>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							
							<div class="input-group date form_datetime" data-link-field="TB_fecha" >
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input id="TB_fechaDate" class="form-control p_input" type="text" readonly >
							</div>
							
							<input id="TB_fecha" name="TB_fecha" type="hidden" />
							
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
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
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
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
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
							style="width:90%; height:100px;"
							maxlength="300">
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
		
			$("#TB_fecha").val(getDate());
			$("#TB_fechaDate").val(getDate());
			$('.form_datetime').datetimepicker({
				language:  'es',
				format: 'yyyy/mm/dd hh:ii',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				showMeridian: 1,
				date: new Date(),
				icons: {
				  time: "fa fa-clock-o",
				  date: "fa fa-calendar",
				  up: "fa fa-caret-up",
				  down: "fa fa-caret-down",
				  previous: "fa fa-caret-left",
				  next: "fa fa-caret-right",
				  today: "fa fa-today",
				  clear: "fa fa-clear",
				  close: "fa fa-close"
				}
			});
			
			function getDate()
			{
				var fecha = new Date();
				
				var dia = fecha.getDate();
				var mes = fecha.getMonth()+1 > 12 ? 1: fecha.getMonth()+1;
				var anio = fecha.getFullYear();
				var hora = fecha.getHours();
				var minutes = fecha.getMinutes();
				
				return anio+"/"+mes+"/"+dia+" "+hora+":"+minutes;
			}		
		
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
	
	
	function EditarOrdenTrabajo($numeroOrden, $fecha, $kilometraje, $observaciones)
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
						  <label for="id_vehiculo">Placa</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-automobile"></i></span>
							<select style="width: 400px!important;" id="id_vehiculo" name="id_vehiculo" class="show-tick form-control" >                                   
                            </select>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							
							<div class="input-group date form_datetime" data-link-field="TB_fecha" >
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input id="TB_fechaDate" class="form-control p_input" value="<?php echo $fecha;?>" type="text" readonly >
							</div>
							
							<input id="TB_fecha" name="TB_fecha" value="<?php echo $fecha;?>" type="hidden" />
							
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
		
			$('.form_datetime').datetimepicker({
				language:  'es',
				format: 'yyyy/mm/dd hh:ii',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				showMeridian: 1,
				date: new Date(),
				icons: {
				  time: "fa fa-clock-o",
				  date: "fa fa-calendar",
				  up: "fa fa-caret-up",
				  down: "fa fa-caret-down",
				  previous: "fa fa-caret-left",
				  next: "fa fa-caret-right",
				  today: "fa fa-today",
				  clear: "fa fa-clear",
				  close: "fa fa-close"
				}
			});
			
			function getDate()
			{
				var fecha = new Date();
				
				var dia = fecha.getDate();
				var mes = fecha.getMonth()+1 > 12 ? 1: fecha.getMonth()+1;
				var anio = fecha.getFullYear();
				var hora = fecha.getHours();
				var minutes = fecha.getMinutes();
				
				return anio+"/"+mes+"/"+dia+" "+hora+":"+minutes;
			}		
		
		
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
	
	function verReferencias($noOrden,
						$Placas,
						$Fecha,
						$Kilometraje,
						$mecanico,
						$conductor,
						$Observaciones)
	{
		?>		
        <input type="hidden" id="id_orden" name="id_orden" value="<?php echo $noOrden;?>" /> 
		<input type="hidden" id="id_referenciaOrden" name="id_referenciaOrden" value="" /> 
        <div class="content-wrapper" style="width: 80% !important;">
            <h3 class="text-primary mb-4">Detalle Orden de Trabajo</h3>
			<br />
			
           <form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_orden">Número de Orden</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_orden" name="id_orden" 
								type="text" class="form-control p_input" 
								placeholder="No. Orden" 
								value="<?php echo $noOrden;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_vehiculo">Placa</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_vehiculo" name="id_vehiculo" 
								type="text" class="form-control p_input" 
								placeholder="Vehiculo" 
								value="<?php echo $Placas;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="TB_fechaDate" class="form-control p_input" 
							type="text" readonly 
							value="<?php echo $Fecha;?>">
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
							<input id="TB_kilometraje" name="TB_kilometraje" 
							type="text" class="form-control p_input" 
							placeholder="Kilometraje" readonly 
							value="<?php echo $Kilometraje;?>"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_conductor">Conductor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_conductor" name="TB_conductor" 
								type="text" class="form-control p_input" 
								placeholder="Conductor" readonly
								value="<?php echo $conductor;?>"/>								
                            </div>                                                      
                        </div>
                    </div>
				</div>
				
				<div class="row">					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_mecanico" name="TB_mecanico" 
								type="text" class="form-control p_input" 
								placeholder="Mecanico" readonly
								value="<?php echo $mecanico;?>"/>								
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
							style="width:90%; height:100px;"
							maxlength="300" readonly>
							<?php echo $Observaciones;?>
							</textarea>
						  </div>
						</div>
					</div>
				</div>
			</form>
			
			<h3 class="text-primary mb-4">Repuestos y materiales</h3>
            
			<div id="div_referencia" class="col-lg-6">
				<div class="row mb-2">
					<div class="form-group">
					  <label for="id_referencia" style="font-weight: bold;">El usuario debe ingresar el No referencia o Nombre:</label> 
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
                            <table id="table_OrdenesReferencia" class="cell-border display" cellspacing="0"></table>							
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
	
	function verReferenciaInfo($noOrden, $id_referencia,
								$Placas,
								$Fecha,
								$Kilometraje,
								$mecanico,
								$conductor,
								$Observaciones)
	{
		?>                
		<meta charset="iso-8859-1" />
        <div class="content-wrapper" >
		
		 <h3 class="text-primary mb-4">Detalle Orden de Trabajo</h3>
			<br />
			
           <form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_orden">Número de Orden</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_orden" name="id_orden" 
								type="text" class="form-control p_input" 
								placeholder="No. Orden" 
								value="<?php echo $noOrden;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						
					</div>
				</div>
								
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_vehiculo">Placa</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_vehiculo" name="id_vehiculo" 
								type="text" class="form-control p_input" 
								placeholder="Vehiculo" 
								value="<?php echo $Placas;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="TB_fechaDate" class="form-control p_input" 
							type="text" readonly 
							value="<?php echo $Fecha;?>">
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
							<input id="TB_kilometraje" name="TB_kilometraje" 
							type="text" class="form-control p_input" 
							placeholder="Kilometraje" readonly 
							value="<?php echo $Kilometraje;?>"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_conductor">Conductor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_conductor" name="TB_conductor" 
								type="text" class="form-control p_input" 
								placeholder="Conductor" readonly
								value="<?php echo $conductor;?>"/>								
                            </div>                                                      
                        </div>
                    </div>
				</div>
				
				<div class="row">					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_mecanico" name="TB_mecanico" 
								type="text" class="form-control p_input" 
								placeholder="Mecanico" readonly
								value="<?php echo $mecanico;?>"/>								
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
							style="width:90%; height:100px;"
							maxlength="300" readonly>
							<?php echo $Observaciones;?>
							</textarea>
						  </div>
						</div>
					</div>
				</div>
			</form>
		
           <h3 class="text-primary mb-4">Agregar Referencia</h3>
            
			<form id="referencia">  
				<input type="hidden" id="id_orden" name="id_orden" value="<?php echo $noOrden;?>" /> 
				<input type="hidden" id="id_referencia" name="id_referencia" value="<?php echo $id_referencia;?>" /> 
				<input type="hidden" id="desea" name="desea" value="" /> 
					  
				<div class="row mb-2">
					<div class="col-lg-12">
						
						<div class="card" style="width: 100% !important;">
							<div class="card-block">
								<table id="table_referencia" class="cell-border display" cellspacing="0"></table>
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
								placeholder="Cantidad"
								onblur="actualizaDatos()" />                                                 
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="TB_utilidad">% Utilidad Sobre el Valor Unitario</label>   
							<input id="TB_utilidad" 
								name="TB_utilidad" type="text" 
								class="form-control p_input" 
								placeholder="Utilidad"
								onblur="actualizaDatos()"/>                                                 
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="TB_valortotal">Valor Total</label>   
							<input id="TB_valortotal" 
								name="TB_valortotal" type="text" 
								class="form-control p_input" 
								placeholder="Valor Total"
								readonly />                                                 
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="TB_valortotalutilidad">Valor Total más Utilidad</label>   
							<input id="TB_valortotalutilidad" 
								name="TB_valortotalutilidad" type="text" 
								class="form-control p_input" 
								placeholder="Valor Total más Utilidad"
								readonly />                                                 
						</div>
					</div>
				</div>	
				<div class="text-center">
					<button onclick="mostrarReferenciasOrden($('#id_vehiculo').val(), 
								$('#TB_fechaDate').val(), 
								$('#TB_kilometraje').val(), 
								$('#TB_mecanico').val(),
								$('#TB_conductor').val(),
								$('#TB_observaciones').val(),
								<?php echo $noOrden;?>, 0)" type="button" class="btn btn-secondary" >Cancelar</button>
					<button onclick="agregarReferencia()" type="button" class="btn btn-primary" >Aceptar</button>
				</div>
            </form>
        </div>
        <script>			
						
			function separadorMiles(data)
			{				
				var number = data,
				thousand_separator = ',',
				decimal_separator = '.';

				var	number_string = number.toString(),
				split	  = number_string.split(decimal_separator),
				result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						
				if(split[1] != "")
				{
					result = split[1] != undefined ? result + decimal_separator + split[1] : result;
				}

				return result;
			}

			function actualizaDatos(){
			
				if(tableSelect != undefined)
				{
					table = tableSelect;
				}
				else{
					table = $('#table_referencia').DataTable().rows().data()[0];
				}
				
				cantidad = $("#TB_cantidad").val();	
				ValorUnitario = table.ValorUnitario;	
				utilidad = $("#TB_utilidad").val();	
				
				$("#TB_valortotal").val(separadorMiles(cantidad * ValorUnitario));
				$("#TB_valortotalutilidad").val(separadorMiles((cantidad * ValorUnitario) + (((utilidad * ValorUnitario)/100)) * cantidad ));				
			}	
			
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
			
			$("#TB_utilidad").keydown(function(event) {
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
	
	
	function verActividadesInfo($noOrden,
						$Placas,
						$Fecha,
						$Kilometraje,
						$mecanico,
						$conductor,
						$Observaciones)
	{
		?>                
		<meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 80% !important;">
			
			<h3 class="text-primary mb-4">Detalle Orden de Trabajo</h3>
			<br />
			<form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
								
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_orden">Número de Orden</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_orden" name="id_orden" 
								type="text" class="form-control p_input" 
								placeholder="No. Orden" 
								value="<?php echo $noOrden;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_vehiculo">Placa</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_vehiculo" name="id_vehiculo" 
								type="text" class="form-control p_input" 
								placeholder="Vehiculo" 
								value="<?php echo $Placas;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="TB_fechaDate" class="form-control p_input" 
							type="text" readonly 
							value="<?php echo $Fecha;?>">
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
							<input id="TB_kilometraje" name="TB_kilometraje" 
							type="text" class="form-control p_input" 
							placeholder="Kilometraje" readonly 
							value="<?php echo $Kilometraje;?>"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_conductor">Conductor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_conductor" name="TB_conductor" 
								type="text" class="form-control p_input" 
								placeholder="Conductor" readonly
								value="<?php echo $conductor;?>"/>								
                            </div>                                                      
                        </div>
                    </div>
				</div>
				
				<div class="row">					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_mecanico" name="TB_mecanico" 
								type="text" class="form-control p_input" 
								placeholder="Mecanico" readonly
								value="<?php echo $mecanico;?>"/>								
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
							style="width:90%; height:100px;"
							maxlength="300" readonly>
							<?php echo $Observaciones;?>
							</textarea>
						  </div>
						</div>
					</div>
				</div>
			</form>		
		
           <h3 class="text-primary mb-4">Agregar Actividades</h3>
            
			<form id="referencia">  
				<input type="hidden" id="id_orden" name="id_orden" value="<?php echo $noOrden;?>" /> 
				<input type="hidden" id="id_actividadOrden" name="id_actividadOrden" value="" /> 
				<input type="hidden" id="desea" name="desea" value="" /> 
					  
				<div class="row mb-2">
					<div class="col-lg-12">
						 <button id="B_crear" type="button" class="btn btn-primary" onclick="formularioCrearActividad()">Crear Nueva</button>
                            <br />
                            <br />
                            
						<div class="card">
							<div class="card-block">
								<table id="table_actividades" class="cell-border display" cellspacing="0"></table>
							</div>
						</div>
					</div>                    
				</div>  
            </form>			
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
                <button onclick="eliminarActividadOrden()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>  
        <?php
	}
	
	function CrearActividad($id_orden,
						$Placas,
						$Fecha,
						$Kilometraje,
						$mecanico,
						$conductor,
						$Observaciones)
	{
		?>
		<meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
		
			<h3 class="text-primary mb-4">Detalle Orden de Trabajo</h3>
			<br />
			<form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
								
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_orden">Número de Orden</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_orden" name="id_orden" 
								type="text" class="form-control p_input" 
								placeholder="No. Orden" 
								value="<?php echo $id_orden;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_vehiculo">Placa</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_vehiculo" name="id_vehiculo" 
								type="text" class="form-control p_input" 
								placeholder="Vehiculo" 
								value="<?php echo $Placas;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="TB_fechaDate2" class="form-control p_input" 
							type="text" readonly 
							value="<?php echo $Fecha;?>">
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
							<input id="TB_kilometraje" name="TB_kilometraje" 
							type="text" class="form-control p_input" 
							placeholder="Kilometraje" readonly 
							value="<?php echo $Kilometraje;?>"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_conductor">Conductor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_conductor" name="TB_conductor" 
								type="text" class="form-control p_input" 
								placeholder="Conductor" readonly
								value="<?php echo $conductor;?>"/>								
                            </div>                                                      
                        </div>
                    </div>
				</div>
				
				<div class="row">					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_mecanico" name="TB_mecanico" 
								type="text" class="form-control p_input" 
								placeholder="Mecanico" readonly
								value="<?php echo $mecanico;?>"/>								
                            </div>                                                      
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_observaciones2">Observaciones</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-thumbs-o-up"></i></span>
							<textarea id="TB_observaciones2" 
							name="TB_observaciones2" 
							class="form-control p_input" 
							placeholder="Observaciones" 
							style="width:90%; height:100px;"
							maxlength="300" readonly>
							<?php echo $Observaciones;?>
							</textarea>
						  </div>
						</div>
					</div>
				</div>
			</form>		
		
           <h3 class="text-primary mb-4">Agregar Actividad</h3>
            
           <form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
				<input type="hidden" id="id_orden" name="id_orden" value="<?php echo $id_orden;?>" />                                              
				<div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_actividad">Actividad</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_actividad" name="id_actividad" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_tiempo">Tiempo/Horas</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
							<input id="TB_tiempo" name="TB_tiempo" type="text" class="form-control p_input" placeholder="Tiempo" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <select style="width: 400px!important;" id="id_mecanico" name="id_mecanico" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
					</div>
					
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							
							<div class="input-group date form_datetime" data-link-field="TB_fecha" >
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input id="TB_fechaDate" class="form-control p_input" type="text" readonly >
							</div>
							
							<input id="TB_fecha" name="TB_fecha" type="hidden" />
							
							
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">					
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valor">Valor</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valor" name="TB_valor" type="text" 
							class="form-control p_input" placeholder="Valor" maxlength="11" 
							onblur="actualizarDatos();"/>
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_utilidad">% Utilidad</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_utilidad" name="TB_utilidad" type="text" 
							class="form-control p_input" placeholder="Utilidad" maxlength="11"
							onblur="actualizarDatos();" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">	
				
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valorTotalUtilidad">Valor Total + Utilidad</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valorTotalUtilidad" name="TB_valorTotalUtilidad" type="text" class="form-control p_input" placeholder="Valor + Utilidad" maxlength="11" readonly />
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
							style="width:90%; height:100px;"
							maxlength="500">
							</textarea>
						  </div>
						</div>
					</div>
				</div>
				
                <div class="text-center">
                    <button type="button" onclick="mostrarOrdenesActividades($('#id_orden').val(),
								   $('#id_vehiculo').val(), 
								   $('#TB_fechaDate2').val(), 
								   $('#TB_kilometraje').val(), 
								   $('#TB_mecanico').val(), 
								   $('#TB_conductor').val(), 
								   $('#TB_observaciones2').val(), 
								   0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarActividad()" class="btn btn-primary">Guardar</button>
                </div>
			</form>
		</div>
		<script>
		
		
			$("#TB_fecha").val(getDate());
			$("#TB_fechaDate").val(getDate());
			$('.form_datetime').datetimepicker({
				language:  'es',
				format: 'yyyy/mm/dd hh:ii',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				showMeridian: 1,
				date: new Date(),
				icons: {
				  time: "fa fa-clock-o",
				  date: "fa fa-calendar",
				  up: "fa fa-caret-up",
				  down: "fa fa-caret-down",
				  previous: "fa fa-caret-left",
				  next: "fa fa-caret-right",
				  today: "fa fa-today",
				  clear: "fa fa-clear",
				  close: "fa fa-close"
				}
			});
			
			function getDate()
			{
				var fecha = new Date();
				
				var dia = fecha.getDate();
				var mes = fecha.getMonth()+1 > 12 ? 1: fecha.getMonth()+1;
				var anio = fecha.getFullYear();
				var hora = fecha.getHours();
				var minutes = fecha.getMinutes();
				
				return anio+"/"+mes+"/"+dia+" "+hora+":"+minutes;
			}		
			
			function actualizarDatos()
			{
				var utilidad = parseInt($("#TB_utilidad").val());
				var valor = ($("#TB_valor").val());								
				valor = valor.replace(",","");
				
				var valorTotalUtilidad = ((parseFloat(valor) * (utilidad))/100);				
				
				valorTotalUtilidad = (parseFloat(valor) + parseFloat(valorTotalUtilidad));
				
				var number = valorTotalUtilidad	,
				thousand_separator = ',',
				decimal_separator = '.';

				var	number_string = number.toString(),
				split	  = number_string.split(decimal_separator),
				result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						
				if(split[1] != "")
				{
					result = split[1] != undefined ? result + decimal_separator + split[1] : result;
				}
				
				$("#TB_valorTotalUtilidad").val(result);
			}
			
			$("#TB_tiempo").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 188 || event.keyCode == 190)    
				{
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

			$("#TB_utilidad").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8 )    
				{
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
			
			$("#id_actividad").change(function() {
			
				id_actividad = ($("#id_actividad").val()); 
				
				if(id_actividad != "")
				{
					$.ajax({
						 url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
						 method: 'post',
						 dataType: 'json',
						 data: { 'desea': 'consultaTiempoActividad',
							'id_actividad': id_actividad
						 },
						 success: function (data) {   
								 if(data)
								 {
									$("#TB_tiempo").val(data);
								 }
								 else{
									 $("#mensaje").html("¡se genero un error al traer la información!");
									 mensaje.modal("show"); 
								 }
							 },
						 error: function(ex){
							console.log(ex);
						 }
					}); 
				}				
			});
		</script>
		<?php
	}
		
	function EditarActividad(
	$id,
	$id_orden, 
	$tiempoHoras, 
	$fecha, 
	$tb_valor, 
	$TB_utilidad,
	$TB_observaciones,
	$Placas,
	$Fecha2,
	$Kilometraje,
	$mecanico,
	$conductor,
	$Observaciones)
	{
		?>
		<meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
		
			<h3 class="text-primary mb-4">Detalle Orden de Trabajo</h3>
           <form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
								
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_orden">Número de Orden</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_orden" name="id_orden" 
								type="text" class="form-control p_input" 
								placeholder="No. Orden" 
								value="<?php echo $id_orden;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="id_vehiculo">Placa</label> 
						  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-automobile"></i></span>							
								<input id="id_vehiculo" name="id_vehiculo" 
								type="text" class="form-control p_input" 
								placeholder="Vehiculo" 
								value="<?php echo $Placas;?>"
								readonly />
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input id="TB_fechaDate2" class="form-control p_input" 
							type="text" readonly 
							value="<?php echo $Fecha2;?>">
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
							<input id="TB_kilometraje" name="TB_kilometraje" 
							type="text" class="form-control p_input" 
							placeholder="Kilometraje" readonly 
							value="<?php echo $Kilometraje;?>"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_conductor">Conductor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_conductor" name="TB_conductor" 
								type="text" class="form-control p_input" 
								placeholder="Conductor" readonly
								value="<?php echo $conductor;?>"/>								
                            </div>                                                      
                        </div>
                    </div>
				</div>
				
				<div class="row">					
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <input id="TB_mecanico" name="TB_mecanico" 
								type="text" class="form-control p_input" 
								placeholder="Mecanico" readonly
								value="<?php echo $mecanico;?>"/>								
                            </div>                                                      
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_observaciones2">Observaciones</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-thumbs-o-up"></i></span>
							<textarea id="TB_observaciones2" 
							name="TB_observaciones2" 
							class="form-control p_input" 
							placeholder="Observaciones" 
							style="width:90%; height:100px;"
							maxlength="300" readonly>
							<?php echo $Observaciones;?>
							</textarea>
						  </div>
						</div>
					</div>
				</div>
			</form>		
		   
		   <h3 class="text-primary mb-4">Editar Actividad</h3>
            
           <form id="ordentrabajo">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
				<input type="hidden" id="id_orden" name="id_orden" value="<?php echo $id_orden;?>" />                                              
				<input type="hidden" id="id_ActividadOrden" name="id_ActividadOrden" value="<?php echo $id;?>" />                                              
				<div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_actividad">Actividad</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_actividad" name="id_actividad" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_tiempo">Tiempo/Horas</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
							<input id="TB_tiempo" name="TB_tiempo" type="text" class="form-control p_input" placeholder="Tiempo"  value="<?php echo $tiempoHoras;?>"/>
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="id_mecanico">Mecánico</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>                                    
                                <select style="width: 400px!important;" id="id_mecanico" name="id_mecanico" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
					</div>
					
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_fecha">Fecha</label> 
						  <div class="input-group">
							
							<div class="input-group date form_datetime" data-link-field="TB_fecha" >
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input id="TB_fechaDate" class="form-control p_input" type="text" value="<?php echo $fecha;?>" readonly >
							</div>
							
							<input id="TB_fecha" name="TB_fecha" type="hidden" value="<?php echo $fecha;?>" />
							
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">					
					
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valor">Valor</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valor" name="TB_valor" type="text" 
							class="form-control p_input" placeholder="Valor" maxlength="11" 
							value="<?php echo $tb_valor;?>"
							onblur="actualizarDatos();"/>
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_utilidad">% Utilidad</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_utilidad" name="TB_utilidad" type="text" 
							class="form-control p_input" placeholder="Utilidad" maxlength="11"
							value="<?php echo $TB_utilidad;?>"
							onblur="actualizarDatos();" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">	
				
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valorTotalUtilidad">Valor Total + Utilidad</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valorTotalUtilidad" name="TB_valorTotalUtilidad" type="text" class="form-control p_input" placeholder="Valor + Utilidad" maxlength="11" readonly />
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
							style="width:90%; height:100px;"
							maxlength="500">
							<?php echo $TB_observaciones;?>
							</textarea>
						  </div>
						</div>
					</div>
				</div>
				
                <div class="text-center">
                    <button type="button" onclick="mostrarOrdenesActividades($('#id_orden').val(),
								   $('#id_vehiculo').val(), 
								   $('#TB_fechaDate2').val(), 
								   $('#TB_kilometraje').val(), 
								   $('#TB_mecanico').val(), 
								   $('#TB_conductor').val(), 
								   $('#TB_observaciones2').val(), 
								   0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarEditarActividad()" class="btn btn-primary">Guardar</button>
                </div>
			</form>
		</div>
		<script>
		
		
			$("#TB_fecha").val(getDate());
			$("#TB_fechaDate").val(getDate());
			$('.form_datetime').datetimepicker({
				language:  'es',
				format: 'yyyy/mm/dd hh:ii',
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				showMeridian: 1,
				date: new Date(),
				icons: {
				  time: "fa fa-clock-o",
				  date: "fa fa-calendar",
				  up: "fa fa-caret-up",
				  down: "fa fa-caret-down",
				  previous: "fa fa-caret-left",
				  next: "fa fa-caret-right",
				  today: "fa fa-today",
				  clear: "fa fa-clear",
				  close: "fa fa-close"
				}
			});
			
			function getDate()
			{
				var fecha = new Date();
				
				var dia = fecha.getDate();
				var mes = fecha.getMonth()+1 > 12 ? 1: fecha.getMonth()+1;
				var anio = fecha.getFullYear();
				var hora = fecha.getHours();
				var minutes = fecha.getMinutes();
				
				return anio+"/"+mes+"/"+dia+" "+hora+":"+minutes;
			}		
			
			function actualizarDatos()
			{
				var utilidad = parseInt($("#TB_utilidad").val());
				var valor = ($("#TB_valor").val());								
				valor = valor.replace(",","");
				
				var valorTotalUtilidad = ((parseFloat(valor) * (utilidad))/100);				
				
				valorTotalUtilidad = (parseFloat(valor) + parseFloat(valorTotalUtilidad));
				
				var number = valorTotalUtilidad	,
				thousand_separator = ',',
				decimal_separator = '.';

				var	number_string = number.toString(),
				split	  = number_string.split(decimal_separator),
				result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						
				if(split[1] != "")
				{
					result = split[1] != undefined ? result + decimal_separator + split[1] : result;
				}
				
				$("#TB_valorTotalUtilidad").val(result);
			}
			
			actualizarDatos();
			
			$("#TB_tiempo").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 188 || event.keyCode == 190)    
				{
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

			$("#TB_utilidad").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8 )    
				{
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
			
			$("#id_actividad").change(function() {
			
				id_actividad = ($("#id_actividad").val()); 
				
				if(id_actividad != "")
				{
					$.ajax({
						 url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
						 method: 'post',
						 dataType: 'json',
						 data: { 'desea': 'consultaTiempoActividad',
							'id_actividad': id_actividad
						 },
						 success: function (data) {   
								 if(data)
								 {
									$("#TB_tiempo").val(data);
								 }
								 else{
									 $("#mensaje").html("¡se genero un error al traer la información!");
									 mensaje.modal("show"); 
								 }
							 },
						 error: function(ex){
							console.log(ex);
						 }
					}); 
				}				
			});
		</script>
		<?php
	}
}
?>