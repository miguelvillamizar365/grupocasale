<?php

//Clase para el manejo de las pantallas principales 
//Autor: Miguel Villamizar
//Fecha: 2017/11/04


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
            
            if($usuario->GetRows()){
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
            
            $usuario = $objData->consultarUsuario($correo, $clave);
            
            $_SESSION["id_usuario"] = $usuario[0][0];
            $_SESSION["id_rol"] = $usuario[0][10];
            
            jsInclude();
                   
            $objPresentacion->cargaContenido();
                
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
            
            $objData->guardarUsuario($nombre, $apellido, $documento, $telefono, $rol, $direccion, $email, $clave );
            
            echo json_encode("1"); 
        }break;
         
        case 'cargaReferencias':{
            
        }break;                          
                                     
        default:{
            
            session_unset();
            $objPresentacion->PaginaPrincipal();
        }break;   
    }
}
else
{
    session_unset();
    $objPresentacion->PaginaPrincipal();
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
        <script type="text/javascript" src="../datatables/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>
        <script type="text/javascript" src="../datatables/Buttons-1.4.2/js/buttons.html5.min.js"></script>
        
        <script src="../js/jsSitio/principal.js"></script>      
    <?php
}

?>