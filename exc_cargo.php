<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

  <div class="topo">
    <?php include_once('header.php'); ?>
  </div>

  <div class="conteudo">

    <?php

    include_once('conexao.php');

    $id_cargo = $_GET["id"];

    $res = mysql_query("UPDATE 
      cargos
      SET
      CAR_STATUS = 0
      WHERE 
      ID_CARGO = '$id_cargo';"); 

    if(mysql_affected_rows()>0)
    {
      die('<script type="text/javascript">window.location.href="ger_cargo.php";</script>');
      mysql_close($conecta);
    }
    else
    {
      die('<script type="text/javascript">window.location.href="ger_cargo.php";</script>');
      mysql_close($conecta);
    }

  ?>

  
</div>

<div class="rodape">
  <?php include_once('footer.php'); ?>
</div>

</div>