<?php  
    include_once('conexao.php');
    include_once('mpdf60/mpdf.php'); 
 
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

    public function __construct($css, $titulo, $funcionario) {  
      $this->titulo = $titulo;  
      $this->setarCSS($css);  
      $this->funcionario = $funcionario;
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
      $retorno .= "<div class='esquerda'> <b>Filtros realizados:</b> <br> ";

      $sql_funcionario  =mysql_query("SELECT F.FUN_NOME, F.FUN_SOBRENOME FROM funcionarios F  WHERE F.ID_FUNCIONARIO = '$this->funcionario'");   

      while ($row = mysql_fetch_array($sql_funcionario)){  
         $retorno .= "<b>Funcionário</b> = {$row['FUN_NOME']} {$row['FUN_SOBRENOME']}";  
      }

      $retorno .= "</div><br>";

     /*  
     * FIM da adaptação feita para criar a linha com os filtros realizados.  
     */ 


        
      $retorno .= "<table border='1' width='100%' align='center'>";  
 
      $sql  =mysql_query("SELECT * FROM funcionarios F LEFT JOIN CARGOS C ON F.ID_CARGO = c.ID_CARGO  WHERE F.ID_FUNCIONARIO = '$this->funcionario'");   



      
      while ($row = mysql_fetch_array($sql)){

         $retorno .= "<tr>";
         $retorno .= "<td><font size='2'>CÓDIGO: </font><br>{$row['ID_FUNCIONARIO']}</td>";  
         $retorno .= "<td colspan='2'><font size='2'>NOME: </font><br>{$row['FUN_NOME']} {$row['FUN_SOBRENOME']}</td>";
         $retorno .= "</tr>"; 

         $retorno .= "<tr>";
         $retorno .= "<td><font size='2'>CPF: </font><br>{$row['FUN_CPF']}</td>";  
         $retorno .= "<td><font size='2'>CNH: </font><br>{$row['FUN_CNH']}</td>";
         $retorno .= "<td><font size='2'>DATA NASC.: </font><br>{$row['FUN_DTNASC']}</td>";
         $retorno .= "</tr>"; 

         $retorno .= "<tr>";
         $retorno .= "<td colspan='2'><font size='2'>ENDEREÇO: </font><br>{$row['FUN_ENDERECO']}, {$row['FUN_NUMERO']}</td>";  
         $retorno .= "<td><font size='2'>BAIRRO:: </font><br>{$row['FUN_BAIRRO']}</td>";
         $retorno .= "</tr>"; 

         $retorno .= "<tr>";
         $retorno .= "<td><font size='2'>CIDADE: </font><br>{$row['FUN_CIDADE']} - {$row['FUN_UF']}</td>";  
         $retorno .= "<td><font size='2'>UF: </font><br>{$row['FUN_UF']}</td>";
         $retorno .= "<td><font size='2'>CEP: </font><br>{$row['FUN_CEP']}</td>";
         $retorno .= "</tr>"; 

         $retorno .= "<tr>";
         $retorno .= "<td><font size='2'>FONE FIXO: </font><br>{$row['FUN_FONE1']}</td>";  
         $retorno .= "<td><font size='2'>FONE CELULAR: </font><br>{$row['FUN_FONE2']}</td>";
         $retorno .= "<td><font size='2'>EMAIL:: </font><br>{$row['FUN_EMAIL']}</td>";
         $retorno .= "</tr>"; 

         $retorno .= "<tr>";
         if ($row['FUN_STATUS'] == 1) {
                      $retorno .= "<td><font size='2'>SITUAÇÃO: </font><br>Ativo</td>"; 
                    }
                    else {
                      $retorno .= "<td><font size='2'>SITUAÇÃO: </font><br>Inativo</td>"; 
                    } 
         if ($row['FUN_ACESSO'] == 0) {
                      $retorno .= "<td><font size='2'>NÍVEL ACESSO: </font><br>Nenhum</td>"; 
                    }
                    elseif ($row['FUN_ACESSO'] == 1) {
                      $retorno .= "<td><font size='2'>NÍVEL ACESSO: </font><br>Básico</td>"; 
                    } 
                    elseif ($row['FUN_ACESSO'] == 2) {
                      $retorno .= "<td><font size='2'>NÍVEL ACESSO: </font><br>Intermediário</td>"; 
                    } 
                    elseif ($row['FUN_ACESSO'] == 3) {
                      $retorno .= "<td><font size='2'>NÍVEL ACESSO: </font><br>Avançado</td>"; 
                    } 
         $retorno .= "<td><font size='2'>CARGO: </font><br>{$row['CAR_NOME']}</td>";
         $retorno .= "</tr>"; 
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

   $report = new reportCliente("css/estilo.css", "Ficha do Funcionário", $funcionario);  
   //$report->getDados();
   $report->BuildPDF();  
   $report->Exibir("Ficha do Funcionário");