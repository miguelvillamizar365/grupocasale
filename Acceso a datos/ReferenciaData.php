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
		
        $cadena = "SELECT 
                    	r.Id, 
                    	r.Nombre, 
                    	te.descripcion tipoempaque, 
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
                    WHERE r.estado = 1	"; 
                
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
                    VALUES(?,?,?,?,?,?,?)"; 
        
        $arr = array($nombre, $id_tipoempaque, $id_clasificacion, $Stante, $Piso, $Stock, 1);
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