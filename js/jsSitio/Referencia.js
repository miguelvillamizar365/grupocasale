 
 // manejo pantalla referencias
 // @author miguel villamizar
 // @copyright 2017/11/13
 //
 
$(document).ready(function(){
    
    $('#table_referencias').DataTable({
        
        language: { url: '../datatables/Spanish.json' },
        data: null,
        scrollX: true,
        columns: [
            { data: "Id",               title: "Id Referencia",   },
            { data: "Nombre",           title: "Nombre",          },
            { data: "tipoempaque",      title: "Tipo Empaque",    },
            { data: "clasificacion",    title: "Clasificacion",   },
            { data: "Stante",           title: "Stante",          },
            { data: "Piso",             title: "Piso",            },
            { data: "Stock",            title: "Stock",           },
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
                    return "<button class='A_imprimir btn btn-danger' >Imprimir</button>";
                }  
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
    
    //$("#loadAjax").modal('show');
        
    $.ajax({
		url: '../Logica de presentacion/Referencia_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultarTipoEmpaque' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_tipoempaque').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
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
            
            //var that = $("#loadAjax");
            //$("body").removeClass("modal-open");
            //$("body").css({"padding-right": "0"});
            //that.removeClass("show");
            //that.css({"display": "none"});
            //$(".modal-backdrop").remove();
            //var bsModal = that.data('bs.modal');
            //bsModal["_isShown"] = false;
            //bsModal["_isTransitioning"] = false;
            //that.data('bs.modal', bsModal);

            //$("#loadAjax").modal('hide'); 
        } 
	}); 
}


function guardarReferencias(){
       
    $('#desea').val("guardarReferencia");
    
    var mensaje = $("#mensajeEmergente");
    
    var nombre = $("#TB_nombre").val();
    var tipoEmpaque = $("#id_tipoempaque").val();
    var clasifica = $("#id_clasificacion").val();
    var stante = $("#TB_stante").val();
    var piso = $("#TB_piso").val();
    var stock = $("#TB_stock").val();
    
    
    if($.trim(nombre) == "")
    {
        $("#mensaje").html("¡El nombre es requerido!");
		mensaje.modal("show");
    }    
    else if($.trim(tipoEmpaque) == "")
    {
        $("#mensaje").html("¡El tipo empaque es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(clasifica) == "")
    {
        $("#mensaje").html("¡La clasificación es requerida!");
		mensaje.modal("show");
    }
    else if($.trim(stante) == "")
    {
        $("#mensaje").html("¡El stante es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(piso) == "")
    {
        $("#mensaje").html("¡El piso es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(stock) == "")
    {
        $("#mensaje").html("¡El stock es requerido!");
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
    				$("#mensaje").html("¡se genero un error al guardar la información!");
    				mensaje.modal("show"); 
                }
    		},
            error: function(ex){
                
                $("#mensaje").html("¡se genero un error al guardar la información!");
        		mensaje.modal("show");
            }            
    	});	   
    }
}


