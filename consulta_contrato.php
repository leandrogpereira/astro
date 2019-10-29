          <div class="table-responsive">  
            <table class="table table-hover table-consulta" id="datatable">
              <thead>
                <tr>
                <th>Código</th>
                <th>Tipo</th>
                <th>Número</th>
                <th>Cliente</th>
                <th>Início</th>
                <th>Término</th>
                <th>Partida</th>
                <th>Destino</th>
                <th>Vl. Peso (R$)</th>
                <th>Valor (R$)</th>
                <th>Situação</th>
                </tr>
              </thead>
              <tbody>
                <?php 

                  include_once('conexao.php');

                  if($_POST["campoData"] == NULL && $_POST["campoData1"] == NULL)
                  {
                    $dt_inicio = '';
                    $dt_fim = '';
                  }
                  else if($_POST["campoData1"] == NULL)
                  {
                    $dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["campoData"]));
                    $dt_fim = '';
                  }
                  else if($_POST["campoData"] == NULL)
                  {
                    $dt_inicio = '';
                    $dt_fim = date('Y-m-d H:i:s', strtotime($_POST['campoData1']));
                  }
                  else
                  {
                    $dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["campoData"]));
                    $dt_fim = date('Y-m-d H:i:s', strtotime($_POST['campoData1']));
                  }

                  if ($_POST["ativo"] == NULL)
                  {
                    $status = '';
                  }
                  else
                  {
                    $status = $_POST["ativo"];
                  }

                  if ($_POST["tpContrato"] == NULL)
                  {
                    $tp_contrato = '';
                  }
                  else
                  {
                    $tp_contrato = $_POST["tpContrato"];
                  }

                  if ($_POST["cliente"] == NULL)
                  {
                    $cliente = '';
                  }
                  else
                  {
                    $cliente = $_POST["cliente"];
                  }

                  $query = mysql_query("SELECT
                                             *
                                             FROM contratos C
                                             LEFT JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA
                                             LEFT JOIN tp_contrato T ON T.ID_TP_CONTRATO = C.ID_TP_CONTRATO
                                                WHERE ((C.CON_DT_INICIO  >= '$dt_inicio') OR ('$dt_inicio' = ''))
                                                  AND ((C.CON_DT_INICIO  <= '$dt_fim') OR ('$dt_fim' = '')) 
                                                  AND ((C.CON_STATUS     = '$status') OR ('$status' = ''))
                                                  AND ((C.ID_TP_CONTRATO = '$tp_contrato') OR ('$tp_contrato' = ''))
                                                  AND ((C.ID_PESSOA      = '$cliente') OR ('$cliente' = ''))");

                  while ($row = mysql_fetch_array($query))
                  {
                    $id_contrato = $row['ID_CONTRATO'];
                    $tp_contrato = $row['TPC_DESCRICAO'];
                    $nr_contrato = $row['NR_CONTRATO'];
                    $cliente = $row['PES_NOME'];
                    $dt_inicio = date('d-m-Y', strtotime($row['CON_DT_INICIO']));
                    $dt_fim = date('d-m-Y', strtotime($row['CON_DT_FIM']));
                    $vl_peso = $row['CON_VL_PESO'];
                    $valor = $row['CON_VALOR'];
                    $partida = $row['CON_PARTIDA'];
                    $destino = $row['CON_DESTINO'];
                    if ($row['CON_STATUS'] == 1) {
                      $status = "Ativo";
                    }
                    else {
                      $status = "Inativo";
                    }

                    echo ("             
                      <tr>
                      <th scope='row'>$id_contrato</th>
                      <td>$tp_contrato</td>
                      <td>$nr_contrato</td>
                      <td>$cliente</td>
                      <td>$dt_inicio</td>
                      <td>$dt_fim</td>
                      <td>$partida</td>
                      <td>$destino</td>
                      <td>$vl_peso</td>
                      <td>$valor</td>
                      <td class='last-td'>$status</td>
                      </td>
                      </tr>
                    ");
                  }
                mysql_close($conecta);
                ?>
              </tbody>
            </table>
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