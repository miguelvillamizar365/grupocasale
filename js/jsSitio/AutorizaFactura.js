
 // manejo pantalla autorización factura
 // @author miguel villamizar
 // @copyright 2018/07/16
 //
 
 
$(document).ready(function(){


    $('#table_facturas').DataTable({       
		
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
			{ 
                title: "Autorizar",
                targets: -1,
                render: function (data, type, row) {
					if(row.EstadoId == 1)
					{
						return "<button class='A_autorizar btn btn-primary' >Autorizar</button>";
					}
					else{
						return "";
					}
                }
            },
            { 
                title: "Imprimir",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_imprimir btn btn-secondary' >Imprimir</button>";
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
            { data: "proveedorId",        title: "Proveedor"    },
            { data: "proveedor",        title: "Proveedor",     },
            { data: "modopagoId",         title: "Modo de pago" },
            { data: "modopago",         title: "Modo de pago"   },
            { data: "Fecha",            title: "Fecha",         },
            { data: "EstadoId",            title: "Estado",     },
			{ data: "Estado",            title: "Estado",       }
        ],
		columnDefs: [
			{
				targets: [ 3 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 6 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 8 ],
				visible: false,
				searchable: false
			},
			{
				targets: [11 ],
				visible: false,
				searchable: false
			}
		]
    });
    
    $.ajax({
        url: '../Logica de presentacion/AutorizaFactura_Logica.php',
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
                 
        }
	}); 	
 });
  

$('#table_facturas').on('click', 'td .A_autorizar', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_facturas').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/AutorizaFactura_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'AutorizarFactura', 
               "NumeroFactura": dataItem.NumeroFactura},
    	success:  function (data) {  
		
			mostrarFacturas(0);
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});


$('#table_facturas').on('click', 'td .A_imprimir', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_facturas').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
	$("#NumeroFactura").val(dataItem.NumeroFactura);
	$("#empresaId").val(dataItem.empresaId);
	$("#EmpresaCompra").val(dataItem.EmpresaCompra);
	$("#ValorFactura").val(dataItem.ValorFactura);
	$("#proveedorId").val(dataItem.proveedorId);  
	$("#proveedor").val(dataItem.proveedor);  
	$("#modopagoId").val(dataItem.modopagoId);    
	$("#modopago").val(dataItem.modopago);   
	$("#Fecha").val(dataItem.Fecha);    
				
	$("#ExportarInformeFactura").submit();
});
 
 
 function cargarFechas()
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

 }
 
function buscarFacturas()
{
	 var fechaInicial = $("#TB_fechaIni").val();
	 var fechaFinal = $("#TB_fechaFin").val();
	 var TB_referencia = $("#id_referencia").val();
	 
	if($("#TB_referencia").val() == "")
	{
		 TB_referencia = "";
		 TB_nombreRepuesto = "";
	}
	
	$.ajax({
		url: '../Logica de presentacion/AutorizaFactura_Logica.php',
		type:  'post',
		dataType:'json',
		data: {
				'desea': 'cargaFacturasFiltros',
				'referencia': TB_referencia,
				'fechaInicial': fechaInicial,
				'fechaFinal': fechaFinal
		},
		success:  function (data) {
			 
			$('#table_facturas').DataTable().clear().draw().rows.add(data).draw();
			
		},
		error: function(ex){
			console.log(ex);
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
    	url:   '../Logica de presentacion/AutorizaFactura_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':''},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	       
        
}