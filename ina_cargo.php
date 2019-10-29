<link rel="shortcut icon" href="img/favicon.png">
<!--ABRE DIV TUDO -->
<div class="tudo">

  <!--ABRE DIV TOPO -->
  <div class="topo">
    <?php include_once('header.php'); ?>
    <!--FECHA DIV TUDO -->
  </div>

  <!--ABRE DIV CONTEUDO -->
  <div class="conteudo">

    <?php include_once('conexao.php'); ?>

    <!--ABRE DIV CONTAINER -->
    <div class="container theme-showcase" role="main">
      <!--ABRE DIV PANEL -->
      <div class="panel panel-primary">
        <!--ABRE DIV PANEL HEADER -->
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-10">
              <h3 class="panel-title altura"> PARA REATIVAR UM CARGO, CLIQUE NO REGISTRO DESEJADO:</h3>
            </div>
            <div class="col-xs-2 col-sm-1 col-sm-offset-1 col-md-1 col-md-offset-0">
              <button type='button' class='btn btn-primary btn-sm pull-right' onClick="history.go(0)" VALUE="Refresh" align="right"> <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Atualizar lista </button>
             </div>
             <div class="col-xs-2 col-sm-1 col-sm-offset-1 col-md-1 col-md-offset-0">
              <button type='button' class='btn btn-default btn-sm pull-right' onClick="Inativos()" align="right"> <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span> Ver ativos </button>
             </div>
           </div>
         <!--FECHA DIV PANEL HEADER -->
       </div>


 
      <!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
       <div id="confirm-active" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel" style="color:black">Confirmação</h4>
            </div>
            <div class="modal-body" style="color:black">
              Deseja realmente reativar o registro?
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



       <!--ABRE DIV PANEL BODY -->
       <div class="panel-body">
        <!--ABRE DIV TABLE RESPONSIVE -->
        <div class="table-responsive">  
          <table class="table table-striped table-hover" id="datatable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th class="text-center">Reativar</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $query = mysql_query("SELECT * FROM cargos WHERE CAR_STATUS = 0");
              while ($row = mysql_fetch_array($query)){
                $id_cargo = $row['ID_CARGO'];
                $descricao = $row['CAR_NOME'];

                echo("             
                  <tr>
                    <th scope='row'>$id_cargo</th>
                    <td>$descricao</td>
                    <td align='center' class='last-td' style='width: 110px'>
                      <button class='btn btn-success btn-sm' data-href='ati_cargo.php?id_cargo=$id_cargo' data-toggle='modal' data-target='#confirm-active'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span>
                      </button>
                    </td>
                  </tr>
                  ");
              }
              mysql_close($conecta);
              ?>
            </tbody>
          </table>
          <!--FECHA DIV TABLE RESPONSIVE -->  
        </div>
        <br>
        <!--FECHA DIV PANEL BODY -->    
      </div>
      <!--FECHA DIV PANEL --> 
    </div>
    <!--FECHA DIV CONTAINER -->      
  </div>

  <!--FECHA DIV CONTEUDO -->
</div>

<!--ABRE DIV RODAPE -->
<div class="rodape">
  <?php include_once('footer.php'); ?>
  <!--FECHA DIV RODAPE -->
</div>

<script>
  $('#confirm-active').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
</script>

<!-- PARA FUNCIONAR O DATATABLE -->
<script src="datatables/js/jquery.js"></script>
<script src="datatables/js/jquery.dataTables.min.js"></script>
<script src="datatables/js/dataTables.bootstrap.min.js"></script>
<script>
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
</script>

<script type="text/javascript">
  function Inativos()
  {
    location.href="ger_cargo.php"
  }
</script>

<!--FECHA DIV TUDO -->
</div>