<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

  <div class="topo">
    <?php include_once('header.php'); ?>
  </div>

  <div class="conteudo">

      <?php

          include_once('conexao.php');
          if ($_SESSION["acesso"] <= 1 || $_GET["id"] == null)
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
            $id = $_GET["id"];

            $delete = mysql_query("DELETE FROM informativos WHERE ID_INFORMATIVO = $id;");

            if(mysql_affected_rows()>0)
            {
              die('<script type="text/javascript">window.location.href="ger_informativo.php";</script>');
              mysql_close($conecta);
            }
            else
            {
              die('<script type="text/javascript">window.location.href="ger_informativo.php";</script>');
              mysql_close($conecta);
            }
          }
?>