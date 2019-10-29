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


if (!isset($_POST["ativo"]))
{
$status = '';
}
else
{
$status = $_POST["ativo"];
}


if (!isset($_POST["tp_despesa"]))
{
$tp_despesa = '';
}
else
{
$tp_despesa = $_POST["tp_despesa"];
}


if (!isset($_POST["fornecedor"]))
{
$fornecedor = '';
}
else
{
$fornecedor = $_POST["fornecedor"];
}


if (!isset($_POST["funcionario"]))
{
$funcionario = '';
}
else
{
$funcionario = $_POST["funcionario"];
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
    private $status = null; 
    private $tp_despesa = null; 
    private $fornecedor = null; 
    private $funcionario = null; 

 
    /*  
    * Construtor da classe  
    * @param $css  - Arquivo CSS  
    * @param $titulo - Título do relatório   
    */  
    //public function __construct($css, $titulo) {  
   //   $this->titulo = $titulo;  
    //  $this->setarCSS($css); 
   // }

    public function __construct($css, $titulo, $dt_inicio, $dt_fim, $vl_inicial, $vl_final, $status, $tp_despesa, $fornecedor, $funcionario) {  
      $this->titulo = $titulo;  
      $this->setarCSS($css); 
      $this->dt_inicio = $dt_inicio; 
      $this->dt_fim = $dt_fim; 
      $this->vl_inicial = $vl_inicial; 
      $this->vl_final = $vl_final; 
      $this->status = $status; 
      $this->tp_despesa = $tp_despesa; 
      $this->fornecedor = $fornecedor; 
      $this->funcionario = $funcionario;  
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


      if ($this->status == '') {
                      $retorno .= "";  
                    }
                    else if ($this->status == 1){
                      $retorno .= "| <b>Situação</b> = Baixado "; 
                    }
                    else {
                      $retorno .= "| <b>Situação</b> = Pendente "; 
                    }



      $sql_tp_despesa  =mysql_query("SELECT T.TPD_DESCRICAO FROM tp_despesas T  WHERE T.ID_TP_DESPESA = '$this->tp_despesa'");   

      while ($row = mysql_fetch_array($sql_tp_despesa)){  
         $retorno .= " <b>|Despesa</b> = {$row['TPD_DESCRICAO']} ";  
      }



      $sql_fornecedor  =mysql_query("SELECT P.PES_NOME FROM pessoas P WHERE P.ID_PESSOA = '$this->fornecedor'");   

      while ($row = mysql_fetch_array($sql_fornecedor)){  
         $retorno .= "| <b>Fornecedor</b> = {$row['PES_NOME']} ";  
      }



      $sql_funcionario  =mysql_query("SELECT F.FUN_NOME FROM funcionarios F  WHERE F.ID_FUNCIONARIO = '$this->funcionario'");   

      while ($row = mysql_fetch_array($sql_funcionario)){  
         $retorno .= "| <b>Funcionário</b> = {$row['FUN_NOME']}";  
      }

      $retorno .= "</div><br>";

     /*  
     * FIM da adaptação feita para criar a linha com os filtros realizados.  
     */ 


        
      $retorno .= "<table border='1' width='100%' align='center'>
                <tr class='header'>  
                <th>Código</th>
                <th>Data</th>
                <th>Nota</th>
                <th>Tipo</th>
                <th>Fornecedor</th>
                <th>Responsável</th>
                <th>Descrição</th>
                <th>Valor (R$)</th>
                <th>Situação</th>
                <th>Data da Baixa</th>";  
 
      $sql  =mysql_query("SELECT
                                             D.ID_DESPESA
                                            ,date_format(D.DES_DATA, '%d/%m/%Y') DESC_DATA
                                            ,D.DES_NOTA
                                            ,D.DES_DESCRICAO
                                            ,P.PES_NOME
                                            ,T.TPD_DESCRICAO
                                            ,F.FUN_NOME
                                            ,F.FUN_SOBRENOME
                                            ,B.BAI_VALOR
                                            ,date_format(B.BAI_DATA, '%d/%m/%Y') BAIX_DATA
                                            ,B.ST_BAIXA
                                             FROM despesas D
                                             LEFT JOIN pessoas P ON P.ID_PESSOA = D.ID_PESSOA
                                             LEFT JOIN tp_despesas T ON T.ID_TP_DESPESA = D.ID_TP_DESPESA
                                             LEFT JOIN funcionarios F ON F.ID_FUNCIONARIO = D.ID_FUNCIONARIO
                                             LEFT JOIN baixas B ON B.ID_DESPESA = D.ID_DESPESA
                                            WHERE ((D.DES_DATA  >= '$this->dt_inicio') OR ('$this->dt_inicio' = ''))
                                            AND ((D.DES_DATA  <= '$this->dt_fim') OR ('$this->dt_fim' = '')) 
                                            AND ((B.BAI_VALOR  >= '$this->vl_inicial') OR ('$this->vl_inicial' = ''))
                                            AND ((B.BAI_VALOR  <= '$this->vl_final') OR ('$this->vl_final' = ''))
                                            AND ((B.ST_BAIXA = '$this->status') OR ('$this->status' = ''))
                                            AND ((D.ID_TP_DESPESA = '$this->tp_despesa') OR ('$this->tp_despesa' = ''))
                                            AND ((D.ID_PESSOA = '$this->fornecedor') OR ('$this->fornecedor' = ''))
                                            AND ((D.ID_FUNCIONARIO = '$this->funcionario') OR ('$this->funcionario' = ''))
                                               ");   

      
      while ($row = mysql_fetch_array($sql)){  
         $retorno .= ($color) ? "<tr>" : "<tr class=\"zebra\">";  
         $retorno .= "<td class='destaque'>{$row['ID_DESPESA']}</td>";  
         $retorno .= "<td>{$row['DESC_DATA']}</td>";  
         $retorno .= "<td>{$row['DES_NOTA']}</td>";  
         $retorno .= "<td>{$row['TPD_DESCRICAO']}</td>";  
         $retorno .= "<td>{$row['PES_NOME']}</td>";  
         $retorno .= "<td>{$row['FUN_NOME']}</td>";  
         $retorno .= "<td>{$row['DES_DESCRICAO']}</td>";  
         $retorno .= "<td>{$row['BAI_VALOR']}</td>";  

        if ($row['ST_BAIXA'] == 1) {
                      $retorno .= "<td class='centralizar'>Baixado</td>"; 
                      $retorno .= "<td class='centralizar'>{$row['BAIX_DATA']}</td>"; 
                    }
                    else {
                      $retorno .= "<td class='centralizar'>Pendente</td>"; 
                      $retorno .= "<td class='centralizar'>--</td>"; 
                    }
 
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

   $report = new reportCliente("css/estilo.css", "Relatório de Despesas", $dt_inicio, $dt_fim, $vl_inicial, $vl_final, $status, $tp_despesa, $fornecedor, $funcionario);  
   //$report->getDados();
   $report->BuildPDF();  
   $report->Exibir("Relatório de Despesas");    
