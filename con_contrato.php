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
          <h3 class="panel-title">CONSULTA DE CONTRATOS:</h3>
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
              <label for="">Situação:</label><br>
              <select id="ativo" name="ativo" class="form-control">
                <option value="1" selected>Somente ativo</option>
                <option value="">Todos</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="tp_contrato">Tipo:</label>
              <select class="form-control" id="tp_contrato" name="tp_contrato">
                <option value="">Todos</option>
                    <?php 

                      $query = mysql_query("SELECT * FROM tp_contrato");

                      while ($row = mysql_fetch_array($query))
                      {
                        $id_tp_contrato = $row['ID_TP_CONTRATO'];
                        $tpc_contrato = $row['TPC_DESCRICAO'];
                        echo ("<option value='$id_tp_contrato'>$tpc_contrato</option>");

                      }

                    ?>
              </select>
            </div>

            <div class="col-md-2">
              <label for="cliente">Cliente:</label>
              <select class="form-control" id="cliente" name="cliente">
                <option value="">Todos</option>
                    <?php 

                    $query = mysql_query("SELECT ID_PESSOA,PES_NOME FROM pessoas WHERE PES_TP_CADASTRO = 0 AND PES_STATUS = 1");

                    while ($row = mysql_fetch_array($query)){
                      $id_pessoa = $row['ID_PESSOA'];
                      $pessoa = $row['PES_NOME'];

                    echo("             
                        <option value='$id_pessoa'>$id_pessoa - $pessoa</option>
                        ");
                    }

                    ?>
              </select>
            </div>

            <div class="col-md-2">
              <br>
              <button type="button" id="consultar" class="btn btn-primary"><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button>
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

  <!-- TELA DE CONSULTA -->
  <script type="text/javascript">
    $('#consultar').click(function(){ //Quando clicado no elemento input
        $.ajax({
            type: "POST",
            url: 'consulta_contrato.php',            
            data: {              
              campoData: $('#campoData').val(),
              campoData1: $('#campoData1').val(),
              ativo: $('#ativo').val(),
              tpContrato: $('#tp_contrato').val(),
              cliente: $('#cliente').val()
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

  </script>

  <!-- Máscara para datas, telefones e senhas -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
       $("#campoTelefone").mask("(99) 9999-9999");
       $("#campoSenha").mask("***-****");
     });
    </script>

    <script>
      jQuery(function($){
     $("#campoData1").mask("99-99-9999");
     $("#campoTelefone1").mask("(99) 99999-9999");
     $("#campoSenha1").mask("***-****");
    });
    </script>
            
</div>