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
          <h3 class="panel-title">RELATÓRIO DE BAIXAS:</h3>
        </div>
        <div class="panel-body">
          <h4 class="panel-title">Selecione as opções para realizar os filtros desejados, e depois clique no botão:</h4>
          <br>

          <form method="POST" target="_blank" action="emi_baixas.php">

          <div class="row">
            <div class="col-md-2">
              <label for="campoData">Data inicial:</label>
              <input type="text" id="campoData" placeholder="Ex.: 01-01-2016" class="form-control" name="dt_inicio" value="01-01-2016" autofocus="">
            </div>
            <div class="col-md-2">
              <label for="campoData1">Data final:</label>
              <input type="text" id="campoData1" placeholder="Ex.: 30-06-2016" class="form-control" name="dt_fim" value=<?= $data_padrao = date('d-m-Y');?> required>
            </div>
            <div class="col-md-2">
              <label for="mascara1">Valor inicial:</label>
              <input type="text" id="mascara1" placeholder="Ex.: 123,99" class="form-control" name="vl_inicial" data-precision="2" value="">
            </div>
            <div class="col-md-2">
              <label for="mascara2">Valor final:</label>
              <input type="text" id="mascara2" placeholder="Ex.: 200,00" class="form-control" name="vl_final" data-precision="2" value="">
            </div>
            <div class="col-md-2">
              <label for="tipo">Tipo:</label><br>
              <select id="tipo" name="tipo" class="form-control">
                <option value="" selected>Todos</option>
                <option value="0">Receitas</option>
                <option value="1">Despesa</option>
                <option value="2">Proventos de Contratos</option>
                <option value="3">Lançamentos(-)</option>
                <option value="4">Lançamentos(+)</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="situacao">Situação:</label><br>
              <select id="situacao" name="situacao" class="form-control">
                <option value="" selected>Todos</option>
                <option value="1">Baixados</option>
                <option value="0">Pendentes</option>
              </select>
            </div>
            </div>
            </br>
            <div class="row">
            <div class="col-md-2">
              <label for="caixa">Conta Bancária:</label>
              <select class="form-control" id="caixa" name="caixa">
                <option value="">Todos</option>
                    <?php 

                      $query = mysql_query("SELECT ID_CAIXA,CAI_NOME FROM caixa WHERE ID_CAIXA <> 0 AND CAI_STATUS = 1");

                      while ($row = mysql_fetch_array($query))
                      {
                        $id_caixa = $row['ID_CAIXA'];
                        $caixa = $row['CAI_NOME'];
                        echo ("<option value='$id_caixa'>$id_caixa - $caixa</option>");

                      }

                    ?>
              </select>
            </div>
            <div class="col-md-2">
              <br>
              <button type="submit" name="enviar" class="btn btn-primary" ><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button>
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