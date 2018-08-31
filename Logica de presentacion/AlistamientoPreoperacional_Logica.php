<?php 

/**
 * 
 * Manejo de Alistamiento preoperacional crear, edita, eliminar
 * @author Miguel Villamizar 
 * @copyright 28/04/2018
 */
 
 session_start();

global $objPresenta, $objData , $objDataAuditoria;
include('../Acceso a datos/AlistamientoPreoperacionalData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/AlistamientoPreoperacional.php');


$objPresenta = new AlistamientoPreoperacional();
$objData = new AlistamientoData();
$objData->Conectar();

$objDataAuditoria = new AuditoriaData();
$objDataAuditoria->Conectar();

if(isset($_POST['desea']))
{
    switch($_POST['desea'])
    {
        case 'cargaAlistamiento':{
            
            $alistamiento = $objData->consultarAlistamiento();
            echo json_encode($alistamiento->GetRows());
            
        }break;
		
		case 'crearAlistamiento':{
			$objPresenta->formularioCrear();			
		}break;
		
		case 'consultaConductor':{            
            $conductor = $objData->consultarConductor();
            echo json_encode($conductor->GetRows());
            
        }break;
		
		case 'consultaMecanico':{            
            $medico = $objData->consultarMecanico();
            echo json_encode($medico->GetRows());
            
        }break;
		
		case 'consultaVehiculo':{            
            $vehiculo = $objData->consultarVehiculo();
            echo json_encode($vehiculo->GetRows());
            
        }break;
		
		case 'cargaCheckAlistamiento':{
			
            $alistamiento = $objData->consultarAlistamientoCheckList();
            echo json_encode($alistamiento->GetRows());
            
		}break;
		
		case 'guardarAlistamiento':{
			$id_vehiculo = $_POST["vehiculo"];
			$fecha = $_POST["TB_fecha"];
			$TB_kilometraje = $_POST["TB_kilometraje"];
			$id_conductor = $_POST["id_conductor"];
			$id_mecanico = $_POST["id_mecanico"];
			$TB_observaciones = $_POST["TB_observaciones"];
			$checkList = $_POST["checkList"];
			
			$fechaFormat = explode('/', $fecha); 
			
            if(trim($id_vehiculo) == ""){                
                header('HTTP/1.1 500');
                echo "¡El vehiculo es requerido!";                 
            }
            else if(trim($fecha) == ""){                
                header('HTTP/1.1 500');
                echo "¡El fecha es requerida!";                 
            }
            else if(trim($TB_kilometraje) == ""){                
                header('HTTP/1.1 500');
                echo "¡El kilometraje es requerido!";                 
            }
            else if(trim($id_conductor) == ""){                
                header('HTTP/1.1 500');
                echo "¡El conductor es requerido!";                 
            }			
            else if(trim($id_mecanico) == ""){                
                header('HTTP/1.1 500');
                echo "¡El mecanico es requerido!";                 
            }			
            else if(trim($TB_observaciones) == ""){                
                header('HTTP/1.1 500');
                echo "¡Las observaciones son requeridas!";                 
            }
            else if(trim($checkList) == ""){                
                header('HTTP/1.1 500');
                echo "¡No hay Checklist seleccionados!";                 
            }
			else 
			{
				$checkList = str_replace('"',"",$checkList );
				
				$fechaActual = getdate();
                $error = $objDataAuditoria->guardarAuditoria("Guarda Alistamiento Preoperacional", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"],
				"id_vehiculo: ".$id_vehiculo.",". 
				"fecha: ".$fecha.",".
				"TB_kilometraje: ".$TB_kilometraje.",".
				"id_conductor: ".$id_conductor.",".
				"id_mecanico: ".$id_mecanico.",".
				"TB_observaciones: ".$TB_observaciones.",".
				"checkList: ".$checkList);
				
                if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la información de la auditoria! ";    
                }
                else
                {	
					//puede retornar ok o error
					$result = $objData->guardarAlistamiento($id_vehiculo, 
														($fecha), 
														$TB_kilometraje, 
														$id_conductor, 
														$id_mecanico, 
														$TB_observaciones,
														$checkList);
					
					if($result == "error")
                    {
                        header('HTTP/1.1 500');
                        echo "¡Se ha generado un error al guardar la información del alistamiento!";
                    }
                    else
                    {						
						// $cont = 0;
						// $tempError = 0;
						// $checkListArray = json_decode($checkList);
						
						// while( $cont < count($checkListArray) )
						// {						
							// $respuesta = $objData->guardarCheckListAlistamiento($id_alistamiento, $checkListArray[$cont]);
							// $cont = $cont + 1;
							
							// if($respuesta == "error")
							// {
								// $tempError = 1;
							// }
						// }
					
						// if($tempError == 1)
						// {
						 // header('HTTP/1.1 500');
						 // echo "¡Se ha generado un error al guardar los checkList seleccionados!";
						// }
						// else
						// {
						 echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarAlistamiento(1)");
						//}
					}
				}			
			}
		}break; 
		
		case 'editarAlistamiento':
		{ 
            $objPresenta-> formularioEditar();
            jsInclude(); 
		}break;
		
		case 'editarAlistamientoDatos':
		{
			$id_alistamiento = $_POST["Id"];
			
			$respuesta = $objData->consultarAlistamientoCodigo($id_alistamiento);
						
            echo json_encode($respuesta->GetRows());
		}break;
				
		case 'cargaCheckAlistamiento':{
			
            $alistamiento = $objData->consultarAlistamientoCheckList();
            echo json_encode($alistamiento->GetRows());
            
		}break;
		
		case 'cargaCheckAlistamientoEditar':{
			
			$id_alistamiento = $_POST["Id"];
            $alistamiento = $objData->consultarAlistamientoCheckListEditar($id_alistamiento);
            echo json_encode($alistamiento->GetRows());
            
		}break;
		
		case 'guardarEditarAlistamiento':{
			
			$idAlistamiento = $_POST["idAlistamiento"];
			$id_vehiculo = $_POST["vehiculo"];
			$fecha = $_POST["TB_fecha"];
			$TB_kilometraje = $_POST["TB_kilometraje"];
			$id_conductor = $_POST["id_conductor"];
			$id_mecanico = $_POST["id_mecanico"];
			$TB_observaciones = $_POST["TB_observaciones"];
			$checkList = $_POST["checkList"];
			
			$fechaFormat = explode('/', $fecha); 
			
            if(trim($id_vehiculo) == ""){                
                header('HTTP/1.1 500');
                echo "¡El vehiculo es requerido!";                 
            }
            else if(trim($fecha) == ""){                
                header('HTTP/1.1 500');
                echo "¡El fecha es requerida!";                 
            }
            else if(trim($TB_kilometraje) == ""){                
                header('HTTP/1.1 500');
                echo "¡El kilometraje es requerido!";                 
            }
            else if(trim($id_conductor) == ""){                
                header('HTTP/1.1 500');
                echo "¡El conductor es requerido!";                 
            }			
            else if(trim($id_mecanico) == ""){                
                header('HTTP/1.1 500');
                echo "¡El mecanico es requerido!";                 
            }			
            else if(trim($TB_observaciones) == ""){                
                header('HTTP/1.1 500');
                echo "¡Las observaciones son requeridas!";                 
            }
            else if(trim($checkList) == ""){                
                header('HTTP/1.1 500');
                echo "¡No hay Checklist seleccionados!";                 
            }
			else 
			{
				$checkList = str_replace('"',"",$checkList );
				
				$fechaActual = getdate();
                $error = $objDataAuditoria->guardarAuditoria("Edita Alistamiento Preoperacional", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"],
				"idAlistamiento: ".$idAlistamiento.",".
				"id_vehiculo: ".$id_vehiculo.",".
				"fecha: ".($fecha).",".
				"TB_kilometraje: ".$TB_kilometraje.",". 
				"id_conductor: ".$id_conductor.",".
				"id_mecanico: ".$id_mecanico.",".
				"TB_observaciones: ".$TB_observaciones.",".
				"checkList: ".$checkList);
				
                if($error == "error")
                {
                    header('HTTP/1.1 500');
                    echo "¡Se ha generado un error al guardar la información de auditoria! ";    
                }
                else
                {	
					//puede retornar id_alistamiento o error
					$respuesta = $objData->guardarEditarAlistamiento($idAlistamiento,
														$id_vehiculo, 
														($fecha), 
														$TB_kilometraje, 
														$id_conductor, 
														$id_mecanico, 
														$TB_observaciones,
														$checkList);
					
					if($respuesta != "")
                    {
                        header('HTTP/1.1 500');
                        echo "¡Se ha generado un error al guardar la información del alistamiento!";
                    }
                    else
                    {			
						echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarAlistamiento(1)");
					}
				}			
			}
			
		}break;
		
		default:{
            $objPresenta-> mostrarAlistamiento();
            jsInclude(); 
        }break;
	}
}
else
{
    $objPresenta-> mostrarAlistamiento();
    jsInclude();
}      

function jsInclude(){
   ?>
    <script src="../js/jsSitio/AlistamientoPreoperacional.js"></script>
    <?php   
}
    
?>