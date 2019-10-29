<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
  if ($_SESSION["acesso"] <= 1 || $_POST["id_baixa"] == null)
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

      if ($_SESSION["st_periodo"] == 0)
      {
        echo "
        <div class='container theme-showcase' role='main'>
          <div class='panel panel-danger'> 
            <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
            <div class='panel-body'> <p align='center'>Período selecionado não é permitido fazer alterações.</p><br><br><a href='ger_baixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
          </div>
        </div>
        ";
      }
      else
      {
        $id_baixa = $_POST['id_baixa'];
        if(!isset($_POST["enviar"]))
        {

          $query = mysql_query("SELECT *  FROM baixas WHERE ID_BAIXA = $id_baixa");

                  while ($row = mysql_fetch_array($query))
                  {
                    $id_baixa = $row['ID_BAIXA'];
                    $status = $row['ST_BAIXA'];
                    $caixa = $row['ID_CAIXA'];
                    $dt_baixa = date('d-m-Y', strtotime($row['BAI_DATA']));
                    $descricao = $row['BAI_DESCRICAO'];
                  }
      ?>

      <div class="container theme-showcase" role="main">
      <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">PARA ALTERAR A BAIXA, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
          </div>
          <div class="panel-body">

      <form method="POST" action="atu_baixa.php">
        
            <div class="row">
              <div class="col-xs-6 col-md-4">
                <br>Código da baixa:<br>
                <input type="text" class="form-control" placeholder="Ex: 001" name="id_baixa" readonly value=<?php echo $id_baixa; ?>>
              </div>

              <div class="col-xs-6 col-md-4">
                <br>Baixar:<br>
                <input name="status" type="radio" value="1" onclick="javascript:habilita_a();" <?php if($status == 1){ echo ("checked");} ?>> Sim
                <input name="status" type="radio" value="0" onclick="javascript:desabilita_a();" <?php if($status == 0){ echo ("checked");} ?>> Não
              </div>

              <div class="col-xs-12 col-md-4">
                <br>Data da Baixa:<br>
                <input type="text" id="campoData1" placeholder="Ex.: 30-06-2016" class="form-control" name="dt_baixa" required="" value=<?php echo (" '$dt_baixa'"); if($status == 0){ echo ("disabled");} ?>>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 col-md-4">
              <br>Conta Bancária:<br>
              <select id="campoCaixa" class="form-control" name="caixa" required="" <?php if($status == 0){ echo ("disabled");} ?>>
                  <?php 

                    $query = mysql_query("SELECT * FROM caixa WHERE CAI_STATUS = 1 AND ID_CAIXA <> 0");
                    while ($row = mysql_fetch_array($query)){
                      $id_caixa = $row['ID_CAIXA'];
                      $cai_nome = $row['CAI_NOME'];

                      if ($caixa == $id_caixa) {
                        echo("             
                        <option value='$id_caixa' selected>$id_caixa - $cai_nome</option>
                        ");
                      }
                      else
                      {
                      echo("             
                        <option value='$id_caixa'>$id_caixa - $cai_nome</option>
                        ");   
                      }
                    
                    }

                  ?>
              </select>
              </div>
            </div>

            <br>Descrição:<br>
            <textarea cols="40" rows="5" class="form-control" name="descricao" maxlength="80"><?php echo $descricao; ?></textarea>

            <br><br><br>
             <button type="submit" class="btn btn-primary btn-lg" name="enviar"> Gravar</button>
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

          $id_funcionario=$_SESSION["id_usuario"];
          $id_baixa = $_POST["id_baixa"];
          $descricao = $_POST["descricao"];

          if ($_POST["status"] == 1)
          {
            if (verificaPeriodo($_POST["dt_baixa"]) == true)
            {
              $status = $_POST["status"];
              $caixa = $_POST["caixa"];
              $dt_baixa = date('Y-m-d H:i:s', strtotime($_POST["dt_baixa"]));
              $res = mysql_query("UPDATE baixas SET ID_CAIXA = $caixa, BAI_DATA = '$dt_baixa', ST_BAIXA = '$status', BAI_DESCRICAO = '$descricao', ID_FUNCIONARIO = '$id_funcionario', ID_PERIODO = ".$_SESSION["id_periodo"]." WHERE ID_BAIXA = '$id_baixa';");
              if(mysql_affected_rows()>0)
              {
                echo "
                <div class='container theme-showcase' role='main'>
                  <div class='panel panel-success'> 
                    <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                    <div class='panel-body'> Baixa atualizada com sucesso!<br><br><a href='ger_baixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
                      <div class='panel-body'> <p align='center'>Data inválida para lançamento.</p><br><br><div class='text-center'><a href='ger_baixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div></div> 
                    </div>
                  </div>
                  ";
            }
          }
          else
          {
            $status = $_POST["status"];
            $res = mysql_query("UPDATE baixas SET ID_CAIXA = 0, BAI_DATA = null, ST_BAIXA = '$status', BAI_DESCRICAO = '$descricao', ID_FUNCIONARIO = '$id_funcionario', ID_PERIODO = ".$_SESSION["id_periodo"]." WHERE ID_BAIXA = '$id_baixa';");
            if(mysql_affected_rows()>0)
            {
              echo "
              <div class='container theme-showcase' role='main'>
                <div class='panel panel-success'> 
                  <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                  <div class='panel-body'> Baixa atualizada com sucesso!<br><br><a href='ger_baixa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
     $("#campoData1").mask("99-99-9999");
     $("#campoTelefone1").mask("(99) 99999-9999");
     $("#campoSenha1").mask("***-****");
    });

      function habilita_a()
      {
        document.getElementById("campoData1").disabled = false; //Habilitando
        document.getElementById("campoCaixa").disabled = false; //Habilitando
      }
      function desabilita_a()
      {
        document.getElementById("campoData1").disabled = true; //Desabilitando
        document.getElementById("campoData1").value='';
        document.getElementById("campoCaixa").disabled = true; //Desabilitando
        document.getElementById("campoCaixa").value='';
      }
    </script>
            
</div>


