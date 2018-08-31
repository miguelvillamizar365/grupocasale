<?php

/**
 * manejo de el estado de las facturas 
 * logica de presentación se puede cerrar la factura
 * @author miguel villamizar
 * @copyright 2018/07/15
 */
 
 
session_start();

global $objPresenta, $objData, $objDataAuditoria;
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

if(isset($_POST['desea']))
{
    switch($_POST['desea'])
    {
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
        
function jsInclude(){
	?>
    <script src="../js/jsSitio/AutorizaFactura.js"></script>
    <?php   
}

?>	