 
 // manejo pantalla referencias
 // @author miguel villamizar
 // @copyright 2017/11/13
 //
 
$(document).ready(function(){


    $('#table_referencias').DataTable({
        
        language: { url: '../datatables/Spanish.json' },
		dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],
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
            { 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_eliminar btn btn-secondary' >Eliminar</button>";
                }  
            },
            { 
                title: "Imprimir Rotulo",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_imprimir btn btn-outline-primary' >Imprimir</button>";
                }  
            },
            { data: "Id"},
			{ data: "Codigo",           title: "Codigo Referencia"},
            { data: "Nombre",           title: "Nombre"           },
            { data: "tipoempaqueId",    title: "Tipo Empaque"     },
            { data: "tipoempaque",      title: "Tipo Empaque"     },
            { data: "clasificacionId",  title: "Clasificacion"	  },
            { data: "clasificacion",    title: "Clasificacion"    },
            { data: "Stante",           title: "Stante"           },
            { data: "Piso",             title: "Piso"             },
			{ data: "Cantidad",         title: "Cantidad Inicial" },
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
							result = split[1] != undefined ? result : result;
						}

						return result;
					}
			},
			{ data: "CantidadActual",   title: "Cantidad Actual", },
			{ 
				data: "ValorTotalActual",
				title: "Valor Total Actual",
				mRender: function (data, type, full) {
					  
						var number = data.replace(",", ""),
						thousand_separator = ',',
						decimal_separator = '.';

						var	number_string = number.toString(),
						split	  = number_string.split(decimal_separator),
						result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
						if(split[1] != "")
						{
							result = split[1] != undefined ? result : result;
						}

						return result;
					}
			},
			{ data: "CantidadUsada",    title: "Cantidad Usada",  },
			{ 
				data: "ValorTotalUsado",
				title: "Valor Total Usado",
				mRender: function (data, type, full) {
					  
						var number = data.replace(",", ""),
						thousand_separator = ',',
						decimal_separator = '.';

						var	number_string = number.toString(),
						split	  = number_string.split(decimal_separator),
						result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
						if(split[1] != "")
						{
							result = split[1] != undefined ? result : result;
						}

						return result;
					}
			},
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
			}
		]
    });
    
    $.ajax({
        url: '../Logica de presentacion/Referencia_Logica.php',
    	type:  'post',
    	dataType:'json',
    	data: {'desea': 'cargaReferencias'},
    	success:  function (data) {
    	     
            $('#table_referencias').DataTable().clear().draw().rows.add(data).draw();
			var valorTotal =parseFloat(0);
			var cont =0;
			while(cont < data.length)
			{
				valorTotal = parseFloat(valorTotal) + parseFloat(data[cont].ValorTotalActual);
				cont ++;
			}
			

			var number = 
			thousand_separator = ',',
			decimal_separator = '.';

			var	number_string = valorTotal.toString(),
			split	  = number_string.split(decimal_separator),
			result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					
			if(split[1] != "")
			{
				result = split[1] != undefined ? result : result;
			}

			$("#L_total").html("<b> Valor Total Actual: $ "+result+"</b>");
    	},
        error: function(ex){
            console.log(ex);
        }
    });    
 });


    $('#table_referencias').on( 'click', 'td .A_editar', function (e) {
                
        e.preventDefault();
        
        var table = $('#table_referencias').DataTable();
        var dataItem = table.row($(this).closest('tr')).data();        
         
         
        $.ajax({
            url: '../Logica de presentacion/Referencia_Logica.php',
        	type:  'post',
        	dataType:'html',
        	data: {'desea': 'editarReferencia', 
                   'Id': dataItem.Id, 
				   'Codigo': dataItem.Codigo, 
                   'Nombre': dataItem.Nombre, 
                   'Piso':dataItem.Piso, 
                   'Stante':dataItem.Stante, },
        	success:  function (data) {  
    		  $('.dashboard').html(data);
              cargarListasDesplegables(dataItem.clasificacionId, dataItem.tipoempaqueId);
        	},
            error: function(ex){
                console.log(ex);
            }
        });
    });
    
    
    $('#table_referencias').on( 'click', 'td .A_eliminar', function (e) {
    	
        e.preventDefault();        
        
        var table = $('#table_referencias').DataTable();
        var dataItem = table.row($(this).closest('tr')).data();        
                
        $("#id_referencia").val(dataItem.Id);
        $("#mensajeConf").html("�Esta seguro de eliminar el registro?");
		$("#mensajeConfirma").modal("show");
        
    });
    
    $('#table_referencias').on( 'click', 'td .A_imprimir', function (e) {
    	
        e.preventDefault();
        
        var table = $('#table_referencias').DataTable();
        var dataItem = table.row($(this).closest('tr')).data();        

        $.ajax({
            url: '../Logica de presentacion/Referencia_Logica.php',
        	type:  'post',
        	dataType:'html',
        	data: {'desea': 'imprimirReferencia', 
                   'Id': dataItem.Id,
				   'Codigo': dataItem.Codigo,
                   'articulo': dataItem.Nombre,
                   'stante': dataItem.Stante,
                   'piso': dataItem.Piso },
        	success:  function (data) {  
    		  $('.dashboard').html(data);
              
        	},
            error: function(ex){
                console.log(ex);
            }
        });
    });


function mostrarReferencias(temp)
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
    else if(temp == 2)
    {
        var that = $("#mensajeImprimirReferencia");
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
    	url:   '../Logica de presentacion/Referencia_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':''},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	
}


function formularioCrearReferencias()
{
    $.ajax({
    	url:   '../Logica de presentacion/Referencia_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':'cargaFormularioCrear'},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	}
    });	
    
    cargarListasDesplegables(0,0);
}

function cargarListasDesplegables(clasificacionId, tipoempaqueId)
{
     $.ajax({
		url: '../Logica de presentacion/Referencia_Logica.php',
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
            
            if(tipoempaqueId  != 0){             
                $('#id_tipoempaque')[0].selectize.setValue(tipoempaqueId);     
            }               
        }
	}); 
        
    $.ajax({
		url: '../Logica de presentacion/Referencia_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultarClasificacion' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_clasificacion').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          }
		},
        complete: function(){
            
             $('#id_clasificacion').selectize({
            	create: false,
            	sortField: {
            		field: 'text',
            		direction: 'asc'
            	},
            	dropdownParent: 'body'
            });
            
            if(clasificacionId  != 0){             
                $('#id_clasificacion')[0].selectize.setValue(clasificacionId);     
            }
        } 
	}); 
    
}

function guardarReferencias(){
       
    $('#desea').val("guardarReferencia");
    
    var mensaje = $("#mensajeEmergente");
    
    var codigo = $("#TB_referencia").val();
	var nombre = $("#TB_nombre").val();
    var tipoEmpaque = $("#id_tipoempaque").val();
    var clasifica = $("#id_clasificacion").val();
    var stante = $("#TB_stante").val();
    var piso = $("#TB_piso").val();
    
    
    if($.trim(codigo) == "")
    {
        $("#mensaje").html("�El c�digo es requerido!");
		mensaje.modal("show");
    }    	
    else if($.trim(nombre) == "")
    {
        $("#mensaje").html("�El nombre es requerido!");
		mensaje.modal("show");
    }    
    else if($.trim(tipoEmpaque) == "")
    {
        $("#mensaje").html("�El tipo empaque es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(clasifica) == "")
    {
        $("#mensaje").html("�La clasificaci�n es requerida!");
		mensaje.modal("show");
    }
    else if($.trim(stante) == "")
    {
        $("#mensaje").html("�El stante es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(piso) == "")
    {
        $("#mensaje").html("�El piso es requerido!");
		mensaje.modal("show");
    }
    else
    {
         $.ajax({
    		url:   '../Logica de presentacion/Referencia_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: $("#referencia").serialize(),
    		success:  function (data) {
    			if(data){    			 
    		      $('.dashboard').html(data);
    			}
                else {               
    				$("#mensaje").html("�se genero un error al guardar la informaci�n!");
    				mensaje.modal("show"); 
                }
    		},
            error: function(ex){
                
                $("#mensaje").html(ex.responseText);
        		mensaje.modal("show");
            }            
    	});	   
    }
}

function editarReferencias(){
    
    $('#desea').val("guardarEditarReferencia");
    
    var mensaje = $("#mensajeEmergente");
    
    var codigo = $("#TB_referencia").val();
    var nombre = $("#TB_nombre").val();
    var tipoEmpaque = $("#id_tipoempaque").val();
    var clasifica = $("#id_clasificacion").val();
    var stante = $("#TB_stante").val();
    var piso = $("#TB_piso").val();
    
    
    if($.trim(codigo) == "")
    {
        $("#mensaje").html("�El c�digo es requerido!");
		mensaje.modal("show");
    }    
    if($.trim(nombre) == "")
    {
        $("#mensaje").html("�El nombre es requerido!");
		mensaje.modal("show");
    }    
    else if($.trim(tipoEmpaque) == "")
    {
        $("#mensaje").html("�El tipo empaque es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(clasifica) == "")
    {
        $("#mensaje").html("�La clasificaci�n es requerida!");
		mensaje.modal("show");
    }
    else if($.trim(stante) == "")
    {
        $("#mensaje").html("�El stante es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(piso) == "")
    {
        $("#mensaje").html("�El piso es requerido!");
		mensaje.modal("show");
    }
    else
    {
         $.ajax({
    		url:   '../Logica de presentacion/Referencia_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: $("#editarReferencia").serialize(),
    		success:  function (data) {
    			if(data){    			 
    		      $('.dashboard').html(data);
    			}
                else {               
    				$("#mensaje").html("�se genero un error al guardar la informaci�n!");
    				mensaje.modal("show"); 
                }
    		},
            error: function(ex){
                
                $("#mensaje").html(ex.responseText);
        		mensaje.modal("show");
            }            
    	});	   
    }
}

function eliminarReferencias()
{    
    
    $("#mensajeConfirma").modal("hide");    
        
    var mensaje = $("#mensajeEmergente");
    var temp =0;
    $.ajax({
		url:   '../Logica de presentacion/Referencia_Logica.php',
		type:  'post',
		dataType:'json',
		data: {'desea': "validaEliminarReferencia",
               'id_referencia': $('#id_referencia').val()
        },
        async: false,
		success: function (data) {
		  
			if( parseInt(data) == parseInt(0)){    			 
			 temp =1;
			}
            else {               
				$("#mensaje").html("�La referencia no se puede eliminar!");
				mensaje.modal("show"); 
            }
		},
        error: function(ex){
            console.log(ex);
        }            
	});
    
      
    if(temp == 1){
        $.ajax({
    		url:   '../Logica de presentacion/Referencia_Logica.php',
    		type:  'post',
    		dataType:'html',
    		data: {'desea': "eliminarReferencia",
                   'id_referencia': $('#id_referencia').val()
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

function exportarReferencia(){
    
    window.open('../Logica de presentacion/Referencia_Logica.php?desea=exportarReferencia', "_blank");
}



