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
					o.Placa,
					DATE_FORMAT(o.Fecha, '%d/%m/%Y') Fecha,
					o.Kilometraje, 
					meca.Id id_mecanico,
					meca.Nombre mecanico,
					con.id id_conductor,
					con.Nombre conductor,
					o.Observaciones
					FROM ordentrabajo o 
					LEFT JOIN usuario meca
					ON o.id_mecanico = meca.id 
					LEFT JOIN usuario con
					ON o.id_conductor = con.id 
                "; 
                
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
				(Placa, fecha, Kilometraje, id_mecanico, id_conductor, Observaciones)
				VALUES (?, ?, ?, ?, ?, ?)
				";
        
        $arr = array($Placa, $fecha, $Kilometraje, $id_mecanico, $id_conductor, $Observaciones);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        
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
				Placa = ?, 
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
				rot.id_referencia,
				r.Nombre referencia,
				rot.id_empaque,
				te.Descripcion empaque,
				i.cantidadActual cantidad,
				rot.valorunitario,
				rot.valortotal
			FROM referenciaordentrabajo rot 
			INNER JOIN referencia r 
				ON rot.id_referencia = r.id
			INNER JOIN tipoempaque te
				ON te.id = rot.id_empaque
			INNER JOIN inventario i
				ON i.id_referencia = rot.id_referencia
			WHERE rot.Id_ordentrabajo = ?
                "; 
        $arr = array($id_ordentrabajo);
        $recordSet = $conexion->EjecutarP($cadena, $arr);        
        $conexion->Close();		
		
        return $recordSet; 
	}
	
	
	public function ValidarReferencia($id_referencia)
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
		 AND f.Estado = 1
		 AND r.Id  = ?"; 
		 
        $arr = array($id_referencia);
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
		
        $cadena = " SELECT r.Id,
		r.Nombre,
		rf.id_tipoempaque,
		(SELECT te.Descripcion FROM tipoempaque te WHERE id = rf.id_tipoempaque) tipoempaque,
		rf.Cantidad,
		CAST(rf.ValorUnitario AS UNSIGNED) ValorUnitario
		 FROM referencia r 
			INNER JOIN referenciafactura rf
				ON r.Id = rf.Id_referencia
			INNER JOIN factura f
				ON rf.Id_factura = f.Id
		 WHERE r.Estado = 1
		 AND f.Estado = 1
		 AND r.Id = ?"; 
		 
        $arr = array($id_referencia);
        $recordSet = $conexion->EjecutarP($cadena, $arr);        
        $conexion->Close();		
		
        return $recordSet; 
	}
	
	public function GuardarReferencias($id_referencia, $Id_ordentrabajo, $Id_empaque, $cantidad, $ValorUnitario, $ValorTotal)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "
				INSERT INTO referenciaordentrabajo
				(id_referencia, Id_ordentrabajo, Id_empaque, cantidad, ValorUnitario, ValorTotal)
				VALUES (?,?,?,?,?,?)
				";
        
        $arr = array($id_referencia, $Id_ordentrabajo, $Id_empaque, $cantidad, $ValorUnitario, $ValorTotal);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        
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
	
	public function ModificarInventario($id_referencia, $cantidad)
	{
		global $conexion;
        $conexion ->conectarAdo();
		
        $cadena = "                 
			SELECT CantidadUsada,
			ValorTotalUsado,
			CantidadActual,
			ValorTotalActual,
			ValorUnitario
			FROM inventario
			WHERE id_referencia = ? "; 
                
        $arr = ($id_referencia);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        
        if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            $CantidadUsada = 0;
			$ValorTotalUsado = 0;
			$CantidadActual = 0;
			$ValorTotalActual = 0;
			$ValorUnitario = 0;
            $i=0;
            
            while(!$recordSet->EOF)
            {        
                $CantidadUsada = $recordSet->fields[0];
                $ValorTotalUsado = $recordSet->fields[1];
                $CantidadActual = $recordSet->fields[2];
                $ValorTotalActual = $recordSet->fields[3];
                $ValorUnitario = $recordSet->fields[4];
                $recordSet->MoveNext();
                $i++;
            }       
		
			
			$cadena = "
					UPDATE inventario SET
					CantidadActual = ?,
					ValorTotalActual = ?,
					CantidadUsada = ?,
					ValorTotalUsado = ?
					WHERE id_referencia = ? ";
			
			$arr = array(($CantidadActual - $cantidad),  //CantidadActual
						(($CantidadActual - $cantidad) * $ValorUnitario), //ValorTotalActual
						($CantidadUsada + $cantidad), //CantidadUsada
						(($CantidadUsada + $cantidad) * $ValorUnitario), //ValorTotalUsado
						$id_referencia);
			$recordSet = $conexion->EjecutarP($cadena, $arr);
			
			
			if($conexion->ObtenerError() != "" )
			{
				return $conexion->ObtenerError();
			}
			else
			{
				return "";   
			}
		}
        $conexion -> Close();
	}
}
?>