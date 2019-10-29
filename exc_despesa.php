<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

			<?php

					include_once('conexao.php');
					if ($_SESSION["acesso"] <= 1 || $_GET["id_despesa"] == null)
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
						$id_despesa = $_GET["id_despesa"];

						$res = mysql_query("DELETE FROM
												baixas
												WHERE 
													ID_DESPESA = $id_despesa;");

						$res = mysql_query("DELETE FROM
												despesas
												WHERE 
													ID_DESPESA = $id_despesa;"); 

						if(mysql_affected_rows()>0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Despesa removida com sucesso!<br><br><a href='ger_despesa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
										<div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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