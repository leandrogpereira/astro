<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
  if ($_SESSION["acesso"] <= 1 || $_POST["id_lancamento"] == null)
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
          <div class='panel-body'> <p align='center'>Período selecionado não é permitido fazer lançamentos.</p><br><br><a href='home.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
        </div>
      </div>
      ";
    }
    else
    {

      if(!isset($_POST["enviar"]))
      {
        $id_lancamento = $_POST["id_lancamento"];

        $query = mysql_query("SELECT
                                     L.ID_LANCAMENTO 
                                   , L.ID_TP_LANCAMENTO
                                   , L.LAN_DESCRICAO
                                   , L.LAN_DOCUMENTO
                                   , B.BAI_DATA
                                   , B.ID_CAIXA
                                   , B.TP_BAIXA
                                   , B.ID_CONTRATO
                                   , B.BAI_VALOR
                                   FROM lancamentos L
                                      LEFT JOIN tp_lancamento T  ON T.ID_TP_LANCAMENTO = L.ID_TP_LANCAMENTO
                                      LEFT JOIN baixas        B  ON B.ID_LANCAMENTO    = L.ID_LANCAMENTO
                                      LEFT JOIN contratos     C  ON C.ID_CONTRATO      = B.ID_CONTRATO
                                      LEFT JOIN caixa        CA  ON CA.ID_CAIXA        = B.ID_CAIXA
                                   WHERE
                                      L.ID_LANCAMENTO = $id_lancamento");

                while ($row = mysql_fetch_array($query))
                {
                  $id_lancamento = $row['ID_LANCAMENTO'];
                  $tp_documento = $row['ID_TP_LANCAMENTO'];
                  $descricao = $row['LAN_DESCRICAO'];
                  $documento = $row['LAN_DOCUMENTO'];
                  $dt_baixa = date('d-m-Y', strtotime($row['BAI_DATA']));
                  $caixa = $row['ID_CAIXA'];
                  $tp_lancamento = $row['TP_BAIXA'];
                  $contrato = $row['ID_CONTRATO'];
                  $valor = $row['BAI_VALOR'];
                }
    ?>

    <div class="container theme-showcase" role="main">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">PARA ATUALIZAR LANÇAMENTOS, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
        </div>
        <div class="panel-body">

    <form method="POST" action="atu_lancamento.php">
      
          <div class="row">
          <div class="col-xs-6 col-md-4">
          <br>Número:<br>
          <input type="text" id="" placeholder="Ex.: 12" class="form-control" name="id_lancamento" readonly value=<?php echo (" '$id_lancamento'"); ?>>
          </div>

          <div class="col-xs-6 col-md-4">
          <br>Data:<br>
          <input type="text" id="campoData" placeholder="Ex.: 30-06-2016" class="form-control" name="data" required value=<?php echo (" '$dt_baixa'"); ?>>
          </div>

          <div class="col-xs-6 col-md-4">
          <br>Conta Bancária:<br>
          <select class="form-control" name="caixa">
              <?php 

                $query = mysql_query("SELECT * FROM caixa WHERE CAI_STATUS = 1 AND ID_CAIXA <> 0");

                while ($row = mysql_fetch_array($query)){
                  $id_caixa = $row['ID_CAIXA'];
                  $caixa_nome = $row['CAI_NOME'];

                  if ($caixa == $id_caixa)
                  {
                    echo(" <option value='$id_caixa' selected>$id_caixa - $caixa_nome</option>");
                  }
                  else
                  {
                    echo(" <option value='$id_caixa'>$id_caixa - $caixa_nome</option>");
                  }
                }

              ?>
          </select>
          </div>
          </div>

          <div class="row">
          <div class="col-xs-6 col-md-4">
          <br>Tipo de Documento:<br>
          <select class="form-control" name="tp_documento">
            <?php 

                $query = mysql_query("SELECT * FROM tp_lancamento");

                while ($row = mysql_fetch_array($query)){
                  $id_tp = $row['ID_TP_LANCAMENTO'];
                  $tp_descricao = $row['TPL_DESCRICAO'];

                  if ($tp_documento == $id_tp)
                  {
                    echo("<option value='$id_tp' selected>$tp_descricao</option>");
                  }
                  else
                  {
                    echo("<option value='$id_tp'>$tp_descricao</option>");    
                  }
                }

              ?>
          </select>
          </div>

          <div class="col-xs-6 col-md-4">   
          <br>Tipo de Lançamento:<br>
          <select class="form-control" id="tipo" name="tp_lancamento" onchange="habilita()">
            <option value="0">Selecione</option>
            <?php
            switch ($tp_lancamento) {
              case 2:
                $v1 = 'selected';
                break;
              case 3:
                $v2 = 'selected';
                break;
              default:
                $v3 = 'selected';
                break;
            }
            echo "
            <option value='2' $v1>Recebimento de Contrato (+)</option>
            <option value='3' $v2>Saída (-)</option>
            <option value='4' $v3>Entrada (+)</option>
            ";

            ?>
          </select>
          </div>

          <div class="col-xs-6 col-md-4">
          <br>Contrato:<br>
          <select class="form-control" id="contrato" name="contrato" <?php if ($tp_lancamento != 2){ echo "disabled"; } ?>>
            <option value="">Selecione</option>
              <?php 

                $query = mysql_query("SELECT C.ID_CONTRATO, C.NR_CONTRATO, P.PES_NOME FROM contratos C LEFT JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA LEFT JOIN tp_contrato T ON T.ID_TP_CONTRATO = C.ID_TP_CONTRATO WHERE C.CON_STATUS = 1 AND C.ID_TP_CONTRATO = 1");
                while ($row = mysql_fetch_array($query))
                {
                  $id_contrato = $row['ID_CONTRATO'];
                  $cliente = $row['PES_NOME'];
                  $nr_contrato = $row['NR_CONTRATO'];

                  if ($contrato == $id_contrato)
                  {
                    echo("<option value='$id_contrato' selected>$nr_contrato - $cliente</option>");
                  }
                  else
                  {
                    echo("<option value='$id_contrato'>$nr_contrato - $cliente</option>");    
                  }
                }

              ?>
          </select>
          </div>
          </div>

          <div class="row">
          <div class="col-xs-6 col-md-4">   
          <br>Valor:<br>
          <input type="text" id="mascara1" placeholder="Ex.: 10.000,00" class="form-control" data-thousands="" name="valor" maxlength="13" required value=<?=$valor;?>>
          </div>

          <div class="col-xs-6 col-md-4">   
          <br>Documento:<br>
          <input type="text" id="" placeholder="Ex.: Cheque 15" class="form-control" name="documento" maxlength="80" value=<?=$documento;?>>
          </div>
          </div>

          <br>Descrição:<br>
          <textarea cols="40" rows="5" class="form-control" name="descricao" maxlength="200"><?php echo "$descricao"; ?></textarea>

          <br><br><br>
           <button type="submit" class="btn btn-primary btn-lg" name="enviar" id="enviar"> Gravar</button>
           <a href='javascript:history.go(-1);'><button type='button' class='btn btn-info btn-lg'> Voltar</button></a>
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
      include_once('funcao.php');
      if (verificaPeriodo($_POST["data"]) == true)
      {

        $id_lancamento = $_POST["id_lancamento"];

        $data = date('Y-m-d H:i:s', strtotime($_POST["data"]));

        $caixa = $_POST["caixa"];

        $tp_documento = $_POST["tp_documento"];

        $tp_lancamento = $_POST["tp_lancamento"];
        
        $valor = number_format(floatval($_POST["valor"]), 2, '.', '');

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

        $usuario = $_SESSION["id_usuario"];

        $res = mysql_query("UPDATE lancamentos SET ID_TP_LANCAMENTO = $tp_lancamento, LAN_DESCRICAO = '$descricao', LAN_DOCUMENTO = '$documento' WHERE ID_LANCAMENTO = $id_lancamento;"); 

        $up = mysql_query("UPDATE
                                baixas
                              SET
                                ID_CAIXA = $caixa
                              , ID_CONTRATO = $contrato
                              , BAI_DATA = '$data'
                              , BAI_DESCRICAO = 'Lançamento: $id_lancamento; Documento: $documento; $descricao'
                              , TP_BAIXA = $tp_lancamento
                              , BAI_VALOR = '$valor'
                              , ID_FUNCIONARIO = $usuario
                              , ID_PERIODO = ".$_SESSION["id_periodo"]."
                              WHERE
                                ID_LANCAMENTO = $id_lancamento;"); 


        if(mysql_affected_rows()>0)
        {
          echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-success'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> Cadastrado atualizado com sucesso!<br><br><a href='ger_lancamento.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
            </div>
          </div>
          ";
          mysql_close($conecta);
        }
        else
        {
          $erro = mysql_error();
          if ($erro == '')
          {
            echo "
                <div class='container theme-showcase' role='main'>
                  <div class='panel panel-success'> 
                    <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                    <div class='panel-body'> Cadastrado atualizado com sucesso!<br><br><a href='ger_lancamento.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
                  </div>
                </div>
                ";
          }
          else
          {
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
      }
      else
      {
        echo "
              <div class='container theme-showcase' role='main'>
                <div class='panel panel-danger'> 
                  <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
                  <div class='panel-body'> <p align='center'>Data inválida para lançamento.</p><br><br><div class='text-center'><a href='ger_lancamento.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div></div> 
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
       $("#campoTelefone").mask("(99) 9999-9999");
       $("#campoSenha").mask("***-****");
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


