<?php 

include_once('conexao.php');
session_start(); 
$email = isset($_POST["email"]) ? addslashes(trim($_POST["email"])) : FALSE; 
$senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE; 


if(!$email || !$senha) 
{ 
echo <<<HTML

		<html lang='pt-br'>

		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1'>
			<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
			<meta name='description' content=''>
			<meta name='author' content=''>

			<link rel='shortcut icon' href='img/favicon.png'>

			<title>Astro Transportes - Sistema</title>

			<!-- Bootstrap core CSS -->
			<link href='css/bootstrap.min.css' rel='stylesheet'>
			<!-- Bootstrap theme -->
			<link href='css/bootstrap-theme.min.css' rel='stylesheet'>
			<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			<link href='css/ie10-viewport-bug-workaround.css' rel='stylesheet'>

			<!-- Custom styles for this template -->
			<link href='css/dashboard.css' rel='stylesheet'>

			<link href='css/style.css' rel='stylesheet'>    

			<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
			<!--[if lt IE 9]><script src='js/ie8-responsive-file-warning.js'></script><![endif]-->
			<script language='JavaScript' type='text/javascript' src='js/ie-emulation-modes-warning.js'></script>

			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
			<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>          
			<![endif]-->

	</head>

	<body>

		<div class="container theme-showcase" role="main">
			<div class='panel panel-danger'> 
					<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
					<div class='panel-body' align='center'> <p align='center'>Preencha corretamente seu e-mail e senha.</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a>
					</div> 
			</div>
		</div>

	</body>

	</html>
HTML;
exit; 
} 

$verifica = mysql_query("
						SELECT ID_FUNCIONARIO,
							   FUN_NOME,
							   FUN_SENHA,
							   FUN_ACESSO
						  FROM funcionarios
						 WHERE FUN_EMAIL = '$email'
						   AND FUN_STATUS = 1
						")
			or die("Erro na sintaxe, entre em contato com o suporte técnico. <a href='index.php'>Voltar</a>");

if(mysql_num_rows($verifica)) 
{ 

$row = mysql_fetch_array($verifica);

if(!strcmp($senha, $row["FUN_SENHA"])) 
{ 

$_SESSION["id_usuario"]= $row["ID_FUNCIONARIO"]; 
$_SESSION["usuario"] = $row["FUN_NOME"];
$_SESSION["acesso"]= $row["FUN_ACESSO"]; 
header("Location: periodo.php"); 
exit; 
} 

else 
{ 
echo <<<HTML

		<html lang='pt-br'>

		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1'>
			<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
			<meta name='description' content=''>
			<meta name='author' content=''>

			<link rel='shortcut icon' href='img/favicon.png'>

			<title>Astro Transportes - Sistema</title>

			<!-- Bootstrap core CSS -->
			<link href='css/bootstrap.min.css' rel='stylesheet'>
			<!-- Bootstrap theme -->
			<link href='css/bootstrap-theme.min.css' rel='stylesheet'>
			<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			<link href='css/ie10-viewport-bug-workaround.css' rel='stylesheet'>

			<!-- Custom styles for this template -->
			<link href='css/dashboard.css' rel='stylesheet'>

			<link href='css/style.css' rel='stylesheet'>    

			<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
			<!--[if lt IE 9]><script src='js/ie8-responsive-file-warning.js'></script><![endif]-->
			<script language='JavaScript' type='text/javascript' src='js/ie-emulation-modes-warning.js'></script>

			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
			<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>          
			<![endif]-->

	</head>

	<body>

		<div class="container theme-showcase" role="main">
			<div class='panel panel-danger'> 
					<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
					<div class='panel-body' align='center'> <p align='center'>Senha inválida.</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a>
					</div> 
			</div>
		</div>

	</body>

	</html>
HTML;
exit; 
} 
} 

else 
{ 
echo <<<HTML

		<html lang='pt-br'>

		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1'>
			<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
			<meta name='description' content=''>
			<meta name='author' content=''>

			<link rel='shortcut icon' href='img/favicon.png'>

			<title>Astro Transportes - Sistema</title>

			<!-- Bootstrap core CSS -->
			<link href='css/bootstrap.min.css' rel='stylesheet'>
			<!-- Bootstrap theme -->
			<link href='css/bootstrap-theme.min.css' rel='stylesheet'>
			<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
			<link href='css/ie10-viewport-bug-workaround.css' rel='stylesheet'>

			<!-- Custom styles for this template -->
			<link href='css/dashboard.css' rel='stylesheet'>

			<link href='css/style.css' rel='stylesheet'>    

			<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
			<!--[if lt IE 9]><script src='js/ie8-responsive-file-warning.js'></script><![endif]-->
			<script language='JavaScript' type='text/javascript' src='js/ie-emulation-modes-warning.js'></script>

			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
			<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>          
			<![endif]-->

	</head>

	<body>

		<div class="container theme-showcase" role="main">
			<div class='panel panel-danger'> 
					<div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
					<div class='panel-body' align='center'> <p align='center'>E-mail não cadastrado.</p><br><br><a href='javascript:history.go(-1);'><button type='button' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Voltar</button></a>
					</div> 
			</div>
		</div>

	</body>

	</html>
HTML;
exit; 
} 
?>