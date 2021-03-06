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
    ?>

    <div class="container theme-showcase" role="main">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">CONSULTA DE TRANSPORTES:</h3>
        </div>
        <div class="panel-body">
          <h4 class="panel-title">Selecione as opções para filtrar sua consulta e clique no botão:</h4>
          <br>
          <div class="row">
            <div class="col-md-2">
              <label for="campoData">Data inicial:</label>
              <input type="text" id="campoData" placeholder="Ex.: 01-01-2016" class="form-control" name="dt_inicio" value="" autofocus="">
            </div>
            <div class="col-md-2">
              <label for="campoData1">Data final:</label>
              <input type="text" id="campoData1" placeholder="Ex.: 30-06-2016" class="form-control" name="dt_fim" value="">
            </div>
            <div class="col-md-2">
              <label for="mascara1">Peso inicial:</label>
              <input type="text" id="mascara1" placeholder="Ex.: 11,99" class="form-control" name="vl_inicial" maxlength="5" data-precision="2" value="">
            </div>
            <div class="col-md-2">
              <label for="mascara2">Peso final:</label>
              <input type="text" id="mascara2" placeholder="Ex.: 99,99" class="form-control" name="vl_final" maxlength="5" data-precision="2" value="">
            </div>
            <div class="col-md-2">
              <label for="contrato">Contrato:</label>
              <select class="form-control" id="contrato" name="contrato">
                <option value="">Todos</option>
                    <?php 

                    $query = mysql_query("SELECT ID_CONTRATO,NR_CONTRATO,PES_NOME FROM contratos LEFT JOIN pessoas ON pessoas.ID_PESSOA = contratos.ID_PESSOA");

                    while ($row = mysql_fetch_array($query)){
                      $id_contrato = $row['ID_CONTRATO'];
                      $nr_contrato = $row['NR_CONTRATO'];
                      $cliente = $row['PES_NOME'];

                    echo("             
                        <option value='$id_contrato'>$nr_contrato - $cliente</option>
                        ");
                    }

                    ?>
              </select>
            </div>

            <div class="col-md-2">
              <label for="motorista">Motorista:</label>
              <select class="form-control" id="motorista" name="motorista">
                <option value="">Todos</option>
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
            </div>

            <div class="row">
            <div class="col-md-2">
              <label for="veiculo">Veículo:</label>
              <select class="form-control" id="veiculo" name="veiculo">
                <option value="">Todos</option>
                    <?php 

                    $query = mysql_query("SELECT ID_VEICULO,VEI_MARCA,VEI_MODELO FROM veiculos WHERE ID_VEICULO <> 0");

                    while ($row = mysql_fetch_array($query)){
                      $id_veiculo = $row['ID_VEICULO'];
                      $veiculo = $row['VEI_MODELO'];
                      $marca = $row['VEI_MARCA'];

                    echo("             
                        <option value='$id_veiculo'>$marca - $veiculo</option>
                        ");
                    }

                    ?>
                  </select>
            </div>
            <div class="col-md-2">
              <br>
              <button type="button" id="consultar" class="btn btn-primary" ><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button>
            </div>
          </div>

          <div id="consulta"></div>

        </div>
      </div>      
    </div>
    <?php } ?>
  </div>

  <div class="rodape">
  <?php include_once('footer.php'); ?>
  </div>  

  <!-- Máscara para datas, telefones e senhas -->
  <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

  <!-- Máscara para moeda -->
  <script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

  <!-- TELA DE CONSULTA -->
  <script type="text/javascript">
    $('#consultar').click(function(){ //Quando clicado no elemento input
        $.ajax({
            type: "POST",
            url: 'consulta_transporte.php',            
            data: {              
              campoData: $('#campoData').val(),
              campoData1: $('#campoData1').val(),
              mascara1: $('#mascara1').val(),
              mascara2: $('#mascara2').val(),
              contrato: $('#contrato').val(),
              veiculo: $('#veiculo').val(),
              motorista: $('#motorista').val()
            },
            success: function(data) {
              $('#consulta').html(data);
              
              //alert(data);
            }/*,
            beforeSend: function(){
              $('.loader').css({display:"block"});
            },
            complete: function(){
              $('.loader').css({display:"none"});
            }*/
      });
    });

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

  </script>
            
</div>