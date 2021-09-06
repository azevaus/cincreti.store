
<div class="container" style="margin-top: 3rem;">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-blok">
              <h4 style="margin-top: 1rem;"><?php echo $titulo?></h4>
            </div>
            <div class="card-body">
              <span>Dados do cliente</span>
                  <p><strong>Nome cliente:</strong> <?php echo $pedido->pedido_cliente_nome?></p>
                  <p><strong>CPF:</strong> <?php echo $pedido->cliente_cpf?></p>                  
                  <p><strong>Celular:</strong> <?php echo $pedido->cliente_telefone_movel?></p> 
                  <p><strong>E-mail:</strong> <?php echo $pedido->cliente_email?></p>
              <hr>
              <span>Dados do pedido</span>
                <p><strong>Status do pedido:</strong> 
                  <?php 
                    switch($pedido->pedido_status){
                      case 1:
                          echo '<div class="badge badge-shadow badge-warning">Aguardando pagamento</div>';
                          break;
                      case 2:
                          echo '<div class="badge badge-shadow badge-info">Em análise</div>';
                          break;
                      case 3:
                          echo '<div class="badge badge-shadow badge-success">Paga</div>';
                          break;
                      case 4:
                          echo '<div class="badge badge-shadow badge-success">Disponível</div>';
                          break;
                      case 5:
                          echo '<div class="badge badge-shadow badge-warning">Em disputa</div>';
                          break;
                      case 6:
                          echo '<div class="badge badge-shadow badge-dark">Devolvida</div>';
                          break;
                      case 7:
                          echo '<div class="badge badge-shadow badge-danger">Cancelada</div>';
                          break;
                      case 8:
                          echo '<div class="badge badge-shadow badge-success">Debitada</div>';
                          break;
                      case 9:
                          echo '<div class="badge badge-shadow badge-warning">Retençao temporária/div>';
                          break;
                      }
                  ?>                
                </p>
              <hr>
              <span>Endereço de entrega</span>
              <p><strong>Rua:</strong> <?php echo $pedido->cliente_endereco?>, <?php echo $pedido->cliente_numero_endereco?>, <strong>Bairro:</strong> <?php echo $pedido->cliente_bairro?>, <strong>Cidade:</strong> <?php echo $pedido->cliente_cidade?>, <strong>Estado:</strong> <?php echo $pedido->cliente_estado?> - <?php echo $pedido->cliente_cep?></p>                  
              <p><strong>Forma de envio: <i class="fa fa-shipping-fast fa-lg"></i>&nbsp;</strong> <?php echo ($pedido->pedido_forma_envio == 1 ?'SEDEX' : 'PAC')?></p> 
              <hr>
              <span>Produtos do pedido</span>

             <div class="table-responsive">
                <table class="table table-striped data-table">
                  <thead>
                    <tr>
                      <th>Produto</th>
                      <th>Quantidade</th>
                      <th>Valor unitário</th>
                      <th>Valor total</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pedido_produtos as $produtos) : ?>
                      <tr>
                        <td> <?php echo word_limiter($produtos->produto_nome, 5); ?> </td>
                        <td> <?php echo $produtos->produto_quantidade; ?> </td>
                        <td> <?php echo number_format($produtos->produto_valor_unitario,2) ?> </td>
                        <td>R$ <?php echo number_format($produtos->produto_valor_total, 2) ?> </td>
                      </tr>
                      <?php endforeach; ?>
                      <tr>
                        <th colspan="3" class="text-right">Valor do frete</th>
                        <td>R$ <?php echo number_format($pedido->pedido_valor_frete, 2) ?> </td>
                      </tr>
                      <tr>
                        <th colspan="3" class="text-right">Valor total</th>
                        <td>R$ <?php echo number_format($pedido->pedido_valor_final, 2) ?> </td>
                      </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>