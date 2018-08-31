
 // manejo pantalla orden trabajo
 // @author miguel villamizar
 // @copyright 2018/03/17
 //
 
$(document).ready(function(){	
	
}); 
 
 var tableSelect = undefined;
 
$('#table_OrdenesAll').on('click', 'td .A_editar', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_OrdenesAll').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'editarOrdenes', 
               "NumeroOrden": dataItem.Id,
			   "Fecha": dataItem.Fecha,
			   "Kilometraje": dataItem.Kilometraje, 
			   "Observaciones": dataItem.Observaciones},
    	success:  function (data) {  
            $('.dashboard').html(data);            
			cargarListasDesplegables(dataItem.id_vehiculo, dataItem.id_conductor, dataItem.id_mecanico);
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});


$('#table_OrdenesAll').on('click', 'td .A_detalleRef', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_OrdenesAll').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'verReferencias', 
               "NumeroOrden": dataItem.Id, 
               "Placas": dataItem.Placas, 
               "Fecha": dataItem.Fecha, 
               "Kilometraje": dataItem.Kilometraje, 
               "mecanico": dataItem.mecanico, 
               "conductor": dataItem.conductor, 
               "Observaciones": dataItem.Observaciones},
    	success:  function (data) {  
            $('.dashboard').html(data); 
			cargardetalleReferencias();            
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});


$('#table_OrdenesAll').on('click', 'td .A_detalleActi', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_OrdenesAll').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'verActividades', 
               "NumeroOrden": dataItem.Id,
			   "Placas": dataItem.Placas, 
               "Fecha": dataItem.Fecha, 
               "Kilometraje": dataItem.Kilometraje, 
               "mecanico": dataItem.mecanico, 
               "conductor": dataItem.conductor, 
               "Observaciones": dataItem.Observaciones},
    	success:  function (data) {  
            $('.dashboard').html(data);  
			cargarDetalleActividades();
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});

function cargarDetalleActividades()
{
	 $('#table_actividades').DataTable({        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
			{ 
                title: "Editar",
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
                title: "Eliminar",
                render: function (data, type, row) {
					
					if(row.EstadoId == 1)
					{
						return "<button class='A_eliminar btn btn-primary' >Eliminar</button>";
					}
					else
					{
						return "";
					}                    
                }
            },
            { data: "Id",    title: "No. Actividad"},
			{ data: "Id_actividad",    title: "Actividad"},
			{ data: "actividad",    title: "Actividad"},
            { data: "Id_mecanico",    title: "Mecanico"},
            { data: "mecanico",    title: "Mecanico"},
			{ data: "Tiempo", title: "Tiempo" },
			{ 
				data: "Valor",   
				title: "Valor",
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
			{ data: "Utilidad", title: "Utilidad" },
			{ 
				data: "ValorTotalUtilidad",   
				title: "Valor Total Utilidad",
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
            { data: "Fecha", title: "Fecha"},
			{ data: "Observaciones", title: "Observaciones"},
			{ data: "EstadoId", title: "EstadoId"},
			{ data: "Estado", title: "Estado"}
        ],
		columnDefs: 
		[
			{
				className: "dt-center", 
				targets: "_all"
			},
			{
				targets: [ 3 ],
				visible: false,
				searchable: false
			},
			
			{
				targets: [ 5 ],
				visible: false,
				searchable: false
			},
			
			{
				targets: [ 13 ],
				visible: false,
				searchable: false
			},
		]
    });
		
    $.ajax({
        url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'json',
    	data: {'desea': 'cargaActividadesOrdenes',
				'id_ordentrabajo': $("#id_orden").val()
		},
    	success:  function (data) {    	     
            $('#table_actividades').DataTable().clear().draw().rows.add(data).draw();			
    	},
		complete: function(data)
		{
			table = $('#table_actividades').DataTable().rows().data()[0];
			
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

	$('#table_actividades').on('click', 'td .A_editar', function (e) {
				
		e.preventDefault();

		var table = $('#table_actividades').DataTable();
		var dataItem = table.row($(this).closest('tr')).data();        
			
		$.ajax({
			url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
			type:  'post',
			dataType:'html',
			data: {'desea': 'editarActividad', 
				   "id": dataItem.Id,
				   "id_orden": $("#id_orden").val(),
				   "tiempoHoras": dataItem.Tiempo,
				   "fecha": dataItem.Fecha, 
				   "tb_valor": dataItem.Valor,
				   "TB_utilidad": dataItem.Utilidad,
				   "TB_observaciones": $.trim(dataItem.Observaciones),				   
					'Placas': $.trim($("#id_vehiculo").val()),
					'Fecha2': $("#TB_fechaDate").val(),
					'Kilometraje':  $("#TB_kilometraje").val(),
					'mecanico': $.trim($("#TB_mecanico").val()),
					'conductor': $.trim($("#TB_conductor").val()),
					'Observaciones2': $.trim($("#TB_observaciones").val())},
			success:  function (data) {  
				$('.dashboard').html(data);            
				
				cargarListasDesplegablesActividad(dataItem.Id_mecanico, dataItem.Id_actividad);	
			},
			error: function(ex){
				console.log(ex);
			}
		});		
	});
		
	$('#table_actividades').on( 'click', 'td .A_eliminar', function (e) {
				
		e.preventDefault();

		var table = $('#table_actividades').DataTable();
		var dataItem = table.row($(this).closest('tr')).data();        
				
		$("#id_actividadOrden").val(dataItem.Id);
		$("#mensajeConf").html("¿Esta seguro de eliminar el registro?");
		$("#mensajeConfirma").modal("show");
		
	});	
}

function cargardetalleReferencias()
{
    $('#table_OrdenesReferencia').DataTable({        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
			{ 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
					
					if(row.EstadoId == 1)
					{
						return "<button class='A_eliminar btn btn-primary' >Eliminar</button>";
					}
					else
					{
						return "";
					}                    
                }
            },
            { data: "Codigo",    title: "Código Referencia"},
			{ data: "referencia",    title: "Referencia"},
            { data: "empaque",    title: "Tipo Empaque"},
			{ data: "cantidad", title: "Cantidad" },
			{ 
				data: "valorunitario", 
				title: "Valor Unitario",
				mRender: function (data, type, full) {
				  // var formmatedvalue = data.replace(/\D/g, "");
					// formmatedvalue = formmatedvalue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				  // return formmatedvalue;
				  
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
				data: "valortotal", 
				title: "Valor Total",
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
			{ data: "Utilidad", title: "% Utilidad" },
			{ 
				data: "ValorTotalUtilidad", 
				title: "Valor Total Más Utilidad",
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
			{ data: "EstadoId", title: "EstadoId" },            
			{ data: "Estado", title: "Estado" },            
        ],
		columnDefs: [
			{
				targets: [ 9 ],
				visible: false,
				searchable: false
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
		complete: function(data)
		{
			table = $('#table_OrdenesReferencia').DataTable().rows().data()[0];
			
			if(table != undefined)
			{
				if(table.EstadoId == 1)
				{
					$("#div_referencia").show();
				}
				else{
					$("#div_referencia").hide();
				}			
			}
		},		
        error: function(ex){
            console.log(ex);
        }
    });    
	
	

	$('#table_OrdenesReferencia').on( 'click', 'td .A_eliminar', function (e) {
				
		e.preventDefault();

		var table = $('#table_OrdenesReferencia').DataTable();
		var dataItem = table.row($(this).closest('tr')).data();        
				
		$("#id_referenciaOrden").val(dataItem.Id);
		$("#mensajeConf").html("¿Esta seguro de eliminar el registro?");
		$("#mensajeConfirma").modal("show");
		
	});

	$("#id_referencia").keydown(function(event) {
		if(event.shiftKey)
		{
			event.preventDefault();
		}
		
		if (event.keyCode == 13)    
		{
			
			var mensaje = $("#mensajeEmergente");  
			//se valida la cantidad de la referencia
			$.ajax({
				url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
				type:  'post',
				dataType:'html',
				data:  {'desea':'agregarReferenciaOrden',
						'id_referencia': $("#id_referencia").val(),
						'id_orden': $("#id_orden").val(),
						'Placas': $("#id_vehiculo").val(),
						'Fecha': $("#TB_fechaDate").val(),
						'Kilometraje':  $("#TB_kilometraje").val(),
						'mecanico': $("#TB_mecanico").val(),
						'conductor': $("#TB_conductor").val(),
						'Observaciones': $("#TB_observaciones").val()},
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
							{ data: "Id",    title: "Seleccione"},
							{ data: "Codigo",    title: "Código Referencia"},
							{ data: "Nombre",    title: "Nombre Referencia"},
							{ data: "id_tipoempaque",    title: "Id Tipo empaque"},
							{ data: "tipoempaque",    title: "Tipo empaque"},
							{ data: "Cantidad",    title: "Cantidad"},
							{ 
								data: "ValorUnitario",   
								title: "Valor Unitario",
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
							}							
						],
						columnDefs: [
								
							{
								targets: [ 3 ],
								visible: false,
								searchable: false
							},
							{ 
								targets: 0,
								searchable: false,
								orderable: false,
								render: function(data, type, full, meta){
								   
								   if(type === 'display'){
									  data = '<input type="radio" class="A_seleccionar" name="id" value="' + data + '">';      
								   }

								   return data;
								}
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
					
					$('#table_referencia').on('click', 'td .A_seleccionar', function (e) {
																		
						var table = $('#table_referencia').DataTable();
						tableSelect = table.row($(this).closest('tr')).data();  
						
					});
				},
				error: function(ex){
										
					$("#mensaje").html(ex.responseText);
					mensaje.modal("show");
				}            
			});
		}	
	});   		
}

function eliminarReferenciaOrden()
{
	$.ajax({
		url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea':'eliminarReferenciaOrden',
				'id_orden': $("#id_orden").val(),
				'id_referenciaOrden':$("#id_referenciaOrden").val(),
				'Placas': $.trim($("#id_vehiculo").val()),
				'Fecha': $("#TB_fechaDate").val(),
				'Kilometraje':  $("#TB_kilometraje").val(),
				'mecanico': $.trim($("#TB_mecanico").val()),
				'conductor': $.trim($("#TB_conductor").val()),
				'Observaciones': $.trim($("#TB_observaciones").val())},
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
    
	cargarListasDesplegables(0, 0, 0);
}

function cargarListasDesplegables(vehiculoId, conductorId, mecanicoId)
{
	$.ajax({
		url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultaVehiculo' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_vehiculo').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          } 
		},
        complete: function()
        {            
            $('#id_vehiculo').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            }); 
            
            if(vehiculoId != 0){             
                $('#id_vehiculo')[0].selectize.setValue(vehiculoId);     
            }           
        }
	}); 
	
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

function mostrarOrdenesActividades(Id,
								   Placas, 
								   Fecha, 
								   Kilometraje, 
								   mecanico, 
								   conductor, 
								   Observaciones,
								   temp)
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
    	data: {'desea': 'verActividades', 
               "NumeroOrden": Id,
			   "Placas": Placas, 
               "Fecha": Fecha, 
               "Kilometraje": Kilometraje, 
               "mecanico": mecanico, 
               "conductor": conductor, 
               "Observaciones": Observaciones},
    	success:  function (data) {  
            $('.dashboard').html(data);  
			cargarDetalleActividades();
    	},
        error: function(ex){
            console.log(ex);
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
    var placa = $("#id_vehiculo").val();
    var fecha = $("#TB_fecha").val();
    var kilometraje = $("#TB_kilometraje").val();
    var conductor = $("#id_conductor").val();
    var mecanico = $("#id_mecanico").val();
	var observaciones = $("#TB_observaciones").val();
       
    
    if($.trim(placa) == "")
    {
        $("#mensaje").html("¡El vehiculo es requerido!");
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
        $("#mensaje").html("¡El mecánico es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(observaciones) == "")
    {
        $("#mensaje").html("¡La observación es requerida!");
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
	var placa = $("#id_vehiculo").val();
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
	
	id_orden = $("#id_orden").val();			
	cantidad = $("#TB_cantidad").val();		
	utilidad = $("#TB_utilidad").val();			

	if($.trim(cantidad) == "")
	{
        $("#mensaje").html("¡La cantidad es requerida!");
		mensaje.modal("show");
	}	
	else if($.trim(utilidad) == ""){
		
        $("#mensaje").html("¡La utilidad es requerida!");
		mensaje.modal("show");
	}
	else{
		
	if(tableSelect != undefined)
	{
		table = tableSelect;
	}
	else{
		table = $('#table_referencia').DataTable().rows().data()[0];
	}
	
	Id_empaque = table.id_tipoempaque;	
	ValorUnitario = table.ValorUnitario;
	CantidadMax = table.Cantidad;
	id_referencia = table.Id;
		
    if(($.trim(cantidad) == "") || ($.trim(cantidad) == "0"))
    {
        $("#mensaje").html("¡La cantidad es requerida!");
		mensaje.modal("show");
    }    
	if(($.trim(utilidad) == "") || ($.trim(utilidad) < "0"))
    {
        $("#mensaje").html("¡La utilidad es requerida!");
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
						'ValorUnitario': ValorUnitario,
						'utilidad': utilidad,
						'Placas': $.trim($("#id_vehiculo").val()),
						'Fecha': $("#TB_fechaDate2").val(),
						'Kilometraje':  $("#TB_kilometraje").val(),
						'mecanico': $.trim($("#TB_mecanico").val()),
						'conductor': $.trim($("#TB_conductor").val()),
						'Observaciones': $.trim($("#TB_observaciones2").val())},
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
}

function mostrarReferenciasOrden(vehiculo, 
								fechaDate, 
								kilometraje, 
								mecanico,
								conductor,
								observaciones,
								id_orden, 
								temp )
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
               "NumeroOrden": id_orden,
				'Placas': $.trim(vehiculo),
				'Fecha': fechaDate,
				'Kilometraje':  kilometraje,
				'mecanico': $.trim(mecanico),
				'conductor': $.trim(conductor),
				'Observaciones': $.trim(observaciones)},
    	success:  function (data) {  
            $('.dashboard').html(data); 
			cargardetalleReferencias();            
    	},
        error: function(ex){
            console.log(ex);
        }
    });
}

function formularioCrearActividad()
{
	$.ajax({
    	url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':'crearActividad',
				'id_orden': $("#id_orden").val(),
				'Placas': $.trim($("#id_vehiculo").val()),
				'Fecha': $("#TB_fechaDate").val(),
				'Kilometraje':  $("#TB_kilometraje").val(),
				'mecanico': $.trim($("#TB_mecanico").val()),
				'conductor': $.trim($("#TB_conductor").val()),
				'Observaciones': $.trim($("#TB_observaciones").val())
			  },
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	
    
	cargarListasDesplegablesActividad(0, 0);
}



function cargarListasDesplegablesActividad(mecanicoId, actividadId)
{
	 $.ajax({
		url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultaActividad' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_actividad').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          } 
		},
        complete: function()
        {            
            $('#id_actividad').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            }); 
            
            if(actividadId != 0){             
                $('#id_actividad')[0].selectize.setValue(actividadId);     
            }

			//carga el tiempo de la actividad actual			
			var mensaje = $("#mensajeEmergente");   
	
			$.ajax({
				 url: '../Logica de presentacion/Orden_Trabajo_Logica.php',
				 method: 'post',
				 dataType: 'json',
				 data: { 'desea': 'consultaTiempoActividad',
					'id_actividad': $("#id_actividad").val()
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

function guardarActividad()
{
    $('#desea').val("guardarActividadOrden");
    
    var mensaje = $("#mensajeEmergente");    
    var id_actividad = $("#id_actividad").val();
    var TB_tiempo = $("#TB_tiempo").val();
    var id_mecanico = $("#id_mecanico").val();
    var TB_fecha = $("#TB_fecha").val();
    var TB_valor = $("#TB_valor").val();
	var TB_observaciones = $("#TB_observaciones").val();
    var TB_utilidad = $("#TB_utilidad").val();
    var id_ordentrabajo = $("#id_orden").val();
    
    if($.trim(id_actividad) == "")
    {
        $("#mensaje").html("¡La actividad es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(TB_tiempo) == "")
    {
        $("#mensaje").html("¡El tiempo es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(id_mecanico) == "")
    {
        $("#mensaje").html("¡El mecánico es requerido!");
		mensaje.modal("show");
    }
	else if($.trim(TB_fecha) == "")
    {
        $("#mensaje").html("¡La fecha es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(TB_valor) == "")
    {
        $("#mensaje").html("¡El valor es requerido!");
		mensaje.modal("show");
    }
	else if($.trim(TB_utilidad) == "")
    {
        $("#mensaje").html("¡La utilidad es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(TB_observaciones) == "")
    {
        $("#mensaje").html("¡La observacion es requerido!");
		mensaje.modal("show");
    }
	else{
		
		TB_valor = TB_valor.replace(",","");
		$.ajax({
			url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
			type:  'post',
			dataType:'html',
			data: { 'desea': $('#desea').val(),
					'id_actividad': id_actividad,
					'TB_tiempo': TB_tiempo,
					'id_mecanico': id_mecanico,
					'TB_fecha': TB_fecha,
					'TB_valor': TB_valor,
					'TB_utilidad': TB_utilidad,
					'TB_observaciones': TB_observaciones, 
					'id_ordentrabajo': $("#id_orden").val(),
					'Placas': $.trim($("#id_vehiculo").val()),
					'Fecha': $("#TB_fechaDate2").val(),
					'Kilometraje':  $("#TB_kilometraje").val(),
					'mecanico': $.trim($("#TB_mecanico").val()),
					'conductor': $.trim($("#TB_conductor").val()),
					'Observaciones': $.trim($("#TB_observaciones2").val())
			},
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


function mostrarActividadesOrden(id_orden, temp )
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
    	data: {'desea': 'verActividades', 
				"NumeroOrden": id_orden},
		success:  function (data) {  
            $('.dashboard').html(data); 
			cargarDetalleActividades();            
    	},
        error: function(ex){
            console.log(ex);
        }
    });
}

function eliminarActividadOrden(){
	$.ajax({
		url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea':'eliminarActividadOrden',
				'id_orden': $("#id_orden").val(),
			    'id_actividadOrden':$("#id_actividadOrden").val(),
			   
				'Placas': $.trim($("#id_vehiculo").val()),
				'Fecha': $("#TB_fechaDate").val(),
				'Kilometraje':  $("#TB_kilometraje").val(),
				'mecanico': $.trim($("#TB_mecanico").val()),
				'conductor': $.trim($("#TB_conductor").val()),
				'Observaciones': $.trim($("#TB_observaciones").val())
			   },
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


function guardarEditarActividad()
{
    $('#desea').val("guardarEditarActividad");
    
    var mensaje = $("#mensajeEmergente");    
	var id_ActividadOrden = $("#id_ActividadOrden").val();
    var id_actividad = $("#id_actividad").val();
    var TB_tiempo = $("#TB_tiempo").val();
    var id_mecanico = $("#id_mecanico").val();
    var TB_fecha = $("#TB_fecha").val();
    var TB_valor = $("#TB_valor").val();
	var TB_observaciones = $("#TB_observaciones").val();
    var TB_utilidad = $("#TB_utilidad").val();
    var id_ordentrabajo = $("#id_orden").val();
    
    if($.trim(id_actividad) == "")
    {
        $("#mensaje").html("¡La actividad es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(TB_tiempo) == "")
    {
        $("#mensaje").html("¡El tiempo es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(id_mecanico) == "")
    {
        $("#mensaje").html("¡El mecánico es requerido!");
		mensaje.modal("show");
    }
	else if($.trim(TB_fecha) == "")
    {
        $("#mensaje").html("¡La fecha es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(TB_valor) == "")
    {
        $("#mensaje").html("¡El valor es requerido!");
		mensaje.modal("show");
    }
	else if($.trim(TB_utilidad) == "")
    {
        $("#mensaje").html("¡La utilidad es requerida!");
		mensaje.modal("show");
    }
	else if($.trim(TB_observaciones) == "")
    {
        $("#mensaje").html("¡La observacion es requerido!");
		mensaje.modal("show");
    }
	else{
		
		TB_valor = TB_valor.replace(",","");
		$.ajax({
			url:   '../Logica de presentacion/Orden_Trabajo_Logica.php',
			type:  'post',
			dataType:'html',
			data: {'desea': $('#desea').val(),
					'id_ActividadOrden': id_ActividadOrden,
					'id_actividad': id_actividad,
					'TB_tiempo': TB_tiempo,
					'id_mecanico': id_mecanico,
					'TB_fecha': TB_fecha,
					'TB_valor': TB_valor,
					'TB_utilidad': TB_utilidad,
					'TB_observaciones': TB_observaciones, 
					'id_ordentrabajo': id_ordentrabajo,
					'Placas': $.trim($("#id_vehiculo").val()),
					'Fecha': $("#TB_fechaDate2").val(),
					'Kilometraje':  $("#TB_kilometraje").val(),
					'mecanico': $.trim($("#TB_mecanico").val()),
					'conductor': $.trim($("#TB_conductor").val()),
					'Observaciones': $.trim($("#TB_observaciones2").val())
			},
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