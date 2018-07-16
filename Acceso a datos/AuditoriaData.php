<?php

/**
 * manejo de base de datos factura, consultas,
 * @author Miguel Villamizar Garcia
 * @copyright 12/01/2018
 */
 
 class AuditoriaData
 {
    public function Conectar()
    {
        global $conexion;
        //include("AdoConnection.php");
        $conexion = new Ado();
    }
    // Function to get the client IP address
	public function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

    public function guardarAuditoria($actividad, $fecha, $usuario, $data)
    {
        global $conexion;
        $conexion ->conectarAdo();
        
		//$ip = get_client_ip();
		$ip = "";
		
        $cadena = "INSERT INTO auditoria
                (actividad, fecha, usuario, ip, data)
                VALUES (?, (SELECT CURRENT_TIMESTAMP), ?, ?, ?)";
        
        $arr = array($actividad, $usuario, $ip, $data);
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
 }
 ?>