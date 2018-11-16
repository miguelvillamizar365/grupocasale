<?php

/**
 * manejo de base de datos factura, consultas,
 * @author Miguel Villamizar Garcia
 * @copyright 09/12/2017
 */
 
 class facturaData
 {
    public function Conectar()
    {
        global $conexion;
        include("AdoConnection.php");
        $conexion = new Ado();
    }  
    
    public function consultarFactura()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "    
		
		SELECT 	f.Id NumeroFactura,
		ec.Id empresaId,
		ec.RazonSocial EmpresaCompra, 
		(SELECT CASE 
				WHEN SUM(rf.ValorTotal) IS NULL  THEN 0 
				ELSE SUM(rf.ValorTotal) 
			END
		 FROM referenciafactura rf
		 WHERE f.Id = rf.id_factura) ValorFactura,
		ep.Id proveedorId, 
		ep.RazonSocial proveedor, 
		mp.Id modopagoId,
		mp.Descripcion modopago , 
		DATE_FORMAT(f.Fecha, '%Y/%m/%d %H:%i') Fecha,
		f.Estado EstadoId, 
		(CASE WHEN f.Estado = 1 THEN 
				'Sin Autorizar'
				  WHEN f.Estado = 0 THEN
					'Eliminada'
				  WHEN f.Estado = 2 THEN
				'Autorizado' 
			END) AS Estado
		FROM 
		factura f 
		LEFT JOIN empresa ec
			ON f.Id_EmpresaCompra = ec.Id
			AND ec.Id_TipoEmpresa = 1		
		LEFT JOIN empresa ep
			ON f.Id_EmpresaProvee = ep.Id
			AND ep.Id_TipoEmpresa = 2
		LEFT JOIN modopago mp
			ON f.id_modopago = mp.Id
		WHERE ec.Estado = 1
		AND ep.Estado = 1
		AND mp.Estado = 1 "; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
		
    public function consultarFacturaFiltro($referencia, $fechaInicial, $fechaFinal)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "CALL SP_ConsultarFacturas(?, ?, ?)"; 
        
		$arr = array( $referencia, $fechaInicial, $fechaFinal);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
    public function validaFechas($fechaInicial, $fechaFinal)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena =		
		"
			SELECT STR_TO_DATE(?, '%Y/%m/%d') > STR_TO_DATE(?, '%Y/%m/%d');
		"; 
        
		$arr = array($fechaInicial, $fechaFinal);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        		
        $valida =0;
        $i=0;
        
        while(!$recordSet->EOF)
        {        
            $valida=$recordSet->fields[0];
            $recordSet->MoveNext();
            $i++;
        }       
        return $valida; 
	}
     
    public function consultarEmpresaCompra()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT id, RazonSocial
                    FROM empresa
                    WHERE Id_TipoEmpresa = 1
                    AND Estado = 1"; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}
    
    public function consultarProveedor()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT id, RazonSocial
                    FROM empresa
                    WHERE Id_TipoEmpresa = 2
                    AND Estado = 1"; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
    public function consultarModoPago()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT id, Descripcion 
                    FROM modopago
                    WHERE Estado = 1"; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
    public function guardarFactura($Id_EmpresaCompra, $Id_EmpresaProvee, $id_modopago, $fecha, $Estado)
    {
        global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "INSERT INTO factura
                (Id_EmpresaCompra, Id_EmpresaProvee, id_modopago, fecha, Estado)
                VALUES (?, ?, ?, ?, ?);";
        
        $arr = array($Id_EmpresaCompra, $Id_EmpresaProvee, $id_modopago, $fecha, $Estado);
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
		
    public function editarFactura($IdFactura, $Id_EmpresaCompra, $Id_EmpresaProvee, $id_modopago, $fecha)
    {
        global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "UPDATE factura SET
                Id_EmpresaCompra = ?, 
				Id_EmpresaProvee = ? , 
				id_modopago = ?, 
				fecha = ?
				WHERE Id = ?";
        
        $arr = array($Id_EmpresaCompra, $Id_EmpresaProvee, $id_modopago, $fecha, $IdFactura);
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
    
    public function comparaFechaActual($fecha)
    {
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
                SELECT CASE WHEN (? < CURRENT_DATE ) 
                     THEN 'MENOR'
                     ELSE 'MAYOR'
                END AS texto "; 
                
        $arr = ($fecha);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
		$conexion -> Close();
        
        if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            $fecha = array();
            $i=0;
            
            while(!$recordSet->EOF)
            {        
                $fecha = $recordSet->fields[0];
                $recordSet->MoveNext();
                $i++;
            }       
            return $fecha;         
        }
    }
    
    public function validaFacturaReferencias($id_factura)
    {
        global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT COUNT(*) numero 
                    FROM referenciafactura
                    WHERE Id_factura = ?"; 
                
        $arr = ($id_factura);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
		$conexion -> Close();        
        return $recordSet;
    }     
    
    
    public function eliminaFactura($id_factura)
    {
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " UPDATE factura SET estado = 0 WHERE id = ? "; 
                
        $arr = ($id_factura);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
		$conexion -> Close();
        
        if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            return "";
        }
    }
    
    
    public function consultarReferenciasFactura($id_factura)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "   
				SELECT 
					rf.Id,
					r.codigo, 
					f.id facturaId, 
					r.Nombre,
					te.Id TipoEmpaqueId,
				te.descripcion TipoEmpaque,
				rf.cantidad,
				CAST(rf.valorunitario AS UNSIGNED) valorunitario,
				rf.descuento,
				rf.iva, 
				CAST(rf.valortotal AS UNSIGNED) valortotal,
					CASE WHEN ( rf.asumeiva = 1 ) 
							THEN 'Si'
							ELSE 'No'
						END asumeiva,
				f.Estado EstadoId, 
				(CASE WHEN f.Estado = 1 THEN 
						'Sin Autorizar'
						  WHEN f.Estado = 0 THEN
							'Eliminada'
						  WHEN f.Estado = 2 THEN
						'Autorizado' 
					END) AS Estado
				FROM referenciafactura rf 
				INNER JOIN factura f
				ON rf.id_factura = f.id
				INNER JOIN referencia r
				ON rf.id_referencia = r.id
				INNER JOIN tipoempaque te 
				ON te.id = rf.id_tipoempaque
				WHERE f.id = ?
				ORDER BY rf.id ASC
			"; 
				
        $arr = ($id_factura);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
	
	
    public function consultarReferencia($id_factura)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "      
                
            SELECT rf.id_referencia, 
            	r.Nombre,
            	te.descripcion TipoEmpaque,
            	rf.cantidad,
            	rf.valorunitario,
            	rf.descuento,
            	rf.iva, 
            	rf.Utilidad,
            	rf.valortotal,
				rf.asumeiva
            FROM referenciafactura rf 
            	INNER JOIN factura f
            		ON rf.id_factura = f.id
            	INNER JOIN referencia r
            		ON rf.id_referencia = r.id
            	INNER JOIN tipoempaque te 
            		ON te.id = rf.id_tipoempaque
            WHERE f.id = ?
            AND r.estado = 1
            AND f.estado = 1
                    
                "; 
        
        $arr = ($id_factura);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
	
	public function ConsultarReferencias()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "      		
				SELECT Id, 
				CONCAT(codigo,' - ', nombre) nombre 
				FROM referencia 
				WHERE Estado = 1
				ORDER BY nombre ASC
                "; 
        
        $recordSet = $conexion->Ejecutar($cadena);        
        $conexion->Close();		
        return $recordSet; 
	}	
	
	public function ConsultarTipoEmpaque()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "    
					SELECT 
					id, 
					Descripcion 
					FROM tipoempaque
					WHERE Estado = 1
					ORDER BY Descripcion ASC
                "; 
        
        $recordSet = $conexion->Ejecutar($cadena);        
        $conexion->Close();		
        return $recordSet; 
	}
	
	public function GuardaReferenciaFactura($id_referencia, $Id_factura, $id_tipoempaque, $cantidad, $ValorUnitario, $descuento, $Iva, $ValorTotal, $asumeiva)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
				CALL SP_GuardaReferenciaFacturaActulizaInventario(?, ?, ?, ?, ?, ?, ?, ?, ?);
				"; 
        
		$arr = array($id_referencia, $Id_factura, $id_tipoempaque, $cantidad, $ValorUnitario, $descuento, $Iva, $ValorTotal, $asumeiva);
        $recordSet = $conexion->EjecutarP($cadena, $arr);   
		
		echo $conexion->ObtenerError() ;
		if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
			$mensaje = "";        
			while(!$recordSet->EOF)
			{        
				$mensaje=$recordSet->fields[0];
				$recordSet->MoveNext();
			}       
			
			if($mensaje == "error")
			{
				return "error";
			}
			else{
				return "";
			}         
        }
        $conexion->Close();
	}
	
	
	public function GuardaInventario($id_referencia, $cantidad, $ValorUnitario)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
				UPDATE inventario SET
				cantidad = ?,
				ValorUnitario = ?,
				ValorTotalInicial = ?,
				CantidadActual = ?,
				ValorTotalActual = ?
				WHERE id_referencia = ? "; 
        
		$arr = array($cantidad, 
		$ValorUnitario, 
		($cantidad * $ValorUnitario), 
		$cantidad, 
		($cantidad * $ValorUnitario),
		$id_referencia);
        $recordSet = $conexion->EjecutarP($cadena, $arr);   
		
		
		if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            return "";   
        }
        $conexion->Close();
	}

	public function EditarReferenciaFactura($id_referenciafac, $id_referencia, $id_tipoempaque, $TB_cantidad, $TB_valorUnitario, $TB_descuento, $TB_iva, $valorTotalFinal, $asumeiva)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 								
				CALL SP_EditarReferenciaFacturaActualizaInventario(?,
				?, 
				?, 
				?,  
				?, 
				?, 
				?, 
				?,
				?);
				"; 
        
		$arr = array($id_referencia, $id_tipoempaque, $TB_cantidad, $TB_valorUnitario, 
		$TB_descuento, $TB_iva, $valorTotalFinal, $asumeiva, $id_referenciafac);
        $recordSet = $conexion->EjecutarP($cadena, $arr);   
		
		
		if($conexion->ObtenerError() != "" )
        {
			echo $conexion->ObtenerError();
            return "error";
        }
        else
        {
			$mensaje = "";        
			while(!$recordSet->EOF)
			{        
				$mensaje=$recordSet->fields[0];
				$recordSet->MoveNext();
			}       
			
			if($mensaje == "error")
			{
				return "error";
			}
			else{
				return "";
			}          
        }
        $conexion->Close();
	}
	
	
	public function EliminarReferenciaFactura($id_referenciafac)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 	
				DELETE FROM referenciafactura
				WHERE id = ?
				"; 
        
		$arr = array($id_referenciafac);
        $recordSet = $conexion->EjecutarP($cadena, $arr);   
		
		if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            return "";   
        }
        $conexion->Close();
	}

 }

?>