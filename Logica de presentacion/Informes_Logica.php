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

if(isset($_POST['desea']))
{
    switch($_POST['desea'])
    {
		case 'cargaInformeTiemposMecanico':{			
            $ordenes = $objData->ObtenerMecanicos();
            echo json_encode($ordenes->GetRows());
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
			
			$informeData = $objData->consultarInformeMecanico($nombre, $documento);
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
	$objPresenta->ListadoInformes();
	jsInclude();
}

function jsInclude()
{
	?>	
    <script src="../js/jsSitio/Informes.js"></script>
	<?php
}

?>