<?php

    class Encuesta extends ConexionBD{
        
        public function Registrar_Encuesta_Publico($Juzgado,$Juez,$Expediente,$Parte,$P1,$P2,$P3,$P4,$P5,$P6,$P7,$P8){
            $Conectar_Base = $this->Conectar();
            $Sentencias_Registro = $this->Sentencias_Registro_Encuesta($Juzgado,$Juez,$Expediente,$Parte,$P1,$P2,$P3,$P4,$P5,$P6,$P7,$P8);
            $Conectar_Base->query($Sentencias_Registro["Registrar_Encuesta_Publico"]);
            $Conectar_Base->close();
        }

        public function Consultar_Encuesta_ID($ID){
            $Encuesta = array();
            $Conectar_Base = $this->Conectar();
            $Sentencias_Consulta = $this->Sentencias_Consulta_Encuesta($ID);
            $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Encuesta_ID"]);
            $Conectar_Base->close();
            $Numero_Resultados = $ResultadoConsulta->num_rows;
            $Validar = new Validar();
            $Validar->Validar_Resultado_ID($Numero_Resultados,$ID);           
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

        public function Consultar_Encuestas(){
            $Juzgado = new Juzgado();
            $Juzgados = $Juzgado->Obtener_Info_General();
            $Encuesta = array();
            $General_Encuestas = array();
            $Totales_Juzgado = array();
            $Contador = 0;
            $Conectar_Base = $this->Conectar();
            $Sentencias_Consulta = $this->Sentencias_Consulta_Encuesta();
            $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Encuestas"]);
            $Conectar_Base->close();
            while ($Resultado = $ResultadoConsulta->fetch_row()){
                $Encuesta['ID_Encuesta'] = $Resultado[0];
                $Encuesta['Juzgado'] = $Resultado[1];
                $Encuesta['Expediente'] = $Resultado[2];
                $General_Encuestas[$Contador] = $Encuesta;
                foreach ($Juzgados as $Juzgado) {
                    if($Juzgado['Juzgado'] == $Encuesta['Juzgado']){
                        if(array_key_exists($Juzgado['Juzgado'], $Totales_Juzgado)){
                            $Totales_Juzgado[$Juzgado['Juzgado']]++;
                        }else{
                            $Totales_Juzgado[$Juzgado['Juzgado']] = 0;
                            $Totales_Juzgado[$Juzgado['Juzgado']]++;
                        }                        
                    }
                } 
        		$Contador++;
            }
            $Datos['Encuestas'] = $General_Encuestas;
            $Datos['Total_Encuestas'] = $Contador;
            $Datos['Totales_Juzgado'] = $Totales_Juzgado;
            echo json_encode($Datos);
        }

    }
?>