 
 // manejo pantalla Alistamiento preoperacional
 // @author miguel villamizar
 // @copyright 2018/04/28
 //
 
 
$(document).ready(function(){

    $('#table_alistamiento').DataTable({
        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
			{ 
                title: "Editar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_editar btn btn-primary' >Editar</button>";
                }
            },
            { data: "Id",    title: "No. Alistamiento"   },
            { data: "Placas",    title: "Placas"},
            { data: "fecha",    title: "Fechas"},
            { data: "Kilometraje",        title: "Kilometraje"},
            { data: "Conductor",        title: "Conductor"   },
            { data: "Mecanico",         title: "Mecanico"},
            { data: "Observaciones",         title: "Observaciones"      },
        ]
    });
    
    $.ajax({
        url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
    	type:  'post',
    	dataType:'json',
    	data: {'desea': 'cargaAlistamiento'},
    	success:  function (data) {
    	     
            $('#table_alistamiento').DataTable().clear().draw().rows.add(data).draw();
			
    	},
        error: function(ex){
            console.log(ex);
        }
    });    
 });
 

$('#table_alistamiento').on( 'click', 'td .A_editar', function (e) {
			
	e.preventDefault();
	
	var table = $('#table_alistamiento').DataTable();
	var dataItem = table.row($(this).closest('tr')).data();        
	 
	 
	$.ajax({
		url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea': 'editarAlistamiento'},
		success:  function (data) {  
		  $('.dashboard').html(data);
		  
		},
		error: function(ex){
			console.log(ex);
		},
		complete: function(ex){
			
			$.ajax({
				url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
				type:  'post',
				dataType:'json',					   
				data: {'desea': 'editarAlistamientoDatos', 
				'Id': dataItem.Id},
				success:  function (data) {  
				  
					$("#IdAlistamiento").val(dataItem.Id);
					$("#TB_fecha").val(data[0].fecha);
					$("#TB_fechaDate").val(data[0].fecha);
					$("#TB_kilometraje").val(data[0].Kilometraje);
					$("#TB_observaciones").val(data[0].Observaciones);
					cargarListasDesplegables(data[0].id_conductor, data[0].id_mecanico, data[0].Id_vehiculo);
						  
					$('#table_alistamientoCheckList').DataTable({						
						language: { url: '../datatables/Spanish.json' },
						data: null,
						scrollX: true,
						columns: [
							{ 
								targets: 0,
								'render': function (data, type, full, meta){
									
									var result = data.split(",");
									
									if(result[1] =='true')
									{
										return '<input type="checkbox" checked name="id[]" value="' + $('<div/>').text(result[0]).html() + '">';
									}
									else
									{
										return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(result[0]).html() + '">';
									}
								 },
								'searchable': false,
								'orderable': false,
								'className': 'dt-body-center'
							},
							{ data: "Id",    title: "Id"},
							{ data: "Descripcion",    title: "Descripcion", width: "100%"},					
						]
					});

					$('#example-select-all').on('click', function(){
					  var rows = $('#table_alistamientoCheckList').DataTable().rows({ 'search': 'applied' }).nodes();
					   $('input[type="checkbox"]', rows).prop('checked', this.checked);
					});


					$.ajax({
						url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
						type:  'post',
						dataType:'json',
						data: {'desea': 'cargaCheckAlistamientoEditar',
							   'Id':  dataItem.Id },
						success:  function (data) {
							 
							$('#table_alistamientoCheckList').DataTable().clear().draw().rows.add(data).draw();
							
						},
						error: function(ex){
							console.log(ex);
						}
					});    
				},
				error: function(ex){
					console.log(ex);
				}
			});
		}
	});
	
	
});
 
 
 function mostrarAlistamiento(temp)
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
    	url:   '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':''},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	       
 }
 
 
function formularioCrearAlistamiento()
{
    $.ajax({
    	url:   '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':'crearAlistamiento'},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	},
		complete: function () {			
			cargarListasDesplegables(0, 0, 0);
			
			
			$('#table_alistamientoCheckList').DataTable({
				
				language: { url: '../datatables/Spanish.json' },
				data: null,
				scrollX: true,
				columns: [
					{ 
						targets: 0,
						'render': function (data, type, full, meta){
							return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
						 },
						'searchable': false,
						'orderable': false,
						'className': 'dt-body-center'
					},
					{ data: "Id",    title: "Id"},
					{ data: "Descripcion",    title: "Descripcion", width: "100%"},					
				]
			});
			
			$('#example-select-all').on('click', function(){
			  // Get all rows with search applied
			  var rows = $('#table_alistamientoCheckList').DataTable().rows({ 'search': 'applied' }).nodes();
			  // Check/uncheck checkboxes for all rows in the table
			  $('input[type="checkbox"]', rows).prop('checked', this.checked);
		   });

   
			$.ajax({
				url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
				type:  'post',
				dataType:'json',
				data: {'desea': 'cargaCheckAlistamiento'},
				success:  function (data) {
					 
					$('#table_alistamientoCheckList').DataTable().clear().draw().rows.add(data).draw();
					
				},
				error: function(ex){
					console.log(ex);
				}
			});    
		}		
    });	
    
}
 
 
 function guardarAlistamiento()
 { 
	 $('#desea').val("guardarAlistamiento");
	
	 var mensaje = $("#mensajeEmergente");    
	 var vehiculo = $("#id_vehiculo").val();
	 var TB_fecha = $("#TB_fecha").val();
	 var TB_kilometraje = $("#TB_kilometraje").val();
	 var id_conductor = $("#id_conductor").val();
	 var id_mecanico = $("#id_mecanico").val();
	 var TB_observaciones = $("#TB_observaciones").val();
	 
	 var idCheck = [];
	//obtengo el checklist
	$('#table_alistamientoCheckList').DataTable().$('input[type="checkbox"]').each(function(){
		 
		if(this.checked){							   
		   idCheck.push(this.value);
		}		
	});
	 
	 var checkList = (JSON.stringify(idCheck));
	
	 if(vehiculo == "")
	 {
		$("#mensaje").html("¡El vehiculo es requerido!");
		mensaje.modal("show");
	 }
	 else if( TB_fecha == "")
	 {
		$("#mensaje").html("¡La fecha es requerida!");
		mensaje.modal("show");
	 }    
	 else if($.trim(TB_kilometraje) == "")
	 {
		$("#mensaje").html("¡El kilometraje es requerido!");
		mensaje.modal("show");
	 }    
	 else if($.trim(id_conductor) == "")
	 {
		$("#mensaje").html("¡El conductor es requerido!");
		mensaje.modal("show");
	 }
	 else if($.trim(id_mecanico) == "")
	 {
		$("#mensaje").html("¡El mecánico es requerido!");
		mensaje.modal("show");
	 }
	 else if($.trim(TB_observaciones) == "")
	 {
		$("#mensaje").html("¡Las observaciones son requeridas!");
		mensaje.modal("show");
	 }	
	 else if($.trim(checkList) == "")
	 {
		$("#mensaje").html("¡No selecionó check list!");
		mensaje.modal("show");
	 }	
	 else
	 {
		$.ajax({
			url:   '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
			type:  'post',
			dataType:'html',
			data: {				
				 'desea': $('#desea').val(),
				 'vehiculo': $("#id_vehiculo").val(),
				 'TB_fecha': $("#TB_fecha").val(),
				 'TB_kilometraje': $("#TB_kilometraje").val(),
				 'id_conductor': $("#id_conductor").val(),
				 'id_mecanico': $("#id_mecanico").val(),
				 'TB_observaciones': $("#TB_observaciones").val(),
				 'checkList': checkList
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
 
function cargarListasDesplegables(conductorId, mecanicoId, vehiculoId)
{
	 $.ajax({
		url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
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
		url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
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
	
	
	$.ajax({
		url: '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
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
}

function editarAlistamiento()
{
	$('#desea').val("guardarEditarAlistamiento");
	
	 var mensaje = $("#mensajeEmergente");  
	 var idAlistamiento = $("#IdAlistamiento").val();
	 var vehiculo = $("#id_vehiculo").val();
	 var TB_fecha = $("#TB_fecha").val();
	 var TB_kilometraje = $("#TB_kilometraje").val();
	 var id_conductor = $("#id_conductor").val();
	 var id_mecanico = $("#id_mecanico").val();
	 var TB_observaciones = $("#TB_observaciones").val();
	 
	 var idCheck = [];
	//obtengo el checklist
	$('#table_alistamientoCheckList').DataTable().$('input[type="checkbox"]').each(function(){
		 
		if(this.checked){							   
		   idCheck.push(this.value);
		}		
	});
	 
	 var checkList = (JSON.stringify(idCheck));
	
	 if(vehiculo == "")
	 {
		$("#mensaje").html("¡El vehiculo es requerido!");
		mensaje.modal("show");
	 }
	 else if( TB_fecha == "")
	 {
		$("#mensaje").html("¡La fecha es requerida!");
		mensaje.modal("show");
	 }    
	 else if($.trim(TB_kilometraje) == "")
	 {
		$("#mensaje").html("¡El kilometraje es requerido!");
		mensaje.modal("show");
	 }    
	 else if($.trim(id_conductor) == "")
	 {
		$("#mensaje").html("¡El conductor es requerido!");
		mensaje.modal("show");
	 }
	 else if($.trim(id_mecanico) == "")
	 {
		$("#mensaje").html("¡El mecánico es requerido!");
		mensaje.modal("show");
	 }
	 else if($.trim(TB_observaciones) == "")
	 {
		$("#mensaje").html("¡Las observaciones son requeridas!");
		mensaje.modal("show");
	 }	
	 else if($.trim(checkList) == "")
	 {
		$("#mensaje").html("¡No selecionó check list!");
		mensaje.modal("show");
	 }	
	 else
	 {
		$.ajax({
			url:   '../Logica de presentacion/AlistamientoPreoperacional_Logica.php',
			type:  'post',
			dataType:'html',
			data: {				
				 'desea': $('#desea').val(),
				 'idAlistamiento': $("#IdAlistamiento").val(),
				 'vehiculo': $("#id_vehiculo").val(),
				 'TB_fecha': $("#TB_fecha").val(),
				 'TB_kilometraje': $("#TB_kilometraje").val(),
				 'id_conductor': $("#id_conductor").val(),
				 'id_mecanico': $("#id_mecanico").val(),
				 'TB_observaciones': $("#TB_observaciones").val(),
				 'checkList': checkList
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

 