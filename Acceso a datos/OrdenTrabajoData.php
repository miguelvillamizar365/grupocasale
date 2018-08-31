<?php

/*
*
*Clase para conectarse con la base de datos,  
*autor Miguel Villamizar
*fecha 25/03/2017
*
*
*/


class OrdenTrabajoData{


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
	
	public function consultarVehiculo()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
		SELECT Id, 
			Placas, 
			Marca, 
			Linea, 
			Modelo, 
			Kilometraje, 
			Propietario, 
			DocumentoPropietario, 
			NumeroMotor, 
			NumeroChasis, 
			Soat, 
			VencimientoSoat, 
			Tecnomecanica, 
			vencimientoTecnomecanica, 
			fotovehiculo	 
		FROM vehiculo "; 
                
        $recordSet = $conexion->Ejecutar($cadena);        
        $conexion->Close();		
        return $recordSet; 
	}
	
	public function consultarConductor()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "                    
					SELECT u.Id, u.Nombre, u.Apellido
					FROM usuario u INNER JOIN rol r
					ON u.Id_Rol = r.Id
					WHERE r.Id = 4
					"; 
                
        $recordSet = $conexion->Ejecutar($cadena);        
        $conexion->Close();		
        return $recordSet; 
	}
	
	public function consultarMedico()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "                    
				SELECT u.Id, u.Nombre, u.Apellido
				FROM usuario u INNER JOIN rol r
				ON u.Id_Rol = r.Id
				WHERE r.Id = 5
                "; 
                
        $recordSet = $conexion->Ejecutar($cadena);        
        $conexion->Close();		
        return $recordSet; 
	}

	public function guardarOrden($Placa, $fecha, $Kilometraje, $id_mecanico, $id_conductor, $Observaciones)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				INSERT INTO ordentrabajo
				(id_vehiculo, fecha, Kilometraje, id_mecanico, id_conductor, Observaciones, Estado)
				VALUES (?, ?, ?, ?, ?, ?, 1)
				";
        
        $arr = array($Placa, $fecha, $Kilometraje, $id_mecanico, $id_conductor, $Observaciones);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
		echo $conexion->ObtenerError() ;
        if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            return "";   
        }
        $conexion -> Close();   
	}			
	
	public function EditarGuardarOrden($Placa, $fecha, $Kilometraje, $id_mecanico, $id_conductor, $Observaciones, $numeroOrden)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				UPDATE ordentrabajo SET
				id_vehiculo = ?, 
				Fecha = ?, 
				Kilometraje = ?, 
				id_mecanico = ?,
				id_conductor = ?,
				Observaciones = ?
				WHERE Id = ? ";
        
        $arr = array($Placa, $fecha, $Kilometraje, $id_mecanico, $id_conductor, $Observaciones, $numeroOrden);
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
	
	
	public function ObtenerReferenciaOrdenes($id_ordentrabajo)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "    				
		
			SELECT rot.Id,
				r.Codigo,
				r.Nombre referencia,
				rot.id_empaque,
				te.Descripcion empaque,
				rot.cantidad cantidad,
				rot.valorunitario,
				rot.valortotal,
				rot.Utilidad,
				rot.ValorTotalUtilidad,
				ot.Estado EstadoId,
				(CASE WHEN ot.Estado = 1 THEN 
						'Sin Autorizar'
					  WHEN ot.Estado = 0 THEN
						'Eliminada'
					  WHEN ot.Estado = 2 THEN
						'Autorizado' 
				END) AS Estado
			FROM referenciaordentrabajo rot 
			INNER JOIN referencia r 
				ON rot.id_referencia = r.id
			INNER JOIN tipoempaque te
				ON te.id = rot.id_empaque
			INNER JOIN ordentrabajo ot
				ON ot.id = rot.Id_ordentrabajo
			WHERE rot.Id_ordentrabajo = ? "; 
        $arr = array($id_ordentrabajo);
        $recordSet = $conexion->EjecutarP($cadena, $arr);        
        $conexion->Close();		
		
        return $recordSet; 
	}
	
	
	public function ValidarCantidadReferencia($id_referencia)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
		SELECT COUNT(*)
		FROM referencia r 
		INNER JOIN referenciafactura rf
			ON r.Id = rf.Id_referencia
		INNER JOIN factura f
			ON rf.Id_factura = f.Id
		WHERE r.Estado = 1
		AND (r.codigo LIKE CONCAT('%', ? ,'%')  OR r.Nombre LIKE CONCAT('%', ? ,'%'))"; 
		 
        $arr = array($id_referencia, $id_referencia);
        $recordSet = $conexion->EjecutarP($cadena, $arr);        
        
		
		$CantidadRef = 0;        
		while(!$recordSet->EOF)
		{        
			$CantidadRef=$recordSet->fields[0];
			$recordSet->MoveNext();
		}   
		$conexion->Close();	
		
		return $CantidadRef; 
	}
	
		
	public function ObtenerReferencias($id_referencia)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
		SELECT r.Id,
		r.Codigo,
		r.Nombre,
		r.id_tipoempaque,
		(SELECT te.Descripcion FROM tipoempaque te WHERE id = r.id_tipoempaque) tipoempaque,
		i.CantidadActual Cantidad,
		CAST(rf.ValorUnitario AS UNSIGNED) ValorUnitario
		 FROM referencia r 
			INNER JOIN referenciafactura rf
				ON r.Id = rf.Id_referencia
			INNER JOIN factura f
				ON rf.Id_factura = f.Id
			INNER JOIN inventario i 
				ON r.Id = i.Id_referencia
		 WHERE r.Estado = 1
		 AND f.Estado = 2
		 AND (r.codigo LIKE CONCAT('%', ? ,'%') OR r.Nombre LIKE CONCAT('%', ? ,'%'))
		 GROUP BY r.Id,
		r.Codigo,
		r.Nombre,
		r.id_tipoempaque,
		i.CantidadActual;"; 
		 
        $arr = array( $id_referencia, $id_referencia);
        $recordSet = $conexion->EjecutarP($cadena, $arr);        
        $conexion->Close();		
		
        return $recordSet; 
	}
	
	public function GuardarReferencias($id_referencia, $Id_ordentrabajo, $Id_empaque, $cantidad, $ValorUnitario, $ValorTotal, $utilidad, $ValorTotalUtilidad)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				CALL SP_GuardaReferenciaOrdenTrabajo( ?, 
								?,
								?, 
								?, 
								?, 
								?,
								?,
								?);
				";
        
        $arr = array($id_referencia, $Id_ordentrabajo, $Id_empaque, $cantidad, $ValorUnitario, $ValorTotal, $utilidad, $ValorTotalUtilidad);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        
		echo $conexion->ObtenerError();
        if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            return "";   
        }
        $conexion -> Close();
	}
		
	public function ObtenerActividades($id_orden)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
		SELECT 	aot.Id, 
			aot.Id_actividad,
			(SELECT a.Nombre FROM Actividad a WHERE a.id = aot.Id_actividad) actividad, 
			aot.Id_mecanico,
			(SELECT u.Nombre FROM usuario u WHERE u.id = aot.Id_mecanico ) mecanico, 
			aot.Tiempo, 
			(aot.Valor) Valor, 
			aot.Utilidad, 
			aot.ValorTotalUtilidad,
			DATE_FORMAT(aot.Fecha, '%Y/%m/%d %H:%i') Fecha,				
			aot.Observaciones,
			ot.Estado EstadoId,
			(CASE WHEN ot.Estado = 1 THEN 
				'Sin Autorizar'
				  WHEN ot.Estado = 0 THEN
					'Eliminada'
				  WHEN ot.Estado = 2 THEN
				'Autorizado' 
			END) AS Estado
		FROM actividadordentrabajo aot
		INNER JOIN ordentrabajo ot
			ON aot.id_ordentrabajo = ot.Id
			WHERE aot.id_ordentrabajo = ?"; 
		 
        $arr = array($id_orden);
        $recordSet = $conexion->EjecutarP($cadena, $arr);        
        $conexion->Close();		
		
        return $recordSet; 
	}
	
	public function consultarActividad()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "                    
				SELECT id, Nombre, Tiempo FROM actividad;
                "; 
                
        $recordSet = $conexion->Ejecutar($cadena);        
        $conexion->Close();		
        return $recordSet; 
	}
	
	
	public function consultaTiempoActividad($actividadId)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "                    
				SELECT Tiempo FROM actividad
				where id = ?;
                "; 
                
		$arr = array($actividadId);
        $recordSet = $conexion->EjecutarP($cadena, $arr);  

		$tiempo = 0;        
		while(!$recordSet->EOF)
		{        
			$tiempo=$recordSet->fields[0];
			$recordSet->MoveNext();
		}   
		
        $conexion->Close();		
        return $tiempo; 
	}
	
	
	public function GuardarActividades($Id_actividad, $id_mecanico, $Tiempo, $Valor, $Fecha, $Id_ordentrabajo, $Observaciones, $utilidad, $valorTotalUtilidad)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				INSERT INTO actividadordentrabajo
				(Id_actividad, id_mecanico, Tiempo, Valor, Fecha, Id_ordentrabajo, Observaciones, Utilidad, ValorTotalUtilidad)
				VALUES (?, ?, ? ,? ,? ,?, ?, ?, ?) ";
        
        $arr = array($Id_actividad, $id_mecanico, $Tiempo, $Valor, $Fecha, $Id_ordentrabajo, $Observaciones, $utilidad, $valorTotalUtilidad);
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

	
	public function EliminarReferenciasOrden($Id_referenciaOrden)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				DELETE FROM referenciaordentrabajo
				WHERE Id = ? ";
        
        $arr = array($Id_referenciaOrden);
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
	
	public function EliminarActividades($Id_actividadOrden)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				DELETE FROM actividadordentrabajo
				WHERE Id = ? ";
        
        $arr = array($Id_actividadOrden);
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
	
	
	
	public function GuardarEditarActividades($Id, $Id_actividad, $id_mecanico, $Tiempo, $Valor, $Fecha, $Observaciones, $utilidad, $valorTotalUtilidad)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				UPDATE actividadordentrabajo SET
				Id_actividad = ?,
				id_mecanico = ?, 
				Tiempo = ?, 
				Valor = ?, 
				Fecha = ?,  
				Observaciones = ?, 
				Utilidad = ?, 
				ValorTotalUtilidad = ?
				WHERE Id = ?";
        
        $arr = array($Id_actividad, $id_mecanico, $Tiempo, $Valor, $Fecha, $Observaciones, $utilidad, $valorTotalUtilidad, $Id);
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