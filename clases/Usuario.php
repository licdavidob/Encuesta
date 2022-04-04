<?php

class Usuario extends ConexionBD{
   	
	public function CrearUsuario($Nombre,$Paterno,$Materno,$Correo){

		$Conectar_Base = $this->Conectar();
       	$Sentencias_Consulta = $this->Sentencias_Consultar_Usuario($ID = 0, $Correo);
		$ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Usuario_Correo"]);
		$Numero_Resultados = $ResultadoConsulta->num_rows;
		$Validar = new Validar();
		$Validar->Validar_Creacion_Usuario($Numero_Resultados,$Correo);
		$Contraseña_Aleatoria = $this->Generar_Contraseña(9);
		$Contraseña = password_hash($Contraseña_Aleatoria, PASSWORD_DEFAULT);
		$Sentencia_Crear = $this->Sentencias_Crear_Usuario($Nombre,$Paterno,$Materno,$Correo,$Contraseña);
		$ResultadoConsulta = $Conectar_Base->query($Sentencia_Crear["Sentencias_Crear_Usuario"]);
		var_dump($ResultadoConsulta);
		$Conectar_Base->close();
		return $Contraseña_Aleatoria;
	}

	public function Generar_Contraseña($Longitud){
		//Carácteres para la contraseña
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$password = "";
		//Reconstruimos la contraseña segun la longitud que se quiera
		for($i=0; $i<$Longitud;$i++) {
		   //obtenemos un caracter aleatorio escogido de la cadena de caracteres
		   $password .= substr($str,rand(0,62),1);
		}
		return $password;
	}

}
?>