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

    $query = mysql_query("SELECT * FROM veiculos WHERE ID_VEICULO <> 0 ORDER BY VEI_STATUS DESC");

    echo("<div class='container theme-showcase'>");
    while ($row = mysql_fetch_array($query)){
          $id = $row['ID_VEICULO'];
          $uf = $row['VEI_PLACA_UF'];
          $municipio = $row['VEI_PLACA_MUN'];
          $placa = $row['VEI_PLACA_COD'];
          $modelo  = $row['VEI_MODELO'];
          $marca = $row['VEI_MARCA'];
          $ano = $row['VEI_ANO'];
          $status  = $row['VEI_STATUS'];
          $observacao =  substr($row['VEI_OBSERVACAO'],0,35);
          $nome_imagem  = $row['VEI_FOTO'];

          
          if($status==1){
            $statusd = '<h5><b>Status: <font color="green">Ativo</font> </b></h5>';
          } else {
            $statusd = '<h5><b>Status: <font color="red">Inativo</font> </b></h5>';
          }

          //if($status==1){
          //  $statusd = 'Ativo';
          //} else {
          //  $statusd = 'Inativo';
          //}

          echo("
          	<div class='col-sm-6 col-md-4'>
            	<div class='thumbnail'> 
          		  <img src='uploads/$nome_imagem' data-holder-rendered='true'	style='height: 200px; width: 100%; display: block;'> 
            		<div class='caption'> 

              		<h3>Placa: $placa</h3>
                  <h5 align='justify'>$municipio - $uf</h5>
                  <h5 align='justify'><b>Modelo:</b> $modelo</h5>
                  <h5 align='justify'><b>Marca:</b> $marca <b>Ano:</b> $ano</h5>
              		<h5 align='justify'><b>Observação:</b> $observacao ...</h5>
                  $statusd

                  <form method='POST' action='atu_veiculo.php' class='form-inline'>
                    <input type='hidden' name='id' value='$id'>
                    <div class='form-group' id='div-veiculo'>
                      <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Alterar</button>
                    </div>
                  </form>

          		  </div> 
          		</div>
          	</div>
             	");
          
          }

        mysql_close($conecta);

        echo("</div>
        	");
  }

?>

</div>

<div class="rodape">
<?php include_once('footer.php'); ?>
</div>
            
</div>