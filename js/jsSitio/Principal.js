

// Js principal, para el inicio de sesión, dashboard, registrarse 
// Autor: Miguel Villamizar
// Fecha: 11/11/2017

$(document).ready(function(){

   	$("#B_referencias").click(function(event){
		
		event.preventDefault();
		$.ajax({
			url:   $(this).attr("href"),
			type:  'post',
			dataType:'html',
			data: { 'desea': ''},
			success:  function (data) {
				$('.dashboard').html(data);
			}
		});		
	});	
    
    $("#B_facturas").click(function(event){
		
		event.preventDefault();
		$.ajax({
			url:   $(this).attr("href"),
			type:  'post',
			dataType:'html',
			data: { 'desea': ''},
			success:  function (data) {
				$('.dashboard').html(data);
			}
		});		
	});	
	
    $("#B_ordenTrabajo").click(function(event){
		
		event.preventDefault();
		$.ajax({
			url:   $(this).attr("href"),
			type:  'post',
			dataType:'html',
			data: { 'desea': ''},
			success:  function (data) {
				$('.dashboard').html(data);
			}
		});		
	});	
    
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
    
    $.ajax({
		url: '../Logica de presentacion/Principal_Logica.php',
		method: 'post',
		dataType: 'html',
		data: {'desea': 'cerrarSesion'},
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
    
    //$("#loadAjax").modal('show');
        
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
            
            
        $('#id_rol').selectize({
			create: false,
			sortField: {
				field: 'text',
				direction: 'asc'
			},
			dropdownParent: 'body'
		});
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

function atrasRegistro()
{
    $('#desea').val("");
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
    var mensaje = $("#mensajeEmergente");
        
    if($.trim($("#TB_nombre").val()) == "")
    {
        $("#mensaje").html("¡El nombre es requerido!");
		mensaje.modal("show");
    }    
    else if($.trim($("#TB_apellido").val()) == "")
    {
        $("#mensaje").html("¡El apellido es requerido!");
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
    else if(ValidaCorreoUsuario())
    {        
        $("#mensaje").html("¡El correo electrónico ya esta registrado!");
		mensaje.modal("show");
    }
    else 
    {            
        $('#desea').val("guardarUsuario");
        $.ajax({
    		url: '../Logica de presentacion/Principal_Logica.php',
    		method: 'post',
    		dataType: 'html',
    		data: $("#registro").serialize(),
    		success: function (data) {                 
    		   
                $('.row3').html(data);  
    		},
            error: function(ex){
                
                $("#mensaje").html(ex.responseText);
        		mensaje.modal("show");
            }
    	}); 
     }
}

function ValidaCorreoUsuario()
{
   var temp =0;
   $('#desea').val("validaUsuario");
   $.ajax({
		url: '../Logica de presentacion/Principal_Logica.php',
		method: 'post',
		dataType: 'json',
		async: false,
		data: $("#registro").serialize(),
		success: function (data) {
            
			if(data.length > 0){    			
				temp =1;
			}
			else
			{
                temp =0;
			}
		}
	});       
    
    if(temp == 1){
        return true;
	}
	else
	{
		return false;
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
    