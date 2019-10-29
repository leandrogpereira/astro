<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
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
    $query = mysql_query("SELECT MAX(PER_ANO)+1 AS ANO FROM periodos ORDER BY ANO ASC") or die("Erro na sintaxe, entre em contato com o suporte técnico. <a href='ger_periodo.php'>Voltar</a>");;
    $row = mysql_fetch_array($query);
    $ano = $row["ANO"];
    if(!isset($_POST["enviar"])){
  ?>

      <div class="container theme-showcase" role="main">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">PARA CADASTRAR UM PERÍODO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
          </div>
            <div class="panel-body">
              <form method="POST" action="cad_periodo.php">
                
                <div class="row">

                  <div class="col-xs-12 col-md-12 text-center">
                    <br>Confirma a criação dos períodos de <?php echo $ano; ?>?<br>
                    <input type="hidden" name="ano" value=<?=$ano?>>
                  </div>

                </div>
                <br>
                <div class="row">
                  <div class="col-xs-12 col-md-12 text-center">
                 <button type="submit" class="btn btn-primary btn-lg" name="enviar">Criar</button>
                 <a class="btn btn-info btn-lg" href="ger_periodo.php" role="button">Voltar</button></a>
                 </div>
                 </div>
              </form>
            </div>
            <br>
          </div>
        </div>      

  <?php

   } else {

    include_once('conexao.php');

    $ano=$_POST["ano"];

    for ($i=1; $i < 13 ; $i++) { 
      $res = mysql_query("INSERT INTO periodos VALUES (NULL,$ano, $i, 0);");
    }

    if(mysql_affected_rows()>0){
      echo "
      <div class='container theme-showcase' role='main'>
        <div class='panel panel-success'> 
          <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
          <div class='panel-body'> Período criado com sucesso!<br><br><a href='ger_periodo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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