<?php 
	
	session_start();
	function valida_usuario() {
  	if (null == $_SESSION['usuario'] || null == $_SESSION['id_periodo'] || null == $_SESSION['st_periodo']) {
    // Não há usuário e período logado, manda pra página de login
    header("Location:periodo.php");
  	}
  	}

  	function verifica_usuario() {
  	if (!isset($_SESSION['usuario'])) {
    // Não há usuário logado, manda pra página de login
    header("Location:index.php");
  	}
  	}

?>