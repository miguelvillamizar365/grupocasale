<?php

/**
 * manejo de base de datos factura, consultas,
 * @author Miguel Villamizar Garcia
 * @copyright 16/07/2018
 */
 
 class AutorizaFacturaData
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
			f.Estado AS EstadoId,
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
			AND mp.Estado = 1 

                "; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
		
    public function AutorizarFactura($IdFactura)
    {
        global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "UPDATE factura SET
				Estado = 2
				WHERE Id = ?";
        
        $arr = array($IdFactura);
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
 }
?>