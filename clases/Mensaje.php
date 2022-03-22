<?php
    class Mensaje{
        public function EnviarError($Mensaje){
            $Respuesta = array(
                "Mensaje" => $Mensaje,
                "Bandera" => false
            );
            echo json_encode($Respuesta);
            exit();
        }
        
        public function EnviarCorrecto($Mensaje){
            $Respuesta = array(
                "Mensaje" => $Mensaje,
                "Bandera" => true
            );
            echo json_encode($Respuesta);
            exit();
        }

        public function EnviarCorrectoInicioSesion($URL,$Mensaje="Sin mensaje asignado"){            
            $Respuesta = array(
                "Mensaje" => $Mensaje,
                "URL" => $URL,
                "Bandera" => true
            );
            echo json_encode($Respuesta);
            exit();
        }

    }
?>