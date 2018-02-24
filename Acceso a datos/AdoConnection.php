<?php

//Clase para conectarse con la base de datos 
//Autor: Miguel Villamizar
//Fecha: 2017/11/04 

class Ado{    
    
	//se conecta con el servidor de base de datos
	//ademas establece la propiedad utf8 para que retorne bien las tildes
     public function conectarAdo(){
        
        global $con;
        
        include('/adodb5/adodb.inc.php');
        
        $nomServidor = "localhost:3306";
        $nomBaseDatos = "grupocasale";
        $nomUsuario = "admin";
        $Clave = "1234";
        
        
        $con = ADONewConnection('mysqli');
        $con->debug = false;
        $con->Connect($nomServidor,$nomUsuario,$Clave,$nomBaseDatos);
        $con->SetCharSet("utf8");
        
        return $con;        
    }
    
	//ejecuta consultar sin parametros
    public function Ejecutar($cadena){        
        global $con;
        $resultado = $con->execute($cadena);
        return $resultado;
    }
	
	//ejecuta consulta con parametros
    public function EjecutarP($cadena,$parame){        
        global $con;
        $resultado = $con->execute($cadena, $parame);
        return $resultado;
    }
	
    
	//obtener error
    public function ObtenerError(){        
        global $con;
        $resultado = $con->ErrorMsg();
        return $resultado;
    }
	
	//cierra una conección
    public function Close()
    {
        global $con;
        $con ->Close();
    }
}

?>