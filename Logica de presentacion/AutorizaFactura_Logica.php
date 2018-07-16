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