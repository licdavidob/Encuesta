<?php

class Usuario extends ConexionBD{
   	
	public function CrearUsuario($Correo){

		$Conectar_Base = $this->Conectar();
       	$Sentencias_Consulta = $this->Sentencias_Consultar_Usuario($ID = 0, $Correo);
		$ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Usuario_Correo"]);
		$Numero_Resultados = $ResultadoConsulta->num_rows;
		$Validar = new Validar();
		$Validar->Validar_Creacion_Usuario($Numero_Resultados,$Correo);
		$Contraseña_Aleatoria = $this->Generar_Contraseña(9);
		$Contraseña = password_hash($Contraseña_Aleatoria, PASSWORD_DEFAULT);
		$Sentencia_Crear = $this->Sentencias_Crear_Usuario($Correo,$Contraseña);
		$ResultadoConsulta = $Conectar_Base->query($Sentencia_Crear["Sentencias_Crear_Usuario"]);
		$Conectar_Base->close();
		return $Contraseña_Aleatoria;
	}

	public function ConsultarUsuario($SQL){
		$ConexionDB = new ConexionDB;
		$Conexion = $ConexionDB->Conectar();
		$ConsultaGeneral = $SQL;
		$Resultado_Consulta = $Conexion->query($ConsultaGeneral);
		$Conexion->close();
		$ArregloAuxiliar = array();
		$ResultadoFinal = array();
		$i = 0;
		while ($fila = $Resultado_Consulta->fetch_row()) {
			$ArregloAuxiliar['Id'] = $fila[0];
			$ArregloAuxiliar['Nombre'] = $fila[1];
			$ArregloAuxiliar['Apellido_P'] = $fila[2];
			$ArregloAuxiliar['Apellido_M'] = $fila[3];
			$ArregloAuxiliar['Correo'] = $fila[4];
			$ArregloAuxiliar['Telefono'] = $fila[5];
			$ArregloAuxiliar['Estado'] = $fila[6];
			$ResultadoFinal[$i] = $ArregloAuxiliar; //Guardo cada renglon en la posicion que valga $i
			$i++;
		}
		$Datos['data'] = $ResultadoFinal;
		echo json_encode($Datos);
		exit();
	}

	public function ActualizarUsuario($ID,$Nombre,$Apellido_P,$Apellido_M,$Correo,$Telefono,$Estado,$Rol){
		
		//Se valida que el usuario haya enviado un nombre
		if($Nombre == false){
			$Mensaje = "Se debe establecer un nombre";
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
		);
		echo json_encode($Respuesta);
		exit();
		}

		//Se valida que el usuario haya enviado un apellido paterno
		if($Apellido_P == false){
			$Mensaje = "Se debe establecer un apellido paterno";
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
			);
			echo json_encode($Respuesta);
			exit();
		}

		//Se valida que el usuario haya enviado un correo electrónico
		$Correo = (filter_var($Correo, FILTER_VALIDATE_EMAIL)) ? $Correo : false;
		if($Correo == false){
			$Mensaje = "Se debe establecer un correo electrónico válido";
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
		);
		echo json_encode($Respuesta);
		exit();
		}

		//Se valida que el usuario haya enviado un estado
		if($Estado == false){
			$Mensaje = "Se debe establecer un estado";
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
		);
		echo json_encode($Respuesta);
		exit();
		}

		//Se valida que el usuario haya enviado un ID
		if($ID == false){
			$Mensaje = "Se debe establecer un ID para actualizar";
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
		);
		echo json_encode($Respuesta);
		exit();
		}

		$ConexionDB = new ConexionDB;
		$Conexion = $ConexionDB->Conectar();
		$Consulta_Actualizar = "UPDATE usuario 
								SET 
								NOMBRE =  '$Nombre',
								APELLIDO_P = '$Apellido_P',
								APELLIDO_M = '$Apellido_M',
								CORREO = '$Correo',
								TELEFONO = '$Telefono',
								ID_ESTADO = '$Estado',
								ROL = '$Rol'
								WHERE
								ID = '$ID';";
		
		if($Conexion->query($Consulta_Actualizar)){
			$Conexion->close();
			$Mensaje = "Se ha actualizado con éxito";
			$Bandera = true;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
			);
			echo json_encode($Respuesta);
			exit();
		}else{
			$Mensaje = "Ha ocurrido un error: " . $Conexion->error;
			$Conexion->close();
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
			);
			echo json_encode($Respuesta);
			exit();
		}
	}

	public function EliminarUsuario($ID){
					
		//Se valida que el usuario haya enviado un id
		if($ID == false){
			$Mensaje = "Se debe establecer un id";
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
		);
		echo json_encode($Respuesta);
		exit();
		}

		$ConexionDB = new ConexionDB;
		$Conexion = $ConexionDB->Conectar();
		$Consulta_Eliminar = "UPDATE usuario 
								SET 
								ESTATUS =  0
								WHERE
								ID = '$ID';";
		
		if($Conexion->query($Consulta_Eliminar)){
			$Conexion->close();
			$Mensaje = "Se ha eliminado con éxito";
			$Bandera = true;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
			);
			echo json_encode($Respuesta);
			exit();
		}else{
			$Mensaje = "Ha ocurrido un error: ".$Conexion->error;
			$Conexion->close();
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
			);
			echo json_encode($Respuesta);
			exit();
		}
	}

	public function RestablecerContraseña($ID){
		
		//Se valida que el usuario haya enviado un id
		if($ID == false){
			$Mensaje = "Se debe establecer un id";
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
		);
		echo json_encode($Respuesta);
		exit();
		}

		$Contraseña_Aleatoria = $this->Generar_Contraseña(8);
		$Contraseña = password_hash($Contraseña_Aleatoria, PASSWORD_DEFAULT);
		
		$Consulta_Restablecer = "	UPDATE usuario 
									SET 
									CONTRASENA =  '$Contraseña'
									WHERE
									ID = '$ID';";
		
		$ConexionDB = new ConexionDB;
		$Conexion = $ConexionDB->Conectar();
		if($Conexion->query($Consulta_Restablecer)){
			$Conexion->close();
			$Info_Usuario = $this->Info_Usuario($ID);
			$Datos_Usuario["Nombre"] = $Info_Usuario['Nombre'];	
			$Datos_Usuario["Apellido_P"] = $Info_Usuario['Apellido_P'];	
			$Datos_Usuario["Apellido_M"] = $Info_Usuario['Apellido_M'];	
			$Datos_Usuario["Correo"] = $Info_Usuario['Correo'];	
			$Datos_Usuario["Contraseña"] = $Contraseña_Aleatoria;
			return $Datos_Usuario;
		}else{
			$Mensaje = "Ha ocurrido un error: ".$Conexion->error;
			$Conexion->close();
			$Bandera = false;
			$Respuesta = array(
				"Mensaje" => $Mensaje,
				"Bandera" => $Bandera
			);
			echo json_encode($Respuesta);
			exit();
		}

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

	public function Info_Usuario($ID){
		//Se obtiene la información de un usuario mediante su ID
		$ConexionDB = new ConexionDB;
		$Conexion = $ConexionDB->Conectar();
		$Obtener_Info = "SELECT * FROM `usuario` WHERE  `ID` = '$ID';";
        $Obtener_Info = $Conexion->query($Obtener_Info);
        while ($fila = $Obtener_Info->fetch_row()) {
			$Info_Usuario['Id'] = $fila[0];
			$Info_Usuario['Nombre'] = $fila[1];
			$Info_Usuario['Apellido_P'] = $fila[2];
			$Info_Usuario['Apellido_M'] = $fila[3];
			$Info_Usuario['Correo'] = $fila[4];
			$Info_Usuario['Telefono'] = $fila[5];
			$Info_Usuario['Estado'] = $fila[6];
			$Info_Usuario['Rol'] = $fila[8];
			$Info_Usuario['Estatus'] = $fila[9];
		}
		$Conexion->close();
		return $Info_Usuario;
	}

}
?>