<?php
header('Content-Type: application/json');
session_start();

include_once "../clases/Mensaje.php";
include_once "../clases/Validar.php";
include_once "../clases/Sesion.php";

$Peticion = $_SERVER['REQUEST_METHOD'];
$Validar = new Validar();
$Mensaje = new Mensaje();

switch ($Peticion) {
    case 'POST':
        $Correo = (isset($_POST["Correo"]) && !empty($_POST["Correo"])) ? $_POST["Correo"] : 0;
        $Contraseña = (isset($_POST["Contraseña"]) && !empty($_POST["Contraseña"])) ? $_POST["Contraseña"] : 0;
        $Variables = array(
            "Correo" => $Correo,
            "Contraseña" => $Contraseña
        );
        $Validar->Validar_Variables_False($Variables);
        $Validar->Validar_Sesion_Activa();
        break;
    case 'GET':
        
        break;
    default:
        $Mensaje->EnviarError("No se encuentra definida esa petición");
        break;
}

?>