<?php 
	//Conexion Base de Datos
	class ConexionBD{
		//Atributos de mi clase
		protected $Servidor = "localhost";
		protected $Usuario = "root";
		protected $Contraseña = "conatrib150";
		protected $DB = "1q2w3e4r5t";
		protected $Sentencias_Consulta;
		protected $Sentencias_Registro;

		public function Conectar(){
			$ConectarBD = new mysqli($this->Servidor, $this->Usuario, $this->Contraseña, $this->DB);
        	return $ConectarBD;
		}

		public function Sentencias_Consulta(){
			$this->Sentencias_Consulta = array(
				"" => "",
				"" => "",
				"" => "",
				"" => "",
			);
		}

		public function Sentencias_Registro(){
			$this->Sentencias_Registro = array(
				"" => "",
				"" => "",
				"" => "",
				"" => "",
			);
		}

	}
?> 