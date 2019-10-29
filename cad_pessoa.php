<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

<div class="topo">
<?php include_once('header.php'); ?>
</div>

<div class="conteudo">

 <?php
  include_once('conexao.php');
  if ($_SESSION["acesso"] <= 1)
  {
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
    if(!isset($_POST["enviar"]))
    {
  ?>

  <div class="container theme-showcase" role="main">
  <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">PARA CADASTRAR UMA NOVA PESSOA, PREENCHA O FORMULÁRIO COM OS DADOS SOLICITADOS:</h3>
      </div>
      <div class="panel-body">

  <form method="POST" action="cad_pessoa.php">
    
        <div class="row">
        <div class="col-xs-6 col-md-4">
        <br>Tipo de Cadastro:<br>
          <select class="form-control" name="tp_cadastro">
            <option value="0">Cliente</option>  
            <option value="1">Fornecedor</option>
          </select>
        </div>

        <div class="col-xs-6 col-md-4">
        <br>Tipo de Pessoa:<br>
          <select id="tpPessoa" class="form-control" name="tp_pessoa" onchange="javascript:verifica();">
              <option value="0">Jurídica</option>  
              <option value="1">Física</option>
          </select>
        </div>

        <div class="col-xs-6 col-md-4">
        <br>CNPJ/CPF:<br>
        <input type="text" id="documento" class="form-control" placeholder="Ex: 12.432.000/0001-90" name="documento" maxlength="18" required>
        </div>
        </div>

        <div class="row">
        <div class="col-xs-6 col-md-4">
        <br>Nome:<br>
        <input type="text" placeholder="Ex: Astro Locação e Transporte LTDA" class="form-control" name="nome" maxlength="80" required>
        </div>

        <div class="col-xs-6 col-md-4">
        <br>Endereço:<br>
        <input type="text" placeholder="Rua das Orquídeas" class="form-control" name="endereco" maxlength="80">
        </div>

        <div class="col-xs-6 col-md-4">   
        <br>Número:<br>
        <input type="text" placeholder="315" class="form-control" name="numero" maxlength="6" onkeypress='return SomenteNumero(event)'>
        </div>
        </div>

        <div class="row">
        <div class="col-xs-6 col-md-4">
        <br>Bairro:<br>
        <input type="text" placeholder="Jardim das Flores" class="form-control" name="bairro" maxlength="80">
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
        <br>CEP:<br>
        <input type="text" id="campoCep" placeholder="12400000" class="form-control" name="cep" maxlength="8" onkeypress='return SomenteNumero(event)'>
        </div>

        <div class="col-xs-6 col-md-4">
        <br>Contato:<br>
        <input type="text" placeholder="Ex.: Francisco Gomes" class="form-control" name="contato" maxlength="80">
        </div>

        <div class="col-xs-6 col-md-4">
        <br>Telefone 1:<br>
        <input type="text" id="campoTelefone" placeholder="Ex.: 1235222121" class="form-control" name="fone1" maxlength="11">
        </div>
        </div>

        <div class="row">
        <div class="col-xs-6 col-md-4">
        <br>Telefone 2:<br>
        <input type="text" id="campoTelefone1" placeholder="12992134049" class="form-control" name="fone2" maxlength="11">
        </div>

        <div class="col-xs-6 col-md-4">
        <br>E-mail:<br>
        <input type="text" placeholder="endereco@dominio.com" class="form-control" name="email" maxlength="80">
        </div>
        </div>

        <br><br><br>
         <button type="submit" class="btn btn-primary btn-lg" name="enviar">Cadastrar</button>
         <button type="reset" class="btn btn-info btn-lg" name ="limpar">Limpar</button>
      </form>

      <br>

    </div>
  </div>      
  </div>

  <?php

   }
   else
   {

    include_once('conexao.php');

    $tp_cadastro = $_POST["tp_cadastro"];
    $tp_pessoa   = $_POST["tp_pessoa"];
    $documento   = str_replace(array(".","/","-"),"",$_POST["documento"]);
    $nome        = $_POST["nome"];
    $endereco    = $_POST["endereco"];
    $numero      = $_POST["numero"];
    $bairro      = $_POST["bairro"];
    $cep         = str_replace(array(".","-"),"",$_POST["cep"]);
    $estado      = $_POST["estado"];
    $cidade      = $_POST["cidade"];
    $contato     = $_POST["contato"];
    $fone1       = $_POST["fone1"];
    $fone2       = $_POST["fone2"];
    $email       = $_POST["email"];
    
    $res = mysql_query("INSERT INTO pessoas VALUES (NULL,'$tp_cadastro','$tp_pessoa','$documento','$nome','$endereco','$numero', '$bairro', '$cidade','$estado', '$cep', '$contato', '$fone1', '$fone2', '$email',1);"); 

    if(mysql_affected_rows()>0)
    {
      echo "
      <div class='container theme-showcase' role='main'>
        <div class='panel panel-success'> 
          <div class='panel-heading'><h3 class='panel-title'>Aviso</h3></div> 
          <div class='panel-body'> Cadastrado realizado com sucesso!<br><br><a href='cad_pessoa.php'><button type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Voltar</button></a></div> 
        </div>
      </div>
      ";
      mysql_close($conecta);
    }
    else
    {
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
       $("#campoData1").mask("99-99-9999");
       $("#campoTelefone").mask("(99) 9999-9999");
       $("#campoTelefone1").mask("(99) 99999-9999");
       $("#campoCep").mask("**.***-***");
       $("#documento").mask("**.***.***/****-**");
    });

      function SomenteNumero(e){
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
          if (tecla==8 || tecla==0) return true;
          else  return false;
        }
      }

      function verifica()
      {
        var testa = document.getElementById("tpPessoa").value;
        if (testa == 0) {
           $("#documento").mask("**.***.***/****-**");
        } 
        else
        {
           $("#documento").mask("***.***.***-**");
        }
      }

      new dgCidadesEstados({
        cidade: document.getElementById('cidade'),
        estado: document.getElementById('estado')
      })

    </script>
            
</div>