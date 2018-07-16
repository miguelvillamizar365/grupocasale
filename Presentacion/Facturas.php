<?php

/**
 * 
 * manejo de la presentación de las facturas
 * @author Miguel Villamizar 
 * @copyright 09/12/2017
 */

class Facturas
{
    function mostrarFacturas()
    {
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>                
        <input type="hidden" id="id_factura" name="id_factura" value="" /> 
        <div class="content-wrapper" style="width: 80% !important;">
            <h3 class="text-primary mb-4">Facturas</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearFacturas()">Crear Nueva</button>
                            <br />
                            <br />
                            
                            <table id="table_facturas" class="display" cellspacing="0"></table>
							
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
    
		header('Content-Type:text/html; charset=iso-8859-1');
    ?>
	
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Agregar Factura</h3>
            
           <form id="factura">                
                <input type="hidden" id="desea" name="desea" value="" />                                              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_empresaCompra">Empresa que compra</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_empresaCompra" name="id_empresaCompra" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_proveedor">Proveedor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_proveedor" name="id_proveedor" class="show-tick form-control" >                                   
                                </select>
                            </div>
                                                      
                        </div>
                    </div>
                </div>

                <div class="row">
                                        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_modopago">Modo de pago</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>                                    
                                <select style="width: 400px!important;" id="id_modopago" name="id_modopago" class="show-tick form-control" >                                   
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
               
                <div class="text-center">
                    <button type="button" onclick="mostrarFacturas(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarFacturas()" class="btn btn-primary">Guardar</button>
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
			
			
			function ActualizarCambios()
			{
				var number = $("#TB_valor").val().replace(",", ""),
					thousand_separator = ',',
					decimal_separator = '.';
					
				var	number_string = number.toString(),
				split	  = number_string.split(decimal_separator),
				result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
				if(split[1] != "")
				{
					result = split[1] != undefined ? result + decimal_separator + split[1] : result;
				}

				$("#TB_valor").val(result);
			}
			
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
		</script>
    <?php        
    }
    
    
    function formularioEditar($numeroFactura, $valorFactura, $Fecha ){
    
		header('Content-Type:text/html; charset=iso-8859-1');
    ?>
        <div class="content-wrapper" style="width: 90% !important;">
            <h3 class="text-primary mb-4">Editar Factura</h3>
            
           <form id="factura">                
                <input type="hidden" id="id_factura" name="id_factura" value="<?php echo $numeroFactura;?>" />  
                <input type="hidden" id="desea" name="desea" value="" />                                              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_empresaCompra">Empresa que compra</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_empresaCompra" name="id_empresaCompra" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_proveedor">Proveedor</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>                                    
                                <select style="width: 400px!important;" id="id_proveedor" name="id_proveedor" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
                </div>

                <div class="row">                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_modopago">Modo de pago</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>                                    
                                <select style="width: 400px!important;" id="id_modopago" name="id_modopago" class="show-tick form-control" >                                   
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
								<input id="TB_fechaDate" class="form-control p_input" value="<?php echo $Fecha;?>" type="text" readonly >
							</div>
							
							<input id="TB_fecha" name="TB_fecha" value="<?php echo $Fecha;?>" type="hidden" />
                          </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="button" onclick="mostrarFacturas(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="editarFacturas()" class="btn btn-primary">Guardar</button>
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
			
			
			function ActualizarCambios()
			{
				var number = $("#TB_valor").val().replace(",", ""),
					thousand_separator = ',',
					decimal_separator = '.';
					
				var	number_string = number.toString(),
				split	  = number_string.split(decimal_separator),
				result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
				if(split[1] != "")
				{
					result = split[1] != undefined ? result + decimal_separator + split[1] : result;
				}

				$("#TB_valor").val(result);
			}
			
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
		</script>
    <?php        
    }
    
    
    
    function mensajeRedirect($mensaje, $url)
    {
		header('Content-Type:text/html; charset=iso-8859-1');
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
    
    function detalleFactura($id_factura)
    {
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>        
        <input type="hidden" id="id_factura" name="id_factura" value="" /> 
		<input type="hidden" id="id_referenciafac" name="id_referenciafac" value="" /> 
        <div class="content-wrapper" style="width: 80% !important;">
            <h3 class="text-primary mb-4">Referencias de la Factura</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">                    
                    <div class="card">
                        <div class="card-block">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearReferenciasFacturas()">Crear Nueva</button>
                            <br />
                            <br />
                            
                            <table id="table_reffacturas" class="display" cellspacing="0"></table>
							
							
							<br />
                            <br />
							<label id="totalFactura" style="font-weight: bold;" />
                        </div>
                    </div>
                </div>                    
            </div>               
        </div>   
        
        <div class="modal fade" id="mensajeConfirmaReferencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div id="mensajeConfRef">
                
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button onclick="eliminarReferenciaFactura()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>
        <script>
            $("#id_factura").val("<?php echo $id_factura?>");
        </script>  
        <?php
    }
	
	function crearReferenciaFacturas($id_factura)
	{
		header('Content-Type:text/html; charset=iso-8859-1');
		?>
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Agregar Referencia de la Factura</h3>
            
           <form id="referenciafactura">                
                <input type="hidden" id="desea" name="desea" value="" />   
				<input type="hidden" id="id_factura" name="id_factura" value="" />   				
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_referencia">Referencia</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>                                    
                                <select style="width: 400px!important;" id="id_referencia" name="id_referencia" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_tipoempaque">Tipo Empaque</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>                                    
                                <select style="width: 400px!important;" id="id_tipoempaque" name="id_tipoempaque" class="show-tick form-control" >                                   
                                </select>
                            </div>                 
                        </div>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_cantidad">Cantidad</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-database"></i></span>
							<input id="TB_cantidad" name="TB_cantidad" type="text" 
							class="form-control p_input" placeholder="Cantidad" 
							value="" maxlength="10" onblur="actualizarCalculos()"  />
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valorUnitario">Valor Unitario</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valorUnitario" name="TB_valorUnitario" 
							type="text" class="form-control p_input" 
							placeholder="Valor Unitario" value=""  maxlength="11" 
							onblur="actualizarCalculos()" />
						  </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_descuento">Descuento %</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_descuento" name="TB_descuento" type="text" 
							class="form-control p_input" placeholder="Descuento" 
							value=""  maxlength="10" onblur="actualizarCalculos()"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-2">
						<label class="form-check-label">
							<input id="CB_iva" name="CB_iva" type="checkbox" 
							class="form-check-input" checked="true">
							¿Lo asume?
						</label>
					</div>

					<div class="col-md-4">
						<div class="form-group">
						  <label for="TB_iva">Iva %</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_iva" name="TB_iva" type="text" 
							class="form-control p_input" placeholder="Iva" value=""  
							maxlength="11" onblur="actualizarCalculos()" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valortotal">Valor Total</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valortotal" name="TB_valortotal" type="text" class="form-control p_input" placeholder="Valor Total" value="0" maxlength="11" disabled />
						  </div>
						</div>
					</div>
				</div>

                <div class="text-center">
                    <button type="button" onclick="atrasCrearReferenciaFactura(<?php echo $id_factura; ?>)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarReferenciaFactura()" class="btn btn-primary">Guardar</button>
                </div>
           </form>
        </div>   
		<script>
					
		$(document).ready(function(){
			$("#id_factura").val(<?php echo $id_factura; ?>);
			 
			 $('#CB_iva').change(function () {
				$("#TB_iva").val("0");
				actualizarCalculos();				 
			 });
			 
			
			$("#TB_valorUnitario").keydown(function(event) {
				
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
			
			$('input#TB_valorUnitario').keyup(function(event) {
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
			
					
			$("#TB_descuento").keydown(function(event) {
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
			
					
			$("#TB_iva").keydown(function(event) {
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
		});
		</script>
		<?php		
	}
	
	function editarReferenciaFacturas(
				$id_referenciafac,
				$id_factura,
				$cantidad,
				$valorunitario,
				$descuento,
				$asumeiva,
				$iva,
				$valortotal )		
	{
		
		header('Content-Type:text/html; charset=iso-8859-1');
		?>
        <div class="content-wrapper" style="width: 90% !important;">
           <h3 class="text-primary mb-4">Editar Referencia de la Factura</h3>
            
           <form id="referenciafactura">                
                <input type="hidden" id="desea" name="desea" value="" />   
				<input type="hidden" id="id_factura" name="id_factura" value="<?php echo $id_factura;?>" />   
				<input type="hidden" id="id_referenciafac" name="id_referenciafac" value="<?php echo $id_referenciafac;?>" />   				
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_referencia">Referencia</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>                                    
                                <select style="width: 400px!important;" id="id_referencia" name="id_referencia" class="show-tick form-control" >                                   
                                </select>
                            </div>                                                      
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_tipoempaque">Tipo Empaque</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>                                    
                                <select style="width: 400px!important;" id="id_tipoempaque" name="id_tipoempaque" class="show-tick form-control" >                                   
                                </select>
                            </div>                 
                        </div>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_cantidad">Cantidad</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-database"></i></span>
							<input id="TB_cantidad" name="TB_cantidad" type="text" 
							class="form-control p_input" placeholder="Cantidad" 
							value="<?php echo $cantidad;?>" maxlength="10" onblur="actualizarCalculos()"  />
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valorUnitario">Valor Unitario</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valorUnitario" name="TB_valorUnitario" 
							type="text" class="form-control p_input" 
							placeholder="Valor Unitario" value="<?php echo $valorunitario;?>"  maxlength="11" 
							onblur="actualizarCalculos()" />
						  </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_descuento">Descuento %</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_descuento" name="TB_descuento" type="text" 
							class="form-control p_input" placeholder="Descuento" 
							value="<?php echo $descuento;?>"  maxlength="10" onblur="actualizarCalculos()"/>
						  </div>
						</div>
					</div>
					
					<div class="col-md-2">
						<label class="form-check-label">
							<input id="CB_iva" name="CB_iva" type="checkbox" 
							class="form-check-input" <?php if($asumeiva == "Si"){echo "checked";}else {echo "";}?> />
							¿Lo asume?
						</label>
					</div>

					<div class="col-md-4">
						<div class="form-group">
						  <label for="TB_iva">Iva %</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_iva" name="TB_iva" type="text" 
							class="form-control p_input" placeholder="Iva"
							value="<?php echo $iva;?>"  
							maxlength="11" onblur="actualizarCalculos()" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valortotal">Valor Total</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valortotal" name="TB_valortotal" 
							type="text" class="form-control p_input" 
							placeholder="Valor Total" 
							value="<?php echo $valortotal; ?>" maxlength="11" disabled />
						  </div>
						</div>
					</div>
				</div>

                <div class="text-center">
                    <button type="button" onclick="atrasCrearReferenciaFactura(<?php echo $id_factura; ?>)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="editarReferenciaFactura()" class="btn btn-primary">Editar</button>
                </div>
           </form>
        </div>   
		<script>
					
		$(document).ready(function(){
			$("#id_factura").val(<?php echo $id_factura; ?>);
			 
			 $('#CB_iva').change(function () {
				$("#TB_iva").val("0");
				actualizarCalculos();				 
			 });
			 			
			$("#TB_valorUnitario").keydown(function(event) {
				
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
			
			$('input#TB_valorUnitario').keyup(function(event) {
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
			
			$("#TB_descuento").keydown(function(event) {
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
			
					
			$("#TB_iva").keydown(function(event) {
				if(event.shiftKey)
				{
					event.preventDefault();
				}

				if (event.keyCode == 46 || event.keyCode == 8){
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
		});
		</script>
		<?php		
	}
}


?>