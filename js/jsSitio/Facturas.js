 
 // manejo pantalla factura
 // @author miguel villamizar
 // @copyright 2017/12/09
 //
 
 
$(document).ready(function(){


    $('#table_facturas').DataTable({
        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
            { data: "NumeroFactura",    title: "No. Factura",   },
            { data: "empresaId",    title: "Empresa que compra", visible:"false"},
            { data: "EmpresaCompra",    title: "Empresa que compra",},
            { data: "ValorFactura",     title: "Valor Factura",   },
            { data: "proveedorId",        title: "Proveedor", visible:"false"},
            { data: "proveedor",        title: "Proveedor",   },
            { data: "modopagoId",         title: "Modo de pago", visible:"false"},
            { data: "modopago",         title: "Modo de pago",      },
            { data: "Fecha",            title: "Fecha",            },
            { 
                title: "Editar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_editar btn btn-primary' >Editar</button>";
                }
            },
            { 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_eliminar btn btn-secondary' >Eliminar</button>";
                }  
            },
            { 
                title: "Ver Detalle",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_detalle btn btn-danger' >Detalle</button>";
                }  
            }
        ]
    });
    
    $.ajax({
        url: '../Logica de presentacion/Factura_Logica.php',
    	type:  'post',
    	dataType:'json',
    	data: {'desea': 'cargaFacturas'},
    	success:  function (data) {
    	     
            $('#table_facturas').DataTable().clear().draw().rows.add(data).draw();
    	},
        error: function(ex){
            console.log(ex);
        }
    });    
 });
 

$('#table_facturas').on('click', 'td .A_editar', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_facturas').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/Factura_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'editarFactura', 
               "NumeroFactura": dataItem.NumeroFactura, 
               "ValorFactura":dataItem.ValorFactura, 
               "Fecha": dataItem.Fecha },
    	success:  function (data) {  
            $('.dashboard').html(data);
            cargarListasDesplegables(dataItem.empresaId, dataItem.proveedorId, dataItem.modopagoId);
                        
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});
    
    

$('#table_facturas').on( 'click', 'td .A_eliminar', function (e) {
            
    e.preventDefault();

    var table = $('#table_facturas').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
            
    $("#id_factura").val(dataItem.NumeroFactura);
    $("#mensajeConf").html("¿Esta seguro de eliminar el registro?");
	$("#mensajeConfirma").modal("show");
    
});
 
 
$('#table_facturas').on( 'click', 'td .A_detalle', function (e) {
            
    e.preventDefault();

    var table = $('#table_facturas').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
            
    
    $.ajax({
        url: '../Logica de presentacion/Factura_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'detalleFactura', 
               "id_factura": dataItem.NumeroFactura},
    	success:  function (data) {  
            $('.dashboard').html(data);   
            cargarRefFacturas();                     
    	},
        error: function(ex){
            console.log(ex);
        }
    });    
});

function cargarRefFacturas()
{
        $('#table_reffacturas').DataTable({
        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
            { data: "id_referencia",    title: "No. Referencia"   },
            { data: "Nombre",    title: "Nombre de la referencia"},
            { data: "TipoEmpaque",    title: "Tipo de empaque"},
            { data: "cantidad",     title: "Cantidad"  },
            { data: "valorunitario",        title: "Valor Unitario"},
            { data: "descuento",        title: "Descuento"   },
            { data: "iva",         title: "Iva"},
            { data: "Utilidad",         title: "Utilidad"      },
            { data: "valortotal",            title: "Valor Total"  },
            { 
                title: "Editar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_editar btn btn-primary' >Editar</button>";
                }
            },
            { 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_eliminar btn btn-secondary' >Eliminar</button>";
                }  
            }
        ]
    });
    
    
    
    $.ajax({
        url: '../Logica de presentacion/Factura_Logica.php',
    	type:  'post',
    	dataType:'json',
    	data: {'desea': 'cargaRefFacturas',
               'id_factura': $("#id_factura").val()
               },
    	success:  function (data) {
    	     
            $('#table_reffacturas').DataTable().clear().draw().rows.add(data).draw();
    	},
        error: function(ex){
            console.log(ex);
        }
    });  
}
 
function formularioCrearFacturas()
{
    $.ajax({
    	url:   '../Logica de presentacion/Factura_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':'cargaFormularioCrear'},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	
    
    cargarListasDesplegables(0,0,0);
}



function cargarListasDesplegables(empresaId, proveedorId, modopagoId)
{
     $.ajax({
		url: '../Logica de presentacion/Factura_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultaEmpresaCompra' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_empresaCompra').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          } 
		},
        complete: function()
        {            
            $('#id_empresaCompra').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            }); 
            
            if(empresaId != 0){             
                $('#id_empresaCompra')[0].selectize.setValue(empresaId);     
            }           
        }
	}); 
        
    $.ajax({
		url: '../Logica de presentacion/Factura_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultaProveedor' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_proveedor').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          }
		},
        complete: function(){
            
             $('#id_proveedor').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            });
            
            if(proveedorId != 0){
                $('#id_proveedor')[0].selectize.setValue(proveedorId);    
            }  
        } 
	}); 
    
     $.ajax({
		url: '../Logica de presentacion/Factura_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultaModoPago' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_modopago').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          }
		},
        complete: function(){
            
             $('#id_modopago').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            });
            
            if(modopagoId != 0){
                $('#id_modopago')[0].selectize.setValue(modopagoId);   
            }
        } 
	});     
}

function mostrarFacturas(temp)
{
    
    if(temp == 1)
    {
        var that = $("#mensajeEmergenteRedirect");
        $("body").removeClass("modal-open");
        $("body").css({"padding-right": "0"});
        that.removeClass("show");
        that.css({"display": "none"});
        $(".modal-backdrop").remove();
        var bsModal = that.data('bs.modal');
        bsModal["_isShown"] = false;
        bsModal["_isTransitioning"] = false;
        that.data('bs.modal', bsModal);
    }
     $.ajax({
    	url:   '../Logica de presentacion/Factura_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':''},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	       
        
}

function guardarFacturas(){
        
    $('#desea').val("guardarFactura");
    
    var mensaje = $("#mensajeEmergente");    
    var empresaCompra = $("#id_empresaCompra").val();
    var proveedor = $("#id_proveedor").val();
    var valor = $("#TB_valor").val();
    var modopago = $("#id_modopago").val();
    var fecha = $("#TB_fecha").val();
       
    
    if(empresaCompra == "")
    {
        $("#mensaje").html("¡La empresa que compra es requerida!");
		mensaje.modal("show");
    }
    else if( proveedor == "")
    {
        $("#mensaje").html("¡El proveedor es requerida!");
		mensaje.modal("show");
    }    
    else if($.trim(valor) == "")
    {
        $("#mensaje").html("¡El valor es requerido!");
		mensaje.modal("show");
    }    
    else if($.trim(modopago) == "")
    {
        $("#mensaje").html("¡El modo de pago es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(fecha) == "")
    {
        $("#mensaje").html("¡La fecha es requerida!");
		mensaje.modal("show");
    }
    else
    {
        $.ajax({
    		url:   '../Logica de presentacion/Factura_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: $("#factura").serialize(),
    		success:  function (data) {
    			if(data){    			 
    		      $('.dashboard').html(data);
    			}
                else {               
    				$("#mensaje").html("¡se genero un error al guardar la información!");
    				mensaje.modal("show"); 
                }
    		},
            error: function(ex){
                
                console.log(ex);
                
                $("#mensaje").html(ex.responseText);
        		mensaje.modal("show");
            }            
    	});	   
    }
}

function eliminarFactura(){
    
    $("#mensajeConfirma").modal("hide");    
        
    var mensaje = $("#mensajeEmergente");
    var temp =0;
    $.ajax({
		url:   '../Logica de presentacion/Factura_Logica.php',
		type:  'post',
		dataType:'json',
		data: {'desea': "validaEliminarFactura",
               'id_factura': $('#id_factura').val()
        },
        async: false,
		success: function (data) {
            
			if( parseInt(data[0].numero) == parseInt(0)){    			 
			 temp =1;
			}
            else {               
				$("#mensaje").html("¡La factura no se puede eliminar!");
				mensaje.modal("show"); 
            }
		},
        error: function(ex){
            console.log(ex);
        }            
	});
    
      
    if(temp == 1){
        $.ajax({
    		url:   '../Logica de presentacion/Factura_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: {'desea': "eliminarFactura",
                   'id_factura': $('#id_factura').val()
            },
    		success: function (data) {
		  			 
		      $('.dashboard').html(data);
    			
    		},
            error: function(ex){
                console.log(ex);
            }            
    	});
    }
}

function formularioCrearReferenciasFacturas()
{
	$.ajax({
		url:   '../Logica de presentacion/Factura_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea': "crearReferenciaFactura",
			   'id_factura': $('#id_factura').val()
		},
		success: function (data) {				 
		  $('.dashboard').html(data);
		  cargarListasReferenciasTipoEmpaque(0, 0);
		},
		error: function(ex){
			console.log(ex);
		}            
	});
}

function atrasCrearReferenciaFactura(NumeroFactura)
{
	
	$.ajax({
		url: '../Logica de presentacion/Factura_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea': 'detalleFactura', 
			   "id_factura": NumeroFactura},
		success:  function (data) {  
			$('.dashboard').html(data);   
			cargarRefFacturas();                     
		},
		error: function(ex){
			console.log(ex);
		}
	});  
}

function cargarListasReferenciasTipoEmpaque(referenciaId, tipoEmpaqueId)
{
	$.ajax({
		url: '../Logica de presentacion/Factura_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultarReferencias' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_referencia').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          } 
		},
        complete: function()
        {            
            $('#id_referencia').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            }); 
            
            if(referenciaId != 0){             
                $('#id_referencia')[0].selectize.setValue(referenciaId);     
            }           
        }
	}); 
	
	$.ajax({
		url: '../Logica de presentacion/Factura_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultarTipoEmpaque' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_tipoempaque').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          } 
		},
        complete: function()
        {            
            $('#id_tipoempaque').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            }); 
            
            if(tipoEmpaqueId != 0){             
                $('#id_tipoempaque')[0].selectize.setValue(referenciaId);     
            }           
        }
	}); 
}


function guardarReferenciaFactura()
{
	$('#desea').val("guardarReferenciaFactura");
    
    var mensaje = $("#mensajeEmergente");    
    var id_referencia = $("#id_referencia").val();
    var id_factura = $("#id_factura").val();
    var id_tipoempaque = $("#id_tipoempaque").val();
    var TB_cantidad = $("#TB_cantidad").val();
    var TB_valorUnitario = $("#TB_valorUnitario").val();
    var TB_descuento = $("#TB_descuento").val();
	var TB_iva = $("#TB_iva").val();
	var TB_utilidad = $("#TB_utilidad").val();
	var TB_valortotal = $("#TB_valortotal").val();
       
    
    if(id_referencia == "")
    {
        $("#mensaje").html("¡La referencia es requerida!");
		mensaje.modal("show");
    }
    else if( id_tipoempaque == "")
    {
        $("#mensaje").html("¡El el tipo de empaque es requerido!");
		mensaje.modal("show");
    }    
    else if($.trim(TB_cantidad) == "")
    {
        $("#mensaje").html("¡La cantidad requerida!");
		mensaje.modal("show");
    }    
    else if($.trim(TB_valorUnitario) == "")
    {
        $("#mensaje").html("¡El valor unitario es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(TB_descuento) == "")
    {
        $("#mensaje").html("¡El descuento es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(TB_iva) == "")
    {
        $("#mensaje").html("¡El iva es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(TB_utilidad) == "")
    {
        $("#mensaje").html("¡La utilidad es requerida!");
		mensaje.modal("show");
    }
    else if($.trim(TB_valortotal) == "")
    {
        $("#mensaje").html("¡El valor total es requerido!");
		mensaje.modal("show");
    }
    else
    {
        $.ajax({
    		url:   '../Logica de presentacion/Factura_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: $("#referenciafactura").serialize(),
    		success:  function (data) {
    			if(data){    			 
    		      $('.dashboard').html(data);
    			}
                //else {               
    			//	$("#mensaje").html("¡se genero un error al guardar la información!");
    			//	mensaje.modal("show"); 
                //}
    		},
            error: function(ex){
                
                console.log(ex);
                
                $("#mensaje").html(ex.responseText);
        		mensaje.modal("show");
            }            
    	});	   
    }
}