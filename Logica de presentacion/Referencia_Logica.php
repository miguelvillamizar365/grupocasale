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
            
            $recodSet = $objData->guardarReferencia($nombre, $id_tipoempaque, $id_clasificacion, $TB_stante, $TB_piso, $TB_stock);
            echo $objPresenta->mensajeRedirect("'Se han guardado los datos satisfactoriamente !'", "mostrarReferencias(1)");
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