<?php
include_once "../clases/ConexionBD.php";
include_once "../clases/Mensaje.php";

class Sesion extends ConexionBD{

    public $URL_Index = "index.html";
    public $URL_Login = "login.html";
    public $URL_Panel; 

    public function Iniciar_Sesion($Correo,$Contraseña){
       $Conectar_Base = $this->Conectar();
       $Sentencias_Consulta = $this->Sentencias_Consultar_Usuario($ID = 0, $Correo);
       $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Usuario_Correo"]);
       $Conectar_Base->close();
       $Numero_Resultados = $ResultadoConsulta->num_rows;
       $Validar = new Validar();
       $Validar->Validar_Existencia_Usuario($Numero_Resultados,$Correo);
       $Datos = $ResultadoConsulta->fetch_row();
       $Nombre = $Datos[0];
       $Paterno = $Datos[1];
       $Materno = $Datos[2];
       $Correo = $Datos[3];
       $Contraseña_Registrada = $Datos[4];       
       $Rol = $Datos[5];
       $Validar->Validar_Contraseña_Usuario($Contraseña,$Contraseña_Registrada);
       $this->Asignar_Permisos($Rol);
       $_SESSION['Sesion_ID'] = session_id();
       $_SESSION['Nombre']  = $Nombre;
       $_SESSION['Paterno'] = $Paterno; 
       $_SESSION['Materno']  = $Materno;
       $_SESSION['Correo']  = $Correo;
       $_SESSION['Rol']  = $Rol;
       $_SESSION['URL_Panel']  = $this->URL_Panel;
       return true;
    }

    public function Cerrar_Sesion(){ 
        $Validar = new Validar();
       if($Validar->Validar_Sesion_Activa()){
        session_destroy();
        return true; 
       }else{
        return false;
       }  
    }

    public function Validar_Sesion_Panel($URL){
       if($URL === $_SESSION['URL_Panel']){
        return true;    
       }else{
        return false;
       }       
    }

    public function Imprimir_Datos_Sesion(){
        if(isset($_SESSION['Sesion_ID']) ){
            $Datos_Sesion = array(
                "Sesion_ID" => $_SESSION['Sesion_ID'],
                "Nombre" => $_SESSION['Nombre'],
                "Paterno" => $_SESSION['Paterno'],
                "Materno" => $_SESSION['Materno'],
                "Correo" => $_SESSION['Correo'],
                "Rol" => $_SESSION['Rol'],
                "URL" => $_SESSION['URL_Panel'],
            );
            echo json_encode($Datos_Sesion);
        }else{
            $Mensaje = new Mensaje();
            $Mensaje->EnviarError("No existe una sesión iniciada");
        }  
    }

    public function Asignar_Permisos($Rol){
          
        switch ($Rol) {
            case '1': //Root
                $this->URL_Panel = "root.html";
                break;
            case '2': //Admin
                $this->URL_Panel = "admin.html";
                break;
            case '3': //Magistrado
                $this->URL_Panel = "magistrado.html";
                break;    
            default:
                $Mensaje = new Mensaje();
                $this->Cerrar_Sesion();
                $Mensaje->EnviarError("No existe ese tipo de rol");
                break;
        }
    }
}

?>