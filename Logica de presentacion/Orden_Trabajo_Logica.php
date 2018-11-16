<?php

/*
*
*
*Manejo de ordenes de trabajo 
*@autor Miguel Villamizar
*@copyright 17/03/2018
*/

session_start();
global $objPresenta, $objData, $objDataAuditoria, $objDataUsuario;

include('../Acceso a datos/UsuarioData.php');
include('../Acceso a datos/OrdenTrabajoData.php');
include('../Acceso a datos/AuditoriaData.php');
include('../Presentacion/OrdenTrabajo.php');

$objPresenta= new OrdenTrabajo();
$objData = new OrdenTrabajoData();
$objData->Conectar();

$objDataAuditoria = new AuditoriaData();
$objDataAuditoria->Conectar();

$objDataUsuario = new usuarioData();
//valida que la sesión no caduque
$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = $objDataUsuario->ConsultaTiempoSesion();

if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
	session_unset();
	session_destroy();
	session_start();
		
    echo "<script> parent.window.location.reload(); </script>";
}
else
{
	$_SESSION['LAST_ACTIVITY'] = $time; 
	// fin valida sesion	

	
	//validacion del permiso del rol
	$MenuLista = $objDataUsuario->consultarMenuUsuarioPermiso($_SESSION["id_rol"], $_SESSION["id_usuario"], 5);
	
	if($MenuLista == 0)
	{
		header('HTTP/1.1 401');
		echo "¡No puede acceder a esta página! ";    
	}
	//fin validacion del permiso
	else
	{			
		if(isset($_POST['desea']))
		{
			switch($_POST['desea'])
			{
					
				case 'cargaOrdenesFiltros':{
					
					$referencia = $_POST["referencia"];
					$actividad = $_POST["actividad"];
					$fechaInicial = $_POST["fechaInicial"];
					$fechaFinal = $_POST["fechaFinal"];
					
					
					$fechaInicial = str_replace("-", "/", $fechaInicial);
					$fechaFinal = str_replace("-", "/", $fechaFinal);
					
					$validaMayor = $objData->validaFechas($fechaInicial, $fechaFinal);
								
					if((trim($fechaInicial) == "")){                
						header('HTTP/1.1 500');
						echo "¡La fecha inicial es requerida!";                 
					}
					else if((trim($fechaFinal) == "")){                
						header('HTTP/1.1 500');
						echo "¡La fecha final es requerida!";                 
					}
					else if( $validaMayor == 1){                
						header('HTTP/1.1 500');
						echo "¡La fecha inicial no pueder ser mayor a la final!";                 
					}
					else{			
						$facturas = $objData->consultarOrdenesFiltro($referencia, $actividad, $fechaInicial, $fechaFinal);
						echo json_encode($facturas->GetRows());            
					}
				}break;
				
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
					$Placas = $_POST["Placas"];	
					$Fecha = $_POST["Fecha"];	
					$Kilometraje = $_POST["Kilometraje"];	
					$mecanico = $_POST["mecanico"];	
					$conductor = $_POST["conductor"];	
					$Observaciones = $_POST["Observaciones"];

					echo $objPresenta-> verReferencias($noOrden,
										$Placas,
										$Fecha,
										$Kilometraje,
										$mecanico,
										$conductor,
										$Observaciones);
				}break;
				
				case'cargaReferenciaOrdenes':{
					$id_ordentrabajo = $_POST["id_ordentrabajo"];
					
					$referencia = $objData->ObtenerReferenciaOrdenes($id_ordentrabajo);
					echo json_encode($referencia->GetRows());
					
				}break;
				
				case 'agregarReferenciaOrden':{
					
					$id_referencia = $_POST["id_referencia"];
					$id_orden = $_POST["id_orden"];
					$Placas = $_POST["Placas"];
					$Fecha = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones = $_POST["Observaciones"];
					
					$cantidadRef = $objData->ValidarCantidadReferencia($id_referencia);
					
					if($cantidadRef > 0)
					{
						echo $objPresenta->verReferenciaInfo($id_orden, 
														$id_referencia,
														$Placas,
														$Fecha,
														$Kilometraje,
														$mecanico,
														$conductor,
														$Observaciones);
						
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
					
					$Placas = $_POST["Placas"];
					$Fecha = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones = $_POST["Observaciones"];
					
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
							echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarReferenciasOrden(
							'".$Placas."',
							'".$Fecha."',
							".$Kilometraje.",
							'".$mecanico."',
							'".$conductor."',
							'".$Observaciones."',
							".$Id_ordentrabajo.",
							1)");			
						}  
					}			
				}break;
				
				case 'verActividades':{
					
					$noOrden = $_POST["NumeroOrden"];
					$Placas = $_POST["Placas"];
					$Fecha = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones = $_POST["Observaciones"];	
								
					echo $objPresenta-> verActividadesInfo($noOrden,
															$Placas,
															$Fecha,
															$Kilometraje,
															$mecanico,
															$conductor,
															$Observaciones);
				}break;
				
				
				case'cargaActividadesOrdenes':{
					$id_ordentrabajo = $_POST["id_ordentrabajo"];
					
					$referencia = $objData->ObtenerActividades($id_ordentrabajo);
					echo json_encode($referencia->GetRows());
					
				}break;
				
				case 'crearActividad':{			
					$id_orden = $_POST["id_orden"];			
					$Placas = $_POST["Placas"];
					$Fecha = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones = $_POST["Observaciones"];	
					
					$objPresenta->CrearActividad($id_orden,
												$Placas,
												$Fecha,
												$Kilometraje,
												$mecanico,
												$conductor,
												$Observaciones);				
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
					$TB_valorHora = $_POST["TB_valorHora"];
					$Fecha = $_POST["TB_fecha"];
					$Id_orden = $_POST["id_ordentrabajo"];
					$TB_utilidad = $_POST["TB_utilidad"];
								
					$Placas = $_POST["Placas"];
					$Fecha2 = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];			
					$Observaciones = $_POST["TB_observaciones"];
					
					
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
					else if(trim($TB_valorHora) == "")
					{
						header('HTTP/1.1 500');
						echo "¡El Valor hora mecanico es obligatorio! ";    
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
						
						$fechaFormat = explode('/', $Fecha); 
					
						$valorTotal  = floatval($TB_valorHora) * floatval($Tiempo);
						
						$valorUtilidad = (($valorTotal * $TB_utilidad)/100);
						$valorTotalUtilidad = ($valorTotal + $valorUtilidad);
						
						
						$fechaActual = getdate();
						$error = $objDataAuditoria->guardarAuditoria("Guarda actividad orden", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"],
						( "Id_actividad: ".$Id_actividad.",". 
						"id_mecanico: ".$id_mecanico.",".
						"Tiempo: ".$Tiempo.",".
						"TB_valorHora: ".$TB_valorHora.",".
						"valorTotal: ".$valorTotal.",".
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
							$error = $objData -> GuardarActividades($Id_actividad, 
																	$id_mecanico, 
																	$Tiempo, 
																	$TB_valorHora, 
																	$Fecha, 
																	$Id_orden, 
																	$Observaciones, 
																	$valorTotal,
																	$TB_utilidad, 
																	$valorTotalUtilidad);
							if(trim($error) != "")
							{
								header('HTTP/1.1 500');
								echo "¡Se ha generado un error al guardar la información! ".$error;    
							}
							else
							{
								echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarOrdenesActividades(".$Id_orden.",
																																	'".$Placas."', 
																																	'".$Fecha2."', 
																																	".$Kilometraje.", 
																																	'".$mecanico."', 
																																	'".$conductor."', 
																																	'".$Observaciones2."',
																																	1)");
							}
						}
					}
					
				}break;		
						
				case 'editarActividad':{
					
					$id = $_POST["id"];
					$id_orden = $_POST["id_orden"];
					$tiempoHoras = $_POST["tiempoHoras"];
					$fecha = $_POST["fecha"];
					$tb_valorHoraMecanico = $_POST["tb_valorHoraMecanico"];
					$tb_valorTotalUtilidad = $_POST["tb_valorTotalUtilidad"];
					$tb_valorTotal = $_POST["tb_valorTotal"];
					$TB_utilidad = $_POST["TB_utilidad"];
					$TB_observaciones = $_POST["TB_observaciones"];
								
					$Placas = $_POST["Placas"];
					$Fecha2 = $_POST["Fecha2"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones2 = $_POST["Observaciones2"];
					
					$objPresenta->EditarActividad($id,	
												$id_orden,	
												$tiempoHoras, 
												$fecha, 
												$tb_valorHoraMecanico, 
												$tb_valorTotalUtilidad,
												$tb_valorTotal,
												$TB_utilidad,
												$TB_observaciones,
												$Placas,
												$Fecha2,
												$Kilometraje,
												$mecanico,
												$conductor,
												$Observaciones2);				
				}break;
				
				case 'guardarEditarActividad':{
					
					$id_ActividadOrden = $_POST["id_ActividadOrden"];
					$id_orden = $_POST["id_ordentrabajo"];
					$Id_actividad = $_POST["id_actividad"];
					$id_mecanico = $_POST["id_mecanico"];			
					$Tiempo = $_POST["TB_tiempo"];
					$TB_valorHora = $_POST["TB_valor"];
					$Fecha = $_POST["TB_fecha"];
					$TB_utilidad = $_POST["TB_utilidad"];
					$Observaciones = $_POST["TB_observaciones"];
					
					
					$Placas = $_POST["Placas"];
					$Fecha2 = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones2 = $_POST["Observaciones"];
					
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
					else if(trim($TB_valorHora) == "")
					{
						header('HTTP/1.1 500');
						echo "¡El Valor hora mecanico es obligatorio! ";    
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
						$fechaFormat = explode('/', $Fecha); 			
						$valorTotal  = floatval($TB_valorHora) * floatval($Tiempo);
						
						$valorUtilidad = (($valorTotal * $TB_utilidad)/100);
						$valorTotalUtilidad = ($valorTotal + $valorUtilidad);
						
						$fechaActual = getdate();
						$error = $objDataAuditoria->guardarAuditoria("Edita actividad orden", ($fechaActual["year"] . "/". $fechaActual["mon"] . "/". (intval($fechaActual["mday"]) - 1)), $_SESSION["id_usuario"],
						( "id_ActividadOrden: ".$id_ActividadOrden.",". 
						"Id_actividad: ".$Id_actividad.",". 
						"id_mecanico: ".$id_mecanico.",".
						"Tiempo: ".$Tiempo.",".
						"ValorHora: ".$TB_valorHora.",".
						"ValorTotal: ".$valorTotal.",".
						"Fecha: ".$Fecha.",".
						"utilidad: ".$TB_utilidad.",".
						"valorTotalUtilidad: ".$valorTotalUtilidad.",".
						"Id_orden: ".$id_orden.",".
						"Observaciones: ".$Observaciones));
						if($error == "error")
						{
							header('HTTP/1.1 500');
							echo "¡Se ha generado un error al guardar la auditoria! ";    
						}
						else
						{
							$error = $objData -> GuardarEditarActividades($id_ActividadOrden, $Id_actividad, $id_mecanico, $Tiempo, $TB_valorHora, $Fecha, $Observaciones, $valorTotal, $TB_utilidad, $valorTotalUtilidad);
							if(trim($error) != "")
							{
								header('HTTP/1.1 500');
								echo "¡Se ha generado un error al guardar la información! ".$error;    
							}
							else
							{
								echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarOrdenesActividades(".$id_orden.",
																																	'".$Placas."', 
																																	'".$Fecha2."', 
																																	".$Kilometraje.", 
																																	'".$mecanico."', 
																																	'".$conductor."', 
																																	'".$Observaciones2."',
																																	1)");
							}
						}
					}			
				}break;		
				
				case 'eliminarReferenciaOrden': 
				{
					$id_referenciaOrden = $_POST["id_referenciaOrden"];
					$id_orden = $_POST["id_orden"];
						
					$Placas = $_POST["Placas"];
					$Fecha = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones = $_POST["Observaciones"];	
					
					$error = $objData->EliminarReferenciasOrden($id_referenciaOrden);
					if(trim($error) != "")
					{				
						header('HTTP/1.1 500');
						echo "¡Se ha generado un error al guardar la información! ".$error;    
					}
					else{
						echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarReferenciasOrden('".$Placas."',
																															'".$Fecha."',
																															".$Kilometraje.",
																															'".$mecanico."',
																															'".$conductor."',
																															'".$Observaciones."',
																															".$id_orden.",
																															1)");			
						
					}
				}break;
						
				case 'eliminarActividadOrden': 
				{
					$Id_actividadOrden = $_POST["id_actividadOrden"];
					$id_orden = $_POST["id_orden"];
					
					$Placas = $_POST["Placas"];
					$Fecha = $_POST["Fecha"];
					$Kilometraje = $_POST["Kilometraje"];
					$mecanico = $_POST["mecanico"];
					$conductor = $_POST["conductor"];
					$Observaciones = $_POST["Observaciones"];			
					
					$error = $objData->EliminarActividades($Id_actividadOrden);
					if(trim($error) != "")
					{				
						header('HTTP/1.1 500');
						echo "¡Se ha generado un error al guardar la información! ".$error;    
					}
					else{
						echo $objPresenta->mensajeRedirect("'Los datos se han guardado con exito'", "mostrarOrdenesActividades(".$id_orden.",
																																'".$Placas."', 
																																'".$Fecha."', 
																																".$Kilometraje.", 
																																'".$mecanico."', 
																																'".$conductor."', 
																																'".$Observaciones."',
																																1)");
					}			
				}break;
				case 'consultaValorHora':{            
					
					$id_medico = $_POST["id_mecanico"];
				
					$mecanico = $objData->consultarMecanicoId($id_medico);
					echo json_encode(Floatval($mecanico));
					
				}break;
				
				case 'consultarReferencias':{
					
					$referenciasList = $objData->ConsultarReferencias();	

					echo json_encode($referenciasList->GetRows());			
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
	}
}

function jsInclude()
{
	?>	
    <script src="../js/jsSitio/OrdenTrabajoNueva.js"></script>
	<?php
}

?>