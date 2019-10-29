<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  if ($_SESSION["acesso"] <= 1)
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
            <h3 class="panel-title">PARA CADASTRAR UM NOVO CARGO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
          </div>
            <div class="panel-body">
              <form method="POST" action="cad_tp_cargo.php">
                <div class="row">
                  <div class="col-xs-6 col-md-4">
                    <br>Cargo:<br>
                    <input type="text" placeholder="Ex: Motorista" class="form-control" name="cargo" maxlength="45" required>
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

    $cargo=$_POST["cargo"];

    $res = mysql_query("INSERT INTO cargos VALUES (NULL,'$cargo',1);"); 

    if(mysql_affected_rows()>0){
      echo "
      <div class='container theme-showcase' role='main'>
        <div class='panel panel-success'> 
          <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
          <div class='panel-body'> Item cadastrado com sucesso!<br><br><a href='cad_tp_cargo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
            
</div>