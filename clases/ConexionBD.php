<?php 
	//Conexion Base de Datos
	class ConexionBD{
		//Atributos de mi clase
		protected $Servidor = "localhost";
		protected $Usuario = "root";
		protected $Contraseña = "conatrib150";
		protected $DB = "encuesta_qr";
		
		public function Conectar(){
			$Conectar_Base = new mysqli($this->Servidor, $this->Usuario, $this->Contraseña, $this->DB);
        	if($Conectar_Base->connect_errno){
				$Validar_Conexion_Base = new Validar();
				$Validar_Conexion_Base->Validar_Conexion_Base($Conectar_Base->connect_error);
			}
			return $Conectar_Base;
			
		}

		public function Sentencias_Consulta_Encuesta($ID = 0){
			$Sentencias_Consulta = array(
				"Consultar_Encuestas" => "SELECT ID_Encuesta, Juzgado, Expediente FROM encuesta a INNER JOIN cat_juzgado b ON a.ID_Juzgado = b.ID_Juzgado WHERE (Estatus = 1 );",
				"Consultar_Encuesta_ID" => "SELECT Juzgado, Expediente, Parte, P1, P2, P3, P4, P5, P6, P7, P8 FROM encuesta a INNER JOIN cat_juzgado b ON a.ID_Juzgado = b.ID_Juzgado WHERE (Estatus = 1 ) AND (ID_Encuesta ='$ID');",
				"Consultar_Encuesta_Fecha" => "",
				"" => "",
			);
			return $Sentencias_Consulta;
		}

		public function Sentencias_Registro_Encuesta($Juzgado,$Juez,$Expediente,$Parte,$P1,$P2,$P3,$P4,$P5,$P6,$P7,$P8){
			$Sentencias_Registro = array(
				"Registrar_Encuesta_Publico" => "INSERT INTO `encuesta`(`ID_Juzgado`,`Juez`,`Expediente`,`Parte`,`P1`,`P2`,`P3`,`P4`,`P5`,`P6`,`P7`,`P8`,`Fecha_Registro`) VALUES ('$Juzgado','$Juez','$Expediente','$Parte','$P1','$P2','$P3','$P4','$P5','$P6','$P7','$P8',CURRENT_DATE());",
			);
			return $Sentencias_Registro;
		}
		
		public function Sentencias_Consulta_Juzgado($ID = null){
			$Sentencias_Consulta_Juzgado = array(
				"Consultar_Juzgado" => "SELECT Juzgado FROM cat_juzgado WHERE (ID_Juzgado = '$ID');",
				"Consultar_Juez" => "SELECT Juez FROM cat_juzgado WHERE (ID_Juzgado = '$ID');",
				"Consultar_Info" => "SELECT Juzgado, Juez FROM cat_juzgado WHERE (ID_Juzgado = '$ID');",
				"Consultar_Info_General" => "SELECT * FROM cat_juzgado;",
			);
			return $Sentencias_Consulta_Juzgado;
		}

	}
?> 