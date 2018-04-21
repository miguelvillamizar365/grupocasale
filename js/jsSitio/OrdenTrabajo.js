
 // manejo pantalla orden trabajo
 // @author miguel villamizar
 // @copyright 2018/03/17
 //
 
$(document).ready(function(){
	
    $('#table_Ordenes').DataTable({
        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
            { data: "Id",    title: "No. Orden Trabajo"},
			{ data: "Placa",    title: "Placa"},
            { data: "Fecha",    title: "Fecha"},
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
            { 
                title: "Editar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_editar btn btn-primary' >Editar</button>";
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
            }
        ],
		columnDefs: [
			{
				targets: [ 4 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 6 ],
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
    	     
            $('#table_Ordenes').DataTable().clear().draw().rows.add(data).draw();
			
    	},
        error: function(ex){
            console.log(ex);
        }
    });    
});


$('#table_Ordenes').on('click', 'td .A_editar', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_Ordenes').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'editarOrdenes', 
               "NumeroOrden": dataItem.Id,
			   "Placa": dataItem.Placa,
			   "Fecha": dataItem.Fecha,
			   "Kilometraje": dataItem.Kilometraje, 
			   "Observaciones": dataItem.Observaciones},
    	success:  function (data) {  
            $('.dashboard').html(data);            
			cargarListasDesplegables(dataItem.id_conductor, dataItem.id_mecanico);
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});


$('#table_Ordenes').on('click', 'td .A_detalleRef', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_Ordenes').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'verReferencias', 
               "NumeroOrden": dataItem.Id},
    	success:  function (data) {  
            $('.dashboard').html(data); 
			cargardetalleReferencias();            
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});


$('#table_Ordenes').on('click', 'td .A_detalleActi', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_Ordenes').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'verReferencias', 
               "NumeroOrden": dataItem.Id},
    	success:  function (data) {  
            $('.dashboard').html(data);  
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});

function cargardetalleReferencias()
{
    $('#table_OrdenesReferencia').DataTable({        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
            { data: "Id",    title: "No. Orden Trabajo"},
			{ data: "referencia",    title: "Referencia"},
            { data: "empaque",    title: "Tipo Empaque"},
			{ data: "cantidad", title: "Cantidad" },
			{ data: "valorunitario", title: "Valor Unitario" },
            { data: "valortotal", title: "Valor Total"},
            { 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_eliminar btn btn-primary' >Eliminar</button>";
                }
            }
        ]
    });
		
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'json',
    	data: {'desea': 'cargaReferenciaOrdenes',
				'id_ordentrabajo': $("#id_orden").val()
			  },
    	success:  function (data) {    	     
            $('#table_OrdenesReferencia').DataTable().clear().draw().rows.add(data).draw();			
    	},
        error: function(ex){
            console.log(ex);
        }
    });    
	
		
	$("#id_referencia").keydown(function(event) {
		if(event.shiftKey)
		{
			event.preventDefault();
		}
		
		if (event.keyCode == 13)    
		{
			
			$.ajax({
				url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
				type:  'post',
				dataType:'html',
				data:  {'desea':'agregarReferenciaOrden',
						'id_referencia': $("#id_referencia").val(),
						'id_orden': $("#id_orden").val()
						},
				success:  function (data) {
					if(data){    			 
					  $('.dashboard').html(data);
					}
					else {               
						$("#mensaje").html("¡se genero un error al cargar la información!");
						mensaje.modal("show"); 
					}
				},				
				complete: function(){
					
					$('#table_referencia').DataTable({						
						language: { url: '../datatables/Spanish.json' },
						data: null,
						scrollX: true,
						columns: [
							{ data: "Id",    title: "No. Referencia"},
							{ data: "Nombre",    title: "Nombre Referencia"},
							{ data: "id_tipoempaque",    title: "Id Tipo empaque"},
							{ data: "tipoempaque",    title: "Tipo empaque"},
							{ data: "Cantidad",    title: "Cantidad"},
							{ 
								data: "ValorUnitario",   
								title: "Valor Unitario",
								mRender: function (data, type, full) {
								 var formmatedvalue = data.replace(/\D/g, "");
									formmatedvalue = formmatedvalue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								  return formmatedvalue;
								}
							}							
						],
						columnDefs: [
							{
								targets: [ 2 ],
								visible: false,
								searchable: false
							}
						]
					});
					
					$.ajax({
						url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
						type:  'post',
						dataType:'json',
						data: {'desea': 'cargarReferencia',
							'id_referencia': $("#id_referencia").val(),
							'id_orden': $("#id_orden").val()},
						success:  function (data) {
							 
							$('#table_referencia').DataTable().clear().draw().rows.add(data).draw();
							
						},
						error: function(ex){
							console.log(ex);
						}
					});    
				},
				error: function(ex){
					
					console.log(ex);                
					$("#mensaje").html(ex.responseText);
					mensaje.modal("show");
				}            
			});
		}	
	});   		
}

function formularioCrearOrden()
{
    $.ajax({
    	url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':'crearOrdenTrabajo'},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	
    
	cargarListasDesplegables(0, 0);
}

function cargarListasDesplegables(conductorId, mecanicoId)
{
	 $.ajax({
		url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultaConductor' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_conductor').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          } 
		},
        complete: function()
        {            
            $('#id_conductor').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            }); 
            
            if(conductorId != 0){             
                $('#id_conductor')[0].selectize.setValue(conductorId);     
            }           
        }
	}); 
	
	$.ajax({
		url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultaMecanico' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_mecanico').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          } 
		},
        complete: function()
        {            
            $('#id_mecanico').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            }); 
            
            if(mecanicoId != 0){             
                $('#id_mecanico')[0].selectize.setValue(mecanicoId);     
            }           
        }
	}); 
}

function mostrarOrdenes(temp)
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
    	url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':''},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	              
}

function guardarOrdenes()
{	   
    $('#desea').val("guardarOrden");
    
    var mensaje = $("#mensajeEmergente");    
    var placa = $("#TB_placa").val();
    var fecha = $("#TB_fecha").val();
    var kilometraje = $("#TB_kilometraje").val();
    var conductor = $("#id_conductor").val();
    var mecanico = $("#id_mecanico").val();
	var observaciones = $("#TB_observaciones").val();
       
    
    if($.trim(placa) == "")
    {
        $("#mensaje").html("¡La placa es requerida!");
		mensaje.modal("show");
    }
    else if( $.trim(fecha) == "")
    {
        $("#mensaje").html("¡La fecha es requerida!");
		mensaje.modal("show");
    }    
    else if($.trim(kilometraje) == "")
    {
        $("#mensaje").html("¡El kilometraje es requerido!");
		mensaje.modal("show");
    }    
    else if((conductor) == "")
    {
        $("#mensaje").html("¡El conductor es requerido!");
		mensaje.modal("show");
    }
    else if((mecanico) == "")
    {
        $("#mensaje").html("¡El mecanico es requerida!");
		mensaje.modal("show");
    }
    else if($.trim(observaciones) == "")
    {
        $("#mensaje").html("¡La observacion es requerida!");
		mensaje.modal("show");
    }
    else
    {		
		kilometraje = kilometraje.replace(",","");
		$("#TB_kilometraje").val(kilometraje);
        $.ajax({
    		url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: $("#ordentrabajo").serialize(),
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

function editarOrdenes()
{
	$('#desea').val("editarGuardarOrden");
    
    var mensaje = $("#mensajeEmergente");    
    var numeroOrden = $("#numeroOrden").val();
	var placa = $("#TB_placa").val();
    var fecha = $("#TB_fecha").val();
    var kilometraje = $("#TB_kilometraje").val();
    var conductor = $("#id_conductor").val();
    var mecanico = $("#id_mecanico").val();
	var observaciones = $("#TB_observaciones").val();
       
    
    if($.trim(placa) == "")
    {
        $("#mensaje").html("¡La placa es requerida!");
		mensaje.modal("show");
    }
    else if( $.trim(fecha) == "")
    {
        $("#mensaje").html("¡La fecha es requerida!");
		mensaje.modal("show");
    }    
    else if($.trim(kilometraje) == "")
    {
        $("#mensaje").html("¡El kilometraje es requerido!");
		mensaje.modal("show");
    }    
    else if((conductor) == "")
    {
        $("#mensaje").html("¡El conductor es requerido!");
		mensaje.modal("show");
    }
    else if((mecanico) == "")
    {
        $("#mensaje").html("¡El mecanico es requerida!");
		mensaje.modal("show");
    }
    else if($.trim(observaciones) == "")
    {
        $("#mensaje").html("¡La observacion es requerida!");
		mensaje.modal("show");
    }
    else
    {
		kilometraje = kilometraje.replace(",","");
		$("#TB_kilometraje").val(kilometraje);
        $.ajax({
    		url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: $("#ordentrabajo").serialize(),
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


function agregarReferencia()
{
    var mensaje = $("#mensajeEmergente");   
	
	$('#desea').val("guardarReferencia");   
	
	id_referencia = $("#id_referencia").val();
	id_orden = $("#id_orden").val();			
	cantidad = $("#TB_cantidad").val();	
		
	table = $('#table_referencia').DataTable().rows().data()[0];
	
	Id_empaque = table.id_tipoempaque;	
	ValorUnitario = table.ValorUnitario;
	CantidadMax = table.Cantidad;
		
    if(($.trim(cantidad) == "") || ($.trim(cantidad) == "0"))
    {
        $("#mensaje").html("¡La cantidad es requerida!");
		mensaje.modal("show");
    }
	else if(parseInt($.trim(cantidad)) > parseInt(CantidadMax))
    {
        $("#mensaje").html("¡La cantidad no puede superar el maximo del stock!");
		mensaje.modal("show");
    }
	else{
			
		$.ajax({
			url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
			type:  'post',
			dataType:'html',
			data: {'desea': $('#desea').val(),
					'id_referencia': id_referencia,
					'id_orden': id_orden,
					'cantidad': cantidad,
					'Id_empaque': Id_empaque,
					'ValorUnitario': ValorUnitario},
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

function mostrarReferenciasOrden(id_orden, temp )
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
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'verReferencias', 
               "NumeroOrden": id_orden},
    	success:  function (data) {  
            $('.dashboard').html(data); 
			cargardetalleReferencias();            
    	},
        error: function(ex){
            console.log(ex);
        }
    });
}
