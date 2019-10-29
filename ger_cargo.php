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

    <!--ABRE DIV CONTAINER -->
    <div class="container theme-showcase" role="main">
      <!--ABRE DIV PANEL -->
      <div class="panel panel-primary">
        <!--ABRE DIV PANEL HEADER -->
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-10">
              <h3 class="panel-title altura">PARA GERENCIAR UM CARGO, CLIQUE NO REGISTRO DESEJADO:</h3>
            </div>
            <div class="col-xs-2 col-sm-1 col-sm-offset-1 col-md-1 col-md-offset-0">
               <button type='button' class='btn btn-primary btn-sm pull-right' onClick="history.go(0)" value="Refresh"> <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Atualizar</button>
            </div>
            <div class="col-xs-2 col-sm-1 col-sm-offset-1 col-md-1 col-md-offset-0">
               <button type='button' class='btn btn-default btn-sm pull-right' onClick="Inativos()"> <span class='glyphicon glyphicon-minus-sign' aria-hidden='true'></span> Inativos </button>
           </div>
          </div>
         <!--FECHA DIV PANEL HEADER -->
       </div>

      <!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
       <div id="confirm-delete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel" style="color:black">Confirmação</h4>
            </div>
            <div class="modal-body" style="color:black">
              Deseja realmente inativar o registro?
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
                <th class="text-center">Alterar</th>
                <th class="text-center">Remover</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $query = mysql_query("SELECT * FROM cargos WHERE CAR_STATUS = 1");
              while ($row = mysql_fetch_array($query)){
                $id_cargo = $row['ID_CARGO'];
                $descricao = $row['CAR_NOME'];

                if ($id_cargo == 1)
                {
                  echo "
                  <tr>
                    <th>$id_cargo</th>
                    <td>$descricao</td>
                    <td align='center'><button type='submit' class='btn btn-warning btn-sm' disabled><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button></td>
                    <td align='center'><button class='btn btn-danger btn-sm' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></td>
                  </tr>";
                }
                else
                {
                echo("             
                  <tr>
                    <th scope='row'>$id_cargo</th>
                    <td>$descricao</td>
                    <td align='center' class='last-td' style='width: 110px'>
                      <form method='POST' action='atu_cargo.php'>
                        <input type='hidden' name='id_cargo' value='$id_cargo'>
                        <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
                      </form>
                    </td>
                    <td align='center' class='last-td' style='width: 110px'>
                      <button class='btn btn-danger btn-sm' data-href='exc_cargo.php?id=$id_cargo' data-toggle='modal' data-target='#confirm-delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>
                    </td>
                  </tr>


                  ");
                }
              }
              mysql_close($conecta);
            }
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

<script type="text/javascript">
  function Inativos()
  {
    location.href="ina_cargo.php"
  }
</script>

<!--FECHA DIV TUDO -->
</div>