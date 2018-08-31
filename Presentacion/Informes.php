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
			
			<div class="content-wrapper" style="width: 100% !important;">
				<h3 class="text-primary mb-4">INFORME TIEMPOS POR MECANICO</h3>
				
				<div class="row mb-2">
					<div class="col-lg-12">
						
						<div class="card">
							<div class="card-block" style="width: 75% !important;">
								
								<table id="table_tiempoMecanico" class="cell-border display" cellspacing="0"></table>
								
							</div>
						</div>
					</div>                    
				</div>               
			</div> 
		</form> 
		
		<script>
				
		$(document).ready(function(){
			$('#table_tiempoMecanico').DataTable({
				
				language: { url: '../datatables/Spanish.json' },
				data: null,
				scrollX: true,
				columns: [
					{ 
						title: "Imprimir",
						targets: -1,
						render: function (data, type, row) {
							return "<button class='A_imprimir btn btn-primary' >Imprimir</button>";							                   
						}
					},					
					{ data: "Documento",    title: "Documento",   },
					{ data: "Nombre",    title: "Nombre",   },
					{ data: "Apellido",    title: "Apellido"},
					{ data: "tiempo",    title: "Tiempo"},
					{ 
						data: "valor",
						title: "Valor",
						mRender: function (data, type, full) {
						  
							var number = data,
							thousand_separator = ',',
							decimal_separator = '.';

							var	number_string = number.toString(),
							split  = number_string.split(decimal_separator),
							result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
									
							if(split[1] != "")
							{
								result = split[1] != undefined ? result + decimal_separator + split[1] : result;
							}
							return result;
						}
					}
				]
			});
			
			$.ajax({
				url: '../Logica de presentacion/Informes_Logica.php',
				type:  'post',
				dataType:'json',
				data: {'desea': 'cargaInformeTiemposMecanico'},
				success:  function (data) {
					 
					$('#table_tiempoMecanico').DataTable().clear().draw().rows.add(data).draw();
					
				},
				error: function(ex){
					console.log(ex);
				}
			});  
		});

		$('#table_tiempoMecanico').on('click', 'td .A_imprimir', function (e) {
					
			e.preventDefault();
			
			var table = $('#table_tiempoMecanico').DataTable();
			var dataItem = table.row($(this).closest('tr')).data();        
			
			$("#Documento").val(dataItem.Documento);
			$("#Nombre").val(dataItem.Nombre);
			$("#Apellido").val(dataItem.Apellido);
			$("#Tiempo").val(dataItem.tiempo);
			$("#Valor").val(dataItem.valor);
			
			$("#ExportarInformeTiempoMecanico").submit();
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
							<th>Fecha</th>
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