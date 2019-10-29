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

      <?php
      
        include_once('conexao.php');

        include("valida_usuario.php");

        verifica_usuario();

        if (!isset($_POST["selecionar"])) {
          
      ?>

        <div class="periodo">

          <div class="panel panel-primary">

            <div class="panel-heading">
              <h3 class="panel-title">SELECIONE O PERÍODO:</h3>
            </div>
  
            <div class="panel-body">

              <form method="POST" action="periodo.php">
                <div class="row">
                  <div class="col-md-12">
                    Ano:<br>
                    <select class="form-control" name="ano" id="ano">
                        <?php 

                          $query = mysql_query("SELECT DISTINCT(PER_ANO) AS ANO FROM periodos ORDER BY ANO ASC");

                          while ($row = mysql_fetch_array($query))
                          {
                            $ano = $row['ANO'];
                          echo ("
                              <option value='$ano'>$ano</option>
                              ");
                          }

                        ?>
                    </select>
                  </div>
                </div>

                <div id="consulta"></div>

              </form>

            </div>
          </div>  
        </div>

      <?php
        }
        else
        {
          $_SESSION["ano"] = $_POST["ano"];
          $_SESSION["mes"] = $_POST["mes"];

          $verifica = mysql_query("SELECT ID_PERIODO, ST_PERIODO FROM periodos WHERE PER_MES = ".$_SESSION["mes"]." AND PER_ANO = ".$_SESSION["ano"]) or die("Erro na sintaxe, entre em contato com o suporte técnico. <a href='login.php'>Voltar</a>");

          $row = mysql_fetch_array($verifica);
          $_SESSION["st_periodo"] = $row["ST_PERIODO"];
          $_SESSION["id_periodo"] = $row["ID_PERIODO"];
          header("Location:home.php");
        }
      ?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>   

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="js/bootstrap.min.js"></script> 

    <script type="text/javascript">

    $('#ano').click(function(){ //Quando alterado o select
        $.ajax({
            type: "POST",
            url: 'atualiza_periodo.php',            
            data: {              
              ano: $('#ano').val()
            },
            success: function(data) {
              $('#consulta').html(data);
              
              //alert(data);
            }/*,
            beforeSend: function(){
              $('.loader').css({display:"block"});
            },
            complete: function(){
              $('.loader').css({display:"none"});
            }*/
        });
      });

    </script>

  </body>
</html>
