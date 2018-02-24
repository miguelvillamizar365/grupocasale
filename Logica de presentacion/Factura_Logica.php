<?php

/**
 * 
 * Manejo de facturas crear, edita, eliminar
 * @author Miguel Villamizar 
 * @copyright 09/12/2017
 */
session_start();

global $objPresenta, $objData , $objDataAuditoria;
include('../Acceso a datos/FacturaData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/Facturas.php');


$objPresenta = new Facturas();
$objData = new facturaData();
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
        
        case 'consultaEmpresaCompra':{
            
            $empresa = $objData->consultarEmpresaCompra();
            echo json_encode($empresa->GetRows());
            
        }break;
        
        case 'consultaProveedor':{
            
            $empresa = $objData->consultarProveedor();
            echo json_encode($empresa->GetRows());
            
        }break;
        
        case 'consultaModoPago':{
            
            $modo = $objData->consultarModoPago();
            echo json_encode($modo ->GetRows());
            
        }break;
        
        case 'cargaFormularioCrear':{
            $objPresenta->formularioCrear();
        }break;
        
        case 'editarFactura':{
            
            $numeroFactura = $_POST["NumeroFactura"];
            $valorFactura = $_POST["ValorFactura"];
            $Fecha = $_POST["Fecha"];
            
            echo $objPresenta->formularioEditar($numeroFactura, $valorFactura, $Fecha ); 
            
        }break;
        
        case 'guardarFactura':{
            
            $empresaCompra = $_POST["id_empresaCompra"];
            $empresaProvee = $_POST["id_proveedor"];
            $valor = $_POST["TB_valor"];
            $modoPago = $_POST["id_modopago"];
            $fecha = $_POST["TB_fecha"]; //input dd/mm/yyyy
            $fechaFormat = explode('/', $fecha); 
            // se debe enviar y/m/d 
            $fechaValida = $objData->comparaFechaActual($fechaFormat[2]."/".$fechaFormat[1]."/".$fechaFormat[0]);                        
                       
            
            if((trim($empresaCompra) == "")){                
                header('HTTP/1.1 500');
                echo "¡La empresa que compra es requerida!";                 
            }
            else if((trim($empresaProvee) == "")){                
                header('HTTP/1.1 500');
                echo "¡El proveedor es requerido!";                 
            }
            else if((trim($valor) == "") || intval(trim($valor)) <= 0){                
                header('HTTP/1.1 500');
                echo "¡El valor es requerido!";                 
            }
            else if((trim($modoPago) == "")){                
                header('HTTP/1.1 500');
                echo "¡El modo de pago es requerido!";                 
            }
            else if((trim($fecha) == "")){                
                header('HTTP/1.1 500');
                echo "¡La fecha es requerida!";                 
            }
            else if( $fechaValida == "MENOR"){                
                header('HTTP/1.1 500');
                echo "¡La fecha no pueder ser menor a la actual! ";                 
            }
            else if($fechaValida == "error"){                
                header('HTTP/1.1 500');
                echo "¡Se ha generado un error en la fecha!";                 
            }
            else
            {
                $fechaActual = getdate();
                $error = $objDataAuditoria->guardarAuditoria("Guarda factura", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"]);
                if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la información! ";    
                }
                else
                {
                    $error = $objData->guardarFactura($empresaCompra, $valor, $empresaProvee, $modoPago, ($fechaFormat[2] . "/". $fechaFormat[1] . "/". $fechaFormat[0]),1);
                    
                    if($error == "error")
                    {
                        header('HTTP/1.1 500');
                        echo "¡Se ha generado un error al guardar la información!";
                    }
                    else
                    {
                        echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarFacturas(1)");
                    }                  
                }            
            }                       
        }break;
        case 'validaEliminarFactura':{
            
            $id_factura = $_POST["id_factura"];
            $cantidad = $objData->validaFacturaReferencias($id_factura);
            
            echo json_encode($cantidad->GetRows());            
            
        }break;
        
        case 'eliminarFactura':{
            
            $id_factura = $_POST["id_factura"];
            $error = $objData->eliminaFactura($id_factura);
            
            if($error != "error")
            {
                echo $objPresenta->mensajeRedirect("'Se ha eliminado la factura satisfactoriamente !'", "mostrarFacturas(1)");    
            }
            else
            {
                echo $objPresenta->mensajeRedirect("'Se presento un error el eliminar la factura!'", "mostrarFacturas(1)");   
            }
        }break;
        
        case 'detalleFactura':{
            
            $id_factura = $_POST["id_factura"];
            echo $objPresenta->detalleFactura($id_factura);
        }break;        
        
        case 'cargaRefFacturas':{
            
            $id_factura = $_POST["id_factura"];
            $reffacturas = $objData->consultarReferenciasFactura($id_factura);
            
            echo json_encode($reffacturas->GetRows());
        }break;
                
		case 'crearReferenciaFactura':{
			$id_factura = $_POST["id_factura"];
			
			echo $objPresenta-> crearReferenciaFacturas($id_factura);
		}break;
		
		case 'consultarReferencias':{
			
			$referenciasList = $objData->ConsultarReferencias();	

            echo json_encode($referenciasList->GetRows());			
		}break;
		
		case 'consultarTipoEmpaque':{
			
			$referenciasList = $objData->ConsultarTipoEmpaque();	

            echo json_encode($referenciasList->GetRows());			
		}break;
		
		case 'guardarReferenciaFactura':{

			$id_referencia = $_POST["id_referencia"];
			$id_factura = $_POST["id_factura"];			
			$id_tipoempaque = $_POST["id_tipoempaque"];
			$TB_cantidad = $_POST["TB_cantidad"];
			$TB_valorUnitario = $_POST["TB_valorUnitario"];
			$TB_descuento = $_POST["TB_descuento"];
			$TB_iva = $_POST["TB_iva"];
			$TB_utilidad = $_POST["TB_utilidad"];
			$TB_valortotal = $_POST["TB_valortotal"];
			
						
            if(trim($id_referencia) == ""){                
                header('HTTP/1.1 500');
                echo "¡La referencia es requerida!";                 
            }
            else if((trim($id_tipoempaque) == "")){                
                header('HTTP/1.1 500');
                echo "¡El tipo de empaque es requerido!";                 
            }
            else if(trim($TB_cantidad) == ""){                
                header('HTTP/1.1 500');
                echo "¡La cantidad es requerido!";                 
            }
            else if(trim($TB_valorUnitario) == ""){                
                header('HTTP/1.1 500');
                echo "¡El valor unitario es requerido!";                 
            }
			else if(strlen(explode(".",trim($TB_valorUnitario))[0]) > 8){                
                header('HTTP/1.1 500');
                echo "¡El número no puede exceder el tamaño maximo 8!";                 
            }
			else if((sizeof(explode(".",trim($TB_valorUnitario)))>1) &&
					(strlen((explode(".",trim($TB_valorUnitario))[1])) > 2))
			{			
				header('HTTP/1.1 500');
				echo "¡El decimal no puede ser mayor de 2!";                 
            }
            else if((trim($TB_descuento) == "")){                
                header('HTTP/1.1 500');
                echo "¡El descuento es requerido!";                 
            }
            else if( trim($TB_iva) == ""){                
                header('HTTP/1.1 500');
                echo "¡El iva es requerido! ";                 
            }
            else if(trim($TB_utilidad) == ""){                
                header('HTTP/1.1 500');
                echo "¡La utilidad es requerida!";                 
            }
            else if(trim($TB_valortotal) == ""){                
                header('HTTP/1.1 500');
                echo "¡El valor total es requerido!";                 
            }
			//else if((sizeof(explode(".",trim($TB_valortotal)))>1) &&
			//		(strlen((explode(".",trim($TB_valortotal))[1])) > 2))
			//{			
			//	header('HTTP/1.1 500');
			//	echo "¡El decimal valor total no puede ser mayor de 2!";                 
            //}
            else
            {
                $fechaActual = getdate();
                $error = $objDataAuditoria->guardarAuditoria("Guarda referencia factura", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]))), $_SESSION["id_usuario"]);
                if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la información!";    
                }
                else
                {
                    $error = $objData->GuardaReferenciaFactura($id_referencia, $id_factura, $id_tipoempaque, $TB_cantidad, $TB_valorUnitario, $TB_descuento, $TB_iva, $TB_utilidad, $TB_valortotal);
                    
                    if($error == "error")
                    {
                      header('HTTP/1.1 500');
                      echo "¡Se ha generado un error al guardar la información!!!!";
                    }
                    else
                    {
                        echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarFacturas(1)");
                    }                  
                }            
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
    <script src="../js/jsSitio/Facturas.js"></script>
    <?php   
}
        

?>