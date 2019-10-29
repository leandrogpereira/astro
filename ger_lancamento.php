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
      <h3 class="panel-title">PARA GERENCIAR LANÇAMENTOS, CLIQUE NO REGISTRO DESEJADO:</h3>
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
      <th>Banco</th>
      <th>Tipo</th>
      <th>Descrição</th>
      <th>Documento</th>
      <th>Valor (R$)</th>
      <th class="text-center">Alterar</th>
      <th class="text-center">Remover</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    $query = mysql_query("SELECT 
                            L.ID_LANCAMENTO
                          , B.BAI_DATA
                          , C.CAI_NOME
                          , T.TPL_DESCRICAO
                          , L.LAN_DESCRICAO
                          , L.LAN_DOCUMENTO
                          , CASE WHEN (B.TP_BAIXA = 1 OR B.TP_BAIXA = 3) THEN -B.BAI_VALOR ELSE B.BAI_VALOR END AS BAI_VALOR
                          FROM lancamentos L
                            LEFT JOIN tp_lancamento T ON T.ID_TP_LANCAMENTO = L.ID_TP_LANCAMENTO
                            LEFT JOIN baixas B ON B.ID_LANCAMENTO = L.ID_LANCAMENTO
                            LEFT JOIN caixa C ON C.ID_CAIXA = B.ID_CAIXA");

    while ($row = mysql_fetch_array($query)){
      $id_lancamento = $row['ID_LANCAMENTO'];
      $data = date('d-m-Y', strtotime($row['BAI_DATA']));
      $caixa = $row['CAI_NOME'];
      $tp_lancamento = $row['TPL_DESCRICAO'];
      $descricao = $row['LAN_DESCRICAO'];
      $documento = $row['LAN_DOCUMENTO'];
      $valor = $row['BAI_VALOR'];

      echo("             
        <tr>
          <th scope='row'>$id_lancamento</th>
          <td>$data</td>
          <td>$caixa</td>
          <td>$tp_lancamento</td>
          <td>$descricao</td>
          <td>$documento</td>
          <td>$valor</td>
          <td align='center'>
            <form method='POST' action='atu_lancamento.php'>
              <input type='hidden' name='id_lancamento' value='$id_lancamento'>
              <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
            </form>
          </td>
          <td align='center' class='last-td'>
            <button class='btn btn-danger btn-sm' data-href='exc_lancamento.php?id_lancamento=$id_lancamento' data-toggle='modal' data-target='#confirm-delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>
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

      <script language="Javascript">
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