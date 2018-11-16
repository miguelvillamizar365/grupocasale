<?php

/**
 * manejo de el estado de las facturas 
 * logica de presentación se puede cerrar la factura
 * @author miguel villamizar
 * @copyright 2018/07/15
 */
 
 
session_start();

global $objPresenta, $objData, $objDataAuditoria, $objDataUsuario;

include('../Acceso a datos/UsuarioData.php');
include('../Acceso a datos/AutorizaFacturaData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/AutorizaFactura.php');
include('../dompdf-master/lib/html5lib/Parser.php');
include('../dompdf-master/lib/Cpdf.php');
include('../dompdf-master/src/Autoloader.php');
Dompdf\Autoloader::register();
use Dompdf\Dompdf;

$objPresenta = new AutorizaFactura();
$objData = new AutorizaFacturaData();
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
	$MenuLista = $objDataUsuario->consultarMenuUsuarioPermiso($_SESSION["id_rol"], $_SESSION["id_usuario"], 4);
	
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
				case 'cargaFacturasFiltros':{
					
					$referencia = $_POST["referencia"];	
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
						$facturas = $objData->consultarFacturaFiltro($referencia, $fechaInicial, $fechaFinal);
						echo json_encode($facturas->GetRows());            
					}
				}break;
				
				case 'cargaFacturas':{
					
					$facturas = $objData->consultarFactura();
					echo json_encode($facturas->GetRows());
					
				}break;
				
				case 'AutorizarFactura':{
					
					$id_factura = $_POST["NumeroFactura"];
					
					$error = $objData->AutorizarFactura($id_factura);
					if($error == "error")
					{
					  header('HTTP/1.1 500');
					  echo "¡Se ha generado un error al guardar la información!";
					}
					
				}break;
				
				
				case 'ImprimirInformeFactura':{
				   
					$NumeroFactura = $_POST["NumeroFactura"];
					$empresaId = $_POST["empresaId"];
					$EmpresaCompra = $_POST["EmpresaCompra"];			
					$ValorFactura = number_format($_POST["ValorFactura"], 2,'.',',');		
					$proveedorId = $_POST["proveedorId"];
					$proveedor = $_POST["proveedor"];
					$modopagoId = $_POST["modopagoId"];
					$modopago = $_POST["modopago"];
					$Fecha = $_POST["Fecha"];
						
					
					$informeData = $objData->consultarInformeFactura($NumeroFactura);
					$informeEmpresa = $objData->consultarInformacionEmpresa($empresaId);
					$report = $objPresenta->exportarInformeFacturaPdf($NumeroFactura, $EmpresaCompra, $ValorFactura, $proveedor, $modopago, $Fecha, $informeEmpresa , $informeData);

					$dompdf = new Dompdf();                                              
					$dompdf->loadHtml($report);                                           
					
					//cambia la posicion a horizontal
					//$dompdf->setPaper('A4', 'landscape');
					$dompdf->set_option('isHtml5ParserEnabled', true);
					$dompdf->render();
					
					$dompdf->stream("ReporteFactura".$NumeroFactura.".pdf");
				}break;
				
				default:{
					$objPresenta-> mostrarFacturas();
					jsInclude(); 
				}break;
			}
		}
		else
		{
			$objPresenta-> mostrarFacturas();
			jsInclude();
		}      
	}
}
        
function jsInclude(){
	?>
    <script src="../js/jsSitio/AutorizaFactura.js"></script>
    <?php   
}

?>	