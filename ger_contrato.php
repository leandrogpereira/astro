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
    ?>

    <div class="container theme-showcase" role="main">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">PARA GERENCIAR CONTRATOS, CLIQUE NO REGISTRO DESEJADO:</h3>
        </div>
        <div class="panel-body">
        <h4 class="panel-title">Contratos que possuem transportes ou recebimentos vinculados <b>não</b> podem ser alterados.</h4><br>
          <div class="table-responsive">  
            <table class="table table-hover" id="datatable">
              <thead>
                <tr>
                <th>Código</th>
                <th>Nr. Contrato</th>
                <th>Cliente</th>
                <th>Início</th>
                <th>Término</th>
                <th>Valor Peso(R$)</th>
                <th>Valor Total(R$)</th>
                <th>Alterar</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $query = mysql_query("SELECT * FROM contratos C INNER JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA");

                  while ($row = mysql_fetch_array($query))
                  {
                    $id_contrato = $row['ID_CONTRATO'];
                    $nr_contrato = $row['NR_CONTRATO'];
                    $cliente = $row['PES_NOME'];
                    $dt_inicio = date('d-m-Y', strtotime($row['CON_DT_INICIO']));
                    $dt_fim = date('d-m-Y', strtotime($row['CON_DT_FIM']));
                    $valor = $row['CON_VALOR'];
                    $vl_peso = $row['CON_VL_PESO'];

                    echo("             
                      <tr>
                      <th scope='row'>$id_contrato</th>
                      <td>$nr_contrato</td>
                      <td>$cliente</td>
                      <td>$dt_inicio</td>
                      <td>$dt_fim</td>
                      <td>$vl_peso</td>
                      <td>$valor</td>
                      <td class='last-td'>
                      <form method='POST' action='atu_contrato.php'>
                        <input type='hidden' name='id_contrato' value='$id_contrato'>
                        <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
                      </form>
                      </td>
                      </tr>
                    ");
                  }
                mysql_close($conecta);
              }
                ?>
              </tbody>
            </table>
          </div>

        <br>

        </div>
      </div>      
    </div>
  </div>


  <div class="rodape">
  <?php include_once('footer.php'); ?>
  </div>

      <!-- PARA FUNCIONAR O DATATABLE -->
      <script src="datatables/js/jquery.js"></script>
      <script src="datatables/js/jquery.dataTables.min.js"></script>
      <script src="datatables/js/dataTables.bootstrap.min.js"></script>
      <script src="datatables/js/moment.min.js"></script>
      <script src="datatables/js/datetime-moment.js"></script>
      <script>

        $(document).ready(function() {
        
        $.fn.dataTable.moment('DD-MM-YYYY');

        $('#datatable').dataTable({
          "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ Resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
              "sNext": "Próximo",
              "sPrevious": "Anterior",
              "sFirst": "Primeiro",
              "sLast": "Último"
            },
            "oAria": {
              "sSortAscending": ": Ordenar colunas de forma ascendente",
              "sSortDescending": ": Ordenar colunas de forma descendente"
            }
          }
        } );

      } );
      </script>
            
</div>