 
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
			{ 
                title: "Editar",
                targets: -1,
                render: function (data, type, row) {
					
					if(row.EstadoId == 1)
					{
						return "<button class='A_editar btn btn-primary' >Editar</button>";
					}
					else{
						return "";
					}                    
                }
            },
            { 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
					
					if(row.EstadoId == 1)
					{
						return "<button class='A_eliminar btn btn-secondary' >Eliminar</button>";
					}
					else
					{
						return "";
					}
                }  
            },
            { 
                title: "Ver Detalle",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_detalle btn btn-outline-primary' >Detalle</button>";
                }  
            },
            { data: "NumeroFactura",    title: "No. Factura",   },
            { data: "empresaId",    title: "Empresa que compra"},
            { data: "EmpresaCompra",    title: "Empresa que compra",},
			{ 
				data: "ValorFactura",
				title: "Valor Factura",
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
            { data: "proveedorId",      title: "Proveedor" 		},
            { data: "proveedor",        title: "Proveedor",   	},
            { data: "modopagoId",       title: "Modo de pago"	},
            { data: "modopago",         title: "Modo de pago",  },
            { data: "Fecha",            title: "Fecha",         },
            { data: "EstadoId",         title: "EstadoId",      },
			{ data: "Estado",           title: "Estado",        }
        ],
		columnDefs: [
			{
				targets: [ 4 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 7 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 9 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 12 ],
				visible: false,
				searchable: false
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
			{ 
                title: "Editar",
                targets: -1,
                render: function (data, type, row) {
                    
					if(row.EstadoId == 1)
					{
						return "<button class='A_editar btn btn-primary' >Editar</button>";
					}
					else{
						return "";
					}    					
                }
            },
            { 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
                   
					if(row.EstadoId == 1)
					{
						return "<button class='A_eliminar btn btn-secondary' >Eliminar</button>";
					}
					else{
						return "";
					}    				   
                }  
            },
            { data: "codigo",title: "Codigo Referencia"   },
            { data: "Nombre",		title: "Nombre de la referencia"},
            { data: "TipoEmpaqueId",	title: "Tipo de empaque Id"},
			{ data: "TipoEmpaque",	title: "Tipo de empaque"},
            { data: "cantidad",     title: "Cantidad"  },
            { 
				data: "valorunitario",
				title: "Valor Unitario",
				mRender: function (data, type, full) {
					 var formmatedvalue = data.replace(/\D/g, "");
						formmatedvalue = formmatedvalue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					  return formmatedvalue;
					}
			},
            { data: "descuento",	title: "Descuento %"   },
			{ data: "asumeiva",		title: "Asume Iva"  },
            { data: "iva",          title: "Iva %"},
            { 
				data: "valortotal",	
				title: "Valor Total",
				mRender: function (data, type, full) {
					 var formmatedvalue = data.replace(/\D/g, "");
						formmatedvalue = formmatedvalue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					  return formmatedvalue;
					}				
			},			
            { data: "EstadoId",     title: "EstadoId"},			
            { data: "Estado",       title: "Estado"  },
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
    	     
				
			var valorTotal =parseFloat(0);
			var cont =0;
			while(cont < data.length)
			{
				valorTotal = parseFloat(valorTotal) + parseFloat(data[cont].valortotal);
				cont ++;
			}
			
			var formmatedvalue = parseFloat(valorTotal).toString().replace(/\D/g, "");
			formmatedvalue = formmatedvalue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			
            $('#table_reffacturas').DataTable().clear().draw().rows.add(data).draw();
			$("#totalFactura").text("Valor Total: " + formmatedvalue);
    	},
		complete: function(data)
		{
			table = $('#table_reffacturas').DataTable().rows().data()[0];
		
			if(table != undefined)
			{
				if(table.EstadoId == 1)
				{
					$("#B_crear").show();
				}
				else{
					$("#B_crear").hide();
				}
			}
		},
        error: function(ex){
            console.log(ex);
        }
    });  
	
		
	$('#table_reffacturas').on('click', 'td .A_editar', function (e) {
				
		e.preventDefault();
		
		var table = $('#table_reffacturas').DataTable();
		var dataItem = table.row($(this).closest('tr')).data();        
				
		$.ajax({
		    url: '../Logica de presentacion/Factura_Logica.php',
			type:  'post',
			dataType:'html',
			data: {'desea': 'editarReferenciaFactura', 
		           "id_referenciafac": dataItem.Id, 
				   "id_factura": dataItem.facturaId, 
		           "cantidad": dataItem.cantidad,
				   "valorunitario": dataItem.valorunitario,
				   "descuento": dataItem.descuento,
				   "asumeiva": dataItem.asumeiva,
				   "iva": dataItem.iva,
				   "Utilidad": dataItem.Utilidad,
				   "valortotal": dataItem.valortotal
				   },
			success:  function (data) {  
		        $('.dashboard').html(data);
		        cargarListasReferenciasTipoEmpaque(dataItem.id_referencia, dataItem.TipoEmpaqueId);
			},
		    error: function(ex){
		        console.log(ex);
		    }
		});
	});

	$('#table_reffacturas').on( 'click', 'td .A_eliminar', function (e) {
				
		e.preventDefault();

		var table = $('#table_reffacturas').DataTable();
		var dataItem = table.row($(this).closest('tr')).data();        
				
		$("#id_referenciafac").val(dataItem.Id);
		$("#mensajeConfRef").html("¿Esta seguro de eliminar el registro?");
		$("#mensajeConfirmaReferencia").modal("show");		
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

function mostrarDetalleFactura(temp, NumeroFactura)
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

function guardarFacturas(){
        
    $('#desea').val("guardarFactura");
    
    var mensaje = $("#mensajeEmergente");    
    var empresaCompra = $("#id_empresaCompra").val();
    var proveedor = $("#id_proveedor").val();
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

function editarFacturas(){
        
    $('#desea').val("guardarEditarFactura");
    
    var mensaje = $("#mensajeEmergente");    
    var empresaCompra = $("#id_empresaCompra").val();
    var proveedor = $("#id_proveedor").val();
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
                $('#id_tipoempaque')[0].selectize.setValue(tipoEmpaqueId);     
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
    else if($.trim(TB_valortotal) == "")
    {
        $("#mensaje").html("¡El valor total es requerido!");
		mensaje.modal("show");
    }
    else
    {
		TB_valorUnitario = TB_valorUnitario.replace(",","");
		$("#TB_valorUnitario").val(TB_valorUnitario);
				
		TB_valortotal = TB_valortotal.replace(",","");
		$("#TB_valortotal").val(TB_valortotal);
				
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


function actualizarCalculos()
{
	//
	var TB_cantidad = $("#TB_cantidad").val();
	var TB_valorUnitario = $("#TB_valorUnitario").val();
	var TB_descuento = $("#TB_descuento").val();
	var TB_iva = $("#TB_iva").val();
	
	
	TB_valorUnitario = TB_valorUnitario.replace(",","");
				
	//refresca el valor total
	var valorTotalFinal = (parseInt(TB_cantidad) * parseFloat(TB_valorUnitario));
	var valorIva = ((parseInt(TB_iva) * valorTotalFinal)/100);
	var valorDescuento = ((parseInt(TB_descuento)*valorTotalFinal)/100);
	
	if ($('#CB_iva').is(':checked')) {
		valorTotalFinal = ((valorTotalFinal - valorDescuento) + valorIva);
	}
	else{
		valorTotalFinal = ((valorTotalFinal - valorDescuento));
	}
	
	
	$("#TB_valortotal").val(valorTotalFinal);
	
	  // format number
	$("#TB_valortotal").val(function(index, value) {
		var number = value.replace(",", ""),
		thousand_separator = ',',
		decimal_separator = '.';
			
		var	number_string = number.toString(),
		split	  = number_string.split(decimal_separator),
		result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						
		if(split[1] != "")
		{
			result = split[1] != undefined ? result + decimal_separator + split[1].substring(0, 2) : result;
		}

		return (result);
	});
	
	ActualizarCambios();
}


 
function ActualizarCambios()
{
	var number = $("#TB_valorUnitario").val().replace(",", ""),
		thousand_separator = ',',
		decimal_separator = '.';
		
	var	number_string = number.toString(),
	split	  = number_string.split(decimal_separator),
	result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					
	if(split[1] != "")
	{
		result = split[1] != undefined ? result + decimal_separator + split[1] : result;
	}

	$("#TB_valorUnitario").val(result);
}

function editarReferenciaFactura()
{
	$('#desea').val("guardarEditarReferenciaFactura");
    
    var mensaje = $("#mensajeEmergente");    
    var id_referencia = $("#id_referencia").val();
    var id_referenciafac = $("#id_referenciafac").val();
    var id_tipoempaque = $("#id_tipoempaque").val();
    var TB_cantidad = $("#TB_cantidad").val();
    var TB_valorUnitario = $("#TB_valorUnitario").val();
    var TB_descuento = $("#TB_descuento").val();
	var TB_iva = $("#TB_iva").val();
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
    else if($.trim(TB_valortotal) == "")
    {
        $("#mensaje").html("¡El valor total es requerido!");
		mensaje.modal("show");
    }
    else
    {
		TB_valorUnitario = TB_valorUnitario.replace(",","");
		$("#TB_valorUnitario").val(TB_valorUnitario);
				
		TB_valortotal = TB_valortotal.replace(",","");
		$("#TB_valortotal").val(TB_valortotal);
				
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

function eliminarReferenciaFactura()
{
	$.ajax({
		url:   '../Logica de presentacion/Factura_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea': 'eliminaReferenciaFactura',
		'id_referenciafac': $("#id_referenciafac").val()},
		success:  function (data) {
			if(data){    			 
			  $('.dashboard').html(data);
			}			
		},
		error: function(ex){
			
			console.log(ex);
			
			$("#mensaje").html(ex.responseText);
			mensaje.modal("show");
		}            
	});	   
}


