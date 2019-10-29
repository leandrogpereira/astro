<div class="row">
  <div class="col-md-12">
    <br>Mês:<br>

<?php

  include_once('conexao.php');

  if ($_POST["ano"] == NULL)
  {
    header("Location:index.php");
  }
  else
  {
    $ano = $_POST["ano"];
  }

  $query = mysql_query("SELECT PER_MES, ST_PERIODO FROM periodos WHERE PER_ANO = $ano");

  while ($row = mysql_fetch_array($query))
  {
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
          <div class='radio'>
            <label>
              <input type='radio' name='mes' value=$nr_mes required> $mes <span class='status'>($status)</span>
            </label>
          </div>
        ");
  }

?>

  <button type="submit" class="btn btn-primary center-block" name="selecionar">Selecionar</button>

<?php

  mysql_close($conecta);

?>