<?php

/*
*
*Clase para conectarse con la base de datos,  
*autor Miguel Villamizar
*fecha 28/07/2018
*
*
*/
class InformeData{

    public function Conectar()
    {
        global $conexion;
        include("AdoConnection.php");
        $conexion = new Ado();
    }  
    
	public function ObtenerMecanicos()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "     
				SELECT 
					u.Documento,
					u.Nombre,
					u.Apellido,
					/*ot.fecha, 
					ot.Kilometraje, 
					v.placas,*/
					SUM(CAST(REPLACE(aot.Tiempo,',','.') AS DECIMAL(10,2))) tiempo,
					SUM(aot.valor) valor
				FROM ordentrabajo ot 
					INNER JOIN actividadordentrabajo aot
						ON ot.id = aot.id_ordentrabajo
					INNER JOIN usuario u 
						ON aot.id_mecanico = u.Id
					INNER JOIN vehiculo v
						ON ot.id_vehiculo = v.id
				WHERE u.id_rol= 5
				GROUP BY 
				u.Documento,
				u.Nombre,
				u.Apellido;
			";
                
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}
		
    public function consultarInformeMecanico($nombre, $documento)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena =		
		"
			CALL SP_InformeMecanico(? , ?);
		"; 
        
		$arr = array($nombre, $documento);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}
	   
	
	
}
?>