<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once "../clases/ConexionBD_Pruebas.php"; //Realiza Conexion a BD 
    include_once "../clases/Validar.php"; 
    include_once "../clases/Encuesta.php"; 
    include_once "../clases/Mensaje.php";
    include_once "../clases/Juzgado.php";  

    $Peticion = $_SERVER['REQUEST_METHOD'];
    $Encuesta = new Encuesta();
    $Mensaje = new Mensaje();
    $Validar = new Validar();
    
    switch ($Peticion) {
        case 'POST':
            $Juzgado = (isset($_POST["Juzgado"]) && !empty($_POST["Juzgado"])) ? $_POST["Juzgado"] : 0;
            $Expediente = (isset($_POST["Expediente"]) && !empty($_POST["Expediente"])) ? $_POST["Expediente"] : 0;
            $Parte = (isset($_POST["Parte"]) && !empty($_POST["Parte"])) ? $_POST["Parte"] : 0;
            $P1 = (isset($_POST["P1"]) && !empty($_POST["P1"])) ? $_POST["P1"] : 0;
            $P2 = (isset($_POST["P2"]) && !empty($_POST["P2"])) ? $_POST["P2"] : 0;
            $P3 = (isset($_POST["P3"]) && !empty($_POST["P3"])) ? $_POST["P3"] : 0;
            $P4 = (isset($_POST["P4"]) && !empty($_POST["P4"])) ? $_POST["P4"] : 0;
            $P5 = (isset($_POST["P5"]) && !empty($_POST["P5"])) ? $_POST["P5"] : 0;
            $P6 = (isset($_POST["P6"]) && !empty($_POST["P6"])) ? $_POST["P6"] : 0;
            $P7 = (isset($_POST["P7"]) && !empty($_POST["P7"])) ? $_POST["P7"] : 0;
            $P8 = (isset($_POST["Comentario"]) && !empty($_POST["Comentario"])) ? $_POST["Comentario"] : "";
            
            $Registro_Obligatorias = array(
                "Juzgado" => $Juzgado,
                "P1" => $P1,
                "P2" => $P2,
                "P3" => $P3,
                "P4" => $P4,
                "P5" => $P5,
                "P6" => $P6,
                "P7" => $P7
            );

            $Validar_NAN = array(
                "Juzgado" => $Juzgado,
                "Expediente" => $Expediente,
                "Parte" => $Parte,
                "P1" => $P1,
                "P2" => $P2,
                "P3" => $P3,
                "P4" => $P4,
                "P5" => $P5,
                "P6" => $P6,
                "P7" => $P7
            );
            
            $Validar->Validar_Variables_Obligatorias($Obligatorias);
            $Validar->Validar_Variables_Obligatorias_NAN($Validar_NAN);
            $Obtener_Juez = new Juzgado();
            $Juez = $Obtener_Juez->Obtener_Juez($Juzgado);
            $Encuesta->Registrar_Encuesta_Publico($Juzgado,$Juez,$Expediente,$Parte,$P1,$P2,$P3,$P4,$P5,$P6,$P7,$P8);
            $Mensaje->EnviarCorrecto("Se registró con éxito");
            break;
        case 'GET':
            $Encuesta_ID = (isset($_GET["Encuesta"]) && !empty($_GET["Encuesta"])) ? $_GET["Encuesta"] : false;
            $Inicio = (isset($_GET["Fecha_Inicio"]) && !empty($_GET["Fecha_Inicio"])) ? $_GET["Fecha_Inicio"] : false;
            $Fin = (isset($_GET["Fecha_Fin"]) && !empty($_GET["Fecha_Fin"])) ? $_GET["Fecha_Fin"] : false;
            
            if($Encuesta_ID == false && ($Inicio == false || $Fin == false) ){
                $Encuesta->Consultar_Encuestas();
            }elseif ($Encuesta_ID == false) {
                $Encuesta->Consultar_Encuestas_Fecha($Inicio,$Fin);
            }
            else{
                $Encuesta->Consultar_Encuesta_ID($Encuesta_ID);
            }
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
