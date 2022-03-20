<?php
    class Validar{
        
        public function Validar_Variables_Registro_Publico($Juzgado,$Expediente,$Parte,$P1,$P2,$P3,$P4,$P5,$P6,$P7){
            if($Juzgado == false || $Expediente == false || $Parte == false || $P1 == false || $P2 == false || $P3 == false || $P4 == false || $P5 == false || $P6 == false || $P7 == false){
                $Error = new Mensaje();
                $Error->EnviarError("No se definio una variable");
                exit();
            }else{
                return true;
            }
        }

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

        public function Validar_Ejecucion_Query($Conectar_Base){
            if($Conectar_Base->error){
                $Error = new Mensaje();
                $Error->EnviarError("Error al ejecutar Query: " . $Conectar_Base->error);
                exit();
            } else {
                return true;
            }
        }

        public function Validar_Tipo_Variable_ID($ID){
            return true;
        }
    }

?>