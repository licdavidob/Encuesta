<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
session_start();

include_once "../clases/Mensaje.php";
include_once "../clases/Validar.php";
include_once "../clases/Sesion.php";

$Peticion = $_SERVER['REQUEST_METHOD'];
$Validar = new Validar();
$Mensaje = new Mensaje();
$Sesion = new Sesion();


switch ($Peticion) {
    case 'POST':
        $Correo = (isset($_POST["Correo"]) && !empty($_POST["Correo"])) ? $_POST["Correo"] : 0;
        $Contraseña = (isset($_POST["Contraseña"]) && !empty($_POST["Contraseña"])) ? $_POST["Contraseña"] : 0;
        $URL = (isset($_POST["URL"]) && !empty($_POST["URL"])) ? $_POST["URL"] : 0;
        if($URL === 0){
            $Obligatorias = array(
                "Correo" => $Correo,
                "Contraseña" => $Contraseña
            );
            $Validar->Validar_Variables_Obligatorias($Obligatorias);
    
            if(!$Validar->Validar_Sesion_Activa()){
                $Sesion->Iniciar_Sesion($Correo,$Contraseña);
                $Mensaje->EnviarCorrectoInicioSesion($Sesion->URL_Panel,"Se inicio sesion de manera exitosa");
            }else{
                $Sesion->Cerrar_Sesion();
                $Mensaje->EnviarError("Ya se encuentra una sesion iniciada, pero puedes volver a intentar");
            }
        }else{
            if ($Sesion->Validar_Sesion_Panel($URL)) {
                $Mensaje->EnviarCorrecto("Todo bien");
            }else {
                $Sesion->Cerrar_Sesion();
                $Mensaje->EnviarFalloValidarSesion($Sesion->URL_Index,"Error al validar sesion");
            }
        }
        break;
    case 'DELETE':
        if($Sesion->Cerrar_Sesion()){
           $Mensaje->EnviarCorrectoCerrarSesion($Sesion->URL_Login,"Se ha cerrado la sesión de manera exitosa"); 
        }else{
            $Mensaje->EnviarError("No existe ninguna sesión iniciada");
        }
        break;
    case 'GET':
        $Sesion->Imprimir_Datos_Sesion();
        break;        
    default:
        $Mensaje->EnviarError("No se encuentra definida esa petición");
        break;
}

?>