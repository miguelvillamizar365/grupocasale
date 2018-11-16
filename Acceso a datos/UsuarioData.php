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
			(SELECT rol FROM rol WHERE id = Id_Rol) Rol,
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
		
        $cadena = " SELECT  U.Id, 
							U.Nombre,
							U.Apellido,
							R.Id,
							R.Rol
					FROM usuario U INNER JOIN
						 rol R ON U.id_rol = R.Id						 
					WHERE Correo = ? 
						  AND estado = 1"; 
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
            $recordSet->MoveNext();
            $i++;
        }       
        return $usuario; 
	}
    
    public function consultarRoles()
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT * FROM rol;"; 
        
        $recordSet = $conexion->Ejecutar($cadena);
                
        if($conexion->ObtenerError() != "" )
        {
            echo $conexion->ObtenerError();
        }
        else
        {
			return $recordSet; 
        }
		$conexion->Close();
	}
    
    public function guardarUsuario($nombre, $apellido, $documento, $telefono, $rol, $direccion, $email, $clave, $valorHora)
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
                    	Estado,
						HoraMecanico
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
						1,
						?
                    )"; 
					
		$arr = array($nombre, $apellido, $documento, $telefono, $direccion, $email, $clave, '', '', '', $rol, $valorHora);
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
	
    public function EditarUsuario($id_usuario, $nombre, $apellido, $documento, $telefono, $rol, $direccion, $email, $valorHora)
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
						Id_Rol = ?,
						HoraMecanico = ?
					WHERE Id = ?; "; 
					
		$arr = array( $nombre, $apellido, $documento, $telefono, $direccion, $email, $rol, $valorHora, $id_usuario);
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
	
	
    public function consultarMenuUsuario($id_rol, $id_usuario)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
		SELECT 
			m.id, 
			m.Menu,
			m.Url,	
			m.NodoPadre,
			m.Icon,
			m.Imagen,
			m.Boton
		FROM menu m
		INNER JOIN rol_menu rm 
			ON m.id = rm.id_menu
		INNER JOIN usuario u
			ON rm.id_rol = u.Id_Rol
		WHERE rm.id_rol = ?
		AND u.Id = ?
		ORDER BY m.Orden ASC "; 
		
		$arr= array($id_rol, $id_usuario);
        
        $recordSet = $conexion->EjecutarP($cadena,$arr);
        
        $conexion->Close();
		
        $menu[][] = array();
        $i=0;
        
        while(!$recordSet->EOF)
        {        
            $menu[$i][0]=$recordSet->fields[0];
            $menu[$i][1]=$recordSet->fields[1];
            $menu[$i][2]=$recordSet->fields[2];
            $menu[$i][3]=$recordSet->fields[3];
            $menu[$i][4]=$recordSet->fields[4];
            $menu[$i][5]=$recordSet->fields[5];
            $menu[$i][6]=$recordSet->fields[6];
            $recordSet->MoveNext();
            $i++;
        }       
        return $menu; 
	}    
	
	
    public function consultarMenuUsuarioPermiso($id_rol, $id_usuario, $id_permiso)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " 
		SELECT COUNT(*)
		FROM menu m
		INNER JOIN rol_menu rm 
			ON m.id = rm.id_menu
		INNER JOIN usuario u
			ON rm.id_rol = u.Id_Rol
		WHERE rm.id_rol = ?
		AND u.Id = ?
		AND m.Id = ?
		ORDER BY m.Orden ASC "; 
		
		$arr= array($id_rol, $id_usuario, $id_permiso);
        
        $recordSet = $conexion->EjecutarP($cadena,$arr);
        
        $conexion->Close();
		
        $menu = 0;
        $i=0;
        
        while(!$recordSet->EOF)
        {        
            $menu = $recordSet->fields[0];
            $recordSet->MoveNext();
        }       
        return $menu; 
	}    
	
	
    public function ConsultaTiempoSesion()
    {
        global $conexion;
        $conexion->conectarAdo();
        
        $cadena = "SELECT valor FROM parametros WHERE id_parametro = 1";
        
        $recordSet = $conexion->Ejecutar($cadena);
        
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
	        
}
?>