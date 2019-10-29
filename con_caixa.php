<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

  <div class="topo">
  <?php include_once('header.php'); ?>
  </div>

  <div class="conteudo">

    <?php
      include_once('conexao.php');
      $dt_inicio = "01-01-".$_SESSION["ano"];
      $data_padrao_inicial = date('d-m-Y', strtotime($dt_inicio));

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
          <h3 class="panel-title">CONSULTA DE EXTRATO BANCÁRIO:</h3>
        </div>
        <div class="panel-body">
        <div class="row">
          <div class="col-xs-12 col-md-6">
            <h4 class="panel-title">Selecione as opções para filtrar sua consulta e clique no botão:</h4>
          </div>
          <div class="col-xs-12 col-md-6">
            <div class="text-right" id="saldo"></div>
          </div>
        </div>

          <div class="row">

            <div class="col-md-2">
              <label for="campoData">Data inicial:</label>
              <input type="text" id="campoData" placeholder="Ex.: 01-01-2016" class="form-control" name="dt_inicio" value="" autofocus>
            </div>

            <div class="col-md-2">
              <label for="campoData1">Data final:</label>
              <input type="text" id="campoData1" placeholder="Ex.: 30-06-2016" class="form-control" name="dt_fim" value="">
            </div>

            <div class="col-md-2">
              <label for="caixa">Conta:</label>
              <select class="form-control" id="caixa" name="caixa">
                    <?php 

                    $query = mysql_query("SELECT ID_CAIXA,CAI_NOME FROM caixa WHERE ID_CAIXA <> 0 AND CAI_STATUS = 1");

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

            <input type="hidden" id="ano" name="ano" value=<?=$_SESSION["ano"]?>>
            <input type="hidden" id="data-padrao-inicial" name="data-padrao-inicial" value=<?=$data_padrao_inicial?>>
            <input type="hidden" id="data-padrao" name="data-padrao" value=<?=$data_padrao?>>

            <div class="col-md-2">
              <br>
              <button type="button" id="consultar" class="btn btn-primary"><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button>
            </div>

          </div>
          <br>
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

  <!-- TELA DE CONSULTA -->
  <script type="text/javascript">
    $('#consultar').click(function(){ //Quando clicado no elemento input
        $.ajax({
            type: "POST",
            url: 'consulta_extrato.php',            
            data: {              
              campoData: $('#campoData').val(),
              campoData1: $('#campoData1').val(),
              caixa: $('#caixa').val(),
              ano: $('#ano').val()
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

    $('#consultar').click(function(){ //Quando clicado no elemento input
        $.ajax({
            type: "POST",
            url: 'consulta_saldo.php',            
            data: {              
              campoData: $('#data-padrao-inicial').val(),
              campoData1: $('#data-padrao').val(),
              caixa: $('#caixa').val(),
              ano: $('#ano').val()
            },
            success: function(data) {
              $('#saldo').html(data);
              
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

  </script>
            
</div>