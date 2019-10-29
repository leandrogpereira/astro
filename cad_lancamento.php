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
    if ($_SESSION["st_periodo"] == 0)
    {
      echo "
      <div class='container theme-showcase' role='main'>
        <div class='panel panel-danger'> 
          <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
          <div class='panel-body'> <p align='center'>Período selecionado não é permitido fazer lançamentos.</p><br><br><a href='home.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
            <h3 class="panel-title">PARA CADASTRAR LANÇAMENTOS, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
          </div>
          <div class="panel-body">

      <form method="POST" action="cad_lancamento.php">
        
            <div class="row">
            <div class="col-xs-6 col-md-4">
            <br>Data:<br>
            <input type="text" id="campoData" placeholder="Ex.: 30-06-2016" class="form-control" name="data" required value=<?=$data_padrao?>>
            </div>

            <div class="col-xs-6 col-md-4">
            <br>Conta Bancária:<br>
            <select class="form-control" name="caixa">
                <?php 

                  $query = mysql_query("SELECT * FROM caixa WHERE CAI_STATUS = 1 AND ID_CAIXA <> 0");

                  while ($row = mysql_fetch_array($query)){
                    $id_caixa = $row['ID_CAIXA'];
                    $caixa = $row['CAI_NOME'];

                  echo("             
                      <option value='$id_caixa'>$id_caixa - $caixa</option>
                      ");
                  }

                ?>
            </select>
            </div>

            <div class="col-xs-6 col-md-4">
            <br>Tipo de Documento:<br>
            <select class="form-control" name="tp_documento">
              <?php 

                  $query = mysql_query("SELECT * FROM tp_lancamento");

                  while ($row = mysql_fetch_array($query)){
                    $id_tp = $row['ID_TP_LANCAMENTO'];
                    $descricao = $row['TPL_DESCRICAO'];

                  echo("             
                      <option value='$id_tp'>$descricao</option>
                      ");
                  }

                ?>
            </select>
            </div>
            </div>

            <div class="row">
            <div class="col-xs-6 col-md-4">   
            <br>Tipo de Lançamento:<br>
            <select class="form-control" name="tp_lancamento" id="tipo" onchange="habilita()">
              <option value="1">Selecione</option>
              <option value="2">Recebimento de Contrato (+)</option>
              <option value="3">Saída (-)</option>
              <option value="4">Entrada (+)</option>
            </select>
            </div>

            <!-- 
            Backup da Alteração Acima... Thiago em 17/09/2016
            <div class="col-xs-6 col-md-4">   
            <br>Tipo de Lançamento:<br>
            <select class="form-control" name="tp_lancamento" onchange="this.form.submit()">
              <option value="-1"  onclick="javascript:desabilita_a();">Selecione</option>
              <option value="2" onclick="javascript:habilita_a();">Recebimento de Contrato (+)</option>
              <option value="3" onclick="javascript:habilita_con();">Saída (-)</option>
              <option value="4" onclick="javascript:habilita_con();">Entrada (+)</option>
            </select>
            </div> 
            -->

            <div class="col-xs-6 col-md-4">
            <br>Contrato:<br>
            <select class="form-control" id="contrato" name="contrato" disabled>
              <option value="">Selecione</option>
                <?php 

                  $query = mysql_query("SELECT C.ID_CONTRATO, C.NR_CONTRATO, P.PES_NOME FROM contratos C LEFT JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA LEFT JOIN tp_contrato T ON T.ID_TP_CONTRATO = C.ID_TP_CONTRATO WHERE C.CON_STATUS = 1 AND C.ID_TP_CONTRATO = 1");
                  while ($row = mysql_fetch_array($query)){
                    $id_contrato = $row['ID_CONTRATO'];
                    $cliente = $row['PES_NOME'];
                    $nr_contrato = $row['NR_CONTRATO'];

                  echo("             
                      <option value='$id_contrato'>$nr_contrato - $cliente</option>
                      ");
                  }

                ?>
            </select>
            </div>

            <div class="col-xs-6 col-md-4">   
            <br>Valor:<br>
            <input type="text" id="mascara1" placeholder="Ex.: 10.000,00" class="form-control" data-thousands="" data-decimal="." name="valor" maxlength="13" disabled required>
            </div>
            </div>

            <div class="row">
            <div class="col-xs-6 col-md-4">   
            <br>Documento:<br>
            <input type="text" id="" placeholder="Ex.: Cheque 15" class="form-control" name="documento" maxlength="80">
            </div>
            </div>

            <br>Descrição:<br>
            <textarea cols="40" rows="5" class="form-control" name="descricao" maxlength="200"></textarea>

            <input type="hidden" name="funcionario" value=<?=$_SESSION["id_usuario"]?>>

            <br><br><br>
             <button type="submit" class="btn btn-primary btn-lg" name="enviar" id="enviar" disabled>Cadastrar</button>
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

        include_once('funcao.php');

        if (verificaPeriodo($_POST["data"]) == true)
        {

          $data = date('Y-m-d H:i:s', strtotime($_POST["data"]));

          $caixa = $_POST["caixa"];

          $tp_documento = $_POST["tp_documento"];

          if ($_POST["tp_lancamento"] <= 0 )
          {
            $tp_lancamento = "null";
            $valor = "null";
          }
          else
          {
            $tp_lancamento = $_POST["tp_lancamento"];
            $valor = number_format(floatval($_POST["valor"]), 2, '.', '');
          }

          if (!isset($_POST["contrato"]) || $_POST["contrato"] == '' || $_POST["contrato"] == null)
          {
            $contrato = "null";
          } 
          else
          {
            $contrato = $_POST["contrato"];
          }

          $documento = $_POST["documento"];

          $descricao = $_POST["descricao"];

          $funcionario = $_POST["funcionario"];

          $verifica_lancamento = mysql_query("SELECT `AUTO_INCREMENT` AS ID_LANCAMENTO FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'astro' AND TABLE_NAME   = 'lancamentos';");
          $row = mysql_fetch_array($verifica_lancamento);
          $id_insert = $row["ID_LANCAMENTO"];

          $res = mysql_query("INSERT INTO lancamentos VALUES (null, $tp_documento, '$descricao', '$documento');"); 

          $res = mysql_query("INSERT INTO baixas VALUES (null, '$caixa', $id_insert, $contrato, null, null,'$data','Lançamento: $id_insert; Documento: $documento; $descricao', $tp_lancamento, '$valor', 1, '$funcionario', ".$_SESSION["id_periodo"].");");


          if(mysql_affected_rows()>0){
            echo "
            <div class='container theme-showcase' role='main'>
              <div class='panel panel-success'> 
                <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                <div class='panel-body'> Cadastrado realizado com sucesso!<br><br><a href='cad_lancamento.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
              </div>
            </div>
            ";
            mysql_close($conecta);
          }else{
            $erro = mysql_error();
            echo "
            <div class='container theme-showcase' role='main'>
              <div class='panel panel-danger'> 
                <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                <div class='panel-body'> <p align='center'>Verifique se todos os campos foram preenchidos corretamente. <br>Erro: $erro</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
                <div class='panel-body'> <p align='center'>Data inválida para lançamento.</p><br><br><div class='text-center'><a href='cad_lancamento.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div></div> 
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

    <script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

    <script language='JavaScript'>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
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

      function habilita() {
      //var x = document.getElementById("tp_lancamento");
      switch(document.getElementById('tipo').selectedIndex) {
      case 0:
        document.getElementById("contrato").disabled = true; //Desabilitando
        document.getElementById("contrato").value='';
        document.getElementById("mascara1").disabled = true; //Desabilitando
        document.getElementById("mascara1").value='';
        document.getElementById("enviar").disabled = true; //Desabilitando
        document.getElementById("enviar").value='';
        break;
      case 1:
        document.getElementById("contrato").disabled = false; //Habilitando
        document.getElementById("mascara1").disabled = false;
        document.getElementById("enviar").disabled = false;
        break;
      case 2:
        document.getElementById("mascara1").disabled = false;
        document.getElementById("contrato").disabled = true; //Desabilitando
        document.getElementById("contrato").value='';
        document.getElementById("enviar").disabled = false;
        break;
      case 3:
        document.getElementById("mascara1").disabled = false;
        document.getElementById("contrato").disabled = true; //Desabilitando
        document.getElementById("contrato").value='';
        document.getElementById("enviar").disabled = false;
        break;
      }
      }
    </script>
            
</div>


