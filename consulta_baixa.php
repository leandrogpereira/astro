          <div class="table-responsive">  
            <table class="table table-hover table-consulta" id="datatable">
              <thead>
                <tr>
                <th>Código</th>
                <th>Conta Bancária</th>
                <th>Documento</th>
                <th>Situação</th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Valor (R$)</th>
                </tr>
              </thead>
              <tbody>

                <?php 

                  include_once('conexao.php');

                  $total = 0.00;

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

                  if($_POST["mascara1"] == NULL && $_POST["mascara2"] == NULL)
                  {
                    $vl_inicial = '';
                    $vl_final = '';
                  }
                  else if($_POST["mascara2"] == NULL)
                  {
                    $vl_inicial = $_POST["mascara1"];
                    $vl_final = '';
                  }
                  else if($_POST["mascara1"] == NULL)
                  {
                    $vl_inicial = '';
                    $vl_final = $_POST['mascara2'];
                  }
                  else
                  {
                    $vl_inicial = $_POST["mascara1"];
                    $vl_final = $_POST['mascara2'];
                  }

                  if ($_POST["tipo"] == NULL)
                  {
                    $tipo = '';
                  }
                  else
                  {
                    $tipo = $_POST["tipo"];
                  }

                  if ($_POST["situacao"] == NULL)
                  {
                    $situacao = '';
                  }
                  else
                  {
                    $situacao = $_POST["situacao"];
                  }

                  if ($_POST["caixa"] == NULL)
                  {
                    $caixa = '';
                  }
                  else
                  {
                    $caixa = $_POST["caixa"];
                  }

                  $query = mysql_query("SELECT
                                             *
                                             FROM baixas B
                                             LEFT JOIN caixa C ON C.ID_CAIXA = B.ID_CAIXA
                                                WHERE ((B.BAI_DATA  >= '$dt_inicio') OR ('$dt_inicio' = ''))
                                                  AND ((B.BAI_DATA  <= '$dt_fim') OR ('$dt_fim' = '')) 
                                                  AND ((B.BAI_VALOR  >= '$vl_inicial') OR ('$vl_inicial' = ''))
                                                  AND ((B.BAI_VALOR  <= '$vl_final') OR ('$vl_final' = ''))
                                                  AND ((B.ST_BAIXA = '$situacao') OR ('$situacao' = ''))
                                                  AND ((C.ID_CAIXA = '$caixa') OR ('$caixa' = ''))
                                                  AND ((B.TP_BAIXA = '$tipo') OR ('$tipo' = ''))");

                  while ($row = mysql_fetch_array($query))
                  {
                    $id_baixa = $row['ID_BAIXA'];
                    $caixa = $row['CAI_NOME'];
                    $documento = $row['BAI_DESCRICAO'];
                    if ($row['ST_BAIXA'] == 1) {
                      $status = "Baixado";
                      $data = date('d-m-Y', strtotime($row['BAI_DATA']));
                    }
                    else {
                      $status = "Pendente";
                      $data = "--";
                    }
                    switch ($row['TP_BAIXA']) {
                      case 0:
                        $tipo = "Receita";
                        $valor = number_format(floatval($row['BAI_VALOR']), 2, '.', '');
                        break;
                      case 1:
                        $tipo = "Despesa";
                        $valor = number_format(floatval(-$row['BAI_VALOR']), 2, '.', '');
                        break;
                      case 2:
                        $tipo = "Contrato";
                        $valor = number_format(floatval($row['BAI_VALOR']), 2, '.', '');
                        break;
                      case 3:
                        $tipo = "Lançamento";
                        $valor = number_format(floatval(-$row['BAI_VALOR']), 2, '.', '');
                        break;
                      default:
                        $tipo = "Lançamento";
                        $valor = number_format(floatval($row['BAI_VALOR']), 2, '.', '');

                        break;
                    }

                    echo ("             
                      <tr>
                      <th scope='row'>$id_baixa</th>
                      <td>$caixa</td>
                      <td>$documento</td>
                      <td>$status</td>
                      <td>$data</td>
                      <td>$tipo</td>
                      <td>$valor</td>
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