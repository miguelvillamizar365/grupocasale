<?php

/**
 * manejo de las referencias 
 * logica de presentación, crear, modificar, ver, 
 * @author miguel villamizar
 * @copyright 2017/11/13
 */


global $objPresenta, $objData;
include('../Acceso a datos/ReferenciaData.php');
include('../Presentacion/Referencia.php');
include('../srcBarcode/BarcodeGenerator.php');
include('../srcBarcode/BarcodeGeneratorPNG.php');
include('../dompdf-master/lib/html5lib/Parser.php');
include('../dompdf-master/lib/Cpdf.php');
include('../dompdf-master/src/Autoloader.php');
Dompdf\Autoloader::register();
use Dompdf\Dompdf;


$objPresenta = new Referencias();
$objData = new referenciaData();
$objData->Conectar();


if(isset($_POST['desea']))
{
    switch($_POST['desea'])
    {
        case 'cargaReferencias':{
            
            $referencia = $objData->consultarReferencias();
            echo json_encode($referencia->GetRows());
            
        }break;      
        
        case 'consultarTipoEmpaque':{
            $result = $objData->consultarTipoEmpaque();  
            echo json_encode($result->GetRows());            
        }break; 
        
        case 'consultarClasificacion':{
            $result = $objData->consultarClasificacion();
            echo json_encode($result->GetRows());            
        }break; 
        
        case 'cargaFormularioCrear':{
            
            $objPresenta->formularioCrear();
                        
        }break;      
        
        case 'guardarReferencia':{
            
            $nombre = $_POST["TB_nombre"];
            $id_tipoempaque = $_POST["id_tipoempaque"];
            $id_clasificacion = $_POST["id_clasificacion"];
            $TB_stante = $_POST["TB_stante"];
            $TB_piso = $_POST["TB_piso"];
            $TB_stock = $_POST["TB_stock"];
            
            if(trim($nombre) == ""){                
                header('HTTP/1.1 500');
                echo "¡El nombre es requerido!";                 
            }
            else if(trim($id_tipoempaque) == ""){                
                header('HTTP/1.1 500');
                echo "¡El tipo empaque es requerido!";                 
            }            
            else if(trim($id_clasificacion) == ""){                
                header('HTTP/1.1 500');
                echo "¡La clasificación es requerida!";                 
            }
            else if((trim($TB_stante) == "") || (trim($TB_stante) == "0")){                
                header('HTTP/1.1 500');
                echo "¡El stante es requerido!";                 
            }            
            else if((trim($TB_piso) == "") || (trim($TB_piso) == "0") ){                
                header('HTTP/1.1 500');
                echo "¡El piso es requerido!";                 
            }
            else if((trim($TB_stock) == "") || (trim($TB_stock) == "0")){                
                header('HTTP/1.1 500');
                echo "¡El stock es requerido!";                 
            }
            else
            {
                $recodSet = $objData->guardarReferencia($nombre, $id_tipoempaque, $id_clasificacion, $TB_stante, $TB_piso, $TB_stock);
                echo $objPresenta->mensajeRedirect("'Se han guardado los datos satisfactoriamente !'", "mostrarReferencias(1)");    
            }
            
        }break;
        
        case 'editarReferencia':{
            $Id = $_POST["Id"];
            $Nombre = $_POST["Nombre"];
            $Piso = $_POST["Piso"];
            $Stante = $_POST["Stante"];
            $Stock = $_POST["Stock"];
            
            echo $objPresenta->formularioEditar($Id, $Nombre, $Piso, $Stante, $Stock);
           
        }break;
        
        case 'guardarEditarReferencia':{
            
            $Id = $_POST["id_referencia"];
            $nombre = $_POST["TB_nombre"];
            $id_tipoempaque = $_POST["id_tipoempaque"];
            $id_clasificacion = $_POST["id_clasificacion"];
            $TB_stante = $_POST["TB_stante"];
            $TB_piso = $_POST["TB_piso"];
            $TB_stock = $_POST["TB_stock"];
            
            
            if(trim($nombre) == ""){                
                header('HTTP/1.1 500');
                echo "¡El nombre es requerido!";                 
            }
            else if(trim($id_tipoempaque) == ""){                
                header('HTTP/1.1 500');
                echo "¡El tipo empaque es requerido!";                 
            }            
            else if(trim($id_clasificacion) == ""){                
                header('HTTP/1.1 500');
                echo "¡La clasificación es requerida!";                 
            }
            else if((trim($TB_stante) == "") || (trim($TB_stante) == "0")){                
                header('HTTP/1.1 500');
                echo "¡El stante es requerido!";                 
            }            
            else if((trim($TB_piso) == "") || (trim($TB_piso) == "0") ){                
                header('HTTP/1.1 500');
                echo "¡El piso es requerido!";                 
            }
            else if((trim($TB_stock) == "") || (trim($TB_stock) == "0")){                
                header('HTTP/1.1 500');
                echo "¡El stock es requerido!";                 
            }
            else
            {
                 $recodSet = $objData->editarReferencia($Id, $nombre, $id_tipoempaque, $id_clasificacion, $TB_stante, $TB_piso, $TB_stock);
                 echo $objPresenta->mensajeRedirect("'Se han guardado los datos satisfactoriamente !'", "mostrarReferencias(1)");              
            }    
        }break;
        
        case 'validaEliminarReferencia':{
            
            $Id = $_POST["id_referencia"];
            $contRefe = $objData->validarEliminaReferencia($Id);
            echo json_encode($contRefe);
            
        }break;
        
        case 'eliminarReferencia':{
            
            $Id = $_POST["id_referencia"];
            $recodSet = $objData->eliminaReferencia($Id);
            echo $objPresenta->mensajeRedirect("'Se ha eliminado la referencia satisfactoriamente !'", "mostrarReferencias(1)");
        }break;
        
        case 'imprimirReferencia':{
            
            $id_referencia = $_POST["Id"];
            $articulo = $_POST["articulo"];
            $stante = $_POST["stante"];
            $piso = $_POST["piso"];
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            $imagen = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($id_referencia, $generator::TYPE_CODE_128)) . '">';
            
            echo $objPresenta->mensajeImprimirReferencia($articulo, $stante,$piso, $imagen , $id_referencia, "mostrarReferencias(2)");
        }break;
        
        case 'exportarReferencia':{
           
            $id_referencia = $_POST["Id"];
            $articulo = $_POST["articulo"];
            $stante = $_POST["stante"];
            $piso = $_POST["piso"];
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            $imagen = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($id_referencia, $generator::TYPE_CODE_128)) . '">';
            
            $report = $objPresenta->exportarPdf($articulo, $stante, $piso, $imagen, $id_referencia );
            
            // instantiate and use the dompdf class
            $dompdf = new Dompdf();
            $dompdf->loadHtml($report);
            
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->set_option('isHtml5ParserEnabled', true);
            // Render the HTML as PDF
            $dompdf->render();
            
            // Output the generated PDF to Browser
            $dompdf->stream();
        }break;
        default:{
            
            $objPresenta->mostrarReferencias();
            jsInclude();
        }break;
    }
}
else
{
    $objPresenta->mostrarReferencias();
    jsInclude();
}
        
function jsInclude(){
   ?>
   
   
    <script src="../js/jsSitio/Referencia.js"></script>
    <?php   
}


?>