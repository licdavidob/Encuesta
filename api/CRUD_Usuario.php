<?php
 header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once "../clases/Usuario.php";
include_once "../clases/Validar.php";
include_once "../clases/Correo.php"; 

$Peticion = $_SERVER['REQUEST_METHOD'];
$Validar = new Validar();
$Usuario = new Usuario();
//$Correo = new Correo();

switch ($Peticion){
    case 'POST':
        $Nombre = (isset($_POST["nombre"]) && !empty($_POST["nombre"])) ? $_POST["nombre"] : false;
        $Apellido_P = (isset($_POST["apellido_p"]) && !empty($_POST["apellido_p"])) ? $_POST["apellido_p"] : false;
        $Apellido_M = (isset($_POST["apellido_m"]) && !empty($_POST["apellido_m"])) ? $_POST["apellido_m"] : false;
        $Telefono = (isset($_POST["telefono"]) && !empty($_POST["telefono"])) ? $_POST["telefono"] : false;
        $Correo = (isset($_POST["correo"]) && !empty($_POST["correo"])) ? $_POST["correo"] : false;
        $Rol = (isset($_POST["rol"]) && !empty($_POST["rol"])) ? $_POST["rol"] : 3;
        $Validar->Validar_Variables_Registro_Usuario($Nombre,$Apellido_P,$Apellido_M,$Telefono,$Correo,$Rol);
        $Datos_Usuario = $Agregar_Usuario->CrearUsuario($Nombre,$Apellido_P,$Apellido_M,$Telefono,$Correo,$Rol);
        //$Notificar_Usuario = new Correo();
        //$Notificar_Usuario->Cuenta_Nueva($Datos_Usuario);
        break;

    case 'consultar':
        $SQL = $Sentencias_SQL->Consultar_Usuarios;
        $Consultar_Usuario = new Usuario();
        $Consultar_Usuario->ConsultarUsuario($SQL);
        break;

    case 'actualizar':
        $Actualizar_Usuario = new Usuario($Nombre,$Apellido_P,$Apellido_M,$Correo,$Telefono,$Estado,$Rol);
        $Actualizar_Usuario->ActualizarUsuario($ID,$Nombre,$Apellido_P,$Apellido_M,$Correo,$Telefono,$Estado,$Rol);
        break;
        
    case 'eliminar':
        $Eliminar_Usuario = new Usuario($Nombre,$Apellido_P,$Apellido_M,$Correo,$Telefono,$Estado,$Rol);
        $Eliminar_Usuario->EliminarUsuario($ID);
        break;
    
    case 'restablecer':
        $Restablecer = new Usuario($Nombre,$Apellido_P,$Apellido_M,$Correo,$Telefono,$Estado,$Rol);
        $Datos_Usuario = $Restablecer->RestablecerContraseña($ID);
        $Notificar_Usuario = new Correo();
        $Notificar_Usuario->Restablecer($Datos_Usuario);
        break;

    default:
        $Mensaje = "No es petición válida";
        $Bandera = false;
        $Respuesta = array(
            "Mensaje" => $Mensaje,
            "Bandera" => $Bandera
        );
        echo json_encode($Respuesta);
        exit();
}

?>