<?php
include_once "../clases/ConexionBD.php";

class Sesion extends ConexionBD{

    private $ID;
    private $Usuario_Sesion;
    private $Contraseña_Sesion;
    private $Rol;
    private $URL_INICIO_SESION = "/";
    private $URL_INDEX_ROOT = "root/Centros_Justicia_Penal.html";
    private $URL_INDEX_ADMIN = "admin/Centros_Justicia_Penal.html";
    private $URL_INDEX_USUARIO = "estado/Centros_Justicia_Penal.html";
    private $URL_ERROR = "../error.html";

    public function __construct($Usuario, $Contraseña, $URL){
        $this->Usuario_Sesion = $Usuario;
        $this->Contraseña_Sesion = $Contraseña;
        $this->URL = $URL;
    }

    //Esta funcion se encarga de iniciar sesion y redirigir a la ruta que debe de ser
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

       
        //   $_SESSION['Sesion_ID'] = session_id();
        //   $_SESSION['Usuario_ID']  = $ID;
        //   $_SESSION['Nombre'] = $Nombre; 
        //   $_SESSION['Apellido_P']  = $Apellido_P;
        //   $_SESSION['Apellido_M']  = $Apellido_M;
        //   $_SESSION['Correo']  = $Correo;
        //   $_SESSION['Telefono']  = $Telefono;
        //   $_SESSION['Estado']  = $Estado;
        //   $_SESSION['Rol']  =$Rol;
       
    }
    //Esta función se encarga de cerrar sesion y redirigir a la ruta de iniciar sesion
    public function Cerrar_Sesion(){ 
       session_start();

       //Se valida que el usuario haya iniciado sesion
       if(!isset($_SESSION['Sesion_ID'])){
        $Mensaje = "Error: No se ha iniciado una sesion";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit();
       }else{
        session_destroy();   
        $Mensaje = "Se ha cerrado la sesion correctamente";   
        $URL = "../";
        $Bandera = true;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "URL" => $URL,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);   
       }
        

    }
    //Esta funcion se encarga de que el usuario no pueda acceder a otras vistas que no le corresponde
    public function Validar_Sesion(){
        $URL = $this->URL;

        //Se valida que el usuario haya enviado un URL
       if($URL == false){
        $Mensaje = "Se debe enviar una URL para seguir con la ejecución del programa";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit();
       }

       //Si URL es igual a "/", se aplican las reglas de negocio para esa página:
       //--No debe haber una sesión activa.
       //--En caso de haber una sesión activa, se envia al usuario a una página de error.
       session_start();
       
       //Si la ruta es la de inicio de sesion, entonces:
       if($URL == $this->URL_INICIO_SESION){
           
           //Se validad si ya existe un inicio de sesión cuando se accede a iniciar_sesion.html
           if(isset($_SESSION['Sesion_ID'])){ //Si existe la variable de session usuario...
            
            switch($_SESSION['Rol']){
                case 1:
                    $Mensaje = "No puedes acceder a la página de inicio de sesión porque ya has iniciado";
                    $URL = $this->URL_INDEX_ROOT;
                    $Bandera = false;
                    $Respuesta = array(
                        "Mensaje" => $Mensaje,
                        "Bandera" => $Bandera,
                        "URL" => $URL
                    );
                    echo json_encode($Respuesta);
                    exit();
                    break;

                case 2:
                    $Mensaje = "No puedes acceder a la página de inicio de sesión porque ya has iniciado";
                    $URL = $this->URL_INDEX_ADMIN;
                    $Bandera = false;
                    $Respuesta = array(
                        "Mensaje" => $Mensaje,
                        "Bandera" => $Bandera,
                        "URL" => $URL
                    );
                    echo json_encode($Respuesta);
                    exit();
                    break; 
                    
                case 3:
                    $Mensaje = "No puedes acceder a la página de inicio de sesión porque ya has iniciado";
                    $URL = $this->URL_INDEX_USUARIO;
                    $Bandera = false;
                    $Respuesta = array(
                        "Mensaje" => $Mensaje,
                        "Bandera" => $Bandera,
                        "URL" => $URL
                    );
                    echo json_encode($Respuesta);
                    exit();
                    break;
            }
            
            
           }else{
            $Mensaje = "Sin problema, puedes iniciar sesion";
            $Bandera = true;
            $Respuesta = array(
                "Mensaje" => $Mensaje,
                "Bandera" => $Bandera
            );
            echo json_encode($Respuesta);
            exit();
           }
       }
       
       //Si la ruta es diferente a la de inicio de sesion, debe existir una sesion ya creada
       if(!isset($_SESSION['Sesion_ID'])){
        $Mensaje = "Alto ahi perro, no tienes permiso de estar aqui porque no has iniciado sesion, regresate a tu casa";
        $URL = $this->URL_INICIO_SESION;
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera,
            "URL" => $URL
        );
        echo json_encode($Respuesta);
        
        exit();
       }

        //Si URL es cualquier otra diferente a la de "/", entonces:
        //--Debe ser una URL válida
        //--Cada rol sólo debe poder acceder a la ruta que le corresponde
        //----Root (1): root/...
        //----Admin (2): admin/...
        //----Estado (3): usuario/...

        switch($URL){
            case "root":
                
                if($_SESSION['Rol'] == 1){
                $Mensaje = "Todo Ok, puede continuar buen hombre";
                $Bandera = true;
                $Respuesta = array(
                    "Mensaje" => $Mensaje,
                    "Bandera" => $Bandera
                );
                echo json_encode($Respuesta);    
                }else{
                $Mensaje = "Alto ahi perro, no tienes permiso de estar aqui, regresate a tu casa";
                $URL = $this->URL_ERROR;
                $Bandera = false;
                $Respuesta = array(
                    "Mensaje" => $Mensaje,
                    "Bandera" => $Bandera,
                    "URL" => $URL

                );
                session_destroy();
                echo json_encode($Respuesta);
                }
                
                break;
            
            case "admin":

                if($_SESSION['Rol'] == 2){
                    $Mensaje = "Todo Ok, puede continuar buen hombre";
                    $Bandera = true;
                    $Respuesta = array(
                        "Mensaje" => $Mensaje,
                        "Bandera" => $Bandera
                    );
                    echo json_encode($Respuesta);    
                    }else{
                    $Mensaje = "Alto ahi perro, no tienes permiso de estar aqui, regresate a tu casa";
                    $URL = $this->URL_ERROR;
                    $Bandera = false;
                    $Respuesta = array(
                        "Mensaje" => $Mensaje,
                        "Bandera" => $Bandera,
                        "URL" => $URL
                    );
                    session_destroy();
                    echo json_encode($Respuesta);
                    }
                    
                    break;
            
            case "estado":
                
                if($_SESSION['Rol'] == 3){
                    $Mensaje = "Todo Ok, puede continuar buen hombre";
                    $Bandera = true;
                    $Respuesta = array(
                        "Mensaje" => $Mensaje,
                        "Bandera" => $Bandera
                    );
                    echo json_encode($Respuesta);    
                    }else{
                    $Mensaje = "Alto ahi perro, no tienes permiso de estar aqui, regresate a tu casa";
                    $URL = $this->URL_ERROR;
                    $Bandera = false;
                    $Respuesta = array(
                        "Mensaje" => $Mensaje,
                        "Bandera" => $Bandera,
                        "URL" => $URL
                    );
                    session_destroy();
                    echo json_encode($Respuesta);
                    }
                    
                    break;
                
            default:
                $Mensaje = "Alto ahi perro, esa ruta ni existe, regresate a tu casa";
                $URL = $this->URL_ERROR;
                $Bandera = false;
                $Respuesta = array(
                    "Mensaje" => $Mensaje,
                    "Bandera" => $Bandera,
                    "URL" => $URL
                );
                session_destroy();
                echo json_encode($Respuesta);    
          }

       
    }

    public function Datos_Sesion(){

    }

    public function Asignar_Rol($Rol){
          
    }
}

?>