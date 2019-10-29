<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["id_usuario"] == null)
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
				if(!isset($_POST["enviar"]))
				{
			?>

			<div class="container theme-showcase" role="main">
				<div class="panel panel-primary">
					<div class="panel-heading">
					<h3 class="panel-title">PARA ATUALIZAR SUA SENHA, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
					</div>
					<div class="panel-body">

						<form method="POST" action="atu_senha.php">

							<div class="row">
								<div class="col-xs-12 col-md-4">
									<br>Senha:<br>
									<input type="password" placeholder="*******" class="form-control" name="senha" maxlength="10" required="">
								</div>

								<div class="col-xs-12 col-md-4">
									<br>Nova Senha:<br>
									<input type="password" placeholder="*******" class="form-control" name="nova_senha1" maxlength="10" required="">
								</div>

								<div class="col-xs-12 col-md-4">
									<br>Repita nova senha:<br>
									<input type="password" placeholder="*******" class="form-control" name="nova_senha2" maxlength="10" required="">
						      	</div>
					      	</div>

							<br><br><br>
							<button type="submit" class="btn btn-primary btn-lg" name="enviar"> Gravar</button>
							<a href='home.php'><button type='button' class='btn btn-info btn-lg'> Voltar</button></a>
						</form>

						<br>

					</div>
				</div>      
			</div>


				<?php

					} 
					else
					{

						include_once('conexao.php');

						$id_funcionario = $_SESSION["id_usuario"];
						$senha      	= md5($_POST["senha"]);

						$verifica = mysql_query("
						SELECT FUN_SENHA
						  FROM funcionarios
						 WHERE ID_FUNCIONARIO = $id_funcionario
						");
						$row = mysql_fetch_array($verifica);

						if(!strcmp($senha, $row["FUN_SENHA"])) 
						{
							$nova_senha1  	= md5($_POST["nova_senha1"]);
							$nova_senha2   	= md5($_POST["nova_senha2"]);
							if (!strcmp($nova_senha1, $nova_senha2))
							{
								$res = mysql_query("UPDATE 
													funcionarios
													SET
														FUN_SENHA = '$nova_senha1'
														WHERE 
															ID_FUNCIONARIO = '$id_funcionario';"); 
								if(mysql_affected_rows()>=0)
								{
									echo "
										<div class='container theme-showcase' role='main'>
											<div class='panel panel-success'> 
												<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
												<div class='panel-body'> Senha atualizada com sucesso!<br><br><a href='home.php'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
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
												<div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
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
											<div class='panel-body'> <p align='center'>Nova senha não confere, verifique os dados digitados e tente novamente.</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
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
											<div class='panel-body'> <p align='center'>Senhas inválida, verifique os dados digitados e tente novamente.</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a></div> 
										</div>
									</div>
								";
						}
					}
				}
			?>

	</div>

	<div class="rodape">
		<?php include_once('footer.php'); ?>
	</div>
</div>