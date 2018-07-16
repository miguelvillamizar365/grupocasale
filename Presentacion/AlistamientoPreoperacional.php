<?php

class AlistamientoPreoperacional
{
	function mostrarAlistamiento()
	{   
	?>                
        <meta charset="iso-8859-1" />
        
        <input type="hidden" id="id_alistamiento" name="id_alistamiento" value="" /> 
        <div class="content-wrapper" style="width: 80% !important;">
            <h3 class="text-primary mb-4">Alistamiento Preoperacional</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearAlistamiento()">Agregar Inspección</button>
                            <br />
                            <br />
                            
                            <table id="table_alistamiento" class="display" cellspacing="0"></table>
							
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
                <button onclick="eliminarFactura()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>   
        <?php
	}
	
	
    function formularioCrear(){
    
		?>	
        <meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Agregar Alistamiento</h3>
            
           <form id="alistamiento">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_vehiculo">Placas</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-truck"></i></span>                                    
                                <select style="width: 400px!important;" id="id_vehiculo" name="id_vehiculo" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_fecha">Fecha</label> 						   
							<div class="input-group date form_datetime" data-link-field="TB_fecha" >
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input id="TB_fechaDate" class="form-control p_input" type="text" readonly >
							</div>							
							<input id="TB_fecha" name="TB_fecha" type="hidden" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_kilometraje">Kilometraje</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tachometer"></i></span>
                            <input id="TB_kilometraje" name="TB_kilometraje" type="text" class="form-control p_input" placeholder="Kilometraje" maxlength="50" />
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
							maxlength="50"
							style="width:90%; height:100px;"}>
							</textarea>
						  </div>
						</div>
					</div>
                </div>
				
				<div class="row" >
					<div class="col-md-12">   
						<div class="card">
							<div class="card-block" style="width: 80% !important;">
								
								<h4 class="text-primary mb-4">Seleccione los tipos de alistamiento:</h4>
		
								<br />
								<br />
								
								<table id="table_alistamientoCheckList" class="display" cellspacing="0" >
								   <thead>
									  <tr>
										 <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
										 <th>Id</th>
										 <th>Descripcion</th>
									  </tr>
								   </thead>
								   <tfoot>
									  <tr>
										 <th></th>
										 <th>Id</th>
										 <th>Descripcion</th>
									  </tr>
								   </tfoot>
								</table>

							</div>
						</div>
					</div>
				</div> 
                <div class="text-center">
                    <button type="button" onclick="mostrarAlistamiento(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarAlistamiento()" class="btn btn-primary">Guardar</button>
                </div>
           </form>
        </div>   
		<script>			
 
		$(document).ready(function(){
			
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
		});
			
		</script>
    <?php        
    }
	
    function formularioEditar(){
    
		?>	
        <meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Editar Alistamiento</h3>
            
           <form id="alistamiento">                
                <input type="hidden" id="desea" name="desea" value="" />       
                <input type="hidden" id="IdAlistamiento" name="IdAlistamiento" value="" />                                              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_vehiculo">Placas</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-truck"></i></span>                                    
                                <select style="width: 400px!important;" id="id_vehiculo" name="id_vehiculo" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_fecha">Fecha</label> 
                          <div class="input-group date form_datetime" data-link-field="TB_fecha" >
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input id="TB_fechaDate" class="form-control p_input" type="text" readonly >
							</div>							
							<input id="TB_fecha" name="TB_fecha" type="hidden" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_kilometraje">Kilometraje</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tachometer"></i></span>
                            <input id="TB_kilometraje" name="TB_kilometraje" type="text" class="form-control p_input" placeholder="Kilometraje" maxlength="50" />
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
							style="width:90%; height:100px;">
							</textarea>
						  </div>
						</div>
					</div>
                </div>
				
				<div class="row">
					<div class="col-md-12">   
						<div class="card">
							<div class="card-block">
								
								<h4 class="text-primary mb-4">Seleccione los tipos de alistamiento:</h4>
		
								<br />
								<br />
								
								<table id="table_alistamientoCheckList" class="display" cellspacing="0" >
								   <thead>
									  <tr>
										 <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
										 <th>Id</th>
										 <th>Descripcion</th>
									  </tr>
								   </thead>
								   <tfoot>
									  <tr>
										 <th></th>
										 <th>Id</th>
										 <th>Descripcion</th>
									  </tr>
								   </tfoot>
								</table>

							</div>
						</div>
					</div>
				</div> 
                <div class="text-center">
                    <button type="button" onclick="mostrarAlistamiento(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="editarAlistamiento()" class="btn btn-primary">Editar</button>
                </div>
           </form>
        </div>   
		<script>			
 
		$(document).ready(function(){
			
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
		});
			
		</script>
    <?php        
    }
	
	
    function mensajeRedirect($mensaje, $url) 
    {
        ?>
        <meta charset="iso-8859-1" />
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
	
}

?>