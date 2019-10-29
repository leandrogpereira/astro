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
          <h3 class="panel-title">PARA BAIXAR OS LANÇAMENTOS NO BANCO, CLIQUE NO REGISTRO DESEJADO:</h3>
        </div>
        <div class="panel-body">
        
    <div class="table-responsive">  
    <table class="table table-hover" id="datatable">
      <thead>
        <tr>
          <th>#</th>
          <th>Data do Documento</th>
          <th>Documento</th>
          <th>Código</th>
          <th>Tipo</th>
          <th>Valor</th>
          <th class="text-center">Baixar</th>
        </tr>
      </thead>
      <tbody>

        <?php 

        $query = mysql_query("SELECT 
                                    B.ID_BAIXA
                                   ,(CASE WHEN B.TP_BAIXA = 0 THEN T.TRA_DATA
                                          WHEN B.TP_BAIXA = 1 THEN D.DES_DATA
                                          ELSE B.BAI_DATA END) AS DATA_BAIXA
                                   , (CASE WHEN B.TP_BAIXA = 0 THEN T.TRA_NOTA
                                      WHEN B.TP_BAIXA  = 1 THEN D.DES_NOTA
                                      ELSE LA.LAN_DOCUMENTO END) AS DOCUMENTO
                                   ,(CASE WHEN B.TP_BAIXA = 0 THEN B.ID_TRANSPORTE
                                          WHEN B.TP_BAIXA = 1 THEN B.ID_DESPESA
                                          WHEN B.TP_BAIXA = 2 THEN B.ID_CONTRATO
                                          ELSE B.ID_LANCAMENTO END) AS CODIGO
                                   ,B.TP_BAIXA
                                   ,B.BAI_VALOR
                                  FROM baixas B
                                    LEFT JOIN contratos C ON C.ID_CONTRATO = B.ID_CONTRATO
                                    LEFT JOIN pessoas P ON C.ID_PESSOA = P.ID_PESSOA
                                    LEFT JOIN transportes T ON T.ID_TRANSPORTE = B.ID_TRANSPORTE
                                    LEFT JOIN despesas D ON D.ID_DESPESA = B.ID_DESPESA
                                    LEFT JOIN caixa CA ON CA.ID_CAIXA = B.ID_CAIXA
                                    LEFT JOIN lancamentos LA ON LA.ID_LANCAMENTO = B.ID_LANCAMENTO
                                  WHERE B.ST_BAIXA = 0");

        while ($row = mysql_fetch_array($query)){
          $id_baixa = $row['ID_BAIXA'];
          $data = date('d-m-Y', strtotime($row['DATA_BAIXA']));
          $documento = $row['DOCUMENTO'];
          $codigo = $row['CODIGO'];
          switch ($row['TP_BAIXA'])
          {
            case 0:
              $tipo = "Receita";
              break;
            case 1:
              $tipo = "Despesa";
              break;
            case 2:
              $tipo = "Contrato";
              break;
            default:
              $tipo = "Lançamento";
              break;
          }

          $valor = $row['BAI_VALOR'];

          echo("             
            <tr>
              <th scope='row'>$id_baixa</th>
              <td>$data</td>
              <td>$documento</td>
              <td>$codigo</td>
              <td>$tipo</td>
              <td>$valor</td>
              <td align='center' class='last-td'>
                <form method='POST' action='cad_baixa_item.php'>
                  <input type='hidden' name='id_baixa' value='$id_baixa'>
                  <input type='hidden' name='tipo' value='$tipo'>
                  <input type='hidden' name='documento' value='$documento'>
                  <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button>
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

<script>
        $(document).ready(function() {
          $('#example').DataTable();
        } );
    </script>


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