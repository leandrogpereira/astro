<?php session_start(); session_destroy(); ?>

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

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="login">
        <form class="form-signin" name="form1" action="login.php" method="post">
            <div class="form-group">
              <img src="img/login.png" class="img-rounded img-responsive" alt="Login">
            </div>

             <!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
             <div id="suporte" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="color:black">Reportar</h4>
                  </div>
                  <div class="modal-body" style="color:black">
                    <p>Relate seu problema via:</p>
                    <ul>
                      <li>E-mail: suporte@astro.com</li>
                      <li>Telefone: (12)3522-2016</li>
                    </ul>
                  </div>

                  <div align="center">
                    <table>
                      <thead>
                        <tr>
                          <th>
                           <button type="button" class="btn btn-primary margem" data-dismiss="modal"></span>Voltar</button>
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

            <h2 class="form-signin-heading">Preencha os campos:</h2>
            <label for="inputEmail" class="sr-only">E-mail:</label>
            <input type="email" id="inputEmail" class="form-control" name="email" placeholder="seunome@dominio.com" maxlength="80" required autofocus>
            <label for="inputPassword" class="sr-only">Senha:</label>
            <input type="password" id="inputPassword" class="form-control" name="senha" placeholder="******" maxlength="10" required>
            <p class="help-block">Problemas ao acessar? Contate o <a href="#" data-toggle="modal" data-target="#suporte">suporte</a>.</p>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Entrar</button>
        </form>
      </div>
    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>   

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="js/bootstrap.min.js"></script> 

  </body>
</html>
