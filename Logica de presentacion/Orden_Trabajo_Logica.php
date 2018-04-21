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

include('../Acceso a datos/OrdenTrabajoData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/OrdenTrabajo.php');

$objPresenta= new OrdenTrabajo();
$objData = new OrdenTrabajoData();
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
		
		case 'crearOrdenTrabajo':{
			$objPresenta->CrearOrdenTrabajo();			
		}break;
		
		case 'consultaConductor':{            
            $conductor = $objData->consultarConductor();
            echo json_encode($conductor->GetRows());
            
        }break;
		
		case 'consultaMecanico':{            
            $medico = $objData->consultarMedico();
            echo json_encode($medico->GetRows());
            
        }break;
		
		case 'guardarOrden':{
			
            $placa = $_POST["TB_placa"];
            $fecha = $_POST["TB_fecha"];
            $kilometraje = $_POST["TB_kilometraje"];
            $conductor = $_POST["id_conductor"];
            $mecanico = $_POST["id_mecanico"];
			$observaciones = $_POST["TB_observaciones"];
            
			$fechaFormat = explode('/', $fecha); 
			
            if((trim($placa) == "")){                
                header('HTTP/1.1 500');
                echo "¡La placa es requerida!";                 
            }
            else if((trim($fecha) == "")){                
                header('HTTP/1.1 500');
                echo "¡El fecha es requerida!";                 
            }
            else if(trim($kilometraje) == ""){                
                header('HTTP/1.1 500');
                echo "¡El kilometraje es requerido!";                 
            }
            else if(trim($conductor) == ""){                
                header('HTTP/1.1 500');
                echo "¡El modo de pago es requerido!";                 
            }
            else if(trim($mecanico) == ""){                
                header('HTTP/1.1 500');
                echo "¡El mecanico es requerido!";                 
            }
            else if(trim($observaciones) == ""){                
                header('HTTP/1.1 500');
                echo "¡La observacion es requerida!";                 
            }
            else
            {
                $fechaActual = getdate();
                $error = $objDataAuditoria->guardarAuditoria("Guarda Orden Trabajo", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"]);
                if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la información! ";    
                }
                else
                {					
                    $error = $objData->guardarOrden($placa, ($fechaFormat[2] . "/". $fechaFormat[1] . "/". $fechaFormat[0]), $kilometraje, $mecanico, $conductor, $observaciones);
                    
                    if($error == "error")
                    {
                        header('HTTP/1.1 500');
                        echo "¡Se ha generado un error al guardar la información!";
                    }
                    else
                    {
                        echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarOrdenes(1)");
                    }                  
                }            
            }      
		}break;
		
		case'editarOrdenes':{
			$numeroOrden = $_POST["NumeroOrden"];
			$placa = $_POST["Placa"];
			$fecha = $_POST["Fecha"];
			$kilometraje = $_POST["Kilometraje"];
			$observaciones = $_POST["Observaciones"];
			
			echo $objPresenta->EditarOrdenTrabajo($numeroOrden, $placa, $fecha, $kilometraje, $observaciones);
		}break;
		
		case 'editarGuardarOrden':{
			
			$numeroOrden = $_POST["numeroOrden"];
			$placa = $_POST["TB_placa"];
			$fecha = $_POST["TB_fecha"];
			$kilometraje = $_POST["TB_kilometraje"];			
            $conductor = $_POST["id_conductor"];
            $mecanico = $_POST["id_mecanico"];
			$observaciones = $_POST["TB_observaciones"];
			
			$fechaFormat = explode('/', $fecha); 
			
            if((trim($placa) == "")){                
                header('HTTP/1.1 500');
                echo "¡La placa es requerida!";                 
            }
            else if((trim($fecha) == "")){                
                header('HTTP/1.1 500');
                echo "¡El fecha es requerida!";                 
            }
            else if(trim($kilometraje) == ""){                
                header('HTTP/1.1 500');
                echo "¡El kilometraje es requerido!";                 
            }
            else if(trim($conductor) == ""){                
                header('HTTP/1.1 500');
                echo "¡El modo de pago es requerido!";                 
            }
            else if(trim($mecanico) == ""){                
                header('HTTP/1.1 500');
                echo "¡El mecanico es requerido!";                 
            }
            else if(trim($observaciones) == ""){                
                header('HTTP/1.1 500');
                echo "¡La observacion es requerida!";                 
            }
            else
            {
                $fechaActual = getdate();
                $error = $objDataAuditoria->guardarAuditoria("Editar Orden Trabajo", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"]);
                if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la información!";    
                }
                else
                {					
                    $error = $objData->EditarGuardarOrden($placa, ($fechaFormat[2] . "/". $fechaFormat[1] . "/". $fechaFormat[0]), $kilometraje, $mecanico, $conductor, $observaciones, $numeroOrden);
                    
                    if($error != "")
                    {
                        header('HTTP/1.1 500');
                        echo "¡Se ha generado un error al guardar la información!" . $error;
                    }
                    else
                    {
                        echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarOrdenes(1)");
                    }                  
                }            
            }      
		}break;
		
		case 'verReferencias':{
			
			$noOrden = $_POST["NumeroOrden"];			
			echo $objPresenta-> verReferencias($noOrden);
		}break;
		
		case'cargaReferenciaOrdenes':{
			$id_ordentrabajo = $_POST["id_ordentrabajo"];
			
			$referencia = $objData->ObtenerReferenciaOrdenes($id_ordentrabajo);
			echo json_encode($referencia->GetRows());
			
		}break;
		
		case 'agregarReferenciaOrden':{
			
			$id_referencia = $_POST["id_referencia"];
			$id_orden = $_POST["id_orden"];
			
			$cantidadRef = $objData->ValidarReferencia($id_referencia);
			
			if($cantidadRef > 0)
			{
				echo $objPresenta->verReferenciaInfo($id_orden, $id_referencia);
			}				
			else{
				header('HTTP/1.1 500');
				echo "¡Se ha generado un error al guardar la información! ";    
			}			
		}break;
		
		case 'cargarReferencia':{
			
			$id_referencia = $_POST["id_referencia"];
			$id_orden = $_POST["id_orden"];
			
			$referencias = $objData-> ObtenerReferencias($id_referencia);
			echo json_encode($referencias->GetRows());
			
		}break; 
		
		case 'guardarReferencia':{
			
			$id_referencia = $_POST["id_referencia"];
			$Id_ordentrabajo = $_POST["id_orden"];			
			$cantidad = $_POST["cantidad"];
			$Id_empaque = $_POST["Id_empaque"];
			$ValorUnitario = $_POST["ValorUnitario"];
			$ValorTotal = ($cantidad * $ValorUnitario);
			
			
			$fechaActual = getdate();
			$error = $objDataAuditoria->guardarAuditoria("Guarda referencia orden", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"]);
			if($error == "error")
			{
				header('HTTP/1.1 500');
				echo "¡Se ha generado un error al guardar la información! ";    
			}
			else
			{
				$error = $objData-> GuardarReferencias($id_referencia, $Id_ordentrabajo, $Id_empaque, $cantidad, $ValorUnitario, $ValorTotal);
				if($error == "error")
				{
					header('HTTP/1.1 500');
					echo "¡Se ha generado un error al guardar la información! ";    
				}
				else
				{
					$error = $objData-> ModificarInventario($id_referencia, $cantidad);
					if($error != "")
					{
						header('HTTP/1.1 500');
						echo "¡Se ha generado un error al guardar la información! ".$error;    
					}
					else
					{
						echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarReferenciasOrden(".$Id_ordentrabajo.",1)");
					}
				}  
			}
			
		}break;
		
		case 'validarReferencia':{
			
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
    <script src="../js/jsSitio/OrdenTrabajo.js"></script>
	<?php
}

?>