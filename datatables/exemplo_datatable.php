<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>





    <br>
     <div class="container">
        <table  class="table table-striped table-hover table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>País</th>
                    <th>Posição</th>

                </tr>
            </thead>
            <tfoot>
                    <th>Nome</th>
                    <th>País</th>
                    <th>Posição</th>
            </tfoot>
            <tbody>
                <tr>
                    <td>Neymar</td>
                    <td>Brasil</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Lugano</td>
                    <td>Uruguai</td>
                    <td>Zagueiro</td>
                </tr>
                <tr>
                    <td>Forlan</td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>T. Silva</td>
                    <td>Brasil</td>
                    <td>Zagueiro</td>
                </tr>
                <tr>
                    <td>Messi</td>
                    <td>Argentina</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>D. Villa</td>
                    <td>Espanha</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>J. Campos</td>
                    <td>México</td>
                    <td>Goleiro</td>
                </tr>
                <tr>
                    <td>Dos Santos</td>
                    <td>México</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Forlán</td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Forlán 2</td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Forlán 3</td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Forlán 4</td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Forlán 5</td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Forlán 6 </td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
                <tr>
                    <td>Forlán 7</td>
                    <td>Uruguai</td>
                    <td>Atacante</td>
                </tr>
            </tbody>
        </table>
        </div>







    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="datatables/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
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
    "sLengthMenu": "_MENU_ resultados por página",
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

  </body>
</html>

