<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php

			if(!isset($_POST["enviar"]))
			{
	    		include_once('conexao.php');

		        $id_funcionario=$_SESSION["id_usuario"];

		        $query = mysql_query("SELECT 
		        					  	F.ID_FUNCIONARIO,
		        					  	F.FUN_NOME,
		        					  	F.FUN_SOBRENOME,
		        					  	F.FUN_CPF,
		        					  	F.FUN_CNH,
		        					  	F.FUN_ENDERECO,
		        					  	F.FUN_NUMERO,
		        					  	F.FUN_BAIRRO,
		        					  	F.FUN_CIDADE,
		        					  	F.FUN_UF,
		        					  	F.FUN_CEP,
		        					  	F.FUN_FONE1,
		        					  	F.FUN_FONE2,
		        					  	F.FUN_EMAIL,
		        					  	F.FUN_STATUS,
		        					  	F.FUN_ACESSO,
		        					  	C.CAR_NOME
		        					  	FROM funcionarios F 
		        					  	INNER JOIN cargos C ON C.ID_CARGO = F.ID_CARGO
		        					  		WHERE ID_FUNCIONARIO = $id_funcionario");

		        while ($row = mysql_fetch_array($query))
		        {
					$id_funcionario = $row['ID_FUNCIONARIO'];
					$nome 			= $row['FUN_NOME'];
					$sobrenome  	= $row['FUN_SOBRENOME'];
					$cpf 			= $row['FUN_CPF'];
					$cnh 			= $row['FUN_CNH'];
					$endereco 		= $row['FUN_ENDERECO'];
					$numero 		= $row['FUN_NUMERO'];
					$bairro 		= $row['FUN_BAIRRO'];
					$cidade 		= $row['FUN_CIDADE'];
					$estado 		= $row['FUN_UF'];
					$cep 			= $row['FUN_CEP'];
					$fone1 			= $row['FUN_FONE1'];
					$fone2 			= $row['FUN_FONE2'];
					$email 			= $row['FUN_EMAIL'];
					$status 		= $row['FUN_STATUS'];
					$acesso 		= $row['FUN_ACESSO'];
					$cargo 			= $row['CAR_NOME'];
	        	}
		?>

		<div class="container theme-showcase" role="main">
			<div class="panel panel-primary">
				<div class="panel-heading">
				<h3 class="panel-title">PARA ATUALIZAR SEU CADASTRO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
				</div>
				<div class="panel-body">

					<form method="POST" action="atu_cadastro.php">

						<input type="hidden" name="id_funcionario" value=<?php echo (" '$id_funcionario'"); ?>>

						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Nome:<br>
								<input type="text" placeholder="Ex: José" class="form-control" name="nome" maxlength="80" required value=<?php echo (" '$nome'"); ?>>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Sobrenome:<br>
								<input type="text" placeholder="Ex: Silva dos Santos" class="form-control" name="sobrenome" maxlength="80" required value=<?php echo (" '$sobrenome'"); ?>>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>CPF:<br>
								<input type="text" id="campoCPF" class="form-control" placeholder="Ex: 40089032190" name="cpf" maxlength="11" onkeypress='return SomenteNumero(event)' required value=<?php echo (" '$cpf'"); ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>CNH:<br>
								<input type="text" class="form-control" placeholder="Ex: 12389032190" name="cnh" maxlength="11" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$cnh'"); ?>>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Endereço:<br>
								<input type="text" placeholder="Rua das Orquídeas" class="form-control" name="endereco" maxlength="80" value=<?php echo (" '$endereco'"); ?>>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Número:<br>
								<input type="text" placeholder="315" class="form-control" name="numero" maxlength="6" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$numero'"); ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Bairro:<br>
								<input type="text" placeholder="Jardim das Flores" class="form-control" name="bairro" maxlength="45" value=<?php echo (" '$bairro'"); ?>>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>CEP:<br>
								<input type="text" id="campoCEP" placeholder="12400000" class="form-control" name="cep" maxlength="8" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$cep'"); ?>>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Estado: <span id="aviso">(Selecione o estado para visualizar as cidades)</span><br>
								<select id="estado" class="form-control" name="estado" value=<?php echo (" '$estado'"); ?>></select>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Cidade:<br>
								<select id="cidade" class="form-control" name="cidade" value=<?php echo (" '$cidade'"); ?>></select>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Telefone 1:<br>
								<input type="text" id="campoTelefone" placeholder="12992134049" class="form-control" name="fone1" maxlength="15" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$fone1'"); ?>>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Telefone 2:<br>
								<input type="text" id="campoTelefone1" placeholder="1235221122" class="form-control" name="fone2" maxlength="15" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$fone2'"); ?>>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<br>E-mail:<br>
								<input type="text" placeholder="seunome@astro.com" class="form-control" name="email" maxlength="80" value=<?php echo (" '$email'"); if ($_SESSION["acesso"] != 3) {	echo "readonly"; } ?>>
							</div>


							<?php  
							if ($_SESSION["acesso"] == 3) {
								echo '
									<div class="col-xs-12 col-sm-6 col-md-4">
										<br>Cargo:<br>
										<select class="form-control" name="cargo" maxlength="11" value=$cargo>
								';
								$query = mysql_query("SELECT * FROM cargos WHERE CAR_STATUS = 1");

								while ($row = mysql_fetch_array($query)){
								$id_cargo = $row['ID_CARGO'];
								$cargo = $row['CAR_NOME'];

								echo("             
											<option value='$id_cargo'>$cargo</option>
									");
								}

								mysql_close($conecta);

								echo '
										</select>
									</div>
								';
							}
							
							?>
						</div>
				      	<?php
				      	if ($_SESSION["acesso"] == 3) {
					      	echo '
				      	<div class="row">

				      		<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Ativo:<br>
								<label class="radio-inline">
						  			<input type="radio" name="status" value="1"'; if($status == 1){ echo ("checked");} echo '> Sim
						  		</label>
								<label class="radio-inline">
									<input type="radio" name="status" value="0" '; if($status == 0){ echo ("checked");} echo '> Não
								</label>
					      	</div>
					    	
					    	<div class="col-xs-12 col-sm-6 col-md-4">
								<br>Acesso:<br>
								<select class="form-control" name="acesso">
										<option value="0"'; if ($acesso == 0) { echo "selected";} echo '>Nenhum</option>
										<option value="1"'; if ($acesso == 1) { echo "selected";} echo '>Básico</option>
										<option value="2"'; if ($acesso == 2) { echo "selected";} echo '>Intermediário</option>
										<option value="3"'; if ($acesso == 3) { echo "selected";} echo '>Avançado</option>
								</select>
							</div>
						</div>';
					    }
					    ?>

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

					$id_funcionario = $_POST["id_funcionario"];
					$nome       	= $_POST["nome"];
					$sobrenome     	= $_POST["sobrenome"];
					$cpf        	= str_replace(array(".","/","-"),"",$_POST["cpf"]);
					$cnh        	= $_POST["cnh"];
					$endereco   	= $_POST["endereco"];
					$numero     	= $_POST["numero"];
					$bairro     	= $_POST["bairro"];
					$cep        	= str_replace(array(".","/","-"),"",$_POST["cep"]);
					$estado     	= $_POST["estado"];
					$cidade     	= $_POST["cidade"];
					$fone1      	= $_POST["fone1"];
					$fone2      	= $_POST["fone2"];
					$email      	= $_POST["email"];
					$status 		= $_POST["status"];
					if ($_SESSION["acesso"] != 3 )
					{
						$res = mysql_query("UPDATE 
											funcionarios
											SET
												FUN_NOME = '$nome',
												FUN_SOBRENOME = '$sobrenome',
												FUN_CPF = '$cpf',
												FUN_CNH = '$cnh',
												FUN_ENDERECO = '$endereco',
												FUN_NUMERO = '$numero',
												FUN_BAIRRO = '$bairro',
												FUN_CIDADE = '$cidade',
												FUN_UF = '$estado',
												FUN_CEP = '$cep',
												FUN_FONE1 = '$fone1',
												FUN_FONE2 = '$fone2'
												WHERE 
													ID_FUNCIONARIO = '$id_funcionario';");
					}
					else
					{
						$cargo = $_POST["cargo"];
						$res = mysql_query("UPDATE 
												funcionarios
												SET
													FUN_NOME = '$nome',
													FUN_SOBRENOME = '$sobrenome',
													FUN_CPF = '$cpf',
													FUN_CNH = '$cnh',
													FUN_ENDERECO = '$endereco',
													FUN_NUMERO = '$numero',
													FUN_BAIRRO = '$bairro',
													FUN_CIDADE = '$cidade',
													FUN_UF = '$estado',
													FUN_CEP = '$cep',
													FUN_FONE1 = '$fone1',
													FUN_FONE2 = '$fone2',
													FUN_EMAIL = '$email',
													FUN_STATUS = '$status',
													ID_CARGO = '$cargo'
													WHERE 
														ID_FUNCIONARIO = '$id_funcionario';"); 
					}
					if(mysql_affected_rows()>0)
					{
						echo "
							<div class='container theme-showcase' role='main'>
								<div class='panel panel-success'> 
									<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
									<div class='panel-body'> Funcionário atualizado com sucesso!<br> Você será encaminhado a tela de login.<br><a href='ger_funcionario.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
								</div>
							</div>
						";
						mysql_close($conecta);
						session_destroy();
					}
					else
					{
						$erro = mysql_error();						
						if ($erro == '')
						{
							echo "
							<div class='container theme-showcase' role='main'>
								<div class='panel panel-success'> 
									<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
									<div class='panel-body'> Cadastro atualizado com sucesso!<br> Você será encaminhado a tela de login.<br><a href='ger_funcionario.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
								</div>
							</div>
						";
						mysql_close($conecta);
						session_destroy();
						}
						else
						{
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

	<script language="JavaScript" type="text/javascript" charset="utf-8">
      new dgCidadesEstados({
        cidade: document.getElementById('cidade'),
        estado: document.getElementById('estado')
      })
	</script>

	<!-- Máscara para datas, telefones e senhas -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
       $("#campoTelefone").mask("(99) 9999-9999");
       $("#campoCPF").mask("999.999.999-99");
     });

      jQuery(function($){
     $("#campoData1").mask("99-99-9999");
     $("#campoTelefone1").mask("(99) 99999-9999");
     $("#campoCEP").mask("99.999-999");
    });

      function SomenteNumero(e){
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
          if (tecla==8 || tecla==0) return true;
          else  return false;
        }
      }
    </script>
            
</div>