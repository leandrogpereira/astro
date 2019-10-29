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
          <h3 class="panel-title">RELATÓRIO DE ANIVERSÁRIANTES DO MÊS:</h3>
        </div>
        <div class="panel-body">
          <h4 class="panel-title">Selecione o mês desejado e depois clique no botão:</h4>
          <br>

          <form method="POST" target="_blank" action="emi_aniversariantes.php">

          <div class="row">

            <div class="col-md-11">
              <label for="">Mês:</label><br>
              <select id="mes" name="mes" class="form-control">
                <option value="2016/01/01" selected>Janeiro</option>
                <option value="2016/02/01">Fevereiro</option>
                <option value="2016/03/01">Março</option>
                <option value="2016/04/01">Abril</option>
                <option value="2016/05/01">Maio</option>
                <option value="2016/06/01">Junho</option>
                <option value="2016/07/01">Julho</option>
                <option value="2016/08/01">Agosto</option>
                <option value="2016/09/01">Setembro</option>
                <option value="2016/10/01">Outubro</option>
                <option value="2016/11/01">Novembro</option>
                <option value="2016/12/01">Dezembro</option>

              </select>
            </div>

            <div class="col-md-1" style="margin-top: 26px">
            <button type="submit" class="btn btn-primary" name="enviar"><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button>
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