<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_POST["id_transporte"] == null)
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
								<div class='panel-body'> <p align='center'>Período selecionado não é permitido fazer alterações.</p><br><br><a href='ger_transporte.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
							</div>
						</div>
						";
	  			}
	  			else
	  			{

					if(!isset($_POST["enviar"]))
					{

				        $id_transporte = $_POST["id_transporte"];

				        $query = mysql_query("SELECT 
			        							*
			        							FROM transportes T
				        							INNER JOIN contratos C ON C.ID_CONTRATO = T.ID_CONTRATO
				        							INNER JOIN veiculos V ON V.ID_VEICULO = T.ID_VEICULO
				        							INNER JOIN funcionarios F ON F.ID_FUNCIONARIO = T.ID_FUNCIONARIO
		    							  		WHERE T.ID_TRANSPORTE = '$id_transporte'");

				        while ($row = mysql_fetch_array($query))
				        {
							$id_transporte = $row['ID_TRANSPORTE'];
							$data 		   = date('d-m-Y H:i:s', strtotime($row['TRA_DATA']));
							$nota 	       = $row['TRA_NOTA'];
							$peso 	       = $row['TRA_PESO'];
							$observacao    = $row['TRA_OBSERVACAO'];
							$veiculo       = $row['ID_VEICULO'];
							$funcionario   = $row['ID_FUNCIONARIO'];
							$contrato 	   = $row['ID_CONTRATO'];
			        	}
				?>

				<div class="container theme-showcase" role="main">
					<div class="panel panel-primary">
					    <div class="panel-heading">
					      <h3 class="panel-title">PARA ALTERAR UM CADASTRO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
					    </div>
					    <div class="panel-body">

							<form method="POST" action="atu_transporte.php">

								<div class="row">

									<div class="col-xs-6 col-md-4">
										<br>Número:<br>
										<input type="text" class="form-control" name="id_transporte" maxlength="6" readonly value=<?php echo (" '$id_transporte'"); ?>>
									</div>

								    <div class="col-xs-6 col-md-4">
								      	<br>Data:<br>
								      	<input type="text" id="campoData" placeholder="Ex.: 30-06-2016 09:30:00" class="form-control" name="data" required value=<?php echo (" '$data'"); ?>>
								    </div>

								    <div class="col-xs-6 col-md-4">
										<br>Código do Contrato:<br>
										<input type="text" class="form-control" name="contrato" maxlength="6" readonly value=<?php echo (" '$contrato'"); ?>>
								    </div>

								</div>

								<div class="row">

									<div class="col-xs-6 col-md-4">
										<br>Veículo:<br>
										<select class="form-control" name="veiculo" required>
										  <?php 

										    $query = mysql_query("SELECT 
										                            ID_VEICULO,
										                            VEI_PLACA_COD,
										                            VEI_MODELO
										                            FROM veiculos
										                            WHERE VEI_STATUS = 1 AND ID_VEICULO <> 0");

										    while ($row = mysql_fetch_array($query)){
												$id_veiculo = $row['ID_VEICULO'];
												$placa = $row['VEI_PLACA_COD'];
												$modelo = $row['VEI_MODELO'];

												if($veiculo == $id_veiculo)
												{
													echo ("<option value='$id_veiculo' selected>$placa - $modelo</option>");
												}
												else
												{            
													echo ("<option value='$id_veiculo'>$placa - $modelo</option>");
												}
										    }

										  ?>
										</select>
									</div>

								    <div class="col-xs-6 col-md-4">
										<br>Motorista:<br>
										<select class="form-control" name="motorista" required>
										  <?php 

										    $query = mysql_query("SELECT 
										                            F.ID_FUNCIONARIO AS ID,
										                            F.FUN_NOME AS NOME,
										                            F.FUN_SOBRENOME AS SOBRENOME
										                            FROM funcionarios F
										                            INNER JOIN cargos C on C.ID_CARGO = F.ID_CARGO
										                            WHERE F.FUN_STATUS = 1 AND F.ID_CARGO = 1");
										    while ($row = mysql_fetch_array($query)){
												$id_funcionario = $row['ID'];
												$motorista = $row['NOME'];
												$sobrenome = $row['SOBRENOME'];

											    if($funcionario == $id_funcionario)
												{
													echo ("<option value='$id_funcionario' selected>$motorista $sobrenome</option>");
												}
												else
												{            
													echo ("<option value='$id_funcionario'>$motorista $sobrenome</option>");
												}
										    }

										  ?>
										</select>
								    </div>

									<div class="col-xs-6 col-md-4">   
										<br>Peso: (Ton)<br>
										<input type="text" id="mascara1" placeholder="Ex.: 32123,612" class="form-control" name="peso" maxlength="5"  data-precision="2" data-thousands="" required value=<?php echo (" '$peso'"); ?>>
									</div>

								</div>

								<div class="row">

									<div class="col-xs-6 col-md-4">   
										<br>Nota:<br>
										<input type="text" id="" placeholder="Ex.: NF-01123" class="form-control" name="nota" maxlength="10" value=<?php echo (" '$nota'"); ?>>
									</div>
								
								</div>

								<br>Observações:<br>
								<textarea cols="40" rows="5" class="form-control" name="observacao" maxlength="200"><?php echo ("$observacao"); ?></textarea>

								<br><br><br>
								<button type="submit" class="btn btn-primary btn-lg" name="enviar">Gravar</button>
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

							if (verificaPeriodo($_POST["data"]) == true && verificaContrato($_POST["data"],$_POST["contrato"]) == true)
	  						{

								$id_transporte = $_POST["id_transporte"];

								$data = date('Y-m-d H:i:s', strtotime($_POST["data"]));

								$nota = $_POST["nota"];

								$peso = number_format(floatval($_POST["peso"]), 2, '.', '');

								$observacao = $_POST["observacao"];

								$veiculo   = $_POST["veiculo"];				

								$motorista   = $_POST["motorista"];

								$contrato = $_POST["contrato"];

								$verifica_contrato = mysql_query("SELECT ID_TP_CONTRATO,CON_VL_PESO FROM contratos WHERE ID_CONTRATO = $contrato");
								$row = mysql_fetch_array($verifica_contrato);
								$tp_contrato = $row["ID_TP_CONTRATO"];
								$vl_peso = number_format(floatval($row["CON_VL_PESO"]), 2, '.', '');

								$valor = number_format(floatval($vl_peso) * floatval($peso), 2, '.', '');

								if($tp_contrato == 2)
								{
									$up = mysql_query("
													UPDATE
														baixas
														SET
														 BAI_DESCRICAO = 'Transporte: $id_transporte; $observacao'
														,BAI_VALOR = '$valor'
														WHERE 
															ID_TRANSPORTE = $id_transporte
														;");
								}

								$res = mysql_query("
													UPDATE
														transportes
														SET
														 TRA_DATA = '$data'
														,TRA_NOTA = '$nota'
														,TRA_PESO = '$peso'
														,TRA_OBSERVACAO = '$observacao'
														,ID_VEICULO = '$veiculo'
														,ID_FUNCIONARIO = '$motorista'
														,ID_CONTRATO = '$contrato'
														,ID_PERIODO  = ".$_SESSION["id_periodo"]."
														WHERE 
															ID_TRANSPORTE = '$id_transporte'
														;"); 
			   
								if(mysql_affected_rows()>0)
								{
									echo "
										<div class='container theme-showcase' role='main'>
											<div class='panel panel-success'> 
												<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
												<div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_transporte.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
							else
							{
								echo "
								  <div class='container theme-showcase' role='main'>
								    <div class='panel panel-danger'> 
								      <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
								      <div class='panel-body'> <p align='center'>Data inválida para lançamento. Verifique os dados preenchidos e a vigência do contrato.</p><br><br><div class='text-center'><a href='ger_transporte.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div></div> 
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

    <!-- Máscara para moeda -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

    <script>
    $(function($) {
      $('#mascara1').maskMoney();
    })

    jQuery(function($){
       $("#campoData").mask("99-99-9999 99:99:99");
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