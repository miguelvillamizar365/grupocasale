<?php

/**
 * referencias presentación
 * @author miguel villamizar
 * @copyright 2017/11/13
 */

class Referencias{
    
    function mostrarReferencias(){
    
		header('Content-Type:text/html; charset=iso-8859-1');
		?>  
        
        <input type="hidden" id="id_referencia" name="id_referencia" value="" /> 
        <div class="content-wrapper" style="width: 65% !important;">
            <h3 class="text-primary mb-4">Referencias</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearReferencias()">Crear Nueva</button>
                            <br />
                            <br />
                            
                            <table id="table_referencias" class="cell-border display" cellspacing="0"></table>
							
							<label id="L_total" name="L_total" text="0" >0.00</label>
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
                <button onclick="eliminarReferencias()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>      
         
    <?php
    }
    
    function formularioCrear()
    {
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>
        
        <div class="content-wrapper" style="width: 90% !important;">
            <h3 class="text-primary mb-4">Agregar Referencia</h3>            
           <form id="referencia">                
                <input type="hidden" id="desea" name="desea" value="" /> 

				<div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_referencia">Código Referencia</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                            <input id="TB_referencia" name="TB_referencia" type="text" class="form-control p_input" placeholder="Código Referencia" maxlength="50" />
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_nombre">Nombre de referencia</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                            <input id="TB_nombre" name="TB_nombre" type="text" class="form-control p_input" placeholder="Nombre de referencia" maxlength="50" />
                          </div>
                        </div>
                    </div>
                </div>		
				
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_tipoempaque">Empaque</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>                                    
                                <select style="width: 400px!important;" id="id_tipoempaque" name="id_tipoempaque" class="show-tick form-control" >                                   
                                </select>
                            </div>
                                                      
                        </div>
                    </div>
					
					<div class="col-md-6">
                        <div class="form-group">                            
                            <label for="id_clasificacion">Clasificación</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>                                    
                                <select style="width: 400px!important;" id="id_clasificacion" name="id_clasificacion" class="show-tick form-control">                                   
                                </select>
                            </div>   
                        </div>
                    </div>
                </div>
                
                <div class="row">
                                         
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="TB_stante">Stante</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                            <input id="TB_stante" name="TB_stante" type="text" class="form-control p_input" placeholder="Stante" maxlength="50"/>
                          </div>
                        </div>
                    </div>
					
					<div class="col-md-6">
                        <div class="form-group">
                        <label for="TB_piso">Piso</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-institution"></i></span>
                            <input id="TB_piso" name="TB_piso" type="text" class="form-control p_input" placeholder="Piso" maxlength="50" />
                          </div>
                        </div>
                    </div>
                </div>                
                            
                <div class="text-center">
                    <button type="button" onclick="mostrarReferencias(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="guardarReferencias()" class="btn btn-primary">Guardar</button>
                </div>
              </form>                          
        </div>
                
        <?php
    }
    
    
    function formularioEditar($Id, $Codigo, $Nombre, $Piso, $Stante)
    {
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>
     
        <div class="content-wrapper" style="width: 90% !important;">
            <h3 class="text-primary mb-4">Editar Referencia</h3>            
           <form id="editarReferencia">                
                
                <input type="hidden" id="desea" name="desea" value="" />  
                <input type="hidden" id="id_referencia" name="id_referencia" value="<?php echo $Id;?>" />                                              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_referencia">Código Referencia</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                            <input id="TB_referencia" name="TB_referencia" type="text" class="form-control p_input" placeholder="Código Referencia" maxlength="50" value="<?php echo $Codigo;?>" />
                          </div>
                        </div>
                    </div>
                    
                     <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_nombre">Nombre de referencia</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                            <input id="TB_nombre" name="TB_nombre" type="text" class="form-control p_input" placeholder="Nombre de referencia" maxlength="50" value="<?php echo $Nombre;?>" />
                          </div>
                        </div>
                    </div>
                </div>		
				<div class="row">
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_tipoempaque">Empaque</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>                                    
                                <select style="width: 400px!important;" id="id_tipoempaque" name="id_tipoempaque" class="show-tick form-control" >                                   
                                </select>
                            </div>
                        </div>
                    </div>
					
					 <div class="col-md-6">
                        <div class="form-group">                            
                            <label for="id_clasificacion">Clasificación</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>                                    
                                <select style="width: 400px!important;" id="id_clasificacion" name="id_clasificacion" class="show-tick form-control" >                                   
                                </select>
                            </div>   
                        </div>
                    </div>
                </div>
                
                <div class="row">
                                        
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="TB_stante">Stante</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                            <input id="TB_stante" name="TB_stante" type="text" class="form-control p_input" placeholder="Stante" maxlength="50" value="<?php echo $Stante;?>" />
                          </div>
                        </div>
                    </div>
					
					<div class="col-md-6">
                        <div class="form-group">
                        <label for="TB_piso">Piso</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-institution"></i></span>
                            <input id="TB_piso" name="TB_piso" type="text" class="form-control p_input" placeholder="Piso" maxlength="50" value="<?php echo $Piso;?>" />
                          </div>
                        </div>
                    </div>
                </div>                
                             
                <div class="text-center">
                    <button type="button" onclick="mostrarReferencias(0)" class="btn btn-secondary">Atrás</button>
                    <button type="button" onclick="editarReferencias()" class="btn btn-primary">Editar</button>
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
    
    
    function mensajeImprimirReferencia($articulo, $stante, $Piso, $imagen, $Id_referencia, $url)
    {
        ?>
        <meta charset="iso-8859-1" />
        <div class="modal fade" id="mensajeImprimirReferencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">                    
                     <div class="form-group">                        
                        <label><b>Articulo:</b></label>
                        <label>
                        <?php
                            echo $articulo;
                        ?> 
                        </label>                    
                     </div>
                    </div>
                    
                    <div class="col-md-6">
                     <div class="form-group">
                        <label><b>Stante:</b></label>
                        <label>
                        <?php
                            echo $stante;
                        ?>
                        </label>  
                    </div>
                    </div>
                </div>
                <div class="row">                
                    <div class="col-md-12">
                     <div class="form-group">
                        <label><b>Piso:</b></label>
                        <label>
                        <?php
                            echo $Piso;
                        ?>
                        </label>  
                    </div>
                    </div>
                </div>
                 <div class="row">                
                    <div class="col-md-12" style="text-align: center;">
                    <?php
                        echo $imagen;
                    ?>
                    <br />
                    <?php
                        echo $Id_referencia;
                    ?>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" onclick="<?php echo $url?>" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                <form action="../Logica de presentacion/Referencia_Logica.php" method="post" target="_blank" >
                
                    <input type="hidden" id="Id" name="Id" value="<?php echo $Id_referencia; ?>" />
                    <input type="hidden" id="articulo" name="articulo" value="<?php echo $articulo; ?>" />
                    <input type="hidden" id="stante" name="stante" value="<?php echo $stante; ?>" />
                    <input type="hidden" id="piso" name="piso" value="<?php echo $Piso; ?>" />
                    <input type="hidden" id="desea" name="desea" value="exportarReferencia" />
                    
                    <button type="submit" class="btn btn-primary" >Exportar Pdf</button>
                </form>
              </div>
            </div>
          </div>
        </div>   
        <script>
        
    		$("#mensajeImprimirReferencia").modal("show");
            
        </script>
        <?php
    }
    
    
    function exportarPdf($articulo, $stante, $Piso, $imagen, $Id_referencia )
    {
       return "<table border='1'>
                <tr>                    
                    <td>                        
                        <label><b>Articulo:</b></label>
                    </td>
                    <td>
                        <label>"
                        . $articulo . 
                        "</label>
                    </td>       
                </tr>             
                <tr>
                    <td>
                        <label><b>Stante:</b></label>
                    </td>
                    <td>                    
                        <label>
                        "
                         . $stante .
                        "
                        </label>
                    </td>  
                </tr>
                <tr>
                    <td>
                        <label><b>Piso:</b></label>
                    </td>
                    <td>
                        <label>"
                         . $Piso .
                        "</label>
                    </td>  
                </tr>            
                <tr> 
                    <td>            
                        <div style='text-align: center;'>
                        " .$imagen ."
                        <br />
                        ". $Id_referencia .
                        "
                    </td>
                </tr>
        </table>";         
    }
}


?>