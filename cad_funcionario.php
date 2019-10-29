<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

<?php
  include_once('conexao.php');
  if ($_SESSION["acesso"] != 3) {
    echo "
          <div class='container theme-showcase' role='main'>
            <div class='panel panel-danger'> 
              <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
              <div class='panel-body'> <p align='center'>Área restrita. Verifique suas permissões de acesso.</p>
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
  if(!isset($_POST["enviar"])){
?>

<div class="container theme-showcase" role="main">
<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">PARA CADASTRAR UM NOVO FUNCIONÁRIO, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
    </div>
    <div class="panel-body">

<form method="POST" action="cad_funcionario.php">

    <div class="row">
      <div class="col-xs-6 col-md-4">
      <br>Nome:<br>
      <input type="text" placeholder="Ex: José" class="form-control" name="nome" maxlength="80" required>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Sobrenome:<br>
      <input type="text" placeholder="Ex: Silva dos Santos" class="form-control" name="sobrenome" maxlength="80" required>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>CPF:<br>
      <input type="text" class="form-control" placeholder="Ex: 40089032190" name="cpf" id="campoCPF" maxlength="11" onkeypress='return SomenteNumero(event)' required>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-md-4">
      <br>CNH:<br>
      <input type="text" class="form-control" placeholder="Ex: 12389032190" name="cnh" maxlength="11" onkeypress='return SomenteNumero(event)'>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Data de Nascimento:<br>
      <input type="text" id="campoData" placeholder="15-07-1992" class="form-control" name="dt_nasc" maxlength="10" required="">
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Cargo:<br>
        <select class="form-control" name="cargo">
          <?php 

            $query = mysql_query("SELECT ID_CARGO
                                       , CAR_NOME
                                    FROM cargos
                                   WHERE CAR_STATUS = 1");

            while ($row = mysql_fetch_array($query)){
              $id_cargo      = $row['ID_CARGO'];
              $cargo_nome = $row['CAR_NOME'];

            echo("             
                <option value='$id_cargo'>$cargo_nome</option>
                ");
            }

            mysql_close($conecta);

          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-md-4">
      <br>Endereço:<br>
      <input type="text" placeholder="Rua das Orquídeas" class="form-control" name="endereco" maxlength="80">
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Número:<br>
      <input type="text" placeholder="315" class="form-control" name="numero" maxlength="6" onkeypress='return SomenteNumero(event)'>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Bairro:<br>
      <input type="text" placeholder="Jardim das Flores" class="form-control" name="bairro" maxlength="45">
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-md-4">
      <br>CEP:<br>
      <input type="text" id="campoCEP" placeholder="12400000" class="form-control" name="cep" maxlength="8" onkeypress='return SomenteNumero(event)'>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Estado: <span id="aviso">(Selecione o estado para visualizar as cidades)</span><br>
      <select id="estado" class="form-control" name="estado"></select>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Cidade:<br>
      <select id="cidade" class="form-control" name="cidade"></select>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-md-4">
      <br>Telefone 1:<br>
      <input type="text" id="campoTelefone" placeholder="12992134049" class="form-control" name="fone1" maxlength="11" onkeypress='return SomenteNumero(event)'>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Telefone 2:<br>
      <input type="text" id="campoTelefone1" placeholder="1235221122" class="form-control" name="fone2" maxlength="11" onkeypress='return SomenteNumero(event)'>
      </div>

      <div class="col-xs-6 col-md-4">
      <br>E-mail:<br>
      <input type="text" placeholder="seunome@astro.com" class="form-control" name="email" maxlength="80">
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6 col-md-4">
      <br>Senha:<br>
      <input type="password" placeholder="*******" class="form-control" name="senha" maxlength="10">
      </div>

      <div class="col-xs-6 col-md-4">
      <br>Acesso:<br>
        <select class="form-control" name="acesso">
          <option value="0">Nenhum</option>
          <option value="1">Básico</option>
          <option value="2">Intermediário</option>
          <option value="3">Avançado</option>
        </select>
      </div>
    </div>

    <br><br>
       <button type="submit" class="btn btn-primary btn-lg" name="enviar">Cadastrar</button>
       <button type="reset" class="btn btn-info btn-lg" name ="limpar">Limpar</button>
</form>

    <br>

  </div>
</div>      
</div>

<?php

 } else {

    include_once('conexao.php');

    $nome       = $_POST["nome"];
    $sobrenome  = $_POST["sobrenome"];
    $cpf        = str_replace(array(".","/","-"),"",$_POST["cpf"]);
    $cnh        = $_POST["cnh"];
    $dt_nasc    = date('Y-m-d H:i:s', strtotime($_POST["dt_nasc"]));
    $endereco   = $_POST["endereco"];
    $numero     = $_POST["numero"];
    $bairro     = $_POST["bairro"];
    $cep        = str_replace(array(".","/","-"),"",$_POST["cep"]);
    $estado     = $_POST["estado"];
    $cidade     = $_POST["cidade"];
    $fone1      = $_POST["fone1"];
    $fone2      = $_POST["fone2"];
    $email      = $_POST["email"];
    $senha      = md5($_POST["senha"]);
    $acesso     = $_POST["acesso"];
    $cargo      = $_POST["cargo"];

    $res = mysql_query("INSERT INTO funcionarios VALUES (NULL,'$nome','$sobrenome','$cpf', '$cnh', '$endereco', '$dt_nasc', '$numero', '$bairro', '$cidade','$estado', '$cep', '$fone1', '$fone2', '$email', '$senha',1, $acesso, $cargo);"); 

    if(mysql_affected_rows()>0){
      echo "
      <div class='container theme-showcase' role='main'>
        <div class='panel panel-success'> 
          <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
          <div class='panel-body'> Funcionário cadastrado com sucesso!<br><br><a href='cad_funcionario.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
        </div>
      </div>
      ";
      mysql_close($conecta);
    }else{
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
}
?>

</div>

<div class="rodape">
<?php include_once('footer.php'); ?>
</div>

    <!-- Máscara para datas, telefones e senhas -->
    <script language="JavaScript" type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <script>
      jQuery(function($){
       $("#campoData").mask("99-99-9999");
       $("#campoTelefone").mask("(99) 9999-9999");
       $("#campoCPF").mask("999.999.999-99");
       $("#campoData1").mask("99-99-9999");
       $("#campoTelefone1").mask("(99) 99999-9999");
       $("#campoCEP").mask("99.999-999");
    });

      function SomenteNumero(e){
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
          if (tecla==8 || tecla==0) return true;
          else  return false;
        }
      }
      
      new dgCidadesEstados({
        cidade: document.getElementById('cidade'),
        estado: document.getElementById('estado')
      })
    </script>
            
</div>