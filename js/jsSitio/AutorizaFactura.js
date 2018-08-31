
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
    
	console.log(dataItem);
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