<?php
    class Juzgado extends ConexionBD{

        public function Obtener_Juzgado($ID=0){
            $Conectar_Base = $this->Conectar();
            $Sentencias_Consulta = $this->Sentencias_Consulta_Juzgado($ID);
            $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Juzgado"]);
            $Numero_Resultados = $ResultadoConsulta->num_rows;
            $Validar = new Validar();
            $Validar->Validar_Resultado_ID($Numero_Resultados,$ID);
            
            while ($Resultado = $ResultadoConsulta->fetch_row()) {
                $Juzgado = $Resultado[0];
            }
            
            $Conectar_Base->close();
            return $Juzgado;
        }

        public function Obtener_Juez($ID=0){
            $Conectar_Base = $this->Conectar();
            $Sentencias_Consulta = $this->Sentencias_Consulta_Juzgado($ID);
            $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Juez"]);
            $Numero_Resultados = $ResultadoConsulta->num_rows;
            
            $Validar = new Validar();
            $Validar->Validar_Resultado_ID($Numero_Resultados,$ID);
            
            while ($Resultado = $ResultadoConsulta->fetch_row()) {
                $Juez = $Resultado[0];
            }
            
            $Conectar_Base->close();
            return $Juez;
        }

        public function Obtener_Info($ID=0){
            $Conectar_Base = $this->Conectar();
            $Sentencias_Consulta = $this->Sentencias_Consulta_Juzgado($ID);
            $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Juez"]);
            $Numero_Resultados = $ResultadoConsulta->num_rows;
            
            $Validar = new Validar();
            $Validar->Validar_Resultado_ID($Numero_Resultados,$ID);
            
            while ($Resultado = $ResultadoConsulta->fetch_row()) {
                $Info = $Resultado[0];
            }
            
            $Conectar_Base->close();
            return $Info;
        }

        public function Obtener_Info_General(){
            $General_Juzgados = array();
            $Juzgado = array();
            $Contador = 0;
            $Conectar_Base = $this->Conectar();
            $Sentencias_Consulta = $this->Sentencias_Consulta_Juzgado();
            $ResultadoConsulta = $Conectar_Base->query($Sentencias_Consulta["Consultar_Info_General"]);
            $Conectar_Base->close();            
            while ($Resultado = $ResultadoConsulta->fetch_row()) {
                $Juzgado['ID_Juzgado'] = $Resultado[0];
                $Juzgado['Juzgado'] = $Resultado[1];
                $Juzgado['Juez'] = $Resultado[2];
                $General_Juzgados[$Contador] = $Juzgado;
                $Contador++;
            }
            return $General_Juzgados;
        }
    }
?>