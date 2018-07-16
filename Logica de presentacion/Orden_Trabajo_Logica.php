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
				
		case 'consultaVehiculo':{            
            $vehiculo = $objData->consultarVehiculo();
            echo json_encode($vehiculo->GetRows());
            
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
			
            $placa = $_POST["id_vehiculo"];
            $fecha = $_POST["TB_fecha"]; //input yyyy/mm/dd hh:mm
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
                $error = $objDataAuditoria->guardarAuditoria("Guarda Orden Trabajo", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"],
				("id_vehiculo: ".$placa.",". 
				"fecha: ".($fecha).",". 
				"kilometraje: ".$kilometraje.",". 
				"mecanico: ".$mecanico.",". 
				"conductor: ".$conductor.",". 
				"observaciones: ".$observaciones));
				
                if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la auditoria! ";    
                }
                else
                {					
                    $error = $objData->guardarOrden($placa, $fecha, $kilometraje, $mecanico, $conductor, $observaciones);
                    
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
			$fecha = $_POST["Fecha"];
			$kilometraje = $_POST["Kilometraje"];
			$observaciones = $_POST["Observaciones"];
			
			echo $objPresenta->EditarOrdenTrabajo($numeroOrden, $fecha, $kilometraje, $observaciones);
		}break;
		
		case 'editarGuardarOrden':{
			
			$numeroOrden = $_POST["numeroOrden"];
			$placa = $_POST["id_vehiculo"];
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
                $error = $objDataAuditoria->guardarAuditoria("Editar Orden Trabajo", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"],
				("placa: ".$placa.",". 
				"fecha: ".($fecha).",". 
				"kilometraje: ".$kilometraje.",". 
				"mecanico: ".$mecanico.",". 
				"conductor".$conductor.",". 
				"observaciones: ".$observaciones.",". 
				"numeroOrden: ".$numeroOrden));
                
				if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la auditoria!";    
                }
                else
                {					
                    $error = $objData->EditarGuardarOrden($placa, ($fecha), $kilometraje, $mecanico, $conductor, $observaciones, $numeroOrden);
                    
                    if($error != "")
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
			
			$cantidadRef = $objData->ValidarCantidadReferencia($id_referencia);
			
			if($cantidadRef > 0)
			{
				echo $objPresenta->verReferenciaInfo($id_orden, $id_referencia);
				
			}				
			else{
				header('HTTP/1.1 500');
				echo "¡La referencia ingresada no existe!";    
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
			$utilidad = $_POST["utilidad"];
			$ValorTotal = ($cantidad * $ValorUnitario);
			$ValorTotalUtilidad = (($cantidad * $ValorUnitario) + (($utilidad * $ValorUnitario)/100) * $cantidad);
						
			$fechaActual = getdate();
			$error = $objDataAuditoria->guardarAuditoria("Guarda referencia orden", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"], 
			("id_referencia: ".$id_referencia.",". 
			"Id_ordentrabajo: ".$Id_ordentrabajo.",". 
			"Id_empaque: ".$Id_empaque.",". 
			"cantidad: ".$cantidad.",". 
			"ValorUnitario: ".$ValorUnitario.",". 
			"ValorTotal: ".$ValorTotal.",". 
			"utilidad: ".$utilidad.",".
			"ValorTotalUtilidad: ".$ValorTotalUtilidad));
						
			if($error == "error")
			{
				header('HTTP/1.1 500');
				echo "¡Se ha generado un error al guardar la Auditoria! ";    
			}
			else
			{
				$error = $objData-> GuardarReferencias($id_referencia, $Id_ordentrabajo, $Id_empaque, $cantidad, $ValorUnitario, $ValorTotal, $utilidad, $ValorTotalUtilidad);
				if($error == "error")
				{
					header('HTTP/1.1 500');
					echo "¡Se ha generado un error al guardar la información! ";    
				}
				else
				{
					//$error = $objData-> ModificarInventario($id_referencia, $cantidad);
					//if($error != "")
					//{
					//	header('HTTP/1.1 500');
					//	echo "¡Se ha generado un error al guardar la información! ".$error;    
					//}
					//else
					//{
						echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarReferenciasOrden(".$Id_ordentrabajo.",1)");
					//}
				}  
			}			
		}break;
		
		case 'verActividades':{
			
			$noOrden = $_POST["NumeroOrden"];			
			echo $objPresenta-> verActividadesInfo($noOrden);
		}break;
		
		
		case'cargaActividadesOrdenes':{
			$id_ordentrabajo = $_POST["id_ordentrabajo"];
			
			$referencia = $objData->ObtenerActividades($id_ordentrabajo);
			echo json_encode($referencia->GetRows());
			
		}break;
		
		case 'crearActividad':{			
			$id_orden = $_POST["id_orden"];
			$objPresenta->CrearActividad($id_orden);				
		}break;
		
		case 'consultaActividad':{
            $medico = $objData->consultarActividad();
            echo json_encode($medico->GetRows());			
		}break;
		
		
		case 'consultaTiempoActividad':{
			
			$id_actividad = $_POST["id_actividad"];
            $tiempo = $objData->consultaTiempoActividad($id_actividad);
            echo json_encode($tiempo);			
		}break;
		
		case 'guardarActividadOrden':
		{			
			$Id_actividad = $_POST["id_actividad"];
			$id_mecanico = $_POST["id_mecanico"];			
			$Tiempo = $_POST["TB_tiempo"];
			$Valor = $_POST["TB_valor"];
			$Fecha = $_POST["TB_fecha"];
			$Id_orden = $_POST["id_ordentrabajo"];
			$TB_utilidad = $_POST["TB_utilidad"];
			$Observaciones = $_POST["TB_observaciones"];
            $fechaFormat = explode('/', $Fecha); 
			$valorUtilidad = (($Valor * $TB_utilidad)/100);
			$valorTotalUtilidad = ($Valor + $valorUtilidad);
			
			if(trim($Id_actividad) == "")
			{
				header('HTTP/1.1 500');
				echo "¡La actividad es obligatoria! ";    
			}
			else if(trim($id_mecanico) == "")
			{
				header('HTTP/1.1 500');
				echo "¡El mecánico es obligatorio! ";    
			}
			else if(trim($Tiempo) == "")
			{
				header('HTTP/1.1 500');
				echo "¡El tiempo es obligatorio! ";    
			}			
			else if(trim($Valor) == "")
			{
				header('HTTP/1.1 500');
				echo "¡El Valor es obligatorio! ";    
			}
			else if(trim($Fecha) == "")
			{
				header('HTTP/1.1 500');
				echo "¡La Fecha es obligatoria! ";    
			}
			else if(trim($TB_utilidad) == "")
			{
				header('HTTP/1.1 500');
				echo "¡La utilidad es obligatoria! ";    
			}
			else if(trim($Observaciones) == "")
			{
				header('HTTP/1.1 500');
				echo "¡La Observacion es obligatoria! ";    
			}
			else{
						
				$fechaActual = getdate();
				$error = $objDataAuditoria->guardarAuditoria("Guarda actividad orden", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"],
				( "Id_actividad: ".$Id_actividad.",". 
				"id_mecanico: ".$id_mecanico.",".
				"Tiempo: ".$Tiempo.",".
				"Valor: ".$Valor.",".
				"Fecha: ".$Fecha.",".
				"utilidad: ".$TB_utilidad.",".
				"valorTotalUtilidad: ".$valorTotalUtilidad.",".
				"Id_orden: ".$Id_orden.",".
				"Observaciones: ".$Observaciones));
				if($error == "error")
				{
					header('HTTP/1.1 500');
					echo "¡Se ha generado un error al guardar la auditoria! ";    
				}
				else
				{
					$error = $objData -> GuardarActividades($Id_actividad, $id_mecanico, $Tiempo, $Valor, ($Fecha), $Id_orden, $Observaciones, $TB_utilidad, $valorTotalUtilidad);
					if(trim($error) != "")
					{
						header('HTTP/1.1 500');
						echo "¡Se ha generado un error al guardar la información! ".$error;    
					}
					else
					{
						echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarActividadesOrden(".$Id_orden.", 1)");
					}
				}
			}
			
		}break;		
		
		case 'eliminarReferenciaOrden': 
		{
			$id_referenciaOrden = $_POST["id_referenciaOrden"];
			$id_orden = $_POST["id_orden"];
			
			$error = $objData->EliminarReferenciasOrden($id_referenciaOrden);
			if(trim($error) != "")
			{				
				header('HTTP/1.1 500');
				echo "¡Se ha generado un error al guardar la información! ".$error;    
			}
			else{
				echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarReferenciasOrden(".$id_orden.",1)");
			}
			
		}break;
		
		
		case 'eliminarActividadOrden': 
		{
			$Id_actividadOrden = $_POST["id_actividadOrden"];
			$id_orden = $_POST["id_orden"];
			
			$error = $objData->EliminarActividades($Id_actividadOrden);
			if(trim($error) != "")
			{				
				header('HTTP/1.1 500');
				echo "¡Se ha generado un error al guardar la información! ".$error;    
			}
			else{
				echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarActividadesOrden(".$id_orden.", 1)");
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
    <script src="../js/jsSitio/OrdenTrabajo.js"></script>
	<?php
}

?>