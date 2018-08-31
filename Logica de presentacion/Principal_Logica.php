<?php

// Clase para el manejo de las pantallas principales, login, registro, 
// manejo de sesion  
// Autor: Miguel Villamizar
// Fecha: 2017/11/04


session_start();

global $objPresenta, $objData;
include('../Acceso a datos/UsuarioData.php');
include('../Presentacion/Principal.php');

$objPresentacion = new Principal();
$objData = new usuarioData();
$objData->Conectar();

if(isset($_POST['desea']))
{
    switch($_POST['desea'])
    {
        case 'inicioSesion':{
            
            $correo = $_POST["TB_correo"];
            $clave = $_POST["TB_clave"];
            
            $usuario = $objData->UsuarioLogin($correo, $clave);
            
            if($usuario >= 1 ){
                echo json_encode("1");    
            }
            else
            {
                echo json_encode("0");
            }
        }break;     
        
        case 'cargarSesion':{
                        
            $correo = $_POST["TB_correo"];
            $clave = $_POST["TB_clave"];
            
            $usuario = $objData->consultarUsuario($correo);
            
            $_SESSION["id_usuario"] = $usuario[0][0];
            $_SESSION["id_rol"] = $usuario[0][10];
                               
            $objPresentacion->cargaContenido();
            jsInclude();			
			jsInclude2();
                
        }break;   
		
		case 'cargarInicio':{
                        
            $objPresentacion->dashboard();
            //jsInclude();			
			 jsInclude3();
			jsInclude2();
        }break;   
        
        case 'validaUsuario':{
            
            $correo = $_POST["TB_email"];            
            $usuario = $objData->ValidaUsuarioLogin($correo);            
            echo json_encode($usuario->GetRows()); 
        }break;
        
        case 'cerrarSesion':{
                
            unset($_SESSION["id_usuario"]);
            unset($_SESSION["id_rol"]);
            session_unset();
            $objPresentacion->cargaLogin();
        }break;
        
        case 'limpiaLogin':{
            
            $objPresentacion->limpiaLogin();
        }break;
        
        case 'registroUsuario':{
            
            $objPresentacion->registroUsuario();
            
        }break;         
        
        case 'consultarRoles':{
            $rol = $objData->consultarRoles();  
            
            echo json_encode($rol->GetRows());            
        }break; 
        
        case 'guardarUsuario':{
            
            $nombre = $_POST["TB_nombre"];
            $apellido = $_POST["TB_apellido"];            
            $documento = $_POST["TB_documento"];
            $telefono = $_POST["TB_telefono"];
            $rol = $_POST["id_rol"];
            $direccion = $_POST["TB_direccion"];
            $email = $_POST["TB_email"];
            $clave = $_POST["TB_clave"];
            $claveConfirma = $_POST["TB_confirmaclave"];           
            
            $ContDoc = $objData -> ConsultaUsuarioDocumento($documento);      
            
            if(trim($nombre) == ""){                
                header('HTTP/1.1 500');
                echo "¡El nombre es requerido!";                 
            }
            else if(trim($apellido) == ""){                
                header('HTTP/1.1 500');
                echo "¡El apellido es requerido!";                 
            }            
            else if(trim($documento) == ""){                
                header('HTTP/1.1 500');
                echo "¡El documento es requerido!";                 
            }
            else if($ContDoc > 0){                
                header('HTTP/1.1 500');
                echo "¡El documento ya esta registrado!";                 
            }
            else if(trim($telefono) == ""){                
                header('HTTP/1.1 500');
                echo "¡El teléfono es requerido!";                 
            }
            else if(trim($rol) == ""){                
                header('HTTP/1.1 500');
                echo "¡El rol es requerido!";                 
            }
            else if(trim($direccion) == ""){                
                header('HTTP/1.1 500');
                echo "¡La dirección es requerido!";                 
            }
            else if(trim($email) == ""){                
                header('HTTP/1.1 500');
                echo "¡El Email es requerido!";                 
            }
            else if(trim($clave) == ""){                
                header('HTTP/1.1 500');
                echo "¡La Clave es requerida!";                 
            }
            else if(trim($clave) != trim($claveConfirma)){                
                header('HTTP/1.1 500');
                echo "¡las claves no coinciden!";                 
            }
            else
            {
                $error = $objData->guardarUsuario($nombre, $apellido, $documento, $telefono, $rol, $direccion, $email, (password_hash($clave,PASSWORD_DEFAULT)) );            
                
				if($error != "")                
				{
					header('HTTP/1.1 500');
					echo "¡Se ha generado un error al guardar la información! ";    
				}
				else
				{
					echo $objPresenta ->mensajeRedirect("'¡Se han guardado los datos satisfactoriamente !'","redirectLogin()");    
				}
            }
            
        }break;
		
        default:{
            
            session_unset();
            $objPresentacion->PaginaPrincipal();
			jsInclude2();
        }break;   
    }
}
else
{
    session_unset();
    $objPresentacion->PaginaPrincipal();
	jsInclude2();
}


function jsInclude()
{
    ?>        
        <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
        <script src="../node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5NXz9eVnyJOA81wimI8WYE08kW_JMe8g&callback=initMap" async defer></script>
        <script src="../js/off-canvas.js"></script>
        <script src="../js/hoverable-collapse.js"></script>
        <script src="../js/misc.js"></script>
        <script src="../js/chart.js"></script>
        <script src="../js/maps.js"></script>
        
        <script src="../js/datatables.min.js"></script>
        <script src="../js/jszip.min.js"></script>      
        <script src="../js/bootstrap-datetimepicker.js"></script>      
        <script src="../js/bootstrap-datetimepicker.es.js"></script>        
        <script type="text/javascript" src="../datatables/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
        <!--<script type="text/javascript" src="../datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>-->
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="../datatables/DataTables-1.10.16/js/dataTables.responsive.js"></script>
            
        <script src="../selectize.js-master/dist/js/standalone/selectize.js"></script>
        <script src="../selectize.js-master/examples/js/index.js"></script>
		<script src="../js/jquery.blockUI.js"></script>
			
    <?php
}


function jsInclude2()
{
    ?>     
        <script src="../js/jsSitio/Principal.js"></script>     
    <?php
}



function jsInclude3()
{
    ?>  
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5NXz9eVnyJOA81wimI8WYE08kW_JMe8g&callback=initMap" async defer></script>	
        <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
        <script src="../js/off-canvas.js"></script>
        <script src="../js/hoverable-collapse.js"></script>
        <script src="../js/misc.js"></script>
        <script src="../js/chart.js"></script>
        <script src="../js/maps.js"></script>
        <!--
		<script src="../node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
        
        
        <script src="../js/datatables.min.js"></script>
        <script src="../js/jszip.min.js"></script>      
        <script src="../js/bootstrap-datetimepicker.js"></script>      
        <script src="../js/bootstrap-datetimepicker.es.js"></script>        
        <script type="text/javascript" src="../datatables/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
        <!--<script type="text/javascript" src="../datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>-->
        <!--<script type="text/javascript" src="../datatables/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="../datatables/DataTables-1.10.16/js/dataTables.responsive.js"></script>
            
            <script src="../selectize.js-master/dist/js/standalone/selectize.js"></script>
            <script src="../selectize.js-master/examples/js/index.js"></script>
		-->	
    <?php
}
?>