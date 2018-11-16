<?php 

/*
*
*manejo de la presentacion de informes
*@autor Miguel Villamizar
*@copyrigth 22/07/2018
*
*/

class Informes
{
	function InformeTiemposMecanico()
	{
		?> 
        <meta charset="iso-8859-1" />        
		<form id="ExportarInformeTiempoMecanico" action="../Logica de presentacion/Informes_Logica.php" method="post" target="_blank" >
			<input type="hidden" id="desea" name="desea" value="exportarInformeTiempo" /> 
			<input type="hidden" id="Documento" name="Documento" value="" /> 
			<input type="hidden" id="Nombre" name="Nombre" value="" /> 
			<input type="hidden" id="Apellido" name="Apellido" value="" /> 
			<input type="hidden" id="Tiempo" name="Tiempo" value="" /> 
			<input type="hidden" id="Valor" name="Valor" value="" /> 
			
			<div class="">
				<h3 class="text-primary mb-4">INFORME TIEMPOS POR MECANICO</h3>
				<div class="row mb-2">
					<div class="col-lg-12">
					
						<div class="card">
							<div class="card-body" style="width: 100% !important;">
											
								<label for="id_referencia" style="font-weight: bold;">El usuario debe ingresar la fecha inicial y la fecha final:</label> 
								
								<br />
								<div class="row">				  
									<div class="col-md-6">
										<div class="form-group">
										  <label for="TB_fechaIni">Fecha Inicial</label> 
										  <div class="input-group">
											
											<div class="input-group date form_datetime" data-link-field="TB_fechaIni" >
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input id="TB_fechaDateIni" class="form-control p_input" type="text" readonly >
											</div>
											
											<input id="TB_fechaIni" name="TB_fechaIni" type="hidden" />
											
										  </div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
										  <label for="TB_fechaFin">Fecha Final</label> 
										  <div class="input-group">
											
											<div class="input-group date form_datetime" data-link-field="TB_fechaFin" >
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input id="TB_fechaDateFin" class="form-control p_input" type="text" readonly >
											</div>
											
											<input id="TB_fechaFin" name="TB_fechaFin" type="hidden" />
											
										  </div>
										</div>
									</div>
								</div>
								
								<div class="row">									
									<div class="col-md-12">
										<button type="button" onclick="filtarMecanicos()" class="btn btn-primary">Buscar</button>
									</div>
								</div>
					
								<div class="row">									
									<div class="col-md-12">							
										<div class="table-responsive">
											<table id="table_tiempoMecanico" class="display table table-striped table-bordered nowrap" cellspacing="0"></table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>                    
				</div>               
			</div> 
		</form> 
		
		<script>			

		$(document).ready(function(){
			cargarTiemposMecanico();
		 });	

		</script>
		<?php
	}
	
	function exportarInformeTiempoMecanicoPdf($documento, $nombre, $apellido, $tiempoF, $valorF, $data)
	{
		$fechaActual = getdate();
				
		$head = "
				<html>
				<head>
				
				<style>
				
				thead,
				tfoot {
					background-color: #3f87a6;
					color: #fff;
				}

				tbody {
					background-color: #00000;
				}

				caption {
					padding: 10px;
					caption-side: bottom;
				}

				table {
					border-collapse: collapse;
					border: 2px solid rgb(200, 200, 200);
					letter-spacing: 1px;
					font-family: sans-serif;
					font-size: .8rem;
				}

				td,
				th {
					border: 1px solid rgb(190, 190, 190);
					padding: 2px 5px;
				}

				td {
					text-align: center;
				}
				
				</style>
				</head>
				<body>
				
				<table align='center' style='width:100%'>
					<tr>
						<td colspan='3'align='left'>
							<b>INFORME TIEMPOS POR MECANICO</b>  
														".($fechaActual["year"].
														"/". $fechaActual["mon"]. 
														"/". (intval($fechaActual["mday"]) - 1).
														" ". $fechaActual["hours"].
														":". $fechaActual["minutes"])."
						</td>
					</tr>
					<tr>
						<td>
						".$documento."
						</td>
						
						<td>
						".$nombre."
						</td>
						
						<td>
						".$apellido."
						</td>
						
					</tr>						
				</table>";
		
		$body = "<table style='width:100%;'>
					<thead>
						<tr>
							<th>Fecha de Actividad</th>
							<th>Kilometraje</th>
							<th>Placa</th>
							<th>Orden Trabajo</th>
							<th>Actividad</th>
							<th>Tiempo</th>
							<th>Valor</th>
						</tr>
					</thead>
					<tbody>";
		
		while(!$data->EOF)
		{        
			$body = $body."<tr>";
			
			$fecha = $data->fields[0];
			$body = $body."<td>".$fecha."</td>";			
			
			$kilometraje = $data->fields[1];
			$body = $body."<td>".$kilometraje."</td>";
			
			$placas = $data->fields[2];
			$body = $body."<td>".$placas."</td>";
			
			$id_orden = $data->fields[3];
			$body = $body."<td>".$id_orden."</td>";
			
			$actividad = $data->fields[4];
			$body = $body."<td>".$actividad."</td>";
			
			$tiempo = $data->fields[5];
			$body = $body."<td>".$tiempo."</td>";
			
			$valor = $data->fields[6];
			$body = $body."<td>".$valor."</td>";
			
			$body = $body."</tr>";			
			$data->MoveNext();
		}  
			
		$body = $body."<tr>
				<td>
				</td>
				
				<td>
				</td>
				
				<td>
				</td>
				
				<td>
				</td>
				
				<td>
				</td>
				
				<td>
				".$tiempoF."
				</td>
				
				<td>
				".$valorF."
				</td>
			</tr>";		
					
		$body = $body."</tbody>";
		$body = $body."</table>";
		
		$body = $head."<br />".$body;
		
		$body = $body."</body></html>";
		
		return $body;
	}
	
	function ListadoInformes()
	{
		?>
		<button type="button" class="btn btn-primary" onclick="formularioInformeTiempoMecanico()">Informe Tiempo Mecanico</button>
                            
		<?php
	}
}
	?>