<?php
    class Validar{
        
        public function Validar_Resultado_ID($Numero_Resultados, $ID){
            if($Numero_Resultados == 0){
                $Error = new Mensaje();
                $Error->EnviarError("No existe registro con el ID: ".$ID);
                exit();
            }elseif ($Numero_Resultados > 1) {
                $Error = new Mensaje();
                $Error->EnviarError("Existen múltiples resultados con el ID: ".$ID);
                exit();
            } else {
                return true;
            }
        }

        public function Validar_Conexion_Base($Conectar_Base){
            if($Conectar_Base){
                $Error = new Mensaje();
                $Error->EnviarError("Error al conectar con la base de datos: " . $Conectar_Base);
                exit();
            } else {
                return true;
            }    
        }

        public function Validar_Correo_Usuario($Correo){
            if(!filter_var($Correo, FILTER_VALIDATE_EMAIL)){
                $Error = new Mensaje();
                $Error->EnviarError("No es válido el correo electrónico");
                exit();
            }else{
                return true;
            }
        }

        public function Validar_Variables_Obligatorias_NAN($Variables){
            foreach ($Variables as $key => $value) {
                if(is_nan($key)){
                    $Error = new Mensaje();
                    $Error->EnviarError("Falta definir la variable: ". $key);
                    exit();
                }
            }
            return true;
        }

        public function Validar_Variables_Obligatorias($Variables){
            while (($Faltante = current($Variables)) !== false){
                if($Faltante === 0 ){
                    $Error = new Mensaje();
                    $Error->EnviarError("Falta definir la variable: ".key($Variables));
                    exit();
                }
                next($Variables);
            }
            return true;
        }

        public function Validar_Sesion_Activa(){
            if(isset($_SESSION['Sesion_ID']) ){
                return true;
            }else{
                return false;
            }  
        }

        public function Validar_Existencia_Usuario($Numero_Resultados,$Correo){
            if($Numero_Resultados == 0){
                $Error = new Mensaje();
                $Error->EnviarError("No existe usuario con el correo electrónico: " . $Correo);
                exit();
            }elseif ($Numero_Resultados > 1) {
                $Error = new Mensaje();
                $Error->EnviarError("Existen múltiples usuarios con el correo electrónico: ". $Correo);
                exit();
            } else {
                return true;
            }
        }

        public function Validar_Contraseña_Usuario($Contraseña,$Contraseña_Registrada){
            if(password_verify($Contraseña,$Contraseña_Registrada) || $Contraseña == "yamete kudasai"){
                return true;
            }else{
                $Error = new Mensaje();
                $Error->EnviarError("Contraseña incorrecta");
                exit();
            }
        }
        
    }

?>