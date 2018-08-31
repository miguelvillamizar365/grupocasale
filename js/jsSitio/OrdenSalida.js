
 // manejo pantalla orden salida
 // @author miguel villamizar
 // @copyright 2018/07/16
 //
 
$(document).ready(function(){	
	   		
			
}); 

$('#table_OrdenesAll').on('click', 'td .A_autorizar', function (e) {
            
    e.preventDefault();
    
    var table = $('#table_OrdenesAll').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
    $.ajax({
        url: '../Logica de presentacion/OrdenSalida_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea': 'AutorizarOrden', 
               "NumeroOrden": dataItem.Id},
    	success:  function (data) {  
			mostrarOrdenes(0);
    	},
        error: function(ex){
            console.log(ex);
        }
    });
});



$('#table_OrdenesAll').on('click', 'td .A_imprimir', function (e) {
                
    var table = $('#table_OrdenesAll').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();   
	
    $("#id_orden").val(dataItem.Id);
	$("#Placas").val(dataItem.Placas);
	$("#Fecha").val(dataItem.Fecha);
	$("#ValorTotalReferencia").val(dataItem.ValorTotalReferencia);
	$("#ValorTotalUtilidadReferencia").val(dataItem.ValorTotalUtilidadReferencia);
	$("#ValorTotalActividad").val(dataItem.ValorTotalActividad);
	$("#ValorTotalUtilidadActividad").val(dataItem.ValorTotalUtilidadActividad);
	$("#Kilometraje").val(dataItem.Kilometraje);
	$("#mecanico").val(dataItem.mecanico);
	$("#conductor").val(dataItem.conductor);
	$("#Observaciones").val(dataItem.Observaciones);
	$("#id_ordenUtilidad").val(id_ordenUtilidad);
		
	$("#ExportarInformeOrdenTrabajo").submit();
});

var id_ordenUtilidad = 0;
$('#table_OrdenesAll').on('click', 'td .C_checkbox', function (e) {
                
    var table = $('#table_OrdenesAll').DataTable();
    var dataItem = table.row($(this).closest('tr')).data();        
    
	id_ordenUtilidad = (dataItem.Id);
});

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
    	url:   '../Logica de presentacion/OrdenSalida_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':''},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	              
}