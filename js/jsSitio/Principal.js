

// Js principal, para el inicio de sesión, dashboard, registrarse 
// Autor: Miguel Villamizar
// Fecha: 11/11/2017

$(document).ready(function(){
    
    function loadReferencias()
    {               
        $.ajax({
    		url: '../Logica de presentacion/Principal_Logica.php',
    		method: 'post',
    		dataType: 'html',
	        data: {desea: "cargaReferencias"},
    		success: function (data) {                         
				$("#dashboard").html(data);    
    		}
    	}); 
    }
    
});

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateInt(number) {
    var re = /^\d+$/;
    return re.test(number);
}

function IniciaSesion()
{
    $("#desea").val("inicioSesion");
    var mensaje = $("#mensajeEmergente");
    var _val =0;
    
    var correo = $("#TB_correo").val();
    var clave = $("#TB_clave").val();
    
    if($.trim(correo) == "")
    {
        $("#mensaje").html("¡El correo electrónico es requerido!");
		mensaje.modal("show");
    }
    else if($.trim(clave) == "")
    {
        $("#mensaje").html("¡La clave es requerida!");
		mensaje.modal("show");
    }
    else if(!validateEmail(correo))
    {
        $("#mensaje").html("¡El correo electrónico es invalido!");
		mensaje.modal("show");
    }
    else
    {
        $.ajax({
    		url: '../Logica de presentacion/Principal_Logica.php',
    		method: 'post',
    		dataType: 'json',
    		async: false,
    		data: $("#login").serialize(),
    		success: function (data) {
                     
    			if(data == "1"){    			
    				$('#desea').val("cargarSesion");
    				_val=1;
    			}
    			else
    			{
    				$("#mensaje").html("¡El usuario no esta registrado!<br /> Verifique la información!");
    				mensaje.modal("show");    
    				_val=0;
    			}
    		}
    	});   
        
        if(_val == 1){
            
		    $('#desea').val("cargarSesion");
            $.ajax({
        		url: '../Logica de presentacion/Principal_Logica.php',
        		method: 'post',
        		dataType: 'html',
        		data: $("#login").serialize(),
        		success: function (data) {                         
					$('.row2').html(data);    
        		}
        	}); 
            
            
		    $('#desea').val("limpiaLogin");
            
            $.ajax({
        		url: '../Logica de presentacion/Principal_Logica.php',
        		method: 'post',
        		dataType: 'html',
  		        data: $("#login").serialize(),
        		success: function (data) {                         
					$('.row1').html(data);    
        		}
        	});             
        }
    }    
}

function CerrarSesion()
{
    $('#desea').val("cerrarSesion");
    $.ajax({
		url: '../Logica de presentacion/Principal_Logica.php',
		method: 'post',
		dataType: 'html',
		data: $("#login").serialize(),
		success: function (data) {                 
			$('.row1').html(data);
            $('.row2').html('');    
		}
	}); 
}


function registrarUsuario()
{
    
    $('#desea').val("registroUsuario");
    $.ajax({
		url: '../Logica de presentacion/Principal_Logica.php',
		method: 'post',
		dataType: 'html',
		data: $("#login").serialize(),
		success: function (data) {                 
			$('.row1').html('');
            $('.row3').html(data);   
		}
	}); 
    
    $("#loadAjax").modal('show');
        
    $.ajax({
		url: '../Logica de presentacion/Principal_Logica.php',
		method: 'post',
		dataType: 'json',
		data: { 'desea': 'consultarRoles' },
		success: function (data) {   
		  
          for (var i = 0; i < data.length; i++) {            
             $('#id_rol').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
          }

		},
        complete: function(){
            
            var that = $("#loadAjax");
            $("body").removeClass("modal-open");
            $("body").css({"padding-right": "0"});
            that.removeClass("show");
            that.css({"display": "none"});
            $(".modal-backdrop").remove();
            var bsModal = that.data('bs.modal');
            bsModal["_isShown"] = false;
            bsModal["_isTransitioning"] = false;
            that.data('bs.modal', bsModal);

            $("#loadAjax").modal('hide');
        } 
	}); 
}

function atrasRegistro()
{
    $('#desea').val("cerrarSesion");
    $.ajax({
		url: '../Logica de presentacion/Principal_Logica.php',
		method: 'post',
		dataType: 'html',
		data: $("#registro").serialize(),
		success: function (data) {                 
			$('.row1').html(data);
            $('.row3').html('');   
		}
	}); 
}
    
    
function guardarUsuario()
{
    $('#desea').val("guardarUsuario");
    
    var mensaje = $("#mensajeEmergente");
        
    if($.trim($("#TB_nombre").val()) == "")
    {
        $("#mensaje").html("¡El nombre requerido!");
		mensaje.modal("show");
    }    
    else if($.trim($("#TB_apellido").val()) == "")
    {
        $("#mensaje").html("¡El apellido requerido!");
		mensaje.modal("show");
    }
    else if($.trim($("#TB_documento").val()) == "")
    {
        $("#mensaje").html("¡El documento requerido!");
		mensaje.modal("show");
    }
    else if(!validateInt($.trim($.trim($("#TB_documento").val()))))
    {
        $("#mensaje").html("¡El documento es invalido!");
		mensaje.modal("show");
    }
    else if($.trim($("#TB_telefono").val()) == "")
    {
        $("#mensaje").html("¡El teléfono requerido!");
		mensaje.modal("show");
    }    
    else if(!validateInt($.trim($.trim($("#TB_telefono").val()))))
    {
        $("#mensaje").html("¡El teléfono es invalido!");
		mensaje.modal("show");
    }
    else if($.trim($("#id_rol").val()) == "")
    {
        $("#mensaje").html("¡El rol requerido!");
		mensaje.modal("show");
    }    
    else if($.trim($("#TB_direccion").val()) == "")
    {
        $("#mensaje").html("¡La dirección requerido!");
		mensaje.modal("show");
    }
    else if($.trim($("#TB_email").val()) == "")
    {
        $("#mensaje").html("¡El correo electrónico requerido!");
		mensaje.modal("show");
    }    
    else if(!validateEmail($.trim($("#TB_email").val())))
    {
        $("#mensaje").html("¡El correo electrónico es invalido!");
		mensaje.modal("show");
    }    
    else if($.trim($("#TB_clave").val()) == "")
    {
        $("#mensaje").html("¡La clave requerido!");
		mensaje.modal("show");
    }    
    else if($.trim($("#TB_confirmaclave").val()) == "")
    {
        $("#mensaje").html("¡La confirmación de la clave requerido!");
		mensaje.modal("show");
    }    
    else if( $.trim($("#TB_clave").val()) != $.trim($("#TB_confirmaclave").val()))
    {
        $("#mensaje").html("¡Las claves no coinciden!");
		mensaje.modal("show");
    }
    else 
    {            
        $.ajax({
    		url: '../Logica de presentacion/Principal_Logica.php',
    		method: 'post',
    		dataType: 'json',
    		data: $("#registro").serialize(),
    		success: function (data) {                 
    		                      
                $("#mensajeEmergenteRedirect")
                .find('.modal-body > div[id="mensaje"]')
                .html("¡Se han guardado los datos satisfactoriamente!");
                	
        		$("#mensajeEmergenteRedirect").modal("show");
    		},
            error: function(ex){
                
                $("#mensaje").html("¡Se ha generado un error, <br /> comuníquese con el administrador!");
        		mensaje.modal("show");
            }
    	}); 
     }
}

function redirectLogin(){
    
    $('#desea').val("cerrarSesion");
    $.ajax({
		url: '../Logica de presentacion/Principal_Logica.php',
		method: 'post',
		dataType: 'html',
		data: $("#registro").serialize(),
		success: function (data) {                 
			$('.row1').html(data);
            $('.row3').html('');   
		}
	});     
}
    