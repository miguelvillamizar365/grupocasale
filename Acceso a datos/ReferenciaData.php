<?php

/**
 * @author Miguel Villamizar
 * @copyright 2017/11/13
 */

class referenciaData{
    
    public function Conectar()
    {
        global $conexion;
        include("AdoConnection.php");
        $conexion = new Ado();
    }    
    
    public function consultarReferencias()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "
                SELECT 
                	r.Id, 
                	r.Nombre, 
                	te.id tipoempaqueId, 
                	te.descripcion tipoempaque, 
                	c.id clasificacionId, 
                	c.descripcion clasificacion, 
                	r.Stante, 
                	r.Piso, 
                	r.Stock, 
                	r.Estado 
                FROM referencia r 
                	LEFT JOIN tipoempaque te
                		ON r.id_tipoempaque = te.id
                	LEFT JOIN clasificacion c
                		ON r.id_clasificacion = c.id
                WHERE r.estado = 1"; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
    public function guardarReferencia($nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso, $Stock)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "INSERT INTO referencia 
                    (Nombre, 
                    id_tipoempaque,
                    id_clasificacion,
                    Stante,
                    piso,
                    Stock,
                    Estado)
                    VALUES(?,?,?,?,?,?,?);"; 
        
        $arr = array($nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso, $Stock, 1);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
       
        if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
			$cadena = "SELECT MAX(id) id_referencia FROM referencia;";
			$recordSet = $conexion->Ejecutar($cadena);
			
			if($conexion->ObtenerError() != "" )
			{
				echo $conexion->ObtenerError();
				return "error";
			}
			else
			{
				 $id_referencia = 0;        
				while(!$recordSet->EOF)
				{        
					$id_referencia=$recordSet->fields[0];
					$recordSet->MoveNext();
				}   
				return $id_referencia;   				
			}		            
        }
        $conexion -> Close();
	}    
	
	public function guardarInventario($id_referencia)
	{

		global $conexion;
        $conexion->conectarAdo();
		
		$cadena = "INSERT INTO inventario
				(id_referencia, 
				Nombre, 
				id_clasificacion, 
				Stante, 
				Piso, 
				Stock, 
				id_tipoEmpaque, 
				cantidad, 
				ValorUnitario, 
				ValorTotalInicial, 
				CantidadUsada, 
				ValorTotalUsado, 
				CantidadActual, 
				ValorTotalActual)
				SELECT r.id id_referencia, 
				r.Nombre,
				r.id_clasificacion,
				r.Stante,
				r.Piso,
				r.Stock,
				r.id_tipoEmpaque, 
				0 Cantidad,
				0 ValorUnitario,
				0 ValorTotalInicial,
				0 CantidadUsada,
				0 ValorTotalUsado,
				0 CantidadActual,
				0 ValorTotalActual
				FROM referencia r 
				WHERE r.id = ?";
					
        $arr = array($id_referencia);
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
		
	
	public function editarInventario($id_referencia, 
				$Nombre, 
				$id_clasificacion, 
				$Stante, 
				$Piso, 
				$Stock, 
				$id_tipoEmpaque )
	{

		global $conexion;
        $conexion->conectarAdo();
		
		$cadena = "
			UPDATE inventario SET
			Nombre = ?,
			id_clasificacion = ?,
			Stante = ?,
			Piso = ?,
			Stock = ?,
			id_tipoEmpaque = ?
			WHERE id_referencia = ?
		";
					
        $arr = array($Nombre, 
				$id_clasificacion, 
				$Stante, 
				$Piso, 
				$Stock, 
				$id_tipoEmpaque,
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
        $conexion -> Close();		
	}
	
	
	
    public function editarReferencia($Id, $nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso, $Stock)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "UPDATE referencia SET 
                    Nombre = ?, 
                    id_tipoempaque = ?,
                    id_clasificacion = ?,
                    Stante = ?,
                    piso = ?,
                    Stock = ?
                    WHERE Id = ?"; 
        
        $arr = array($nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso, $Stock, $Id);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
    public function validarEliminaReferencia($Id)
    {
        global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "SELECT COUNT(*) referencia
                    FROM referenciafactura
                    WHERE Id_referencia  = ?"; 
        
        $arr = array($Id);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
        
        $contRefe = 0;        
		while(!$recordSet->EOF)
        {        
            $contRefe=$recordSet->fields[0];
            $recordSet->MoveNext();
        }       
        return $contRefe;    
    }
        
    public function eliminaReferencia($Id)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "UPDATE referencia SET 
                    Estado = 0
                    WHERE Id = ?"; 
        
        $arr = array($Id);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
    
    public function consultarTipoEmpaque()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "SELECT 
                    	* 
                    FROM tipoempaque
                    WHERE estado = 1"; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}
    
    public function consultarClasificacion()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "SELECT 
                    	* 
                    FROM clasificacion
                    WHERE estado = 1"; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	} 
}

?>