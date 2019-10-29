<?php  
    include_once('conexao.php');
    include_once('mpdf60/mpdf.php'); 
 

 if (!isset($_POST["mes"]))
{
$mes = '';
}
else
{
$mes = $_POST["mes"];
}



  class reportCliente extends mpdf{  
 
    // Atributos da classe  
    private $pdf  = null;
    private $css  = null;  
    private $titulo = null; 
    private $mes = null; 


 
    /*  
    * Construtor da classe  
    * @param $css  - Arquivo CSS  
    * @param $titulo - Título do relatório   
    */  
    //public function __construct($css, $titulo) {  
   //   $this->titulo = $titulo;  
    //  $this->setarCSS($css); 
   // }

    public function __construct($css, $titulo, $mes) {  
      $this->titulo = $titulo;  
      $this->setarCSS($css); 
      $this->mes = $mes; 
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
      $smes = "";  



        switch ($this->mes) {
    case '2016/01/01':
        $smes = "Janeiro";
        break;
    case '2016/02/01':
        $smes = "Fevereiro";
        break;
    case '2016/03/01':
        $smes = "Março";
        break;
    case '2016/04/01':
        $smes = "Abril";
        break;
    case '2016/05/01':
        $smes = "Maio";
        break;
    case '2016/06/01':
        $smes = "Junho ";
        break;
    case '2016/07/01':
        $smes = "Julho";
        break;
    case '2016/08/01':
        $smes = "Agosto";
        break;
    case '2016/09/01':
        $smes = "Setembro";
        break;
    case '2016/10/01':
        $smes = "Outubro";
        break;
    case '2016/11/01':
        $smes = "Novembro";
        break;
    case '2016/12/01':
        $smes = "Dezembro";
        break;
    default:
        $smes = "Mês Selecionado Incorretamente";
        }


      $retorno .= "<h2 style=\"text-align:center\">Mês Selecionado: <u>$smes</u></h2>";


      $retorno .= "<table border='1' width='100%' align='center'>
                <tr class='header'>  
                <th>Nome do Funcionário</th>
                <th>Aniversário</th>";  
 
      $sql  =mysql_query("SELECT 
        MONTH(F.FUN_DTNASC) MES_NASC,
        case MONTH(F.FUN_DTNASC)
                when 1 then 'Janeiro'
                when 2 then 'Fevereiro'
                when 3 then 'Março'
                when 4 then 'Abril'
                when 5 then 'Maio'
                when 6 then 'Junho'
                when 7 then 'Julho'
                when 8 then 'Agosto'
                when 9 then 'Setembro'
                when 10 then 'Outubro'
                when 11 then 'Novembro'
                when 12 then 'Dezembro'
                end AS STRING_MES, 
        CONCAT(F.FUN_NOME, ' ', F.FUN_SOBRENOME) NOME_FUN,  
        CONCAT(DAY(F.FUN_DTNASC), '/',  MONTH(F.FUN_DTNASC)) ANIVERSARIO 

        FROM `funcionarios` F 
        WHERE ((MONTH(F.FUN_DTNASC)  = MONTH('$this->mes')) OR ('$this->mes' = ''))");   

      
      while ($row = mysql_fetch_array($sql)){  
         $retorno .= ($color) ? "<tr>" : "<tr class=\"zebra\">";  
         $retorno .= "<td class='destaqueleft'>{$row['NOME_FUN']}</td>";  
         $retorno .= "<td class='centralizar'>{$row['ANIVERSARIO']}</td>";  
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
     $this->pdf->AddPage('P', // L - landscape, P - portrait 
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
echo ('Mês:');
echo $this->mes;echo('<br>');
    }*/

 
    /*   
    * Método para exibir o arquivo PDF  
    * @param $name - Nome do arquivo se necessário grava-lo  
    */  
    public function Exibir($name) {  
     $this->pdf->Output($name, 'I');  
    }  
  } 

   $report = new reportCliente("css/estilo.css", "Aniversáriantes", $mes);  
   //$report->getDados();
   $report->BuildPDF();  
   $report->Exibir("Relatório de Aniversáriantes");    
