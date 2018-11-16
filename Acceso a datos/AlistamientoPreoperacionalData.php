<?php


/**
 * 
 * Manejo de Alistamiento preoperacional crear, edita, eliminar 
 * base de datos
 * @author Miguel Villamizar 
 * @copyright 28/04/2018
 */
 
 class AlistamientoData
 {
	public function Conectar()
    {
        global $conexion;
        include("AdoConnection.php");
        $conexion = new Ado();
    }  
    
    public function consultarAlistamiento()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "                    
                   SELECT 	ap.Id, 
					v.Placas, 
					DATE_FORMAT(ap.Fecha, '%Y/%m/%d %H:%i') fecha, 
					ap.Kilometraje, 
					(SELECT Nombre FROM usuario u WHERE u.Id = ap.id_conductor) Conductor, 
					(SELECT Nombre FROM usuario u WHERE u.Id = ap.id_mecanico) Mecanico, 
					ap.Observaciones	 
				   FROM alistamientopreoperacional ap
					INNER JOIN vehiculo v
						ON ap.id_vehiculo = v.Id
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
	
	public function consultarMecanico()
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
	
    public function consultarAlistamientoCheck($id_alistamiento)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = 		
		"
			SELECT a.Id, a.Descripcion, ac.check active
			FROM checklist a INNER JOIN alistamientochecklist ac
			ON a.Id = ac.id_checklist
			WHERE ac.Id_Alistamiento = ?
		"; 
        
		$arr = array($id_alistamiento);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}
	
	
    public function consultarAlistamientoCheckList()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = 		
		"
			SELECT a.Id, a.Id, a.Descripcion
			FROM checklist a 
			ORDER BY a.Id
		"; 
        
        $recordSet = $conexion->Ejecutar($cadena);        
        $conexion->Close();		
        return $recordSet; 
	}
		
    public function consultarAlistamientoCheckListEditar($id_alistamiento)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = 		
		"				
			CALL SP_ObtenerCheckAlistamiento(?);
		"; 
		$arr = array($id_alistamiento);
        
        $recordSet = $conexion->EjecutarP($cadena, $arr);    

		if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
            return $recordSet;   
        }
		
        $conexion->Close();	
	}
		
	public function guardarAlistamiento(
						$Id_vehiculo, 
						$fecha, 
						$Kilometraje, 
						$id_conductor, 
						$id_mecanico, 
						$Observaciones)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "				
					CALL SP_AgregarAlistamientoPreoperacional(?,?,?,?,?,?);
				";
        
        $arr = array($Id_vehiculo, 
		             $fecha, 
		             $Kilometraje, 
		             $id_conductor,
		             $id_mecanico, 
		             $Observaciones);
		
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
				return $mensaje;
			}         
        }
        $conexion->Close();
	}
			
	public function guardarCheckListAlistamiento($Id_Alistamiento, $id_checklist)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "				
				INSERT INTO alistamientochecklist 
					(Id_Alistamiento, 
					id_checklist
					)
					VALUES
					(?, 
					 ?
					);				
				";
        
        $arr = array($Id_Alistamiento, $id_checklist);
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
	
	
	public function eliminaCheckListAlistamiento($Id_Alistamiento)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "				
					DELETE FROM alistamientochecklist 
					WHERE Id_Alistamiento = ?;
				";
        
        $arr = array($Id_Alistamiento);
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
	
	public function consultarAlistamientoCodigo($id_alistamiento)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = 		
		"
			SELECT Id, 
				Id_vehiculo, 
				DATE_FORMAT(Fecha, '%Y/%m/%d %H:%i') fecha, 
				Kilometraje, 
				id_conductor, 
				id_mecanico, 
				Observaciones 
			FROM alistamientopreoperacional
			WHERE id = ?
		"; 
        
		$arr = array($id_alistamiento);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
		if($conexion->ObtenerError() != "" )
        {
			$conexion->Close();
            return "error";
        }
        else
        {
			$conexion->Close();
			return $recordSet; 
		}		
	}



	public function guardarEditarAlistamiento(
						$IdAlistamiento, 
						$Id_vehiculo, 
						$fecha, 
						$Kilometraje, 
						$id_conductor, 
						$id_mecanico, 
						$Observaciones)
	{
		global $conexion;
        $conexion ->conectarAdo();
        
        $cadena = "				
					CALL SP_EditarAlistamientoPreoperacional(?,?,?,?,?,?,?);
				";
        
        $arr = array($IdAlistamiento,
					 $Id_vehiculo, 
		             $fecha, 
		             $Kilometraje, 
		             $id_conductor,
		             $id_mecanico, 
		             $Observaciones);
		
        $recordSet = $conexion->EjecutarP($cadena, $arr);
                
        if($conexion->ObtenerError() != "" )
        {
            return $conexion->ObtenerError();
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
				return $mensaje;
			}         
        }	
        $conexion -> Close();   
	}	
	
	
    public function consultarAlistamientoCheckListInforme($id_alistamiento)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = 		
		"				
			CALL SP_ObtenerCheckAlistamiento(?);
		"; 
		$arr = array($id_alistamiento);
        
        $recordSet = $conexion->EjecutarP($cadena, $arr);    

		if($conexion->ObtenerError() != "" )
        {
            return "error";
        }
        else
        {
			$alistamiento[][] = array();
			$i=0;
			
			while(!$recordSet->EOF)
			{        
				$alistamiento[$i][0]=$recordSet->fields[0];
				$alistamiento[$i][1]=$recordSet->fields[1];
				$alistamiento[$i][2]=$recordSet->fields[2];
				$recordSet->MoveNext();
				$i++;
			}       
			return $alistamiento;  
        }
		
        $conexion->Close();	
	}
 } 
?>