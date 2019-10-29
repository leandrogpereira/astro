<?php 

  include_once('conexao.php');

  if($_POST["campoData"] == NULL && $_POST["campoData1"] == NULL)
  {
    $dt_inicio = '';
    $data_ini = '';
    $dt_fim = '';
  }
  else if($_POST["campoData1"] == NULL)
  {
    $dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["campoData"]));
    $data_ini = date('Y-m-d H:i:s', strtotime('-1 days', strtotime($dt_inicio)));
    $dt_fim = '';
  }
  else if($_POST["campoData"] == NULL)
  {
    $dt_inicio = '';
    $data_ini = '';
    $dt_fim = date('Y-m-d H:i:s', strtotime($_POST['campoData1']));
  }
  else
  {
    $dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["campoData"]));
    $data_ini = date('Y-m-d H:i:s', strtotime('-1 days', strtotime($dt_inicio)));
    $dt_fim = date('Y-m-d H:i:s', strtotime($_POST['campoData1']));
  }

  $caixa = $_POST["caixa"];
  $ano = $_POST["ano"];

  $query_saldo = mysql_query("SELECT C.VL_SALDO
                                FROM caixas_saldos C
                               WHERE C.ID_CAIXA = $caixa
                                 AND C.PER_ANO = $ano");
  $registro = mysql_fetch_array($query_saldo);
  $saldo = $registro['VL_SALDO'];
  $primeiro_dia = $ano.".01.01";

  $creditos = 0.00;
  $debitos = 0.00;

  $query_d = mysql_query("SELECT   B.BAI_VALOR
                            FROM   baixas B
                           WHERE ((B.BAI_DATA >= '$primeiro_dia') OR ('$primeiro_dia' = ''))
                             AND ((B.BAI_DATA <= '$data_ini')  OR ('$data_ini' = ''))
                             AND   B.ID_CAIXA  = $caixa
                             AND   B.ST_BAIXA  = 1
                             AND   B.TP_BAIXA IN (1,3)
                        ORDER BY   B.BAI_DATA
                             ASC");

  while ($row = mysql_fetch_array($query_d))
  {
    $debitos = $debitos + $row['BAI_VALOR'];
  }

  $query_c = mysql_query("SELECT   B.BAI_VALOR
                            FROM   baixas B
                           WHERE ((B.BAI_DATA >= '$primeiro_dia') OR ('$primeiro_dia' = ''))
                             AND ((B.BAI_DATA <= '$data_ini') OR ('$data_ini' = ''))
                             AND   B.ID_CAIXA  = $caixa
                             AND   B.ST_BAIXA  = 1
                             AND   B.TP_BAIXA IN (0,2,4)
                        ORDER BY   B.BAI_DATA
                             ASC");

  while ($row = mysql_fetch_array($query_c))
  {
    $creditos = $creditos + $row['BAI_VALOR'];
  }

  $saldo = number_format(floatval(($saldo + $creditos) - $debitos), 2, '.', '');

  $query = mysql_query("SELECT    B.ID_BAIXA
                              ,   B.BAI_DATA
                              ,   B.BAI_DESCRICAO
                              ,   B.TP_BAIXA
                              ,   CASE WHEN (B.TP_BAIXA = 1 OR B.TP_BAIXA = 3) THEN -B.BAI_VALOR ELSE B.BAI_VALOR END AS BAI_VALOR
                           FROM   baixas B
                          WHERE ((B.BAI_DATA >= '$dt_inicio') OR ('$dt_inicio' = ''))
                            AND ((B.BAI_DATA <= '$dt_fim')    OR ('$dt_fim' = ''))
                            AND   B.ID_CAIXA  = $caixa
                            AND   B.ST_BAIXA  = 1
                       ORDER BY   B.BAI_DATA
                            ASC");

  while ($row = mysql_fetch_array($query))
  {
    #$id_baixa = $row['ID_BAIXA'];
    $data = date('d-m-Y', strtotime($row['BAI_DATA']));
    $documento = $row['BAI_DESCRICAO'];
    switch ($row['TP_BAIXA'])
    {
      case 0:
        $tipo = "Receita";
        break;
      case 1:
        $tipo = "Despesa";
        break;
      case 2:
        $tipo = "Contrato";
        break;
      default:
        $tipo = "Lançamento";
        break;
    }
    $valor = $row['BAI_VALOR'];
    $saldo = number_format(floatval($saldo + $valor), 2, '.', '');
  }
  $saldo = number_format(floatval($saldo), 2, ',', '.');
  $dt_fim = date('d/m/Y', strtotime($dt_fim));
  echo ("Saldo em $dt_fim: <b>R$ $saldo</b>");

mysql_close($conecta);
?>