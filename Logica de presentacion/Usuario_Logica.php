<?php

// Clase para el manejo de las pantallas de usuarios, registro, modificación, etc
// manejo de sesion  
// Autor: Miguel Villamizar
// Fecha: 2018/08/30


session_start();

global $objPresenta, $objData, $objDataAuditoria;
include('../Acceso a datos/AuditoriaData.php');
include('../Acceso a datos/UsuarioData.php');
include('../Presentacion/Usuario.php');
include('../Presentacion/Principal.php');

$objPresenta = new Usuarios();
$objPresentacion = new Principal();
$objData = new usuarioData();
$objData->Conectar();

$objDataAuditoria = new AuditoriaData();
$objDataAuditoria->Conectar();

//valida que la sesión no caduque
$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = $objData->ConsultaTiempoSesion();
			
if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
	session_unset();
	session_destroy();
	session_start();
		
    echo "<script> parent.window.location.reload(); </script>";
}
else
{
	$_SESSION['LAST_ACTIVITY'] = $time; 
// fin valida sesion	

	//validacion del permiso del rol
	$MenuLista = $objData->consultarMenuUsuarioPermiso($_SESSION["id_rol"], $_SESSION["id_usuario"], 13);
	
	if($MenuLista == 0)
	{
		header('HTTP/1.1 401');
		echo "¡No puede acceder a esta página! ";    
	}
	//fin validacion del permiso
	else
	{			
		if(isset($_POST['desea']))
		{
			switch($_POST['desea'])
			{
				case 'cargaUsuarios':{
					
					$usuarios = $objData->ConsultarListaUsuario();
					echo json_encode($usuarios->GetRows());
					
				}break;    
				
				case 'cargaFormularioCrear':{
					
					$objPresenta->formularioCrear();
				}break;   
				
				case 'consultarRoles':{
					$rol = $objData->consultarRoles();  
					
					echo json_encode($rol->GetRows());            
				}break; 
				
				case 'validaUsuario':{
					
					$correo = $_POST["TB_email"];            
					$usuario = $objData->ValidaUsuarioLogin($correo);            
					echo json_encode($usuario->GetRows()); 
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
					$TB_valorHM = ($_POST["TB_valor"]);           
								
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
					else if((trim($rol) == 5) && (trim($TB_valorHM == "")) ){                
						header('HTTP/1.1 500');
						echo "¡El valor hora es requerido para este usuario!";                 
					}
					else
					{	
						if((trim($rol) != 5) && (trim($TB_valorHM == "")) ){                
							$TB_valorHM =0;
						}
					
						$fechaActual = getdate();
						$error = $objDataAuditoria->guardarAuditoria("Guarda usuario", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"], "usuario: nombre".$nombre.", apellido:".$apellido.", documento:". $documento.", telefono:". $telefono.", rol:".$rol.", direccion:". $direccion.", email:". $email.", valor hora mecanico: ".$TB_valorHM);
						if($error == "error")                
						{
							header('HTTP/1.1 500');
							echo "¡Se ha generado un error al guardar la auditoria! ";    
						}
						else
						{
							$error = $objData->guardarUsuario($nombre, $apellido, $documento, $telefono, $rol, $direccion, $email, (password_hash($clave,PASSWORD_DEFAULT)), $TB_valorHM );            
							if($error != "")                
							{
								header('HTTP/1.1 500');
								echo "¡Se ha generado un error al guardar la información! ".$error;    
							}
							else
							{
								echo $objPresenta ->mensajeRedirect("'¡Se han guardado los datos satisfactoriamente !'","mostrarUsuarios(1)");    
							}
						}
					}            
				}break;
				
				case 'editarUsuario':{
					
					$id_usuario = $_POST["id_usuario"];
					$nombre = $_POST["nombre"];
					$apellido = $_POST["apellido"];
					$documento = $_POST["documento"];
					$telefono = $_POST["telefono"];
					$direccion = $_POST["direccion"];
					$email = $_POST["email"];			
					$valorHora = $_POST["valorHora"];			
					
					echo $objPresenta -> formularioEditar($id_usuario, 
									  $nombre,
									  $apellido,
									  $documento, 
									  $telefono,
									  $direccion,
									  $email,
									  $valorHora);
				}break;
				
				case 'guardarEditarUsuario':{
					
					$id_usuario = $_POST["id_usuario"];
					$nombre = $_POST["TB_nombre"];
					$apellido = $_POST["TB_apellido"];            
					$documento = $_POST["TB_documento"];
					$telefono = $_POST["TB_telefono"];
					$rol = $_POST["id_rol"];
					$direccion = $_POST["TB_direccion"];
					$email = $_POST["TB_email"];    
					$valorHora = $_POST["TB_valor"];	      
					
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
					else if((trim($rol) == 5) && (trim($valorHora == "")) ){                
						header('HTTP/1.1 500');
						echo "¡El valor hora es requerido para este usuario!";                 
					}
					else
					{	
						if((trim($rol) != 5) && (trim($valorHora == "")) ){                
							$valorHora =0;
						}
						
						$fechaActual = getdate();
						$error = $objDataAuditoria->guardarAuditoria("Edita usuario", 
														($fechaActual["year"] . "/". 
														$fechaActual["mon"] . "/". 
														(intval($fechaActual["mday"]) - 1)), 
														$_SESSION["id_usuario"], 
														"usuario: id_usuario:".$id_usuario.
														", nombre".$nombre.", apellido:".$apellido.
														", documento:". $documento.
														", telefono:". $telefono.
														", rol:".$rol.", direccion:". $direccion.
														", email:".$email.
														", valorHora:".$valorHora);
						if($error == "error")                
						{
							header('HTTP/1.1 500');
							echo "¡Se ha generado un error al guardar la auditoria! ";    
						}
						else
						{
							$error = $objData->EditarUsuario($id_usuario, $nombre, $apellido, $documento, $telefono, $rol, $direccion, $email, $valorHora);            
							if($error != "")                
							{
								header('HTTP/1.1 500');
								echo "¡Se ha generado un error al guardar la información! ".$error;    
							}
							else
							{
								echo $objPresenta ->mensajeRedirect("'¡Se han guardado los datos satisfactoriamente !'","mostrarUsuarios(1)");    
							}
						}
					}
				}break;
				
				case 'eliminarUsuario':{
					
					$Id = $_POST["id_usuario"];
					$recodSet = $objData->eliminaUsuario($Id);
					echo $objPresenta->mensajeRedirect("'Se ha eliminado el usuario satisfactoriamente !'", "mostrarUsuarios(1)");
				}break;
				
				default:{
					
					$objPresenta->mostrarUsuarios();
					jsInclude();
				}break;
			}
		}
		else
		{
			$objPresenta->mostrarUsuarios();
			jsInclude();
		}
	}	
}
        
function jsInclude(){
	?>
	<script src="../js/jsSitio/Usuario.js"></script>
	<?php   
}

function jsInclude2()
{
    ?>     
        <script src="../js/jsSitio/Principal.js"></script>     
    <?php
}

?>