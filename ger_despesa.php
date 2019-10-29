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
      <h3 class="panel-title">PARA GERENCIAR DESPESAS, CLIQUE NO REGISTRO DESEJADO:</h3>
    </div>
    <div class="panel-body">

    <!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
       <div id="confirm-delete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel" style="color:black">Confirmação</h4>
            </div>
            <div class="modal-body" style="color:black">
              Deseja realmente remover o registro?
            </div>

            <div align="right">
              <table>
                <thead>
                  <tr>
                    <th>
                     <button type="button" class="btn btn-default margem" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Cancelar</button>
                     <a class="btn btn-primary margem btn-ok"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Confirmar</a>
                   </th>
                 </tr>
               </thead>
             </table>
             <br>
           </div>
         </div>
       </div>
       </div>
       <!-- Fim Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
    
<div class="table-responsive">  
<table class="table table-hover" id="datatable">
  <thead>
    <tr>
      <th>Código</th>
      <th>Data</th>
      <th>Descrição</th>
      <th>Fornecedor</th>
      <th>Responsável</th>
      <th>Valor (R$)</th>
      <th class="text-center">Alterar</th>
      <th class="text-center">Remover</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    $query = mysql_query("SELECT 
                            D.ID_DESPESA,
                            D.DES_DATA,
                            D.DES_DESCRICAO,
                            P.PES_NOME,
                            F.FUN_NOME,
                            F.FUN_SOBRENOME,
                            B.BAI_VALOR
                          FROM despesas D
                            INNER JOIN pessoas P ON P.ID_PESSOA = D.ID_PESSOA
                            INNER JOIN funcionarios F ON F.ID_FUNCIONARIO = D.ID_FUNCIONARIO
                            INNER JOIN baixas B ON B.ID_DESPESA = D.ID_DESPESA");

    while ($row = mysql_fetch_array($query)){
      $id_despesa = $row['ID_DESPESA'];
      $data = date('d-m-Y', strtotime($row['DES_DATA']));
      $descricao = $row['DES_DESCRICAO'];
      $fornecedor = $row['PES_NOME'];
      $funcionario = $row['FUN_NOME'];
      $sobrenome = $row['FUN_SOBRENOME'];
      $valor = $row['BAI_VALOR'];

      echo("             
        <tr>
          <th scope='row'>$id_despesa</th>
          <td>$data</td>
          <td>$descricao</td>
          <td>$fornecedor</td>
          <td>$funcionario $sobrenome</td>
          <td>$valor</td>
          <td align='center'>
            <form method='POST' action='atu_despesa.php'>
              <input type='hidden' name='id_despesa' value='$id_despesa'>
              <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
            </form>
          </td>
          <td align='center' class='last-td'>
            <button class='btn btn-danger btn-sm' data-href='exc_despesa.php?id_despesa=$id_despesa' data-toggle='modal' data-target='#confirm-delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>
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

      <script type="text/javascript">
        $(document).ready(function() {
          $('#confirma').modal();
      });

      $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });
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