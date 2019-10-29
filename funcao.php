<?php
	
	function atualizaPeriodo()
	{
		$verifica = mysql_query("SELECT ST_PERIODO FROM periodos WHERE PER_MES = ".$_SESSION["mes"]." AND PER_ANO = ".$_SESSION["ano"]) or die("Erro na sintaxe, entre em contato com o suporte técnico. <a href='periodo.php'>Voltar</a>");

		$row = mysql_fetch_array($verifica);
		$_SESSION["st_periodo"] = $row["ST_PERIODO"];
	}

	function verificaPeriodo($x)
	{
		$ano = date('Y', strtotime($x));
		$mes = substr($x, 3,2);
		if ($ano != $_SESSION["ano"] || $mes != $_SESSION["mes"] || $_SESSION["st_periodo"] != 1)
		{
			//echo '<script type="text/javascript">alert("Data inválida para o lançamento.");';
			//echo 'javascript:window.location="home.php";</script>';
			$v = false;
		}
		else
		{
			$v = true;
		}
		return $v;
	}

	function verificaContrato($x,$c)
	{
		$dt = date('Y.m.d', strtotime($x));
		$verifica = mysql_query("SELECT COUNT(C.ID_CONTRATO) AS AUX
     								  , COUNT(A.ID_CONTRATO) AS AUY
								   FROM contratos C
                              LEFT JOIN aditivos A ON A.ID_CONTRATO = C.ID_CONTRATO
								  WHERE C.ID_CONTRATO    = $c
								    AND ((C.CON_DT_INICIO <= '$dt') OR (A.DT_INICIO <= '$dt'))
								    AND ((C.CON_DT_FIM    >= '$dt') OR (A.DT_TERMINO >= '$dt'))")
								or
								die("Erro na sintaxe, entre em contato com o suporte técnico. <a href='home.php'>Voltar</a>");
		$row = mysql_fetch_array($verifica);
		$aux = $row['AUX'] + $row['AUY'];

		if ($aux > 0)
		{
			//echo '<script type="text/javascript">alert("Data inválida para o lançamento.");';
			//echo 'javascript:window.location="home.php";</script>';
			$v = true;
		}
		else
		{
			$v = false;
		}
		return $v;
	}

	function verificaDataContrato($x,$y)
	{
		$dt_inicio = date('Y.m.d', strtotime($x));
		$dt_final  = date('Y.m.d', strtotime($y));
		if ($dt_inicio > $dt_final)
		{
			$aux = false;
		}
		else
		{
			$aux = true;
		}
		return $aux;
	}

?>