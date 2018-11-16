<?php

/*
*
*
*Manejo de ordenes de trabajo 
*@autor Miguel Villamizar
*@copyright 17/03/2018
*/

session_start();
global $objPresenta, $objData, $objDataAuditoria, $objDataUsuario;

include('../Acceso a datos/UsuarioData.php');
include('../Acceso a datos/InformesData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/Informes.php');
include('../dompdf-master/lib/html5lib/Parser.php');
include('../dompdf-master/lib/Cpdf.php');
include('../dompdf-master/src/Autoloader.php');
Dompdf\Autoloader::register();
use Dompdf\Dompdf;


$objPresenta= new Informes();
$objData = new InformeData();
$objData->Conectar();

$objDataAuditoria = new AuditoriaData();
$objDataAuditoria->Conectar();

$objDataUsuario = new usuarioData();
//valida que la sesión no caduque
$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = $objDataUsuario->ConsultaTiempoSesion();

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
	$MenuLista = $objDataUsuario->consultarMenuUsuarioPermiso($_SESSION["id_rol"], $_SESSION["id_usuario"], 10);
	
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
				case 'cargaInformeTiemposMecanico':{	
					
					
					$fechaInicial = $_POST["fechaInicial"];
					$fechaFinal = $_POST["fechaFinal"];
					
					$fechaInicial = str_replace("-", "/", $fechaInicial);
					$fechaFinal = str_replace("-", "/", $fechaFinal);
					
					$validaMayor = $objData->validaFechas($fechaInicial, $fechaFinal);
								
					if((trim($fechaInicial) == "")){                
						header('HTTP/1.1 500');
						echo "¡La fecha inicial es requerida!";                 
					}
					else if((trim($fechaFinal) == "")){                
						header('HTTP/1.1 500');
						echo "¡La fecha final es requerida!";                 
					}
					else if( $validaMayor == 1){                
						header('HTTP/1.1 500');
						echo "¡La fecha inicial no pueder ser mayor a la final!";                 
					}
					else{			
					
						$ordenes = $objData->ObtenerMecanicos($fechaInicial, $fechaFinal);
						echo json_encode($ordenes->GetRows());
					}
				}break;
				
				case 'InformeTiemposMecanico':{			
					$objPresenta-> InformeTiemposMecanico();
					jsInclude(); 
					
				}break;
				
				
				case 'exportarInformeTiempo':{
				   
					$documento = $_POST["Documento"];
					$nombre = $_POST["Nombre"];
					$apellido = $_POST["Apellido"];
					$tiempo = $_POST["Tiempo"];
					$valor = $_POST["Valor"];	
					
					$fechaInicial = $_POST["TB_fechaIni"];
					$fechaFinal = $_POST["TB_fechaFin"];
					
					$fechaInicial = str_replace("-", "/", $fechaInicial);
					$fechaFinal = str_replace("-", "/", $fechaFinal);
					
					$informeData = $objData->consultarInformeMecanico($nombre, $documento, $fechaInicial, $fechaFinal);
					$report = $objPresenta->exportarInformeTiempoMecanicoPdf($documento, $nombre, $apellido, $tiempo, $valor, $informeData);

					$dompdf = new Dompdf();                                              
					$dompdf->loadHtml($report);                                           
					
					//cambia la posicion a horizontal
					//$dompdf->setPaper('A4', 'landscape');
					$dompdf->set_option('isHtml5ParserEnabled', true);
					$dompdf->render();
					
					$dompdf->stream("ReporteTiempoMecanico".$documento.".pdf");
				}break;
				
				default:{
					$objPresenta-> ListadoInformes();
					jsInclude(); 
				}break;
			}
		}
		else
		{
			jsInclude();
			$objPresenta->ListadoInformes();
		}
	}
}

function jsInclude()
{
	?>	
    <script src="../js/jsSitio/Informes.js"></script>
	<?php
}

?>