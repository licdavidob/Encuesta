<?php
    include_once "ConexionBD.php"; //Realiza Conexion a BD
    include_once "Error.php"; 

    $Juzgado = (isset($_POST["Juzgado"]) && !empty($_POST["Juzgado"])) ? $_POST["Juzgado"] : false;
    $Expediente = (isset($_POST["Expediente"]) && !empty($_POST["Expediente"])) ? $_POST["Expediente"] : false;
    $P1 = (isset($_POST["P1"]) && !empty($_POST["P1"])) ? $_POST["P1"] : false;
    $P2 = (isset($_POST["P2"]) && !empty($_POST["P2"])) ? $_POST["P2"] : false;
    $P3 = (isset($_POST["P3"]) && !empty($_POST["P3"])) ? $_POST["P3"] : false;
    $P4 = (isset($_POST["P4"]) && !empty($_POST["P4"])) ? $_POST["P4"] : false;
    $P5 = (isset($_POST["P5"]) && !empty($_POST["P5"])) ? $_POST["P5"] : false;
    $P6 = (isset($_POST["P6"]) && !empty($_POST["P6"])) ? $_POST["P6"] : false;
    $P7 = (isset($_POST["P7"]) && !empty($_POST["P7"])) ? $_POST["P7"] : false;
    $P8 = (isset($_POST["Comentario"]) && !empty($_POST["Comentario"])) ? $_POST["Comentario"] : false;

    if($Juzgado == false || $Expediente == false || $P1 == false || $P2 == false || $P3 == false || $P4 == false || $P5 == false || $P6 == false || $P7 == false || $P8 == false){
        $Error = new Error_David();
        $Error->DefinirMensaje("Error_Variable");
        $Error->EnviarError();
    }else{
        //Procede a registrar
    }

?>