<?php

/*
*
*
*Manejo de ordenes de trabajo 
*@autor Miguel Villamizar
*@copyright 17/03/2018
*/

session_start();
global $objPresenta, $objData, $objDataAuditoria;

include('../Acceso a datos/OrdenSalidaData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/OrdenSalida.php');

$objPresenta= new OrdenSalida();
$objData = new OrdenSalidaData();
$objData->Conectar();

$objDataAuditoria = new AuditoriaData();
$objDataAuditoria->Conectar();

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

function jsInclude()
{
	?>	
    <script src="../js/jsSitio/OrdenSalida.js"></script>
	<?php
}

?>