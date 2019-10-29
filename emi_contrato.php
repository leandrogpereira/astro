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


 if (!isset($_POST["ativo"]))
{
$status = '';
}
else
{
$status = $_POST["ativo"];
}


if (!isset($_POST["tp_contrato"]))
{
$tp_contrato = '';
}
else
{
$tp_contrato = $_POST["tp_contrato"];
}


if (!isset($_POST["cliente"]))
{
$cliente = '';
}
else
{
$cliente = $_POST["cliente"];
}



  class reportCliente extends mpdf{  
 
    // Atributos da classe  
    private $pdf  = null;
    private $css  = null;  
    private $titulo = null; 
    private $dt_inicio = null; 
    private $dt_fim = null; 
    private $status = null; 
    private $tp_contrato = null; 
    private $cliente = null; 

 
    /*  
    * Construtor da classe  
    * @param $css  - Arquivo CSS  
    * @param $titulo - Título do relatório   
    */  
    //public function __construct($css, $titulo) {  
   //   $this->titulo = $titulo;  
    //  $this->setarCSS($css); 
   // }

    public function __construct($css, $titulo, $dt_inicio, $dt_fim, $status, $tp_contrato, $cliente) {  
      $this->titulo = $titulo;  
      $this->setarCSS($css); 
      $this->dt_inicio = $dt_inicio; 
      $this->dt_fim = $dt_fim; 
      $this->status = $status; 
      $this->tp_contrato = $tp_contrato; 
      $this->cliente = $cliente;  
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
                      $retorno .= "| <b>Situação</b> = Todas ";  
                    }
                    else if ($this->status == 1){
                      $retorno .= "| <b>Situação</b> = Ativo "; 
                    }
                    else {
                      $retorno .= "| <b>Situação</b> = Inativo "; 
                    }



      $sql_tp_contrato  =mysql_query("SELECT C.TPC_DESCRICAO FROM tp_contrato C  WHERE C.ID_TP_CONTRATO = '$this->tp_contrato'");   

      while ($row = mysql_fetch_array($sql_tp_contrato)){  
         $retorno .= "| <b>Tipo de Contrato</b> = {$row['TPC_DESCRICAO']} ";  
      }



      $sql_cliente  =mysql_query("SELECT P.PES_NOME FROM pessoas P WHERE P.ID_PESSOA = '$this->cliente'");   

      while ($row = mysql_fetch_array($sql_cliente)){  
         $retorno .= "| <b>Cliente</b> = {$row['PES_NOME']}";  
      }

      $retorno .= "</div><br>";  

     /*  
     * FIM da adaptação feita para criar a linha com os filtros realizados.  
     */ 




      $retorno .= "<table border='1' width='100%' align='center'>
                <tr class='header'>  
                <th>Código</th>
                <th>Tipo</th>
                <th>Número</th>
                <th>Cliente</th>
                <th>Início</th>
                <th>Término</th>
                <th>Partida</th>
                <th>Destino</th>
                <th>Descrição</th>
                <th>Vl. Peso (R$)</th>
                <th>Valor (R$)</th>
                <th>Situação</th>";  
 
      $sql  =mysql_query("SELECT
                C.*, P.*, T.*, case c.con_status
                when 0 then 'Inativo'
                when 1 then 'Ativo'
                end AS STATUS
                                             FROM contratos C
                                             LEFT JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA
                                             LEFT JOIN tp_contrato T ON T.ID_TP_CONTRATO = C.ID_TP_CONTRATO
                                                WHERE ((C.CON_DT_INICIO  >= '$this->dt_inicio') OR ('$this->dt_inicio' = ''))
                                                  AND ((C.CON_DT_INICIO  <= '$this->dt_fim') OR ('$this->dt_fim' = '')) 
                                                  AND ((C.CON_STATUS     = '$this->status') OR ('$this->status' = ''))
                                                  AND ((C.ID_TP_CONTRATO = '$this->tp_contrato') OR ('$this->tp_contrato' = ''))
                                                  AND ((C.ID_PESSOA      = '$this->cliente') OR ('$this->cliente' = ''))");   

      
      while ($row = mysql_fetch_array($sql)){  
         $retorno .= ($color) ? "<tr>" : "<tr class=\"zebra\">";  
         $retorno .= "<td class='destaque'>{$row['ID_CONTRATO']}</td>";  
         $retorno .= "<td>{$row['TPC_DESCRICAO']}</td>";  
         $retorno .= "<td>{$row['NR_CONTRATO']}</td>";  
         $retorno .= "<td>{$row['PES_NOME']}</td>";  
         $retorno .= "<td>{$row['CON_DT_INICIO']}</td>";  
         $retorno .= "<td>{$row['CON_DT_FIM']}</td>";  
         $retorno .= "<td>{$row['CON_PARTIDA']}</td>";  
         $retorno .= "<td>{$row['CON_DESTINO']}</td>";  
         $retorno .= "<td>{$row['CON_DESCRICAO']}</td>";  
         $retorno .= "<td>{$row['CON_VL_PESO']}</td>";  
         $retorno .= "<td>{$row['CON_VALOR']}</td>";  
         $retorno .= "<td>{$row['STATUS']}</td>";  
       $retorno .= "<tr>";  
       $color = !$color;  
      }  

      $retorno .= "</table>"; 
      $retorno .= "<br>"; 
      $retorno .= "<table border='1' width='350' align='center'>
                <tr> <th colspan='2'> Filtros Selecionados </th> </tr>
                <tr class='header'>  
                <th>Parâmetro</th>
                <th>Valor</th>"; 
      $retorno .= (true) ? "<tr>" : "<tr class=\"zebra\">";  
      $retorno .= "<td class='destaque'>Data de Inicio</td>";  
      $retorno .= "<td>$this->dt_inicio</td>";  
      $retorno .= "<tr>";
      $retorno .= (false) ? "<tr>" : "<tr class=\"zebra\">";  
      $retorno .= "<td class='destaque'>Data Fim</td>";  
      $retorno .= "<td>$this->dt_fim</td>";  
      $retorno .= "<tr>";
      $retorno .= (true) ? "<tr>" : "<tr class=\"zebra\">";  
      $retorno .= "<td class='destaque'>Status</td>";  
      $retorno .= "<td>$this->status</td>";  
      $retorno .= "<tr>";
      $retorno .= (false) ? "<tr>" : "<tr class=\"zebra\">";  
      $retorno .= "<td class='destaque'>Tipo de Contrato</td>";  
      $retorno .= "<td>$this->tp_contrato</td>";  
      $retorno .= "<tr>";
      $retorno .= (true) ? "<tr>" : "<tr class=\"zebra\">";  
      $retorno .= "<td class='destaque'>Cliente</td>";  
      $retorno .= "<td>$this->cliente</td>";  
      $retorno .= "<tr>";
      $retorno .= "</table>"; 
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

   $report = new reportCliente("css/estilo.css", "Relatório de Contratos", $dt_inicio, $dt_fim, $status, $tp_contrato, $cliente);  
   //$report->getDados();
   $report->BuildPDF();  
   $report->Exibir("Relatório de Contratos");    
