<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_POST["id_cargo"] == null)
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
			        $id_cargo = $_POST["id_cargo"];

			        $query = mysql_query("SELECT *	FROM cargos WHERE ID_CARGO = $id_cargo");

			        while ($row = mysql_fetch_array($query))
			        {
						$id_cargo = $row['ID_CARGO'];
						$nome 	  = $row['CAR_NOME'];
		        	}
			?>

			<div class="container theme-showcase" role="main">
				<div class="panel panel-primary">
				    <div class="panel-heading">
				      <h3 class="panel-title">PARA ALTERAR UM CADASTRO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
				    </div>
				    <div class="panel-body">

				<form method="POST" action="atu_cargo.php">
					
					<input type="hidden" name="id_cargo" value=<?php echo (" '$id_cargo'"); ?>>

				      <div class="row">
				      <div class="col-xs-6 col-md-4">
				      <br>Descrição:<br>
				      <input type="text" placeholder="Ex: Motorista" class="form-control" name="nome" maxlength="80" required value=<?php echo (" '$nome'"); ?>>
				      </div>
				      </div>

				      	<br><br><br>
						<button type="submit" class="btn btn-primary btn-lg" name="enviar"> Gravar</button>
						<a href='javascript:history.go(-1);'><button type='button' class='btn btn-info btn-lg'> Voltar</button></a>
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

						$id_cargo = $_POST["id_cargo"];
						$nome  	  = $_POST["nome"];

						$res = mysql_query("UPDATE 
												cargos
												SET
													CAR_NOME = '$nome'
													WHERE 
														ID_CARGO = '$id_cargo';"); 

						if(mysql_affected_rows()>0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_cargo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
				}
			?>

	</div>

	<div class="rodape">
		<?php include_once('footer.php'); ?>
	</div>
            
</div>