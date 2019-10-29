<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

			<?php

					include_once('conexao.php');

					$id_contrato = $_GET["id_contrato"];

					$verifica_registro = mysql_query("SELECT COUNT(DISTINCT(T.ID_TRANSPORTE)) AS AUX
														   , COUNT(DISTINCT(B.ID_BAIXA))      AS AUY 
														   , COUNT(DISTINCT(A.ID_ADITIVO))    AS AUZ
														FROM contratos C
												   LEFT JOIN transportes T ON T.ID_CONTRATO = C.ID_CONTRATO
												   LEFT JOIN baixas      B ON B.ID_CONTRATO = C.ID_CONTRATO 
												   LEFT JOIN aditivos    A ON A.ID_CONTRATO = C.ID_CONTRATO
													   WHERE C.ID_CONTRATO = $id_contrato");
						$reg = mysql_fetch_array($verifica_registro);
						$aux = $reg["AUX"] + $reg["AUY"] + $reg["AUZ"];
						if ($aux >= 1)
						{
							echo "
								  <div class='container theme-showcase' role='main'>
								    <div class='panel panel-danger'> 
								      <div class='panel-heading'><h3 class='panel-title text-left'>Aviso</h3></div> 
								      <div class='panel-body'> <p align='center'>Contratos que possuem aditivos, transportes ou recebimentos vinculados não podem ser removidos.<br><br><a class='btn btn-danger btn-sm' href='ger_contrato.php'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</a></p></div> 
								    </div>
								  </div>
								  ";
						}
						else
						{

						$res = mysql_query("DELETE
												FROM
													contratos
												WHERE 
													ID_CONTRATO = $id_contrato;");

						if(mysql_affected_rows()>0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Contrato removido com sucesso!<br><br><a href='ger_contrato.php'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
									</div>
								</div>
							";
							mysql_close($conecta);
						}
						else
						{
							$erro = mysql_error();
							echo var_dump($id_contrato)."
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-danger'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='ger_contrato.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
									</div>
								</div>
							";
						}
					}

			?>

	</div>

	<div class="rodape">
		<?php include_once('footer.php'); ?>
	</div>
            
</div>