<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
  
  if ($_SESSION["acesso"] <= 1 || $_POST['id_baixa'] == null)
  {
    echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-danger'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> <p align='center'>Área restrita.</p>
              <div class='text-center'>
              <a href='home.php' class='btn btn-danger' role='button'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</a>
              </div>
              </div> 
            </div>
          </div>
          ";
  }
  else
  {
    $id_baixa = $_POST['id_baixa'];
    $tipo = $_POST['tipo'];
    $documento = $_POST['documento'];
    
    if ($_SESSION["st_periodo"] == 0)
    {
      echo "
      <div class='container theme-showcase' role='main'>
        <div class='panel panel-danger'> 
          <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
          <div class='panel-body'> <p align='center'>Período selecionado não é permitido fazer alterações.</p><br><br><a href='cad_baixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
        </div>
      </div>
      ";
    }
    else
    {
    if(!isset($_POST["enviar"])){
  ?>

  <div class="container theme-showcase" role="main">
  <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">PARA BAIXAR, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
      </div>
      <div class="panel-body">

  <form method="POST" action="cad_baixa_item.php">
    
        <div class="row">
        <div class="col-xs-12 col-md-4">
        <br>Código da baixa:<br>
          <input type="text" class="form-control" placeholder="Ex: 001" name="id_baixa" readonly value=<?php echo $id_baixa; ?>>
        </div>

        <div class="col-xs-12 col-md-4">
        <br>Data da Baixa:<br>
          <input type="text" id="campoData" placeholder="Ex.: 30-06-2016" class="form-control" name="data" required>
        </div>

        <div class="col-xs-12 col-md-4">
        <br>Conta Bancária:<br>
        <select id="campoCaixa" class="form-control" name="caixa">
            <?php 

              $query = mysql_query("SELECT * FROM caixa WHERE CAI_STATUS = 1 AND ID_CAIXA <> 0");
              while ($row = mysql_fetch_array($query)){
                $id_caixa = $row['ID_CAIXA'];
                $cai_nome = $row['CAI_NOME'];

              echo("             
                  <option value='$id_caixa'>$id_caixa - $cai_nome</option>
                  ");
              }

            ?>
        </select>
        </div>
        </div>
        <div class="row">
        <div class="col-xs-12 col-md-4">
        <br>Tipo:<br>
          <input type="text" class="form-control" placeholder="Ex: Receita" name="tipo" readonly value=<?php echo (" '$tipo'"); ?>>
        </div>

        <div class="col-xs-12 col-md-4">
        <br>Documento:<br>
          <input type="text" placeholder="Ex.: NF-XXXX" class="form-control" name="documento" readonly value=<?php echo (" '$documento'"); ?>>
        </div>
        </div>
        <br><br><br>
         <button type="submit" class="btn btn-primary btn-lg" name="enviar">Baixar</button>
         <a href='javascript:history.go(-1);'><button type='button' class='btn btn-info btn-lg'>Voltar</button></a>
      </form>

      <br>

    </div>
  </div>      
  </div>

  <?php

     }
     else
     {

      include_once('funcao.php');

      if (verificaPeriodo($_POST["data"]) == true)
      {
        $id_funcionario=$_SESSION["id_usuario"];
        $data = date('Y-m-d H:i:s', strtotime($_POST["data"]));
        $caixa = $_POST["caixa"];

        $id_baixa = $_POST["id_baixa"];

        $res = mysql_query("UPDATE baixas SET BAI_DATA = '$data', ST_BAIXA = 1, ID_FUNCIONARIO = '$id_funcionario', ID_CAIXA = $caixa, ID_PERIODO = ".$_SESSION["id_periodo"]." WHERE ID_BAIXA = '$id_baixa';"); 

        if(mysql_affected_rows()>0)
        {
          echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-success'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> Baixa realizada com sucesso!<br><br><a href='cad_baixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
            </div>
          </div>
          ";
          mysql_close($conecta);
        }
        else
        {
          $erro = mysql_error();
          echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-danger'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
            </div>
          </div>
          ";
        }
      }
      else
      {
        echo "
              <div class='container theme-showcase' role='main'>
                <div class='panel panel-danger'> 
                  <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                  <div class='panel-body'> <p align='center'>Data inválida para lançamento.</p><br><br><div class='text-center'><a href='cad_baixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div></div> 
                </div>
              </div>
              ";
      }
    }
  }
}
?>

</div>

<div class="rodape">
<?php include_once('footer.php'); ?>
</div>

<!-- Máscara para datas, telefones e senhas -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
       $("#campoTelefone").mask("(99) 9999-9999");
       $("#campoSenha").mask("***-****");
     });
    </script>
            
</div>


