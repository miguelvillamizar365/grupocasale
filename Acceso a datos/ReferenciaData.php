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
			r.Codigo,
			r.Nombre, 
			te.id tipoempaqueId, 
			te.descripcion tipoempaque, 
			c.id clasificacionId, 
			c.descripcion clasificacion, 
			r.Stante, 
			r.Piso, 
			i.Cantidad,
			i.CantidadActual,
			i.CantidadUsada,
			i.ValorUnitario,			
			i.ValorTotalUsado,			
			i.ValorTotalActual
		FROM referencia r 
			LEFT JOIN tipoempaque te
				ON r.id_tipoempaque = te.id
			LEFT JOIN clasificacion c
				ON r.id_clasificacion = c.id
			LEFT JOIN inventario i
				ON r.id = i.id_referencia
		WHERE r.estado = 1
		ORDER BY r.Id
		"; 
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
    public function guardarReferencia($codigo, $nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "call SP_GuardaReferenciaInventario(?,?,?,?,?,?,?);"; 
        
        $arr = array($codigo, $nombre,$id_tipoempaque, $id_clasificacion, $Stante, $Piso, 1);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
       
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
        $conexion -> Close();
	}    
		
    public function editarReferencia($Id, $Codigo, $nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "CALL SP_EditarReferenciaInventario(?,?,?,?,?,?,?)"; 
        
        $arr = array($Id, $Codigo, $nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        
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
        $conexion -> Close();		
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
	
	
    public function validarCodigo($codigo)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "SELECT COUNT(*) FROM referencia WHERE codigo = ?"; 
                
        $arr = array($codigo);
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
	
}

?>