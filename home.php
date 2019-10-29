<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">
<div class="topo">
<?php 
include_once('header.php'); 
include_once('conexao.php');
?>
</div>

<div class="conteudo">
	<style>
		body {
			height:100%;
			width:100%;
			background: url(img/background.png) no-repeat center center;
		}
	</style>
	<div class="container"> <!-- Inicio Container -->



	<div class="row"> <!-- Inicio ROW -->

		<div class="col-md-6"> <!--INICIO CONTAGEM DE CONTRATOS -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title"> Contratos Ativos:</h2>
				<Font Size=1.5><b>Definição: </b> Trata-se da quantidade de contratos ativos na data atual, podendo ser do tipo Fixado ou Quantitativo.</font>
			</div>
			<div class="panel-body">
				<div class="table-condenssed">  
				

			<?php 
			$sql_contratos  = mysql_query("SELECT COUNT(A.ID_TP_CONTRATO) AS QUANTIDADE, A.ID_TP_CONTRATO, 
											CASE A.ID_TP_CONTRATO 
											WHEN '1' THEN 'Fixado' 
											ELSE 'Quantitativo' 
											END AS DESCRICAO,
											CASE A.ID_TP_CONTRATO 
											WHEN '1' THEN 'progress-bar-warning' 
											ELSE 'progress-bar-primary' 
											END AS COR,
											(COUNT(A.ID_TP_CONTRATO) / (SELECT COUNT(*) AS QUANTIDADE FROM CONTRATOS A LEFT JOIN ADITIVOS B ON A.ID_CONTRATO = B.ID_CONTRATO WHERE A.CON_DT_INICIO <= NOW() AND A.CON_DT_FIM >= NOW()))*100 AS PERCENTUAL
											FROM CONTRATOS A LEFT JOIN ADITIVOS B ON A.ID_CONTRATO = B.ID_CONTRATO
											WHERE A.CON_DT_INICIO <= NOW() AND A.CON_DT_FIM >= NOW()
                                        	GROUP BY A.ID_TP_CONTRATO");   

      		while ($row = mysql_fetch_array($sql_contratos)){  
  				$quantidade = $row['QUANTIDADE'];
  				$descricao = $row['DESCRICAO'];
  				$cor = $row['COR'];
  				$percentual = $row['PERCENTUAL'];

			echo ("<div class='text-xs-center' id='example-caption-6'>$descricao: </div>
					<div class='progress'>
					<div class='progress-bar $cor progress-bar-striped active' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='$percentual' style='width: 0%'>
						$quantidade
					</div>
					</div>");
			}
			?>

			<span class="label label-warning">Fixado</span>
			<span class="label label-primary">Quantitativo</span>						
				</div>
			</div>
		</div> 
        </div> <!--FIM CONTAGEM DE CONTRATOS -->
		

		
		<div class="col-md-6"> <!--INICIO INDICADOR DE DESPESAS NOS ULTIMOS MESES -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title"> Despesas nos Últimos Meses:</h2>
				<Font Size=1.5><b>Definição: </b> Trata-se de um gráfico exibindo o total de despesas nos últimos 3 meses, a partir do mês atual.</font>
			</div>
			<div class="panel-body">
				<div class="table-condenssed">  
				




			<?php 

			$sql_max = mysql_query("SELECT MAX(A.VALOR_MAX) AS TOTAL FROM (SELECT 										SUM(B.BAI_VALOR) AS VALOR_MAX
											FROM BAIXAS B
											WHERE B.ID_DESPESA IS NOT NULL AND B.ST_BAIXA = '1'
											GROUP BY EXTRACT(YEAR_MONTH FROM B.BAI_DATA)
											ORDER BY 1 DESC
											LIMIT 3) A");

			while ($row = mysql_fetch_array($sql_max)){  
			$maximo = $row['TOTAL'];

			$sql_despesas  = mysql_query("SELECT EXTRACT(YEAR_MONTH FROM B.BAI_DATA) AS PERIODO, 
											SUM(B.BAI_VALOR) AS VALOR
											FROM BAIXAS B
											WHERE B.ID_DESPESA IS NOT NULL AND B.ST_BAIXA = '1'
											GROUP BY EXTRACT(YEAR_MONTH FROM B.BAI_DATA)
											ORDER BY 1 DESC
											LIMIT 3");   
			$cont = 1;
      			while ($row = mysql_fetch_array($sql_despesas)){  
  					$periodo = $row['PERIODO'];
  					$valor = $row['VALOR'];
  					$percentual = (($valor / $maximo) * 100);

  					switch ($cont) {
                          case 1:
                            $cores = "progress-bar-danger";
                            break;
                          case 2:
                            $cores = "progress-bar-success";
                            break;
                          case 3:
                            $cores = "progress-bar-warning";
                            break;
                          default:
                            $cores = "";
                            break;
                    }


			echo ("<div class='text-xs-center' id='example-caption-6'>Período - $periodo: </div>
					<div class='progress'>
					<div class='progress-bar $cores progress-bar-striped active' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='$percentual' style='width: 0%'>
						$valor
					</div>
					</div>");
				$cont++;
				}
			}

			$contador = 1;
			$sql_periodos  = mysql_query("SELECT EXTRACT(YEAR_MONTH FROM B.BAI_DATA) AS PERIODO
											FROM BAIXAS B
											WHERE B.ID_DESPESA IS NOT NULL AND B.ST_BAIXA = '1'
											GROUP BY EXTRACT(YEAR_MONTH FROM B.BAI_DATA)
											ORDER BY 1 DESC
											LIMIT 3");   

      		while ($row = mysql_fetch_array($sql_periodos)){  
  				$periodo = $row['PERIODO'];

  				switch ($contador) {
                          case 1:
                            $cores = "class='label label-danger'";
                            break;
                          case 2:
                            $cores = "class='label label-success'";
                            break;
                          case 3:
                            $cores = "class='label label-warning'";
                            break;
                          default:
                            $cores = "";
                            break;
                          }

			echo ("<span $cores>$periodo</span> &nbsp; ");
			$contador++;
			}

			?>			
				</div>
			</div>
		</div> 
        </div> <!--FIM INDICADOR DE DESPESAS NOS ULTIMOS MESES -->
		
	</div> <!-- Fim ROW -->




	<div class="row"> <!-- Inicio ROW -->
		<?php 
			include_once "conexao.php";
			$data_padrao = date('Y-m-d H:i:s', strtotime($data_padrao));
			$query_baixas = mysql_query("SELECT COUNT(B.ID_BAIXA) AS QTD FROM baixas B WHERE B.ST_BAIXA = 0");
			$registros = mysql_fetch_array($query_baixas);
		    $qtd_baixas = $registros['QTD'];

			$query = mysql_query("SELECT * FROM informativos I WHERE I.ST_INFORMATIVO = 1 AND I.DT_VENCIMENTO >= '$data_padrao'");

			while ($row = mysql_fetch_array($query))
			{
				$titulo = $row['INF_TITULO'];
				$corpo = $row['INF_CORPO'];
				$link = $row['INF_LINK'];
				switch ($row['TP_INFORMATIVO']) {
				 	case 0:
				 		$tipo = "info";
				 		break;
				 	case 1:
				 		$tipo = "success";
				 		break;
				 	case 2:
				 		$tipo = "warning";
				 		break;
				 	default:
				 		$tipo = "danger";
				 		break;
			 } 

				echo("             
				  <div class='col-md-3'>
					<div class='alert alert-$tipo alert-dismissible fade in' role='alert'>
				      <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
				      <h4>$titulo</h4>
				      <p>".nl2br($corpo)."</p>
			      ");
				if ($link == '')
				{
					echo ('
					</div>
				  </div>
					');
				}
				else
				{
					echo ("
					<p align='center'>
						<a class='btn btn-$tipo ' href='$link' role='button'>Verificar</button></a>
					</p>
				    </div>
			    </div>
					");	
				}
			}
		?>

	    <div class="col-md-3">
		    <div class="alert alert-success alert-dismissible fade in" role="alert">
		      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		      <h4>Baixas disponíveis: <span class="badge"><?=$qtd_baixas?></span></h4>
		      <p>Confira seu extrato bancário e confirma as baixas pendentes.</p>
		      <p align="center">
		      	<a class='btn btn-success' href='cad_baixa.php' role='button'>Verificar</button></a>
		      </p>
		    </div>
	    </div>

	    <div class="col-md-3">
		    <div class="alert alert-info alert-dismissible fade in" role="alert">
		      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		      <h4>Aniversariante(s) do Mês:</h4>
				<?php 
			      	$mes = date('m', strtotime($data_padrao));
			      	$x = 0;
				    $query_aniversario = mysql_query("SELECT F.FUN_NOME, F.FUN_SOBRENOME, F.FUN_DTNASC  FROM funcionarios F WHERE MONTH(F.FUN_DTNASC) = $mes AND F.FUN_STATUS = 1");
				    while ($aniv = mysql_fetch_array($query_aniversario))
					{
						$nome = $aniv['FUN_NOME'];
						$sobrenome = $aniv['FUN_SOBRENOME'];
						$data = date('d/m', strtotime($aniv['FUN_DTNASC']));
						echo "<p>$nome $sobrenome - $data</p>";
						$x = $x + 1;
					}
					if ($x == 0) {
						echo "<p>Sem informação.</p>";
					}
		       ?>
		      <p align="center">
		      	<a class='btn btn-info' href='ger_funcionario.php' role='button'>Verificar</button></a>
		      </p>
		    </div>
	    </div>

	    <div class="col-md-3">
		    <div class="alert alert-danger alert-dismissible fade in" role="alert">
		      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		      <h4>Contrato(s) encerrando no mês:</h4>
				<?php 
					$ano = date('Y', strtotime($data_padrao));
					$x = 0;
				    $query_contrato = mysql_query("	 SELECT C.NR_CONTRATO
				    									  , P.PES_NOME
													   FROM contratos C
					                              LEFT JOIN aditivos A ON A.ID_CONTRATO = C.ID_CONTRATO
					                              LEFT JOIN pessoas  P ON P.ID_PESSOA = C.ID_PESSOA
													  WHERE C.CON_STATUS    = 1
													    AND ((MONTH(C.CON_DT_FIM) = $mes) OR (MONTH(A.DT_TERMINO) = $mes))
					                                    AND ((YEAR(C.CON_DT_FIM) = $ano) OR (YEAR(A.DT_TERMINO) = $ano))");
				    while ($cont = mysql_fetch_array($query_contrato))
					{
						$nr_contrato = $cont['NR_CONTRATO'];
						$cliente = $cont['PES_NOME'];
						echo "<p>$nr_contrato - $cliente</p>";
						$x = $x + 1;
					}
					if ($x == 0)
					{
						echo "<p align='center'>Sem informações.</p>";
					}
					else
					{
						echo "<p>Verifique os aditivos.</p>";
					}
		       ?>
		      <p align="center">
		      	<a class='btn btn-danger' href='ger_contrato.php' role='button'>Verificar</button></a>
		      </p>
		    </div>
	    </div>
	  	
	</div> <!-- Fim ROW -->



	</div> <!-- Fim Container -->

</div>
<div class="rodape">
<?php include_once('footer.php'); ?>
</div>

<!-- INICIO PROGRESS BAR -->
  <script type="text/javascript">
  

$('.progress-bar').each(function() {
    var $bar = $(this);
    var progress = setInterval(function() {

      var currWidth = parseInt($bar.attr('aria-valuenow'));
      var maxWidth = parseInt($bar.attr('aria-valuemax'));

	
      //update the progress
        $bar.width(currWidth+'%');
        $bar.attr('aria-valuenow',currWidth+1);

      //clear timer when max is reach
      if (currWidth >= maxWidth){
        clearInterval(progress);
      }

    }, 0);
});
  </script>
<!-- FIM PROGRESS BAR -->
            
</div>