<?php
 header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once "../clases/ConexionBD.php"; //Realiza Conexion a BD
include_once "../clases/Mensaje.php"; 
include_once "../clases/Usuario.php";
include_once "../clases/Validar.php";
//include_once "../clases/Correo.php"; 

$Peticion = $_SERVER['REQUEST_METHOD'];
$Validar = new Validar();
$Usuario = new Usuario();
$Mensaje = new Mensaje();
//$Correo = new Correo();

switch ($Peticion){
    case 'POST':
        $Nombre = (isset($_POST["Nombre"]) && !empty($_POST["Nombre"])) ? $_POST["Nombre"] : 0;
        $Paterno = (isset($_POST["Paterno"]) && !empty($_POST["Paterno"])) ? $_POST["Paterno"] : 0;
        $Materno = (isset($_POST["Materno"]) && !empty($_POST["Materno"])) ? $_POST["Materno"] : false;
        $Correo = (isset($_POST["Correo"]) && !empty($_POST["Correo"])) ? $_POST["Correo"] : 0;
        $Obligatorias = array(
            "Nombre" => $Nombre,
            "Paterno" => $Paterno,
            "Correo" => $Correo
        );
        $Validar->Validar_Variables_Obligatorias($Obligatorias);
        $Validar->Validar_Correo_Usuario($Correo);
        $Contraseña = $Usuario->CrearUsuario($Nombre,$Paterno,$Materno,$Correo);
        $Mensaje->EnviarContraseña($Contraseña,"Se ha creado el usuario de manera exitosa");
        break;

    case 'GET':
        
        break;

    case 'PUT':
        
        break;
        
    case 'DELETE':
        
        break;
    
    default:
        
}

?>