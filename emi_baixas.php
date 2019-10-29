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


if (!isset($_POST["tipo"]))
{
$tipo = '';
}
else
{
$tipo = $_POST["tipo"];
}

if (!isset($_POST["situacao"]))
{
$situacao = '';
}
else
{
$situacao = $_POST["situacao"];
}

if (!isset($_POST["caixa"]))
{
$caixa = '';
}
else
{
$caixa = $_POST["caixa"];
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
    private $tipo = null; 
    private $situacao = null; 
    private $caixa = null; 

 
    /*  
    * Construtor da classe  
    * @param $css  - Arquivo CSS  
    * @param $titulo - Título do relatório   
    */  
    //public function __construct($css, $titulo) {  
   //   $this->titulo = $titulo;  
    //  $this->setarCSS($css); 
   // }

    public function __construct($css, $titulo, $dt_inicio, $dt_fim, $vl_inicial, $vl_final, $tipo, $situacao, $caixa) {  
      $this->titulo = $titulo;  
      $this->setarCSS($css); 
      $this->dt_inicio = $dt_inicio; 
      $this->dt_fim = $dt_fim; 
      $this->vl_inicial = $vl_inicial; 
      $this->vl_final = $vl_final; 
      $this->tipo = $tipo; 
      $this->situacao = $situacao; 
      $this->caixa = $caixa; 
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
                    

      if ($this->tipo == '') {
                      $retorno .= "";  
                    }
                    else {
                          switch ($this->tipo) {
                          case 0:
                            $retorno .= "| <b>Tipo</b> = Receita ";
                            break;
                          case 1:
                            $retorno .= "| <b>Tipo</b> = Despesa ";
                            break;
                          case 2:
                            $retorno .= "| <b>Tipo</b> = Contrato ";
                            break;
                          case 3:
                            $retorno .= "| <b>Tipo</b> = Lançamento ";
                            break;
                          default:
                            $retorno .= "";
                            break;
                          }
                    }

                 if ($this->situacao == '') {
                      $retorno .= "";  
                    } elseif ($this->situacao == 1) {
                      $retorno .= "| <b>Situação</b> = Baixado ";
                    }
                    else {
                      $retorno .= "| <b>Situação</b> = Pendente ";
                    } 

      $sql_caixa  = mysql_query("SELECT C.CAI_NOME FROM CAIXA C  WHERE C.ID_CAIXA = '$this->caixa' AND C.ID_CAIXA <> 0");   

      while ($row = mysql_fetch_array($sql_caixa)){  

         $retorno .= " | <b>Caixa</b> = {$row['CAI_NOME']} ";  

      }

      $retorno .= "</div><br>";

     /*  
     * FIM da adaptação feita para criar a linha com os filtros realizados.  
     */ 


        
      $retorno .= "<table border='1' width='100%' align='center'>
                <tr class='header'>  
                <th>Código</th>
                <th>Conta Bancária</th>
                <th>Documento</th>
                <th>Situação</th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Valor (R$)</th>"; 
 
      $sql  =mysql_query("SELECT
                                             *
                                             FROM baixas B
                                             LEFT JOIN caixa C ON C.ID_CAIXA = B.ID_CAIXA
                                             WHERE    ((B.BAI_DATA  >= '$this->dt_inicio') OR ('$this->dt_inicio' = ''))
                                                  AND ((B.BAI_DATA  <= '$this->dt_fim') OR ('$this->dt_fim' = '')) 
                                                  AND ((B.BAI_VALOR  >= '$this->vl_inicial') OR ('$this->vl_inicial' = ''))
                                                  AND ((B.BAI_VALOR  <= '$this->vl_final') OR ('$this->vl_final' = ''))
                                                  AND ((B.ST_BAIXA = '$this->situacao') OR ('$this->situacao' = ''))
                                                  AND ((C.ID_CAIXA = '$this->caixa') OR ('$this->caixa' = ''))
                                                  AND ((B.TP_BAIXA = '$this->tipo') OR ('$this->tipo' = ''))");   

      
      while ($row = mysql_fetch_array($sql)){  


         $retorno .= ($color) ? "<tr>" : "<tr class=\"zebra\">";  
         $retorno .= "<td class='destaque'>{$row['ID_BAIXA']}</td>";  
         $retorno .= "<td>{$row['CAI_NOME']}</td>";  
         $retorno .= "<td>{$row['BAI_DESCRICAO']}</td>"; 


                 if ($row['ST_BAIXA'] == 1) {
                      $retorno .= "<td class='centralizar'>Baixado</td>"; 
                      $retorno .= "<td class='centralizar'>{$row['BAI_DATA']}</td>"; 
                    }
                    else {
                      $retorno .= "<td class='centralizar'>Pendente</td>"; 
                      $retorno .= "<td class='centralizar'>--</td>"; 
                    } 


                    switch ($row['TP_BAIXA']) {
                      case 0:
                        $tipo = "Receita";
                        $valor = number_format(floatval($row['BAI_VALOR']), 2, '.', '');
                        break;
                      case 1:
                        $tipo = "Despesa";
                        $valor = number_format(floatval(-$row['BAI_VALOR']), 2, '.', '');
                        break;
                      case 2:
                        $tipo = "Contrato";
                        $valor = number_format(floatval($row['BAI_VALOR']), 2, '.', '');
                        break;
                      case 3:
                        $tipo = "Lançamento";
                        $valor = number_format(floatval(-$row['BAI_VALOR']), 2, '.', '');
                        break;
                      default:
                        $tipo = "Lançamento";
                        $valor = number_format(floatval($row['BAI_VALOR']), 2, '.', '');

                        break;
                    }
 
         $retorno .= "<td>$tipo</td>";  
         $retorno .= "<td>$valor</td>";  


 
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

   $report = new reportCliente("css/estilo.css", "Relatório de Baixas", $dt_inicio, $dt_fim, $vl_inicial, $vl_final, $tipo, $situacao, $caixa);  
   //$report->getDados();
   $report->BuildPDF();  
   $report->Exibir("Relatório de Baixas");