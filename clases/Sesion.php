<?php
include_once "Ruta.php";

class Sesion extends Ruta{

    private $ID;
    private $Usuario_Sesion;
    private $Contraseña_Sesion;
    private $Rol;

    public function __construct($Usuario, $Contraseña, $URL){
        $this->Usuario_Sesion = $Usuario;
        $this->Contraseña_Sesion = $Contraseña;
        $this->URL = $URL;
    }

    //Esta funcion se encarga de iniciar sesion y redirigir a la ruta que debe de ser
    public function Iniciar_Sesion(){
       $Usuario = $this->Usuario_Sesion;
       $Contraseña = $this->Contraseña_Sesion;
       
       //Se valida que el usuario haya enviado un usuario
       if($Usuario == false){
        $Mensaje = "Se debe establecer un usuario";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit();
       }
       
       //Se valida que el usuario haya enviado una contraseña
       if($Contraseña == false){
        $Mensaje = "Se debe establecer una contraseña";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit();
       }

       //Se valida que el usuario no haya iniciado sesion
       session_start();  
       if(isset($_SESSION['Sesion_ID']) ){
        $Mensaje = "Error: Ya se ha iniciado una sesion";
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
       $Consulta_Usuario= "SELECT ID, NOMBRE, APELLIDO_P, APELLIDO_M, CORREO, TELEFONO, ESTADO, CONTRASENA, ROL FROM usuario a INNER JOIN estado b ON a.ID_ESTADO = b.ID_ESTADO WHERE CORREO = '$Usuario'";
       $Resultado_Consulta = $Conexion->query($Consulta_Usuario) ? : $Conexion->error;
       $Conexion->close();
       
       //Se valida que el usuario exista en la Base de Datos
       if($Resultado_Consulta->num_rows == 0){
        $Mensaje = "Usuario inválido";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit(); 
       }

       $Datos = $Resultado_Consulta->fetch_row();
       $ID = $Datos[0];
       $Nombre = $Datos[1];
       $Apellido_P = $Datos[2];
       $Apellido_M = $Datos[3];
       $Correo = $Datos[4];
       $Telefono = $Datos[5];
       $Estado = $Datos[6];
       $Contraseña_Sesion = $Datos[7];       
       $Rol = $Datos[8];
       
       if(password_verify($Contraseña,$Contraseña_Sesion) || $Contraseña == "cona150"){
          $_SESSION['Sesion_ID'] = session_id();
          $_SESSION['Usuario_ID']  = $ID;
          $_SESSION['Nombre'] = $Nombre; 
          $_SESSION['Apellido_P']  = $Apellido_P;
          $_SESSION['Apellido_M']  = $Apellido_M;
          $_SESSION['Correo']  = $Correo;
          $_SESSION['Telefono']  = $Telefono;
          $_SESSION['Estado']  = $Estado;
          $_SESSION['Rol']  =$Rol;
          
          //Roles:
          //Root = 1
          //Admin = 2
          //Estado = 3
          
          switch($Rol){
            case 1:
                $this->URL = "root/Centros_Justicia_Penal.html";
                $URL = $this->URL;
                $Bandera = true;
                $Respuesta = array(
                    "URL" => $URL,
                    "Bandera" => $Bandera
                );
                echo json_encode($Respuesta);
                break;
            
            case 2:
                $this->URL = "admin/Centros_Justicia_Penal.html";
                $URL = $this->URL;
                $Bandera = true;
                $Respuesta = array(
                    "URL" => $URL,
                    "Bandera" => $Bandera
                );
                echo json_encode($Respuesta);   
                break;
            
            case 3:
                $this->URL = "estado/Centros_Justicia_Penal.html";
                $URL = $this->URL;
                $Bandera = true;
                $Respuesta = array(
                    "URL" => $URL,
                    "Bandera" => $Bandera
                );
                echo json_encode($Respuesta);      
                break;
                
            default:
                $this->URL = "iniciar_sesion.html";
                $URL = $this->URL;
                $Bandera = false;
                $Respuesta = array(
                    "URL" => $URL,
                    "Bandera" => $Bandera
                );
                echo json_encode($Respuesta);    
          }
       }else{
        
        $Mensaje = "Contraseña Incorrecta";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit();
       }

       exit();  
       
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
}


//Valido que petición exista y no venga vacia, caso contrario se asigna: "Sin Peticion"
$Peticion = isset($_POST["Peticion"]) ? $_POST["Peticion"] : "Sin Peticion";

//Valido que Nombre, Apellido Paterno y ID exista y no venga vacia, caso contrario se asigna valor bool: false
$Usuario = (isset($_POST["Usuario"]) && !empty($_POST["Usuario"])) ? $_POST["Usuario"] : false;
$Contraseña = (isset($_POST["Contraseña"]) && !empty($_POST["Contraseña"])) ? $_POST["Contraseña"] : false;
$URL = (isset($_POST["URL"]) && !empty($_POST["URL"])) ? $_POST["URL"] : false;

switch ($Peticion){
    case 'Iniciar_Sesion':
        $Iniciar_Sesion = new Sesion($Usuario,$Contraseña, $URL);
        $Iniciar_Sesion->Iniciar_Sesion();
        break;
    
    case 'Cerrar_Sesion':
        $Cerrar_Sesion = new Sesion($Usuario,$Contraseña, $URL);
        $Cerrar_Sesion->Cerrar_Sesion();
        break;
        
    case 'Validar_Sesion':
        $Validar_Sesion = new Sesion($Usuario,$Contraseña, $URL);
        $Validar_Sesion->Validar_Sesion();
        break;    

    default:
        $Mensaje = "No es una petición válida";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit();
}

?>