<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

  <div class="topo">
    <?php include_once('header.php'); ?>
  </div>

  <div class="conteudo">

    <?php
      include_once('conexao.php');
      if ($_SESSION["acesso"] <= 1 || $_POST["id"] == null)
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
        if(!isset($_POST["enviar"]))
        {
          $id = $_POST["id"];

          $query = mysql_query("SELECT *  FROM veiculos WHERE ID_VEICULO = $id");

          while ($row = mysql_fetch_array($query))
          {
            $id         = $row['ID_VEICULO'];
            $placa_uf   = $row['VEI_PLACA_UF'];
            $placa_mun  = $row['VEI_PLACA_MUN'];
            $placa_cod  = $row['VEI_PLACA_COD'];
            $modelo     = $row['VEI_MODELO'];
            $marca      = $row['VEI_MARCA'];
            $ano        = $row['VEI_ANO'];
            $status     = $row['VEI_STATUS'];
            $observacao = $row['VEI_OBSERVACAO'];
            $foto       = $row['VEI_FOTO'];
          }
          ?>

          <div class="container theme-showcase" role="main">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">DETALHES DO VEÍCULO:</h3>
              </div>
              <div class="panel-body">

                <form method="POST" action="atu_veiculo.php" enctype="multipart/form-data">

                  <input type="hidden" name="id" value=<?php echo (" '$id'"); ?>>

                  <div class="row">
                    <div class="col-xs-6 col-md-4">
                      <br>UF da Placa:<br>
                      <input type="text" placeholder="Ex: SP" class="form-control" name="placa_uf" maxlength="2" value=<?php echo (" '$placa_uf'"); ?> disabled>
                    </div>

                    <div class="col-xs-6 col-md-4">
                      <br>Município da Placa:<br>
                      <input type="text" placeholder="Ex: Pindamonhangaba" class="form-control" name="placa_mun" maxlength="80" value=<?php echo (" '$placa_mun'"); ?>disabled>
                    </div>

                    <div class="col-xs-6 col-md-4">
                      <br>Número da Placa:<br>
                      <input type="text" placeholder="Ex: FKB7532" class="form-control" name="placa_cod" maxlength="7" value=<?php echo (" '$placa_cod'"); ?>disabled>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-xs-6 col-md-4">
                      <br>Modelo:<br>
                      <input type="text" placeholder="Ex: VM 260 - Semipesado" class="form-control" name="modelo" maxlength="45" value=<?php echo (" '$modelo'"); ?>disabled>
                    </div>

                    <div class="col-xs-6 col-md-4">
                      <br>Marca:<br>
                      <input type="text" placeholder="Ex: Volvo" class="form-control" name="marca" maxlength="45" value=<?php echo (" '$marca'"); ?>disabled>
                    </div>

                    <div class="col-xs-6 col-md-4">
                      <br>Ano:<br>
                      <input type="text" placeholder="Ex: 2016" class="form-control" name="ano" maxlength="4" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$ano'"); ?>disabled>
                    </div>
                  </div>


                  <br>Ativo:<br>
                  <label class="radio-inline">
                    <input type="radio" name="status" value="1" disabled <?php if($status == 1){ echo ("checked"); } ?>> Sim
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="status" value="0" disabled <?php if($status == 0){ echo ("checked"); } ?>> Não
                  </label>
                  <br>

                  <br>Observação:<br>
                  <textarea cols="40" rows="5" class="form-control" name="observacao" maxlength="200" disabled><?php echo (" $observacao"); ?></textarea>


                  <div class="row">
                    <div class="col-xs-6 col-md-9">

                    </div>

                    <div class="col-xs-6 col-md-3">
                      <br>Imagem Atual:<br>
                      <a><?php echo ("<img src='uploads/$foto' style='width:256px; border: #C0C0C0 2px solid; border-radius: 10px;'"); ?></a>
                      <input type="hidden" class="form-control" name="foto" value=<?php echo (" '$foto'"); ?>>
                    </div>
                  </div>

                  <a href='javascript:history.go(-1);'><button type='button' class='btn btn-primary btn-lg'> Voltar</button></a>
                </form>

                <br>

              </div>
            </div>      
          </div>


          <?php

        } 
        else
        {

          include_once('conexao.php');

          $id         = $_POST["id"];
          $placa_uf   = $_POST["placa_uf"];
          $placa_mun  = $_POST["placa_mun"];
          $placa_cod  = $_POST["placa_cod"];
          $modelo     = $_POST["modelo"];
          $marca      = $_POST["marca"];
          $ano        = $_POST["ano"];
          $status     = $_POST["status"];
          $observacao = $_POST["observacao"];
          $foto       = $_POST["foto"];

                // Pasta onde o arquivo vai ser salvo
          $_UP['pasta'] = 'uploads/';
                // Tamanho máximo do arquivo (em Bytes)
                $_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
                // Array com as extensões permitidas
                $_UP['extensoes'] = array('jpg', 'png', 'gif');
                // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
                $_UP['renomeia'] = true;
                // Array com os tipos de erros de upload do PHP
                $_UP['erros'][0] = 'Não houve erro';
                $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
                $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
                $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
                $_UP['erros'][4] = 'Não foi feito o upload do arquivo';
                // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                if ($_FILES['arquivo']['error'] == 4) {
                  $nome_final = $foto;
                } else {
                 if ($_FILES['arquivo']['error'] != 0) {
                  die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
                  exit; // Para a execução do script
                } 
                // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
                // Faz a verificação da extensão do arquivo
                //extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
                $arr = explode('.', $_FILES['arquivo']['name']);
                $extensao = strtolower(end($arr));
                if (array_search($extensao, $_UP['extensoes']) === false) {
                  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
                  exit;
                }
                // Faz a verificação do tamanho do arquivo
                if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
                  echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
                  exit;
                }
                // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
                // Primeiro verifica se deve trocar o nome do arquivo
                if ($_UP['renomeia'] == true) {
                  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
                  $nome_final = md5(time()).'.jpg';
                } else {
                  // Mantém o nome original do arquivo
                  $nome_final = $_FILES['arquivo']['name'];
                }

                // Depois verifica se é possível mover o arquivo para a pasta escolhida
                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
                    // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
                  // echo "Upload efetuado com sucesso!";
                  // echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';^
                } else {
                  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
                  echo "Não foi possível enviar o arquivo, tente novamente";
                }

              }


              $res = mysql_query("UPDATE 
                veiculos
                SET
                VEI_PLACA_UF = '$placa_uf',
                VEI_PLACA_MUN = '$placa_mun',
                VEI_PLACA_COD = '$placa_cod',
                VEI_MODELO = '$modelo',
                VEI_MARCA = '$marca',
                VEI_ANO = '$ano',
                VEI_STATUS = '$status',
                VEI_OBSERVACAO = '$observacao',
                VEI_FOTO = '$nome_final'
                WHERE 
                ID_VEICULO = '$id';"); 

              if(mysql_affected_rows()>0)
              {
                echo "
                <div class='container theme-showcase' role='main'>
                  <div class='panel panel-success'> 
                    <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                    <div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_veiculo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
        ?>

      </div>

      <div class="rodape">
        <?php include_once('footer.php'); ?>
      </div>

      <script language='JavaScript'>
      function SomenteNumero(e){
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
          if (tecla==8 || tecla==0) return true;
          else  return false;
        }
      }
    </script>

    </div>