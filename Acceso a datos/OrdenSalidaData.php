<?php

/*
*
*Clase para conectarse con la base de datos,  
*autor Miguel Villamizar
*fecha 16/07/2018
*
*
*/

class OrdenSalidaData{


    public function Conectar()
    {
        global $conexion;
        include("AdoConnection.php");
        $conexion = new Ado();
    }  
    
	public function ObtenerOrdenes()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "     
					
			SELECT o.Id,
				o.id_vehiculo,
				v.Placas,
				DATE_FORMAT(o.Fecha, '%Y/%m/%d %H:%i') Fecha,
				(SELECT CASE 
					WHEN SUM(ro.ValorTotal) IS NULL THEN 0
					ELSE SUM(ro.ValorTotal)
					END
				FROM referenciaordentrabajo ro 
				WHERE ro.Id_ordentrabajo = o.Id) ValorTotalReferencia,
				(SELECT CASE
					WHEN SUM(ro.ValorTotalUtilidad) IS NULL THEN 0
					ELSE SUM(ro.ValorTotalUtilidad)
					END
				FROM referenciaordentrabajo ro 
				WHERE ro.Id_ordentrabajo = o.Id) ValorTotalUtilidadReferencia,
				(SELECT CASE
					WHEN SUM(ao.Valor) IS NULL THEN 0
					ELSE SUM(ao.Valor)
					END
				FROM actividadordentrabajo ao 
				WHERE ao.Id_ordentrabajo = o.Id) ValorTotalActividad,
				(SELECT CASE
					WHEN SUM(ao.ValorTotalUtilidad) IS NULL THEN 0
					ELSE SUM(ao.ValorTotalUtilidad)
					END
				FROM actividadordentrabajo ao 
				WHERE ao.Id_ordentrabajo = o.Id) ValorTotalUtilidadActividad,
				o.Kilometraje, 
				meca.Id id_mecanico,
				meca.Nombre mecanico,
				con.id id_conductor,
				con.Nombre conductor,
				o.Observaciones,
				o.Estado EstadoId,
				(CASE WHEN o.Estado = 1 THEN 
					'Sin Autorizar'
					  WHEN o.Estado = 0 THEN
						'Eliminada'
					  WHEN o.Estado = 2 THEN
					'Autorizado' 
				END) AS Estado
			FROM ordentrabajo o 
			LEFT JOIN usuario meca
				ON o.id_mecanico = meca.id 
			LEFT JOIN usuario con
				ON o.id_conductor = con.id 
			LEFT JOIN vehiculo v
				ON o.id_vehiculo = v.id ;
                "; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}
	
	public function AutorizarOrden($NumeroOrden)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				UPDATE ordentrabajo SET
				Estado = 2
				WHERE Id = ? ";
        
        $arr = array($NumeroOrden);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        
        if($conexion->ObtenerError() != "" )
        {
            return $conexion->ObtenerError();
        }
        else
        {
            return "";   
        }
        $conexion -> Close(); 
	}	
}
?>