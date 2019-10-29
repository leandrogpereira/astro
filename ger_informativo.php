<link rel="shortcut icon" href="img/favicon.png">
<div class="tudo">

  <div class="topo">
    <?php include_once('header.php'); ?>
  </div>

  <div class="conteudo">

    <?php
  
  if ($_SESSION["acesso"] == 0)
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
    ?>

    <div class="container theme-showcase" role="main">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">CADASTRO DE INFORMAÇÕES:</h3>
        </div>
        <div class="panel-body">

        <form method="post">

              <div class="row">
          
                <div class="col-xs-3 col-md-2">
                  <br>Título:<br>
                  <input type="text" id="" placeholder="Ex.: Revisão dos veículos !" class="form-control" name="titulo" required>
                </div>

                <div class="col-xs-3 col-md-2">
                  <br>Cor:<br>
                  <select class="form-control" name="cor">
                      <option value="0">Azul</option>
                      <option value="1">Verde</option>
                      <option value="2">Amarelo</option>
                      <option value="3">Vermelho</option>
                  </select>
                </div>

                <div class="col-xs-3 col-md-2">
                  <br>Validade:<br>
                  <select class="form-control" name="validade">
                      <option value="1">1 Dia</option>
                      <option value="7">1 Semana</option>
                      <option value="30">1 Mês</option>
                      <option value="360">1 Ano</option>
                  </select>
                </div>

                <div class="col-xs-3 col-md-2">
                  <br>Link:<br>
                  <select class="form-control" name="link">
                    <option value="">Sem link</option>
                    <option value="ger_despesa.php">Despesas</option>
                    <option value="ger_contrato.php">Contratos</option>
                    <option value="ger_transporte.php">Transportes</option>
                    <option value="ger_funcionario.php">Funcionários</option>
                    <option value="ger_pessoa.php">Clientes/Fornecedores</option>
                    <option value="ger_veiculo.php">Veículos</option>
                  </select>
                </div>

                <div class="col-xs-3 col-md-2">
                  <button  style="margin-top: 40px;" type="submit" class="btn btn-primary" name="enviar">Cadastrar</button>
                  <button  style="margin-top: 40px;" type="reset" class="btn btn-info" name ="limpar">Limpar</button>
                </div>

              </div>

              <div class="row">
                  <div class="col-md-12">
                    <br>Informações:<br>
                    <textarea cols="40" rows="5" class="form-control" name="corpo" maxlength="250" required=""></textarea>
                  </div>
              </div>
        </form>

        <?php 

          if (isset($_POST["enviar"]))
          {
            include_once "conexao.php";
            $titulo      = $_POST["titulo"];
            $corpo       = $_POST["corpo"];
            $link        = $_POST["link"];
            $cor         = $_POST["cor"];
            $dt_cadastro = date('Y-m-d H:i:s', strtotime($data_padrao));
            switch ($_POST["validade"])
            {
              case 1:
                $dt_validade = date("Y-m-d H:i:s", strtotime('+1 days', strtotime($data_padrao)));
                break;
              case 7:
                $dt_validade = date("Y-m-d H:i:s", strtotime('+1 week', strtotime($data_padrao)));
                break;
              case 30:
                $dt_validade = date("Y-m-d H:i:s", strtotime('+1 month', strtotime($data_padrao)));
                break;
              default:
                $dt_validade = date("Y-m-d H:i:s", strtotime('+1 year', strtotime($data_padrao)));
                break;
            }
            $insert      = mysql_query("INSERT INTO informativos VALUES (NULL, '$titulo', '$corpo', '$link', $cor, '$dt_cadastro', '$dt_validade', 1, ".$_SESSION["id_usuario"].");");
            if(mysql_affected_rows()>0)
            {
              echo '
             <div id="confirma" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="color:black">Aviso</h4>
                  </div>
                  <div class="modal-body" style="color:black">
                    <p>Cadastro realizado com sucesso.</p>
                  </div>

                  <div align="center">
                    <table>
                      <thead>
                        <tr>
                          <th>
                           <button type="button" class="btn btn-primary margem" data-dismiss="modal"></span>OK</button>
                         </th>
                       </tr>
                     </thead>
                   </table>
                   <br>
                 </div>
               </div>
             </div>
             </div>
              ';
            }
            else
            {
              echo '
             <div id="confirma" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="color:black">Aviso</h4>
                  </div>
                  <div class="modal-body" style="color:black">
                    <p>Erro: $erro.</p>
                  </div>

                  <div align="center">
                    <table>
                      <thead>
                        <tr>
                          <th>
                           <button type="button" class="btn btn-danger margem" data-dismiss="modal"></span>OK</button>
                         </th>
                       </tr>
                     </thead>
                   </table>
                   <br>
                 </div>
               </div>
             </div>
             </div>
              ';
            }
          }

        ?>
      
      </div>
    </div>

      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">PARA GERENCIAR OS INFORMATIVOS, CLIQUE NO REGISTRO DESEJADO:</h3>
        </div>
        <div class="panel-body">

        <!-- Modal RESPONSAVEL PELA CAIXA DE DIALOGO -->
       <div id="confirm-delete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel" style="color:black">Confirmação</h4>
            </div>
            <div class="modal-body" style="color:black">
              Deseja realmente remover o registro?
            </div>

            <div align="right">
              <table>
                <thead>
                  <tr>
                    <th>
                     <button type="button" class="btn btn-default margem" data-dismiss="modal"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Cancelar</button>
                     <a class="btn btn-primary margem btn-ok"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Confirmar</a>
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

          <div class="table-responsive">  
            <table class="table table-hover" id="datatable">
              <thead>
                <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Validade</th>
                <th>Gerenciar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  include_once "conexao.php";
                  $query = mysql_query("SELECT I.ID_INFORMATIVO
                                             , I.INF_TITULO
                                             , I.DT_VENCIMENTO
                                          FROM informativos I");

                  while ($row = mysql_fetch_array($query))
                  {
                    $id = $row['ID_INFORMATIVO'];
                    $titulo = $row['INF_TITULO'];
                    $dt_vencimento = date('d-m-Y', strtotime($row['DT_VENCIMENTO']));

                    echo("             
                      <tr>
                      <th scope='row'>$id</th>
                      <td>$titulo</td>
                      <td>$dt_vencimento</td>
                      <td class='last-td'>
                        <button class='btn btn-danger btn-sm' data-href='exc_informativo.php?id=$id' data-toggle='modal' data-target='#confirm-delete'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Remover</button>
                      </td>
                      </tr>
                    ");
                  }                  
              }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>      
    </div>
  </div>

  <div class="rodape">
    <?php include_once('footer.php'); ?>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
        $('#confirma').modal();
    });

    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
  </script>
            
</div>


