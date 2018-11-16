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
	
	public function consultarInformeFactura($id_factura)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena =		
		"
			CALL SP_InformeFactura(?);
		"; 
        
		$arr = array($id_factura);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}	
	
	public function consultarInformacionEmpresa($id_empresa)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena =		
		"
		SELECT NumeroIdentificacion,
			CodigoVerificacion, 
			RazonSocial,
			Direccion,
			Telefono,
			Ciudad,
			Correo
		FROM empresa
		WHERE Id = ?
		"; 
        
		$arr = array($id_empresa);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
		
        $empresa[] = array();
        $i=0;
        
        while(!$recordSet->EOF)
        {        
            $empresa[0]=$recordSet->fields[0];
            $empresa[1]=$recordSet->fields[1];
            $empresa[2]=$recordSet->fields[2];
            $empresa[3]=$recordSet->fields[3];
            $empresa[4]=$recordSet->fields[4];
            $empresa[5]=$recordSet->fields[5];
            $empresa[6]=$recordSet->fields[6];
            $recordSet->MoveNext();
            $i++;
        }       
        return $empresa;
	}
 }
?>