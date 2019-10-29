<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
  <?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
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
    if(!isset($_POST["enviar"])){

    ?>

    <div class="container theme-showcase" role="main">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">PARA CADASTRAR TRANSPORTES, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
        </div>
        <div class="panel-body">

    <form method="POST" action="cad_transporte.php">
      
          <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Data:<br>
          <input type="text" id="campoData" placeholder="Ex.: 30-06-2016 10:45:00" class="form-control" name="data" required autofocus="" value=<?php echo (" '$data_padrao'"); ?>>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Contratos:<br>
          <select class="form-control" name="contrato" required>
              <?php 

                $query = mysql_query("SELECT
                                        C.ID_CONTRATO,
                                        C.NR_CONTRATO,
                                        P.PES_NOME,
                                        TP.TPC_DESCRICAO
                                          FROM contratos C
                                          INNER JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA
                                          INNER JOIN tp_contrato TP ON TP.ID_TP_CONTRATO = C.ID_TP_CONTRATO
                                          WHERE C.CON_STATUS = 1");

                while ($row = mysql_fetch_array($query)){
                  $id_contrato   = $row['ID_CONTRATO'];
                  $nr_contrato   = $row['NR_CONTRATO'];
                  $cliente       = $row['PES_NOME'];
                  $tpc_descricao = $row['TPC_DESCRICAO'];

                echo("             
                    <option value='$id_contrato'>$nr_contrato - $cliente - $tpc_descricao</option>
                    ");
                }

                ?>
          </select>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Veículo:<br>
          <select class="form-control" name="veiculo" required>
              <?php 

                $query = mysql_query("SELECT 
                                        ID_VEICULO,
                                        VEI_PLACA_COD,
                                        VEI_MODELO
                                        FROM veiculos WHERE VEI_STATUS = 1 AND ID_VEICULO <> 0");

                while ($row = mysql_fetch_array($query)){
                  $id_veiculo = $row['ID_VEICULO'];
                  $placa = $row['VEI_PLACA_COD'];
                  $modelo = $row['VEI_MODELO'];

                echo("             
                    <option value='$id_veiculo'>$placa - $modelo</option>
                    ");
                }

              ?>
          </select>
          </div>
          </div>

          <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Motorista:<br>
          <select class="form-control" name="motorista" required>
              <?php 

                $query = mysql_query("SELECT 
                                        F.ID_FUNCIONARIO AS ID,
                                        F.FUN_NOME AS NOME,
                                        F.FUN_SOBRENOME AS SOBRENOME
                                        FROM funcionarios F
                                        INNER JOIN cargos C on C.ID_CARGO = F.ID_CARGO
                                        WHERE F.FUN_STATUS = 1 AND F.ID_CARGO = 1");
                while ($row = mysql_fetch_array($query)){
                  $id_funcionario = $row['ID'];
                  $motorista = $row['NOME'];
                  $sobrenome = $row['SOBRENOME'];

                echo("             
                    <option value='$id_funcionario'>$motorista $sobrenome</option>
                    ");
                }

              ?>
          </select>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">   
          <br>Peso: (em Toneladas)<br>
          <input type="text" id="mascara1" placeholder="Ex.: 32,61" class="form-control" name="peso" maxlength="5"  data-precision="2" data-thousands="" data-decimal="." required>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">   
          <br>Nota:<br>
          <input type="text" id="" placeholder="Ex.: NF-01123" class="form-control" name="nota" maxlength="10">
          </div>
          </div>

          <br>Observações:<br>
          <textarea cols="40" rows="5" class="form-control" name="observacao" maxlength="200"></textarea>

          <input type="hidden" name="funcionario" value=<?=$_SESSION["id_usuario"]?>>

          <br><br><br>
           <button type="submit" class="btn btn-primary btn-lg" name="enviar">Cadastrar</button>
           <button type="reset" class="btn btn-info btn-lg" name ="limpar">Limpar</button>
        </form>

        <br>

      </div>
    </div>
    </div>

    <?php

     }
     else
     {

      include_once("funcao.php");

      if (verificaPeriodo($_POST["data"]) == true && verificaContrato($_POST["data"],$_POST["contrato"]) == true)
      {
        $data = date('Y-m-d H:i:s', strtotime($_POST["data"]));

        $contrato = $_POST["contrato"];

        $verifica_contrato = mysql_query("SELECT ID_TP_CONTRATO,CON_VL_PESO FROM contratos WHERE ID_CONTRATO = $contrato");
        $row = mysql_fetch_array($verifica_contrato);
        $tp_contrato = $row["ID_TP_CONTRATO"];
        $vl_peso = number_format(floatval($row["CON_VL_PESO"]), 2, '.', '');

        $verifica_transporte = mysql_query("SELECT `AUTO_INCREMENT` AS ID_TRANSPORTE FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'astro' AND TABLE_NAME   = 'transportes';");
        $row = mysql_fetch_array($verifica_transporte);
        $id_insert = $row["ID_TRANSPORTE"];

        $veiculo = $_POST["veiculo"];

        $motorista = $_POST["motorista"];

        $peso = number_format(floatval($_POST["peso"]), 2, '.', '');

        $valor = number_format(floatval($vl_peso) * floatval($peso), 2, '.', '');

        $nota = $_POST["nota"];

        $observacao = $_POST["observacao"];

        $funcionario = $_POST["funcionario"];

        if($tp_contrato == 1)
        {
          $res = mysql_query("INSERT INTO transportes VALUES (NULL,'$data','$nota','$peso','$observacao','$veiculo','$motorista', '$contrato', ".$_SESSION["id_periodo"].");");
        }
        else
        {
          $res = mysql_query("INSERT INTO transportes VALUES (NULL,'$data','$nota','$peso','$observacao','$veiculo','$motorista', '$contrato', ".$_SESSION["id_periodo"].");");
          $insert = mysql_query("INSERT INTO baixas VALUES (NULL, 0, NULL,NULL, $id_insert,NULL,NULL, 'Transporte: $id_insert; $observacao', 0, '$valor', 0,'$funcionario', ".$_SESSION["id_periodo"].");");
        }

        if(mysql_affected_rows()>0)
        {
          echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-success'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'><p align='center'> Cadastrado realizado com sucesso!<br><br><a href='cad_transporte.php'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></p></div> 
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
              <div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='cad_transporte.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
              <div class='panel-body'> <p align='center'>Data inválida para lançamento. Verifique os dados preenchidos e a vigência do contrato.</p><br><br><div class='text-center'><a href='cad_transporte.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div></div> 
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

<!-- Máscara para datas, telefones e senhas -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <!-- Máscara para moeda -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999 99:99:99");
     });

    $(function($) {
      $('#mascara1').maskMoney();
    })

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


