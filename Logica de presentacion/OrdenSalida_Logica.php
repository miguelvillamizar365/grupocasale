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
include('../Acceso a datos/OrdenSalidaData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/OrdenSalida.php');
include('../dompdf-master/lib/html5lib/Parser.php');
include('../dompdf-master/lib/Cpdf.php');
include('../dompdf-master/src/Autoloader.php');
Dompdf\Autoloader::register();
use Dompdf\Dompdf;

$objPresenta= new OrdenSalida();
$objData = new OrdenSalidaData();
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
	$MenuLista = $objDataUsuario->consultarMenuUsuarioPermiso($_SESSION["id_rol"], $_SESSION["id_usuario"], 6);
	
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
				case 'cargaOrdenes':{			
					$ordenes = $objData->ObtenerOrdenes();
					echo json_encode($ordenes->GetRows());
				}break;
				
				case 'AutorizarOrden':{			
					
					$NumeroOrden = $_POST["NumeroOrden"];
					$error = $objData->AutorizarOrden($NumeroOrden);
					
					if($error == "error")
					{
						header('HTTP/1.1 500');
						echo "¡Se ha generado un error al guardar la información!";
					}			
				}break;
				
				case 'ExportarInformeOrdenTrabajo':{
					
					$id_orden = $_POST["id_orden"];
					$Placas = $_POST["Placas"];
					$Fecha = $_POST["Fecha"];
					$ValorTotalReferencia = $_POST["ValorTotalReferencia"];
					$ValorTotalUtilidadReferencia = $_POST["ValorTotalUtilidadReferencia"];
					$ValorTotalActividad = $_POST["ValorTotalActividad"];
					$ValorTotalUtilidadActividad = $_POST["ValorTotalUtilidadActividad"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones = $_POST["Observaciones"];
					$id_ordenUtilidad = $_POST["id_ordenUtilidad"];
								
					$informeDataReferencia = $objData->InformeOrdenTrabajoReferencia($id_orden);
					$informeDataActividad = $objData->InformeOrdenTrabajoActividad($id_orden);
					
					$report = $objPresenta->exportarInformeOrdenTrabajo($id_orden, 
					$Placas, 
					$Fecha , 
					$ValorTotalReferencia, 
					$ValorTotalUtilidadReferencia, 
					$ValorTotalActividad , 
					$ValorTotalUtilidadActividad, 
					$Kilometraje, 
					$mecanico, 
					$conductor, 
					$Observaciones,
					$informeDataReferencia, 
					$informeDataActividad,
					$id_ordenUtilidad);

					
					$dompdf = new Dompdf();                                              
					$dompdf->loadHtml($report);                                           
					
					//cambia la posicion a horizontal
					//$dompdf->setPaper('A4', 'landscape');
					$dompdf->set_option('isHtml5ParserEnabled', true);
					$dompdf->render();
					
					$dompdf->stream("ReporteOrdenSalida".$id_orden.".pdf");
				}break;
				
				default:{
					$objPresenta-> mostrarOrdenTrabajo();
					jsInclude(); 
				}break;
			}
		}
		else
		{
			$objPresenta->mostrarOrdenTrabajo();
			jsInclude();
		}
	}
}

function jsInclude()
{
	?>	
    <script src="../js/jsSitio/OrdenSalida.js"></script>
	<?php
}

?>