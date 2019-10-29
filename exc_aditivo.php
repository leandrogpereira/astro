<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

			<?php

					include_once('conexao.php');

					$aditivo = $_GET["aditivo"];
					$dt_inicial = $_GET["dt_inicial"];
					$dt_final = $_GET["dt_final"];
					$id_contrato = $_GET["id_contrato"];

					$verifica = mysql_query("
									 SELECT T.ID_TRANSPORTE 
									   FROM transportes T
							    	  WHERE T.TRA_DATA BETWEEN '$dt_inicial' AND '$dt_final'
										AND T.ID_CONTRATO = $id_contrato"
											);

					if(mysql_affected_rows() == 0)
					{

						$res = mysql_query("DELETE
												FROM
													aditivos
												WHERE 
													ID_ADITIVO = $aditivo;");

						if(mysql_affected_rows()>0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Aditivo removido com sucesso!<br><br><a href='ger_contrato.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
										<div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='ger_contrato.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
									</div>
								</div>
							";
						}
					}
					else
					{
						echo "
							<div class='container theme-showcase' role='main'>
								<div class='panel panel-danger'> 
									<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
									<div class='panel-body'> <p align='center'>Erro: O aditivo selecionado possui transporte cadastrado durante seu período de vigência.</p><br><br><a href='ger_contrato.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
								</div>
							</div>
							";
					}

			?>

	</div>

	<div class="rodape">
		<?php include_once('footer.php'); ?>
	</div>
            
</div>