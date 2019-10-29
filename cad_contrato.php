<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
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
          <h3 class="panel-title">PARA CADASTRAR CONTRATO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
        </div>
        <div class="panel-body">

    <form method="POST" action="cad_contrato.php">
      
          <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Tipo de Contrato:<br>
            <select class="form-control" id="tpContrato" name="tp_contrato" onclick="javascript:verifica();">
              <?php 

                $query = mysql_query("SELECT ID_TP_CONTRATO,TPC_DESCRICAO FROM tp_contrato");

                while ($row = mysql_fetch_array($query)){
                  $id_tp_contrato = $row['ID_TP_CONTRATO'];
                  $tp_contrato = $row['TPC_DESCRICAO'];

                echo("             
                    <option value='$id_tp_contrato'>$tp_contrato</option>
                    ");
                }

              ?>
            </select>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Número do Contrato:<br>
            <input type="text" class="form-control" placeholder="Ex: 001" name="nr_contrato" maxlength="6" onkeypress='return SomenteNumero(event)' required>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Contratante:<br>
          <select class="form-control" name="pessoa">
              <?php 

                $query = mysql_query("SELECT ID_PESSOA,PES_NOME FROM pessoas WHERE PES_TP_CADASTRO = 0 AND PES_STATUS = 1");

                while ($row = mysql_fetch_array($query)){
                  $id_pessoa = $row['ID_PESSOA'];
                  $pessoa = $row['PES_NOME'];

                echo("             
                    <option value='$id_pessoa'>$pessoa</option>
                    ");
                }

              ?>
          </select>
          </div>
          </div>

          <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Data de Início:<br>
          <input type="text" id="campoData" placeholder="Ex.: 01-01-2016" class="form-control" name="dt_inicio" required>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Data de Término:<br>
          <input type="text" id="campoData1" placeholder="Ex.: 31-12-2016" class="form-control" name="dt_fim" required>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">   
          <br>Valor do Contrato:<br>
          <input type="text" id="mascara1" data-thousands="" placeholder="Ex.: 10.000,00" class="form-control" name="vl_total" maxlength="13">
          </div>
          </div>

          <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Valor por Peso:<br>
          <input type="text" id="mascara2" data-thousands="" placeholder="Ex.: 4,50" class="form-control" name="vl_peso" maxlength="13" disabled="">
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Endereço de Partida:<br>
          <input type="text" placeholder="Ex.: Avenida dos Cravos Nº 13 Jardim das Flores Taubaté/SP" class="form-control" name="partida" maxlength="80">
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
          <br>Endereço de Destino:<br>
          <input type="text" placeholder="Ex.: Estrada dos Pardais Nº 11 Parque das Aves Pindamonhangaba/SP" class="form-control" name="destino" maxlength="80">
          </div>
          </div>

          <br>Descrição:<br>
          <textarea cols="40" rows="5" class="form-control" name="descricao" maxlength="200"></textarea>

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
      if (verificaDataContrato($_POST["dt_inicio"],$_POST["dt_fim"]) == true)
      {
        $tp_contrato = $_POST["tp_contrato"];
        $nr_contrato = $_POST["nr_contrato"];
        $dt_inicio   = date('Y-m-d', strtotime($_POST["dt_inicio"]));
        $dt_fim      = date('Y-m-d', strtotime($_POST["dt_fim"]));
        if (!isset($_POST["vl_total"]))
        {
          $vl_total = 0.00;
        }
        else
        {
          $vl_total    = $_POST["vl_total"];  
          #$vl_total   = number_format(floatval($vl_total), 2, '.', '');
        }
        if (!isset($_POST["vl_peso"]))
        {
          $vl_peso = 0.00;
        }
        else
        {
          $vl_peso     = $_POST["vl_peso"];
          #$vl_peso    = number_format(floatval($vl_peso), 2, '.', '');    
        }      
        $partida     = $_POST["partida"];
        $destino     =  $_POST["destino"];
        $descricao   = $_POST["descricao"];
        $pessoa      = $_POST["pessoa"];
        $res         = mysql_query("INSERT INTO contratos VALUES (NULL,'$tp_contrato','$nr_contrato','$dt_inicio','$dt_fim','$vl_peso','$vl_total', '$partida', '$destino','$descricao', 1, '$pessoa');"); 

        if(mysql_affected_rows()>0)
        {
          echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-success'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'><p align='center'> Cadastrado realizado com sucesso!<br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></p></div> 
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
              <div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
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
              <div class='panel-heading'><h3 class='panel-title text-left'>Aviso</h3></div> 
              <div class='panel-body'> <p align='center'>A data inicial do contrato deve ser maior que a data de término.<br><br><a class='btn btn-danger btn-sm' href='javascript:history.go(-1);'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</a></p></div> 
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

    <!-- Máscara para datas, telefones e senhas -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
       $("#campoData1").mask("99-99-9999");
     });

    $(function($) {
      $('#mascara1').maskMoney();
    })

    $(function($) {
      $('#mascara2').maskMoney();
    })
    
      function SomenteNumero(e){
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
          if (tecla==8 || tecla==0) return true;
          else  return false;
        }
      }

    function verifica()
    {
      var testa = document.getElementById("tpContrato").value;
      if (testa == 1)
      {
         document.getElementById("mascara1").disabled = false;
         document.getElementById("mascara2").disabled = true;
      } 
      else
      {
         document.getElementById("mascara1").disabled = true;
         document.getElementById("mascara2").disabled = false;
      }
    }
    </script>
            
</div>


