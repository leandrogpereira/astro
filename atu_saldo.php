<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_GET["id"] == null)
			{
			echo "
			    <div class='container theme-showcase' role='main'>
			      <div class='panel panel-danger'> 
			        <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
			        <div class='panel-body'> <p align='center'>Área restrita.</p>
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
				if ($_SESSION["st_periodo"] == 0)
	  			{
	  				echo "
						<div class='container theme-showcase' role='main'>
							<div class='panel panel-danger'> 
								<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
								<div class='panel-body'> <p align='center'>Período selecionado não é permitido fazer alterações.</p><br><br><a href='ger_saldo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
							</div>
						</div>
						";
	  			}
	  			else
	  			{
					
					$id = $_GET["id"];
					$verifica = mysql_query("SELECT COUNT(ID_CAIXA_SALDO) AS CONT FROM caixas_saldos WHERE ID_CAIXA = $id AND PER_ANO = ".$_SESSION["ano"]."");
					$linha = mysql_fetch_array($verifica);
					if ($linha["CONT"] == 0)
					{
						$ano_anterior = $_SESSION["ano"] - 1;
						$query_saldo = mysql_query("SELECT C.VL_SALDO
													  FROM caixas_saldos C
													 WHERE C.ID_CAIXA = $id
													   AND C.PER_ANO  = $ano_anterior");

						$registro = mysql_fetch_array($query_saldo);
						$saldo = $registro['VL_SALDO'];

						$creditos = 0.00;
						$debitos  = 0.00;

						$dt_inicio = "01-01-".$ano_anterior;
						$dt_inicio = date('Y.m.d', strtotime($dt_inicio));
						$dt_final = "31-12-".$ano_anterior;
						$dt_final = date('Y.m.d', strtotime($dt_final));

						$query_d = mysql_query("SELECT   B.BAI_VALOR
						                          FROM   baixas B
						                         WHERE ((B.BAI_DATA >= '$dt_inicio') OR ('$dt_inicio' = ''))
						                           AND ((B.BAI_DATA <= '$dt_final')  OR ('$dt_final' = ''))
						                           AND   B.ID_CAIXA  = $id
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
						                         WHERE ((B.BAI_DATA >= '$dt_inicio') OR ('$dt_inicio' = ''))
						                           AND ((B.BAI_DATA <= '$dt_final') OR ('$dt_final' = ''))
						                           AND   B.ID_CAIXA  = $id
						                           AND   B.ST_BAIXA  = 1
						                           AND   B.TP_BAIXA IN (0,2,4)
						                      ORDER BY   B.BAI_DATA
						                           ASC");

						while ($row = mysql_fetch_array($query_c))
						{
							$creditos = $creditos + $row['BAI_VALOR'];
						}
						
						$saldo = number_format(floatval(($saldo + $creditos) - $debitos), 2, '.', '');
						
						$insert = mysql_query("INSERT INTO caixas_saldos VALUES (null, $id, $saldo, ".$_SESSION["ano"].");");
						
						if(mysql_affected_rows()>0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Saldo cadastrado com sucesso!<br><br><a href='ger_saldo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
									</div>
								</div>
							";
							mysql_close($conecta);
						}
						else
						{
							$erro = mysql_error();
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-danger'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='ger_saldo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
									</div>
								</div>
							";
						}
					}
					else
					{
						$ano_anterior = $_SESSION["ano"] - 1;
						$query_saldo = mysql_query("SELECT C.VL_SALDO
													  FROM caixas_saldos C
													 WHERE C.ID_CAIXA = $id
													   AND C.PER_ANO  = $ano_anterior");

						$registro = mysql_fetch_array($query_saldo);
						$saldo = $registro['VL_SALDO'];

						$creditos = 0.00;
						$debitos  = 0.00;

						$dt_inicio = "01-01-".$ano_anterior;
						$dt_inicio = date('Y.m.d', strtotime($dt_inicio));
						$dt_final = "31-12-".$ano_anterior;
						$dt_final = date('Y.m.d', strtotime($dt_final));

						$query_d = mysql_query("SELECT   B.BAI_VALOR
						                          FROM   baixas B
						                         WHERE ((B.BAI_DATA >= '$dt_inicio') OR ('$dt_inicio' = ''))
						                           AND ((B.BAI_DATA <= '$dt_final')  OR ('$dt_final' = ''))
						                           AND   B.ID_CAIXA  = $id
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
						                         WHERE ((B.BAI_DATA >= '$dt_inicio') OR ('$dt_inicio' = ''))
						                           AND ((B.BAI_DATA <= '$dt_final') OR ('$dt_final' = ''))
						                           AND   B.ID_CAIXA  = $id
						                           AND   B.ST_BAIXA  = 1
						                           AND   B.TP_BAIXA IN (0,2,4)
						                      ORDER BY   B.BAI_DATA
						                           ASC");

						while ($row = mysql_fetch_array($query_c))
						{
							$creditos = $creditos + $row['BAI_VALOR'];
						}
						
						$saldo = number_format(floatval(($saldo + $creditos) - $debitos), 2, '.', '');
						
						$update = mysql_query("UPDATE caixas_saldos C
											 	  SET C.VL_SALDO = $saldo
											 	WHERE C.ID_CAIXA = $id
											 	  AND C.PER_ANO  = ".$_SESSION["ano"].";");
						
						if(mysql_affected_rows()>=0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Saldo atualizado com sucesso!<br><br><a href='ger_saldo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
									</div>
								</div>
							";
							mysql_close($conecta);
						}
						else
						{
							$erro = mysql_error();
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-danger'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='ger_saldo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
									</div>
								</div>
							";
						}
					}
				}
			}
			?>

	</div>		
	<div class="rodape">
		<?php include_once('footer.php'); ?>
	</div>
            
</div>