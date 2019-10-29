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
      <h3 class="panel-title altura"> PARA GERENCIAR UM FUNCIONÁRIO, CLIQUE NO REGISTRO DESEJADO:
      <button type='button' class='btn btn-primary btn-sm direita' onClick="history.go(0)" VALUE="Refresh" align="right"> <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Atualizar lista </button>
      </h3>
    </div>

    <div class="panel-body">

<div class="table-responsive">  
<table class="table table-striped table-hover" id="datatable">
  <thead>
    <tr>
      <th>ID</th>
      <th>CPF</th>
      <th>Nome</th>
      <th>E-mail</th>
      <th>Cargo</th>
      <th>Status</th>
      <th class="text-center">Alterar</th>
      <th class="text-center">Senha</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    $query = mysql_query("SELECT
                            F.ID_FUNCIONARIO,
                            F.FUN_CPF,
                            F.FUN_NOME,
                            F.FUN_SOBRENOME,
                            F.FUN_EMAIL,
                            C.CAR_NOME,
                            F.FUN_STATUS
                            FROM funcionarios F
                            INNER JOIN cargos C ON C.ID_CARGO = F.ID_CARGO");

    while ($row = mysql_fetch_array($query)){
      $id_funcionario = $row['ID_FUNCIONARIO'];
      $cpf = $row['FUN_CPF'];
      $nome = $row['FUN_NOME'];
      $sobrenome = $row['FUN_SOBRENOME'];
      $email = $row['FUN_EMAIL'];
      $cargo = $row['CAR_NOME'];
      $status = $row['FUN_STATUS'];
      if ($status == 1) {
        $status = "Ativo";
      } else {
        $status = "Inativo";
      }

      echo("             
        <tr>
          <th scope='row'>$id_funcionario</th>
          <td>$cpf</td>
          <td>$nome $sobrenome</td>
          <td>$email</td>
          <td>$cargo</td>
          <td>$status</td>
          <td align='center'>
            <form method='POST' action='atu_funcionario.php'>
              <input type='hidden' name='id_funcionario' value='$id_funcionario'>
              <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
            </form>
          </td>
          <td align='center' class='last-td'>
            <form method='POST' action='atu_senha_funcionario.php'>
              <input type='hidden' name='id_funcionario' value='$id_funcionario'>
              <input type='hidden' name='email' value='$email'>
              <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></button>
            </form>
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