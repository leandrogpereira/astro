          <div class="table-responsive">  
            <table class="table table-hover table-consulta" id="datatable">
              <thead>
                <tr>
                <th>Código</th>
                <th>Data</th>
                <th>Nota</th>
                <th>Tipo</th>
                <th>Fornecedor</th>
                <th>Responsável</th>
                <th>Descrição</th>
                <th>Valor (R$)</th>
                <th>Situação</th>
                <th>Data da Baixa</th>
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

                  if ($_POST["tpDespesa"] == NULL)
                  {
                    $tp_despesa = '';
                  }
                  else
                  {
                    $tp_despesa = $_POST["tpDespesa"];
                  }

                  if ($_POST["fornecedor"] == NULL)
                  {
                    $fornecedor = '';
                  }
                  else
                  {
                    $fornecedor = $_POST["fornecedor"];
                  }

                  if ($_POST["funcionario"] == NULL)
                  {
                    $funcionario = '';
                  }
                  else
                  {
                    $funcionario = $_POST["funcionario"];
                  }

                  $query = mysql_query("SELECT
                                             D.ID_DESPESA
                                            ,D.DES_DATA
                                            ,D.DES_NOTA
                                            ,D.DES_DESCRICAO
                                            ,P.PES_NOME
                                            ,T.TPD_DESCRICAO
                                            ,F.FUN_NOME
                                            ,F.FUN_SOBRENOME
                                            ,B.BAI_VALOR
                                            ,B.BAI_DATA
                                            ,B.ST_BAIXA
                                             FROM despesas D
                                             LEFT JOIN pessoas P ON P.ID_PESSOA = D.ID_PESSOA
                                             LEFT JOIN tp_despesas T ON T.ID_TP_DESPESA = D.ID_TP_DESPESA
                                             LEFT JOIN funcionarios F ON F.ID_FUNCIONARIO = D.ID_FUNCIONARIO
                                             LEFT JOIN baixas B ON B.ID_DESPESA = D.ID_DESPESA
                                                WHERE ((D.DES_DATA  >= '$dt_inicio') OR ('$dt_inicio' = ''))
                                                  AND ((D.DES_DATA  <= '$dt_fim') OR ('$dt_fim' = '')) 
                                                  AND ((B.BAI_VALOR  >= '$vl_inicial') OR ('$vl_inicial' = ''))
                                                  AND ((B.BAI_VALOR  <= '$vl_final') OR ('$vl_final' = ''))
                                                  AND ((B.ST_BAIXA = '$status') OR ('$status' = ''))
                                                  AND ((D.ID_TP_DESPESA = '$tp_despesa') OR ('$tp_despesa' = ''))
                                                  AND ((D.ID_PESSOA = '$fornecedor') OR ('$fornecedor' = ''))
                                                  AND ((D.ID_FUNCIONARIO = '$funcionario') OR ('$funcionario' = ''))");

                  while ($row = mysql_fetch_array($query))
                  {
                    $id_despesa = $row['ID_DESPESA'];
                    $data = date('d-m-Y', strtotime($row['DES_DATA']));
                    $nota = $row['DES_NOTA'];
                    $descricao = $row['DES_DESCRICAO'];
                    $fornecedor = $row['PES_NOME'];
                    $tp_despesa = $row['TPD_DESCRICAO'];
                    $funcionario = $row['FUN_NOME'];
                    $sobrenome = $row['FUN_SOBRENOME'];
                    $valor = $row['BAI_VALOR'];
                    if ($row['ST_BAIXA'] == 1) {
                      $status = "Baixado";
                      $dt_baixa = date('d-m-Y', strtotime($row['BAI_DATA']));
                    }
                    else {
                      $status = "Pendente";
                      $dt_baixa = "--";
                    }

                    echo ("             
                      <tr>
                      <th scope='row'>$id_despesa</th>
                      <td>$data</td>
                      <td>$nota</td>
                      <td>$tp_despesa</td>
                      <td>$fornecedor</td>
                      <td>$funcionario $sobrenome</td>
                      <td>$descricao</td>
                      <td>$valor</td>
                      <td>$status</td>
                      <td>$dt_baixa</td>
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