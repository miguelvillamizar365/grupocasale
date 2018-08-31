	<?php 

/*
*
*manejo de la presentacion de la orden de salida
*@autor Miguel Villamizar
*@copyrigth 16/07/2018
*
*/

class OrdenSalida
{
	function mostrarOrdenTrabajo()
	{
		?> 
        <meta charset="iso-8859-1" />   
		<form id="ExportarInformeOrdenTrabajo" action="../Logica de presentacion/OrdenSalida_Logica.php" method="post" target="_blank" >
				
			<input type="hidden" id="desea" name="desea" value="ExportarInformeOrdenTrabajo" /> 
			<input type="hidden" id="id_orden" name="id_orden" value="" /> 
			<input type="hidden" id="Placas" name="Placas" value="" /> 
			<input type="hidden" id="Fecha" name="Fecha" value="" /> 
			<input type="hidden" id="ValorTotalReferencia" name="ValorTotalReferencia" value="" /> 
			<input type="hidden" id="ValorTotalUtilidadReferencia" name="ValorTotalUtilidadReferencia" value="" /> 
			<input type="hidden" id="ValorTotalActividad" name="ValorTotalActividad" value="" /> 
			<input type="hidden" id="ValorTotalUtilidadActividad" name="ValorTotalUtilidadActividad" value="" /> 
			<input type="hidden" id="Kilometraje" name="Kilometraje" value="" /> 
			<input type="hidden" id="mecanico" name="mecanico" value="" /> 
			<input type="hidden" id="conductor" name="conductor" value="" /> 
			<input type="hidden" id="Observaciones" name="Observaciones" value="" /> 
			<input type="hidden" id="id_ordenUtilidad" name="id_ordenUtilidad" value="" /> 
			
			<div class="content-wrapper" style="width: 60% !important;">
				<h3 class="text-primary mb-4">Ordenes de Salida</h3>
				
				<div class="row mb-2">
					<div class="col-lg-12">
						
						<div class="card">
							<div class="card-block">
								
								<table id="table_OrdenesAll" class="cell-border display" cellspacing="0"></table>
								
							</div>
						</div>
					</div>                    
				</div>               
			</div>  
		</form>		
		<script>
		
	$('#table_OrdenesAll').DataTable({
		
		language: { url: '../datatables/Spanish.json' },
		data: null,
		scrollX: true,
		columns: [
			{ 
				title: "Autorizar",
				targets: -1,
				render: function (data, type, row) {
					
					if(row.EstadoId == 1)
					{
						return "<button class='A_autorizar btn btn-primary'>Autorizar</button>";
					}
					else{
						return "";
					}
				}
			},
			{ 
				title: "Imprimir",
				targets: -1,
				render: function (data, type, row) {
					return "<button class='A_imprimir btn btn-secondary'>Imprimir</button>";
				}  
			},
			{ 
				title: "Imprimir con Utilidad",
				targets: 0,
				'render': function (data, type, full, meta){
					return '<input class="C_checkbox" type="radio" name="id[]" value="' + data + '">';
				 },
				'searchable': false,
				'orderable': false,
				'className': 'dt-body-center'
			},
			{ data: "Id",    title: "No. Orden Trabajo"},
			{ data: "id_vehiculo",    title: "id_vehiculo"},
			{ data: "Placas",    title: "Placa"},
			{ data: "Fecha",    title: "Fecha"},
			{ 
				data: "ValorTotalReferencia",
				title: "Valor Total Referencia",
				mRender: function (data, type, full) {
					  
						var number = data.replace(",", ""),
						thousand_separator = ',',
						decimal_separator = '.';

						var	number_string = number.toString(),
						split	  = number_string.split(decimal_separator),
						result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
						if(split[1] != "")
						{
							result = split[1] != undefined ? result + decimal_separator + split[1] : result;
						}

						return result;
					}
			},
			{ 
				data: "ValorTotalUtilidadReferencia",
				title: "Valor Total Utilidad Referencia",
				mRender: function (data, type, full) {
					  
						var number = data.replace(",", ""),
						thousand_separator = ',',
						decimal_separator = '.';

						var	number_string = number.toString(),
						split	  = number_string.split(decimal_separator),
						result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
						if(split[1] != "")
						{
							result = split[1] != undefined ? result + decimal_separator + split[1] : result;
						}

						return result;
					}
			},
			{ 
				data: "ValorTotalActividad",
				title: "Valor Total Actividad",
				mRender: function (data, type, full) {
					  
						var number = data.replace(",", ""),
						thousand_separator = ',',
						decimal_separator = '.';

						var	number_string = number.toString(),
						split	  = number_string.split(decimal_separator),
						result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
						if(split[1] != "")
						{
							result = split[1] != undefined ? result + decimal_separator + split[1] : result;
						}

						return result;
					}
			},
			{ 
				data: "ValorTotalUtilidadActividad",
				title: "ValorTotal Utilidad Actividad",
				mRender: function (data, type, full) {
					  
						var number = data.replace(",", ""),
						thousand_separator = ',',
						decimal_separator = '.';

						var	number_string = number.toString(),
						split	  = number_string.split(decimal_separator),
						result = split[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								
						if(split[1] != "")
						{
							result = split[1] != undefined ? result + decimal_separator + split[1] : result;
						}

						return result;
					}
			},
			{ 
				data: "Kilometraje",   
				title: "Kilometraje",
				mRender: function (data, type, full) {
				 var formmatedvalue = data.replace(/\D/g, "");
					formmatedvalue = formmatedvalue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				  return formmatedvalue;
				}
			},
			{ data: "id_mecanico", title: "Mecánico" },
			{ data: "mecanico", title: "Mecánico" },
			{ data: "id_conductor", title: "Conductor"},
			{ data: "conductor", title: "Conductor"},
			{ data: "Observaciones", title: "Observaciones"},
			{ data: "EstadoId", title: "EstadoId"},
			{ data: "Estado", title: "Estado"}
		],
		columnDefs: [
			{
				targets: [ 4 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 12 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 14 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 17 ],
				visible: false,
				searchable: false
			}
		]
	});
	
	$.ajax({
		url: '../Logica de presentacion/OrdenSalida_Logica.php',
		type:  'post',
		dataType:'json',
		data: {'desea': 'cargaOrdenes'},
		success:  function (data) {
			 
			$('#table_OrdenesAll').DataTable().clear().draw().rows.add(data).draw();
			
		},
		complete: function()
		{
			
		},
		error: function(ex){
			console.log(ex);
		}
	}); 
		</script>
		<?php
	}
	
	function exportarInformeOrdenTrabajo($id_orden, 
			$Placas, 
			$Fecha , 
			$ValorTotalReferencia, 
			$ValorTotalUtilidadReferencia, 
			$ValorTotalActividad , 
			$ValorTotalUtilidadActividad, 
			$Kilometraje, 
			$mecanico, 
			$conductor, 
			$Observaciones, 
			$informeDataReferencia, 
			$informeDataActividad,
			$id_ordenUtilidad)
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
				
				p {					
					letter-spacing: 1px;
					font-family: sans-serif;
					font-size: .8rem;
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
					<tr align='left'>
						<td colspan='5' align='left'>
							<img height='50' width='130' src='../images/logo_centro2.jpg'>
						</td>
					</tr>
					<tr>
						<td colspan='3'align='left'>
							<b>INFORME ORDEN DE SALIDA</b>  
														".($fechaActual["year"].
														"/". $fechaActual["mon"]. 
														"/". (intval($fechaActual["mday"])-1))."
						</td>
						<td>
							<b>ORDEN No.</b>  
						</td>
						<td  style='color:red;'>
							<b>".$id_orden."</b>  
						</td>
					</tr>		
					<tr>
						<td>
							<b>Placas</b>							
						</td>
						<td>
							<b>Fecha</b>
						</td>
						<td>
							<b>Kilometraje</b>
						</td>
						<td colspan='2'>
							<b>Mecánico</b>
						</td>
					</tr>	

					<tr>
						<td >
							".$Placas."
						</td>
						<td>
							".$Fecha."
						</td>
						<td>
							".$Kilometraje." 
						</td>
						<td colspan='2'>
							".$mecanico."
						</td>
					</tr>						
					<tr>
						<td colspan='2'>							
							<b>conductor<b>
						</td>
						<td colspan='3'align='left'>
							<b>Observaciones</b>
						</td>
					</tr>	
					<tr>
						<td colspan='2'>					
							".$conductor."
						</td>
						<td colspan='3'align='left'>
							".$Observaciones."
						</td>
					</tr>						
				</table>";
		
		$body = "<b>Detalle de Referencias</b>";
		
		if($id_ordenUtilidad == $id_orden)
		{			
			$body = $body."<table style='width:100%;'>
						<thead>
							<tr>
								<th>Código</th>
								<th>Referencia</th>
								<th>Empaque</th>
								<th>cantidad</th>
								<th>valor unitario</th>
								<th>Utilidad %</th>
								<th>Valor Total</th>
							</tr>
						</thead>
						<tbody>";
			
			$valorTotalUti =0;
			while(!$informeDataReferencia->EOF)
			{        
				$body = $body."<tr>";
				
				$Codigo = $informeDataReferencia->fields[0];
				$body = $body."<td>".$Codigo."</td>";			
				
				$referencia = $informeDataReferencia->fields[1];
				$body = $body."<td>".$referencia."</td>";
				
				$empaque = $informeDataReferencia->fields[2];
				$body = $body."<td>".$empaque."</td>";
				
				$cantidad = $informeDataReferencia->fields[3];
				$body = $body."<td>".$cantidad."</td>";
				
				$valorunitario = $informeDataReferencia->fields[4];
				$body = $body."<td>".number_format($valorunitario, 2,'.',',')."</td>";
								
				$Utilidad = $informeDataReferencia->fields[6];
				$body = $body."<td>".$Utilidad."</td>";
				
				$ValorTotalUtilidad = $informeDataReferencia->fields[7];
				$body = $body."<td>".number_format($ValorTotalUtilidad, 2,'.',',')."</td>";
				$valorTotalUti = $valorTotalUti + ($ValorTotalUtilidad);
				
				$body = $body."</tr>";			
				$informeDataReferencia->MoveNext();
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
					</td>
					
					<td>
					".number_format($valorTotalUti, 2,'.',',')."
					</td>
				</tr>";		
		}
		else{
				
			$body = $body."<table style='width:100%;'>
						<thead>
							<tr>
								<th>Código</th>
								<th>Referencia</th>
								<th>Empaque</th>
								<th>cantidad</th>
								<th>valor unitario</th>
								<th>valor total</th>
							</tr>
						</thead>
						<tbody>";
			
			 $valorTotalF =0;
			while(!$informeDataReferencia->EOF)
			{        
				$body = $body."<tr>";
				
				$Codigo = $informeDataReferencia->fields[0];
				$body = $body."<td>".$Codigo."</td>";			
				
				$referencia = $informeDataReferencia->fields[1];
				$body = $body."<td>".$referencia."</td>";
				
				$empaque = $informeDataReferencia->fields[2];
				$body = $body."<td>".$empaque."</td>";
				
				$cantidad = $informeDataReferencia->fields[3];
				$body = $body."<td>".$cantidad."</td>";
				
				$valorunitario = $informeDataReferencia->fields[4];
				$body = $body."<td>".number_format($valorunitario, 2,'.',',')."</td>";
				
				$valortotal = $informeDataReferencia->fields[5];
				$body = $body."<td>".number_format($valortotal, 2,'.',',')."</td>";
				$valorTotalF = $valorTotalF + $valortotal;
								
				$body = $body."</tr>";			
				$informeDataReferencia->MoveNext();
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
					".number_format($valorTotalF, 2,'.',',')."
					</td>					
				</tr>";
		}	
		
		$body = $body."</tbody>";
		$body = $body."</table>";
		
		$body = $body."<br />";
		
		$body = $body."<b>Detalle de Actividades</b>";
		
		if($id_ordenUtilidad == $id_orden)
		{				
			$body = $body."<table style='width:100%;'>
						<thead>
							<tr>
								<th>Actividad</th>
								<th>Mecánico</th>
								<th>Tiempo</th>
								<th>Utilidad %</th>
								<th>ValorTotal</th>
								<th>Fecha</th>
								<th>Observaciones</th>
							</tr>
						</thead>
						<tbody>";
			
			 $ValorTotalUtilidadF =0;
			while(!$informeDataActividad->EOF)
			{        
				$body = $body."<tr>";
				
				$actividad = $informeDataActividad->fields[0];
				$body = $body."<td>".$actividad."</td>";			
				
				$mecanico = $informeDataActividad->fields[1];
				$body = $body."<td>".$mecanico."</td>";
				
				$Tiempo = $informeDataActividad->fields[2];
				$body = $body."<td>".$Tiempo."</td>";
				
				
				$Utilidad = $informeDataActividad->fields[4];
				$body = $body."<td>".$Utilidad."</td>";
				
				$ValorTotalUtilidad = $informeDataActividad->fields[5];
				$body = $body."<td>".number_format($ValorTotalUtilidad, 2,'.',',')."</td>";
				$ValorTotalUtilidadF = $ValorTotalUtilidadF + $ValorTotalUtilidad;
								
				$Fecha = $informeDataActividad->fields[6];
				$body = $body."<td>".$Fecha."</td>";
				
				$Observaciones = $informeDataActividad->fields[7];
				$body = $body."<td>".$Observaciones."</td>";
								
				$body = $body."</tr>";			
				$informeDataActividad->MoveNext();
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
					".number_format($ValorTotalUtilidadF, 2,'.',',')."
					</td>
					
					<td>
					</td>
					
					<td>
					</td>
									
				</tr>";
		}
		else{
			$body = $body."<table style='width:100%;'>
						<thead>
							<tr>
								<th>Actividad</th>
								<th>Mecánico</th>
								<th>Tiempo</th>
								<th>Fecha</th>
								<th>Observaciones</th>
								<th>Valor</th>
							</tr>
						</thead>
						<tbody>";
			
			 $ValorTotalAF =0;
			while(!$informeDataActividad->EOF)
			{        
				$body = $body."<tr>";
				
				$actividad = $informeDataActividad->fields[0];
				$body = $body."<td>".$actividad."</td>";			
				
				$mecanico = $informeDataActividad->fields[1];
				$body = $body."<td>".$mecanico."</td>";
				
				$Tiempo = $informeDataActividad->fields[2];
				$body = $body."<td>".$Tiempo."</td>";
																
				$Fecha = $informeDataActividad->fields[6];
				$body = $body."<td>".$Fecha."</td>";
				
				$Observaciones = $informeDataActividad->fields[7];
				$body = $body."<td>".$Observaciones."</td>";			

				$ValorTotal = $informeDataActividad->fields[3];
				$body = $body."<td>".number_format($ValorTotal, 2,'.',',')."</td>";
				$ValorTotalAF = $ValorTotalAF + $ValorTotal;
				
				$body = $body."</tr>";			
				
				$informeDataActividad->MoveNext();
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
					".number_format($ValorTotalAF, 2,'.',',')."
					</td>					
				</tr>";
		}				
			
		$body = $body."</tbody>";
		$body = $body."</table>";
		
		$body = $body."<br />";
		
		
		if($id_ordenUtilidad == $id_orden)
		{			
			$body = $body."<table style='width:50%; text-align: center;'  align='right'>
							<thead>
							</thead>
							<tbody>
								<tr>
									<td>Total Referencia</td>
									<td>
									".number_format($valorTotalUti, 2,'.',',')."
									</td>
								</tr>
								<tr>		
									<td>Total Actividad</td>						
									<td>
									".number_format($ValorTotalUtilidadF, 2,'.',',')."
									</td>								
								</tr>
								<tr>
									<td><b>Valor Total</b></td>
									<td>
									<b>".number_format(($valorTotalUti + $ValorTotalUtilidadF), 2,'.',',')."</b>
									</td>
								</tr>
							</tbody>
						</table>";
		}
		else{
			
			$body = $body."<table style='width:50%; text-align: center;'  align='right'>
							<thead>
							</thead>
							<tbody>
								<tr>
									<td>
										Total Referencia
									</td>
									
									<td>
									".number_format($valorTotalF, 2,'.',',')."
									</td>								
								</tr>
								<tr>
									<td>
										Total Actividad
									</td>
									
									<td>
									".number_format($ValorTotalAF, 2,'.',',')."
									</td>								
								</tr>
								<tr>
									<td>
										<b>Valor Total</b>
									</td>
									
									<td>
									<b>".number_format(($valorTotalF + $ValorTotalAF), 2,'.',',')."</b>
									</td>								
								</tr>
							</tbody>
						</table>";			
		}	
		
		
		
		$body = $head."<br />".$body;
		
		$body = $body."</body></html>";
		
		return $body;
	}
}
?>