<?php

/**
 * referencias presentación
 * @author miguel villamizar
 * @copyright 2017/11/13
 */

class Referencias{
    
    function mostrarReferencias(){
    ?>  
        <meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
            <h3 class="text-primary mb-4">Referencias</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            <button type="button" class="btn btn-primary" onclick="formularioCrearReferencias()">Crear Nueva</button>
                            <br />
                            <br />
                            
                            <table id="table_referencias" class="display" cellspacing="0"></table>
                        </div>
                    </div>
                </div>                    
            </div>               
        </div>        
         
    <?php
    }
    
    function formularioCrear()
    {
        ?>
        
        <meta charset="iso-8859-1" />
        <div class="content-wrapper" style="width: 90% !important;">
            <h3 class="text-primary mb-4">Agregar Referencia</h3>
            
           <form id="referencia">
                
                <input type="hidden" id="desea" name="desea" value="" />                                              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="TB_nombre">Nombre de referencia</label> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                            <input id="TB_nombre" name="TB_nombre" type="text" class="form-control p_input" placeholder="Nombre de referencia" />
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_tipoempaque">Empaque</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>                                    
                                <select style="width: 400px!important;" id="id_tipoempaque" name="id_tipoempaque" class="">                                   
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            
                            <label for="id_clasificacion">Clasificación</label>   
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>                                    
                                <select style="width: 400px!important;" id="id_clasificacion" name="id_clasificacion" class="">                                   
                                </select>
                            </div>   
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="TB_stante">Stante</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                            <input id="TB_stante" name="TB_stante" type="text" class="form-control p_input" placeholder="Stante" />
                          </div>
                        </div>
                    </div>
                </div>                

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="TB_piso">Piso</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-institution"></i></span>
                            <input id="TB_piso" name="TB_piso" type="text" class="form-control p_input" placeholder="Piso" />
                          </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="TB_stock">Stock</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-folder-o"></i></span>
                            <input id="TB_stock" name="TB_stock" type="text" class="form-control p_input" placeholder="Stock" />
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
}


?>