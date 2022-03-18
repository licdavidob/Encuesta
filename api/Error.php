<?php
    class Error_David{
        public $Mensaje;

        public function EnviarError(){
            $Respuesta = array(
                "Mensaje" => $this->Mensaje,
                "Bandera" => false
            );
            echo json_encode($Respuesta);
            exit();
        }
        public function DefinirMensaje($Mensaje,$Variable = null){
            
            //Diccionario de Errores
            $Errores = array(
                "Error_Variable" => "No se definio una variable: ",
            );

            //Se evalua que el error enviado exista en el diccionario
            if(!in_array($Mensaje,$Errores)){
                throw new Exception ('No existe error en el diccionario');
            }

            //Define el mensaje de error
            try {
                $this->Mensaje = $Errores[$Mensaje];
            } catch (Exception $e) {
                $this->Mensaje = $e->getMessage();
                exit();  
            }
        }

    }
?>