<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_POST["id_despesa"] == null)
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
								<div class='panel-body'> <p align='center'>Período selecionado não é permitido fazer alterações.</p><br><br><a href='ger_despesa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
							</div>
						</div>
						";
	  			}
	  			else
	  			{
					if(!isset($_POST["enviar"]))
					{
				        $id_despesa = $_POST["id_despesa"];

				        $query = mysql_query("SELECT 
				        							*,
				        							D.ID_FUNCIONARIO AS FUNCIONARIO
				        							FROM despesas D
				        							INNER JOIN pessoas 		P ON P.ID_PESSOA = D.ID_PESSOA
				        							INNER JOIN funcionarios F ON F.ID_FUNCIONARIO = D.ID_FUNCIONARIO
				        							INNER JOIN tp_despesas 	T ON T.ID_TP_DESPESA = D.ID_TP_DESPESA 
				        							INNER JOIN baixas	    B ON B.ID_DESPESA = D.ID_DESPESA
				        								WHERE D.ID_DESPESA = $id_despesa");

				        while ($row = mysql_fetch_array($query))
				        {
							$id_despesa    = $row['ID_DESPESA'];
							$veiculo 	   = $row['ID_VEICULO'];
							$data  		   = date('d-m-Y', strtotime($row['DES_DATA']));
							$nota 	       = $row['DES_NOTA'];
							$descricao 	   = $row['DES_DESCRICAO'];
							$id_fornecedor = $row['ID_PESSOA'];
							$tp_despesa    = $row['ID_TP_DESPESA'];
							$funcionario   = $row['FUNCIONARIO'];
							$valor 	       = $row['BAI_VALOR'];
							$status 	   = $row['ST_BAIXA'];
							if ($status == 1) {
								$dt_baixa = date('d-m-Y', strtotime($row['BAI_DATA']));
								$caixa = $row['ID_CAIXA'];
							}
							else
							{
								$dt_baixa = '';
								$caixa = '';
							}
			        	}
				?>

				<div class="container theme-showcase" role="main">
					<div class="panel panel-primary">
					    <div class="panel-heading">
					      <h3 class="panel-title">PARA ALTERAR UM CADASTRO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
					    </div>
					    <div class="panel-body">

					<form method="POST" action="atu_despesa.php">

					      <div class="row">

						      <div class="col-xs-6 col-md-4">
							      <br>Número:<br>
							      <input type="text" class="form-control" name="id_despesa" maxlength="6" readonly value=<?php echo (" '$id_despesa'"); ?>>
						      </div>

						      <div class="col-xs-6 col-md-4">
							      <br>Data:<br>
							      <input type="text" id="campoData" placeholder="Ex.: 30-06-2016" class="form-control" name="data" required value=<?php echo (" '$data'"); ?>>
						      </div>

						      <div class="col-xs-6 col-md-4">
							      <br>Fornecedor:<br>
							      <select class="form-control" name="fornecedor">
							          <?php 

							            $query = mysql_query("SELECT ID_PESSOA, PES_NOME FROM pessoas WHERE PES_TP_CADASTRO = 1");

							            while ($row = mysql_fetch_array($query))
							            {
											$id_pessoa = $row['ID_PESSOA'];
											$fornecedor = $row['PES_NOME'];

											if($id_fornecedor == $id_pessoa)
											{
												echo ("<option value='$id_pessoa' selected>$fornecedor</option>");
											}
											else
											{            
												echo ("<option value='$id_pessoa'>$fornecedor</option>");
											}
							            }
							          ?>
							      </select>
						      </div>
					      </div>

						  <div class="row">

						  	<div class="col-xs-6 col-md-4">
								<br>Tipo de Despesa:<br>
								<select class="form-control" id="tp_despesa" name="tp_despesa" onchange="habilita_vei()">
									<?php 

										$query = mysql_query("SELECT ID_TP_DESPESA,TPD_DESCRICAO FROM tp_despesas");

										while ($row = mysql_fetch_array($query))
										{
											$id_tp_despesa = $row['ID_TP_DESPESA'];
											$tp_despesa_descricao = $row['TPD_DESCRICAO'];

											if ($tp_despesa == $id_tp_despesa) {
												$verifica = "selected";
											}
											else
											{
												$verifica = "";
											}

											if($id_tp_despesa == 2 || $id_tp_despesa == 3)
											{
												echo ("<option value='$id_tp_despesa' $verifica>$tp_despesa_descricao</option>");
											}
											else
											{            
												echo ("<option value='$id_tp_despesa' $verifica>$tp_despesa_descricao</option>");
											}
										}
									?>
								</select>
							</div>

							<div class="col-xs-6 col-md-4">
								<br>Emitente:<br>
								<select class="form-control" name="funcionario">
									<?php 

									$query = mysql_query("SELECT ID_FUNCIONARIO,FUN_NOME, FUN_SOBRENOME FROM funcionarios WHERE FUN_STATUS = 1");
									while ($row = mysql_fetch_array($query))
									{
										$id_funcionario = $row['ID_FUNCIONARIO'];
										$funcionario_nome = $row['FUN_NOME'];
										$funcionario_sobrenome = $row['FUN_SOBRENOME'];

										if($funcionario == $id_funcionario)
										{
											echo ("<option value='$id_funcionario' selected>$funcionario_nome $funcionario_sobrenome</option>");
										}
										else
										{            
											echo ("<option value='$id_funcionario'>$funcionario_nome $funcionario_sobrenome</option>");
										}
									}

									?>
								</select>
							</div>

							<div class="col-xs-6 col-md-4">
						      <br>Veículo:<br>
						      <select class="form-control" id="veiculo" name="veiculo" <?php if($tp_despesa == 2 || $tp_despesa == 3){ echo ("");} else{ echo ("disabled");} ?>>
						      	<option value="0" selected>--</option>
						          <?php 

						            $query = mysql_query("SELECT 
						                                    ID_VEICULO,
						                                    VEI_PLACA_COD,
						                                    VEI_MODELO
						                                    FROM veiculos WHERE VEI_STATUS = 1 AND ID_VEICULO <> 0");

						            while ($row = mysql_fetch_array($query)){
						              $id_veiculo = $row['ID_VEICULO'];
						              $placa = $row['VEI_PLACA_COD'];
						              $modelo = $row['VEI_MODELO'];
						              if ($veiculo == $id_veiculo) {
						              	echo("             
						                  <option value='$id_veiculo' selected>$placa - $modelo</option>
						              		");
						              }
						              echo("             
						                  <option value='$id_veiculo' >$placa - $modelo</option>
						              ");
						            }

						          ?>
						      </select>
					        </div>

					  	  </div>

						  <div class="row">

						  	<div class="col-xs-6 col-md-4">   
								<br>Nota:<br>
								<input type="text" id="" placeholder="Ex.: NF-01123" class="form-control" name="nota" maxlength="8" value=<?php echo (" '$nota'"); ?>> 
							</div>

						  	<div class="col-xs-6 col-md-4">   
								<br>Valor:<br>
								<input type="text" id="mascara1" placeholder="Ex.: 100,00" class="form-control" name="valor" maxlength="13" data-thousands="" value=<?php echo (" '$valor'"); ?>> 
							</div>
						  </div>

						  <div class="row">

							<div class="col-xs-6 col-md-4">
								<br>Baixar:<br>
								<input name="status" type="radio" value="1" onclick="javascript:habilita_a();" <?php if($status == 1){ echo ("checked");} ?>> Sim
								<input name="status" type="radio" value="0" onclick="javascript:desabilita_a();" <?php if($status == 0){ echo ("checked");} ?>> Não
							</div>

							<div class="col-xs-6 col-md-4">
								<br>Data da Baixa:<br>
								<input type="text" id="campoData1" placeholder="Ex.: 30-06-2016" class="form-control" name="dt_baixa" value=<?php echo (" '$dt_baixa'"); if($status == 0){ echo ("disabled");} ?>>
							</div>

							<div class="col-xs-6 col-md-4">
						      <br>Conta Bancária:<br>
						      <select id="campoCaixa" class="form-control" name="caixa" <?php if($status == 0){ echo ("disabled");} ?>>
						          <?php 

						            $query = mysql_query("SELECT * FROM caixa WHERE CAI_STATUS = 1 AND ID_CAIXA <> 0");
						            while ($row = mysql_fetch_array($query)){
						              $id_caixa = $row['ID_CAIXA'];
						              $cai_nome = $row['CAI_NOME'];

						              if ($caixa == $id_caixa) {
						              	echo("             
						                <option value='$id_caixa' selected>$id_caixa - $cai_nome</option>
						                ");
						              }
						              else
						              {
						            	echo("             
						                <option value='$id_caixa'>$id_caixa - $cai_nome</option>
						                ");  	
						              }
						            
						            }

						          ?>
						      </select>
					      	</div>
						  </div>

							<br>Descrição:<br>
							<textarea cols="40" rows="5" class="form-control" name="descricao" maxlength="80"><?php echo ("$descricao"); ?></textarea>

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

							include_once('funcao.php');

							if (verificaPeriodo($_POST["data"]) == true)
	  						{

								$id_usuario=$_SESSION["id_usuario"];

								$id_despesa = $_POST["id_despesa"];

								if (!isset($_POST["veiculo"]))
								{
									$veiculo = 0;
								}
								else
								{
									$veiculo = $_POST["veiculo"]; 
								}

								$data = date('Y-m-d H:i:s', strtotime($_POST["data"]));

								$fornecedor = $_POST["fornecedor"];

								$tp_despesa = $_POST["tp_despesa"];

								$funcionario = $_POST["funcionario"];

								$valor = number_format(floatval($_POST["valor"]), 2, '.', '');  

								$nota   = $_POST["nota"];

								$status = $_POST["status"];

								$descricao = $_POST["descricao"];

								if($status == 0)
								{
									$res = mysql_query("
														UPDATE
															despesas
															SET
															 ID_VEICULO = $veiculo
															,DES_DATA = '$data'
															,DES_NOTA = '$nota'
															,DES_DESCRICAO = '$descricao'
															,ID_PESSOA = '$fornecedor'
															,ID_TP_DESPESA = '$tp_despesa'
															,ID_FUNCIONARIO = '$funcionario'
															,ID_PERIODO = ".$_SESSION["id_periodo"]."
															WHERE 
															 ID_DESPESA = '$id_despesa';
													  "); 

									$up = mysql_query("
														UPDATE 
															baixas
														   SET BAI_DATA = null
														   	 , BAI_DESCRICAO = 'Despesa: $id_despesa; $descricao'
														     , ST_BAIXA = $status
														     , BAI_VALOR = '$valor'
														     , ID_FUNCIONARIO = $id_usuario
														     ,ID_PERIODO = ".$_SESSION["id_periodo"]."
													       WHERE ID_DESPESA = $id_despesa;
													  ");
								}
								else
								{
									$caixa = $_POST["caixa"];
									$dt_baixa = date('Y-m-d H:i:s', strtotime($_POST["dt_baixa"]));
									$res = mysql_query("
														UPDATE
															despesas
															SET
															 ID_VEICULO = $veiculo
															,DES_DATA = '$data'
															,DES_NOTA = '$nota'
															,DES_DESCRICAO = '$descricao'
															,ID_PESSOA = '$fornecedor'
															,ID_TP_DESPESA = '$tp_despesa'
															,ID_FUNCIONARIO = '$funcionario'
															,ID_PERIODO = ".$_SESSION["id_periodo"]."
															WHERE 
															 ID_DESPESA = '$id_despesa';
														");

									$up = mysql_query("
														UPDATE 
															baixas
														   SET 
														   	   ID_CAIXA = $caixa
														   	 , BAI_DESCRICAO = 'Despesa: $id_despesa; $descricao'
														   	 , BAI_DATA = '$dt_baixa'
														     , ST_BAIXA = $status
														     , BAI_VALOR = '$valor'
														     , ID_FUNCIONARIO = $id_usuario
														     ,ID_PERIODO = ".$_SESSION["id_periodo"]."
													       WHERE ID_DESPESA = $id_despesa;
													  ");
								}
			   
								if(mysql_affected_rows()>0)
								{
									echo "
										<div class='container theme-showcase' role='main'>
											<div class='panel panel-success'> 
												<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
												<div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_despesa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
											</div>
										</div>
									";
									mysql_close($conecta);
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
												<div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_despesa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
											</div>
										</div>
									";
									mysql_close($conecta);
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
							else
							{
							echo "
							  <div class='container theme-showcase' role='main'>
							    <div class='panel panel-danger'> 
							      <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
							      <div class='panel-body'> <p align='center'>Data inválida para lançamento.</p><br><br><div class='text-center'><a href='ger_despesa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div></div> 
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

	<!-- Máscara para datas, telefones e senhas -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
       $("#campoTelefone").mask("(99) 9999-9999");
       $("#campoSenha").mask("***-****");
     });
    </script>

    <script>
      jQuery(function($){
     $("#campoData1").mask("99-99-9999");
     $("#campoTelefone1").mask("(99) 99999-9999");
     $("#campoSenha1").mask("***-****");
    });
    </script>

    <!-- Máscara para moeda -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

    <script>
    $(function($) {
      $('#mascara1').maskMoney();
    })
    </script>

    <script>
    $(function($) {
      $('#mascara2').maskMoney();
    })
    </script>

     <script language='JavaScript'>
      function SomenteNumero(e){
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
          if (tecla==8 || tecla==0) return true;
          else  return false;
        }
      }
    </script>

    <script type="text/javascript">
      function habilita_a()
      {
              document.getElementById("campoData1").disabled = false; //Habilitando
              document.getElementById("campoData1").value = '<?=$data_padrao=date('d-m-Y');?>'; //Habilitando
              document.getElementById("campoCaixa").disabled = false; //Habilitando
              document.getElementById("campoCaixa").value = '1'; //Habilitando
            }
            function desabilita_a()
            {
              document.getElementById("campoData1").disabled = true; //Desabilitando
              document.getElementById("campoData1").value='';
              document.getElementById("campoCaixa").disabled = true; //Desabilitando
              document.getElementById("campoCaixa").value='';
            }
     function habilita_vei(){
      switch(document.getElementById('tp_despesa').value) {
          case '2': 
              document.getElementById('veiculo').disabled = false;
              document.getElementById('veiculo').selectedIndex = 0;
          break;
          case '3': 
              document.getElementById('veiculo').disabled = false;
              document.getElementById('veiculo').selectedIndex = 0;
          break;
          default:
              document.getElementById('veiculo').disabled = true;
              document.getElementById('veiculo').selectedIndex = 0;
          break;
      }
  }
    </script>
            
</div>