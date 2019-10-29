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
      <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-10">
          <h3 class="panel-title altura">PARA GERENCIAR OS PERÍODOS, CLIQUE NO REGISTRO DESEJADO:</h3>
        </div>
        <div class="col-xs-2 col-sm-1 col-sm-offset-1 col-md-1 col-md-offset-0">
           <a href='cad_periodo.php'><button type='button' class='btn btn-default btn-sm pull-right'> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Criar</button></a>
       </div>
      </div>
    </div>
    <div class="panel-body">
    
<div class="table-responsive">  
<table class="table table-hover" id="datatable">
  <thead>
    <tr>
      <th>Ano</th>
      <th>Mês</th>
      <th>Situação</th>
      <th class="text-center">Alterar</th>
    </tr>
  </thead>
  <tbody>

    <?php 

    $query = mysql_query("SELECT *
                            FROM periodos
                        ORDER BY PER_MES
                             ASC");

    while ($row = mysql_fetch_array($query)){
      $ano = $row['PER_ANO'];
      switch ($row["PER_MES"]) {
              case 1:
                $mes = "Janeiro";
                $nr_mes = $row["PER_MES"];
                break;
              case 2:
                $mes = "Fevereiro";
                $nr_mes = $row["PER_MES"];
                break;
              case 3:
                $mes = "Março";
                $nr_mes = $row["PER_MES"];
                break;
              case 4:
                $mes = "Abril";
                $nr_mes = $row["PER_MES"];
                break;
              case 5:
                $mes = "Maio";
                $nr_mes = $row["PER_MES"];
                break;
              case 6:
                $mes = "Junho";
                $nr_mes = $row["PER_MES"];
                break;
              case 7:
                $mes = "Julho";
                $nr_mes = $row["PER_MES"];
                break;
              case 8:
                $mes = "Agosto";
                $nr_mes = $row["PER_MES"];
                break;
              case 9:
                $mes = "Setembro";
                $nr_mes = $row["PER_MES"];
                break;
              case 10:
                $mes = "Outubro";
                $nr_mes = $row["PER_MES"];
                break;
              case 11:
                $mes = "Novembro";
                $nr_mes = $row["PER_MES"];
                break;
              case 12:
                $mes = "Dezembro";
                $nr_mes = $row["PER_MES"];
                break;
              default:
                $mes = "Erro";
                $nr_mes = $row["PER_MES"];
                break;
            }

            switch ($row["ST_PERIODO"]) {
              case 0:
                $status = "Encerrado";
                break;
              case 1:
                $status = "Aberto";
                break;
              
              default:
                $status = "Desconhecido";
                break;
            }

      echo("             
        <tr>
          <th>$ano</th>
          <td>$nr_mes - $mes</td>
          <td>$status</td>
          <td align='center' class='last-td'>
            <form method='POST' action='atu_periodo.php'>
              <input type='hidden' name='ano' value='$ano'>
              <input type='hidden' name='mes' value='$nr_mes'>
              <button type='submit' class='btn btn-warning btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
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
            
</div>