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
    
	public function ObtenerMecanicos($fechaInicio, $fechaFin)
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
				AND (aot.Fecha >= STR_TO_DATE(?, '%Y/%m/%d') AND 
					aot.Fecha <= STR_TO_DATE(?, '%Y/%m/%d'))
				GROUP BY 
				u.Documento,
				u.Nombre,
				u.Apellido;
			";
                
		$arr = array($fechaInicio, $fechaFin);
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
	
    public function consultarInformeMecanico($nombre, $documento, $fechaInicio, $fechaFin)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena =		
		"
			CALL SP_InformeMecanico(?, ?, ?, ?);
		"; 
        
		$arr = array($nombre, $documento, $fechaInicio, $fechaFin);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}
	   
	
	
}
?>