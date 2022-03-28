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

        public function EnviarCorrectoInicioSesion($URL,$Mensaje){            
            $Respuesta = array(
                "Mensaje" => $Mensaje,
                "URL" => $URL,
                "Bandera" => true
            );
            echo json_encode($Respuesta);
            exit();
        }

        public function EnviarCorrectoCerrarSesion($URL,$Mensaje){            
            $Respuesta = array(
                "Mensaje" => $Mensaje,
                "URL" => $URL,
                "Bandera" => true
            );
            echo json_encode($Respuesta);
            exit();
        }

        public function EnviarFalloValidarSesion($URL,$Mensaje){            
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