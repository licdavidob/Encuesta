<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once "../clases/ConexionBD.php";
include_once "../clases/Validar.php";
include_once "../clases/Encuesta.php";
include_once "../clases/Mensaje.php";
include_once "../clases/Juzgado.php";

$Peticion = $_SERVER['REQUEST_METHOD'];
$Encuesta = new Encuesta();
$Mensaje = new Mensaje();
$Validar = new Validar();
$Variable_Encuesta = array();

switch ($Peticion) {
    case 'POST':
        //Se definene que variables voy a recibir para mi registro de encuesta
        $Variable_Encuesta["ID_Juzgado"] = (isset($_POST["Juzgado"]) && !empty($_POST["Juzgado"])) ? $_POST["Juzgado"] : 0;
        $Variable_Encuesta["Expediente"] = (isset($_POST["Expediente"]) && !empty($_POST["Expediente"])) ? $_POST["Expediente"] : "Sin definir";
        $Variable_Encuesta["Parte"] = (isset($_POST["Parte"]) && !empty($_POST["Parte"])) && $_POST["Parte"] == 0 ? $_POST["Parte"] : 3;
        $Variable_Encuesta["P1"] = (isset($_POST["P1"]) && !empty($_POST["P1"])) ? $_POST["P1"] : 0;
        $Variable_Encuesta["P2"] = (isset($_POST["P2"]) && !empty($_POST["P2"])) ? $_POST["P2"] : 0;
        $Variable_Encuesta["P3"] = (isset($_POST["P3"]) && !empty($_POST["P3"])) ? $_POST["P3"] : 0;
        $Variable_Encuesta["P4"] = (isset($_POST["P4"]) && !empty($_POST["P4"])) ? $_POST["P4"] : 0;
        $Variable_Encuesta["P5"] = (isset($_POST["P5"]) && !empty($_POST["P5"])) ? $_POST["P5"] : 0;
        $Variable_Encuesta["P6"] = (isset($_POST["P6"]) && !empty($_POST["P6"])) ? $_POST["P6"] : 0;
        $Variable_Encuesta["P7"] = (isset($_POST["P7"]) && !empty($_POST["P7"])) ? $_POST["P7"] : 0;
        $Variable_Encuesta["Comentario"] = (isset($_POST["Comentario"]) && !empty($_POST["Comentario"])) ? $_POST["Comentario"] : "";

        //Se definen que variables deseo que sean obligatorias para poder registrar
        $Obligatorias = array(
            "Juzgado" => $Variable_Encuesta["ID_Juzgado"],
            "P1" => $Variable_Encuesta["P1"],
            "P2" => $Variable_Encuesta["P2"],
            "P3" => $Variable_Encuesta["P3"],
            "P4" => $Variable_Encuesta["P4"],
            "P5" => $Variable_Encuesta["P5"],
            "P6" => $Variable_Encuesta["P6"],
            "P7" => $Variable_Encuesta["P7"]
        );

        $Validar->Validar_Variables_Obligatorias($Obligatorias);
        $Validar->Validar_Variables_Obligatorias_NAN($Variable_Encuesta);

        //Se obtiene el juez que esta relacionado al juzgado ingresado
        $Obtener_Juez = new Juzgado();
        $Variable_Encuesta["Juez"] = $Obtener_Juez->Obtener_Juez($Variable_Encuesta["ID_Juzgado"]);

        //Se registra la encuesta
        $Encuesta->Registrar_Encuesta_Publico($Variable_Encuesta);
        $Mensaje->EnviarCorrecto("Se registró con éxito");
        break;

    case 'GET':
        $Encuesta_ID = (isset($_GET["Encuesta"]) && !empty($_GET["Encuesta"])) ? $_GET["Encuesta"] : false;
        $Inicio = (isset($_GET["Fecha_Inicio"]) && !empty($_GET["Fecha_Inicio"])) ? $_GET["Fecha_Inicio"] : false;
        $Fin = (isset($_GET["Fecha_Fin"]) && !empty($_GET["Fecha_Fin"])) ? $_GET["Fecha_Fin"] : false;

        // Si se envia un ID, se consultará la encuesta con dicho ID
        if ($Encuesta_ID != false) {
            $Encuesta->Consultar_Encuesta_ID($Encuesta_ID);
        }

        //Si se envía un intervalo de consulta , se consultaran todas las encuestas en dicho intervalo
        if ($Inicio != false && $Fin != false) {
            $Encuesta->Consultar_Encuestas_Fecha($Inicio, $Fin);
        }

        //Se consultan todas las encuestas registradas
        $Encuesta->Consultar_Encuestas();

        break;

    case 'DELETE':
        $ID = (isset($_GET["ID"]) && !empty($_GET["ID"])) ? $_GET["ID"] : 0;
        $Obligatorias = array(
            "ID" => $ID
        );
        $Validar->Validar_Variables_Obligatorias($Obligatorias);
        $Encuesta->Eliminar_Encuesta_ID($ID);
        $Mensaje->EnviarCorrecto("Se elimino la encuesta correctamente");
        break;

    default:
        $Mensaje->EnviarError("No se encuentra definida la petición");
        break;
}
