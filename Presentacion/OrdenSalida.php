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
        <input type="hidden" id="id_orden" name="id_orden" value="" /> 
        <div class="content-wrapper" style="width: 80% !important;">
            <h3 class="text-primary mb-4">Ordenes de Salida</h3>
            
            <div class="row mb-2">
                <div class="col-lg-12">
                    
                    <div class="card">
                        <div class="card-block">
                            
                            <table id="table_OrdenesAll" class="display" cellspacing="0"></table>
							
                        </div>
                    </div>
                </div>                    
            </div>               
        </div>   
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
			{ data: "Id",    title: "No. Orden Trabajo"},
			{ data: "id_vehiculo",    title: "id_vehiculo"},
			{ data: "Placas",    title: "Placa"},
			{ data: "Fecha",    title: "Fecha"},
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
				targets: [ 3 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 7 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 9 ],
				visible: false,
				searchable: false
			},
			{
				targets: [ 12 ],
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
}
?>