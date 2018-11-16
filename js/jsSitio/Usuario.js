
 // manejo pantalla usuarios
 // @author miguel villamizar
 // @copyright 2018/08/30
 //
 
$(document).ready(function(){

    $('#table_usuarios').DataTable({
        
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
            { 
                title: "Eliminar",
                targets: -1,
                render: function (data, type, row) {
                    return "<button class='A_eliminar btn btn-secondary' >Eliminar</button>";
                }  
            },
            { data: "Id", 				 title: "Id Usuario"		},
			{ data: "Nombre",            title: "Nombre"			},
            { data: "Apellido",          title: "Apellido"       	},
            { data: "Documento",    	 title: "Documento"     	},
            { data: "Telefono",      	 title: "Telefono"     		},
            { data: "Direccion",  		 title: "Direccion"	  		},
            { data: "Correo",		     title: "Correo"    		},
			{ data: "RenovacionLicencia",title: "Renovación Licencia"},
			{ data: "LicenciaTrancito",  title: "Licencia Trancito"	},
			{ data: "Id_Rol",			title: "Rol"				},
			{ data: "Rol",				title: "Rol"				},
			{ data: "HoraMecanico",		title: "Hora Mecanico"		},
			{ data: "Estado",			title: "Estado"				},
        ],
		columnDefs: [
			{
				targets: [ 11 ],
				visible: false,
				searchable: false
			}
		]
    });
    
    $.ajax({
        url: '../Logica de presentacion/Usuario_Logica.php',
    	type:  'post',
    	dataType:'json',
    	data: {'desea': 'cargaUsuarios'},
    	success:  function (data) {
    	     
            $('#table_usuarios').DataTable().clear().draw().rows.add(data).draw();
			
    	},
        error: function(ex){
            console.log(ex);
        }
    });    
 });
 

$('#table_usuarios').on( 'click', 'td .A_editar', function (e) {
			
	e.preventDefault();
	
	var table = $('#table_usuarios').DataTable();
	var dataItem = table.row($(this).closest('tr')).data();        
	 	 
	$.ajax({
		url: '../Logica de presentacion/Usuario_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea': 'editarUsuario', 
			   'id_usuario': dataItem.Id, 
			   'nombre': dataItem.Nombre, 
			   'apellido': dataItem.Apellido, 
			   'documento':dataItem.Documento, 
			   'telefono':dataItem.Telefono, 
			   'direccion':dataItem.Direccion,
			   'email':dataItem.Correo,
			   'valorHora':dataItem.HoraMecanico},
		success:  function (data) {  
		  $('.dashboard').html(data);
		  cargarListasDesplegables(dataItem.Id_Rol);
		  
		  if(dataItem.Id_Rol == 5) //si es igual al mecanico
			{
				$("#valorHora").show();
			}
			else{
				$("#valorHora").hide();
			}
			
		  $("#valorHora").hide();
			$("#id_rol").change(function() {
				if($("#id_rol").val() == 5) //si es igual al mecanico
				{
					$("#valorHora").show();
				}
				else{
					$("#valorHora").hide();
				}
			});
			
			
		},
		error: function(ex){
			console.log(ex);
		}
	});
});


$('#table_usuarios').on( 'click', 'td .A_eliminar', function (e) {
	
	e.preventDefault();        
	
	var table = $('#table_usuarios').DataTable();
	var dataItem = table.row($(this).closest('tr')).data();        
			
	$("#id_usuario").val(dataItem.Id);
	$("#mensajeConf").html("¿Esta seguro de eliminar el registro?");
	$("#mensajeConfirma").modal("show");
	
});
    
 
function formularioCrearUsuarios()
{
    $.ajax({
    	url:   '../Logica de presentacion/Usuario_Logica.php',
    	type:  'post',
    	dataType:'html',
    	data: {'desea':'cargaFormularioCrear'},
    	success:  function (data) {
    		$('.dashboard').html(data);
    	},
		complete: function()
		{
			$("#valorHora").hide();
			$("#id_rol").change(function() {
				if($("#id_rol").val() == 5) //si es igual al mecanico
				{
					$("#valorHora").show();
				}
				else{
					$("#valorHora").hide();
				}
			});

			cargarListasDesplegables(0);
		}
    });	
}

function cargarListasDesplegables(id_rol)
{
    $.ajax({
		url: '../Logica de presentacion/Usuario_Logica.php',
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
			
            if(id_rol  != 0){             
                $('#id_rol')[0].selectize.setValue(id_rol);     
            }              
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
	else if(($("#id_rol").val() == 5) && ($("#TB_valor").val() == "")) //si es igual al mecanico
	{
        $("#mensaje").html("¡El valor hora es requerido para este usuario!");
		mensaje.modal("show");		
	}
    else 
    {            
		TB_valor = $("#TB_valor").val();
		TB_valor = TB_valor.replace(",","");
		$("#TB_valor").val(TB_valor);
		
        $('#desea').val("guardarUsuario");
        $.ajax({
    		url: '../Logica de presentacion/Usuario_Logica.php',
    		method: 'post',
    		dataType: 'html',
    		data: $("#registro").serialize(),
    		success: function (data) {                 
    		   
    		      $('.dashboard').html(data);
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
		url: '../Logica de presentacion/Usuario_Logica.php',
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

function guardarUsuarioEditar()
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
	else if(($("#id_rol").val() == 5) && ($("#TB_valor").val() == "")) //si es igual al mecanico
	{
        $("#mensaje").html("¡El valor hora es requerido para este usuario!");
		mensaje.modal("show");		
	}
    else 
    {            
		TB_valor = $("#TB_valor").val();
		TB_valor = TB_valor.replace(",","");
		$("#TB_valor").val(TB_valor);
		
        $('#desea').val("guardarEditarUsuario");
        $.ajax({
    		url: '../Logica de presentacion/Usuario_Logica.php',
    		method: 'post',
    		dataType: 'html',
    		data: $("#registro").serialize(),
    		success: function (data) {                 
    		   
    		      $('.dashboard').html(data);
    		},
            error: function(ex){
                
                $("#mensaje").html(ex.responseText);
        		mensaje.modal("show");
            }
    	}); 
    }
}

function mostrarUsuarios(temp){
        
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
		url: '../Logica de presentacion/Usuario_Logica.php',
		method: 'post',
		dataType: 'html',
		data: {'desea': ''},
		success: function (data) {                 
    		$('.dashboard').html(data);		
		}
	});     
}

function eliminarUsuario()
{
    $("#mensajeConfirma").modal("hide");            
	
	$.ajax({
		url:   '../Logica de presentacion/Usuario_Logica.php',
		type:  'post',
		dataType:'html',
		data: {'desea': "eliminarUsuario",
			   'id_usuario': $('#id_usuario').val()
		},
		success: function (data) {
				 
		  $('.dashboard').html(data);
			
		},
		error: function(ex){
			console.log(ex);
		}            
	});	
}