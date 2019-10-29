          <div class="table-responsive">  
            <table class="table table-hover table-consulta" id="datatable">
              <thead>
                <tr>
                <th>Código</th>
                <th>Data</th>
                <th>Observação</th>
                <th>Veículo</th>
                <th>Motorista</th>
                <th>Tipo de Contrato</th>
                <th>Contrato</th>
                <th>Nota</th>
                <th>Peso (Ton)</th>
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

                  if ($_POST["ativo"] == NULL)
                  {
                    $status = '';
                  }
                  else
                  {
                    $status = $_POST["ativo"];
                  }

                  if ($_POST["contrato"] == NULL)
                  {
                    $contrato = '';
                  }
                  else
                  {
                    $contrato = $_POST["contrato"];
                  }

                  if ($_POST["motorista"] == NULL)
                  {
                    $motorista = '';
                  }
                  else
                  {
                    $motorista = $_POST["motorista"];
                  }

                  if ($_POST["veiculo"] == NULL)
                  {
                    $veiculo = '';
                  }
                  else
                  {
                    $veiculo = $_POST["veiculo"];
                  }

                  $query = mysql_query("SELECT
                                             T.ID_TRANSPORTE
                                            ,T.TRA_DATA
                                            ,T.TRA_NOTA
                                            ,T.TRA_PESO
                                            ,T.TRA_OBSERVACAO
                                            ,V.VEI_MODELO
                                            ,V.VEI_MARCA
                                            ,F.FUN_NOME
                                            ,F.FUN_SOBRENOME
                                            ,TP.TPC_DESCRICAO
                                            ,C.NR_CONTRATO
                                            ,P.PES_NOME
                                             FROM transportes T
                                             LEFT JOIN contratos C ON C.ID_CONTRATO = T.ID_CONTRATO
                                             LEFT JOIN tp_contrato TP ON TP.ID_TP_CONTRATO = C.ID_TP_CONTRATO
                                             LEFT JOIN pessoas P ON P.ID_PESSOA = C.ID_PESSOA
                                             LEFT JOIN funcionarios F ON F.ID_FUNCIONARIO = T.ID_FUNCIONARIO
                                             LEFT JOIN veiculos V ON V.ID_VEICULO = T.ID_VEICULO
                                                WHERE ((DATE(T.TRA_DATA)  >= '$dt_inicio') OR ('$dt_inicio' = ''))
                                                  AND ((DATE(T.TRA_DATA)  <= '$dt_fim') OR ('$dt_fim' = '')) 
                                                  AND ((T.TRA_PESO  >= '$vl_inicial') OR ('$vl_inicial' = ''))
                                                  AND ((T.TRA_PESO  <= '$vl_final') OR ('$vl_final' = ''))
                                                  AND ((T.ID_VEICULO = '$veiculo') OR ('$veiculo' = ''))
                                                  AND ((C.ID_CONTRATO = '$contrato') OR ('$contrato' = ''))
                                                  AND ((F.ID_FUNCIONARIO = '$motorista') OR ('$motorista' = ''))");

                  while ($row = mysql_fetch_array($query))
                  {
                    $id_transporte = $row['ID_TRANSPORTE'];
                    $data = date('d-m-Y H:i:s', strtotime($row['TRA_DATA']));
                    $nota = $row['TRA_NOTA'];
                    $peso = $row['TRA_PESO'];
                    $observacao = $row['TRA_OBSERVACAO'];
                    $veiculo = $row['VEI_MODELO'];
                    $marca = $row['VEI_MARCA'];
                    $motorista = $row['FUN_NOME'];
                    $sobrenome = $row['FUN_SOBRENOME'];
                    $tp_contrato = $row['TPC_DESCRICAO'];
                    $contrato = $row['NR_CONTRATO'];
                    $cliente = $row['PES_NOME'];

                    echo ("             
                      <tr>
                      <th scope='row'>$id_transporte</th>
                      <td>$data</td>
                      <td>$observacao</td>
                      <td>$marca - $veiculo</td>
                      <td>$motorista $sobrenome</td>
                      <td>$tp_contrato</td>
                      <td>$contrato - $cliente</td>
                      <td>$nota</td>
                      <td>$peso</td>
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