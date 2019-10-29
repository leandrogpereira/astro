<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

  <div class="topo">
    <?php include_once('header.php'); ?>
  </div>

  <div class="conteudo">

    <?php

    include_once('conexao.php');

    if ($_SESSION["acesso"] <= 1 || $_GET["id_cargo"] == null)
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

      $id_cargo = $_GET["id_cargo"];

      $res = mysql_query("UPDATE 
        cargos
        SET
        CAR_STATUS = 1
        WHERE 
        ID_CARGO = '$id_cargo';"); 

      if(mysql_affected_rows()>0)
      {
        die('<script type="text/javascript">window.location.href="ina_cargo.php";</script>');
        mysql_close($conecta);
      }
      else
      {
        die('<script type="text/javascript">window.location.href="ina_cargo.php";</script>');
        mysql_close($conecta);
      }
    }

  ?>

  
</div>

<div class="rodape">
  <?php include_once('footer.php'); ?>
</div>

</div>