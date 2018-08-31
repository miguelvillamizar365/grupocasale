<?php

/**
 * 
 * manejo de la presentación de autorizacion de facturas
 * @author Miguel Villamizar 
 * @copyright 16/07/2018
 */

class AutorizaFactura
{
    function mostrarFacturas()
    {
		header('Content-Type:text/html; charset=iso-8859-1');
        ?>                
        <input type="hidden" id="id_factura" name="id_factura" value="" /> 
        <div class="content-wrapper" style="width: 80% !important;">
            <h3 class="text-primary mb-4">Autoriza Facturas</h3>
            
			<form id="ExportarInformeFactura" action="../Logica de presentacion/AutorizaFactura_Logica.php" method="post" target="_blank" >
			
				
			<input type="hidden" id="desea" name="desea" value="ImprimirInformeFactura" /> 
			<input type="hidden" id="NumeroFactura" name="NumeroFactura" value="" /> 
			<input type="hidden" id="empresaId" name="empresaId" value="" /> 
			<input type="hidden" id="EmpresaCompra" name="EmpresaCompra" value="" /> 
			<input type="hidden" id="ValorFactura" name="ValorFactura" value="" /> 
			<input type="hidden" id="proveedorId" name="proveedorId" value="" /> 
			<input type="hidden" id="proveedor" name="proveedor" value="" /> 
			<input type="hidden" id="modopagoId" name="modopagoId" value="" /> 
			<input type="hidden" id="modopago" name="modopago" value="" /> 
			<input type="hidden" id="Fecha" name="Fecha" value="" /> 
			
				<div class="row mb-2">
					<div class="col-lg-12">
						
						<div class="card">
							<div class="card-block">
								
								<table id="table_facturas" class="cell-border display" cellspacing="0"></table>
								
							</div>
						</div>
					</div>                    
				</div>     
			</form>     			
        </div>   
        
        <div class="modal fade" id="mensajeConfirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mensaje de aplicación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div id="mensajeConf">
                
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button onclick="eliminarFactura()" type="button" class="btn btn-primary" >Aceptar</button>
              </div>
            </div>
          </div>
        </div>   
        <?php
    }  
	
	function exportarInformeFacturaPdf($NumeroFactura, 
	$EmpresaCompra, 
	$ValorFactura, 
	$proveedor, 
	$modopago, 
	$Fecha, 
	$informeEmpresa, 
	$informeData)
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
					<tr align='left'>
						<td colspan='8' align='left'>
							<img height='50' width='130' src='../images/logo_centro2.jpg'>
						</td>
					</tr>
					<tr>
						<td colspan='4' align='left'>
							<b>INFORME FACTURA</b>  
														".($fechaActual["year"].
														"/". $fechaActual["mon"]. 
														"/". (intval($fechaActual["mday"])-1))."
						</td>		
						
						<td colspan='2'>						
							<b>FACTURA NO. </b> 
						</td>	
						<td colspan='2' style='color:red;'>						
							 ".$NumeroFactura."
						</td>	
					</tr>
					<tr>
						<td>
						<b>CLIENTE</b>
						</td>
						
						<td colspan='3'>
						".$EmpresaCompra."
						</td>	

						<td colspan='4'>						
							<b>POR CONCEPTO DE </b>
						</td>	
					</tr>	
					<tr>
						<td>
						<b>NIT</b>
						</td>
						
						<td colspan='3'>
						".$informeEmpresa[0]."
						</td>
						
						<td colspan='4'>						
							Factura de compra 
						</td>	
					</tr>
					<tr>
						<td colspan='2'>
						<b>DIRECCIÓN</b>
						</td>
						
						<td >
						<b>CIUDAD</b>
						</td>
						
						<td >
						<b>TELÉFONO</b>
						</td>
											
						<td colspan='4'>	
						<b>VENDEDOR</b>					
						</td>	
					</tr>
					<tr>
						<td colspan='2'>
						".$informeEmpresa[3]."
						</td>
						
						<td >
						".$informeEmpresa[5]."
						</td>
						
						<td >
						".$informeEmpresa[4]."
						</td>
									
						<td colspan='4'>
						".$proveedor."						
						</td>	
					</tr>					
					<tr>
						<td colspan='4'>			
						<b>FECHA FACTURA</b>
						</td>
			
						<td colspan='4'>			
						<b>FORMA DE PAGO</b>					
						</td>							
					</tr>			
					<tr>
						<td colspan='4'>						
						".$Fecha."
						</td>	
			
						<td colspan='4'>	
						".$modopago."
						</td>							
					</tr>							
				</table>";
		
		$body = "<table style='width:100%;'>
					<thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Tipo Empaque</th>
							<th>Cantidad</th>
							<th>ValorUnitario</th>
							<th>Descuento</th>
							<th>Iva</th>
							<th>Valor Total</th>
						</tr>
					</thead>
					<tbody>";
		
		$descuentoTot =0;
		while(!$informeData->EOF)
		{        
			$body = $body."<tr>";
			
			$codigo = $informeData->fields[0];
			$body = $body."<td>".$codigo."</td>";			
			
			$Nombre = $informeData->fields[1];
			$body = $body."<td>".$Nombre."</td>";
			
			$TipoEmpaque = $informeData->fields[2];
			$body = $body."<td>".$TipoEmpaque."</td>";
			
			$Cantidad = $informeData->fields[3];
			$body = $body."<td>".$Cantidad."</td>";
			
			$ValorUnitario = $informeData->fields[4];
			$body = $body."<td>".$ValorUnitario."</td>";
			
			$descuento = $informeData->fields[5];
			$body = $body."<td>".$descuento."</td>";
						
			$Iva = $informeData->fields[6];
			$body = $body."<td>".$Iva."</td>";
			
			$ValorTotal = $informeData->fields[7];
			$body = $body."<td>".$ValorTotal."</td>";
			
			$body = $body."</tr>";			
			$informeData->MoveNext();
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
				</td>
				
				<td>
				".$ValorFactura."
				</td>
			</tr>";		
					
		$body = $body."</tbody>";
		$body = $body."</table>";
		
		$body = $head."<br />".$body;
		
		$body = $body."</body></html>";
		
		return $body;
	}
	
}
?>