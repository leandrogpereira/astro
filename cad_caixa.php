<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  if ($_SESSION["acesso"] != 3)
  {
    echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-danger'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> <p align='center'>Área restrita. Verifique suas permissões de acesso.</p>
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
      if(!isset($_POST["enviar"])){
    ?>

        <div class="container theme-showcase" role="main">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">PARA CADASTRAR UM CAIXA, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
            </div>
              <div class="panel-body">

                <h4 class="panel-title">Preencha os campos de agência e conta separando o dígito por traço conforme o exemplo.</h4>
                <form method="POST" action="cad_caixa.php">
                  
                  <div class="row">

                    <div class="col-xs-3 col-md-2">
                      <br>Banco:<br>
                      <input type="text" placeholder="Ex: Banco do Brasil" class="form-control" name="banco" maxlength="80" required="">
                    </div>

                    <div class="col-xs-3 col-md-2">
                      <br>Agência:<br>
                      <input type="text" placeholder="Ex: 9999-9" class="form-control" name="agencia" maxlength="7" required>
                    </div>

                    <div class="col-xs-3 col-md-2">
                      <br>Conta:<br>
                      <input type="text" placeholder="Ex: 9999999-9" class="form-control" name="conta" maxlength="14" required>
                    </div>

                    <div class="col-xs-3 col-md-2">
                      <br>Descrição da conta:<br>
                      <input type="text" placeholder="Ex: 9999999-9 Conta" class="form-control" name="nome" maxlength="80" required>
                    </div>

                    <div class="col-xs-3 col-md-2">
                      <br>Saldo Inicial:<br>
                      <input type="text" id="mascara1" placeholder="Ex.: 10.000,00" class="form-control" name="saldo" maxlength="13" data-thousands="" required>
                    </div>

                  </div>
                    <br><br><br>
                     <button type="submit" class="btn btn-primary btn-lg" name="enviar">Cadastrar</button>
                     <button type="reset" class="btn btn-info btn-lg" name ="limpar">Limpar</button>
                </form>
              </div>
              <br>
            </div>
          </div>      

    <?php

     } else {

      include_once('conexao.php');

      $banco=$_POST["banco"];
      $agencia=$_POST["agencia"];
      $conta=$_POST["conta"];
      $nome=$_POST["nome"];
      $saldo=$_POST["saldo"];  

      $verifica_lancamento = mysql_query("SELECT `AUTO_INCREMENT` AS ID_CAIXA FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'astro' AND TABLE_NAME   = 'caixa';");
      $row = mysql_fetch_array($verifica_lancamento);
      $id_insert = $row["ID_CAIXA"];

      $res = mysql_query("INSERT INTO caixa VALUES (NULL, '$banco','$agencia','$conta','$nome', 1);");

      $ins = mysql_query("INSERT INTO caixas_saldos VALUES (NULL, $id_insert,'$saldo', ".$_SESSION["ano"].");");

      if(mysql_affected_rows()>0){
        echo "
        <div class='container theme-showcase' role='main'>
          <div class='panel panel-success'> 
            <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
            <div class='panel-body'> Item cadastrado com sucesso!<br><br><a href='cad_caixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
          </div>
        </div>
        ";
        mysql_close($conecta);
      } else {
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
  }
?>

</div>

<div class="rodape">
<?php include_once('footer.php'); ?>
</div>
    <!-- Máscara para moeda -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

    <script>
      $(function($) {
        $('#mascara1').maskMoney();
      })
    </script>
            
</div>