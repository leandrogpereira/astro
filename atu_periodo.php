<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_POST["ano"] == null || $_POST["mes"] == null)
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
		    		$ano = $_POST["ano"];
			        $mes = $_POST["mes"];
			?>

			<div class="container theme-showcase" role="main">
				<div class="panel panel-primary">
				    <div class="panel-heading">
				      <h3 class="panel-title">PARA ALTERAR UM PERÍODO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
				    </div>
				    <div class="panel-body">

						<form method="POST" action="atu_periodo.php">
			  
							<div class="row">

						      	<div class="col-xs-6 col-md-4">
							     	<br>Ano:<br>
							        <input type="text" class="form-control" placeholder="Ex: 2016" name="ano" maxlength="4" readonly value=<?php echo (" '$ano'"); ?>>
						      	</div>

								<div class="col-xs-6 col-md-4">
									<br>Mês:<br>
									<input type="text" class="form-control" name="mes" maxlength="2" readonly value=<?php echo (" '$mes'"); ?>>
							    </div>

								<div class="col-xs-6 col-md-4">
								  <br>Situação:<br>
								  <select class="form-control" name="status">
								  	<option value="0">Encerrar</option>
								  	<option value="1">Abrir</option>
								  </select>
								</div>

						  	</div>

						 	<br><br><br>
							<button type="submit" class="btn btn-primary btn-lg" name="enviar" id="enviar"> Gravar</button>
							<a href='javascript:history.go(-1);'><button type='button' class='btn btn-info btn-lg'> Voltar</button></a>

						</form>

						

					</div>
				</div>      
			</div>


				<?php

					} 
					else
					{
						include_once('conexao.php');

						$ano = $_POST["ano"];
			        	$mes = $_POST["mes"];
			        	$status = $_POST["status"];

						$res = mysql_query("
											UPDATE periodos
											   SET ST_PERIODO = $status
											 WHERE PER_ANO = $ano
											   AND PER_MES = $mes
										;"); 
	   
						if(mysql_affected_rows()>=0)
						{
							include_once("funcao.php");
							atualizaPeriodo();
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Período atualizado com sucesso!<br><br><a href='ger_periodo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
										<div class='panel-body'> <p align='center'>Erro: $erro</p><br><br><a href='ger_periodo.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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