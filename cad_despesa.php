<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
  $data_padrao = date('d-m-Y');
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
          <h3 class="panel-title">PARA CADASTRAR DESPESAS, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
        </div>
        <div class="panel-body">

    <form method="POST" action="cad_despesa.php">
      
          <div class="row">
          <div class="col-xs-6 col-md-4">
          <br>Data:<br>
          <input type="text" id="campoData" placeholder="Ex.: 30-06-2016" class="form-control" name="data" required value=<?=$data_padrao?>>
          </div>

          <div class="col-xs-6 col-md-4">
          <br>Fornecedor:<br>
          <select class="form-control" name="fornecedor" required>
            <option value="0">--</option>
              <?php 

                $query = mysql_query("SELECT ID_PESSOA, PES_NOME FROM pessoas WHERE PES_TP_CADASTRO = 1 AND PES_STATUS = 1 ORDER BY PES_NOME ASC");

                while ($row = mysql_fetch_array($query)){
                  $id_pessoa = $row['ID_PESSOA'];
                  $fornecedor = $row['PES_NOME'];

                echo("             
                    <option value='$id_pessoa'>$fornecedor</option>
                    ");
                }

              ?>
          </select>
          </div>

          <div class="col-xs-6 col-md-4">
          <br>Tipo de Despesa:<br>
          <select class="form-control" id="tp_despesa" name="tp_despesa" onchange="habilita_vei()" required>
            <option value="0">--</option>
              <?php 

                $query = mysql_query("SELECT ID_TP_DESPESA,TPD_DESCRICAO FROM tp_despesas");

                while ($row = mysql_fetch_array($query)){
                  $id_tp_despesa = $row['ID_TP_DESPESA'];
                  $tp_despesa = $row['TPD_DESCRICAO'];
                  echo("             
                      <option value='$id_tp_despesa'>$tp_despesa</option>
                      ");
                }

              ?>
          </select>
          </div>
          </div>

          <div class="row">
          <div class="col-xs-6 col-md-4">
          <br>Emitente:<br>
          <select class="form-control" name="funcionario" required>
            <option value="0">--</option>
              <?php 

                $query = mysql_query("SELECT ID_FUNCIONARIO,FUN_NOME, FUN_SOBRENOME FROM funcionarios WHERE FUN_STATUS = 1");
                while ($row = mysql_fetch_array($query)){
                  $id_funcionario = $row['ID_FUNCIONARIO'];
                  $funcionario = $row['FUN_NOME'];
                  $sobrenome = $row['FUN_SOBRENOME'];

                echo("             
                    <option value='$id_funcionario'>$funcionario $sobrenome</option>
                    ");
                }

              ?>
          </select>
          </div>

          <div class="col-xs-6 col-md-4">
          <br>Veículo:<br>
          <select class="form-control" id="veiculo" name="veiculo" disabled="">
            <option value="0" selected>--</option>
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
                      <option value='$id_veiculo' >$placa - $modelo</option>
                  ");
                }

              ?>
          </select>
          </div>

          <div class="col-xs-6 col-md-4">   
          <br>Valor:<br>
          <input type="text" id="mascara1" placeholder="Ex.: 10.000,00" class="form-control" data-thousands="" data-decimal="." name="valor" maxlength="13" required>
          </div>      
          </div>

          <div class="row">
          <div class="col-xs-6 col-md-4">   
          <br>Nota:<br>
          <input type="text" id="" placeholder="Ex.: NF-01123" class="form-control" name="nota" maxlength="8">
          </div>
          </div>

          <div class="row">
          <div class="col-xs-6 col-md-4">
          <br>Baixar:<br>
          <input name="baixa" type="radio" value="1" onclick="javascript:habilita_a();"> Sim
          <input name="baixa" type="radio" value="0" onclick="javascript:desabilita_a();" checked> Não
          </div>

          <div class="col-xs-6 col-md-4">
          <br>Conta Bancária:<br>
          <select id="campoCaixa" class="form-control" name="caixa" disabled>
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

          <div class="col-xs-6 col-md-4">
          <br>Data da Baixa:<br>
          <input type="text" id="campoData1" placeholder="Ex.: 30-06-2016" class="form-control" name="dt_baixa" disabled>
          </div>      
          </div>

          <br>Descrição:<br>
          <textarea cols="40" rows="5" class="form-control" name="descricao" maxlength="80"></textarea>

          <input type="hidden" name="usuario" value=<?=$_SESSION["id_usuario"]?>>

          <br><br><br>
           <button type="submit" class="btn btn-primary btn-lg" name="enviar">Cadastrar</button>
           <button type="reset" class="btn btn-info btn-lg" name ="limpar">Limpar</button>
        </form>

        <br>

      </div>
    </div>      
    </div>

    <?php

     } else {

      include_once("funcao.php");

      if (verificaPeriodo($_POST["data"]) == true)
      {

        $data = date('Y-m-d H:i:s', strtotime($_POST["data"]));

        $fornecedor = $_POST["fornecedor"];

        $tp_despesa = $_POST["tp_despesa"];

        $funcionario = $_POST["funcionario"];

        $usuario = $_POST["usuario"];

        if (!isset($_POST["veiculo"]))
        {
          $veiculo = 0;
        }
        else
        {
          $veiculo = $_POST["veiculo"]; 
        }
        
        $valor = number_format(floatval($_POST["valor"]), 2, '.', '');  

        $nota = $_POST["nota"];

        $baixa = $_POST["baixa"];

        $descricao = $_POST["descricao"];

        $verifica_despesa = mysql_query("SELECT `AUTO_INCREMENT` AS ID_DESPESA FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'astro' AND TABLE_NAME   = 'despesas';");
        $row = mysql_fetch_array($verifica_despesa);
        $id_insert = $row["ID_DESPESA"];

        if($baixa == 0)
        {
          $res = mysql_query("INSERT INTO despesas VALUES (NULL, $veiculo,'$data','$nota','$descricao','$fornecedor','$tp_despesa','$funcionario', ".$_SESSION["id_periodo"].");");

          $insert = mysql_query("INSERT INTO baixas VALUES (NULL, 0, NULL, NULL, NULL, $id_insert, NULL,'Despesa: $id_insert - $descricao', 1, '$valor', 0,'$usuario', ".$_SESSION["id_periodo"].");");
        }
        else
        {
          $caixa = $_POST["caixa"];
          $dt_baixa = date('Y-m-d', strtotime($_POST["dt_baixa"]));
          $res = mysql_query("INSERT INTO despesas VALUES (NULL, $veiculo,'$data','$nota','$descricao','$fornecedor','$tp_despesa','$funcionario', ".$_SESSION["id_periodo"].");");
          $insert = mysql_query("INSERT INTO baixas VALUES (NULL, $caixa, NULL, NULL, NULL, $id_insert,'$dt_baixa', 'Despesa: $id_insert - $descricao', 1, '$valor', 1,'$usuario', ".$_SESSION["id_periodo"].");");
        }
        

        if(mysql_affected_rows()>0)
        {
          echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-success'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> Cadastrado realizado com sucesso!<br><br><a href='cad_despesa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
            </div>
          </div>
          ";
          mysql_close($conecta);
        }
        else
        {
          $erro = mysql_error();
          echo "
          <div class='container theme-showcase'>
            <div class='panel panel-danger'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> <p align='center'>Verifique os dados preenchidos.<br>Erro: $erro</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
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
              <div class='panel-body'> <p align='center'>Data inválida para lançamento.</p><br><br><div class='text-center'><a href='cad_despesa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div></div> 
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
   $("#campoData").mask("99-99-9999");
   $("#campoData1").mask("99-99-9999");
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

  function habilita_vei()
  {
    switch(document.getElementById('tp_despesa').value)
    {
        case '2': 
            document.getElementById('veiculo').disabled = false;
            document.getElementById('veiculo').selectedIndex = 0;
        break;
        case '3': 
            document.getElementById('veiculo').disabled = false;
            document.getElementById('veiculo').selectedIndex = 0;
        break;
        default:
            document.getElementById('veiculo').disabled = true;
            document.getElementById('veiculo').selectedIndex = 0;
        break;
    }
  }

</script>
            
</div>


