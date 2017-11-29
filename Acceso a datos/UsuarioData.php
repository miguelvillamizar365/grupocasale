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
    
    
    public function ValidaUsuarioLogin($usuario)
    {
        global $conexion;
        $conexion->conectarAdo();
        
        $cadena = "SELECT * FROM usuario WHERE Correo = ? ;";
        $arr = array($usuario);
        
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();              
                       
        return $recordSet; 
    }
    
    
    public function UsuarioLogin($usuario, $clave)
    {
        global $conexion;
        $conexion->conectarAdo();
        
        $cadena = "SELECT * FROM usuario WHERE Correo = ? AND clave = ?;";
        $arr = array($usuario, $clave);
        
        $recordSet = $conexion->EjecutarP($cadena, $arr);
        
        $conexion->Close();              
                       
        return $recordSet; 
    }
    
    public function consultarUsuario($correo, $clave)
	{
		global $conexion;
        $conexion->conectarAdo();
		
        $cadena = " SELECT * FROM usuario WHERE Correo = ? AND clave = ?;"; 
		$arr= array($correo, $clave);
        
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
                    	Id_Rol
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
                        ?
                    )"; 
		$arr= array($nombre, $apellido, $documento, $telefono, $direccion, $email, $clave, '', '', '', $rol);
        
        $recordSet = $conexion->EjecutarP($cadena,$arr);
        
        $conexion->Close();		
	}
}
?>