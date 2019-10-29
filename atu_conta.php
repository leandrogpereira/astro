<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_POST["id"] == null)
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
			        $id = $_POST["id"];
			        $ano = $_SESSION["ano"];

			        $query = mysql_query("SELECT C.ID_CAIXA
			        						   , C.CAI_BANCO
			        						   , C.CAI_AGENCIA
			        						   , C.CAI_CONTA
			        						   , C.CAI_NOME
			        						   , C.CAI_STATUS
			        						   , S.VL_SALDO
			        						FROM caixa         C
			        				   LEFT JOIN caixas_saldos S ON S.ID_CAIXA = C.ID_CAIXA
			        					   WHERE C.ID_CAIXA = $id
			        					     AND S.PER_ANO  = $ano");

			        while ($row = mysql_fetch_array($query))
			        {
						$id = $row['ID_CAIXA'];
						$banco = $row['CAI_BANCO'];
	                    $agencia = $row['CAI_AGENCIA'];
	                    $conta = $row['CAI_CONTA'];
	                    $descricao = $row['CAI_NOME'];
	                    $status = $row['CAI_STATUS'];
	                    $saldo = $row['VL_SALDO'];
		        	}
			?>

			<div class="container theme-showcase" role="main">
				<div class="panel panel-primary">
				    <div class="panel-heading">
				      <h3 class="panel-title">PARA ALTERAR UM CADASTRO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
				    </div>
				    <div class="panel-body">

				<form method="POST" action="atu_conta.php">
					
					<div class="row">

		                <div class="col-xs-12 col-md-3">
		                  <br>Código:<br>
		                  <input type="text" placeholder="Ex: 01" class="form-control" name="id" value=<?=$id?> readonly="">
		                </div>

		                <div class="col-xs-12 col-md-3">
		                  <br>Banco:<br>
		                  <input type="text" placeholder="Ex: Banco do Brasil" class="form-control" name="banco" maxlength="80" readonly="" value=<?php echo (" '$banco'"); ?>>
		                </div>

		                <div class="col-xs-12 col-md-3">
		                  <br>Agência:<br>
		                  <input type="text" placeholder="Ex: 9999-9" class="form-control" name="agencia" maxlength="7" readonly="" value=<?php echo (" '$agencia'"); ?>>
		                </div>

		                <div class="col-xs-12 col-md-3">
		                  <br>Conta:<br>
		                  <input type="text" placeholder="Ex: 9999999-9" class="form-control" name="conta" maxlength="14" readonly="" value=<?php echo (" '$conta'"); ?>>
		                </div>
		            </div>

		            <div class="row">

		                <div class="col-xs-12 col-md-3">
		                  <br>Saldo inicial de <?php echo (" $ano"); ?>:<br>
		                  <input type="text" placeholder="Ex: 999,99" class="form-control" name="saldo" maxlength="14" readonly="" value=<?php echo (" '$saldo'"); ?>>
		                </div>

		                <div class="col-xs-12 col-md-3">
		                  <br>Descrição da conta:<br>
		                  <input type="text" placeholder="Ex: 9999999-9 Conta" class="form-control" name="descricao" maxlength="80" required="" value=<?php echo (" '$descricao'"); ?>>
		                </div>

		                <div class="col-xs-12 col-md-3">
						<br>Situação:<br>
						<label class="radio-inline">
				  			<input type="radio" name="status" value="1" <?php if($status == 1){ echo ("checked"); } ?>> Ativo
				  		</label>
						<label class="radio-inline">
							<input type="radio" name="status" value="0" <?php if($status == 0){ echo ("checked"); } ?>> Inativo
						</label>
				  	  </div>

	              	</div>

				      	<br><br><br>
						<button type="submit" class="btn btn-primary btn-lg" name="enviar"> Gravar</button>
						<a href='ger_conta.php'><button type='button' class='btn btn-info btn-lg'> Voltar</button></a>
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

						$id = $_POST["id"];
						$descricao = $_POST["descricao"];
						$status = $_POST["status"];

						$res = mysql_query("UPDATE caixa
											   SET CAI_NOME   = '$descricao'
											     , CAI_STATUS = '$status'
											 WHERE ID_CAIXA   = '$id';"); 

						if(mysql_affected_rows()>=0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_conta.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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