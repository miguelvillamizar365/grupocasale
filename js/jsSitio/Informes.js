
 // manejo pantalla informes
 // @author miguel villamizar
 // @copyright 2018/07/28
 //
 
 
$(document).ready(function(){
  
 });
 
 
 function cargarTiemposMecanico()
 {
		
	$("#TB_fechaIni").val(getDate());
	$("#TB_fechaFin").val(getDate());
	$("#TB_fechaDateIni").val(getDate());
	$("#TB_fechaDateFin").val(getDate());
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


	$('#table_tiempoMecanico').DataTable({
		
		language: { url: '../datatables/Spanish.json' },
		data: null,
		scrollX: true,
		columns: [
			{ 
				title: "Imprimir",
				targets: -1,
				render: function (data, type, row) {
					return "<button class='A_imprimir btn btn-primary' >Imprimir</button>";							                   
				}
			},					
			{ data: "Documento",    title: "Documento",   },
			{ data: "Nombre",    title: "Nombre",   },
			{ data: "Apellido",    title: "Apellido"},
			{ data: "tiempo",    title: "Tiempo"},
			{ 
				data: "valor",
				title: "Valor",
				mRender: function (data, type, full) {
				  
					var number = data,
					thousand_separator = ',',
					decimal_separator = '.';

					var	number_string = number.toString(),
					split  = number_string.split(decimal_separator),
					result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
							
					if(split[1] != "")
					{
						result = split[1] != undefined ? result + decimal_separator + split[1] : result;
					}
					return result;
				}
			}
		]
	});
	 var fechaInicial = $("#TB_fechaIni").val();
	 var fechaFinal = $("#TB_fechaFin").val();
	
	$.ajax({
		url: '../Logica de presentacion/Informes_Logica.php',
		type:  'post',
		dataType:'json',
		data: {'desea': 'cargaInformeTiemposMecanico',
			   'fechaInicial': fechaInicial,
			   'fechaFinal': fechaFinal},
		success:  function (data) {
			 
			$('#table_tiempoMecanico').DataTable().clear().draw().rows.add(data).draw();
			
		},
		error: function(ex){
			console.log(ex);
		}
	});  
		
	$('#table_tiempoMecanico').on('click', 'td .A_imprimir', function (e) {
				
		e.preventDefault();
		
		var table = $('#table_tiempoMecanico').DataTable();
		var dataItem = table.row($(this).closest('tr')).data();        
		
		$("#Documento").val(dataItem.Documento);
		$("#Nombre").val(dataItem.Nombre);
		$("#Apellido").val(dataItem.Apellido);
		$("#Tiempo").val(dataItem.tiempo);
		$("#Valor").val(dataItem.valor);
		
		$("#ExportarInformeTiempoMecanico").submit();
	});			
 }
 
 function filtarMecanicos()
 {
	 var fechaInicial = $("#TB_fechaIni").val();
	 var fechaFinal = $("#TB_fechaFin").val();
	 	 
    var mensaje = $("#mensajeEmergente");  
	 $.ajax({
		url: '../Logica de presentacion/Informes_Logica.php',
		type:  'post',
		dataType:'json',
		data: {'desea': 'cargaInformeTiemposMecanico',
			   'fechaInicial': fechaInicial,
			   'fechaFinal': fechaFinal},
		success:  function (data) {
			
			if(data){    			 					
				if(data.length == 0){    			 
				   $("#mensaje").html("¡No se encontraron datos, con los filtros de entrada!");
					mensaje.modal("show"); 
				}
				else if(data.length >= 0){    			 
					$('#table_tiempoMecanico').DataTable().clear().draw().rows.add(data).draw();	
				}
			}
			else {               
				$("#mensaje").html("¡se genero un error al consultar la información!");
				mensaje.modal("show"); 
			}
		},
		error: function(ex){
			
			$("#mensaje").html(ex.responseText);
			mensaje.modal("show");
		}   
	});  
 }