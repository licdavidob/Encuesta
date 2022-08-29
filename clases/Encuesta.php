<?php

class Encuesta extends ConexionBD
{

    public function Registrar_Encuesta_Publico($Juzgado, $Juez, $Expediente, $Parte, $P1, $P2, $P3, $P4, $P5, $P6, $P7, $P8)
    {
        $Conectar_Base = $this->Conectar();
        $Sentencias_Registro = $this->Sentencias_Registro_Encuesta($Juzgado, $Juez, $Expediente, $Parte, $P1, $P2, $P3, $P4, $P5, $P6, $P7, $P8);
        $Conectar_Base->query($Sentencias_Registro["Registrar_Encuesta_Publico"]);
        $Conectar_Base->close();
    }

    public function Consultar_Encuesta_ID($ID)
    {
        $Encuesta = array();
        $Conectar_Base = $this->Conectar();
        $Sentencias_Consulta = $this->Sentencias_Consulta_Encuesta($ID);
        $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Encuesta_ID"]);
        $Conectar_Base->close();
        $Numero_Resultados = $ResultadoConsulta->num_rows;
        $Validar = new Validar();
        $Validar->Validar_Resultado_ID($Numero_Resultados, $ID);
        while ($Resultado = $ResultadoConsulta->fetch_row()) {
            $Encuesta['Juzgado'] = $Resultado[0];
            $Encuesta['Expediente'] = $Resultado[1];
            $Encuesta['Parte'] = $Resultado[2];
            $Encuesta['P1'] = $Resultado[3];
            $Encuesta['P2'] = $Resultado[4];
            $Encuesta['P3'] = $Resultado[5];
            $Encuesta['P4'] = $Resultado[6];
            $Encuesta['P5'] = $Resultado[7];
            $Encuesta['P6'] = $Resultado[8];
            $Encuesta['P7'] = $Resultado[9];
            $Encuesta['P8'] = $Resultado[10];
        }

        echo json_encode($Encuesta);
    }

    public function Consultar_Encuestas()
    {
        $Juzgado = new Juzgado();
        $Juzgados = $Juzgado->Obtener_Info_General();
        $Encuesta = array();
        $General_Encuestas = array();
        $Totales_Juzgado = array();
        $Top_Juzgados = array();
        $Estadistica = array();
        $Preguntas_Si = array(
            "P1" => 0,
            "P2" => 0,
            "P3" => 0,
            "P4" => 0,
            "P5" => 0,
            "P6" => 0,
            "P7" => 0,
        );
        $Preguntas_No = array(
            "P1" => 0,
            "P2" => 0,
            "P3" => 0,
            "P4" => 0,
            "P5" => 0,
            "P6" => 0,
            "P7" => 0,
        );
        $Total_Actor = 0;
        $Total_Demandado = 0;
        $Total_Otro = 0;
        $Contador = 0;
        $Detener_Foreach = 0;
        $Conectar_Base = $this->Conectar();
        $Sentencias_Consulta = $this->Sentencias_Consulta_Encuesta();
        $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Encuestas"]);
        $Conectar_Base->close();
        while ($Resultado = $ResultadoConsulta->fetch_row()) {
            $Encuesta['ID_Encuesta'] = $Resultado[0];
            $Encuesta['Juzgado'] = $Resultado[1];
            $Encuesta['Expediente'] = $Resultado[2];
            $Encuesta['Parte'] = $Resultado[3];
            $Encuesta['Fecha'] = $Resultado[4];
            $General_Encuestas[$Contador] = $Encuesta;
            foreach ($Juzgados as $Juzgado) {
                if ($Juzgado['Juzgado'] == $Encuesta['Juzgado']) {
                    if (array_key_exists($Juzgado['Juzgado'], $Totales_Juzgado)) {
                        $Totales_Juzgado[$Juzgado['Juzgado']]++;
                    } else {
                        $Totales_Juzgado[$Juzgado['Juzgado']] = 0;
                        $Totales_Juzgado[$Juzgado['Juzgado']]++;
                    }
                }
            }
            if ($Resultado[3] == 1) {
                $Total_Actor++;
            }
            if ($Resultado[3] == 2) {
                $Total_Demandado++;
            }
            if ($Resultado[3] == 3) {
                $Total_Otro++;
            }

            // SI = 1 -- NO = 2 
            if ($Resultado[5] == 1) {
                $Preguntas_Si['P1']++;
            } else {
                $Preguntas_No['P1']++;
            }
            if ($Resultado[6] == 1) {
                $Preguntas_Si['P2']++;
            } else {
                $Preguntas_No['P2']++;
            }
            if ($Resultado[7] == 1) {
                $Preguntas_Si['P3']++;
            } else {
                $Preguntas_No['P3']++;
            }
            if ($Resultado[8] == 1) {
                $Preguntas_Si['P4']++;
            } else {
                $Preguntas_No['P4']++;
            }
            if ($Resultado[9] == 1) {
                $Preguntas_Si['P5']++;
            } else {
                $Preguntas_No['P5']++;
            }
            if ($Resultado[10] == 1) {
                $Preguntas_Si['P6']++;
            } else {
                $Preguntas_No['P6']++;
            }
            if ($Resultado[11] == 1) {
                $Preguntas_Si['P7']++;
            } else {
                $Preguntas_No['P7']++;
            }

            $Contador++;
        }

        arsort($Totales_Juzgado);
        foreach ($Totales_Juzgado as $Juzgado => $Valor) {
            $Top_Juzgados[$Juzgado] = $Valor;
            $Detener_Foreach++;
            if ($Detener_Foreach == 5) {
                break;
            }
        }
        $Preguntas_Si_No['Si'] = $Preguntas_Si;
        $Preguntas_Si_No['No'] = $Preguntas_No;

        $Estadistica['Top_Juzgados'] = $Top_Juzgados;
        $Estadistica['Preguntas'] = $Preguntas_Si_No;

        $Datos['data'] = $General_Encuestas;
        $Datos['Total_Encuestas'] = $Contador;
        $Datos['Total_Actor'] = $Total_Actor;
        $Datos['Total_Demandado'] = $Total_Demandado;
        $Datos['Total_Otro'] = $Total_Otro;
        // $Datos['Total_Juzgado'] = $Totales_Juzgado;
        $Datos['Estadistica'] = $Estadistica;
        echo json_encode($Datos);
    }

    public function Consultar_Encuestas_Fecha($Inicio, $Fin)
    {
        $Juzgado = new Juzgado();
        $Juzgados = $Juzgado->Obtener_Info_General();
        $Encuesta = array();
        $General_Encuestas = array();
        $Totales_Juzgado = array();
        $Top_10 = array();
        $Total_Actor = 0;
        $Total_Demandado = 0;
        $Total_Otro = 0;
        $Contador = 0;
        $Detener_Foreach = 0;
        $Conectar_Base = $this->Conectar();
        $Sentencias_Consulta = $this->Sentencias_Consulta_Encuesta($ID = 0, $Inicio, $Fin);
        $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Encuestas_Fecha"]);
        $Conectar_Base->close();
        while ($Resultado = $ResultadoConsulta->fetch_row()) {
            $Encuesta['ID_Encuesta'] = $Resultado[0];
            $Encuesta['Juzgado'] = $Resultado[1];
            $Encuesta['Expediente'] = $Resultado[2];
            $Encuesta['Parte'] = $Resultado[3];
            $Encuesta['Fecha'] = $Resultado[4];
            $General_Encuestas[$Contador] = $Encuesta;
            foreach ($Juzgados as $Juzgado) {
                if ($Juzgado['Juzgado'] == $Encuesta['Juzgado']) {
                    if (array_key_exists($Juzgado['Juzgado'], $Totales_Juzgado)) {
                        $Totales_Juzgado[$Juzgado['Juzgado']]++;
                    } else {
                        $Totales_Juzgado[$Juzgado['Juzgado']] = 0;
                        $Totales_Juzgado[$Juzgado['Juzgado']]++;
                    }
                }
            }
            if ($Resultado[3] == 1) {
                $Total_Actor++;
            }
            if ($Resultado[3] == 2) {
                $Total_Demandado++;
            }
            if ($Resultado[3] == 3) {
                $Total_Otro++;
            }
            $Contador++;
        }

        arsort($Totales_Juzgado);
        foreach ($Totales_Juzgado as $Juzgado => $Valor) {
            $Top_10[$Juzgado] = $Valor;
            $Detener_Foreach++;
            if ($Detener_Foreach == 5) {
                break;
            }
        }

        $Datos['data'] = $General_Encuestas;
        $Datos['Total_Encuestas'] = $Contador;
        $Datos['Total_Actor'] = $Total_Actor;
        $Datos['Total_Demandado'] = $Total_Demandado;
        $Datos['Total_Otro'] = $Total_Otro;
        $Datos['Total_Juzgado'] = $Totales_Juzgado;
        $Datos['Top_10'] = $Top_10;
        echo json_encode($Datos);
    }

    public function Eliminar_Encuesta_ID($ID)
    {
        $Conectar_Base = $this->Conectar();
        $Sentencias_Consulta = $this->Sentencias_Consulta_Encuesta($ID);
        $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Encuesta_ID"]);
        $Numero_Resultados = $ResultadoConsulta->num_rows;
        $Validar = new Validar();
        $Validar->Validar_Resultado_ID($Numero_Resultados, $ID);
        $Sentencias_Eliminar = $this->Sentencias_Eliminar_Encuesta($ID);
        $Conectar_Base->query($Sentencias_Eliminar["Sentencias_Eliminar_Encuesta"]);
        $Conectar_Base->close();
        return true;
    }
}
