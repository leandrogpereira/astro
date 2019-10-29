<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
  if ($_SESSION["acesso"] != 3) {
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
      <h3 class="panel-title">PARA ATUALIZAR O SALDO BANCÁRIO INICIAL, CLIQUE NO REGISTRO DESEJADO:</h3>
    </div>
    <div class="panel-body">

    <!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
    <div id="confirm-atualiza" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel" style="color:black; text-align: center;">Aviso</h4>
        </div>
        <div class="modal-body" style="color:black ; text-align:center;">
          Confirma a atualização do saldo inicial da conta?
        </div>

        <div align="center">
          <table>
            <thead>
              <tr>
                <th>
                 <a class="btn btn-primary margem btn-ok"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Confirmar</a>
                 <button type="button" class="btn btn-default margem" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Cancelar</button>
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
      <th>Banco</th>
      <th>Agência</th>
      <th>Conta</th>
      <th>Descrição</th>
      <th class="text-center">Atualizar</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    $query = mysql_query("SELECT *
                            FROM caixa C
                           WHERE C.CAI_STATUS = 1
                             AND C.ID_CAIXA  <> 0");

    while ($row = mysql_fetch_array($query)){
      $id = $row['ID_CAIXA'];
      $banco = $row['CAI_BANCO'];
      $agencia = $row['CAI_AGENCIA'];
      $conta = $row['CAI_CONTA'];
      $descricao = $row['CAI_NOME'];

      echo("             
        <tr>
          <th scope='row'>$id</th>
          <td>$banco</td>
          <td>$agencia</td>
          <td>$conta</td>
          <td>$descricao</td>
          <td align='center' class='last-td'>          
              <button data-href='atu_saldo.php?id=$id' data-toggle='modal' data-target='#confirm-atualiza' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-refresh' aria-hidden='true'></span></button>
          </td>
        </tr>
         ");
    }
  }

    mysql_close($conecta);

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
        $('#confirm-atualiza').on('show.bs.modal', function(e) {
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