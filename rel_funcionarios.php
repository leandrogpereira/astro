<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

  <div class="topo">
  <?php include_once('header.php'); ?>
  </div>

  <div class="conteudo">

    <?php
      include_once('conexao.php');
      include_once('mpdf60/mpdf.php'); 
      if ($_SESSION["acesso"] == 0)
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
    ?>

    <div class="container theme-showcase" role="main">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">FICHA DO FUNCIONÁRIO:</h3>
        </div>
        <div class="panel-body">
          <h4 class="panel-title">Selecione o funcionário e clique no botão para gerar o relatório:</h4>
          <br>

          <form method="POST" target="_blank" action="emi_funcionarios.php">
                    
            <div class="row">
            <div class="col-md-11">
              <label for="funcionario">Funcionário:</label>
              <select class="form-control" id="funcionario" name="funcionario">
                    <?php 

                    $query = mysql_query("SELECT ID_FUNCIONARIO,FUN_NOME, FUN_SOBRENOME FROM funcionarios WHERE FUN_STATUS = 1");

                    while ($row = mysql_fetch_array($query)){
                      $id_funcionario = $row['ID_FUNCIONARIO'];
                      $funcionario = $row['FUN_NOME'];
                      $sobrenome = $row['FUN_SOBRENOME'];

                    echo("             
                        <option value='$id_funcionario'>$id_funcionario - $funcionario $sobrenome</option>
                        ");
                    }

                    ?>
                  </select>
            </div>
            <div class="col-md-1" style="margin-top: 26px">
              <button type="submit" class="btn btn-primary" name="enviar"><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button>
            </div>
          </div>
        </form>


        </div>
      </div>      
    </div>
    <?php } ?>
  </div>

  <div class="rodape">
  <?php include_once('footer.php'); ?>
  </div>  
            
</div>