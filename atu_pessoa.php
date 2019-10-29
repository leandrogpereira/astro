<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_POST["id_pessoa"] == null)
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
			        $id_pessoa = $_POST["id_pessoa"];

			        $query = mysql_query("SELECT 
			        					  	P.ID_PESSOA,
			        					  	P.PES_TP_CADASTRO,
			        					  	P.PES_TP_PESSOA,
			        					  	P.PES_DOCUMENTO,
			        					  	P.PES_NOME,
			        					  	P.PES_ENDERECO,
			        					  	P.PES_NUMERO,
			        					  	P.PES_BAIRRO,
			        					  	P.PES_CIDADE,
			        					  	P.PES_UF,
			        					  	P.PES_CEP,
			        					  	P.PES_CONTATO,
			        					  	P.PES_FONE1,
			        					  	P.PES_FONE2,
			        					  	P.PES_EMAIL,
			        					  	P.PES_STATUS
			        					  	FROM pessoas P 
			        					  	WHERE id_pessoa = $id_pessoa");

			        while ($row = mysql_fetch_array($query))
			        {
						$id_pessoa   = $row['ID_PESSOA'];
						$tp_cadastro = $row['PES_TP_CADASTRO'];
						$tp_pessoa   = $row['PES_TP_PESSOA'];
						$documento   = $row['PES_DOCUMENTO'];
						$nome 		 = $row['PES_NOME'];
						$endereco 	 = $row['PES_ENDERECO'];
						$numero 	 = $row['PES_NUMERO'];
						$bairro 	 = $row['PES_BAIRRO'];
						$cidade 	 = $row['PES_CIDADE'];
						$estado 	 = $row['PES_UF'];
						$cep 		 = $row['PES_CEP'];
						$contato	 = $row['PES_CONTATO'];
						$fone1 		 = $row['PES_FONE1'];
						$fone2 		 = $row['PES_FONE2'];
						$email 		 = $row['PES_EMAIL'];
						$status 	 = $row['PES_STATUS'];
		        	}
			?>

			<div class="container theme-showcase" role="main">
				<div class="panel panel-primary">
				    <div class="panel-heading">
				      <h3 class="panel-title">PARA ALTERAR UM CADASTRO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
				    </div>
				    <div class="panel-body">

				<form method="POST" action="atu_pessoa.php">
					
					<input type="hidden" name="id_pessoa" value=<?php echo (" '$id_pessoa'"); ?>>
					<input type="hidden" name="tp_pessoa" value=<?php echo (" '$tp_pessoa'"); ?>>
					<input type="hidden" name="tp_cadastro" value=<?php echo (" '$tp_cadastro'"); ?>>

				      <div class="row">
				      <div class="col-xs-6 col-md-4">
				      <br>Tipo de Cadastro:<br>
				        <select class="form-control" name="tipo_cadastro" disabled="">
				          <?php
				          	if ($tp_cadastro == 0)
				          	{
				          		echo "
				          			<option value='0' selected>Cliente</option>  
				          			<option value='1'>Fornecedor</option>
				          		";
				          	}
				          	else
				          	{
				          		echo "
				          			<option value='0'>Cliente</option>  
				          			<option value='1' selected>Fornecedor</option>
				          		";
				          	}
				          ?>
				        </select>
				      </div>

				      <div class="col-xs-6 col-md-4">
				      <br>Tipo de Pessoa:<br>
				        <select id="tpPessoa" class="form-control" name="tipo_pessoa" disabled="">
				            <?php
				          	if ($tp_pessoa == 0)
				          	{
				          		echo "
				          			<option value='0' selected>Jurídica</option> 
				          			<option value='1'>Física</option>
								</select>
							</div>

									<div class='col-xs-6 col-md-4'>
									<br>CNPJ/CPF:<br>
									<input type='text' id='documento1' class='form-control' placeholder='Ex: 12.432.000/0001-90' name='documento' maxlength='14' required value='$documento'>
									</div>
									</div>
				          		";
				          	}
				          	else
				          	{
				          		echo "
				          			<option value='0'>Jurídica</option>
				          			<option value='1' selected>Física</option>
			          			</select>
						</div>

				          			<div class='col-xs-6 col-md-4'>
									<br>CNPJ/CPF:<br>
									<input type='text' id='documento2' class='form-control' placeholder='Ex: 123.456.789-00' name='documento' maxlength='14' required value='$documento'>
									</div>
									</div>
				          		";
				          	}
				          ?>
				        

				      <div class="row">
				      <div class="col-xs-6 col-md-4">
				      <br>Nome:<br>
				      <input type="text" placeholder="Ex: Astro Locação e Transporte LTDA" class="form-control" name="nome" maxlength="80" required value=<?php echo (" '$nome'"); ?>>
				      </div>

				      <div class="col-xs-6 col-md-4">
				      <br>Endereço:<br>
				      <input type="text" placeholder="Rua das Orquídeas" class="form-control" name="endereco" maxlength="80" value=<?php echo (" '$endereco'"); ?>>
				      </div>

				      <div class="col-xs-6 col-md-4">   
				      <br>Número:<br>
				      <input type="text" placeholder="315" class="form-control" name="numero" maxlength="6" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$numero'"); ?>>
				      </div>
				      </div>

				      <div class="row">
				      <div class="col-xs-6 col-md-4">
				      <br>Bairro:<br>
				      <input type="text" placeholder="Jardim das Flores" class="form-control" name="bairro" maxlength="80" value=<?php echo (" '$bairro'"); ?>>
				      </div>

				      <div class="col-xs-6 col-md-4">
				      <br>Estado: <span id="aviso">(Selecione o estado para visualizar as cidades)</span><br>
				        <select id="estado" class="form-control" name="estado" value=<?php echo (" '$estado'"); ?>></select>
				      </div>

				      <div class="col-xs-6 col-md-4">
				      <br>Cidade:<br>
				      <select id="cidade" class="form-control" name="cidade" value=<?php echo (" '$cidade'"); ?>></select>
				      </div>
				      </div>

				      <div class="row">
				      <div class="col-xs-6 col-md-4">
				      <br>CEP:<br>
				      <input type="text" id="campoCep" placeholder="12400000" class="form-control" name="cep" maxlength="8" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$cep'"); ?>>
				      </div>

				      <div class="col-xs-6 col-md-4">
				      <br>Contato:<br>
				      <input type="text" placeholder="Ex.: Francisco Gomes" class="form-control" name="contato" maxlength="80" value=<?php echo (" '$contato'"); ?>>
				      </div>

				      <div class="col-xs-6 col-md-4">
				      <br>Telefone 1:<br>
				      <input type="text" placeholder="Ex.: 1235222121" class="form-control" id="campoTelefone" name="fone1" maxlength="11" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$fone1'"); ?>>
				      </div>
				      </div>

				      <div class="row">
				      <div class="col-xs-6 col-md-4">
				      <br>Telefone 2:<br>
				      <input type="text" placeholder="12992134049" class="form-control" name="fone2" id="campoTelefone1" maxlength="11" onkeypress='return SomenteNumero(event)' value=<?php echo (" '$fone2'"); ?>>
				      </div>

				      <div class="col-xs-6 col-md-4">
				      <br>E-mail:<br>
				      <input type="text" placeholder="endereco@dominio.com" class="form-control" name="email" maxlength="80" value=<?php echo (" '$email'"); ?>>
				      </div>

				      <div class="col-xs-6 col-md-4">
						<br>Ativo:<br>
						<label class="radio-inline">
				  			<input type="radio" name="status" value="1" <?php if($status == 1){ echo ("checked"); } ?>> Sim
				  		</label>
						<label class="radio-inline">
							<input type="radio" name="status" value="0" <?php if($status == 0){ echo ("checked"); } ?>> Não
						</label>
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

						$id_pessoa   = $_POST["id_pessoa"];
						$tp_cadastro = $_POST["tp_cadastro"];
						$tp_pessoa   = $_POST["tp_pessoa"];
						$documento   = str_replace(array(".","/","-"),"",$_POST["documento"]);
						$nome 		 = $_POST["nome"];
						$endereco 	 = $_POST["endereco"];
						$numero 	 = $_POST["numero"];
						$bairro 	 = $_POST["bairro"];
						$cidade 	 = $_POST["cidade"];
						$estado 	 = $_POST["estado"];
						$cep  		 = str_replace(array(".","-"),"",$_POST["cep"]);
						$contato	 = $_POST["contato"];
						$fone1 		 = $_POST["fone1"];
						$fone2 		 = $_POST["fone2"];
						$email 		 = $_POST["email"];
						$status 	 = $_POST["status"];

						$res = mysql_query("UPDATE 
												pessoas
												SET
													PES_TP_CADASTRO = '$tp_cadastro',
													PES_TP_PESSOA = '$tp_pessoa',
													PES_DOCUMENTO = '$documento',
													PES_NOME = '$nome',
													PES_ENDERECO = '$endereco',
													PES_NUMERO = '$numero',
													PES_BAIRRO = '$bairro',
													PES_CIDADE = '$cidade',
													PES_UF = '$estado',
													PES_CEP = '$cep',
													PES_CONTATO = '$contato',
													PES_FONE1 = '$fone1',
													PES_FONE2 = '$fone2',
													PES_EMAIL = '$email',
													PES_STATUS = '$status'
													WHERE 
														ID_PESSOA = '$id_pessoa';"); 

						if(mysql_affected_rows()>0)
						{
							echo "
								<div class='container theme-showcase' role='main'>
									<div class='panel panel-success'> 
										<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
										<div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_pessoa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
		$("#campoTelefone").mask("(99) 9999-9999");
		$("#campoCep").mask("**.***-***");
		$("#campoTelefone1").mask("(99) 99999-9999");
		$("#documento1").mask("**.***.***/****-**");
		$("#documento2").mask("***.***.***-**");
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