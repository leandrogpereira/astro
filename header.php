<!DOCTYPE html>

<html lang="pt-br">

        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
          <meta name="description" content="">
          <meta name="author" content="">

          <link rel="shortcut icon" href="img/favicon.png">

          <title>ALT Transportes - Sistema</title>

          <!-- Bootstrap core CSS -->
          <link href="css/bootstrap.min.css" rel="stylesheet">

          <!-- Bootstrap theme -->
          <link href="css/bootstrap-theme.min.css" rel="stylesheet">

          <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
          <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

          <!-- Custom styles for this template -->
          <link href="css/dashboard.css" rel="stylesheet">
          <link href="css/style.css" rel="stylesheet">    

          <!-- PARA FUNCIONAR O DATATABLE -->
          <link href="datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">


          <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
          <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
          <script language="JavaScript" type="text/javascript" src="js/ie-emulation-modes-warning.js"></script>

          <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
          <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>          
          <![endif]-->

          <script language="JavaScript" type="text/javascript" src="js/cidades-estados-utf8.js"></script>

    </head>

    <body>

      <?php
        include("valida_usuario.php");
        valida_usuario();

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set( 'America/Sao_Paulo' );
        #echo strftime( '%Y-%m-%e %T', strtotime('now')); 
        $data_padrao = date("d-m-Y H:i:s");

        function mostra_periodo($m,$a,$st){

          switch ($m) {
            case 1:
              $m = "Janeiro";
              break;
            case 2:
              $m = "Fevereiro";
              break;
            case 3:
              $m = "Março";
              break;
            case 4:
              $m = "Abril";
              break;
            case 5:
              $m = "Maio";
              break;
            case 6:
              $m = "Junho";
              break;
            case 7:
              $m = "Julho";
              break;
            case 8:
              $m = "Agosto";
              break;
            case 9:
              $m = "Setembro";
              break;
            case 10:
              $m = "Outubro";
              break;
            case 11:
              $m = "Novembro";
              break;
            case 12:
              $m = "Dezembro";
              break;
            default:
              $m = "Erro";
              break;
          }

          switch ($st) {
            case 0:
              $st1 = " <span class='glyphicon glyphicon-lock' aria-hidden='true'></span>";
              break;
            
            default:
              $st1 = "";
              break;
          }

          echo "$m/$a".$st1;

        }

      ?>

      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
			<a href="home.php"><img id="img-logo" src="img/logoheader.png"></a>
			<!-- <span class="navbar-brand"></span> -->
          </div>

		  
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
              <li><a href="ger_informativo.php"><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span> Anotações </a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Cadastrar <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">Movimentação</li>
                  <li><a href="cad_contrato.php">Contratos</a></li>
                  <li><a href="cad_transporte.php">Transportes</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Tesouraria</li>
                  <li><a href="cad_despesa.php">Despesas</a></li>
                  <li><a href="cad_lancamento.php">Lançamento Bancário</a></li>
                  <li><a href="cad_baixa.php">Baixas</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Cadastros Básicos</li>
                  <li><a href="cad_tp_cargo.php">Cargos</a></li>
                  <li><a href="cad_funcionario.php">Funcionários</a></li>
                  <li><a href="cad_pessoa.php">Pessoas (Fornecedor/Cliente)</a></li>
                  <li><a href="cad_veiculo.php">Veículos</a></li>
                  <li><a href="cad_tp_despesa.php">Tipos de Despesas</a></li>
                  <!--<li><a href="cad_tp_contrato.php">Tipos de Contratos</a></li>-->
                  <li><a href="cad_caixa.php">Contas</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Gerenciar <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">Movimentação</li>
                  <li><a href="ger_contrato.php">Contratos</a></li>
                  <li><a href="ger_transporte.php">Transportes</a></li>
                  <li><a href="ger_periodo.php">Períodos</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Tesouraria</li>
                  <li><a href="ger_despesa.php">Despesas</a></li>
                  <li><a href="ger_lancamento.php">Lançamentos Bancários</a></li>
                  <li><a href="ger_baixa.php">Baixas</a></li>
                  <li><a href="ger_saldo.php">Saldos</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Cadastros Básicos</li>
                  <li><a href="ger_cargo.php">Cargos</a></li>
                  <li><a href="ger_funcionario.php">Funcionários</a></li>
                  <li><a href="ger_pessoa.php">Pessoas (Fornecedor/Cliente)</a></li>
                  <li><a href="ger_veiculo.php">Veículos</a></li>
                  <li><a href="ger_tp_despesa.php">Tipos de Despesas</a></li>
                  <li><a href="ger_conta.php">Contas</a></li>
                  <!--<li><a href="cad_tp_contrato.php">Tipos de Contratos</a></li>-->
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class='glyphicon glyphicon-search' aria-hidden='true'></span> Consultar <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="con_contrato.php">Contratos</a></li>
                  <li><a href="con_caixa.php">Extrato Bancário</a></li>
                  <li><a href="con_baixa.php">Baixas por Período</a></li>
                  <li><a href="con_transporte.php">Transportes do Período</a></li>
                  <li><a href="con_despesa.php">Despesas do Período</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Consultas Extras</li>
                  <li><a href="con_veiculo.php">Detalhe dos Caminhões</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class='glyphicon glyphicon-print' aria-hidden='true'></span> Relatórios <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="rel_contrato.php">Contratos</a></li>
                  <li><a href="rel_baixas.php">Baixas</a></li>
                  <li><a href="rel_transporte.php">Transportes</a></li>
                  <li><a href="rel_despesa.php">Depesas</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Relatórios Extras</li>
                  <li><a href="rel_aniversariantes.php">Aniversáriantes do Mês</a></li>
                  <li><a href="rel_funcionarios.php">Funcionários</a></li>
                </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" id="user" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class='glyphicon glyphicon-user' aria-hidden='true'></span> Olá, <?php echo $_SESSION["usuario"]; ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">Período: <?php mostra_periodo($_SESSION["mes"],$_SESSION["ano"],$_SESSION["st_periodo"]); ?></li>
                  <li><a href="atu_cadastro.php"><span class='glyphicon glyphicon-user' aria-hidden='true'></span> Meu Usuário</a></li>
                  <li><a href="atu_senha.php"><span class='glyphicon glyphicon-cog' aria-hidden='true'></span> Trocar senha</a></li>
                  <li><a href="periodo.php"><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> Períodos</a></li>
                  <li><a href="index.php"><span class='glyphicon glyphicon-off' aria-hidden='true'></span> Sair</a></li>
                </ul>
              </li>
            </ul>

          </div>
        </div>
      </nav>
      <br><br>