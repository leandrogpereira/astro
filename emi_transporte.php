<?php  
    include_once('conexao.php');
    include_once('mpdf60/mpdf.php'); 
 

if (!isset($_POST["dt_inicio"]) && !isset($_POST["dt_fim"]))
{
$dt_inicio = '';
$dt_fim = '';
}
else if (!isset($_POST["dt_fim"]))
{
$dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["dt_inicio"]));
$dt_fim = '';
}
else if (!isset($_POST["dt_inicio"]))
{
$dt_inicio = '';
$dt_fim = date('Y-m-d H:i:s', strtotime($_POST['dt_fim']));
}
else
{
$dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["dt_inicio"]));
$dt_fim = date('Y-m-d H:i:s', strtotime($_POST['dt_fim']));
}


if (!isset($_POST["vl_inicial"]))
{
$vl_inicial = '';
}
else
{
$vl_inicial = $_POST["vl_inicial"];
}


if (!isset($_POST["vl_final"]))
{
$vl_final = '';
}
else
{
$vl_final = $_POST["vl_final"];
}


if (!isset($_POST["contrato"]))
{
$contrato = '';
}
else
{
$contrato = $_POST["contrato"];
}


if (!isset($_POST["motorista"]))
{
$motorista = '';
}
else
{
$motorista = $_POST["motorista"];
}


if (!isset($_POST["veiculo"]))
{
$veiculo = '';
}
else
{
$veiculo = $_POST["veiculo"];
}



  class reportCliente extends mpdf{  
 
    // Atributos da classe  
    private $pdf  = null;
    private $css  = null;  
    private $titulo = null; 
    private $dt_inicio = null; 
    private $dt_fim = null; 
    private $vl_inicial = null; 
    private $vl_final = null; 
    private $contrato = null; 
    private $motorista = null; 
    private $veiculo = null; 

 
    /*  
    * Construtor da classe  
    * @param $css  - Arquivo CSS  
    * @param $titulo - Título do relatório   
    */  
    //public function __construct($css, $titulo) {  
   //   $this->titulo = $titulo;  
    //  $this->setarCSS($css); 
   // }

    public function __construct($css, $titulo, $dt_inicio, $dt_fim, $vl_inicial, $vl_final, $contrato, $motorista, $veiculo) {  
      $this->titulo = $titulo;  
      $this->setarCSS($css); 
      $this->dt_inicio = $dt_inicio; 
      $this->dt_fim = $dt_fim; 
      $this->vl_inicial = $vl_inicial; 
      $this->vl_final = $vl_final; 
      $this->contrato = $contrato; 
      $this->motorista = $motorista; 
      $this->veiculo = $veiculo; 
      $this->dt_inicio_filter = date('d/m/Y', strtotime($dt_inicio));
      $this->dt_fim_filter = date('d/m/Y', strtotime($dt_fim));
    }
 
    /*  
    * Método para setar o conteúdo do arquivo CSS para o atributo css  
    * @param $file - Caminho para arquivo CSS  
    */  
    public function setarCSS($file){  
     if (file_exists($file)):  
       $this->css = file_get_contents($file);  
     else:  
       echo 'Arquivo inexistente!';  
     endif;  
    }  
 
    /*  
    * Método para montar o Cabeçalho do relatório em PDF  
    */  
    protected function getHeader(){  
       $data = date('d/m/Y',time());  
       $retorno = "<table class=\"tbl_header\" width=\"100%\">  
               <tr>  
                 <td  width=\"30%\" align=\"left\"><img src='img/pdf.png'/></td> 
                 <td  width=\"40%\" align=\"center\"><h2 style=\"text-align:center\">{$this->titulo}</h2></td>  
                 <td  width=\"30%\" align=\"right\">Gerado em: $data</td>  
               </tr>  
             </table>";  
       return $retorno;  
     }  
 
     /*  
     * Método para montar o Rodapé do relatório em PDF  
     */  
     protected function getFooter(){  
       $retorno = "<table class=\"tbl_footer\" width=\"100%\">  
               <tr>  
                 <td align=\"left\"><a href=''>www.astrotransportes.com.br</a></td>  
                 <td align=\"right\">Página: {PAGENO}</td>  
               </tr>  
             </table>";  
       return $retorno;  
     }  
 
    /*   
    * Método para construir a tabela em HTML com todos os dados  
    * Esse método também gera o conteúdo para o arquivo PDF  
    */  
    private function getTabela(){  
      $color  = false;  
      $retorno = "";  




     /*  
     * INICIO da adaptação feita para criar a linha com os filtros realizados.  
     */ 
      $retorno .= "<div class='esquerda'> <b>Filtros realizados:</b> <br> <b>Data Inicio</b> = $this->dt_inicio_filter | <b>Data Fim</b> = $this->dt_fim_filter ";

      if ($this->vl_inicial == '') {
                      $retorno .= "";  
                    }
                    else {
                      $retorno .= "| <b>Valor Inicial</b> = $this->vl_inicial "; 
                    }




      if ($this->vl_final == '') {
                      $retorno .= "";  
                    }
                    else {
                      $retorno .= "| <b>Valor Final</b> = $this->vl_final "; 
                    }



      $sql_tp_despesa  =mysql_query("SELECT C.ID_CONTRATO, C.NR_CONTRATO, P.PES_NOME  FROM contratos C LEFT JOIN pessoas P ON C.ID_PESSOA = P.ID_PESSOA  WHERE C.ID_CONTRATO = '$this->contrato'");   

      while ($row = mysql_fetch_array($sql_tp_despesa)){  
         $retorno .= " <b>|Contrato</b> = {$row['NR_CONTRATO']} - {$row['PES_NOME']}";  
      }


      $sql_motorista  =mysql_query("SELECT F.FUN_NOME FROM funcionarios F  WHERE F.ID_FUNCIONARIO = '$this->motorista'");   

      while ($row = mysql_fetch_array($sql_motorista)){  
         $retorno .= "| <b>Motorista</b> = {$row['FUN_NOME']}";  
      }


      $sql_veiculo  =mysql_query("SELECT V.VEI_MARCA, V.VEI_PLACA_COD FROM veiculos V WHERE V.ID_VEICULO= '$this->veiculo' AND V.ID_VEICULO <> 0");   

      while ($row = mysql_fetch_array($sql_veiculo)){  
         $retorno .= "| <b>Veículo</b> = {$row['VEI_MARCA']} - {$row['VEI_PLACA_COD']} ";  
      }





      $retorno .= "</div><br>";

     /*  
     * FIM da adaptação feita para criar a linha com os filtros realizados.  
     */ 


        
      $retorno .= "<table border='1' width='100%' align='center'>
                <tr class='header'>  
                <th>Código</th>
                <th>Data</th>
                <th>Observação</th>
                <th>Veículo</th>
                <th>Motorista</th>
                <th>Tipo de Contrato</th>
                <th>Contrato</th>
                <th>Nota</th>
                <th>Peso (Ton)</th>";  
 
      $sql  =mysql_query("SELECT
                                             T.ID_TRANSPORTE
                                            ,date_format(T.TRA_DATA, '%d/%m/%Y') TRAN_DATA
                                            ,T.TRA_NOTA
                                            ,T.TRA_PESO
                                            ,T.TRA_OBSERVACAO
                                            ,V.VEI_MODELO
                                            ,V.VEI_MARCA
                                            ,V.VEI_PLACA_COD
                                            ,F.FUN_NOME
                                            ,F.FUN_SOBRENOME
                                            ,TP.TPC_DESCRICAO
                                            ,C.NR_CONTRATO
                                            ,P.PES_NOME
                                             FROM transportes T
                                             LEFT JOIN contratos C ON C.ID_CONTRATO = T.ID_CONTRATO
                                             LEFT JOIN tp_contrato TP ON TP.ID_TP_CONTRATO = C.ID_TP_CONTRATO
                                             LEFT JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA
                                             LEFT JOIN funcionarios F ON F.ID_FUNCIONARIO = T.ID_FUNCIONARIO
                                             LEFT JOIN veiculos V ON V.ID_VEICULO = T.ID_VEICULO
                                                WHERE ((DATE(T.TRA_DATA)  >= '$this->dt_inicio') OR ('$this->dt_inicio' = ''))
                                                  AND ((DATE(T.TRA_DATA)  <= '$this->dt_fim') OR ('$this->dt_fim' = '')) 
                                                  AND ((T.TRA_PESO  >= '$this->vl_inicial') OR ('$this->vl_inicial' = ''))
                                                  AND ((T.TRA_PESO  <= '$this->vl_final') OR ('$this->vl_final' = ''))
                                                  AND ((T.ID_VEICULO = '$this->veiculo') OR ('$this->veiculo' = ''))
                                                  AND ((C.ID_CONTRATO = '$this->contrato') OR ('$this->contrato' = ''))
                                                  AND ((F.ID_FUNCIONARIO = '$this->motorista') OR ('$this->motorista' = ''))");   

      
      while ($row = mysql_fetch_array($sql)){  
         $retorno .= ($color) ? "<tr>" : "<tr class=\"zebra\">";  
         $retorno .= "<td class='destaque'>{$row['ID_TRANSPORTE']}</td>";  
         $retorno .= "<td>{$row['TRAN_DATA']}</td>";  
         $retorno .= "<td>{$row['TRA_OBSERVACAO']}</td>";  
         $retorno .= "<td>{$row['VEI_MARCA']} - {$row['VEI_PLACA_COD']}</td>";  
         $retorno .= "<td>{$row['FUN_NOME']} {$row['FUN_SOBRENOME']}</td>";  
         $retorno .= "<td>{$row['TPC_DESCRICAO']}</td>";  
         $retorno .= "<td>{$row['NR_CONTRATO']} - {$row['PES_NOME']}</td>";   
         $retorno .= "<td>{$row['TRA_NOTA']}</td>";  
         $retorno .= "<td>{$row['TRA_PESO']}</td>";  
         $retorno .= "<tr>";  
         $color = !$color;  
        }

      $retorno .= "</table>"; 
      $retorno .= "<br>"; 
     
      return $retorno;  
    } 
 
    /*   
    * Método para construir o arquivo PDF  
    */  
    public function BuildPDF(){  
     $this->pdf = new mPDF('utf-8', 'A4-L');  
     $this->pdf->WriteHTML($this->css, 1);  
     $this->pdf->SetHTMLHeader($this->getHeader());  
     $this->pdf->SetHTMLFooter($this->getFooter()); 
     $this->pdf->AddPage('L', // L - landscape, P - portrait 
        '', '', '', '',
        10, // margin_left
        10, // margin right
        30, // margin top
        20, // margin bottom
        10, // margin header
        10); // margin footer 
     $this->pdf->WriteHTML($this->getTabela());   
    }   

    /*public function getDados(){  
echo ('Cliente:');
echo $this->cliente;echo('<br>');
echo ('Dt Fim:');
echo $this->dt_fim;echo('<br>');
echo ('Tp Contrato:');
echo $this->tp_contrato;echo('<br>');
echo ('Status:');
echo $this->status;echo('<br>');
echo ('Dt Inicio:');
echo $this->dt_inicio;echo('<br>');
    }*/

 
    /*   
    * Método para exibir o arquivo PDF  
    * @param $name - Nome do arquivo se necessário grava-lo  
    */  
    public function Exibir($name) {  
     $this->pdf->Output($name, 'I');  
    }  
  } 

   $report = new reportCliente("css/estilo.css", "Relatório de Transportes", $dt_inicio, $dt_fim, $vl_inicial, $vl_final, $contrato, $motorista, $veiculo);
   //$report->getDados();
   $report->BuildPDF();  
   $report->Exibir("Relatório de Transportes");    
