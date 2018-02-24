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
        ?>        
        <meta charset="iso-8859-1" />
        
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
    
    ?>
        <meta charset="iso-8859-1" />
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
                          <label for="TB_valor">Valor de la factura</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                            <input id="TB_valor" name="TB_valor" type="text" class="form-control p_input" placeholder="Valor de la factura" />
                          </div>
                        </div>
                    </div>
                    
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
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_fecha">Fecha</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input id="TB_fecha" name="TB_fecha" type="text" class="form-control p_input" placeholder="fecha" />
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                                                                              
                        </div>
                    </div>
                </div>
                 <div class="text-center">
                    <button type="button" onclick="mostrarFacturas(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarFacturas()" class="btn btn-primary">Guardar</button>
                </div>
           </form>
        </div>   
    <?php        
    }
    
    
    function formularioEditar($numeroFactura, $valorFactura, $Fecha ){
    
    ?>
        <meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
            <h3 class="text-primary mb-4">Editar Factura</h3>
            
           <form id="factura">                
                <input type="hidden" id="id" name="id" value="<?php echo $numeroFactura;?>" />  
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
                          <label for="TB_valor">Valor de la factura</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                            <input id="TB_valor" name="TB_valor" type="text" class="form-control p_input" placeholder="Valor de la factura" value="<?php echo $valorFactura;?>" />
                          </div>
                        </div>
                    </div>
                    
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
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_fecha">Fecha</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input id="TB_fecha" name="TB_fecha" type="text" class="form-control p_input" placeholder="fecha" value="<?php echo $Fecha;?>" />
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                                                                              
                        </div>
                    </div>
                </div>
                 <div class="text-center">
                    <button type="button" onclick="mostrarFacturas(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarFacturas()" class="btn btn-primary">Guardar</button>
                </div>
           </form>
        </div>   
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
    
    function detalleFactura($id_factura)
    {
        ?>
        <meta charset="iso-8859-1" />
        
        <input type="hidden" id="id_factura" name="id_factura" value="" /> 
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
        <script>
            $("#id_factura").val("<?php echo $id_factura?>");
        </script>  
        <?php
    }
	
	function crearReferenciaFacturas($id_factura)
	{
		?>
		<meta charset="iso-8859-1" />
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
							<input id="TB_cantidad" name="TB_cantidad" type="text" class="form-control p_input" placeholder="Cantidad" value="" maxlength="10" />
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valorUnitario">Valor Unitario</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valorUnitario" name="TB_valorUnitario" type="text" class="form-control p_input" placeholder="Valor Unitario" value=""  maxlength="11" />
						  </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_descuento">Descuento</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_descuento" name="TB_descuento" type="text" class="form-control p_input" placeholder="Descuento" value=""  maxlength="10" />
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_iva">Iva</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_iva" name="TB_iva" type="text" class="form-control p_input" placeholder="Iva" value=""  maxlength="11" />
						  </div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_utilidad">Utilidad</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_utilidad" name="TB_utilidad" type="text" class="form-control p_input" placeholder="Utilidad" value="" maxlength="11" />
						  </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						  <label for="TB_valortotal">Valor Total</label> 
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
							<input id="TB_valortotal" name="TB_valortotal" type="text" class="form-control p_input" placeholder="Valor Total" value="" maxlength="11" />
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
		$("#id_factura").val(<?php echo $id_factura; ?>);
	
		$('input#TB_valorUnitario').blur(function(){
			
		 var num = parseFloat($(this).val());
		 var cleanNum = num.toFixed(2);
		 $(this).val(cleanNum);
		 if(num/cleanNum < 1){
			$('#error').text('Por favor ingrese solo dos decimales!');
			}
         });
		 
		 $('input#TB_valortotal').blur(function(){
		 var num = parseFloat($(this).val());
		 var cleanNum = num.toFixed(2);
		 $(this).val(cleanNum);
		 if(num/cleanNum < 1){
			$('#error').text('Por favor ingrese solo dos decimales!');
			}
         });
		 
		 
		
		</script>
		<?php		
	}
}


?>