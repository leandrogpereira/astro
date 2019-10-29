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
			        $tp_contrato = $_POST["tp_contrato"];

			        $query = mysql_query("SELECT A.NR_ADITIVO
		        							FROM aditivos    A 
		        						   WHERE A.ID_CONTRATO = $id_contrato
		        						ORDER BY A.NR_ADITIVO
		        							 DESC ");

			        $row = mysql_fetch_array($query);
			        
			        $nr_aditivo = $row['NR_ADITIVO'];

			        $nr_aditivo = $nr_aditivo + 1;

			?>

			<div class="container theme-showcase" role="main">
				<div class="panel panel-primary">
				    <div class="panel-heading">
				      <h3 class="panel-title">PARA ADICIONAR UM ADITIVO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
				    </div>
				    <div class="panel-body">

						<form method="POST" action="cad_aditivo.php">
			  
							<div class="row">

						      	<div class="col-xs-6 col-md-4">
							     	<br>Código do Contrato:<br>
							        <input type="text" class="form-control" placeholder="Ex: 001" name="id_contrato" maxlength="6" required readonly value=<?php echo (" '$id_contrato'"); ?>>
						      	</div>

								<div class="col-xs-6 col-md-4">
									<br>Aditivo:<br>
									<input type="text" class="form-control" name="nr_aditivo" maxlength="6" readonly value=<?php echo (" '$nr_aditivo'"); ?>>
							    </div>

								<div class="col-xs-6 col-md-4">
								  <br>Data de Início:<br>
								  <input type="text" id="campoData" placeholder="Ex.: 01-01-2017" class="form-control" name="dt_inicio" required>
								</div>

						  	</div>

						  	<div class="row"> 

								<div class="col-xs-6 col-md-4">
									<br>Data de Término:<br>
									<input type="text" id="campoData1" placeholder="Ex.: 31-12-2017" class="form-control" name="dt_termino" required>
								</div>

								<div class="col-xs-6 col-md-4">
									<br>Valor por Peso:<br>
									<input type="text" id="mascara1" placeholder="Ex.: 4,50" class="form-control" name="vl_peso" maxlength="13" data-precision="2" data-thousands="" data-decimal="."  required <?php if ($tp_contrato == 1) { echo "disabled";} ?>>
								</div>

								<div class="col-xs-6 col-md-4">   
									<br>Valor do Aditivo:<br>
									<input type="text" id="mascara2" placeholder="Ex.: 10.000,00" class="form-control" name="vl_total" data-precision="2" maxlength="13" data-thousands="" data-decimal="." required <?php if ($tp_contrato == 2) { echo "disabled";} ?>>
								</div>
							</div>

							<br><br><br>
							<button type="submit" class="btn btn-primary btn-lg" name="enviar">Gravar</button>
							<a href='ger_contrato.php'><button type='button' class='btn btn-info btn-lg'> Voltar</button></a>
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
						include_once("funcao.php");
						if (verificaDataContrato($_POST["dt_inicio"],$_POST["dt_termino"]) == true)
						{
							$id_contrato = $_POST["id_contrato"];

							$nr_aditivo = $_POST["nr_aditivo"];

							$dt_inicio = date('Y-m-d H:i:s', strtotime($_POST["dt_inicio"]));

							$dt_termino = date('Y-m-d H:i:s', strtotime($_POST["dt_termino"]));

							if (!isset($_POST["vl_total"]))
					        {
					          $vl_total = 0.00;
					        }
					        else
					        {
					          $vl_total    = number_format(floatval($_POST["vl_total"]), 2, '.', '');
					          #$vl_total   = number_format(floatval($vl_total), 2, '.', '');
					        }
					        if (!isset($_POST["vl_peso"]))
					        {
					          $vl_peso = 0.00;
					        }
					        else
					        {
					          $vl_peso     = number_format(floatval($_POST["vl_peso"]), 2, '.', '');
					          #$vl_peso    = number_format(floatval($vl_peso), 2, '.', '');    
					        }      

							$res = mysql_query("
												INSERT aditivos
											    VALUES (null, $id_contrato, $nr_aditivo, '$dt_inicio', '$dt_termino', '$vl_peso', '$vl_total')
											  ;"); 
		   
							if(mysql_affected_rows()>0)
							{
								echo "
									<div class='container theme-showcase' role='main'>
										<div class='panel panel-success'> 
											<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
											<div class='panel-body'> Cadastro realizado com sucesso!<br><br><a href='ger_contrato.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
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
					              <div class='panel-body'> <p align='center'>A data inicial do aditivo deve ser maior que a data de término.<br><br><a class='btn btn-danger btn-sm' href='ger_contrato.php'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</a></p></div> 
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
    </script>
            
</div>