<?php

//Clase para el manejo de usuarios 
//Autor: Miguel Villamizar
//Fecha: 2017/11/04



class usuarioData {
    
    public function Conectar()
    {
        global $conexion;
        include("AdoConnection.php");
        $conexion = new Ado();
    }
        
    public function ConsultarListaUsuario()
    {
        global $conexion;
        $conexion->conectarAdo();
        
        $cadena = "
		SELECT 	
			Id, 
			Nombre, 
			Apellido, 
			Documento, 
			Telefono, 
			Direccion, 
			Correo, 
			UrlFirma, 
			RenovacionLicencia, 
			LicenciaTrancito, 
			Id_Rol, 
			(SELECT rol FROM Rol WHERE id = Id_Rol) Rol,
			HoraMecanico,
			(CASE WHEN Estado = 1 THEN 
				'Activo'
				  WHEN Estado = 0 THEN
					'Eliminado'
			END) AS Estado
		FROM 
			usuario 
		 ;";
        
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();    
        return $recordSet; 
    }
    	
    public function ValidaUsuarioLogin($usuario)
    {
        global $conexion;
        $conexion->conectarAdo();
        
        $cadena = "SELECT * FROM usuario WHERE Correo = ? AND estado = 1;";
        $arr = array($usuario);
        
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();              
                       
        return $recordSet; 
    }
        
    public function UsuarioLogin($usuario2, $clave)
    {
        global $conexion;
        $conexion->conectarAdo();
        
        $cadena = "call sp_usuarioLogin(?)";
        $arr = array($usuario2);
        
        $recordSet = $conexion->EjecutarP($cadena, $arr);
		
        $conexion->Close(); 
		
        $usuario = 0;
        $i=0;
        
        while(!$recordSet->EOF)
        {      		
			if(password_verify($clave, $recordSet->fields[7]))
			{
				$usuario = 1;
			}
            $recordSet->MoveNext();
            $i++;
        }    
		return ($usuario);
    }
    
    public function consultarUsuario($correo)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT * FROM usuario WHERE Correo = ? AND estado = 1"; 
		$arr= array($correo);
        
        $recordSet = $conexion->EjecutarP($cadena,$arr);
        
        $conexion->Close();
		
        $usuario[][] = array();
        $i=0;
        
        while(!$recordSet->EOF)
        {        
            $usuario[0][0]=$recordSet->fields[0];
            $usuario[0][1]=$recordSet->fields[1];
            $usuario[0][2]=$recordSet->fields[2];
            $usuario[0][3]=$recordSet->fields[3];
            $usuario[0][4]=$recordSet->fields[4];
            $usuario[0][5]=$recordSet->fields[5];
            $usuario[0][6]=$recordSet->fields[6];
            $usuario[0][7]=$recordSet->fields[7];
            $usuario[0][8]=$recordSet->fields[8];
            $usuario[0][9]=$recordSet->fields[9];
            $usuario[0][10]=$recordSet->fields[10];
            $recordSet->MoveNext();
            $i++;
        }       
        return $usuario; 
	}
    
    public function consultarRoles()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT * FROM Rol;"; 
        
        $recordSet = $conexion->Ejecutar($cadena);
        
        $conexion->Close();
		
        return $recordSet; 
	}
    
    public function guardarUsuario($nombre, $apellido, $documento, $telefono, $rol, $direccion, $email, $clave)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
                    INSERT INTO usuario
                    ( 	 
                    	Nombre, 
                    	Apellido, 
                    	Documento, 
                    	Telefono, 
                    	Direccion, 
                    	Correo, 
                    	Clave, 
                    	UrlFirma, 
                    	RenovacionLicencia, 
                    	LicenciaTrancito, 
                    	Id_Rol, 
                    	Estado
                    )
                    VALUES (
                    	?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
						1
                    )"; 
					
		$arr = array($nombre, $apellido, $documento, $telefono, $direccion, $email, $clave, '', '', '', $rol);
        $recordSet = $conexion->EjecutarP($cadena,$arr);
        
        if($conexion->ObtenerError() != "" )
        {
            return $conexion->ObtenerError();
        }
        else
        {
			return "";
        }
        $conexion->Close();		
	}	
	
    public function EditarUsuario($id_usuario, $nombre, $apellido, $documento, $telefono, $rol, $direccion, $email)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
                    UPDATE usuario SET                    
						Nombre = ?,  
						Apellido= ?,  
						Documento= ?,  
						Telefono= ?,  
						Direccion= ?,  
						Correo= ?,   
						Id_Rol = ?
					WHERE Id = ?; "; 
					
		$arr = array( $nombre, $apellido, $documento, $telefono, $direccion, $email, $rol, $id_usuario);
        $recordSet = $conexion->EjecutarP($cadena,$arr);
        
        if($conexion->ObtenerError() != "" )
        {
            return $conexion->ObtenerError();
        }
        else
        {
			return "";
        }
        $conexion->Close();		
	}
        
    public function ConsultaUsuarioDocumento($documento)
    {
        global $conexion;
        $conexion->conectarAdo();
        
        $cadena = "SELECT COUNT(*) FROM usuario WHERE Documento = ? ;";
        $arr = array($documento);
        
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();              
                       
        $usuario = 0;
        $i=0;
        
        while(!$recordSet->EOF)
        {        
            $usuario=$recordSet->fields[0];
            $recordSet->MoveNext();
            $i++;
        }       
        return $usuario;  
    }
	        
    public function eliminaUsuario($Id)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = "UPDATE usuario SET 
                    Estado = 0
                    WHERE Id = ?"; 
        
        $arr = array($Id);
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();
		
        return $recordSet; 
	}    
    
}
?>