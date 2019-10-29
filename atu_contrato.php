<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

	<div class="topo">
		<?php include_once('header.php'); ?>
	</div>

	<div class="conteudo">

		<?php
			include_once('conexao.php');
			if ($_SESSION["acesso"] <= 1 || $_POST["id_contrato"] == null)
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
					$id_contrato = $_POST["id_contrato"];

			        $query = mysql_query("SELECT *
		        							FROM contratos   C
	    							  INNER JOIN pessoas     P ON P.ID_PESSOA = C.ID_PESSOA
			        				  INNER JOIN tp_contrato T ON T.ID_TP_CONTRATO = C.ID_TP_CONTRATO
			        					   WHERE C.ID_CONTRATO  = '$id_contrato'");

			        while ($row = mysql_fetch_array($query))
			        {
						$id_contrato   = $row['ID_CONTRATO'];
						$tp_contrato   = $row['ID_TP_CONTRATO'];
						$nr_contrato = $row['NR_CONTRATO'];
						$dt_inicio = date('d-m-Y', strtotime($row['CON_DT_INICIO']));
						$dt_fim = date('d-m-Y', strtotime($row['CON_DT_FIM']));
						$vl_peso = $row['CON_VL_PESO'];
						$vl_total = $row['CON_VALOR'];
						$partida = $row['CON_PARTIDA'];
						$destino = $row['CON_DESTINO'];
						$descricao = $row['CON_DESCRICAO'];
						$status = $row['CON_STATUS'];
						$cliente = $row['ID_PESSOA'];
		        	}
			?>

			<div class="container theme-showcase" role="main">
				<div class="panel panel-primary">
				    <div class="panel-heading">
				      <h3 class="panel-title">PARA ALTERAR UM CADASTRO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
				    </div>
				    <div class="panel-body">

					<!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
					<div id="confirm-delete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
					  <div class="modal-content">
					    <div class="modal-header">
					      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title" id="myModalLabel" style="color:black">Confirmação</h4>
					    </div>
					    <div class="modal-body" style="color:black">
					      Deseja realmente remover o registro?
					    </div>

					    <div align="right">
					      <table>
					        <thead>
					          <tr>
					            <th>
					             <button type="button" class="btn btn-default margem" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Cancelar</button>
					             <a class="btn btn-primary margem btn-ok"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Confirmar</a>
					           </th>
					         </tr>
					       </thead>
					     </table>
					     <br>
					   </div>
					 </div>
					</div>
					</div>
					<!-- Fim Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->

					<!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
					<div id="confirm-remove" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
					  <div class="modal-content">
					    <div class="modal-header">
					      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      <h4 class="modal-title" id="myModalLabel" style="color:black">Confirmação</h4>
					    </div>
					    <div class="modal-body" style="color:black">
					      Deseja realmente remover o contrato?
					    </div>

					    <div align="right">
					      <table>
					        <thead>
					          <tr>
					            <th>
					             <button type="button" class="btn btn-default margem" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Cancelar</button>
					             <a class="btn btn-primary margem btn-ok"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Confirmar</a>
					           </th>
					         </tr>
					       </thead>
					     </table>
					     <br>
					   </div>
					 </div>
					</div>
					</div>
					<!-- Fim Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->

						<form method="POST" action="atu_contrato.php">
			  
							<div class="row">

						      	<div class="col-xs-6 col-md-4">
							     	<br>Código:<br>
							        <input type="text" class="form-control" placeholder="Ex: 001" name="id_contrato" maxlength="6" required readonly value=<?php echo (" '$id_contrato'"); ?>>
						      	</div>

								<div class="col-xs-6 col-md-4">
									<br>Tipo de Contrato:<br>
						            <select class="form-control" id="tpContrato" name="tp_contrato" onclick="javascript:verifica();">
						              <?php
							          	if ($tp_contrato == 1)
							          	{
							          		echo "
							          			<option value='1' selected>Fixado</option>  
							          			<option value='2'>Quantitativo</option>
							          		";
							          	}
							          	else
							          	{
							          		echo "
							          			<option value='1'>Fixado</option>  
							          			<option value='2' selected>Quantitativo</option>
							          		";
							          	}
							          ?>
						            </select>
							    </div>

								<div class="col-xs-6 col-md-4">
								  <br>Número do Contrato:<br>
								  <input type="text" class="form-control" placeholder="Ex: 001" name="nr_contrato" maxlength="6" onkeypress='return SomenteNumero(event)' required value=<?php echo (" '$nr_contrato'"); ?>>
								</div>

						  	</div>

						  	<div class="row"> 

								<div class="col-xs-6 col-md-4">
									<br>Contratante:<br>
									<select class="form-control" name="cliente">
									  <?php 

									    $query = mysql_query("SELECT * FROM pessoas WHERE PES_TP_CADASTRO = 0 AND PES_STATUS = 1");

									    while ($row = mysql_fetch_array($query))
									    {
											$id_pessoa = $row['ID_PESSOA'];
											$pessoa = $row['PES_NOME'];

										    if($cliente == $id_pessoa)
											{
												echo ("<option value='$id_pessoa' selected>$pessoa</option>");
											}
											else
											{            
												echo ("<option value='$id_pessoa'>$pessoa</option>");
											}
									    }

									  ?>
									</select>
								</div>

								<div class="col-xs-6 col-md-4">
									<br>Data de Início:<br>
									<input type="text" id="campoData" placeholder="Ex.: 01-01-2016" class="form-control" name="dt_inicio" required value=<?php echo (" '$dt_inicio'"); ?>>
								</div>

								<div class="col-xs-6 col-md-4">
									<br>Data de Término:<br>
									<input type="text" id="campoData1" placeholder="Ex.: 31-12-2016" class="form-control" name="dt_fim" required value=<?php echo (" '$dt_fim'"); ?>>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-6 col-md-4">   
									<br>Valor do Contrato:<br>
									<input type="text" id="mascara1" placeholder="Ex.: 10.000,00" class="form-control" name="vl_total" maxlength="13" data-thousands="" <?php if ($tp_contrato == 2) { echo "disabled";} ?> value=<?php echo (" '$vl_total'"); if ($tp_contrato == 2) { echo "disabled";} ?>>
								</div>

								<div class="col-xs-6 col-md-4">
									<br>Valor por Peso:<br>
									<input type="text" id="mascara2" placeholder="Ex.: 4,50" class="form-control" name="vl_peso" maxlength="13" data-thousands="" <?php if ($tp_contrato == 1) { echo "disabled";} ?> value=<?php echo (" '$vl_peso'"); if ($tp_contrato == 1) { echo "disabled";} ?>>
								</div>

								<div class="col-xs-6 col-md-4">
									<br>Ativo:<br>
									<input name="status" type="radio" value="1" <?php if($status == 1){ echo ("checked");} ?>> Sim
									<input name="status" type="radio" value="0" <?php if($status == 0){ echo ("checked");} ?>> Não
								</div>
							</div>

							<div class="row">

								<div class="col-xs-6 col-md-4">
									<br>Endereço de Partida:<br>
									<input type="text" placeholder="Ex.: Avenida dos Cravos Nº 13 Jardim das Flores Taubaté/SP" class="form-control" name="partida" maxlength="80" value=<?php echo (" '$partida'"); ?>>
								</div>

								<div class="col-xs-6 col-md-4">
									<br>Endereço de Destino:<br>
									<input type="text" placeholder="Ex.: Estrada dos Pardais Nº 11 Parque das Aves Pindamonhangaba/SP" class="form-control" name="destino" maxlength="80" value=<?php echo (" '$destino'"); ?>>
								</div>

								<div class="col-xs-6 col-md-4">
									<button type="submit" class="btn btn-primary" name="enviar" id="btn_aditivo">Gravar</button>
									<a href='ger_contrato.php'><button type='button' class='btn btn-info' id="btn_aditivo"> Voltar</button></a>
									<input type="button" class="btn btn-danger" id="btn_aditivo" name="excluir" data-href=<?php echo "exc_contrato.php?id_contrato=$id_contrato"; ?> data-toggle="modal" data-target="#confirm-remove" value="Remover">
								</div>
								
							</div>

							<br>Descrição:<br>
							<textarea cols="40" rows="5" class="form-control" name="descricao" maxlength="200"><?php echo ("$descricao"); ?></textarea>

						</form>

						<br>Aditivos:<br>
							<div class="table-responsive">  
					            <table class="table table-hover table-consulta" id="datatable">
					              <thead>
					                <tr>
					                <th>Número</th>
					                <th>Data de Início</th>
					                <th>Data de Término</th>
					                <th>Vl. Peso (R$)</th>
					                <th>Vl. Aditivo (R$)</th>
					                <th><th>
					                </tr>
					              </thead>
					              <tbody>
					                <?php 
					                  $query = mysql_query("SELECT * FROM aditivos A WHERE A.ID_CONTRATO = $id_contrato");

					                  while ($row = mysql_fetch_array($query))
					                  {
					                    $aditivo = $row['ID_ADITIVO'];
					                    $nr_aditivo = $row['NR_ADITIVO'];
					                    $inicial = date('d-m-Y', strtotime($row['DT_INICIO']));
					                    $dt_inicial = $row['DT_INICIO'];
					                    $final = date('d-m-Y', strtotime($row['DT_TERMINO']));
					                    $dt_final = $row['DT_TERMINO'];
					                    $vl_peso = $row['VL_PESO'];
					                    $vl_total = $row['VL_TOTAL'];

					                    echo("             
					                      <tr>
					                      <th scope='row'>$nr_aditivo</th>
					                      <td>$inicial</td>
					                      <td>$final</td>
					                      <td>$vl_peso</td>
					                      <td>$vl_total</td>
					                      <td class='last-td'>
	                      					<button class='btn btn-danger btn-sm' data-href='exc_aditivo.php?aditivo=$aditivo&dt_inicial=$dt_inicial&dt_final=$dt_final&id_contrato=$id_contrato' data-toggle='modal' data-target='#confirm-delete'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>
	                      				  </td>
					                      </td>
					                      </tr>
					                    ");
					                  }
					                mysql_close($conecta);
					                ?>
					              </tbody>
					            </table>
					          </div>
				    		
				    		<form method="POST" action="cad_aditivo.php" id="cad_aditivo">
		                        <input type="hidden" name="id_contrato" value=<?php echo (" '$id_contrato'"); ?>/>
		                        <input type="hidden" name="tp_contrato" value=<?php echo (" '$tp_contrato'"); ?>/>
		                        <button type="submit" class="btn btn-primary btn-sm" name="cadastrar" <?php if ($status == 0) { echo "disabled";} ?>><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
		                    </form>

					</div>
				</div>      
			</div>

				<?php

					} 
					else
					{
						include_once('conexao.php');
						$id_contrato = $_POST["id_contrato"];

						/***** VERIFICA SE O CONTRATO POSSUI TRANSPORTES VINCULADOS *****/

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
								      <div class='panel-body'> <p align='center'>Contratos que possuem aditivos, transportes ou recebimentos vinculados não podem ser alterados.<br><br><a class='btn btn-danger btn-sm' href='ger_contrato.php'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</a></p></div> 
								    </div>
								  </div>
								  ";
						}

						/*****				 FIM DA VERIFICAÇÃO						 *****/
						else
						{
							include_once('funcao.php');
							if (verificaDataContrato($_POST["dt_inicio"],$_POST["dt_fim"]) == true)
	      					{
								$tp_contrato = $_POST["tp_contrato"];
								$nr_contrato = $_POST["nr_contrato"];
								$dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["dt_inicio"]));
								$dt_fim = date('Y-m-d H:i:s', strtotime($_POST["dt_fim"]));
								if (!isset($_POST["vl_total"]))
						        {
						          $vl_total = 0.00;
						        }
						        else
						        {
						          $vl_total    = $_POST["vl_total"];  
						          #$vl_total   = number_format(floatval($vl_total), 2, '.', '');
						        }
						        if (!isset($_POST["vl_peso"]))
						        {
						          $vl_peso = 0.00;
						        }
						        else
						        {
						          $vl_peso     = $_POST["vl_peso"];
						          #$vl_peso    = number_format(floatval($vl_peso), 2, '.', '');    
						        }      
								$partida = $_POST["partida"];
								$destino = $_POST["destino"];
								# $vl_peso = number_format(floatval($vl_peso), 2, '.', '');  
								$descricao = $_POST["descricao"];
								$status = $_POST["status"];
								$cliente = $_POST["cliente"];
								$res = mysql_query("
													UPDATE	contratos
													   SET  ID_TP_CONTRATO = '$tp_contrato'
														 ,  NR_CONTRATO = '$nr_contrato'
														 ,  CON_DT_INICIO = '$dt_inicio'
														 ,  CON_DT_FIM = '$dt_fim'
														 ,  CON_VALOR = '$vl_total'
														 ,  CON_VL_PESO = '$vl_peso'
														 ,  CON_PARTIDA = '$partida'
														 ,  CON_DESTINO = '$destino'
														 ,  CON_DESCRICAO = '$descricao'
														 ,  CON_STATUS = '$status'
														 ,  ID_PESSOA = '$cliente'
													 WHERE 	ID_CONTRATO = '$id_contrato'
												;"); 
			   
								if(mysql_affected_rows()>0)
								{
									echo "
										<div class='container theme-showcase' role='main'>
											<div class='panel panel-success'> 
												<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
												<div class='panel-body'> Cadastro atualizado com sucesso!<br><br><a href='ger_contrato.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
								      <div class='panel-heading'><h3 class='panel-title text-left'>Aviso</h3></div> 
								      <div class='panel-body'> <p align='center'>A data inicial do contrato deve ser maior que a data de término.<br><br><a class='btn btn-danger btn-sm' href='javascript:history.go(-1);'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</a></p></div> 
								    </div>
								  </div>
								  ";
							}
						} //fim da verificação de registros
					}
				}

			?>

	</div>

	<div class="rodape">
		<?php include_once('footer.php'); ?>
	</div>

	<script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

	<!-- Máscara para moeda -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
       $("#campoData1").mask("99-99-9999");
    });
    
    $(function($) {
      $('#mascara1').maskMoney();
    })
    
    $(function($) {
      $('#mascara2').maskMoney();
    })
    
      function SomenteNumero(e){
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
          if (tecla==8 || tecla==0) return true;
          else  return false;
        }
      }

        $(document).ready(function() {
          $('#confirma').modal();
      });

      $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });

      $('#confirm-remove').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });

		function verifica()
		{
			var testa = document.getElementById("tpContrato").value;
			if (testa == 1)
			{
			 document.getElementById("mascara1").disabled = false;
			 document.getElementById("mascara2").disabled = true;
			} 
			else
			{
			 document.getElementById("mascara1").disabled = true;
			 document.getElementById("mascara2").disabled = false;
			}
		}
    </script>
            
</div>