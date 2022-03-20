<?php
    include_once "../clases/ConexionBD.php"; //Realiza Conexion a BD 
    include_once "../clases/Validar.php"; 
    include_once "../clases/Encuesta.php"; 
    include_once "../clases/Mensaje.php";
    include_once "../clases/Juzgado.php";  
    header('Content-Type: application/json');

    $Peticion = $_SERVER['REQUEST_METHOD'];
    $Encuesta = new Encuesta();
    $Mensaje = new Mensaje();
    $Validar = new Validar();
    
    switch ($Peticion) {
        case 'POST':
            $Juzgado = (isset($_POST["Juzgado"]) && !empty($_POST["Juzgado"])) ? $_POST["Juzgado"] : false;
            $Expediente = (isset($_POST["Expediente"]) && !empty($_POST["Expediente"])) ? $_POST["Expediente"] : false;
            $Parte = (isset($_POST["Parte"]) && !empty($_POST["Parte"])) ? $_POST["Parte"] : false;
            $P1 = (isset($_POST["P1"]) && !empty($_POST["P1"])) ? $_POST["P1"] : false;
            $P2 = (isset($_POST["P2"]) && !empty($_POST["P2"])) ? $_POST["P2"] : false;
            $P3 = (isset($_POST["P3"]) && !empty($_POST["P3"])) ? $_POST["P3"] : false;
            $P4 = (isset($_POST["P4"]) && !empty($_POST["P4"])) ? $_POST["P4"] : false;
            $P5 = (isset($_POST["P5"]) && !empty($_POST["P5"])) ? $_POST["P5"] : false;
            $P6 = (isset($_POST["P6"]) && !empty($_POST["P6"])) ? $_POST["P6"] : false;
            $P7 = (isset($_POST["P7"]) && !empty($_POST["P7"])) ? $_POST["P7"] : false;
            $P8 = (isset($_POST["Comentario"]) && !empty($_POST["Comentario"])) ? $_POST["Comentario"] : "";
            $Validar->Validar_Variables_Registro_Publico($Juzgado,$Expediente,$Parte,$P1,$P2,$P3,$P4,$P5,$P6,$P7);
            $Obtener_Juez = new Juzgado();
            $Juez = $Obtener_Juez->Obtener_Juez($Juzgado);
            $Encuesta->Registrar_Encuesta_Publico($Juzgado,$Juez,$Expediente,$Parte,$P1,$P2,$P3,$P4,$P5,$P6,$P7,$P8);
            $Mensaje->EnviarCorrecto("Se registró con éxito");
            break;
        case 'GET':
            $Encuesta_ID = (isset($_GET["Encuesta"]) && !empty($_GET["Encuesta"])) ? $_GET["Encuesta"] : false;
            if($Encuesta_ID == false){
                $Encuesta->Consultar_Encuestas();
            }else{
                $Encuesta->Consultar_Encuesta_ID($Encuesta_ID);
            }
            break;
        default:
            # code...
            break;
    }
?>