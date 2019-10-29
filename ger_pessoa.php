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
      <h3 class="panel-title altura"> PARA GERENCIAR UMA PESSOA, CLIQUE NO REGISTRO DESEJADO:
      <button type='button' class='btn btn-primary btn-sm direita' onClick="history.go(0)" VALUE="Refresh" align="right"> <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Atualizar lista </button>
      </h3>
    </div>

    <div class="panel-body">

<div class="table-responsive">  
<table class="table table-striped table-hover" id="datatable">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tipo Cadastro</th>
      <th>Tipo Pessoa</th>
      <th>Documento</th>
      <th>Nome</th>
      <th>Endereço</th>
      <th>Status</th>
      <th class="text-center">Alterar</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    $query = mysql_query("SELECT ID_PESSOA, PES_TP_CADASTRO, PES_TP_PESSOA, PES_DOCUMENTO, PES_NOME, PES_ENDERECO, PES_NUMERO, PES_BAIRRO, PES_CIDADE, PES_UF, PES_STATUS FROM pessoas");

    while ($row = mysql_fetch_array($query)){
      $id_pessoa = $row['ID_PESSOA'];
      $tpcadastro = $row['PES_TP_CADASTRO'];
      if ($tpcadastro == 1) {
        $tpcadastro = "Fornecedor";
      } else {
        $tpcadastro = "Cliente";
      }
      $tppessoa = $row['PES_TP_PESSOA'];
      if ($tppessoa == 1) {
        $tppessoa = "Física";
      } else {
        $tppessoa = "Jurídica";
      }
      $documento = $row['PES_DOCUMENTO'];
      $nome = $row['PES_NOME'];
      $endereco = $row['PES_ENDERECO'];
      $numero = $row['PES_NUMERO'];
      $bairro = $row['PES_BAIRRO'];
      $cidade = $row['PES_CIDADE'];
      $uf = $row['PES_UF'];
      $status = $row['PES_STATUS'];
      if ($status == 1) {
        $status = "Ativo";
      } else {
        $status = "Inativo";
      }

      echo("             
        <tr>
          <th scope='row'>$id_pessoa</th>
          <td>$tpcadastro</td>
          <td>$tppessoa</td>
          <td>$documento</td>
          <td>$nome</td>
          <td>$endereco, $numero - $bairro - $cidade - $uf</td>
          <td>$status</td>
          <td align='center' class='last-td'>
            <form method='POST' action='atu_pessoa.php'>
              <input type='hidden' name='id_pessoa' value='$id_pessoa'>
              <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
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